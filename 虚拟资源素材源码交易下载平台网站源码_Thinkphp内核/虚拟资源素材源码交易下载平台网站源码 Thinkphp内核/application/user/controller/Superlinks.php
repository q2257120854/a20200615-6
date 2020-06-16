<?php
namespace app\user\controller;

use org\Http;
use think\Cache;
use think\Controller;
use think\Db;
use think\Session;

class Push extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
       
    }

    public function Agree_link()
    {
        //同意互联后会在双方站点写入
        $where['id']=['gt',0];
        $list=Db::name('article')->where($where)->select();
        $data=[];
        foreach($list as $v){
            $v['id']=null;
            $data[]=$v;
        }

        //查询需要推送的网站
        $domain='www.52txw.cn';
        $url='https://'.$domain.'/index/autoupdate/receive';
        $post['key']='a6e5781ba436bee84854f39da0293b64';
        $post['table']='article';
        $post['data']=json_encode($data);
        //print_r($post['data']);
      //  $post['attachlink']=json_encode($attachlink);
        $htd    = new Http();
        $line = $htd->get_curl($url,$post);
        $line = str_replace('\\t', '', $line);
        $result = json_decode($line, true);
        print_r($line);
        
    }
	public function Be_Agree_link()
    {
        //同意互联后会在双方站点写入
        $where['id']=['gt',0];
        $list=Db::name('superlinks')->where($where)->select();
        $data=[];
        foreach($list as $v){
            $v['id']=null;
            $data[]=$v;
        }

        //查询需要推送的网站
        $domain='www.52txw.cn';
        $url='https://'.$domain.'/index/autoupdate/receive';
        $post['key']='a6e5781ba436bee84854f39da0293b64';
        $post['table']='article';
        $post['data']=json_encode($data);

        $htd    = new Http();
        $line = $htd->get_curl($url,$post);
        $line = str_replace('\\t', '', $line);
        $result = json_decode($line, true);
        print_r($line);
        
    }
}
