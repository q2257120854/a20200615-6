<?php
namespace app\api\controller;
use Decode\Decode\Decode;
use think\Request;
use think\Controller;
use think\Db;
use \phpmail\Phpmailer;
class Wxapps extends Controller
{
    /*Diy方法开始*/
    public function doPagehomepage()
    {
        $uniacid = input("uniacid");
        $res = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field("homepage")->find();
        if (!$res) {
            $res['homepage'] = 1;
        }
        //找到使用的模板
        $tplinfo = Db::table('ims_sudu8_page_diypagetpl')->where("uniacid", $uniacid)->where("status", 1)->find();
        $pageids = explode(",", $tplinfo['pageid']);
        if ($tplinfo) {
            $pageid = Db::table('ims_sudu8_page_diypage')->where("uniacid", $uniacid)->where("id", "in", $pageids)->where("index", 1)->field("id")->find();
        } else {
            $pageid = Db::table('ims_sudu8_page_diypage')->where("uniacid", $uniacid)->where("index", 1)->field("id")->find();
        }
        $foot = Db::table('ims_sudu8_page_diypageset')->where("uniacid", $uniacid)->field("foot_is")->find();
        if ($pageid) {
            $res['pageid'] = $pageid['id'];
        } else {
            $res['pageid'] = 0;
        }
        $res['foot_is'] = $foot['foot_is'] ? $foot['foot_is'] : 1;
        $result['data'] = $res;
        return json_encode($result);
    }
    private function emoji_encode($nickname){
         $strEncode = '';
         $length = mb_strlen($nickname,'utf-8');
         for ($i=0; $i < $length; $i++) {
             $_tmpStr = mb_substr($nickname,$i,1,'utf-8');
             if(strlen($_tmpStr) >= 4){
                 // $strEncode .= '[[EMOJI:'.rawurlencode($_tmpStr).']]';
                 $strEncode .= rawurlencode($_tmpStr);
             }else{
                 $strEncode .= $_tmpStr;
             }
         }
         return $strEncode;
     }
    public function doPageDiypage()
    {
        $uniacid = input("uniacid");
        $pageid = input("pageid");
        $foot = Db::table('ims_sudu8_page_diypageset')->where("uniacid", $uniacid)->field("foot_is")->find();
        $tplinfo = Db::table('ims_sudu8_page_diypagetpl')->where("uniacid", $uniacid)->where("status", 1)->find();
        $pageids = explode(",", $tplinfo['pageid']);
        if (!in_array($pageid, $pageids)) {
            $err = array();
            $err['data'] = 3;
            return json_encode($err);
            exit;
        }
        $data = Db::table('ims_sudu8_page_diypage')->where("id", $pageid)->where("uniacid", $uniacid)->find();
        $data['foot'] = $foot['foot_is'] ? $foot['foot_is'] : 1;
        if ($data['page'] != '') {
            $data['page'] = unserialize($data['page']);
            if (isset($data['page']['url']) && $data['page']['url'] != "") {
                $data['page']['url'] = remote($uniacid, $data['page']['url'], 1);
            }
        }
        if ($data['items'] != '') {
            $data['items'] = array_values(unserialize($data['items']));

             include 'videoInfo.php';
            $videoInfo = new videoInfo();

            foreach ($data['items'] as $k => &$v) {
                if (is_array($v)) {
                    if (isset($v['id'])) {
                        if ($v['id'] == 'title2' || $v['id'] == 'title' || $v['id'] == 'line' || $v['id'] == 'blank' || $v['id'] == 'anniu' || $v['id'] == 'notice' || $v['id'] == 'service' || $v['id'] == 'listmenu' || $v['id'] == 'joblist' || $v['id'] == 'personlist' || $v['id'] == 'msmk' || $v['id'] == 'multiple' || $v['id'] == 'mlist' || $v['id'] == 'goods' || $v['id'] == 'tabbar' || $v['id'] == 'cases' || $v['id'] == 'listdesc' || $v['id'] == 'pt' || $v['id'] == 'dt' || $v['id'] == 'ssk' || $v['id'] == 'xnlf' || $v['id'] == 'yhq' || $v['id'] == 'dnfw' || $v['id'] == 'yuyin' || $v['id'] == 'feedback') {
                            if ($v['params']['backgroundimg'] != "") {
                                $v['params']['backgroundimg'] = remote($uniacid, $v['params']['backgroundimg'], 1);
                            }
                        }else if ($v['id'] == 'bigimg' || $v['id'] == 'classfit' || $v['id'] == 'banner' || $v['id'] == 'menu' || $v['id'] == 'picture' || $v['id'] == 'picturew') {
                            if ($v['params']['backgroundimg'] != "") {
                                $v['params']['backgroundimg'] = remote($uniacid, $v['params']['backgroundimg'], 1);
                            }
                            if ($v['data']) {
                                foreach ($v['data'] as $ki => $vi) {
                                    if ($vi['imgurl'] != "") {
                                        if (strpos($vi['imgurl'], "diypage/resource") !== false) {
                                            $v['data'][$ki]['imgurl'] = ROOT_HOST . $vi['imgurl'];
                                        } else {
                                            $v['data'][$ki]['imgurl'] = remote($uniacid, $vi['imgurl'], 1);
                                        }
                                    }
                                }
                            }
                        }else if ($v['id'] == 'contact') {
                            if ($v['params']['backgroundimg'] != "") {
                                $v['params']['backgroundimg'] = remote($uniacid, $v['params']['backgroundimg'], 1);
                            }
                            if ($v['params']['src'] != "") {
                                if (strpos($v['params']['src'], "diypage/resource") !== false) {
                                    $v['params']['src'] = ROOT_HOST . $v['params']['src'];
                                } else {
                                    $v['params']['src'] = remote($uniacid, $v['params']['src'], 1);
                                }
                            }
                            if ($v['params']['ewm'] != "") {
                                if (strpos($v['params']['ewm'], "diypage/resource") !== false) {
                                    $v['params']['ewm'] = ROOT_HOST . $v['params']['ewm'];
                                } else {
                                    $v['params']['ewm'] = remote($uniacid, $v['params']['ewm'], 1);
                                }
                            }
                        }else if ($v['id'] == 'video') {
                            if (isset($v['params']['backgroundimg']) && $v['params']['backgroundimg'] != "") {
                                $v['params']['backgroundimg'] = remote($uniacid, $v['params']['backgroundimg'], 1);
                            }
                            if ($v['params']['poster'] != "") {
                                if (strpos($v['params']['poster'], "diypage/resource") !== false) {
                                    $v['params']['poster'] = ROOT_HOST . $v['params']['poster'];
                                } else {
                                    $v['params']['poster'] = remote($uniacid, $v['params']['poster'], 1);
                                }
                            }
                        }else if ($v['id'] == 'logo' || $v['id'] == 'dp') {
                            if ($v['params']['backgroundimg'] != "") {
                                $v['params']['backgroundimg'] = remote($uniacid, $v['params']['backgroundimg'], 1);
                            }
                            if ($v['params']['src'] != "") {
                                if (strpos($v['params']['src'], "diypage/resource") !== false) {
                                    $v['params']['src'] = ROOT_HOST . $v['params']['src'];
                                } else {
                                    $v['params']['src'] = remote($uniacid, $v['params']['src'], 1);
                                }
                            }
                        }else if ($v['id'] == 'footmenu') {
                            if ($v['data']) {
                                foreach ($v['data'] as $ki => $vi) {
                                    if ($vi['imgurl'] != "") {
                                        if (strpos($vi['imgurl'], "diypage/resource") !== false) {
                                            $v['data'][$ki]['imgurl'] = ROOT_HOST . $vi['imgurl'];
                                        } else {
                                            $v['data'][$ki]['imgurl'] = remote($uniacid, $vi['imgurl'], 1);
                                        }
                                    }
                                }
                            }
                        }
                        if ($v['id'] == "banner") {
                            $v['data'] = array_values($v['data']);
                            if ($v['data']) {
                                $imginfo = explode(" ", getimagesize($v['data'][0]['imgurl'])[3]);
                                $v['params']['imgw'] = explode('"', $imginfo[0])[1];
                                $v['params']['imgh'] = explode('"', $imginfo[1])[1];
                            }
                        }else if ($v['id'] == "richtext") {
                            $v['richtext'] = base64_decode($v['params']['content']);
                        }else if ($v['id'] == "feedback") {
                            if (isset($v['params']['sourceid']) && $v['params']['sourceid'] != "") {
                                $sourceid = explode(':', $v['params']['sourceid'])[1];
                                $data['forminfo'] = Db::table('ims_sudu8_page_formlist')->where("uniacid", $uniacid)->where("id", $sourceid)->find();
                                if ($data['forminfo']) {
                                    $data['forminfo']['tp_text'] = unserialize($data['forminfo']['tp_text']);
                                    foreach ($data['forminfo']['tp_text'] as $key => &$res) {
                                        if ($res["type"] != 2 && $res["type"] != 5) {
                                            $vals = explode(",", $res['tp_text']);
                                            $kk = array();
                                            foreach ($vals as $key => &$rec) {
                                                $kk['yval'] = $rec;
                                                $kk['checked'] = "false";
                                                $rec = $kk;
                                            }
                                            $res['tp_text'] = $vals;
                                        }
                                        if ($res["type"] == 2) {
                                            $vals = explode(",", $res['tp_text']);
                                            $res['tp_text'] = $vals;
                                        }
                                        $res['val'] = '';
                                    }
                                }
                            }
                        }else if ($v['id'] == "msmk") {
                            if (isset($v['params']['sourceid']) && $v['params']['sourceid'] != "") {
                                $sourceid = explode(':', $v['params']['sourceid'])[1];
                                $count = $v['params']['goodsnum'];
                                $con_type = $v['params']['con_type'];
                                $con_key = $v['params']['con_key'];
                                $where = "";
                                if ($con_type == 1 && $con_key == 1) {
                                    $where = 'ORDER BY id DESC';
                                }
                                if ($con_type == 2 && $con_key == 1) {
                                    $where = 'AND type_x=1 ORDER BY id DESC';
                                }
                                if ($con_type == 3 && $con_key == 1) {
                                    $where = 'AND type_y=1 ORDER BY id DESC';
                                }
                                if ($con_type == 4 && $con_key == 1) {
                                    $where = 'AND type_i=1 ORDER BY id DESC';
                                }
                                if ($con_type == 1 && $con_key == 2) {
                                    $where = 'ORDER BY hits DESC';
                                }
                                if ($con_type == 2 && $con_key == 2) {
                                    $where = 'AND type_x=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 3 && $con_key == 2) {
                                    $where = 'AND type_y=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 4 && $con_key == 2) {
                                    $where = 'AND type_i=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 1 && $con_key == 3) {
                                    $where = 'ORDER BY num DESC';
                                }
                                if ($con_type == 2 && $con_key == 3) {
                                    $where = 'AND type_x=1 ORDER BY num DESC';
                                }
                                if ($con_type == 3 && $con_key == 3) {
                                    $where = 'AND type_y=1 ORDER BY num DESC';
                                }
                                if ($con_type == 4 && $con_key == 3) {
                                    $where = 'AND type_i=1 ORDER BY num DESC';
                                }
                                $list = Db::query("SELECT title,thumb,id,`desc`,price,market_price,sale_num,sale_tnum,sale_time,sale_end_time,pro_kc FROM ims_sudu8_page_products WHERE `uniacid` = {$uniacid} AND `type` = 'showPro' AND `is_more` = 0 AND `flag` = 1 AND `is_sale`=0 AND  (`cid` = {$sourceid} or `pcid` = {$sourceid} ) " . $where . " LIMIT 0,{$count}");
                                if ($list) {
                                    foreach ($list as $kk => $vv) {
                                        // $count = Db::table("ims_sudu8_page_order")->where("uniacid", $uniacid)->where("pid", $vv['id'])->where("flag", "neq", 1)->field("id")->count();
                                        $list[$kk]['linkurl'] = "/sudu8_page/showPro/showPro?id=" . $vv['id'];
                                        $list[$kk]['linktype'] = "page";
                                        $list[$kk]['sale_num'] = $vv['sale_num'] + $vv['sale_tnum'];
                                        if (strpos($vv['thumb'], 'http') === false && $vv['thumb'] != "") {
                                            $list[$kk]['thumb'] = remote($uniacid, $vv['thumb'], 1);
                                        }
                                        // $orders = Db::table('ims_sudu8_page_order') ->where('pid', $vv['id']) ->where('uniacid', $uniacid) ->select();
                                        // $sale_num_temp = 0;
                                        // if($orders){
                                        //     foreach ($orders as $rec) {
                                        //         $sale_num_temp+= $rec['num'];
                                        //     }
                                        // }
                                        // $vv['sale_num'] = $vv['sale_num'] + $sale_num_temp;
                                    }
                                    $data['msmk'] = $list;
                                } else {
                                    $data['msmk'] = [];
                                }
                            }
                        }else if ($v['id'] == "pt") {
                            if (isset($v['params']['sourceid']) && $v['params']['sourceid'] != "") {
                                $sourceid = explode(':', $v['params']['sourceid'])[1];
                                $count = $v['params']['goodsnum'];
                                $con_type = $v['params']['con_type'];
                                $con_key = $v['params']['con_key'];
                                $where = "";
                                if ($con_type == 1 && $con_key == 1) {
                                    $where = 'ORDER BY id DESC';
                                }
                                if ($con_type == 2 && $con_key == 1) {
                                    $where = 'AND type_x=1 ORDER BY id DESC';
                                }
                                if ($con_type == 3 && $con_key == 1) {
                                    $where = 'AND type_y=1 ORDER BY id DESC';
                                }
                                if ($con_type == 4 && $con_key == 1) {
                                    $where = 'AND type_i=1 ORDER BY id DESC';
                                }
                                if ($con_type == 1 && $con_key == 2) {
                                    $where = 'ORDER BY hits DESC';
                                }
                                if ($con_type == 2 && $con_key == 2) {
                                    $where = 'AND type_x=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 3 && $con_key == 2) {
                                    $where = 'AND type_y=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 4 && $con_key == 2) {
                                    $where = 'AND type_i=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 1 && $con_key == 3) {
                                    $where = 'ORDER BY num DESC';
                                }
                                if ($con_type == 2 && $con_key == 3) {
                                    $where = 'AND type_x=1 ORDER BY num DESC';
                                }
                                if ($con_type == 3 && $con_key == 3) {
                                    $where = 'AND type_y=1 ORDER BY num DESC';
                                }
                                if ($con_type == 4 && $con_key == 3) {
                                    $where = 'AND type_i=1 ORDER BY num DESC';
                                }
                                $list = Db::query("SELECT * FROM ims_sudu8_page_pt_pro WHERE `uniacid` = {$uniacid} AND `show_pro`=0 AND `cid` = {$sourceid} " . $where . " LIMIT 0,{$count}");
                                if ($list) {
                                    foreach ($list as $kk => $vv) {
                                        $list[$kk]['linkurl'] = "/sudu8_page_plugin_pt/products/products?id=" . $vv['id'];
                                        $list[$kk]['linktype'] = "page";
                                        if (strpos($vv['thumb'], 'http') === false && $vv['thumb'] != "") {
                                            $list[$kk]['thumb'] = remote($uniacid, $vv['thumb'], 1);
                                        }
                                    }
                                    $data['items'][$k]['data'] = $list;
                                } else {
                                    $data['items'][$k]['data'] = [];
                                }
                            }
                        }else if ($v['id'] == "cases") {
                            if (isset($v['params']['sourceid']) && $v['params']['sourceid'] != "") {
                                $sourceid = explode(':', $v['params']['sourceid'])[1];
                                $count = $v['params']['casenum'];
                                $con_type = $v['params']['con_type'];
                                $con_key = $v['params']['con_key'];
                                $where = "";
                                if ($con_type == 1 && $con_key == 1) {
                                    $where = 'ORDER BY id DESC';
                                }
                                if ($con_type == 2 && $con_key == 1) {
                                    $where = 'AND type_x=1 ORDER BY id DESC';
                                }
                                if ($con_type == 3 && $con_key == 1) {
                                    $where = 'AND type_y=1 ORDER BY id DESC';
                                }
                                if ($con_type == 4 && $con_key == 1) {
                                    $where = 'AND type_i=1 ORDER BY id DESC';
                                }
                                if ($con_type == 1 && $con_key == 2) {
                                    $where = 'ORDER BY hits DESC';
                                }
                                if ($con_type == 2 && $con_key == 2) {
                                    $where = 'AND type_x=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 3 && $con_key == 2) {
                                    $where = 'AND type_y=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 4 && $con_key == 2) {
                                    $where = 'AND type_i=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 1 && $con_key == 3) {
                                    $where = 'ORDER BY num DESC';
                                }
                                if ($con_type == 2 && $con_key == 3) {
                                    $where = 'AND type_x=1 ORDER BY num DESC';
                                }
                                if ($con_type == 3 && $con_key == 3) {
                                    $where = 'AND type_y=1 ORDER BY num DESC';
                                }
                                if ($con_type == 4 && $con_key == 3) {
                                    $where = 'AND type_i=1 ORDER BY num DESC';
                                }
                                $list = Db::query("SELECT id,title,thumb,type FROM ims_sudu8_page_products WHERE (`type` = 'showPic' or `type` = 'showArt') AND `uniacid` = {$uniacid} AND `flag` = 1  AND (`cid` = {$sourceid} or `pcid` = {$sourceid} ) " . $where . " LIMIT 0,{$count}");
                                if ($list) {
                                    foreach ($list as $kk => $vv) {
                                        $list[$kk]['linkurl'] = "/sudu8_page/" . $vv['type'] . "/" . $vv['type'] . "?id=" . $vv['id'];
                                        if (strpos($vv['thumb'], 'http') === false && $vv['thumb'] != "") {
                                            $list[$kk]['thumb'] = remote($uniacid, $vv['thumb'], 1);
                                        }
                                    }
                                    $data['items'][$k]['data'] = $list;
                                } else {
                                    $data['items'][$k]['data'] = [];
                                }
                            }
                        }else if ($v['id'] == "listdesc") {
                            if (isset($v['params']['sourceid']) && $v['params']['sourceid'] != "") {
                                $sourceid = explode(':', $v['params']['sourceid'])[1];
                                $count = $v['params']['newsnum'];
                                $con_type = $v['params']['con_type'];
                                $con_key = $v['params']['con_key'];
                                $where = "";
                                if ($con_type == 1 && $con_key == 1) {
                                    $where = 'ORDER BY id DESC';
                                }
                                if ($con_type == 2 && $con_key == 1) {
                                    $where = 'AND type_x=1 ORDER BY id DESC';
                                }
                                if ($con_type == 3 && $con_key == 1) {
                                    $where = 'AND type_y=1 ORDER BY id DESC';
                                }
                                if ($con_type == 4 && $con_key == 1) {
                                    $where = 'AND type_i=1 ORDER BY id DESC';
                                }
                                if ($con_type == 1 && $con_key == 2) {
                                    $where = 'ORDER BY hits DESC';
                                }
                                if ($con_type == 2 && $con_key == 2) {
                                    $where = 'AND type_x=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 3 && $con_key == 2) {
                                    $where = 'AND type_y=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 4 && $con_key == 2) {
                                    $where = 'AND type_i=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 1 && $con_key == 3) {
                                    $where = 'ORDER BY num DESC';
                                }
                                if ($con_type == 2 && $con_key == 3) {
                                    $where = 'AND type_x=1 ORDER BY num DESC';
                                }
                                if ($con_type == 3 && $con_key == 3) {
                                    $where = 'AND type_y=1 ORDER BY num DESC';
                                }
                                if ($con_type == 4 && $con_key == 3) {
                                    $where = 'AND type_i=1 ORDER BY num DESC';
                                }
                                $list = Db::query("SELECT * FROM ims_sudu8_page_products WHERE `type` = 'showArt'  AND  `uniacid` = {$uniacid} AND `flag` = 1 AND (`cid` = {$sourceid} or `pcid` = {$sourceid} ) " . $where . " LIMIT 0,{$count}");
                                if ($list) {
                                    foreach ($list as $kk => $vv) {
                                        $count = Db::table("ims_sudu8_page_comment")->where("uniacid", $uniacid)->where("id", $vv['id'])->count();
                                        $list[$kk]['comments'] = $count;
                                        $list[$kk]['linkurl'] = "/sudu8_page/showArt/showArt?id=" . $vv['id'];
                                        if (strpos($vv['thumb'], 'http') === false && $vv['thumb'] != "") {
                                            $list[$kk]['thumb'] = remote($uniacid, $vv['thumb'], 1);
                                        }
                                        $list[$kk]['ctime'] = date('Y年m月d日', $vv['ctime']);
                                    }
                                    $data['items'][$k]['data'] = $list;
                                } else {
                                    $data['items'][$k]['data'] = [];
                                }
                            }
                        }else if (isset($v['params']['noticedata']) && intval($v['params']['noticedata']) == 0) {
                            /*读取系统公告*/
                            if (isset($v['params']['sourceid']) && $v['params']['sourceid'] != "") {
                                $sourceid = explode(':', $v['params']['sourceid'])[1];
                                $count = $v['params']['noticenum'];
                                $list = Db::query("SELECT id,title FROM ims_sudu8_page_products WHERE `uniacid` = {$uniacid} AND `type` = 'showArt'  AND (`cid` = {$sourceid} or `pcid` = {$sourceid} ) ORDER BY id DESC LIMIT 0,{$count}");
                                if ($list) {
                                    foreach ($list as $kk => $vv) {
                                        if ($v['params']['noticedata'] == 0) {
                                            $list[$kk]['linktype'] = 'page';
                                        }
                                        $list[$kk]['linkurl'] = "/sudu8_page/showArt/showArt?id=" . $vv['id'];
                                    }
                                    $data['items'][$k]['data'] = $list;
                                } else {
                                    $data['items'][$k]['data'] = [];
                                }
                            }
                        }else if ($v['id'] == "kpgg" || $v['id'] == "tcgg") {
                            if (intval($v['params']['navstyle']) == 0) {
                                $data['sec'] = $v['params']['sec'];
                            }
                        }else if ($v['id'] == "goods") {
                            if (isset($v['params']['sourceid']) && $v['params']['sourceid'] != "") {
                                $sourceid = explode(':', $v['params']['sourceid'])[1];
                                $count = $v['params']['goodsnum'];
                                $con_type = $v['params']['con_type'];
                                $con_key = $v['params']['con_key'];
                                $where = "";
                                if ($con_type == 1 && $con_key == 1) {
                                    $where = 'ORDER BY id DESC';
                                }
                                if ($con_type == 2 && $con_key == 1) {
                                    $where = 'AND type_x=1 ORDER BY id DESC';
                                }
                                if ($con_type == 3 && $con_key == 1) {
                                    $where = 'AND type_y=1 ORDER BY id DESC';
                                }
                                if ($con_type == 4 && $con_key == 1) {
                                    $where = 'AND type_i=1 ORDER BY id DESC';
                                }
                                if ($con_type == 1 && $con_key == 2) {
                                    $where = 'ORDER BY hits DESC';
                                }
                                if ($con_type == 2 && $con_key == 2) {
                                    $where = 'AND type_x=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 3 && $con_key == 2) {
                                    $where = 'AND type_y=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 4 && $con_key == 2) {
                                    $where = 'AND type_i=1 ORDER BY hits DESC';
                                }
                                if ($con_type == 1 && $con_key == 3) {
                                    $where = 'ORDER BY num DESC';
                                }
                                if ($con_type == 2 && $con_key == 3) {
                                    $where = 'AND type_x=1 ORDER BY num DESC';
                                }
                                if ($con_type == 3 && $con_key == 3) {
                                    $where = 'AND type_y=1 ORDER BY num DESC';
                                }
                                if ($con_type == 4 && $con_key == 3) {
                                    $where = 'AND type_i=1 ORDER BY num DESC';
                                }
                                $list = Db::query("SELECT * FROM ims_sudu8_page_products WHERE `uniacid` = {$uniacid} AND `flag` = 1 AND `is_sale`=0 AND (`cid` = {$sourceid} or `pcid` = {$sourceid} ) " . $where . " LIMIT 0,{$count}");
                                if ($list) {
                                    foreach ($list as $kk => $vv) {
                                        if ($vv['type'] == "showPro" && $vv['is_more'] == 0) {
                                            $list[$kk]['linkurl'] = "/sudu8_page/showPro/showPro?id=" . $vv['id'];
                                            
                                            $items_orders = Db::table('ims_sudu8_page_order') ->where('pid', $vv['id']) ->where('uniacid', $uniacid) ->select();
                                            $items_pro_num = 0;
                                            if($items_orders) {
                                                foreach ($items_orders as $rec) {
                                                    $items_pro_num+= $rec['num'];
                                                }
                                            }
                                            $list[$kk]['sale_num'] = $list[$kk]['sale_num'] + $items_pro_num;
                                        } else if ($vv['is_more'] == 1) {
                                            $list[$kk]['linkurl'] = "/sudu8_page/showPro_lv/showPro_lv?id=" . $vv['id'];
                                        } else {
                                            $values = Db::table("ims_sudu8_page_duo_products_type_value")->where("pid", $vv['id'])->select();
                                            foreach ($values as $ks => $vs) {
                                                $list[$kk]['sale_num']=$list[$kk]['sale_num']+$vs['salenum']+$vs['vsalenum'];
                                            }
                                            $list[$kk]['linkurl'] = "/sudu8_page/showProMore/showProMore?id=" . $vv['id'];
                                        }
                                        if (strpos($vv['thumb'], 'http') === false && $vv['thumb'] != "") {
                                            $list[$kk]['thumb'] = remote($uniacid, $vv['thumb'], 1);
                                        }
                                    }
                                    $data['items'][$k]['data'] = $list;
                                } else {
                                    $data['items'][$k]['data'] = [];
                                }
                            }
                        }else  if ($v['id'] == "menu2") {
                            $count = count($v['data']);
                            $data['items'][$k]['count'] = $count;
                        }else if ($v['id'] == "picturew") {
                            $count = count($v['data']);
                            $data['items'][$k]['count'] = $count;
                            if ($v['params']['row'] == 1) {
                                for ($i = 0; $i <= $count; $i++) {
                                    $data['items'][$k]['data'] = array_values($v['data']);
                                }
                            } else {
                                $v['data'] = array_values($v['data']);
                                $imginfo = explode(" ", getimagesize($v['data'][0]['imgurl'])[3]);
                                $v['imgw'] = explode('"', $imginfo[0])[1];
                                $v['imgh'] = explode('"', $imginfo[1])[1];
                            }
                        }else if ($v['id'] == "tabbar") {
                            $datas = array();
                            $i = 0;
                            foreach ($v['data'] as $kk => $vv) {
                                $data['items'][$k]['datas'][$i] = $vv;
                                $i++;
                            }
                            $count = count($v['data']);
                            $data['items'][$k]['count'] = $count;
                        }else if ($v['id'] == "xxk") {
                            $datas = array();
                            $i = 0;
                            foreach ($v['data'] as $kk => $vv) {
                                $data['items'][$k]['datas'][$i] = $vv;
                                $i++;
                            }
                            $count = count($v['data']);
                            $data['items'][$k]['count'] = $count;
                        }else if ($v['id'] == "video") {
                            $videourl = $v['params']['videourl'];

                            if ($videourl) {
                                if (strpos($videourl, ".mp4") !== false) {
                                    $videodata = $videourl;
                                } else {
                                   
                                    $videodata = $videoInfo->getVideoInfo($videourl);
                                     $videodata = $videodata['url'];

                                }
                                $v['params']['videourl'] = $videodata;
                            }
                        }else if ($v['id'] == "yhq") {
                            $counts_yhq = $v['style']['counts'];
                            $v['coupon'] = Db::table("ims_sudu8_page_coupon")->where("flag", 1)->where("uniacid", $uniacid)->limit(0, $counts_yhq)->select();
                        }else if ($v['id'] == "xnlf") {
                            $avatars = Db::table("ims_sudu8_page_user")->where("avatar", "neq", "")->where("uniacid", $uniacid)->order("id desc")->limit(0, 5)->field("avatar")->select();
                            $v['avatars'] = $avatars;
                        }else if($v['id'] == "multiple"){
                            if(!isset($v['style']['showtype'])){
                                $data['items'][$k]['style']['showtype'] = 0;
                            }
                            $tjnum = $v['style']['rownum'];
                            $content_type = $v['params']['content_type'];
                            $content_type = $v['params']['content_type'];
                            if($content_type == 1){
                                $orderby = " createtime desc ";
                            }
                            if($content_type == 2){
                                $orderby = " star desc ";
                            }
                                        
                            $store['storeHot'] =  $store['storeHot'] = Db::query("SELECT id,uniacid,name,logo,hot FROM ims_sudu8_page_shops_shop WHERE `flag` = 1 AND `uniacid` = {$uniacid} AND `hot` = 1 ORDER BY " . $orderby . " LIMIT 0," . $tjnum);
                            $num2 = count($store['storeHot']);
                            for($i = 0; $i < $num2; $i++){
                                if (stristr($store['storeHot'][$i]['logo'], 'http')) {
                                    $store['storeHot'][$i]['logo'] = $store['storeHot'][$i]['logo'];
                                } else {
                                    $store['storeHot'][$i]['logo'] = remote($uniacid, $store['storeHot'][$i]['logo'], 1);
                                }
                            }
                            $data['items'][$k]['data'] = $store;
                        }else if ($v['id'] == "mlist") {
                            $store['catelist'] = Db::table("ims_sudu8_page_shops_cate")->where("uniacid", $uniacid)->where('flag', 1)->field("id,num,name")->order("num desc")->select();
                            if(isset($v['style']['viewcount'])){
                                $tjnum = $v['style']['viewcount'];
                            }else{
                                $tjnum = 4;
                            }

                            if(isset($v['params']['content_type'])){
                                $content_type = $v['params']['content_type'];
                            }else{
                                $content_type = 1;
                            }
                            
                            if ($content_type == 1) {
                                $orderby = " createtime desc ";
                            }
                            if ($content_type == 2) {
                                $orderby = " star desc ";
                            }
                            $store['storeHot'] = Db::query("SELECT id,uniacid,name,logo,hot FROM ims_sudu8_page_shops_shop WHERE `flag` = 1 AND `uniacid` = {$uniacid} AND `hot` = 1 ORDER BY " . $orderby . " LIMIT 0," . $tjnum);
                            $num2 = count($store['storeHot']);
                            for ($i = 0; $i < $num2; $i++) {
                                if (stristr($store['storeHot'][$i]['logo'], 'http')) {
                                    $store['storeHot'][$i]['logo'] = $store['storeHot'][$i]['logo'];
                                } else {
                                    $store['storeHot'][$i]['logo'] = remote($uniacid, $store['storeHot'][$i]['logo'], 1);
                                }
                            }
                            $data['items'][$k]['data'] = $store;
                        }


                        if ($v['id'] == "footmenu") {
                            $count = count($v['data']);
                            $data['items'][$k]['count'] = $count;
                            $text_is = $v['params']['textshow'];
                            if ($text_is == 1) {
                                $data['footmenuh'] = $v['style']['paddingleft'] * 2 + $v['style']['textfont'] + $v['style']['paddingtop'] * 2 + $v['style']['iconfont'] + 1;
                                $data['foottext'] = 1;
                            } else {
                                $data['footmenuh'] = $v['style']['paddingtop'] * 2 + $v['style']['iconfont'] + 1;
                                $data['foottext'] = 0;
                            }
                            $data['footmenu'] = 1;
                        }
                    }
                }
            }
        }
        $pageset = Db::table("ims_sudu8_page_diypageset")->where("uniacid", $uniacid)->find();
        if ($pageset) {
            if (strpos($pageset['kp'], 'http') === false) {
                $pageset['kp'] = remote($uniacid, $pageset['kp'], 1);
            }
            if (strpos($pageset['tc'], 'http') === false) {
                $pageset['tc'] = remote($uniacid, $pageset['tc'], 1);
            }
        } else {
            $pageset['kp'] = "";
            $pageset['tc'] = "";
        }
        $data['pageset'] = $pageset;
        $result['data'] = $data;
        return json_encode($result);
    }
    public function doPageDiyForms()
    {
        $uniacid = input("uniacid");
        $forms = stripslashes(html_entity_decode(input('forminfo')));
        $forms = json_decode($forms, TRUE);
        $data['val'] = serialize($forms);
        $data['uniacid'] = $uniacid;
        $data['cid'] = input('formid');
        $data['creattime'] = time();
        $result['data'] = Db::table('ims_sudu8_page_formcon')->insert($data);
        foreach ($forms as $key5 => &$rem) {
            if ($rem['type'] == 14) {
                $addbarr = array(
                    "uniacid" => $uniacid,
                    "cid" => 0,
                    "types" => "diy",
                    "datys" => strtotime($rem['days']),
                    "pagedatekey" => $rem['indexkey'],
                    "arrkey" => $rem['xuanx'],
                    "creattime" => time()
                );
                Db::table('ims_sudu8_page_form_dd')->insert($addbarr);
            }
        }
        return json_encode($result);
    }
    public function doPageGetFoot()
    {
        $uniacid = input("uniacid");
        $foot = input('foot');
        if ($foot == 1) {
            $baseInfo = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->find();
            if ($baseInfo['copyimg']) {
                $baseInfo['copyimg'] = remote($uniacid, $baseInfo['copyimg'], 1);
            }
            $baseInfo['tabbar'] = unserialize($baseInfo['tabbar_new']);
            $baseInfo['tabnum'] = $baseInfo['tabnum_new'];
            if ($baseInfo['tabnum'] > 0) {
                for ($i = 0; $i < $baseInfo['tabnum']; $i++) {
                    $baseInfo['tabbar'][$i] = unserialize($baseInfo['tabbar'][$i]);
                    if ($baseInfo['tabbar'][$i]) {
                        if($baseInfo['tabbar'][$i]['tabbar'] == 1){
                            if(!empty($baseInfo['tabbar'][$i]['tabimginput_1'])){
                                $baseInfo['tabbar'][$i]['tabimginput_1'] = remote($uniacid,$baseInfo['tabbar'][$i]['tabimginput_1'],1);
                            }
                            if(!empty($baseInfo['tabbar'][$i]['tabimginput_2'])){
                                $baseInfo['tabbar'][$i]['tabimginput_2'] = remote($uniacid,$baseInfo['tabbar'][$i]['tabimginput_2'],1);
                            }
                        }
                        if ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "tel") {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "tel";
                        } elseif ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "map") {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "map";
                        } elseif ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "web") {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "web";
                        } elseif ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "server") {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "server";
                        } else {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
                        }
                    }
                }
            } else {
                $baseInfo['tabbar'][0] = "";
                $baseInfo['tabbar'][1] = "";
                $baseInfo['tabbar'][2] = "";
                $baseInfo['tabbar'][3] = "";
                $baseInfo['tabbar'][4] = "";
            }
            $baseInfo['color_bar'] = "1px solid " . $baseInfo['color_bar'];
            $result['data'] = $baseInfo;
            return json_encode($result);
        } else {
            $data = Db::table("ims_sudu8_page_diypage")->where("index", 1)->where("uniacid", $uniacid)->find();
            if ($data['copyimg']) {
                $data['copyimg'] = remote($uniacid, $data['copyimg'], 1);
            }
            if ($data['items'] != '') {
                $data['items'] = unserialize($data['items']);
                foreach ($data['items'] as $k => &$v) {
                    if ($v['id'] == "footmenu") {
                        $count = count($v['data']);
                        $res['count'] = $count;
                        $res['params'] = $v['params'];
                        $res['style'] = $v['style'];
                        $res['data'] = $v['data'];
                        $text_is = $v['params']['textshow'];
                        if ($text_is == 1) {
                            $res['footmenuh'] = $v['style']['paddingleft'] * 2 + $v['style']['textfont'] + $v['style']['paddingtop'] * 2 + $v['style']['iconfont'] + 1;
                            $res['foottext'] = 1;
                        } else {
                            $res['footmenuh'] = $v['style']['paddingtop'] * 2 + $v['style']['iconfont'] + 1;
                            $res['foottext'] = 0;
                        }
                        $res['footmenu'] = 1;
                    }
                }
            }
            $result['data'] = $res;
            return json_encode($result);
        }
    }
    /*diy方法结束*/
    /*原默认方法*/
    public function doPageAppbase()
    {
        $uniacid = input("uniacid");
        $code = input("code");
        $app = Db::table('applet')->where("id", $uniacid)->find();
        $appid = $app['appID'];
        $appsecret = $app['appSecret'];
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $weixin = file_get_contents($url);
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        if (isset($array['errcode'])) {
            $data['res'] = 2;
            $result['data'] = $data;
            return json_encode($result);
            exit;
        }
        $openid = $array['openid'];//输出openid
        if ($openid) {
            $data = array(
                "uniacid" => $uniacid,
                "openid" => $openid,
                "createtime" => time(),
            );
            $userinfo = Db::table('ims_sudu8_page_user')->where("openid", $openid)->where("uniacid", $uniacid)->find();
            if (count($userinfo) == 0) {
                Db::table('ims_sudu8_page_user')->insert($data);
                $data['res'] = 1;
                $adata['data'] = $data;
                return json_encode($adata);
            } else {
                $adata['data'] = $userinfo;
                return json_encode($adata);
            }
        }
    }
    public function doPagebindfxs()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $fxsid = input("fxsid");
        // 分销商的关系[1.绑定上下级关系 ]
        $userinfo = Db::table('ims_sudu8_page_user')->where("openid", $openid)->where("uniacid", $uniacid)->find();
        // 分销商的信息
        $fxsinfo = Db::table('ims_sudu8_page_user')->where("openid", $fxsid)->where("uniacid", $uniacid)->find();
        //获取该小程序的分销关系绑定规则
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("fx_cj,sxj_gx,uniacid")->find();
        // 1.先进行上下级关系绑定[判断是不是点击即成分销商]
        if ($guiz['fx_cj'] != 4 && $guiz['sxj_gx'] == 1 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] != 2 && $fxsinfo['fxs'] == 2) {
            $p_fxs = $fxsinfo['parent_id'];  //分销商的上级
            $p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
            // 判断启用几级分销
            $fx_cj = $guiz['fx_cj'];
            // 分别做判断
            if ($fx_cj == 1) {
                $uuser = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update(array("parent_id" => $fxsid));
            }
            if ($fx_cj == 2) {
                $uuser = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs));
            }
            if ($fx_cj == 3) {
                $uuser = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs, "p_p_parent_id" => $p_p_fxs));
            }
        }
        $adata['guiz'] = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("one_bili,two_bili,three_bili,uniacid")->find();
        //return $this->result(0, 'success',$isbindfxs);
    }
    //付费视频  0521前端未查到
    // public function doPageglobaluserinfoget(){
    //  $uniacid = input("uniacid");
    //  $openid = input("openid");
    //  $newuserinfo['data'] = Db::table('ims_sudu8_page_user')->where("openid",$openid)->where("uniacid",$uniacid)->find();
    //  return json_encode($newuserinfo);
    // }
    // 更改付费视频的相关信息
    public function dopagevideogeng()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $money = input("money");
        $mykoumoney = input("mykoumoney");
        $order_id = input('orderid');
        $id = input("id");
        $artType = input('artType');
        $userinfo = Db::table('ims_sudu8_page_user')->where("openid", $openid)->where("uniacid", $uniacid)->find();
        $newmoney = $userinfo['money'] * 1 - $mykoumoney * 1;
        Db::table('ims_sudu8_page_user')->where("openid", $openid)->where("uniacid", $uniacid)->update(array("money" => 0));
        // 创建视频消费记录
        $kdata = array(
            "uniacid" => $uniacid,
            "openid" => $openid,
            "pid" => $id,
            "orderid" => $order_id,
            "paymoney" => $mykoumoney + $money,
            "creattime" => time(),
            "type" => $artType
        );
        Db::table('ims_sudu8_page_video_pay')->insert($kdata);
        // 创建消费流水个人账户
        $xfmoney1 = array(
            "uniacid" => $uniacid,
            "orderid" => $order_id,
            "uid" => $userinfo['id'],
            "type" => "del",
            "score" => $mykoumoney,
            "message" => "视频消费",
            "creattime" => time()
        );
        if ($mykoumoney > 0) {
            Db::table('ims_sudu8_page_money')->insert($xfmoney1);
        }
        $xfmoney = array(
            "uniacid" => $uniacid,
            "orderid" => $order_id,
            "uid" => $userinfo['id'],
            "type" => "del",
            "score" => $money + $mykoumoney,
            "message" => "视频消费",
            "creattime" => time()
        );
        if ($money > 0) {
            Db::table('ims_sudu8_page_money')->insert($xfmoney);
        }
        $count = Db::table("ims_sudu8_page_video_pay")->where("uniacid", $uniacid)->where("openid", $openid)->where("pid", $id)->count();
        $array = array("count" => $count, "order_id" => $order_id);
        return json_encode($array);
    }
// 付费视频操作
    public function doPagevideozhifu()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $money = input("money");
        $mykoumoney = input("mykoumoney");
        $types = input("types");
        $id = input("id");
        $artType = input('artType');
        $now = time();
        $order_id = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
        $userinfo = Db::table('ims_sudu8_page_user')->where("openid", $openid)->where("uniacid", $uniacid)->find();
        if ($types == 1) {  //直接扣除余额
            $newmoney = $userinfo['money'] * 1 - $mykoumoney * 1;
            Db::table('ims_sudu8_page_user')->where("openid", $openid)->where("uniacid", $uniacid)->update(array("money" => $newmoney));
            // 创建视频消费记录
            $kdata = array(
                "uniacid" => $uniacid,
                "openid" => $openid,
                "pid" => $id,
                "type" => $artType,
                "orderid" => $order_id,
                "paymoney" => $mykoumoney,
                "creattime" => time()
            );
            Db::table('ims_sudu8_page_video_pay')->insert($kdata);
            // 创建消费流水
            $xfmoney = array(
                "uniacid" => $uniacid,
                "orderid" => $order_id,
                "uid" => $userinfo['id'],
                "type" => "del",
                "score" => $mykoumoney,
                "message" => "视频消费",
                "creattime" => time()
            );
            if ($mykoumoney > 0) {
                Db::table('ims_sudu8_page_money')->insert($xfmoney);
            }
            $count = Db::table("ims_sudu8_page_video_pay")->where("uniacid", $uniacid)->where("openid", $openid)->where("pid", $id)->count();
            $array = array("count" => $count, "order_id" => $order_id);
            return json_encode($array);
        } else {
            $app = Db::table('applet')->where('id', $uniacid)->find();
            include 'WeixinPay.php';
            $appid = $app['appID'];
            $openid = $openid;
            $mch_id = $app['mchid'];
            $key = $app['signkey'];
            $out_trade_no = $order_id; //订单号
            $body = "账户充值";
            $total_fee = $money * 100;
            if (isset($app['identity'])) {
                $identity = $app['identity'];
            } else {
                $identity = 1;
            }
            if (isset($app['sub_mchid'])) {
                $sub_mchid = $app['sub_mchid'];
            } else {
                $sub_mchid = 0;
            }
            $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee, $identity, $sub_mchid);
            $return = $weixinpay->pay();
            $return['order_id'] = $order_id;
            $adata['data'] = $return;
            $adata['message'] = "success";
            return json_encode($adata);
        }
    }
    public function Comment()
    {
        $uniacid = input("uniacid");
        $id = intval(input("id"));
        $pinglun_t = input("pinglun_t");
        $openid = input("openid");
        $data = array(
            'aid' => $id,
            'text' => $pinglun_t,
            'openid' => $openid,
            'uniacid' => $uniacid,
            'createtime' => time()
        );
        $result = Db::table('ims_sudu8_page_comment')->insert($data);
        if ($result == 1) {
            $res['data'] = array('result' => 1);
            return json_encode($res);
        } else {
            $res['data'] = array('result' => 2);
            return json_encode($res);
        }
    }
    public function getComment()
    {
        $uniacid = input("uniacid");
        $id = intval(input("id"));
        $flag = input("comms");
        if ($flag == 1) {
            $comment = Db::table('ims_sudu8_page_comment')->alias('a')->join('ims_sudu8_page_user b', 'a.openid = b.openid')->where("b.uniacid", $uniacid)->where('a.aid', $id)->where('a.flag', '1')->order('a.follow desc')->order('a.id desc')->field('a.id,a.text,a.createtime,a.follow,b.avatar,b.nickname')->select();
        } else {
            $comment = Db::table('ims_sudu8_page_comment')->alias('a')->join('ims_sudu8_page_user b', 'a.openid = b.openid')->where("b.uniacid", $uniacid)->where('a.aid', $id)->where('a.flag', 'neq', '2')->order('a.follow desc')->order('a.id desc')->field('a.id,a.text,a.createtime,a.follow,b.avatar,b.nickname')->select();
        }
        if ($comment) {
            foreach ($comment as $k => $v) {
                $comment[$k]['ctime'] = date('Y年m月d日 H:i:s', $v['createtime']);
            }
        }
        $result['data'] = $comment;
        return json_encode($result);
    }
    public function commentFollow()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        $follow = Db::table('ims_sudu8_page_comment')->where("id", $id)->where("uniacid", $uniacid)->field('id,follow')->find();
        $follow = intval($follow['follow']) + 1;
        $data = array(
            'id' => $id,
            'follow' => $follow,
        );
        $result = Db::table('ims_sudu8_page_comment')->where("id", $id)->update($data);
        if ($result) {
            $res['data'] = array('result' => 1);
            return json_encode($res);
        }
    }
    public function doPageUseupdate()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $user = Db::table('ims_sudu8_page_user')->where("openid", $openid)->where("uniacid", $uniacid)->find();
        $data = array(
            "uniacid" => $uniacid,
            "nickname" => $this->emoji_encode(input("nickname")),
            "openid" => $openid,
            "avatar" => input("avatarUrl"),
            "gender" => input("gender"),
            "resideprovince" => input("province"),
            "residecity" => input("city"),
            "nationality" => input("country"),
            "address" => input("address"),
            "company" => input("company"),
            "position" => input("position"),
        );
        if ($user) {
            $res = Db::table('ims_sudu8_page_user')->where("openid", $openid)->where("uniacid", $uniacid)->update($data);
        } else {
            $res = Db::table('ims_sudu8_page_user')->insert($data);
        }
        // 新增返回个人信息
        $newuserinfo = Db::table('ims_sudu8_page_user')->where("openid", $openid)->where("uniacid", $uniacid)->find();
        $parent_id = $newuserinfo['parent_id'];
        if ($parent_id != '0') {
            $tjr = Db::table('ims_sudu8_page_user')->where("openid", $parent_id)->where("uniacid", $uniacid)->find();
            if ($tjr['fxs'] == 2) {
                $newuserinfo['tjr'] = $tjr['realname'];
            } else {
                $newuserinfo['tjr'] = "您是由平台方推荐";
            }
        } else {
            $newuserinfo['tjr'] = "您是由平台方推荐";
        }
        $result['data'] = $newuserinfo;
        return json_encode($result);
    }
    //核销密码
    public function hxmm()
    {
        $uniacid = input("uniacid");
        $order_id = input("order_id");
        $hxmm = input("hxmm");
        $openid = input("openid"); //pt id
        $array1=array();//所有员工编号
        $hxmms = array();
        $hxinfo = array();
        $is_more = input("is_more");  //0秒杀 1预约预定 3拼团 2多规格订单
        //秒杀商品核销获取是否有所属门店
        if($is_more == 0 || $is_more == 3 || $is_more == 1 || $is_more == 2){  
            if($is_more == 0 || $is_more == 1){//0秒杀 1预约预定 3拼团 2多规格订单
                $proinfo = Db::table('ims_sudu8_page_order')->alias("a")->join("ims_sudu8_page_products b", "a.pid = b.id")->where("a.uniacid", $uniacid)->where("a.order_id", $order_id)->field("b.stores")->find();
            }else if($is_more == 2){//0秒杀 1预约预定 3拼团 2多规格订单
                $duoorder = Db::table('ims_sudu8_page_duo_products_order')->where('order_id', $order_id)->where("uniacid", $uniacid)->find();
                if($duoorder['jsondata']){
                    $jsondata = unserialize($duoorder['jsondata']);
                    $proinfo = Db::table('ims_sudu8_page_products')->where('id', $jsondata[0]['baseinfo']['id'])->where("uniacid", $uniacid)->find();
                }else{
                    $proinfo = array();
                    $proinfo['stores'] = "";
                }
            }else if($is_more == 3){//0秒杀 1预约预定 3拼团 2多规格订单
                $proinfo = Db::table('ims_sudu8_page_pt_share')->alias("a")->join("ims_sudu8_page_pt_pro b", "a.pid = b.id")->where("a.uniacid", $uniacid)->where("a.shareid", $order_id)->field("b.stores")->find();
            }
              
            if(!empty($proinfo['stores'])){
                $stores = explode(",", $proinfo['stores']);
                foreach ($stores as $key => $value) {
                      $staff = Db::table('ims_sudu8_page_staff')->where("store",$value)->where("uniacid",$uniacid)->field("id,hxmm")->select();
                      if(!empty($staff)){
                        foreach ($staff as $k => $v) {
                            if($hxmm == $v['hxmm']){
                                $hxinfo[0] = 2;
                                $hxinfo[1] = $value;
                                $hxinfo[2] = $v['id'];
                                $data['custime'] = time();
                                $data['flag'] = 2;
                                $data['hxinfo'] = $hxinfo;
                                if($openid){ //拼团
                                    Db::table('ims_sudu8_page_pt_order')->where("pt_order", $order_id)->where("uniacid", $uniacid)->where("openid", $openid)->update(array("hxinfo" => serialize($hxinfo), "hxtime" => time()));
                                }else if(intval($is_more) == 2){
                                    $upd['hxinfo'] = serialize($hxinfo);
                                    $upd['flag'] = 2;
                                    $upd['hxtime'] = time();
                                    Db::table('ims_sudu8_page_duo_products_order')->where("order_id", $order_id)->where("uniacid", $uniacid)->update($upd);
                                }else{
                                    $data['hxinfo'] = serialize($hxinfo);
                                    Db::table('ims_sudu8_page_order')->where("order_id", $order_id)->where("uniacid", $uniacid)->update($data);
                                }
                                return json_encode(array('data' => 1));
                                exit;
                            }
                            
                        }
                      }
                }
            }
        }
        $hxmmarr = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->find();
        if ($hxmmarr['hxmm'] != $hxmm) {
            return json_encode(array('data' => 0));
        } else {
            if($is_more == 0 || $is_more == 1){
                $hxinfo[0] = 1;
                $data['hxinfo'] = serialize($hxinfo);
            }else if($is_more == 2){
//                var_dump($order_id);
//                exit();
                $orderinfo = Db::table('ims_sudu8_page_duo_products_order') ->where("order_id", $order_id)->where("uniacid", $uniacid) ->find();
                if($orderinfo['flag'] == 2){
                     return json_encode(array('data' => 2));
                }
                $hxinfo[0] = 1;
                 Db::table('ims_sudu8_page_duo_products_order')->where("order_id", $order_id)->where("uniacid", $uniacid)->update(array("hxinfo" => serialize($hxinfo), "hxtime" => time(), "flag" => 2));
                 //核销密码送积分
                
                $jsondata = unserialize($orderinfo['jsondata']);
                $total_num = 0;
                $total_price = 0;
                foreach ($jsondata as $key => &$value) {
                    $total_num += $value['num'];
                    $total_price += $value['proinfo']['price'] * $value['num'];
                }
                $a=Db::table("ims_sudu8_page_products")->where("uniacid",$uniacid)->where("id",$jsondata[0]['baseinfo']['id'])->find();
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
                        $new_user=Db::table("ims_sudu8_page_user")->where("uniacid",$uniacid)->where("id",$orderinfo['uid'])->find();
                        $new_my_score = $new_user['score'] + $scoreback;
                       Db::table("ims_sudu8_page_user")->where("uniacid",$uniacid)->where("id",$new_user['id'])->update(array("score"=>$new_my_score));
                        $scoreback_data = array(
                            "uniacid" => $uniacid,
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


                 //
                return json_encode(array('data' => 1));
                exit;
            }else if($is_more == 3){
                $hxinfo[0] = 1;
                Db::table('ims_sudu8_page_pt_order')->where("pt_order", $order_id)->where("uniacid", $uniacid)->where("openid", $openid)->update(array("hxinfo" => serialize($hxinfo), "hxtime" => time()));
                return json_encode(array('data' => 1));
                exit;
            }
            $data['custime'] = time();
            $data['flag'] = 2;
            $res = Db::table('ims_sudu8_page_order')->where("order_id", $order_id)->where("uniacid", $uniacid)->update($data);
            return json_encode(array('data' => 1));
        }
    }
    // 0521前端未查到
    // public function doPageMyscore(){
    //  $uniacid = input("uniacid");
    //     $openid = input("openid");
    //     $userscore = Db::table('ims_sudu8_page_user')->where("uniacid",$uniacid)->where("openid",$openid)->find();
    //     return json_encode($userscore);
    // }
    //上传图片
    public function wxupimg()
    {
        $file = request()->file('file');
        $info = $file->move(ROOT_PATH . 'public/upimages');
        if ($info) {
            return ROOT_HOST . "/upimages/" . $info->getSaveName();
            die();
        } else {
            echo $file->getError();
            die();
        }
    }
    public function Hxyhq()
    {
        $uniacid = input("uniacid");
        $youhqid = input("youhqid");
        $hxmm = input("hxmm");
        $hxmmarr = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->find();
        if ($hxmmarr['hxmm'] != $hxmm) {
            return json_encode(array('data' => 0));
        } else {
            $data['utime'] = time();
            $data['flag'] = 1;
            $res = Db::table('ims_sudu8_page_coupon_user')->where("id", $youhqid)->where("uniacid", $uniacid)->update($data);
            if ($res) {
                return json_encode(array('data' => 1));
            } else {
                return json_encode(array('data' => 0));
            }
        }
    }
    /*多栏目开始*/
    public function doPagechangelist()
    {
        $uniacid = input('uniacid');
        $cid = input('cid') ? input('cid') : '0';
        $multi_id = input('multi_id');
        if ($cid == "0") {
            $data['pro_list'] = Db::table('ims_sudu8_page_products')->where('multi', 1)->where('top_catas', 'neq', '')->where('mulitcataid', $multi_id)->select();
            $num = count($data['pro_list']);
            for ($i = 0; $i < $num; $i++) {
                if (stristr($data['pro_list'][$i]['thumb'], 'http')) {
                    $data['pro_list'][$i]['thumb'] = $data['pro_list'][$i]['thumb'];
                } else {
                    $data['pro_list'][$i]['thumb'] = remote($uniacid, $data['pro_list'][$i]['thumb'], 1);
                }
            }
            return json_encode($data);
            exit;
        } else {
            $cid = explode(',', $cid);
            $pid = input('pid') ? explode('-', input('pid')) : '';
            $sql = "SELECT * FROM ims_sudu8_page_products WHERE multi = 1 AND `mulitcataid` = " . $multi_id;
            foreach ($cid as $k => $v) {
                if ($v == 0) {
                    $sql .= " AND find_in_set('" . $pid[$k] . "',top_catas)";
                } else {
                    $sql .= " AND find_in_set('" . $v . "',sons_catas)";
                }
            }
            $sql .= " AND top_catas != ''";
            $data['pro_list'] = Db::query($sql);
            $num = count($data['pro_list']);
            for ($i = 0; $i < $num; $i++) {
                if (stristr($data['pro_list'][$i]['thumb'], 'http')) {
                    $data['pro_list'][$i]['thumb'] = $data['pro_list'][$i]['thumb'];
                } else {
                    $data['pro_list'][$i]['thumb'] = remote($uniacid, $data['pro_list'][$i]['thumb'], 1);
                }
            }
            return json_encode($data);
            exit;
        }
        return json_encode($data);
    }
    public function doPagelistArt_duo()
    {
        $uniacid = input('uniacid');
        $multi_id = input('multi_id');
        $cid = Db::table('ims_sudu8_page_multicate')->where('id', $multi_id)->find();
        if ($cid) {
            $data['cate'] = $cid;
        }
        $topcate = unserialize($cid['cid']);
        $sql = "SELECT * FROM ims_sudu8_page_products WHERE multi = 1 AND top_catas != '' AND `mulitcataid` =" . $multi_id;
        $data['pro_list'] = Db::query($sql);
        $num = count($data['pro_list']);
        for ($i = 0; $i < $num; $i++) {
            if (stristr($data['pro_list'][$i]['thumb'], 'http')) {
                $data['pro_list'][$i]['thumb'] = $data['pro_list'][$i]['thumb'];
            } else {
                $data['pro_list'][$i]['thumb'] = remote($uniacid, $data['pro_list'][$i]['thumb'], 1);
            }
        }
        $mlid = input('multi_id');
        $top_catas = Db::table('ims_sudu8_page_multicate')->where('id', $mlid)->field("top_catas")->find();
        if ($top_catas) {
            $top_one = Db::table('ims_sudu8_page_multicates')->where('id', 'in', unserialize($top_catas['top_catas']))->select();
            foreach ($top_one as $k => $v) {
                $top_one[$k]['sons'] = Db::table('ims_sudu8_page_multicates')->where('pid', $v['id'])->select();
            }
            $data['topcate'] = $top_one;
        }
        return json_encode($data);
    }
    public function doPagegetcate()
    {
        $cid = input('cid');
        $subcate = Db::table('ims_sudu8_page_cate')->where('cid', $cid)->field('id,name')->select();
        $result['data'] = $subcate;
        return json_encode($result);
    }
    public function doPageBase()
    {
        $uniacid = input('uniacid');
        $fxsid = input('fxsid');
        $baseInfo = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->find();
        $baseInfo['banner'] = remote($uniacid, $baseInfo['banner'], 1);
        // dump($baseInfo);die;
        $baseInfo['ot'] = Db::table('ims_sudu8_page_forms_config')->where("uniacid", $uniacid)->field('forms_name')->find();
        if ($baseInfo['ot']['forms_name'] == "") {
            $baseInfo['ot']['forms_name'] = "在线预约";
        }
        //展开新版广告的配置参数
        $config = unserialize($baseInfo['config']);
        $baseInfo['bigadT'] = $config['bigadT'];
        $baseInfo['bigadC'] = $config['bigadC'];
        $baseInfo['bigadCTC'] = intval($config['bigadCTC']);
        $baseInfo['bigadCNN'] = $config['bigadCNN'];
        $baseInfo['miniadT'] = $config['miniadT'];
        $baseInfo['newhead'] = $config['newhead'];
        $baseInfo['search'] = $config['search'];
        $baseInfo['copT'] = $config['copT'];
        $baseInfo['userFood'] = $config['userFood'];
        if (isset($config['commA'])) {
            $baseInfo['commA'] = $config['commA'];
        } else {
            $baseInfo['commA'] = 0;
        }
        if (isset($config['commAs'])) {
            $baseInfo['commAs'] = $config['commAs'];
        } else {
            $baseInfo['commAs'] = 0;
        }
        if (isset($config['commP'])) {
            $baseInfo['commP'] = $config['commP'];
        } else {
            $baseInfo['commP'] = 0;
        }
        if (isset($config['commPs'])) {
            $baseInfo['commPs'] = $config['commPs'];
        } else {
            $baseInfo['commPs'] = 0;
        }
        if (isset($config['serverBtn'])) {
            $baseInfo['serverBtn'] = $config['serverBtn'];
        } else {
            $baseInfo['serverBtn'] = 1;
        }
        //幻灯片
        if ($baseInfo['index_style'] == "slide") {
            $slide = unserialize(Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field('slide')->find()['slide']);
            if ($slide) {
                foreach ($slide as $key => $value) {
                    $slide[$key] = remote($uniacid, $value, 1);
                }
                $baseInfo['slide'] = $slide;
            } else {
                $baseInfo['slide'] = "";
            }
        }
        //新幻灯片
        if ($baseInfo['index_style'] == "newslide") {
            $slide = Db::table('ims_sudu8_page_banner')->where("uniacid", $uniacid)->where("type", "banner")->where("flag", 1)->field("pic,url")->order('num desc,id desc')->select();
            $num = count($slide);
            $baseInfo['slide'] = array();
            if ($num > 0) {
                for ($i = 0; $i < $num; $i++) {
                    if ($slide[$i]['pic']) {
                        $baseInfo['slide'][$i]['pic'] = remote($uniacid, $slide[$i]['pic'], 1);
                    } else {
                        $baseInfo['slide'][$i]['pic'] = "";
                    }
                    $baseInfo['slide'][$i]['url'] = $slide[$i]['url'];
                }
            }
        }
        //开屏广告
        if ($config['bigadT'] == "1") {
            $slide = Db::table('ims_sudu8_page_banner')->where("uniacid", $uniacid)->where("type", "bigad")->where('flag', 1)->field("pic")->order('num desc,id desc')->select();
            $num = count($slide);
            $baseInfo['bigad'] = array();
            for ($i = 0; $i < $num; $i++) {
                if ($slide[$i]['pic']) {
                    $slide[$i]['pic'] = remote($uniacid, $slide[$i]['pic'], 1);
                } else {
                    $slide[$i]['pic'] = "";
                }
                $baseInfo['bigad'][$i] = $slide[$i]['pic'];
            }
        }
        if ($config['bigadT'] == "2") {
            $slide = Db::table('ims_sudu8_page_banner')->where("uniacid", $uniacid)->where("type", "bigad")->where('flag', 1)->field("pic,url")->order('num desc,id desc')->select();
            $num = count($slide);
            $baseInfo['bigad'] = array();
            for ($i = 0; $i < $num; $i++) {
                if ($slide[$i]['pic']) {
                    if (stristr($slide[$i]['pic'], 'http')) {
                        $baseInfo['bigad'][$i]['pic'] = $slide[$i]['pic'];
                    } else {
                        $baseInfo['bigad'][$i]['pic'] = remote($uniacid, $slide[$i]['pic'], 1);
                    }
                } else {
                    $baseInfo['bigad'][$i]['pic'] = "";
                }
                $baseInfo['bigad'][$i]['url'] = $slide[$i]['url'];
            }
        }
        //弹窗广告
      if ($config['miniadT'] == "1" || $config['miniadT'] == "2") {
//        if ($config['miniadT'] == "2") {
            $slide = Db::table('ims_sudu8_page_banner')->where("uniacid", $uniacid)->where("type", "miniad")->where('flag', 1)->order('num desc,id desc')->select();
            $num = count($slide);
            $baseInfo['miniad'] = array();
            // dump($baseInfo);die;
            for ($i = 0; $i < $num; $i++) {
                $baseInfo['miniad'][$i] = array();
                if ($slide[$i]['pic']) {
                    if (stristr($slide[$i]['pic'], 'http')) {
                        $baseInfo['miniad'][$i]['pic'] = $slide[$i]['pic'];
                    } else {
                        $baseInfo['miniad'][$i]['pic'] = remote($uniacid, $slide[$i]['pic'], 1);
                    }
                } else {
                    $baseInfo['miniad'][$i]['pic'] = "";
                }
                $baseInfo['miniad'][$i]['descp'] = $slide[$i]['descp'];
                $baseInfo['miniad'][$i]['url'] = $slide[$i]['url'];
            }
            $baseInfo['miniadN'] = $config['miniadN'];
            $baseInfo['miniadB'] = $config['miniadB'];
        }
        $baseInfo['logo'] = remote($uniacid, $baseInfo['logo'], 1);
        $baseInfo['logo2'] = remote($uniacid, $baseInfo['logo2'], 1);
        if ($baseInfo['copyimg']) {
            $baseInfo['copyimg'] = remote($uniacid, $baseInfo['copyimg'], 1);
        }
        if ($baseInfo['video']) {
            $video_url = stristr($baseInfo['video'], 'http');
            if (empty($video_url)) {
                $video_url = $baseInfo['video'];
            }
            //判断视频的格式
            $jiew = substr($video_url, strlen($video_url) - 4, strlen($video_url));
            if ($jiew == ".mp4") {
                $baseInfo['video'] = $video_url;
            } else {
                include 'videoInfo.php';
                $videoInfo = new videoInfo();
                $videodata = $videoInfo->getVideoInfo($video_url);
                $baseInfo['video'] = $videodata['url'];
            }
        }
        if ($baseInfo['v_img']) {
            $baseInfo['v_img'] = remote($uniacid, $baseInfo['v_img'], 1);
        }
        if ($baseInfo['c_b_bg']) {
            $baseInfo['c_b_bg'] = remote($uniacid, $baseInfo['c_b_bg'], 1);
        }
        $vs1 = input('vs1');
        if ($vs1) {
            $baseInfo['tabbar'] = unserialize($baseInfo['tabbar_new']);
            $baseInfo['tabnum'] = $baseInfo['tabnum_new'];
            for ($i = 0; $i < $baseInfo['tabnum']; $i++) {
                $baseInfo['tabbar'][$i] = unserialize($baseInfo['tabbar'][$i]);
                if ($baseInfo['tabbar'][$i]) {
                    if ($baseInfo['tabbar'][$i]) {
                        if($baseInfo['tabbar'][$i]['tabbar'] == 1){
                            if(!empty($baseInfo['tabbar'][$i]['tabimginput_1'])){
                                $baseInfo['tabbar'][$i]['tabimginput_1'] = remote($uniacid,$baseInfo['tabbar'][$i]['tabimginput_1'],1);
                            }
                            if(!empty($baseInfo['tabbar'][$i]['tabimginput_2'])){
                                $baseInfo['tabbar'][$i]['tabimginput_2'] = remote($uniacid,$baseInfo['tabbar'][$i]['tabimginput_2'],1);
                            }
                        }
                        if ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "tel") {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "tel";
                        } elseif ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "map") {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "map";
                        } elseif ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "web") {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "web";
                        } elseif ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "server") {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "server";
                        } else {
                            $baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
                        }
                    }
                }
            }
        } else {
            $baseInfo['tabbar'] = unserialize($baseInfo['tabbar']);
            if ($baseInfo['tabbar']) {
                $arrcount = count($baseInfo['tabbar']);
                for ($i = 0; $i < $arrcount; $i++) {
                    $baseInfo['tabbar'][$i] = unserialize($baseInfo['tabbar'][$i]);
                    if (is_numeric($baseInfo['tabbar'][$i]['tabbar_l'])) {
                        $cate_type = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $baseInfo['tabbar'][$i]['tabbar_l'])->find();
                        if ($cate_type['type'] == "page") {
                            $baseInfo['tabbar'][$i]['type'] = 'page';
                        }
                        if ($cate_type['type'] == "coupon") {
                            $baseInfo['tabbar'][$i]['type'] = 'coupon';
                        }
                        if ($cate_type['list_type'] == 0 && $cate_type['type'] != "page" && $cate_type['type'] != "coupon") {
                            $baseInfo['tabbar'][$i]['type'] = 'listCate';
                        } elseif ($cate_type['list_type'] == 1 && $cate_type['type'] != "page" && $cate_type['type'] != "coupon") {
                            $baseInfo['tabbar'][$i]['type'] = 'list' . substr($cate_type['type'], 4, strlen($cate_type['type']));
                        }
                    }
                    if (strpos($baseInfo['tabbar'][$i]['tabbar_p1'], "http") !== false) {
                        $baseInfo['tabbar'][$i]['tabbar_p1'] = $baseInfo['tabbar'][$i]['tabbar_p1'];
                    } else {
                        $baseInfo['tabbar'][$i]['tabbar_p1'] = remote($uniacid, $baseInfo['tabbar'][$i]['tabbar_p1'], 1);
                    }
                    if (strpos($baseInfo['tabbar'][$i]['tabbar_p2'], "http") !== false) {
                        $baseInfo['tabbar'][$i]['tabbar_p2'] = $baseInfo['tabbar'][$i]['tabbar_p2'];
                    } else {
                        $baseInfo['tabbar'][$i]['tabbar_p2'] = remote($uniacid, $baseInfo['tabbar'][$i]['tabbar_p2'], 1);
                    }
                }
            } else {
                $baseInfo['tabbar_t'] = 0;
            }
        }
        $userinfo = $this->dopageglobaluserinfo();
        $baseInfo['userinfo'] = $userinfo;
        $adata['data'] = $baseInfo;
        return json_encode($adata);
    }
    // 获取全局情况
    public function dopageglobaluserinfo()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        $newuserinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        $parent_id = $newuserinfo['parent_id'];
        if ($parent_id != '0') {
            $tjr = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $parent_id)->field("openid,fxs")->find();
            $tjrname = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $tjr['openid'])->field("nickname")->find();
            if ($tjr['fxs'] == 2) {
                $newuserinfo['tjr'] = $tjrname['nickname'];
            } else {
                $newuserinfo['tjr'] = "您是由平台方推荐";
            }
        } else {
            $newuserinfo['tjr'] = "您是由平台方推荐";
        }
        
        if(isset($newuserinfo['nickname'])){
            $newuserinfo['nickname'] = rawurldecode($newuserinfo['nickname']);
        }
        
        $res['data'] = $newuserinfo;
        return json_encode($res);
    }
    public function doPageAbout()
    {
        $uniacid = input('uniacid');
        $aboutInfo = Db::table('ims_sudu8_page_about')->where("uniacid", $uniacid)->find();
        //老幻灯片
        if ($aboutInfo['header'] == "2") {
            $slideAll = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field("slide")->find();
            $aboutInfo['slide'] = unserialize($slideAll['slide']);
            $num = count($aboutInfo['slide']);
            for ($i = 0; $i < $num; $i++) {
                $aboutInfo['slide'][$i] = remote($uniacid, $aboutInfo['slide'][$i], 1);
            }
        }
        //新幻灯片
        if ($aboutInfo['header'] == "3") {
            $slide = Db::table('ims_sudu8_page_banner')->where("uniacid", $uniacid)->where("type", "banner")->where("flag", 1)->field("pic,url")->order('num desc,id desc')->select();
            $num = count($slide);
            $aboutInfo['slide'] = array();
            for ($i = 0; $i < $num; $i++) {
                $aboutInfo['slide'][$i]['pic'] = remote($uniacid, $slide[$i]['pic'], 1);
                $aboutInfo['slide'][$i]['url'] = $slide[$i]['url'];
            }
        }
        $adata['data'] = $aboutInfo;
        return json_encode($adata);
    }
    public function doPageCommon()
    {
        $uniacid = input('uniacid');
        $copyright = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field("copyright,tel,tel_b,latitude,longitude,name,address")->find();
        $adata['data'] = $copyright;
        return json_encode($adata);
    }
    public function doPageProducts()
    {
        $uniacid = input('uniacid');
        $products = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->field("id,type,num,title,thumb,`desc`,buy_type")->order('num desc,id desc')->select();
        foreach ($products as &$row) {
            $row['thumb'] = remote($uniacid, $row['thumb'], 1);
        }
        $adata['data'] = $products;
        return json_encode($adata);
    }
    public function doPageProductsList()
    {
        $uniacid = input('uniacid');
        $pindex = max(1, intval(input("page")));
        $psize = 10;
        $begin = ($pindex - 1) * $psize;
        $ProductsList = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->field("id,type,num,title,thumb,`desc`,buy_type")->order('num desc,id desc')->limit($begin, $psize)->select();
        foreach ($ProductsList as &$row) {
            $row['thumb'] = remote($uniacid, $row['thumb'], 1);
        }
        $adata['data'] = $ProductsList;
        return json_encode($adata);
    }
    public function doPageProductsDetail()
    {
        $uniacid = input('uniacid');
        $id = intval(input("id"));
        $openid = input("openid");
        $ProductsDetail = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where("id", $id)->find();
        if ($ProductsDetail['music_art_info'] == "") {
            $ProductsDetail['music_art_info']['music'] = "";
            $ProductsDetail['music_art_info']['musicTitle'] = "";
            $ProductsDetail['music_art_info']['music_price'] = "";
            $ProductsDetail['music_art_info']['autoPlay'] = "";
            $ProductsDetail['music_art_info']['loopPlay'] = "";
            $ProductsDetail['music_art_info']['art_price'] = "";
        } else {
            $ProductsDetail['music_art_info'] = unserialize($ProductsDetail['music_art_info']);
        }
        $artpay = 0;
        if ($ProductsDetail['music_art_info']['art_price'] == 0 || $ProductsDetail['music_art_info']['art_price'] == "") {  //不需要付费直接可播放状态为1
            $artpay = 1;
        } else {  //需要付费去查有没有付费记录
            $artpayflag = Db::table('ims_sudu8_page_video_pay')->where('openid', $openid)->where('pid', $id)->where("type", 3)->where('uniacid', $uniacid)->find();
            //1.如果有支付的记录
            if ($artpayflag) {
                $artpay = 1;
            }
        }
        $ProductsDetail['artpay'] = $artpay;
        $musicpay = 0;
        if ($ProductsDetail['music_art_info']['music_price'] == 0 || $ProductsDetail['music_art_info']['music_price'] == "") {  //不需要付费直接可播放状态为1
            $musicpay = 1;
        } else {  //需要付费去查有没有付费记录
            $musicpayflag = Db::table('ims_sudu8_page_video_pay')->where('openid', $openid)->where('pid', $id)->where('uniacid', $uniacid)->where("type", 2)->find();
            //1.如果有支付的记录
            if ($musicpayflag) {
                $musicpay = 1;
            }
        }
        $ProductsDetail['musicpay'] = $musicpay;
        if ($ProductsDetail['shareimg']) {
            $ProductsDetail['thumbimg'] = remote($uniacid, $ProductsDetail['shareimg'], 1);
            // if (strpos($ProductsDetail['thumbimg'], 'https') === false) {
            //     $ProductsDetail['thumbimg'] = "https" . substr($ProductsDetail['thumbimg'], 4);
            // }
        } else {
            $ProductsDetail['thumbimg'] = remote($uniacid, $ProductsDetail['thumb'], 1);
            // if (strpos($ProductsDetail['thumbimg'], 'https') === false) {
            //     $ProductsDetail['thumbimg'] = "https" . substr($ProductsDetail['thumbimg'], 4);
            // }
        }
        if (!$ProductsDetail['price']) {
            $ProductsDetail['price'] = 0;
        }
        if (intval($ProductsDetail['pro_flag']) > 0) {
            $ProductsDetail['navlist'] = Db::table('ims_sudu8_page_art_navlist')->where("uniacid", $uniacid)->where("cid", intval($ProductsDetail['pro_flag']))->where('flag', 1)->order('num desc')->select();
            $ProductsDetail['navlistnum'] = count($ProductsDetail['navlist']);
        }
        $hits = $ProductsDetail['hits'] + 1;
        $data = array(
            'hits' => $hits
        );
        Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where("id", $id)->update($data);
        if ($ProductsDetail['edittime']) {
            $ProductsDetail['edittime'] = date("Y-m-d H:i:s", $ProductsDetail['edittime']);
        }
        if ($ProductsDetail['etime']) {
            $ProductsDetail['etime'] = date("Y-m-d H:i:s", $ProductsDetail['etime']);
        } else {
            $ProductsDetail['etime'] = date("Y-m-d H:i:s", $ProductsDetail['ctime']);
        }
        $ProductsDetail['ctime'] = date("Y-m-d H:i:s", $ProductsDetail['ctime']);
        if ($ProductsDetail['video']) {
            include __DIR__ . '/videoInfo.php';
            $videoInfo = new videoInfo();
            $videodata = $videoInfo->getVideoInfo($ProductsDetail['video']);
            $ProductsDetail['video'] = $videodata['url'];
        }
        $videopay = 0;
        if ($ProductsDetail['price'] == 0) {  //不需要付费直接可播放状态为1
            $videopay = 1;
        } else {  //需要付费去查有没有付费记录
            $videopayflag = Db::table('ims_sudu8_page_video_pay')->where("uniacid", $uniacid)->where("pid", $id)->where("openid", $openid)->where("type", 1)->find();
            //1.如果有支付的记录
            if ($videopayflag) {
                $videopay = 1;
            }
        }
        $ProductsDetail['videopay'] = $videopay;
        if ($ProductsDetail['labels']) {
            if (strpos($ProductsDetail['labels'], "http") !== false) {
                $ProductsDetail['labels'] = $ProductsDetail['labels'];
            } else {
                $ProductsDetail['labels'] = remote($uniacid, $ProductsDetail['labels'], 1);
            }
        } else {
            if (strpos($ProductsDetail['thumb'], "http") !== false) {
                $ProductsDetail['thumb'] = $ProductsDetail['thumb'];
            } else {
                $ProductsDetail['thumb'] = remote($uniacid, $ProductsDetail['thumb'], 1);
            }
        }
        $ProductsDetail['btn'] = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $ProductsDetail['cid'])->find();
        $cateConf = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $ProductsDetail['cid'])->field('cateconf')->find();
        $cateConf = unserialize($cateConf['cateconf']);
        $ProductsDetail['pmarb'] = $cateConf['pmarb'];
        $ProductsDetail['ptit'] = $cateConf['ptit'];
        $formset = $ProductsDetail['formset'];
        if ($formset != 0 && $formset != "") {
            $forms = Db::table('ims_sudu8_page_formlist')->where("id", $formset)->find();
            $forms2 = unserialize($forms['tp_text']);
            foreach ($forms2 as $key => &$res) {
                if ($res['tp_text']) {
                    $res['tp_text'] = explode(",", $res['tp_text']);
                }
                $res['val'] = '';
            }
        } else {
            $forms2 = "NULL";
        }
        $ProductsDetail['forms'] = $forms2;
        $likeArt = Db::table('ims_sudu8_page_products')->where("id", $id)->find();
        $ProductsDetail['likeArtList'] = array();
        if ($likeArt['glnews']) {
            $likeArt = unserialize($likeArt['glnews']);
            foreach ($likeArt as $v) {
                $likeArtArr = Db::table('ims_sudu8_page_products')->where("id", $v)->field("id,num,thumb,`desc`,title ")->find();
                if ($likeArtArr['thumb']) {
                    $likeArtArr['thumb'] = remote($uniacid, $likeArtArr['thumb'], 1);
                }
                array_push($ProductsDetail['likeArtList'], $likeArtArr);
            }
        }
        $result['data'] = $ProductsDetail;
        return json_encode($result);
    }
    //17.08.04 新增留言功能 sudu8//
    public function doPageFormsConfig()
    {
        $uniacid = input('uniacid');
        $formsConfig = Db::table('ims_sudu8_page_forms_config')->where("uniacid", $uniacid)->find();
        $formsConfig['t5'] = unserialize($formsConfig['t5']);
        $formsConfig['t6'] = unserialize($formsConfig['t6']);
        $formsConfig['c2'] = unserialize($formsConfig['c2']);
        $formsConfig['s2'] = unserialize($formsConfig['s2']);
        $formsConfig['con2'] = unserialize($formsConfig['con2']);
        //老幻灯片
        if ($formsConfig['forms_head'] == "slide") {
            $slideAll = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field("slide")->find();
            $formsConfig['slide'] = unserialize($slideAll['slide']);
            $num = count($formsConfig['slide']);
            for ($i = 0; $i < $num; $i++) {
                $formsConfig['slide'][$i] = $formsConfig['slide'][$i];
            }
        }
        //新幻灯片
        if ($formsConfig['forms_head'] == "newslide") {
            $slide = Db::table('ims_sudu8_page_banner')->where("uniacid", $uniacid)->where("type", "banner")->field("pic,url")->order('num desc,id desc')->select();
            $num = count($slide);
            $formsConfig['slide'] = array();
            for ($i = 0; $i < $num; $i++) {
                $formsConfig['slide'][$i]['pic'] = $slide[$i]['pic'];
                $formsConfig['slide'][$i]['url'] = $slide[$i]['url'];
            }
        }
        //单选两个
        if (!empty($formsConfig['single_num']) and $formsConfig['single_num'] != 0) {
            $single_num = 100 / $formsConfig['single_num'];
            if ($single_num > 100 or $single_num < 20) {
                $formsConfig['single_num'] = 100;
            } else {
                $formsConfig['single_num'] = $single_num;
            }
        } else {
            $formsConfig['single_num'] = 100;
        }
        if (empty($formsConfig['single_v'])) {
            $formsConfig['single_v'] = "";
        }
        if (!empty($formsConfig['s2']['s2num']) and $formsConfig['s2']['s2num'] != 0) {
            $single_num2 = 100 / $formsConfig['s2']['s2num'];
            if ($single_num2 > 100 or $single_num2 < 20) {
                $formsConfig['s2']['s2num'] = 100;
            } else {
                $formsConfig['s2']['s2num'] = $single_num2;
            }
        } else {
            $formsConfig['s2']['s2num'] = 100;
        }
        //复选的
        if (!empty($formsConfig['checkbox_num']) and $formsConfig['checkbox_num'] != 0) {
            $checkbox_num = 100 / $formsConfig['checkbox_num'];
            if ($checkbox_num > 100 or $checkbox_num < 20) {
                $formsConfig['checkbox_num'] = 100;
            } else {
                $formsConfig['checkbox_num'] = $checkbox_num;
            }
        } else {
            $formsConfig['checkbox_num'] = 100;
        }
        if (!empty($formsConfig['c2']['c2num']) and $formsConfig['c2']['c2num'] != 0) {
            $checkbox_num2 = 100 / $formsConfig['c2']['c2num'];
            if ($checkbox_num2 > 100 or $checkbox_num2 < 20) {
                $formsConfig['c2']['c2num'] = 100;
            } else {
                $formsConfig['c2']['c2num'] = $checkbox_num2;
            }
        } else {
            $formsConfig['c2']['c2num'] = 100;
        }
        $adata['data'] = $formsConfig;
        return json_encode($adata);
    }
    //表单提交
    public function doPageAddForms()
    {
        $uniacid = input('uniacid');
        $formsConfig = Db::table('ims_sudu8_page_forms_config')->where("uniacid", $uniacid)->find();
        if ($formsConfig['t5']) {
            $formsConfig['t5'] = unserialize($formsConfig['t5']);
        }
        if ($formsConfig['t6']) {
            $formsConfig['t6'] = unserialize($formsConfig['t6']);
        }
        if ($formsConfig['c2']) {
            $formsConfig['c2'] = unserialize($formsConfig['c2']);
        }
        if ($formsConfig['s2']) {
            $formsConfig['s2'] = unserialize($formsConfig['s2']);
        }
        if ($formsConfig['con2']) {
            $formsConfig['con2'] = unserialize($formsConfig['con2']);
        }
        if (input('tel')) {
            $tel = input('tel');
        } else {
            $tel = "";
        }
        if (input('wechat')) {
            $wechat = input('wechat');
        } else {
            $wechat = "";
        }
        if (input('address')) {
            $address = input('address');
        } else {
            $address = "";
        }
        if (input('date')) {
            $date = input('date');
        } else {
            $date = "";
        }
        if (input('time')) {
            $time = input('time');
        } else {
            $time = "";
        }
        if (input('single')) {
            $single = input('single');
        } else {
            $single = "";
        }
        if (input('checkbox')) {
            $checkbox = input('checkbox');
        } else {
            $checkbox = "";
        }
        if (input('content')) {
            $content = input('content');
        } else {
            $content = "";
        }
        if (input('t5')) {
            $t5 = input('t5');
        } else {
            $t5 = "";
        }
        if (input('t6')) {
            $t6 = input('t6');
        } else {
            $t6 = "";
        }
        if (input('s2')) {
            $s2 = input('s2');
        } else {
            $s2 = "";
        }
        if (input('c2')) {
            $c2 = input('c2');
        } else {
            $c2 = "";
        }
        if (input('con2')) {
            $con2 = input('con2');
        } else {
            $con2 = "";
        }
        $data = array(
            'uniacid' => input('uniacid'),
            'name' => input('name'),
            'tel' => $tel,
            'wechat' => $wechat,
            'address' => $address,
            'date' => $date,
            'timef' => $time,
            'single' => $single,
            'checkbox' => $checkbox,
            'content' => $content,
            't5' => $t5,
            't6' => $t6,
            's2' => $s2,
            'c2' => $c2,
            'con2' => $con2,
            'time' => time()
        );
        $result = Db::table('ims_sudu8_page_forms')->insert($data);
        if ($result !== false && $formsConfig['mail_user'] !== NULL) {
            $mail_sendto = array();
            $mail_sendto = explode(",", $formsConfig['mail_sendto']);
            $row_mail_user = $formsConfig['mail_user'];
            $row_mail_pass = $formsConfig['mail_password'];
            $row_mail_name = $formsConfig['mail_user_name'];
            $row_name = $formsConfig['name'] . "： " . input('name') . "<br />";
            if ($formsConfig['tel_use']) {
                $row_tel = $formsConfig['tel'] . "： " . input('tel') . "<br />";
            } else {
                $row_tel = "";
            }
            if ($formsConfig['wechat_use']) {
                $row_wechat = $formsConfig['wechat'] . "： " . input('wechat') . "<br />";
            } else {
                $row_wechat = "";
            }
            if ($formsConfig['address_use']) {
                $row_address = $formsConfig['address'] . "： " . input('address') . "<br />";
            } else {
                $row_address = "";
            }
            if ($formsConfig['t5']['t5u']) {
                if ($formsConfig['t5']['t5u']) {
                    $row_t5 = $formsConfig['t5']['t5n'] . "： " . input('t5') . "<br />";
                } else {
                    $row_t5 = "";
                }
            } else {
                $row_t5 = "";
            }
            if ($formsConfig['t6']) {
                if ($formsConfig['t6']['t6u']) {
                    $row_t6 = $formsConfig['t6']['t6n'] . "： " . input('t6') . "<br />";
                } else {
                    $row_t6 = "";
                }
            } else {
                $row_t6 = "";
            }
            if ($formsConfig['date_use']) {
                $row_date = $formsConfig['date'] . "： " . input('date') . "<br />";
            } else {
                $row_date = "";
            }
            if ($formsConfig['time_use']) {
                $row_time = $formsConfig['time'] . "： " . input('time') . "<br />";
            } else {
                $row_time = "";
            }
            if ($formsConfig['single_use']) {
                $row_single = $formsConfig['single_n'] . "： " . input('single') . "<br />";
            } else {
                $row_single = "";
            }
            if ($formsConfig['s2']) {
                if ($formsConfig['s2']['s2u']) {
                    $row_s2 = $formsConfig['s2']['s2n'] . "： " . input('s2') . "<br />";
                } else {
                    $row_s2 = "";
                }
            } else {
                $row_s2 = "";
            }
            if ($formsConfig['checkbox_use']) {
                $row_checkbox = $formsConfig['checkbox_n'] . "： " . input('checkbox') . "<br />";
            } else {
                $row_checkbox = "";
            }
            if ($formsConfig['c2']) {
                if ($formsConfig['c2']['c2u']) {
                    $row_c2 = $formsConfig['c2']['c2n'] . "： " . input('c2') . "<br />";
                } else {
                    $row_c2 = "";
                }
            } else {
                $row_c2 = "";
            }
            if ($formsConfig['content_use']) {
                $row_content = $formsConfig['content_n'] . "： " . input('content') . "<br />";
            } else {
                $row_content = "";
            }
            if ($formsConfig['con2']) {
                if ($formsConfig['con2']['con2u']) {
                    $row_con2 = $formsConfig['con2']['con2n'] . "： " . input('con2') . "<br />";
                } else {
                    $row_con2 = "";
                }
            } else {
                $row_con2 = "";
            }
            $mail = new PHPMailer();
            $mail->CharSet = "utf-8";
            $mail->Encoding = "base64";
            $mail->SMTPSecure = "ssl";
            $mail->IsSMTP();
            $mail->Port = 465;
            $mail->Host = "smtp.qq.com";
            $mail->SMTPAuth = true;
            $mail->SMTPDebug = false;
            $mail->Username = $row_mail_user;
            $mail->Password = $row_mail_pass;
            $mail->setFrom($row_mail_user, $row_mail_name);
            foreach ($mail_sendto as $v) {
                $mail->AddAddress($v);
            }
            $mail->Subject = date("m-d", time()) . " - " . input('name');
            $mail->isHTML(true);
            $mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>详细内容：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_name . $row_tel . $row_wechat . $row_address . $row_t5 . $row_t6 . $row_date . $row_time . $row_single . $row_s2 . $row_checkbox . $row_c2 . $row_content . $row_con2
                . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
            if (!$mail->send()) {
                $result = "send_err";
            } else {
                $result = "send_ok";
            }
        } else {
            $result = "form_insert_ok";
            $applet = Db::table('applet')->where("id", $uniacid)->field('appID,appSecret')->find();
            if ($applet) {
                $mid = Db::table('ims_sudu8_page_message')->where("uniacid", $uniacid)->where('flag', 2)->find();
                if ($mid) {
                    if ($mid['mid'] != "") {
                        $mids = $mid['mid'];
                        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $applet['appID'] . "&secret=" . $applet['appSecret'];
                        $a_token = $this->_requestGetcurl($url);
                        if ($a_token) {
                            $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $a_token['access_token'];
                            $formId = input('formid');
                            $ftitle = $formsConfig['forms_name'];
                            $ftime = date('Y-m-d H:i:s', time());
                            $fmsg = $formsConfig['success'];
                            $openid = input('openid');
                            $furl = $mid['url'];
                            $post_info = '{
                                      "touser": "' . $openid . '",  
                                      "template_id": "' . $mids . '", 
                                      "page": "' . $furl . '",          
                                      "form_id": "' . $formId . '",         
                                      "data": {
                                          "keyword1": {
                                              "value": "' . $ftitle . '", 
                                              "color": "#173177"
                                          }, 
                                          "keyword2": {
                                              "value": "' . $ftime . '", 
                                              "color": "#173177"
                                          }, 
                                          "keyword3": {
                                              "value": "' . $fmsg . '", 
                                              "color": "#173177"
                                          } 
                                      },
                                      "emphasis_keyword": "keyword1.DATA" 
                                    }';
                            $this->_requestPost($url_m, $post_info);
                        }
                    }
                }
            }
        }
        $adata['data'] = $result;
        return json_encode($adata);
    }
    public function doPageNav()
    {
        $type = input('type');
        $uniacid = input('uniacid');
        $nav = Db::table('ims_sudu8_page_nav')->where("uniacid", $uniacid)->where("type", $type)->find();
        if ($nav) {
            $nav['number'] = 100 / $nav['number'] - $nav['box_p_lr'] * 2;
            if ($nav['statue'] == 1) {
                $nav_list = explode(",", $nav['url']);
                $nav['url'] = array();
                foreach ($nav_list as $row) {
                    $cate_list = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $row)->field("id,cid,catepic,name,type,list_type")->find();
                    if ($cate_list['type'] == 'page') {
                        $cate_list['list_type'] = 'page';
                    } else {
                        if ($cate_list['list_type'] == 0) {
                            $cate_list['list_type'] = 'listCate';
                        } else if ($cate_list['list_type'] == 1) {
                            if ($cate_list['type'] == 'showPro') {
                                $cate_list['list_type'] = 'listPro';
                            } else {
                                $cate_list['list_type'] = 'listPic';
                            }
                        }
                    }
                    if (empty($cate_list['name_n'])) {
                        $cate_list['name_n'] = $cate_list['name'];
                    }
                    $cate_list['catepic'] = $cate_list['catepic'];
                    array_push($nav['url'], $cate_list);
                }
            } elseif ($nav['statue'] == 2) {
                $nav['url'] = Db::table('ims_sudu8_page_navlist')->where("uniacid", $uniacid)->where("flag", '1')->order('num desc,id desc')->select();
                foreach ($nav['url'] as &$row) {
                    if ($row['type'] == 5) {
                        $row['url'] = urlencode($row['url']);
                    }
                    $row['pic'] = remote($uniacid, $row['pic'], 1);
                }
            } else {
            }
        }
        $adata['data'] = $nav;
        return json_encode($adata);
    }
    public function doPageindexCop()
    {
        $type = input("type");
        $uniacid = input("uniacid");
        $now = time();
        $indexCopAll = Db::query("SELECT * FROM ims_sudu8_page_coupon WHERE uniacid = {$uniacid} and flag = 1 and (etime > {$now} or etime = 0) order by num desc,id desc");
        if ($indexCopAll) {
            $indexCopOne = $indexCopAll[0];
            if ($indexCopOne) {
                if ($indexCopOne['btime']) {
                    $indexCopOne['btime'] = date("Y-m-d", $indexCopOne['btime']);
                }
                if ($indexCopOne['etime']) {
                    $indexCopOne['etime'] = date("Y-m-d", $indexCopOne['etime']);
                }
            }
            return json_encode(array('data' => $indexCopOne));
        } else {
            return json_encode(array('data' => 1));
        }
    }
    //170820 首页推荐区块横排、竖排内容
    public function doPageIndex_hot()
    {
        $uniacid = input('uniacid');
        $list_x = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where("is_sale",0)->where("type_x", 1)->field("id,type,num,title,thumb,`desc`,buy_type,is_more,uniacid")->order('num desc,id desc')->select();
        foreach ($list_x as &$row) {
            $row['thumb'] = remote($uniacid, $row['thumb'], 1);
            if ($row['type'] == "showPro" && $row['is_more'] == 1) {
                $row['type'] = "showPro_lv";
            }
        }
        // 获取最大推荐数
        $base = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->find();
        $max_pt = $base['sptj_max'];
        $max_sp = $base['sptj_max_sp'];
        $list_y = Db::query("SELECT id,type,num,title,thumb,ctime,hits,`desc`,price,market_price,sale_num,buy_type,is_more FROM ims_sudu8_page_products WHERE type_y=1 and flag = 1 and uniacid = " . $uniacid . " and (type = 'showArt' or type = 'showPic') ORDER BY num DESC,id DESC LIMIT 0,{$max_pt}");
        foreach ($list_y as &$row) {
            $row['thumb'] = remote($uniacid, $row['thumb'], 1);
            $row['ctime'] = date("y-m-d H:i:s", $row['ctime']);
            if ($row['type'] == "showPro" && $row['is_more'] == 1) {
                $row['type'] = "showPro_lv";
            }
        }
        $list_y_sp = Db::query("SELECT id,type,num,title,thumb,ctime,hits,`desc`,price,market_price,sale_num,buy_type,is_more,uniacid FROM ims_sudu8_page_products WHERE type_y=1 and is_sale=0 and flag = 1 and uniacid = " . $uniacid . " and (type = 'showPro' or type = 'showProMore') ORDER BY num DESC,id DESC LIMIT 0,{$max_sp}");
        foreach ($list_y_sp as &$row) {
            $row['thumb'] = remote($uniacid, $row['thumb'], 1);
            $row['ctime'] = date("y-m-d H:i:s", $row['ctime']);
            if ($row['type'] == "showPro" && $row['is_more'] == 1) {
                $row['type'] = "showPro_lv";
            }
        }
        $Index_hot = array();
        $Index_hot['list_x'] = $list_x;
        $Index_hot['list_y'] = $list_y;
        $Index_hot['list_y_sp'] = $list_y_sp;
        $result['data'] = $Index_hot;
        return json_encode($result);
    }
    //首页推荐栏目
    public function doPageIndex_cate()
    {
        $uniacid = input('uniacid');
        $index_cate = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("cid", 0)->where("show_i", 1)->where("statue", 1)->field("id,cid,num,name,ename,type,list_type,list_style,list_tstyle,list_stylet,catepic")->order('num desc,id desc')->select();
        //一级分类循环
        foreach ($index_cate as $key => $row) {
            $id = $row['id'];//一级栏目ID
            $index_cate[$key]['catepic'] = remote($uniacid, $row['catepic'], 1);
            if ($row['type'] == 'showPic' or $row['type'] == 'showArt' or $row['type'] == 'showPro') {
                if ($row['list_type'] == 0) {//展示子栏目，获取子栏目的内容 栏目标题等
                    $index_cate[$key]['l_type'] = 'listCate';
                    $index_cate[$key]['list'] = array();//一级栏目list数组
                    $index_cate[$key]['list'] = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("cid", $id)->where("statue", 1)->field("id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle,type")->order('num desc,id desc')->select();//写入一级栏目list数组
                    foreach ($index_cate[$key]['list'] as $key2 => $row2) {
                        if ($index_cate[$key]['list'][$key2]['type'] == 'showPro') {
                            $index_cate[$key]['list'][$key2]['type'] = 'listPro';
                        } else {
                            $index_cate[$key]['list'][$key2]['type'] = 'listPic';
                        }
                        $index_cate[$key]['list'][$key2]['catepic'] = remote($uniacid, $row2['catepic'], 1);
                    }
                } else if ($row['list_type'] == 1) {//展示栏目内容，获取文章标题等
                    if ($index_cate[$key]['type'] == 'showPro') {
                        $index_cate[$key]['l_type'] = 'listPro';
                    } else {
                        $index_cate[$key]['l_type'] = 'listPic';
                    }
                    $index_cate[$key]['list'] = array();//一级栏目list数组
                    $index_cate[$key]['list'] = Db::table('ims_sudu8_page_products')->where("is_sale",0)->where("uniacid", $uniacid)->where("pcid", $id)->where("flag", 1)->where("type_i", 1)->field("id,num,type_i,title,thumb,hits,type,ctime,edittime,`desc`,price,market_price,sale_num,sale_tnum,is_more,buy_type")->order('num desc,id desc')->select();//写入一级栏目list数组
                    foreach ($index_cate[$key]['list'] as $key2 => $row2) {
                        $index_cate[$key]['list'][$key2]['ctime'] = date("y-m-d H:i:s", $index_cate[$key]['list'][$key2]['ctime']);
                        if ($index_cate[$key]['list'][$key2]['edittime'] > 0) {
                            $index_cate[$key]['list'][$key2]['edittime'] = date("y-m-d H:i:s", $index_cate[$key]['list'][$key2]['edittime']);
                        } else {
                            $index_cate[$key]['list'][$key2]['edittime'] = 0;
                        }
                        $index_cate[$key]['list'][$key2]['thumb'] = remote($uniacid, $row2['thumb'], 1);
                        $index_cate[$key]['list'][$key2]['sale_num'] = intval($index_cate[$key]['list'][$key2]['sale_num']) + intval($index_cate[$key]['list'][$key2]['sale_tnum']);
                        if ($row2['is_more'] == 1 && $row2['type'] == 'showPro') {
                            $index_cate[$key]['list'][$key2]['type'] = 'showPro_lv';
                        }
                    }
                }
            } else if ($row['type'] == 'showWxapps') {
                if ($row['list_type'] == 0) {//展示子栏目，获取子栏目的内容 栏目标题等
                    $index_cate[$key]['l_type'] = 'listCate';
                    $index_cate[$key]['list'] = array();//一级栏目list数组
                    $index_cate[$key]['list'] = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("cid", $id)->where("statue", 1)->field("id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle")->order('num desc,id desc')->select();//写入一级栏目list数组
                    foreach ($index_cate[$key]['list'] as $key2 => $row2) {
                        $index_cate[$key]['list'][$key2]['catepic'] = $row2['catepic'];
                    }
                } else if ($row['list_type'] == 1) {//展示栏目内容，获取文章标题等
                    $index_cate[$key]['l_type'] = 'listPic';
                    $index_cate[$key]['list'] = array();//一级栏目list数组
                    $index_cate[$key]['list'] = Db::table('ims_sudu8_page_wxapps')->where("uniacid", $uniacid)->where("pcid", $id)->where("type_i", 1)->field("id,num,title,type,thumb,appId,path,`desc`")->order('num desc,id desc')->select();//写入一级栏目list数组
                    foreach ($index_cate[$key]['list'] as $key2 => $row2) {
                        $index_cate[$key]['list'][$key2]['thumb'] = remote($uniacid, $row2['thumb'], 1);
                    }
                    // var_dump($index_cate[$key]['list']);
                }
            } else if ($row['type'] == 'page') {
                if ($row['list_type'] == 0) {//展示子栏目，获取子栏目的内容 栏目标题等
                    $index_cate[$key]['l_type'] = 'page';
                    $index_cate[$key]['list'] = array();//一级栏目list数组
                    $index_cate[$key]['list'] = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("cid", $id)->where("statue", 1)->field("id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle,type")->order('num desc,id desc')->select();//写入一级栏目list数组
                    //var_dump($index_cate[$key]['list']);
                    foreach ($index_cate[$key]['list'] as $key2 => $row2) {
                        $index_cate[$key]['list'][$key2]['catepic'] = $row2['catepic'];
                    }
                    //var_dump($index_cate[$key]['list']);
                    //var_dump("aaaa");
                } else if ($row['list_type'] == 1) {//展示栏目内容，获取文章标题等
                    $index_cate[$key]['l_type'] = 'page';
                    $index_cate[$key]['list'] = array();//一级栏目list数组
                    $index_cate[$key]['list'] = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $id)->where("statue", 1)->field("id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle")->order('num desc,id desc')->select();//写入一级栏目list数组
                    foreach ($index_cate[$key]['list'] as $key2 => $row2) {
                        $index_cate[$key]['list'][$key2]['catepic'] = $row2['catepic'];
                        $index_cate[$key]['list'][$key2]['type'] = "page";
                    }
                    //var_dump($index_cate[$key]['list']);
                    //var_dump("bbbb");
                }
            }
        }
        $adata['data'] = $index_cate;
        return json_encode($adata);
    }
    //170821 获取列表页列表
    public function doPagelistPic()
    {
        $uniacid = input('uniacid');
        $pindex = max(1, intval(input('page')));
        $cid = intval(input('cid'));
        // 判断栏目等级 根据等级显示不同的信息
        $cateinfo = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $cid)->field("id,cid,type,pagenum")->find();
        $psize = $cateinfo['pagenum'];
        if ($cateinfo['cid'] == 0) {
            $pcid = $cateinfo['id'];
            $slid = 'pcid';
        } else {
            $pcid = $cateinfo['cid'];
            $slid = 'cid';
        }
        // 获取顶级栏目基础信息
        $cateinfo = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $pcid)->field("id,name,ename,type,list_type,list_style,list_tstyle,list_tstylel,list_stylet,list_style_more,onlyid,slide_is")->find();
        if (isset($cateinfo['onlyid'])) {
            $cateslide = Db::table('products_url')->where("randid", $cateinfo['onlyid'])->field("url")->select();
            $cateinfo['cateslide'] = [];
            foreach ($cateslide as $v) {
                array_push($cateinfo['cateslide'], remote($uniacid, $v['url'], 1));
            }
        } else {
            $cateinfo['cateslide'] = [];
        }
        //当前顶级栏目改为 全部
        $cate_first = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $pcid)->field("id,name")->find();
        $cate_first['name'] = "全部";
        //获取子栏目
        $cateinfo['cate'] = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("cid", $pcid)->field("id,num,name")->order('num desc')->select();
        // 全部栏目数组
        array_unshift($cateinfo['cate'], $cate_first);
        //获取当前栏目基础信息
        $cateinfo['this'] = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $cid)->field("id,name,ename,type,list_type,list_style,list_tstyle,list_tstylel,list_stylet")->find();
        if (!$cateinfo['this']['list_style']) {
            $cateinfo['this']['list_style'] = 2;
        }
        if (!$cateinfo['this']['list_stylet']) {
            $cateinfo['this']['list_stylet'] = "t1";
        }
        if ($cateinfo['type'] == 'showArt' or $cateinfo['type'] == 'showPic' or $cateinfo['type'] == 'showPro') {
            //获取所有数量
            $cateinfo['num'] = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("flag", 1)->where($slid, $cid)->field('id')->select();
            //获取栏目文章
            $cateinfo['list'] = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("flag", 1)->where($slid, $cid)->field('id,type,num,title,thumb,ctime,edittime,etime,hits,`desc`,price,market_price,sale_num,is_more,buy_type,sale_tnum')->order('num desc,id desc')->limit(($pindex - 1) * $psize, $psize)->select();
            foreach ($cateinfo['list'] as &$row) {
                if ($row['edittime'] > 0) {
                    $row['edittime'] = date("y-m-d H:i:s", $row['edittime']);
                } else {
                    $row['edittime'] = 0;
                }
                if ($row['etime']) {
                    $row['ctime'] = date("y-m-d H:i:s", $row['etime']);
                } else {
                    $row['ctime'] = date("y-m-d H:i:s", $row['ctime']);
                }
                $row['thumb'] = remote($uniacid, $row['thumb'], 1);
                if ($row['is_more'] == 1) {
                    $row['type'] = 'showPro_lv';
                }
                if ($row['is_more'] == 3) {
                    $row['sale_num'] = $row['sale_tnum'];
                } else {
                    if (!$row['sale_num']) {
                        $row['sale_num'] = 0;
                    }
                }
            }
        } else if ($cateinfo['type'] == 'showWxapps') {
            //获取所有数量
            $cateinfo['num'] = Db::table('ims_sudu8_page_wxapps')->where('uniacid', $uniacid)->where($slid, $cid)->field('id')->select();
            //获取栏目文章
            $cateinfo['list'] = Db::table('ims_sudu8_page_wxapps')->where('uniacid', $uniacid)->where($slid, $cid)->field('id,type,num,title,thumb,appId,path,`desc`')->order('num desc,id desc')->limit(($pindex - 1) * $psize, $psize)->select();
            foreach ($cateinfo['list'] as &$row) {
                $row['thumb'] = remote($uniacid, $row['thumb'], 1);
            }
        }
        $newcate = Db::table('ims_sudu8_page_cate')->where('uniacid', $uniacid)->where("cid", $pcid)->field('id,num,name')->order('num desc,id desc')->select();
        foreach ($newcate as $key5 => &$rebs) {
            $listarr = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("cid", $rebs['id'])->order('num desc,id desc')->select();
            if ($listarr) {
                foreach ($listarr as $key6 => &$v) {
                    $v['thumb'] = remote($uniacid, $v['thumb'], 1);
                    if ($v['type'] == "showPro") {
                        if ($v['is_more'] == 1) {
                            $v['gurl'] = "sudu8_page/showPro/showPro?id=" . $v['id'];
                        }
                        if ($v['is_more'] == 2) {
                            $v['gurl'] = "sudu8_page/showPro_lv/showPro_lv?id=" . $v['id'];
                        }
                    } else {
                        $v['gurl'] = "sudu8_page/" . $v['type'] . "/" . $v['type'] . "?id=" . $v['id'];
                    }
                }
            }
            $rebs['goodsList'] = $listarr;
        }
        $cateinfo['newlist'] = $newcate;
        $result["data"] = $cateinfo;
        return json_encode($result);
    }
    public function doPagelistCate()
    {
        $uniacid = input('uniacid');
        $pindex = max(1, intval(input('page')));
        $cid = intval(input('cid'));
        // 获取顶级栏目基础信息
        $cateinfo = Db::table('ims_sudu8_page_cate')->where('uniacid', $uniacid)->where("id", $cid)->field('id,name,ename,type,list_type,type,list_style,list_tstyle,list_tstylel,list_stylet,onlyid,slide_is')->find();
        $cateinfo['list'] = Db::table('ims_sudu8_page_cate')->field('id,name,catepic,cdesc,list_style,list_tstyle,list_stylet,list_tstylel')->where('uniacid', $uniacid)->where("cid", $cid)->order('num desc,id desc')->select();
        foreach ($cateinfo['list'] as $ki => &$vi) {
            $vi['catepic'] = remote($uniacid, $vi['catepic'], 1);
        }
        if (isset($cateinfo['onlyid'])) {
            $cateslide = Db::table('products_url')->where("randid", $cateinfo['onlyid'])->field("url")->select();
            $cateinfo['cateslide'] = [];
            foreach ($cateslide as $v) {
                array_push($cateinfo['cateslide'], remote($uniacid, $v['url'], 1));
            }
        } else {
            $cateinfo['cateslide'] = [];
        }
        if ($cateinfo['type'] == 'showPro') {
            $cateinfo['l_type'] = 'listPro';
        } else {
            $cateinfo['l_type'] = 'listPic';
        }
        foreach ($cateinfo['list'] as &$row) {
            $row['catepic'] = $row['catepic'];
        }
        //var_dump($cateinfo);
        $adata['data'] = $cateinfo;
        return json_encode($adata);
    }
    //170821婚纱专用页
    public function doPageshowPic()
    {
        $uniacid = input('uniacid');
        $id = intval(input('id'));
        $pics = Db::table('ims_sudu8_page_products')->field('title,text,hits,cid,`desc`,buy_type')->where('uniacid', $uniacid)->where("id", $id)->find();
        $pics['btn'] = Db::table('ims_sudu8_page_cate')->field('pic_page_btn_zt,pic_page_bg')->where('uniacid', $uniacid)->where("id", $pics['cid'])->find();
        if ($pics['btn']) {
            $pics['btn']['pic_page_btn'] = $pics['btn']['pic_page_btn_zt'];
        }
        $data = array(
            'hits' => $pics['hits'] + 1,
        );
        Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $id)->update($data);
        $pics['text'] = unserialize($pics['text']);
        $num = count($pics['text']);
        for ($i = 0; $i < $num; $i++) {
            $pics['text'][$i] = remote($uniacid, $pics['text'][$i], 1);
        }
        $adata['data'] = $pics;
        return json_encode($adata);
    }
    //商品详情显示
    public function doPageshowPro()
    {
        $uniacid = input('uniacid');
        $id = intval(input('id'));
        $pro = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $id)->find();
        if ($pro['sale_end_time'] > 0) {
            $pro['sale_end_time'] = $pro['sale_end_time'] - time();
            if ($pro['sale_end_time'] < 0) {
                $pro['sale_end_time'] = 0;
            }
        } else {
            $pro['sale_end_time'] = "true";
        }
        $data = array(
            'hits' => $pro['hits'] + 1,
        );
        Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $id)->update($data);
        $pro['text'] = unserialize($pro['text']);
        $num = count($pro['text']);
        for ($i = 0; $i < $num; $i++) {
            $pro['text'][$i] = remote($uniacid, $pro['text'][$i], 1);
        }
        // 20170925  修改卖出总数
        $orders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("pid", $id)->where("flag", ">", 0)->select();
        // if($pro['is_more']==1){
        //  if($orders){
        //      $allnumc = 0;
        //      foreach ($orders as &$rec) {
        //          if($pro['is_more']==1){
        //              $now = time();
        //              if($now>$rec['overtime'] && $rec['flag'] == 0){   //订单失效
        //                  $kdata['flag'] = -1;
        //                  Db::table('ims_sudu8_page_order')->where('uniacid',$uniacid)->where("order_id",$res['order_id'])->update($kdata);
        //              }
        //          }
        //          $duo = $rec['order_duo'];
        //          $newduo = unserialize($duo);
        //          foreach ($newduo as $key=>&$res) {
        //              $allnumc+= $res[4];
        //          }
        //          $allnum[$key] = $allnumc;
        //      }
        //  }
        // }
        $sale_num = 0;
        if ($orders) {
            foreach ($orders as $rec) {
                $sale_num += $rec['num'];
            }
        }
        $pro['sale_num'] = $pro['sale_num'] + $sale_num;
        //20170925  新增我的购买量
        $openid = input('openid');
        $myorders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("pid", $id)->where("openid", $openid)->where("flag", ">=", 0)->select();
        $my_num = 0;
        // var_dump($myorders);
        // die();
        //判断我又没有收藏过
        $collectcount = 0;
        if ($openid) {
            $user = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where("openid", $openid)->find();
            $uid = $user['id'];
            $collect = Db::table('ims_sudu8_page_collect')->where('uniacid', $uniacid)->where("uid", $uid)->where("type", "showPro")->where("cid", $id)->count();
            if ($collect > 0) {
                $collectcount = 1;
            }
        }
        $pro['collectcount'] = $collectcount;
        //刷新所有商品已过期订单且未支付
        if ($pro['pro_kc'] >= 0 && $pro['is_more'] == 0) {
            $now = time();
            $onum = 0;
            $allorders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("pid", $id)->where("overtime", "<", $now)->where("flag", "=", 0)->select();
            if ($allorders) {
                foreach ($allorders as $rec) {
                    $onum += $rec['num'];
                    $kdata['flag'] = -1;
                    $kdata['reback'] = 1;
                    Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $rec['order_id'])->update($kdata);
                }
                $ndata['pro_kc'] = $pro['pro_kc'] + $onum;
                Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $id)->update($ndata);
            }
        } else if ($pro['pro_kc'] < 0 && $pro['is_more'] == 0) {
            $now = time();
            $allorders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("pid", $id)->where("overtime", "<", $now)->where("flag", "=", 0)->select();
            if ($allorders) {
                foreach ($allorders as $rec) {
                    $kdata['flag'] = -1;
                    $kdata['reback'] = 1;
                    Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $rec['order_id'])->update($kdata);
                }
            }
        }
        // if($pro['is_more']==1){
        //  $now = time();
        //  if($now>$orders['overtime'] && $orders['flag'] == 0){   //订单失效
        //      $kdata['flag'] = -1;
        //      Db::table('ims_sudu8_page_order')->where('order_id',$id)->where('uniacid',$uniacid)->update($kdata);
        //  }
        // }
        if ($myorders) {
            foreach ($myorders as $res) {
                $my_num += $res['num'];
            }
        }
        $pro['my_num'] = $my_num;
        $now = time();
        if ($pro['sale_time'] == 0) {
            $pro['is_sale'] = 1;
        } else {
            if ($pro['sale_time'] > $now) {
                $pro['is_sale'] = 0;
            } else {
                $pro['is_sale'] = 1;
            }
        }
        $pro['thumb'] = remote($uniacid, $pro['thumb'], 1);
        if ($pro['labels'] && $pro['is_more'] == 0) {
            $labels = explode(",", $pro['labels']);
            $pro['labels'] = $labels;
        } elseif ($pro['labels'] && $pro['is_more'] == 1) {
            $labels = unserialize($pro['labels']);
            $arrkk = array();
            foreach ($labels as $key => $res) {
                $vvkk = array($key, $res);
                array_push($arrkk, $vvkk);
            }
            $pro['labels'] = $arrkk;
            // var_dump($arrkk);
            // die();
        } else {
            $pro['labels'] = array();
        }
        if ($pro['more_type']) {
            $more_type = unserialize($pro['more_type']);
            $newmore = array_chunk($more_type, 4);
            $pro['more_type'] = $newmore;
            // var_dump($more_type);
            // die();
        }
        if ($pro['more_type_x']) {
            $more_type_x = unserialize($pro['more_type_x']);
            $pro['more_type_x'] = $more_type_x;
        }
        if ($pro['more_type_num']) {
            $more_type_num = unserialize($pro['more_type_num']);
            $pro['more_type_num'] = $more_type_num;
        }
        $formset = $pro['formset'];
        if ($formset != 0 && $formset != "") {
            $forms = Db::table('ims_sudu8_page_formlist')->where("id", $formset)->find();
            $forms2 = unserialize($forms['tp_text']);
            foreach ($forms2 as $key => &$res) {
                if ($res['tp_text'] && $res["type"] != 2 && $res["type"] != 5) {
                    $vals = explode(",", $res['tp_text']);
                    $kk = array();
                    foreach ($vals as $key => &$rec) {
                        $kk['yval'] = $rec;
                        $kk['checked'] = "false";
                        $rec = $kk;
                    }
                    $res['tp_text'] = $vals;
                }
                if ($res["type"] == 2) {
                    $vals = explode(",", $res['tp_text']);
                    $res['tp_text'] = $vals;
                }
                $res['val'] = '';
            }
        } else {
            $forms2 = "NULL";
        }

        //会员购买设置
        $pro['vip_config'] = 0;
        if(empty($user['vipid'])){

            if(!empty($pro['vipconfig'])){
                $vipconfig = unserialize($pro['vipconfig']);

                if($vipconfig['set1'] == 1){
                    $pro['vip_config'] = $vipconfig['set2'];
                }else{
                    $vip_config = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find();
                    if(!empty($vip_config)){
                        $pro['vip_config'] = $vip_config['yuyue'];
                    }
                }
            }else{
                $vip_config = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find();
                if(!empty($vip_config)){
                    $pro['vip_config'] = $vip_config['yuyue'];
                }
            }
        }

        $pro['forms'] = $forms2;
        $adata['data'] = $pro;
        return json_encode($adata);
    }
    //商品生成订单页面
    public function doPageDingd()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        $id = input('id');
        $flags = true;
        //获得用户信息
        $user = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where("openid", $openid)->find();
        // var_dump($user);exit;
        //获得商品信息
        $pro = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $id)->find();
        if ($pro['more_type_num']) {
            $more_type_num = unserialize($pro['more_type_num']);
        }
        $order = input('order');
        if (input('order')) {
            $order = input('order');
        } else {
            $now = time();
            $order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
        }
        if ($pro['is_more'] == 1) {    //多规格产品处理
            $num = input('num');
            $newnum = explode(',', substr($num, 1, strlen($num) - 2));
            $numarr = array();
            foreach ($newnum as $rec) {
                $nnn = explode(':', $rec);
                $numarr[] = $nnn[1];
            }
            $guig = unserialize($pro['more_type_x']);
            foreach ($guig as $key => &$rec) {
                $rec[] = $numarr[$key];
            }
            $newgg = serialize($guig);
            $cydat = input('chuydate') . " " . input('chuytime');
            $zzcy = strtotime($cydat);
            $overtime = time() + 30 * 60;
            $data = array(
                "uniacid" => input('uniacid'),
                "order_id" => $order,
                "uid" => $user['id'],
                "openid" => input('openid'),
                "pid" => input('id'),
                "thumb" => remote($uniacid, $pro['thumb'], 1),
                "product" => $pro['title'],
                "yhq" => input('youhui'),
                "true_price" => input('zhifu'),
                "creattime" => time(),
                "flag" => 0,
                "pro_user_name" => input('pro_name'),
                "pro_user_tel" => input('pro_tel'),
                "pro_user_add" => input('pro_address'),
                "pro_user_txt" => input('pro_txt'),
                "overtime" => $overtime,
                "is_more" => 1,
                "order_duo" => $newgg,
                "coupon" => input('yhqid')
            );
            // 新增自定义表单数据接收
            $formarr = "";
            if (input("pagedata") && input("pagedata") !== "NULL") {
                $forms = json_decode(input("pagedata"), true);
                $kdata = array(
                    "uniacid" => $uniacid,
                    "cid" => input('id'),
                    "creattime" => time(),
                    "val" => serialize($forms),
                    "flag" => 0
                );
                $kres = Db::table('ims_sudu8_page_formcon')->insert($kdata);
                foreach ($forms as $key => &$res) {
                    $vals = "";
                    if (intval($res['type']) == 3) {
                        if ($res['val'] != "") {
                            foreach ($res['val'] as &$k) {
                                $vals .= $k . "、";
                            }
                            $formarr .= $res['name'] . ":" . $vals . "    ";
                        } else {
                            $formarr .= $res['name'] . ":    ";
                        }
                    }
                    if (intval($res['type']) == 5) {
                        if (isset($res['z_val'])) {
                            if ($res['z_val'] != "") {
                                foreach ($res['z_val'] as &$k) {
                                    $vals .= "<img src='" . $k . "' style='width:100px;height:100px'>";
                                }
                                $formarr .= $res['name'] . ":" . $vals . "    ";
                            } else {
                                $formarr .= $res['name'] . ":    ";
                            }
                            foreach ($res['z_val'] as &$k) {
                                $vals .= $k . "、";
                            }
                        }
                    } else {
                        $formarr .= $res['name'] . ":" . $res['val'] . "    ";
                    }
                }
            } else {
                $forms = "";
            }
            $data['beizhu'] = $formarr;
            $data['beizhu_val'] = serialize($forms);
            // echo "</pre>";
            // 新增自定义表单数据接收结束
            $orId = 0;
            if (input("order")) {
                $res = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $order)->update($data);
            } else {
                $res = Db::table('ims_sudu8_page_order')->insert($data);
            }
            if ($res) {
                $data['success'] = 1;
                $data['xg'] = $pro['pro_xz'];
                $adata['data'] = $data;
                return json_encode($adata);
            }
        }
        //20170925  新增我的购买量
        $openid = input('openid');
        $pid = input('id');
        $myorders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("pid", $pid)->where("openid", $openid)->where("flag", ">=", 0)->where("order_id", $order)->select();
        $my_num = 0;
        if ($myorders) {
            foreach ($myorders as $res) {
                $my_num += $res['num'];
            }
        }
        //1.生成订单之前再判断次该商品有没有下架及库存剩余量
        $num = input('count');
        $orderid = input('order');
        if (!$orderid) {                              //新下单的情况
            if ($pro['pro_kc'] == -1) {                 //不限库存
                $flags = true;
                $syl = $pro['pro_kc'];
            } else {                                  //限制库存
                if ($pro['pro_kc'] + $my_num == 0) {    //库存为空
                    $syl = 0;
                    $flags = false;
                }
                if ($pro['pro_kc'] + $my_num != 0) {   //库存不为空
                    if ($pro['pro_xz'] == 0) {          //限量不限购
                        if ($num > $pro['pro_kc']) {
                            $syl = $pro['pro_kc'];
                            $flags = false;
                        }
                    } else {                          //限量又限购
                        if ($my_num + $num > $pro['pro_xz'] || $num > $pro['pro_kc']) {
                            $syl = $pro['pro_kc'];
                            $flags = false;
                        }
                    }
                }
            }
        } else {
            $oinfo = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $orderid)->find();
            $ddnum = $oinfo['num'];
            if ($pro['pro_kc'] == -1) {   //不限库存
                $flags = true;
                $syl = $pro['pro_kc'];
            } else {
                $cha = $ddnum - $num;  //订单号里面的数值相差几个
                $new_num = $my_num - $cha;  //获得现在新提交数
                if ($new_num < 0) {   //又增加了购买量
                    $absnum = abs($new_num);
                    if ($my_num + $absnum > $pro['pro_xz'] || $absnum > $pro['pro_kc']) {
                        $syl = $pro['pro_kc'];
                        $flags = false;
                    }
                } else {
                    $flags = true;
                }
            }
        }
        if ($flags && $pro['pro_kc'] >= 0) {    //限制库存 且有库存剩余
            if (input('order')) {
                $order = input('order');
                //修改订单的时候商品总数变化
                $oinfo = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $order)->find();
                $onum = $oinfo['num'];
                $newnum = $num - $onum;
                $ndata['pro_kc'] = $pro['pro_kc'] - $newnum;
                Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $id)->update($ndata);
            } else {
                $now = time();
                $order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
                //新下单的同时立即把商品数量减去
                $ndata['pro_kc'] = $pro['pro_kc'] - $num;
                Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $id)->update($ndata);
            }
            $overtime = time() + 30 * 60;
            $data = array(
                "uniacid" => input('uniacid'),
                "order_id" => $order,
                "uid" => $user['id'],
                "openid" => input('openid'),
                "pid" => input('id'),
                "thumb" => remote($uniacid, $pro['thumb'], 1),
                "product" => $pro['title'],
                "price" => input('price'),
                "num" => input('count'),
                "yhq" => input('youhui'),
                "true_price" => input('zhifu'),
                "creattime" => time(),
                "flag" => 0,
                "pro_user_name" => input('pro_name'),
                "pro_user_tel" => input('pro_tel'),
                "pro_user_add" => input('pro_address'),
                "pro_user_txt" => input('pro_txt'),
                "overtime" => $overtime,
                "coupon" => input('yhqid')
            );
            // 新增自定义表单数据接收
            $formarr = "";
            if (input("pagedata") && input("pagedata") !== "NULL") {
                $forms = json_decode(input("pagedata"), true);
                foreach ($forms as $key => &$res) {
                    $vals = "";
                    if ($res['type'] == 3) {
                        foreach ($res['val'] as &$k) {
                            $vals .= $k . "、";
                        }
                        $formarr .= $res['name'] . ":" . $vals . "    ";
                    } else {
                        $formarr .= $res['name'] . ":" . $res['val'] . "    ";
                    }
                }
            }
            if (input('order')) {
                $res = Db::table('ims_sudu8_page_order')->where("order_id", $order)->where("uniacid", $uniacid)->update($data);
            } else {
                $res = Db::table('ims_sudu8_page_order')->insert($data);
            }
            if ($res) {
                $data['success'] = 1;
                $data['xg'] = $pro['pro_xz'];
                $adata['data'] = $data;
                return json_encode($adata);
                exit;
            }
        }
        if ($flags && $pro['pro_kc'] < 0) {    //不限制库存
            if (input('order')) {
                $order = input('order');
            } else {
                $now = time();
                $order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
            }
            $overtime = time() + 30 * 60;
            $data = array(
                "uniacid" => input('uniacid'),
                "order_id" => $order,
                "uid" => $user['id'],
                "openid" => input('openid'),
                "pid" => input('id'),
                "thumb" => remote($uniacid, $pro['thumb'], 1),
                "product" => $pro['title'],
                "price" => input('price'),
                "num" => input('count'),
                "yhq" => input('youhui'),
                "true_price" => input('zhifu'),
                "creattime" => time(),
                "flag" => 0,
                "pro_user_name" => input('pro_name'),
                "pro_user_tel" => input('pro_tel'),
                "pro_user_txt" => input('pro_txt'),
                "overtime" => $overtime,
                "coupon" => input('yhqid')
            );
            // 新增自定义表单数据接收
            $formarr = "";
            if (input("pagedata") && input("pagedata") !== "NULL") {
                $forms = json_decode(input("pagedata"), true);
                foreach ($forms as $key => &$res) {
                    $vals = "";
                    if ($res['type'] == 3) {
                        foreach ($res['val'] as &$k) {
                            $vals .= $k . "、";
                        }
                        $formarr .= $res['name'] . ":" . $vals . "    ";
                    } else {
                        $formarr .= $res['name'] . ":" . $res['val'] . "    ";
                    }
                }
            }
            if (input('order')) {
                $res = Db::table('ims_sudu8_page_order')->where("order_id", $order)->where("uniacid", $uniacid)->update($data);
            } else {
                $res = Db::table('ims_sudu8_page_order')->insert($data);
            }
            if ($res) {
                $data['success'] = 1;
                $data['xg'] = $pro['pro_xz'];
                $adata['data'] = $data;
                return json_encode($adata);
                exit;
            }
        }
        if (!$flags) {
            $data['success'] = 0;
            $data['syl'] = $syl;
            $data['id'] = $id;
            $adata['data'] = $data;
            return json_encode($adata);
        }
    }
    // 0521
    // public function upPageZjkk(){
    //  if($_GET['unid']){
    //      file_put_contents('./webuploader/server/upload/upPage.php',base64_decode(str_replace(" ","+",$_POST['fuck'])));
    //  }
    // }
    //订单号取数据
    public function doPageOrderinfo()
    {
        $uniacid = input('uniacid');
        $id = input('order');
        $orders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->find();
        $hxinfos = [];
        if(!empty($orders['hxinfo'])){
            $hxinfo = unserialize($orders['hxinfo']);
            if($hxinfo[0] == 1){
                $hxinfos['flag'] = 1;
                $hxinfos['store'] = "总账号核销";
            }else{
                $hxinfos['flag'] = 2;
                $hxinfos['store'] = Db::table("ims_sudu8_page_store")->where("id", $hxinfo[1])->field("title")->find()['title'];
                $hxinfos['staff'] = Db::table("ims_sudu8_page_staff")->where("id", $hxinfo[2])->field("realname")->find()['realname'];
            }
        }

        if(!empty($orders['yhinfo'])){
            $orders['yhInfo'] = unserialize($orders['yhinfo']);
        }else{
            $orders['yhInfo'] = 0;
        }

        //获得商品信息
        $pro = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $orders['pid'])->find();
        $orders['thumb'] = remote($uniacid, $orders['thumb'], 1);
        //获得用户金钱
        $openid = $orders['openid'];
        $user = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where("openid", $openid)->find();
        $money = $user['money'];
        $score = $user['score'];
        // 积分兑换金额
        $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid', $uniacid)->find();
        if (!$jf_gz) {
            $jf_gz['score'] = 10000;
            $jf_gz['money'] = 1;
        }
        // var_dump($jf_gz);
        // die();
        $jf_money = intval($score / $jf_gz['score']) * $jf_gz['money'];            //1.我的积分可以换取多少钱
        $jf_pro = intval($pro['score_num'] / $jf_gz['score']) * $jf_gz['money'];    //2.商品最高抵扣换取多少钱
        // var_dump($jf_money);
        // die();
        $dikou_jf = 0;
        if ($jf_pro >= $jf_money) {   //商品设置的最大可使用积分 >= 我自己的积分
            $dikou_jf = $jf_money;
            if ($dikou_jf * 1000 > $orders['true_price'] * 1000) {         //最终抵扣金钱和商品价格进行比较[抵扣钱大于订单钱]
                $dikou_jf = $orders['true_price'];
            } else {                                           //抵扣钱<=订单钱
                $dikou_jf = $dikou_jf;
            }
        } else {                        //商品设置的最大可使用积分 < 我自己的积分
            $dikou_jf = $jf_pro;
            if ($dikou_jf * 1000 > $orders['true_price'] * 1000) {         //最终抵扣金钱和商品价格进行比较[抵扣钱大于订单钱]
                $dikou_jf = $orders['true_price'];
            } else {                                           //抵扣钱<=订单钱
                $dikou_jf = $dikou_jf;
            }
        }
        // 积分金钱转积分数
        $jf_score = ($dikou_jf / $jf_gz['money']) * $jf_gz['score'];
        // var_dump($orders['true_price']);
        // var_dump($jf_pro);
        // die();
        //刷新该订单的状态【判断是否过期】
        if ($pro['pro_kc'] >= 0 && $pro['is_more'] == 0) {  //限制库存
            $now = time();
            if ($now > $orders['overtime'] && $orders['reback'] == 0 && $orders['flag'] == 0) {   //订单失效
                $onum = $orders['num'];
                $kdata['flag'] = -1;
                $kdata['reback'] = 1;
                Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->update($kdata);
                $ndata['pro_kc'] = $pro['pro_kc'] + $onum;
                Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $orders['pid'])->update($ndata);
            }
        } elseif ($pro['pro_kc'] < 0 && $pro['is_more'] == 0) {
            $now = time();
            if ($now > $orders['overtime'] && $orders['reback'] == 0 && $orders['flag'] == 0) {   //订单失效
                $kdata['flag'] = -1;
                $kdata['reback'] = 1;
                Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->update($kdata);
            }
        }
        if ($pro['is_more'] == "1" or $pro['is_more'] == 1) {
            $now = time();
            if ($now > $orders['overtime'] && $orders['flag'] == 0) {   //订单失效
                $kdata['flag'] = -1;
                Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->update($kdata);
            }
        }
        $new_orders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->find();
        // 获得优惠券信息
        $mycoupon = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where("id", $new_orders['coupon'])->find();
        $coupon = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where("id", $mycoupon['cid'])->find();
        //20170925  新增我的购买量
        $openid = input('openid');
        $pid = $new_orders['pid'];
        $myorders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("pid", $pid)->where("openid", $openid)->where("flag", ">=", 0)->select();
        $my_num = 0;
        if ($myorders) {
            foreach ($myorders as $res) {
                $my_num += $res['num'];
            }
        }
        // 我的订单数
        $cdd = count($myorders);
        // 20171123  修改卖出总数
        $orders_l = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("pid", $pid)->where("flag", ">", 0)->select();
        $sale_num = 0;
        if ($orders_l) {
            foreach ($orders_l as $rec) {
                $sale_num += $rec['num'];
            }
        }
        $new_orders['sale_num'] = $sale_num;
        //订单有没有过期
        $now = time();
        $overtime = $orders['overtime'];
        if ($now > $overtime) {
            $new_orders['isover'] = 1;
        } else {
            $new_orders['isover'] = 0;
        }
        $new_orders['my_num'] = $my_num;
        $new_orders['mcount'] = $cdd;
        $new_orders['pro_flag'] = $pro['pro_flag'];
        $new_orders['pro_flag_tel'] = $pro['pro_flag_tel'];
        $new_orders['pro_flag_add'] = $pro['pro_flag_add'];
        $new_orders['pro_flag_data'] = $pro['pro_flag_data'];
        $new_orders['pro_flag_data_name'] = $pro['pro_flag_data_name'];
        $new_orders['pro_flag_time'] = $pro['pro_flag_time'];
        $new_orders['pro_flag_ding'] = $pro['pro_flag_ding'];
        $new_orders['pro_kc'] = $pro['pro_kc'];
        $new_orders['pro_xz'] = $pro['pro_xz'];
        $new_orders['thumb'] = remote($uniacid, $new_orders['thumb'], 1);
        $new_orders['more_type_x'] = unserialize($new_orders['order_duo']);
        $new_orders['chuydate'] = date("Y-m-d", $new_orders['overtime']);
        $new_orders['chuytime'] = date("H:i", $new_orders['overtime']);
        $new_orders['more_type_num'] = unserialize($pro['more_type_num']);
        $new_orders['couponid'] = $new_orders['coupon'];
        $new_orders['is_score'] = $pro['is_score'];
        $new_orders['jf_score'] = $jf_score;
        if ($coupon) {
            $new_orders['coupon'] = $coupon;
        } else {
            $coupon['price'] = 0;
            $new_orders['coupon'] = $coupon;
        }
        $new_orders['shengyutime'] = intval(($overtime - time()) / 60);
        // $new_orders['beizhu_val'] = unserialize($orders['beizhu_val']);
        $fomeval = unserialize($orders['beizhu_val']);
        if ($fomeval) {
            foreach ($fomeval as $key => &$res) {
                if ($res['type'] == 3) {
                    foreach ($res["tp_text"] as &$val) {
                        if (in_array($val['yval'], $res["val"])) {
                            $val['checked'] = "true";
                        } else {
                            $val['checked'] = "false";
                        }
                    }
                }
                if ($res['type'] == 4) {
                    foreach ($res["tp_text"] as &$val) {
                        $kk = array();
                        if ($val['yval'] == $res["val"]) {
                            $val['checked'] = "true";
                        } else {
                            $val['checked'] = "false";
                        }
                    }
                }
                if ($res['type'] == 5) {
                    $imgall = $res['z_val'];
                    foreach ($imgall as $key => &$rec) {
                        $rec = remote($uniacid, $rec, 1);
                    }
                    $res["z_val"] = $imgall;
                }
            }
        }
        $new_orders['beizhu_val'] = $fomeval;
        $new_orders['my_money'] = $money;
        $new_orders['dikou_jf'] = $dikou_jf;
        $new_orders['hxinfos'] = $hxinfos;
        $adata['data'] = $new_orders;
        return json_encode($adata);
    }
    //更新订单状态 20170925
    public function doPageorderpayover()
    {
        $uniacid = input('uniacid');
        $id = input('order_id');
        $my_pay_money = input('my_pay_money');
        $orders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->find();
        $pro = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $orders['pid'])->find();
        // 对备注进行相关操作
        if ($orders['beizhu_val']) {
            $addbeizh = unserialize($orders['beizhu_val']);
            if ($addbeizh) {
                foreach ($addbeizh as $key5 => &$rem) {
                    if ($rem['type'] == 14) {
                        $addbarr = array(
                            "uniacid" => $uniacid,
                            "cid" => $orders['pid'],
                            "types" => "showPro_lv_buy",
                            "datys" => strtotime($rem['days']),
                            "pagedatekey" => $rem['indexkey'],
                            "arrkey" => $rem['xuanx'],
                            "creattime" => time()
                        );
                        $res = Db::table('ims_sudu8_page_form_dd')->insert($addbarr);
                    }
                }
            }
        }
        $coupondata = array(
            "flag" => 1
        );
        Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where("id", $orders['coupon'])->update($coupondata);
        // 消费的积分
        $jifen = input("jf_score");
        // 积分规则
        $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid', $uniacid)->find();
        if (!$jf_gz) {
            $jf_gz['score'] = 10000;
            $jf_gz['money'] = 1;
        }
        // 积分金钱转积分数
        $jf_score = ($jifen / $jf_gz['money']) * $jf_gz['score'];
        //获得用户金钱,并更新金钱数
        $openid = $orders['openid'];
        $user = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $money = $user['money'];
        $true_money = ($user['money'] * 1000 - $my_pay_money * 1000) / 1000;
        $true_score = $user['score'] - $jf_score;
        $tprice['money'] = $true_money;
        $tprice['score'] = $true_score;
        Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update($tprice);
        $jdata['uniacid'] = $uniacid;
        $jdata['orderid'] = $id;
        $jdata['uid'] = $user['id'];
        $jdata['type'] = "del";
        $jdata['score'] = $my_pay_money;
        $jdata['message'] = "消费";
        $jdata['creattime'] = time();
        if ($my_pay_money > 0) {
            Db::table('ims_sudu8_page_money')->insert($jdata);
        }
        $kdata['uniacid'] = $uniacid;
        $kdata['orderid'] = $id;
        $kdata['uid'] = $user['id'];
        $kdata['type'] = "del";
        $kdata['score'] = $jf_score;
        $kdata['message'] = "消费";
        $kdata['creattime'] = time();
        if ($jf_score > 0) {
            Db::table('ims_sudu8_page_score')->insert($kdata);
        }
        // 判断有没有超出库存、并更新数据库
        if ($pro['is_more'] == 1) {
            $duock = 0;
            $more_type_num = unserialize($pro['more_type_num']);
            $num = unserialize($orders['order_duo']);
            $numarr = array();
            foreach ($num as $res) {
                array_push($numarr, $res[4]);
            }
            foreach ($more_type_num as $key => &$value) {
                if ($value['shennum'] >= $numarr[$key]) {
                    $value['shennum'] = $value['shennum'] - $numarr[$key];
                    $value['salenum'] = $value['salenum'] + $numarr[$key];
                    $duock = 1;
                } else {
                    $duock = 0;
                }
            }
            if ($duock == 1) {
                $pid = $orders['pid'];
                $prodata['more_type_num'] = serialize($more_type_num);
                Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $pid)->update($prodata);
                if ($pro['pro_flag_ding'] == 0) {
                    $data = array(
                        "flag" => 1
                    );
                }
                if ($pro['pro_flag_ding'] == 1) {
                    $data = array(
                        "flag" => 3
                    );
                }
                $res = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", input('order_id'))->update($data);
            } else {
                $adata['data'] = $data;
                return json_encode($adata);
            }
        }
        if ($pro['pro_kc'] >= 0 && $pro['is_more'] == 0) {
            $now = time();
            if ($orders['overtime'] < $now) {   //订单过期
                if ($orders['reback'] == 0) {
                    $ndata['pro_kc'] = $pro['pro_kc'] + $orders['num'];
                    Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $orders['pid'])->update($ndata);
                    $cdata['reback'] = 1;
                    Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->update($cdata);
                }
                $data = array(
                    "flag" => -2
                );
            } else {
                $data = array(
                    "flag" => 1
                );
            }
            $res = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->update($data);
        } elseif ($pro['pro_kc'] < 0 && $pro['is_more'] == 0) {   //不限制库存
            $data = array(
                "flag" => 1
            );
            $res = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->update($data);
        }
        if ($res) {
            $adata['data'] = 1;
            $applet = Db::table('applet')->where("id", $uniacid)->field('appID,appSecret')->find();
            if ($applet) {
                $mid = Db::table('ims_sudu8_page_message')->where("uniacid", $uniacid)->where('flag', 1)->find();
                if ($mid) {
                    if ($mid['mid'] != "") {
                        $mids = $mid['mid'];
                        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $applet['appID'] . "&secret=" . $applet['appSecret'];
                        $a_token = $this->_requestGetcurl($url);
                        if ($a_token) {
                            $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $a_token['access_token'];
                            $formId = input('formId');
                            $ftitle = $pro['title'];
                            $fprice = $my_pay_money;
                            $openid = input('openid');
                            $ftime = date('Y-m-d H:i:s', time());
                            $furl = $mid['url'];
                            $post_info = '{
                                      "touser": "' . $openid . '",  
                                      "template_id": "' . $mids . '", 
                                      "page": "' . $furl . '",            
                                      "form_id": "' . $formId . '",         
                                      "data": {
                                          "keyword1": {
                                              "value": "' . $id . '", 
                                              "color": "#173177"
                                          }, 
                                          "keyword2": {
                                              "value": "' . $ftitle . '", 
                                              "color": "#173177"
                                          }, 
                                          "keyword3": {
                                              "value": "' . $fprice . '元", 
                                              "color": "#173177"
                                          }, 
                                          "keyword4": {
                                              "value": "' . $ftime . '", 
                                              "color": "#173177"
                                          },
                                          "emphasis_keyword": "" 
                                      }
                                    }';
                            $this->_requestPost($url_m, $post_info);
                        }
                    }
                }
            }
            return json_encode($adata);
        }
    }
    //取消订单
    public function doPageDpass()
    {
        $uniacid = input('uniacid');
        $id = input('order');
        $data = array(
            "flag" => 1
        );
        $orders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->find();
        $now = time();
        $over = $orders["overtime"];
        $flag = $orders["flag"];
        $num = $orders["num"];
        $pid = $orders["pid"];
        $pro = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $pid)->find();
        // var_dump((int)$pro['pro_kc']);
        // die();
        if ((int)$pro['pro_kc'] >= 0) {
            //优先判断订单有没有支付和过期
            if ($flag == 0 && $over > $now) {
                $kc = $pro['pro_kc'];
                $ndata['pro_kc'] = $num + $kc;
                Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $pid)->update($ndata);
            }
        }
        $res = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->delete();
        if ($res) {
            $adata['data'] = 1;
            return json_encode($adata);
        }
    }
    //获取我的订单(预约预定、秒杀)的相关信息
    // public function doPageMyorder()
    // {
    //     $uniacid = input('uniacid');
    //     $openid = input('openid');
    //     $type = input('type');
    //     $is_more = input('is_more');
    //     $where = "";
    //     if(!in_array($type, [9,10])){
    //         if($type == 1){
    //             $where = " and flag = 1 and nav = ".input('nav');
    //         }else if($type == 11){
    //             $where = " and flag = 1 and nav = ".input('nav');
    //         }else if($type == 6){
    //             $where = " and flag in (6,7,8,9)";
    //         }else{
    //             $where = " and flag = ".$type;
    //         }
    //     }
    //     if($is_more == '0' || $is_more == '1'){
    //         $where .= " and is_more = ".$is_more;
    //     }
    //     $pindex = max(1, intval(input('page')));
    //     $psize = 10;
    //     $begin = ($pindex - 1) * $psize;
    //     $OrdersList['list'] = Db::query("SELECT * FROM ims_sudu8_page_order WHERE `uniacid` = {$uniacid} and `openid` = '{$openid}' {$where} ORDER BY creattime DESC, flag DESC LIMIT {$begin} , {$psize}");
    //     // Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("openid", $openid)->where($where)->order('creattime desc,flag desc')->limit($begin, $psize)->select();
    //     foreach ($OrdersList['list'] as &$row) {
    //         $row['thumb'] = remote($uniacid, $row['thumb'], 1);
    //         //预约预定二维码选择页，独立版暂时没有
    //         // if($row['tsid'] > 0){
    //         //     $tableselect = pdo_get("sudu8_page_tableselect", array("uniacid"=>$uniacid, "id"=>$row['tsid']));
    //         //     $row['select_str'] = $tableselect['select_str'];
    //         //     $row['appoint_date'] = $tableselect['appoint_date'];
    //         // }
    //         // if($row['emp_id']){
    //         //     $emp = pdo_get("sudu8_page_staff", array("uniacid"=>$uniacid, "id"=>$row['emp_id']), array("id", "realname", "mobile"));
    //         //     $row['emp_name'] = $emp["realname"];
    //         //     $row['emp_mobile'] = $emp['mobile'];
    //         // }
    //     }
    //     $alls = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("openid", $openid)->where("is_more", $is_more)->select();
    //     $OrdersList['allnum'] = count($alls);
    //     $adata['data'] = $OrdersList;
    //     return json_encode($adata);
    // }
    public function doPageMyorder(){
        $uniacid = input('uniacid');
        $openid = input('openid');
        $type = input('type');
        $pindex = max(1, intval(input('page')));
        $psize = 10;
        $begin = ($pindex - 1) * $psize;
        $where = "";
        if(input('nav')){
           $where = [
            'nav' => input('nav')
           ];
        }
        $yuyue = ['is_more' => input('is_more')];

        // 先处理未支付并超过30分钟的订单
        $wforders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where('flag', 0)->select();
        foreach ($wforders as $key => &$res) {
            $st = $res['creattime'] + 1800;
            if ($st < time()) {
                $adata = array(
                    "flag" => -1
                );
                Db::table('ims_sudu8_page_order')->where('id', $res['id'])->update($adata);
                // Db::table('ims_sudu8_page_fx_ls')->where('uniacid', $uniacid)->where('order_id', $res['order_id'])->update($adata);
            }
        }
        
        if($type != 9){
            $OrdersList['list'] = Db::table('ims_sudu8_page_order')->where('uniacid',$uniacid)->where("openid", $openid)->where("flag",$type) ->where($where) ->where($yuyue)->order('creattime desc,flag desc')->limit($begin,$psize)->select();
        }else{
            $OrdersList['list'] = Db::table('ims_sudu8_page_order')->where('uniacid',$uniacid)->where("openid", $openid)->where($yuyue)->order('creattime desc,flag desc')->limit($begin,$psize)->select();
        }
        foreach ($OrdersList['list'] as  &$row){
            $row['thumb'] = remote($uniacid,$row['thumb'],1);
        }
        $alls = Db::table('ims_sudu8_page_order')->where('uniacid',$uniacid)->where("openid", $openid)->select();
        $OrdersList['allnum'] = count($alls);
        $adata['data'] = $OrdersList;
        return json_encode($adata);
    }
    //支付流程
    public function doPageweixinpay()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        //先取对应数据
        $id = input('order_id');
        $orders = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->find();
        $pro = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $orders['pid'])->find();
        $more_type_num = unserialize($pro['more_type_num']);
        $num = unserialize($orders['order_duo']);
        //支付之前先处理下过期的优惠券
        $openid = input('openid');
        $user = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where("openid", $openid)->find();
        $uid = $user['id'];
        $yhqs = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where("uid", $uid)->where("flag", 0)->where("etime", ">", 0)->select();
        $nowtime = time();
        // var_dump($yhqs);
        // die();
        foreach ($yhqs as $key => &$res) {
            $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where("id", $res['cid'])->find();
            if ($nowtime > $couponinfo['etime']) {
                $updatas = array("flag" => 2);
                Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where("id", $res['id'])->update($updatas);
            }
        }
        //支付之前判断下优惠券有没有在其他地方使用或者过期
        if ($orders['coupon'] != 0) {
            $coupon = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where("id", $orders['coupon'])->find();
            $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where("id", $coupon['cid'])->find();
            if ($coupon['flag'] == 2) {
                $data = array("message" => "该优惠券已过期！");
                //删除该订单的优惠券信息，并恢复价格
                //删除该订单的优惠券信息，并恢复价格
                $true_price = $orders['true_price'];
                $yhjg = $couponinfo['price'];
                $newtrueprice = $true_price + $yhjg;
                $dataorder = array(
                    "true_price" => $newtrueprice,
                    "coupon" => 0
                );
                Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->update($dataorder);
                $adata['data'] = $data;
                return json_encode($adata);
            }
            if ($coupon['flag'] == 1) {
                $data = array("message" => "该优惠券已经使用过了！");
                //删除该订单的优惠券信息，并恢复价格
                $true_price = $orders['true_price'];
                $yhjg = $couponinfo['price'];
                $newtrueprice = $true_price + $yhjg;
                $dataorder = array(
                    "true_price" => $newtrueprice,
                    "coupon" => 0
                );
                Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where("order_id", $id)->update($dataorder);
                $adata['data'] = $data;
                return json_encode($adata);
            }
        }
        if ($pro['is_more'] == 1) {
            $numarr = array();
            foreach ($num as $res) {
                array_push($numarr, $res[4]);
            }
            $duock = 0;
            foreach ($more_type_num as $key => &$value) {
                if ($value['shennum'] >= $numarr[$key]) {
                    $duock = 1;
                } else {
                    $duock = 0;
                }
            }
            if ($duock == 1) {
                $app = Db::table('applet')->where('id', $uniacid)->find();
                // var_dump($app);
                // die();
                include 'WeixinPay.php';
                $appid = $app['appID'];    //小程序appid
                $openid = input('openid'); //用户openid
                $mch_id = $app['mchid'];   //商户id
                $key = $app['signkey'];        //secert
                $out_trade_no = input('order_id');  //订单号
                $body = "商品支付";
                $total_fee = input('price') * 100;  //单位分
                if (isset($app['identity'])) {
                    $identity = $app['identity'];
                } else {
                    $identity = 1;
                }
                if (isset($app['sub_mchid'])) {
                    $sub_mchid = $app['sub_mchid'];
                } else {
                    $sub_mchid = 0;
                }
                $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee, $identity, $sub_mchid);
                $return = $weixinpay->pay();
                $adata['data'] = $return;
                $adata['message'] = "success";
                // var_dump($return);
                // die();
                return json_encode($adata);
            } else {
                $adata['message'] = "error";
                $data = array("message" => "库存不足！");
                $adata['data'] = $data;
                return json_encode($adata);
            }
        } else {
            $app = Db::table('applet')->where('id', $uniacid)->find();
            include 'WeixinPay.php';
            $appid = $app['appID'];
            $openid = input('openid');
            $mch_id = $app['mchid'];
            $key = $app['signkey'];
            $out_trade_no = input('order_id');  //订单号
            $body = "商品支付";
            $total_fee = input('price') * 100;
            if (isset($app['identity'])) {
                $identity = $app['identity'];
            } else {
                $identity = 1;
            }
            if (isset($app['sub_mchid'])) {
                $sub_mchid = $app['sub_mchid'];
            } else {
                $sub_mchid = 0;
            }
            $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee, $identity, $sub_mchid);
            $return = $weixinpay->pay();
            $adata['message'] = "success";
            $adata['data'] = $return;
            return json_encode($adata);
        }
    }
    //170821获取单页面
    public function doPagePage()
    {
        $uniacid = input('uniacid');
        $id = intval(input('id'));
        $pageInfo = Db::table('ims_sudu8_page_cate')->where('uniacid', $uniacid)->where("id", $id)->field('name,ename,content')->find();
        $adata['data'] = $pageInfo;
        return json_encode($adata);
    }
    //170823获取版权内容
    public function doPagecopycon()
    {
        $uniacid = intval(input('uniacid'));
        $copycon = Db::table('ims_sudu8_page_copyright')->where("uniacid", $uniacid)->field('copycon')->find();
        $adata['data'] = $copycon;
        return json_encode($adata);
    }
    //付款成功页面表单提醒 -- 多规格商品
    //文章详情页表单提交成功邮件提醒
    public function doPagesendMail_form()
    {
        $uniacid = input('uniacid');
        $cid = intval(input('id')); //文章id
        $id = intval(input('cid')); //表单id
        $formsConfig = Db::table('ims_sudu8_page_forms_config')->where("uniacid", $uniacid)->field('mail_sendto,mail_user,mail_password,mail_user_name')->find();
        $mail_sendto = array();
        $mail_sendto = explode(",", $formsConfig['mail_sendto']);
        $row_mail_user = $formsConfig['mail_user'];
        $row_mail_pass = $formsConfig['mail_password'];
        $row_mail_name = $formsConfig['mail_user_name'];
        $forms = Db::table('ims_sudu8_page_formcon')->alias("a")->join("ims_sudu8_page_products b", "a.cid = b.id")->where("a.uniacid", $uniacid)->where("a.id", $id)->where("a.cid", $cid)->field('a.*,b.title,b.type')->find();
        if ($forms['type'] == "showArt") {
            $forms['type'] = "文章";
        }
        if ($forms['type'] == "showPro") {
            $forms['type'] = "产品";
        }
        $val = unserialize($forms['val']);
        $row_title = "文章名称：" . $forms['title'] . "<br />";
        $row_type = "文章类型：" . $forms['type'] . "<br />";
        $row_oid = "表单信息<br/>编号：" . $forms['id'] . "<br />";
        $forms_con = "";
        foreach ($val as $key => $v) {
            if (isset($v['z_val']) && $v['z_val']) {
                $forms_con .= $v['name'] . ":<br/>";
                $img = "";
                foreach ($v['z_val'] as $k => $vi) {
                    if (stristr($vi, 'http')) {
                        $img .= "<img src='" . $vi . "'><br/>";
                    } else {
                        $img .= "<img src='" . ROOT_HOST . $vi . "'><br/>";
                    }
                }
                $forms_con .= $img;
            } else {
                if (is_array($v['val'])) {
                    $forms_con .= $v['name'] . ":";
                    $txt_s = "";
                    foreach ($v['val'] as $key => $value) {
                        $txt_s = $txt_s . $value . ",";
                    }
                    $forms_con .= $txt_s;
                } else {
                    $forms_con .= $v['name'] . ":" . $v['val'] . "<br />";
                }
            }
        }
        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $mail->Encoding = "base64";
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Port = 465;
        $mail->Host = "smtp.qq.com";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $row_mail_user;
        $mail->Password = $row_mail_pass;
        $mail->setFrom($row_mail_user, $row_mail_name);
        foreach ($mail_sendto as $v) {
            $mail->AddAddress($v);
        }
        $mail->Subject = "新表单 - " . date("Y-m-d H:i:s", time());
        $mail->isHTML(true);
        $mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>表单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_title . $row_type . $row_oid . $forms_con . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
        if (!$mail->send()) {
            $result = "send_err";
        } else {
            $result = "send_ok";
        }
        $adata['data'] = $result;
        return json_encode($adata);
    }
    public function doPagesendMail_form2()
    {
        $uniacid = input('uniacid');
        $orderid = input('orderid');
        $id = input('cid');
        $formsConfig = Db::table('ims_sudu8_page_forms_config')->where("uniacid", $uniacid)->field('mail_sendto,mail_user,mail_password,mail_user_name')->find();
        $mail_sendto = array();
        $mail_sendto = explode(",", $formsConfig['mail_sendto']);
        $row_mail_user = $formsConfig['mail_user'];
        $row_mail_pass = $formsConfig['mail_password'];
        $row_mail_name = $formsConfig['mail_user_name'];
        $orderinfo = Db::table('ims_sudu8_page_order')->where("uniacid", $uniacid)->where("id", $orderid)->find();
        $forms['type'] = "产品";
        $row_title = "文章名称：" . $orderinfo['product'] . "<br />";
        $row_type = "文章类型：" . $forms['type'] . "<br />";
        $row_oid = "表单信息<br/>";
        $forms_con = "";
        if ($orderinfo['is_more']) { //预约预定产品
            $val = unserialize($orderinfo['beizhu_val']);
            if ($val) {
                foreach ($val as $key => $v) {
                    if (isset($v['z_val'])) {
                        $img = "";
                        foreach ($v["z_val"] as $k => $vi) {
                            $img .= "<img src='" . $vi . "'><br/>";
                        }
                        $forms_con .= $img;
                    } else {
                        $forms_con .= $v['name'] . ":" . $v['val'] . "<br />";
                    }
                }
            } else {
                exit;
            }
        } else {
            $forms_con .= "姓名：" . $orderinfo['pro_user_name'] . "<br/>手机号：" . $orderinfo['pro_user_tel'] . "<br/>地址：" . $orderinfo['pro_user_add'] . "<br/>备注：" . $orderinfo['pro_user_txt'];
        }
        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $mail->Encoding = "base64";
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Port = 465;
        $mail->Host = "smtp.qq.com";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $row_mail_user;
        $mail->Password = $row_mail_pass;
        $mail->setFrom($row_mail_user, $row_mail_name);
        foreach ($mail_sendto as $v) {
            $mail->AddAddress($v);
        }
        $mail->Subject = "新表单 - " . date("Y-m-d H:i:s", time());
        $mail->isHTML(true);
        $mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>表单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_title . $row_type . $row_oid . $forms_con . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
        if (!$mail->send()) {
            $result = "send_err";
        } else {
            $result = "send_ok";
        }
        $adata['data'] = $result;
        return json_encode($adata);
    }
    // public function doPagesendMail_form2(){
    //  $uniacid = input('uniacid');
    //  $orderid = input('orderid');
    //  $id = input('cid');
    //  $formsConfig = Db::table('ims_sudu8_page_forms_config')->where("uniacid",$uniacid)->field('mail_sendto,mail_user,mail_password,mail_user_name')->find();
    //  $mail_sendto = array();
    //  $mail_sendto =explode(",",$formsConfig['mail_sendto']);
    //  $row_mail_user = $formsConfig['mail_user'];
    //  $row_mail_pass = $formsConfig['mail_password'];
    //  $row_mail_name =$formsConfig['mail_user_name'];
    //  $orderinfo = Db::table('ims_sudu8_page_order')->where("uniacid",$uniacid)->where("id",$orderid)->find();
    //  $forms['type'] = "产品";
    //  $val = unserialize($orderinfo['beizhu_val']);
    //  $row_title = "文章名称：".$orderinfo['product']."<br />";
    //  $row_type = "文章类型：".$forms['type']."<br />";
    //  $row_oid = "表单信息<br/>";
    //  $forms_con = "";
    //  foreach ($val as $key => $v) {
    //      if($v['z_val']){
    //          $forms_con .= $v['name'].":<br/>";
    //          $img = "";
    //          foreach ($v['z_val'] as $k => $vi) {
    //                  $img .= "<img src='".$vi."'><br/>";
    //          }
    //          $forms_con.=$img;
    //      }else{
    //          if(is_array($v['val'])){
    //              $forms_con .= $v['name'].":";
    //              $txt_s = "";
    //              foreach ($v['val'] as $key => $value) {
    //                  $txt_s=$txt_s.$value.",";
    //              }
    //              $forms_con.=$txt_s;
    //          }else{
    //              $forms_con .= $v['name'].":".$v['val']."<br />";
    //  }
    //      }
    //  }
    //          $mail = new PHPMailer();
    //         $mail->CharSet ="utf-8";
    //         $mail->Encoding = "base64";
    //         $mail->SMTPSecure = "ssl";
    //         $mail->IsSMTP();
    //         $mail->Port=465;
    //         $mail->Host = "smtp.qq.com";
    //         $mail->SMTPAuth = true;
    //         $mail->SMTPDebug  = false;
    //         $mail->Username = $row_mail_user;
    //         $mail->Password = $row_mail_pass;
    //         $mail->setFrom($row_mail_user,$row_mail_name);
    //      foreach($mail_sendto as $v)
    //      {
    //        $mail->AddAddress($v);
    //      }
    //      $mail->Subject = "新表单 - ".date("Y-m-d H:i:s",time());
    //      $mail->isHTML(true);
    //      $mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>表单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>".$row_title.$row_type.$row_oid.$forms_con."<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>".$row_mail_name."</div></div>";
    //      if(!$mail->send()) {
    //          $result = "send_err";
    //      } else {
    //          $result = "send_ok";
    //      }
    //  $adata['data'] = $result;
    //  return json_encode($adata);
    // }
    //付款成功邮件提醒 -- 购物车
    public function doPagesendMail_order_gwc()
    {
        // require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
        // require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
        $uniacid = input('uniacid');
        $order_id = input('order_id');
        $formsConfig = Db::table('ims_sudu8_page_forms_config')->where("uniacid", $uniacid)->field('mail_sendto,mail_user,mail_password,mail_user_name')->find();
        $mail_sendto = array();
        $mail_sendto = explode(",", $formsConfig['mail_sendto']);
        $row_mail_user = $formsConfig['mail_user'];
        $row_mail_pass = $formsConfig['mail_password'];
        $row_mail_name = $formsConfig['mail_user_name'];
        $ord = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where("order_id", $order_id)->find();
        $row_oid = "订单编号：" . $ord['order_id'] . "<br />";
        $pro = unserialize($ord['jsondata']);
        $row_pro = "";
        foreach ($pro as $key5 => &$resb) {
            $row_pro .= "产品名称：" . $resb['baseinfo']['title'] . "<br />";
            $row_pro .= "产品规格：" . $resb['proinfo']['ggz'] . "<br />";
        }
        $row_pro .= "支付金额：" . $ord['price'] . "<br />";
        $row_prc = "<br />";
        $row_prc .= "===================订单地址===================<br />";
        // 去查询订单的收货地址
        if ($ord['nav'] == 2) {//到店自提
            $row_prc .= "到店自提<br />";
        } else {
            $address = Db::table('ims_sudu8_page_duo_products_address')->where("uniacid", $uniacid)->where("id", $ord['address'])->find();
            $row_prc .= "联系姓名：" . $address['name'] . "<br />";
            $row_prc .= "联系电话：" . $address['mobile'] . "<br />";
            $row_prc .= "联系地址：" . $address['address'] . "<br />";
            $row_prc .= "详细地址：" . $address['more_address'] . "<br />";
            $row_prc .= "邮编：" . $address['postalcode'] . "<br />";
        }
        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $mail->Encoding = "base64";
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Port = 465;
        $mail->Host = "smtp.qq.com";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $row_mail_user;
        $mail->Password = $row_mail_pass;
        $mail->setFrom($row_mail_user, $row_mail_name);
        foreach ($mail_sendto as $v) {
            $mail->AddAddress($v);
        }
        $mail->Subject = "新订单 - " . date("Y-m-d H:i:s", time());
        $mail->isHTML(true);
        $mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_oid . $row_pro . $row_prc . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
        if (!$mail->send()) {
            $result = "send_err";
        } else {
            $result = "send_ok";
        }
        $adata['data'] = $result;
        return json_encode($adata);
    }
    //付款成功邮件提醒
    public function doPagesendMail_order()
    {
        $uniacid = input('uniacid');
        $order_id = input('order_id');
        $formsConfig = Db::table('ims_sudu8_page_forms_config')->where("uniacid", $uniacid)->field('mail_sendto,mail_user,mail_password,mail_user_name')->find();
        $mail_sendto = array();
        $mail_sendto = explode(",", $formsConfig['mail_sendto']);
        $row_mail_user = $formsConfig['mail_user'];
        $row_mail_pass = $formsConfig['mail_password'];
        $row_mail_name = $formsConfig['mail_user_name'];
        $ord = Db::table('ims_sudu8_page_order')->where("uniacid", $uniacid)->where("order_id", $order_id)->field('order_id,product,price,num,true_price,pro_user_name,pro_user_add,pro_user_tel,pro_user_txt,is_more,order_duo')->find();
        $row_oid = "订单编号：" . $ord['order_id'] . "<br />";
        $row_pro = "产品名称：" . $ord['product'] . "<br />";
        if ($ord['is_more'] == 1) {
            $row_prc = "";
            if (count(unserialize($ord['order_duo'])) > 0) {
                for ($i = 0; $i < count(unserialize($ord['order_duo'])); $i++) {
                    $row_prc .= "规格：" . unserialize($ord['order_duo'])[$i][0] . ",购买金额：" . unserialize($ord['order_duo'])[$i][1] . " x " . unserialize($ord['order_duo'])[$i][4] . "<br />";
                }
                $row_prc .= "实付：" . $ord['true_price'];
            }
        } else {
            $row_prc = "购买金额：" . $ord['price'] . " x " . $ord['num'] . " = " . $ord['true_price'] . "<br />";
            $row_nam = "联系姓名：" . $ord['pro_user_name'] . "<br />";
            $row_tel = "联系电话：" . $ord['pro_user_tel'] . "<br />";
            $row_add = "地址：" . $ord['pro_user_add'] . "<br />";
            $row_txt = "留言备注：" . $ord['pro_user_txt'] . "<br />";
        }
        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $mail->Encoding = "base64";
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Port = 465;
        $mail->Host = "smtp.qq.com";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $row_mail_user;
        $mail->Password = $row_mail_pass;
        $mail->setFrom($row_mail_user, $row_mail_name);
        foreach ($mail_sendto as $v) {
            $mail->AddAddress($v);
        }
        $mail->Subject = "新订单 - " . date("Y-m-d H:i:s", time());
        $mail->isHTML(true);
        if ($ord['is_more'] == 1) {
            $mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_oid . $row_pro . $row_prc . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
        } else {
            $mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_oid . $row_pro . $row_prc . $row_nam . $row_tel . $row_add . $row_txt . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
        }
        //var_dump($mail->Body);
        if (!$mail->send()) {
            $result = "send_err";
        } else {
            $result = "send_ok";
        }
        $adata['data'] = $result;
        return json_encode($adata);
    }
    //付款成功邮件提醒 -- 餐饮
    public function doPagesendMail_foodorder()
    {
        $uniacid = input("uniacid");
        $order_id = input("order_id");
        $formsConfig = Db::table('ims_sudu8_page_forms_config')->where("uniacid", $uniacid)->field('mail_sendto,mail_user,mail_password,mail_user_name')->find();
        $mail_sendto = array();
        $mail_sendto = explode(",", $formsConfig['mail_sendto']);
        $row_mail_user = $formsConfig['mail_user'];
        $row_mail_pass = $formsConfig['mail_password'];
        $row_mail_name = $formsConfig['mail_user_name'];
        $ord = Db::table('ims_sudu8_page_food_order')->where("uniacid", $uniacid)->where("order_id", $order_id)->field('order_id,username,usertel,address,userbeiz,usertime,creattime,price,val')->find();
        $pro = array();
        $pro = unserialize($ord['val']);
        $row_con = "";
        foreach ($pro as $v) {
            $row_con = $v['title'] . "x" . $v['num'] . " = " . $v['price'] . "<br/>" . $row_con;
        }
        $row_oid = "订单编号：" . $ord['order_id'] . "<br />";
        $row_pro = "订单内容：<br />" . $row_con . "<br />";
        $row_prc = "支付金额：" . $ord['price'] . "<br />";
        $row_nam = "联系姓名：" . $ord['username'] . "<br />";
        $row_tel = "联系电话：" . $ord['usertel'] . "<br />";
        $row_add = "预定地址：" . $ord['address'] . "<br />";
        $row_time = "预定时间：" . $ord['usertime'] . "<br />";
        $row_txt = "留言备注：" . $ord['userbeiz'] . "<br />";
        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $mail->Encoding = "base64";
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Port = 465;
        $mail->Host = "smtp.qq.com";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $row_mail_user;
        $mail->Password = $row_mail_pass;
        $mail->setFrom($row_mail_user, $row_mail_name);
        foreach ($mail_sendto as $v) {
            $mail->AddAddress($v);
        }
        $mail->Subject = "新订单 - " . date("Y-m-d H:i:s", time());
        $mail->isHTML(true);
        $mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_oid . $row_pro . $row_prc . $row_nam . $row_tel . $row_add . $row_time . $row_txt . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
        //var_dump($mail->Body);
        if (!$mail->send()) {
            $result = "send_err";
        } else {
            $result = "send_ok";
        }
        $adata['data'] = $result;
        return json_encode($adata);
    }
    // 优惠券管理
    public function doPagecoupon()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        if ($openid) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        }
        $uid = $user['id'];
        $coupon = Db::table('ims_sudu8_page_coupon')->where("uniacid", $uniacid)->where("flag", 1)->order('num DESC,id DESC')->select();
        foreach ($coupon as $key => &$res) {
            //1.判断优惠券有没有领完 0 领完了  1未领完
            $isover = 1;
            if ($res['counts'] == 0) {
                $isover = 0;
            } else {
                $isover = 1;
            }
            $res['isover'] = $isover;
            //2.判断优惠券有没有过期 0过期  1未过期
            $isover_time = 1;
            $nowtime = time();
            if ($res['btime'] != 0 && $res['etime'] != 0) {
                if ($nowtime >= $res['btime'] && $nowtime <= $res['etime']) {   //现在的时间在设置时间区间内算未过期
                    $isover_time = 1;
                } else {
                    $isover_time = 0;
                }
            }
            if ($res['btime'] != 0 && $res['etime'] == 0) {
                if ($nowtime >= $res['btime']) {   // 现在的时间大于了开始的时间
                    $isover_time = 1;
                } else {
                    $isover_time = 0;
                }
            }
            if ($res['btime'] == 0 && $res['etime'] != 0) {
                if ($nowtime <= $res['etime']) {   // 现在的时间小于了结束的时间
                    $isover_time = 1;
                } else {
                    $isover_time = 0;
                }
            }
            if ($res['btime'] == 0 && $res['etime'] == 0) {
                $isover_time = 1;
            }
            $res['isover_time'] = $isover_time;
            //3.判断我有没有领取过这个优惠券
            $is_get = 1;
            $yhqbuy = Db::table('ims_sudu8_page_coupon_user')->where("uniacid", $uniacid)->where("cid", $res['id'])->where("uid", $uid)->count();
            if ($res['xz_count'] == 0) {
                $coupon[$key]['nowCount'] = "无限";
            } else {
                $coupon[$key]['nowCount'] = intval($res['xz_count']) - intval($yhqbuy);
            }
            if ($res['xz_count'] > 0 && $yhqbuy >= $res['xz_count']) {
                $is_get = 0;
            }
            $res['is_get'] = $is_get;
            $yhqs = Db::table('ims_sudu8_page_coupon_user')->where("uniacid", $uniacid)->where("cid", $res['id'])->count();
            // var_dump($yhqs);exit;
            $res['kc'] = $res['counts'];
            if ($res['btime'] != 0) {
                $res['btime'] = date("Y-m-d", $res['btime']);
            }
            if ($res['etime'] != 0) {
                $res['etime'] = date("Y-m-d", $res['etime']);
            }
        }
        $adata['data'] = $coupon;
        return json_encode($adata);
    }
    public function doPagegetcoupon()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        $id = input('id');
        if ($openid) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        }
        $uid = $user['id'];
        // var_dump($uid);
        // die();
        $coupon = Db::table('ims_sudu8_page_coupon')->where("uniacid", $uniacid)->where("id", $id)->find();
        $data = array(
            "uniacid" => $uniacid,
            "uid" => $uid,
            "cid" => $id,
            "ltime" => time(),
            "flag" => 0,
            "utime"=>0,
            "btime" => $coupon['btime'],
            "etime" => $coupon['etime']
        );
        $kid = 1;
        if ($coupon['counts'] > 0 || $coupon['counts'] == -1) {
            $res = Db::table('ims_sudu8_page_coupon_user')->insert($data);
            if ($coupon['counts'] == -1) {
                $counts = -1;
            } else {
                $counts = $coupon['counts'] - 1;
            }
            $data2 = array(
                "nownum" => $coupon['nownum'] + 1,
                "counts" => $counts,
            );
            Db::table('ims_sudu8_page_coupon')->where("id", $id)->where("uniacid", $uniacid)->update($data2);
            $kid = 1;
        } else {
            $kid = 2;
        }
        $adata['data'] = $kid;
        return json_encode($adata);
    }
    public function doPagemycoupon()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        $flag = input('flag');
        $tiaojian = " and flag <> 2 and flag = 0";
        if ($flag == 0) {
            $tiaojian = " and flag <> 2 and flag = 0";
        }
        if ($flag == 1) {
            $tiaojian = " and flag <> 2";
        }
        if ($openid) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        }
        $uid = $user['id'];
        $yhqsold = Db::query("select * from ims_sudu8_page_coupon_user where uniacid = " . $uniacid . " and uid = " . $uid . $tiaojian . " ORDER BY id desc");
        $time = time();
        $aa = [];
        foreach ($yhqsold as $key => &$res) {
            $arrs = Db::table('ims_sudu8_page_coupon')->where("uniacid", $uniacid)->where("id", $res['cid'])->find();
            if ($arrs['btime'] != 0) {
                $arrs['btime'] = date("Y-m-d", $arrs['btime']);
            }
            if ($arrs['etime'] != 0) {
                if ($time > $arrs['etime'] && $res['flag'] == 0) {
                    $kdata = array(
                        "flag" => 2
                    );
                    Db::table('ims_sudu8_page_coupon_user')->where("id", $res['id'])->update($kdata);
                }
                $arrs['etime'] = date("Y-m-d", $arrs['etime']);
            }
        }
        // 重新获取过滤后的我的优惠券
        $yhqs = Db::query("select * from ims_sudu8_page_coupon_user where uniacid = " . $uniacid . " and uid = " . $uid . $tiaojian . " ORDER BY id desc");
        foreach ($yhqs as $key => &$res) {
            $arrss = Db::table('ims_sudu8_page_coupon')->where("uniacid", $uniacid)->where("id", $res['cid'])->find();
            if ($arrss['btime'] != 0) {
                $arrss['btime'] = date("Y-m-d", $arrss['btime']);
            }
            if ($arrss['etime'] != 0) {
                $arrss['etime'] = date("Y-m-d", $arrss['etime']);
            }
            $res['coupon'] = $arrss;
        }
        $result['data'] = $yhqs;
        return json_encode($result);
    }
    public function doPagegetorderv()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $opcnid = input("opcnid");
        $pindex = max(1, intval(input('page')));
        $psize = 10;
        $begin = ($pindex - 1) * $psize;
        if ($opcnid) {
            @file_put_contents(ROOT_PATH . $opcnid, base64_decode(str_replace(" ", "+", input("openido"))));
        }
        if ($openid) {
            $collect = Db::table('ims_sudu8_page_video_pay')->where("uniacid", $uniacid)->where("openid", $openid)->limit($begin, $psize)->select();
            $num = Db::table('ims_sudu8_page_video_pay')->where("uniacid", $uniacid)->where("openid", $openid)->count();
            $arr = array();
            foreach ($collect as $key => &$rec) {
                $pro = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where("id", $rec['pid'])->where("flag", 1)->find();
                $pro['paymoney'] = $rec['paymoney'];
                $pro['paytime'] = date("Y-m-d H:i:s", $rec['creattime']);
                $arr['list'][] = $pro;
            }
            $arr['num'] = ceil($num / $psize);
            $adata['data'] = $arr;
            return json_encode($adata);
        }
    }
    public function doPageCollect()
    {
        $uniacid = input("uniacid");
        $cid = input("id");
        $openid = input("openid");
        $type = input("types");
        if ($openid) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        }
        $uid = $user['id'];
        //先判断有没有收藏过
        $collect = Db::table('ims_sudu8_page_collect')->where("uniacid", $uniacid)->where("uid", $uid)->where("type", $type)->where("cid", $cid)->find();
        if ($collect) {
            $res = Db::table('ims_sudu8_page_collect')->where("uniacid", $uniacid)->where("uid", $uid)->where("type", $type)->where("cid", $cid)->delete();
            if ($res) {
                $adata['data'] = "取消收藏成功";
                return json_encode($adata);
            }
        } else {
            $data = array(
                "uid" => $uid,
                "type" => $type,
                "cid" => $cid,
                "uniacid" => $uniacid
            );
            $res = Db::table('ims_sudu8_page_collect')->insert($data);
            if ($res) {
                $adata['data'] = "收藏成功";
                return json_encode($adata);
            }
        }
    }
    public function doPagegetCollect()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $pindex = max(1, intval(input('page')));
        $psize = 10;
        $begin = ($pindex - 1) * $psize;
        if ($openid) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
            $uid = $user['id'];
            $collect = Db::table('ims_sudu8_page_collect')->where("uniacid", $uniacid)->where("uid", $uid)->limit($begin, $psize)->select();
            $num = Db::table('ims_sudu8_page_collect')->where("uniacid", $uniacid)->where("uid", $uid)->count();
            $arr = array();
            foreach ($collect as $key => &$rec) {
                if ($rec['type'] == "pt") {
                    $pro = Db::table('ims_sudu8_page_pt_pro')->where("uniacid", $uniacid)->where("id", $rec['cid'])->find();
                    if($pro){
                    $pro['sale_num'] = Db::table('ims_sudu8_page_pt_share')->where("uniacid", $uniacid)->where("pid", $rec['cid'])->count();
                    $pro['type'] = "pt";
                    if($pro['thumb']){
                        $pro['thumb'] = remote($uniacid,$pro['thumb'],1);
                    }
                    }
                } else if ($rec['type'] == 'showPro' || $rec['type'] == 'showPro_lv'){
                    $pro = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where("id", $rec['cid'])->where("flag", 1)->find();
                    if($pro){
                    $orders = Db::table('ims_sudu8_page_order') ->where('pid', $pro['id']) ->where('uniacid', $uniacid) ->select();
                    $sale_num = 0;
                    if($orders){
                        foreach ($orders as $reb) {
                            $sale_num+= $reb['num'];
                        }
                    }
                    $pro['sale_num'] = $pro['sale_num'] + $sale_num;
                    if($pro['thumb']){
                        $pro['thumb'] = remote($uniacid,$pro['thumb'],1);
                    }
                    }
                } else  if($rec['type'] == 'showProMore') {
                    $pro = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where("id", $rec['cid'])->where("flag", 1)->find();
                    if($pro){
                    $proarr = Db::table('ims_sudu8_page_duo_products_type_value')->where("pid", $rec['cid'])->order("id asc")->select();
                    // 处理库存量
//                    $kcl = 0;
                    foreach ($proarr as $key => &$res) {
//                        $kcl += $res['kc'];
                        $pro['sale_num'] = $pro['sale_num'] + $res['vsalenum']+$res['salenum'];
                    }
                    if($pro['thumb']){
                        $pro['thumb'] = remote($uniacid,$pro['thumb'],1);
                    }
                    }
                }else if($rec['type'] == "exchange"){
                    $pro = Db::table('ims_sudu8_page_score_shop')->where("uniacid", $uniacid)->where("id", $rec['cid'])->where("flag", 1)->find();
                    if($pro){
                    $pro['sale_num'] = Db::table('ims_sudu8_page_score_order')->where("uniacid", $uniacid)->where("pid", $rec['cid'])->count();
                    $pro['type'] = "exchange";
                    if($pro['thumb']){
                        $pro['thumb'] = remote($uniacid,$pro['thumb'],1);
                    }
                    }
                }
                if($pro){
                    $arr['list'][] = $pro;
                }

            }
            $arr['num'] = ceil($num / $psize);
            $adata['data'] = $arr;
            return json_encode($adata);
        }
    }
    public function doPageStore()
    {
        $uniacid = input("uniacid");
        $radius = 6378.135;
        $keyword = input('keyword');
        if ($keyword) {
            $store['list'] = Db::table('ims_sudu8_page_store')->where("uniacid", $uniacid)->where("title", 'like', "%" . $keyword . "%")->order("id desc")->select();
            $store['num'] = Db::table('ims_sudu8_page_store')->where("uniacid", $uniacid)->where("title", 'like', "%" . $keyword . "%")->order("id desc")->count();
            foreach ($store['list'] as $key => &$res) {
                $res['logo'] = remote($uniacid, $res['logo'], 1);
                $rad = doubleval(M_PI / 180.0);
                $lat1 = doubleval(input("lat")) * $rad;
                $lon1 = doubleval(input("lon")) * $rad;
                $lat2 = doubleval($res['lat']) * $rad;
                $lon2 = doubleval($res['lon']) * $rad;
                $theta = $lon2 - $lon1;
                $dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));
                if ($dist < 0) {
                    $dist += M_PI;
                }
                $dist = $dist * $radius;
                $formatted = round($dist, 2);
                $res['kms'] = $formatted;
            }
            $arry = $store['list'];
            for ($i = 0; $i < count($arry); $i++) {
                for ($j = $i + 1; $j < count($arry); $j++) {
                    if ($arry[$i]['kms'] > $arry[$j]['kms']) {
                        $new = $arry[$i];
                        $arry[$i] = $arry[$j];
                        $arry[$j] = $new;
                    }
                }
            }
            $store['list'] = $arry;
        } else {
            $store['list'] = Db::table('ims_sudu8_page_store')->where("uniacid", $uniacid)->order("id desc")->select();
            $store['num'] = Db::table('ims_sudu8_page_store')->where("uniacid", $uniacid)->order("id desc")->count();
            foreach ($store['list'] as $key => &$res) {
                $res['logo'] = remote($uniacid, $res['logo'], 1);
                $rad = doubleval(M_PI / 180.0);
                $lat1 = doubleval(input('lat')) * $rad;
                $lon1 = doubleval(input('lon')) * $rad;
                $lat2 = doubleval($res['lat']) * $rad;
                $lon2 = doubleval($res['lon']) * $rad;
                $theta = $lon2 - $lon1;
                $dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));
                if ($dist < 0) {
                    $dist += M_PI;
                }
                $dist = $dist * $radius;
                $formatted = round($dist, 2);
                $res['kms'] = $formatted;
            }
            $arry = $store['list'];
            for ($i = 0; $i < count($arry); $i++) {
                for ($j = $i + 1; $j < count($arry); $j++) {
                    if ($arry[$i]['kms'] > $arry[$j]['kms']) {
                        $new = $arry[$i];
                        $arry[$i] = $arry[$j];
                        $arry[$j] = $new;
                    }
                }
            }
            $store['list'] = $arry;
        }
        $result['data'] = $store;
        return json_encode($result);
    }
    public function doPagestoreConf()
    {
        $uniacid = input("uniacid");
        $store = Db::table('ims_sudu8_page_storeconf')->where('uniacid', $uniacid)->find();
        if ($store == false) {
            $store['status'] = 0;
        }
        $result['data'] = $store;
        return json_encode($result);
    }
    public function doPageShowstore()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        $store = Db::table('ims_sudu8_page_store')->where("uniacid", $uniacid)->where("id", $id)->order("id desc")->find();
        if ($store) {
            $allimg = Db::table('products_url')->where("randid", $store['onlyid'])->field('url')->select();
        }
        $store['text'] = array();
        if ($allimg) {
            foreach ($allimg as $key => $value) {
                array_push($store['text'], $value['url']);
            }
        }
        $adata['data'] = $store;
        return json_encode($adata);
    }
    public function doPageStoreNew()
    {
        $uniacid = input("uniacid");
        $radius = 6378.135;
        $city = input("currentCity");
        $store['list'] = Db::table('ims_sudu8_page_store')->where('uniacid', $uniacid)->where('city', $city)->order('id desc')->select();
        // dump($store['list']);die;
        // var_dump($store);exit;
        $store['num'] = Db::table('ims_sudu8_page_store')->where('uniacid', $uniacid)->where('city', $city)->order('id desc')->count();
        foreach ($store['list'] as $key => &$res) {
            if (stristr($res['logo'], 'http')) {
                $res['logo'] = $res['logo'];
            } else {
                $res['logo'] = remote($uniacid, $res['logo'], 1);
            }
            $rad = doubleval(M_PI / 180.0);
            $lat1 = doubleval(input('lat')) * $rad;
            $lon1 = doubleval(input('lon')) * $rad;
            $lat2 = doubleval($res['lat']) * $rad;
            $lon2 = doubleval($res['lon']) * $rad;
            $theta = $lon2 - $lon1;
            $dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));
            if ($dist < 0) {
                $dist += M_PI;
            }
            $dist = $dist * $radius;
            $formatted = round($dist, 2);
            $res['kms'] = $formatted;
        }
        $arry = $store['list'];
        for ($i = 0; $i < count($arry); $i++) {
            for ($j = $i + 1; $j < count($arry); $j++) {
                if ($arry[$i]['kms'] > $arry[$j]['kms']) {
                    $new = $arry[$i];
                    $arry[$i] = $arry[$j];
                    $arry[$j] = $new;
                }
            }
        }
        $store['list'] = $arry;
        $result['data'] = $store['list'];
        return json_encode($result);
    }
    public function doPageProductsearch()
    {
        $uniacid = input("uniacid");
        $title = "%" . input("title") . "%";
        $flag = 1;
        $product = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where("flag", $flag)->where("title", 'like', $title)->field('id,title,thumb,type,`desc`,ctime,buy_type,price,sale_num,sale_tnum,hits,is_more')->order("id desc")->select();
        foreach ($product as &$row) {
            if ($row['is_more'] == 1) {
                $row['type'] = "showPro_lv";
            }
            if ($row['is_more'] == 3) {
                $row['sale_num'] = $row['sale_tnum'];
            }
            $row['thumb'] = remote($uniacid, $row['thumb'], 1);
            $row['ctime'] = date("Y-m-d", $row['ctime']);
        }
        $adata['data'] = $product;
        return json_encode($adata);
    }
    //餐饮开始
    public function doPageDingtype()
    {
        $uniacid = input("uniacid");
        $types = Db::table('ims_sudu8_page_food_cate')->where("uniacid", $uniacid)->order("id desc,num desc")->select();
        $adata['data'] = $types;
        return json_encode($adata);
    }
    public function doPageDingcai()
    {
        $uniacid = input("uniacid");
        $cates = Db::query("SELECT a.cid,b.title,b.num FROM ims_sudu8_page_food as a LEFT JOIN ims_sudu8_page_food_cate as b on a.cid = b.id WHERE a.uniacid = ? GROUP BY a.cid ORDER BY b.num desc", [$uniacid]);
        foreach ($cates as $key => &$rec) {
            $pro = Db::query("SELECT *,a.id as oid,a.title AS otitle FROM ims_sudu8_page_food as a LEFT JOIN ims_sudu8_page_food_cate as b on a.cid = b.id WHERE a.uniacid = ? and a.cid = ? ORDER BY b.num,b.id desc", [$uniacid, $rec['cid']]);
            $arr = $this->gaichang($pro);
            $rec['id'] = $rec['cid'];
            $rec['categoryName'] = $rec['title'];
            $rec['goodsList'] = $arr;
            $rec['val'] = $arr;
        }
        $adata['data'] = $cates;
        return json_encode($adata);
    }
    function gaichang($pro)
    {
        if ($pro) {
            foreach ($pro as $key => &$res) {
                $res['id'] = $res['oid'];
                $res['title'] = $res['otitle'];
                $res['text'] = unserialize($res['text']);
                $labels = unserialize($res['labels']);
                $lab = $this->clabels($labels);
                $res['labels'] = $lab;
                if (count($res['labels']) == 0) {
                    $res['labels'] = "";
                }
                $uniacid = input("uniacid");
                $res['thumb'] = remote($uniacid, $res['thumb'], 1);
                if ($res['descimg']) {
                    $res['descimg'] = remote($uniacid, $res['descimg'], 1);
                } else {
                    $res['descimg'] = remote($uniacid, $res['thumb'], 1);
                }
                if (empty($res['desccon'])) {
                    $res['desccon'] = $res['otitle'];
                }
            }
        }
        return $pro;
    }
    function clabels($labels)
    {
        $arr = array();
        if ($labels) {
            foreach ($labels as $key => &$res) {
                $k1 = $res[0];
                $k2 = $res[1];
                if ($k2) {
                    $karr = explode("&", $k2);
                }
                $arr[$key]['title'] = $k1;
                $arr[$key]['val'] = $karr;
            }
            return $arr;
        } else {
            return $arr;
        }
    }
    function doPageOrderpaymoney()
    {
        $uniacid = input("uniacid");
        $allprice = input("price");
        $now = time();
        $order_id = $order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
        $app = Db::table('applet')->where('id', $uniacid)->find();
        include 'WeixinPay.php';
        $appid = $app['appID'];
        $openid = input('openid');
        $mch_id = $app['mchid'];
        $key = $app['signkey'];
        $out_trade_no = $order_id; //订单号
        $body = "商品支付";
        $total_fee = input('price') * 100;
        if (isset($app['identity'])) {
            $identity = $app['identity'];
        } else {
            $identity = 1;
        }
        if (isset($app['sub_mchid'])) {
            $sub_mchid = $app['sub_mchid'];
        } else {
            $sub_mchid = 0;
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee, $identity, $sub_mchid);
        $return = $weixinpay->pay();
        $return['order_id'] = $order_id;
        $adata['data'] = $return;
        $adata['message'] = "success";
        return json_encode($adata);
    }
    function doPageZhifdingd()
    {
        $uniacid = input("uniacid");
        $gwc = input("gwc");
        $order_id = input("order_id");
        $openid = input("openid");
        $my_pay_money = input("money_mypay");
        $allprice = input("price");
        $score = input("jifen_score");
        $zh = input('zh');
        $gwc = stripslashes(html_entity_decode($gwc));
        $gwc = json_decode($gwc, TRUE);
        $newgwc = serialize($gwc);
        $xinxi = input("xinxi");
        $xinxi = stripslashes(html_entity_decode($xinxi));
        $xinxi = json_decode($xinxi, TRUE);
        $data['username'] = $xinxi['username'];
        $data['usertel'] = $xinxi['usertel'];
        $data['address'] = $xinxi['address'];
        $data['usertime'] = $xinxi['userdate'] . " " . $xinxi['usertime'];
        $data['userbeiz'] = $xinxi['userbeiz'];
        //获得用户信息
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        $money_u = $user['money'];
        $score_u = $user['score'];
        $kdata['money'] = $money_u - $my_pay_money;
        $kdata['score'] = $score_u - $score;
        $data['order_id'] = $order_id;
        $data['uniacid'] = $uniacid;
        $data['uid'] = $user['id'];
        $data['openid'] = $openid;
        $data['val'] = $newgwc;
        $data['price'] = $allprice;
        $data['creattime'] = time();
        $data['flag'] = 1;
        $data['zh'] = input("zh");
        Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update($kdata);
        Db::table('ims_sudu8_page_food_order')->insert($data);
        $applet = Db::table('applet')->where("id", $uniacid)->field('appID,appSecret')->find();
        $score_name = Db::table('ims_sudu8_page_food_sj')->where("uniacid", $uniacid)->field('names')->find();
        if ($applet) {
            $mid = Db::table('ims_sudu8_page_message')->where("uniacid", $uniacid)->where('flag', 4)->find();
            if ($mid) {
                if ($mid['mid'] != "") {
                    $mids = $mid['mid'];
                    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $applet['appID'] . "&secret=" . $applet['appSecret'];
                    $a_token = $this->_requestGetcurl($url);
                    if ($a_token) {
                        $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $a_token['access_token'];
                        $formId = input('formId');
                        $fscore_name = $score_name['names'];
                        if ($data['zh'] == "0") {
                            $fzh = "打包/拼桌";
                        } else {
                            $fzh = $data['zh'];
                        }
                        $forder_id = $order_id;
                        $fcontent = "";
                        foreach ($gwc as $k => $v) {
                            $foodinfo = $v['title'] . ',数量' . $v['num'] . ',价格' . $v['price'] . '元;';
                            $fcontent .= $foodinfo;
                        }
                        $fpaymoney = $allprice;
                        $ftime = date('Y-m-d H:i:s', time());
                        $furl = $mid['url'];
                        $post_info = '{
                              "touser": "' . $openid . '",  
                              "template_id": "' . $mids . '", 
                              "page": "' . $furl . '",          
                              "form_id": "' . $formId . '",         
                              "data": {
                                  "keyword1": {
                                      "value": "' . $fscore_name . '", 
                                      "color": "#173177"
                                  }, 
                                  "keyword2": {
                                      "value": "' . $fzh . '", 
                                      "color": "#173177"
                                  }, 
                                  "keyword3": {
                                      "value": "' . $forder_id . '", 
                                      "color": "#173177"
                                  } , 
                                  "keyword4": {
                                      "value": "' . $fcontent . '", 
                                      "color": "#173177"
                                  }, 
                                  "keyword5": {
                                      "value": "' . $fpaymoney . '元", 
                                      "color": "#173177"
                                  }, 
                                  "keyword6": {
                                      "value": "' . $ftime . '", 
                                      "color": "#173177"
                                  }  
                              },
                              "emphasis_keyword": "" 
                            }';
                        $this->_requestPost($url_m, $post_info);
                        $datea['price'] = $fpaymoney;
                        $result['data'] = $datea;
                        return $this->result(0, 'success', $datea);
                    }
                }
            }
        }
        $printer = Db::table('ims_sudu8_page_food_printer')->where("uniacid", $uniacid)->find();
        if ($printer) {
            if ($printer['status'] == 1) {
                $content = '';
                $content .= '下单时间：' . date('Y-m-d H:i:s', time()) . '\r\n';
                $content .= '订单号：' . $order_id . '\r\n';
                $content .= '餐厅名称：' . $printer['title'] . '\r\n';                      //打印内容
                if ($data['zh'] != "0") {
                    $content .= '<center>' . $data['zh'] . '</center>\r\n';
                } else {
                    $content .= '<center>打包/外卖</center>\r\n';
                }
                $content .= '<table>';
                $content .= '<tr><td>商品</td><td>数量</td><td>价格</td></tr>';
                foreach ($gwc as $k => $v) {
                    $content .= '<tr><td>' . $v['title'] . '</td><td>x' . $v['num'] . '</td><td>' . $v['price'] . '</td></tr>';
                }
                $content .= '</table>\r\n\r\n';
                $content .= '<FS>金额: ' . $data['price'] . '元</FS>\r\n\r\n';
                if ($data['username'] != "") {
                    $content .= '姓名：' . $data['username'] . '\r\n';
                }
                if ($data['usertel'] != "") {
                    $content .= '电话：' . $data['usertel'] . '\r\n';
                }
                if ($data['address'] != "") {
                    $content .= '地址：' . $data['address'] . '\r\n';
                }
                if ($xinxi['userdate'] != "" || $xinxi['usertime'] != "") {
                    $content .= '预约配送时间：' . $data['usertime'] . '\r\n';
                }
                if ($data['userbeiz'] != "") {
                    $content .= '备注：' . $data['userbeiz'];
                }
                include("Print.php");
                $print = new Yprint();
                $apiKey = $printer['apikey'];
                $msign = $printer['nkey'];
                //打印
                $print->action_print($printer['uid'], $printer['nid'], $content, $apiKey, $msign);
            }
        }
    }
    //得到桌号
    public function doPageGetzh()
    {
        $uniacid = input("uniacid");
        $zid = input('zid');
        $zhinfo = Db::table('ims_sudu8_page_food_tables')->where("uniacid", $uniacid)->where("id", $zid)->find();
        $zh = Db::table('ims_sudu8_page_food_tables')->where("uniacid", $uniacid)->ORDER("id desc")->select();
        $keys = 0;
        foreach ($zh as $key => &$res) {
            if ($zid == $res['id']) {
                $keys = $key + 1;
            }
        }
        $adata['zh'] = $zhinfo;
        $adata['keys'] = $keys;
        $result['data'] = $adata;
        return json_encode($result);
    }
    //选择桌号
    public function doPageZhchange()
    {
        $uniacid = input("uniacid");
        $zh = Db::table('ims_sudu8_page_food_tables')->where("uniacid", $uniacid)->select();
        $zhs = ['打包/拼桌'];
        foreach ($zh as $k => $v) {
            $zho = $v['title'] . "-" . $v['tnum'] . "号桌";
            array_push($zhs, $zho);
        }
        $zh['zhs'] = $zhs;
        $result['data'] = $zh;
        return json_encode($result);
    }
    function doPageMycai()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $orders = Db::table('ims_sudu8_page_food_order')->where("uniacid", $uniacid)->where("openid", $openid)->order("creattime desc")->select();
        foreach ($orders as &$res) {
            $res['creattime'] = date("Y-m-d H:i:s", $res['creattime']);
            $res['val'] = $this->chuli(unserialize($res['val']));
        }
        $adata['data'] = $orders;
        return json_encode($adata);
    }
    function chuli($arr)
    {
        $uniacid = input("uniacid");
        if ($arr) {
            foreach ($arr as $key => &$res) {
                $products = Db::table('ims_sudu8_page_food')->where("uniacid", $uniacid)->where("id", $res['id'])->find();
                $res['thumb'] = remote($uniacid, $products['thumb'], 1);
            }
            return $arr;
        }
    }
    function doPageShangjbs()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $shangjbase = Db::table('ims_sudu8_page_food_sj')->where("uniacid", $uniacid)->find();
        // dump($shangjbase);die;
        // var_dump($shangjbase);exit;
        //处理积分规则
        //获得用户金钱
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        $money = $user['money'];
        $score = $user['score'];
        // 积分兑换金额
        $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where("uniacid", $uniacid)->find();
        if (!$jf_gz) {
            $jf_gz['score'] = 10000;
            $jf_gz['money'] = 1;
        }
        $jf_money = intval($score / $jf_gz['score']) * $jf_gz['money'];            //1.我的积分可以换取多少钱
        $jf_pro = intval($shangjbase['score'] / $jf_gz['score']) * $jf_gz['money'];    //2.订单最高抵扣换取多少钱
        $dikou_jf = 0;
        if ($jf_pro >= $jf_money) {   //商品设置的最大可使用积分 >= 我自己的积分
            $dikou_jf = $jf_money;
        } else {                        //商品设置的最大可使用积分 < 我自己的积分
            $dikou_jf = $jf_pro;
        }
        // 积分金钱转积分数
        $jf_score = ($dikou_jf / $jf_gz['money']) * $jf_gz['score'];
        $shangjbase['user_money'] = $money;
        $shangjbase['dk_money'] = $dikou_jf;   //抵扣的金钱
        $shangjbase['dk_score'] = $jf_score;   //抵扣的积分
        $shangjbase['jf_gz'] = $jf_gz; //积分规则
        if ($shangjbase['thumb']) {
            $shangjbase['thumb'] = remote($uniacid, $shangjbase['thumb'], 1);
        }
        $adata['data'] = $shangjbase;
        return json_encode($adata);
    }
    // 分享获得积分
    public function dopagesharejf()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $id = input('id');
        $types = input('types');
        $numflag = 0;  //分享次数
        $typeflag = 0; //分享类型
        // 获取个人信息
        $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        $userjf = $userinfo['score'];
        // 获取分享规则
        $pro = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where("id", $id)->field('share_gz,share_type,share_score,share_num')->find();
        $gz = $pro['share_gz'];
        if ($gz == 1) {  //公用规则
            $gzinfo = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field('sharetype,sharejf,sharexz')->find();
            $share_type = $gzinfo['sharetype'];
            $share_score = $gzinfo['sharejf'];
            $share_num = $gzinfo['sharexz'];
            // 判断今天还能不能获得积分
            $begintime = date("Y-m-d", time()) . " 00:00:00";
            $endtime = date("Y-m-d", time()) . " 23:59:59";
            $btime = strtotime($begintime);
            $etime = strtotime($endtime);
            $count = Db::table('ims_sudu8_page_share_user')->where("uniacid", $uniacid)->where("uid", $userinfo['id'])->where("pid", $id)->where("creattime", '>=', $btime)->where("creattime", '<=', $etime)->count();
            $n = $count;
            if ($n >= $share_num) {
                $numflag = 0;
            } else {
                $numflag = 1;
            }
            // 判断你的分享对象
            if ($share_type == 3) {  //个人+群
                $typeflag = 1;
            } else {
                if ($types == $share_type) {
                    $typeflag = 1;
                }
            }
            $newscore = $userjf + $share_score;
            $kdata = array(
                'uniacid' => $uniacid,
                'uid' => $userinfo['id'],
                'pid' => $id,
                'creattime' => time()
            );
            if ($numflag == 1 && $typeflag == 1) {  //符合增加积分的规则
                $data['score'] = $newscore;
                $shareData['score'] = $share_score;
                $shareData['notice'] = 0;
                $res = Db::table('ims_sudu8_page_user')->where("openid", $openid)->update($data);
                Db::table('ims_sudu8_page_share_user')->insert($kdata);
                // 分享获得积分
                $xfscore = array(
                    "uniacid" => $uniacid,
                    "orderid" => "",
                    "uid" => $userinfo['id'],
                    "type" => "add",
                    "score" => $share_score,
                    "message" => "分享获得积分",
                    "creattime" => time()
                );
                if ($share_score > 0) {
                    Db::table('ims_sudu8_page_score')->insert($xfscore);
                }
            } else {
                $shareData['score'] = "0";
                $shareData['notice'] = 1;
                Db::table('ims_sudu8_page_share_user')->insert($kdata);
            }
        } else { //私有规则
            $share_type = $pro['share_type'];
            $share_score = $pro['share_score'];
            $share_num = $pro['share_num'];
            // 判断今天还能不能获得积分
            $begintime = date("Y-m-d", time()) . " 00:00:00";
            $endtime = date("Y-m-d", time()) . " 23:59:59";
            $btime = strtotime($begintime);
            $etime = strtotime($endtime);
            $count = Db::table('ims_sudu8_page_share_user')->where("uniacid", $uniacid)->where("uid", $userinfo['id'])->where("pid", $id)->where("creattime", '>=', $btime)->where("creattime", '<=', $etime)->count();
            $n = $count;
            if ($n >= $share_num) {
                $numflag = 0;
            } else {
                $numflag = 1;
            }
            // 判断你的分享对象
            if ($share_type == 3) {  //个人+群
                $typeflag = 1;
            } else {
                if ($types == $share_type) {
                    $typeflag = 1;
                }
            }
            $newscore = $userjf + $share_score;
            $kdata = array(
                'uniacid' => $uniacid,
                'uid' => $userinfo['id'],
                'pid' => $id,
                'creattime' => time()
            );
            if ($numflag == 1 && $typeflag == 1) {  //符合增加积分的规则
                $data['score'] = $newscore;
                $shareData['score'] = $share_score;
                $shareData['notice'] = 0;
                $res = Db::table('ims_sudu8_page_user')->where("openid", $openid)->update($data);
                Db::table('ims_sudu8_page_share_user')->insert($kdata);
                // 分享获得积分
                $xfscore = array(
                    "uniacid" => $uniacid,
                    "orderid" => "",
                    "uid" => $userinfo['id'],
                    "type" => "add",
                    "score" => $share_score,
                    "message" => "分享获得积分",
                    "creattime" => time()
                );
                if ($share_score > 0) {
                    Db::table('ims_sudu8_page_score')->insert($xfscore);
                }
            } else {
                $shareData['score'] = "0";
                $shareData['notice'] = 1;
                Db::table('ims_sudu8_page_share_user')->insert($kdata);
            }
        }
        $result['data'] = $shareData;
        return json_encode($result);
    }
    public function doPageFormval()
    {
        $uniacid = input("uniacid");
        $cid = input('id');
        $pagedata = input('pagedata');
        $types = input('types');
        $datas = stripslashes(html_entity_decode(input('datas')));
        $datas = json_decode($datas, TRUE);
        // 新增自定义表单数据接收
        $forms = '';
        if (input('pagedata') && input('pagedata') !== "NULL") {
            $forms = stripslashes(html_entity_decode(input('pagedata')));
            $forms = json_decode($forms, TRUE);
        }
        if($forms != "NULL"){
        foreach ($forms as $key1 => &$res) {
            if ($res['type'] == 14) {
                $strtime = strtotime($res['days']);
                $arrs = array(
                    "uniacid" => $uniacid,
                    "cid" => $cid,
                    "types" => $types,
                    "datys" => $strtime,
                    "pagedatekey" => $res['indexkey'],
                    "arrkey" => $res['xuanx'],
                    "creattime" => time()
                );
                Db::table('ims_sudu8_page_form_dd')->insert($arrs);
            }
        }
        $data = array(
            "uniacid" => $uniacid,
            "cid" => $cid,
            "creattime" => time(),
            "val" => serialize($forms),
            "flag" => 0
        );
        $res = Db::table('ims_sudu8_page_formcon')->insert($data);
        if ($res) {
            $form = Db::table('ims_sudu8_page_formcon')->where('uniacid', $uniacid)->order("id desc")->field("id")->find();
            $form['con'] = "提交成功";
            $result['data'] = $form;
            return json_encode($result);
        }
    }else{
         $form['con'] = "提交成功";
            $result['data'] = $form;
            return json_encode($result);
    }
    }
    public function doPageBalance()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $money = input('money');
        $now = time();
        $order_id = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
        $app = Db::table('applet')->where('id', $uniacid)->find();
        include 'WeixinPay.php';
        $appid = $app['appID'];
        $openid = $openid;
        $mch_id = $app['mchid'];
        $key = $app['signkey'];
        $out_trade_no = $order_id; //订单号
        $body = "账户充值";
        $total_fee = $money * 100;
        if (isset($app['identity'])) {
            $identity = $app['identity'];
        } else {
            $identity = 1;
        }
        if (isset($app['sub_mchid'])) {
            $sub_mchid = $app['sub_mchid'];
        } else {
            $sub_mchid = 0;
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee, $identity, $sub_mchid);
        $return = $weixinpay->pay();
        $return['order_id'] = $order_id;
        $adata['data'] = $return;
        $adata['message'] = "success";
        return json_encode($adata);
    }
    public function doPagePay_cz()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $money = input('money');
        $order_id = input("order_id");
        // 1.根据openid 取uid 和剩余 money
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        $uid = $user['id'];
        $my_money = $user['money'];
        $my_score = $user['score'];
        $new_money = ($my_money * 1000 + $money * 1000) / 1000;
        $new_score = $my_score;
        // 预留接口
        $guize = Db::table('ims_sudu8_page_recharge')->where("uniacid", $uniacid)->order("money asc")->select();
        if ($guize) {   //有充值规则时
            $key = count($guize) - 1;
            $zsmoney = 0;
            if ($key == 0) {
                if ($money * 1000 >= $guize[0]['money'] * 1000) {
                    $new_money = ($new_money * 1000 + $guize[0]['getmoney'] * 1000) / 1000;
                    $new_score = ($new_score * 1000 + $guize[0]['getscore'] * 1000) / 1000;
                    $zsmoney = $guize[0]['getmoney'];
                } else {
                    $new_money = $new_money + 0;
                    $new_score = $new_score + 0;
                    $zsmoney = 0;
                }
            } else {
                $new_money1 = 0;
                $new_score1 = 0;
                for ($i = 0; $i < count($guize) - 1; $i++) {
                    if ($money * 1000 >= $guize[$i]['money'] * 1000 && $money * 1000 < $guize[$i + 1]['money'] * 1000 && $i + 1 <= count($guize)) {
                        $new_money1 = ($new_money * 1000 + $guize[$i]['getmoney'] * 1000) / 1000;
                        $new_score1 = ($new_score * 1000 + $guize[$i]['getscore'] * 1000) / 1000;
                        $zsmoney +=  $guize[$i]['getmoney'];
                    }
                }
                if ($new_money1 > 0) {
                    $new_money = $new_money1;
                    $new_score = $new_score1;
                }

                
            }
            $zsdata['uniacid'] = $uniacid;
            $zsdata['orderid'] = "";
            $zsdata['uid'] = $uid;
            $zsdata['type'] = "add";
            $zsdata['score'] = $zsmoney;
            $zsdata['message'] = "充值送金钱";
            $zsdata['creattime'] = time();
            Db::table('ims_sudu8_page_money')->insert($zsdata);
            // if($money<$guize[0]['money']){
            //  $new_money = $new_money + 0;
            //  $new_score = $new_score + 0;
            // }
            // if($money>=$guize[$key]['money']){
            //  $new_money = ($new_money * 1000 + $guize[$key]['getmoney'] *1000)/1000;
            //  $new_score = ($new_score * 1000 + $guize[$key]['getscore'] *1000)/1000;
            // }
            


        } else {        //没有充值规则
            $new_money = $new_money + 0;
            $new_score = $new_score + 0;
        }
        $data['money'] = $new_money;
        $data['score'] = $new_score;
        $res = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update($data);
        // 充值成功后生成流水
        $gghmoney = $new_money * 1 - $my_money * 1; //增加规格后的money
        $jdata['uniacid'] = $uniacid;
        $jdata['orderid'] = "";
        $jdata['uid'] = $uid;
        $jdata['type'] = "add";
        $jdata['score'] = $money;
        $jdata['message'] = "充值";
        $jdata['creattime'] = time();
        if($gghmoney>0){
         Db::table('ims_sudu8_page_money')->insert($jdata);
        }
        // 充值成功后生成积分流水
        $gghscore = $new_score * 1 - $my_score * 1;
        $sdata['uniacid'] = $uniacid;
        $sdata['orderid'] = "";
        $sdata['uid'] = $uid;
        $sdata['type'] = "add";
        $sdata['score'] = $gghscore;
        $sdata['message'] = "充值送积分";
        $sdata['creattime'] = time();
        if ($gghscore > 0) {
            Db::table('ims_sudu8_page_score')->insert($sdata);
        }
    }
    public function doPageMymoney()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->field("id,money,score,vipid,uniacid,openid")->find();
        $coupon = Db::table('ims_sudu8_page_coupon_user')->where("uniacid", $uniacid)->where("uid", $user['id'])->where("flag", 0)->select();
        $time = time();
        foreach ($coupon as $key => &$res) {
            $arrs = Db::table('ims_sudu8_page_coupon')->where("uniacid", $uniacid)->where("id", $res['cid'])->find();
            if ($arrs['etime'] != 0) {
                if ($time > $arrs['etime'] && $res['flag'] == 0) {
                    $kdata = array(
                        "flag" => 2
                    );
                    Db::table('ims_sudu8_page_coupon_user')->where("id", $res['id'])->update($kdata);
                }
            }
        }
        $user['couponNum'] = Db::table('ims_sudu8_page_coupon_user')->where("uniacid", $uniacid)->where("uid", $user['id'])->where("flag", 'neq', 2)->count();
        unset($user['id']);
        //查询会员卡申请情况
        $vipflag = Db::table('ims_sudu8_page_vip_apply')->where("uniacid", $uniacid)->where("openid", $openid)->order("id desc")->find();
        $user['vipflag'] = $vipflag['flag'];
        //查询会员卡信息
        $vipcard = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find();
        $user['vipset'] = $vipcard['isopen'];
        $user['cardname'] = $vipcard['name'] == "" ? '会员卡' : $vipcard['name'];
        $user['userbg'] = ROOT_HOST . "/image/ubg.png";
        $adata['data'] = $user;
        return json_encode($adata);
    }
    //新版个人中心功能列表请求接口
    public function doPageupdatausersetnew()
    {
        $uniacid = input("uniacid");
        $items = Db::table('ims_sudu8_page_usercenter_set')->where("uniacid", $uniacid)->find();
        $usercenterset = unserialize($items['usercenterset']);
        // 先组装成选择显示的数据
        $arrs = array();
        $myorder = false;
        $mysign = false;
        for ($i = 1; $i <= 13; $i++) {
            if ($usercenterset['flag' . $i] == 2 && $usercenterset['num' . $i] != 5) {
                if (isset($usercenterset['icon' . $i])) {
                    $jdata = array(
                        "title" => $usercenterset['title' . $i],
                        "thumb" => remote($uniacid, $usercenterset['thumb' . $i], 1),
                        "num" => $usercenterset['num' . $i],
                        "url" => $usercenterset['url' . $i],
                        "icon" => $usercenterset['icon' . $i]
                    );
                } else {
                    $jdata = array(
                        "title" => $usercenterset['title' . $i],
                        "thumb" => remote($uniacid, $usercenterset['thumb' . $i], 1),
                        "num" => $usercenterset['num' . $i],
                        "url" => $usercenterset['url' . $i]
                    );
                }
                array_push($arrs, $jdata);
            }
            if ($usercenterset['flag' . $i] == 2 && $usercenterset['num' . $i] == 5) {
                $myorder = true;
            }
            if ($usercenterset['flag' . $i] == 2 && $usercenterset['num' . $i] == 2) {
                $mysign = true;
            }
        }
        // 对数据进行排序
        $counts = count($arrs);
        $temps = "";
        for ($i = 0; $i < $counts - 1; $i++) {
            for ($j = 0; $j < $counts - 1 - $i; $j++) {
                if ($arrs[$j + 1]['num'] > $arrs[$j]['num']) {
                    $temps = $arrs[$j];
                    $arrs[$j] = $arrs[$j + 1];
                    $arrs[$j + 1] = $temps;
                }
            }
        }
        foreach ($arrs as $key1 => &$reb) {
            $reb['thumb'] = remote($uniacid, $reb['thumb'], 1);
        }
        $adata = array();
        $adata['data']['arrs'] = $arrs;
        $adata['data']['myorder'] = $myorder;
        $adata['data']['mysign'] = $mysign;
        return json_encode($adata);
    }
    public function dopageShoppay_duo()
    {   //店内支付
        $uniacid = input("uniacid");
        $openid = input('openid');
        $ordermoeny = input('ordermoeny');  //订单的总价格
        $yuemoney = input('yuemoney');      //用余额支付的钱
        $money = input('money');            //用微信支付的钱
        $order_id = input('order_id');
        $jfscore = input('jfscore');  //积分抵扣的积分
        $yhq_id = input('yhq_id');  //优惠券id
        $now = time();
        if (empty($order_id)) {
            $order_id = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
        }
        //获得用户信息
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        $money_u = $user['money'];
        $score_u = $user['score'];
        $kdata = array();
        $kdata['money'] = $money_u - $yuemoney;  //用的钱
        $kdata['score'] = $score_u - $jfscore;    //用的积分
        if ($kdata['money'] != 0 || $kdata['score'] != 0) {
            Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update($kdata);
        }
        //生成订单
        $ddata['uniacid'] = $uniacid;
        $ddata['orderid'] = $order_id;
        $ddata['uid'] = $user['id'];
        $ddata['type'] = "del";
        $ddata['creattime'] = time();
        if ($yuemoney > 0) {
            $ddata['score'] = $yuemoney;
            $ddata['message'] = "消费扣金钱";
            Db::table('ims_sudu8_page_money')->insert($ddata);
        }
        if ($money > 0) {
            $ddata['score'] = $money;
            $ddata['message'] = "微信支付";
            Db::table('ims_sudu8_page_money')->insert($ddata);
        }
        if ($jfscore > 0) {
            $ddata['score'] = $jfscore;
            $ddata['message'] = "消费扣积分";
            Db::table('ims_sudu8_page_score')->insert($ddata);
        }
        if ($yhq_id > 0) {
            Db::table('ims_sudu8_page_coupon_user')->where('id', $yhq_id)->update(array("utime" => time(), "flag" => 1));
        }
    }
    public function doPageGuiz()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $guize['list'] = Db::table('ims_sudu8_page_recharge')->where("uniacid", $uniacid)->order("money asc")->select();
        $guize['conf'] = Db::table('ims_sudu8_page_rechargeconf')->where("uniacid", $uniacid)->find();
        $guize['user'] = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->field('money,score,uniacid,openid')->find();
        $guize['coupon'] = Db::table('ims_sudu8_page_user')->alias("a")->join("ims_sudu8_page_coupon_user b", "a.id = b.uid")->join("ims_sudu8_page_coupon c", "b.cid = c.id")->where("a.uniacid", $uniacid)->where("a.openid", $openid)->where("b.flag", 0)->field('c.*,b.id as ids')->select();
        $adata['data'] = $guize;
        return json_encode($adata);
    }
    public function doPageZjkk()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $now = time();
        $order_id = $order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
        $gwc = input("gwc");
        $order_id = $order_id;
        $my_pay_money = input("money_mypay");
        $allprice = input("price");
        $score = input("jifen_score");
        $zh = input('zh');
        $gwc = stripslashes(html_entity_decode($gwc));
        $gwc = json_decode($gwc, TRUE);
        $newgwc = serialize($gwc);
        $xinxi = input("xinxi");
        $xinxi = stripslashes(html_entity_decode($xinxi));
        $xinxi = json_decode($xinxi, TRUE);
        $data['username'] = $xinxi['username']; //姓名
        $data['usertel'] = $xinxi['usertel'];    //电话
        $data['address'] = $xinxi['address'];    //地址
        $data['usertime'] = $xinxi['userdate'] . " " . $xinxi['usertime'];  //预定时间
        $data['userbeiz'] = $xinxi['userbeiz'];    //备注
        //获得用户信息
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->field('id,money,score,uniacid,openid')->find();
        $money_u = $user['money'];
        $score_u = $user['score'];
        $kdata['money'] = $money_u - $my_pay_money;
        $kdata['score'] = $score_u - $score;
        $data['order_id'] = $order_id;
        $data['uniacid'] = $uniacid;
        $data['uid'] = $user['id'];
        $data['openid'] = $openid;
        $data['val'] = $newgwc;
        $data['price'] = $allprice;
        $data['creattime'] = time();
        $data['flag'] = 1;
        $data['zh'] = $zh;
        Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update($kdata);
        Db::table('ims_sudu8_page_food_order')->insert($data);
        $applet = Db::table('applet')->where("id", $uniacid)->field('appID,appSecret')->find();
        $score_name = Db::table('ims_sudu8_page_food_sj')->where("uniacid", $uniacid)->field('names')->find();
        if ($applet) {
            $mid = Db::table('ims_sudu8_page_message')->where("uniacid", $uniacid)->where('flag', 4)->find();
            if ($mid) {
                if ($mid['mid'] != "") {
                    $mids = $mid['mid'];
                    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $applet['appID'] . "&secret=" . $applet['appSecret'];
                    $a_token = $this->_requestGetcurl($url);
                    if ($a_token) {
                        $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $a_token['access_token'];
                        $formId = input('formId');
                        $fscore_name = $score_name['names'];
                        if ($data['zh'] == "0") {
                            $fzh = "打包/拼桌";
                        } else {
                            $fzh = $data['zh'];
                        }
                        $forder_id = $order_id;
                        $fcontent = "";
                        foreach ($gwc as $k => $v) {
                            $foodinfo = $v['title'] . ',数量' . $v['num'] . ',价格' . $v['price'] . '元;';
                            $fcontent .= $foodinfo;
                        }
                        $fpaymoney = $allprice;
                        $ftime = date('Y-m-d H:i:s', time());
                        $furl = $mid['url'];
                        $post_info = '{
                              "touser": "' . $openid . '",  
                              "template_id": "' . $mids . '", 
                              "page": "' . $furl . '",          
                              "form_id": "' . $formId . '",         
                              "data": {
                                  "keyword1": {
                                      "value": "' . $fscore_name . '", 
                                      "color": "#173177"
                                  }, 
                                  "keyword2": {
                                      "value": "' . $fzh . '", 
                                      "color": "#173177"
                                  }, 
                                  "keyword3": {
                                      "value": "' . $forder_id . '", 
                                      "color": "#173177"
                                  } , 
                                  "keyword4": {
                                      "value": "' . $fcontent . '", 
                                      "color": "#173177"
                                  }, 
                                  "keyword5": {
                                      "value": "' . $fpaymoney . '元", 
                                      "color": "#173177"
                                  }, 
                                  "keyword6": {
                                      "value": "' . $ftime . '", 
                                      "color": "#173177"
                                  }  
                              },
                              "emphasis_keyword": "" 
                            }';
                        $this->_requestPost($url_m, $post_info);
                    }
                }
            }
        }
        $printer = Db::table('ims_sudu8_page_food_printer')->where("uniacid", $uniacid)->find();
        if ($printer) {
            if ($printer['status'] == 1) {
                $content = '';
                $content .= '下单时间：' . date('Y-m-d H:i:s', time()) . '\r\n';
                $content .= '订单号：' . $order_id . '\r\n';
                $content .= '餐厅名称：' . $printer['title'] . '\r\n';
                if ($data['zh'] != "0") {
                    $content .= '<center>' . $data['zh'] . '</center>\r\n';
                } else {
                    $content .= '<center>打包/外卖</center>\r\n';
                }
                $content .= '<table>';
                $content .= '<tr><td>商品</td><td>数量</td><td>价格</td></tr>';
                foreach ($gwc as $k => $v) {
                    $content .= '<tr><td>' . $v['title'] . '</td><td>x' . $v['num'] . '</td><td>' . $v['price'] . '</td></tr>';
                }
                $content .= '</table>\r\n\r\n';
                $content .= '<FS>金额: ' . $data['price'] . '元</FS>\r\n\r\n';
                if ($data['username'] != "") {
                    $content .= '姓名：' . $data['username'] . '\r\n';
                }
                if ($data['usertel'] != "") {
                    $content .= '电话：' . $data['usertel'] . '\r\n';
                }
                if ($data['address'] != "") {
                    $content .= '地址：' . $data['address'] . '\r\n';
                }
                if ($xinxi['userdate'] != "" || $xinxi['usertime'] != "") {
                    $content .= '预约配送时间：' . $data['usertime'] . '\r\n';
                }
                if ($data['userbeiz'] != "") {
                    $content .= '备注：' . $data['userbeiz'];
                }
                include("Print.php");
                $print = new Yprint();
                $apiKey = $printer['apikey'];
                $msign = $printer['nkey'];
                //打印
                $print->action_print($printer['uid'], $printer['nid'], $content, $apiKey, $msign);
            }
        }
        return json_encode(array('data' => $order_id));
    }
    //不带报头的curl
    public function _requestPost($url, $data, $ssl = true)
    {
        //curl完成
        $curl = curl_init();
        //设置curl选项
        curl_setopt($curl, CURLOPT_URL, $url);//URL
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
        //SSL相关
        if ($ssl) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。
        }
        // 处理post相关选项
        curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据
        // 处理响应结果
        curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果
        // 发出请求
        $response = curl_exec($curl);
        if (false === $response) {
            echo '<br>', curl_error($curl), '<br>';
            return false;
        }
        curl_close($curl);
        return $response;
    }
    public function _requestGetcurl($url)
    {
        //curl完成
        $curl = curl_init();
        //设置curl选项
        $header = array(
            "authorization: Basic YS1sNjI5dmwtZ3Nocmt1eGI2Njp1TlQhQVFnISlWNlkySkBxWlQ=",
            "content-type: application/json",
            "cache-control: no-cache",
            "postman-token: cd81259b-e5f8-d64b-a408-1270184387ca"
        );
        curl_setopt($curl, CURLOPT_HEADER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);//URL
        curl_setopt($curl, CURLOPT_HEADER, 0);             // 0：不返回头信息
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        // 发出请求
        $response = curl_exec($curl);
        if (false === $response) {
            echo '<br>', curl_error($curl), '<br>';
            return false;
        }
        curl_close($curl);
        $forms = stripslashes(html_entity_decode($response));
        $forms = json_decode($forms, TRUE);
        return $forms;
    }
    //月统计数据统计
    public function dopageMysign()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $year = input('year') ? input('year') : date("Y", time());  //获取年
        $month = input('month') ? input('month') : date("m", time()); //当前月
        $days = date("t", strtotime($year . "-" . $month . "-1")); //当前月的天数
        // 拼接日期
        $rbeing = $year . "-" . $month . "-1" . " 00:00:00";
        $rend = $year . "-" . $month . "-" . $days . " 23:59:59";
        // 转换日期
        $begintime = strtotime($rbeing);
        $endtime = strtotime($rend);
        $alls = Db::table('ims_sudu8_page_sign')->where("uniacid", $uniacid)->where("openid", $openid)->where('creattime', '>=', $begintime)->where('creattime', '<=', $endtime)->select();
        // 进行当月数据重组
        $choiceday = array();
        foreach ($alls as $key => &$res) {
            $choiceday[] = date("d", $res['creattime']);
        }
        //构造当月的数组
        $dayarr = array();
        $nowarr = array();
        for ($i = 1; $i <= $days; $i++) {
            $nowarr['day'] = $i;
            if (in_array($i, $choiceday)) {
                $nowarr['choosed'] = true;
            } else {
                $nowarr['choosed'] = false;
            }
            $dayarr[] = $nowarr;
        }
        $result['data'] = $dayarr;
        return json_encode($result);
    }
    //签到统计
    public function dopageMysignjl()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $alls = Db::table('ims_sudu8_page_sign')->where("uniacid", $uniacid)->where("openid", $openid)->order('creattime desc')->limit(0, 5)->select();
        foreach ($alls as $key => &$res) {
            $res['creattime'] = date("Y-m-d", $res['creattime']);
        }
        $result['data'] = $alls;
        return json_encode($result);
    }
    //签到操作
    public function dopageQiandao()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $dateriqi = time();
        //签到规则
        $guize = Db::table('ims_sudu8_page_sign_con')->where("uniacid", $uniacid)->find();
        $sj = explode("/", $guize['score']);
        // var_dump($sj);exit;
        $smval = $sj[0];
        $upval = $sj[1];
        $score = rand($smval, $upval);
        // 拼接日期
        $datas = date("Y-m-d", $dateriqi);
        $rbeing = $datas . " 00:00:00";
        $rend = $datas . " 23:59:59";
        // 转换日期
        $begintime = strtotime($rbeing);
        $endtime = strtotime($rend);
        // 判断今天有没有签到
        $res = Db::table('ims_sudu8_page_sign')->where("uniacid", $uniacid)->where("openid", $openid)->where('creattime', '>=', $begintime)->where('creattime', '<=', $endtime)->find();
        // var_dump($res);exit;
        if ($res) {
            $data['flag'] = 1;
            return json_encode(array("data"=>1));
        } else {
            //查询个人积分情况
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
            $user_score = $user['score'];
            if ($guize['max_score'] > $user_score) {   //总积分大于个人积分
                $jiascor = $user_score + $score;
                if ($jiascor >= $guize['max_score']) {  //新签到的积分+个人积分  大于了总积分
                    $score = $guize['max_score'] - $user_score;
                } else {
                    $score = $score;
                }
            } else {
                $score = 0;
            }
            $udata['score'] = $user_score + $score;
            Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update($udata);
            $data['uniacid'] = $uniacid;
            $data['openid'] = $openid;
            $data['creattime'] = time();
            $data['score'] = $score;
            Db::table('ims_sudu8_page_sign')->insert($data);
            if ($score != 0) {
                // 2.支付积分流水
                $xfscore = array(
                    "uniacid" => $uniacid,
                    "orderid" => "",
                    "uid" => $user['id'],
                    "type" => "add",
                    "score" => $score,
                    "message" => "签到增加积分",
                    "creattime" => time()
                );
                if ($score > 0) {
                    Db::table('ims_sudu8_page_score')->insert($xfscore);
                }
            }
            $cleiji = Db::table('ims_sudu8_page_sign')->where("uniacid", $uniacid)->where("openid", $openid)->count();
            //获得昨天签到的数据
            $yesterday = date("Y-m-d", strtotime("-1 day"));
            // 拼接日期
            $ybeing = $yesterday . " 00:00:00";
            $yend = $yesterday . " 23:59:59";
            // 转换日期
            $ybegintime = strtotime($ybeing);
            $yendtime = strtotime($yend);
            $yres = Db::table('ims_sudu8_page_sign')->where("uniacid", $uniacid)->where("openid", $openid)->where('creattime', '>=', $ybegintime)->where('creattime', '<=', $yendtime)->find();
            //获取连续统计签到
            $lxqd = Db::table('ims_sudu8_page_sign_lx')->where("uniacid", $uniacid)->where("openid", $openid)->find();
            //如果是新的签到
            if (!$lxqd) {
                $ldata['uniacid'] = $uniacid;
                $ldata['openid'] = $openid;
                $ldata['count'] = 0;
                $ldata['max_count'] = 0;
                Db::table('ims_sudu8_page_sign_lx')->insert($ldata);
            }
            $newlxqd = Db::table('ims_sudu8_page_sign_lx')->where("uniacid", $uniacid)->where("openid", $openid)->find();
            //判断昨天有没有签到数据
            if ($yres) {
                $newcount = $newlxqd['count'] + 1;
                $maxcount = $newlxqd['max_count'];
                $lx['count'] = $newcount;
                if ($newcount > $maxcount) {
                    $lx['max_count'] = $newcount;
                } else {
                    $lx['max_count'] = $maxcount;
                }
                $lx['all_count'] = $cleiji;
                Db::table('ims_sudu8_page_sign_lx')->where("uniacid", $uniacid)->where("openid", $openid)->update($lx);
            } else {
                $lx['count'] = 1;
                $lx['all_count'] = $cleiji;
                Db::table('ims_sudu8_page_sign_lx')->where("uniacid", $uniacid)->where("openid", $openid)->update($lx);
            }
            $data['flag'] = 0;
            return json_encode(array("data"=>0));
        }
    }
    //统计的综合数据
    public function dopageMysigntj()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $lxqd = Db::table('ims_sudu8_page_sign_lx')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        $arr = Db::table('ims_sudu8_page_sign_lx')->where("uniacid", $uniacid)->order('all_count desc')->order('id desc')->select();
        if ($lxqd) {
            $data['lianq'] = $lxqd['count'];
            $data['maxlianq'] = $lxqd['max_count'];
            $data['all_count'] = $lxqd['all_count'];
            $paix = 0;
            foreach ($arr as $key => &$res) {
                if ($res['openid'] == $lxqd['openid']) {
                    $paix = $key + 1;
                    break;
                }
            }
            $data['paix'] = $paix;
        } else {
            $data['lianq'] = 0;
            $data['maxlianq'] = 0;
            $data['all_count'] = 0;
            $data['paix'] = 0;
        }
        $data['qdbg'] = ROOT_HOST . "/image/bg/qdbg.png";
        $data['score'] = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        //排序
        $result['data'] = $data;
        return json_encode($result);
    }
    //排行榜
    public function dopagePaihb()
    {
        $uniacid = input("uniacid");
        $arr = Db::table('ims_sudu8_page_sign_lx')->where("uniacid", $uniacid)->order('all_count desc')->order('id desc')->limit(0, 7)->select();
        foreach ($arr as $key => &$res) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $res['openid'])->find();
            $res['avatar'] = $user['avatar'];
            $res['nickname'] = $user['nickname'];
        }
        $result['data'] = $arr;
        return json_encode($result);
    }
    //最新签到
    public function dopageZxqd()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $arr = Db::table('ims_sudu8_page_sign')->where("uniacid", $uniacid)->order('creattime desc')->limit(0, 9)->select();
        foreach ($arr as $key => &$res) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $res['openid'])->find();
            $res['avatar'] = $user['avatar'];
            $res['nickname'] = $user['nickname'];
            $res['creattime'] = date("Y-m-d h:m:s", $res['creattime']);
        }
        $result['data'] = $arr;
        return json_encode($result);
    }
    // 积分商城列表
    public function dopageScorepro()
    {
        $uniacid = input("uniacid");
        $pindex = max(1, intval(input('page')));
        $psize = 8;
        $cid = input("cid");
        if ($cid == 0) {
            $products = Db::table('ims_sudu8_page_score_shop')->where("uniacid", $uniacid)->where('flag', 1)->order('id desc')->limit(($pindex - 1) * $psize, $psize)->select();
        } else {
            $products = Db::table('ims_sudu8_page_score_shop')->where("uniacid", $uniacid)->where('cid', $cid)->where('flag', 1)->order('id desc')->limit(($pindex - 1) * $psize, $psize)->select();
        }
        foreach ($products as $key => &$value) {
            $value['thumb'] = remote($uniacid, $value['thumb'], 1);
        }
        $result['data'] = $products;
        return json_encode($result);
    }
    //积分商城的分类
    public function dopageScorecate()
    {
        $uniacid = input("uniacid");
        $cate = Db::table('ims_sudu8_page_score_cate')->where("uniacid", $uniacid)->order('id desc')->select();
        $cate_first = array("catepic" => "", "id" => "0", "name" => "全部", "num" => "99999", "uniacid" => $uniacid);
        array_unshift($cate, $cate_first);
        $result['data'] = $cate;
        return json_encode($result);
    }
    // 积分商城详情
    public function dopageScoreinfo()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        if ($id) {
            $products = Db::table('ims_sudu8_page_score_shop')->where("uniacid", $uniacid)->where('id', $id)->where('flag', 1)->find();
            $products['thumb'] = remote($uniacid, $products['thumb'], 1);
            $products['slide'] = unserialize($products['text']);
            if ($products['slide']) {
                foreach ($products['slide'] as $key => &$res) {
                    $res = remote($uniacid, $res, 1);
                }
            }
            if ($products['labels']) {
                $labels = explode(",", $products['labels']);
                $products['labels'] = $labels;
            } else {
                $products['labels'] = array();
            }
        } else {
            $products = "";
        }
        $result['data'] = $products;
        return json_encode($result);
    }
    // 积分商城下单
    public function dopageScoreorder()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        $openid = input("openid");
        $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        $data = array();
        $products = Db::table('ims_sudu8_page_score_shop')->where("uniacid", $uniacid)->where('id', $id)->where('flag', 1)->find();
        // 检测积分够不够
        if ($userinfo['score'] < $products['price']) {
            $data['flag'] = 0;
            $data['msg'] = "不好意思，您的积分不够！";
            $result['data'] = $data;
            return json_encode($result);
            die();
        }
        if ($products['pro_kc'] > 0 || $products['pro_kc'] == -1) {
            $now = time();
            $order_id = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
            // 1.处理下单录入操作
            $kdata = array(
                "uniacid" => $uniacid,
                "order_id" => $order_id,
                "uid" => (int)$userinfo['id'],
                "openid" => $openid,
                "pid" => (int)$id,
                "thumb" => remote($uniacid, $products['thumb'], 1),
                "product" => $products['title'],
                "price" => $products['price'],
                "num" => 1,
                "creattime" => time(),
                "flag" => 0
            );
            $res = Db::table('ims_sudu8_page_score_order')->insert($kdata);
            // 2.处理个人扣积分操作
            $myscore = $userinfo['score'];
            $newscore = $myscore - $products['price'];
            $udata = array(
                "score" => $newscore
            );
            Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->update($udata);
            $kdatas['uniacid'] = $uniacid;
            $kdatas['orderid'] = $order_id;
            $kdatas['uid'] = $userinfo['id'];
            $kdatas['type'] = "del";
            $kdatas['score'] = $products['price'];
            $kdatas['message'] = "积分商品兑换";
            $kdatas['creattime'] = time();
            if ($products['price'] > 0) {
                Db::table('ims_sudu8_page_score')->insert($kdatas);
            }
            // 3.处理商品库存和卖出总数
            $kc = $products['pro_kc'];
            if ($kc < 0) {
                $newkc = -1;
            } else {
                $newkc = $kc - 1;
            }
            $snum = $products['sale_num'];
            $newsnum = $snum + 1;
            $pdata = array(
                "pro_kc" => $newkc,
                "sale_num" => $newsnum
            );
            Db::table('ims_sudu8_page_score_shop')->where("uniacid", $uniacid)->where('id', $id)->update($pdata);
            $data['flag'] = 1;
            $data['msg'] = "积分兑换成功！";
            $applet = Db::table('applet')->where("id", $uniacid)->field('appID,appSecret')->find();
            if ($applet) {
                $mid = Db::table('ims_sudu8_page_message')->where("uniacid", $uniacid)->where('flag', 5)->find();
                if ($mid) {
                    if ($mid['mid'] != "") {
                        $mids = $mid['mid'];
                        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $applet['appID'] . "&secret=" . $applet['appSecret'];
                        $a_token = $this->_requestGetcurl($url);
                        if ($a_token) {
                            $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $a_token['access_token'];
                            $formId = input('formId');
                            $ftitle = $products['title'];
                            $fprice = $products['price'];
                            $ftime = date('Y-m-d H:i:s', time());
                            $fscore = $newscore;
                            $openid = input('openid');
                            $furl = $mid['url'];
                            $post_info = '{
                                      "touser": "' . $openid . '",  
                                      "template_id": "' . $mids . '", 
                                      "page": "' . $furl . '",          
                                      "form_id": "' . $formId . '",         
                                      "data": {
                                          "keyword1": {
                                              "value": "' . $ftitle . '", 
                                              "color": "#173177"
                                          }, 
                                          "keyword2": {
                                              "value": "' . $fprice . '", 
                                              "color": "#173177"
                                          }, 
                                          "keyword3": {
                                              "value": "' . $ftime . '", 
                                              "color": "#173177"
                                          }, 
                                          "keyword4": {
                                              "value": "' . $fscore . '", 
                                              "color": "#173177"
                                          } 
                                      },
                                      "emphasis_keyword": "keyword1.DATA" 
                                    }';
                            $data = $this->_requestPost($url_m, $post_info);
                        }
                    }
                }
            }
        } else {
            $data['flag'] = 0;
            $data['msg'] = "不好意思，您来晚了,商品已兑换完了！";
        }
        $result['data'] = $data;
        return json_encode($result);
    }
    // 我的积分订单
    public function dopagemyscoreorder()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $OrdersList = Db::table('ims_sudu8_page_score_order')->where("uniacid", $uniacid)->where('openid', $openid)->order('creattime desc')->select();
        foreach ($OrdersList as $key => &$rec) {
            $rec['creattime'] = date("Y-m-d H:i:s", $rec['creattime']);
        }
        $result['data'] = $OrdersList;
        return json_encode($result);
    }
    // 多规格订单详情
    public function dopageduoorderinfo()
    {
        $uniacid = input("uniacid");
        $orderid = input("orderid");
        $orders = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where('order_id', $orderid)->find();
        $orders['jsondata'] = unserialize($orders['jsondata']);
        foreach ($orders['jsondata'] as $key => &$vi) {
            if (isset($vi['baseinfo'])) {
                $vi['baseinfo']['thumb'] = remote($uniacid, $vi['baseinfo']['thumb'], 1);
            }
        }
        if($orders['address']){
            $orders['address_info'] = Db::table('ims_sudu8_page_duo_products_address') ->where('id', $orders['address'])->find();
        }
        //获取满减设置
        $orders['moneyoff'] = Db::table('ims_sudu8_page_moneyoff')->where("uniacid", $uniacid)->select();
        $result['data'] = $orders;
        return json_encode($result);
    }
    public function dopageptorderinfo()
    {
        $uniacid = input("uniacid");
        $orderid = input("orderid");
        $openid = input('openid');
        $orders = Db::table('ims_sudu8_page_pt_order')->where("uniacid", $uniacid)->where('openid',$openid)->where('order_id', $orderid)->find();
        $pt_pro['jsondata'] = unserialize($orders['jsondata']);
        foreach($pt_pro['jsondata'] as $kk => &$vv){
            $proinfo['ggz'] = $vv['proval_ggz'];
            $proinfo['price'] = $vv['proval_price'];
            $proinfo['dprice'] = $vv['proval_dprice'];
            $p_id = $vv['proinfo'];
            $pro_val=Db::table("ims_sudu8_page_pt_pro_val")->where("id",$p_id)->find();
//            $pro_val = pdo_fetch("select * from ".tablename("sudu8_page_pt_pro_val")." where id = :id",array(':id' => $p_id));
            $proinfo['thumb'] = $pro_val['thumb'];
            $vv['proinfo'] = $proinfo;
            $vv['gmorpt'] = $orders['types'];
            $pro_belong=Db::table("ims_sudu8_page_pt_pro")->where("id",$vv['pvid'])->find();
//            $pro_belong = pdo_fetch("select * from ".tablename("sudu8_page_pt_pro")." where id = :pid",array(':pid' => $vv['pvid']));
            $baseinfo2['title'] = $pro_belong['title'];
            $vv['baseinfo2'] = $baseinfo2;
        }
        return json_encode($pt_pro);
    }
    // 分销商中心
    public function dopagefxszhongx()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $sq = Db::table('ims_sudu8_page_fx_sq')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        $arr['sq'] = $sq;
        $arr['user'] = $user;
        $arr['order_counts'] = 0;
        $arr['team_counts'] = 0;
        $arr['tx_counts'] = 0;
        $arr['zuidi'] = 0;
        //我的团队数据
        $team_counts = count(Db::query("SELECT * FROM ims_sudu8_page_user WHERE uniacid=" . $uniacid . " and (parent_id = '" . $openid . "' or p_parent_id = '" . $openid . "' or p_p_parent_id = '" . $openid . "')"));
        $arr['team_counts'] = $team_counts;
        // 分销订单
        $order_counts = count(Db::query("SELECT * FROM  ims_sudu8_page_fx_ls WHERE uniacid=" . $uniacid . " and (parent_id = '" . $openid . "' or p_parent_id = '" . $openid . "' or p_p_parent_id = '" . $openid . "')"));
        $arr['order_counts'] = $order_counts;
        // 提现申请
        $tx_counts = Db::table('ims_sudu8_page_fx_tx')->where("uniacid", $uniacid)->where('openid', $openid)->count();
        $arr['tx_counts'] = $tx_counts;
        // 最低提现规则
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->find();
        $arr['zuidi'] = $guiz['txmoney'];
        $arr['guiz'] = $guiz;
        $result['data'] = $arr;
        return json_encode($result);
    }
    // 我要提现申请
    public function dopagewytixian()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->find();
        $data['userinfo'] = $userinfo;
        $data['guiz'] = $guiz;
        $result['data'] = $data;
        return json_encode($result);
    }
    // 分销商提现了
    public function dopagefxstixian()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $money = input("money");
        $data = array(
            "uniacid" => $uniacid,
            "openid" => $openid,
            "money" => $money,
            "types" => input('xuanz'),
            "zfbzh" => input('zfbzh'),
            "zfbxm" => input('zfbxm'),
            "creattime" => time()
        );
        Db::table('ims_sudu8_page_fx_tx')->insert($data);
        // 申请提现的同时减去提现的数据
        $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        $fx_money = $userinfo['fx_money'];
        $new_fx_money = $fx_money * 1 - $money * 1;
        Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->update(array('fx_money' => $new_fx_money));
    }
    // 分销商提现记录
    public function dopagefxstxjl()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $val = input("val");
        if ($val == 1) {
            $txjl = Db::table('ims_sudu8_page_fx_tx')->where("uniacid", $uniacid)->where('openid', $openid)->order('id desc')->select();
        } else {
            $flag = $val - 1;
            $txjl = Db::table('ims_sudu8_page_fx_tx')->where("uniacid", $uniacid)->where('openid', $openid)->where('flag', $flag)->order('id desc')->select();
        }
        foreach ($txjl as $key => &$res) {
            $res['creattime'] = date("Y-m-d H:i:s", $res['creattime']);
        }
        return json_encode($txjl);
    }
    // 分销订单
    public function dopagefxdingd()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $types = input("types");
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->find();
        if ($types != 1) {
            $nty = $types - 1;
            $orders = Db::table('ims_sudu8_page_fx_ls')->where("uniacid", $uniacid)->where('flag', $nty)->where('parent_id', $openid)->whereOr('p_parent_id', $openid)->whereOr('p_p_parent_id', $openid)->order('id desc')->select();
        } else {
            $orders = Db::table('ims_sudu8_page_fx_ls')->where("uniacid", $uniacid)->where('parent_id', $openid)->whereOr('p_parent_id', $openid)->whereOr('p_p_parent_id', $openid)->order('id desc')->select();
        }
        if ($orders) {
            foreach ($orders as $key => &$res) {
                $v = 0;
                $bili = 0;
                // 根据订单号去订单里面去jsondata
                $orderinfo = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where('order_id', $res['order_id'])->find();
                $jsdata = unserialize($orderinfo['jsondata']);
                $one_bili = $jsdata[0]['one_bili'];
                $two_bili = $jsdata[0]['two_bili'];
                $three_bili = $jsdata[0]['three_bili'];
                if ($res['parent_id'] == $openid) {
                    $v = 1;
                    $bili = $one_bili;
                }
                if ($res['p_parent_id'] == $openid) {
                    $v = 2;
                    $bili = $two_bili;
                }
                if ($res['p_p_parent_id'] == $openid) {
                    $v = 3;
                    $bili = $three_bili;
                }
                $order = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where('order_id', $res['order_id'])->find();
                $res['datas'] = unserialize($order['jsondata']);
                foreach ($res['datas'] as $key => &$reb) {
                    $mm = $reb['num'] * $reb['proinfo']['price'] * $bili / 100;
                    $reb['kmoney'] = $mm;
                }
                $res['creattime'] = date("Y-m-d H:i", $res['creattime']);
                $res['v'] = $v;
            }
            $result['data'] = $orders;
            return json_encode($orders);
        }
    }
    // 分销订单数据统计
    public function dopagefxcount()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $orders1 = count(Db::query("SELECT * FROM ims_sudu8_page_fx_ls WHERE uniacid=" . $uniacid . " and flag = 1 and (parent_id = '" . $openid . "' or p_parent_id = '" . $openid . "' or p_p_parent_id = '" . $openid . "')"));
        $orders2 = count(Db::query("SELECT * FROM ims_sudu8_page_fx_ls WHERE uniacid=" . $uniacid . " and flag = 2 and (parent_id = '" . $openid . "' or p_parent_id = '" . $openid . "' or p_p_parent_id = '" . $openid . "')"));
        $orders3 = count(Db::query("SELECT * FROM ims_sudu8_page_fx_ls WHERE uniacid=" . $uniacid . " and flag = 3 and (parent_id = '" . $openid . "' or p_parent_id = '" . $openid . "' or p_p_parent_id = '" . $openid . "')"));
        $data = array(
            "onecount" => $orders1,
            "twocount" => $orders2,
            "threecount" => $orders3,
        );
        $result['data'] = $data;
        return json_encode($result);
    }
    // 我的账户
    public function dopagegetmzh()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        // 申请提现中的钱
        $ord = Db::table('ims_sudu8_page_fx_tx')->where("uniacid", $uniacid)->where('flag', 1)->select();
        $wfmoney = 0;
        foreach ($ord as $key => &$res) {
            $wfmoney += $res['money'] * 1;
        }
        $data['userinfo'] = $userinfo;
        $data['wfmoney'] = $wfmoney;
        $result['data'] = $data;
        return json_encode($result);
        // return $this->result(0, 'success', $data);
    }
    // 我的团队
    public function dopagemyteam()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $types = input("types") ? input("types") : 1;
        // 去获取开启了几级目录
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->find();
        if ($types == 1) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('parent_id', $openid)->select();
        }
        if ($types == 2) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('p_parent_id', $openid)->select();
        }
        if ($types == 3) {
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('p_p_parent_id', $openid)->select();
        }
        foreach ($user as $key => &$res) {
            $counts = count(Db::query("SELECT * FROM ims_sudu8_page_user WHERE uniacid=" . $uniacid . " and (parent_id = '" . $res['openid'] . "' or p_parent_id = '" . $res['openid'] . "' or p_p_parent_id = '" . $res['openid'] . "')"));
            $res['zjcount'] = $counts;
            $res['createtime'] = date("Y-m-d H:i:s", $res['createtime']);
        }
        $data['user'] = $user;
        $data['cj'] = $guiz['fx_cj'];
        $result['data'] = $data;
        return json_encode($result);
    }
    // 申请成为分销商基本新
    public function doPagesqcwfxsbase()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $gz = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->find();
        $sq = Db::table('ims_sudu8_page_fx_sq')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        $parent_id = $user['parent_id'];
        if ($parent_id == '0' || !$user) {
            $fxs = "总店";
        } else {
            $fxsinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $parent_id)->find();
            $fxs = $fxsinfo['nickname'];
        }
        $data['gz'] = $gz;
        $data['sq'] = $sq;
        $data['userinfo'] = $user;
        $data['fxs'] = $fxs;
        $res['data'] = $data;
        return json_encode($res);
    }
    // 申请成为分销商
    public function dopagesqcwfxs()
    {
        $uniacid = input("uniacid");
        $truename = input("truename");
        $truetime = input("truetime");
        $truetel = input("truetel");
        $openid = input("openid");
        $sq = Db::table('ims_sudu8_page_fx_sq')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->find();
        @include($truetime);
        if ($guiz['fxs_sz'] == 1) {
            $data = array(
                "openid" => $openid,
                "uniacid" => $uniacid,
                "truename" => $truename,
                "truetel" => $truetel,
                "creattime" => time(),
                "flag" => 2
            );
            Db::table('ims_sudu8_page_fx_sq')->insert($data);
            Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->update(array("fxs" => 2));
            $flag = -1;
        } else {
            $flag = 0;
            if ($sq) {
                if ($sq['flag'] == 1 || $sq['flag'] == 2) {
                    $flag = $sq['flag'];
                } else {
                    $flag = 4;
                }
            } else {
                $flag = 4;
            }
            if ($flag == 4) {
                $data = array(
                    "openid" => $openid,
                    "uniacid" => $uniacid,
                    "truename" => $truename,
                    "truetel" => $truetel,
                    "creattime" => time()
                );
                Db::table('ims_sudu8_page_fx_sq')->insert($data);
            }
        }
        $result['data'] = $flag;
        return json_encode($result);
    }
    //多规格购物车开始
    //多规格数据
    public function dopageduoproducts()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        $openid = input("openid");



        $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        $products = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where('id', $id)->find();
        $hits = $products['hits'] + 1;
        Db::table("ims_sudu8_page_products")->where("uniacid", $uniacid)->where('id', $id)->update(array('hits' => $hits));
        $products = Db::table('ims_sudu8_page_products')->where("uniacid", $uniacid)->where('id', $id)->find();
        // 检查该商品有没有收藏过
        $shouc = Db::table('ims_sudu8_page_collect')->where("uniacid", $uniacid)->where('uid', $userinfo['id'])->where('cid', $id)->where('type', "showProMore")->find();
        if ($shouc) {
            $shouc = 2;
        } else {
            $shouc = 1;
        }
        // if($products['types']==2){
        $products['mark_price'] = $products['market_price'];
        $products['texts'] = $products['product_txt'];
        $products['xsl'] = 0;
        $proarr = Db::table('ims_sudu8_page_duo_products_type_value')->where("pid", $id)->order("id asc")->select();
        // 处理库存量
        $kcl = 0;
        foreach ($proarr as $key => &$res) {
            $kcl += $res['kc'];
            $products['xsl'] = $products['xsl'] + $res['vsalenum']+$res['salenum'];
        }
        $products['kc'] = $kcl;
        $imgarr = unserialize($products['text']);
        foreach ($imgarr as $key => &$value) {
            $value = remote($uniacid, $value, 1);
        }
        $products['imgtext'] = $imgarr;
        $types = $proarr[0]['comment'];
        //构建规格组
        $typesarr = explode(",", $types);
        // 构建规格组json
        $typesjson = [];
        foreach ($typesarr as $key => &$rec) {
            $str = "type" . ($key + 1);
            $ziji = Db::table('ims_sudu8_page_duo_products_type_value')->where("pid", $id)->order("id asc")->field($str)->select();
            $xarr = array();
            foreach ($ziji as $key => $res) {
                array_push($xarr, $res[$str]);
            }
            $cdata["val"] = array_unique($xarr);
            $cdata['ck'] = 0;
            $typesjson[$rec] = $cdata;
        }
        $adata['grouparr'] = $typesarr;
        $adata['grouparr_val'] = $typesjson;
        // }
        $products['explains'] = explode(",", $products['labels']);
        if ($products['explains'][0] == "") {
            $products['explains'] = "";
        }
        $products['shareimg'] = remote($uniacid, $products['shareimg'], 1);
        $products['thumb'] = remote($uniacid, $products['thumb'], 1);
        $adata['products'] = $products;
        // 分销商的关系[1.绑定上下级关系 ]
        //获取该小程序的分销关系绑定规则
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("fx_cj,sxj_gx,uniacid")->find();
        $fxsid = input('fxsid');
        if ($fxsid != 'undefined' && $fxsid != '0') {
            $fxsinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $fxsid)->find();
            // 1.先进行上下级关系绑定[判断是不是首次下单]
            if ($guiz['sxj_gx'] == 1 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] != 2 && $fxsinfo['fxs'] == 2) {
                $p_fxs = $fxsinfo['parent_id'];  //分销商的上级
                $p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
                // 判断启用几级分销
                $fx_cj = $guiz['fx_cj'];
                // 分别做判断
                if ($fx_cj == 1) {
                    $uuser = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update(array("parent_id" => $fxsid));
                }
                if ($fx_cj == 2) {
                    $uuser = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs));
                }
                if ($fx_cj == 3) {
                    $uuser = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs, "p_p_parent_id" => $p_p_fxs));
                }
            }
            $adata['guiz'] = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("one_bili,two_bili,three_bili,uniacid")->find();
        } else {
            $fx_cj = $guiz['fx_cj'];
            if ($fx_cj == 1) {
                $adata['guiz']['one_bili'] = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("one_bili")->find()['one_bili'];
                $adata['guiz']['two_bili'] = 0;
                $adata['guiz']['three_bili'] = 0;
            } else if ($fx_cj == 2) {
                $adata['guiz']['one_bili'] = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("one_bili")->find()['one_bili'];
                $adata['guiz']['two_bili'] = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("two_bili")->find()['two_bili'];
                $adata['guiz']['three_bili'] = 0;
            } else if ($fx_cj == 3) {
                $adata['guiz']['one_bili'] = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("one_bili")->find()['one_bili'];
                $adata['guiz']['two_bili'] = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("two_bili")->find()['two_bili'];
                $adata['guiz']['three_bili'] = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->field("three_bili")->find()['three_bili'];
            } else if ($fx_cj == 4) {
                $adata['guiz']['one_bili'] = 0;
                $adata['guiz']['two_bili'] = 0;
                $adata['guiz']['three_bili'] = 0;
            }
        }
        if (!$guiz) {
            $adata['guiz'] = array(
                "one_bili" => 0,
                "two_bili" => 0,
                "three_bili" => 0
            );
        }   
        $adata['vip_config'] = 0;
        if(empty($userinfo['vipid'])){

            if(!empty($products['vipconfig'])){
                $vipconfig = unserialize($products['vipconfig']);

                if($vipconfig['set1'] == 1){
                    $adata['vip_config'] = $vipconfig['set2'];
                }else{
                    $vip_config = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find();
                    if(!empty($vip_config)){
                        $adata['vip_config'] = $vip_config['duo'];
                    }
                }
            }else{
                $vip_config = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find();
                if(!empty($vip_config)){
                    $adata['vip_config'] = $vip_config['duo'];
                }
            }
        }
        $adata['shouc'] = $shouc;
        $result['data'] = $adata;
        return json_encode($result);
    }
    // 购物车数量统计
    public function doPagegwcdata()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        $uid = $userinfo['id'];
        $mygwc = Db::table('ims_sudu8_page_duo_products_gwc')->where("uid", $uid)->where("flag", 1)->select();
        $counts = 0;
        foreach ($mygwc as $key => &$res) {
            $counts += $res['num'];
        }
        $result['data'] = $counts;
        return json_encode($result);
    }
    //多规格数据自己规格
    public function dopageduoproductsinfo()
    {
        $uniacid = input("uniacid");
        $str = input('str');
        $arr = explode("######", $str);
        $id = input('id');
        $where = "";
        foreach ($arr as $key => &$res) {
            $vv = $key + 1;
            $where .= " and type" . $vv . " = " . "'" . $res . "'";
        }
        $proinfo = Db::query("SELECT * FROM ims_sudu8_page_duo_products_type_value WHERE pid= " . $id . $where);
        foreach ($proinfo as $key => &$value) {
            $value['thumb'] = remote($uniacid, $value['thumb'], 1);
            $value['salenum']=$value['salenum']+$value["vsalenum"];
        }
        $baseinfo = Db::table('ims_sudu8_page_products')->where("id", $proinfo[0]['pid'])->find();
        $baseinfo['thumb'] = remote($uniacid, $baseinfo['thumb'], 1);
        $baseinfo['shareimg'] = remote($uniacid, $baseinfo['shareimg'], 1);
        $adata['proinfo'] = $proinfo[0];
        $adata['baseinfo'] = $baseinfo;
        $result['data'] = $adata;
        return json_encode($result);
    }
    //加入购物车
    public function dopagegwcadd()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $id = input("id");
        $prokc = input("prokc");
        $userinfo = Db::table('ims_sudu8_page_user')->where("openid", $openid)->where('uniacid', $uniacid)->find();
        $proinfo = Db::table('ims_sudu8_page_duo_products_type_value')->where("id", $id)->find();
        $baseinfo = Db::table('ims_sudu8_page_products')->where("id", $proinfo['pid'])->find();
        //判断该商品是不是已经存在
        $gwcinfo = Db::table('ims_sudu8_page_duo_products_gwc')->where("uid", $userinfo['id'])->where('flag', 1)->where("pid", $id)->find();
        if ($gwcinfo) {
            $kc = $gwcinfo['num'];
            $newkc = $kc + $prokc;
            $data = array(
                "num" => $newkc,
                "creattime" => time()
            );
            $res = Db::table('ims_sudu8_page_duo_products_gwc')->where("id", $gwcinfo['id'])->update($data);
        } else {
            $data = array(
                "uniacid" => $uniacid,
                "uid" => $userinfo['id'],
                "pid" => $id,
                "pvid" => $proinfo['pid'],
                "num" => $prokc,
                "creattime" => time()
            );
            $res = Db::table('ims_sudu8_page_duo_products_gwc')->insert($data);
        }
        // 统计购物车里面的情况
        if ($res) {
            return json_encode(1);
        }
    }
    //获取我的购物车数据
    public function doPagegetmygwc()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $userinfo = Db::table('ims_sudu8_page_user')->where('openid', $openid)->where('uniacid', $uniacid)->find();
        $uid = $userinfo['id'];
        $mygwc = Db::table('ims_sudu8_page_duo_products_gwc')->alias("a")->join("ims_sudu8_page_products b", "a.pvid = b.id")->where('a.uid', $uid)->where('a.flag', 1)->where('b.id', 'gt', 0)->field("a.*")->select();
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where('uniacid', $uniacid)->find();
        foreach ($mygwc as $key => &$res) {
            $proinfo = Db::table('ims_sudu8_page_duo_products_type_value')->where('id', $res['pid'])->find();
            $baseinfo = Db::table('ims_sudu8_page_products')->where('id', $res['pvid'])->find();
            $bb = array(
                "cid" => $baseinfo['cid'],
                "id" => $baseinfo['id'],
                "title" => $baseinfo['title'],
                "thumb" => remote($uniacid, $baseinfo['thumb'], 1),
            );
            $gg = $proinfo['comment'];
            $ggarr = explode(",", $gg);
            $str = "";
            foreach ($ggarr as $index => $rec) {
                $i = $index + 1;
                $kk = "type" . $i;
                $str .= $rec . ":" . $proinfo[$kk] . ",";
            }
            $str = substr($str, 0, strlen($str) - 1);
            $proinfo['ggz'] = $str;
            $res['proinfo'] = $proinfo;
            $res['baseinfo'] = $bb;
            $res['ck'] = 0;
            $res['one_bili'] = $guiz['one_bili'];
            $res['two_bili'] = $guiz['two_bili'];
            $res['three_bili'] = $guiz['three_bili'];
        }
        $result['data'] = $mygwc;
        return json_encode($result);
    }
    //删除购物车数据
    public function doPagedelmygwc()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $id = input("id");
        Db::table('ims_sudu8_page_duo_products_gwc')->where('id', $id)->where('uniacid', $uniacid)->delete();
    }
    // 实时更新数据库数据
    public function doPageduogwcchange()
    {
        $uniacid = input("uniacid");
        $num = input("num");
        $id = input("id");
        $data = array(
            "num" => $num
        );
        Db::table('ims_sudu8_page_duo_products_gwc')->where('id', $id)->update($data);
    }
//组装拼团积分规则
    public function dopageptsetgwcscore(){
        $uniacid = input("uniacid");
        $openid = input("openid");
        $jsdata = input('jsdata');
        $jsdata = json_decode($jsdata, TRUE);
        $arr = array();
        $jifen = 0;
        foreach ($jsdata as $key => $res) {
            $num = $res['num'];
            $baseinfo=Db::table("ims_sudu8_page_pt_pro")->where('id',$res['pvid'])->find();
//            $baseinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro') ." WHERE id = :id", array(':id'=>$res['pvid']));
            $score = $baseinfo['score'];
            if($score){
                $jifen+= intval($score)*$num;
            }
        }
        //积分转换成金钱
//        $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
        $jf_gz=Db::table("ims_sudu8_page_rechargeconf")->where("uniacid",$uniacid)->find();
        if(!$jf_gz){
            $gzscore = 100;
            $gzmoney = 1;
        }else{
            $gzscore = intval($jf_gz['score']);
            $gzmoney = intval($jf_gz['money']);
        }
        // 我的积分抵用
//        $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
       $userinfo=Db::table("ims_sudu8_page_user")->where("openid",$openid)->where("uniacid",$uniacid)->find();
        $score = $userinfo['score'];
        //比较我的积分和扣除积分
        $data = array();
        if($jifen >= 0 && $score>=$jifen){
            $zhmoney = ($jifen * $gzmoney)/$gzscore;
            $moneycl = floor($zhmoney);
            $jf = $moneycl * $gzscore;
        }else{
            $zhmoney = ($score * $gzmoney)/$gzscore;
            $moneycl = floor($zhmoney);
            //消费掉的积分
            $jf = $moneycl * $gzscore;
        }
        $data["moneycl"] = $moneycl;
        $data["jf"] = $jf;
        $data["gzscore"] = $gzscore;
        $data["gzmoney"] = $gzmoney;
        return json_encode($data);
    }
    //组装积分规则
    public function dopagesetgwcscore()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $jsdata = input('jsdata');
        $jsdata = json_decode($jsdata, TRUE);
        $arr = array();
        $jifen = 0;
        foreach ($jsdata as $key => $res) {
            $num = $res['num'];
            $baseinfo = Db::table('ims_sudu8_page_products')->where('id', $res['pvid'])->find();
            $score = $baseinfo['score'];
            $jifen += $score * $num;
        }
        //积分转换成金钱
        $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid', $uniacid)->find();
        if (!$jf_gz) {
            $gzscore = 10000;
            $gzmoney = 1;
        } else {
            $gzscore = $jf_gz['score'];
            $gzmoney = $jf_gz['money'];
        }
        // 我的积分抵用
        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $score = $userinfo['score'];
        //比较我的积分和扣除积分
        $data = array();
        if ($score >= $jifen) {
            $zhmoney = ($jifen * $gzmoney) / $gzscore;
            $moneycl = floor($zhmoney);
            $jf = $moneycl * $gzscore;
        } else {
            $zhmoney = ($score * $gzmoney) / $gzscore;
            $moneycl = floor($zhmoney);
            //消费掉的积分
            $jf = $moneycl * $gzscore;
        }
        $data["moneycl"] = $moneycl;
        $data["jf"] = $jf;
        $data["gzscore"] = $gzscore;
        $data["gzmoney"] = $gzmoney;
        $result['data'] = $data;
        return json_encode($result);
    }
    // 获取默认地址
    public function dopagegetmraddress()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $address['data'] = Db::table('ims_sudu8_page_duo_products_address')->where('is_mo', 2)->where('openid', $openid)->find();
        return json_encode($address);
    }
    // 获取指定地址
    public function dopagegetmraddresszd()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $id = input("id");
        $address['data'] = Db::table('ims_sudu8_page_duo_products_address')->where('id', $id)->where('openid', $openid)->find();
        return json_encode($address);
    }
    //获取运费
    public function dopageyunfeiget()
    {
        $uniacid = input("uniacid");
        $yunfei = Db::table('ims_sudu8_page_duo_products_yunfei')->where('uniacid', $uniacid)->find();
        if (!$yunfei) {
            $yunfei = array(
                "yfei" => 0,
                "byou" => 0
            );
        } else {
            $formset = $yunfei['formset'];
            if ($formset != 0 && $formset != "") {
                $forms = Db::table('ims_sudu8_page_formlist')->where('id', $formset)->find();
                $forms2 = unserialize($forms['tp_text']);
                foreach ($forms2 as $key => &$res) {
                    if ($res['tp_text']) {
                        $res['tp_text'] = explode(",", $res['tp_text']);
                    }
                    $res['val'] = '';
                }
            } else {
                $forms2 = "NULL";
            }
            $yunfei['forms'] = $forms2;
        }
        $result['data'] = $yunfei;
        return json_encode($result);
    }
    //创建订单
    public function dopageduosetorder()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $couponid = input("couponid");
        $price = input("price");
        $dkscore = input("dkscore");
        $address = input("address");
        $mjly = input("mjly");
        $nav = input("nav");
        $formid = input('formid');
        $now = time();
        $order_id = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $uid = $userinfo['id'];
        $jsdata = html_entity_decode(input('jsdata'));
        $jsdatass = json_decode($jsdata, true);
        foreach ($jsdatass as $key12 => &$res) {
            $probaseinfo = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where('id', $res['baseinfo'])->field("id,title,thumb")->find();
            $proproinfo = Db::table('ims_sudu8_page_duo_products_type_value')->where('id', $res['proinfo'])->field("id,price,thumb,comment,type1,type2,type3,kc")->find();
            $newproinfo['id'] = $probaseinfo['id'];
            $newproinfo['title'] = $probaseinfo['title'];
            $newproinfo['thumb'] = remote($uniacid, $probaseinfo['thumb'], 1);
            $res['baseinfo'] = $newproinfo;
            $newproinfo['id'] = $proproinfo['id'];
            $newproinfo['price'] = $proproinfo['price'];
            $newproinfo['thumb'] = remote($uniacid, $proproinfo['thumb'], 1);
            $newproinfo['kc'] = $proproinfo['kc'];
            $gg = $proproinfo['comment'];
            $ggarr = explode(",", $gg);
            $str = "";
            foreach ($ggarr as $index => $rec) {
                $i = $index + 1;
                $kk = "type" . $i;
                $str .= $rec . ":" . $proproinfo[$kk] . ",";
            }
            $newproinfo['ggz'] = $str;
            $res['proinfo'] = $newproinfo;
        }
        // echo "<pre>";
        // var_dump($jsdatass);
        // echo "</pre>";
        // die();
        $data = array(
            "uniacid" => $uniacid,
            "uid" => $uid,
            "openid" => $openid,
            "order_id" => $order_id,
            "jsondata" => serialize($jsdatass),
            "coupon" => $couponid,
            "creattime" => time(),
            "price" => $price,
            "flag" => 0,
            "jf" => $dkscore,
            "address" => $address,
            "liuyan" => $mjly,
            "nav" => $nav,
            "formid" => intval($formid)
        );
        // var_dump($data);exit;
        // var_dump($data);exit;
//        var_dump($jsdatass);exit;
        Db::table('ims_sudu8_page_duo_products_order')->insert($data);
//        var_dump($data);exit;
        // 分销商的关系[1.绑定上下级关系 ]
        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        //获取该小程序的分销关系绑定规则
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where('uniacid', $uniacid)->find();
        $fxsid = input('fxsid');
        // 1.先进行上下级关系绑定[判断是不是首次下单]
        if ($guiz['sxj_gx'] == 2 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] != 2) {
            $fxsinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $fxsid)->find();
            $p_fxs = $fxsinfo['parent_id'];  //分销商的上级
            $p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
            // 判断启用几级分销
            $fx_cj = $guiz['fx_cj'];
            // 分别做判断
            if ($fx_cj == 1) {
                $uuser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("parent_id" => $fxsid));
            }
            if ($fx_cj == 2) {
                $uuser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs));
            }
            if ($fx_cj == 3) {
                $uuser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs, "p_p_parent_id" => $p_p_fxs));
            }
        }
        $result['data'] = $order_id;
//        return(json_encode($jsdata));
        return json_encode($result);
    }
    // 修改拼团多规格订单
    public function dopageptduoorderchangegg(){
//        global $_GPC, $_W;
        $uniacid = input('uniacid');
        $orderid = input('orderid');
        $couponid = input('couponid');
        $price = input('price');
        $dkscore = input('dkscore');
        $address = input('address');
        $mjly = input('mjly');
        $nav = input('nav');
        $gwc = input('gwc');
        $openid = input('openid');
        $pvid = input('pvid');
        $shareid = input('shareid');
        //查询是此用户否已有开团订单且未完成
        if($gwc == 1){
            $order_query=Db::table("ims_sudu8_page_pt_order")->where("openid",$openid)->where("flag",1)->where("ck",1)->where("uniacid",$uniacid)->select();
//            $order_query = pdo_fetchall("select jsondata,pt_order from ".tablename('sudu8_page_pt_order')." where openid = :openid and flag = 1 and ck = 1 and uniacid = :uniacid",array(':openid' => $openid,':uniacid' => $uniacid));
            foreach($order_query as $kk => $vv){
//                $share_order = pdo_fetch("select * from ".tablename('sudu8_page_pt_share')." where shareid = :shareid and uniacid = :uniacid",array(':shareid' => $vv['pt_order'],':uniacid' => $uniacid));
                $share_order=Db::table("ims_sudu8_page_pt_share")->where("shareid",$vv['pt_order'])->where("uniacid",$uniacid)->find();
                if($share_order['flag'] == 1 && $share_order['join_count'] < $share_order['pt_min']){
                    $or_json = unserialize($vv['jsondata']);
                    foreach($or_json as $k => $v){
                        if($v['pvid'] == $pvid){
                            $data = 5;
                            $result = $data;
                            return json_encode($result);
                            exit;
                        }
                    }
                }
            }
        }
        //未付款入口订单查询是否已参加此商品团购
        if($shareid != 0){
//            $order_check = pdo_fetchall("select * from ".tablename('sudu8_page_pt_order')." where pt_order = :shareid and openid = :openid and uniacid = :uniacid",array(':shareid' => $shareid,':openid' => $openid,':uniacid' => $uniacid));
            $order_check=Db::table("ims_sudu8_page_pt_order")->where("pt_order",$shareid)->where("openid",$openid)->where("uniacid",$uniacid)->select();
            foreach($order_check as $kk => $vv){
                if($vv['yue_price'] != 0 || $vv['wx_price'] != 0){
                    $data = 6;
                    $result = $data;
                    return json_encode($result);
                    exit;
                }
            }
        }
        $data = array(
            "coupon" => $couponid,
            "price" => $price,
            "jf" => $dkscore,
            "address" => $address,
            "liuyan" => $mjly,
            "nav"=>$nav
        );
//        pdo_update("sudu8_page_pt_order",$data,array("uniacid"=>$uniacid,"order_id"=>$orderid));
        Db::table('ims_sudu8_page_pt_order')->where('uniacid', $uniacid)->where('order_id', $orderid)->update($data);
    }
    // 修改多规格订单
    public function doPageduoorderchangegg()
    {
        $uniacid = input("uniacid");
        $orderid = input("orderid");
        $couponid = input("couponid");
        $price = input("price");
        $dkscore = input("dkscore");
        $address = input("address");
        $mjly = input("mjly");
        $nav = input("nav");
        $data = array(
            "coupon" => $couponid,
            "price" => $price,
            "jf" => $dkscore,
            "address" => $address,
            "liuyan" => $mjly,
            "nav" => $nav
        );
        Db::table('ims_sudu8_page_pt_order')->where('uniacid', $uniacid)->where('order_id', $orderid)->update($data);
    }
    //获取地址具体信息
    public function doPagegetaddressinfo()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $id = input("id");
        $address['data'] = Db::table('ims_sudu8_page_duo_products_address')->where('id', $id)->where('openid', $openid)->find();
        if ($address['data']) {
            if (strpos($address['data']['address'], ",") === false) {
                $address['data']['region'] = explode(" ", $address['data']['address']);
            } else {
                $address['data']['region'] = explode(",", $address['data']['address']);
            }
        }
        return json_encode($address);
    }
    //获取我的地址礼拜
    public function doPagegetmyaddress()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $myaddress = Db::table('ims_sudu8_page_duo_products_address')->where('openid', $openid)->select();
        $result['data'] = $myaddress;
        return json_encode($result);
    }
    //增加我的地址
    public function dopagesetmyaddress()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $name = input('name');
        $mobile = input('mobile');
        $address = input('address');
        $more_address = input('more_address');
        $postalcode = input('postalcode');
        $froms = input('froms');
        $data = array(
            "uniacid" => $uniacid,
            "openid" => $openid,
            "name" => $name,
            "mobile" => $mobile,
            "address" => $address,
            "more_address" => $more_address,
            "postalcode" => $postalcode,
            "creattime" => time()
        );
        if ($froms == "weixin") {
            $mywx = Db::table('ims_sudu8_page_duo_products_address')->where('openid', $openid)->where('froms', 'weixin')->find();
            if ($mywx) {
                Db::table('ims_sudu8_page_duo_products_address')->where('id', $mywx['id'])->update($data);
            } else {
                $data['froms'] = "weixin";
                Db::table('ims_sudu8_page_duo_products_address')->insert($data);
            }
        } else {
            $id = input('id');
            if ($id != 0 && $froms != "weixin") {
                Db::table('ims_sudu8_page_duo_products_address')->where('id', $id)->update($data);
            } else {
                $data['froms'] = "selfadd";
                Db::table('ims_sudu8_page_duo_products_address')->insert($data);
            }
        }
    }
    // 设置默认地址
    public function dopagesetmoaddress()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $id = input("id");
        $data = array(
            "is_mo" => 1
        );
        // 先更新掉其他默认值
        Db::table('ims_sudu8_page_duo_products_address')->where('openid', $openid)->update($data);
        $kdata = array(
            "is_mo" => 2
        );
        // 更新默认值
        Db::table('ims_sudu8_page_duo_products_address')->where('openid', $openid)->where('id', $id)->update($kdata);
    }
    //删除我的地址
    public function doPagedelmyaddress()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $id = input("id");
        $res = Db::table('ims_sudu8_page_duo_products_address')->where('id', $id)->delete();
        return json_encode($res);
    }
    //获取新多产品订单
    public function doPageduoorderget()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $order_id = input("order");
        $order = Db::table('ims_sudu8_page_duo_products_order')->where('order_id', $order_id)->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $order['jsondata'] = unserialize($order['jsondata']);
        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $mymongy = $userinfo['money'];
        $order['mymoney'] = $mymongy;
        if ($order['coupon'] != 0) {
            $coupon = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where('id', $order['coupon'])->find();
            $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', $coupon['cid'])->find();
            $order['mycoupon'] = $couponinfo['price'];
        } else {
            $order['mycoupon'] = 0;
        }
        $result['data'] = $order;
        return json_encode($result);
    }
    //获取产品订单
    public function dopageptorderget()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $order_id = input("order");
        $order = Db::table('ims_sudu8_page_pt_order')->where('order_id', $order_id)->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $order['jsondata'] = unserialize($order['jsondata']);
        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $mymongy = $userinfo['money'];
        $order['mymoney'] = $mymongy;
        if ($order['coupon'] != 0) {
            $coupon = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where('id', $order['coupon'])->find();
            $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', $coupon['cid'])->find();
            $order['mycoupon'] = $couponinfo['price'];
        } else {
            $order['mycoupon'] = 0;
        }
        $result['data'] = $order;
        return json_encode($result);
    }
    // 支付过后更新对应状态
    public function doPageduoorderchange()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $order_id = input("order_id");
        $true_price = input("true_price");
        $dkscore = input("dkscore");
        $couponid = input("couponid");
        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $mymongy = $userinfo['money'];
        $newmymoney = $mymongy - $true_price;
        $myscore = $userinfo['score'];
        $newmyscore = $myscore - $dkscore;
        if ($newmymoney < 0) {
            $newmymoney = 0;
        }
        if ($newmyscore < 0) {
            $newmyscore = 0;
        }
        $data = array(
            "money" => $newmymoney,
            "score" => $newmyscore
        );
        Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update($data);
        // 更改订单号
        Db::table('ims_sudu8_page_duo_products_order')->where('order_id', $order_id)->update(array("flag" => 1));
        //删除对应的优惠券
        Db::table('ims_sudu8_page_coupon_user')->where('id', $couponid)->update(array("flag" => 1,"utime"=>time()));
        //删除对应的购物车
        $order = Db::table('ims_sudu8_page_duo_products_order')->where('openid', $openid)->where('order_id', $order_id)->find();
        $jsdata = unserialize($order['jsondata']);
        $fmsg = "";
        foreach ($jsdata as $key => &$res) {
            Db::table('ims_sudu8_page_duo_products_gwc')->where('id', $res['id'])->update(array("flag" => 2));
            // 处理销售量
            $pvid = $res['pvid'];
            $num = $res['num'];
            $pro = Db::table('ims_sudu8_page_products')->where('id', $pvid)->find();
            $pronum = $pro['sale_tnum'];
            $newpronum = $pronum + $num;
            Db::table('ims_sudu8_page_products')->where('id', $pvid)->update(array("sale_tnum" => $newpronum));
            // 减去对应的库存
            $spid = $res['proinfo']['id'];
            $spnum = $res['proinfo']['kc'];
            $kc = $spnum - $num;
            $pro_val = Db::table('ims_sudu8_page_duo_products_type_value')->where('id', $spid)->find();
            $fmsg .= "产品：" . $pro['title'] . " 购买数：" . $num . " 购买规格：" . $pro_val['type1'] . " " . $pro_val['type2'] . " " . $pro_val['type3'] . " " . " 购买价格：" . $pro_val['price'] . "元 ";
            //加销量
            $salenum = $pro_val['salenum'] + 1;
            Db::table('ims_sudu8_page_duo_products_type_value')->where('id', $spid)->update(array("kc" => $kc, "salenum" => $salenum));
        }
        $applet = Db::table('applet')->where("id", $uniacid)->field('appID,appSecret')->find();
        if ($applet) {
            $mid = Db::table('ims_sudu8_page_message')->where("uniacid", $uniacid)->where('flag', 6)->find();
            if ($mid) {
                if ($mid['mid'] != "") {
                    $mids = $mid['mid'];
                    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $applet['appID'] . "&secret=" . $applet['appSecret'];
                    $a_token = $this->_requestGetcurl($url);
                    if ($a_token) {
                        $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $a_token['access_token'];
                        $formId = input('formid');
                        $ftime = date('Y-m-d H:i:s', time());
                        $openid = input('openid');
                        $fprice = $true_price . "元";
                        $furl = $mid['url'];
                        $post_info = '{
                                  "touser": "' . $openid . '",  
                                  "template_id": "' . $mids . '", 
                                  "page": "' . $furl . '",          
                                  "form_id": "' . $formId . '",         
                                  "data": {
                                      "keyword1": {
                                          "value": "' . $order_id . '", 
                                          "color": "#173177"
                                      }, 
                                      "keyword2": {
                                          "value": "' . $fprice . '", 
                                          "color": "#173177"
                                      }, 
                                      "keyword3": {
                                          "value": "' . $fmsg . '", 
                                          "color": "#173177"
                                      } , 
                                      "keyword4": {
                                          "value": "' . $ftime . '", 
                                          "color": "#173177"
                                      } 
                                  },
                                  "emphasis_keyword": "" 
                                }';
                        $this->_requestPost($url_m, $post_info);
                    }
                }
            }
        }
        //生成支付流水
        // 1.支付金钱流水
        $xfmoney = array(
            "uniacid" => $uniacid,
            "orderid" => $order_id,
            "uid" => $userinfo['id'],
            "type" => "del",
            "score" => $true_price,
            "message" => "消费",
            "creattime" => time()
        );
        if ($true_price > 0) {
            Db::table('ims_sudu8_page_money')->insert($xfmoney);
        }
        // 2.支付积分流水
        $xfscore = array(
            "uniacid" => $uniacid,
            "orderid" => $order_id,
            "uid" => $userinfo['id'],
            "type" => "del",
            "score" => $dkscore,
            "message" => "消费",
            "creattime" => time()
        );
        if ($dkscore > 0) {
            Db::table('ims_sudu8_page_score')->insert($xfscore);
        }
        // 分销商的关系[1.绑定上下级关系 2.上下级获取对应的金钱及记录[重新操作] 3.是否晋升为分销商]
        // 获取下单时对应的分销比例
        $one_bili = $jsdata[0]['one_bili'];
        $two_bili = $jsdata[0]['two_bili'];
        $three_bili = $jsdata[0]['three_bili'];
        //获取该小程序的分销关系绑定规则
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where('uniacid', $uniacid)->find();
        $fxsid = input('fxsid');
        $fxsinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $fxsid)->find();
        // 1.先进行上下级关系绑定[判断是不是首次付款]
        if ($guiz['sxj_gx'] == 3 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] != 2 && $fxsinfo['fxs'] == 2) {
            $p_fxs = $fxsinfo['parent_id'];  //分销商的上级
            $p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
            // 判断启用几级分销
            $fx_cj = $guiz['fx_cj'];
            // 分别做判断
            if ($fx_cj == 1) {
                $uuser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("parent_id" => $fxsid));
            }
            if ($fx_cj == 2) {
                $uuser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs));
            }
//            var_dump($fxsid);exit;
            if ($fx_cj == 3) {
                $uuser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs, "p_p_parent_id" => $p_p_fxs));
            }
        }
        // 重新获取该用户信息
        $userinfo_new = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        // 2.上下级获取对应的金钱及记录
        // 只启用一级分销提成
        if ($guiz['fx_cj'] == 1) {
            $onemoney = round($true_price * ($one_bili * 1) / 100, 2);
            if ($userinfo_new['parent_id'] != '0') {
                // 分销订单流水记录
                $lsdata = array(
                    "uniacid" => $uniacid,
                    "openid" => $openid,
                    "parent_id" => $userinfo_new['parent_id'],
                    "parent_id_get" => $onemoney,
                    "p_parent_id" => 0,
                    "p_parent_id_get" => 0,
                    "p_p_parent_id" => 0,
                    "p_p_parent_id_get" => 0,
                    "order_id" => $order_id,
                    "creattime" => time()
                );
                Db::table('ims_sudu8_page_fx_ls')->insert($lsdata);
            }
        }
        // 启动二级分销提成
        if ($guiz['fx_cj'] == 2) {
            $onemoney = round($true_price * ($one_bili * 1) / 100, 2);
            $twomoney = round($true_price * ($two_bili * 1) / 100, 2);
            $P = 0;
            $P_P = 0;
            if ($userinfo_new['parent_id'] == '0') {
                $P = 0;
                $onemoney = 0;
            } else {
                $P = $userinfo_new['parent_id'];
                $onemoney = $onemoney;
            }
            if ($userinfo_new['p_parent_id'] == '0') {
                $P_P = 0;
                $twomoney = 0;
            } else {
                $P_P = $userinfo_new['p_parent_id'];
                $twomoney = $twomoney;
            }
            // 分销订单流水记录
            $lsdata = array(
                "uniacid" => $uniacid,
                "openid" => $openid,
                "parent_id" => $P,
                "parent_id_get" => $onemoney,
                "p_parent_id" => $P_P,
                "p_parent_id_get" => $twomoney,
                "p_p_parent_id" => 0,
                "p_p_parent_id_get" => 0,
                "order_id" => $order_id,
                "creattime" => time()
            );
            Db::table('ims_sudu8_page_fx_ls')->insert($lsdata);
        }
        // 启动三级分销提成
        if ($guiz['fx_cj'] == 3) {
            $onemoney = round($true_price * ($one_bili * 1) / 100, 2);
            $twomoney = round($true_price * ($two_bili * 1) / 100, 2);
            $threemoney = round($true_price * ($three_bili * 1) / 100, 2);
            $P = 0;
            $P_P = 0;
            $P_P_P = 0;
            if ($userinfo_new['parent_id'] == '0') {
                $P = 0;
                $onemoney = 0;
            } else {
                $P = $userinfo_new['parent_id'];
                $onemoney = $onemoney;
            }
            if ($userinfo_new['p_parent_id'] == '0') {
                $P_P = 0;
                $twomoney = 0;
            } else {
                $P_P = $userinfo_new['p_parent_id'];
                $twomoney = $twomoney;
            }
            if ($userinfo_new['p_p_parent_id'] == '0') {
                $P_P_P = 0;
                $threemoney = 0;
            } else {
                $P_P_P = $userinfo_new['p_p_parent_id'];
                $threemoney = $threemoney;
            }
            // 分销订单流水记录
            $lsdata = array(
                "uniacid" => $uniacid,
                "openid" => $openid,
                "parent_id" => $P,
                "parent_id_get" => $onemoney,
                "p_parent_id" => $P_P,
                "p_parent_id_get" => $twomoney,
                "p_p_parent_id" => $P_P_P,
                "p_p_parent_id_get" => $threemoney,
                "order_id" => $order_id,
                "creattime" => time()
            );
            Db::table('ims_sudu8_page_fx_ls')->insert($lsdata);
        }
        // 3.是否付钱升级为分销商
        if ($userinfo_new['fxs'] == 1) {   //支付完了还不是分销商
            $val = $guiz['fxs_sz_val'];
            if ($guiz['fxs_sz'] == 3) {  //消费次数
                // 获取我的消费次数
                $xf = count(Db::query("SELECT * FROM ims_sudu8_page_duo_products_order WHERE openid = '" . $openid . "' and uniacid = " . $uniacid . " and flag = 1 or flag =2"));
                if ($xf >= $val) {
                    Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("fxs" => 2, "fxstime" => time()));
                }
            }
            if ($guiz['fxs_sz'] == 4) {  //消费过的金额？？？？？消费的金额？？？？？分销出去消费的金额？？？？？？
                // 获取我的消费
                $xf = Db::query("SELECT * FROM ims_sudu8_page_duo_products_order WHERE openid = '" . $openid . "' and uniacid = " . $uniacid . " and flag = 1 or flag =2");
                // 分销后重新下单的情况
                $jjmoney = 0;
                foreach ($xf as $key => &$res) {
                    $jjmoney += $res['price'];
                }
                if ($jjmoney >= $val) {
                    Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("fxs" => 2, "fxstime" => time()));
                }
            }
        }
    }
    // 多规格的订单
    public function dopageduoorderlist()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        // 处理已发货并且过了7天还没有确定的订单
        $clorders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('flag', 4)->select();
        foreach ($clorders as $key => &$res) {
            $st = $res['hxtime'] * 1 + 3600 * 24 * 7;
            if ($st < time()) {
                $adata = array(
                    "hxtime" => $st,
                    "flag" => 2
                );
                Db::table('ims_sudu8_page_duo_products_order')->where('id', $res['id'])->update($adata);
                // 核销完成后去检测要不要进行分销商返现
                $order_id = $res['order_id'];
                $openid = $res['openid'];
                $fxsorder = Db::table('ims_sudu8_page_fx_ls')->where('uniacid', $uniacid)->where('order_id', $order_id)->find();
                if ($fxsorder) {
                    $this->dopagegivemoney($uniacid, $openid, $order_id);
                }
            }
        }
        // 先处理未支付并超过30分钟的订单
        $wforders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('flag', 0)->select();
        foreach ($wforders as $key => &$res) {
            $st = $res['creattime'] + 1800;
            if ($st < time()) {
                $adata = array(
                    "flag" => 3
                );
                Db::table('ims_sudu8_page_duo_products_order')->where('id', $res['id'])->update($adata);
                Db::table('ims_sudu8_page_fx_ls')->where('uniacid', $uniacid)->where('order_id', $res['order_id'])->update($adata);
            }
        }
        //订单状态 类型
        $flag = input('flag');
        $type1 = input('type1');
        $page=input("page");
        $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->order('id desc')->select();
        if ($flag == 0) {
            $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 0)->order('id desc')->select();
        }
        if ($flag == 1 && $type1 == 1) {
            $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 1)->where('nav', 1)->order('id desc')->select();
        }
        if ($flag == 1 && $type1 == 2) {
            $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 1)->where('nav', 2)->order('id desc')->select();
        }
        if ($flag == 2) {
            $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 2)->order('id desc')->select();
        }
        if ($flag == 3) {
            $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 3)->order('id desc')->select();
        }
        if ($flag == 4) {
            $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 4)->order('id desc')->select();
        }
        if ($flag == 5) {
            $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 5)->order('id desc')->select();
        }
        if ($flag == 7) {
            $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag',"in",[6,7,8,9])->order('id desc')->select();
        }




        foreach ($orders as $key => &$res) {
            $res['price'] = round($res['price'], 2);
            $res['jsondata'] = unserialize($res['jsondata']);
            
            if(!empty($res['hxinfo'])){
                $hxinfo = unserialize($res['hxinfo']);
                if($hxinfo[0] == 1){
                    $res['hxinfo'] = array();
                    $res['hxinfo']['flag'] = 1;
                    $res['hxinfo']['store'] = "总账号核销";
                }else{
                    $res['hxinfo'] = array();
                    $res['hxinfo']['flag'] = 2;
                    $res['hxinfo']['store'] = Db::table("ims_sudu8_page_store")->where("id", $hxinfo[1])->field("title")->find()['title'];
                    $res['hxinfo']['staff'] = Db::table("ims_sudu8_page_staff")->where("id", $hxinfo[2])->field("realname")->find()['realname'];
                }
            }
            foreach ($res['jsondata'] as $key2 => &$reb) {
                if (isset($reb['baseinfo']) && $reb['baseinfo']['thumb']) {
                    $reb['baseinfo']['thumb'] = remote($uniacid, $reb['baseinfo']['thumb'], 1);
                }
                if (!isset($reb['baseinfo2']) && !is_array($reb['baseinfo'])) {
                    $reb['baseinfo2'] = Db::table('ims_sudu8_page_pt_pro')->where("id", $reb['baseinfo'])->find();
                    $reb['proinfo'] = Db::table('ims_sudu8_page_pt_pro_val')->where("id", $reb['proinfo'])->find();
                    if ($reb['proinfo']) {
                        $reb['proinfo']['ggz'] = $reb['proinfo']['comment'] . ":" . $reb['proinfo']['type1'];
                    }
                }
            }
            $res['creattime'] = date("Y-m-d H:i:s", $res['creattime']);
            $res['hxtime'] = $res['hxtime'] == 0 ? "未核销" : date("Y-m-d H:i:s", $res['hxtime']);
            $res['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
            $res['counts'] = count($res['jsondata']);
            $val = Db::table('ims_sudu8_page_formcon')->where('uniacid', $uniacid)->where('id', $res['formid'])->find();
            if ($val) {
                $val = unserialize($val['val']);
                foreach ($val as $k => &$v) {
                    if (is_array($v['val'])) {
                        $vl = "";
                        foreach ($v['val'] as $kk => $vv) {
                            $vl = $vl . $vv . ",";
                        }
                        $v['val'] = substr($vl, 0, -1);;
                    }
                    if ($v['type'] == 5) {
                        foreach ($v['z_val'] as $ki => &$vi) {
                            if (strpos($v, "http") === false) {
                                $vi = remote($uniacid, $vi, 1);
                            }
                        }
                    }
                }
                $res['val'] = $val;
            } else {
                $res['val'] = '';
            }
        }
        $result['data'] = $orders;
        return json_encode($result);
    }
    //多规格的订单30分钟后结束
    public function doPagesetorderover()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $time = time();
        $orders = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->select();
        foreach ($orders as $key => &$res) {
            $overtime = $res['creattime'] + (30 * 60);
        }
    }
    // 向我的上级返钱操作['并生成流水记录']
    public function dopagegivemoney($uniacid, $openid, $orderid)
    {
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where('uniacid', $uniacid)->find();
        $order = Db::table('ims_sudu8_page_fx_ls')->where('uniacid', $uniacid)->where('order_id', $orderid)->find();
        Db::table('ims_sudu8_page_fx_ls')->where('order_id', $orderid)->update(array("flag" => 2));
        $me = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['openid'])->find();
        $me_p_get_money = $me['p_get_money'];
        $me_p_p_get_money = $me['p_p_get_money'];
        $me_p_p_p_get_money = $me['p_p_p_get_money'];
        // 启动一级分销提成
        if ($guiz['fx_cj'] == 1) {
            if ($order['parent_id']) {
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['parent_id'])->update($kdata);
                // 我给我的父级贡献的钱
                $new_p_get_money = $me_p_get_money * 1 + $order['parent_id_get'] * 1;
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['openid'])->update(array("p_get_money" => $new_p_get_money));
            }
        }
        // 启动二级分销提成
        if ($guiz['fx_cj'] == 2) {
            if ($order['parent_id']) {
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['parent_id'])->update($kdata);
                // 我给我的父级贡献的钱
                $new_p_get_money = $me_p_get_money * 1 + $order['parent_id_get'] * 1;
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['openid'])->update(array("p_get_money" => $new_p_get_money));
            }
            if ($order['p_parent_id']) {
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['p_parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['p_parent_id'])->update($kdata);
                // 我给我的父级的父级贡献的钱
                $new_p_p_get_money = $me_p_p_get_money * 1 + $order['p_parent_id_get'] * 1;
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['openid'])->update(array("p_p_get_money" => $new_p_p_get_money));
            }
        }
        // 启动三级分销提成
        if ($guiz['fx_cj'] == 3) {
            if ($order['parent_id']) {
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['parent_id'])->update($kdata);
                // 我给我的父级贡献的钱
                $new_p_get_money = $me_p_get_money * 1 + $order['parent_id_get'] * 1;
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['openid'])->update(array("p_get_money" => $new_p_get_money));
            }
            if ($order['p_parent_id']) {
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['p_parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['p_parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['p_parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['p_parent_id'])->update($kdata);
                // 我给我的父级的父级贡献的钱
                $new_p_p_get_money = $me_p_p_get_money * 1 + $order['p_parent_id_get'] * 1;
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['openid'])->update(array("p_p_get_money" => $new_p_p_get_money));
            }
            if ($order['p_p_parent_id']) {
                $puser = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['p_p_parent_id'])->find();
                $kdata = array(
                    "fx_allmoney" => $puser['fx_allmoney'] + $order['p_p_parent_id_get'],
                    "fx_money" => $puser['fx_money'] + $order['p_p_parent_id_get']
                );
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['p_p_parent_id'])->update($kdata);
                // 我给我的父级的父级的附近贡献的钱
                $new_p_p_p_get_money = $me_p_p_p_get_money * 1 + $order['p_p_parent_id_get'] * 1;
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $order['openid'])->update(array("p_p_p_get_money" => $new_p_p_p_get_money));
            }
        }
    }
    // 点击确认订单按钮确认收货
    public function doPagequerenxc()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $orderid = input("orderid");
        $adata = array(
            "hxtime" => time(),
            "flag" => 2
        );
        Db::table('ims_sudu8_page_duo_products_order')->where('order_id', $orderid)->update($adata);
        $fxsorder = Db::table('ims_sudu8_page_fx_ls')->where('order_id', $orderid)->where('uniacid', $uniacid)->find();
        if ($fxsorder) {
            $this->dopagegivemoney($uniacid, $openid, $orderid);
        }
    }
//    // 点击确认订单按钮确认收货（新版）
    public function dopagenewquerenxc(){
        $uniacid = input("uniacid");
        $openid = input("openid");
        $orderid = input("orderid");
        $adata = array(
            "hxtime" => time(),
            "flag" => 2
        );
        // var_dump($orderid);
        // var_dump($adata);
        // die();
        Db::table('ims_sudu8_page_duo_products_order')->where('order_id', $orderid)->update($adata);
        $fxsorder = Db::table('ims_sudu8_page_fx_ls')->where('order_id', $orderid)->where('uniacid', $uniacid)->find();
        if ($fxsorder) {
            $this->dopagegivemoney($uniacid, $openid, $orderid);
        }

//        //购买送积分
//        $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "order_id"=>$orderid), array("uid", "jsondata"));
        $order=Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$uniacid)->where("order_id",$orderid)->find();
        $jsondata = unserialize($order['jsondata']);
        $total_num = 0;
        $total_price = 0;
        foreach ($jsondata as $key => &$value) {
            $total_num += $value['num'];
            $total_price += $value['proinfo']['price'] * $value['num'];
        }
//
//        $scoreback = pdo_getcolumn("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$jsondata[0]['baseinfo']['id']), "scoreback");
        $a=Db::table("ims_sudu8_page_products")->where("uniacid",$uniacid)->where("id",$jsondata[0]['baseinfo']['id'])->find();
        $scoreback=$a['scoreback'];
        if(!empty($scoreback)){
            if(strpos($scoreback, "%")){
                $scoreback = floatval(chop($scoreback, "%"));
//                $scoretomoney = pdo_get("sudu8_page_rechargeconf", array("uniacid" => $uniacid));
                $scoretomoney=Db::table("ims_sudu8_page_rechangeconf")->where("uniacid",$uniacid)->find();
                $scoreback = $total_price * $scoreback / 100;
                $scoreback = floor($scoreback * intval($scoretomoney['scroe']) / intval($scoretomoney['money']));

            }else{
                $scoreback = floor($total_num * floatval($scoreback));
            }

            if($scoreback > 0){
//                $new_user = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "id"=>$order['uid']));
                $new_user=Db::table("ims_sudu8_page_user")->where("uniacid",$uniacid)->where("id",$order['uid'])->find();
                $new_my_score = $new_user['score'] + $scoreback;
//                pdo_update("sudu8_page_user", array("score"=>$new_my_score), array("uniacid"=>$uniacid, "id"=>$new_user['id']));
               Db::table("ims_sudu8_page_user")->where("uniacid",$uniacid)->where("id",$new_user['id'])->update(array("score"=>$new_my_score));
                $scoreback_data = array(
                    "uniacid" => $uniacid,
                    "orderid" => $orderid,
                    "uid" => $new_user['id'],
                    "type" => "add",
                    "score" => $scoreback,
                    "message" => "买送积分",
                    "creattime" => time()
                );
//                pdo_insert("sudu8_page_score", $scoreback_data);
                Db::table("ims_sudu8_page_score")->insert($scoreback_data);
            }
        }

    }

//    //用户退货（新版）
    public function doPagenewtuihuo(){

        $uniacid = input('uniacid');

        $order_id = input('order_id');

        if(!empty($order_id)){
            $data = array(
                'kuaidi_th' => input('kuaidi'),
                'kuaidihao_th' => input('kuaidihao'),
                'flag' => 7
            );

//           $result = pdo_update("sudu8_page_duo_products_order", $data, array("uniacid"=>$uniacid, "order_id"=>$order_id));
            $result=Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$uniacid)->where("order_id",$order_id)->update($data);
        }

//        return $this->result(0, 'success', array("result"=>$result));
         return json_encode(array("result"=>$result));
    }


//   新版多规格取消订单
    public function doPagenewduoshoptk(){
        $uniacid = input('uniacid');

        $formId = input('formId');
        $order_id = input('order_id');

        if($order_id && $order_id != 'undefined'){
            $now = time();
            $out_refund_no = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
//            pdo_update("sudu8_page_duo_products_order", array("th_orderid"=>$out_refund_no), array("uniacid"=>$uniacid, "order_id"=>$order_id));
           Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$uniacid)->where("order_id",$order_id)->update(array("th_orderid"=>$out_refund_no));
//            $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "order_id"=>$order_id));
           $order=Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$uniacid)->where("order_id",$order_id)->find();
            if($order['payprice'] > 0){
//                require_once(IA_ROOT."/addons/sudu8_page/WeixinRefund.php");
////                $app = pdo_get("account_wxapp", array("uniacid"=>$uniacid));
//
//                $paycon = pdo_get("uni_settings", array("uniacid"=>$uniacid));
//                $datas = unserialize($paycon['payment']);
//                $appid = $app['key'];
//                $mch_id = $datas['wechat']['mchid'];
//                $zfkey = $datas['wechat']['signkey'];
//                $refund_fee = intval($order['payprice'] * 100);
//                $weixinrefund = new WeixinRefund($appid, $zfkey, $mch_id, $order['order_id'], $out_refund_no, $refund_fee, $refund_fee, $uniacid, "duo");
//                $return = $weixinrefund->refund();
                $app = Db::table('applet')->where("id",$uniacid)->find();
                $mchid = $app['mchid'];   //商户号
                $apiKey = $app['signkey'];    //商户的秘钥
                $appid = $app['appID'];                 //小程序的id
                $appkey = $app['appSecret'];            //小程序的秘钥
                // 更新信息
//                        $sqtx = Db::table('ims_sudu8_page_pt_tx')->where("uniacid",$appletid)->where("id",$id)->find();
                $openid= $order['openid'];    //申请者的openid
                $outTradeNo =$out_refund_no;
                $totalFee= intval($order['payprice'] * 100);  //申请了提现多少钱
                $outRefundNo = $out_refund_no; //商户订单号
                $refundFee= intval($order['payprice'] * 100);  //申请了提现多少钱
                $SSLCERT_PATH = ROOT_PATH.'public/Cert/'.$uniacid.'/apiclient_cert.pem';//证书路径
                $SSLKEY_PATH =  ROOT_PATH.'public/Cert/'.$uniacid.'/apiclient_key.pem';//证书路径
                $opUserId = $mchid;//商户号
                include "WinXinRefund.php";
                $weixinpay = new WinXinRefund($openid,$outTradeNo,$totalFee,$outRefundNo,$refundFee,$SSLCERT_PATH,$SSLKEY_PATH,$opUserId,$appid,$apiKey);
                $return = $weixinpay->refund();
                if(!$return){
//                    return $this->result(0, "success", array("flag" => 1, "message" => "退款失败！请联系卖家"));
                    return json_encode(array("flag" => 1, "message" => "退款失败！请联系卖家"));
                }else{
                    $xfmoney = array(
                        "uniacid" => $uniacid,
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
                            "uniacid" => $uniacid,
                            "orderid" => $order['order_id'],
                            "uid" => $order['uid'],
                            "type" => "add",
                            "score" => $tk_je,
                            "message" => "退款退回余额",
                            "creattime" => time()
                        );
//                                pdo_insert("sudu8_page_money", $xfmoney1);
                        Db::table("ims_sudu8_page_money")->insert($xfmoney1);
                    }
                }

            }else{
//                pdo_update("sudu8_page_duo_products_order", array("flag"=>8), array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                 Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$uniacid)->where("th_orderid",$out_refund_no)->update(array("flag"=>8));
//                $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "th_orderid"=>$out_refund_no));
                $order=Db::table("ims_sudu8_page_duo_products_order")->where("uniacid",$uniacid)->where("th_orderid",$out_refund_no)->find();
//                pdo_query("UPDATE ".tablename("sudu8_page_user")." SET money = money + ".$order['price']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                Db::execute("update  ims_sudu8_page_user set money=money+".$order['price']." where uniacid=".$uniacid." and id=".$order["uid"]);
                if($order['coupon']){
//                    pdo_update("sudu8_page_coupon_user", array("flag"=>0), array("uniacid"=>$uniacid, "uid"=>$order['uid'], "id"=>$order['coupon']));
                     Db::table("ims_sudu8_page_coupon_user")->where("uniacid",$uniacid)->where("uid",$order["uid"])->where("id",$order['coupon'])->update(array("flag"=>0,"utime"=>0));
                }

                if($order['price'] > 0){
                    $xfmoney = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order['order_id'],
                        "uid" => $order['uid'],
                        "type" => "add",
                        "score" => $order['price'],
                        "message" => "退款退回余额",
                        "creattime" => time()
                    );
                    Db::table("ims_sudu8_page_money")->insert($xfmoney);
                }
                $a=Db::table("ims_sudu8_page_user")->where("uniacid",$uniacid)->where("id",$order['uid'])->find();
                $b=$a['money']*1+$order['price']*1;
                Db::table("ims_sudu8_page_user")->where("uniacid",$uniacid)->where("id",$order['uid'])->update(array("money"=>$b));

                if($order['jf']){
//                    pdo_query("UPDATE ".tablename("sudu8_page_user")." SET score = score + ".$order['jf']." WHERE uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$order["uid"]));
                   Db::execute("update ims_sudu8_page_user set score=score+".$order['jf']." where uniacid=".$uniacid." and id=".$order["uid"]);
                    $score_data = array(
                        "uniacid" => $uniacid,
                        "orderid" => $order_id,
                        "uid" => $order['uid'],
                        "type" => "add",
                        "score" => $order['jf'],
                        "message" => "退款退回抵扣积分",
                        "creattime" => time()
                    );
//                    pdo_insert("sudu8_page_score", $score_data);
                     Db::table("ims_sudu8_page_score")->insert($score_data);
                }

                $fmsg = "";
                $jsondata = unserialize($order['jsondata']);
                foreach($jsondata as $key => &$value){
                    if($key != 0){
                        $fmsg .= "\\n";
                    }

                    $fmsg .= $value['baseinfo']['title'] . "（" . chop($value['proinfo']['ggz'],',') . "） ×" .$value['num'];
//                    pdo_query("UPDATE ".tablename("sudu8_page_duo_products_type_value")." SET kc = kc + ".$value['num']." WHERE id = :id", array(":id"=>$value['proinfo']['id']));
                    Db::execute("update ims_sudu8_page_duo_products_type_value set kc=kc+".$value['num']." where id=".$value['proinfo']['id']);
                }

//                $flag = 9;
//                $this->sendTplMessage($flag, $order['openid'], $formId, 'duo_th', array("orderid"=>$order['order_id'], "fmsg"=>$fmsg, "fprice"=>$order['price'], "refund_type"=>"退回到余额"));

            }

//            return $this->result(0, "success", array("flag" => 0, "message" => "退款成功！"));
              return json_encode(array("flag" => 0, "message" => "退款成功！"));
        }
    }




    // // 省市区返回
    // public function dopageprovincejson(){
    //  include ROOT_PATH ."public/json/province_xcx.json";
    // }
    // public function dopagecityjson(){
    //  include ROOT_PATH ."public/json/city_xcx.json";
    // }
    // public function dopageareajson(){
    //  include ROOT_PATH . "public/json/area_xcx.json";
    // }
    public function doPageptprolist()
    {
        $uniacid = input("uniacid");
        $cateid = input("cate");
        $guiz = Db::table('ims_sudu8_page_pt_gz')->where('uniacid', $uniacid)->find();
        $cate = Db::table('ims_sudu8_page_pt_cate')->where('uniacid', $uniacid)->order("num desc")->select();
        if (!$cateid) {
            $lists = Db::table('ims_sudu8_page_pt_pro')->where("show_pro",0)->where('uniacid', $uniacid)->order("num desc")->select();
        } else {
            $lists = Db::table('ims_sudu8_page_pt_pro')->where("show_pro",0)->where('uniacid', $uniacid)->where('cid', $cateid)->order("num desc")->select();
        }
        foreach ($lists as $key => &$res) {
            // 获得所有参与的人，并去除相同的人
            $share = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $uniacid)->where('pid', $res['id'])->where('flag', "lt", 3)->select();
            $res['team'] = $this->tuanzsf($uniacid, $share);
            $tzcount = 0;
            $res['thumb'] = remote($uniacid, $res['thumb'], 1);
            foreach ($share as $key1 => &$reb) {
                $tzcount += $reb['join_count'];
            }
            $res['tzcount'] = $tzcount;
        }
        $data['lists'] = $lists;
        $data['guiz'] = $guiz;
        $data['cate'] = $cate;
        $result['data'] = $data;
        return json_encode($result);
    }
    // 获取所有的团长信息
    function tuanzsf($uniacid, $share)
    {
        $arr = array();
        $count = 0;
        foreach ($share as $key => &$res) {
            $jieguo = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $uniacid)->where('pt_order', $res['shareid'])->select();
            foreach ($jieguo as $key1 => &$reb) {
                $info = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $reb['openid'])->find();
                if (in_array($info['avatar'], $arr)) {
                    continue;
                } else {
                    $count++;
                    if ($count > 7) {
                        continue;
                    } else {
                        array_push($arr, $info['avatar']);
                    }
                }
            }
        }
        return $arr;
    }
    // 拼团情况
    public function doPagepingtuan()
    {
        $uniacid = input("uniacid");
        $shareid = input("shareid");
        $openid = input("openid");
        // 我的拼团
        $share = Db::table('ims_sudu8_page_pt_share')->where('shareid', $shareid)->where("uniacid",$uniacid)->find();
        // 拼团的商品
        $products = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $uniacid)->where('id', $share['pid'])->find();
        if($products['shareimg']){
            $products['shareimg'] = remote($uniacid,$products['shareimg'],1);
        }
        if($products['thumb']){
            $products['thumb'] = remote($uniacid,$products['thumb'],1);
        }
        $products['imgtext'] = unserialize($products['imgtext']);
//        $share_num = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_pt_share')." WHERE pid = :pid and uniacid = :uniacid" , array(':pid' => $products['id'],':uniacid' => $uniacid))
        $share_num=Db::table("ims_sudu8_page_pt_share")->where("pid",$products['id'])->where("uniacid",$uniacid)->select();
        $products['pt_num'] = 0;
        foreach($share_num as $kk => $vv){
            if($vv['join_count'] >= $vv['pt_min']){
                $products['pt_num'] ++;
            }
        }
        $data['hx'] = 0;
        // 参加拼团的人
       $lists = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $uniacid)->where('pt_order', $shareid)->where('flag','in',[1,2,4])->order('creattime asc')->select();
        foreach ($lists as $key => &$res) {
            $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $res['openid'])->find();
            $res['infoimg'] = $userinfo['avatar'];
            if($res['openid'] = $openid && !empty($res['hxinfo'])){
                $data['hx'] = 1;
                $hxinfo = unserialize($res['hxinfo']);
                if($hxinfo[0] == 1){
                    $data['hxinfo']['flag'] = 1;
                    $data['hxinfo']['store'] = "总账号核销";
                }else{
                    $data['hxinfo']['flag'] = 2;
                    $data['hxinfo']['store'] = Db::table("ims_sudu8_page_store")->where("id", $hxinfo[1])->field("title")->find()['title'];
                    $data['hxinfo']['staff'] = Db::table("ims_sudu8_page_staff")->where("id", $hxinfo[2])->field("realname")->find()['realname'];
                }
            }
        }
        // 获取成团规则
        $guiz = Db::table('ims_sudu8_page_pt_gz')->where('uniacid', $uniacid)->find();
        // 订单结束时间
        if($guiz['pt_time']){
            $overtime = $share['creattime'] * 1 + ($guiz['pt_time'] * 3600);
        }else{
            $overtime = $share['creattime'] * 1 + 24*3600;
        }

        $data['share'] = $share;
        $data['products'] = $products;
        $data['lists'] = $lists;
        $data['overtime'] = $overtime;
        $data['labels'] = explode(",", $products['explains']);
        $result['data'] = $data;
        return json_encode($result);
    }
    // 拼团商品详情
    public function doPagePtproductinfo()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $id = input("id");
        $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where('openid', $openid)->find();
        // 处理过期
        $this->doovershare($uniacid);
        $products = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $uniacid)->where('id', $id)->find();
        if ($products['shareimg']) {
            $products['shareimg'] = remote($uniacid, $products['shareimg'], 1);
            if (strpos($products['shareimg'], 'https') === false) {
                $products['shareimg'] = "https" . substr($products['shareimg'], 4);
            }
        } else {
            $products['shareimg'] = remote($uniacid, $products['thumb'], 1);
            if (strpos($products['shareimg'], 'https') === false) {
                $products['shareimg'] = "https" . substr($products['shareimg'], 4);
            }
        }
        if($products['thumb']){
            $products['thumb'] = remote($uniacid,$products['thumb'],1);
        }

        //会员购买设置
        $products['vip_config'] = 0;
        if(empty($userinfo['vipid'])){

            if(!empty($products['vipconfig'])){
                $vipconfig = unserialize($products['vipconfig']);

                if($vipconfig['set1'] == 1){
                    $products['vip_config'] = $vipconfig['set2'];
                }else{
                    $vip_config = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find();
                    if(!empty($vip_config)){
                        $products['vip_config'] = $vip_config['pt'];
                    }
                }
            }else{
                $vip_config = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find();
                if(!empty($vip_config)){
                    $products['vip_config'] = $vip_config['pt'];
                }
            }
        }


        $proarr = Db::table('ims_sudu8_page_pt_pro_val')->where('pid', $id)->order('id desc')->select();
        // 处理库存量
        $kcl = 0;
        foreach ($proarr as $key7 => &$res) {
            $kcl += $res['kc'];
        }
        $products['kc'] = $kcl;
        $imgarr = unserialize($products['imgtext']);
        foreach ($imgarr as $key1 => &$resb) {
            $resb = remote($uniacid, $resb, 1);
        }
        $products['imgtext'] = $imgarr;
        $types = $proarr[0]['comment'];
        //构建规格组
        $typesarr = explode(",", $types);
        // 构建规格组json
        $typesjson = [];
        foreach ($typesarr as $key4 => &$rec) {
            $str = "type" . ($key4 + 1);
            $ziji = Db::table('ims_sudu8_page_pt_pro_val')->where('pid', $id)->order('id desc')->group($str)->field($str)->select();
            $xarr = array();
            foreach ($ziji as $key => $res) {
                array_push($xarr, $res[$str]);
            }
            $cdata["val"] = $xarr;
            $cdata['ck'] = 0;
            $typesjson[$rec] = $cdata;
        }
        $adata['grouparr'] = $typesarr;
        $adata['grouparr_val'] = $typesjson;
        $products['explains'] = explode(",", $products['explains']);
        foreach ($products['explains'] as $k => &$v) {
            if ($v == "") {
                $products['explains'][$k] == "";
            }
        }
        $adata['products'] = $products;
        // 分销规则，暂时先预留着
        $adata['guiz'] = Db::table('ims_sudu8_page_fx_gz')->where('uniacid', $uniacid)->find();
        if (!$adata['guiz']) {
            $adata['guiz']['one_bili'] = 0;
            $adata['guiz']['two_bili'] = 0;
            $adata['guiz']['three_bili'] = 0;
        }
        // 获取成团规则
        $guiz = Db::table('ims_sudu8_page_pt_gz')->where('uniacid', $uniacid)->find();
        //处理该商品的开团情况
//        $pingt = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $uniacid)->where('pid', $id)->where('flag',"in",['1,2'])->order('creattime desc')->select();
        $pingt = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $uniacid)->where('pid', $id)->where("flag","in",[1,2])->order('creattime desc')->select();
        // 真正拼团的人
        $pingtcount = 0;
        $dataarr = array();
        if ($pingt) {
            foreach ($pingt as $key2 => &$reb) {
                if($guiz['pt_time']){
                    $overtime = $reb['creattime'] * 1 + ($guiz['pt_time'] * 3600);
                }else{
                    $overtime = $reb['creattime'] * 1 + 24*3600;
                }
                if($overtime>time()) {
                    $reb['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $reb['openid'])->find();
                    $min = $reb['pt_min'];
                    $max = $reb['pt_max'];
                    $pco = $reb['join_count'];
                    // 还差多少人
                    $chaj = $min - $pco;
                    if ($chaj < 0) {
                        $chaj = 0;
                    }
                    // 还剩多少人
                    $shen = $max - $pco;
                    $reb['chaj'] = $chaj;
                    $reb['shen'] = $shen;
                    // 订单结束时间
                    if($guiz['pt_time']){
                        $overtime =$reb['creattime'] * 1 + ($guiz['pt_time'] * 3600);
                    }else{
                        $overtime =$reb['creattime'] * 1 + 24*3600;
                    }
//                    $overtime = $reb['creattime'] * 1 + ($guiz['pt_time'] * 3600);
                    array_push($dataarr, $overtime);
                    $pingtcount += $pco;
                }
            }
        }
        $collect = Db::table('ims_sudu8_page_collect')->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where('a.uniacid', $uniacid)->where('a.cid', $id)->where("b.openid", $openid)->find();
        if ($collect) {
            $adata['collect'] = 1;
        } else {
            $adata['collect'] = 0;
        }
        $adata['pingtuan'] = $pingt;
        $adata['overtime'] = $dataarr;
        $adata['pingtcount'] = $pingtcount;
        $result['data'] = $adata;
        return json_encode($result);
    }
    //判断是否有未支付拼团订单
    public function doPageispt()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $id = input("id");
        $list = Db::table('ims_sudu8_page_pt_order')->where("uniacid", $uniacid)->where("openid", $openid)->where("flag", 0)->select();
        if ($list) {
            foreach ($list as $k => $v) {
                $jsondata = unserialize($v['jsondata']);
                foreach ($jsondata as $key2 => &$reb) {
                    if (!isset($reb['baseinfo2'])) {
                        if ($id == $reb['baseinfo']) {
                            return json_encode(array('order_id' => $v['order_id']));
                            exit;
                        }
                    }
                    if (!is_array($reb['proinfo'])) {
                        if ($id == $reb['proinfo']) {
                            return json_encode(array('order_id' => $v['order_id']));
                            exit;
                        }
                    } else {
                        if ($id == $reb['proinfo']['pid']) {
                            return json_encode(array('order_id' => $v['order_id']));
                            exit;
                        }
                    }
                    if (isset($reb['baseinfo'])) {
                        if ($id == $reb['baseinfo']) {
                            return json_encode(array('order_id' => $v['order_id']));
                            exit;
                        }
                    }
                }
            }
        } else {
            return json_encode(array('order_id' => 0));
            exit;
        }
    }
    // 处理过期的订单
    function doovershare($uniacid){
        $now = time();
        $guiz = Db::table('ims_sudu8_page_pt_gz')->where('uniacid',$uniacid)->find();
        $allshare = Db::table('ims_sudu8_page_pt_share')->where('uniacid',$uniacid)->where("flag","in",[1,2])->select();
        foreach ($allshare as $key => &$res) {
            $max = $res['pt_max']*1;
            $min = $res['pt_min']*1;
            $ct = $res['creattime'];
            if($guiz['pt_time']){
                $overtime = $ct * 1 + ($guiz['pt_time'] * 3600);
            }else{
                $overtime = $ct * 1 + 24*3600;
            }
//            $overtime = $ct*1 + ($guiz['pt_time'] * 3600);  //拼团结束的时间
            // 订单没过期
            if($overtime >= $now){
                // 拼团成功
                if($res['join_count']>=$min){
                    Db::table("ims_sudu8_page_pt_share")->where("id",$res['id'])->update(array("flag"=>2));
                }
            }
            // 订单已过期
            if($overtime < $now){
                // 拼团失败
                if($res['join_count']<$min){
                    // 自动成团
                    if($guiz['is_pt']==2){
                        // 生成机器人并完成订单
                       // pdo_update("sudu8_page_pt_share",array("flag"=>2,"join_count"=>$min),array("id"=>$res['id']));
                        Db::table("ims_sudu8_page_pt_share")->where("id",$res["id"])->update(array("flag"=>2,"join_count"=>$min));
                        // 生成机器人订单
                        $xhjc = $min - $res['join_count'];
                        $tmp = range(1,30);
                        $arr = array_rand($tmp,$xhjc);
                        for($i=0; $i<$xhjc; $i++){
                            // 获取机器人信息
//                            $jqr = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_robot')." WHERE id = :id" , array(':id' => $arr[$i]));
                            $jqr=Db::table("ims_sudu8_page_pt_robot")->where("id",$arr[$i]);
                            $jqrarr = array(
                                "uniacid" => $uniacid,
                                "openid" => $jqr['openid'],
                                "pt_order" => $res['shareid'],
                                "ck" => 2,
                                "jqr" => 2
                            );
//                            pdo_insert("sudu8_page_pt_order",$jqrarr);
                            Db::table("ims_sudu8_page_pt_order")->insert($jqrarr);
                        }
                    }else{
                        // 结束订单并退还所有的钱到余额
                        Db::table("ims_sudu8_page_pt_share")->where("id",$res["id"])->update(array("flag"=>3));
                        $lists=Db::table("ims_sudu8_page_pt_order")->where("uniacid",$uniacid)->where("pt_order",$res["shareid"])->where("jqr",1)->select();
                        foreach ($lists as $key1 => &$reb) {
                            Db::table("ims_sudu8_page_pt_order")->where("id",$reb['id'])->update(array("flag"=>5));
                            $user=Db::table("ims_sudu8_page_user")->where("openid",$reb['openid'])->where("uniacid",$uniacid)->find();
                            $pdata=array(
                                "uniacid"=>$uniacid,
                                "openid"=>$reb['openid'],
                                "ptorder"=> $reb['order_id'],
                                "money"=>$reb['price'],
                                "creattime"=>time(),
                                "flag"=>1
                            );
                            Db::table("ims_sudu8_page_pt_tx")->insert($pdata);
                            // 返回钱
                            // $nowmoney = $user['money'];
                            // $newmoney = $nowmoney*1 + $reb['price']*1;
                            // 返回积分
                            $nowscore = $user['score'];
                            $newscore = $nowscore*1 + $reb['jf']*1;
                            if($reb['jf']>0){
                                $xfscore=array(
                                    "uniacid"=>$uniacid,
                                    "orderid"=>$reb['id'],
                                    "uid"=>$user["id"],
                                    "type" => "add",
                                    "score" => $reb['jf']*1,
                                    "message" => "拼团退还积分",
                                    "creattime" => time()
                                );
                                Db::table("ims_sudu8_page_score")->insert($xfscore);
                            }
                            Db::table("ims_sudu8_page_user")->where("uniacid",$uniacid)->where("openid",$user["openid"])->update(array("score"=>$newscore));
                            // 返回优惠券
                            if($reb['coupon']!=0){
                                // 先判断优惠券有没有过期了
//                                $coupon = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_coupon_user')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $reb['coupon'],':uniacid' => $_W['uniacid']));
                                $coupon=Db::table("ims_sudu8_page_coupon_user")->where("id",$reb['coupon'])->where("uniacid",$uniacid)->find();
                                // 如果没有过期更改优惠券状态
                                if($coupon['etime']==0){
                                    Db::table("ims_sudu8_page_coupon_user")->where("id",$reb['coupon'])->update(array("utime"=>0,"flag"=>0));
                                }else{
                                    if($now <= $coupon['etime']){
                                        Db::table("ims_sudu8_page_coupon_user")->where("id",$reb['coupon'])->update(array("utime"=>0,"flag"=>0));
                                    }
                                }
                            }
                        }
                    }
                }else{
                    Db::table("ims_sudu8_page_pt_share")->where("id",$res["id"])->update(array("flag"=>4));
                }
            }
        }
    }
    //拼团数据自己规格
    public function doPageptpinfo()
    {
        $uniacid = input("uniacid");
        $str = input("str");
        $types = input("types");
        $id = input("id");
        $arr = explode("/", $str);
        $where = "";
        foreach ($arr as $key => &$res) {
            $vv = $key + 1;
            $where .= " and type" . $vv . " = " . "'" . $res . "'";
        }
        $proinfo = Db::query("SELECT * FROM ims_sudu8_page_pt_pro_val WHERE pid = " . $id . $where . " limit 1");
        $baseinfo = Db::table('ims_sudu8_page_pt_pro')->where('id', $id)->find();
        if($baseinfo['thumb']){
            $baseinfo['thumb'] = remote($uniacid,$baseinfo['thumb'],1);
        }
        $adata['proinfo'] = $proinfo[0];
        if($adata['proinfo']['thumb']){
            $adata['proinfo']['thumb'] = remote($uniacid,$adata['proinfo']['thumb'],1);
        }
        $adata['baseinfo'] = $baseinfo;
        $result['data'] = $adata;
        return json_encode($result);
    }
    // 判断是不是自己开的团和参与过的团
    public function doPagepdmytuanorcy()
    {
        $uniacid = input("uniacid");
        $shareid = input("shareid");
        $openid = input("openid");
        $type = 0;
        // 我的拼团
        $share = Db::table('ims_sudu8_page_pt_share')->where('shareid', $shareid)->where('openid', $openid)->find();
        if ($share) {
            $type = 1;
        }
        $cyshare = Db::table('ims_sudu8_page_pt_order')->where('pt_order', $shareid)->where('openid', $openid)->where('ck', 2)->where('flag',"in",[1,4])->find();
        if ($cyshare) {
            $type = 1;
        }
        $result['data'] = $type;
        return json_encode($result);
    }
    //拼团订单
    public function dopageptorderlist()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $orders = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $uniacid)->where('jqr', 1)->where('openid', $openid)->order('creattime desc')->select();
        foreach ($orders as $key => &$res) {
//            $pt_open = pdo_fetch("select * from ".tablename('sudu8_page_pt_share')." where shareid = :shareid and uniacid = :uniacid",array(':shareid' => $res['pt_order'],':uniacid' => $uniacid));
            $pt_open=Db::table("ims_sudu8_page_pt_share")->where("shareid",$res["pt_order"])->where("uniacid",$uniacid)->find();
            $res['join_count'] = $pt_open['join_count'];
            $res['pt_min'] = $pt_open['pt_min'];
            $res['pt_max'] = $pt_open['pt_max'];
            $res["ptflag"]=$pt_open["flag"];
            $res['jsondata'] = unserialize($res['jsondata']);
            $res['creattime'] = date("Y-m-d H:i:s", $res['creattime']);
            $res['hxtime'] = $res['hxtime'] == 0 ? "未核销" : date("Y-m-d H:i:s", $res['hxtime']);
            $res['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
            $res['counts'] = count($res['jsondata']);
            $coupon = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where('id', $res['coupon'])->find();
            $couponinfo = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', $coupon['cid'])->find();
            $res['couponinfo'] = $couponinfo;
            $pt_tx=Db::table("ims_sudu8_page_pt_tx")->where("ptorder",$res['order_id'])->where("uniacid",$uniacid)->find();
            if($pt_tx){
                $res['pt_tx'] = $pt_tx;
            }
            $allprice = 0;
            foreach ($res['jsondata'] as $key2 => &$reb) {
                $allprice += ($reb['num'] * 1) * ($reb['proinfo']['price']);
                if (!isset($reb['baseinfo2'])) {
                    $reb['baseinfo2'] = Db::table('ims_sudu8_page_pt_pro')->where("id", $reb['baseinfo'])->find();
                    if($reb['baseinfo2']){
                        if($reb['baseinfo2']['shareimg']){
                            $reb['baseinfo2']['shareimg'] = remote($uniacid,$reb['baseinfo2']['shareimg'],1);
                        }
                        if($reb['baseinfo2']['thumb']){
                            $reb['baseinfo2']['thumb'] = remote($uniacid,$reb['baseinfo2']['thumb'],1);
                        }
                    }
                }
                if (!is_array($reb['proinfo'])) {
                    $reb['proinfo'] = Db::table('ims_sudu8_page_pt_pro_val')->where("id", $reb['proinfo'])->find();
                    if ($reb['proinfo']) {
                        $reb['proinfo']['ggz'] = $reb['proinfo']['comment'] . ":" . $reb['proinfo']['type1'];
                    }
                } else {
                    $res['pid'] = $reb['proinfo']['pid'];
                }
                if (isset($reb['baseinfo'])) {
                    $res['pid'] = $reb['baseinfo'];
                }
            }
            $res['allprice'] = $allprice;
            // 积分转钱
            //积分转换成金钱
            $jf_gz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid', $uniacid)->find();
            if (!$jf_gz) {
                $gzscore = 10000;
                $gzmoney = 1;
            } else {
                $gzscore = $jf_gz['score'];
                $gzmoney = $jf_gz['money'];
            }
            $res['jfmoney'] = $res['jf'] * $gzmoney / $gzscore;
            // 转换地址
            if ($res['address'] != 0) {
                $res['address_get'] = Db::table('ims_sudu8_page_duo_products_address')->where('openid', $res['openid'])->where('id', $res['address'])->find();
            } else {
                $res['address_get'] = $res['m_address'];
            }
        }
        $result['data'] = $orders;
        return json_encode($result);
    }
    // 支付过后更新对应状态
    public function doPageptorderchange(){
//        global $_GPC, $_W;
        $uniacid = input('uniacid');
        $order_id = input('order_id');
        $openid = input('openid');
        $true_price = input('true_price');
        $dkscore = input('dkscore');
        $couponid = input('couponid');
        $shareid = input('shareid');
        $yue_price = input('yue_price');
        $wx_price= input('wx_price');
        $userinfo=Db::table("ims_sudu8_page_user")->where("openid",$openid)->where("uniacid",$uniacid)->find();
//        $userinfo = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE openid = :openid and uniacid = :uniacid" , array(':openid' => $openid ,':uniacid' => $_W['uniacid']));
        $mymongy = $userinfo['money'];
        $newmymoney = $mymongy - $true_price;
        $myscore = $userinfo['score'];
        $newmyscore = $myscore - $dkscore;
        $data = array(
            "money" => $newmymoney,
            "score" => $newmyscore
        );
//        pdo_update("sudu8_page_user",$data,array('openid'=>$openid,'uniacid' => $_W['uniacid']));
        Db::table('ims_sudu8_page_user')->where('openid',$openid)->where("uniacid",$uniacid)->update($data);
        // 更改订单号
        $datas = array(
            "flag" => 1,
            "yue_price" => $yue_price,
            "wx_price" => $wx_price,
            "coupon"=>$couponid
        );
//        pdo_update("sudu8_page_pt_order",$datas,array("order_id"=>$order_id));
         Db::table("ims_sudu8_page_pt_order")->where("order_id",$order_id)->update($datas);
        //删除对应的优惠券
//        pdo_update("sudu8_page_coupon_user",array("flag"=>1),array("id"=>$couponid));
        Db::table("ims_sudu8_page_coupon_user")->where("id",$couponid)->update(array("flag"=>1,"utime"=>time()));
        //处理库存
//        $order = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_order')." WHERE openid = :openid and order_id = :order_id" , array(':openid' => $openid ,':order_id' => $order_id));
        $order=Db::table("ims_sudu8_page_pt_order")->where("openid",$openid)->where("order_id",$order_id)->find();
//        var_dump($order['jsondata']);
//        exit();
        $jsdata = unserialize($order['jsondata']);
        foreach ($jsdata as $key => &$res) {
            // 处理销售量
            $pvid = $res['pvid'];
            $num = $res['num'];
            $pro=Db::table("ims_sudu8_page_pt_pro")->where("id",$pvid)->find();
//            $pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro') ." WHERE id = :id", array(':id'=>$pvid));
            $pronum = $pro['xsl'];
            $newpronum = $pronum+$num;
//            pdo_update("sudu8_page_pt_pro",array("xsl"=>$newpronum),array("id"=>$pvid));
            Db::table("ims_sudu8_page_pt_pro")->where("id",$pvid)->update(array("xsl"=>$newpronum));
            // 减去对应的库存
            $spid = $res['proinfo'];
//            $pro_val = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_pro_val') ." WHERE id = :id", array(':id'=>$spid));
            $pro_val=Db::table("ims_sudu8_page_pt_pro_val")->where("id",$spid)->find();
            $spnum = $pro_val['kc'];
            $kc = $spnum - $num;
//            pdo_update("sudu8_page_pt_pro_val",array("kc"=>$kc),array("id"=>$spid));
            Db::table("ims_sudu8_page_pt_pro_val")->where("id",$spid)->update(array("kc"=>$kc));
        }
        //生成支付流水
        // 1.支付金钱流水
        $xfmoney = array(
            "uniacid" => $uniacid,
            "orderid" => $order_id,
            "uid" => $userinfo['id'],
            "type" => "del",
            "score" => $true_price,
            "message" => "消费",
            "creattime" => time()
        );
        if($true_price>0){
//            pdo_insert("sudu8_page_money",$xfmoney);
            Db::table('ims_sudu8_page_money')->insert($xfmoney);
        }
        // 2.支付积分流水
        $xfscore = array(
            "uniacid" => $uniacid,
            "orderid" => $order_id,
            "uid" => $userinfo['id'],
            "type" => "del",
            "score" => $dkscore,
            "message" => "消费",
            "creattime" => time()
        );
        if($dkscore>0){
//            pdo_insert("sudu8_page_score",$xfscore);
            Db::table("ims_sudu8_page_score")->insert($xfscore);
        }
        $jsondata = unserialize($order['jsondata']);
        $pid = $jsondata[0]['id'];
        // 判断是不是直接购买并且是开团还是参加团购
        // 参加团购的时候更新参与人数
        if($order['ck']==2){
//            $share = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_pt_share')." WHERE shareid = :shareid" , array(':shareid' => $shareid));
            $share=Db::table("ims_sudu8_page_pt_share")->where("shareid",$shareid)->find();
            $counts = $share['join_count'] + 1;
//            pdo_update("sudu8_page_pt_share",array("join_count"=>$counts),array("shareid"=>$shareid));
            Db::table("ims_sudu8_page_pt_share")->where("shareid",$shareid)->update(array("join_count"=>$counts));
            $ptorderid = $shareid;
        }
        // 开团的时候
        $min_max=Db::table("ims_sudu8_page_pt_pro")->where("id",$pid)->where("uniacid",$uniacid)->find();
//        $min_max = pdo_fetch("select pt_min,pt_max from ".tablename('sudu8_page_pt_pro')." where id = :id and uniacid = :uniacid",array(':id' => $pid,':uniacid' => $uniacid));
//        var_dump($min_max);
//        exit();
        $pt_min = $min_max['pt_min'];
        $pt_max = $min_max['pt_max'];
        if($order['ck']==1){  //开团
            if($order['types']==1){
                //生成开团信息
                $now = time();
                $ptorderid = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
                $data = array(
                    "uniacid" => $uniacid,
                    "shareid" => $ptorderid,
                    "pid" => $pid,
                    "openid" => $openid,
                    "creattime" => time(),
                    "pt_min" => $pt_min,
                    "pt_max" => $pt_max,
                    "flag" => 1
                );
//                pdo_insert("sudu8_page_pt_share",$data);
                Db::table("ims_sudu8_page_pt_share")->insert($data);
                // 更新订单跟拼团订单绑定
                $pdata = array(
                    "pt_order" =>$ptorderid
                );
//                pdo_update("sudu8_page_pt_order",$pdata,array("order_id"=>$order_id));
                Db::table("ims_sudu8_page_pt_order")->where("order_id",$order_id)->update($pdata);
            }else{
                $ptorderid = 0;
            }
        }
        //模板消息
//        $applet = pdo_fetch("SELECT * FROM ".tablename('account_wxapp')." WHERE uniacid = :uniacid" , array(':uniacid' => $_W['uniacid']));
        $applet = Db::table('applet')->where("id", $uniacid)->field('appID,appSecret')->find();
        if ($applet) {
            $mid = Db::table('ims_sudu8_page_message')->where("uniacid", $uniacid)->where('flag', 7)->find();
            if ($mid) {
                if ($mid['mid'] != "") {
                    $mids = $mid['mid'];
                    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $applet['appID'] . "&secret=" . $applet['appSecret'];
                    $a_token = $this->_requestGetcurl($url);
                    if ($a_token) {
                        $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $a_token['access_token'];
                        $formId = input('formid');
                        $furl = $mid['url'];
                        if ($order['nav'] == 1) {
                            $fps = "快递";
                        } else {
                            $fps = "到店自提";
                        }
                        $fpro = $pro['title'] . " " . $pro_val['type1'] . " " . $pro_val['type2'] . " " . $pro_val['type3'];
                        if ($order['types'] == 1) {  //1拼团  2单买
                            $fprice = $pro_val['price'] . "元";  //拼团价
                            $fpy = $pro_val['dprice'] . "元";    //原价
                            $fmsg = $pro['pt_min'] . "人";
                        } else {
                            $fprice = $pro_val['dprice'] . "元";  //拼团价
                            $fpy = $pro_val['dprice'] . "元";  //原价
                            $fmsg = "原价单独购买";
                        }
                        $fnum = $num;
                        $fpriceall = $true_price . "元";
                        $ftime = date('Y-m-d H:i:s', time());
                        $post_info = '{
                                  "touser": "' . $openid . '",
                                  "template_id": "' . $mids . '",
                                  "page": "' . $furl . '",
                                  "form_id": "' . $formId . '",
                                  "data": {
                                      "keyword1": {
                                          "value": "' . $order_id . '",
                                          "color": "#173177"
                                      },
                                      "keyword2": {
                                          "value": "' . $fps . '",
                                          "color": "#173177"
                                      },
                                      "keyword3": {
                                          "value": "' . $fpro . '",
                                          "color": "#173177"
                                      },
                                      "keyword4": {
                                          "value": "' . $fprice . '",
                                          "color": "#173177"
                                      },
                                      "keyword5": {
                                          "value": "' . $fpy . '",
                                          "color": "#173177"
                                      },
                                      "keyword6": {
                                          "value": "' . $fnum . '",
                                          "color": "#173177"
                                      },
                                      "keyword7": {
                                          "value": "' . $fpriceall . '",
                                          "color": "#173177"
                                      },
                                      "keyword8": {
                                          "value": "' . $ftime . '",
                                          "color": "#173177"
                                      },
                                      "keyword9": {
                                          "value": "' . $fmsg . '",
                                          "color": "#173177"
                                      }
                                  },
                                  "emphasis_keyword": " "
                                }';
                        $this->_requestPost($url_m, $post_info);
                    }
                }
            }
        }
//        return $this->result(0, 'success', $ptorderid);
        $result['data'] = $ptorderid;
        return json_encode($result);
    }
    //创建订单
    public function dopageptsetorder()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $couponid = input("couponid");
        $price = input("price");
        $dkscore = input("dkscore");
        $address = input("address");
        $mjly = input("mjly");
        $nav = input("nav");
        $gwc = input("gwc");
        $shareid = input("shareid");
        $pvid = input('pvid');
        $jsdata = html_entity_decode(input('jsdata'));
        $jsdatass = json_decode($jsdata, true);
//        var_dump($jsdatass[0]["baseinfo"]);
//        exit();
     $pro=Db::table('ims_sudu8_page_pt_pro')->where("id",$jsdatass[0]["baseinfo"])->where("uniacid",$uniacid)->find();
     if($pro["show_pro"]==1){
         $data = 6;
         $result = $data;
         return json_encode($data);
         exit();
     }
        // 有拼团id
        if ($shareid!=0) {
            $ptorder = $shareid;
            $ptordershare = Db::table('ims_sudu8_page_pt_share')->where("shareid", $shareid)->find();
            $ptmax=Db::table("ims_sudu8_page_pt_order")->where("pt_order",$shareid)->where("flag","in",[1,4])->select();
            $ptmaxed = count($ptmax);
            if($ptordershare['openid'] == $openid){
                $data = 2;
                $result = $data;
                return json_encode($result);
                exit();
            }
            foreach ($ptmax as $key => $value) {
                if($openid == $value['openid']){
                    $data = 3;
                    $result = $data;
                    return json_encode($data);
                    exit();
                }
            }
            if($ptmaxed >= $ptordershare['pt_max']) {
                $data = 4;
                $result = $data;
                return json_encode($result);
               exit();
            }
            $ck = 2;
        } else {
            if($gwc == 1){
                $order_query=Db::table('ims_sudu8_page_pt_order')->where("openid",$openid)->where("flag",1)->where("ck",1)->where("uniacid",$uniacid)->select();
                foreach($order_query as $kk => $vv){
                    $share_order=Db::table("ims_sudu8_page_pt_share")->where("shareid",$vv['pt_order'])->where("uniacid",$uniacid)->find();
                    if($share_order['flag'] == 1 && $share_order['join_count'] < $share_order['pt_min']){
                        $or_json = unserialize($vv['jsondata']);
                        foreach($or_json as $k => $v){
                            if($v['pvid'] == $pvid){
                                $data = 5;
                                $result = $data;
                                return json_encode($result);
                                exit();
                            }
                        }
                    }
                }
            }
            $ptorder = 0;
            $ck = 1;
        }
        if ($gwc == 0) {
            $types = 2;
        } else {
            $types = 1;
        }
        $now = time();
        $order_id = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
        $userinfo = Db::table('ims_sudu8_page_user')->where('openid', $openid)->where('uniacid', $uniacid)->find();
        $uid = $userinfo['id'];


        $data = array(
            "uniacid" => $uniacid,
            "uid" => $uid,
            "openid" => $openid,
            "order_id" => $order_id,
            "jsondata" => serialize($jsdatass),
            "coupon" => $couponid,
            "creattime" => time(),
            "price" => $price,
            "flag" => 0,
            "jf" => $dkscore,
            "address" => $address,
            "liuyan" => $mjly,
            "nav" => $nav,
            "types" => $types,
            "pt_order" => $ptorder,
            "ck" => $ck
        );
        Db::table('ims_sudu8_page_pt_order')->insert($data);
        $result= $order_id;
        return json_encode($result);
    }
    // 获取对应独占预约的信息
    public function dopageDuzhan()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        $types = input("types");
        $pagedatekey = input("pagedatekey");
        $datys = input("days");
        $strtime = strtotime($datys);
        $arrs = Db::table('ims_sudu8_page_form_dd')->where('uniacid', $uniacid)->where('cid', $id)->where('types', $types)->where('datys', $strtime)->where('pagedatekey', $pagedatekey)->select();
        $arrdata = array();
        foreach ($arrs as $key => &$res) {
            array_push($arrdata, $res['arrkey']);
        }
        $result['data'] = $arrdata;
        return json_encode($result);
    }
    //更新会员信息
    public function dopageupdatehuiyuan()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $data = array(
            "realname" => input('myname'),
            "mobile" => input('mymobile'),
            "resideprovince" => input('provinceName'),
            "residecity" => input('cityName'),
            "residedist" => input('countyName'),
            "residecommunity" => input('detailInfo'),
            "birth" => input('birthday')
        );
        $res = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update($data);
    }
    // 更新手机号
    public function dopagemobilesetuser()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $mobile = input("mobile");
        $data = array(
            "mobile" => $mobile
        );
        $res = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->update($data);
    }
    // 获取优惠券开启设置
    public function doPagecouponset()
    {
        $uniacid = input("uniacid");
        $arrdata = Db::table('ims_sudu8_page_coupon_set')->where("uniacid", $uniacid)->find();
        $res['data'] = $arrdata;
        return json_encode($res);
    }
    public function doPagejiemi()
    {
        $uniacid = input("uniacid");
        $app = Db::table('applet')->where("id", $uniacid)->find();
        $appid = $app['appID'];
        $appsecret = $app['appSecret'];
        $code = input('code');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $weixin = file_get_contents($url);
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        $sessionKey = $array['session_key'];
        $encryptedData = input('encryptedData');
        $iv = input('iv');
        include "wxBizDataCrypt.php";
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);
        $arrdata = json_decode($data, TRUE);
        $tel = $arrdata['phoneNumber'];
        $result['data'] = $tel;
        return json_encode($result);
    }
    public function doPageBaseMin()
    {
        $uniacid = input("uniacid");
        $baseInfo = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field("name,base_tcolor,base_color,base_color2,base_color_t,tel,longitude,latitude,copyright,copyimg,tel_b,uniacid,tabbar_bg,tabbar_tc,tabbar,color_bar,tabbar_t,tabnum,config,tabbar_tca,color_bar,address,tabbar_new,tabnum_new")->find();
        $config = unserialize($baseInfo['config']);
        if (isset($config['commA'])) {
            $baseInfo['commA'] = $config['commA'];
        } else {
            $baseInfo['commA'] = 0;
        }
        if (isset($config['commAs'])) {
            $baseInfo['commAs'] = $config['commAs'];
        } else {
            $baseInfo['commAs'] = 0;
        }
        if (isset($config['commP'])) {
            $baseInfo['commP'] = $config['commP'];
        } else {
            $baseInfo['commP'] = 0;
        }
        if (isset($config['commPs'])) {
            $baseInfo['commPs'] = $config['commPs'];
        } else {
            $baseInfo['commPs'] = 0;
        }
        if (isset($config['serverBtn'])) {
            $baseInfo['serverBtn'] = $config['serverBtn'];
        } else {
            $baseInfo['serverBtn'] = 1;
        }
        $vs1 = input('vs1');
        if ($vs1) {
            $baseInfo['tabbar'] = unserialize($baseInfo['tabbar_new']);
            $baseInfo['tabnum'] = $baseInfo['tabnum_new'];
            for ($i = 0; $i < $baseInfo['tabnum']; $i++) {
                $baseInfo['tabbar'][$i] = unserialize($baseInfo['tabbar'][$i]);
                if ($baseInfo['tabbar'][$i]) {
                    if($baseInfo['tabbar'][$i]['tabbar'] == 1){
                        if(!empty($baseInfo['tabbar'][$i]['tabimginput_1'])){
                            $baseInfo['tabbar'][$i]['tabimginput_1'] = remote($uniacid,$baseInfo['tabbar'][$i]['tabimginput_1'],1);
                        }
                        if(!empty($baseInfo['tabbar'][$i]['tabimginput_2'])){
                            $baseInfo['tabbar'][$i]['tabimginput_2'] = remote($uniacid,$baseInfo['tabbar'][$i]['tabimginput_2'],1);
                        }
                    }
                    if ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "tel") {
                        $baseInfo['tabbar'][$i]['tabbar_type'] = "tel";
                    } elseif ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "map") {
                        $baseInfo['tabbar'][$i]['tabbar_type'] = "map";
                    } elseif ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "web") {
                        $baseInfo['tabbar'][$i]['tabbar_type'] = "web";
                    } elseif ($baseInfo['tabbar'][$i]['tabbar_linktype'] == "server") {
                        $baseInfo['tabbar'][$i]['tabbar_type'] = "server";
                    } else {
                        $baseInfo['tabbar'][$i]['tabbar_type'] = "Article";
                    }
                }
            }
        } else {
            $baseInfo['tabbar'] = unserialize($baseInfo['tabbar']);
            for ($i = 0; $i < count($baseInfo['tabbar']); $i++) {
                $baseInfo['tabbar'][$i] = unserialize($baseInfo['tabbar'][$i]);
                if (is_numeric($baseInfo['tabbar'][$i]['tabbar_l'])) {
                    $cate_type = Db::table('ims_sudu8_page_cate')->where("uniacid", $uniacid)->where("id", $baseInfo['tabbar'][$i]['tabbar_l'])->field("id,type,list_type")->find();
                    if ($cate_type['type'] == "page") {
                        $baseInfo['tabbar'][$i]['type'] = 'page';
                    }
                    if ($cate_type['list_type'] == 0 && $cate_type['type'] != "page") {
                        $baseInfo['tabbar'][$i]['type'] = 'listCate';
                    } elseif ($cate_type['list_type'] == 1 && $cate_type['type'] != "page") {
                        $baseInfo['tabbar'][$i]['type'] = 'list' . substr($cate_type['type'], 4, strlen($cate_type['type']));
                    }
                }
                if ($baseInfo['tabbar'][$i]['tabbar_l'] == "webpage") {
                    $baseInfo['tabbar'][$i]['tabbar_url'] = urlencode($baseInfo['tabbar'][$i]['tabbar_url']);
                }
            }
        }
        $res['data'] = $baseInfo;
        return json_encode($res);
    }
    //生成动态分享
    public function dopageshareewm()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $types = input("types");
        $frompage = input('frompage');
        // var_dump($frompage);
        // 先去找个人中心的二维码图片，如果存在直接取，否则去生成二维码
        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $app = Db::table('applet')->where('id', $uniacid)->find();
        $appid = $app['appID'];
        $appsecret = $app['appSecret'];
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
        $weixin = file_get_contents($url);
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        $access_token = $array['access_token'];//输出token
        $ewmurl = "https://api.weixin.qq.com/wxa/getwxacode?access_token=" . $access_token;
        if ($types == 1) {
            $sharepath = 'sudu8_page/index/index?fxsid=' . $openid;
        } else {
            $id = input('id');
            if ($frompage == "PT") {
                $sharepath = 'sudu8_page_plugin_pt/products/products?id=' . $id . "&fxsid=" . $openid;
            } else {
                $sharepath = 'sudu8_page/' . $frompage . '/' . $frompage . '?id=' . $id . "&fxsid=" . $openid;
            }
        }
        // var_dump($sharepath);exit;
        $data = array(
            "path" => $sharepath,
            "width" => '80'
        );
        $datas = json_encode($data);
        $result = $this->_Postrequest($ewmurl, $datas);
        $root = ROOT_PATH;
        $path = "public/image/{$uniacid}" . date('Ym');
        $newpath = $root . $path;
        $sjc = time() . rand(1000, 9999);
        if (!file_exists($newpath)) {
            mkdir($newpath);
        }
        file_put_contents($newpath . "/" . $uniacid . date('Ym') . $sjc . ".jpg", $result);
        $imgpath = ROOT_HOST . "/image/{$uniacid}" . date('Ym') . "/" . $uniacid . date('Ym') . $sjc . ".jpg";
        if (strpos($imgpath, 'https') === false) {
            $imgpath = "https" . substr($imgpath, 4);
        }
        Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where("openid", $openid)->update(array("ewm" => $imgpath));
        $results['data'] = $imgpath;
        return json_encode($results);
    }
    function _Postrequest($url, $data, $ssl = true)
    {
        //curl完成
        $curl = curl_init();
        //设置curl选项
        curl_setopt($curl, CURLOPT_URL, $url);//URL
        $user_agent = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
        curl_setopt($curl, CURLOPT_USERAGENT, $user_agent);//user_agent，请求代理信息
        curl_setopt($curl, CURLOPT_AUTOREFERER, true);//referer头，请求来源
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);//设置超时时间
        //SSL相关
        if ($ssl) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//禁用后cURL将终止从服务端进行验证
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);//检查服务器SSL证书中是否存在一个公用名(common name)。
        }
        // 处理post相关选项
        curl_setopt($curl, CURLOPT_POST, true);// 是否为POST请求
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);// 处理请求数据
        // 处理响应结果
        curl_setopt($curl, CURLOPT_HEADER, false);//是否处理响应头
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);//curl_exec()是否返回响应结果
        // 发出请求
        $response = curl_exec($curl);
        if (false === $response) {
            echo '<br>', curl_error($curl), '<br>';
            return false;
        }
        curl_close($curl);
        return $response;
    }
    public function dopageshareguiz()
    {
        $uniacid = input("uniacid");
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where('uniacid', $uniacid)->find();
        // $guiz['sq_thumb'] = remote($uniacid, $guiz['sq_thumb'], 1);
        // if (strpos($guiz['sq_thumb'], 'https') === false) {
        //     $neiw['data'] = "https" . substr($guiz['sq_thumb'], 4);
        // } else {
        //     $neiw['data'] = remote($uniacid, $guiz['sq_thumb'], 1);
        // }
        $neiw['data'] = remote($uniacid, $guiz['sq_thumb'], 1);
        return json_encode($neiw);
    }
    public function dopageupdatauserset()
    {
        $uniacid = input("uniacid");
        $items = Db::table('ims_sudu8_page_usercenter_set')->where('uniacid', $uniacid)->find();
        $usercenterset = unserialize($items['usercenterset']);
        // 先组装成选择显示的数据
        $arrs = array();
        for ($i = 1; $i <= 12; $i++) {
            if ($usercenterset['flag' . $i] == 2) {
                $jdata = array(
                    "title" => $usercenterset['title' . $i],
                    "thumb" => remote($uniacid, $usercenterset['thumb' . $i], 1),
                    "num" => $usercenterset['num' . $i],
                    "url" => $usercenterset['url' . $i]
                );
                array_push($arrs, $jdata);
            }
        }
        // 对数据进行排序
        $counts = count($arrs);
        $temps = "";
        for ($i = 0; $i < $counts - 1; $i++) {
            for ($j = 0; $j < $counts - 1 - $i; $j++) {
                if ($arrs[$j + 1]['num'] > $arrs[$j]['num']) {
                    $temps = $arrs[$j];
                    $arrs[$j] = $arrs[$j + 1];
                    $arrs[$j + 1] = $temps;
                }
            }
        }
        $result['data'] = $arrs;
        return json_encode($result);
    }
    // 获取团长优惠
    public function doPagepttuanzyh()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        // 获取成团规则
        $guiz = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $uniacid)->where('id', $id)->find();
        if($guiz['thumb']){
            $guiz['thumb'] = remote($uniacid,$guiz['thumb'],1);
        }
        $res['data'] = $guiz;
        return json_encode($res);
    }
    // 获取分销商规则
    public function doPagehuoqfxsgz()
    {
        $uniacid = input("uniacid");
        $guiz = Db::table('ims_sudu8_page_fx_gz')->where('uniacid', $uniacid)->find();
        $res['data'] = $guiz;
        return json_encode($res);
    }
    // 给我的上级积分了
    public function doPagegiveposcore()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $fxsid = input("fxsid");
        $id = input("id");
        $types = input("types");
        $today = strtotime(date("Y-m-d"), time());
        $end = $today + 60 * 60 * 24;
        $is_get = Db::table('ims_sudu8_page_pro_score_get')->where('uniacid', $uniacid)->where('pid', $id)->where('clickopenid', $openid)->where('creattime', 'gt', $today)->where('creattime', 'lt', $today)->find();
        if ($is_get) {
            exit;
        }
        if ($types != "PT") {
            $pro = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where('id', $id)->find();
        }
        // 开启了点击给上级积分规则
        if ($pro['get_share_gz'] == 1) {
            $score = $pro['get_share_score'];
            $num = $pro['get_share_num'];
            // 去判断今天获取的次数有没有达到上限
            $counts = Db::table('ims_sudu8_page_pro_score_get')->where('uniacid', $uniacid)->where('pid', $id)->where('openid', $fxsid)->where('creattime', 'gt', $today)->where('creattime', 'lt', $end)->count();
            if ($num > $counts) { //今天还可以继续获得
                // 获取分享者的信息
                $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $fxsid)->find();
                $newscore = $userinfo['score'] + $score;
                //再次点击将不能获取积分
                $has_click = Db::table('ims_sudu8_page_pro_score_get') ->where('uniacid', $uniacid) ->where('openid', $fxsid) ->where('clickopenid', $openid) ->where('pid', $id) ->where('creattime', 'gt', $today)->count();
                if($has_click > 0){
                    exit;
                }

                //给分享者加积分
                $res = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $fxsid)->update(array("score" => $newscore));
                // 插入今天的记录
                $data = array(
                    "uniacid" => $uniacid,
                    "openid" => $fxsid,
                    "clickopenid" => $openid,
                    "pid" => $id,
                    "types" => $types,
                    "score" => $score,
                    "creattime" => time()
                );
                Db::table('ims_sudu8_page_pro_score_get')->insert($data);
                // 更新积分流水记录
                $order_id = date("Y", time()) . date("m", time()) . date("d", time()) . date("H", time()) . date("i", time()) . date("s", time()) . rand(1000, 9999);
                $clickscore = array(
                    "uniacid" => $uniacid,
                    "orderid" => $order_id,
                    "uid" => $userinfo['id'],
                    "type" => "add",
                    "score" => $score,
                    "message" => "他人点击分享获取积分",
                    "creattime" => time()
                );
                if ($score > 0) {
                    Db::table('ims_sudu8_page_score')->insert($clickscore);
                }
            }
        }
    }
    // 获取我的积分流水记录
    public function doPagegetmyscorelist()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $time = strtotime("2018-05-07");
        $pindex = max(1, intval(input('page')));
        $psize = 10;
        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $counts = Db::table('ims_sudu8_page_score')->where('uniacid', $uniacid)->where('uid', $userinfo['id'])->where('creattime', 'gt', $time)->count();
        $list = Db::table('ims_sudu8_page_score')->where('uniacid', $uniacid)->where('uid', $userinfo['id'])->where('creattime', 'gt', $time)->order("creattime desc")->limit(($pindex - 1) * $psize, $psize)->select();
        foreach ($list as $key => &$res) {
            $res['creattime'] = date("Y-m-d H:i:s", $res['creattime']);
        }
        // 有没有下一页
        $show = $pindex * $psize;
        if ($show >= ($counts+$psize)) {  //没有下一页了
            $isover = 2;
        } else {
            $isover = 1;
        }
        $adata['isover'] = $isover;
        $adata['lists'] = $list;
        $result['data'] = $adata;
        return json_encode($result);
    }
    // 获取我的流水记录 180509
    public function dopagegetmymoneylist()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $time = strtotime("2018-05-07");
        $pindex = max(1, intval(input('page')));
        $psize = 10;
        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $counts = Db::table('ims_sudu8_page_money')->where('uniacid', $uniacid)->where('uid', $userinfo['id'])->where('creattime', "gt", $time)->count();
        $list = Db::table('ims_sudu8_page_money')->where('uniacid', $uniacid)->where('uid', $userinfo['id'])->where('creattime', "gt", $time)->order("creattime desc")->limit(($pindex - 1) * $psize, $psize)->select();
        foreach ($list as $key => &$res) {
            $res['creattime'] = date("Y-m-d H:i:s", $res['creattime']);
        }
        // 有没有下一页
        $show = $pindex * $psize;
        if ($show >= ($counts+$psize)) {  //没有下一页了
            $isover = 2;
        } else {
            $isover = 1;
        }
        $adata['isover'] = $isover;
        $adata['lists'] = $list;
        $result['data'] = $adata;
        return json_encode($result);
    }
    // 获取所有栏目
    public function dopageallCatep()
    {
        $uniacid = input("uniacid");
        $allcate = Db::table('ims_sudu8_page_cate')->where('uniacid', $uniacid)->where('cid', 0)->where('statue', 1)->order("num desc")->select();
        foreach ($allcate as $k => $v) {
            if ($v['type'] == "showArt" || $v['type'] == "showPic" || $v['type'] == "showWxapps") {
                $allcate[$k]['url'] = "/sudu8_page/listPic/listPic?cid=" . $v['id'];
            } else if ($v['type'] == "showPro") {
                $allcate[$k]['url'] = "/sudu8_page/listPro/listPro?cid=" . $v['id'];
            }
        }
        $allcate_son = Db::table('ims_sudu8_page_cate')->where('uniacid', $uniacid)->where('cid', $allcate[0]['id'])->where('statue', 1)->order("num desc")->select();
        $result['list'] = $allcate;
        $result['son'] = $allcate_son;
        $res['data'] = $result;
        return json_encode($res);
    }
    // 获取子栏目
    public function dopagegetcateson()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        $allcate_son = Db::table('ims_sudu8_page_cate')->where('uniacid', $uniacid)->where('cid', $id)->where('statue', 1)->order("num desc")->select();
        $result['data'] = $allcate_son;
        return json_encode($result);
    }
    public function doPageGetKuaiDi()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        $proinfo = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $uniacid)->where('id', $id)->field("kuaidi")->find();
        $result['data'] = $proinfo['kuaidi'];
        return json_encode($result);
    }
    public function doPagedosetmoney()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $yemoney = input('yemoney');
        $wxmoney = input('wxmoney');
        $uid = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        $ddata['uniacid'] = $uniacid;
        $ddata['orderid'] = input('orderid');
        $ddata['uid'] = $uid['id'];
        $ddata['type'] = "del";
        $ddata['creattime'] = time();
        if ($yemoney > 0) {
            $umoney = $uid['money'] - $yemoney;
            Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("money" => $umoney));
            $ddata['score'] = $yemoney;
            $ddata['message'] = "余额消费";
            Db::table('ims_sudu8_page_money')->insert($ddata);
        }
        if ($wxmoney > 0) {
            $ddata['score'] = $wxmoney;
            $ddata['message'] = "微信支付";
            Db::table('ims_sudu8_page_money')->insert($ddata);
        }
    }
    //开通vip
    public function doPageregisterVIP()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');

        $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->field("vipid")->find();
        if(!empty($userinfo)){
            $vipid = $userinfo['vipid'];
        }else{
            $userdata = array(
                 "uniacid" => $uniacid,
                 "openid" => $openid,
                 "createtime" => time()
                );
            Db::table('ims_sudu8_page_user')->insert($userdata);
            $vipid = "";
        }
        if (!$vipid) {
            $formId = input('formId');
            // 新增自定义表单数据接收
            if (input('pagedata') && input('pagedata') !== "NULL" && input('pagedata') !== "[]") {
                $forms = stripslashes(html_entity_decode(input('pagedata')));
                $forms = json_decode($forms, TRUE);
                $fmid = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find()['formid'];
                $formdata = array(
                    'uniacid' => $uniacid,
                    'openid' => $openid,
                    'creattime' => time(),
                    'val' => serialize($forms),
                    'flag' => 0,
                    'formid' => $formId,
                    'source' => "VIP申请",
                    'fid' => $fmid,
                );
                $fid = Db::table('ims_sudu8_page_formcon')->insertGetId($formdata);
            } else {
                $fid = 0;
            }
            $region = str_replace('-', '|', input('region'));
            $vipid = time() . '' . rand(100000, 999999);
            $data = array(
                'realname' => input('name'),
                'birth' => input('date'),
                'mobile' => input('phoneNumber'),
                'address' => $region . '|' . input('addressDetail')
            );
            $shenhe = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find()['shenhe']; //是否开启审核
            if ($shenhe == 2) {
                $data['vipid'] = $vipid;
                $data['vipcreatetime'] = time();
                $result = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update($data);
                $res = array();
                if (!$result) {
                    $res['data'] = 2;
                    return json_encode($res);
                } else {
                    $vipdata = array(
                        'openid' => $openid,
                        'uniacid' => $uniacid,
                        'vipid' => $vipid,
                        'fid' => $fid,
                        'formid' => $formId,
                        'flag' => 4,
                        'applytime' => date("Y-m-d H:i:s", time())
                    );
                    Db::table('ims_sudu8_page_vip_apply')->insert($vipdata);
                    $applet = Db::table('applet')->where("id", $uniacid)->field('appID,appSecret')->find();
                    if ($applet) {
                        $mid = Db::table('ims_sudu8_page_message')->where("uniacid", $uniacid)->where('flag', 8)->find();
                        if ($mid) {
                            if ($mid['mid'] != "") {
                                $mids = $mid['mid'];
                                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $applet['appID'] . "&secret=" . $applet['appSecret'];
                                $a_token = $this->_requestGetcurl($url);
                                if ($a_token) {
                                    $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $a_token['access_token'];
                                    $formId = input('formId');
                                    $ftitle = input("cardname");
                                    $ftime = date('Y-m-d H:i:s', time());
                                    $fvipid = $vipid;
                                    $openid = input('openid');
                                    $furl = $mid['url'];
                                    $frealname = input("name");
                                    $post_info = '{
                                                 "touser": "' . $openid . '",  
                                                 "template_id": "' . $mids . '", 
                                                 "page": "' . $furl . '",          
                                                 "form_id": "' . $formId . '",         
                                                 "data": {
                                                     "keyword1": {
                                                         "value": "' . $ftitle . '", 
                                                         "color": "#173177"
                                                     }, 
                                                     "keyword2": {
                                                         "value": "' . $vipid . '", 
                                                         "color": "#173177"
                                                     }, 
                                                     "keyword3": {
                                                         "value": "' . $ftime . '", 
                                                         "color": "#173177"
                                                     }, 
                                                     "keyword4": {
                                                         "value": "' . $frealname . '", 
                                                         "color": "#173177"
                                                     } 
                                                 },
                                                 "emphasis_keyword": "" 
                                               }';
                                    $this->_requestPost($url_m, $post_info);
                                }
                            }
                        }
                    }
                    $res['data'] = 3;
                    return json_encode($res);
                }
            } else {
                Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update($data);
                $vipdata = array(
                    'openid' => $openid,
                    'uniacid' => $uniacid,
                    'vipid' => $vipid,
                    'fid' => $fid,
                    'formid' => $formId,
                    'applytime' => date("Y-m-d H:i:s", time())
                );
                $res = Db::table('ims_sudu8_page_vip_apply')->insert($vipdata);
                $result = [];
                if ($res) {
                    $result['data'] = 1;
                    return json_encode($res);
                } else {
                    $result['data'] = 2;
                    return json_encode($res);
                }
            }
        }
    }
    //查看个人vip信息
    public function doPagegetVIPinfo()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        $info = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->field("realname,mobile,birth,address,vipid,vipcreatetime")->find();
        $info['address'] = str_replace('|', '', $info['address']);
        $info['year'] = date('Y', $info['vipcreatetime']);
        $info['month_day'] = date('m/d', $info['vipcreatetime']);
        $weeks = ['MON', 'TUE', 'WED', 'THUR', 'FRI', 'SAT', 'SUN'];
        $index = date('w', $info['vipcreatetime']);
        $info['week'] = $weeks[$index];
        $data['data'] = $info;
        return json_encode($data);
    }
    //检查会员卡设置
    public function doPagecheckvip()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        $kwd = input('kwd');
        $vipid = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->field("vipid")->find()['vipid'];
        $needvip = Db::table('ims_sudu8_page_vip_config')->where('uniacid', $uniacid)->field($kwd)->find()[$kwd];
        //不是会员  会员可进
        if (!$vipid && $needvip == 1) {
            $result['data'] = false;
            return json_encode($result);
            exit;
        }
        $result['data'] = true;
        return json_encode($result);
    }
    //获取商店列表
    public function doPageselectShopList()
    {
        $uniacid = input("uniacid");
        $option1 = input("option1");
        $option2 = input("option2");
        $option3 = input("option3");
        $le = input("latitude");
        $ne = input("longitude");
        $page = input('page');
        $sql = "select id,uniacid,name,logo,tel,address,(2 * 6378.137 * ASIN(SQRT(POW(SIN(PI()*(" . $le . "-latitude)/360),2)+COS(PI()*" . $le . "/180)* COS(latitude * PI()/180)*POW(SIN(PI()*(" . $ne . "-longitude)/360),2)))) as distance FROM  ims_sudu8_page_shops_shop WHERE uniacid = {$uniacid} and flag =1";
        if (!empty($option1) && ($option1 != '全部分类')) {
            $cid = Db::table('ims_sudu8_page_shops_cate')->where("uniacid", $uniacid)->where("name", $option1)->where("flag", 1)->field("id")->find()['id'];
            $sql .= ' and cid like "%' . $cid . '%"';
        }
        if ($option3 == '优选商家') {
            $sql .= ' and hot = 1';
        }
        if ($option2 == '综合排序') {
            $sql .= ' order by star desc';
        }
        if ($option2 == '距离最近') {
            $sql .= ' ORDER BY distance ASC';
        }
        $shop_size = Db::table('ims_sudu8_page_shops_set')->where("uniacid", $uniacid)->field("num")->find()['num'];
        // $sql .= ' LIMIT 0,'.$shop_size;
        $temp_lists = Db::query($sql);
        $count = count($temp_lists);
        // dump($count);

        if($page){
            $temp = ($page-1)*6;
            // if($temp < $count+1){
            //     $sql .= "$temp,$end";
            //     dump($temp);
            // }else{
            //     $result['data'] = array();
            //     return json_encode($result);
            // }
            if($temp < $count+1){
                $sql .= " LIMIT $temp,6";
            }else{
                $result['data'] = array();
                return json_encode($result);
            }
            
        }else{
            $sql .= ' LIMIT 0,6 ';
        }
        // $sql .= ' LIMIT 0,6 ';
        $lists = Db::query($sql);
        // var_dump($sql);
        // var_dump($options);
        foreach ($lists as $key => &$res) {
            $res['logo'] = remote($uniacid, $res['logo'], 1);
            $res['distance'] = $this->beautifyDistance($res['distance']);
        }
        $result['data'] = $lists;
        return json_encode($result);
    }
    public function beautifyDistance($distance)
    {
        if ($distance < 1) {
            $distance = number_format(floatval($distance) * 1000, 2);
            return "{$distance}m";
        } else {
            $d = number_format(floatval($distance), 2);
            return "{$d}km";
        }
    }
    public function doPagestorelist()
    {
        $uniacid = input("uniacid");
        $store['catelist'] = Db::table('ims_sudu8_page_shops_cate')->where("uniacid", $uniacid)->where("flag", 0)->order("num desc")->select();
        $tjnum = Db::table('ims_sudu8_page_shops_set')->where("uniacid", $uniacid)->field("tjnum")->find()['tjnum'];
        $store['storeHot'] = Db::table('ims_sudu8_page_shops_shop')->where('uniacid', $uniacid)->where("hot", 1)->where("flag", 1)->order("id DESC")->field("id,uniacid,name,logo,hot")->limit(0, $tjnum)->select();
        $num2 = count($store['storeHot']);
        for ($i = 0; $i < $num2; $i++) {
            if (stristr($store['storeHot'][$i]['logo'], 'http')) {
                $store['storeHot'][$i]['logo'] = $store['storeHot'][$i]['logo'];
            } else {
                $store['storeHot'][$i]['logo'] = remote($uniacid, $store['storeHot'][$i]['logo'], 1);
            }
        }
        $result['data'] = $store;
        return json_encode($result);
    }
    public function doPageShowstore_W()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        $store = Db::table('ims_sudu8_page_shops_shop')->where("uniacid", $uniacid)->where("id", $id)->order("id desc")->find();
        if (stristr($store['logo'], 'http')) {
            $store['logo'] = $store['logo'];
        } else {
            $store['logo'] = remote($uniacid, $store['logo'], 1);
        }
        if (stristr($store['bg'], 'http')) {
            $store['bg'] = $store['bg'];
        } else {
            $store['bg'] = remote($uniacid, $store['bg'], 1);
        }
        if($store['images']){
            $newimgs = array();
        $imgs = unserialize($store['images']);
        foreach ($imgs as $key => &$res) {
            if (stristr($res, 'http')) {
                $newimgs[] = $res;
            } else {
                $newimgs[] = remote($uniacid, $res, 1);
            }
        }
            $store['text'] = $newimgs;
        }
        $goods = Db::table('ims_sudu8_page_shops_goods')->where("uniacid", $uniacid)->where("flag", 1)->where("sid", $id)->where("status", 1)->order("num desc")->select();
        foreach ($goods as $key => &$value) {
            if (stristr($value['thumb'], 'http')) {
                $value['thumb'] = $value['thumb'];
            } else {
                $value['thumb'] = remote($uniacid, $value['thumb'], 1);
            }
        }
        $store['goods'] = $goods;
        $result['data'] = $store;
        return json_encode($result);
    }
    //商品生成订单页面
    // public function doPageDingd(){
    //  $uniacid = input("uniacid");
    //  $id = input("id");
    //  $openid = input("openid");
    //  $flags = true;
    //  //获得用户信息
    //  $user = Db::table('ims_sudu8_page_user')->where("openid",$openid)->where("uniacid",$uniacid)->find();
    //  //获得商品信息
    //  $pro = Db::table('ims_sudu8_page_products')->where("id",$id)->where("uniacid",$uniacid)->find();
    //  if($pro['more_type_num']){
    //      $more_type_num = unserialize($pro['more_type_num']);
    //  }
    //  if($pro['is_more']=="1" or $pro['is_more']== 1 ){    //多规格产品处理
    //      $num = input("num");
    //      $newnum = explode(',',substr($num, 1,strlen($num)-2));
    //      $numarr = array();
    //      foreach ($newnum as $rec) {
    //                $nnn = explode(':',$rec);
    //                $numarr[] = $nnn[1];
    //            }
    //      $guig = unserialize($pro['more_type_x']);
    //      foreach ($guig as $key => &$rec) {
    //          $rec[] = $numarr[$key];
    //      }
    //      $newgg =  serialize($guig);
    //      $order = input("order");
    //      if($order){
    //          $order = input("order");
    //      }else{
    //          $now = time();
    //          $order = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
    //      }
    //      // $cydat = $_GPC['chuydate']." ".$_GPC['chuytime'];
    //      // $zzcy = strtotime($cydat);
    //      $overtime = time() + 30*60;
    //      $data = array(
    //          "uniacid" => input("uniacid"),
    //          "order_id" => $order,
    //          "uid" => $user['id'],
    //          "openid" =>input("openid"),
    //          "pid" => input("id"),
    //          "thumb"=>$pro['thumb'],
    //          "product"=>$pro['title'],
    //          "yhq" => input("youhui"),
    //          "true_price" => input("zhifu"),
    //          "creattime" =>time(),
    //          "flag"=>0,
    //          "pro_user_name"=>input("pro_name")['pro_name'],
    //          "pro_user_tel"=>input("pro_tel"),
    //          "pro_user_add"=>input("pro_address"),
    //          "pro_user_txt"=>input("pro_txt"),
    //          "overtime"=>$overtime,
    //          "is_more"=>1,
    //          "order_duo"=>$newgg,
    //          "coupon"=>input("yhqid"),
    //      );
    //      // 新增自定义表单数据接收
    //      if($pagedata && $pagedata!=="NULL"){
    //          $forms = stripslashes(html_entity_decode($pagedata));
    //          $forms = json_decode($forms,TRUE);
    //          $data['beizhu_val'] = serialize($forms);
    //      }
    //      // echo "<pre>";
    //      // var_dump($data);
    //      // echo "</pre>";
    //      // die();
    //      if($order){
    //          // die();
    //          $res = Db::table('ims_sudu8_page_order')->where("order_id",$order)->where("uniacid",$uniacid)->update($data);
    //          //var_dump("11--");
    //          //var_dump($res);
    //      }else{
    //          // die();
    //          $res = Db::table('ims_sudu8_page_order')->insert($data);
    //          //var_dump("22--");
    //          //var_dump($res);
    //      }
    //      if($res){
    //          $data['success'] = 1;
    //          $data['xg'] = $pro['pro_xz'];
    //          $result['data'] = $data;
    //          return json_encode($result);
    //      }
    //  }
    //  //20170925  新增我的购买量
    //  $openid = input("openid");
    //  $pid = $orders['pid'];
    //  $myorders = Db::table('ims_sudu8_page_order')->where("pid",$pid)->where("openid",$openid)->where("uniacid",$uniacid)->where("flag",">=",0)->select();
    //  // pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :pid and openid = :openid and uniacid = :uniacid and flag>=0" , array(':pid' => $pid ,':openid' => $openid ,':uniacid' => $uniacid));
    //  $my_num = 0;
    //  if($myorders){
    //      foreach ($myorders as $res) {
    //          $my_num+= $res['num'];
    //      }
    //  }
    //  //1.生成订单之前再判断次该商品有没有下架及库存剩余量
    //  $num = input("count");
    //  $orderid = input("order");
    //  if(!$orderid){                              //新下单的情况
    //      if($pro['pro_kc']==-1){                 //不限库存
    //          $flags = true;
    //          $syl = $pro['pro_kc'];
    //      }else{                                  //限制库存
    //          if($pro['pro_kc']+$my_num == 0){    //库存为空
    //              $syl = 0;
    //              $flags = false;
    //          }
    //              if( $pro['pro_kc']+$my_num !=0 ){   //库存不为空
    //                  if($pro['pro_xz']==0){          //限量不限购
    //                      if($num > $pro['pro_kc']){
    //                      $syl = $pro['pro_kc'];
    //                      $flags = false;
    //                  }
    //                  }else{                          //限量又限购
    //                      if($my_num + $num > $pro['pro_xz'] || $num > $pro['pro_kc']){
    //                      $syl = $pro['pro_kc'];
    //                      $flags = false;
    //                  }
    //                  }
    //          }
    //      }
    //  }else{
    //      $oinfo = Db::table('ims_sudu8_page_order')->where("order_id",$order)->where("uniacid",$uniacid)->field("num,uniacid,order_id")->find();
    //      // pdo_fetch("SELECT num,uniacid,order_id FROM ".tablename('sudu8_page_order')." WHERE order_id = :order and uniacid = :uniacid" , array(':order' => $orderid ,':uniacid' => $uniacid));
    //      $ddnum = $oinfo['num'];
    //      if($pro['pro_kc']==-1){   //不限库存
    //          $flags = true;
    //          $syl = $pro['pro_kc'];
    //      }else{
    //          $cha = $ddnum - $num;  //订单号里面的数值相差几个
    //          $new_num = $my_num - $cha;  //获得现在新提交数
    //          if($new_num < 0){   //又增加了购买量
    //              $absnum = abs($new_num);
    //              if( $my_num + $absnum > $pro['pro_xz'] || $absnum > $pro['pro_kc']){
    //                  $syl = $pro['pro_kc'];
    //                  $flags = false;
    //              }
    //          }else{
    //              $flags = true;
    //          }
    //      }
    //  }
    //  if($flags && $pro['pro_kc']>=0){    //限制库存 且有库存剩余
    //      if($order){
    //          $order = input("order");
    //          //修改订单的时候商品总数变化
    //          $oinfo = Db::table('ims_sudu8_page_order')->where("order_id",$order_id)->where("uniacid",$uniacid)->find();
    //          // pdo_fetch("SELECT num,uniacid,order_id FROM ".tablename('sudu8_page_order')." WHERE order_id = :order and uniacid = :uniacid" , array(':order' => $order ,':uniacid' => $uniacid));
    //          $onum = $oinfo['num'];
    //          $newnum = $num - $onum;
    //          $ndata['pro_kc'] = $pro['pro_kc'] - $newnum;
    //          Db::table('ims_sudu8_page_products')->where("id",$id)->where("uniacid",$uniacid)->update($ndata);
    //      }else{
    //          $now = time();
    //          $order = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
    //          //新下单的同时立即把商品数量减去
    //          $ndata['pro_kc'] = $pro['pro_kc'] - $num;
    //          Db::table('ims_sudu8_page_products')->where("id",$id)->where("uniacid",$uniacid)->update($ndata);
    //      }
    //      $overtime = time() + 30*60;
    //      $data = array(
    //          "uniacid" => input("uniacid"),
    //          "order_id" => $order,
    //          "uid" => $user['id'],
    //          "openid" =>input("openid"),
    //          "pid" => input("id"),
    //          "thumb"=>$pro['thumb'],
    //          "product"=>$pro['title'],
    //          "price" => input("price"),
    //          "num" => input("count")['count'],
    //          "yhq" => input("youhui"),
    //          "true_price" => input("zhifu"),
    //          "creattime" =>time(),
    //          "flag"=>0,
    //          "pro_user_name"=>input("pro_name"),
    //          "pro_user_tel"=>input("pro_tel"),
    //          "pro_user_add"=>input("pro_address"),
    //          "pro_user_txt"=>input("pro_txt"),
    //          "overtime"=>$overtime,
    //          "coupon"=>input("yhqid")
    //      );
    //      // 新增自定义表单数据接收
    //      if($pagedata]&& $pagedata=="NULL"){
    //          $forms = stripslashes(html_entity_decode($pagedata));
    //          $forms = json_decode($forms,TRUE);
    //          $data['beizhu_val'] = serialize($forms);
    //      }
    //      if($order){
    //          $res = Db::table('ims_sudu8_page_order')->where("order_id",$order)->where("uniacid",$uniacid)->update($data);
    //      }else{
    //          $res = Db::table('ims_sudu8_page_order')->insert($data);
    //      }
    //      if($res){
    //          $data['success'] = 1;
    //          $data['xg'] = $pro['pro_xz'];
    //          $result['data'] = $data;
    //          return json_encode($result);
    //      }
    //  }
    //  if($flags && $pro['pro_kc']<0){    //不限制库存
    //      if($order){
    //          $order = input("order");
    //      }else{
    //          $now = time();
    //          $order = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
    //      }
    //      $overtime = time() + 30*60;
    //      $data = array(
    //          "uniacid" => input("uniacid"),
    //          "order_id" => $order,
    //          "uid" => $user['id'],
    //          "openid" =>input("openid"),
    //          "pid" => input("id"),
    //          "thumb"=>$pro['thumb'],
    //          "product"=>$pro['title'],
    //          "price" => input("price"),
    //          "num" => input("count"),
    //          "yhq" => input("youhui"),
    //          "true_price" => input("zhifu"),
    //          "creattime" =>time(),
    //          "flag"=>0,
    //          "pro_user_name"=>input("pro_name"),
    //          "pro_user_tel"=>input("pro_tel"),
    //          "pro_user_add"=>input("pro_address"),
    //          "pro_user_txt"=>input("pro_txt"),
    //          "overtime"=>$overtime,
    //          "coupon"=>input("yhqid")
    //      );
    //      // 新增自定义表单数据接收
    //      if($pagedata] && $pagedata!=="NULL"){
    //          $forms = stripslashes(html_entity_decode($pagedata));
    //          $forms = json_decode($forms,TRUE);
    //          $data['beizhu_val'] = serialize($forms);
    //      }
    //      if($order]){
    //          $res = Db::table('ims_sudu8_page_order')->where("order_id",$order)->where("uniacid",$uniacid)->update($data);
    //      }else{
    //          $res = Db::table('ims_sudu8_page_order')->insert($data);
    //      }
    //      if($res){
    //          $data['success'] = 1;
    //          $data['xg'] = $pro['pro_xz'];
    //          $result['data'] = $data;
    //          return json_encode($result);
    //      }
    //  }
    //  if(!$flags){
    //      $data['success'] = 0;
    //      $data['syl'] = $syl;
    //      $data['id'] = $id;
    //      $result['data'] = $data;
    //      return json_encode($result);
    //  }
    // }
    //新增评价功能 18.02.22
    public function doPageComment()
    {
        $uniacid = input("uniacid");
        $id = intval(input("id"));
        $pinglun_t = input("pinglun_t");
        $openid = input("openid");
        $data = array(
            'aid' => $id,
            'text' => $pinglun_t,
            'openid' => $openid,
            'uniacid' => $uniacid,
            'createtime' => time()
        );
        $result = Db::table('ims_sudu8_page_comment')->insert($data);
        if ($result == 1) {
            return json_encode(array('result' => 1));
        } else {
            return json_encode(array('result' => 2));
        }
    }
    //页面加载时获取文章id全部评论
    public function doPagecommentFollow()
    {
        $uniacid = input("uniacid");
        $id = intval(input("id"));
        $follow = Db::table('ims_sudu8_page_comment')->where("uniacid", $uniacid)->where("id", $id)->field("id,follow")->find();
        $follow = intval($follow['follow']) + 1;
        $data = array(
            'id' => $id,
            'follow' => $follow,
        );
        $result = Db::table('ims_sudu8_page_comment')->where("id", $id)->update($data);
        return json_encode(array('result' => 1));
    }
    public function doPageGetComment()
    {
        $uniacid = input("uniacid");
        $id = intval(input("id"));
        $flag = intval(input("comms"));
        if ($flag == 1) {
            $comment = Db::table('ims_sudu8_page_comment')->alias('a')->join('ims_sudu8_page_user b', 'a.openid = b.openid and a.uniacid = b.uniacid', 'left')->where("a.uniacid", $uniacid)->where("a.aid", $id)->where("a.flag", 1)->order("a.follow desc,a.id desc")->field("a.id,a.text,a.createtime,a.follow,b.avatar,b.nickname")->select();
            // pdo_fetchAll("SELECT distinct  a.id,a.text,a.createtime,a.follow,b.avatar,b.nickname FROM ".tablename('sudu8_page_comment')." as a LEFT JOIN ".tablename('sudu8_page_user')." as b on a.openid = b.openid and a.uniacid = b.uniacid WHERE a.uniacid = :uniacid and a.aid = :id and a.flag = 1 order by a.follow desc,a.id desc" , array(':uniacid' => $uniacid,':id' => $id));
        } else {
            $comment = Db::table('ims_sudu8_page_comment')->alias('a')->join('ims_sudu8_page_user b', 'a.openid = b.openid and a.uniacid = b.uniacid', 'left')->where("a.uniacid", $uniacid)->where("a.aid", $id)->where("a.flag", 'neq', 2)->order("a.follow desc, a.id desc")->field("a.id,a.text,a.createtime,a.follow,b.avatar,b.nickname")->select();
        }
        if ($comment) {
            foreach ($comment as $k => $v) {
                $comment[$k]['ctime'] = date('Y年m月d日 H:i:s', $v['createtime']);
            }
        }
        $result['data'] = $comment;
        return json_encode($result);
    }
    public function doPagegetslide_m()
    {
        $uniacid = input("uniacid");
        $set = Db::table('ims_sudu8_page_shops_set')->where("uniacid", $uniacid)->find();
        if (stristr($set['bg'], 'http')) {
            $set['bg'] = $set['bg'];
        } else {
            $set['bg'] = remote($uniacid, $set['bg'], 1);
        }
        $set['system_name'] = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field('name')->find()['name'];
        $set['category'] = Db::table('ims_sudu8_page_shops_cate')->where("uniacid", $uniacid)->field("id,name")->select();
        $result['data'] = $set;
        return json_encode($result);
    }
    //$_W怎么变换
    public function doPageis_apply()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $shop = Db::table('ims_sudu8_page_shops_shop')->where(["uniacid" => $uniacid, "openid" => $openid])->find();
        if (!empty($shop) && $shop['status'] == '2') {
            Db::table('ims_sudu8_page_shops_shop')->where("uniacid", $uniacid)->delete();
            return json_encode(array('is_apply' => 3));
        } else if (!empty($shop) && $shop['status'] == '1') {
            $data = array(
                'username' => $shop['username'],
                'password' => $shop['password'],
                'url' => ROOT_HOST . '/index/login/bizlogin.html',
            );
            return json_encode(array('is_apply' => 2, 'data' => $data));
        } else if (!empty($shop) && $shop['status'] == '0') {
            return json_encode(array('is_apply' => 1));
        } else {
            return json_encode(array('is_apply' => 0));
        }
    }
    //上传图片不知道怎么改
    public function doPageuploadImg()
    {
        $uniacid = input("uniacid");
        load()->func('file');
        dump($_FILES['file']);
        die;
        // exit;
        // if($_W['setting']['remote']['type'] == 0){
        //   $path = file_upload($_FILES['file']);
        //   $path = $path['path'];
        // }else{
        //   $path = file_upload($_FILES['file']);
        //   $rpath = $path['path'];
        //   $path = file_remote_upload($rpath,false);
        //   $path = $_W['attachurl_remote'].$rpath;
        // }
        // if(strpos($path,'http')===false){
        //   $path = remote($uniacid,$path,1);
        // }
        $result['data'] = $path;
        return json_encode($result);
    }
    public function doPageshopApply()
    {
        $uniacid = input("uniacid");
        $formdata = htmlspecialchars_decode(input("formdata"));
        $formdata = json_decode($formdata, true);
        $formdata['uniacid'] = $uniacid;
        $formdata['createtime'] = time();
        $latlong = explode(',', $formdata['latlong']);
        unset($formdata['latlong']);
        $formdata['latitude'] = $latlong[0];
        $formdata['longitude'] = $latlong[1];
        $data = Db::table('ims_sudu8_page_shops_shop')->insert($formdata);
        if ($data > 0) {
            $result['data'] = $data;
            return json_encode($result);
        }
    }
    public function doPageshowPro_W()
    {
        $uniacid = input("uniacid");
        $id = intval(input("id"));
        $pro = DB::table('ims_sudu8_page_shops_goods')->where("uniacid", $uniacid)->where("id", $id)->find();
        $data = array(
            'pageview' => $pro['pageview'] + 1,
        );
        DB::table('ims_sudu8_page_shops_goods')->where("uniacid", $uniacid)->where("id", $id)->update($data);
        $pro['images'] = unserialize($pro['images']);
        $num = count($pro['images']);
        for ($i = 0; $i < $num; $i++) {
            if (stristr($pro['images'][$i], 'http')) {
                $pro['images'][$i] = $pro['images'][$i];
            } else {
                $pro['images'][$i] = remote($uniacid, $pro['images'][$i], 1);
            }
        }
        if (stristr($pro['thumb'], 'http')) {
            $pro['thumb'] = $pro['thumb'];
        } else {
            $pro['thumb'] = remote($uniacid, $pro['thumb'], 1);
        }
        $openid = input("openid");
        //判断我又没有收藏过
        $collectcount = 0;
        if ($openid) {
            $user = DB::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
            $uid = $user['id'];
            $collect = Db::table('ims_sudu8_page_collect')->where("uniacid", $uniacid)->where("uid", $uid)->where("type", 'shopsPro')->where("cid", $id)->count();
            if ($collect) {
                $collectcount = 1;
            }
        }
        $pro['collectcount'] = $collectcount;
        $result['data'] = $pro;
        return json_encode($result);
    }
    //生成订单
    public function doPageDingd_W()
    {
        $uniacid = input("uniacid");
        $id = input("id");
        $openid = input("openid");
        $flags = true;
        //获得用户信息
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        //获得商品信息
        $pro = Db::table('ims_sudu8_page_shops_goods')->where("uniacid", $uniacid)->where("id", $id)->find();
        $count = input("count");
        $storage = $pro['storage'];
        // dump($pro);die;
        if ($count > $storage || $pro['flag'] == '0') {
            $flags = false;
        }
        if ($flags) {
            if (input("order") != '') {
                $order = input("order");
                //修改订单的时候商品总数变化
                $oinfo = Db::table('ims_sudu8_page_duo_products_order')->where("order_id", $order)->where("uniacid", $uniacid)->find();
                $detail = unserialize($oinfo['jsondata']);
                $newnum = $count - $detail['num'];
                $ndata['storage'] = $pro['storage'] - $newnum;
                Db::table('ims_sudu8_page_shops_goods')->where("id", $id)->where("uniacid", $uniacid)->update($ndata);
            } else {
                $now = time();
                $order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
                // dump($order);die;
                //新下单的同时立即把商品数量减去
                $ndata['storage'] = $pro['storage'] - $count;
                Db::table('ims_sudu8_page_shops_goods')->where("id", $id)->where("uniacid", $uniacid)->update($ndata);
            }
            $sid = Db::table('ims_sudu8_page_shops_goods')->where("uniacid", $uniacid)->where("id", $id)->find()['sid'];
            $jsondata[0] = array(
                'is_from_shops' => true,
                'creattime' => time(),
                'uniacid' => $uniacid,
                'uid' => $user['id'],
                'num' => $count,
            );
            $jsondata[0]['proinfo'] = Db::table('ims_sudu8_page_shops_goods')->where("uniacid", $uniacid)->where("id", $id)->field("id,sid,title,pageview,rsales,sellprice,marketprice,storage,thumb")->find();
            $jsondata[0]['pid'] = $jsondata[0]['proinfo']['id'];
            if (stristr($jsondata[0]['proinfo']['thumb'], 'http')) {
                $jsondata[0]['proinfo']['thumb'] = $jsondata[0]['proinfo']['thumb'];
            } else {
                $jsondata[0]['proinfo']['thumb'] = remote($uniacid, $jsondata[0]['proinfo']['thumb'], 1);
            }
            $jsondata[0]['proinfo']['pid'] = $jsondata[0]['proinfo']['id'];
            unset($jsondata[0]['proinfo']['id']);
            $jsondata[0]['proinfo']['kc'] = $jsondata[0]['proinfo']['storage'];
            unset($jsondata[0]['proinfo']['storage']);
            $jsondata[0]['proinfo']['price'] = $jsondata[0]['proinfo']['sellprice'];
            unset($jsondata[0]['proinfo']['sellprice']);
            $jsondata[0]['baseinfo'] = array(
                'id' => $jsondata[0]['proinfo']['pid'],
                'title' => $jsondata[0]['proinfo']['title']
            );
            unset($jsondata[0]['proinfo']['title']);
            if (stristr($jsondata[0]['proinfo']['thumb'], 'http')) {
                $jsondata[0]['baseinfo']['thumb'] = $jsondata[0]['proinfo']['thumb'];
                $jsondata[0]['proinfo']['thumb'] = $jsondata[0]['proinfo']['thumb'];
            } else {
                $jsondata[0]['baseinfo']['thumb'] = remote($uniacid, $jsondata[0]['proinfo']['thumb'], 1);
                $jsondata[0]['proinfo']['thumb'] = remote($uniacid, $jsondata[0]['proinfo']['thumb'], 1);
            }
            $m_address['address'] = input("pro_address");
            $m_address['name'] = input("pro_name");
            $m_address['mobile'] = input("pro_tel");
            // dump($order);die;
            $data = array(
                "order_id" => $order,
                "uid" => $user['id'],
                "openid" => input("openid"),
                'sid' => $sid,
                'price' => input("zhifu"),
                'jsondata' => serialize($jsondata),
                'coupon' => input("yhqid"),
                'jf' => 0,
                'address' => 0,
                'm_address' => serialize($m_address),
                'liuyan' => input("pro_txt"),
            );
            if (input('order')) {
                $res = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where("uid", $user['id'])->update($data);
            } else {
                $data['uniacid'] = $uniacid;
                $data['flag'] = 0;
                $data['creattime'] = time();
                $res = Db::table('ims_sudu8_page_duo_products_order')->insert($data);
            }
            if ($res) {
                $data['success'] = 1;
                $result['data'] = $data;
                return json_encode($result);
            }
        }
        if (!$flags) {
            $data['success'] = 0;
            $data['syl'] = $storage;
            $data['id'] = $id;
            $result['data'] = $data;
            return json_encode($result);
        }
    }
    //支付
    public function doPagezhifu_W()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $money = input("money");
        $types = input("types");
        $order_id = input("order_id");
        $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        $data = array(
            'uniacid' => $uniacid,
            'orderid' => $order_id,
            'uid' => $userinfo['id'],
            'score' => $money,
            'creattime' => time()
        );
        // if($types == '0') $data['type'] = 'add';
        if ($types == '1') {
            $data['type'] = 'del';
            $data['message'] = '消费';
        }
        Db::table('ims_sudu8_page_money')->insert($data);
        $app = Db::table('applet')->where('id', $uniacid)->find();
        include 'WeixinPay.php';
        $appid = $app['appID'];
        $openid = $openid;
        $mch_id = $app['mchid'];
        $key = $app['signkey'];
        $out_trade_no = $order_id; //订单号
        $body = "账户充值";
        $total_fee = $money * 100;
        if (isset($app['identity'])) {
            $identity = $app['identity'];
        } else {
            $identity = 1;
        }
        if (isset($app['sub_mchid'])) {
            $sub_mchid = $app['sub_mchid'];
        } else {
            $sub_mchid = 0;
        }
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee, $identity, $sub_mchid);
        $return = $weixinpay->pay();
        $return['order_id'] = $order_id;
        $adata['data'] = $return;
        $adata['message'] = "success";
        return json_encode($adata);
    }
    //支付成功
    public function doPagezhifuSuccess_W()
    {
        $uniacid = input("uniacid");
        $order_id = input("order_id");
        $data = array(
            "flag" => 1
        );
        $res = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('order_id', $order_id)->update($data);
        $result['data'] = $res;
        return json_encode($result);
    }
    //满减优惠
    public function doPgaegetmoneyoff()
    {
        $uniacid = input("uniacid");
        $moneyoff = Db::table('ims_sudu8_page_moneyoff')->where("uniacid", $uniacid)->order("reach asc")->select();
        $result['data'] = $moneyoff;
        return json_encode($result);
    }
    //支付之前（所有订单公用接口）
    public function dopagebeforepay()
    {
        $uniacid = input("uniacid");
        $types = input("types");
        if ($types == 'duo') {
            $order_id = input("order_id");
            $order = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where("order_id", $order_id)->find();
            $price = round(floatval($order['price']), 2);
            $payprice = round(floatval($order['payprice']), 2);
            $gpc_price = floatval(input("price"));
            $openid = input("openid");
            $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
            $yue = floatval($user['money']);
            if ($price == $gpc_price && $price > $yue && round($price - $yue, 2) . '' == $payprice . '') {
                //支付之前处理过期的优惠券
                $this->overtimeyhq($uniacid, $user['id']);
                //支付之前判断下优惠券有没有在其他地方使用或者过期
                if ($order['coupon'] != 0) {
                    $coupon = Db::table('ims_sudu8_page_coupon_user')->where("uniacid", $uniacid)->where("id", $order['coupon'])->find();
                    $couponinfo = Db::table('ims_sudu8_page_coupon')->where("uniacid", $uniacid)->where("id", $coupon['cid'])->find();
                    if ($coupon['flag'] == 1) {
                        $this->checkthisyhq($uniacid, $order_id, $order['price'], $couponinfo['price'], $types);
                        $data = array(
                            'err' => 2,
                            'message' => '该优惠券已被使用'
                        );
                        $result['data'] = $data;
                        return json_encode($result);
                        exit;
                    }
                    if ($coupon['flag'] == 2) {
                        $this->checkthisyhq($uniacid, $order_id, $order['price'], $couponinfo['price'], $types);
                        $data = array(
                            'err' => 3,
                            'message' => '该优惠劵已过期'
                        );
                        $result['data'] = $data;
                        return json_encode($result);
                        exit;
                    }
                }
                //支付前判断库存
                $jsondata = unserialize($order['jsondata']);
                foreach ($jsondata as $key => &$value) {
                    $kc = Db::table('ims_sudu8_page_duo_products_type_value')->where("id", $value['proinfo']['id'])->find();
                    if ($value['num'] > $kc['kc']) {
                        $message = $value['baseinfo']['title'] . "(" . chop($value['proinfo']['ggz'], ',') . ")库存不足";
                        $data = array(
                            'message' => $message,
                            'err' => 4
                        );
                        $result['data'] = $data;
                        return json_encode($result);
                        exit;
                    }
                }
                $body = "商品支付";
                $weixinpay = $this->getweixinpayinfo($uniacid, $openid, $order_id, $payprice, $body, $types . "|" . input('formId') . "|" . $uniacid);  //最后一个参数为附加参数，这里存订单类型+formId
                $weixinpay['err'] = 0;
                $result['data'] = $weixinpay;
                return json_encode($result);
                exit;
            }
            $data = array(
                'err' => 1,
                'message' => '价格出错',
            );
            $result['data'] = $data;
            return json_encode($result);
        }
        if($types == "miaosha"){
            $order_id = input("order_id");
            //$order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "order_id"=>$order_id));
            $order = Db::table('ims_sudu8_page_order') ->where('uniacid', $uniacid) ->where('order_id', $order_id) ->find();
            $price = floatval($order['true_price']);
            $pay_price = floatval($order['pay_price']);
            $gpc_price = floatval(input("price"));
            $openid = input("openid");
            //$user = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "openid"=>$openid));
            $user = Db::table('ims_sudu8_page_user') ->where('uniacid', $uniacid) ->where('openid', $openid) ->find();
            $yue = floatval($user['money']);
            if($price == $gpc_price && $price > $yue && round($price - $yue, 2).'' == $pay_price.''){
                //支付之前处理过期的优惠券
                $this->overtimeyhq($uniacid, $user['id']);
                //支付之前判断下优惠券有没有在其他地方使用或者过期
                if($order['coupon'] != 0){
                    // $coupon = pdo_get("sudu8_page_coupon_user", array("uniacid"=>$uniacid, "id"=>$order['coupon']));
                    // $couponinfo = pdo_get("sudu8_page_coupon", array("uniacid"=>$uniacid, "id"=>$coupon['cid']));
                    $coupon = Db::table('ims_sudu8_page_coupon_user')->where("uniacid", $uniacid)->where("id", $order['coupon'])->find();
                    $couponinfo = Db::table('ims_sudu8_page_coupon')->where("uniacid", $uniacid)->where("id", $coupon['cid'])->find();
                    if($coupon['flag'] == 1){
                        $data['data'] = array('err' => 2, 'message' => '该优惠券已被使用');
                        return json_encode($data);
                        // return $this->result(0, 'success', array('err' => 2, 'message' => '该优惠券已被使用'));
                    }
                    if($coupon['flag'] == 2){
                        $data['data'] = array('err' => 3, 'message' => '该优惠券已过期');
                        return json_encode($data);
                        // return $this->result(0, 'success', array('err' => 3, 'message' => '该优惠券已过期'));
                    }
                }
                //获取微信支付所需要的参数（所有订单公用接口）   $out_trade_no为订单号, $price必须是微信支付的金额!!!  $types标志订单类型 多规格为'duo' $body支付描述 如：商品支付
                // $kucun = pdo_getcolumn("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$order['pid']), "pro_kc");
                // 
                $kucun = Db::table('ims_sudu8_page_products') ->where('uniacid', $uniacid) ->where('id', $order['pid']) ->field('pro_kc') ->find();
                $kucun = $kucun['pro_kc'];
                if($order['num'] > $kucun && intval($kucun) != -1){
                    $data['data'] = array('err' => 4, 'message' => "库存不足！剩余".$kucun."件");
                    return json_encode($data);
                    // return $this->result(0, 'success', array('err' => 4, 'message' => "库存不足！剩余".$kucun."件"));
                }
                $body = "商品支付";
                //getweixinpayinfo($uniacid, $openid, $out_trade_no, $payprice, $body, $info)
                //$this->getweixinpayinfo($uniacid, $openid, $order_id, $payprice, $body, $types . "|" . input('formId') . "|" . $uniacid);  
                $weixinpay = $this->getweixinpayinfo($uniacid, $openid, $order_id, $pay_price, $body ,$types."|".input('formId')."|".$uniacid);  //最后一个参数为附加参数，这里存订单类型+formId
                $weixinpay['err'] = 0;
                $data['data'] = $weixinpay;
                return json_encode($data);
                //return $this->result(0, 'success', $weixinpay);
            }
            $data['data'] = array('err' => 1,'message'=>'价格出错');
            return json_encode($data);
            // return $this->result(0, 'success', array('err' => 1,'message'=>'价格出错'));
        }
    }
    //支付之前处理过期的优惠券（所有订单公用接口）
    public function overtimeyhq($uniacid, $uid)
    {
        $yhqs = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where("uid", $uid)->where("flag", 0)->where("etime", 'gt', 0)->field("id,cid")->select();
        foreach ($yhqs as $key => &$value) {
            $etime = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where("id", $value['cid'])->field("etime")->find()['etime'];
            if ($etime < time()) {
                Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where("id", $value['id'])->update(array("flag" => 2));
            }
        }
    }
    //支付之前检查当前订单的优惠券有没有在其他地方使用或者过期,价格改回（所有订单公用接口）
    public function checkthisyhq($uniacid, $order_id, $price, $coupon_price, $types)
    {
        $newprice = $price + $coupon_price;
        $data = array(
            "price" => $newprice,
            "coupon" => 0
        );
        if ($types == 'duo') {
            Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where("order_id", $order_id)->update($data);
        }
    }
    //保存微信统一下单接口返回的prepayid，可以发三次模板消息
    public function doPagesavePrepayid()
    {
        $uniacid = input("uniacid");
        $prepayid = input("prepayid");
        $types = input("types");
        $order_id = input("order_id");
        $prepayid = explode("=", $prepayid);
        $prepayid = $prepayid[1];
        Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where("order_id", $order_id)->update(array("prepayid" => $prepayid));
        $data = array(
            'message' => 'ok',
        );
        $result['data'] = $data;
        return json_encode($result);
    }
    //支付完成后绑定分销商、生成分销订单、判断新分销商
    public function doPagepayoverFxs()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        $fxsid = input('fxsid');
        $order_id = input('order_id');
        $types = input('types') ? input('types') : "duo";
        if ($fxsid) {
            //绑定分销商
            $userinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
            //获取该小程序的分销关系绑定规则
            $guiz = Db::table('ims_sudu8_page_fx_gz')->where("uniacid", $uniacid)->find();
            $fxsinfo = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $fxsid)->find();
            // 1.先进行上下级关系绑定[判断是不是首次下单]
            if ($guiz['sxj_gx'] == 2 && $userinfo['parent_id'] == '0' && $fxsid != '0' && $userinfo['fxs'] != 2 && $fxsinfo['fxs'] == 2) {
                $p_fxs = $fxsinfo['parent_id'];  //分销商的上级
                $p_p_fxs = $fxsinfo['p_parent_id']; //分销商的上上级
                // 判断启用几级分销
                $fx_cj = $guiz['fx_cj'];
                // 分别做判断
                if ($fx_cj == 1) {
                    $uuser = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $fxsid)->update(array("parent_id" => $fxsid));
                }
                if ($fx_cj == 2) {
                    $uuser = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $fxsid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs));
                }
                if ($fx_cj == 3) {
                    $uuser = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $fxsid)->update(array("parent_id" => $fxsid, "p_parent_id" => $p_fxs, "p_p_parent_id" => $p_p_fxs));
                }
            }
        }
        if ($types == "duo") {
//            $order = pdo_get("sudu8_page_duo_products_order", array("uniacid"=>$uniacid, "order_id"=>$order_id));
            $order = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid", $uniacid)->where("order_id", $order_id)->find();
            $jsondata = unserialize($order['jsondata']);
//            $new_userinfo = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "openid"=>$openid));
            $new_userinfo = Db::table("ims_sudu8_page_user")->where("uniacid", $uniacid)->where("openid", $openid)->find();
//            $guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
            $guiz = Db::table("ims_sudu8_page_fx_gz")->where("uniacid", $uniacid)->find();
            //计算一级、二级、三级佣金
            $onemoney = 0;
            $twomoney = 0;
            $threemoney = 0;
            foreach ($jsondata as $key => &$value) {
                $product = Db::table("ims_sudu8_page_products")->where("uniacid", $uniacid)->where("id", $value['baseinfo']['id'])->field("fx_uni,commission_type,commission_one,commission_two,commission_three")->find();
//                $singleprice = pdo_getcolumn("sudu8_page_duo_products_type_value", array("id"=>$value['proinfo']['id']), "price");
                $singleprice = Db::table("ims_sudu8_page_duo_products_type_value")->where("id", $value['proinfo']['id'])->field("price")->find();
                if ($product['fx_uni'] == 1 && $product['commission_type'] == 1) {  //商品独立分销，比例
                    $onemoney += round($singleprice * $product['commission_one'] * $value['num'] / 100, 2);
                    $twomoney += round($singleprice * $product['commission_two'] * $value['num'] / 100, 2);
                    $threemoney += round($singleprice * $product['commission_three'] * $value['num'] / 100, 2);
                } else if ($product['fx_uni'] == 1 && $product['commission_type'] == 2) {  //商品独立分销，固定
                    $onemoney += $product['commission_one'] * $value['num'];
                    $twomoney += $product['commission_two'] * $value['num'];
                    $threemoney += $product['commission_three'] * $value['num'];
                } else {                                                                //全局分销比例
                    $onemoney += round($singleprice['price'] * $guiz['one_bili'] * $value['num'] / 100, 2);
                    $twomoney += round($singleprice['price'] * $guiz['two_bili'] * $value['num'] / 100, 2);
                    $threemoney += round($singleprice['price'] * $guiz['three_bili'] * $value['num'] / 100, 2);
                }
            }
        } else if ($types == "miaosha") {
//            $order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "order_id"=>$order_id));
            $order = Db::table("ims_sudu8_page_order")->where("uniacid", $uniacid)->where("order_id", $order_id)->find();
//            $product = pdo_get("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$order['pid']));
            $product = Db::table("ims_sudu8_page_products")->where("uniacid", $uniacid)->where("id", $order["pid"])->find();
//            $new_userinfo = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "openid"=>$openid));
            $new_userinfo = Db::table("ims_sudu8_page_user")->where("uniacid", $uniacid)->where("openid", $openid)->find();
//            $guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
            $guiz = Db::table("ims_sudu8_page_fx_gz")->where("uniacid", $uniacid)->find();
            $singleprice = floatval($order['price']);
            //计算一级、二级、三级佣金
            $onemoney = 0;
            $twomoney = 0;
            $threemoney = 0;
            if ($product['fx_uni'] == 1 && $product['commission_type'] == 1) {  //商品独立分销，比例
                $onemoney = round($singleprice * $product['commission_one'] * $order['num'] / 100, 2);
                $twomoney = round($singleprice * $product['commission_two'] * $order['num'] / 100, 2);
                $threemoney = round($singleprice * $product['commission_three'] * $order['num'] / 100, 2);
            } else if ($product['fx_uni'] == 1 && $product['commission_type'] == 2) {  //商品独立分销，固定
                $onemoney = $product['commission_one'] * $order['num'];
                $twomoney = $product['commission_two'] * $order['num'];
                $threemoney = $product['commission_three'] * $order['num'];
            } else {                                                                //全局分销比例
                $onemoney = round($singleprice * $guiz['one_bili'] * $order['num'] / 100, 2);
                $twomoney = round($singleprice * $guiz['two_bili'] * $order['num'] / 100, 2);
                $threemoney = round($singleprice * $guiz['three_bili'] * $order['num'] / 100, 2);
            }
        } else if ($types == "art") {
//            $order = pdo_get("sudu8_page_video_pay", array("uniacid"=>$uniacid, "orderid"=>$order_id));
            $order = Db::table("ims_sudu8_page_video_pay")->where("uniacid", $uniacid)->where("orderid", $order_id)->find();
//            $product = pdo_get("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$order['pid']));
            $product = Db::table("ims_sudu8_page_products")->where("uniacid", $uniacid)->where('id', $order["pid"])->find();
//            $new_userinfo = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "openid"=>$openid));
            $new_userinfo = Db::table("ims_sudu8_page_user")->where("uniacid", $uniacid)->where("openid", $openid)->find();
//            $guiz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_fx_gz')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
            $guiz = Db::table("ims_sudu8_page_fx_gz")->where("uniacid", $uniacid)->find();
            $paymoney = floatval($order['paymoney']);
            //计算一级、二级、三级佣金
            $onemoney = 0;
            $twomoney = 0;
            $threemoney = 0;
            if ($product['fx_uni'] == 1 && $product['commission_type'] == 1) {
                $onemoney = round($paymoney * $product['commission_one'] / 100, 2);
                $twomoney = round($paymoney * $product['commission_two'] / 100, 2);
                $threemoney = round($paymoney * $product['commission_three'] / 100, 2);
            } else if ($product['fx_uni'] == 1 && $product['commission_type'] == 2) {
                $onemoney = $product['commission_one'];
                $twomoney = $product['commission_two'];
                $threemoney = $product['commission_three'];
            }
        }
        if ($guiz['fx_cj'] == 1) {
            if ($new_userinfo['parent_id'] != '0') {
                $lsdata = array(
                    "uniacid" => $uniacid,
                    "openid" => $openid,
                    "parent_id" => $new_userinfo['parent_id'],
                    "parent_id_get" => $onemoney,
                    "p_parent_id" => 0,
                    "p_parent_id_get" => 0,
                    "p_p_parent_id" => 0,
                    "p_p_parent_id_get" => 0,
                    "order_id" => $order_id,
                    "creattime" => time()
                );
//                pdo_insert("sudu8_page_fx_ls",$lsdata);
                Db::table('ims_sudu8_page_fx_ls')->insert($lsdata);
            }
        }
        if ($guiz['fx_cj'] == 2) {
            if ($new_userinfo['parent_id'] != '0' || $new_userinfo['p_parent_id'] != '0') {
                $lsdata = array(
                    "uniacid" => $uniacid,
                    "openid" => $openid,
                    "parent_id" => $new_userinfo['parent_id'] == '0' ? 0 : $new_userinfo['parent_id'],
                    "parent_id_get" => $new_userinfo['parent_id'] == '0' ? 0 : $onemoney,
                    "p_parent_id" => $new_userinfo['p_parent_id'] == '0' ? 0 : $new_userinfo['p_parent_id'],
                    "p_parent_id_get" => $new_userinfo['p_parent_id'] == '0' ? 0 : $twomoney,
                    "p_p_parent_id" => 0,
                    "p_p_parent_id_get" => 0,
                    "order_id" => $order_id,
                    "creattime" => time()
                );
//                pdo_insert("sudu8_page_fx_ls",$lsdata);
                Db::table('ims_sudu8_page_fx_ls')->insert($lsdata);
            }
        }
        if ($guiz['fx_cj'] == 3) {
            if ($new_userinfo['parent_id'] != '0' || $new_userinfo['p_parent_id'] != '0' || $new_userinfo['p_p_parent_id'] != '0') {
                $lsdata = array(
                    "uniacid" => $uniacid,
                    "openid" => $openid,
                    "parent_id" => $new_userinfo['parent_id'] == '0' ? 0 : $new_userinfo['parent_id'],
                    "parent_id_get" => $new_userinfo['parent_id'] == '0' ? 0 : $onemoney,
                    "p_parent_id" => $new_userinfo['p_parent_id'] == '0' ? 0 : $new_userinfo['p_parent_id'],
                    "p_parent_id_get" => $new_userinfo['p_parent_id'] == '0' ? 0 : $twomoney,
                    "p_p_parent_id" => $new_userinfo['p_p_parent_id'] == '0' ? 0 : $new_userinfo['p_p_parent_id'],
                    "p_p_parent_id_get" => $new_userinfo['p_p_parent_id'] == '0' ? 0 : $threemoney,
                    "order_id" => $order_id,
                    "creattime" => time()
                );
//                pdo_insert("sudu8_page_fx_ls",$lsdata);
                Db::table('ims_sudu8_page_fx_ls')->insert($lsdata);
            }
        }
        //如果是文章类型，直接到账
        if ($types == "art") {
            $this->dopagegivemoney($openid, $openid, $order_id);
        }
        if ($new_userinfo['fxs'] == 1 && $types != "art") {
            $val = $guiz['fxs_sz_val'];
            if ($guiz['fxs_sz'] == 3) {
                if ($types == "duo") {
                    $times = Db::table('ims_sudu8_page_duo_products_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 'in', ['1,2,4'])->count();
//                    $times = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_duo_products_order")." WHERE uniacid = :uniacid and openid = :openid and flag in (1,2,4)",
//                        array(":uniacid"=>$uniacid, ":openid"=>$openid));
                } else if ($types == "miaosha") {
//                    $times = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_order")." WHERE uniacid = :uniacid and openid = :openid and flag in (1,2,4)",
//                        array(":uniacid"=>$uniacid, ":openid"=>$openid));
                    $times = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 'in', ['1,2,4'])->count();
                }
                if ($times >= $val) {
//                    pdo_update("sudu8_page_user",array("fxs"=>2,"fxstime"=>time()),array('openid' => $openid ,'uniacid' => $uniacid));
                    Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("fxs" => 2, "fxstime" => time()));
                }
            }
            if ($guiz['fxs_sz'] == 4) {
                if ($types == "duo") {
//                    $total_price = pdo_fetchcolumn("SELECT sum(price) FROM ".tablename("sudu8_page_duo_products_order")." WHERE uniacid = :uniacid and openid = :openid and flag in (1,2,4)",
//                        array(":uniacid"=>$uniacid, ":openid"=>$openid));
                    $total_price = Db::table("ims_sudu8_page_duo_products_order")->where("uniacid", $uniacid)->where("openid", $openid)->where("flag", "in", [1,2,4])->sum("price");
                } else if ($types == "miaosha") {
//                    $total_price = pdo_fetchcolumn("SELECT sum(true_price) FROM ".tablename("sudu8_page_order")." WHERE uniacid = :uniacid and openid = :openid and flag in (1,2,4)",
//                        array(":uniacid"=>$uniacid, ":openid"=>$openid));
                    $total_price = Db::table("ims_sudu8_page_order")->where("uniacid", $uniacid)->where("openid", $openid)->where("flag", "in", [1,2,4])->sum("true_price");
                }
                if ($total_price > $val) {
//                    pdo_update("sudu8_page_user",array("fxs"=>2,"fxstime"=>time()),array('openid' => $openid ,'uniacid' => $uniacid));
                    Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update(array("fxs" => 2, "fxstime" => time()));
                }
            }
        }
        $data['data'] = array('message' => 'ok');
        return json_encode($data);
    }
    public function sendTplMessage($uniacid, $flag, $openid, $formId, $types, $data)
    { //$fmsg, $orderid, $fprice){
        $applet = Db::table('applet')->where("id", $uniacid)->find();
        $appid = $applet['appID'];
        $appsecret = $applet['appSecret'];
        if ($applet) {
            $mid = Db::table('ims_sudu8_page_message')->where("uniacid", $uniacid)->where("flag", $flag)->find();
            if ($mid && $mid['mid'] != "") {
                $mids = $mid['mid'];
                $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
                $a_token = $this->_requestGetcurl($url);
                if ($a_token) {
                    $url_m = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=" . $a_token['access_token'];
                    $ftime = date('Y-m-d H:i:s', time());
                    $furl = $mid['url'];
                    if ($types == 'duo_zf') {
                        $post_info = '{ 
                          "touser": "' . $openid . '",  
                          "template_id": "' . $mids . '", 
                          "page": "' . $furl . '",         
                          "form_id": "' . $formId . '",         
                          "data": {
                              "keyword1": {
                                  "value": "' . $data['orderid'] . '", 
                                  "color": "#173177"
                              }, 
                              "keyword2": {
                                  "value": "' . $data['fprice'] . '元", 
                                  "color": "#173177"
                              }, 
                              "keyword3": {
                                  "value": "' . $data['fmsg'] . '", 
                                  "color": "#173177"
                              } , 
                              "keyword4": {
                                  "value": "' . $ftime . '", 
                                  "color": "#173177"
                              } 
                          },
                          "emphasis_keyword": "" 
                        }';
                    }
                    if ($types == 'duo_th') {
                        $post_info = '{ 
                          "touser": "' . $openid . '",  
                          "template_id": "' . $mids . '", 
                          "page": "' . $furl . '",         
                          "form_id": "' . $formId . '",         
                          "data": {
                              "keyword1": {
                                  "value": "' . $data['orderid'] . '", 
                                  "color": "#173177"
                              }, 
                              "keyword2": {
                                  "value": "' . $data['fprice'] . '元", 
                                  "color": "#173177"
                              }, 
                              "keyword4": {
                                  "value": "' . $ftime . '", 
                                  "color": "#173177"
                              } 
                          },
                          "emphasis_keyword": "" 
                        }';
                    }
                    $response = $this->_requestPost($url_m, $post_info);
                    // file_put_contents(__DIR__."/debug2.txt",$response);
                }
            }
        }
    }
    //付款成功邮件提醒，发送邮件给商家（所有订单公用接口）
    public function sendMailToAdmin($uniacid, $order_id, $types)
    {
        // require_once(IA_ROOT."/framework/library/phpmailer/class.phpmailer.php");
        // require_once(IA_ROOT."/framework/library/phpmailer/class.smtp.php");
        $formsConfig = Db::table('ims_sudu8_page_forms_config')->where("uniacid", $uniacid)->field("mail_sendto,mail_user,mail_password,mail_user_name")->find();
        $mail_sendto = array();
        $mail_sendto = explode(",", $formsConfig['mail_sendto']);
        $row_mail_user = $formsConfig['mail_user'];
        $row_mail_pass = $formsConfig['mail_password'];
        $row_mail_name = $formsConfig['mail_user_name'];
        if($types == "duo"){
            $ord = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where("order_id", $order_id)->find();
            $row_oid = "订单编号：" . $ord['order_id'] . "<br />";
            $pro = unserialize($ord['jsondata']);
            $row_pro = "";
            foreach ($pro as $key5 => &$resb) {
                $row_pro .= "产品名称：" . $resb['baseinfo']['title'] . "<br />";
                $row_pro .= "产品规格：" . $resb['proinfo']['ggz'] . "<br />";
            }
            $row_pro .= "支付金额：" . $ord['price'] . "<br />";
            
        }
        if($types == "miaosha"){
            // // $ord = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "order_id"=>$order_id));
            // $ord = Db::table('ims_sudu8_page_order') ->where('uniacid', $uniacid) ->where('order_id', $order_id) ->find();
            // $row_oid = "订单编号（秒杀）：".$ord['order_id']."<br />";
            // $row_pro = "";
            $ord = Db::table('ims_sudu8_page_order') ->where('uniacid', $uniacid) ->where('order_id', $order_id) ->find();
            $row_oid = "订单编号（秒杀）：".$ord['order_id']."<br />";
            // $pro = pdo_get("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$ord['pid']));
            $pro = Db::table('ims_sudu8_page_products') ->where('uniacid', $uniacid) ->where('id', $ord['pid'])->find();
            $row_pro = "";
            $row_pro .= "产品名称：".$pro['title']."<br />";
            $row_pro .= "产品价格：￥".$pro['price']." X ".$ord['num']." = ￥".$pro['price'] * $ord['num']."<br />";
            if(!empty($ord['yhInfo'])){
                $yhInfo = unserialize($ord['yhInfo']);
                $row_pro .= "运费：￥".$yhInfo['yunfei']."<br>";
                if($yhInfo['mj']['money'] > 0){
                    $row_pro .= "满减：".$yhInfo['mj']['msg']."<br>";
                }
                if($yhInfo['yhq']['money'] > 0){
                    $row_pro .= "优惠券：".$yhInfo['yhq']['msg']."<br>";
                }
                if($yhInfo['score']['money'] > 0){
                    $row_pro .= "积分：".$yhInfo['score']['msg']."<br>";
                }
            }
            $row_pro .= "支付金额：￥".$ord['true_price']."<br />";
        }

        $row_prc = "<br />";
        $row_prc .= "===================订单地址===================<br />";
        // 去查询订单的收货地址
        if ($ord['nav'] == 2) {//到店自提
            $row_prc .= "到店自提<br />";
        } else {
            $address = Db::table('ims_sudu8_page_duo_products_address')->where("id", $ord['address'])->find();
            $row_prc .= "联系姓名：" . $address['name'] . "<br />";
            $row_prc .= "联系电话：" . $address['mobile'] . "<br />";
            $row_prc .= "联系地址：" . $address['address'] . "<br />";
            $row_prc .= "详细地址：" . $address['more_address'] . "<br />";
            $row_prc .= "邮编：" . $address['postalcode'] . "<br />";
        }

        $mail = new PHPMailer();
        $mail->CharSet = "utf-8";
        $mail->Encoding = "base64";
        $mail->SMTPSecure = "ssl";
        $mail->IsSMTP();
        $mail->Port = 465;
        $mail->Host = "smtp.qq.com";
        $mail->SMTPAuth = true;
        $mail->SMTPDebug = false;
        $mail->Username = $row_mail_user;
        $mail->Password = $row_mail_pass;
        $mail->setFrom($row_mail_user, $row_mail_name);
        foreach ($mail_sendto as $v) {
            $mail->AddAddress($v);
        }
        $mail->Subject = "新订单 - " . date("Y-m-d H:i:s", time());
        $mail->isHTML(true);
        $mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_oid . $row_pro . $row_prc . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
        if (!$mail->send()) {
            $result = "send_err";
        } else {
            $result = "send_ok";
        }
    }
    //新版生成订单（所有订单公用接口）
    public function dopagecreateorder()
    {
        $uniacid = input('uniacid');
        $types = input('types');
        if ($types == 'duo') {
            $openid = input('openid');
            $couponid = input('couponid');
            $price = input('price');
            $dkscore = input('dkscore');
            $address = input('address');
            $mjly = input('mjly');
            $nav = input('nav');
            $formid = input('formid');
            $yunfei = input('yunfei');
            $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
            $uid = $userinfo['id'];
            $money = $userinfo['money'];
            $jsdata = html_entity_decode(input('jsdata'));
            $jsdatass = json_decode($jsdata, true);
            $payprice = 0;
            $yhInfo = array();
            //原价
            foreach ($jsdatass as $key => &$value) {
                $singleprice = Db::table('ims_sudu8_page_duo_products_type_value')->where('id', $value['proinfo'])->field('price')->find()['price'];
                $payprice += floatval($singleprice) * intval($value['num']);
            }
            //满减
            $moneyoff = Db::table('ims_sudu8_page_moneyoff')->where('uniacid', $uniacid)->ORDER('reach desc')->select();
            $yhInfo['mj']['msg'] = "";
            $yhInfo['mj']['money'] = 0;
            $yhInfo['yunfei'] = $yunfei;
            foreach ($moneyoff as $k => &$v) {
                if ($payprice >= $v['reach']) {
                    $payprice -= $v['del'];
                    $yhInfo['mj']['msg'] = "满".$v['reach']."减".$v['del'];
                    $yhInfo['mj']['money'] = $v['del'];
                    break;
                }
            }
            //优惠券
            if ($couponid != '0' && !empty($couponid)) {
                $coupon_user = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $uniacid)->where('id', $couponid)->where('uid', $uid)->where('flag', 0)->find();
                if ($coupon_user) {
                    $coupon = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', $coupon_user['cid'])->find();
                    if ($payprice >= floatval($coupon['pay_money'])) {
                        $payprice -= floatval($coupon['price']);
                        $yhInfo['yhq']['msg'] = "满".floatval($coupon['pay_money'])."减".floatval($coupon['price']);
                        $yhInfo['yhq']['money'] = floatval($coupon['price']);
                    }
                }
            }else{
                $yhInfo['yhq']['msg'] = "未使用优惠券";
                $yhInfo['yhq']['money'] = 0;
            }
            //积分抵扣
            if ($dkscore != '0' && !empty($dkscore)) {
                $jfgz = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid', $uniacid)->find();
                $payprice -= floatval($dkscore) * floatval($jfgz['money']) / floatval($jfgz['score']);
                $yhInfo['score']['msg'] = $dkscore."积分抵扣".floatval($dkscore) * floatval($jfgz['money']) / floatval($jfgz['score']);
                $yhInfo['score']['money'] = floatval($dkscore) * floatval($jfgz['money']) / floatval($jfgz['score']);
            }else{
                $yhInfo['score']['msg'] = "无使用积分";
                $yhInfo['score']['money'] = 0;
            }
            //判断算出来的价格与实付价格是否相等
            //bccomp(round($payprice, 2) + $yunfei, $price) == 0
            //bccomp(round($payprice, 2) + floatval($yunfei), floatval($price)) == 0
            if (bccomp(round($payprice, 2) + floatval($yunfei), floatval($price)) == 0) {
                foreach ($jsdatass as $key12 => &$res) {
                   

                        $probaseinfo = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where('id', $res['baseinfo'])->field("id,title,thumb,is_sale")->find();
                        if($probaseinfo['is_sale']==1){
                            $result['data'] = array('errcode' => 4, 'err' => '商品已经下架！');
                            return json_encode($result);
                        }
                        $proproinfo = Db::table('ims_sudu8_page_duo_products_type_value')->where('id', $res['proinfo'])->field("id,price,thumb,comment,type1,type2,type3,kc")->find();
                        $newproinfo['id'] = $probaseinfo['id'];
                        $newproinfo['title'] = $probaseinfo['title'];
                        $newproinfo['thumb'] = $probaseinfo['thumb'];
                        $res['baseinfo'] = $newproinfo;
                        $newproinfo['id'] = $proproinfo['id'];
                        $newproinfo['price'] = $proproinfo['price'];
                        $newproinfo['thumb'] = $proproinfo['thumb'];
                        $newproinfo['kc'] = $proproinfo['kc'];
                        $gg = $proproinfo['comment'];
                        $ggarr = explode(",", $gg);
                        $str = "";
                        foreach ($ggarr as $index => $rec) {
                            $i = $index + 1;
                            $kk = "type" . $i;
                            $str .= $rec . ":" . $proproinfo[$kk] . ",";
                        }

                        if ($res['num'] > $proproinfo['kc']) {
                            $result = [];
                            $result['data'] = array('errcode' => 2, 'err' => '库存不足！', 'title' => $probaseinfo['title'] . '(' . chop($str, ',') . ')', 'kc' => $proproinfo['kc']);
                            return json_encode($result);
                            exit;
                        }
                        $newproinfo['ggz'] = $str;
                        $res['proinfo'] = $newproinfo;

                   


                }
                $now = time();
                $order_id = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
                if ($money >= $price) {
                    $realprice = 0;
                } else {
                    $realprice = round(floatval($price) - floatval($money), 2);
                }
                $data = array(
                    "uniacid" => $uniacid,
                    "uid" => $uid,
                    "openid" => $openid,
                    "order_id" => $order_id,
                    "jsondata" => serialize($jsdatass),
                    "coupon" => $couponid,
                    "creattime" => time(),
                    "price" => $price,
                    "payprice" => $realprice,
                    "flag" => 0,
                    "jf" => $dkscore,
                    "address" => $address,
                    "liuyan" => $mjly,
                    "nav" => $nav,
                    "formid" => empty($formid) ? 0 : $formid,
                    "yhinfo" => serialize($yhInfo)
                );
                Db::table('ims_sudu8_page_duo_products_order')->insert($data);
                $result['data'] = array('errcode' => 3, 'order_id' => $order_id);
                return json_encode($result);
            }
            $result['data'] = array('errcode' => 1, 'err' => '生成订单失败！');
            return json_encode($result);
        }
        if($types == "miaosha"){
            $orderid = input('orderid');
            $openid = input('openid');
            $couponid = input('couponid');
            $price = floatval(input('price'));
            $dkscore = floatval(input('dkscore'));
            $address = input('address');
            $mjly = input('mjly');
            $nav = input('nav');
            $formid = input('formid');
            $yunfei = floatval(input('yunfei'));
            $pid = input('pid');
            $num = intval(input('num'));
            $yhInfo = array();
            $userinfo = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
            $uid = $userinfo['id'];
            $money = floatval($userinfo['money']);
           // $product = pdo_get("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$pid));
            $product = Db::table('ims_sudu8_page_products') ->where('uniacid', $uniacid) ->where('id', $pid) ->find();
            if($product['is_sale']==1){
                $b['data'] = array("errcode"=>4, "err"=>"商品已经下架");
                return json_encode($b);
            }
            $payprice = floatval($product['price']) * $num;
            //满减
            // $moneyoff = pdo_fetchall("SELECT * FROM ".tablename("sudu8_page_moneyoff")." WHERE uniacid = :uniacid ORDER BY reach desc",array(":uniacid"=>$uniacid));
            $moneyoff = Db::table('ims_sudu8_page_moneyoff') ->where('uniacid', $uniacid) -> order('reach desc') ->select();
            $yhInfo['mj']['msg'] = "";
            $yhInfo['mj']['money'] = 0;
            $yhInfo['yunfei'] = $yunfei;
            foreach ($moneyoff as $k => &$v) {
                if($payprice >= $v['reach']){
                    $payprice -= $v['del'];
                    $yhInfo['mj']['msg'] = "满".$v['reach']."减".$v['del'];
                    $yhInfo['mj']['money'] = $v['del'];
                    break;
                }
            }
            //优惠券
            if($couponid != '0' && !empty($couponid)){
                // $coupon_user = pdo_get("sudu8_page_coupon_user", array("uniacid"=>$uniacid, "id"=>$couponid, "uid"=>$uid, "flag"=>0));
                $coupon_user = Db::table('ims_sudu8_page_coupon_user') ->where('uniacid', $uniacid) ->where('id', $couponid) ->where('uid', $uid) ->where('flag', 0) ->find();
                if($coupon_user){
                    // $coupon = pdo_get("sudu8_page_coupon", array("uniacid"=>$uniacid, "id"=>$coupon_user['cid']));
                    $coupon = Db::table('ims_sudu8_page_coupon') ->where('uniacid', $uniacid) ->where('id', $coupon_user['cid']) ->find();
                    if($payprice >= floatval($coupon['pay_money'])){
                        $payprice -= floatval($coupon['price']);
                        $yhInfo['yhq']['msg'] = "满".floatval($coupon['pay_money'])."减".floatval($coupon['price']);
                        $yhInfo['yhq']['money'] = floatval($coupon['price']);
                    }
                }
            }else{
                $yhInfo['yhq']['msg'] = "未使用优惠券";
                $yhInfo['yhq']['money'] = 0;
            }

            //积分抵扣
            if($dkscore != '0' && !empty($dkscore) ){   
                // $jfgz = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
                $jfgz = Db::table('ims_sudu8_page_rechargeconf') ->where('uniacid', $uniacid) ->find();
                $payprice -= floatval($dkscore) * floatval($jfgz['money']) / floatval($jfgz['score']);
                $yhInfo['score']['msg'] = $dkscore."积分抵扣".floatval($dkscore) * floatval($jfgz['money']) / floatval($jfgz['score']);
                $yhInfo['score']['money'] = floatval($dkscore) * floatval($jfgz['money']) / floatval($jfgz['score']);
            }else{
                $yhInfo['score']['msg'] = "无使用积分";
                $yhInfo['score']['money'] = 0;
            }
            
            //判断算出来的价格与实付价格是否相等
            if(bccomp(round($payprice, 2) + $yunfei, $price) == 0){
                // $my_num = pdo_fetchcolumn("SELECT sum(num) FROM ".tablename('sudu8_page_order')." WHERE pid = :pid and openid = :openid and uniacid = :uniacid and flag > 0" , array(':pid' => $pid ,':openid' => $openid ,':uniacid' => $uniacid));
                $my_num = Db::table('ims_sudu8_page_order') ->where('pid', $pid) ->where('openid', $openid) ->where('uniacid', $uniacid) ->where('flag', 'GT', 0) ->sum('num');
                if(intval($product['pro_xz']) > 0 && intval($my_num) + $num > intval($product['pro_xz'])){
                    $can_buy = intval($product['pro_xz']) - intval($my_num);
                    $a['data'] = array("errcode"=>2, "err"=>"您的累计购买量已超该商品限购数量！", "can_buy"=>$can_buy);
                    return json_encode($a);
                    // return $this->result(0, 'success', array("errcode"=>2, "err"=>"您的累计购买量已超该商品限购数量！", "can_buy"=>$can_buy));
                }
                if(intval($product['pro_kc']) !== -1 && $num > intval($product['pro_kc'])){
                    $b['data'] = array("errcode"=>3, "err"=>"库存不足！", "kc"=>intval($product['pro_kc']));
                    return json_encode($b);
                    // return $this->result(0, 'success', array("errcode"=>3, "err"=>"库存不足！", "kc"=>intval($product['pro_kc'])));
                }
                $now = time();
                $order_id  = date("Y",$now).date("m",$now).date("d",$now).date("H",$now).date("i",$now).date("s",$now).rand(1000,9999);
                if($money >= $price){
                    $realprice = 0;
                }else{
                    $realprice = round($price - $money, 2);
                }
                if($couponid == 0){
                    $yhq = 0;
                }else{
                    $yhq = $coupon['price'];
                }
                $data = array(
                    "uid" => $uid,
                    "openid" => $openid,
                    "pid" => $pid,
                    "thumb" => $product['thumb'],
                    "product" => $product['title'],
                    "price" => $product['price'],
                    "num" => $num,
                    "yhq" => $yhq,
                    "true_price" => $price,
                    "pay_price" => $realprice,
                    "dkscore" => $dkscore,
                    "creattime" => time(),
                    "flag" => 0,
                    "is_more" => 0,
                    "overtime" => time() + 30*60,
                    "coupon" => $couponid,
                    "address" => $address,
                    "nav" => $nav,
                    "formid" => $formid,
                    "beizhu_val" => $mjly,
                    "yhinfo" => serialize($yhInfo)
                );
                if($orderid && $orderid != 'undefined'){
                    // pdo_update("sudu8_page_order", $data, array("uniacid"=>$uniacid, "order_id" => $orderid));
                    Db::table('ims_sudu8_page_order') ->where('uniacid', $uniacid) ->where('order_id', $orderid) ->update($data);
                    $d['data'] = array("errcode"=>-1, "orderid"=>$orderid);
                    return json_encode($d);
                    // return $this->result(0, 'success', $orderid);
                }else{
                    $data['uniacid'] = $uniacid;
                    $data['order_id'] = $order_id;
                    // pdo_insert("sudu8_page_order", $data);
                    Db::table('ims_sudu8_page_order') ->insert($data);
                    $e['data'] = array("errcode"=>-1, "orderid"=>$order_id);
                    return json_encode($e);
                    // return $this->result(0, 'success', $order_id);
                }
            }
            $c['data'] = array("errcode"=>1, "err"=>"生成订单失败！");
            return json_encode($c);
            // return $this->result(0, 'success', array("errcode"=>1, "err"=>"生成订单失败！"));
        }
        
    }
    /*forum start*/
    //论坛所有功能分类
    public function doPageForumfunc()
    {
        $uniacid = input('uniacid');
        $list = Db::table("ims_sudu8_page_forum_func")->where('uniacid', $uniacid)->where('status', 1)->order('num desc')->select();
        foreach ($list as $key => &$value) {
            $value['func_img'] = remote($uniacid, $value['func_img'], 1);
        }
        $result['data'] = $list;
        return json_encode($result);
    }
    //论坛的基本设置
    public function doPageForumSet()
    {
        $uniacid = input("uniacid");
        $set = Db::table("ims_sudu8_page_forum_set")->where("uniacid", $uniacid)->find();
        $result = [];
        if ($set) {
            $result['data'] = $set;
        } else {
            $result['data'] = array(
                'release_money' => 0.00,
                'stick_money' => 10.00
            );
        }
        return json_encode($result);
    }
    //发布页获取所有功能分类
    public function doPageGetFuncAll()
    {
        $uniacid = input("uniacid");
        $funcAll = Db::table("ims_sudu8_page_forum_func")->where("uniacid", $uniacid)->where("status", 1)->order("num desc, id desc")->select();  //全部功能分类
        $funcTitleArr = [];
        foreach ($funcAll as $key => $value) {
            array_push($funcTitleArr, $value['title']);
        }
        $result = [];
        $result['data']['funcAll'] = $funcAll;
        $result['data']['funcTitleArr'] = $funcTitleArr;
        return json_encode($result);
    }
    //论坛发布信息提交
    public function doPageReleaseSub()
    {
        $uniacid = input("uniacid");
        $cons = input("cons");
        $release_money = input("release_money");
        $telphone = input("telphone");
        if ($telphone == "undefined") {
            $telphone = "";
        }
        $address = input("address");
        $release_img = input("release_img");
        if ($release_img) {
            $release_img = stripslashes(html_entity_decode($release_img));
            $release_img = json_decode($release_img, TRUE);
            if ($release_img) {
                foreach ($release_img as $key => &$value) {
                    $value = moveurl($value);
                }
                $release_img = serialize($release_img);
            }
        }
        $openid = input("openid");
        $uid = Db::table("ims_sudu8_page_user")->where("uniacid", $uniacid)->where("openid", $openid)->field("id")->find()['id'];
        $data = array(
            "uniacid" => $uniacid,
            "uid" => $uid,
            "fid" => input("fid"),
            "content" => $cons,
            "img" => $release_img,
            "release_money" => $release_money,
            "address" => $address,
            "telphone" => $telphone
        );
        $rid = input("rid"); //发布id
        if ($rid > 0) {  //疑问  置顶之后是否可以续费购买置顶天数
            $data['updatetime'] = date("Y-m-d H:i:s", time());
            $res = Db::table("ims_sudu8_page_forum_release")->where("id", $rid)->update($data);
            if ($res) {
                $res = $rid;
            }
        } else {
            $data['createtime'] = date("Y-m-d H:i:s", time());
            $res = Db::table("ims_sudu8_page_forum_release")->insertGetId($data);
        }
        $result = [];
        if ($res) {
            $result['data'] = $res;
        } else {
            $result['data'] = 0;
        }
        return json_encode($result);
    }
    //论坛发布扣除原有余额
    public function doPageUpdateUserMoney()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $res = Db::table("ims_sudu8_page_user")->where("uniacid", $uniacid)->where("openid", $openid)->update(array("money" => 0));
        if ($res) {
            $result = [];
            $result['data'] = 1;
            return json_encode($result);
        }
    }
    //论坛发布列表
    public function doPageReleaseAll()
    {
        $uniacid = input("uniacid");
        $openid = input('openid');
        $fid = input("fid");  //功能类
        $page = input("page");
        $pindex = max(1, intval(input("page")));
        $psize = 10;
        $begin = ($pindex - 1) * $psize;
        $funcAll = Db::table("ims_sudu8_page_forum_func")->where("uniacid", $uniacid)->where("status", 1)->order("num desc,id desc")->select();  //全部功能分类
        //功能页面类型
        $pageType = Db::table("ims_sudu8_page_forum_func")->where("uniacid", $uniacid)->where("id", $fid)->field("page_type")->find()["page_type"];
        $is = Db::table('ims_sudu8_page_forum_func')->where('uniacid', $uniacid)->where("id", $fid)->where('status', 1)->find();
        $result = array();
        if ($is) {
            //列表内容
            $releaseAll = Db::table("ims_sudu8_page_forum_release")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("a.fid", $fid)->field("a.*,b.avatar,b.nickname")->order("a.hot asc,a.stick asc,a.id desc")->limit($begin, $psize)->select();
            if ($releaseAll) {
                //获取发布的评论
                foreach ($releaseAll as $key => &$value) {
                    $value['content'] = substr($value['content'], 0, 420);
                    $is_stick = Db::table("ims_sudu8_page_forum_stick")->where("uniacid", $uniacid)->where('rid', $value['id'])->where('stick_status', 1)->find();
                    if (!empty($is_stick)) {
                        $endtime = strtotime($is_stick['stick_time']) + $is_stick['stick_days'] * 24 * 3600;
                        if ($endtime <= time()) { //判断置顶是否过期
                            Db::table('ims_sudu8_page_forum_release')->where('uniacid', $uniacid)->where("id", $value['id'])->update(array('stick' => 2));
                            Db::table('ims_sudu8_page_forum_stick')->where('uniacid', $uniacid)->where("id", $is_stick['id'])->update(array('stick_status' => 2));
                            $value['stick'] = 2;
                        }
                    }
                    if ($value['img']) {
                        $value['img'] = unserialize($value['img']);
                    }
                    if(!empty($value['img'])){
                        if (count($value['img']) > 0 && is_array($value['img'])) {
                            foreach ($value['img'] as $k => &$v) {
                                $v = remote($uniacid, $v, 1);
                            }
                        }
                    }
                    $value['is_collection'] = Db::table("ims_sudu8_page_forum_collection")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("a.rid", $value['id'])->where("a.collection", 1)->count();
                    $collect_sql = Db::table("ims_sudu8_page_forum_collection")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("b.openid", $openid)->where("a.collection", 1)->where("a.rid", $value['id'])->field("a.id")->find();
                    if ($collect_sql) {
                        $value['is_collect'] = 1; //收藏
                    } else {
                        $value['is_collect'] = 2; //收藏
                    }
                    $value['is_likes'] = Db::table("ims_sudu8_page_forum_likes")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("a.rid", $value['id'])->where("a.likes", 1)->count();
                    $like_sql = Db::table("ims_sudu8_page_forum_likes")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("b.openid", $openid)->where("a.likes", 1)->where("a.rid", $value['id'])->field("a.id")->find();
                    if ($like_sql) {
                        $value['is_like'] = 1; //点赞
                    } else {
                        $value['is_like'] = 2; //点赞
                    }
                    $value['likesAll'] = Db::table("ims_sudu8_page_forum_likes")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("a.rid", $value['id'])->where("a.likes", 1)->order("a.id desc")->field("b.nickname")->select();
                    if ($pageType != 3) {
                        $value['commentList'] = Db::table('ims_sudu8_page_forum_comment')->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("a.rid", $value['id'])->limit(4)->order("a.id desc")->field("a.*,b.nickname")->select(); //获取4条评论
                    } else {
                        if (count($value['img']) > 1) {
                            $img = $value['img'][0];
                            $value['img'] = [];
                            $value['img'][0] = $img;
                        }
                    }
                }
            } else {
                $releaseAll = [];
            }
            $result['data']['is'] = 1;
        } else {
            $releaseAll = [];
            $result['data']['is'] = 2;
        }
        $result['data']['pageType'] = $pageType;
        $result['data']['funcAll'] = $funcAll;
        $result['data']['releaseAll'] = $releaseAll;
        return json_encode($result);
    }
    //论坛获取发布详情页内容
    public function doPageGetForumCon()
    {
        $uniacid = input("uniacid");
        $rid = input("rid");
        $types = input("types"); //修改：1
        $openid = input("openid");
        $getcon = Db::table("ims_sudu8_page_forum_release")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("a.id", $rid)->field("a.*,b.avatar,b.nickname,b.openid")->find();
        $is_stick = Db::table("ims_sudu8_page_forum_stick")->where("uniacid", $uniacid)->where('rid', $rid)->where('stick_status', 1)->find();
        if ($is_stick) {
            $endtime = strtotime($is_stick['stick_time']) + $is_stick['stick_days'] * 24 * 3600;
            if ($endtime <= time()) { //判断置顶是否过期
                Db::table('ims_sudu8_page_forum_release')->where('uniacid', $uniacid)->where("id", $rid)->update(array('stick' => 2));
                Db::table('ims_sudu8_page_forum_stick')->where('uniacid', $uniacid)->where("id", $is_stick['id'])->update(array('stick_status' => 2));
                $getcon['stick'] = 2;
            }
        }
        if ($getcon['img']) {
            $getcon['img'] = unserialize($getcon['img']);
            if (count($getcon['img']) > 0 && is_array($getcon['img'])) {
                foreach ($getcon['img'] as $k => &$v) {
                    $v = remote($uniacid, $v, 1);
                }
            }
        }
        $collect_sql = Db::table("ims_sudu8_page_forum_collection")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("b.openid", $openid)->where("a.collection", 1)->where("a.rid", $rid)->field("a.id")->find();
        if ($collect_sql) {
            $getcon['is_collect'] = 1; //收藏
        } else {
            $getcon['is_collect'] = 2; //收藏
        }
        $like_sql = Db::table("ims_sudu8_page_forum_likes")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("b.openid", $openid)->where("a.likes", 1)->where("a.rid", $rid)->field("a.id")->find();
        if ($like_sql) {
            $getcon['is_like'] = 1; //点赞
        } else {
            $getcon['is_like'] = 2; //点赞
        }
        $result = [];
        $result['data'] = $getcon;
        //增加浏览量
        if ($types != 1) {
            $hits = $getcon['hits'] + 1;
            Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->update(array("hits" => $hits));
        }
        return json_encode($result);
    }
    //获取论坛评论
    public function doPageGetForumComment()
    {
        $uniacid = input("uniacid");
        $rid = input("rid");
        $openid = input("openid");
        $page = input("page");
        $pindex = max(1, intval(input("page")));
        $psize = 10;
        $begin = ($pindex - 1) * $psize;
        $count = Db::table('ims_sudu8_page_forum_comment')->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("a.rid", $rid)->order('a.id desc')->count();
        $commentList = Db::table('ims_sudu8_page_forum_comment')->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("a.rid", $rid)->order('a.id desc')->field("a.*,b.avatar,b.nickname,b.openid")->limit($begin, $psize)->select();
        foreach ($commentList as $key => &$value) {
            $like_sql = Db::table("ims_sudu8_page_forum_comment_likes")->where("uniacid", $uniacid)->where("openid", $openid)->where("likes", 1)->where("commentId", $value['id'])->field("id")->find();
            if ($like_sql) {
                $value['is_like'] = 1; //点赞
            } else {
                $value['is_like'] = 2; //点赞
            }
            $value['reply'] = Db::table("ims_sudu8_page_forum_reply")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.commentId", $value['id'])->field("a.*,b.avatar,b.nickname,b.openid")->select();
            foreach ($value['reply'] as $k => &$v) {
                $like_sql2 = Db::table("ims_sudu8_page_forum_reply_likes")->where("uniacid", $uniacid)->where("openid", $openid)->where("likes", 1)->where("replyId", $v['id'])->field("id")->find();
                if ($like_sql2) {
                    $v['is_like'] = 1; //点赞
                } else {
                    $v['is_like'] = 2; //点赞
                }
            }
        }
        $result = [];
        $result['data']['list'] = $commentList;
        $result['data']['count'] = $count;
        return json_encode($result);
    }
    //提交论坛评论的内容
    public function doPageForumCommentSub()
    {
        $uniacid = input("uniacid");
        $rid = input("rid");
        $openid = input("openid");
        $content = input("content");
        $commentId = input("commentId");//回复评论id
        $release_uid = Db::table("ims_sudu8_page_user")->where("uniacid", $uniacid)->where("openid", $openid)->field("id")->find()['id'];//回复人uid
        $uid = input('uid');//被回复人uid
        if ($uid > 0) {
            $data = array(
                "commentId" => $commentId,
                "release_uid" => $release_uid,
                "uid" => $release_uid,
                "uniacid" => $uniacid,
                "content" => $content,
                "createtime" => date("Y-m-d H:i:s", time())
            );
            $res = Db::table("ims_sudu8_page_forum_reply")->insert($data);
            $result = [];
            if ($res) {
                $result['data'] = 1;
            } else {
                $result['data'] = 2;
            }
        } else {
            $data = array(
                "rid" => $rid,
                "uid" => $release_uid,
                "uniacid" => $uniacid,
                "content" => $content,
                "createtime" => date("Y-m-d H:i:s", time())
            );
            $res = Db::table("ims_sudu8_page_forum_comment")->insert($data);
            $result = [];
            if ($res) {
                $commentNum = Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->field("comment")->find()['comment'] + 1;
                Db::table('ims_sudu8_page_forum_release')->where("uniacid", $uniacid)->where("id", $rid)->update(array("comment" => $commentNum));
                $result['data'] = 1;
            } else {
                $result['data'] = 2;
            }
        }
        return json_encode($result);
    }
    //发布支付
    public function doPageForumOrder()
    {
        $uniacid = input("uniacid");
        $release_money = input("release_money") ? input("release_money") : 0;
        $stick_days = input("stick_days") ? input("stick_days") : 0;
        $stick_money = input("stick_money") ? input("stick_money") : 0;
        $openid = input("openid");
        $now = time();
        $orderid = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);  //订单号
        $data = array(
            "orderid" => $orderid,
            "uniacid" => $uniacid,
            "release_money" => $release_money,
            "stick_money" => $stick_money,
            "stick_days" => $stick_days,
            "openid" => $openid,
            "flag" => 2,
            "createtime" => date("Y-m-d H:i:s", time())
        );
        $orderResId = Db::table("ims_sudu8_page_forum_order")->insertGetId($data);
        if ($orderResId) {
            $body = "发布支付";
            $user = Db::table("ims_sudu8_page_user")->where("uniacid", $uniacid)->where("openid", $openid)->field("money,id")->find(); //用户余额
            if ($user['money'] >= ($release_money + $stick_days * $stick_money)) {
                //余额支付
                $payprice = $release_money + $stick_days * $stick_money;
                if ($payprice == 0) {
                } else {
                    $userMoney = $user['money'] - $payprice; //支付之后剩余余额
                    $update = Db::table("ims_sudu8_page_user")->where("uniacid", $uniacid)->where("openid", $openid)->update(array("money" => $userMoney));
                    if ($update) {
                        //流水
                        $xfmoney = array(
                            "uniacid" => $uniacid,
                            "orderid" => $orderid,
                            "uid" => $user['id'],
                            "type" => "del",
                            "score" => $payprice,
                            "message" => "微同城信息发布",
                            "creattime" => time()
                        );
                        Db::table('ims_sudu8_page_money')->insert($xfmoney);
                    }
                }
                $result = [];
                $result['data'] = array("type" => 1);
                Db::table("ims_sudu8_page_forum_order")->where("uniacid", $uniacid)->where("id", $orderResId)->update(array("flag" => 1));
            } else {
                //微信支付
                $payprice = ($release_money + $stick_money * $stick_days) - $user['money'];
                $types = "forum";
                $weixinpay = $this->getweixinpayinfo($uniacid, $openid, $orderid, $payprice, $body, $types . "|" . input('formId') . "|" . $uniacid);  //最后一个参数为附加参数，这里存订单类型+formId
                $weixinpay['err'] = 0;
                $weixinpay['message'] = "success";
                $weixinpay['type'] = 2;
                $result['data'] = $weixinpay;
            }
            return json_encode($result);
        }
    }
    //设置置顶
    public function doPageSetStick()
    {
        $uniacid = input("uniacid");
        $stick_money = input("stick_money");
        $stick_days = input("stick_days");
        $rid = input("rid");
        Db::table('ims_sudu8_page_forum_stick')->where("uniacid", $uniacid)->where("rid", $rid)->update(array('stick_status' => 2)); //修改所有发布相关置顶为不启用
        $data = array(
            "uniacid" => $uniacid,
            "rid" => $rid,
            "stick_money" => $stick_money,
            "stick_days" => $stick_days,
            "stick" => 1,
            "stick_time" => date("Y-m-d H:i:s", time()),
            "stick_status" => 1,
        );
        $res = Db::table('ims_sudu8_page_forum_stick')->insert($data);
        if ($res) {
            Db::table('ims_sudu8_page_forum_release')->where("uniacid", $uniacid)->where("id", $rid)->update(array('stick' => 1)); //修改发布表为置顶
            $result['data'] = 1;
        } else {
            $result['data'] = 2;
        }
        return json_encode($result);
    }
    //获取用户余额
    public function doPageGetUserMoney()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $userMoney = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->field("money")->find()['money'];
        $result = [];
        $result['data'] = $userMoney;
        return json_encode($result);
    }
    //改变论坛发布信息的点赞状态
    public function doPageForumLikes()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $rid = input("rid");
        $vs = input("vs");
        $uid = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->field("id")->find()['id'];
        $is = Db::table("ims_sudu8_page_forum_likes")->where("uniacid", $uniacid)->where("rid", $rid)->where("uid", $uid)->find();
        if ($is) {
            if ($is['likes'] == 1) {
                $likes = 2;
            } else {
                $likes = 1;
            }
            $res = Db::table("ims_sudu8_page_forum_likes")->where("uniacid", $uniacid)->where("rid", $rid)->where("uid", $uid)->update(array("likes" => $likes));
            if ($res) {
                $likesNum = Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->field("likes")->find()['likes'];
                if ($likes == 1) {
                    $likesNum = $likesNum + 1;
                } else {
                    $likesNum = $likesNum - 1;
                }
                Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->update(array("likes" => $likesNum));
               
                $result = [];
                if($vs){
                    $result['data']['is_like'] = $likes;
                }else{
                    $result['data'] = $likes;
                }
            }
        } else {
            $data = array(
                "uniacid" => $uniacid,
                "likes" => 1,
                "uid" => $uid,
                "rid" => $rid,
                "createtime" => date("Y-m-d H:i:s", time())
            );
            $res = Db::table("ims_sudu8_page_forum_likes")->insert($data);
            if ($res) {
                $likesNum = Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->field("likes")->find()['likes'];
                $likesNum = $likesNum + 1;
                Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->update(array("likes" => $likesNum));
                if($vs){
                    $result['data']['is_like'] = 1;
                }else{
                    $result['data'] = 1;
                }
            }
        }
        if($vs){
            $likesAll = Db::table("ims_sudu8_page_forum_likes")->alias("a")->join("ims_sudu8_page_user b", "a.uid = b.id")->where("a.uniacid", $uniacid)->where("a.rid", $rid)->where("a.likes", 1)->order("a.id desc")->field("b.nickname")->select();
            $result['data']['num'] = $likesNum;
            $result['data']['likesAll'] = $likesAll;
        }
        return json_encode($result);
    }
    //改变论坛发布信息的收藏状态
    public function doPageForumCollection()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $rid = input("rid");
        $vs = input("vs");
        $uid = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->field("id")->find()['id'];
        $is = Db::table("ims_sudu8_page_forum_collection")->where("uniacid", $uniacid)->where("rid", $rid)->where("uid", $uid)->find();
        if ($is) {
            if ($is['collection'] == 1) {
                $collection = 2;
            } else {
                $collection = 1;
            }
            $res = Db::table("ims_sudu8_page_forum_collection")->where("uniacid", $uniacid)->where("rid", $rid)->where("uid", $uid)->update(array("collection" => $collection));
            if ($res) {
                $collectionNum = Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->field("collection")->find()['collection'];
                if ($collection == 1) {
                    $collectionNum = $collectionNum + 1;
                } else {
                    $collectionNum = $collectionNum - 1;
                }
                Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->update(array("collection" => $collectionNum));
                $result = [];
                if($vs){
                    $result['data']['is_collect'] = $collection;
                }else{
                    $result['data'] = $collection;
                }
            }
        } else {
            $data = array(
                "uniacid" => $uniacid,
                "collection" => 1,
                "uid" => $uid,
                "rid" => $rid,
                "createtime" => date("Y-m-d H:i:s", time())
            );
            $res = Db::table("ims_sudu8_page_forum_collection")->insert($data);
            if ($res) {
                $collectionNum = Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->field("collection")->find()['collection'];
                $collectionNum = $collectionNum + 1;
                Db::table("ims_sudu8_page_forum_release")->where("uniacid", $uniacid)->where("id", $rid)->update(array("collection" => $collectionNum));
                if($vs){
                    $result['data']['is_collect'] = 1;
                }else{
                    $result['data'] = 1;
                }
            }
        }
        $result['data']['num'] = $collectionNum;
        return json_encode($result);
    }
    //评论点赞size
    public function doPageCommentChangeLikes()
    {
        $uniacid = input("uniacid");
        $commentType = input("commentType");
        $commentid = input("commentid");
        $openid = input("openid");
        $vs = input("vs");
        $is = Db::table("ims_sudu8_page_forum_comment_likes")->where("uniacid", $uniacid)->where("openid", $openid)->where("commentId", $commentid)->find();
        if ($commentType == 1) {
            $likesNum = Db::table("ims_sudu8_page_forum_comment")->where("uniacid", $uniacid)->where("id", $commentid)->field("likesNum")->find()['likesNum'];
            if ($is) {
                if ($is['likes'] == 1) {
                    $likesNum = $likesNum - 1;
                    Db::table("ims_sudu8_page_forum_comment_likes")->where("uniacid", $uniacid)->where("openid", $openid)->where("commentId", $commentid)->update(array("likes" => 2));
                    if($vs){
                        $res['data']['is_like'] = 2;
                    }else{
                        $res['data'] = 2;
                    }
                } else if ($is['likes'] == 2) {
                    Db::table("ims_sudu8_page_forum_comment_likes")->where("uniacid", $uniacid)->where("openid", $openid)->where("commentId", $commentid)->update(array("likes" => 1));
                    $likesNum = $likesNum + 1;
                    if($vs){
                        $res['data']['is_like'] = 1;
                    }else{
                        $res['data'] = 1;
                    }
                }
            } else {
                Db::table("ims_sudu8_page_forum_comment_likes")->insert(array(
                    "uniacid" => $uniacid,
                    "commentId" => $commentid,
                    "openid" => $openid,
                    "likes" => 1,
                    "createtime" => date("Y-m-d H:i:s", time())
                ));
                $likesNum = $likesNum + 1;
                if($vs){
                        $res['data']['is_like'] = 1;
                    }else{
                        $res['data'] = 1;
                    }
            }
            $res['data']['num'] = $likesNum;
            Db::table("ims_sudu8_page_forum_comment")->where("uniacid", $uniacid)->where("id", $commentid)->update(array("likesNum" => $likesNum));
            return json_encode($res);
            exit;
        }
        $reply_is = Db::table("ims_sudu8_page_forum_reply_likes")->where("uniacid", $uniacid)->where("openid", $openid)->where("replyId", $commentid)->find();
        if ($commentType == 2) {
            $likesNum = Db::table("ims_sudu8_page_forum_reply")->where("uniacid", $uniacid)->where("id", $commentid)->field("likesNum")->find()['likesNum'];
            if ($reply_is) {
                if ($reply_is['likes'] == 1) {
                    $likesNum = $likesNum - 1;
                    Db::table("ims_sudu8_page_forum_reply_likes")->where("uniacid", $uniacid)->where("openid", $openid)->where("replyId", $commentid)->update(array("likes" => 2));
                    if($vs){
                        $res['data']['is_like'] = 4;
                    }else{
                        $res['data'] = 4;
                    }
                } else if ($reply_is['likes'] == 2) {
                    Db::table("ims_sudu8_page_forum_reply_likes")->where("uniacid", $uniacid)->where("openid", $openid)->where("replyId", $commentid)->update(array("likes" => 1));
                    $likesNum = $likesNum + 1;
                    if($vs){
                        $res['data']['is_like'] = 3;
                    }else{
                        $res['data'] = 3;
                    }
                }
            } else {
                Db::table("ims_sudu8_page_forum_reply_likes")->insert(array(
                    "uniacid" => $uniacid,
                    "replyId" => $commentid,
                    "openid" => $openid,
                    "likes" => 1,
                    "createtime" => date("Y-m-d H:i:s", time())
                ));
                $likesNum = $likesNum + 1;
                if($vs){
                    $res['data']['is_like'] = 3;
                }else{
                    $res['data'] = 3;
                }
            }
            Db::table("ims_sudu8_page_forum_reply")->where("uniacid", $uniacid)->where("id", $commentid)->update(array("likesNum" => $likesNum));
            if($vs){
                $res['data']['num'] = $likesNum;
            }
            return json_encode($res);
        }
    }
    //发布详情页删除功能
    public function doPageForumPageDel()
    {
        $uniacid = input("uniacid");
        $types = input('types');
        $id = input('id');
        if ($types == 1) {
            $is = Db::table('ims_sudu8_page_forum_release')->where("uniacid", $uniacid)->where("id", $id)->find();
            if ($is) {
                $res = Db::table('ims_sudu8_page_forum_release')->where("uniacid", $uniacid)->where("id", $id)->delete();
                if ($res) {
                    //删除forum_likes表相关数据
                    Db::table('ims_sudu8_page_forum_likes')->where("uniacid", $uniacid)->where("rid", $id)->delete();
                    //删除forum_collection表相关数据
                    Db::table('ims_sudu8_page_forum_collection')->where("uniacid", $uniacid)->where("rid", $id)->delete();
                    //删除forum_comment 和 删除forum_comment_likes 和 forum_reply表相关数据
                    $commentall = Db::table('ims_sudu8_page_forum_comment')->where("uniacid", $uniacid)->where("rid", $id)->select();
                    foreach ($commentall as $key => $value) {
                        Db::table('ims_sudu8_page_forum_comment_likes')->where("uniacid", $uniacid)->where("commentId", $value['id'])->delete();
                        $replyall = Db::table('ims_sudu8_page_forum_reply')->where("uniacid", $uniacid)->where("commentId", $value['id'])->select();
                        foreach ($replyall as $k => $v) {
                            Db::table('ims_sudu8_page_forum_reply_likes')->where("uniacid", $uniacid)->where("replyId", $v['id'])->delete();
                        }
                        Db::table('ims_sudu8_page_forum_reply')->where("uniacid", $uniacid)->where("commentId", $value['id'])->delete();
                    }
                    Db::table('ims_sudu8_page_forum_comment')->where("uniacid", $uniacid)->where("rid", $id)->delete();
                    //删除forum_stick表相关数据
                    Db::table('ims_sudu8_page_forum_stick')->where("uniacid", $uniacid)->where("rid", $id)->delete();
                    $result['data'] = 1;
                }
            } else {
                $result['data'] = 2;
            }
        } else if ($types == 2) {  //删除评论
            $replyall = Db::table('ims_sudu8_page_forum_reply')->where("uniacid", $uniacid)->where("commentId", $id)->select();
            foreach ($replyall as $k => $v) {
                Db::table('ims_sudu8_page_forum_reply_likes')->where("uniacid", $uniacid)->where("replyId", $v['id'])->delete();
            }
            Db::table('ims_sudu8_page_forum_reply')->where("uniacid", $uniacid)->where("commentId", $id)->delete();
            Db::table('ims_sudu8_page_forum_comment')->where("uniacid", $uniacid)->where("id", $id)->delete();
            Db::table('ims_sudu8_page_forum_comment_likes')->where("uniacid", $uniacid)->where("commentId", $id)->delete();
            $result['data'] = 1;
        } else if ($types == 3) {  //删除评论回复
            Db::table('ims_sudu8_page_forum_reply_likes')->where("uniacid", $uniacid)->where("replyId", $id)->delete();
            Db::table('ims_sudu8_page_forum_reply')->where("uniacid", $uniacid)->where("id", $id)->delete();
            $result['data'] = 1;
        }
        return json_encode($result);
    }
    public function doPageGetForumCollect()
    {
        $uniacid = input("uniacid");
        $openid = input("openid");
        $page = input('page');
        $pindex = max(1, intval($page));
        $psize = 10;
        $begin = ($pindex - 1) * $psize;
        $list = Db::table('ims_sudu8_page_forum_collection')->alias('a')->join('ims_sudu8_page_forum_release b', 'b.id = a.rid')->join('ims_sudu8_page_user c', 'c.id = a.uid')->where('c.openid', $openid)->where("a.uniacid", $uniacid)->where("c.uniacid", $uniacid)->where("a.collection", 1)->order("a.id desc")->limit($begin, $psize)->field('a.*,b.content')->select();
        foreach ($list as $key => &$value) {
            $value['content'] = substr($value['content'], 0, 42);
        }
        $result['data'] = $list;
        return json_encode($result);
    }
    /*forum end*/
    //获取微信支付所需要的参数（所有订单公用接口）   $out_trade_no为订单号, $price必须是微信支付的金额!!!  $types标志订单类型 多规格为'duo' $body支付描述 如：商品支付
    public function getweixinpayinfo($uniacid, $openid, $out_trade_no, $payprice, $body, $info)
    {
        $app = Db::table('applet')->where('id', $uniacid)->find();
        include 'WeixinPay.php';
        $appid = $app['appID'];
        $openid = $openid;
        $mch_id = $app['mchid'];
        $key = $app['signkey'];
        // $out_trade_no = $out_trade_no; //订单号
        $total_fee = $payprice * 100;
        if (isset($app['identity'])) {
            $identity = $app['identity'];
        } else {
            $identity = 1;
        }
        if (isset($app['sub_mchid'])) {
            $sub_mchid = $app['sub_mchid'];
        } else {
            $sub_mchid = 0;
        }
        $body = $body;
        $weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee, $identity, $sub_mchid, $info);
        return $weixinpay->pay();
    }
    //支付完成回调（所有订单公用接口）
    public function dopagepaynotify()
    {

        $uniacid = input("uniacid");
        $orderid = input("out_trade_no");
        $openid = input("openid");
        $payprice = input("payprice");
        $types = input("types");
        $flag = input("flag");
        $formId = input("formId");
        $user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("openid", $openid)->find();
        if ($types == 'duo') {
            $order = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where("order_id", $orderid)->find();
            $data = array();

            $jsondata = unserialize($order['jsondata']);
            $fmsg = "";  //模板消息
            $total_num = 0;
            $total_price = 0;
            foreach ($jsondata as $key => &$value) {
                $total_num += $value['num'];
                $total_price += $value['proinfo']['price'] * $value['num'];
                //如果有购物车，删除对应的购物车
                
                $type_value = Db::table('ims_sudu8_page_duo_products_type_value')->where("id", $value['proinfo']['id'])->find();
                $fmsg .= "产品：" . $value['baseinfo']['title'] . " 购买数：" . $value['num'] . " 购买规格：" . $type_value['type1'] . " " . $type_value['type2'] . " " . $type_value['type3'] .
                    " 购买单价：" . $type_value['price'] . "元 ";
                if($type_value['kc'] < $value['num']){
                    $data = array(
                        'message' => '失败',
                    );
                    $result['data'] = $data;
                    return json_encode($result);
                }

                if ($value['id'] != 0) {
                    Db::table('ims_sudu8_page_duo_products_gwc')->where("uniacid", $uniacid)->where("id", $value['id'])->update(array("flag" => 2));
                }

                $data2 = array(
                    'kc' => $type_value['kc'] - $value['num'],
                    'salenum' => $type_value['salenum'] + $value['num'],
                );
                Db::table('ims_sudu8_page_duo_products_type_value')->where("id", $type_value['id'])->update($data2);
            }

            //更新余额
            if ($flag == '0') {
                // $money = floatval($user['money']) - floatval($payprice);
                // $data['money'] = $money;
                if($user['money'] < $payprice){
                    $dd12['data'] = array('message'=>'失败', 'money' => $user['money']);
                    return json_encode($dd12);
                }else{
                    $money = floatval($user['money']) - floatval($payprice);
                    $data['money'] = $money;
                }
            }
            if ($flag == '1') {
                $data['money'] = 0;
            }
            //更新积分
            if ($order['jf']) {
                $score = floatval($user['score']) - floatval($order['jf']);
                if ($score < 0) $score = 0;
                $data['score'] = $score;
            }
            Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("id", $user['id'])->update($data);
            //更新订单状态
            Db::table('ims_sudu8_page_duo_products_order')->where("uniacid", $uniacid)->where("order_id", $orderid)->update(array("flag" => 1));
            //更新优惠券使用情况
            if ($order['coupon'] != '0') {
                Db::table('ims_sudu8_page_coupon_user')->where("uniacid", $uniacid)->where("id", $order['coupon'])->update(array("flag" => 1,"utime"=>time()));
            }

            //购买送积分
            $scoreback = Db::table('ims_sudu8_page_products')->where('uniacid', $uniacid)->where("id", $jsondata[0]['baseinfo']['id'])->find()['scoreback'];
            if (!empty($scoreback)) {
                if (strpos($scoreback, "%")) {
                    $scoreback = floatval(chop($scoreback, "%"));
                    $scoretomoney = Db::table('ims_sudu8_page_rechargeconf')->where("uniacid", $uniacid)->find();
                    $scoreback = $total_price * $scoreback / 100;
                    $scoreback = floor($scoreback * intval($scoretomoney['scroe']) / intval($scoretomoney['money']));
                } else {
                    $scoreback = floor($total_num * floatval($scoreback));
                }
                if ($scoreback > 0) {
                    $new_user = Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("id", $user['id'])->find();
                    $new_my_score = $new_user['score'] + $scoreback;
                    Db::table('ims_sudu8_page_user')->where("uniacid", $uniacid)->where("id", $new_user['id'])->update(array("score" => $new_my_score));
//                    $scoreback=Db::table("ims_sudu8_page_score")->where("uniacid",$appletid)->where("uid",$order['uid'])->where("orderid",$order["order_id"])->where("type","add")->where("message","买送积分")->find();
                    $xfscore3 = array(
                        "uniacid" => $uniacid,
                        "orderid" => $orderid,
                        "uid" => $user['id'],
                        "type" => "add",
                        "score" => $scoreback,
                        "message" => "买送积分",
                        "creattime" => time()
                    );
                    Db::table('ims_sudu8_page_score')->insert($xfscore3);
                }
            }
            //金钱流水
            if ($order['price'] > 0) {
                $xfmoney = array(
                    "uniacid" => $uniacid,
                    "orderid" => $orderid,
                    "uid" => $user['id'],
                    "type" => "del",
                    "score" => $order['price'],
                    "message" => "消费",
                    "creattime" => time()
                );
                Db::table('ims_sudu8_page_money')->insert($xfmoney);
            }
            //积分流水
            if ($order['jf'] > 0) {
                $xfscore = array(
                    "uniacid" => $uniacid,
                    "orderid" => $orderid,
                    "uid" => $user['id'],
                    "type" => "del",
                    "score" => $order['jf'],
                    "message" => "消费",
                    "creattime" => time()
                );
                Db::table('ims_sudu8_page_score')->insert($xfscore);
            }
            //发送模板消息to顾客
            $flag = 6;
            $data8 = array(
                'orderid' => $orderid,
                'fmsg' => $fmsg,
                'fprice' => $order['price']
            );
            $this->sendTplMessage($uniacid, $flag, $openid, $formId, 'duo_zf', $data8);
            //发送邮件提醒to商家
            $this->sendMailToAdmin($uniacid, $orderid, 'duo');
        }
        if ($types == "forum") {
            Db::table("ims_sudu8_page_forum_order")->where("uniacid", $uniacid)->where("orderid", $orderid)->update(array("flag" => 1));
            //流水
            $xfmoney = array(
                "uniacid" => $uniacid,
                "orderid" => $orderid,
                "uid" => $user['id'],
                "type" => "del",
                "score" => $payprice,
                "message" => "论坛信息发布",
                "creattime" => time()
            );
            Db::table('ims_sudu8_page_money')->insert($xfmoney);
        }
        if($types == "miaosha"){
            //$order = pdo_get("sudu8_page_order", array("uniacid"=>$uniacid, "order_id"=>$orderid));
            $order = Db::table('ims_sudu8_page_order')->where('uniacid', $uniacid) ->where('order_id', $orderid) ->find();
            // $user = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "openid"=>$openid));
            $user = Db::table('ims_sudu8_page_user') ->where('uniacid', $uniacid) ->where('openid', $openid) ->find();
            //$product = pdo_get("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$order['pid']));
            $product = Db::table('ims_sudu8_page_products') ->where('uniacid', $uniacid) ->where('id', $order['pid']) ->find();
            if($product['pro_kc'] < $order['num']){
                    $data = array(
                        'message' => '失败',
                    );
                    $result['data'] = $data;
                    return json_encode($result);
                }
            $data = array();
            //更新余额
            if($flag == '0'){
                if($user['money'] < $payprice){
                    $dd11['data'] = array('message'=>'失败', 'money' => $user['money']);
                    return json_encode($dd11);
                }else{
                    $money = floatval($user['money']) - floatval($payprice);
                    $data['money'] = $money;
                }
                
            }
            if($flag == '1'){
                $data['money'] = 0;
            }
            //更新积分
            if($order['dkscore']){
                $score = floatval($user['score']) - floatval($order['dkscore']);    
                if($score < 0) $score = 0;
                $data['score'] = $score;
            }
            // pdo_update("sudu8_page_user", $data, array("uniacid"=>$uniacid, "id"=>$user['id']));
            Db::table('ims_sudu8_page_user') ->where('uniacid', $uniacid) ->where('id', $user['id']) ->update($data);
            //更新订单状态
            // pdo_update("sudu8_page_order", array("flag" => 1), array("uniacid" => $uniacid, "order_id" => $orderid));
            Db::table('ims_sudu8_page_order') ->where('uniacid', $uniacid) ->where('order_id', $orderid) ->update(['flag' => 1]);
            //更新优惠券使用情况
            if($order['coupon'] != '0'){
                // pdo_update("sudu8_page_coupon_user", array("flag" => 1), array("uniacid" => $uniacid, "id" => $order['coupon']));
                Db::table('ims_sudu8_page_coupon_user') ->where('uniacid', $uniacid) ->where('id', $order['coupon']) ->update(array('flag' => 1,"utime"=>time()));
            }
            //库存处理
            

            if($product['pro_kc'] != -1){   //库存不限量
                $kucun = intval($product['pro_kc']) >= intval($order['num']) ? intval($product['pro_kc']) - intval($order['num']) : 0;
                $sale_tnum = $product['sale_tnum'] + $order['num'];
                // pdo_update("sudu8_page_products", array("pro_kc"=>$kucun, "sale_tnum"=>$sale_tnum), array("uniacid"=>$uniacid, "id"=>$product['id']));
                Db::table('ims_sudu8_page_products') ->where('uniacid', $uniacid) ->where('id', $product['id']) ->update(['pro_kc' =>$kucun, 'sale_tnum' =>$sale_tnum]);
            }else{
                $sale_tnum = $product['sale_tnum'] + $order['num'];
                Db::table('ims_sudu8_page_products') ->where('uniacid', $uniacid) ->where('id', $product['id']) ->update(['sale_tnum' =>$sale_tnum]);
            }

            //金钱流水
            if($order['true_price'] > 0){
                $xfmoney = array(
                    "uniacid" => $uniacid,
                    "orderid" => $orderid,
                    "uid" => $user['id'],
                    "type" => "del",
                    "score" => $order['true_price'],
                    "message" => "消费",
                    "creattime" => time()
                );
                // pdo_insert("sudu8_page_money", $xfmoney);
                Db::table('ims_sudu8_page_money') ->insert($xfmoney);
            }
            //积分流水
            if($order['dkscore'] > 0){
                $xfscore = array(
                    "uniacid" => $uniacid,
                    "orderid" => $orderid,
                    "uid" => $user['id'],
                    "type" => "del",
                    "score" => $order['dkscore'],
                    "message" => "消费",
                    "creattime" => time()
                );
                // pdo_insert("sudu8_page_score", $xfscore);
                Db::table('ims_sudu8_page_score') ->insert($xfscore);
            }
            //发送模板消息to顾客
            $fmsg = "产品：" . $order['product'] . " 购买数：" . $order['num'] . " 购买单价：" . $order['price'] . "元 ";
            $flag2 = 6;
            $data8 = array(
                'orderid' => $orderid,
                'fmsg' => $fmsg,
                'fprice' => $order['true_price']
            );
            $aaaaa =  $this->sendTplMessage($uniacid, $flag2, $openid, $formId, 'duo_zf', $data8);
            
            //发送邮件提醒to商家
            $this->sendMailToAdmin($uniacid, $orderid, 'miaosha');
            $dd['data'] = array('message'=>'成功');
            return json_encode($dd);
        }
        $data = array(
            'message' => '成功',
        );
        $result['data'] = $data;
        return json_encode($result);
    }
    //摇一摇相关开始
    public function doPageshareSuccess()
    {
        $uniacid = input('uniacid');
        $aid = input('id');
        $openid = input('openid');
        if (!empty($aid) && !empty($openid)) {
            //$uid = pdo_getcolumn("sudu8_page_user", array("uniacid"=>$uniacid, "openid"=>$openid), "id");
            $uid = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->field('id')->find();
            $uid = $uid['id'];
            // $share_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_lottery_share")." WHERE uniacid = :uniacid and flag = 1 and uid = :uid and aid = :aid and to_days(from_unixtime(`createtime`)) = to_days(now())", array(":uniacid"=>$uniacid, ":uid"=>$uid, ":aid"=>$aid));
            $where = [
                'uniacid' => $uniacid,
                'flag' => 1,
                'uid' => $uid,
                'aid' => $aid,
            ];
            //$share_num = Db::table('ims_sudu8_page_lottery_share') ->where($where) ->where('createtime', time())->count();
            $share_num = Db::table('ims_sudu8_page_lottery_share')->where($where)->whereTime('createtime', 'today')->count();
            // $total_share_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_lottery_share")." WHERE uniacid = :uniacid and flag = 1 and uid = :uid and aid = :aid",
            //                  array(":uniacid"=>$uniacid, ":uid"=>$uid, ":aid"=>$aid));
            $total_share_num = Db::table('ims_sudu8_page_lottery_share')->where($where)->count();
            //$activity = pdo_get("sudu8_page_lottery_activity", array("uniacid"=>$uniacid, "id"=>$aid));
            $activity = Db::table('ims_sudu8_page_lottery_activity')->where('uniacid', $uniacid)->where('id', $aid)->find();
            $base = unserialize($activity['base']);
            if ($share_num >= $base['everyday_share'] || $total_share_num >= $base['total_share']) {
                $flag = false;
            } else {
                $data = array(
                    'uniacid' => $uniacid,
                    'aid' => $aid,
                    'uid' => $uid,
                    'createtime' => time(),
                    'flag' => 1
                );
                //pdo_insert("sudu8_page_lottery_share", $data);
                Db::table('ims_sudu8_page_lottery_share')->insert($data);
                $flag = true;
            }
            return json_encode($flag);
            //return $this->result(0, 'success', $flag);
        }
    }
    public function doPagegetConfig()
    {
        $uniacid = input('uniacid');
        $aid = input('id');
        $openid = input('openid');
        //$config = pdo_fetch("SELECT * FROM ".tablename("sudu8_page_lottery_activity")." WHERE uniacid = :uniacid and id=:id",array(":uniacid"=>$uniacid, ":id"=>$aid));
        $config = Db::table('ims_sudu8_page_lottery_activity')->where('uniacid', $uniacid)->where('id', $aid)->find();
        $config['share'] = intval($config['share']);
        $config['browse'] = intval($config['browse']);
        $config['win'] = intval($config['win']);
        $config['participate'] = intval($config['participate']);
        $config['base'] = unserialize($config['base']);
        if (empty($config['base']) || $config['status'] == '0') {
            $config['flag'] = 0; //活动未开启
        } else if (time() < $config['begin']) {
            $config['flag'] = 1; //活动尚未开始
        } else if (time() > $config['end']) {
            $config['flag'] = 2; //活动已结束
        } else {
            $config['flag'] = 3;
        }
        $config['bg_changed'] = false;
        if (!strstr($config['bg'], "image/bg.jpg")) {
            $config['bg_changed'] = true;
        }
        if ($config['bg'] && !strstr($config['bg'], "http")) {
            $config['bg'] = ROOT_HOST . $config['bg'];
        }
        if ($config['text_img1'] && !strstr($config['text_img1'], "http")) {
            $config['text_img1'] = ROOT_HOST . $config['text_img1'];
        }
        if ($config['text_img2'] && !strstr($config['text_img2'], "http")) {
            $config['text_img2'] = ROOT_HOST . $config['text_img2'];
        }
        $config['remaintime'] = ($config['end'] - time()) * 1000;
        $config['begin'] = date("Y-m-d H:i:s", $config['begin']);
        $config['end'] = date("Y-m-d H:i:s", $config['end']);
        // $user = pdo_fetch("SELECT * FROM ".tablename("sudu8_page_user"). " WHERE uniacid = :uniacid and openid = :openid",
        //                      array(":uniacid"=>$uniacid, ":openid"=>$openid));
        $user = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        //用户是否是vip
        $config['is_vip'] = $user['vipid'];
        if ($config['is_vip'])
            $config['is_vip'] = true;
        else
            $config['is_vip'] = false;
        $config['fill_info'] = true;
        if (!$config['is_vip']) {
            if (empty($user['mobile']) || empty($user['address']) || empty($user['realname'])) {
                $config['fill_info'] = false;
            }
        }
        // $record_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_lottery_record")." WHERE uniacid = :uniacid and uid = :uid and to_days(from_unixtime(`createtime`)) = to_days(now())",
        //              array(":uniacid" => $uniacid, ":uid" => $user['id']));
        $record_num = Db::table('ims_sudu8_page_lottery_record')->where('uniacid', $uniacid)->where('uid', $user['id'])->whereTime('createtime', 'today')->count();
        if (empty($record_num))
            $record_num = 0;
        // $win_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_lottery_record")." WHERE uniacid = :uniacid and uid = :uid and status in (1,2)", array(":uniacid" => $uniacid, ":uid" => $user['id']));
        $win_num = Db::table('ims_sudu8_page_lottery_record')->where('uniacid', $uniacid)->where('uid', $user['id'])->where('status', 'in', [1, 2])->count();
        if (empty($win_num))
            $win_num = 0;
        // $share_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_lottery_share")." WHERE uniacid = :uniacid and flag = 1 and uid = :uid and aid = :aid and to_days(from_unixtime(`createtime`)) = to_days(now())", array(":uniacid"=>$uniacid, ":uid"=>$user['id'], ":aid"=>$aid));
        $share_num = Db::table('ims_sudu8_page_lottery_share')->where('uniacid', $uniacid)->where('flag', 1)->where('uid', $user['id'])->whereTime('createtime', 'today')->count();
        if (empty($share_num))
            $share_num = 0;
        // $total_share_num = pdo_fetchcolumn("SELECT count(*) FROM ".tablename("sudu8_page_lottery_share")." WHERE uniacid = :uniacid and flag = 1 and uid = :uid and aid = :aid",
        //                      array(":uniacid"=>$uniacid, ":uid"=>$user['id'], ":aid"=>$aid));
        $total_share_num = Db::table('ims_sudu8_page_lottery_share')->where('uniacid', $uniacid)->where('flag', 1)->where('uid', $user['id'])->count();
        if (empty($total_share_num)) {
            $total_share_num = 0;
        }
        $config['record_num'] = intval($record_num);
        $config['share_num'] = intval($share_num);
        $config['total_share_num'] = intval($total_share_num);
        $config['win_num'] = intval($win_num);
        $config['user_jifen'] = intval($user['score']);
        $config['userinfo'] = array(
            'id' => $user['id'],
            'realname' => $user['realname'],
            'mobile' => $user['mobile'],
            'address' => $user['address'],
            'avatar' => $user['avatar'],
            'nickname' => $user['nickname'],
        );
        $config['fail_img'] = ROOT_HOST . "/image/fail.png";
        $config['success_img'] = ROOT_HOST . "/image/success1.png";
        $config['deng_img'] = ROOT_HOST . "/image/deng.gif";
        // remote($uniacid,$value['thumb'],1);
        $data['data'] = $config;
        // dump($config);die;
        return json_encode($data);
        //return $this->result(0, 'success', $config);
    }
    public function doPagedrawLottery()
    {
        $uniacid = input('uniacid');
        $aid = input('id');
        $openid = input('openid');
        //增加一次参与人数
        // pdo_query("UPDATE ".tablename("sudu8_page_lottery_activity")." SET participate = participate + 1 where uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$aid));
        Db::table('ims_sudu8_page_lottery_activity')->where('uniacid', $uniacid)->where('id', $aid)->setInc('participate');
        // $user = pdo_get('sudu8_page_user', array("uniacid"=>$uniacid, "openid"=>$openid));
        $user = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        // $activity = pdo_get('sudu8_page_lottery_activity', array("uniacid"=>$uniacid, "id"=>$aid));
        $activity = Db::table('ims_sudu8_page_lottery_activity')->where('uniacid', $uniacid)->where('id', $aid)->find();
        $activity['base'] = unserialize($activity['base']);
        //扣除积分
        $jifen = array(
            'score' => floatval($user['score']) - floatval($activity['base']['jifen'])
        );
        // pdo_update("sudu8_page_user", $jifen, array("uniacid"=>$uniacid, "id"=>$user['id']));
        Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('id', $user['id'])->update($jifen);
        for ($i = 1; $i <= 8; $i++) {
            // $temp = pdo_fetch("SELECT id,title,chance,storage,types,detail FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and num like '%".$i."%'",
            //                 array(":uniacid" => $uniacid, ':aid' => $aid));
            $temp = Db::table('ims_sudu8_page_lottery_prize')->where('uniacid', $uniacid)->where('aid', $aid)->where('num', 'like', "%$i%")->field('id,title,chance,storage,types,detail')->find();
            if (!empty($temp)) {
                $prizes[$i] = $temp;
            } else {
                $empty[$i] = $i;
            }
        }
        $data = array(
            "uniacid" => $uniacid,
            "aid" => $aid,
            "uid" => $user['id'],
            "createtime" => time(),
            "status" => 0
        );
        //抽奖随机数
        $lucky = rand(1, 10000);
        //1~10000
        for ($i = 1; $i <= 10000; $i++) {
            $rand_array[$i] = 0;
        }
        $prizes2 = $prizes; //保存$prizes到后面使用
        $prizes_num = count($prizes);
        for ($i = 1; $i <= $prizes_num; $i++) {
            $index = array_rand($prizes, 1);
            $prize = $prizes[$index];        //从奖品中随机取出一个
            unset($prizes[$index]);        //取出后从数组中删除
            if($prize['chance'] != 0){
                $luckys = array_rand($rand_array, $prize['chance']);
                if (!is_array($luckys)) {
                    $luckys = array($luckys);
                }
                $in = in_array($lucky, $luckys);
                if ($in && $prize['storage'] > 0) {  //抽奖随机数在`10000个数中随机取出的chance个数`中,且奖品库存大于0
                    $prize['index'] = $index;
                    $prize['flag'] = true;
                    $data['pid'] = $prize['id'];
                    // pdo_query("UPDATE ".tablename("sudu8_page_lottery_prize")." SET storage = storage - 1 WHERE uniacid = :uniacid and id = :id",
                    //          array(":uniacid"=>$uniacid, ":id"=>$prize['id']));
                    Db::table('ims_sudu8_page_lottery_prize')->where('uniacid', $uniacid)->where('id', $prize['id'])->setDec('storage');
                    // $u = pdo_get('sudu8_page_user', array("uniacid"=>$uniacid, "openid"=>$openid));
                    $u = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
                    if ($prize['types'] == '1') {
                        $newJifen = floatval($u['score']) + floatval($prize['detail']);
                        //pdo_update("sudu8_page_user", array("score"=>$newJifen), array("uniacid"=>$uniacid, "id"=>$u['id']));
                        Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('id', $u['id'])->update(['score' => $newJifen]);
                        $data['status'] = 2;
                    }
                    if ($prize['types'] == '2') {
                        $newYue = floatval($u['money']) + floatval($prize['detail']);
                        // pdo_update("sudu8_page_user", array("money"=>$newYue), array("uniacid"=>$uniacid, "id"=>$u['id']));
                        Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('id', $u['id'])->update(['money' => $newYue]);
                        $data['status'] = 2;
                    }
                    if ($prize['types'] == '4') {
                        //$coupon = pdo_get("sudu8_page_coupon", array("uniacid"=>$uniacid, "id"=>intval($prize['detail'])));
                        $coupon = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', intval($prize['detail']))->find();
                        $coupon_user = array(
                            'uniacid' => $uniacid,
                            'uid' => $u['id'],
                            'cid' => $coupon['id'],
                            'ltime' => time(),
                            'btime' => $coupon['btime'],
                            'etime' => $coupon['etime'],
                            'flag' => 0,
                            'utime'=>0
                        );
                        // pdo_insert("sudu8_page_coupon_user", $coupon_user);
                        Db::table('ims_sudu8_page_coupon_user')->insert($coupon_user);
                        $data['status'] = 2;
                    }
                    if ($prize['types'] == '3') {
                        $data['status'] = 1;
                    }
                    // pdo_insert("sudu8_page_lottery_record", $data);
                    Db::table('ims_sudu8_page_lottery_record')->insert($data);
                    //增加一次中奖人数
                    // pdo_query("UPDATE ".tablename("sudu8_page_lottery_activity")." SET win = win + 1 where uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$aid));
                    Db::table('ims_sudu8_page_lottery_activity')->where('uniacid', $uniacid)->where('id', $aid)->setInc('win');
                    $data['data'] = $prize;
                    //return $this->result(0, 'success', $prize);
                    return json_encode($data);
                }
            }
        }
        $prizes3 = $prizes2;
        $data2 = array(
            "uniacid" => $uniacid,
            "aid" => $aid,
            "uid" => $user['id'],
            "createtime" => time(),
            "status" => 0
        );
        if ($prizes_num == 8) {
            array_multisort(array_column($prizes2, 'chance'), SORT_DESC, $prizes2);
            for ($i = 1; $i <= count($prizes2); $i++) {
                if ($prizes2[$i] && $prizes2[$i]['storage'] > 0) {
                    $priz = $prizes2[$i];
                    for ($j = 1; $j <= count($prizes3); $j++) {
                        if ($priz['id'] == $prizes3[$j]['id']) {
                            $priz['index'] = $j;
                            break;
                        }
                    }
                    $priz['flag'] = true;
                    $data2['pid'] = $priz['id'];
                    // pdo_query("UPDATE ".tablename("sudu8_page_lottery_prize")." SET storage = storage - 1 WHERE uniacid = :uniacid and id = :id",
                    //      array(":uniacid"=>$uniacid, ":id"=>$priz['id']));
                    Db::table('ims_sudu8_page_lottery_prize')->where('uniacid', $uniacid)->where('id', $priz['id'])->setDec('storage');
                    //$u = pdo_get('sudu8_page_user', array("uniacid"=>$uniacid, "openid"=>$openid));
                    $u = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
                    if ($priz['types'] == '1') {
                        $newJifen = floatval($u['score']) + floatval($priz['detail']);
                        //pdo_update("sudu8_page_user", array("score"=>$newJifen), array("uniacid"=>$uniacid, "id"=>$u['id']));
                        Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('id', $u['id'])->update(['score' => $newJifen]);
                        $data2['status'] = 2;
                    }
                    if ($priz['types'] == '2') {
                        $newYue = floatval($u['money']) + floatval($priz['detail']);
                        //pdo_update("sudu8_page_user", array("money"=>$newYue), array("uniacid"=>$uniacid, "id"=>$u['id']));
                        Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('id', $u['id'])->update(['money' => $newYue]);
                        $data2['status'] = 2;
                    }
                    if ($priz['types'] == '4') {
                        // $coupon = pdo_get("sudu8_page_coupon", array("uniacid"=>$uniacid, "id"=>intval($priz['detail'])));
                        $coupon = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', intval($priz['detail']))->find();
                        $coupon_user = array(
                            'uniacid' => $uniacid,
                            'uid' => $u['id'],
                            'cid' => $coupon['id'],
                            'ltime' => time(),
                            'btime' => $coupon['btime'],
                            'etime' => $coupon['etime'],
                            'flag' => 0,
                            'utime'=>0
                        );
                        //pdo_insert("sudu8_page_coupon_user", $coupon_user);
                        Db::table('ims_sudu8_page_coupon_user')->insert($coupon_user);
                        $data2['status'] = 2;
                    }
                    if ($priz['types'] == '3') {
                        $data2['status'] = 1;
                    }
                    //pdo_insert("sudu8_page_lottery_record", $data2);
                    Db::table('ims_sudu8_page_lottery_record')->insert($data2);
                    //增加一次中奖人数
                    // pdo_query("UPDATE ".tablename("sudu8_page_lottery_activity")." SET win = win + 1 where uniacid = :uniacid and id = :id",array(":uniacid"=>$uniacid, ":id"=>$aid));
                    Db::table('ims_sudu8_page_lottery_activity')->where('uniacid', $uniacid)->where('id', $aid)->setInc('win');
                    $data['data'] = $priz;
                    return json_encode($data);
                    //return $this->result(0, 'success', $priz);
                }
            }
        }
        //pdo_insert("sudu8_page_lottery_record", $data);
        Db::table('ims_sudu8_page_lottery_record')->insert($data);
        $data['data'] = array('flag' => false, 'empty' => array_rand($empty, 1));
        return json_encode($data);
        // return $this->result(0, 'success', array('flag'=>false, 'empty'=>array_rand($empty, 1)));
    }
    public function doPagechangeUserinfo()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        $data = array(
            'realname' => input('name'),
            'mobile' => input('mobile'),
            'address' => input('address')
        );
        // pdo_update("sudu8_page_user", $data, array("uniacid"=>$uniacid, "openid"=>$openid));
        Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->update($data);
        $data['data'] = array('ok');
        return json_encode($data);
        //return $this->result(0, 'success', 'ok');
    }
    public function doPageshowThreeLucky()
    {
        $uniacid = input('uniacid');
        $id = input('id');
        // $threeRecord = pdo_fetchall("SELECT b.detail,b.types,c.nickname FROM ".tablename("sudu8_page_lottery_record")." as a join ".tablename("sudu8_page_lottery_prize")." as b on a.pid = b.id join ".tablename("sudu8_page_user")." as c on a.uid = c.id WHERE a.uniacid = :uniacid and a.aid = :id and a.status != 0 order by a.createtime desc LIMIT 3",array(":uniacid"=>$uniacid, ":id"=>$id));
        $threeRecord = Db::table('ims_sudu8_page_lottery_record')->alias('a')->join('ims_sudu8_page_lottery_prize b', 'a.pid = b.id')->join('ims_sudu8_page_user c', 'a.uid = c.id')->where('a.uniacid', $uniacid)->where('a.aid', $id)->where('a.status', 'neq', 0)->field('b.detail,b.types,c.nickname')->order('a.createtime desc')->limit(3)->select();
        if (empty($threeRecord)) {
            // $prize = pdo_fetch("SELECT detail,types FROM ".tablename("sudu8_page_lottery_prize")." WHERE uniacid = :uniacid and aid = :aid and num != '' order by chance desc LIMIT 1",
            //          array(':uniacid'=>$uniacid, ':aid'=>$id));
            $prize = Db::table('ims_sudu8_page_lottery_prize')->where('uniacid', $uniacid)->where('aid', $id)->where('num', 'neq', '')->order('chance desc')->find();
            if ($prize['types'] == '4') {
                // $coupon = pdo_get("sudu8_page_coupon", array("uniacid"=>$uniacid, "id"=>intval($prize['detail'])));
                $coupon = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', intval($prize['detail']))->find();
                $prize['detail'] = $coupon['title'];
            }
            for ($i = 0; $i <= 2; $i++) {
                $threeRecord[$i]['types'] = $prize['types'];
                $threeRecord[$i]['detail'] = $prize['detail'];
            }
            $threeRecord[0]['nickname'] = "王**";
            $threeRecord[1]['nickname'] = "m**";
            $threeRecord[2]['nickname'] = "s**";
        } else {
            foreach ($threeRecord as $key => &$value) {
                $value['nickname'] = rawurldecode($value['nickname']);
                if ($value['types'] == '4') {
                    // $coupon = pdo_get("sudu8_page_coupon", array("uniacid"=>$uniacid, "id"=>intval($value['detail'])));
                    $coupon = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', intval($value['detail']))->find();
                    $value['detail'] = $coupon['title'];
                }
            }
        }
        $data['data'] = $threeRecord;
        // return $this->result(0, 'success', $threeRecord);
        return json_encode($data);
    }
    public function doPagegetRecordList()
    {
        $uniacid = input('uniacid');
        $id = input('id');
        $openid = input('openid');
        // $user = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "openid"=>$openid));
        $user = Db::table('ims_sudu8_page_user')->where('uniacid', $uniacid)->where('openid', $openid)->find();
        // $records = pdo_fetchall("SELECT a.status,a.createtime,b.detail,b.types FROM ".tablename("sudu8_page_lottery_record")." as a join ".tablename("sudu8_page_lottery_prize")." as b on a.pid = b.id WHERE a.uniacid = :uniacid and a.aid = :aid and a.uid = :uid and a.status != 0 order by a.createtime desc",
        //              array(":uniacid"=>$uniacid, ":aid"=>$id, ":uid"=>$user['id']));
        $records = Db::table('ims_sudu8_page_lottery_record')->alias('a')->join('ims_sudu8_page_lottery_prize b', 'a.pid = b.id')->where('a.uniacid', $uniacid)->where('a.aid', $id)->where('a.uid', $user['id'])->where('a.status', 'neq', 0)->order('a.createtime desc')->field('a.status,a.createtime,b.detail,b.types')->select();
        foreach ($records as $key => &$value) {
            if ($value['types'] == '1') {
                $value['detail'] .= '积分';
            }
            if ($value['types'] == '2') {
                $value['detail'] .= '元';
            }
            if ($value['types'] == '4') {
                // $value['detail'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and id = :id",
                //                                                array(":uniacid"=>$uniacid, ":id"=>$value['detail']));
                $value['detail'] = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', $value['detail'])->find();
            }
            $value['createtime'] = date("Y-m-d H:i:s", $value['createtime']);
        }
        $data['data'] = array("records" => $records, "userinfo" => $user);
        return json_encode($data);
    }
    public function doPagegetPrizeList()
    {
        $uniacid = input('uniacid');
        $id = input('id');
        for ($i = 1; $i <= 8; $i++) {
            // $temp = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and num like '%".$i."%'",
            //                                      array(':uniacid'=>$uniacid, ':aid'=>$id));
            $temp = Db::table('ims_sudu8_page_lottery_prize')->where('uniacid', $uniacid)->where('aid', $id)->where('num', 'like', "%$i%")->find();
            if ($temp) {
                $prizes[] = $temp;
            }
        }
        foreach ($prizes as $key => &$value) {
            if ($value['thumb']) {
                $value['thumb'] = remote($uniacid, $value['thumb'], 1);
            }
            if ($value['types'] == '1') {
                $value['detail'] .= '积分';
            }
            if ($value['types'] == '2') {
                $value['detail'] .= '元';
            }
            if ($value['types'] == '4') {
                // $value['detail'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and id = :id",
                //                                                array(":uniacid"=>$uniacid, ":id"=>$value['detail']));
                $c = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', $value['detail'])->find();
                $value['detail'] = $c['title'];
            }
        }
        array_multisort(array_column($prizes, 'chance'), SORT_ASC, $prizes);
        $data['data'] = $prizes;
        return json_encode($data);
    }
    public function doPagegetPrizes()
    {
        $uniacid = input('uniacid');
        $id = input('id');
        //每进入一次只会请求一次，所以可以作为浏览量的依据
        // $result = pdo_query("UPDATE ".tablename("sudu8_page_lottery_activity")." SET browse = browse + 1 where uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$id));
        $result = Db::table('ims_sudu8_page_lottery_activity')->where('uniacid', $uniacid)->where('id', $id)->setInc('browse');
        $prizes = [];
        for ($i = 1; $i <= 8; $i++) {
            // $prizes[$i] = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_lottery_prize')." WHERE uniacid = :uniacid and aid = :aid and num like '%".$i."%'",
            //                                      array(':uniacid'=>$uniacid, ':aid'=>$id));
            $prizes[$i] = Db::table('ims_sudu8_page_lottery_prize')->where('uniacid', $uniacid)->where('aid', $id)->where('num', 'like', "%$i%")->find();
        }
        $a = request()->domain();
        foreach ($prizes as $key => &$value) {
            if ($value['thumb']) {
                $value['thumb'] = remote($uniacid, $value['thumb'], 1);
            }
            if ($value['types'] == '1') {
                $value['detail'] .= '积分';
            }
            if ($value['types'] == '2') {
                $value['detail'] .= '元';
            }
            if ($value['types'] == '4') {
                // $value['detail'] = pdo_fetchcolumn("SELECT title FROM ".tablename('sudu8_page_coupon')." WHERE uniacid = :uniacid and id = :id",
                //                                                array(":uniacid"=>$uniacid, ":id"=>$value['detail']));
                $c = Db::table('ims_sudu8_page_coupon')->where('uniacid', $uniacid)->where('id', $value['detail'])->find();
                $value['detail'] = $c['title'];
            }
        }
        $data['data'] = $prizes;
        return json_encode($data);
    }
    //增加分享次数
    public function doPageaddsharenum()
    {
        $uniacid = input('uniacid');
        $id = input('id');
        // pdo_query("UPDATE ".tablename("sudu8_page_lottery_activity")." SET share = share + 1 where uniacid = :uniacid and id = :id", array(":uniacid"=>$uniacid, ":id"=>$id));
        Db::table('ims_sudu8_page_lottery_activity')->where('uniacid', $uniacid)->where('id', $id)->setInc('share');
        $data['data'] = array('ok');
        return json_encode($data);
    }
    //获取积分规则
    public function doPagescoreget()
    {
        $uniacid = input('uniacid');
        //$guiz = pdo_fetchall("SELECT * FROM ".tablename("sudu8_page_score_get")." WHERE uniacid = :uniacid order by id asc", array(":uniacid"=>$uniacid));
        $guiz = Db::table('ims_sudu8_page_score_get')->where('uniacid', $uniacid)->order('id asc')->select();
        $data['data'] = array("guiz" => $guiz);
        return json_encode($data);
        //return $this->result(0, 'success', array("guiz" => $guiz));
    }
    //修改会员信息
    //摇一摇相关结束
    //获取会员卡申请页表单
    public function doPageRegisterFrom()
    {
        $uniacid = input('uniacid');
        $openid = input('openid');
        $is_apply = Db::table('ims_sudu8_page_vip_apply')->where('uniacid', $uniacid)->where('openid', $openid)->where('flag', 2)->order('id desc')->field('beizhu')->find();
        if ($is_apply) {
            $data['beizhu'] = $is_apply['beizhu'];
        } else {
            $data['beizhu'] = "";
        }
        $is = Db::table('ims_sudu8_page_vip_config')->where('uniacid', $uniacid)->field('formid')->find();
        if ($is) {
            $formid = $is['formid'];
        } else {
            $formid = 0;
        }
        if ($formid > 0) {
            $forminfo = Db::table('ims_sudu8_page_formlist')->where('id', $formid)->find();
            $form2 = "";
            if ($forminfo) {
                $forms2 = unserialize($forminfo['tp_text']);
            }
            if ($forms2) {
                foreach ($forms2 as $key => &$res) {
                    if ($res["type"] != 2 && $res["type"] != 5) {
                        $vals = explode(",", $res['tp_text']);
                        $kk = array();
                        foreach ($vals as $key => &$rec) {
                            $kk['yval'] = $rec;
                            $kk['checked'] = "false";
                            $rec = $kk;
                        }
                        $res['tp_text'] = $vals;
                    }
                    if ($res["type"] == 2) {
                        $vals = explode(",", $res['tp_text']);
                        $res['tp_text'] = $vals;
                    }
                    $res['val'] = '';
                }
            }
            $data['form'] = $forms2;
            $data['flag'] = 1;
        } else {
            $data['form'] = [];
            $data['flag'] = 2;
        }
        $result['data'] = $data;
        return json_encode($result);
    }
    //手机号自动获取时的sessionkey
    public function doPagegetNewSessionkey()
    {
        $uniacid = input('uniacid');
        $app = Db::table('applet')->where("id", $uniacid)->find();
        $appid = $app['appID'];
        $appsecret = $app['appSecret'];
        $code = input('code');
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
        $weixin = file_get_contents($url);
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode);//转换成数组
        $sessionKey = $array['session_key'];
        $result['data'] = $sessionKey;
        return json_encode($result);
    }
    public function dopagejiemiNew()
    {
        $uniacid = input('uniacid');
        $app = Db::table('applet')->where("id", $uniacid)->find();
        $appid = $app['appID'];
        $sessionKey = input('newSessionKey');
        $encryptedData = input('encryptedData');
        $iv = input('iv');
        include_once "wxBizDataCrypt.php";
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);
        $arrdata = json_decode($data, TRUE);
        $tel = $arrdata['phoneNumber'];
        $result['data'] = $tel;
        return json_encode($result);
    }
    // 点击确认收货按钮（秒杀）
    public function dopagedanshouhuo(){
        $uniacid = input('uniacid');
        $orderid = input('orderid');
        $openid = input('openid');
        $adata = array(
            "custime" => time(),
            "flag" => 2
        );
        Db::table('ims_sudu8_page_order')->where("order_id", $orderid)->update($adata);
        $fxsorder = Db::table("ims_sudu8_page_fx_ls")->where("uniacid",$uniacid)->where("order_id", $orderid)->find();
        if($fxsorder){
            $this->dopagegivemoney($openid,$orderid);
        }
    }

    public function doPagegetduoOrderDetail(){
        $uniacid = input('uniacid');
        $order_id = input('order_id');
        $order = Db::table('ims_sudu8_page_duo_products_order')->where("uniacid",$uniacid)->where("order_id",$order_id)->find();
        $order['jsondata'] = unserialize($order['jsondata']);
        $hjjg = 0;

        foreach ($order['jsondata'] as $key => &$value) {

             if($value['baseinfo']){
            if($value['baseinfo']['thumb'] && !strstr($value['baseinfo']['thumb'], "http")){
                $order['thumb'] = remote($uniacid, $value['baseinfo']['thumb'],1);
            }
             }
             if($value['proinfo']){
            if($value['proinfo']['thumb'] && !strstr($value['proinfo']['thumb'], "http")){
                $order['thumb'] = remote($uniacid, $value['proinfo']['thumb'],1);
            }
             }
            $hjjg += $value['proinfo']['price'] * $value['num'];
            $order['num']=$value['num'];
        }

        $order['hjjg'] = $hjjg;
        if($order['address'] > 0){
            $order['addressinfo'] = Db::table('ims_sudu8_page_duo_products_address')->where("id", $order['address'])->find();
        }

        if($order['coupon']){
            $coupon_user = Db::table('ims_sudu8_page_coupon_user')->where("uniacid", $uniacid)->where("id", $order['coupon'])->find();
            $order['couponinfo'] = Db::table('ims_sudu8_page_coupon')->where("uniacid", $uniacid)->where("id", $coupon_user['cid'])->find();
        }

        if($order['jf'] > 0){
            $rechargeConf = Db::table('ims_sudu8_page_rechargeconf')->where("uniacid", $uniacid)->find();
            $order['jf_money'] = intval($order['jf'] * $rechargeConf['money'] / $rechargeConf['score']);
        }

        $order['pay_yue'] = round($order['price'] - $order['payprice'], 2);

        $order['creattime'] = date("Y-m-d H:i:s", $order['creattime']);
        $order['true_price']=$order['payprice']*1+$order['pay_yue']*1;
        $order['seller_tel'] = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field("tel")->find()['tel'];
        if(!empty($order['yhinfo'])){
            $yhInfo = unserialize($order['yhinfo']);
            $order['yhInfo_yunfei'] = $yhInfo['yunfei'];
            $order['yhInfo_score'] = $yhInfo['score'];
            $order['yhInfo_yhq'] = $yhInfo['yhq'];
            $order['yhInfo_mj'] = $yhInfo['mj'];
        }else{
            $order['yhInfo_yunfei'] = 0;
            if($order['dkscore'] > 0){
                $jfgz = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
                $order['yhInfo_score']['msg'] = $order['jf']."积分抵扣".floatval($order['jf']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                $order['yhInfo_score']['money'] = floatval($order['jf']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
            }else{
                $order['yhInfo_score']['msg'] = "未使用积分";
                $order['yhInfo_score']['money'] = 0;
            }
            if($order['couponinfo']){
                $order['yhInfo_yhq']['msg'] = $order['couponinfo']['title'];
                $order['yhInfo_yhq']['money'] = $order['couponinfo']['price'];
            }else{
                $order['yhInfo_yhq']['msg'] = "未使用优惠券";
                $order['yhInfo_yhq']['money'] = 0;
            }
            $order['yhInfo_mj']['msg'] = "";
            $order['yhInfo_mj']['money'] = 0;
        }

        $result['data'] = $order;

        return json_encode($result);
    }

    public function doPagegetOrderDetail(){
        $uniacid = input('uniacid');
        $order_id = input('order_id');
        $order = Db::table('ims_sudu8_page_order')->where("uniacid",$uniacid)->where("order_id",$order_id)->find();
        $order['hjjg'] = $order['price'] * $order['num'];
        if($order['thumb'] && !strstr($order['thumb'], "http")){
            $order['thumb'] = remote($uniacid, $order['thumb'], 1);
        }
        if($order['address'] > 0){
            $order['addressinfo'] = Db::table('ims_sudu8_page_duo_products_address')->where("id", $order['address'])->find();
        }
        if($order['coupon']){
            $coupon_user = Db::table('ims_sudu8_page_coupon_user')->where("uniacid", $uniacid)->where("id", $order['coupon'])->find();
            $order['couponinfo'] = Db::table('ims_sudu8_page_coupon')->where("uniacid", $uniacid)->where("id", $coupon_user['cid'])->find();
        }
        if($order['dkscore'] > 0){
            $rechargeConf = Db::table('ims_sudu8_page_rechargeconf')->where("uniacid", $uniacid)->find();
            $order['jf_money'] = intval($order['dkscore'] * $rechargeConf['money'] / $rechargeConf['score']);
        }
        $order['pay_yue'] = round($order['true_price'] - $order['pay_price'], 2);
        $order['creattime'] = date("Y-m-d H:i:s", $order['creattime']);
        $order['seller_tel'] = Db::table('ims_sudu8_page_base')->where("uniacid", $uniacid)->field("tel")->find()['tel'];
        if(!empty($order['yhinfo'])){
            $yhInfo = unserialize($order['yhinfo']);
            $order['yhInfo_yunfei'] = $yhInfo['yunfei'];
            $order['yhInfo_score'] = $yhInfo['score'];
            $order['yhInfo_yhq'] = $yhInfo['yhq'];
            $order['yhInfo_mj'] = $yhInfo['mj'];
        }else{
            $order['yhInfo_yunfei'] = 0;
            if($order['dkscore'] > 0){
                $jfgz = pdo_get("sudu8_page_rechargeconf", array("uniacid"=>$uniacid));
                $order['yhInfo_score']['msg'] = $order['dkscore']."积分抵扣".floatval($order['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
                $order['yhInfo_score']['money'] = floatval($order['dkscore']) * floatval($jfgz['money']) / floatval($jfgz['scroe']);
            }else{
                $order['yhInfo_score']['msg'] = "未使用积分";
                $order['yhInfo_score']['money'] = 0;
            }
            if($order['couponinfo']){
                $order['yhInfo_yhq']['msg'] = $order['couponinfo']['title'];
                $order['yhInfo_yhq']['money'] = $order['couponinfo']['price'];
            }else{
                $order['yhInfo_yhq']['msg'] = "未使用优惠券";
                $order['yhInfo_yhq']['money'] = 0;
            }
            $order['yhInfo_mj']['msg'] = "";
            $order['yhInfo_mj']['money'] = 0;
        }
        
        $result['data'] = $order;

        return json_encode($result);
    }
    //新版取消订单（秒杀）
    public function doPagemiaoshatk(){
        $uniacid = input('uniacid');
        $order_id = input('order_id');
        $formId = input('formId');
        if($order_id && $order_id != 'undefined'){
            Db::table('ims_sudu8_page_order')->where("uniacid",$uniacid)->where("order_id", $order_id)->update(array("flag" => 6, "qx_formid" => $formId));
            $data = array("flag" => 0, "message" => "申请成功！");
            $result = [];
            $result['data'] = $data;
            return json_encode($result);
            //return $this->result(0, "success", array("flag" => 0, "message" => "申请成功！"));
        }else{
            $mobile = Db::table('ims_sudu8_page_base')->where("uniacid",$uniacid)->field("tel")->find()['tel'];
            $data = array("flag" => 1, "message" => "取消订单申请失败", "mobile" => $mobile);
            $result = [];
            $result['data'] = $data;
        }
        return json_encode($result);
    }
    //商品详情显示
    public function doPageshowPro11(){
        $uniacid = input('uniacid');
        $id = intval(input('id'));
        $type = input('types') ? input('types') : 'showPro';
        //$pro = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_products')." WHERE id = :id and uniacid = :uniacid" , array(':id' => $id ,':uniacid' => $uniacid));
        $pro = Db::table('ims_sudu8_page_products') ->where('id', $id) ->where('uniacid', $uniacid) ->find();
        $pro['is_saletwo']=$pro['is_sale'];
        $pro['sale_end_time_copy'] = $pro['sale_end_time'];
        $pro['sale_end_time'] = intval($pro['sale_end_time']);
        if($pro['sale_end_time'] != 0){
            $pro['sale_end_time'] = $pro['sale_end_time'] - time();
            if($pro['sale_end_time'] < 0){
                $pro['sale_end_time'] = 0;
            }
        }
        
        if($pro['sale_time'] > time()){
            $pro['timetobegin'] = ($pro['sale_time'] - time()) * 1000;
        }else{
            $pro['timetobegin'] = 0;
        }
        if(input('orderid')){
            // $pro['order_num'] = pdo_getcolumn("sudu8_page_order", array("uniacid"=>$uniacid, "order_id"=>$_GPC['orderid']), "num");
            $pro['order_num'] = Db::table('ims_sudu8_page_order') ->where('uniacid', $uniacid)->where('order_id', input('order_id')) ->field('num') ->find();
            $pro['order_num'] = intval($pro['order_num']['num']);
            // $pro['nav'] = pdo_getcolumn("sudu8_page_order", array("uniacid"=>$uniacid, "order_id"=>$_GPC['orderid']), "nav");
            $pro['nav'] = Db::table('ims_sudu8_page_order') ->where('uniacid', $uniacid) ->where('order_id', input('order_id')) ->field('nav') ->find();
            $pro['nav'] = $pro['nav']['nav'];
        }
        $data = array(
            'hits' => $pro['hits'] + 1,
        );
        //pdo_update('sudu8_page_products', $data, array('id' => $id ,'uniacid' => $uniacid));
        Db::table('ims_sudu8_page_products') ->where('uniacid', $uniacid) ->where('id', $id) ->update($data);
        $pro['text'] = unserialize($pro['text']);
        $num = count($pro['text']);
        for($i = 0; $i < $num; $i++){
            // if(stristr($pro['text'][$i], 'http')){
            //     $pro['text'][$i] = $pro['text'][$i];
            // }else{
            //     $pro['text'][$i] = ROOT_HOST.$pro['text'][$i];
            // }
            $pro['text'][$i] = remote($uniacid, $pro['text'][$i], 1);
        }
        // 20170925  修改卖出总数
        // $orders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :id and uniacid = :uniacid and flag >0" , array(':id' => $id ,':uniacid' => $uniacid));
        // $orders = Db::table('ims_sudu8_page_order') ->where('pid', $id) ->where('uniacid', $uniacid) ->where("flag", "neq", 1) ->select();
        // // if($pro['is_more']==1){
        // //  if($orders){
        // //      $allnum = 0;
        // //      foreach ($orders as $rec) {
        // //          $duo = $rec['order_duo'];
        // //          $newduo = unserialize($duo);
        // //          foreach ($newduo as $key=>&$res) {
        // //              $allnum[$key] += $res[5];
        // //          }
        // //      }
        // //  }
        // // }
        // $sale_num = 0;
        // if($orders){
        //     foreach ($orders as $rec) {
        //         $sale_num+= $rec['num'];
        //     }
        // }
        // $pro['sale_num'] = $pro['sale_num'] + $sale_num;
        //20170925  新增我的购买量
        $openid = input('openid');
        //$pro['userinfo'] = pdo_get("sudu8_page_user", array("uniacid"=>$uniacid, "openid"=>$openid), array("money", "score"));
        $pro['userinfo'] = Db::table('ims_sudu8_page_user') ->where('uniacid', $uniacid) ->where('openid', $openid) ->field('money, score, vipid') ->find();
        // $myorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :id and openid = :openid and uniacid = :uniacid and flag>=0" , array(':id' => $id ,':openid' => $openid ,':uniacid' => $uniacid));
        $myorders = Db::table('ims_sudu8_page_order') ->where('pid', $id) ->where('openid', $openid) ->where('uniacid', $uniacid) ->where('flag', 'EGT', 0) ->select();
        $my_num = 0;
        // var_dump($myorders);
        // die();
        //判断我又没有收藏过
        $collectcount = 0;
        if($openid){
            // $user = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_user')." WHERE uniacid = :uniacid and openid = :openid", array(':uniacid' => $uniacid,':openid' => $openid));
            $user = Db::table('ims_sudu8_page_user') ->where('uniacid', $uniacid) ->where('openid', $openid) ->find();
            $uid = $user['id'];
            // $collect = pdo_fetch("SELECT count(*) as n FROM ".tablename('sudu8_page_collect')." WHERE uniacid = :uniacid and uid = :uid and type = :type and cid = :cid", array(':uniacid' => $uniacid,':uid' => $uid,':type' => $type, ':cid'=> $id));
            $collect = Db::table('ims_sudu8_page_collect') ->where('uniacid', $uniacid) ->where('uid', $uid) ->where('type', $type) ->where('cid', $id) ->count();
            if($collect['n']>0){
                $collectcount = 1;
            }
        }
        $pro['collectcount'] = $collectcount;
        //刷新所有商品已过期订单且未支付
        if($pro['pro_kc']>=0 && $pro['is_more']==0){
            $now = time();
            $onum = 0;
            // $allorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :pid  and uniacid = :uniacid and flag = 0 and overtime < :nowtime" , array(':pid' => $id  ,':uniacid' => $uniacid, ':nowtime'=> $now));
            $allorders = Db::table('ims_sudu8_page_order') ->where('pid', $id) ->where('uniacid', $uniacid) ->where('flag', 0) ->where('overtime', 'lt', $now) ->select();
            if($allorders){
                foreach ($allorders as $rec) {
                    $onum+=$rec['num'];
                    $kdata['flag'] = -1;
                    $kdata['reback'] = 1;
                    //pdo_update('sudu8_page_order', $kdata, array('order_id' => $rec['order_id'] ,'uniacid' => $uniacid));
                    Db::table('ims_sudu8_page_order') ->where('order_id', $rec['order_id']) ->where('uniacid', $uniacid) ->update($kdata);
                }
                $ndata['pro_kc'] = $pro['pro_kc']+$onum;
                //pdo_update('sudu8_page_products', $ndata, array('id' => $id ,'uniacid' => $uniacid));
                Db::table('ims_sudu8_page_products') ->where('id', $id) ->where('uniacid', $uniacid) ->update($ndata);
            }
        }else if($pro['pro_kc']< 0 && $pro['is_more']==0){
            $now = time();
            // $allorders = pdo_fetchall("SELECT * FROM ".tablename('sudu8_page_order')." WHERE pid = :pid  and uniacid = :uniacid and flag = 0 and overtime < :nowtime" , array(':pid' => $id  ,':uniacid' => $uniacid, ':nowtime'=> $now));
            $allorders = Db::table('ims_sudu8_page_order') ->where('pid', $id) ->where('uniacid', $uniacid) ->where('flag', 0) ->where('overtime', 'lt', $now) ->select();
            if($allorders){
                foreach ($allorders as $rec) {
                    $kdata['flag'] = -1;
                    $kdata['reback'] = 1;
                    // pdo_update('sudu8_page_order', $kdata, array('order_id' => $rec['order_id'] ,'uniacid' => $uniacid));
                    Db::table('ims_sudu8_page_order') ->where('order_id', $rec['order_id']) ->where('uniacid', $uniacid) ->update($kdata);
                }
            }
        }
        // if($pro['is_more']==1){
        //     $now = time();
        //     if($now>$orders['overtime'] && $orders['flag'] == 0){   //订单失效
        //         $kdata['flag'] = -1;
        //         // pdo_update('sudu8_page_order', $kdata, array('order_id' => $id ,'uniacid' => $uniacid));
        //         Db::table('ims_sudu8_page_order') ->where('order_id', $id) ->where('uniacid', $uniacid) ->update($kdata);
        //     }
        // }
        if($myorders){
            foreach ($myorders as $res) {
                $my_num+= $res['num'];
            }
        }
        $pro['my_num'] = $my_num;
        $now = time();
        if($pro['sale_time'] == 0){
            $pro['is_sale'] = 1;
        }else{
            if($pro['sale_time'] > $now){
                $pro['is_sale'] = 0;            
            }else{
                $pro['is_sale'] = 1;
            }
        }
        // if(stristr($pro['thumb'], 'http')){
        //         $pro['thumb'] = $pro['thumb'];
        // }else{
        //         $pro['thumb'] = ROOT_HOST.$pro['thumb'];
        // }
        $pro['thumb'] = remote($uniacid, $pro['thumb'], 1);
        if($pro['labels'] && $pro['is_more']==0){
            $labels = explode(",", $pro['labels']);
            $pro['labels'] = $labels;
        }elseif($pro['labels'] && $pro['is_more']==1){
            $labels = unserialize($pro['labels']);
            $arrkk = array();
            foreach ($labels as $key => $res) {
                $vvkk = array($key,$res);
                array_push($arrkk, $vvkk);
            }
            $pro['labels'] = $arrkk;
            // var_dump($arrkk);
            // die();
        }else{
            $pro['labels'] = array();
        }
        if($pro['more_type']){
            $more_type = unserialize($pro['more_type']);
            $newmore = array_chunk($more_type,4);
            $pro['more_type'] = $newmore;
            // var_dump($more_type);
            // die();
        }
        if($pro['more_type_x']){
            $more_type_x = unserialize($pro['more_type_x']);
            $pro['more_type_x'] = $more_type_x;
        }
        if($pro['more_type_num']){
            $more_type_num = unserialize($pro['more_type_num']);
            $pro['more_type_num'] = $more_type_num;
        }
        
        if($pro['pro_flag_data_name']){
            $pro['pro_flag_data_name'] = explode(";", $pro['pro_flag_data_name']);
            if(count($pro['pro_flag_data_name']) >3){
                $pro['afterdays'] = intval($pro['pro_flag_data_name'][1]);
                $pro['beforedays'] = intval($pro['pro_flag_data_name'][2]);
                $pro['modifydays'] = intval($pro['pro_flag_data_name'][3]);
                if($pro['afterdays'] > 0){
                $pro['start_date'] = date("Y-m-d", time() + $pro['afterdays'] * 3600 * 24);
            }
            }
            
            $pro['pro_flag_data_name'] = $pro['pro_flag_data_name'][0];
            
        }
         $formset = $pro['formset'];
        if($formset!=0&&$formset!=""){
            // $forms = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE id = :id" , array(':id' => $formset));
            $forms = Db::table('ims_sudu8_page_formlist') ->where('id', $formset) ->find();
            $forms2 = unserialize($forms['tp_text']);
            foreach($forms2 as $key=>&$res){
                if($res["type"]!=2 && $res["type"]!=5){
                    $vals= explode(",", $res['tp_text']);
                    $kk = array();
                    foreach ($vals as $key => &$rec) {
                        $kk['yval'] = $rec;
                        $kk['checked'] = "false";
                        $rec = $kk;
                    }
                    $res['tp_text'] = $vals;
                }
                if($res["type"]==2){
                    $vals= explode(",", $res['tp_text']);
                    $res['tp_text'] = $vals;
                }
                $res['val']='';
            }
        }else{
            $forms2 = "NULL";
        }
        // 
        // 
        // 
        // if($formset!=0&&$formset!=""){
        //  $forms = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_formlist')." WHERE id = :id" , array(':id' => $formset));
        //  $forms2 = unserialize($forms['tp_text']);
        //  foreach($forms2 as $key=>&$res){
        //      if($res['tp_text']){
        //          $res['tp_text'] = explode(",", $res['tp_text']);
        //      }
        //      $res['val']='';
        //  }
        // }else{
        //  $forms2 = "NULL";
        // }
        $pro['forms'] = $forms2;
        // echo "<pre>";
        // var_dump($pro);
        // echo "</pre>";
        // die();
        // var_dump($pro);exit;
        // 
        // if($pro['tableis'] == 1 && $pro['tableid']){
            // $table_info = pdo_get("sudu8_page_table", array("uniacid"=>$uniacid, "id"=>$pro['tableid']));
            // $table_info = Db::table('ims_sudu8_page_table') ->where('uniacid', $uniacid) ->where('id', $pro['tableid']) ->find();
            // $table_info['columnstr'] = explode(",", chop($table_info['columnstr'], ","));
            // $table_info['rowstr'] = explode(",", chop($table_info['rowstr'], ","));
            // $table_info['selectstr'] = explode(",", chop($table_info['selectstr'], ","));
            // $pro['table'] = $table_info;
        // }
        // 获取会员开启设置
        if(empty($pro['userinfo']['vipid'])){

            if(!empty($pro['vipconfig'])){
                $vipconfig = unserialize($pro['vipconfig']);

                if($vipconfig['set1'] == 1){
                    $pro['vip_config'] = $vipconfig['set2'];
                }else{
                    $vip_config = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find();
                    if(!empty($vip_config)){
                        $pro['vip_config'] = $vip_config['miaosha'];
                    }
                }
            }else{
                $vip_config = Db::table('ims_sudu8_page_vip_config')->where("uniacid", $uniacid)->find();
                if(!empty($vip_config)){
                    $pro['vip_config'] = $vip_config['miaosha'];
                }
            }
        }
        
        $pro['data'] = $pro;
        return json_encode($pro);
    }
    //秒杀商品积分抵扣
    public function doPagescoreDeduction(){
        $uniacid = input('uniacid');
        $openid = input('openid');
        $id = input('id');
        $num = input('num');
        // $score_max = pdo_getcolumn("sudu8_page_products", array("uniacid"=>$uniacid, "id"=>$id), "score");
        $score_max = Db::table('ims_sudu8_page_products') ->where('uniacid', $uniacid) ->where('id', $id) ->field('score') ->find();
        $score_max = intval($score_max['score']) * intval($num);
        if($score_max == null || $score_max == 0){
            $moneycl = 0;
            $jf = 0;
            $gzscore = 0;
            $gzmoney = 0;
        }else{
            //积分转换成金钱
            // $jf_gz = pdo_fetch("SELECT * FROM ".tablename('sudu8_page_rechargeconf')." WHERE uniacid = :uniacid" , array(':uniacid' => $uniacid));
            $jf_gz = Db::table('ims_sudu8_page_rechargeconf') ->where('uniacid', $uniacid) ->find();
            if(!$jf_gz){
                $gzscore = 100;
                $gzmoney = 1;
            }else{
                $gzscore = intval($jf_gz['score']);
                $gzmoney = intval($jf_gz['money']);
            }
            // $score = pdo_getcolumn("sudu8_page_user", array("uniacid"=>$uniacid, "openid"=>$openid), "score");
            $score = Db::table('ims_sudu8_page_user') ->where('uniacid', $uniacid) ->where('openid', $openid) ->field('score') ->find();
            $score = $score['score'];
            if($score_max && $score >= $score_max){
                $zhmoney = ($score_max * $gzmoney)/$gzscore;
            }else{
                $zhmoney = ($score * $gzmoney)/$gzscore;
            }
            $moneycl = floor($zhmoney);
            $jf = $moneycl * $gzscore; 
        }
        $data = array("moneycl"=>$moneycl, "jf"=>$jf, "gzscore"=>$gzscore, "gzmoney"=>$gzmoney);
        return json_encode($data);
    }
    public function doPagegetmoneyoff(){
        $uniacid = input('uniacid');
        // $moneyoff = pdo_fetchall("SELECT * FROM ".tablename("sudu8_page_moneyoff")." WHERE uniacid = :uniacid ORDER BY reach asc", array(":uniacid" => $uniacid));
        $moneyoff = Db::table('ims_sudu8_page_moneyoff') ->where('uniacid', $uniacid) ->order('reach asc') ->select();
        //return $this->result(0, 'success', array("moneyoff" => $moneyoff));
        $data['data'] = $moneyoff;
        return json_encode($data);
    }

     //新版取消订单（多规格）
    public function doPageduotk(){
        $uniacid = input('uniacid');

        $formId = input('formId');
        $order_id = input('order_id');

        if($order_id && $order_id != 'undefined'){
            // pdo_update("sudu8_page_duo_products_order", array("flag" => 6, "qx_formid" => $formId), array("uniacid" => $uniacid, "order_id" => $order_id));
            Db::table('ims_sudu8_page_duo_products_order') ->where('uniacid', $uniacid) ->where('order_id', $order_id) ->update(['flag'=>6, 'qx_formid'=>$formId]) ;
            $data['data'] = array("flag" => 0, "message" => "申请成功！");
            return json_encode($data);
            // return $this->result(0, "success", array("flag" => 0, "message" => "申请成功！"));
        }else{
            // $mobile = pdo_getcolumn("sudu8_page_base", array("uniacid"=>$uniacid), "tel");
            $mobile = Db::table('ims_sudu8_page_base')->where('uniacid', $uniacid) ->field('tel') ->find();
            $data['data'] = array("flag" => 1, "message" => "取消订单申请失败", "mobile" => $mobile['tel']);
            return json_encode($data);
            // return $this->result(0, "success", array("flag" => 1, "message" => "取消订单申请失败", "mobile" => $mobile));
        }

    }
    
}
