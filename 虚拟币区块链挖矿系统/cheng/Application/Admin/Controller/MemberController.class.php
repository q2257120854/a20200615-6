<?php
namespace Admin\Controller;
use Think\Controller;
class MemberController extends Controller {
    public function index(){
        $user = M("member");                                        
        $num = $user ->field('count(*) count') -> find();
        $total = $num["count"];
        $page = new \Think\Page($total,20);
        $limit = $page ->firstRow.','.$page->listRows;
        $data = $user->limit($limit)->select(); 
        $this -> assign("title","用户管理");
        $this -> assign("page",$page->show());               
        $this -> assign("user",$data);
        $this -> display();
    }

    //删除
    public function del(){
    	$uid = $_GET["uid"];
    	$del = M("member");
    	if($del-> delete($uid)){
            echo 1;
            return;
        }
        echo 0;
    }

    //搜索时调用此方法
    public function search(){
        $user = M("member");
        $uname = $_GET['uname'];     	
        $map['uname'] = array("like","%$uname%"); 
        $num = $user -> where($map) -> field('count(*) count') -> find();
        $total = $num["count"];
        $page = new \Think\Page($total,10);
        $limit = $page ->firstRow.','.$page->listRows;
        $data = $user -> where($map) ->limit($limit) -> select();               
        $this -> assign("page",$page->show());
        $this -> assign("user",$data);
        $this -> assign("title","搜索用户名");
        $this -> display('index');
    }

    //修改时调用此方法
    public function mod(){
        $user = M("member");
        $data = $user ->where(array("uid"=>$_GET['uid']))->find(); 
        $this -> assign("title",'查看会员信息');
        $this -> assign("data",$data);
        $this -> display();
    }
    //添加用户
    public function insert(){
        $this -> assign("title",'添加用户');
        $this -> display();
    }
    public function add(){
         $user = M("member");
        $uname = $_POST['uname'];
        $_POST['regtime'] = time();
        $_POST['password'] = md5($_POST['password']);
        $email = $_POST['email'];
        $resemail = $user -> where(array('email'=>$email)) -> field('email') -> find();
        if($resemail){
        	$this -> error('邮箱已存在');
        }
        $res = $user -> where(array("uname"=>$uname)) -> field("uname") -> find();
        if($res){
            $this -> error("用户名已存在");
        }else{
            if($user->create()){
            $res = $user -> add();
            if($res){
                $this -> success("添加成功","index");
            }else{
                $this -> error("添加失败");
            }
        } 
    } 
    }
}