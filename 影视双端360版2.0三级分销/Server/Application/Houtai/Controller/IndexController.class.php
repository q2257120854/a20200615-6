<?php
namespace Houtai\Controller;
use Think\Controller;
class IndexController extends YnController {
	
    public function index(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$jin  = M('user')->where('logintime >'. strtotime(date('Y-m-d')))->count();
		$hui  = M("user")->count();
		$dai  = M("user")->where('addtime >'. strtotime(date('Y-m-d')))->count();
		$fcount	=	M('kami')->where('yid>1')->count('distinct(yid)');
		
		$an  = M("user")->where("type='安卓'")->count();
		
		$ping  = M("user")->where("type='苹果'")->count();
		$pay  = M('pay')->where('time >'. strtotime(date('Y-m-d')))->count();
		$mian = $hui-$fcount;
		$this->assign("pay",$pay);
		$this->assign("ping",$ping);
		$this->assign("an",$an);
		$this->assign("mian",$mian);
		$this->assign("fcount",$fcount);
		$this->assign("dai",$dai);
		$this->assign("hui",$hui);
		$this->assign("jin",$jin);
        $this->display("index");
    }
	 public function home(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$jin  = M('user')->where('logintime >'. strtotime(date('Y-m-d')))->count();
		$hui  = M("user")->count();
		$dai  = M("user")->where('addtime >'. strtotime(date('Y-m-d')))->count();
		$fcount	=	M('kami')->where('yid>1')->count('distinct(yid)');
		
		$an  = M("user")->where("type='安卓'")->count();
		
		$ping  = M("user")->where("type='苹果'")->count();
		$pay  = M('pay')->where('time >'. strtotime(date('Y-m-d')))->count();
		$mian = $hui-$fcount;
		$this->assign("pay",$pay);
		$this->assign("ping",$ping);
		$this->assign("an",$an);
		$this->assign("mian",$mian);
		$this->assign("fcount",$fcount);
		$this->assign("dai",$dai);
		$this->assign("hui",$hui);
		$this->assign("jin",$jin);
        $this->display("home");
    }
}