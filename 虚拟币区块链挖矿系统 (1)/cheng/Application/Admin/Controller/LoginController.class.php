<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
	//echo md5('admin');die;
        $this -> display();
    }
    
    //处理用户登录
    public function checkLogin(){
    	$login['uname'] = I('username');
    	$login['shopstatus'] = 1;
    	$login['password'] = I('userpwd','','md5');
    	$login['_logic'] = "AND";
    	$m = M('member');
    	$user = $m -> where($login) -> field('uid,uname') -> find();
		
    	if ($user) {
    		$_SESSION['uid'] = $user['uid'];
            $_SESSION['uname'] = $user['uname'];
    		$this->redirect('Admin/Index/index');
    	}else{
    		$this->error("账号或密码错误，或者没有开通商户权限",U('Admin/Index/index'));
    	}
    }

    //处理用户登出
    public function loginOut(){
        unset($_SESSION['uid']);
        unset($_SESSION['uname']);
        $this->redirect('Admin/Login/index');
    }
}
