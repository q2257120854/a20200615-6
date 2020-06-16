<?php

namespace app\index\controller;



use think\Controller;

use think\Db;

use think\Request;

use think\Session;

use think\View;

use think\Cookie;



class Bizlogin extends Controller

{

    public function index(){

        $shopid = Cookie::get("venue_id");  //商户id

        $id = Cookie::get("uniacid");  //uniacid

        $res = Db::table('applet')->where("id",$id)->find();

        if(!$res){

            $this->error("找不到对应的小程序！");

        }

        $this->assign('applet',$res);

        $this->assign('page',1); //页面id

        return $this->fetch('index');

    }

    public function goods(){

        $id = input("appletid");  //uniacid

        $res = Db::table('applet')->where("id",$id)->find();

        if(!$res){

            $this->error("找不到对应的小程序！");

        }

        $this->assign("applet",$res);



        $shopid = Cookie::get("venue_id");  //店铺id

        // var_dump($_COOKIE['venue_id']);  另一种获取cookie的方法

        $goods = Db::table("ims_sudu8_page_shops_goods")->where("uniacid",$id)->where("sid",$shopid)->order("createtime desc")->paginate(10,false,['query' => array('appletid' => input("appletid"))]);

        $count = Db::table("ims_sudu8_page_shops_goods")->where("uniacid",$id)->where("sid",$shopid)->order("createtime desc")->count();

        if($goods->toArray()){

            $products = $goods->toArray()['data'];

        }

        foreach ($products as $key => &$value) {

            $value['thumb'] = remote($id,$value['thumb'],1);

        }

        $this->assign('goods',$goods);

        $this->assign('goodslist',$products);

        $this->assign('counts',$count);

        $this->assign('page',2); //页面id

        return $this->fetch('goods');

    }

    //审核商品通过

    public function goodspass(){

        $pid = intval(input("goodsid"));

        $appletid = input("appletid");

        $data = array(

            "uniacid" =>$appletid,

            "id" => $pid,

            "status" => 1

        );

        $res = Db::table('ims_sudu8_page_shops_goods')->where("uniacid",$appletid)->where("id",$pid)->update($data);

        if($res){

            $this->success("审核通过");

        }else{

            $this->success("审核失败");

        }

    }



    //审核商品不通过

    public function goodscancel(){

        $pid = intval(input("goodsid"));

        $appletid = input("appletid");

        $data = array(

            "uniacid" =>$appletid,

            "id" => $pid,

            "status" => 2

        );

        $res = Db::table('ims_sudu8_page_shops_goods')->where("uniacid",$appletid)->where("id",$pid)->update($data);

        if($res){

            $this->success("审核不通过");

        }else{

            $this->success("审核失败");

        }

    }

    //新增商品

    public function goodsadd(){

        $appletid = input("appletid");

        $res = Db::table('applet')->where("id",$appletid)->find();

        if(!$res){

            $this->error("找不到对应的小程序！");

        }

        $this->assign('applet',$res);

        $goodsid = input("goodsid");
        $shopid = Session::get("shopuserid");

        $goodsinfo = '';

        if($goodsid){

            $goods = DB::table('ims_sudu8_page_shops_goods')->where("uniacid",$appletid)->where("id",$goodsid)->find();

            if($goods['images']){

                $goods['images'] = unserialize($goods['images']);

                if($goods['images']){

                    foreach ($goods['images'] as $key => &$value) {

                        $value = remote($appletid,$value,1);

                    }

                }

            }

        }else{


            $goods = "";

        }

        $this->assign('goodsid',$goodsid);

        $this->assign('page',2); //页面id

        $this ->assign('goods',$goods);

        $this->assign('shopid',$shopid);

        return $this->fetch('goodsadd');

    }

    //提交商品信息

    public function goodssave(){

       $appletid = input("appletid");

        $pid = input("pid");

        $sid = input("sid");

        $flag = input("flag");

        if(!$flag){

            $flag = 0;

        }

        $hot = input("hot");

        if(!$hot){

            $hot = 0;

        }

        $pcid = Db::table('ims_sudu8_page_shops_shop')->where('uniacid',$appletid)->where('id',$sid)->find();

        if($pcid){

            $data= array(

                "uniacid" => $appletid,

                "sid" => input('sid'),

                "num" => input('num'),

                "flag" => $flag,

                "hot" => $hot,

                "title" => input('title'),

                "buy_type" => input('buy_type'),

                "pageview" => input('pageview'),

                "vsales" => input('vsales'),

                "rsales" => input('rsales'),

                "sellprice" => input('sellprice'),

                "marketprice" => input('marketprice'),

                "storage" => input('storage'),

            );

        }

        $imgsrcs = input("imgsrcs/a");

        if($imgsrcs){

            foreach ($imgsrcs as $key => &$value) {

                $value = moveurl(remote($appletid,$value,1));

            }

            $data['images'] = serialize($imgsrcs);

        }else{

            $data['images'] = [];

        }

        $thumb = input("commonuploadpic1");

        if($thumb){

           $data['thumb'] = moveurl(remote($appletid,$thumb,1));

        }

        $goodsid = input("goodsid");

        if($goodsid){

            $res = Db::table('ims_sudu8_page_shops_goods')->where("uniacid",$appletid)->where("id",$goodsid)->update($data);

        }else{

            $data['uniacid'] = $appletid;

            $res = Db::table("ims_sudu8_page_shops_goods")->insert($data);

        }

        if($res){

            $this->success('商品信息更新成功！');

        }

    }

    //删除商品

    public function goodsdel(){

        $appletid = input("appletid");

        $pid = input("goodsid");

        $data = array(

            "uniacid"=>$appletid,

            "id"=>$pid

        );

        $res = Db::table('ims_sudu8_page_shops_goods')->where($data)->delete();

        if($res){

            $this->success('商品删除成功');

        }else{

            $this->success('商品删除失败');

        }

    }

    public function order(){

        $appletid = input("appletid");

        $res = Db::table('applet')->where("id",$appletid)->find();



        if(!$res){

            $this->error("找不到对应的小程序！");

        }

        $this->assign('applet',$res);



        $op = input('op');

        if($op == "hx"){  //核销

            $order = input('orderid');



            $shopid = input('shopid');

            $data['hxtime'] = time();

            $data['flag'] = 2;

            $res = Db::table('ims_sudu8_page_duo_products_order')->where("id",$order)->update($data);

            if($shopid != '0'){

                $money = Db::table('ims_sudu8_page_shops_shop')->where("uniacid",$appletid)->where("id",$shopid)->field("tixian")->find()['tixian'];



                $add = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid",$appletid)->where("id",$order)->field("price")->find()['price'];



            

                $money = $money + $add;

                $result = Db::table('ims_sudu8_page_shops_shop')->where("uniacid",$appletid)->where("id",$shopid)->update(array('tixian' => $money));

            }

            if($res){

                $this->success("核销成功");

            }

        }

        if($op == "fh"){  

            $order = input('orderid');

            $data['flag'] = 2;

            $res = Db::table('ims_sudu8_page_duo_products_order')->where("id",$order)->update($data);

            if($res){

                $this->success("操作成功");

            }

        }

        if($op == "fahuo"){  //发货

            $order = input('orderid');

            $data['hxtime'] = time();

            $data['kuadi'] = input('kuadi');

            $data['kuaidihao'] = input('kuaidihao');

            $data['flag'] = 4;

            $res = Db::table('ims_sudu8_page_duo_products_order')->where("id",$order)->update($data);

            if($res){

                $this->success("发货成功");

            }

        }

        $total = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid',$appletid)->where("sid",'neq',0)->order("creattime desc")->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"))]);

        $orders = $total->toArray()['data'];

        foreach ($orders as $key => &$res) {

            $res['jsondata'] = unserialize($res['jsondata']);

            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);

            $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);

            $res['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid',$appletid)->where("openid",$res['openid'])->find();

            $res['counts'] = count($res['jsondata']);

            $coupon = Db::table('ims_sudu8_page_coupon_user')->where('uniacid',$appletid)->where("id",$res['coupon'])->find();

            $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid',$appletid)->where("id",$coupon['cid'])->find();

            $res['couponinfo'] = $couponinfo;

            if($res['sid'] == '0'){

                $res['shopname'] = '总平台';

            }else{

                $res['shopname'] = Db::table('ims_sudu8_page_shops_shop')->where('uniacid',$appletid)->where("id",$res['sid'])->field('name')->find()['name'];

            }



            // 重新算总价

            $allprice = 0;

            foreach ($res['jsondata'] as $key2 => &$reb) {

                $allprice += ($reb['num']*1)*($reb['proinfo']['price']);

            }

            $res['allprice'] = $allprice;



            // 积分转钱

            //积分转换成金钱

            $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid',$appletid)->find();

            

            if(!$jf_gz){

                $gzscore = 10000;

                $gzmoney = 1;

            }else{

                $gzscore = $jf_gz['score'];

                $gzmoney = $jf_gz['money'];

            }

            $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;





            // 转换地址

            if($res['address']!=0){

                $res['address_get'] = Db::table('ims_sudu8_page_duo_products_address')->where('openid',$res['openid'])->where('id',$res['address'])->find();

            }else{

                // dump($res['m_address']);die;

                $res['address_get'] = unserialize($res['m_address']);

            }

            if($res['formid']){

                $res['formcon'] = Db::table('ims_sudu8_page_formcon')->where('uniacid',$appletid)->where('id',$res['formid'])->find();

                $res['formcon'] = unserialize($res['formcon']['val']);

                foreach ($res['formcon'] as $k => $vi) {

                    if($vi['z_val']){

                        foreach ($vi['z_val'] as $kv => $vv) {

                            if(strpos($vv,'http')===false){

                                $res['formcon'][$k]['z_val'][$kv] = remote($appletid,$vv,1);

                            }else{

                                $res['formcon'][$k]['z_val'][$kv] = $vv;

                            }

                        }

                    }

                }

            }

        }

        $this->assign('page',3); //页面id

        $this->assign('orders',$orders);

        $this->assign('total',$total);

        return $this->fetch('order');

    }

    public function fahuo(){

        $appletid = input("appletid");

        $order_id = input("orderid");

        $shopid = input('shopid');

        $data['hxtime'] = time();

        $data['flag'] = 2;

        Db::table('ims_sudu8_page_duo_products_order')->where("uniacid",$appletid)->where("id",$order_id)->update($data);

        if($shopid != '0'){

            $money = Db::table('ims_sudu8_page_shops_shop')->where("uniacid",$appletid)->where("id",$shopid)->find()['tixian'];

            $add = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid",$appletid)->where("id",$order_id)->find()['price'];

            $money = $money + $add;

            $result = Db::table('ims_sudu8_page_shops_shop')->where("uniacid",$appletid)->where("id",$shopid)->update(array('tixian' => $money));

        }

        if($result){

            $this->success("核销成功");

        }

    }

    //提现申请

    public function withdraw(){ 

 

        $appletid = input("appletid");

        $res = Db::table('applet')->where("id",$appletid)->find();

        if(!$res){

            $this->error("找不到对应的小程序！");

        }

        $this->assign('applet',$res);

        $records = Db::table('ims_sudu8_page_shops_tixian')->where("uniacid",$appletid)->order("createtime desc")->select();

        foreach ($records as $key => &$value){

            $value['shopname'] = Db::table('ims-sudu8_page_shops_shop')->where("$uniacid",$appletid)->where("id",$value['sid'])->find()['name'];

        };

        $count = Db::table('ims_sudu8_page_shops_tixian')->where("uniacid",$appletid)->count();

        

        $this->assign('records',$records);

        $this->assign('counts',$count);

        $this->assign('page',4); //页面id

        return $this->fetch('withdraw');

    }

    //提现审核

    public function withdrawpass(){

        $appletid = input("appletid");

        $id = input("id");

        $data = array(

            "flag" => 1

        );

        $res = Db::table('ims_sudu8_page_shops_tixian')->where("uniacid",$appletid)->where("id",$id)->update($data);

        if($res){

            $this->success("审核成功");

        }

    }

    public function shopset(){

        $appletid = input("appletid");

        $res = Db::table('applet')->where("id",$appletid)->find();

        if(!$res){

            $this->error("找不到对应的小程序！");

        }

        $this->assign('applet',$res);

        $shopid = Cookie::get("venue_id");//店铺id

        $listV = Db::table('ims_sudu8_page_shops_cate')->where("uniacid",$appletid)->order('num desc')->order('id desc')->select();

        $shopinfo = '';

        if($shopid){

            $shopinfo = DB::table('ims_sudu8_page_shops_shop')->where("uniacid",$appletid)->where("id",$shopid)->find();

            if($shopinfo['images']){

                $shopinfo['images'] = unserialize($shopinfo['images']);

                if($shopinfo['images']){

                    foreach ($shopinfo['images'] as $key => &$value) {

                        $value = remote($appletid,$value,1);

                    }

                }

            }

        }else{

            $shopid = 0;

        }

        $this->assign('page',5); //页面id

        $this->assign('shopid',$shopid);

        $this->assign('shopinfo',$shopinfo);

        $this->assign('listAll',$listV);

        return $this->fetch("shopset");

    }

     //提交新添加的商户信息

    public function shopsave(){

        $appletid = input("appletid");

        $shopid = input("shopid");

        //判断修改时账号是否唯一

        $cid = input("cid");

        $latlong = input("latlong");

        if($latlong){

            $latlong = explode(",",$latlong);

            $latitude = $latlong[0];

            $longitude = $latlong[1];

        }else{

            $latitude = "";

            $longitude = "";

        }

        $password = input("password");

        $pcid = Db::table('ims_sudu8_page_shops_cate')->where('uniacid',$appletid)->where('id',$cid)->find();

        if($pcid){

            $data= array(

                "uniacid" => $appletid,

                "cid" => input('cid'),

                "password" => $password,

                "intro" => input("intro"),

                "worktime" => input("worktime"),

                "name" => input("name"),

                "star" => input("star"),

                "tel" => input("tel"),

                "address" => input("address"),

                "latitude" => $latitude,

                "longitude" => $longitude,

                "title" => input("title"),

                "descp" => input("descp"),

            );

        }

        $imgsrcs = input("imgsrcs/a");

        if($imgsrcs){

            foreach ($imgsrcs as $key => &$value) {

                $value = remote($appletid,$value,1);

            }

            $data['images'] = serialize($imgsrcs);

        }else{

            $data['images'] = [];

        }

        //logo

        $logo = input("commonuploadpic1");

        if($logo){

           $data['logo'] = remote($appletid,$logo,2);

        }

        $bg = input("commonuploadpic2");

        if($bg){

            $data['bg'] = remote($appletid,$bg,2);

        }

        $shop = Db::table('ims_sudu8_page_shops_shop')->where("uniacid",$appletid)->where("id",$shopid)->find();

        if($shop){

            $res = Db::table('ims_sudu8_page_shops_shop')->where("uniacid",$appletid)->where("id",$shopid)->update($data);

        }

        if($res){

            if($password == $shop['password']){

                $this->success('店铺信息更新成功！');

            }else{

                $this->success('店铺信息更新成功,账号信息有更改，需重新登录！', 'index/login/bizlogin');

            }

        }else{

            $this->success('店铺信息更新失败！');

        }

    }

}