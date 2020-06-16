<?php
//学生信息控制类
namespace Houtai\Controller;
use Think\Controller;
class PublicController extends Controller {	
	public function login(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$this->display("login");
	}
	//获取登录信息
	public function checkLogin(){
	$admin = M("Admin")->where("name='{$_POST['name']}'")->find();
	if(empty($admin)){
		$this->assign("errorinfo","登录账号不存在，或已被禁用！");
		$this->display("login");
		exit();
		}
		//判断密码md5(sha1($data['passwd']))
		if($admin['pass']==md5(sha1($_POST['pass']))){
            //此处表示登录成功
            $_SESSION['adminuser']=$admin; //将登录成功的信息放入到session中
            $this->redirect("Index/index");
        }else{
            $this->assign("errorinfo","登录密码错误！");
            $this->display("login");
            exit();
        }
    }
	
	
	//执行退出
	public function loginOut(){
		unset($_SESSION['adminuser']);
		unset($_SESSION['auth_temp']);
		
		$this->redirect("Public/login");
	}

}