<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
defined('IN_IA') or exit('Access Denied');

load()->model('cloud');
load()->func('communication');
load()->func('db');

$cloud_ready = cloud_prepare();
if (is_error($cloud_ready)) {
	itoast($cloud_ready['message'], url('cloud/profile'), 'error');
}

$dos = array('upgrade');
$do = in_array($do, $dos) ? $do : 'upgrade';
uni_user_permission_check('system_cloud_upgrade');

if (empty($_W['setting']['site']['profile_perfect'])) {
	}

if ($do == 'upgrade') {
	$_W['page']['title'] = '一键更新 - 云服务';
	if (empty($_W['setting']['cloudip']) || $_W['setting']['cloudip']['expire'] < TIMESTAMP) {
  $cloudip = gethostbyname('up.vip432.com');
		if (empty($cloudip) || !preg_match('/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}$/', $cloudip)) {
			itoast('云服务域名解析失败，请查看服务器DNS设置或是在“云服务诊断”中手动设置云服务IP', url('cloud/diagnose'), 'error');
		}
		setting_save(array('ip' => $cloudip, 'expire' => TIMESTAMP + 3600), 'cloudip');
	}

	if (checksubmit('submit')) {
		$upgrade = cloud_build();
		if (is_error($upgrade)) {
			itoast($upgrade['message'], '', 'error');
		}
		if ($upgrade['upgrade']) {
			itoast("检测到新版本: <strong>{$upgrade['version']} (Release {$upgrade['release']})</strong>, 请立即更新.", 'refresh');
		} else {
			cache_delete('checkupgrade:system');
			cache_delete('cloud:transtoken');
			itoast('检查结果: 恭喜, 你的程序已经是最新版本. ', 'refresh');
		}
	}
	cache_load('upgrade');
	if (!empty($_W['cache']['upgrade'])) {
		$upgrade_cache = $_W['cache']['upgrade'];
	}
	if (empty($upgrade_cache) || TIMESTAMP - $upgrade_cache['lastupdate'] >= 3600 * 24 || empty($upgrade_cache['data'])) {
		$upgrade = cloud_build();
	} else {
		$upgrade = $upgrade_cache['data'];
	}
	cache_delete('cloud:transtoken');
	$path = IA_ROOT . '/data/patch/' . date('Ymd') . '/';
	if (is_dir($path)) {
		if ($handle = opendir($path)) {
			while (false !== ($patchpath = readdir($handle))) {
				if ($patchpath != '.' && $patchpath != '..') {
					if(is_dir($path.$patchpath)){
						$patchs[] = $patchpath;
					}
				}
			}
		}
		if (!empty($patchs)) {
			sort($patchs, SORT_NUMERIC);
		}
	}
}
template('cloud/upgrade');