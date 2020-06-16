<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Wxreview extends Base
{
    public function index(){
        if(check_login()){
        	if(powerget()){
        		$id = input("appletid");
        		$res = Db::table('applet')->where("id",$id)->find();
                if(!$res){
                    $this->error("找不到对应的小程序！");
                }
        		$this->assign('applet',$res);
                /*旧版本获取登录二维码*/
//                $url = "http://122.114.217.68:8008/?type=get&op=login&appid=".$res['appID'];
//                $xcxewm = $this->_requestGetcurl($url);
//                $this->assign("xcxewm",$xcxewm);
                /*新版本获取二维码*/
                $commitData = [
                    'siteroot' => "https://".$_SERVER['HTTP_HOST']."/api/Wxapps/",//'https://duli.nttrip.cn/api/Wxapps/',
                    'appid' => $res['appID'],
                    'site_name' => $res['name'],
                    'uniacid' => $id,
                    'version' => '2.05',//当前小程序的版本
                ];

                $params = http_build_query($commitData);
                $url = "http://wx.hdewm.com/uploadApi.php?".$params;

                $response = $this->_requestGetcurl($url);


                $result = json_decode($response,true);
//
//                var_dump($result);
//                var_dump($url);
//                exit();
                if(isset($result['data']) && $result['data'] != ""){
                    $this->assign("code_uuid",$result['code_uuid']);
                    $this->assign("code_token",$result['data']['code_token']);
                }
                $this->assign("appid",$res['appID']);
                $this->assign("projectname",$res['name']);
                $this->assign("id",$id);
                $this->assign("url",$url);
        	}else{
        		$usergroup = Session::get('usergroup');
        		if($usergroup==1){
        			$this->error("您没有权限操作该小程序或找不到相应小程序！",'Applet/applet');
        		}
        		if($usergroup==2){
        			$this->error("您没有权限操作该小程序或找不到相应小程序！",'Applet/index');
        		}
                if($usergroup==3){
                    $this->error("您没有权限操作该小程序或找不到相应小程序！",'Applet/index');
                }
        	}
            return $this->fetch('index');
        }else{
            $this->redirect('Login/index');
        }
    }
    public function checkscan(){
        $token = input("token");
        $last = input("last");
        $url = "http://wx.hdewm.com/uploadApi.php?do=checkscan&code_token=".$token."&last=".$last;
        $response = $this->_requestGetcurl($url);
        echo $response;
    }
    public function checklogin(){
        $uniacid = input("uniacid");
        $appid = input('appid');
        $name = input('name');
        if(strpos(ROOT_HOST,'https')===false){
            $host = "https".substr(ROOT_HOST,4);
        }
        $url = "http://122.114.217.68:8008/?type=get&op=open&appid=".$appid."&projectname=".$name."&url=".$host."/api/Wxapps/&uniacid=".$uniacid;
        $result = json_decode($this->_requestGetcurl($url),true);
        if(isset($result['status']) && (int)$result['status'] == 1){
            return 1;
        }else{
            return 0;
        }
    }
    public function wxxcxinfo(){
        $uniacid = input("appletid");
        $status = input("status");
        $token = input("token");
        $scan_token = input("scan_token");
        $code_uuid = input("code_uuid");
        $this->assign("code_uuid",$code_uuid);
        $this->assign("scan_token",$scan_token);
        $res = Db::table('applet')->where("id",$uniacid)->find();
        if(!$res){ 
            $this->error("找不到对应的小程序！");
            exit;
        }
        
        if($status){
            $this->assign('applet',$res);
            return $this->fetch("wxxcxinfo");
        }else{
            $this->error("登录有误，需重新登录",$this->redirect('Wxreview/index'));
        }
    }
    public function yulan(){
        $uniacid = input("uniacid");
        $res = Db::table('applet')->where("id",$uniacid)->find();
        if(!$res){ 
            $this->error("找不到对应的小程序！");
            exit;
        }
        $url = "http://122.114.217.68:8008/?type=get&op=preview&appid=".$res['appID'];
        $result = $this->_requestGetcurl($url);
        if(strpos($result,'错误 需要重新登录')===true){
            return 1;
        }else if($result){
            return "data:image/jpeg;base64,".$result;
        }
    }
    public function upload(){
        $uniacid = input("uniacid");
        $desc = input("desc");
        $version = input("version");
        $res = Db::table('applet')->where("id",$uniacid)->find();
        $url = "http://122.114.217.68:8008/?type=get&op=upload&appid=".$res['appID']."&version=".$version."&desc=".$desc;
        $result = json_decode($this->_requestGetcurl($url),true);
        if(isset($result['error']) &&  $result['error']== "错误 需要重新登录"){
            return 1;
        }else if($result){
            return 2;
        }
    }
    /*
     * 新版本预览
     * */
    public function preview(){
        $token = input('token');
        $uuid = input("uuid");
        $url = "http://wx.hdewm.com/uploadApi.php?do=preview&code_token=".$token."&code_uuid=".$uuid;
        $response = $this->_requestGetcurl($url);
        echo $response;
    }
    /*新版本的代码提交*/
    public function commitcode(){
        $token = input("token");
        $uuid = input("uuid");
        $version = input("version");
        $desc = input('desc');
        $data = [
            'user_version' => $version,'user_desc' => $desc,'code_token' => $token,'code_uuid' => $uuid
        ];
        $params = http_build_query($data);
        $url = "http://wx.hdewm.com/uploadApi.php?do=commitcode&".$params;
        $response = json_decode($this->_requestGetcurl($url));
        // var_dump($response);
        // var_dump(1);
        // exit;
        return $response;
    }
        
    public function _requestGetcurl($url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        curl_close($curl);
        return $data;
    }
}