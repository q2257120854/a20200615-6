<?php
namespace Houtai\Controller;
use Think\Controller;
class AdminController extends YnController {
    public function index(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
       $this->display("index");
    }
	
	
	public function add(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$mod = M("admin")->where("id=1")->find();
		$this->assign("mod",$mod);
		$this->display("add");
	}
	
	
	public function update() {
	$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$_POST["pass"]=md5(sha1($_POST["pass"]));
		parent::update();
	}
	
}