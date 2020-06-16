<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('miniapp');
load()->model('phoneapp');
load()->model('account');
load()->model('user');

$dos = array('display', 'link_account', 'get_sub_accounts', 'list');
$do = in_array($do, $dos) ? $do : 'display';

if ($do == 'list') {
	$module_name = safe_gpc_string($_GPC['m']);
	$module_info = module_fetch($module_name);

	$module_link_uniacids = module_link_uniacid_fetch($_W['uid'], $module_name);
	if (!empty($module_link_uniacids)) {
		foreach ($module_link_uniacids as $uniacid_val) {
			$account_list[] = uni_fetch($uniacid_val['uniacid']);
		}
	}

	template('module/link-list');
}

if ($do == 'display') {
	$user_modules = user_modules();
		foreach ($user_modules as $key => $module) {
		$total_support = 0;
		foreach (module_support_type() as $support => $item) {
			if ($support == 'welcome_support') {
				continue;
			}
			if ($module[$support] == $item['support']) {
				if ($support == 'wxapp_support') {
					$total_support += 2;
				} else {
					$total_support += 1;
				}
			}
		}
		if ($total_support < 2) {
			unset($user_modules[$key]);
		}
	}
	template('module/link');
}

if ($do == 'get_sub_accounts') {
	$module_name = safe_gpc_string($_GPC['module_name']);
	if (empty($module_name)) {
		iajax(1, '模块信息不能为空');
	}
	$account_list = uni_user_accounts($_W['uid'], safe_gpc_string($_GPC['type']));
	if (!empty($account_list)) {
		$account_type_info = uni_account_type();
		$link_main_uniacids = table('uni_link_uniacid')->getAllMainUniacidsByModuleName($module_name);		foreach ($account_list as $key => $account) {
						if (in_array($account['uniacid'], $link_main_uniacids)) {
				unset($account_list[$key]);
				continue;
			}
			$type_sign = $account_type_info[$account['type']]['type_sign'];
			if (in_array($type_sign, array(WXAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN))) {
								if ($type_sign == PHONEAPP_TYPE_SIGN) {
					$miniapp = phoneapp_fetch($account['uniacid']);
				} else {
					$miniapp = miniapp_fetch($account['uniacid']);
				}
				if (empty($miniapp['version']['modules'])) {
					unset($account_list[$key]);
					continue;
				} else {
					$version_module = current($miniapp['version']['modules']);
					if ($version_module['name'] != $module_name) {
						unset($account_list[$key]);
						continue;
					}
				}
			} else {
								$uni_modules = uni_modules_by_uniacid($account['uniacid']);
				if (!in_array($module_name, array_keys($uni_modules))) {
					unset($account_list[$key]);
					continue;
				}
			}
			$account_list[$key]['link_type'] = trim($_GPC['link_type']);
			$account_list[$key]['type_title'] = $account_type_info[$account['type']]['title'];
			$account_list[$key]['type_sign'] = $account_type_info[$account['type']]['type_sign'];
			$account_list[$key]['logo'] = is_file(IA_ROOT . '/attachment/headimg_' . $account['acid'] . '.jpg') ? tomedia('headimg_'.$account['acid']. '.jpg').'?time='.time() : './resource/images/nopic-107.png';
			$account_list[$key]['module_name'] = $module_name;
		}
	}
	iajax(0, $account_list);
}

if ($do == 'link_account') {
	$link_info = safe_gpc_array($_GPC['link_info']);
	if (empty($link_info['module_name'])) {
		iajax(-1, '应用不能为空');
	}
	$module = module_fetch($link_info['module_name']);
	if (empty($module)) {
		iajax(-1, '应用不存在或已被删除');
	}
	if (empty($link_info['main_account']) || empty($link_info['link_accounts'])) {
		iajax(-1, '关联账号不能为空');
	}
	foreach ($link_info['link_accounts'] as $uniacid => $account) {
		if ($uniacid == $link_info['main_account']['uniacid']) {
			continue;
		}
		$version_id = 0;
		if (in_array($account['type_sign'], array(WXAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN))) {
			if ($account['type_sign'] == PHONEAPP_TYPE_SIGN) {
				$last_version = phoneapp_fetch($account['uniacid']);
			} else {
				$last_version = miniapp_fetch($account['uniacid']);
			}
			if (empty($last_version['version']) || empty($last_version['version']['modules']) || !is_array($last_version['version']['modules'])) {
				continue;
			}
			$module_version = array();
			foreach ($last_version['version']['modules'] as $item) {
				if ($item['name'] == $link_info['module_name']) {
					$module_version = $item;
					break;
				}
			}
			if (empty($module_version)) {
				continue;
			}
			$version_id = $last_version['version']['id'];
		}
				$link_uniacid_table = table('uni_link_uniacid');
		$sub_uniacids = $link_uniacid_table->getSubUniacids($uniacid, $link_info['module_name'], $last_version['version']['id']);
		if (!empty($sub_uniacids)) {
			continue;
		}
				$link_uniacid_table->fill(array(
			'uniacid' => $uniacid,
			'link_uniacid' => $link_info['main_account']['uniacid'],
			'version_id' => $version_id,
			'module_name' => $link_info['module_name'],
		));
		$main_uniacid = $link_uniacid_table->getMainUniacid($uniacid, $link_info['module_name'], $version_id);
		if (!empty($main_uniacid)) {
			$link_uniacid_table->where('id', $main_uniacid);
		}
		$link_uniacid_table->save();

		cache_clean(cache_system_key('module_setting', array('module_name' => $link_info['module_name'], 'uniacid' => $link_info['main_account']['uniacid'])));
		if (!empty($main_uniacid)) {
			cache_clean(cache_system_key('module_setting', array('module_name' => $link_info['module_name'], 'uniacid' => $main_uniacid)));
		}
		if (empty($version_id)) {
			cache_build_module_info($link_info['module_name']);
		} else {
			cache_delete(cache_system_key('miniapp_version', array('version_id' => $version_id)));
		}
	}
	iajax(0, '关联成功', url('module/display'));
}