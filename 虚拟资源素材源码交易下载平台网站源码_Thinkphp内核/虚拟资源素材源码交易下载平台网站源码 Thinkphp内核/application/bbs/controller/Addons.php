<?php
namespace app\bbs\controller;
use app\common\controller\HomeBase;
use think\Controller;
use think\Session;
use think\Db;
/**
 * 扩展控制器
 * 用于调度各个扩展的URL访问需求
 */
class Addons extends HomeBase{

	protected $addons = null;

	
	
	public function execute($addon_name = null, $controller_name = null, $action_name = null,$json=false){
		
		
		$class_path = "\\".ADDON_DIR_NAME."\\".$addon_name."\controller\\".$controller_name;
	
	    	//$class_path = "\addon\\attach\controller\Attach";
    	
    	$controller = new $class_path();
    	
	if($json){
    		return json($controller->$action_name());
    	}else{
    		$controller->$action_name();
    	}
	}
	/**
	 * 获取插件的配置数组
	 */
	public function getConfig($name=''){
		
		
		$config =   array();
		$map['name']    =   $name;
		$map['status']  =   1;
		$config  =   Db::name('addons')->where($map)->value('config');
		$config   =   json_decode($config, true);
		 
		return $config;
	}
	
	

}
