<?php
namespace Houtai\Controller;
use Think\Controller;
class ConfigController extends YnController {
    public function index(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
       $this->display("index");
    }
	 public function moban() {
		 $config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$mod = M('config') -> find();
		 $this -> assign("mod",$mod);
		$this->display("moban");
	}
	public function type() {
		 $config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$mod = M('config') -> find();
		 $this -> assign("mod",$mod);
		$this->display("type");
	}
	 public function add() {
		 $config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$mod = M('config') -> find();
		 $this -> assign("mod",$mod);
		$this->display("add");
	}
	public function fdd() {
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$mod = M('config') -> find();
		 $this -> assign("mod",$mod);
		$this->display("fdd");
	}
	public function price() {
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$mod = M('config') -> find();
		 $this -> assign("mod",$mod);
		$this->display("price");
	}
	public function zhifu() {
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$mod = M('config') -> find();
		 $this -> assign("mod",$mod);
		$this->display("zhifu");
	}
}