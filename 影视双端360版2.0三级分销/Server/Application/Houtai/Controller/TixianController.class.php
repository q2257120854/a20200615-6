<?php
namespace Houtai\Controller;
use Think\Controller;
class TixianController extends YnController {
   
    public function index(){	
$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);	
		$mod = M('tixian');
	    $page = new \Think\Page($mod->count(),15);
	    $this->assign("mod",$mod->order("addtime DESC")->limit($page->firstRow,$page->listRows)->select());
		$this->assign("pageinfo",$page->show());
        $this->display("index");
    }
	
	 public function zhifu(){	
$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);	 
		$mod = M('pay');
	    $page = new \Think\Page($mod->count(),15);
	    $this->assign("mod",$mod->order("time DESC")->limit($page->firstRow,$page->listRows)->select());
		$this->assign("pageinfo",$page->show());
        $this->display("zhifu");
    }
	public function fanxian(){	
$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);	
		$mod = M('fanxian');
	    $page = new \Think\Page($mod->count(),15);
	    $this->assign("mod",$mod->order("addtime DESC")->limit($page->firstRow,$page->listRows)->select());
		$this->assign("pageinfo",$page->show());
        $this->display("fanxian");
    }
	public function del(){
		
		$id = $_GET['id'];
		$mod = M("tixian")->delete($id);
      
		if($mod>0){
           die("y");
        }else{
            die("n");
        }

	}
	
	public function shenhe(){
        $id = $_GET['id'];
		$where = array();
		$where['id'] = array('in',$id);
		$data['status'] = '2';
		$mod =  M('tixian')->where($where)->save($data);		
		if($mod>0){
           die("y");
        }else{
            die("n");
        }
		
	}
	
}