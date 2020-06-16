<?php
namespace Index\Controller;

use Think\Controller;
class IndexController extends Controller
{
    public function index(){
        $config = M("config")->where("id=1")->find();
        $this->assign("config", $config);
        if(strpos($_SERVER['HTTP_USER_AGENT'],'Mobile')!==false){
           $this->display("m");
        }else{
            $this->display("index");
        }
    }
    public function qudao(){
        $config = M("config")->where("id=1")->find();
      	$config['share'] =  $_GET['share'];
        $this->assign("config", $config);
        $this->display("qudao");
    }
  
  public function register(){
     	$uuid = null;
        $data1 = M('user')->where("username ='{$_GET['name']}'")->find();
        if (!$data1) {
          if ($_GET['share'] == null or $_GET['share'] == '') {
            $config = M('config')->where("id=1")->find();
            $shi = $config['time'];
            $mod = M('user');
            $insert['username'] = $_GET['name'];
            $insert['password'] = md5(sha1($_GET['password']));
            $insert['mim'] = $_GET['password'];
            $insert['uuid'] = $uuid;
            $insert['addtime'] = time();
            $insert['logintime'] = time();
            $insert['viptime'] = time() + $shi * 60;
            $insert['share'] = substr(base_convert(md5(uniqid(md5(microtime(true)), true)), 16, 10), 0, 6);
            $mod->create($insert);
            $result = $mod->add();
          } else {
            $data3 = M('user')->where("share ='{$_GET['share']}'")->find();
            if (!$data3) {
              echo json_encode(['code' => '0', 'tips' => '邀请链接不存在，请直接下载后注册~:)'], JSON_UNESCAPED_UNICODE);
              exit;
            }
            $config = M('config')->where("id=1")->find();
            $shi = $config['time'];
            $mod = M('user');
            $insert['username'] = $_GET['name'];
            $insert['password'] = md5(sha1($_GET['password']));
            $insert['mim'] = $_GET['password'];
            $insert['uuid'] = $uuid;
            $insert['addtime'] = time();
            $insert['logintime'] = time();
            $insert['pid'] = $data3['id'];
            $insert['viptime'] = time() + $shi * 60;
            $insert['share'] = substr(base_convert(md5(uniqid(md5(microtime(true)), true)), 16, 10), 0, 6);
            $mod->create($insert);
            $result = $mod->add();
            $er = M("user_rel");
            $data5['uid'] = $result;
            $data5['pid'] = $data3['id'];
            $data5['uname'] = $data3['username'];
            $data5['lv'] = '1';
            $data5['addtime'] = time();
            $data0['shijian'] = date("Y-m-d H:i:s ", time());
            $er->add($data5);
          }if($result){
            $data = M('user')->where("uuid='{$uuid}'")->find();
            $arr['name'] = $data['username'];
            $arr['pass'] = $data['password'];
            $arr['mim'] = $data['mim'];
            $arr['viptime'] = $data['viptime'];
            $arr['id'] = $data['id'];
            $arr['num'] = $data['num'];
            $arr['money'] = $data['money'];
            $arr['jifen'] = $data['jifen'];
            $arr['share'] = $data['share'];
            $arr['kefu'] = $config['kefu'];
            $a = M('user')->where("uuid='{$uuid}'")->setInc('count', 1);
            $b = M('user')->where("uuid='{$uuid}'")->save(['logintime' => time()]);
            echo json_encode(['code' => '1', 'tips' => '注册成功~'], JSON_UNESCAPED_UNICODE);
          }
        }else{
            echo json_encode(['code' => '0', 'tips' => '用户名已被注册，请重新输入~'], JSON_UNESCAPED_UNICODE);
            exit;
        }

  }
 
}