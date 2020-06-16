<?php
namespace app\common\controller;

use org\Auth;
use think\Loader;
use think\Cache;
use think\Controller;
use think\Db;
use think\Session;
use app\common\model\Addons as AddonsModel;
/**
 * 后台公用基础控制器
 * Class AdminBase
 * @package app\common\controller
 */
class AdminBase extends Controller
{
    protected function _initialize()
    {
        parent::_initialize(); 
        $root='http://'.$_SERVER['HTTP_HOST'].getbaseurl();  
        $this->checkAuth();
        $this->getMenu();
        $this->assign('root',$root);
        // 输出当前请求控制器（配合后台侧边菜单选中状态）
        $this->assign('controller', Loader::parseName($this->request->controller()));
    }

    /**
     * 权限检查
     * @return bool
     */
    protected function checkAuth()
    {

        if (!Session::has('admin_id')) {
            $this->redirect('login/index');
        }

        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();

       
      
        
        
        // 排除权限
        $not_check = ['admin/Index/adminindex','admin/Index/home','admin/Index/deal_sql','admin/Public/tips', 'admin/AuthGroup/getjson', 'admin/System/clear', 'admin/System/ajax_mail_test', 'admin/System/doUploadPic', 'admin/Upload/upimage', 'admin/Upload/upfile', 'admin/Upload/umeditor_upimage', 'admin/Upload/layedit_upimage'];

        if (!in_array($module . '/' . $controller . '/' . $action, $not_check)) {
            $auth     = new Auth();
            $admin_id = Session::get('admin_id');
          
            if (!$auth->check($module . '/' . $controller . '/' . $action, $admin_id) && $admin_id != 1) {
            	//return json(array('code' => 0, 'msg' => '没有权限'));
            	$this->error('没有权限');
            }
        }
        if(strtolower($controller)!='log'){

        	
        	
        	
        	$data['uid']=session('admin_id');
        	$data['add_time']=time();
        	$data['controller']=$module . '/' . $controller . '/' . $action;
        	$data['username']=session('admin_name');
        	Db::name('log')->insert($data);
        }
        if(in_array(strtolower($action), array('add','edit'))){
        	$token=md5(rand().time());
        	Session::set('datatoken',$token);
        	 
        	$this->assign('token',$token);
        	 
        }else{
        	$this->assign('token',0);
        }
        if(in_array(strtolower($action), array('save','update'))){
        
            
        	$token=Session::get('datatoken');
            if($token==0&&$token!=request()->param('token')){
        		$this->error('非法操作');
        	}
        
        
        }
        
        
        
        
    }


  
    /**
     * 获取侧边栏菜单
     */
    protected function getMenu()
    {
        $menu     = [];
        $admin_id = Session::get('admin_id');
        $auth     = new Auth();

        $auth_rule_list = Db::name('auth_rule')->where('status', 1)->order(['sort' => 'DESC', 'id' => 'ASC'])->select();

        foreach ($auth_rule_list as $value) {
            if ($auth->check($value['name'], $admin_id) || $admin_id == 1) {
            	if($value['pid']!=0||$value['id']==104){
            		$value['href']=url($value['name']);
            	}
            	
            	
                $menu[] = $value;
                
                
            }
        }
        $addons        = new AddonsModel();
        $AdminList=$addons->getAdminList();
        
       if(!empty($AdminList)){
       	foreach($AdminList as $key=> $vo){
       	
       		$url='';
       		$url=url($vo['url']);
       		$adminliststr[$key]['href']=$url;
       		$adminliststr[$key]['title']=	$vo['title'];
       		$adminliststr[$key]['pid']=	104;
       		$adminliststr[$key]['id']='104'.$key;
       		$menu[] =$adminliststr[$key];
       	}
       }
       
        
       
        
        $menu = !empty($menu) ? array2tree($menu) : [];

        if(!empty($menu)){
        	
        }
        $this->assign('menu',  json_encode($menu));
      // return  json_encode($menu);
      //  return $menu;
        
        
    }
}