<?php
namespace app\index\controller;
use org\Http;
use think\Cache;
use think\Controller;
use think\Db;

class Autoupdate extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
    }

    public function receive()
    {
        $updateKey=input('key');
        if($updateKey==''){
            return json_encode(array('code' => 0, 'msg' => 'updateKey不能为空'));
          }
        $otaservice        = Db::name('system')->field('value')->where('name', 'otaservice')->find();
        $config            = unserialize($otaservice['value']);
        
        if($config['updatekey']!=$updateKey){
          return json_encode(array('code' => -1, 'msg' => 'updateKey有误'));
        }
        $table=input('table');
        if($table!='article'&&$table!='forum'){
            return json_encode(array('code' => -10, 'msg' => '表名不正确'));
        }
        $data=json_decode(input('data'),true);
        //查找推送的md5是否存在
        $md5s=array_keys($data);

        //
        $where['hash']=['in',$md5s];
        $list=Db::name($table)->where($where)->column('hash');
        $arr=[];
        foreach($data as $k => &$v){
            if(in_array($k,$list)){
                unset($data[$k]);
            }else{
                $v['uid']=1;
                array_push($arr,$k);
            }
        }

        $res= model($table)->allowfield(true)->saveAll($data);
        $where2['hash']=['in',$arr];
        $arrList=Db::name($table)->where($where)->column('hash,id');

        if($res){
            return json_encode(array('code' => 200, 'msg' => '自动推送成功'));
        }else{
            return json_encode(array('code' => -2, 'msg' => '自动推送失败'));
        }
    }

}
