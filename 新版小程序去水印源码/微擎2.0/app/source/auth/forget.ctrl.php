<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

$openid = $_W['openid'];
$dos = array('reset', 'forget', 'verifycode');
$do = in_array($do, $dos) ? $do : 'forget';

$setting = uni_setting($_W['uniacid'], array('uc', 'passport'));
$uc_setting = $setting['uc'] ? $setting['uc'] : array();
$register_mode = $setting['passport']['item'] ? $setting['passport']['item'] : 'random';
$forward = url('mc');
if(!empty($_GPC['forward'])) {
	$forward = './index.php?' . base64_decode($_GPC['forward']) . '#wechat_redirect';
}
if(!empty($_W['member']) && (!empty($_W['member']['mobile']) || !empty($_W['member']['email']))) {
	header('location: ' . $forward);
	exit;
}
if ($do == 'verifycode') {
	if($_W['ispost'] && $_W['isajax']) {
		$username = safe_gpc_string($_GPC['username']);
		$code = safe_gpc_string($_GPC['code']);
		load()->model('utility');
		if(!code_verify($_W['uniacid'], $username, $code)) {
			message('验证码错误', referer(), 'error');
		} else {
			pdo_delete('uni_verifycode', array('receiver' => $username));
			isetcookie('__we7_app_find_password', md5($username . $code), 0, true);
			message('验证码正确', referer(), 'success');
		}
	}
}
if($do == 'reset') {
	if($_W['ispost'] && $_W['isajax']) {
		$username = safe_gpc_string($_GPC['username']);
		$code = safe_gpc_string($_GPC['code']);
		if ($_GPC['__we7_app_find_password'] !== md5($username . $code)) {
			iajax(-1, '请先验证手机号及验证码!');
		}
		$password = safe_gpc_string($_GPC['password']);
		$repassword = safe_gpc_string($_GPC['repassword']);
		if ($repassword != $password) {
			message('密码输入不一致', referer(), 'error');
		}
		$sql = 'SELECT `uid`,`salt` FROM ' . tablename('mc_members') . ' WHERE `uniacid`=:uniacid';
		$pars = array();
		$pars[':uniacid'] = $_W['uniacid'];
		if(preg_match('/^\d{11}$/', $username)) {
			$type = 'mobile';
			$sql .= ' AND `mobile`=:mobile';
			$pars[':mobile'] = $username;
		} elseif(preg_match("/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/", $username)) {
			$type = 'email';
			$sql .= ' AND `email`=:email';
			$pars[':email'] = $username;
		} else {
			message('用户名格式不正确', referer(), 'error');
		}
		$user = pdo_fetch($sql, $pars);
		if(empty($user)) {
			message('用户不存在', referer(), 'error');
		} else {
			$password = md5($password . $user['salt'] . $_W['config']['setting']['authkey']);
			mc_update($user['uid'], array('password' => $password));
		}
		isetcookie('__we7_app_find_password', '', 0, true);
		message('找回成功', referer(), 'success');
	}
}
template('auth/forget');
