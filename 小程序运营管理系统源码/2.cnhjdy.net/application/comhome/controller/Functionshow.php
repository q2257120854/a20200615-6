<?php

namespace app\comhome\controller;



use think\Controller;

use think\Db;

use think\Request;

use think\Session;

use think\View;



class Functionshow extends Controller

{

	public function index(){

		$list = Db::table("ims_sudu8_page_com_func")->order("num desc,id desc")->paginate(20);

		$this->assign("lists",$list);
		$this->assign("page",1);
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

	public function show(){

		$id = input("id");

		$info = Db::table("ims_sudu8_page_com_func")->where("id",$id)->find();

		if($info){
			if($info['funcimg']){
				$info['funcimg'] = unserialize($info['funcimg']);
			}
			if($info['place']){
				$info['place'] = explode(",", $info['place']);
			}
			if($info['func']){
				$info['func'] = explode(",", $info['func']);
			}
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
		$this->assign("info",$info);
		$this->assign("page",1);
		return $this->fetch("show");

	}
	public function addHits(){
		$id = input("id");
		$is = Db::table("ims_sudu8_page_com_func")->where("id",$id)->field("hits")->find();
		$hits = $is['hits'] + 1;
		$res = Db::table("ims_sudu8_page_com_func")->where("id",$id)->update(array("hits" => $hits));
		if($res){
			return 1;
		}
	}
}