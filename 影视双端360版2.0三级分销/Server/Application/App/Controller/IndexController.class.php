<?php
namespace App\Controller;

use Think\Controller;
class IndexController extends Controller
{
    public function home()
    {
        $config = M("config")->where("id=1")->find();
        $this->assign("config", $config);
        $this->display("home");
    }
    public function config(){
        $data = M('config')->where("id=1")->find();
        $arr1 = M("jiage")->where("id = 1")->find();
        $arr['jx1'] = $data['jiexi1'];
        $arr['jx2'] = $data['jiexi2'];
        $arr['jx3'] = $data['jiexi3'];
        $arr['jx4'] = $data['jiexi4'];
        $arr['jx5'] = $data['jiexi5'];
        $arr['kefu'] = $data['kefu'];
        $arr['day'] = $arr1['day'];
        $arr['month'] = $arr1['month'];
        $arr['quarter'] = $arr1['quarter'];
        $arr['half'] = $arr1['half'];
        $arr['year'] = $arr1['year'];
        $arr['yongjiu'] = $arr1['yongjiu'];
        $arr['daili'] = $arr1['daili'];
        if ($data) {
            //return json(['code' => '1','msg'=>$arr]);
            echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode($arr, JSON_UNESCAPED_UNICODE);
        }
    }
    public function index()
    {
        if (!empty($_SESSION['user']) || !empty($_SESSION['adminuser'])) {
            $uid = $_SESSION['user']['id'];
            $user = M("user")->where("id={$uid}")->find();
            $config = M("config")->where("id=1")->find();
            $this->assign("user", $user);
            $this->assign("config", $config);
            $this->display("index");
        } else {
            $this->redirect("Login/login");
            exit;
        }
    }
    public function veify()
    {
        $data = M('user')->where('username="' . $_POST['name'] . '" and password ="' . md5(sha1($_POST['pass'])) . '" and status =2')->find();
        if ($data) {
            $_SESSION['user'] = $data;
            echo json_encode(['code' => '1'], JSON_UNESCAPED_UNICODE);
        } else {
            echo json_encode(['code' => '0'], JSON_UNESCAPED_UNICODE);
        }
    }
    public function pay()
    {
        header("Content-type: application/json; charset=utf-8");
        $pay = M('pay');
        $str = $_POST['outtrade'];
        $str1 = substr($str, 14);
        $insert['outtrade'] = $_POST['outtrade'];
        $insert['trade'] = $_POST['trade'];
        $insert['type'] = $_POST['type'];
        $insert['money'] = $_POST['money'];
        $insert['trade_status'] = $_POST['trade_status'];
        $insert['name'] = $_POST['name'];
        $insert['time'] = time();
        $insert['cid'] = $str1;
        $pay->create($insert);
        if ($_POST['trade_status'] != 'TRADE_SUCCESS') {
            echo json_encode(['code' => '0', 'msg' => '支付未完成'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $ztai = M('pay')->where("trade={$_POST['trade']}")->find()['trade'];
        if ($ztai == $_POST['trade']) {
            echo json_encode(['code' => '0', 'msg' => '请勿重复刷新,支付已成功请返回重新登录即可获得会员！'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        $pay->add();
        //加时间
        $jia = M("jiage")->where("id=1")->find();
        if ($_POST['money'] == $jia['daili']) {
        } else {
            echo json_encode(['code' => '0', 'msg' => '订单支付金额有误，请联系客服处理'], JSON_UNESCAPED_UNICODE);
            exit;
        }
        M('user')->where("id={$str1}")->save(['status' => '2']);
        ///M('user')->where("id={$str1}")->save(['viptime'=>$k['viptime']+$time]);
        $mess = M("mess");
        $data0['title'] = '系统消息:代理开通成功！';
        $data0['shijian'] = date("Y-m-d H:i:s ", time());
        $data0['addtime'] = time();
        $data0['uid'] = $str1;
        $mess->add($data0);
        $user = M("user")->where("id={$str1}")->find()['pid'];
        $userd = M("user")->where("id={$user}")->find();
        //一级
        $userd2 = M("user")->where("id={$userd['pid']}")->find();
        //二级
        $userd3 = M("user")->where("id={$userd2['pid']}")->find();
        //三级
        $con = M("config")->where("id=1")->find();
        if (!empty($userd)) {
            $a = $_POST['money'];
            $c = (float) $con['yi'] / 100;
            $d = $a * $c;
            M('user')->where("id={$user}")->setInc('money', $d);
            $user2 = M("user")->where("id={$user}")->find()['pid'];
            $User1 = M("fanxian");
            $data['title'] = $_POST['name'];
            $data['price'] = $d;
            $data['addtime'] = time();
            $data['uid'] = $user;
            $data['shijian'] = date("Y-m-d H:i", time());
            $data['type'] = '一级返现';
            $User1->add($data);
        }
        if (!empty($userd2)) {
            $a = $_POST['money'];
            $c = (float) $con['er'] / 100;
            $d = $a * $c;
            M('user')->where("id={$user2}")->setInc('money', $d);
            $user3 = M("user")->where("id={$user2}")->find()['pid'];
            $User1 = M("fanxian");
            $data['title'] = $_POST['name'];
            $data['price'] = $d;
            $data['addtime'] = time();
            $data['uid'] = $user2;
            $data['shijian'] = date("Y-m-d H:i", time());
            $data['type'] = '二级返现';
            $User1->add($data);
        }
        if (!empty($userd3)) {
            $a = $_POST['money'];
            $c = (float) $con['san'] / 100;
            $d = $a * $c;
            M('user')->where("id={$user3}")->setInc('money', $d);
            $User1 = M("fanxian");
            $data['title'] = $_POST['name'];
            $data['price'] = $d;
            $data['addtime'] = time();
            $data['uid'] = $user3;
            $data['shijian'] = date("Y-m-d H:i", time());
            $data['type'] = '三级返现';
            $User1->add($data);
        }
        echo json_encode(['code' => '1', 'msg' => '开通成功'], JSON_UNESCAPED_UNICODE);
    }
    public function jilu()
    {
        $mod = M('jilu');
        $insert['uid'] = $_GET['uid'];
        $insert['title'] = $_GET['title'];
        $insert['url'] = $_GET['url'];
        $insert['img'] = $_GET['img'];
        $insert['time'] = time();
        $mod->create($insert);
        $mod->add();
    }
	public function deljilu(){
		if($_GET['uid']){
			$uid=$_GET['uid'];
			M('jilu')->where("uid={$uid}")->delete();
		}
	}
    public function yaoqing(){
        $id = $_GET['id'];
        $uid = $_GET['uid'];
        $sharema = $id;
        $id_isnull = M("user")->where("share={$sharema}")->getField('id');
        if ($id_isnull == null) {
            echo json_encode(['code' => 1, 'msg' => '┌(。Д。)┐上级不存在！' . $sharema . $id_isnull], JSON_UNESCAPED_UNICODE);
            exit;
        }
        if ($id != $uid) {
            $user = M("user")->where("id={$uid}")->find()['pid'];
            $uname = M("user")->where("id={$uid}")->find()['name'];
            //66
            if ($user == 0) {
                $data = M('user')->where("id={$uid}")->save(['pid' => $id]);
                $cha = M("user")->where("id={$id}")->find()['pid'];
                //66
                if ($cha != 0) {
                    $cha1 = M("user")->where("id={$cha}")->find()['pid'];
                    //72
                    if ($cha1 != 0) {
                        $san = M("user_rel");
                        $data1['uid'] = $uid;
                        $data1['pid'] = $cha1;
                        $data1['lv'] = '3';
                        $data1['uname'] = $uname;
                        $data1['addtime'] = time();
                        $san->add($data1);
                        $yi = M("user_rel");
                        $data2['uid'] = $uid;
                        $data2['pid'] = $cha;
                        $data2['lv'] = '2';
                        $data2['uname'] = $uname;
                        $data2['addtime'] = time();
                        $yi->add($data2);
                        $er = M("user_rel");
                        $data3['uid'] = $uid;
                        $data3['pid'] = $id;
                        $data3['uname'] = $uname;
                        $data3['lv'] = '1';
                        $data3['addtime'] = time();
                        $er->add($data3);
                    } else {
                        $yi = M("user_rel");
                        $data4['uid'] = $uid;
                        $data4['pid'] = $cha;
                        $data4['lv'] = '2';
                        $data9['uname'] = $uname;
                        $data4['addtime'] = time();
                        $yi->add($data4);
                        $er = M("user_rel");
                        $data5['uid'] = $uid;
                        $data5['pid'] = $id;
                        $data5['uname'] = $uname;
                        $data5['lv'] = '1';
                        $data5['addtime'] = time();
                        $er->add($data5);
                    }
                } else {
                    $yi = M("user_rel");
                    $data9['uid'] = $uid;
                    $data9['pid'] = $id;
                    $data9['uname'] = $uname;
                    $data9['lv'] = '1';
                    $data9['addtime'] = time();
                    $yi->add($data9);
                }
                if ($data) {
                    echo json_encode(['code' => 0], JSON_UNESCAPED_UNICODE);
                } else {
                    echo json_encode(['code' => 1, 'msg' => '已经绑定过了！'], JSON_UNESCAPED_UNICODE);
                }
            } else {
                echo json_encode(['code' => 1, 'msg' => '已经绑定过了！'], JSON_UNESCAPED_UNICODE);
            }
        } else {
            echo json_encode(['code' => 1, 'msg' => '不能绑定自己！'], JSON_UNESCAPED_UNICODE);
        }
    }
}