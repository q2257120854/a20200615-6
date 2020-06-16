<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
vendor('Qiniu.autoload');
use Qiniu\Auth as Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
class Duoproducts extends Base
{
    // 最新购物车列表
    public function index(){
        if(check_login()){
            if(powerget()){
                $appletid = input("appletid");
                $res = Db::table('applet')->where("id",$appletid)->find();
                if(!$res){
                    $this->error("找不到对应的小程序！");
                }
                $this->assign('applet',$res);

                $product = Db::table('ims_sudu8_page_products')->alias('a')->join('ims_sudu8_page_cate b','a.cid = b.id','LEFT')->where("a.uniacid",$appletid)->where('is_more',3)->order("a.num desc")->field('a.*,b.name')->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"))]);
                $count = Db::table('ims_sudu8_page_products')->where("uniacid",$appletid)->where('is_more',3)->count();
                $products = $product->toArray();
                foreach ($products['data'] as $key => &$value) {
         
                    if($value['thumb']){
                      $value['thumb'] = remote($appletid,$value['thumb'],1);
                    }else{
                        $value['thumb'] = remote($appletid,"/image/noimage.jpg",1);
                    }
                    //获取多规格
                    // $value['type_values'] = pdo_getall("sudu8_page_duo_products_type_value", array("pid"=>$value['id']));
                    $value['type_values'] = Db::table('ims_sudu8_page_duo_products_type_value') ->where('pid', $value['id']) ->order("id asc") ->select();
                }

                $this->assign('counts',$count);
                $this->assign('product',$product);
                $this->assign('products',$products);
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
    public function del(){
        $appletid = input("appletid");
        $id = intval(input('newsid'));
        $res1 = Db::table('ims_sudu8_page_products')->where("uniacid",$appletid)->where('id',$id)->delete();
        $res2 = Db::table('ims_sudu8_page_duo_products_type_value')->where('pid',$id)->delete();
        $this->success('删除成功');
    }
    public function save(){
        $appletid = input("appletid");
        $newsid = input("newsid");
        $cid = intval(input('cid'));
        $onlyid = input('onlyid');
        $imgsrcs = input("imgsrcs/a");
        if($imgsrcs){
            $imgarr = array();
            foreach ($imgsrcs as $k => $v) {
                $imgarr['randid'] = $onlyid;
                $imgarr['appletid'] = $appletid;
                $imgarr['url'] = remote($appletid,$v,2);
                $imgarr['dateline'] = time();
                $is = Db::table('products_url')->insert($imgarr);
            }
        }else{
            $is = 1;
        }
        $data['onlyid'] = $onlyid;
        $imgs = Db::table('products_url')->where('randid',$onlyid)->select();
        $imgtext = array();
        foreach($imgs as $k => $v){
            array_push($imgtext,$v['url']);
        }

        $set1 = input("set1");
        $set2 = input("set2");
        $vipconfig = array(
            "set1" => $set1,
            "set2" => $set2
            );


        $pcid = Db::table('ims_sudu8_page_cate')->where('uniacid',$appletid)->where('id',$cid)->find();
        if($pcid){
            if($pcid['cid'] == 0){
                $pcids = $cid;
            }else{
                $pcids = intval($pcid['cid']);
            }
            $is_sale=0;
            if(input("is_sale")){
                $is_sale=input("is_sale");
            }
            $data = array(
                "uniacid" => $appletid,
                "num" => input('num'),
                "cid" => input('cid'),
                "pcid" => $pcids,
                "type_x" => input('type_x'),
                "type_y" => input('type_y'),
                "type_i" => input('type_i'),
                "is_sale"=>$is_sale,
                "title" => input('title'),
               "price" => input('priceq'),
                "market_price" => input('mark_priceq'),
                "desc" => input('desc'),
                'labels' => input('labels'),
                "score" => input('score'),
                "onlyid" => $onlyid,
                "product_txt" => input('product_txt'),
                "text" => serialize($imgtext),
                "is_more" => 3,
                "type" => "showProMore",
                "hits" => input("hits"),
                'scoreback'=> input('scoreback'),
                "vipconfig" => serialize($vipconfig)
            );

            //门店
            $stores=input("stores");
            if($stores){
                $data['stores']=$stores;
            }else{
                $data['stores']=null;
            }

            $fx_uni = input('fx_uni');
            if($fx_uni == null){
                $data['fx_uni'] = 2;
            }else{
                $data['fx_uni'] = input('fx_uni');
            }
            $commission_type = input('commission_type');
            if($commission_type == null){
                $data['commission_type'] = 1;
            }
            $data['commission_one'] = input('commission_one');
            $data['commission_two'] = input('commission_two');
            $data['commission_three'] = input('commission_three');
            $data["get_share_gz"] = input('get_share_gz');
            $data["get_share_score"] = input('get_share_score');
            $data["get_share_num"] = input('get_share_num');
            //缩略图
            $thumb = input("commonuploadpic1");
            if($thumb){
                $data['thumb'] = remote($appletid,$thumb,2);
            }
            $shareimg = input("commonuploadpic2");
            if($shareimg){
                $data['shareimg'] = remote($appletid,$shareimg,2);
            }
            $guig = input('ischeck');
            $data["types"] = intval($guig);
            if($newsid){
                Db::table('ims_sudu8_page_products')->where('id',$newsid)->update($data);
                // 全部删除已有数据
                Db::table('ims_sudu8_page_duo_products_type_value')->where('pid',$newsid)->delete();
                //删除产品相关gwc信息
                Db::table('ims_sudu8_page_duo_products_gwc')->where('pvid',$newsid)->delete();  
            }else{
                $newsid = Db::table('ims_sudu8_page_products')->insertGetId($data);
            }                            
            
            if($guig == 2){
                // 规格组长度
                $typelen = input('typelen');
                // 规格数组
                $types = input('typesarr');
                $typezz = $types;
                $typesarr = explode(",", $types);
                // 子商品
                // $ggarr = input('biaogedata');
                $ggarr = stripslashes(html_entity_decode(input('biaogedata')));
                $proarr = json_decode($ggarr,true);
                $count = 0;
                if($proarr){
                    foreach ($proarr as $key => $rec) {
                        if($typelen == 1){
                            $type1 = $rec[$typesarr[0]];
                            $type2 = "";
                            $type3 = "";
                        }
                        if($typelen == 2){
                            $type1 = $rec[$typesarr[0]];
                            $type2 = $rec[$typesarr[1]];
                            $type3 = "";
                        }
                        if($typelen == 3){
                            $type1 = $rec[$typesarr[0]];
                            $type2 = $rec[$typesarr[1]];
                            $type3 = $rec[$typesarr[2]];
                        }
                        $datas = array(
                            "pid" => $newsid,
                            "type1" => $type1,
                            "type2" => $type2,
                            "type3" => $type3,
                            "kc" => $rec['库存'],
                            "price" => $rec['价格'],
                            "hnum" => $rec['货号'],
                            "salenum" => $rec['已售数量'],
                            "thumb" => $rec['规格图片'],
                            "comment" => $typezz,
                            "vsalenum"=>$rec['虚拟销量']
                        );
                        $res = Db::table('ims_sudu8_page_duo_products_type_value')->insert($datas);
                        if($res){
                            $count++;
                            if($count == count($proarr)){
                                $minprice=Db::table('ims_sudu8_page_duo_products_type_value')->where('pid',$newsid)->order("price asc")->limit(1)->find();
                                Db::table("ims_sudu8_page_products")->where("id",$newsid)->update(array("price"=>$minprice['price']));
                                $this->success('多规格产品更新成功',Url('Duoproducts/index').'?appletid='.$appletid);
                            }
                        }
                    }
                }
            }else{
                $datas = array(
                    "pid" => $newsid,
                    "type1" => "默认",
                    "type2" => "",
                    "type3" => "",
                    "kc" => 1,
                    "price" =>1,
                    "hnum" => 0,
                    "salenum" => 0,
                    "thumb" => input('nothumb'),
                    "comment" => "规格",
                    "vsalenum"=>0
                );
                Db::table("ims_sudu8_page_products")->where("id",$newsid)->update(array("price"=>1));
                $res = Db::table('ims_sudu8_page_duo_products_type_value')->insert($datas);
                if($res){
                    $this->success('多规格产品更新成功',Url('Duoproducts/index').'?appletid='.$appletid);
                }
            }
        }
    }
    public function add(){
        if(check_login()){
            if(powerget()){
                $appletid = input("appletid");
                $res = Db::table('applet')->where("id",$appletid)->find();
                if(!$res){
                    $this->error("找不到对应的小程序！");
                }
                $this->assign('applet',$res);
                $id = input('newsid');
                $stores=Db::table("ims_sudu8_page_store")->where("uniacid",$appletid)->select();

                $this->assign('stores',$stores);
                $listV = Db::table('ims_sudu8_page_cate')->where("uniacid",$appletid)->where('type','showPro')->where('cid',0)->order('num desc')->order('id desc')->select();
                $listAll = array();
                foreach($listV as $key=>$val) {
                    $cid = intval($val['id']);
                    $listP = Db::table('ims_sudu8_page_cate')->where("uniacid",$appletid)->where('type','showPro')->where('id',$cid)->order('num desc')->order('id desc')->find();
                    $listS = Db::table('ims_sudu8_page_cate')->where("uniacid",$appletid)->where('type','showPro')->where('cid',$cid)->order('num desc')->order('id desc')->select();
                    $listP['data'] = $listS;
                    array_push($listAll,$listP);
                }
                if($id){
                    $products = Db::table('ims_sudu8_page_products')->where('is_more',3)->where("uniacid",$appletid)->where('id',$id)->find();
                    if(!empty($products['vipconfig'])){
                        $products['vipconfig'] = unserialize($products['vipconfig']);
                    }
                    if($products['thumb']){
                        $products['thumb'] = remote($appletid,$products['thumb'],1);
                    }
                    if($products['shareimg']){
                        $products['shareimg'] = remote($appletid,$products['shareimg'],1);
                    }
                    $allimg = Db::table('products_url')->where('randid',$products['onlyid'])->select();    
                    foreach ($allimg as $key => &$value) {
                        $value['url'] = remote($appletid,$value['url'],1);
                    }
                    if($products['types']==2){
                        $proarr = Db::table('ims_sudu8_page_duo_products_type_value')->where('pid',$id)->order('id asc')->select();
                        //构建规格组
                        $counttypes=0;
                        $typesarr=array();
                        $typesjson = [];
                        if($proarr){
                            $types = $proarr[0]['comment'];
                            // 构建规格组json
                            $typesarr = explode(",", $types);
                            $counttypes = count($typesarr);

                            foreach ($typesarr as $key => &$rec) {
                                $str = "type".($key+1);
                                $ziji = Db::table('ims_sudu8_page_duo_products_type_value')->where('pid',$id)->order("id asc")->field($str)->select();
                                $xarr = array();
                                foreach ($ziji as $key => $res) {
                                    array_push($xarr, $res[$str]);
                                }
                                $typesjson[$rec] = $xarr;
                            }
                        }
                        // 构建对应的数值
                        $datajson = [];
                        foreach ($proarr as $key => &$rec) {
                            $strs = $rec['type1'].$rec['type2'].$rec['type3'];
                            $strv = $rec['kc'].",".$rec['price'].",".$rec['hnum'].",".$rec['salenum'].",".$rec['vsalenum'].",".$rec['thumb'];
                            $datajson[$strs]=$strv;
                        }
                    }
                    if($products['types']==1){
                        $proarr = Db::table('ims_sudu8_page_duo_products_type_value')->where('pid',$id)->order("id asc")->find();
                        $products['kc'] = 1; 
	                    $counttypes = 0;
	                    $typesarr = [];
	                    $typesjson = [];
	                    $datajson = [];
                    }
                }else{
                    $products = "";
                    $id = 0; 
                    $allimg = "";
                    $counttypes = 0;
                    $typesarr = [];
                    $typesjson = [];
                    $datajson = [];
                }
                foreach ($typesjson as $key => &$value) {
                    $value = array_unique($value);
                }

                $this->assign('counttypes',$counttypes);
                $this->assign('typesarr',$typesarr);
                $this->assign('typesjson',$typesjson);
                $this->assign('datajson',$datajson);
                $this->assign('allimg',$allimg);
                $this->assign('id',$id);
                $this->assign('products',$products);
                $this->assign('listAll',$listAll);
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
            return $this->fetch('add');
        }else{
            $this->redirect('Login/index');
        }
    }
    public function order(){
        if(check_login()){
            if(powerget()){
                $appletid = input("appletid");
                $res = Db::table('applet')->where("id",$appletid)->find();
                if(!$res){
                    $this->error("找不到对应的小程序！");
                }
                $this->assign('applet',$res);
                $op = input('op');
//                $ops = array('allowth','refuseth','refuseqx');
                if($op == "hx"){  //核销
                    $order = input('orderid');
                    $orderinfo = Db::table('ims_sudu8_page_duo_products_order')->where("id",$order)->where("uniacid",$appletid)->find();
                    if($orderinfo['flag'] == 2){
                        $this->error("已核销!");
                    }
                    $data['hxtime'] = time();
                    $data['flag'] = 2;
                    $res = Db::table('ims_sudu8_page_duo_products_order')->where("id",$order)->update($data);

                    //核销完成赠送积分
                    $jsondata = unserialize($orderinfo['jsondata']);
                    $total_num = 0;
                    $total_price = 0;
                    foreach ($jsondata as $key => &$value) {
                        $total_num += $value['num'];
                        $total_price += $value['proinfo']['price'] * $value['num'];
                    }
                    $a=Db::table("ims_sudu8_page_products")->where("uniacid",$appletid)->where("id",$jsondata[0]['baseinfo']['id'])->find();
                    $scoreback=$a['scoreback'];
                    if(!empty($scoreback)){
                        if(strpos($scoreback, "%")){
                            $scoreback = floatval(chop($scoreback, "%"));
                            $scoretomoney=Db::table("ims_sudu8_page_rechangeconf")->where("uniacid",$appletid)->find();
                            $scoreback = $total_price * $scoreback / 100;
                            $scoreback = floor($scoreback * intval($scoretomoney['scroe']) / intval($scoretomoney['money']));

                        }else{
                            $scoreback = floor($total_num * floatval($scoreback));
                        }

                        if($scoreback > 0){
                            $new_user=Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$orderinfo['uid'])->find();
                            $new_my_score = $new_user['score'] + $scoreback;
                           Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$new_user['id'])->update(array("score"=>$new_my_score));
                            $scoreback_data = array(
                                "uniacid" => $appletid,
                                "orderid" => $orderinfo['order_id'],
                                "uid" => $new_user['id'],
                                "type" => "add",
                                "score" => $scoreback,
                                "message" => "买送积分",
                                "creattime" => time()
                            );
                            Db::table("ims_sudu8_page_score")->insert($scoreback_data);
                        }
                    }


                    // 核销完成后去检测要不要进行分销商返现
                    
                    $order_id = $orderinfo['order_id'];
                    $openid = $orderinfo['openid'];
                    $fxsorder = Db::table('ims_sudu8_page_fx_ls')->where("order_id",$order_id)->where("uniacid",$appletid)->find();
                    if($fxsorder){
                        $this->dopagegivemoney($appletid,$openid,$order_id);
                    }
                    $this->success("核销成功");
                }
                if($op == "fh"){  
                    $order = input('orderid');
                    $data['flag'] = 2;
                    $res = Db::table('ims_sudu8_page_duo_products_order')->where("id",$order)->update($data);
                    $this->success("操作成功");
                }
                if($op == "fahuo"){  //发货
                    $order = input('orderid');
                    $data['hxtime'] = time();
                    $data['kuadi'] = input('kuadi');
                    $data['kuaidihao'] = input('kuaidihao');
                    $data['flag'] = 4;
                    $res = Db::table('ims_sudu8_page_duo_products_order')->where("id",$order)->update($data);
                    $this->success("发货成功");
                }
                if($op == 'refuseqx'){
                    $orderid = input("orderid");
//                    pdo_update("", array("flag"=>1), array("uniacid"=>$appletid, "id"=>$order_id));
                    Db::table('ims_sudu8_page_duo_products_order')->where("uniacid",$appletid)->where("id",$orderid)->update(array("flag"=>1));
                    $this->success('拒绝取消成功!');
                }

                if($op == "quxiao" || $op == "confirmtk"){  //取消
                    $orderid = input('orderid');

                    //微信退款
                    if(input('qxbeizhu')){
                        $data['qxbeizhu'] = input('qxbeizhu');
                    }
                    $now = time();
                    $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
                    $data['th_orderid'] = $out_refund_no;

                    Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("id",$orderid)->update($data);
                     $order=Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where('id',$orderid)->find();
                    $types = ($op == "confirmtk") ? "duotk" : "duoqx";


                    if($order['payprice'] > 0){
                        $app = Db::table('applet')->where("id",$appletid)->find();
                        $mchid = $app['mchid'];   //商户号
                        $apiKey = $app['signkey'];    //商户的秘钥
                        $appid = $app['appID'];                 //小程序的id
                        $appkey = $app['appSecret'];            //小程序的秘钥
                        $openid= $order['openid'];    //申请者的openid
                        $outTradeNo =$order['order_id'];
                        $totalFee= intval($order['payprice'] * 100);  //申请了提现多少钱
                        $outRefundNo = $order['order_id']; //商户订单号
                        $refundFee= intval($order['payprice'] * 100);  //申请了提现多少钱
                        $SSLCERT_PATH = ROOT_PATH.'public/Cert/'.$appletid.'/apiclient_cert.pem';//证书路径
                        $SSLKEY_PATH =  ROOT_PATH.'public/Cert/'.$appletid.'/apiclient_key.pem';//证书路径
                        $opUserId = $mchid;//商户号
                        include "WinXinRefund.php";
                        $weixinpay = new WinXinRefund($openid,$outTradeNo,$totalFee,$outRefundNo,$refundFee,$SSLCERT_PATH,$SSLKEY_PATH,$opUserId,$appid,$apiKey);
                        $return = $weixinpay->refund();
                        if(!$return){
                            message('退货失败!请检查系统设置->小程序设置和支付设置');
                        }


                        if(!$return){
                            $this->error("退款失败 请检查证书是否正常");
                        }else{
                            //更新订单状态
                            Db::table('ims_sudu8_page_duo_products_order') ->where('uniacid', $appletid) ->where('th_orderid', $out_refund_no) ->update(['flag' => 5]);

                            //金钱流水
                            $xfmoney = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['payprice'],
                                "message" => "退款退回微信",
                                "creattime" => time()
                            );
//                            pdo_insert("sudu8_page_money", $xfmoney);
                            Db::table("ims_sudu8_page_money")->insert($xfmoney);
                            $tk_je = $order['price'] - $order['payprice']; //退回余额
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
//                                pdo_insert("sudu8_page_money", $xfmoney1);
                                Db::table("ims_sudu8_page_money")->insert($xfmoney1);
//                                $e=Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->find();
//                                $f=$e["score"]*1-$scoreback['score']*1;
//                                Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->update(array("score"=>$f));
                                Db::execute("update ims_sudu8_page_user set money=money+".$tk_je." where id=".$order['uid']);
                            }

                            if($order['coupon']){

                            Db::table("ims_sudu8_page_coupon_user")->where("uniacid",$appletid)->where("uid",$order['uid'])->where("id",$order['coupon'])->update(array("flag"=>0,"utime"=>0));
                        }
                        if($order['jf']){
                            $c=Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->find();
                            $d=$c["score"]*1+$order['jf'];
                            Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->update(array("score"=>$d));
                            $score_data = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['jf'],
                                "message" => "退款退回抵扣积分",
                                "creattime" => time()
                            );
//                            pdo_insert("sudu8_page_score", $score_data);
                             Db::table("ims_sudu8_page_score")->insert($score_data);
                        }
                       // $scoreback=Db::table("ims_sudu8_page_score")->where("uniacid",$appletid)->where("uid",$order['uid'])->where("orderid",$order["order_id"])->where("type","add")->where("message","买送积分")->find();
                       //  if($scoreback){
                       //      $e=Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->find();
                       //      $f=$e["score"]*1-$scoreback['score']*1;
                       //      Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->update(array("score"=>$f));
                       //      $score_data2 = array(
                       //          "uniacid" => $appletid,
                       //          "orderid" => $order['order_id'],
                       //          "uid" => $order['uid'],
                       //          "type" => "del",
                       //          "score" => $scoreback['score'],
                       //          "message" => "退款扣除买送积分",
                       //          "creattime" => time()
                       //      );
                       //      Db::table("ims_sudu8_page_score")->insert($score_data2);
                       //  }
                        }
                    }else{
                        if($op == "confirmtk"){
//                            pdo_update("sudu8_page_duo_products_order", array("flag"=>8), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                            Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("th_orderid",$out_refund_no)->update(array("flag"=>8));
                        }else{
//                            pdo_update("sudu8_page_duo_products_order", array("flag"=>5), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                            Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("th_orderid",$out_refund_no)->update(array("flag"=>5));
                        }

                        //金钱流水
                        if($order['price'] > 0){
                            $xfmoney = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['price'],
                                "message" => "退款退回余额",
                                "creattime" => time()
                            );
                            Db::table("ims_sudu8_page_money")->insert($xfmoney);
                        }
                        $a=Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->find();
                         $b=$a['money']*1+$order['price']*1;
                         Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->update(array("money"=>$b));


                        if($order['coupon']){

                            Db::table("ims_sudu8_page_coupon_user")->where("uniacid",$appletid)->where("uid",$order['uid'])->where("id",$order['coupon'])->update(array("flag"=>0,"utime"=>0));
                        }
                        if($order['jf']){
                            $c=Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->find();
                            $d=$c["score"]*1+$order['jf'];
                            Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->update(array("score"=>$d));
                            $score_data = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['jf'],
                                "message" => "退款退回抵扣积分",
                                "creattime" => time()
                            );
//                            pdo_insert("sudu8_page_score", $score_data);
                             Db::table("ims_sudu8_page_score")->insert($score_data);
                        }
                       // $scoreback=Db::table("ims_sudu8_page_score")->where("uniacid",$appletid)->where("uid",$order['uid'])->where("orderid",$order["order_id"])->where("type","add")->where("message","买送积分")->find();
                       //  if($scoreback){
                       //      $e=Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->find();
                       //      $f=$e["score"]*1-$scoreback['score']*1;
                       //      Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->update(array("score"=>$f));
                       //      $score_data2 = array(
                       //          "uniacid" => $appletid,
                       //          "orderid" => $order['order_id'],
                       //          "uid" => $order['uid'],
                       //          "type" => "del",
                       //          "score" => $scoreback['score'],
                       //          "message" => "退款扣除买送积分",
                       //          "creattime" => time()
                       //      );
                       //      Db::table("ims_sudu8_page_score")->insert($score_data2);
                       //  }

                        $fmsg = "";
                        $jsondata = unserialize($order['jsondata']);
                        foreach($jsondata as $key => &$value){
                            if($key != 0){
                                $fmsg .= "\\n";
                            }
                            $fmsg .= $value['baseinfo']['title'] . "（" . chop($value['proinfo']['ggz'],',') . "） ×" .$value['num'];
                          Db::execute('update ims_sudu8_page_duo_products_type_value  set kc=kc+'.$value['num'].' where id='.$value['proinfo']['id']);
                            Db::execute('update ims_sudu8_page_duo_products_type_value  set salenum=salenum-'.$value['num'].' where id='.$value['proinfo']['id']);
                          Db::execute('update ims_sudu8_page_products set sale_tnum=sale_tnum-'.$value['num'].' where id='.$value['pvid']);
                        }

//                       
                    }
                    $this->success("取消成功");
                }

                if($op == 'allowth'){
                    $orderid = input('orderid');
                    //微信退款
//                    $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$appletid, "id"=>$order_id), array("price", "order_id", "payprice"));
                    $order=Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("id",$orderid)->find();
                    $now = time();
                    // var_dump($mch_id);exit();
                    $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
//                    pdo_update("sudu8_page_duo_products_order", array("th_orderid"=>$out_refund_no), array("uniacid"=>$uniacid, "id"=>$order_id));

                    Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("id",$orderid)->update(array("th_orderid"=>$out_refund_no));

                    if($order['payprice'] > 0){

                        $app = Db::table('applet')->where("id",$appletid)->find();
                        $mchid = $app['mchid'];   //商户号
                        $apiKey = $app['signkey'];    //商户的秘钥
                        $appid = $app['appID'];                 //小程序的id
                        $appkey = $app['appSecret'];            //小程序的秘钥
                        // 更新信息
//                        $sqtx = Db::table('ims_sudu8_page_pt_tx')->where("uniacid",$appletid)->where("id",$id)->find();
                        $openid= $order['openid'];    //申请者的openid
                        $outTradeNo =$order['order_id'];
                        $totalFee= intval($order['payprice'] * 100);  //申请了提现多少钱
                        $outRefundNo = $order['order_id']; //商户订单号
                        $refundFee= intval($order['payprice'] * 100);  //申请了提现多少钱
                        $SSLCERT_PATH = ROOT_PATH.'public/Cert/'.$appletid.'/apiclient_cert.pem';//证书路径
                        $SSLKEY_PATH =  ROOT_PATH.'public/Cert/'.$appletid.'/apiclient_key.pem';//证书路径
                        $opUserId = $mchid;//商户号
                        include "WinXinRefund.php";
                        $weixinpay = new WinXinRefund($openid,$outTradeNo,$totalFee,$outRefundNo,$refundFee,$SSLCERT_PATH,$SSLKEY_PATH,$opUserId,$appid,$apiKey);
                        $return = $weixinpay->refund();
                        if(!$return){
                            message('退货失败!请检查系统设置->小程序设置和支付设置');
                        }else{
                            if($order['coupon']){
                            Db::table("ims_sudu8_page_coupon_user")->where("uniacid",$appletid)->where("uid",$order['uid'])->where("id",$order['coupon'])->update(array("flag"=>0,"utime"=>0));
                        }
                        if($order['jf']){
                            Db::execute("update ims_sudu8_page_user set score=score+".$order['jf']." where uniacid=".$appletid." and id=".$order["uid"]);
                            $score_data = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['jf'],
                                "message" => "退款退回抵扣积分",
                                "creattime" => time()
                            );
//                            pdo_insert("sudu8_page_score", $score_data);
                            Db::table("ims_sudu8_page_score")->insert($score_data);
                        }
                        $scoreback=Db::table("ims_sudu8_page_score")->where("uniacid",$appletid)->where("uid",$order['uid'])->where("orderid",$order["order_id"])->where("type","add")->where("message","买送积分")->find();
                        if($scoreback){
                            $e=Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->find();
                            $f=$e["score"]*1-$scoreback['score']*1;
                            Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->update(array("score"=>$f));
                            $score_data2 = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "del",
                                "score" => $scoreback['score'],
                                "message" => "退款扣除买送积分",
                                "creattime" => time()
                            );
                            Db::table("ims_sudu8_page_score")->insert($score_data2);
                        }
                        }

                    }else{
                        Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("th_orderid",$out_refund_no)->update(array("flag"=>8));
                        $order=Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("th_orderid",$out_refund_no)->find();
                         Db::execute("update ims_sudu8_page_user set money=money+".$order['price']." where uniacid=".$appletid." and id=".$order['uid']);
                          //金钱流水
                        if($order['price'] > 0){
                            $xfmoney = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['price'],
                                "message" => "退款退回余额",
                                "creattime" => time()
                            );
                            Db::table("ims_sudu8_page_money")->insert($xfmoney);
                        }

                        
                        if($order['coupon']){
                            Db::table("ims_sudu8_page_coupon_user")->where("uniacid",$appletid)->where("uid",$order['uid'])->where("id",$order['coupon'])->update(array("flag"=>0,"utime"=>0));
                        }
                        if($order['jf']){
                            Db::execute("update ims_sudu8_page_user set score=score+".$order['jf']." where uniacid=".$appletid." and id=".$order["uid"]);
                            $score_data = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "add",
                                "score" => $order['jf'],
                                "message" => "退款退回抵扣积分",
                                "creattime" => time()
                            );
//                            pdo_insert("sudu8_page_score", $score_data);
                            Db::table("ims_sudu8_page_score")->insert($score_data);
                        }
                        $scoreback=Db::table("ims_sudu8_page_score")->where("uniacid",$appletid)->where("uid",$order['uid'])->where("orderid",$order["order_id"])->where("type","add")->where("message","买送积分")->find();
                        if($scoreback){
                            $e=Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->find();
                            $f=$e["score"]*1-$scoreback['score']*1;
                            Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$order['uid'])->update(array("score"=>$f));
                            $score_data2 = array(
                                "uniacid" => $appletid,
                                "orderid" => $order['order_id'],
                                "uid" => $order['uid'],
                                "type" => "del",
                                "score" => $scoreback['score'],
                                "message" => "退款扣除买送积分",
                                "creattime" => time()
                            );
                            Db::table("ims_sudu8_page_score")->insert($score_data2);
                        }

                        $jsondata = unserialize($order['jsondata']);
                        foreach($jsondata as $key => &$value){
                              Db::execute("update ims_sudu8_page_duo_products_type_value set kc=kc+".$value['num']." where id=".$value['proinfo']['id']);
                        }

                    }
                       $this->success("退货成功");
                }


                if($op == 'refuseth'){
                    $orderid = input('orderid');
//                    pdo_update("sudu8_page_duo_products_order", array("flag"=>9), array("uniacid"=>$uniacid, "id"=>$order_id));
                    Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("id",$orderid)->update(array("flag"=>9));
//                    message('拒绝退货成功!', $this->createWebUrl('Orderset', array('opt'=>'fahuosp','op'=>'orderdo','cateid'=>$_GPC['cateid'],'chid'=>$_GPC['chid'])), 'success');
                    $this->success("拒绝退货成功");
                }
//





                // 处理已发货并且过了7天还没有确定的订单
                $clorders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid',$appletid)->where('flag',4)->select();
                foreach ($clorders as $key => &$res) {
                    $st = $res['hxtime'] + 3600*24*7;
                    if($st < time()){
                        $adata = array(
                            "hxtime" => $st,
                            "flag" => 2
                        );
                        Db::table('ims_sudu8_page_duo_products_order')->where('id',$res['id'])->update($adata);
                        // 核销完成后去检测要不要进行分销商返现
                        $order_id = $res['order_id'];
                        $openid = $res['openid'];
                        $fxsorder = Db::table('ims_sudu8_page_fx_ls')->where('uniacid',$appletid)->where('order_id',$order_id)->find();
                        if($fxsorder){
                            $this->dopagegivemoney($appletid,$openid,$order_id);
                        }
                    }
                }

                // 处理30分钟未付款的订单
                $wforders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid',$appletid)->where('flag',0)->select();
                foreach ($wforders as $key => &$res) {
                    $st = $res['creattime'] + 1800;
                    if($st < time()){
                        $adata = array(
                            "flag" => 3
                        );
                        Db::table('ims_sudu8_page_duo_products_order')->where('id',$res['id'])->update($adata);
                        Db::table('ims_sudu8_page_fx_ls')->where('uniacid',$appletid)->where('order_id',$res['order_id'])->update($adata);
                    }
                }
                $order_id = input('order_id');
                if($order_id){
                    $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid',$appletid)->where('order_id','like',"%".$order_id."%")->order('creattime desc')->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"))]);
                    $order = $orders->toArray();
                    foreach ($order['data'] as $key => &$res) {
                        $res['jsondata'] = unserialize($res['jsondata']);
                        foreach ($res['jsondata'] as $key2 => &$reb) {
                            if($reb['proinfo']['thumb']!=null||$reb['proinfo']['thumb']!=""){
                                if(!strstr($reb['proinfo']['thumb'], "http")){
                                    $reb['proinfo']['thumb'] =remote($appletid,$reb['proinfo']['thumb'],1);
                                }
                            }
                            if($reb['baseinfo']['thumb']!=null||$reb['baseinfo']['thumb']!=""){
                                if(!strstr($reb['baseinfo']['thumb'], "http")){
                                    $reb['baseinfo']['thumb'] =remote($appletid,$reb['baseinfo']['thumb'],1);
                                }
                            }
                        }
                        if($res['yhinfo']!=null){
                            $res['yhinfo'] = unserialize($res['yhinfo']);
                            $res['mjinfo']=$res['yhinfo']['mj']['msg'];
                            $res['couponinfo']=$res['yhinfo']['yhq']['msg'];
                            $res['jfinfo']=$res['yhinfo']['score']['msg'];
                            if(isset($res['yhinfo']['yunfei'])){
                            $res['yunfei']=$res['yhinfo']['yunfei'];
                            }else{
                                $res['yunfei']=0;
                            }

                        }else{
                            if($res['coupon']!=0&&$res['coupon']!=null){
                                $coupon =  Db::table('ims_sudu8_page_coupon_user')->where('uniacid',$appletid)->where('id',$res['coupon'])->find();
                                $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid',$appletid)->where('id',$coupon['cid'])->find();
                                $res['couponinfo'] = "满".floatval($couponinfo['pay_money'])."减".floatval($couponinfo['price']);
                            }else{
                                $res['couponinfo']="未使用优惠券";
                            }
                            $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid',$appletid)->find();
                            if(!$jf_gz){
                                $gzscore = 10000;
                                $gzmoney = 1;
                            }else{
                                $gzscore = $jf_gz['score'];
                                $gzmoney = $jf_gz['money'];
                            }
                            if($res['jf'] == 0 && $gzmoney == 0 && $gzscore == 0){
                                $res['jfmoney'] = 0;
                                $res['jfinfo']="未使用积分";
                            }else{
                                $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;
                                $res['jfinfo']=$res['jf']."抵".$res['jf']*$gzmoney/$gzscore;
                            }
                            $res['yunfei']=0;
                            $res['mjinfo']=null;
                        }

                        $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                        $res['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid',$appletid)->where('openid',$res['openid'])->find();
                        $res['counts'] = count($res['jsondata']);
//                        $coupon =  Db::table('ims_sudu8_page_coupon_user')->where('uniacid',$appletid)->where('id',$res['coupon'])->find();
//                        $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid',$appletid)->where('id',$coupon['cid'])->find();
//                        $res['couponinfo'] = $couponinfo;
                        // 重新算总价
                        $allprice = 0;
                        foreach ($res['jsondata'] as $key2 => &$reb) {
                            $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                        }
                        $res['allprice'] = $allprice;
                        // 积分转钱
                        //积分转换成金钱
//                        $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid',$appletid)->find();
//                        if(!$jf_gz){
//                            $gzscore = 10000;
//                            $gzmoney = 1;
//                        }else{
//                            $gzscore = $jf_gz['score'];
//                            $gzmoney = $jf_gz['money'];
//                        }
//                        $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;
                        // 转换地址
                        if($res['address']!=0){
                            $res['address_get'] = Db::table('ims_sudu8_page_duo_products_address')->where('openid',$res['openid'])->where('id',$res['address'])->find();
                        }else{
                            $res['address_get'] = unserialize($res['m_address']);
                            if(!isset($res['address_get']['name'])){
                                $res['address_get']['name'] = "";
                            }
                            if(!isset($res['address_get']['mobile'])){
                                $res['address_get']['mobile'] = "";
                            }
                            if(!isset($res['address_get']['address'])){
                                $res['address_get']['address'] = "";
                            }

                            if(!isset($res['address_get']['postalcode'])){
                                $res['address_get']['postalcode'] = "";
                            }
                            if(!isset($res['address_get']['more_address'])){
                                $res['address_get']['more_address'] = "";
                            }

                        }

                        if($res['hxinfo'] == ""){

                           $res['hxinfo2']="暂无核销信息";

                        }else{

                            $res['hxinfo'] = unserialize($res['hxinfo']);

                             if($res['hxinfo'][0]==1){

                                 $res['hxinfo2']="系统核销";

                             }else{

                                $store=Db::table('ims_sudu8_page_store')->where("id",$res['hxinfo'][1])->where("uniacid",$appletid)->find();

                                $staff=Db::table('ims_sudu8_page_staff')->where("id",$res['hxinfo'][2])->where("uniacid",$appletid)->find();

                                $res['hxinfo2']="门店：".$store['title']."</br>员工：".$staff['realname'];

                             }

                        }
                    }
                }else{
                    $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid',$appletid)->order('creattime desc')->paginate(10,false,[ 'query' => array('appletid'=>input("appletid"))]);
                    $order = $orders->toArray();
                    foreach ($order['data'] as $key => &$res) {
                        $res['jsondata'] = unserialize($res['jsondata']);
//                        var_dump($res['jsondata']);
//                        exit();
                        foreach ($res['jsondata'] as $key2 => &$reb) {
                            if($reb['proinfo']['thumb']!=null||$reb['proinfo']['thumb']!=""){
                            if(!strstr($reb['proinfo']['thumb'], "http")){
                                $reb['proinfo']['thumb'] =remote($appletid,$reb['proinfo']['thumb'],1);
                            }
                            }
                            if($reb['baseinfo']['thumb']!=null||$reb['baseinfo']['thumb']!=""){
                            if(!strstr($reb['baseinfo']['thumb'], "http")){
                                $reb['baseinfo']['thumb'] =remote($appletid,$reb['baseinfo']['thumb'],1);
                            }
                            }
                        }
                        if($res['yhinfo']!=null&&$res['yhinfo']!=""){
                            $res['yhinfo'] = unserialize($res['yhinfo']);
                            $res['mjinfo']=$res['yhinfo']['mj']['msg'];
                            $res['couponinfo']=$res['yhinfo']['yhq']['msg'];
                            $res['jfinfo']=$res['yhinfo']['score']['msg'];
                            if(isset($res['yhinfo']['yunfei'])){
                                $res['yunfei']=$res['yhinfo']['yunfei'];
                            }else{
                                $res['yunfei']=0;
                            }
                        }else{
                            if($res['coupon']!=0&&$res['coupon']!=null){
                                $coupon =  Db::table('ims_sudu8_page_coupon_user')->where('uniacid',$appletid)->where('id',$res['coupon'])->find();
                                $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid',$appletid)->where('id',$coupon['cid'])->find();
                                $res['couponinfo'] = "满".floatval($couponinfo['pay_money'])."减".floatval($couponinfo['price']);
                            }else{
                                $res['couponinfo']="未使用优惠券";
                            }

                            $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid',$appletid)->find();
                            if(!$jf_gz){
                                $gzscore = 10000;
                                $gzmoney = 1;
                            }else{
                                $gzscore = $jf_gz['score'];
                                $gzmoney = $jf_gz['money'];
                            }
                            if($res['jf'] == 0 && $gzmoney == 0 && $gzscore == 0){
                                $res['jfmoney'] = 0;
                                $res['jfinfo']="未使用积分";
                            }else{
                                $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;
                                $res['jfinfo']=$res['jf']."抵".$res['jf']*$gzmoney/$gzscore;
                            }
                            $res['mjinfo']=null;
                            $res['yunfei']=0;
                        }
//                        var_dump($res['mjinfo']);
//                        exit();
                        $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
                        $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
                        $res['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid',$appletid)->where('openid',$res['openid'])->find();
                        $res['counts'] = count($res['jsondata']);
//
//                        $coupon =  Db::table('ims_sudu8_page_coupon_user')->where('uniacid',$appletid)->where('id',$res['coupon'])->find();
//                        $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid',$appletid)->where('id',$coupon['cid'])->find();
//                        $res['couponinfo'] = $couponinfo;
                        // 重新算总价
                        $allprice = 0;
                        foreach ($res['jsondata'] as $key2 => &$reb) {
                            $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
                            if(!isset($reb['proinfo']['ggz'])){
                                $reb['proinfo']['ggz'] = "";
                            }
                        }
                        $res['allprice'] = $allprice;
                        // 积分转钱
                        //积分转换成金钱
//                        $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid',$appletid)->find();
//                        if(!$jf_gz){
//                            $gzscore = 10000;
//                            $gzmoney = 1;
//                        }else{
//                            $gzscore = $jf_gz['score'];
//                            $gzmoney = $jf_gz['money'];
//                        }
//                        if($res['jf'] == 0 && $gzmoney == 0 && $gzscore == 0){
//                          $res['jfmoney'] = 0;
//                        }else{
//                          $res['jfmoney'] = $res['jf']*$gzmoney/$gzscore;
//                        }
                        // 转换地址
                        if($res['address']!=0){
                            $res['address_get'] = Db::table('ims_sudu8_page_duo_products_address')->where('openid',$res['openid'])->where('id',$res['address'])->find();
                        }else{
                            $res['address_get'] = unserialize($res['m_address']);
                            if(!isset($res['address_get']['name'])){
                                $res['address_get']['name'] = "";
                            }
                            if(!isset($res['address_get']['mobile'])){
                                $res['address_get']['mobile'] = "";
                            }
                            if(!isset($res['address_get']['address'])){
                                $res['address_get']['address'] = "";
                            }

                            if(!isset($res['address_get']['postalcode'])){
                                $res['address_get']['postalcode'] = "";
                            }
                            if(!isset($res['address_get']['more_address'])){
                                $res['address_get']['more_address'] = "";
                            }
                        }
                        if($res['hxinfo'] == ""){

                           $res['hxinfo2']="暂无核销信息";

                        }else{

                            $res['hxinfo'] = unserialize($res['hxinfo']);

                             if($res['hxinfo'][0]==1){

                                 $res['hxinfo2']="系统核销";

                             }else{

                                $store=Db::table('ims_sudu8_page_store')->where("id",$res['hxinfo'][1])->where("uniacid",$appletid)->find();

                                $staff=Db::table('ims_sudu8_page_staff')->where("id",$res['hxinfo'][2])->where("uniacid",$appletid)->find();

                                $res['hxinfo2']="门店：".$store['title']."</br>员工：".$staff['realname'];

                             }

                        }
                    }
                }
                if($order_id){
                    $this->assign('order_id',$order_id);
                }else{
                    $order_id = "";
                    $this->assign('order_id',$order_id);  
                }
//                var_dump($orders[0]);
//                exit();
                $this->assign('order',$order);
                $this->assign('counts',$order['total']);
                $this->assign('orders',$orders);
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
            return $this->fetch('order');
        }else{
            $this->redirect('Login/index');
        }
    }
    public function orderdown(){
        $appletid = input("appletid");
        $res = Db::table('applet')->where("id",$appletid)->find();
        if(!$res){
            $this->error("找不到对应的小程序！");
        }
        $this->assign('applet',$res); 
        $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid',$appletid)->order('creattime desc')->select();
        foreach ($orders as $key => &$res) {
            $res['jsondata'] = unserialize($res['jsondata']);
            $res['creattime'] = date("Y-m-d H:i:s",$res['creattime']);
            $res['hxtime'] = $res['hxtime'] == 0?"未核销":date("Y-m-d H:i:s",$res['hxtime']);
            $res['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid',$appletid)->where('openid',$res['openid'])->find();
            // 重新算总价
            $allprice = 0;
            foreach ($res['jsondata'] as $key2 => &$reb) {
                $allprice += ($reb['num']*1)*($reb['proinfo']['price']);
            }
            $res['allprice'] = $allprice;
            // 转换地址
            if($res['address']!=0){
                $res['address_get'] = Db::table('ims_sudu8_page_duo_products_address')->where('openid',$res['openid'])->where('id',$res['address'])->find();
            }else{
                $res['address_get'] = unserialize($res['m_address']);
            }
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
        $objPHPExcel->getActiveSheet()->setCellValue('I1', '核销/快递时间');
        $objPHPExcel->getActiveSheet()->setCellValue('J1', '快递信息');
        $objPHPExcel->getActiveSheet()->setCellValue('K1', '状态');
        $objPHPExcel->getActiveSheet()->setCellValue('L1', '下单时间');
        $objPHPExcel->getActiveSheet()->setCellValue('M1', '地址信息');
        $objPHPExcel->getActiveSheet()->setCellValue('N1', '小程序uniacid');
        foreach($orders as $k => $v){
            $num=$k+2;
            $objPHPExcel->getActiveSheet()->setCellValueExplicit('A'.$num, $v['order_id'],'s');
            $thumb = "";
            $proname = "";
            $proprice = "";
            $catename = "";
            if($v['jsondata']){
                foreach ($v['jsondata'] as $ki => &$vi) {
                    $thumb .= $vi['baseinfo']['thumb']."  ";
                    $proname .= $vi['baseinfo']['title']."-".$vi['proinfo']['ggz']."  ";
                    $proprice .= $vi['proinfo']['price']."*".$vi['num']."  ";
                    $catename .= Db::table("ims_sudu8_page_cate")->alias('a')->join("ims_sudu8_page_products b","b.cid = a.id")->where("b.id",$vi['pvid'])->field('a.name')->find()['name']."   ";
                }
            }
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$num, $thumb);
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$num, $proname);
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$num, $catename);
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$num, $proprice);
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$num, $v['price']);
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$num, $v['userinfo']['realname']);
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$num, $v['userinfo']['mobile']);
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$num, $v['hxtime']);
            if($v['kuadi']){
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$num, $v['kuadi'].":".$v['kuaidihao']);
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('J'.$num," ");
            }
            if($v['flag']==0){
                $flag = "未支付";
            }
            if($v['flag']==1 && $v['nav'] == 2){
                $flag = "到店提货";
            }
            if($v['flag']==1 && $v['nav'] == 1){
                $flag = "立即发货";
            }
            if($v['flag']==2){
                $flag = "已完成";
            }
            if($v['flag']==3){
                $flag = "已过期";
            }
            if($v['flag']==4){
                $flag = "已发货";
            }
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$num, $flag);
            
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$num, $v['creattime']);
            if($v['address_get']){
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$num, $v['address_get']['name'].",".$v['address_get']['mobile'].",".$v['address_get']['address'].",".$v['address_get']['more_address']);
            }else{
                $objPHPExcel->getActiveSheet()->setCellValue('M'.$num, "");
            }
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$num, $v['uniacid']);
        }
        $objPHPExcel->getActiveSheet()->setTitle('导出订单列表');
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="多规格订单列表.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
        // 向我的上级返钱操作
    public function dopagegivemoney($uniacid,$openid,$orderid){
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where('uniacid',$uniacid)->order('creattime desc')->find();
        $order = Db::table('ims_sudu8_page_fx_ls')->where('uniacid',$uniacid)->where('order_id',$orderid)->find();
        Db::table('ims_sudu8_page_fx_ls')->where('order_id',$orderid)->update(array("flag"=>2));
        $me = Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['openid'])->find();
        $me_p_get_money = $me['p_get_money'];
        $me_p_p_get_money = $me['p_p_get_money'];
        $me_p_p_p_get_money = $me['p_p_p_get_money'];
        // 启动一级分销提成
        if($guiz['fx_cj'] == 1){
            if($order['parent_id']){
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['parent_id'])->update($kdata);
                // 我给我的父级贡献的钱
                $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;  
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['openid'])->update(array("p_get_money" => $new_p_get_money));
            }
        }
        // 启动二级分销提成
        if($guiz['fx_cj'] == 2){
            if($order['parent_id']){
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['parent_id'])->update($kdata);
                // 我给我的父级贡献的钱
                $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['openid'])->update(array("p_get_money" => $new_p_get_money));
            }
            if($order['p_parent_id']){
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['p_parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['p_parent_id'])->update($kdata);
                // 我给我的父级的父级贡献的钱
                $new_p_p_get_money = $me_p_p_get_money*1 + $order['p_parent_id_get']*1;
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['openid'])->update(array("p_p_get_money" => $new_p_p_get_money));
            }
        }
        // 启动三级分销提成
        if($guiz['fx_cj'] == 3){
            if($order['parent_id']){
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['parent_id'])->update($kdata);
                // 我给我的父级贡献的钱
                $new_p_get_money = $me_p_get_money*1 + $order['parent_id_get']*1;
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['openid'])->update(array("p_get_money" => $new_p_get_money));
            }
            if($order['p_parent_id']){
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['p_parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['p_parent_id'])->update($kdata);
                // 我给我的父级的父级贡献的钱
                $new_p_p_get_money = $me_p_p_get_money*1 + $order['p_parent_id_get']*1;
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['openid'])->update(array("p_p_get_money" => $new_p_p_get_money));
            }
            if($order['p_p_parent_id']){
                $puser =  Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['p_p_parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['p_p_parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['p_p_parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['p_p_parent_id'])->update($kdata);
                // 我给我的父级的父级的附近贡献的钱
                $new_p_p_p_get_money = $me_p_p_p_get_money*1 + $order['p_p_parent_id_get']*1;
                Db::table('ims_sudu8_page_user')->where('uniacid',$uniacid)->where('openid',$order['openid'])->update(array("p_p_p_get_money" => $new_p_p_p_get_money));
            }
        }
    }
    //图片上传
    function imgup(){
    	$picname = $_FILES['uploadfile']['name']; 
        $picsize = $_FILES['uploadfile']['size']; 
        if ($picname != "") { 
            if ($picsize > 10240000) { //限制上传大小 
                echo '{"status":0,"content":"图片大小不能超过2M"}';
                exit; 
            } 
            $type = strstr($picname, '.'); //限制上传格式 
            if ($type != ".gif" && $type != ".jpg" && $type != ".png") {
                echo '{"status":2,"content":"图片格式不对！"}';
                exit; 
            }
            $rand = rand(100, 999); 
            $pics = uniqid() . $type; //命名图片名称 
            //上传路径 
            $pic_path = ROOT_HOST."/upimages/".date("Ymd",time())."/". $pics; 
            move_uploaded_file($_FILES['uploadfile']['tmp_name'], $pic_path); 
        } 
        $size = round($picsize/1024,2); //转换成kb 
        echo '{"status":1,"name":"'.$picname.'","url":"'.$pic_path.'","size":"'.$size.'","content":"上传成功"}'; 
    }
 
    //单个图片上传操作
    function onepic_uploade($file){
        $thumb = request()->file($file);
        if(isset($thumb)){
            $dir = upload_img();
            $info = $thumb->validate(['ext'=>'jpg,png,gif,jpeg'])->move($dir); 
            if($info){  
                $imgurl = ROOT_HOST."/upimages/".date("Ymd",time())."/".$info->getFilename();
                return $imgurl;
            }  
        }
    }
        //多图片上传
    public function imgupload_duo(){
        $data['randid'] = input('randid');
        $files = request()->file('');    
        foreach($files as $file){        
            // 移动到框架应用根目录/public/upimages/ 目录下        
            $info = $file->validate(['ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
           if($info){
                $data['url'] =  ROOT_HOST."/upimages/".date("Ymd",time())."/".$info->getFilename();
                $data['dateline'] = time();
                $res = Db::table('products_url')->insert($data);
            }else{
                // 上传失败获取错误信息
                return $this->error($file->getError()) ;
            }    
        }
    }
    //上传成功后获取图片
    public function getimg(){
        $id = $_POST['id'];     
        $allimg = Db::table('products_url')->where("randid",$id)->select();
        if($allimg){
            return $allimg;
        }
    }
    public function del_img(){
        $id = input("id");
        $res = Db::table('products_url')->where('id', $id)->delete();
        if($res){
            return 1;
        }else{
            $this->error("删除失败！");
        }
    }
    //规格图片上传
    public function imgupload(){
        $uniacid = input("uniacid");
        $remote = Db::table("ims_sudu8_page_base")->where("uniacid",$uniacid)->field("remote")->find()['remote'];
        if(!$remote){
            $remote = 1;
        }
        $groupid = 0;
        if($remote == 1){
            $files = request()->file('');  
            foreach($files as $file){        
                // 移动到框架应用根目录/public/upimages/ 目录下        
                $info = $file->validate(['ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
                if($info){
                    $url =  "/upimages/".date("Ymd",time())."/".$info->getFilename();
                    $arr = array("url"=>$url);
                    return json_encode($arr);
                }else{
                    // 上传失败获取错误信息
                    return $this->error($file->getError()) ;
                }    
            }
        }else if($remote == 2){
            $qiniu_info = Db::table("ims_sudu8_page_remote")->where("type",2)->where("uniacid",$uniacid)->find();
            $file = $_FILES['uploadfile']['tmp_name'];
            $is_img = getimagesize($file);
            if($is_img){
            }
            $oringal_name = $_FILES['uploadfile']['name'];
           
            $pathinfo = pathinfo($oringal_name);
            // var_dump($pathinfo);exit;
            // 要上传图片的本地路径
            $ext = $pathinfo['extension'];
            $key = 'upimages/'.md5(uniqid(microtime(true),true)).'.'.$ext;
            
            // 需要填写你的 Access Key 和 Secret Key
            $accessKey = $qiniu_info['ak'];
            $secretKey = $qiniu_info['sk'];
            // 构建鉴权对象
            $auth = new Auth($accessKey, $secretKey);
            // 要上传的空间
            $bucket = $qiniu_info['bucket'];
            $domain = $qiniu_info['domain'];
            $token = $auth->uploadToken($bucket);
            // 初始化 UploadManager 对象并进行文件的上传
            $uploadMgr = new UploadManager();
            // 调用 UploadManager 的 putFile 方法进行文件的上传
            list($ret, $err) = $uploadMgr->putFile($token, $key, $file);
            if ($err !== null) {
                echo ["err"=>1,"msg"=>$err,"data"=>""];
            } else {
                $arr = array("url"=>$qiniu_info['domain'].'/'.$ret['key']);
                return json_encode($arr);
            }
        }
    }
}