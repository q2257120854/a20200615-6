<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use  think\Request;
use  think\Cache;
use  think\Session;
use app\common\model\Addons as AddonsModel;
use app\common\model\Hooks as HooksModel;
/**
 * 扩展后台管理页面
 * @author yangweijie <yangweijiester@gmail.com>
 */
class InstallAddons extends AdminBase {
	
   
    public function index(){
      
      
          return view();

    }


}
