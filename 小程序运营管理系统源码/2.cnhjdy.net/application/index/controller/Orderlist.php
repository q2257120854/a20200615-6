<?php

namespace app\index\controller;

use think\Controller;

use think\Db;

use think\Request;

use think\Session;

use think\View;

class Orderlist extends Base
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

                if(input('order')){

                    $order = Db::table('ims_sudu8_page_order')->where("uniacid",$id)->where("is_more",0)->where("order_id",'like','%'.input("order").'%')->order('creattime desc')->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"),'order'=>input("order"))]);

                    $count = Db::table('ims_sudu8_page_order')->where("uniacid",$id)->where("is_more",0)->where("order_id",'like','%'.input("order").'%')->order('creattime desc')->count();

                }else{

                    $order = Db::table('ims_sudu8_page_order')->where("uniacid",$id)->where("is_more",0)->order('creattime desc')->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"))]);

                    $count = Db::table('ims_sudu8_page_order')->where("uniacid",$id)->where("is_more",0)->order('creattime desc')->count();

                }

                $neworder = $order->toArray();

                foreach($neworder['data'] as &$row){

                    if($row['custime']){

                        $row['custime']=date("Y-m-d H:i:s",$row['custime']);

                    }else{

                        $row['custime']="";

                    }

                    $row['thumb'] =  remote($id,$row['thumb'],1);

                    if($row['hxinfo'] == ""){

                       $row['hxinfo2']="暂无核销信息";

                    }else{

                        $row['hxinfo'] = unserialize($row['hxinfo']);

                         if($row['hxinfo'][0]==1){

                             $row['hxinfo2']="系统核销";

                         }else{

                            $store=Db::table('ims_sudu8_page_store')->where("id",$row['hxinfo'][1])->where("uniacid",$id)->find();

                            $staff=Db::table('ims_sudu8_page_staff')->where("id",$row['hxinfo'][2])->where("uniacid",$id)->find();

                            $row['hxinfo2']="门店：".$store['title']."</br>员工：".$staff['realname'];

                         }

                    }

                    //获取联系方式
                    if($row['address']){
                       $row['addressinfo'] =  Db::table('ims_sudu8_page_duo_products_address') ->where('id', $row['address']) ->field('name, mobile, address, more_address') ->find();
                    }else{
                        $row['addressinfo'] = '';
                    }

                    $row['creattime']=date("Y-m-d H:i:s",$row['creattime']);

                    $user = Db::table('ims_sudu8_page_user')->where("uniacid",$row['uniacid'])->where("id",$row['uid'])->find();

                    if($user['nickname']){

                        $row['nickname'] = $user['nickname'];

                    }else{

                        $row['nickname'] = "";

                    }

                    if($user['mobile']){

                        $row['mobile'] = $user['mobile'];

                    }else{

                        $row['mobile'] = "";

                    }

                    if($row['is_more']==0){

                        $row['beizhu'] = "姓名：".$row['pro_user_name'].",电话：".$row['pro_user_tel']."地址：".$row['pro_user_add'].",备注：".$row['pro_user_txt'];

                    }

                    //查询优惠劵
                    

                    $row['order_duo'] = unserialize($row['order_duo']);

                    $row['yhInfo_msg'] = array();
                    if(!empty($row['yhinfo'])){
                        $yhInfo = unserialize($row['yhinfo']);
                        $row['yhInfo_msg']['yhInfo_yunfei'] = $yhInfo['yunfei'];
                        $row['yhInfo_msg']['yhInfo_score'] = $yhInfo['score'];
                        $row['yhInfo_msg']['yhInfo_yhq'] = $yhInfo['yhq'];
                        $row['yhInfo_msg']['yhInfo_mj'] = $yhInfo['mj'];
                    }else{
                        $row['yhInfo_msg']['yhInfo_yunfei'] = 0;
                        if($row['dkscore'] > 0){
                            // $jfgz = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
                            $jfgz = Db::table('ims_sudu8_page_rechargeconf') ->where('uniacid', $id) ->find();
                            $row['yhInfo_msg']['yhInfo_score']['msg'] = $row['dkscore']."抵扣".floatval($row['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['score']);
                            $row['yhInfo_msg']['yhInfo_score']['money'] = floatval($row['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['score']);
                        }else{
                            $row['yhInfo_msg']['yhInfo_score']['msg'] = "未使用积分";
                            $row['yhInfo_msg']['yhInfo_score']['money'] = 0;
                        }
                        if($row['coupon']){
                            //查询优惠劵
                            // $arr[$k]['couponinfo'] = pdo_fetch("SELECT b.title,b.price FROM ".tablename('sudu8_page_coupon_user')." as a LEFT JOIN  ".tablename('sudu8_page_coupon')." as b on a.cid = b.id WHERE a.uniacid = :uniacid and a.flag = 1 and a.id=:coupon",array(":uniacid"=>$uniacid,":coupon"=>$res['coupon']));
                            $coupon = Db::table('ims_sudu8_page_coupon_user') ->alias('a') ->join('ims_sudu8_page_coupon b', 'a.cid = b.id', 'left') ->where('a.uniacid', $id) ->where('a.flag', 1) ->field('b.title,b.price') ->find(); 
                            $row['yhInfo_msg']['yhInfo_yhq']['msg'] = $coupon['title'];
                            $row['yhInfo_msg']['yhInfo_yhq']['money'] = $coupon['price'];
                        }else{
                            $row['yhInfo_msg']['yhInfo_yhq']['msg'] = "未使用优惠券";
                            $row['yhInfo_msg']['yhInfo_yhq']['money'] = 0;
                        }
                        $row['yhInfo_msg']['yhInfo_mj']['msg'] = "";
                        $row['yhInfo_msg']['yhInfo_mj']['money'] = 0;
                    }

                    if(!$row['custime']){
                        $row['custime'] = "未消费";
                    }

                   

                }

                $this->assign('neworder',$neworder);

                // dump($neworder);die;

                $this->assign('order',$order);

                $this->assign('counts',$count);

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

    public function yuyue(){

        if(check_login()){

            if(powerget()){



                $id = input("appletid");

                $res = Db::table('applet')->where("id",$id)->find();

                if(!$res){

                    $this->error("找不到对应的小程序！");

                }

                $this->assign('applet',$res);

                // $pros = Db::table("ims_sudu8_page_products")->where("uniacid",$id)->where("type","showPro")->select();





                if(input('order')){

                    $order = Db::table('ims_sudu8_page_order')->where("uniacid",$id)->where("is_more",1)->where("order_id",'like','%'.input("order").'%')->order('creattime desc')->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"),'order'=>input("order"))]);

                    $count = Db::table('ims_sudu8_page_order')->where("uniacid",$id)->where("is_more",1)->where("order_id",'like','%'.input("order").'%')->order('creattime desc')->count();

                }else{

                    $order = Db::table('ims_sudu8_page_order')->where("uniacid",$id)->where("is_more",1)->order('creattime desc')->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"))]);

                    $count = Db::table('ims_sudu8_page_order')->where("uniacid",$id)->where("is_more",1)->order('creattime desc')->count();

                }

                $neworder = $order->toArray();

                foreach($neworder['data'] as &$row){

                    if($row['custime']){

                        $row['custime']=date("Y-m-d H:i:s",$row['custime']);

                    }else{

                        $row['custime']="";

                    }

                    $row['creattime']=date("Y-m-d H:i:s",$row['creattime']);

                    $user = Db::table('ims_sudu8_page_user')->where("uniacid",$row['uniacid'])->where("id",$row['uid'])->find();

                    if($user['nickname']){

                        $row['nickname'] = $user['nickname'];

                    }else{

                        $row['nickname'] = "";

                    }

                    if($user['mobile']){

                        $row['mobile'] = $user['mobile'];

                    }else{

                        $row['mobile'] = "";

                    }

                    if($row['is_more']==0){

                        $row['beizhu'] = "姓名：".$row['pro_user_name'].",电话：".$row['pro_user_tel']."地址：".$row['pro_user_add'].",备注：".$row['pro_user_txt'];

                    }

                    $row['order_duo'] = unserialize($row['order_duo']);

                    if($row['hxinfo'] == ""){

                       $row['hxinfo2']="暂无核销信息";

                    }else{

                        $row['hxinfo'] = unserialize($row['hxinfo']);

                         if($row['hxinfo'][0]==1){

                             $row['hxinfo2']="系统核销";

                         }else{

                            $store=Db::table('ims_sudu8_page_store')->where("id",$row['hxinfo'][1])->where("uniacid",$id)->find();

                            $staff=Db::table('ims_sudu8_page_staff')->where("id",$row['hxinfo'][2])->where("uniacid",$id)->find();

                            $row['hxinfo2']="门店：".$store['title']."</br>员工：".$staff['realname'];

                         }

                    }

                }

                $this->assign('neworder',$neworder);



                $this->assign('order',$order);

                $this->assign('counts',$count);

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

            return $this->fetch('yuyue');

        }else{

            $this->redirect('Login/index');

        }

    }

    public function video(){

        if(check_login()){

            if(powerget()){

                $id = input("appletid");

                $res = Db::table('applet')->where("id",$id)->find();

                if(!$res){

                    $this->error("找不到对应的小程序！");

                }

                $this->assign('applet',$res);

                if(input('order')){

                    $order = Db::table('ims_sudu8_page_video_pay')->alias("a")->join('ims_sudu8_page_products b','a.pid = b.id')->join("ims_sudu8_page_user c","a.openid = c.openid")->where("a.uniacid",$id)->where("c.uniacid",$id)->where("a.orderid",'like',"%".input('order')."%")->order('a.creattime desc')->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"))]);

                    $count = Db::table('ims_sudu8_page_video_pay')->alias("a")->join('ims_sudu8_page_products b','a.pid = b.id')->join("ims_sudu8_page_user c","a.openid = c.openid")->where("a.uniacid",$id)->where("c.uniacid",$id)->where("a.orderid",'like',"%".input('order')."%")->count();

                }else{

                   $order = Db::table('ims_sudu8_page_video_pay')->alias("a")->join('ims_sudu8_page_products b','a.pid = b.id')->join("ims_sudu8_page_user c","a.openid = c.openid")->where("a.uniacid",$id)->where("c.uniacid",$id)->order('a.creattime desc')->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"))]);

                    $count = Db::table('ims_sudu8_page_video_pay')->alias("a")->join('ims_sudu8_page_products b','a.pid = b.id')->join("ims_sudu8_page_user c","a.openid = c.openid")->where("a.uniacid",$id)->where("c.uniacid",$id)->count(); 

                }

                $this->assign('order',$order);

                $this->assign('counts',$count);

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

            return $this->fetch('video');

        }else{

            $this->redirect('Login/index');

        }

    }

    public function hexiao(){

        $order = input("order");

        $data['custime'] = time();

        $data['flag'] = 2;

        $res = Db::table('ims_sudu8_page_order')->where('order_id', $order)->update($data);

        if($res){

            $this->success("核销成功！");

        }

    }

    //发货  核销  取消订单
    public function order(){
        if(check_login()){

            if(powerget()){

                $appletid = input("appletid");
                $res = Db::table('applet')->where("id",$appletid)->find();
                if(!$res){
                    $this->error("找不到对应的小程序！");
                }
                $this->assign('applet',$res);

                $order = input('orderid');
                $op = input('op');
                if($op == 'hx'){

                    $data['custime'] = time();
                    $data['flag'] = 2;
                    $res = Db::table('ims_sudu8_page_order')->where('id', $order)->update($data);
                    if($res){
                        $this->success("核销成功！");
                    }
                }

                if($op== 'fahuo'){
                    $data['custime'] = time();
                    $data['kuaidi'] = input('kuaidi');
                    $data['kuaidihao'] = input('kuaidihao');
                    $data['flag'] = 4;
                    $res = Db::table('ims_sudu8_page_order')->where("id",$order)->update($data);
                    if($res){
                        $this->success("发货成功");
                    }
                    
                }

                //取消订单   confirmtk   取消订单
                if($op == "qx" || $op == "confirmtk"){
                    $order_id = input('orderid');
                    if(input('qxbeizhu')){
                        $data['qxbeizhu'] = input('qxbeizhu');
                    }
                    $now = time();
                    $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
                    $data['th_orderid'] = $out_refund_no;
                    // pdo_update("sudu8_page_order", $data, array("uniacid"=>$uniacid, "id"=>$order_id));
                    Db::table('ims_sudu8_page_order') ->where('uniacid', $appletid) ->where('id', $order_id) ->update($data);
                    // $order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "id"=>$order_id));

                    $order = Db::table('ims_sudu8_page_order') ->where('uniacid', $appletid) ->where('id', $order_id) ->find();
                    // $types = ($op == "confirmtk") ? "dantk" : "danqx";
                    $order_product = Db::table('ims_sudu8_page_products') ->where('id', $order['pid']) ->find();

                    if($order['pay_price'] > 0){
                        $app = Db::table('applet')->where("id",$appletid)->find();
                        $mchid = $app['mchid'];   //商户号
                        $apiKey = $app['signkey'];    //商户的秘钥
                        $appid = $app['appID'];                 //小程序的id
                        $appkey = $app['appSecret'];            //小程序的秘钥
                         // 更新信息
                        $sqtx = Db::table('ims_sudu8_page_order')->where("uniacid",$appletid)->where("id",$order_id)->find();

                        $openid= $sqtx['openid'];    //申请者的openid
                        $outTradeNo = $sqtx['order_id'];
                        $totalFee= $sqtx['pay_price']*100;  //申请了提现多少钱
                        $outRefundNo = $sqtx['order_id']; //商户订单号
                        $refundFee= $sqtx['pay_price']*100;  //申请了提现多少钱
                        $SSLCERT_PATH = ROOT_PATH.'public/Cert/'.$appletid.'/apiclient_cert.pem';//证书路径
                        $SSLKEY_PATH =  ROOT_PATH.'public/Cert/'.$appletid.'/apiclient_key.pem';//证书路径
                        $opUserId = $mchid;//商户号
                        include "WinXinRefund.php";
                        $weixinpay = new WinXinRefund($openid,$outTradeNo,$totalFee,$outRefundNo,$refundFee,$SSLCERT_PATH,$SSLKEY_PATH,$opUserId,$appid,$apiKey);
                        $return = $weixinpay->refund();

                        if(!$return){
                            $this->error('退货失败!请检查系统设置->小程序设置和支付设置');
                        }else{
                            Db::table('ims_sudu8_page_order') ->where('uniacid', $appletid) ->where('th_orderid', $out_refund_no) ->update(['flag' => 5]);
                            
                            //金钱流水
                            $xfmoney = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['pay_price'],
                                "message" => "退款退回微信",
                                "creattime" => time()
                            );
                            // pdo_insert("sudu8_page_money", $xfmoney);
                            Db::table('ims_sudu8_page_money') ->insert($xfmoney);

                            $tk_je = $order['true_price'] - $order['pay_price']; //退回余额
                            if($tk_je > 0){
                                $xfmoney1 = array(
                                    "uniacid" => $appletid,
                                    "orderid" => $order['order_id'],
                                    "uid" => $order['uid'],
                                    "type" => "add",
                                    "score" => $tk_je,
                                    "message" => "退款退回余额",
                                    "creattime" => time()
                                );
                                // pdo_insert("sudu8_page_money", $xfmoney1);
                                Db::table('ims_sudu8_page_money') ->insert($xfmoney1);
                                Db::execute("UPDATE ims_sudu8_page_user set money = money + ".$tk_je." where uniacid = ".$appletid." and id = ".$order['uid']);
                            }

                            if($order['coupon']){
                                // pdo_update("sudu8_page_coupon_user", array("flag"=>0), array("uniacid"=>$uniacid, "uid"=>$order['uid'], "id"=>$order['coupon']));
                                Db::table('ims_sudu8_page_coupon_user') ->where('uniacid', $appletid) ->where('uid', $order['uid']) ->where('id', $order['coupon']) ->update(array('flag' => 0,"utime"=>0));
                            }

                            if($order['dkscore']){
                                // pdo_query("UPDATE ".tablename("sudu8_page_user")." SET score = score + ".$order['dkscore']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                                Db::execute("UPDATE ims_sudu8_page_user set score = score + ".$order['dkscore']." where uniacid = ".$appletid." and id = ".$order['uid']);
                                $score_data = array(
                                    "uniacid" => $appletid,
                                    "orderid" => $order['order_id'],
                                    "uid" => $order['uid'],
                                    "type" => "add",
                                    "score" => $order['dkscore'],
                                    "message" => "退款退回抵扣积分",
                                    "creattime" => time()
                                );
                                // pdo_insert("sudu8_page_score", $score_data);
                                Db::table('ims_sudu8_page_score') ->insert($score_data);
                            }

                            //处理库存与真实销量
                            if($order_product['pro_kc'] == -1){ //无限量库存
                                if($order['num'] > 0){
                                    Db::execute("UPDATE ims_sudu8_page_products set sale_tnum = sale_tnum - ".$order['num']." where uniacid = ".$appletid." and id = ".$order['pid']);
                                }
                            }else{   //有限量库存
                                if($order['num'] > 0){
                                    // pdo_query("UPDATE ".tablename("sudu8_page_products")." SET pro_kc = pro_kc + ".$order['num']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order['pid']));
                                    Db::execute("UPDATE ims_sudu8_page_products set pro_kc = pro_kc - ".$order['num']." where uniacid = ".$appletid." and id = ".$order['pid']);
                                    Db::execute("UPDATE ims_sudu8_page_products set sale_tnum = sale_tnum - ".$order['num']." where uniacid = ".$appletid." and id = ".$order['pid']);
                                }
                            }
                        }

                    }else{
                        // if($op == "confirmtk"){
                        //     // pdo_update("sudu8_page_order", array("flag"=>8), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                        //     Db::table('ims_sudu8_page_order') ->where('uniacid', $appletid) ->where('th_orderid', $out_refund_no) ->update(['flag' => 8]);
                        // }else{
                            // pdo_update("sudu8_page_order", array("flag"=>5), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                            Db::table('ims_sudu8_page_order') ->where('uniacid', $appletid) ->where('th_orderid', $out_refund_no) ->update(['flag' => 5]);
                        // }
                        //金钱流水
                        if($order['true_price'] > 0){
                            $xfmoney = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['true_price'],
                                "message" => "退款退回余额",
                                "creattime" => time()
                            );
                            // pdo_insert("sudu8_page_money", $xfmoney);
                            Db::table('ims_sudu8_page_money') ->insert($xfmoney);
                        }
                        // $order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                        $order = Db::table('ims_sudu8_page_order') ->where('uniacid', $appletid) ->where('th_orderid', $out_refund_no) ->find();

                        // pdo_query("UPDATE ".tablename("sudu8_page_user")." SET money = money + ".$order['true_price']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                        
                        Db::execute("UPDATE ims_sudu8_page_user set money = money + ".$order['true_price']." where uniacid = ".$appletid." and id = ".$order['uid']);

                        if($order['coupon']){
                            // pdo_update("sudu8_page_coupon_user", array("flag"=>0), array("uniacid"=>$uniacid, "uid"=>$order['uid'], "id"=>$order['coupon']));
                            Db::table('ims_sudu8_page_coupon_user') ->where('uniacid', $appletid) ->where('uid', $order['uid']) ->where('id', $order['coupon']) ->update(array('flag' => 0,"utime"=>0));
                        }

                        if($order['dkscore']){
                            // pdo_query("UPDATE ".tablename("sudu8_page_user")." SET score = score + ".$order['dkscore']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                            Db::execute("UPDATE ims_sudu8_page_user set score = score + ".$order['dkscore']." where uniacid = ".$appletid." and id = ".$order['uid']);
                            $score_data = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['dkscore'],
                                "message" => "退款退回抵扣积分",
                                "creattime" => time()
                            );
                            // pdo_insert("sudu8_page_score", $score_data);
                            Db::table('ims_sudu8_page_score') ->insert($score_data);
                        }

                        // $scoreback = pdo_get("sudu8_page_score", array("uniacid"=>$uniacid, "uid"=>$order["uid"], "orderid"=>$order['order_id'], "type"=>"add", "message"=>"买送积分"));
                        $scoreback = Db::table('ims_sudu8_page_score') ->where('uniacid', $appletid) ->where('uid', $order['uid']) ->where('orderid', $order['order_id']) ->where('message', ',买送积分') ->find();
                        if($scoreback){
                            // pdo_query("UPDATE ".tablename("sudu8_page_user")." SET score = score - ".$scoreback['score']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                            Db::execute("UPDATE ims_sudu8_page_user set score = score - ".$scoreback['score']." where uniacid = ".$appletid." and id = ".$order['uid']);
                            $score_data2 = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "del",
                                "score" => $scoreback['score'],
                                "message" => "退款扣除买送积分",
                                "creattime" => time()
                            );
                            // pdo_insert("sudu8_page_score", $score_data2);
                            Db::table('ims_sudu8_page_score') ->insert($score_data2);
                        }

                        //处理库存与真实销量
                        if($order_product['pro_kc'] == -1){ //无限量库存
                            if($order['num'] > 0){
                                Db::execute("UPDATE ims_sudu8_page_products set sale_tnum = sale_tnum - ".$order['num']." where uniacid = ".$appletid." and id = ".$order['pid']);
                            }
                        }else{   //有限量库存
                            if($order['num'] > 0){
                                // pdo_query("UPDATE ".tablename("sudu8_page_products")." SET pro_kc = pro_kc + ".$order['num']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order['pid']));
                                Db::execute("UPDATE ims_sudu8_page_products set pro_kc = pro_kc - ".$order['num']." where uniacid = ".$appletid." and id = ".$order['pid']);
                                Db::execute("UPDATE ims_sudu8_page_products set sale_tnum = sale_tnum - ".$order['num']." where uniacid = ".$appletid." and id = ".$order['pid']);
                            }
                        }

                        

                    }
                    $this ->success('取消成功!');
                }


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
            return $this->fetch('video');
        }else{
            $this->redirect('Login/index');
        }
    }

    

    public function queren(){

        $order = input("order");

        $data['custime'] = time();

        $data['flag'] = 1;

        $res = Db::table('ims_sudu8_page_order')->where('order_id', $order)->update($data);

        if($res){

            $this->success("确认成功！");

        }

    }

    public function orderdown(){

        $id = input("appletid");

        $res = Db::table('applet')->where("id",$id)->find();

        if(!$res){

            $this->error("找不到对应的小程序！");

        }

        $this->assign('applet',$res); 

        $is_more = input("is_more");

        $order = Db::table('ims_sudu8_page_order')->alias("a")->join("ims_sudu8_page_products b","a.pid = b.id")->join("ims_sudu8_page_cate c","b.cid = c.id")->where("a.uniacid",$id)->where("a.is_more",$is_more)->order('a.creattime desc')->field('c.name,a.*')->select();

        foreach($order as &$row){

            if($row['custime']){

                $row['custime']=date("Y-m-d H:i:s",$row['custime']);

            }else{

                $row['custime']="";

            }

            $row['creattime']=date("Y-m-d H:i:s",$row['creattime']);

            $user = Db::table('ims_sudu8_page_user')->where("uniacid",$row['uniacid'])->where("id",$row['uid'])->find();

            if($user['nickname']){

                $row['nickname'] = $user['nickname'];

            }else{

                $row['nickname'] = "";

            }

            if($user['mobile']){

                $row['mobile'] = $user['mobile'];

            }else{

                $row['mobile'] = "";

            }

            if($row['is_more']==0){

                $row['beizhu'] = "姓名：".$row['pro_user_name'].",电话：".$row['pro_user_tel']."地址：".$row['pro_user_add'].",备注：".$row['pro_user_txt'];

            }

            $row['order_duo'] = unserialize($row['order_duo']);

        }

        require_once ROOT_PATH.'public/plugin/PHPExcel/PHPExcel.php';

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator("导出订单列表")

                ->setLastModifiedBy("订单列表")

                ->setTitle("导出订单列表")

                ->setSubject("导出订单列表")

                ->setDescription("导出订单列表")

                ->setKeywords("导出订单列表")

                ->setCategory("导出订单列表");



        $objPHPExcel->getActiveSheet()->setCellValue('A1', '订单号');

        $objPHPExcel->getActiveSheet()->setCellValue('B1', '产品图片');

        $objPHPExcel->getActiveSheet()->setCellValue('C1', '产品名称');

        $objPHPExcel->getActiveSheet()->setCellValue('D1', '产品分类');

        $objPHPExcel->getActiveSheet()->setCellValue('E1', '单价/数量');

        $objPHPExcel->getActiveSheet()->setCellValue('F1', '订单总价');

        $objPHPExcel->getActiveSheet()->setCellValue('G1', '姓名');

        $objPHPExcel->getActiveSheet()->setCellValue('H1', '联系方式');

        $objPHPExcel->getActiveSheet()->setCellValue('I1', '核销时间');

        $objPHPExcel->getActiveSheet()->setCellValue('J1', '状态');

        $objPHPExcel->getActiveSheet()->setCellValue('K1', '下单时间');

        $objPHPExcel->getActiveSheet()->setCellValue('L1', '备注');

        $objPHPExcel->getActiveSheet()->setCellValue('M1', '小程序uniacid');



        foreach($order as $k => $v){

            $num=$k+2;



            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$num, $v['order_id'],'s');

            // // 图片生成

            // $objDrawing[$k] = new \PHPExcel_Worksheet_Drawing();

            // $objDrawing[$k]->setPath(ROOT_PATH.'public/upimages/20180516/355184cf8a623d73a1b04c989b7bbe2c756.png');

            // // 设置宽度高度

            // $objDrawing[$k]->setHeight(80);//照片高度

            // $objDrawing[$k]->setWidth(80); //照片宽度

            // /*设置图片要插入的单元格*/

            // $objDrawing[$k]->setCoordinates('B'.$k);

            // // 图片偏移距离

            // $objDrawing[$k]->setOffsetX(12);

            // $objDrawing[$k]->setOffsetY(12);

            // $objDrawing[$k]->setWorksheet($objPHPExcel->getActiveSheet());



            $objPHPExcel->getActiveSheet()->setCellValue('B'.$num, $v['thumb']);



            if($is_more==0){

                $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, $v['product']);

            }

            if($is_more==1){

                $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, $v['product']."-".$v['order_duo'][0][0]);

            }

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$num, $v['name']);

            if($is_more==0){

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$num, $v['price']."*".$v['num']);

                $objPHPExcel->getActiveSheet()->setCellValue('F'.$num, $v['price']*$v['num']);

            }

            if($is_more==1){

                $objPHPExcel->getActiveSheet()->setCellValue('E'.$num, $v['order_duo'][0][1]."*".$v['order_duo'][0][4]);

                $objPHPExcel->getActiveSheet()->setCellValue('F'.$num, $v['true_price']);

            }

            

            $objPHPExcel->getActiveSheet()->setCellValue('G'.$num, $v['nickname']);

            $objPHPExcel->getActiveSheet()->setCellValue('H'.$num, $v['mobile']);

            $objPHPExcel->getActiveSheet()->setCellValue('I'.$num, $v['custime']);

            if($v['flag']==-2){

                $flag = "无效订单";

            }

            if($v['flag']==-1){

                $flag = "已关闭";

            }

            if($v['flag']==0){

                $flag = "未支付";

            }

            if($v['flag']==1){

                $flag = "立即核销";

            }

            if($v['flag']==2){

                $flag = "已完成";

            }

            if($v['flag']==3){

                $flag = "确认订单";

            }

            $objPHPExcel->getActiveSheet()->setCellValue('J'.$num, $flag);

            $objPHPExcel->getActiveSheet()->setCellValue('K'.$num, $v['creattime']);

            $objPHPExcel->getActiveSheet()->setCellValue('L'.$num, $v['beizhu']);

            $objPHPExcel->getActiveSheet()->setCellValue('M'.$num, $v['uniacid']);

        }

        $objPHPExcel->getActiveSheet()->setTitle('导出订单列表');

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');

        if($is_more==0){

            header('Content-Disposition: attachment;filename="秒杀订单列表.xls"');

        }

        if($is_more==1){

            header('Content-Disposition: attachment;filename="预约预定订单列表.xls"');

        }

        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');

        

    }

    public function videodown(){

        $id = input("appletid");

        $res = Db::table('applet')->where("id",$id)->find();

        if(!$res){

            $this->error("找不到对应的小程序！");

        }

        $this->assign('applet',$res); 

        $is_more = input("is_more");

        $order = Db::table('ims_sudu8_page_video_pay')->alias("a")->join('ims_sudu8_page_products b','a.pid = b.id')->join("ims_sudu8_page_user c","a.openid = c.openid")->join('ims_sudu8_page_cate d','b.cid = d.id')->where("a.uniacid",$id)->where("c.uniacid",$id)->order('a.creattime desc')->field("a.uniacid,a.orderid,a.paymoney,b.title,b.thumb,a.creattime,d.name,c.nickname")->select();

        foreach($order as &$row){

            $row['creattime']=date("Y-m-d H:i:s",$row['creattime']);

        }

        require_once ROOT_PATH.'public/plugin/PHPExcel/PHPExcel.php';

        $objPHPExcel = new \PHPExcel();

        $objPHPExcel->getProperties()->setCreator("导出订单列表")

                ->setLastModifiedBy("订单列表")

                ->setTitle("导出订单列表")

                ->setSubject("导出订单列表")

                ->setDescription("导出订单列表")

                ->setKeywords("导出订单列表")

                ->setCategory("导出订单列表");



        $objPHPExcel->getActiveSheet()->setCellValue('A1', '订单号');

        $objPHPExcel->getActiveSheet()->setCellValue('B1', '产品图片');

        $objPHPExcel->getActiveSheet()->setCellValue('C1', '产品名称');

        $objPHPExcel->getActiveSheet()->setCellValue('D1', '产品分类');

        $objPHPExcel->getActiveSheet()->setCellValue('E1', '视频价格');

        $objPHPExcel->getActiveSheet()->setCellValue('F1', '用户昵称');

        $objPHPExcel->getActiveSheet()->setCellValue('G1', '下单时间');

        $objPHPExcel->getActiveSheet()->setCellValue('H1', '小程序uniacid');

        foreach($order as $k => $v){

            $num=$k+2;

            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$num, $v['orderid'],'s');

            $objPHPExcel->getActiveSheet()->setCellValue('B'.$num, $v['thumb']);

            $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, $v['title']);

            $objPHPExcel->getActiveSheet()->setCellValue('D'.$num, $v['name']);

            $objPHPExcel->getActiveSheet()->setCellValue('E'.$num, $v['paymoney']);

            $objPHPExcel->getActiveSheet()->setCellValue('F'.$num, $v['nickname']);

            $objPHPExcel->getActiveSheet()->setCellValue('G'.$num, $v['creattime']);

            $objPHPExcel->getActiveSheet()->setCellValue('H'.$num, $v['uniacid']);

        }

        $objPHPExcel->getActiveSheet()->setTitle('导出订单列表');

        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');

        header('Content-Disposition: attachment;filename="付费视频订单列表.xls"');

        header('Cache-Control: max-age=0');

        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

        $objWriter->save('php://output');

        

    }

}