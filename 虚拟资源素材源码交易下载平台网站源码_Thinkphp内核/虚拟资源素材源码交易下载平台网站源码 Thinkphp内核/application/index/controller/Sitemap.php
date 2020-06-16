<?php
namespace app\index\controller;

use org\Http;
use think\Cache;
use think\Controller;
use think\Db;
use think\Session;
use app\common\model\Sms as SmsModel;

class Sitemap extends Controller
{
    protected $site_config;
    public function _initialize()
    {
        parent::_initialize();
        $this->site_config = Cache::get('site_config');
    }


    public function index() {
        //$tables = Db::name()->db()->getTables();//获取网站所有的表

        $site_url = (is_HTTPS()?'https://':'http://').$_SERVER['HTTP_HOST'];

        $str = '<?xml version="1.0" encoding="utf-8"?>'.PHP_EOL;
        $str .= '<urlset>'.PHP_EOL;
        // article 表
        $articles = Db::name('article')->where('open',1)->field('id,updatetime')->select();
        foreach ($articles as $k => $v) {
            $str .= '<url>';
            $str .= '<loc>'.$site_url.'/html/'.$v['id'].'.html</loc>'.PHP_EOL;
            // if($v['last_time']){
            //     $str .= '<lastmod>'.date('Y-m-d' ,$v['last_time']).'</lastmod>'.PHP_EOL;
            // }else{
                $str .= '<lastmod>'.date('Y-m-d h:i:s' ,$v['updatetime']).'</lastmod>'.PHP_EOL;
            // }            
            $str .= '<priority>1.0</priority >'.PHP_EOL;
            $str .= '<changefreq>Always</changefreq>'.PHP_EOL.PHP_EOL.PHP_EOL;
            $str .= '</url>';
        }
      

        // article_cate表
        $article_cate = Db::name('articlecate')->field('alias')->select();
        foreach ($article_cate as $k => $v) {
            $str .= '<url>';
            $str .= '<loc>'.$site_url.'/lists/'.$v['alias'].'.html</loc>'.PHP_EOL;
            $str .= '<lastmod>'.date('Y-m-d h:i:s' ,time()).'</lastmod>'.PHP_EOL;          
            $str .= '<priority>1.0</priority >'.PHP_EOL;
            $str .= '<changefreq>Always</changefreq>'.PHP_EOL.PHP_EOL.PHP_EOL;
            $str .= '</url>';
        }


        $str .='</urlset>'.PHP_EOL;
        file_put_contents(APP_PATH."/../sitemap.xml", $str);
        echo '已经更新成功！可以到网站根目录下的<a href="'.$site_url.'/sitemap.xml">sitemap.xml</a>查看！';
        // echo '<script>alert("已经更新成功！可以到网站根目录下的Sitemap.xml查看！");</script>';
    }
   
}
