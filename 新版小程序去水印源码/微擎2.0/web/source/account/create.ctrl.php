<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('module');
load()->model('miniapp');
load()->model('phoneapp');
load()->model('user');

$dos = array('base_info', 'account_modules', 'create_version', 'get_user_info');
$do = in_array($do, $dos) ? $do : 'base_info';

if ($do == 'base_info') {
	$sign = safe_gpc_string($_GPC['sign']);
	$sign_title = $account_all_type_sign[$sign]['title'];
	$create_account_type = $account_all_type_sign[$sign]['contain_type'][0];

	if (empty($account_all_type_sign[$sign])) {
		message('账号类型不存在,请重试.');
	}

	$user_account_num = permission_user_account_num($_W['uid']);
	if (empty($_W['isfounder']) && $user_account_num["{$sign}_limit"] <= 0) {
		message('创建的' .  $sign_title . '已达上限！');
	}
	if (checksubmit('submit')) {
		$post = array();
		$post['name'] = safe_gpc_string(trim($_GPC['name']));
		$post['description'] = safe_gpc_string($_GPC['description']);
		if (empty($post['name'])) {
			itoast($sign_title . '名称不能为空', '', '');
		}
				$account_table = table('account');
		$account_table->searchWithTitle($post['name']);
		$account_table->searchWithType($create_account_type);
		$check_uniacname = $account_table->searchAccountList();
		if (!empty($check_uniacname)) {
			itoast("该{$sign_title}名称已经存在", '', '');
		}

		if (in_array($sign, array(ACCOUNT_TYPE_SIGN, XZAPP_TYPE_SIGN, WEBAPP_TYPE_SIGN, PHONEAPP_TYPE_SIGN))) {
						pdo_insert('uni_account', array(
				'groupid' => 0,
				'default_acid' => 0,
				'name' => $post['name'],
				'description' => $post['description'],
				'title_initial' => get_first_pinyin($post['name']),
			));
			$uniacid = pdo_insertid();
			if (empty($uniacid)) {
				itoast("添加{$sign_title}失败", '', '');
			}
						$account_data = array(
				'name' => $post['name'],
				'type' => $create_account_type,
			);
			if ($sign == ACCOUNT_TYPE_SIGN) {
				$account_data['account'] = safe_gpc_string(trim($_GPC['account']));
				$account_data['original'] = safe_gpc_string(trim($_GPC['original']));
				$account_data['level'] = intval($_GPC['level']);
				$account_data['key'] = safe_gpc_string(trim($_GPC['key']));
				$account_data['secret'] = safe_gpc_string(trim($_GPC['secret']));
			} elseif ($sign == XZAPP_TYPE_SIGN) {
				$account_data['original'] = safe_gpc_string(trim($_GPC['original']));
				$account_data['level'] = intval($_GPC['level']);
				$account_data['key'] = safe_gpc_string(trim($_GPC['key']));
				$account_data['secret'] = safe_gpc_string(trim($_GPC['secret']));
			}
			$acid = account_create($uniacid, $account_data);
			if(is_error($acid)) {
				itoast("添加{$sign_title}信息失败", '', 'error');
			}
			pdo_update('uni_account', array('default_acid' => $acid), array('uniacid' => $uniacid));

						if (!empty($_GPC['headimg'])) {
				$headimg = safe_gpc_path($_GPC['headimg']);
				if (file_is_image($headimg)) {
					copy($headimg, IA_ROOT . '/attachment/headimg_'.$acid.'.jpg');
				}
			}
			if (!empty($_GPC['qrcode'])) {
				$qrcode = safe_gpc_path($_GPC['qrcode']);
				if (file_is_image($qrcode)) {
					copy($qrcode, IA_ROOT . '/attachment/qrcode_'.$acid.'.jpg');
				}
			}
						if (empty($_W['isfounder'])) {
				uni_user_account_role($uniacid, $_W['uid'], ACCOUNT_MANAGE_NAME_OWNER);
				cache_build_account_modules($uniacid);
			}
			
				if (user_is_vice_founder()) {
					uni_user_account_role($uniacid, $_W['uid'], ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
				}
				if (!empty($_W['user']['owner_uid'])) {
					uni_user_account_role($uniacid, $_W['user']['owner_uid'], ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
				}
			

						if (in_array($sign, array(ACCOUNT_TYPE_SIGN, XZAPP_TYPE_SIGN))) {
				pdo_insert('mc_groups', array('uniacid' => $uniacid, 'title' => '默认会员组', 'isdefault' => 1));
				$fields = pdo_getall('profile_fields');
				if (is_array($fields)) {
					foreach($fields as $field) {
						pdo_insert('mc_member_fields', array(
							'uniacid' => $uniacid,
							'fieldid' => $field['id'],
							'title' => $field['title'],
							'available' => $field['available'],
							'displayorder' => $field['displayorder'],
						));
					}
				}
			}
						if ($sign == ACCOUNT_TYPE_SIGN) {
								$oauth = uni_setting($uniacid, array('oauth'));
				if ($acid　&& empty($oauth['oauth']['account']) && !empty($account_data['key']) && !empty($account_data['secret'])  && $account_data['level'] == ACCOUNT_SERVICE_VERIFY) {
					pdo_update('uni_settings',
						array('oauth' => iserializer(array('account' => $acid, 'host' => $oauth['oauth']['host']))),
						array('uniacid' => $uniacid)
					);
				}
								$template = pdo_fetch('SELECT id,title FROM ' . tablename('site_templates') . " WHERE name = 'default'");
				pdo_insert('site_styles', array(
					'uniacid' => $uniacid,
					'templateid' => $template['id'],
					'name' => $template['title'] . '_' . random(4),
				));
				$styleid = pdo_insertid();
								pdo_insert('site_multi', array(
					'uniacid' => $uniacid,
					'title' => $post['name'],
					'styleid' => $styleid,
				));
				$multi_id = pdo_insertid();
			}
			pdo_insert('uni_settings', array(
				'creditnames' => iserializer(array('credit1' => array('title' => '积分', 'enabled' => 1), 'credit2' => array('title' => '余额', 'enabled' => 1))),
				'creditbehaviors' => iserializer(array('activity' => 'credit1', 'currency' => 'credit2')),
				'uniacid' => $uniacid,
				'default_site' => empty($multi_id) ? 0 : $multi_id,
				'sync' => iserializer(array('switch' => 0, 'acid' => '')),
			));
		}

		if (in_array($sign, array(WXAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, BAIDUAPP_TYPE_SIGN, TOUTIAOAPP_TYPE_SIGN))) {
			$miniapp_data = array(
				'name' => $post['name'],
				'type' => $create_account_type,
				'description' => $post['description'],
				'headimg' => !empty($_GPC['headimg']) && file_is_image($_GPC['headimg']) ?  $_GPC['headimg'] : '',
				'qrcode' => !empty($_GPC['qrcode']) && file_is_image($_GPC['qrcode']) ?  $_GPC['qrcode'] : '',
			);
			if ($sign == WXAPP_TYPE_SIGN) {
				$miniapp_data['original'] = safe_gpc_string($_GPC['original']);
				$miniapp_data['level'] = 1;
			}
						if (isset($_GPC['key']) && !empty($_GPC['key'])) {
				$miniapp_data['key'] = safe_gpc_string($_GPC['key']);
			}
			if (isset($_GPC['appid']) && !empty($_GPC['appid'])) {
				if ($sign == WXAPP_TYPE_SIGN || $sign == ALIAPP_TYPE_SIGN) {
					$miniapp_data['key'] = safe_gpc_string($_GPC['appid']);
				} else {
					$miniapp_data['appid'] = safe_gpc_string($_GPC['appid']);
				}
			}
			if (isset($_GPC['secret']) && !empty($_GPC['secret'])) {
				$miniapp_data['secret'] = safe_gpc_string($_GPC['secret']);
			}

			$uniacid = miniapp_create($miniapp_data);
			if (is_error($uniacid)) {
				itoast('添加失败');
			}
		}
		$next_url = '';
		if ($_W['isfounder']) {
			$next_url = url('account/create/account_modules', array('uniacid' => $uniacid));
		} else {
			if ($sign == ACCOUNT_TYPE_SIGN) {
				$next_url = url('account/post-step', array('uniacid' => $uniacid, 'acid' => $account['acid'], 'step' => 4));
			} elseif ($sign == XZAPP_TYPE_SIGN) {
				$next_url = url('xzapp/post-step', array('uniacid' => $uniacid, 'acid' => $account['acid'], 'step' => 4));
			} elseif (in_array($sign, array(PHONEAPP_TYPE_SIGN, WXAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, BAIDUAPP_TYPE_SIGN, TOUTIAOAPP_TYPE_SIGN))) {
				$next_url = url('account/create/create_version', array('uniacid' => $uniacid));
			} else {
				$next_url = url('account/display/switch', array('uniacid' => $uniacid, 'acid' => $acid, 'type' => $create_account_type));
			}
		}
		header('Location: ' . $next_url);
		exit;
	}
}

if ($do == 'account_modules') {
	if (empty($_W['isfounder'])) {
		itoast('无权限');
	}
	$uniacid = $_GPC['uniacid'];
	if (empty($uniacid)) {
		itoast('参数有误');
	}
	$account = uni_fetch($uniacid);
	if (empty($account)) {
		itoast('参数有误');
	}
	$sign = $account['type_sign'];
	$sign_title = $account_all_type_sign[$account['type_sign']]['title'];

	if (checksubmit('submit')) {
		$uid = intval($_GPC['uid']);
		if (!empty($uid)) {
						if (!user_is_founder($_W['uid'], true)) {
				$create_account_info = permission_user_account_num($uid);
				if ($create_account_info[$account['type_sign'] . '_limit'] <= 0) {
					itoast("您所设置的主管理员所在的用户组可添加的公众号数量已达上限，请选择其他人做主管理员！", referer(), 'error');
				}
			}
			$owner = pdo_get('uni_account_users', array('uniacid' => $uniacid, 'role' => 'owner'));
			if (!empty($owner)) {
				pdo_update('uni_account_users', array('uid' => $uid), array('uniacid' => $uniacid, 'role' => 'owner'));
			} else {
				uni_user_account_role($uniacid, $uid, ACCOUNT_MANAGE_NAME_OWNER);
			}
			
				$user_vice_id = pdo_getcolumn('users', array('uid' => $uid), 'owner_uid');
				if ($_W['user']['founder_groupid'] != ACCOUNT_MANAGE_GROUP_VICE_FOUNDER && !empty($user_vice_id)) {
					uni_user_account_role($uniacid, $user_vice_id, ACCOUNT_MANAGE_NAME_VICE_FOUNDER);
				}
			
		}

		if (!empty($_GPC['endtime'])) {
			$account_end_time = strtotime($_GPC['endtime']);
			if (!empty($uid)) {
				$user_end_time = user_end_time($uid);
				if ($user_end_time > 0 && $account_end_time > $user_end_time) {
					$account_end_time = $user_end_time;
				}
			}
		} else {
			$account_end_time = 0;
		}
		pdo_update('account', array('endtime' => $account_end_time), array('uniacid' => $uniacid));

				pdo_delete('uni_account_group', array('uniacid' => $uniacid));
		if (!empty($_GPC['package'])) {
			foreach ($_GPC['package'] as $packageid) {
				$packageid = intval($packageid);
				if (!empty($packageid)) {
					pdo_insert('uni_account_group', array(
						'uniacid' => $uniacid,
						'groupid' => $packageid,
					));
				}
			}
		}
				if (!empty($_GPC['extra']['modules']) || !empty($_GPC['extra']['templates'])) {
			$data = array(
				'modules' => array('modules' => array(), 'wxapp' => array(), 'webapp' => array(), 'xzapp' => array(), 'phoneapp' => array()),
				'templates' => iserializer($_GPC['extra']['templates']),
				'uniacid' => $uniacid,
				'name' => '',
			);
			$group_sign = $account['type_sign'] == 'account' ? 'modules' : $account['type_sign'];
			$data['modules'][$group_sign] = $_GPC['extra']['modules'];
			$data['modules'] = iserializer($data['modules']);
			$id = pdo_fetchcolumn("SELECT id FROM ".tablename('uni_group')." WHERE uniacid = :uniacid", array(':uniacid' => $uniacid));
			if (empty($id)) {
				pdo_insert('uni_group', $data);
			} else {
				pdo_update('uni_group', $data, array('id' => $id));
			}
		} else {
			pdo_delete('uni_group', array('uniacid' => $uniacid));
		}

		cache_delete(cache_system_key('uniaccount', array('uniacid' => $uniacid)));
		cache_delete(cache_system_key('unimodules', array('uniacid' => $uniacid, 'enabled' => 1)));
		cache_delete(cache_system_key('unimodules', array('uniacid' => $uniacid, 'enabled' => '')));
		cache_delete(cache_system_key('proxy_wechatpay_account'));
		cache_build_account_modules($uniacid, $uid);
		$cash_index = $account['type_sign'] == 'account' ? 'app' : $account['type_sign'];
		cache_delete(cache_system_key('user_accounts', array('type' => $cash_index, 'uid' => $_W['uid'])));
		if (!empty($uid)) {
			cache_delete(cache_system_key('user_accounts', array('type' => $cash_index, 'uid' => $uid)));
		}

		$next_url = '';
		if ($account['type_sign'] == ACCOUNT_TYPE_SIGN) {
			$next_url = url('account/post-step', array('uniacid' => $uniacid, 'acid' => $account['acid'], 'step' => 4));
		} elseif ($account['type_sign'] == XZAPP_TYPE_SIGN) {
			$next_url = url('xzapp/post-step', array('uniacid' => $uniacid, 'acid' => $account['acid'], 'step' => 4));
		} elseif (in_array($account['type_sign'], array(PHONEAPP_TYPE_SIGN, WXAPP_TYPE_SIGN, ALIAPP_TYPE_SIGN, BAIDUAPP_TYPE_SIGN, TOUTIAOAPP_TYPE_SIGN))) {
			$next_url = url('account/create/create_version', array('uniacid' => $uniacid));
		} else {
			$next_url = url('account/display/switch', array('uniacid' => $uniacid, 'acid' => $account['acid'], 'type' => $create_account_type));
		}
		header('Location: ' . $next_url);
		exit;
	}

	$unigroups = uni_groups();
	foreach ($unigroups as $key => $group) {
		if (empty($group[$account['type_sign']])) {
			unset($unigroups[$key]); 		}
	}
	$modules = user_modules($_W['uid']);
	foreach ($modules as $k => $module) {
		if ($module['issystem'] == 1 || $module[$account['type_sign'].'_support'] != MODULE_SUPPORT_ACCOUNT) {
			unset($modules[$k]);		} else {
			$modules[$k]['support'] = $account['type_sign'] . '_support';
		}
	}
	if (in_array($account['type_sign'], array(ACCOUNT_TYPE_SIGN, XZAPP_TYPE_SIGN))) {
		$templates  = pdo_fetchall("SELECT * FROM ".tablename('site_templates'));
	}
}

if ($do == 'create_version') {
	$uniacid = $_GPC['uniacid'];
	if (empty($uniacid)) {
		iajax(-1, '参数有误');
	}
	$account = uni_fetch($uniacid);
	if (empty($account)) {
		iajax(-1, '参数有误');
	}
	$sign = $account['type_sign'];
	$sign_title = $account_all_type_sign[$account['type_sign']]['title'];

	if (checksubmit('submit')) {
		if (!preg_match('/^[0-9]{1,2}\.[0-9]{1,2}(\.[0-9]{1,2})?$/', trim($_GPC['version']))) {
			iajax(-1, '版本号错误，只能是数字、点，数字最多2位，例如 1.1.1 或1.2');
		}
				$version = array(
			'uniacid' => $uniacid,
			'description' => safe_gpc_string($_GPC['description']),
			'version' => safe_gpc_string($_GPC['version']),
			'modules' => '',
			'createtime' => TIMESTAMP,
		);
				$modulename = safe_gpc_string($_GPC['choose_module']['name']);
		$module = module_fetch($modulename);
		if (!empty($module)) {
			$version['modules'] = serialize(array($module['name'] => array(
				'name' => $module['name'],
				'version' => $module['version'],
			)));
		}
		if ($account['type_sign'] == WXAPP_TYPE_SIGN) {
			$version['design_method'] = WXAPP_MODULE;
			$version['quickmenu'] = '';
			$version['createtime'] = TIMESTAMP;
			$version['template'] = 0;
			$version['type'] = 0; 			$version['multiid'] = 0;
		}

		if ($account['type_sign'] == PHONEAPP_TYPE_SIGN) {
			pdo_insert('phoneapp_versions', $version);
		} else {
			pdo_insert('wxapp_versions', $version);
		}
		$version_id = pdo_insertid();
		if (empty($version_id)) {
			iajax(-1, '创建失败');
		} else {
			cache_delete(cache_system_key('user_accounts', array('type' => $account['type_sign'], 'uid' => $_W['uid'])));
			iajax(0, '创建成功', url('account/display/switch', array('uniacid' => $uniacid, 'version_id' => $version_id, 'type' => $account['type'])));
		}
	}
}

if ($do == 'get_user_info') {
	$uid = intval($_GPC['uid'][0]);
	$sign = trim($_GPC['sign']);
	if (empty($account_all_type_sign[$sign])) {
		iajax(-1, '参数有误');
	}
	$user = user_single(array('uid' => $uid));
	if (empty($user)) {
		iajax(-1, '用户不存在或是已经被删除', '');
	}
	$info = array(
		'uid' => $user['uid'],
		'username' => $user['username'],
		'group' => user_group_detail_info($user['groupid']),
		'modules' => array(),
	);
	$info['package'] = empty($info['group']['package']) ? array() : iunserializer($info['group']['package']);

	$user_modules = user_modules($user['uid']);
	if (!empty($user_modules)) {
		foreach ($user_modules as $module) {
			if ($module['issystem'] != 1 && $module[$sign.'_support'] == MODULE_SUPPORT_ACCOUNT) {
				$info['modules'][] = $module;
			}
		}
	}
	iajax(0, $info);
}

template('account/create');