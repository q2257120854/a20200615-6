<?php
namespace app\home\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;


class Showart extends Controller
{
    
    public function index(){

		$newsid = input("newsid");

		$sbase = "";
		$sbase =  Db::table('ims_sudu8_page_system_base')->find();  
		$this->assign('sbase',$sbase);

		if($newsid){

			$news = Db::table('ims_sudu8_page_system_news')->where("id",$newsid)->find();  
			if($news){

				$news['creattime'] = date("Y-m-d",$news['creattime']);	

				$data['hits'] = $news['hits']+1;
				Db::table('ims_sudu8_page_system_news')->where("id",$newsid)->update($data);  
			}



		}else{
			$this->error("没有找到对应的资讯！");
		}
		
		$newnews = Db::table('ims_sudu8_page_system_news')->limit(5)->select();  
		
		$this->assign('news',$news);
		$this->assign('newnews',$newnews);

        return $this->fetch('index');

    }


}
