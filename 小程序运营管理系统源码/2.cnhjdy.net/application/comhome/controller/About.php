<?php
namespace app\comhome\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;

class About extends Controller
{

	public function index(){
		
		$info = Db::table("ims_sudu8_page_com_about")->find();
		$staff = Db::table("ims_sudu8_page_com_staff")->where("flag",1)->order("num desc,id desc")->select();
		if($info){
			$letlonarr = explode(",", $info['letlon']);		
			$info['letlon'] = $letlonarr[0]."|".$letlonarr[1];
			$info['letloncen'] = $letlonarr[0].",".$letlonarr[1];
		}
		$sbase =  Db::table('ims_sudu8_page_com_about')->find();  
		$sbase['banner'] = unserialize($sbase['banner']);
		$sbase['bannernum'] = 0;
		if($sbase['banner']['banner1'] != ""){
			$sbase['bannernum'] += 1;
		}
		if($sbase['banner']['banner2'] != ""){
			$sbase['bannernum'] += 1;
		}
		if($sbase['banner']['banner3'] != ""){
			$sbase['bannernum'] += 1;
		}
		$this->assign('sbase',$sbase);
		$this->assign("page",5);
		$this->assign("info",$info);
		$this->assign("list",$staff);
		return $this->fetch("index");

	}
}