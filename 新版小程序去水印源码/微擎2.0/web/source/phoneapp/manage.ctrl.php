<?php

defined('IN_IA') or exit('Access Denied');


load()->model('phoneapp');
$account_info = permission_user_account_num();

$do = safe_gpc_belong($do, array('create_display', 'save', 'display', 'del_version'), 'display');

$uniacid = intval($_GPC['uniacid']);
$acid = intval($_GPC['acid']);

if (!empty($uniacid)) {
	$state = permission_account_user_role($_W['uid'], $uniacid);
	
		$role_permission = in_array($state, array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_FOUNDER, ACCOUNT_MANAGE_NAME_MANAGER, ACCOUNT_MANAGE_NAME_VICE_FOUNDER));
	
	
	if (!$role_permission) {
		itoast('无权限操作！', referer(), 'error');
	}
}


if ($do == 'save') {
	$version_id = intval($_GPC['version_id']);
	if (empty($uniacid) && empty($account_info['phoneapp_limit']) && !user_is_founder($_W['uid'])) {
		iajax(-1, '创建APP个数已满');
	}
	if (empty($_GPC['name']) && empty($_GPC['uniacid'])) {
		iajax(1, '请填写APP名称');
	}
	if (!preg_match('/^[0-9]{1,2}\.[0-9]{1,2}(\.[0-9]{1,2})?$/', trim($_GPC['version']))) {
		iajax('-1', '版本号错误，只能是数字、点，数字最多2位，例如 1.1.1 或1.2');
	}
	$modulename = safe_gpc_string(trim($_GPC['module'][0]['name']));
	$version = safe_gpc_string(trim($_GPC['module'][0]['version']));

	$version_data = array(
		'uniacid' => $uniacid,
		'description' => safe_gpc_string($_GPC['description']),
		'version' => safe_gpc_string($_GPC['version']),
		'modules' => iserializer(array($modulename => array('name' => $modulename, 'version' => $version))),
	);

	if (empty($uniacid) && empty($version_id)) {
		
	} elseif (!empty($version_id)) {
		$version_exist = phoneapp_version($version_id);
		if(empty($version_exist)) {
			iajax(1, '版本不存在或已删除！');
		}
		$result = pdo_update('phoneapp_versions', $version_data, array('id' => $version_id));
		if (!empty($result)) {
			table('uni_link_uniacid')->searchWithUniacidModulenameVersionid($uniacid, $modulename, $version_id)->delete();
		}

	} else {
		$result = pdo_insert('phoneapp_versions', $version_data);
		$version_id = pdo_insertid();
	}

	if (!empty($result)) {
		cache_delete(cache_system_key('user_accounts', array('type' => 'phoneapp', 'uid' => $_W['uid'])));
		iajax(0, '创建成功', url('account/display/switch', array('uniacid' => $uniacid, 'version_id' => $version_id)));
	}
	iajax(-1, '创建失败', url('phoneapp/manage/create_display'));
}

if($do == 'create_display') {
	$version_id = intval($_GPC['version_id']);
	$version_info = phoneapp_version($version_id);
	$modules = phoneapp_support_modules();
	template('phoneapp/create');
}

if ($do == 'display') {
	$account = uni_fetch($uniacid);
	if (is_error($account)) {
		itoast($account['message'], url('account/manage', array('account_type' => ACCOUNT_TYPE_PHONEAPP_NORMAL)), 'error');
	} else {
		$phoneapp_info = table('account_phoneapp')->where('uniacid', $account['uniacid'])->get();

		$version_exist = phoneapp_fetch($account['uniacid']);

		if (!empty($version_exist)) {
			$phoneapp_version_lists = phoneapp_version_all($account['uniacid']);
			$phoneapp_modules = phoneapp_support_modules();
		}
	}

	template('phoneapp/manage');
}

if ($do == 'del_version') {
	$id = intval($_GPC['version_id']);
	if (empty($id)) {
		iajax(1, '参数错误！');
	}
	$version_exist = pdo_get('phoneapp_versions', array('id' => $id, 'uniacid' => $uniacid));
	if (empty($version_exist)) {
		iajax(1, '模块版本不存在！');
	}

	$version_module = current((array)iunserializer($version_exist['modules']));
	if (!empty($version_module['uniacid']) && !empty($version_module['name'])) {
		table('uni_link_uniacid')->searchWithUniacidModulenameVersionid($uniacid, $version_module['name'], $id)->delete();
	}
	$result = pdo_delete('phoneapp_versions', array('id' => $id, 'uniacid' => $uniacid));
	if (!empty($result)) {
		iajax(0, '删除成功！', referer());
	} else {
		iajax(1, '删除失败，请稍候重试！');
	}
}