<?php
namespace Houtai\Controller;
use Think\Controller;
class UserController extends YnController {
    public function index(){		
	$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$user = M('user')->where("status=1");
	    $page = new \Think\Page($user->count(),15);
	    $this->assign("user",$user->where("status=1")->order("addtime DESC")->limit($page->firstRow,$page->listRows)->select());
		$this->assign("pageinfo",$page->show());
        $this->display("index");
    }
	public function daili(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$user = M('user')->where("status=2");
	    $page = new \Think\Page($user->count(),15);
	    $this->assign("user",$user->where("status=2")->order("addtime DESC")->limit($page->firstRow,$page->listRows)->select());
		$this->assign("pageinfo",$page->show());
        $this->display("daili");
		
	}
	
	public function insert(){
		$config = M('config')->where("id=1")->find();
		$shi=$config['time'];
		$pass = md5(sha1($_POST['pass']));
		$_POST['mim'] = $_POST['pass'];
		$_POST['password'] =   $pass;
		$_POST['viptime'] = time()+$shi*60;
		$_POST['addtime'] = time();
		$_POST['logintime'] = time();
		$_POST['share'] = substr(base_convert(md5(uniqid(md5(microtime(true)),true)), 16, 10), 0, 6);
		parent::insert();
	}
	
	public function update(){
		$pass = md5(sha1($_POST['pass']));
		$_POST['mim'] = $_POST['pass'];
		$_POST['password'] =   $pass;
		
		parent::update();
	}
	
	public function edit(){
		$config =M("config")->where("id=1")->find()['webname'];
		$this->assign("config",$config);
		$id = $_GET['id'];
		$user =M("user")->where("id = {$id}")->find();
		$this->assign("mod",$user);
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
				for ($i=0;$i<$fen;$i++){
				 $str='ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
				 $randStr = str_shuffle($str);
				 $rands= md5(time().$randStr);
				 $ka = substr($rands,0,6);
                    $insert['uid']      =   1;
                    $insert['dianka']   =   $ka;
                    $insert['ctime']    =   time();
                    $insert['time']     =   $time;
                    $insert['type']     =   $type;
                    $insert['name']     =   $name;
					M('kami')->data($insert)->add();
				  }
			$this -> success("添加成功！","{$_SERVER['HTTP_REFERER']}",'0');
		
	}
	
	public function ctime(){
		
		$last = $_GET['pass']*60*60*24;

        $id = $_GET['id'];
		$where = array();
		$where['id'] = array('in',$id);
		$mod =  M('user')->where($where)->setInc('viptime',$last);		
		if($mod>0){
           die("y");
        }else{
            die("n");
        }
		
	}
	
	public function money(){
		
		$last = $_GET['pass'];

        $id = $_GET['id'];
		$where = array();
		$where['id'] = array('in',$id);
		$mod =  M('user')->where($where)->setInc('price',$last);		
		if($mod>0){
           die("y");
        }else{
            die("n");
        }
		
	}
	
	public function del1(){
		
		$id = $_GET['id'];
		$mod = M("user")->delete($id);
      
		if($mod>0){
           die("y");
        }else{
            die("n");
        }
	}
	
	public function sea(){
		$uname =$_POST['uname'];
		$user = M("user")->where("username like '%$uname%'")->select();
		$this->assign("user",$user);
		$this->display("sea");
		
	}
	public function shengji(){
        $id = $_GET['id'];
		$data['status'] = '2';
		$mod =  M('user')->where("id={$id}")->save($data);		
		if($mod>0){
           die("y");
        }else{
            die("n");
        }
		
	}
	
}