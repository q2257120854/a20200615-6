<?php

namespace app\comhome\controller;



use think\Controller;

use think\Db;

use think\Request;

use think\Session;

use think\View;



class Cases extends Controller

{

	public function index(){

		$list = Db::table("ims_sudu8_page_com_cases")->order("num desc,id desc")->paginate(20);

		$this->assign("lists",$list);
		$this->assign("page",3);
		$this->assign("list",$list->toArray()['data']);
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
		return $this->fetch("index");

	}

}