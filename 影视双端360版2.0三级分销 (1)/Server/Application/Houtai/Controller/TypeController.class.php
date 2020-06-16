<?php
namespace Houtai\Controller;
use Think\Controller;
class TypeController extends YnController {
    public function index(){
			$mod = M('type')->order("id ASC") -> select();
		 $this -> assign("mod",$mod);
		 	
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
       $this->display("index");
    }
	
	public function insert() {
		if(!empty($_FILES)) {
			//如果有文件上传 上传附件
			 $this->_upload();
			//$this->forward();
		}
        
		parent::insert();
	}
	
	public function edit(){
		$id=$_GET['id'];
		$mod = M('type')->where("id={$id}")->find();
		$this->assign("mod",$mod);
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
	   $this->display("edit");
	}
	 public function add() {
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$this->display("add");
	}
	
	
		//执行修改
    public function update() {
		if(!empty($_FILES) && $_FILES["uploadpic"]["error"]==0){
			//如果有文件上传 上传附件
			 $this->_upload();
			//$this->forward();
			//删除原图
			$model = D("Adver");
		    $id = $_REQUEST ["id"];
			$ob = $model->find($id);
			if(!empty($ob)){
				@unlink('./Public/uploads/'.$ob['picname']);
				//@unlink('./Public/uploads/links/s_'.$ob['logo']);
			}
		}
		parent::update();
	}
	
	
	
	
	
	
	// 文件上传
    protected function _upload()
    {	
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize = 2120000 ;// 设置附件上传大小
        $upload->exts = array('jpg', 'gif','png','jpeg','pjpeg');// 设置附件上传类型 
        $upload->rootPath = './Public/uploads/'; // 设置附件上传目录    
        $upload->autoSub = false; // 设置不创建子目录
		
		$info = $upload->upload();
		if(!$info) {
			$this->error($upload->getError());
        }else {
            //取得成功上传的文件信息
            $uploadList = array_values($info);
			$picname = $uploadList[0]['savename'];
			
			// $image = new \Think\Image();
			// $image->open('./Public/uploads/gl/'.$picname);
			// //按照原图的比例生成一个最大为150*150的缩略图并保存
			// //$image->thumb(150, 150)->save('./Public/uploads/links/s_'.$picname);
			// //$image->thumb(500, 500)->save('./Public/uploads/links/'.$picname);
			// //$image->thumb(220, 220)->save('./Public/uploads/links/m_'.$picname);
			// $image->thumb(1200, 130)->save('./Public/uploads/gl/'.$picname);
			$url = 'http://'.$_SERVER['SERVER_NAME'].'/'.'Public/uploads/'; 
			$_POST['picname']  = $url.$picname;
		}
	}
}