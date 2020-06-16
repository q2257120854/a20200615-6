<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
namespace We7\Table\Uni;

class Modules extends \We7Table {
	protected $tableName = 'uni_modules';
	protected $primaryKey = 'id';
	protected $field = array(
		'uniacid',
		'module_name',

	);
	protected $default = array(
		'uniacid' => '',
		'module_name' => '',

	);

	public function searchLikeModuleTitle($module_title) {
		return $this->query->where('m.title LIKE', "%{$module_title}%");
	}

	public function searchWithModuleLetter($module_letter) {
		return $this->query->where('m.title_initial', $module_letter);
	}

	public function searchLikeAccountName($account_name) {
		return $this->query->where('a.name LIKE', "%{$account_name}%");
	}

	public function searchWithModuleName($module_name) {
		$this->query->where('u.module_name', $module_name);
	}

	public function searchGroupbyModuleName() {
		return $this->query->groupby('u.module_name');
	}

	public function getModulesByUid($uid, $uniacid = 0) {
		global $_W;
		if (empty($uid)) {
			$uid = $_W['uid'];
		}

		if (!empty($uniacid)) {
			$this->where('u.uniacid', $uniacid);
		} else {
			$this->where('u.uniacid <>', 0);
		}

		$slect_fields = "u.uniacid,u.module_name,m.title,m.logo,m.account_support,m.wxapp_support,m.webapp_support,m.phoneapp_support,m.xzapp_support,m.aliapp_support,m.baiduapp_support,m.toutiaoapp_support,a.name as account_name,c.acid,c.type as account_type,r.rank,ul.uniacid as default_uniacid";

		if (!user_is_founder($uid) && $_W['highest_role'] != ACCOUNT_MANAGE_NAME_CLERK) {
			$slect_fields .= ", uau.role";
			$this->where('uau.uid', $uid);
			$this->query->from('uni_account_users', 'uau')
				->leftjoin('uni_modules', 'u')
				->on(array('uau.uniacid' => 'u.uniacid'));
		} elseif (!user_is_founder($uid) && $_W['highest_role'] == ACCOUNT_MANAGE_NAME_CLERK) {
			$this->where('up.uid', $uid);
			$this->query->from('users_permission', 'up')
				->leftjoin('uni_modules', 'u')
				->on(array('up.type' => 'u.module_name'));
		} else {
			$this->query->from('uni_modules', 'u');
		}

		$modules = $this->query
			->select($slect_fields)
			->leftjoin('modules', 'm')
			->on(array('u.module_name' => 'm.name'))
			->leftjoin('uni_account', 'a')
			->on(array('u.uniacid' => 'a.uniacid'))
			->leftjoin('account', 'c')
			->on(array('u.uniacid' => 'c.uniacid'))
			->leftjoin('users_lastuse', 'ul')
			->on(array('u.module_name' => 'ul.modulename'))
			->leftjoin('modules_rank', 'r')
			->on(array('u.uniacid' => 'r.uniacid', 'u.module_name' => 'r.module_name'))
			->orderby('r.rank', 'DESC')
			->getall();

		$total = $this->getLastQueryTotal();
		return array('modules' => $modules, 'total' => $total);
	}

	public function deleteUniModules($module_name, $uniacid) {
		$this->query->where('module_name', $module_name)->where('uniacid', $uniacid)->delete();
	}

}