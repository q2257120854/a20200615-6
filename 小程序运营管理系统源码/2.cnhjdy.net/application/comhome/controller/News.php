<?php

namespace app\comhome\controller;



use think\Controller;

use think\Db;

use think\Request;

use think\Session;

use think\View;



class News extends Controller

{

	public function index(){

		$list = Db::table("ims_sudu8_page_com_news")->where("type",1)->where("flag",1)->order("num desc,id desc")->paginate(10);
		$this->assign("lists",$list);
		$this->assign("page",2);
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

		$info = Db::table("ims_sudu8_page_com_news")->where("id",$id)->find();
		
		$list = Db::table("ims_sudu8_page_com_news")->where("id",'neq',$id)->where("type",1)->limit(3)->select();
		$pre = 	Db::table("ims_sudu8_page_com_news")->where("id",'<',$id)->where("type",1)->order("id desc")->find();
		$next = Db::table("ims_sudu8_page_com_news")->where("id",'>',$id)->where("type",1)->order("id asc")->find();
		$this->assign("pre",$pre);
		$this->assign("next",$next);
		$this->assign("page",2);
		$this->assign("info",$info);
		$this->assign("list",$list);
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
		return $this->fetch("show");

	}
	public function gg(){

		$list = Db::table("ims_sudu8_page_com_news")->where("type",2)->where("flag",1)->order("num desc,id desc")->paginate(10);
		$this->assign("page",2);
		$this->assign("lists",$list);

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
		return $this->fetch("gg");

	}

	public function showgg(){
		$id = input("id");
		$info = Db::table("ims_sudu8_page_com_news")->where("id",$id)->find();
		$list = Db::table("ims_sudu8_page_com_news")->where("id",'neq',$id)->where("type",2)->limit(3)->select();
		$pre = 	Db::table("ims_sudu8_page_com_news")->where("id",'<',$id)->where("type",2)->order("id desc")->find();
		$next = Db::table("ims_sudu8_page_com_news")->where("id",'>',$id)->where("type",2)->order("id asc")->find();
		$this->assign("pre",$pre);
		$this->assign("next",$next);
		$this->assign("list",$list);
		$this->assign("info",$info);
		$this->assign("page",2);
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
		return $this->fetch("showgg");

	}
	public function update(){

		$list = Db::table("ims_sudu8_page_com_news")->where("type",3)->where("flag",1)->order("num desc,id desc")->paginate(20);

		$this->assign("lists",$list);
		$this->assign("page",2);
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
		return $this->fetch("update");

	}

	public function addHits(){
		$id = input("id");
		$is = Db::table("ims_sudu8_page_com_news")->where("id",$id)->field("hits")->find();
		$hits = $is['hits'] + 1;
		$res = Db::table("ims_sudu8_page_com_news")->where("id",$id)->update(array("hits" => $hits));
		if($res){
			return 1;
		}
	}

}