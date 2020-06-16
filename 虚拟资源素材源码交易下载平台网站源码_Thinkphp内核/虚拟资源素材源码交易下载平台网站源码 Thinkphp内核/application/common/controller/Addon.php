<?php

namespace app\common\controller;
use think\Loader;
use think\Cache;
use think\Config;
use think\Controller;
use think\Db;
use org\Http;
/**
 * 插件类
 * @author yangweijie <yangweijiester@gmail.com>
 */
class Addon extends Controller{
    /**
     * 视图实例对象
     * @var view
     * @access protected
     */
    protected $view = null;
    public $info                =   array();
    public $addon_path          =   '';
    public $config_file         =   '';
    public $custom_config       =   '';
    public $admin_list          =   array();
    public $custom_adminlist    =   '';
    public $custom_hiddeninput    =   '';
    public $custom_searchbar    =   '';
    public $access_url          =   array();
  
    public function __construct(){
    	parent::__construct();
    	$this->addon_path   =   ADDON_PATH.$this->getName().'/';
    	$this->assign('static_path', (is_HTTPS()?'https://':'http://') . $_SERVER['HTTP_HOST'] .getbaseurl().ADDON_DIR_NAME.'/' . strtolower($this->getName()).'/static/');
    	if(is_file($this->addon_path.'config.php')){
    		$this->config_file = $this->addon_path.'config.php';
    	}
    }
    
    //用于显示模板的方法
    protected function tplfetch($templateFile = ''){   	
        $view_path = ADDON_DIR_NAME.'/'.$this->getName().'/view/';  
        $this->view->engine(['view_path' => $view_path]);
        
    		$templateFile = $view_path.$templateFile.'.'.Config::get('template')['view_suffix'];
    		if(!is_file($templateFile)){
    			throw new \Exception("模板不存在:$templateFile");
    		}
    	
    	
    	echo $this->fetch($templateFile);
    }


    public function getName(){
        $class = get_class($this);
        return substr($class,strrpos($class, '\\')+1);
    }

   
    public function checkInfo(){
        
        $info_check_keys = array('name','title','description','status','author','version');
        foreach ($info_check_keys as $value) {
            if(!array_key_exists($value, $this->info))
                return FALSE;
        }
        return TRUE;
    }

    /**
     * 获取插件的配置数组
     */
    public function getConfig($name=''){
        static $_config = array();
        if(empty($name)){
            $name = $this->getName();
        }
       
       if(isset($_config[$name])){
            return $_config[$name];
        }
        $config =   array();
        $map['name']    =   $name;
        $map['status']  =   1;
        $config  =   Db::name('addons')->where($map)->value('config');

       if($config){
            $config   =   json_decode($config, true);
        }else{
        	
        	if(file_exists($this->config_file)){
        		$temp_arr = include $this->config_file;
        		 
        		foreach ($temp_arr as $key => $value) {
        			if($value['type'] == 'group'){
        				foreach ($value['options'] as $gkey => $gvalue) {
        					foreach ($gvalue['options'] as $ikey => $ivalue) {
        						$config[$ikey] = $ivalue['value'];
        					}
        				}
        			}else{
        				$config[$key] = $temp_arr[$key]['value'];
        			}
        		}
        	}
        	

        }
        $_config[$name]     =   $config; 
        return $config;
    }
 /**
     * 获取插件所需的钩子是否存在，没有则新增
     * @param string $str  钩子名称
     * @param string $addons  插件名称
     * @param string $addons  插件简介
     */
    public function getisHook($str, $addons, $msg=''){
        
        $where['name'] = $str;
        $gethook = Db::name('hooks')->where($where)->find();
        if(!$gethook || empty($gethook) || !is_array($gethook)){
            $data['name'] = $str;
            $data['description'] = $msg;
            $data['type'] = 1;
            $data['update_time'] = time();
            $data['addons'] = $addons;
            if( false !== Db::name('hooks')->insert($data) ){
               
            }
        }
    }
    
    /**
     * 删除钩子
     * @param string $hook  钩子名称
     */
    public function deleteHook($hook){
       
        $condition = array(
            'name' => $hook,
        );
       Db::name('hooks')->where($condition)->delete();
    }
    //必须实现安装
    public function install(){

    }

    //必须卸载插件方法
    public function uninstall(){
    	
    }
}
