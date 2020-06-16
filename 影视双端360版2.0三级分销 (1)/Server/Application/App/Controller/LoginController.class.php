<?php
namespace App\Controller;
use Think\Controller;
class LoginController extends Controller {
  
	  public function index(){
		  
			$id = $_SESSION['user']['id'];
			$kami = M('kami')->where("uid={$id} and y=0");
			$page = new \Think\Page($kami->count(),20);
			$this->assign("kami",$kami->where("y=0 and uid={$id}")->order("ctime DESC")->limit($page->firstRow,$page->listRows)->select());
			$this->assign("pageinfo",$page->show());
		   $this -> display("index");
	  }
	public function login(){
	
		$this->display("login");
	}
	
	
	
	public function jilu(){
		$id = $_SESSION['user']['id'];
		$kami = M('kami')->where("uid={$id} and y=1");;
	    $page = new \Think\Page($kami->count(),20);
	    $this->assign("kami",$kami->where("y=1 and uid={$id}")->order("ctime DESC")->limit($page->firstRow,$page->listRows)->select());
		$this->assign("pageinfo",$page->show());
        $this->display("jilu");
		
	}
	public function del(){
		
		$id = $_GET['id'];
		
	
		
		$mod = M("kami")->delete($id);
      
		if($mod>0){
           die("y");
        }else{
            die("n");
        }
		
		
	}
	
	
	public function txt(){
		$id = $_SESSION['user']['id'];
		$kami = M('kami')->where("y=0 and uid={$id}")->order("id ASC")->select();
		 Header( "Content-type:   application/octet-stream ");
        Header( "Accept-Ranges:   bytes ");
        header( "Content-Disposition:   attachment;   filename=".date('Y-m-d H:i:s').".txt ");
        header( "Expires:   0 ");
        header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 ");
        header( "Pragma:   public ");
		
		 foreach ($kami as $value)
        { 
			
            echo $value['name'];
            echo '----';
            echo $value['dianka'];
            echo "\r\n";
        }
       
	}
	
		public function daotxt(){
		$type = $_POST['type'];
		$id = $_SESSION['user']['id'];
		$kami = M('kami')->where("y=0 and name='{$type}' and uid={$id}")->order("id ASC")->select();
		 Header( "Content-type:   application/octet-stream ");
        Header( "Accept-Ranges:   bytes ");
        header( "Content-Disposition:   attachment;   filename=".date('Y-m-d H:i:s').".txt ");
        header( "Expires:   0 ");
        header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 ");
        header( "Pragma:   public ");
		
		 foreach ($kami as $value)
        { 
			
            echo $value['name'];
            echo '----';
            echo $value['dianka'];
            echo "\r\n";
        }
       
	}
	
	  public function add(){
		 
			$con = M("config")->where("id=1")->find();
			
			
		
		   $this->assign("con",$con);
		   $this -> display("add");
	  }
	
	public function kami(){
		
		$type=$_POST['type'];
		$fen=$_POST['fen'];
		$id = $_SESSION['user']['id'];
		$con = M("config")->where("id=1")->find();
		 switch ($type)
            {
                case $con['dailiqi'];
                    $time  =   7*60*60*24;
                    $name   =   '七天';
                    break;
                case $con['dailiyi'];
                    $time  =   30*60*60*24;
                    $name   =   '一个月';
                    break;
                case $con['dailisan'];
                    $time  =   90*60*60*24;
                    $name   =   '三个月';
                    break;
                case $con['daililiu'];
                    $time  =   180*60*60*24;
                    $name   =   '六个月';
                    break;
               case $con['dailinian'];
                    $time  =   365*60*60*24;
                    $name   =   '一年';
                    break;
               
            }
			
				$price  =   M('user')->where("id={$id}")->find()['money'];
				$user  =   M('user')->where("id={$id}")->find()['name'];
                if($price<$fen*$type)
                {
                    echo json_encode(['code'=>1,'dian'=>'余额不足，请充值！'], JSON_UNESCAPED_UNICODE);
                    exit();
                }else{
					$d = $price - $fen*$type;
				  M('user')->where("id={$id}")->save(['money'=>$d]);
				  $dian   =   '';
					for ($i=0;$i<$fen;$i++){
					 $str='ABCDEFGHIJKLMNOPQRSTUVWXYZ';  
					 $randStr = str_shuffle($str);
					 $rands= md5(time().$randStr);
					 $ka = substr($rands,0,8);
                    $insert['uid']      =   $id;
                    $insert['dianka']   =   $ka;
                    $insert['ctime']    =   time();
                    $insert['time']     =   $time;
                    $insert['type']     =   $type;
                    $insert['name']     =   $name;
					 $insert['sbh']     =   $user;
					M('kami')->data($insert)->add();
					$dian.=   $ka."<br><hr>";
				  }
				  
				echo json_encode(['code'=>1,'dian'=>$dian], JSON_UNESCAPED_UNICODE);
			
				}
	}
	
	
	
	
	public function checkLogin(){
	$admin = M("user")->where("username='{$_POST['name']}' and status = 2")->find();
	if(empty($admin)){
		$this->assign("errorinfo","登录账号不存在，或您不是代理，或已被禁用！");
		$this->display("login");
		exit();
		}
		//判断密码md5(sha1($data['passwd']))
		if($admin['password']==md5(sha1($_POST['pass']))){
            //此处表示登录成功
            $_SESSION['user']=$admin; //将登录成功的信息放入到session中
            $this->redirect("Index/index");
        }else{
            $this->assign("errorinfo","登录密码错误！");
            $this->display("login");
            exit();
        }
    }
	//执行退出
	public function loginOut(){
		unset($_SESSION['user']);
		$this->redirect("Login/login");
	}

	
	public function news(){
		$mod = M("news")->order("addtime DESC")->select();
		$this->assign("mod",$mod);
       $this->display("news");
		
	}
	public function shownews(){
		$id=$_GET['id'];
		$mod = M("news")->where("id={$id}")->find();
		$this->assign("mod",$mod);

       $this->display("shownews");
    }
	
	public function xtxt()
    {
        $data   =   $_GET['content'];
        Header( "Content-type:   application/octet-stream ");
        Header( "Accept-Ranges:   bytes ");
        header( "Content-Disposition:   attachment;   filename=".date('Y-m-d H:i:s').".txt ");
        header( "Expires:   0 ");
        header( "Cache-Control:   must-revalidate,   post-check=0,   pre-check=0 ");
        header( "Pragma:   public ");
        echo str_replace('<br><hr>',"\r\n",$data);
    }

	public function xexcel()
    {
        $data   =    $_GET['content'];
        header( "Content-Type: application/vnd.ms-excel; name='excel'" );
        header( "Content-type: application/octet-stream" );
        header( "Content-Disposition: attachment; filename=".date('Y-m-d H:i:s').".xls" );
        header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
        header( "Pragma: no-cache" );
        header( "Expires: 0" );
        echo str_replace('<br><hr>',"\r\n",$data);
    }
	
	
	public function excel()
    {
       $kami = M('kami')->where("y=0")->order("id ASC")->select();
        header( "Content-Type: application/vnd.ms-excel; name='excel'" );
        header( "Content-type: application/octet-stream" );
        header( "Content-Disposition: attachment; filename=".date('Y-m-d H:i:s').".xls" );
        header( "Cache-Control: must-revalidate, post-check=0, pre-check=0" );
        header( "Pragma: no-cache" );
        header( "Expires: 0" );
        // $list   =   db('dianka')->where($where)->paginate(20);
        echo "<table>";

        foreach ($kami as $value)
        {
            echo "<tr>";
            echo "<td>";
            echo $value['dianka'];
            echo "</td>";
            echo "<td>";
            echo $value['name'];
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }	
}