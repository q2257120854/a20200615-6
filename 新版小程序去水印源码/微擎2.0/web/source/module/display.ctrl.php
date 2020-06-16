<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('switch');
load()->model('miniapp');

$dos = array('display', 'switch', 'have_permission_uniacids', 'accounts_dropdown_menu', 'rank', 'set_default_account', 'switch_last_module', 'init_uni_modules');
$do = in_array($do, $dos) ? $do : 'display';

if ($do == 'switch_last_module') {
	$last_module = switch_get_module_display();
	if (empty($last_module)) {
		itoast('', url('module/display'));
	}
	$account_info = uni_fetch($last_module['uniacid']);
	if ($account_info['endtime'] > 0 && TIMESTAMP > $account_info['endtime'] && !user_is_founder($_W['uid'], true)) {
		itoast('', url('module/display'));
	}
	itoast('', url('account/display/switch', array('module_name' => $last_module['modulename'], 'uniacid' => $last_module['uniacid'], 'switch_uniacid' => 1)));
}

if ($do == 'display') {
	$pageindex = max(1, intval($_GPC['page']));
	$pagesize = 20;

	$uni_modules_table = table('uni_modules');
	$module_title = safe_gpc_string($_GPC['module_title']);
	$account_name = safe_gpc_string($_GPC['account_name']);
	$module_letter = safe_gpc_string($_GPC['letter']);

	if (!empty($module_letter) && $module_letter != '全部') {
		$uni_modules_table->searchWithModuleLetter($module_letter);
	}

	if (!empty($module_title)) {
		$uni_modules_table->searchLikeModuleTitle($module_title);
	}

	if (!empty($account_name)) {
		$uni_modules_table->searchLikeAccountName($account_name);
	}
	$uni_modules_table->searchGroupbyModuleName();
	$own_account_modules = array();
	$own_account_modules = $uni_modules_table->searchWithPage($pageindex, $pagesize)->getModulesByUid($_W['uid']);

	$own_account_modules['pager'] = pagination($own_account_modules['total'], $pageindex, $pagesize, '', array('jaaxcallback' => true, 'callbackfuncname' => 'changePage'));
	$default_module_list = table('users_lastuse')->getDefaultModulesAccount($_W['uid']);
	foreach($own_account_modules['modules'] as $m_key => &$m_val) {
		if ($m_val['role'] == 'clerk') {
						$user_module_permission_info = table('users_permission')->getUserPermissionByType($_W['uid'], $m_val['uniacid'], $m_val['module_name']);
			if (!$user_module_permission_info) {
				unset($own_account_modules['modules'][$m_key]);
			}
		}

		$m_val['logo'] = tomedia($m_val['logo']);
		if (in_array($m_val['module_name'], array_keys($own_account_modules['modules']))) {
			$m_val['default_uniacid'] = $default_module_list[$m_val['module_name']]['default_uniacid'];
		}

		if (!empty($m_val['default_uniacid'])) {
			$m_val['default_account_name'] = $default_module_list[$m_val['module_name']]['default_account_name'];
			$m_val['default_account_info'] = uni_fetch($m_val['default_uniacid']);
			$m_val['default_account_type'] = $m_val['default_account_info']['type'];
		}
	}
	unset($m_val);

		$own_account_modules['system_have_modules'] = table('modules')->where('issystem !=', 1)->get();
	template('module/display');
}

if ($do == 'rank') {
	$module_name = trim($_GPC['module_name']);
	$uniacid = intval($_GPC['uniacid']);

	$exist = module_fetch($module_name, $uniacid);
	if (empty($exist)) {
		iajax(1, '模块不存在', '');
	}
	module_rank_top($module_name, $uniacid);
	itoast('更新成功！', referer(), 'success');
}

if ($do == 'switch') {
	$module_name = trim($_GPC['module_name']);
	$module_info = module_fetch($module_name);
	$module_name = empty($module_info['main_module']) ? $module_name : $module_info['main_module'];
	$uniacid = intval($_GPC['uniacid']);
	$account_info = uni_fetch($uniacid);
	if (empty($module_info)) {
		itoast('模块不存在或已经删除！', referer(), 'error');
	}
	if ($account_info->supportVersion) {
		$miniapp_version_info = miniapp_fetch($uniacid);
		$version_id = $miniapp_version_info['version']['id'];
	}

	if (empty($uniacid) && empty($version_id)) {
		itoast('该模块暂无可用的公众号或小程序，请先给公众号或小程序分配该应用的使用权限', url('module/display'), 'info');
	}

	if (!empty($version_id)) {
		$version_info = miniapp_version($version_id);
		miniapp_update_last_use_version($version_info['uniacid'], $version_id);
		$url = url('account/display/switch', array('uniacid' => $uniacid, 'module_name' => $module_name, 'version_id' => $version_id, 'switch_uniacid' => true));
	} else {
		$url = url('account/display/switch', array('uniacid' => $uniacid, 'module_name' => $module_name, 'switch_uniacid' => true));
	}

	switch_save_module_display($uniacid, $module_name);
	itoast('', $url, 'success');
}

if ($do == 'have_permission_uniacids') {
	$module_name = trim($_GPC['module_name']);
	$accounts_list = module_link_uniacid_fetch($_W['uid'], $module_name);
	iajax(0, $accounts_list);
}

if ($do == 'accounts_dropdown_menu') {
	$module_name = trim($_GPC['module_name']);
	if (empty($module_name)) {
		exit();
	}
	$accounts_list = module_link_uniacid_fetch($_W['uid'], $module_name);
	if (empty($accounts_list)) {
		exit();
	}

	foreach ($accounts_list as $key => $account) {
		$url = url('module/display/switch', array('uniacid' => $account['uniacid'], 'module_name' => $module_name));
		if (!empty($account['version_id'])) {
			$url .= '&version_id=' . $account['version_id'];
		}
		$accounts_list[$key]['url'] = $url;
	}
	echo template('module/dropdown-menu');
	exit;
}

if ($do == 'set_default_account') {
	$uniacid = intval($_GPC['uniacid']);
	$module_name = safe_gpc_string($_GPC['module_name']);
	if (empty($uniacid) || empty($module_name)) {
		iajax(-1, '设置失败!');
	}
	$result = switch_save_module($uniacid, $module_name);
	if ($result) {
		iajax(0, '设置成功!');
	} else {
		iajax(-1, '设置失败!');
	}
}

if ($do == 'init_uni_modules') {
	$pageindex = max(1, intval($_GPC['pageindex']));
	$pagesize = 20;
	$total = table('account')->count();
	$total = ceil($total/$pagesize);
	$init_accounts = table('account')->searchWithPage($pageindex, $pagesize)->getUniAccountList();
	if (empty($init_accounts)) {
		iajax(1, 'finished');
	}
	foreach ($init_accounts as $account) {
		cache_build_account_modules($account['uniacid']);
	}
	$pageindex = $pageindex + 1;
	iajax(0, array('pageindex' => $pageindex, 'total' => $total));
}
