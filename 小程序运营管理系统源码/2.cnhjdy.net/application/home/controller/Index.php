<?php

namespace app\home\controller;

use think\Controller;

use think\Db;

use think\Request;

use think\Session;

use think\View;





class Index extends Controller

{

    

    public function index(){



		$sbase = "";

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

		//功能介绍
		$func = Db::table('ims_sudu8_page_com_func')->limit(12)->order("num desc,id desc")->select();  

		//小程序产品动态
		$news1 = Db::table('ims_sudu8_page_com_news')->where("type",1)->limit(3)->order("num desc,id desc")->select();  

		if($news1){

			foreach ($news1 as &$res) {

				$res['createtime'] = date("Y-m-d",$res['createtime']);

			}

		}



		// 小程序公司公告



		$news2 = Db::table('ims_sudu8_page_com_news')->where("type",2)->limit(3)->order("num desc,id desc")->select();  

		if($news2){

			foreach ($news2 as &$res) {

				$res['createtime'] = date("Y-m-d",$res['createtime']);

			}

		}


		// 小程序更新版本



		$news3 = Db::table('ims_sudu8_page_com_news')->where("type",3)->limit(3)->order("num desc,id desc")->select();  

		if($news3){

			foreach ($news3 as &$res) {

				$res['createtime'] = date("m-d",$res['createtime']);

			}

		}








		$this->assign('func',$func);
		$this->assign('news1',$news1);

		$this->assign('news2',$news2);

		$this->assign('news3',$news3);

		$this->assign('sbase',$sbase);



        return $this->fetch('index');



    }





}