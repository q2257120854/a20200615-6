<?php
namespace app\index\controller;

use org\Http;
use think\Cache;
use think\Controller;
use think\Db;
use think\Session;
use app\common\model\Sms as SmsModel;

class Api extends Controller
{
    protected $site_config;
    public function _initialize()
    {
        parent::_initialize();
        $this->site_config = Cache::get('site_config');
    }


    public function downinfo()
    {

        $data = request()->param();
        Db::name('attach')->where('id', $data['id'])->setInc('download');
        $info = Db::name('attach')->where('id', $data['id'])->find();
        return json(array('code' => 200, 'msg' => '开始下载', 'url' => $info['savepath']));
    }
    public function download($url, $name, $local)
    {
        $local1 = $local;
        if (strpos($url, 'zip') === false || strpos($url, 'rar') === false) {
            $local1 = 0;
        }
        $down = new Http();
        if ($local1 == 1) {
            $down->download($url, $name);
        }
    }
    public function getMyItem()
    {
        $uid = session('userid');

        $tableArr = ['article', 'forum'];
        $table    = in_array(input('item'), $tableArr) ? input('item') : '';
        if (!$uid || !$table) {
            return json(array('code' => 0, 'msg' => '请求非法'));
        }

        $limit = is_number(input('limit')) ? input('limit') : 1;
        $page  = is_number(input('page')) ? input('page') : 10;
        $pre   = ($page - 1) * $limit;

        $model = Db::name($table);
        $count = $model->where("uid = {$uid}")->count();

        $field = 'm.*,c.template,c.name as catename';
        $order = 'updatetime DESC';
        if ($table == 'forum') {
            $field = 'm.*,c.name as catename';
            $order = 'time DESC';
        }
        $tptc = $model->alias('m')->join($table . 'cate c', 'c.id=m.tid', 'LEFT')->where("uid = {$uid}")->field($field)->order($order)->limit($pre, $limit)->select();
        foreach ($tptc as $k => $v) {
            $tptc[$k]['title'] = strip_tags($v['title']);
        }
        return json(array('code' => 0, 'msg' => '', 'count' => $count, 'data' => $tptc));
    }
    public function getMyCollect()
    {
        $uid      = session('userid');
        $type     = is_number(input('ctype')) ? input('ctype') : '';
        $tableArr = ['article', 'forum'];
        $table    = in_array(input('item'), $tableArr) ? input('item') : '';
        if (!$type || !$uid || !$table) {
            return json(array('code' => 0, 'msg' => '请求非法'));
        }

        $limit = is_number(input('limit')) ? input('limit') : 1;
        $page  = is_number(input('page')) ? input('page') : 10;
        $pre   = ($page - 1) * $limit;
        $model = Db::name('collect');
        $count = $model->where("uid = {$uid}")->count();
        $field = 'c.*,t.uid as zuid,u.username,t.id as fid,t.title,a.template';
        if ($table == 'forum') {
            $field = 'c.*,t.uid as zuid,u.username,t.id as fid,t.title';
        }

        $tptc = $model->alias('c')->join($table . ' t', 'c.sid=t.id', 'LEFT')->join($table . 'cate a', 'a.id=t.tid')->join('user u', 'u.id=t.uid')->field($field)->where("c.uid = {$uid} and c.type = {$type}")->order('id DESC')->limit($pre, $limit)->select();
        foreach ($tptc as $k => $v) {
            $tptc[$k]['title'] = strip_tags($v['title']);
        }
        return json(array('code' => 0, 'msg' => '', 'count' => $count, 'data' => $tptc));
    }
    public function zan_collect()
    {
        $data = $this->request->param();
        $id   = $data['id'];
        $uid  = session('userid');
        if (!session('userid') || !session('username')) {

            return json(array('code' => 0, 'msg' => '登录后才能操作'));
        } else {

            //状态:
            // 0 用户 1 帖子 2 评论
            $zan_collect = $data['zan_collect'];

            $msgsubject                         = '';
            $zan_collect == 'zan' ? $msgsubject = '点赞' : $msgsubject = '收藏';
            $tablename                          = '';
            $type                               = $data['type'];
            switch ($type) {
                case 1:
                    $tablename = 'forum';

                    break;

                case 2:

                    $tablename = 'comment';
                    break;

                case 3:

                    $tablename = 'article';
                    break;

                    case 4:

                    $tablename = 'artcomment';
                    break;
                    
                default:
                    $msgsubject = '关注';
                    $tablename  = 'user';
                    break;
            }
            $zuid = $id;
            if ($type != '0') {
                $zuid = Db::name($tablename)->where('id', $id)->value('uid');

            }
            if ($zuid == $uid) {
                return json(array('code' => 0, 'res' => '减', 'msg' => '不可以孤芳自赏哦'));

            }

            $insertdata['type'] = $type;
            $insertdata['uid']  = $uid;
            $insertdata['sid']  = $id;

            $n = Db::name($zan_collect)->where($insertdata)->find();
            if (empty($n)) {
                $insertdata['time'] = time();
                if (Db::name($zan_collect)->insert($insertdata)) {

                    Db::name($tablename)->where('id', $id)->setInc($zan_collect);

                    return json(array('code' => 200, 'res' => '加', 'msg' => $msgsubject . '成功'));

                } else {
                    return json(array('code' => 0, 'res' => '加', 'msg' => $msgsubject . '失败'));

                }
            } else {
                if (Db::name($zan_collect)->where('id', $n['id'])->delete()) {
                    Db::name($tablename)->where('id', $id)->setDec($zan_collect);
                    return json(array('code' => 200, 'res' => '减', 'msg' => $msgsubject . '成功'));

                } else {
                    return json(array('code' => 0, 'res' => '减', 'msg' => $msgsubject . '失败'));
                }
            }

        }
    }
//打赏
    public function tipauthor()
    {
        $data   = $this->request->param();
        $thread = Db::name('forum')->where('id', $data['id'])->find();
        $zuid   = $thread['uid'];
        $pay    = is_number(input('pay')) ? input('pay') : '';
        if ($pay <= 0) {
            exit('{"code":0,"msg":"你想干啥"}');
        }
        $uid = session('userid');
        if (!session('userid') || !session('username')) {
            exit('{"code":0,"msg":"登录后才能操作"}');
        } else {

            if ($zuid == $uid) {
                exit('{"code":0,"msg":"你太无聊了，不可以孤芳自赏哦"}');
            } else {

                $point = Db::name('user')->where('id', $uid)->value('point');

                if ($point < $pay) {
                    exit('{"code":-1,"msg":"量力而行，你只有' . $point . $this->site_config['jifen_name'] . '"}');
                } else {
                    point_note(0 - $pay, $uid, 'tipauthor', $data['id']);
                    point_note($pay, $zuid, 'tipauthor', $data['id']);
                    Db::name('user')->where('id', $zuid)->setInc('tips');
                    exit('{"code":200,"msg":"打赏成功"}');
                }
            }
        }
    }
     //禁言
     public function gaguser()
     {
         $uid = session('userid');
         $id  = is_number(input('id')) ? input('id') : 0;
         $cid = is_number(input('cid')) ? input('cid') : 0;
 
         if ($uid > 0 && $id && $cid) {
 
             //检测是不是自己的
             $zuid = db('comment')->where('id', $id)->value('uid');
             //检测是否是版主
             $res = 0;
             if ($zuid == $uid) {
                 $res = 1;
             } else {
                 $catemodel = new ForumcateModel();
                 $res       = $catemodel->isbanzhu($uid, $cid);
             }
 
             if ($res) {
 
                 if (db('comment')->delete($id)) {
                     return json(array('code' => 200, 'msg' => '删除成功'));
                 } else {
                     return json(array('code' => 0, 'msg' => '删除失败'));
                 }
 
             } else {
                 return json(array('code' => 0, 'msg' => '没有权限'));
             }
 
         } else {
             return json(array('code' => 0, 'msg' => '你迷路了'));
         }
     }
 function gettaoke()
    {

        $taoke_config = Db::name('system')->field('value')->where('name', 'taoke')->find();

        $taoke_config = unserialize($taoke_config['value']);

        $htd = new Http();
        if ($line = $htd->get_curl($taoke_config['quan_api'].'&page=1')) {
            ///$line = str_replace('\\t', '', $line);
           $_res = json_decode($line, true);
           $res=$_res['result'];
           $data=array();
           $arr=array_rand(range(1,100),6);
           $i=0;
           foreach ($arr as $k => $v){
            $i++;
            $data[$k]['pic']=$res[$v]['Pic'];
            $data[$k]['title']=$res[$v]['Title'];
            $data[$k]['quan']=floatval($res[$v]['Quan_price']);
            $data[$k]['price']=floatval($res[$v]['Org_Price']);
            $data[$k]['link']=$res[$v]['Quan_link'];
              if($i==6) break;
           }
           return json(array('code'=>200,'data'=>$data));
        }
    }
     //申请友联
     public function applySuperlink(){
        $data = $this->request->post();

        $_data['uid'] = session('userid');

        if(!$_data['uid']){

            $this->error('没有登录');  

        }  

       

        //查询记录

        $count=Db::name('superlinks')->where('uid',$_data['uid'])->count();

        if($count>=3){

            $this->error('一个用户最多只能申请三个友链');

        }

        $_data['title']=remove_xss($data['title']);

        $_data['cover_id']=remove_xss($data['cover_id']);
        $_data['type']=remove_xss($data['type']);
        $_data['link']=remove_xss($data['link']);

        $_data['contacts']=remove_xss($data['contacts']);
        $_data['create_time'] = time();
        if (!Db::name('superlinks')->insert($_data)) {
            $this->error('提交失败');
        } else {
            $this->success('提交申请成功，请等待站长审核！');
        }
    }


    function send_sms() {



        $arr=array(
            0=>'发送成功',
            30=>'短信平台密码错误',
            40=>'短信平台账号不存在',
            41=>'短信平台余额不足',
            42=>'短信平台帐户已过期',
            43=>'IP地址受短信平台限制',
            50=>'内容含有敏感词',
            51=>'手机号码不正确',
            -2=>'服务器空间不支持',
            -1=>'发送短信参数不全，请联系站长'
        );

        $data = $this->request->param();
        if (!captcha_check(input('vercode'))) {
            return json(array('code' => -1, 'msg' => '验证码错误'));
        }
        $code=rand(1000,9999);
        $mobile=$data['mobile'];


        $find = Db::name('system')->field('value')->where('name', 'sms')->find();
        $smsConfig = unserialize($find['value']);
        $params=explode("\n",$smsConfig['params']);
        $paramArr=[];
        foreach($params as $v){
            $_arr=explode("=",$v);
            $paramArr[$_arr[0]]=$_arr[1];
        }
       
        $ip=$this->request->ip();
        $model= new SmsModel();
       
        $where1['created_at']=$where2['created_at']=['gt',date('Y-m-d')];
        $where1['mobile']=$mobile;
        $mobileCount=$model->where($where1)->count();
        if(!isset($smsConfig['mobile_max'])){
            return json(array('code' => -1, 'msg' => '短信服务配置有误，请联系管理员'));
        }
        $mobileMax=$smsConfig['mobile_max'];
        if($mobileCount>=$mobileMax){
            return json(array('code' => -1, 'msg' => '每个手机号每天限制发送'.$mobileMax.'条短信')); 
        }
        $where2['ip']=['eq',$ip];
        $ipCount=$model->where($where2)->count();
        $ipMax=$smsConfig['ip_max'];
        if($ipCount>=$ipMax){
            return json(array('code' => -1, 'msg' => '每个IP每天限制发送'.$ipMax.'条短信')); 
        }
		//获取结果
        $url = $smsConfig['apiurl']."?u=".$paramArr['u']."&p=".md5($paramArr['p'])."&m=".$mobile."&c=".urlencode("【".$this->site_config['site_title']."】验证码：".$code."，您正在绑定".$this->site_config['site_title']."手机号，请5分钟内完成验证。如非本人操作，请忽略本短信。");
        $htd    = new Http();
        $data = $htd->get_curl($url);
        if(is_numeric($data)) {
            if($data==0){
                $model->type='REG';
                $model->content=$code;
                $model->mobile=$mobile;
                $model->ip=$ip;
                $model->expiry_time=date('Y-m-d H:i:s',time()+$smsConfig['expiry_time']);
                $model->save();
            }
			return json(array('code' => $data, 'msg' => $arr[$data]));
	    }else{
            return json(array('code' => -1, 'msg' => $data));
        }
    
    }
}
