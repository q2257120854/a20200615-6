<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');
load()->model('app');
load()->func('tpl');

$title = $_W['account']['name'] . '微站';
$dos = array('index', 'editprofile', 'personal_info', 'contact_method', 'education_info', 'jobedit', 'avatar', 'address', 'addressadd');
$do = in_array($do, $dos) ? $do : 'index';
$navs = app_navs('profile');
if (empty($_W['member']['uid'])) {
	message('请先登录!', url('auth/login', array('i' => $_W['uniacid'])), 'error');
}

$profile = mc_fetch($_W['member']['uid']);
if(!empty($profile)) {
	if(empty($profile['email']) || (!empty($profile['email']) && substr($profile['email'], -6) == 'we7.cc' && strlen($profile['email']) == 39)) {
		$profile['email'] = '';
		$profile['email_effective'] = 1;
	}
}
if(!empty($_W['openid'])) {
	$map_fans = pdo_getcolumn('mc_mapping_fans', array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']), 'tag');
	if(!empty($map_fans)) {
		if (is_base64($map_fans)){
			$map_fans = base64_decode($map_fans);
		}
		if (is_serialized($map_fans)) {
			$map_fans = iunserializer($map_fans);
		}
		if(!empty($map_fans) && is_array($map_fans)) {
						empty($profile['nickname']) ? ($data['nickname'] = strip_emoji($map_fans['nickname'])) : '';
			empty($profile['gender']) ? ($data['gender'] = $map_fans['sex']) : '';
			empty($profile['residecity']) ? ($data['residecity'] = ($map_fans['city']) ? $map_fans['city'] . '市' : '') : '';
			empty($profile['resideprovince']) ? ($data['resideprovince'] = ($map_fans['province']) ? $map_fans['province'] . '省' : '') : '';
			empty($profile['nationality']) ? ($data['nationality'] = $map_fans['country']) : '';
			empty($profile['avatar']) ? ($data['avatar'] = $map_fans['headimgurl']) : '';
			if(!empty($data)) {
				mc_update($_W['member']['uid'], $data);
			}
		}
	}
}


$sql = 'SELECT `mf`.*, `pf`.`field` FROM ' . tablename('mc_member_fields') . ' AS `mf` JOIN ' . tablename('profile_fields') . " AS `pf`
		ON `mf`.`fieldid` = `pf`.`id` WHERE `mf`.`uniacid` = :uniacid AND `mf`.`available` = :available";
$params = array(':uniacid' => $_W['uniacid'], ':available' => '1');
$mcFields = pdo_fetchall($sql, $params, 'field');
$personal_info_hide = mc_card_settings_hide('personal_info');
$contact_method_hide = mc_card_settings_hide('contact_method');
$education_info_hide = mc_card_settings_hide('education_info');
$jobedit_hide = mc_card_settings_hide('jobedit');

if ($do == 'editprofile'){
	if ($_W['isajax'] && $_W['ispost']) {
		if (!empty($_GPC)) {
			$_GPC['createtime'] = TIMESTAMP;
			foreach ($_GPC as $field => $value) {
				if (!isset($value) || in_array($field, array('uid','act', 'name', 'token', 'submit', 'session'))) {
					unset($_GPC[$field]);
					continue;
				}
			}
			if(empty($_GPC['email']) && $profile['email_effective'] == 1) {
				unset($_GPC['email']);
			}
			mc_update($_W['member']['uid'], safe_gpc_array($_GPC));
		}
		message('更新资料成功！', referer(), 'success');
	}
}
if ($do == 'avatar') {
	$avatar = array('avatar' => safe_gpc_string($_GPC['avatar']));
	if (mc_update($_W['member']['uid'], $avatar)) {
		message('头像设置成功！', referer(), 'success');
	}
}

if ($do == 'address') {
	$address_id = intval($_GPC['id']);
	if ($_GPC['op'] == 'default') {
		pdo_update('mc_member_address', array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
		pdo_update('mc_member_address', array('isdefault' => 1), array('id' => $address_id, 'uniacid' => $_W['uniacid']));
		mc_update($_W['member']['uid'], array('address' => safe_gpc_string($_GPC['address'])));
	}
	if ($_GPC['op'] == 'delete') {
		if (!empty($profile) && !empty($_W['openid'])) {
			pdo_delete('mc_member_address', array('id' => $address_id, 'uid' => $_W['member']['uid']));
		}
	}
	$where = ' WHERE 1';
	$params = array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid']);
	if (!empty($_GPC['addid'])) {
		$where .= ' AND `id` = :id';
		$params[':id'] = intval($_GPC['addid']);
	}
	$where .= ' AND `uniacid` = :uniacid AND `uid` = :uid';
	$sql = 'SELECT * FROM ' . tablename('mc_member_address') . $where;
	if (empty($params[':id'])) {
		$psize = 10;
		$pindex = max(1, intval($_GPC['page']));
		$sql .= ' LIMIT ' . ($pindex - 1) * $psize . ',' . $psize;
		$addresses = pdo_fetchall($sql, $params);
		$sql = 'SELECT COUNT(*) FROM ' . tablename('mc_member_address') . $where;
		$total = pdo_fetchcolumn($sql, $params);
		$pager = pagination($total, $pindex, $psize);
	} else {
		$address = pdo_fetch($sql, $params);
	}
}

if ($do == 'addressadd') {
	$addid = intval($_GPC['addid']);
	if ($_W['isajax'] && $_W['ispost']) {
		$post = safe_gpc_array($_GPC['address']);
		if (empty($post['username'])) {
			message('请输入您的姓名', referer(), 'error');
		}
		if (empty($post['mobile'])) {
			message('请输入您的手机号', referer(), 'error');
		}
		if (empty($post['zipcode'])) {
			message('请输入您的邮政编码', referer(), 'error');
		}
		if (empty($post['province'])) {
			message('请输入您的所在省', referer(), 'error');
		}
		if (empty($post['city'])) {
			message('请输入您的所在市', referer(), 'error');
		}
		if (empty($post['address'])) {
			message('请输入您的详细地址', referer(), 'error');
		}
		$address = array(
			'username' => $post['username'],
			'mobile' => $post['mobile'],
			'zipcode' => $post['zipcode'],
			'province' => $post['province'],
			'city' => $post['city'],
			'district' => empty($post['district']) ? '' : $post['district'],
			'address' => $post['address'],
		);
		$address_data = pdo_get('mc_member_address', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
		if (empty($address_data)) {
			$address['isdefault'] = 1;
		}
		if (!empty($addid)) {
			if (pdo_update('mc_member_address', $address, array('id' => $addid, 'uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']))) {
				message('修改收货地址成功', url('mc/profile/address'), 'success');
			} else {
				message('修改收货地址失败，请稍后重试', url('mc/profile/address'), 'error');
			}
		} else {
			$address['uniacid'] = $_W['uniacid'];
			$address['uid'] = $_W['member']['uid'];
			if (pdo_insert('mc_member_address', $address)) {
				$adres = pdo_get('mc_member_address', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'isdefault'=> 1));
				if (!empty($adres)) {
					$adres['address'] = $adres['province'].$adres['city'].$adres['district'].$adres['address'];
					mc_update($_W['member']['uid'], array('address' => $adres['address']));
				}
				message('地址添加成功', url('mc/profile/address'), 'success');
			}
		}
	}
	if (!empty($addid)) {
		$address = pdo_get('mc_member_address', array('id' => $addid, 'uniacid' => $_W['uniacid']));
	}
}
template('mc/profile');