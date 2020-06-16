<?php
namespace app\index\controller;

use org\Http;
use think\Cache;
use think\Controller;
use think\Db;
use think\Session;
use think\Request;
use think\Config;

class Job extends Controller
{

    

    public function time_push_article()
    {
        if(!input('update_key')){
            die('非法入侵');
        }
        if(input('update_key')=='test12345678912345678911111'){
            die('请修改初始化的update_key');
        }
        $res = Db::name('system')->where('name', 'otaservice')->find();
        if ($res) {
            $ota_info = unserialize($res['value']);
            if($ota_info['updatekey']!=input('update_key')){
                die('update_key不正确');
            }
        }
      
        $db_config = array();
        $prefix = Config::get('database.prefix');
        $sql = "update ".$prefix."article set open=1,updatetime=time where open=0 and time<".time()." and time>updatetime;";
        //执行插入操作
        $result = Db::execute($sql);            
        // $map['open'] = 0;//还是草稿状态
        // $map['time'] = ['<',time()];
        // $result =Db('article')->where('time > updatetime')->where($map)->setField("open",1); //改为发布状态

        if($result!==false){
            return json(array('code' => 0, 'msg' => '自动发布成功'));
        }

    }
}
