<?php
namespace Houtai\Controller;
use Think\Controller;
class NoticeController extends YnController {
    public function index(){
		$mod = M('notice')->order("id ASC")-> select();
		$this -> assign("mod",$mod);
		 	
	$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
       $this->display("index");
    }
	
	public function zb(){
		$mod = M('notice')->where("type=1")->order("id ASC")-> select();
		$this -> assign("mod",$mod);
		 	
	$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
       $this->display("zb");
    }
	public function edit(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$id = $_GET['id'];
		$mod =M("notice")->where("id={$id}")->find();
		$this->assign("mod",$mod);
		$this->display("edit");
	}
	
	
	
		public function insert() {
			$_POST['addtime'] = time();        
		parent::insert();
	}
	
	
	 public function add() {
	$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$this->display("add");
	}
	
}