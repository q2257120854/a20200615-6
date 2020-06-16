<?php
namespace Admin\Controller;
use Admin\Controller\AdminController;

class IndexController extends AdminController {
    public function index(){
		
		$member = M('member')->where(array('username'=>$_SESSION['uname']))->field('shopname,shoplevel')->find();
		
		$shop_group = M('shop_group')->where(array('level'=>$member['shoplevel']))->find();
		
		$shopname = $shop_group['name'];
		$scsl = $shop_group['goosnum'];		
		
        $this -> assign(shopname,$shopname);
        $this -> assign(scsl,$scsl);
        $this -> assign(title,'控制台');
        $this -> display();
    }
}
