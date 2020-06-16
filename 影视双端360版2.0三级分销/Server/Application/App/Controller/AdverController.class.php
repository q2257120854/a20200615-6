<?php
namespace App\Controller;
use Think\Controller;
class AdverController extends Controller {
  
	 public function add(){
		 
		$uid = $_SESSION['user']['id'];
		$mod = M('user')->where("id={$uid}")->find();
		$this->assign("mod",$mod);
	   $this->display("add");
		 
	 }
	 
	  public function cz(){
		 
		$uid = $_GET['id'];
		$mod = M('user')->where("id={$uid}")->find();
		$this->assign("mod",$mod);
	   $this->display("cz");
		 
	 }
	  public function update2(){
		  $uid = $_SESSION['user']['id'];
		  $mod = M('user')->where("id={$uid}")->find();
		  $money = $_POST['money'];
		  if($money>$mod['money']){
			  $this -> error("对不起，您的余额不足，不足以充值！","{$_SERVER['HTTP_REFERER']}",'0');
		  }else{
			  $id= $_POST['id'];
			  $oldshare = $mod['money'];
					M('user')->where("id={$uid}")->save(['money'=> $oldshare-$money]);
			  $mod =  M('user')->where("id={$id}")->setInc('money',$money);	
			  $this -> success("充值成功！","{$_SERVER['HTTP_REFERER']}",'0');
		  }
		 $this->display("cz");  
	  }
	 public function update1(){
		$uid = $_SESSION['user']['id'];
		$mod = M('user')->where("id={$uid}")->find();
		$this->assign("mod",$mod);
		$time=$_POST['time'];
		if($time>=21){ 
				
				$this -> error("对不起，时间输入错误！","{$_SERVER['HTTP_REFERER']}",'0');
				exit;
			} 
		$str=$_POST['share']; 
			if(strlen($str)<6){ 
				
				$this -> error("对不起，您的邀请码小于六位！","{$_SERVER['HTTP_REFERER']}",'0');
				exit;
			} 
		// $data3 = M("user")->where("share={$_POST['share']}")->find();
		// if($data3){
			// $this -> error("邀请码重复！","{$_SERVER['HTTP_REFERER']}",'0');
			// exit;
		// }
		$pass = md5(sha1($_POST['pass']));
		$User = M("User"); // 实例化User对象
		$User->mim = $_POST['pass'];
		$User->password = $pass;
		$User->share = $_POST['share'];
		$User->kefu = $_POST['kefu'];
		$User->time = $_POST['time'];
		$User->url1 = $_POST['url1'];
		$User->url2 = $_POST['url2'];
		$User->url3 = $_POST['url3'];
		$User->url4 = $_POST['url4'];
		$User->url5 = $_POST['url5'];
		$User->url6 = $_POST['url6'];
		$data = $User->where("id={$uid}")->save(); 
		if($data){
			$this -> success("修改成功！","{$_SERVER['HTTP_REFERER']}",'0');
		}else{
			
			$this -> error("修改失败！","{$_SERVER['HTTP_REFERER']}",'0');
		}
		
	   $this->display("add");
		 
	 }
	 public function update(){
		$id = $_POST['id']; 
		 $pass = md5(sha1($_POST['pass']));
		 $User = M("User"); // 实例化User对象
		// 要修改的数据对象属性赋值
		
		$User->mim = $_POST['pass'];
		$User->password = $pass;
		$User->jifen = $_POST['jifen'];
		$User->money = $_POST['money'];
		$User->status = $_POST['status'];
		$data = $User->where("id={$id}")->save(); 
		if($data){
			$this -> success("修改成功！","{$_SERVER['HTTP_REFERER']}",'0');
		}else{
			
			$this -> error("修改失败！","{$_SERVER['HTTP_REFERER']}",'0');
		}
	 }
	 
	
	 
		
		

	 
	 public function edit(){
		$id=$_GET['id'];
		$mod = M('user')->where("id={$id}")->find();
		$this->assign("mod",$mod);
		
	   $this->display("edit");
	}
	
	
	public function user(){
		$uid = $_SESSION['user']['id'];
		$user = M('user')->where("status=1 and pid={$uid}");
	    $page = new \Think\Page($user->count(),20);
	    $this->assign("user",$user->where("status=1 and pid={$uid}")->order("addtime DESC")->limit($page->firstRow,$page->listRows)->select());
		$this->assign("pageinfo",$page->show());
		
		 $this->display("user");
	}
	
	public function daili(){
		$uid = $_SESSION['user']['id'];
		 $user = M('user')->where("status=2 and pid={$uid}");
	     $page = new \Think\Page($user->count(),20);
	     $this->assign("user",$user->where("status=2 and pid={$uid}")->order("addtime DESC")->limit($page->firstRow,$page->listRows)->select());
		 $this->assign("pageinfo",$page->show());
		
		 $this->display("daili");
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
	public function cyue(){
		$uid = $_SESSION['user']['id'];
		$last = $_GET['pass'];
		$data = M('user')->where("id={$uid}")->find();
		if($last>$data['money']){
				die("n");
				exit;
			}else{
				$oldshare = $data['money'];
					M('user')->where("id={$uid}")->save(['money'=> $oldshare-$last]);
				 $id = $_GET['id'];
					$where = array();
					$where['id'] = array('in',$id);
					$mod =  M('user')->where($where)->setInc('moeny',$last);		
					if($mod>0){
					   die("y");
					}else{
						die("n");
					}
			}
       
		
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