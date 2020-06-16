<?php
/**
 * [WeEngine System] Copyright (c) 2014 WE7.CC
 * WeEngine is NOT a free software, it under the license terms, visited http://www.we7.cc/ for more details.
 */
namespace We7\Table\Wxapp;

class Versions extends \We7Table {
	protected $tableName = 'wxapp_versions';
	protected $primaryKey = 'id';
	protected $field = array(
		'uniacid',
		'multiid',
		'version',
		'description',
		'modules',
		'design_method',
		'template',
		'quickmenu',
		'createtime',
		'appjson',
		'default_appjson',
		'use_default',
		'type',
		'entry_id',
		'last_modules',
		'upload_time',
		'tominiprogram',
	);
	protected $default = array(
		'uniacid' => '',
		'multiid' => '',
		'version' => '',
		'description' => '',
		'modules' => '',
		'design_method' => '',
		'template' => '',
		'quickmenu' => '',
		'createtime' => '',
		'appjson' => '',
		'default_appjson' => '',
		'use_default' => 1,
		'type' => 0,
		'entry_id' => 0,
		'last_modules' => '',
		'upload_time' => 0,
		'tominiprogram' => '',
	);

	
	public function latestVersion($uniacid) {
		return $this->query->where('uniacid', $uniacid)->orderby('id', 'desc')->limit(4)->getall('id');
	}

	public function getById($version_id) {
		$result = $this->query->where('id', $version_id)->get();
		if (!empty($result)) {
			$result['modules'] = iunserializer($result['modules']);
			$result['quickmenu'] = iunserializer($result['quickmenu']);
			$result['last_modules'] = iunserializer($result['last_modules']);
		}
		return $result;
	}

	public function getByUniacidAndVersion($uniacid, $version) {
		$result = $this->query->where('uniacid', $uniacid)->where('version', $version)->get();
		if (!empty($result)) {
			$result['modules'] = iunserializer($result['modules']);
			$result['quickmenu'] = iunserializer($result['quickmenu']);
			$result['last_modules'] = iunserializer($result['last_modules']);
		}
		return $result;
	}

	public function getAllByUniacid($uniacid) {
		$data = $this->where('uniacid', $uniacid)->orderby(array('upload_time' => 'DESC', 'id' => 'DESC'))->getall();
		if (!empty($data)) {
			foreach ($data as $key => $row) {
				$data[$key]['modules'] = iunserializer($row['modules']);
				$data[$key]['quickmenu'] = iunserializer($row['quickmenu']);
				$data[$key]['last_modules'] = iunserializer($row['last_modules']);
			}
		}
		return $data;
	}
}