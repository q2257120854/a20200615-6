<?php
namespace Houtai\Controller;
use Think\Controller;
class TanController extends YnController {
    public function index(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$mod = M('tan')->find();
		$this -> assign("mod",$mod);
		 	

       $this->display("index");
    }
	
	
	
	
}