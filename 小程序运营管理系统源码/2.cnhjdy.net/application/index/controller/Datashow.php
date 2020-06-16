<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Datashow extends Base
{
    public function index(){
        if(check_login()){
            $cytable = 'cytable.php';
            $cyt = include($cytable);
            $filename = __DIR__.'/file.txt';
            if(file_exists($filename)){
            }else{
                $wxapps = Db::table('ims_sudu8_page_wxapps')->select();
                foreach ($wxapps  as $k => $v) {
                    $cid = Db::table('ims_sudu8_page_cate')->where('id',$v['cid'])->find();
                    if($cid['cid'] != $v['pcid']){
                        Db::table('ims_sudu8_page_wxapps')->where('id',$v['id'])->update(array('pcid'=>$cid['cid']));
                    }
                    if($cid['cid'] == 0){
                        Db::table('ims_sudu8_page_wxapps')->where('id',$v['id'])->update(array('pcid'=>$v['cid']));
                    }
                }
                $pro = Db::table('ims_sudu8_page_products')->select();
                foreach ($pro  as $k => $v) {
                    $cid = Db::table('ims_sudu8_page_cate')->where('id',$v['cid'])->find();
                    if($cid['cid'] != $v['pcid']){
                        Db::table('ims_sudu8_page_products')->where('id',$v['id'])->update(array('pcid'=>$cid['cid']));
                    }
                    if($cid['cid'] == 0){
                        Db::table('ims_sudu8_page_products')->where('id',$v['id'])->update(array('pcid'=>$v['cid']));
                    }
                }
                $isf = fopen(__DIR__."/file.txt", "w");
            }
            $base_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_base");
            if(count($base_01)<54){
                Db::query("ALTER table ims_sudu8_page_base ADD slide varchar(2000)");
            }   
            Db::query("ALTER TABLE `ims_sudu8_page_products` CHANGE `sale_num` `sale_num` INT(11) NULL DEFAULT '0'");
            $base_02 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_base");
            if(count($base_02)<56){
                Db::query("ALTER table ims_sudu8_page_base ADD hxmm varchar(255)");
                Db::query("ALTER table ims_sudu8_page_base ADD logo2 varchar(255)");
                Db::query("ALTER table ims_sudu8_page_base ADD sharejf varchar(255)");
            }
            $base_03 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_base");
            if(count($base_03)<59){
                Db::query("ALTER table ims_sudu8_page_base ADD sharetype int(1)");
                Db::query("ALTER table ims_sudu8_page_base ADD sharexz int(11)");
            }
            $base_04 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_base");
            if(count($base_04)<61){
                Db::query("ALTER table ims_sudu8_page_base ADD score_shoppay int(11)");
                Db::query("ALTER table ims_sudu8_page_base ADD spcatename varchar(255)");
                Db::query("ALTER table ims_sudu8_page_base ADD spcatenameen varchar(255)");
                Db::query("ALTER table ims_sudu8_page_base ADD sp_i_b_y_ts int(1)");
            }
            $base_05 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_base");
            if(count($base_05)<65){
                Db::query("ALTER table ims_sudu8_page_base ADD  sptj_max int(11) NOT NULL DEFAULT '10'");
                Db::query("ALTER table ims_sudu8_page_base ADD  sptj_max_sp int(11) NOT NULL DEFAULT '10'");
            }
            $base_06 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_base");
            if(count($base_06)<67){
                Db::query("ALTER table ims_sudu8_page_base ADD  gonggao varchar(255) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_base ADD  gonggaoUrl varchar(255) NOT NULL");
            }
            $base_07 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_base");
            if(count($base_07)<69){
                Db::query("ALTER table ims_sudu8_page_base ADD  tabbar_new text NOT NULL");
                Db::query("ALTER table ims_sudu8_page_base ADD  tabnum_new int(1) NOT NULL");
            }
            $base_08 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_base");
            if(count($base_08)<71){
                Db::query("ALTER table ims_sudu8_page_base ADD  homepage int(1)  NOT NULL DEFAULT '1'");
            }
            $base_09 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_base");
            if(count($base_09)<72){
                Db::query("ALTER table ims_sudu8_page_base ADD  duomerchants int(1)  NOT NULL DEFAULT '2'");
                Db::query("ALTER table ims_sudu8_page_base ADD  remote int(1)  NOT NULL DEFAULT '1'");
            }
            $diypageset_1 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_diypageset");
            if(count($diypageset_1)<14){
                Db::query("ALTER table ims_sudu8_page_diypageset ADD pid int(11)  NOT NULL");
            }
            $diypagetpl_1 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_diypagetpl");
            if(count($diypagetpl_1)<7){
                Db::query("ALTER table ims_sudu8_page_diypagetpl ADD status int(1) NOT NULL DEFAULT '2'");
            }
            Db::query('ALTER TABLE `ims_sudu8_page_base` CHANGE `sharexz` `sharexz` INT(11) NULL DEFAULT NULL;');
            Db::query("ALTER TABLE `ims_sudu8_page_base` CHANGE `sp_i_b_y_ts` `sp_i_b_y_ts` INT(1) NOT NULL DEFAULT '0'");
            Db::query("ALTER TABLE `ims_sudu8_page_usercenter_set` CHANGE `usercenterset` `usercenterset` varchar(5000) NOT NULL");
            $applet_01 = Db::query("SHOW COLUMNS FROM applet");
            if(count($applet_01)<13){
                Db::query("ALTER table applet ADD xcxId varchar(255)");
            }
            $formlet = Db::table('ims_sudu8_page_formt')->where("val",5)->find();
            if($formlet['flag']!=1){
                Db::table('ims_sudu8_page_formt')->where("val",5)->update(array('flag'=>1));
            }
            $formlets = Db::table('ims_sudu8_page_formt')->where("val",1)->find();
            if($formlets['flag']!=1){
                Db::table('ims_sudu8_page_formt')->where("val",1)->update(array('flag'=>1));
                Db::table('ims_sudu8_page_formt')->insert(array('name'=>"可独占选项",'val'=>14,'flag'=>1));
            }
            // 180302
            $fordersj_count = Db::query("SHOW COLUMNS FROM ims_sudu8_page_food_sj");
            if(count($fordersj_count)<14){
                Db::query("ALTER table ims_sudu8_page_food_sj ADD phone varchar(15)");
                Db::query("ALTER table ims_sudu8_page_food_sj ADD address varchar(100)");
                Db::query("ALTER table ims_sudu8_page_food_sj ADD tags varchar(100)");
                Db::query("ALTER table ims_sudu8_page_food_sj ADD notice varchar(200)");
            }
            $foodorder_count = Db::query("SHOW COLUMNS FROM ims_sudu8_page_food_order");
            if(count($foodorder_count)<15){
                Db::query("ALTER table ims_sudu8_page_food_order ADD zh varchar(255)");
            }
            $store_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_store");
            if(count($store_01)<18){
                Db::query("ALTER table ims_sudu8_page_store ADD province varchar(255)");
                Db::query("ALTER table ims_sudu8_page_store ADD city varchar(255)");
                Db::query("ALTER table ims_sudu8_page_store ADD proid int(10)");
                Db::query("ALTER table ims_sudu8_page_store ADD cityid int(10)");
            }
            $store_02 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_store");
            if(count($store_02)<22){
                Db::query("ALTER table ims_sudu8_page_store ADD desc2 text NOT NULL");
            }
            $store_03 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_store");
            if(count($store_03)<23){
                Db::query("ALTER table ims_sudu8_page_store ADD staff varchar(1000) COMMENT '员工'");
            }
            $duoProOrder_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_duo_products_order");
            if(count($duoProOrder_01)<19){
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD formid int(11) DEFAULT NULL");
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD qxbeizhu varchar(255) DEFAULT NULL");
            }
            $duoProOrder_02 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_duo_products_order");
            if(count($duoProOrder_02)<21){
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD sid int(11) DEFAULT 0");
            }
            $duoProOrder_03 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_duo_products_order");
            if(count($duoProOrder_03)<22){
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD prepayid varchar(255) DEFAULT NULL COMMENT '模板消息id'");
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD kuaidi_th varchar(255) DEFAULT NULL COMMENT '退货快递'");
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD kuaidihao_th varchar(255) DEFAULT NULL COMMENT '退货快递号'");
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD th_orderid varchar(255) DEFAULT NULL COMMENT '退货订单号'");
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD payprice float DEFAULT NULL COMMENT '微信支付金额'");
            }
            $duoProOrder_04 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_duo_products_order");
            if(count($duoProOrder_04)<27){
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD hxinfo varchar(255) DEFAULT NULL");
            }
            $products_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_01)<49){
                Db::query("ALTER table ims_sudu8_page_products ADD share_type int(1)");
                Db::query("ALTER table ims_sudu8_page_products ADD share_score varchar(255)");
                Db::query("ALTER table ims_sudu8_page_products ADD share_num int(11)");
                Db::query("ALTER table ims_sudu8_page_products ADD share_gz int(1)");
                Db::query("ALTER table ims_sudu8_page_products ADD comment int(1)");
            }
            $products_02 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_02)<54){
                Db::query("ALTER table ims_sudu8_page_products ADD multi int(1) NOT NULL DEFAULT 1");
            }
            $products_03 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_03)<55){
                Db::query("ALTER table ims_sudu8_page_products ADD types int(1) NOT NULL DEFAULT 1");
            }
            $products_04 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_04)<56){
                Db::query("ALTER table ims_sudu8_page_products ADD top_catas varchar(255) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_products ADD sons_catas varchar(255) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_products ADD mulitcataid int(5) NOT NULL DEFAULT 1");
            }
            $products_05 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_05)<59){
                Db::query("ALTER table ims_sudu8_page_products ADD get_share_gz int(11) NOT NULL DEFAULT '2'");
                Db::query("ALTER table ims_sudu8_page_products ADD get_share_score int(11) NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_products ADD get_share_num int(11) NOT NULL DEFAULT '0'");
            }
            $products_06 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_06)<62){
                Db::query("ALTER table ims_sudu8_page_products ADD `shareimg` varchar(255) NOT NULL");
            }
            $products_07 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_07)<63){
                Db::query("ALTER table ims_sudu8_page_products ADD `glnews` text NOT NULL");
            }
            $products_08 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_08)<64){
                Db::query("ALTER table ims_sudu8_page_products ADD `kuaidi` int(1) NOT NULL DEFAULT '0'");
            }
            $products_09 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_09)<65){
                Db::query("ALTER table ims_sudu8_page_products ADD `edittime` int(11) NOT NULL");
            }
            $products_10 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_10)<66){
                Db::query("ALTER table ims_sudu8_page_products ADD `sale_end_time` int(11) NOT NULL DEFAULT '0'");
            }
            $products_11 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if(count($products_11)<67){
                Db::query("ALTER table ims_sudu8_page_products ADD `fx_uni` int(1) NOT NULL DEFAULT '2'");
                Db::query("ALTER table ims_sudu8_page_products ADD `scoreback` varchar(255) NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_products ADD `commission_type` int(1) NOT NULL DEFAULT '1'");
                Db::query("ALTER table ims_sudu8_page_products ADD `commission_one` float NULL");
                Db::query("ALTER table ims_sudu8_page_products ADD `commission_two` float NULL");
                Db::query("ALTER table ims_sudu8_page_products ADD `commission_three` float NULL");
            }
            $products_12 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if (count($products_12) < 73) {
                Db::query("ALTER table ims_sudu8_page_products ADD music_art_info varchar(3000) NULL DEFAULT NULL");
            }
            $products_13 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if (count($products_13) < 74) {
                Db::query("ALTER table ims_sudu8_page_products ADD stores varchar(255) NULL DEFAULT NULL");
            }
            $products_14 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if (count($products_14) < 75) {
                Db::query("ALTER table ims_sudu8_page_products ADD con2 varchar(5000) NULL DEFAULT NULL");
                Db::query("ALTER table ims_sudu8_page_products ADD con3 varchar(5000) NULL DEFAULT NULL");
            }
            $storeconf_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_storeconf");
            if(count($storeconf_01)<7){
                Db::query("ALTER table ims_sudu8_page_storeconf ADD title varchar(255) NOT NULL");
            }
            $food_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_food");
            if(count($food_01)<18){
                Db::query("ALTER table ims_sudu8_page_food ADD unit char(10) NOT NULL");
            }
            $user_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_user");
            if(count($user_01)<43){
                Db::query("ALTER table ims_sudu8_page_user ADD p_p_parent_id varchar(1000) NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_user ADD p_parent_id varchar(1000) NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_user ADD parent_id varchar(1000) NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_user ADD fxs int(1) NOT NULL DEFAULT '1'");
                Db::query("ALTER table ims_sudu8_page_user ADD fxstime int(11) NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_user ADD fx_allmoney float NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_user ADD fx_getmoney float NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_user ADD fx_money float NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_user ADD p_get_money float NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_user ADD p_p_get_money float NOT NULL DEFAULT '0'");
                Db::query("ALTER table ims_sudu8_page_user ADD p_p_p_get_money float NOT NULL DEFAULT '0'");
            }
            $user_02 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_user");
            if(count($user_02)<54){
                Db::query("ALTER table ims_sudu8_page_user ADD ewm varchar(255) NOT NULL");
            }
            $user_03 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_user");
            if(count($user_03)<55){
                Db::query("ALTER table ims_sudu8_page_user ADD birth varchar(255) DEFAULT NULL");
                Db::query("ALTER table ims_sudu8_page_user ADD vipid varchar(255) DEFAULT NULL");
                Db::query("ALTER table ims_sudu8_page_user ADD vipcreatetime varchar(255) DEFAULT NULL");
            }
            Db::query("ALTER TABLE `ims_sudu8_page_user` CHANGE `money` `money` FLOAT NOT NULL DEFAULT '0'");
            Db::query("ALTER TABLE `ims_sudu8_page_user` CHANGE `score` `score` FLOAT NOT NULL DEFAULT '0'");
            $fxgz_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_fx_gz");
            if(count($fxgz_01)<12){
                Db::query("ALTER table ims_sudu8_page_fx_gz ADD fxs_name varchar(255) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_fx_gz ADD certtext varchar(2000) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_fx_gz ADD keytext varchar(2000) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_fx_gz ADD catext varchar(2000) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_fx_gz ADD thumb varchar(255) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_fx_gz ADD sq_thumb varchar(255) NOT NULL");
            }
            $multicate_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_multicate");
            if(count($multicate_01)<19){
                Db::query("ALTER table ims_sudu8_page_multicate ADD top_catas varchar(255) NOT NULL");
            }
            $duo_products_yunfei_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_duo_products_yunfei");
            if(count($duo_products_yunfei_01)<5){
                Db::query("ALTER table ims_sudu8_page_duo_products_yunfei ADD formset int(11) NOT NULL DEFAULT '0'");
            }
            $page_cate_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_cate");
            if(count($page_cate_01)<22){
                Db::query("ALTER table ims_sudu8_page_cate ADD `list_style_more` int(1) NOT NULL DEFAULT '1'");
            }
            $page_cate_02 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_cate");
            if(count($page_cate_02)<23){
                Db::query("ALTER table ims_sudu8_page_cate ADD `slide_is` int(1) NOT NULL DEFAULT '2'");
            }
            $page_cate_03 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_cate");
            if(count($page_cate_03)<24){
                Db::query("ALTER table ims_sudu8_page_cate ADD `pic_page_bg` int(1) NOT NULL DEFAULT '0'");
            }
            $page_cate_04 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_cate");
            if(count($page_cate_04)<25){
                Db::query("ALTER table ims_sudu8_page_cate ADD `pagenum` int(11) NOT NULL DEFAULT '10'");
            }
            $pt_pro_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_pro");
            if(count($pt_pro_01)<23){
                Db::query("ALTER table ims_sudu8_page_pt_pro ADD `tz_yh` int(11) NOT NULL DEFAULT '10'");
            }
            $pt_pro_02 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_pro");
            if(count($pt_pro_02)<24){
                Db::query("ALTER table ims_sudu8_page_pt_pro ADD `shareimg` varchar(255) NOT NULL");
            }
            $pt_pro_03 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_pro");
            if(count($pt_pro_03)<25){
                Db::query("ALTER table ims_sudu8_page_pt_pro ADD `kuaidi` int(1) NOT NULL DEFAULT '0'");
            }
            $pt_pro_val_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_pro_val");
            if(count($pt_pro_val_01)<11){
                Db::query("ALTER table ims_sudu8_page_pt_pro_val ADD `updatetime` int(11) NOT NULL");
            }
            $products_type_value_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_duo_products_type_value");
            if(count($products_type_value_01)<11){
                Db::query("ALTER table ims_sudu8_page_duo_products_type_value ADD `updatetime` int(11) NOT NULL");
            }
            $products_type_value_02 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_duo_products_type_value");
            if(count($products_type_value_02)<12){
                Db::query("ALTER table ims_sudu8_page_duo_products_type_value ADD `salenum` int(11) NOT NULL");
            }
            $rechargeconf_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_rechargeconf");
            if(count($rechargeconf_01)<6){
                Db::query("ALTER table ims_sudu8_page_rechargeconf ADD `score_shoppay` int(11) NOT NULL DEFAULT '0'");
            }
            $score_get_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pro_score_get");
            if(count($score_get_01)<8){
                Db::query("ALTER table ims_sudu8_page_pro_score_get ADD `clickopenid` varchar(255) NOT NULL");
            }
            //20180920  修改rule表微论坛为微同城
            $is_rule_name = Db::table('rule')->where("name", '微论坛')->find();
            if($is_rule_name){
                Db::table('rule')->where("id", $is_rule_name['id'])->update(array('name' => '微同城'));
            }

            //20181015  拼团功能修改
            $pt_share_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_share");
            if(count($pt_share_01)<10){
                Db::query("ALTER table ims_sudu8_page_pt_share ADD `pt_min` int(11) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_pt_share ADD `pt_max` int(11) NOT NULL");
            }
            
            $pt_order_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_order");
            if(count($pt_order_01)<25){
                Db::query("ALTER table ims_sudu8_page_pt_order ADD `yue_price` float NOT NULL");
                Db::query("ALTER table ims_sudu8_page_pt_order ADD `wx_price` float NOT NULL");
            }

            //20181023   秒杀,多规格商品版本大更新
            $vip_config_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_vip_config");
            if(count($vip_config_01)<13){
                Db::query("ALTER table ims_sudu8_page_vip_config ADD `miaosha` int(1) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_vip_config ADD `duo` int(1) NOT NULL");
                Db::query("ALTER table ims_sudu8_page_vip_config ADD `yuyue` int(1) NOT NULL");
            }

            $products_15 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if (count($products_15) < 77) {
                Db::query("ALTER table ims_sudu8_page_products ADD `vipconfig` varchar(255) NULL DEFAULT NULL");
            }

            $duoProOrder_05 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_duo_products_order");
            if(count($duoProOrder_05)<29){
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD yhinfo varchar(255) DEFAULT NULL");
                Db::query("ALTER table ims_sudu8_page_duo_products_order ADD qx_formid varchar(255) DEFAULT NULL");
            }

            $proOrder_01 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_order");
            if(count($proOrder_01)<45){
                Db::query("ALTER table ims_sudu8_page_order ADD yhinfo varchar(255) DEFAULT NULL");
            }

            $products_type_value_03 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_duo_products_type_value");
            if(count($products_type_value_03)<13){
                Db::query("ALTER table ims_sudu8_page_duo_products_type_value ADD `vsalenum` int(11) NOT NULL DEFAULT '0'");
            }

            $is_rule_name_01 = Db::table('rule')->where("name", '申请记录')->find();
            if($is_rule_name_01){
                Db::table('rule')->where("id", $is_rule_name_01['id'])->update(array('pid' => '24'));
            }

            //2018-10-24
            $vip_config_02 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_vip_config");
            if(count($vip_config_02)<14){
                Db::query("ALTER table ims_sudu8_page_vip_config ADD `pt` int(1) NOT NULL");
            }

            $pt_pro_04 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_pro");
            if (count($pt_pro_04) < 27) {
                Db::query("ALTER table ims_sudu8_page_pt_pro ADD `vipconfig` varchar(255) NULL DEFAULT NULL");
            }

            //2018-11-02 
           

            Db::query("alter table admin modify column lastloginip varchar(20)");

            //2018-11-03
            $products_16 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_products");
            if (count($products_16) < 78) {
                Db::query("ALTER table ims_sudu8_page_products ADD `is_sale` int(2) NOT NULL DEFAULT '0'");
            }

            $pt_pro_05 = Db::query("SHOW COLUMNS FROM ims_sudu8_page_pt_pro");
            if (count($pt_pro_05) < 28) {
                Db::query("ALTER table ims_sudu8_page_pt_pro ADD `show_pro` int(2) NOT NULL DEFAULT '0'");
            }
            

            if(powerget()){
                $appletid = input("appletid");
                $res = Db::table('applet')->where("id",$appletid)->find();
                if(!$res){
                    $this->error("找不到对应的小程序！");
                }
                $this->assign('applet',$res);
                // $visitNum = pdo_fetchcolumn("SELECT sum(`visit_pv`) FROM ".tablename("wxapp_general_analysis")." WHERE uniacid = :uniacid",array(":uniacid"=>$uniacid));
                $visitNum = 0;
                $this->assign('visitNum',$visitNum);
                $userNum = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->count();
                $this->assign('userNum',$userNum);
                $vipNum = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("vipid","gt",0)->count();
                $this->assign('vipNum',$vipNum);
                $firstDay = strtotime(date('Y-m-01 00:00:00', strtotime(date("Y-m-d"))));
                $lastDay = strtotime(date('Y-m-d 23:59:59', strtotime("$firstDay +1 month -1 day")));
                $birthNum = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("birth",'neq',null)->where("birth",">=",$firstDay)->where("birth","<=",$lastDay)->count();
                $this->assign('birthNum',$birthNum);
                $yue = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->sum("money");
                $yue = sprintf("%.2f", $yue);
                $now = time();
                $tod = date("Y-m-d",time());
                $thirtyDayBefore = strtotime("$tod -30 days");
                $this->assign('yue',$yue);
                $duo_platform_num = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$thirtyDayBefore)->where("creattime","<=",$now)->where("flag","in",[1,2])->count();
                $this->assign("duo_platform_num",$duo_platform_num);
                $duo_platform_money = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$thirtyDayBefore)->where("creattime","<=",$now)->where("flag","in",[1,2])->sum("price");
                $duo_platform_money = sprintf("%.2f", $duo_platform_money);
                $this->assign("duo_platform_money",$duo_platform_money);
                for($i = 6; $i >= 0; $i--){
                    $stt = "$tod -".$i." days";
                    $btime = strtotime(date("Y-m-d 00:00:00", strtotime($stt)));
                    $etime = strtotime(date("Y-m-d 23:59:59", strtotime($stt)));
                    $duo_chart_num[6-$i] = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$btime)->where("creattime","<=",$etime)->where("flag","in",[1,2])->count();
                    $duo_chart_num[6-$i] = $duo_chart_num[6-$i]?$duo_chart_num[6-$i]:0;
                    $duo_chart_money[6-$i] = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$btime)->where("creattime","<=",$etime)->where("flag","in",[1,2])->sum("price");
                    $duo_chart_money[6-$i] = sprintf("%.2f", $duo_chart_money[6-$i]);
                    $last_week_date[6-$i] = date("Ymd",$btime);
                }
                $duo_chart_num_max = max($duo_chart_num)?max($duo_chart_num)+intval(max($duo_chart_num)/3):50;
                $this->assign("duo_chart_num_max",$duo_chart_num_max);
                $duo_chart_money_max = max($duo_chart_money) != 0.00?max($duo_chart_money)+intval(max($duo_chart_money)/10):500;
                $this->assign("duo_chart_money_max",$duo_chart_money_max);
                $duo_chart_num_interval = $duo_chart_num_max/5;
                $this->assign("duo_chart_num_interval",$duo_chart_num_interval);
                $duo_chart_money_interval = $duo_chart_money_max/5;
                $this->assign("duo_chart_money_interval",$duo_chart_money_interval);
                $duo_chart_num = '[' .implode(',', $duo_chart_num). ']';
                $this->assign("duo_chart_num",$duo_chart_num);
                $duo_chart_money = '[' . implode(',', $duo_chart_money) . ']';
                $this->assign("duo_chart_money",$duo_chart_money);
                $last_week_date = '[' . implode(',', $last_week_date) . ']';
                $this->assign("last_week_date",$last_week_date);
                $today = strtotime(date("Y-m-d 00:00:00", time()));
                $today_num = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$today)->where("creattime","<=",$now)->where("flag","in",[1,2])->count();
                $today_num=$today_num?$today_num:0;
                $this->assign("today_num",$today_num);
                $today_money = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$today)->where("creattime","<=",$now)->where("flag","in",[1,2])->sum("price");
                $today_money = sprintf("%.2f", $today_money);
                if(empty($today_money) || $today_money == '0.00') $today_money = 0;
                $this->assign("today_money",$today_money);
                $today_avg = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$today)->where("creattime","<=",$now)->where("flag","in",[1,2])->avg("price");
                $today_avg = sprintf("%.2f", $today_avg);
                if(empty($today_avg) || $today_avg == '0.00') $today_avg = 0;
                $this->assign("today_avg",$today_avg);
                $today_flag0 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$today)->where("creattime","<=",$now)->where("flag",0)->count();
                $today_flag0=$today_flag0?$today_flag0:0;
                $this->assign("today_flag0",$today_flag0);
                $today_flag1 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$today)->where("creattime","<=",$now)->where("flag",1)->count();
                $today_flag1=$today_flag1?$today_flag1:0;
                $this->assign("today_flag1",$today_flag1);
                $today_flag4 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$today)->where("creattime","<=",$now)->where("flag",5)->count();
                $today_flag4=$today_flag4?$today_flag4:0;
                $this->assign("today_flag4",$today_flag4);
                $yes = strtotime(date("Y-m-d 00:00:00", strtotime("$tod -1 day")));
                $yes_end = strtotime(date("Y-m-d 23:59:59", strtotime("$tod -1 day")));
                $yes_num = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$yes)->where("creattime","<=",$yes_end)->where("flag","in",[1,2])->count();
                $yes_num=$yes_num?$yes_num:0;
                $this->assign("yes_num",$yes_num);
                $yes_money = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$yes)->where("creattime","<=",$yes_end)->where("flag","in",[1,2])->sum("price");
                $yes_money = sprintf("%.2f", $yes_money);
                if(empty($yes_money) || $yes_money == '0.00') $yes_money = 0;
                $this->assign("yes_money",$yes_money);
                $yes_avg = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$yes)->where("creattime","<=",$yes_end)->where("flag","in",[1,2])->avg("price");
                $yes_avg = sprintf("%.2f", $yes_avg);
                if(empty($yes_avg) || $yes_avg == '0.00') $yes_avg = 0;
                $this->assign("yes_avg",$yes_avg);
                $yes_flag0 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$yes)->where("creattime","<=",$yes_end)->where("flag",0)->count();
                $yes_flag0=$yes_flag0?$yes_flag0:0;
                $this->assign("yes_flag0",$yes_flag0);
                $yes_flag1 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$yes)->where("creattime","<=",$yes_end)->where("flag",1)->count();
                $yes_flag1=$yes_flag1?$yes_flag1:0;
                $this->assign("yes_flag1",$yes_flag1);
                $yes_flag4 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$yes)->where("creattime","<=",$yes_end)->where("flag",5)->count();
                $yes_flag4=$yes_flag4?$yes_flag4:0;
                $this->assign("yes_flag4",$yes_flag4);
                $week = strtotime(date("Y-m-d 00:00:00", strtotime("$tod -7 days")));
                $week_num = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$week)->where("creattime","<=",$now)->where("flag","in",[1,2])->count();
                $week_num=$week_num?$week_num:0;
                $this->assign('week_num',$week_num);
                $week_money = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$week)->where("creattime","<=",$now)->where("flag","in",[1,2])->sum("price");
                $week_money = sprintf("%.2f", $week_money);
                if(empty($week_money) || $week_money == '0.00') $week_money = 0;
                $this->assign('week_money',$week_money);
                $week_avg = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$week)->where("creattime","<=",$now)->where("flag","in",[1,2])->avg("price");
                $week_avg = sprintf("%.2f", $week_avg);
                if(empty($week_avg) || $week_avg == '0.00') $week_avg = 0;
                $this->assign('week_avg',$week_avg);
                $week_flag0 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$week)->where("creattime","<=",$now)->where("flag",0)->count();
                $week_flag0=$week_flag0?$week_flag0:0;
                $this->assign('week_flag0',$week_flag0);
                $week_flag1 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$week)->where("creattime","<=",$now)->where("flag",1)->count();
                $week_flag1=$week_flag1?$week_flag1:0;
                $this->assign('week_flag1',$week_flag1);
                $week_flag4 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$week)->where("creattime","<=",$now)->where("flag",5)->count();
                $week_flag4=$week_flag4?$week_flag4:0;
                $this->assign('week_flag4',$week_flag4);
                $month = strtotime(date("Y-m-d 00:00:00", strtotime("$tod -30 days")));
                $month_num = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$month)->where("creattime","<=",$now)->where("flag","in",[1,2])->count();
                $month_num=$month_num?$month_num:0;
                $this->assign("month_num",$month_num);
                $month_money = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$month)->where("creattime","<=",$now)->where("flag","in",[1,2])->sum("price");
                $month_money = sprintf("%.2f", $month_money);
                if(empty($month_money) || $month_money == '0.00') $month_money = 0;
                $this->assign("month_money",$month_money);
                $month_avg = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$month)->where("creattime","<=",$now)->where("flag","in",[1,2])->avg("price");
                $month_avg = sprintf("%.2f", $month_avg);
                if(empty($month_avg) || $month_avg == '0.00') $month_avg = 0;
                $this->assign("month_avg",$month_avg);
                $month_flag0 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$month)->where("creattime","<=",$now)->where("flag",0)->count();
                $month_flag0=$month_flag0?$month_flag0:0;
                $this->assign("month_flag0",$month_flag0);
                $month_flag1 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$month)->where("creattime","<=",$now)->where("flag",1)->count();
                $month_flag1=$month_flag1?$month_flag1:0;
                $this->assign("month_flag1",$month_flag1);
                $month_flag4 = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->where("creattime",">=",$month)->where("creattime","<=",$now)->where("flag",5)->count();
                $month_flag4=$month_flag4?$month_flag4:0;
                $this->assign("month_flag4",$month_flag4);
                $duo_platform_orders = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid",0)->order('creattime desc')->limit(0,5)->field("id,creattime,order_id,jsondata,uid,flag,nav")->select();
                
                foreach ($duo_platform_orders as $key => &$value) {
                    $value['creattime'] = date('Y-m-d H:i:s', $value['creattime']);
                    $jsondata = unserialize($value['jsondata']);
                    unset($value['jsondata']);
                    $pname = '';
                    // if($jsondata[0]['is_from_shops'] == 1){
                    if(2 == 1){
                        foreach ($jsondata as $k => $v) {
                            $pname .= Db::table("ims_sudu8_page_shops_goods")->where("uniacid",$appletid)->where("id",$v['pid'])->field("title")->find()['title'];
                        }
                    }else{
           
                            if($jsondata){
                                foreach ($jsondata as $k => $v) {
                                    if(isset($v['baseinfo2']) && $v['baseinfo2']){
                                        $pname .= $v['baseinfo2']['title'] . ':' . chop($v['proinfo']['ggz'],',') . 'x' . $v['num'] . ';';
                                    }else{
                                       if(isset($v['type']) && $v['type'] == "showProMore"){
                                            
                                            $pname .= $v['baseinfo']['title'] . ':' . chop($v['proinfo']['ggz'],',') . 'x' . $v['num'] . ';';
                                        }else{
                                            $pname .= $v['baseinfo']['title'] . ':' . chop($v['proinfo']['ggz'],',') . 'x' . $v['num'] . ';';
                                        }
                                    }
                                }
                            }else{
                                $pname = "";
                            }
                    }
                    $pname = chop($pname, ';');
                    
                    $value['pname'] = $pname;
                    $value['nickname'] = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$value['uid'])->field("nickname")->find()['nickname'];
                    unset($value['uid']);
                }
 
                $this->assign("duo_platform_orders",$duo_platform_orders);
                //商户id
                $duo_shop_orders = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$appletid)->where("sid","neq",0)->field("id,creattime,order_id,jsondata,uid,flag,nav")->order("creattime desc")->limit(0,5)->select();
                foreach ($duo_shop_orders as $key => &$value) {
                    $value['creattime'] = date('Y-m-d H:i:s', $value['creattime']);
                    $jsondata = unserialize($value['jsondata']);
                    unset($value['jsondata']);
                    $pname = '';
                    // if($jsondata[0]['is_from_shops'] == 1){
                    if(2 == 1){
                        foreach ($jsondata as $k => $v) {
                            $pname .= Db::table("ims_sudu8_page_shops_goods")->where("uniacid",$appletid)->where("id",$v['pid'])->field("title")->find()['title'];
                        }
                    }else{
                        foreach ($jsondata as $k => $v) {
                            $pname .= Db::table("ims_sudu8_page_shops_goods")->where("uniacid",$appletid)->where("id",$v['proinfo']['pid'])->field("title")->find()['title'];
                        }
                    }
                    $pname = chop($pname, ';');
                    $value['pname'] = $pname;
                    $value['nickname'] = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$value['uid'])->field("nickname")->find()['nickname'];
                    unset($value['uid']);
                }
                $this->assign("duo_shop_orders",$duo_shop_orders);
                $yuyue_orders = Db::table("ims_sudu8_page_order")->where("uniacid",$appletid)->where("is_more",1)->order("creattime desc")->limit(0,5)->select();
                foreach ($yuyue_orders as $key => &$value) {
                    $value['creattime'] = date('Y-m-d H:i:s', $value['creattime']); 
                    $value['pname'] = Db::table("ims_sudu8_page_products")->where("uniacid",$appletid)->where("id",$value['pid'])->field("title")->find()['title'];
                    unset($value['pid']);
                    $value['nickname'] = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$value['uid'])->field("nickname")->find()['nickname'];
                    unset($value['uid']);
                }
                $this->assign("yuyue_orders",$yuyue_orders);
                $miaosha_orders = Db::table("ims_sudu8_page_order")->where("uniacid",$appletid)->where("is_more",0)->order("creattime desc")->limit(0,5)->select();
                foreach ($miaosha_orders as $key => &$value) {
                    $value['creattime'] = date('Y-m-d H:i:s', $value['creattime']); 
                    $value['pname'] = Db::table("ims_sudu8_page_products")->where("uniacid",$appletid)->where("id",$value['pid'])->field("title")->find()['title'];
                    unset($value['pid']);
                    $value['nickname'] = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$value['uid'])->field("nickname")->find()['nickname'];
                    unset($value['uid']);
                }
                $this->assign("miaosha_orders",$miaosha_orders);
                $pintuan_orders = Db::table("ims_sudu8_page_pt_order")->where("uniacid",$appletid)->order("creattime desc")->limit(0,5)->select();
                foreach ($pintuan_orders as $key => &$value) {
                    $value['creattime'] = date('Y-m-d H:i:s', $value['creattime']);
                    $jsondata = unserialize($value['jsondata']);
                    unset($value['jsondata']);
                    $pname = '';
                    
                    foreach ($jsondata as $k => $v) {
                        $pname .= Db::table("ims_sudu8_page_pt_pro")->where("uniacid",$appletid)->where("id",$v['baseinfo'])->field("title")->find()['title'];
                    }
                    
                    $pname = chop($pname, ';');
                    
                    $value['pname'] = $pname;
                    $value['nickname'] = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("id",$value['uid'])->field("nickname")->find()['nickname'];
                    unset($value['uid']);
                }
                $this->assign("pintuan_orders",$pintuan_orders);
                $video_orders = Db::table("ims_sudu8_page_video_pay")->where("uniacid",$appletid)->order("creattime desc")->limit(0,5)->select();
                foreach ($video_orders as $key => &$value) {
                    $value['creattime'] = date('Y-m-d H:i:s', $value['creattime']); 
                    $value['pname'] = Db::table("ims_sudu8_page_products")->where("uniacid",$appletid)->where("id",$value['pid'])->field("title")->find()['title'];
                    unset($value['pid']);
                    $value['nickname'] = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("openid",$value['openid'])->field("nickname")->find()['nickname'];
                    unset($value['openid']);
                }
                $this->assign("video_orders",$video_orders);
                // $acticle_comments = Db::table("ims_sudu8_page_comment")->where("uniacid",$appletid)->where("types",0)->order("creattime desc")->limit(0,5)->field('id,openid,text,createtime')->select();
                $acticle_comments = Db::table("ims_sudu8_page_comment")->where("uniacid",$appletid)->order("createtime desc")->limit(0,5)->field('id,openid,text,createtime')->select();
                foreach ($acticle_comments as $key => &$value) {
                    $value['createtime'] = date('Y-m-d H:i:s', $value['createtime']);       
                    $value['nickname'] = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->where("openid",$value['openid'])->field("nickname")->find()['nickname'];
                    unset($value['openid']);
                }
                $this->assign("acticle_comments",$acticle_comments);
                //SELECT type,cid,COUNT(*) as num FROM `ims_sudu8_page_collect` GROUP BY cid,type ORDER BY num desc;
                $collect_max = Db::table("ims_sudu8_page_collect")->field("count(*) as num")->where("uniacid",$appletid)->group("cid,type")->order("num desc")->limit(0,1)->find()['num'];
                    $this->assign("collect_max",$collect_max);
                $collects = Db::table("ims_sudu8_page_collect")->where("uniacid",$appletid)->where("type","in",['showPro','showProMore','showPro_lv','shopsPro'])->group("cid,type")->limit(0,5)->field("id,type, cid,count(*) as num")->order("num desc")->select();
                // $collects['num'] = count($collects);
                foreach ($collects as $key => &$value) {
                    if($value['type'] == 'shopsPro'){
                        // $value['title'] = Db::table("ims_sudu8_page_shops_goods")->where("uniacid",$appletid)->where("id",$value['cid'])->field("title")->find()['title'];
                        $value['title'] = 1;
                    }else{
                        $value['title'] = Db::table("ims_sudu8_page_products")->where("uniacid",$appletid)->where("id",$value['cid'])->field("title")->find()['title'];
                    }
                    unset($value['cid']);
                    unset($value['type']);
                }
                
                $this->assign("collects",$collects);
                $sale_max_1 = Db::table("ims_sudu8_page_products")->where("uniacid",$appletid)->max("sale_tnum");
                // $sale_max_2 = Db::table("ims_sudu8_page_shops_goods")->where("uniacid",$appletid)->max("rsales");
                $sale_max_2 = 0;
                $sale_max = max($sale_max_1, $sale_max_2);
                $this->assign("sale_max",$sale_max);
                $sales_1 = Db::table("ims_sudu8_page_products")->where("uniacid",$appletid)->order("sale_tnum desc")->limit(0,5)->field("id,title,sale_tnum as rsales")->select();
                // $sales_2 = Db::table("ims_sudu8_page_shops_goods")->where("uniacid",$appletid)->order("rsales desc")->limit(0,5)->field("id,title,rsales")->select();
                $sales_2 = [];
                $sales = array_merge($sales_1, $sales_2);
                $key_value = $new_array = array();
                foreach($sales as $k => $v){
                    $key_value[$k] = $v['rsales'];
                }
                arsort($key_value);
                // reset($key_value);
                foreach ($key_value as $k => $v) {
                    $new_array[] = $sales[$k];
                }
                $sales = $new_array;
                for($i = 5; $i < 10; $i++){
                    unset($sales[$i]);
                }
                
                $this->assign("sales",$sales);
                $credit_max = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->max("score");
                $credits = Db::table("ims_sudu8_page_user")->where("uniacid",$appletid)->order("score desc")->limit(0,5)->field("id,nickname,score")->select(); 
                $this->assign('credit_max',$credit_max);
                $this->assign('credits',$credits);
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
            //根据所属套装组获取权限
            if($res['combo_id'] == 0){
                //$this ->error('请设置小程序的套餐组');
                $id = Db::name('rule') -> field('id') ->select();
                $node_id = array();
                foreach ($id as $item) {
                    $node_id[] = (string)$item['id'];
                }
            }else{
                $combo = Db::name('combo') ->where('id', $res['combo_id']) ->find();
                if($combo){
                    if($combo['node_id']){
                        $node_id = unserialize($combo['node_id']);
                    }else{
                        $this->error('请为您的功能套餐设置权限!');
                    }
                }else{
                    $this->error('请设置功能套餐, 或您的功能套餐已被删除!');
                    exit;
                }
            }
            $_SESSION['node_id'] = $node_id;
            //$this ->assign('node_id', $node_id);
            return $this->fetch('index');
        }else{
            $this->redirect('Login/index');
        }
        
    }
}