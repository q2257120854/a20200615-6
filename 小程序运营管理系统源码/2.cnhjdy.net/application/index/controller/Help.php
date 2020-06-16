<?php


namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;

class Help extends Base
{
    public function index(){
        if(check_login()) {
            if(powerget())
            {
                $var_5360=input('appletid');
                $var_5361=Db::table('applet')->where('id',$var_5360)->find();
                if(!$var_5361)
                {
                    $this->error('找不到对应的小程序！');
                }
                $this->assign('applet',$var_5361);
            }
            else
            {
                $var_5363=Session::get('usergroup');
                if($var_5363==1)
                {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
                }
                if($var_5363==2)
                {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
                }
                if($var_5363==3)
                {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
                }
            }
            return $this->fetch(index);
        }else
        {
            $this->redirect('Login/index');
        }

    }

}