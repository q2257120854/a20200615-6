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

class Diypage extends Base
{
    public function index(){

        if(check_login()){

            if(powerget()){

                $appletid = input("appletid");
                $res = Db::table('applet')->where("id",$appletid)->find();

                if(!$res){

                    $this->error("找不到对应的小程序！");
                }
                $this->assign('applet',$res);

                $op=input("op");

                $tplid=input("tplid");

                if($op){

                    if($op=="setindex"){

                        $val = input('v');

                        $key_id = input('key_id');

                        if(empty($key_id)){

                            return false;
                        }

                        if($val == 1){

                            Db::table('ims_sudu8_page_diypage')->where("uniacid",$appletid)->update(array("index"=>0));
                            $result = Db::table('ims_sudu8_page_diypage')->where("uniacid",$appletid)->where("id",$key_id)->update(array("index"=>1));
                        }else{
                            $result = Db::table('ims_sudu8_page_diypage')->where("uniacid",$appletid)->where("id",$key_id)->update(array("index"=>0));
                        }

                        if($result){

                            return  json_encode(['status' => 1,'result' => ['returndata' => 1]]);

                        }else{

                            return json_encode(['status' => 0]);

                        }
                    }
                    if($op == "query"){

                        $type = input('type');

                        $kw = input('kw');

                        switch ($type){

                            case 'news':


                                $list = Db::table('ims_sudu8_page_products')->where("uniacid",$appletid)->where("type","showArt")->where("title","like","%".$kw."%")->field("id,title")->select();



                                $html = '';


                                if($list){
                                    foreach ($list as $k => $v){

                                        $html .= '<div class="line">

                                                    <div class="icon icon-link1"></div>

                                                    <nav data-href="/sudu8_page/showArt/showArt?id='.$v['id'].'" data-linktype="page" class="btn btn-default btn-sm" title="选择">选择</nav>

                                                    <div class="text"><span class="label lable-default">普通</span>'.$v['title'].'</div>

                                                </div>';

                                    }
                                }else{
                                   $html = '<div class="line">

                                            无相关搜索结果

                                        </div>';  
                                }

                                break;
                            case 'pic':

                                $list = Db::table('ims_sudu8_page_products')->where("uniacid",$appletid)->where("type","showPic")->where("title","like","%".$kw."%")->field("id,title")->select();



                                $html = '';


                                if($list){

                                    foreach ($list as $k => $v){

                                        $html .= '<div class="line">

                                                    <div class="icon icon-link1"></div>

                                                    <nav data-href="/sudu8_page/showPic/showPic?id='.$v['id'].'" data-linktype="page" class="btn btn-default btn-sm" title="选择">选择</nav>

                                                    <div class="text"><span class="label lable-default">普通</span>'.$v['title'].'</div>

                                                </div>';

                                    }
                                }else{
                                   $html = '<div class="line">

                                            无相关搜索结果

                                        </div>';  
                                }

                                break;

                            case 'goods':


                                $list = Db::table('ims_sudu8_page_products')->where("uniacid",$appletid)->where("type","neq","showArt")->where("type","neq","showPic")->where("type","neq","wxapp")->where("title","like","%".$kw."%")->field("id,title,price,pro_kc,pro_flag")->select();

                                $html = '';


                                if($list){
                                    foreach ($list as $k => $v){

                                        if($v['pro_flag'] == 2){

                                            $url = "/sudu8_page/showProMore/showProMore?id=".$v['id'];

                                            $g = "多规格";

                                        }else{

                                            $url = "/sudu8_page/showPro/showPro?id=".$v['id'];

                                            $g = "单规格";

                                        }

                                        $html .= '<div class="line">

                                                    <div class="icon icon-link1"></div>

                                                    <nav data-href="'.$url.'" data-linktype="page" class="btn btn-default btn-sm" title="选择">选择</nav>

                                                    <div class="text"><span class="label lable-default">普通</span>'.$g.' - 商品名称：'.$v['title'].' &nbsp; 价格：'.$v['price'].' &nbsp; 库存：'.$v['pro_kc'].'</div>

                                                </div>';

                                    }
                                }else{
                                   $html = '<div class="line">

                                            无相关搜索结果

                                        </div>';  
                                }

                                break;
                        }

                        echo $html;
                        exit;
                    }
                    if ($op == 'delpage'){
                        $tpl_id = input("tplid");
                        $tpl_pages = Db::table('ims_sudu8_page_diypagetpl')->where("uniacid",$appletid)->where("id",$tpl_id)->find()['pageid'];
                        
                        $tpl_pages_arr = explode(",",$tpl_pages);
                        $tpl_pages_count = Db::table('ims_sudu8_page_diypage')->where("uniacid",$appletid)->where("id","in",$tpl_pages_arr)->count();
                        if($tpl_pages_count == 1){
                            $this->error('删除失败，模板必须保留一个页面');

                            exit;
                        }



                        $id = input('id') ? intval(input('id')) : 0;

                        if($id == 0){

                            $this->error('参数错误');

                            exit;

                        }

                        $is_index = Db::table('ims_sudu8_page_diypage')->where("uniacid",$appletid)->where("id",$id)->where("index",1)->find();
                        if($is_index){
                            $this->error("当前页面为首页不可删除");
                            exit;
                        }
                        $result = Db::table('ims_sudu8_page_diypage')->where("uniacid",$appletid)->where("id",$id)->delete();

                        if($result){
                            $this->success("删除成功");

                        }else{
                            $this->error('删除失败');

                        }

                    }
                    if($op == "setsave"){
                        // $pid = input('key_id');
                        $is = Db::table('ims_sudu8_page_diypageset')->where("uniacid",$appletid)->find();
                        // $is = Db::table('ims_sudu8_page_diypageset')->where("uniacid",$appletid)->where("pid",$pid)->find();
                        $go_home = input('go_home');
                        $kp = input('kp');
                        $kp_is = input('kp_is');
                        $kp_m = input('kp_m');
                        $kp_url = input('kp_url');
                        $kp_urltype = input('kp_urltype');
                        $tc_is = input('tc_is');
                        $tc = input('tc');
                        $tc_url = input('tc_url');
                        $tc_urltype = input('tc_urltype');
                        $foot_is = input('foot_is');
                        $data = array(
                            // "pid"=>$pid,
                            "go_home"=>$go_home,
                            "kp"=>remote($appletid,$kp,2),
                            "kp_is"=>intval($kp_is),
                            "kp_m"=>intval($kp_m),
                            "kp_url"=>$kp_url,
                            "kp_urltype"=>$kp_urltype,
                            "tc_is"=>$tc_is,
                            "tc"=>remote($appletid,$tc,2),
                            "tc_url"=>$tc_url,
                            "tc_urltype"=>$tc_urltype,
                            "foot_is"=>$foot_is,
                            );
                        if($is){
                            $res = Db::table('ims_sudu8_page_diypageset')->where("uniacid",$appletid)->update($data);
                        }else{
                            $data['uniacid'] = $appletid;
                            $res = Db::table('ims_sudu8_page_diypageset')->insert($data);
                        }
                        if($res==1){
                            return 1;
                        }else{
                            return 2;
                        }
                    }
                    if ($op == 'add'){

                        $data = $_POST;

                        if(isset($data['data']['page']['url']) && $data['data']['page']['url'] != ""){
                            $data['data']['page']['url'] = remote($appletid,$data['data']['page']['url'],2);
                        }

                        if(isset($data['data']['page']['name']) && $data['data']['page']['name'] != ''){

                            $sd = [];

                            $sd['tpl_name'] = $data['data']['page']['name'];
                            if(isset($data['data']['page']['url']) && $data['data']['page']['url'] != ""){
                                $data['data']['page']['url'] = remote($appletid,$data['data']['page']['url'],2);
                            }

                            $sd['page'] = serialize($data['data']['page']);
                            if(isset($data['data']['items'])){
                                foreach($data['data']['items'] as $ki => $vi){
                                    if($vi['id'] == "video" ){
                                        if(!empty($vi['params']['videourl'])){
                                            if(strpos($vi['params']['videourl'],"</iframe>") !== false || strpos($vi['params']['videourl'],"</embed>") !== false){
                                                $data['data']['items'][$ki]['params']['videourl'] = "";
                                            }
                                        }
                                    }
                                    if($vi['id'] == "yuyin" ){
                                        if(!empty($vi['params']['linkurl'])){
                                            if(strpos($vi['params']['linkurl'],"</iframe>") !== false || strpos($vi['params']['linkurl'],"</embed>") !== false){
                                                $data['data']['items'][$ki]['params']['linkurl'] = "";
                                            }
                                        }
                                    }
                                }
                            }
                            if(isset($data['data']['items']) && $data['data']['items'] != ""){
                                foreach ($data['data']['items'] as $k => &$v) {
                                    if($v['id'] == 'title2' || $v['id'] == 'title' || $v['id'] == 'line' || $v['id'] == 'blank' || $v['id'] == 'anniu' || $v['id'] == 'notice' || $v['id'] == 'service' || $v['id'] == 'listmenu' || $v['id'] == 'joblist' || $v['id'] == 'personlist' || $v['id'] == 'msmk' || $v['id'] == 'multiple' || $v['id'] == 'mlist' || $v['id'] == 'goods' || $v['id'] == 'tabbar' || $v['id'] == 'cases' || $v['id'] == 'listdesc' || $v['id'] == 'pt' || $v['id'] == 'dt' || $v['id'] == 'ssk' || $v['id'] == 'xnlf' || $v['id'] == 'yhq' || $v['id'] == 'dnfw' || $v['id'] == 'yuyin' || $v['id'] == 'feedback' || $v['id'] == 'yuyin'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                    }
                                    if($v['id'] == 'bigimg' || $v['id'] == 'classfit' || $v['id'] == 'banner' || $v['id'] == 'menu' || $v['id'] == 'picture' || $v['id'] == 'picturew'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                        if($v['data']){
                                            foreach ($v['data'] as $ki => $vi) {
                                                if($vi['imgurl'] != ""){
                                                    $v['data'][$ki]['imgurl'] = remote($appletid,$vi['imgurl'],2);
                                                }
                                            }
                                        }
                                    }
                                    if($v['id'] == 'contact'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                        if($v['params']['src'] != ""){
                                            $v['params']['src'] = remote($appletid,$v['params']['src'],2);
                                        }
                                        if($v['params']['ewm'] != ""){
                                            $v['params']['ewm'] = remote($appletid,$v['params']['ewm'],2);
                                        }
                                    }
                                    if($v['id'] == 'video'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                        if($v['params']['poster'] != ""){
                                            $v['params']['poster'] = remote($appletid,$v['params']['poster'],2);
                                        }
                                    }
                                    if($v['id'] == 'logo' || $v['id'] == 'dp'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                        if($v['params']['src'] != ""){
                                            $v['params']['src'] = remote($appletid,$v['params']['src'],2);
                                        }
                                    }
                                    if($v['id'] == 'footmenu'){
                                        if($v['data']){
                                            foreach ($v['data'] as $ki => $vi) {
                                                if($vi['imgurl'] != ""){
                                                    $v['data'][$ki]['imgurl'] = remote($appletid,$vi['imgurl'],2);
                                                }
                                            }
                                        }
                                    }
                                }
                                $sd['items'] = serialize($data['data']['items']);
                            }else{
                                $sd['items'] = "";  
                            }
                            

                            $sd['uniacid'] = $appletid;



                            if(intval($data['id']) == 0){

                                // $tplid = input('tplid');


                                /*新创建*/

                                $idata = Db::table('ims_sudu8_page_diypage')->where("uniacid",$appletid)->where("tpl_name",$sd['tpl_name'])->find();

                                if($idata){

                                    echo json_encode(['status' => 0,'message' => '创建页面名称重复','id' => 0],JSON_UNESCAPED_UNICODE);exit;

                                }
                                $is = Db::table('ims_sudu8_page_diypage')->where('uniacid',$appletid)->find();
                                if(!$is){
                                    $sd['index'] = 1;
                                }
                                $result = Db::table('ims_sudu8_page_diypage')->insert($sd);

                                $key = Db::table('ims_sudu8_page_diypage')->getLastInsID();

                                if($tplid>0){
                                   $pageid =  Db::table('ims_sudu8_page_diypagetpl')->where("uniacid",$appletid)->where("id",$tplid)->field("pageid")->find()['pageid'];
                                   Db::table('ims_sudu8_page_diypagetpl')->where("uniacid",$appletid)->where("id",$tplid)->update(array("pageid"=>$pageid.",".$key));
                                } 
                         

                            }else{
              
                                $result = Db::table('ims_sudu8_page_diypage')->where("uniacid",$appletid)->where("id",$data['id'])->update($sd);
                   
                                $key = $data['id'];

                            }
                            if($result){
                      
                                echo json_encode(['status' => 0,'message' => '保存成功','id' => $key],JSON_UNESCAPED_UNICODE);
                                exit;
                            }else{

                                echo json_encode(['status' => -1,'message' => '保存成功，本次保存未做修改'],JSON_UNESCAPED_UNICODE);
                                exit;
                            }
                        }
                    } 
                    //另存为模板
                    if ($op == 'settemplate') {
                        $pageid = input('ids/a');
                        $pageids = "";
                        foreach ($pageid as $key => $value) {
                            $info = Db::table("ims_sudu8_page_diypage")->where("id",$value)->find();
                            $info['page'] = unserialize($info['page']);
                            if(isset($info['page']['url']) && $info['page']['url'] != ""){
                                $info['page']['url'] = remote($appletid,$info['page']['url'],2);
                            }

                            $items = unserialize($info['items']);
                            if($items){
                                foreach ($items as $k => $v) {
                                    if($v['id'] == 'title2' || $v['id'] == 'title' || $v['id'] == 'line' || $v['id'] == 'blank' || $v['id'] == 'anniu' || $v['id'] == 'notice' || $v['id'] == 'service' || $v['id'] == 'listmenu' || $v['id'] == 'joblist' || $v['id'] == 'personlist' || $v['id'] == 'msmk' || $v['id'] == 'multiple' || $v['id'] == 'mlist' || $v['id'] == 'goods' || $v['id'] == 'tabbar' || $v['id'] == 'cases' || $v['id'] == 'listdesc' || $v['id'] == 'pt' || $v['id'] == 'dt' || $v['id'] == 'ssk' || $v['id'] == 'xnlf' || $v['id'] == 'yhq' || $v['id'] == 'dnfw' || $v['id'] == 'yuyin' || $v['id'] == 'feedback' || $v['id'] == 'yuyin'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                    }
                                    if($v['id'] == 'bigimg' || $v['id'] == 'classfit' || $v['id'] == 'banner' || $v['id'] == 'menu' || $v['id'] == 'picture' || $v['id'] == 'picturew'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                        if($v['data']){
                                            foreach ($v['data'] as $ki => $vi) {
                                                if($vi['imgurl'] != ""){
                                                    $v['data'][$ki]['imgurl'] = remote($appletid,$vi['imgurl'],2);
                                                }
                                            }
                                        }
                                    }
                                    if($v['id'] == 'contact'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                        if($v['params']['src'] != ""){
                                            $v['params']['src'] = remote($appletid,$v['params']['src'],2);
                                        }
                                        if($v['params']['ewm'] != ""){
                                            $v['params']['ewm'] = remote($appletid,$v['params']['ewm'],2);
                                        }
                                    }
                                    if($v['id'] == 'video'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                        if($v['params']['poster'] != ""){
                                            $v['params']['poster'] = remote($appletid,$v['params']['poster'],2);
                                        }
                                    }
                                    if($v['id'] == 'logo' || $v['id'] == 'dp'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],2);
                                        }
                                        if($v['params']['src'] != ""){
                                            $v['params']['src'] = remote($appletid,$v['params']['src'],2);
                                        }
                                    }
                                    if($v['id'] == 'footmenu'){
                                        if($v['data']){
                                            foreach ($v['data'] as $ki => $vi) {
                                                if($vi['imgurl'] != ""){
                                                    $v['data'][$ki]['imgurl'] = remote($appletid,$vi['imgurl'],2);
                                                }
                                            }
                                        }
                                    }

                                    //去除栏目信息 
                                    //notice(公告) msmk(秒杀模块) goods(产品组) feedback(表单) pt(拼团) listdesc(文章) cases(图文)
                                    
                                    if ($v['id'] == 'notice' || $v['id'] == 'msmk' || $v['id'] == 'goods' || $v['id'] == 'feedback' || $v['id'] == 'pt' || $v['id'] == 'listdesc' || $v['id'] == 'cases') {
                                        $items[$k]['params']['sourceid'] = '';
                                    }
                                }
                            }
                            $insert_id = Db::table('ims_sudu8_page_diypage_sys')->insertGetId(array(
                                    'index' => $info['index'],
                                    'page' => serialize($info['page']),
                                    'items' => serialize($items),
                                    'tpl_name' => $info['tpl_name'],
                                ));
                            $pageids = $pageids .','. $insert_id;
                        }
                        $pageids = substr($pageids,1);
                        $data = [
                            'pageid' => $pageids,
                            'template_name' => input('name'),
                            'thumb' => input('preview'),
                            'create_time' => time()
                        ];


                        $key_id = Db::table("ims_sudu8_page_diypagetpl_sys")->insertGetId($data);

                        echo json_encode(['status' => 1,'id' => $key_id,'message' => '保存成功'],JSON_UNESCAPED_UNICODE);
                        exit;
              
                    }
                    if ($op == 'settemp') {
                        $template_id = input('templateid');

                        if($template_id > 0){

                            $data = [

                                // 'pageid' => implode(',',input('ids/a')),

                                'template_name' => input('name'),

                                'thumb' => remote($appletid,input('preview'),2),

                                'uniacid' => $appletid,

                                // 'create_time' => time()

                            ];

                            $res = Db::table("ims_sudu8_page_diypagetpl")->where("id",$template_id)->update($data);

                            if($res){
                                echo json_encode(['status' => 1],JSON_UNESCAPED_UNICODE);
                                exit;
                            }else{
                                echo json_encode(['status' => 0],JSON_UNESCAPED_UNICODE);
                                exit;
                            }
                        }
                    }
                }else{
                    //页面设置
                    $setsave = Db::table("ims_sudu8_page_diypageset")->where("uniacid",$appletid)->find();
                    if(!$setsave){
                        $foot_is = 1;
                        $setsave = [];
                    }else{
                        if($setsave['kp']){
                           $setsave['kp'] = remote($appletid,$setsave['kp'],1);    
                        }
                        if($setsave['tc']){
                           $setsave['tc'] = remote($appletid,$setsave['tc'],1);    
                        }
                        $foot_is = 0;
                    }
                    //查出当前模板关联页面id
                    $temp = Db::table("ims_sudu8_page_diypagetpl")->where("id",$tplid)->find();
                    if($temp['thumb']){
                       $temp['thumb'] = remote($appletid,$temp['thumb'],1);
                    }
                    if($temp['pageid'] == ""){
                        $pageid = Db::table("ims_sudu8_page_diypage")->insertGetId(array(
                            'uniacid' => $appletid,
                            'index' => 1,
                            'page' => 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffffff";s:8:"topcolor";s:1:"1";s:9:"styledata";s:1:"0";s:5:"title";s:21:"小程序页面标题";s:4:"name";s:18:"后台页面名称";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}',
                            'items' => '',
                            'tpl_name' => '后台页面名称',
                        ));
                        Db::table("ims_sudu8_page_diypagetpl")->where("id",$tplid)->update(array("pageid"=>$pageid));
                        $temp = Db::table("ims_sudu8_page_diypagetpl")->where("id",$tplid)->find();
                    }


                    //改变原来的模板状态为不启用
                    $tpls = Db::table("ims_sudu8_page_diypagetpl")->where('uniacid',$appletid)->select();
                    if($tpls){
                        foreach ($tpls as $k => $v) {
                            Db::table("ims_sudu8_page_diypagetpl")->where('uniacid',$appletid)->update(array('status' => 2));
                        }
                    }
                    Db::table("ims_sudu8_page_diypagetpl")->where("id",$tplid)->update(array("status"=>1));

                    $pageidArray = explode(',',$temp['pageid']);

                    //查出当前模板所有的页面
                    $list = Db::table("ims_sudu8_page_diypage")->where("uniacid",$appletid)->where("id","in",$pageidArray)->field("id,tpl_name,index")->select();


                    //页面操作
                    $diypage = Db::table("ims_sudu8_page_diypage")->where("uniacid",$appletid)->where("id","in",$pageidArray)->where("index",1)->find();
                    if($diypage == null){
                        $diypageone = Db::table("ims_sudu8_page_diypage")->where("uniacid",$appletid)->where("id","in",$pageidArray)->find();
                        Db::table("ims_sudu8_page_diypage")->where("uniacid",$appletid)->where("id",$diypageone['id'])->where("index",0)->update(array("index" => 1));
                        $diypage['id'] = $diypageone['id'];
                    }
                    $key_id = input('key_id') ? input('key_id') : $diypage['id'];  //显示页面id
                    if($key_id>0){
                        $data = Db::table("ims_sudu8_page_diypage")->where("id",$key_id)->where("uniacid",$appletid)->find();
                        $data['page'] = unserialize($data['page']);
                        if(isset($data['page']['url']) && $data['page']['url'] != ""){
                            $data['page']['url'] = remote($appletid,$data['page']['url'],1);
                        }
                        $data['items'] = unserialize($data['items']);
                        if($data['items'] != ""){
                            if(isset($data['items']) && $data['items'] != ""){
                                foreach ($data['items'] as $k => &$v) {
                                    if($v['id'] == 'title2' || $v['id'] == 'title' || $v['id'] == 'line' || $v['id'] == 'blank' || $v['id'] == 'anniu' || $v['id'] == 'notice' || $v['id'] == 'service' || $v['id'] == 'listmenu' || $v['id'] == 'joblist' || $v['id'] == 'personlist' || $v['id'] == 'msmk' || $v['id'] == 'multiple' || $v['id'] == 'mlist' || $v['id'] == 'goods' || $v['id'] == 'tabbar' || $v['id'] == 'cases' || $v['id'] == 'listdesc' || $v['id'] == 'pt' || $v['id'] == 'dt' || $v['id'] == 'ssk' || $v['id'] == 'xnlf' || $v['id'] == 'yhq' || $v['id'] == 'dnfw' || $v['id'] == 'yuyin' || $v['id'] == 'feedback' || $v['id'] == 'yuyin'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],1);
                                        }
                                    }
                                    if($v['id'] == 'bigimg' || $v['id'] == 'classfit' || $v['id'] == 'banner' || $v['id'] == 'menu' || $v['id'] == 'picture' || $v['id'] == 'picturew'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],1);
                                        }
                                        if($v['data']){
                                            foreach ($v['data'] as $ki => $vi) {
                                                if($vi['imgurl'] != "" && strpos($vi['imgurl'],"diypage/resource") === false){
                                                    $v['data'][$ki]['imgurl'] = remote($appletid,$vi['imgurl'],1);
                                                }
                                            }
                                        }
                                    }
                                    if($v['id'] == 'contact'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],1);
                                        }
                                        if($v['params']['src'] != ""  && strpos($v['params']['src'],"diypage/resource") === false){
                                            $v['params']['src'] = remote($appletid,$v['params']['src'],1);
                                        }
                                        if($v['params']['ewm'] != ""  && strpos($v['params']['ewm'],"diypage/resource") === false){
                                            $v['params']['ewm'] = remote($appletid,$v['params']['ewm'],1);
                                        }
                                    }
                                    if($v['id'] == 'video'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],1);
                                        }
                                        if($v['params']['poster'] != "" && strpos($v['params']['poster'],"diypage/resource") === false){
                                            $v['params']['poster'] = remote($appletid,$v['params']['poster'],1);
                                        }
                                    }
                                    if($v['id'] == 'logo' || $v['id'] == 'dp'){
                                        if($v['params']['backgroundimg'] != ""){
                                            $v['params']['backgroundimg'] = remote($appletid,$v['params']['backgroundimg'],1);
                                        }
                                        if($v['params']['src'] != ""  && strpos($v['params']['src'],"diypage/resource") === false){
                                            $v['params']['src'] = remote($appletid,$v['params']['src'],1);
                                        }
                                    }
                                    if($v['id'] == 'footmenu'){
                                        if($v['data']){
                                            foreach ($v['data'] as $ki => $vi) {
                                                if($vi['imgurl'] != "" && strpos($vi['imgurl'],"diypage/resource") === false){
                                                    $v['data'][$ki]['imgurl'] = remote($appletid,$vi['imgurl'],1);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        $page = $data['page'];
                        if(isset($page['url']) && $page['url'] != ""){
                            $page['url'] = remote($appletid,$page['url'],1);
                        }
                        $diyform = Db::table("ims_sudu8_page_formlist")->where("uniacid",$appletid)->field("id,formname as title")->select();
                        $data['diyform'] = $diyform;
                        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
                        $data = preg_replace("/\'/", "\'", $data);
                        $data = preg_replace('/(\\\n)/', "<br>", $data);
                    }       
                    $this->assign("page",$page);
                    $this->assign("template_id",$tplid);
                    $this->assign("key_id",$key_id);
                    $this->assign("list",$list);
                    $this->assign("data",$data);
                    $this->assign("setsave",$setsave);
                    $this->assign("foot_is",$foot_is);
                    $this->assign("temp",$temp);
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

            return $this->fetch('index');
        }else{
            $this->redirect('Login/index');
        }
    }
    public function selectUrl(){
        $uniacid = input('appletid');
        $tplid = input('tplid_only'); //模板id
        if(!$tplid){
            $tplid = Db::table('ims_sudu8_page_diypagetpl')->where("uniacid",$uniacid)->where("status",1)->find()['id'];
        }
        $pageid = explode(",",Db::table('ims_sudu8_page_diypagetpl')->where("uniacid",$uniacid)->where("id",$tplid)->field("pageid")->find()['pageid']); //当前模板拥有的页面id
        $diypage = Db::table('ims_sudu8_page_diypage')->where("uniacid",$uniacid)->where("id","in",$pageid)->field("id,tpl_name")->select();

        $article = Db::table('ims_sudu8_page_products')->where("uniacid",$uniacid)->where("type","showArt")->field("id,title")->select();
        $pro = Db::table('ims_sudu8_page_products')->where("uniacid",$uniacid)->where("type","neq","showArt")->where("type","neq","showPic")->where("type","neq","wxapp")->field("id,title,type,is_more")->select();
        if($pro){
            foreach ($pro as $k => $v) {
                if($v['is_more'] == 1){
                    $pro[$k]['type'] = "showPro_lv";
                }
            }
        }
        $pic = Db::table('ims_sudu8_page_products')->where("uniacid",$uniacid)->where("type","showPic")->field("id,title")->select();
        $cates = Db::table('ims_sudu8_page_cate')->where("uniacid",$uniacid)->where("cid",0)->field("id,name,type")->select();
        if($cates){
            foreach ($cates as $k => $v) {
                if($v['type'] == "showPro"){
                    $cates[$k]['type'] = "listPro";
                }
                if($v['type'] == "showPic" || $v['type'] == "showArt"){
                    $cates[$k]['type'] = "listPic";
                }
                $subcate = Db::table('ims_sudu8_page_cate')->where("uniacid",$uniacid)->where("cid",$v['id'])->field("id,name,type")->select();

                foreach ($subcate as $ki=> $vi) {
                    if($vi['type'] == "showPro"){
                        $subcate[$ki]['type'] = "listPro";
                    }
                    if($vi['type'] == "showPic" || $vi['type'] == "showArt"){
                        $subcate[$ki]['type'] = "listPic";
                    }
                }
                $cates[$k]['subcate'] = $subcate;
            }

        }

        $this->assign("diypage",$diypage);
        $this->assign("article",$article);
        $this->assign("pro",$pro);
        $this->assign("pic",$pic);
        $this->assign("cates",$cates);
        $this->assign("uniacid",$uniacid);
        return $this->fetch('selecturl');
    }
    public function selectsource(){

        $uniacid = input("appletid");

        $type = input('type');

        switch ($type){

            case 'noticcate':

                $list = Db::table("ims_sudu8_page_cate")->where("uniacid",$uniacid)->where("type","showArt")->where("cid",0)->field("id,name")->select();
                foreach ($list as $key => &$value) {
                    $subcate = Db::table("ims_sudu8_page_cate")->where("uniacid",$uniacid)->where("type","showArt")->where("cid",$value['id'])->field("id,name")->select();
                    $value['subcate'] = $subcate;
                }
                break;

            case 'goodscate':

                $list = Db::table("ims_sudu8_page_cate")->where("uniacid",$uniacid)->where("type","showPro")->where("cid",0)->field("id,name")->select();
                foreach ($list as $key => &$value) {
                    $subcate = Db::table("ims_sudu8_page_cate")->where("uniacid",$uniacid)->where("type","showPro")->where("cid",$value['id'])->field("id,name")->select();
                    $value['subcate'] = $subcate;
                }
                break;

            case 'piccate':


                $list = Db::table("ims_sudu8_page_cate")->where("uniacid",$uniacid)->where("type","showPic")->where("cid",0)->field("id,name")->select();
                foreach ($list as $key => &$value) {
                    $subcate = Db::table("ims_sudu8_page_cate")->where("uniacid",$uniacid)->where("type","showPic")->where("cid",$value['id'])->field("id,name")->select();
                    $value['subcate'] = $subcate;
                }
                break;

            case 'picartcate':

                $list = Db::query("SELECT id,name,type FROM ims_sudu8_page_cate WHERE `uniacid` = {$uniacid} AND `cid` = 0 AND (`type` = 'showPic' or `type` = 'showArt')");
                foreach ($list as $key => &$value) {
                    $subcate = Db::query("SELECT id,name,type FROM ims_sudu8_page_cate WHERE `uniacid` = {$uniacid} AND (`type` = 'showPic' or `type` = 'showArt') AND cid = {$value['id']}");
                    $value['subcate'] = $subcate;
                }
                break;

            case 'articlecate':


                $list = Db::table("ims_sudu8_page_cate")->where("uniacid",$uniacid)->where("type","showArt")->where("cid",0)->field("id,name")->select();
                foreach ($list as $key => &$value) {
                    $subcate = Db::table("ims_sudu8_page_cate")->where("uniacid",$uniacid)->where("type","showArt")->where("cid",$value['id'])->field("id,name")->select();
                    $value['subcate'] = $subcate;
                }
                break;
            case 'ptcate':

                $list = Db::table("ims_sudu8_page_pt_cate")->where("uniacid",$uniacid)->field("id,title as name")->select();
                foreach ($list as $key => &$value) {
                    $value['subcate'] = "";
                }
                break;
            case 'formcate':

                $list = Db::table("ims_sudu8_page_formlist")->where("uniacid",$uniacid)->field("id,formname as name")->select();
                foreach ($list as $key => &$value) {
                    $value['subcate'] = "";
                }
                break;

        }
        $this->assign("type",$type);

        $this->assign("list",$list);

        $this->assign("uniacid",$uniacid);

        return $this->fetch('selectsource');

    }

    public function selecticon(){
        return $this->fetch('icon');
    }
    
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
    public function moban(){
        if(check_login()){
            if(powerget()){

                $appletid = input("appletid");

                $res = Db::table('applet')->where("id",$appletid)->find();

                $usergroup = Session::get('usergroup');

                $this->assign('usergroup', $usergroup);


                if(!$res){

                    $this->error("找不到对应的小程序！");
                }

                $this->assign('applet',$res);


                $is = Db::table("ims_sudu8_page_diypagetpl")->where('uniacid',$appletid)->select();

                //将原有页面放到一个模板中
                if(!$is){
                    $pages = Db::table("ims_sudu8_page_diypage")->where('uniacid',$appletid)->field('id')->select();
                    if($pages){
                        $pageids = '';
                        foreach ($pages as $key => $value) {
                            $pageids .= ','.$value['id'];
                        }
                        $pageids = substr($pageids,1);
                        $data = [
                                'pageid' => $pageids,
                                'uniacid' => $appletid,
                                'template_name' => '原有页面模板',
                                'thumb' => "/diypage/img/blank.jpg",
                                'status' => 1,
                                'create_time' => time()
                                ];
                        Db::table("ims_sudu8_page_diypagetpl")->insert($data);
                    }
                }
                $moban = Db::table("ims_sudu8_page_diypagetpl")->where('uniacid',$appletid)->select();
                foreach ($moban as $key => &$value) {
                    $value['thumb'] = remote($appletid, $value['thumb'], 1);
                }
                $moban_sys = Db::table("ims_sudu8_page_diypagetpl_sys")->select();
                foreach ($moban_sys as $key => &$value) {
                    $value['thumb'] = remote($appletid, $value['thumb'], 1);
                }
                $this->assign("moban_sys",$moban_sys);
                $this->assign("moban",$moban);

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
            return $this->fetch('moban');
        }else{

            $this->redirect('Login/index');

        }
    }
    public function moban_copy(){
        $id = input("id");
        $uniacid = input("appletid");
        //改变原来的模板状态为不启用
        $tpls = Db::table("ims_sudu8_page_diypagetpl")->where('uniacid',$uniacid)->select();
        if($tpls){
            foreach ($tpls as $k => $v) {
                Db::table("ims_sudu8_page_diypagetpl")->where('uniacid',$uniacid)->update(array('status' => 2));
            }
        }
        //判断系统模板是否为空白模板
        if ($id == 'sys_blank') {
            //是
            //为空白模板添加页面
            $pageid = Db::table("ims_sudu8_page_diypage")->insertGetId(array(
                'uniacid' => $uniacid,
                'index' => 1,
                'page' => 'a:7:{s:10:"background";s:7:"#f1f1f1";s:13:"topbackground";s:7:"#ffffff";s:8:"topcolor";s:1:"1";s:9:"styledata";s:1:"0";s:5:"title";s:21:"小程序页面标题";s:4:"name";s:18:"后台页面名称";s:10:"visitlevel";a:2:{s:6:"member";s:0:"";s:10:"commission";s:0:"";}}',
                'items' => '',
                'tpl_name' => '后台页面名称',
            ));
            
            $tplid = Db::table("ims_sudu8_page_diypagetpl")->insertGetId(array(
                'uniacid' => $uniacid,
                'pageid' => $pageid,
                'template_name' => '空白模板',
                'thumb' => '/diypage/img/blank.jpg',
                'status' => '1',
                'create_time' => time(),
            ));
            if($tplid){
                return $tplid;
            }
        } elseif($id > 0) {
            $tplinfo = Db::table("ims_sudu8_page_diypagetpl_sys")->where('id',$id)->find();
            $pageid = explode(",",$tplinfo['pageid']);
            $pageids = '';
            foreach ($pageid as $key => $value) {
                $info = Db::table("ims_sudu8_page_diypage_sys")->where("id",$value)->find();
                $insert_id = Db::table('ims_sudu8_page_diypage')->insertGetId(array(
                        'uniacid' => $uniacid,
                        'index' => $info['index'],
                        'page' => $info['page'],
                        'items' => $info['items'],
                        'tpl_name' => $info['tpl_name'],
                    ));
                $pageids = $pageids .','. $insert_id;
            }
            $pageids = substr($pageids,1);
            $data = [
                'uniacid' => $uniacid,
                'pageid' => $pageids,
                'template_name' => $tplinfo['template_name'],
                'thumb' => $tplinfo['thumb'],
                'status' => '1',
                'create_time' => time()
            ];
            $tplid = Db::table("ims_sudu8_page_diypagetpl")->insertGetId($data);
            if($tplid){
                return $tplid;
            }
        }
    }
    //删除模板
    public function del_moban(){
        $appletid = input("appletid");
        $id = input("id");
        $sql = Db::table("ims_sudu8_page_diypagetpl")->where("uniacid",$appletid)->where("id",$id)->field('pageid')->find();
        $tplpages = $sql['pageid'];
        if($tplpages){
            $tplpagearr = explode(',',$tplpages);
            foreach ($tplpagearr as $key => $value) {
                Db::table('ims_sudu8_page_diypage')->where("uniacid", $appletid)->where("id", $value)->delete();
            }
        }
        $res = Db::table("ims_sudu8_page_diypagetpl")->where("uniacid",$appletid)->where("id",$id)->delete();
        if($res){
            return 1;
        }else{
            return 2;
        }
    }

    //删除系统模板
    public function del_sys_moban(){
        $appletid = input("appletid");
        $id = input("id");
        $sql = Db::table("ims_sudu8_page_diypagetpl_sys")->where("uniacid",$appletid)->where("id",$id)->field('pageid')->find();
        $tplpages = $sql['pageid'];
        if($tplpages){
            $tplpagearr = explode(',',$tplpages);
            foreach ($tplpagearr as $key => &$value) {
                // pdo_delete("sudu8_page_diypage_sys", array('id' => $value));
                Db::table('ims_sudu8_page_diypage_sys')->where("uniacid", $appletid)->where("id", $value)->delete();
            }
        }
        // $res = pdo_delete("sudu8_page_diypagetpl_sys", array("id" => $id));
        $res = Db::table("ims_sudu8_page_diypagetpl_sys")->where("id",$id)->delete();
        if($res){
            return 1;
        }else{
            return 2;
        }
    }

    public function webmoban(){
        $appletid = input("appletid");

        $res = Db::table('applet')->where("id",$appletid)->find();

        if(!$res){

            $this->error("找不到对应的小程序！");
        }

        $this->assign('applet',$res);

        return $this->fetch("webmoban");
    }
}