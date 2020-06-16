<?php
namespace Houtai\Controller;
use Think\Controller;
class JiageController extends YnController {
    public function index(){
		$mod =M("jiage")->where("id=1")->find();
		$this->assign("mod",$mod);
		 	
$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
       $this->display("index");
    }
	public function edit(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$id = $_GET['id'];
		$mod =M("jiage")->where("id=1")->find();
		$this->assign("mod",$mod);
		$this->display("edit");
	}
	
	
	
	public function kami(){
		$type=$_POST['type'];
		$fen=$_POST['fen'];
		 switch ($type)
            {
                case 0.75;
                    $time  =   7*60*60*24;
                    $name   =   '七天';
                    break;
                case 1.5;
                    $time  =   30*60*60*24;
                    $name   =   '一个月';
                    break;
                case 4.5;
                    $time  =   90*60*60*24;
                    $name   =   '三个月';
                    break;
                case 9;
                    $time  =   180*60*60*24;
                    $name   =   '六个月';
                    break;
               case 18;
                    $time  =   365*60*60*24;
                    $name   =   '一年';
                    break;
                case 150;
                    $type   =   1;
                    $time   =   0;
                    $name   =   '永久';
                    break;
            }
                
                
                    $insert['ctime']     =   $time;
                    $insert['name']     =   $name;
					$insert['title']     =   $_POST['title'];
					$insert['link']     =   $_POST['link'];
					$insert['price']     =   $_POST['price'];
					$insert['sort']     =   $_POST['sort'];
					M('jiage')->data($insert)->add();
				 
			$this -> success("添加成功！","{$_SERVER['HTTP_REFERER']}",'0');
		
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
			$model = D("jifen");
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
		$upload->maxSize = 5120000 ;// 设置附件上传大小
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