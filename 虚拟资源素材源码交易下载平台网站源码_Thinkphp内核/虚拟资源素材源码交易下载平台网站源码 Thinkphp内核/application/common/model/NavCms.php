<?php
namespace app\common\model;
use think\Db;

use think\Model;

class NavCms extends Model
{

    public function catetree($pid)
    {
        $tptc = Db::name('nav_cms')->where('pid='.$pid)->order('id ASC')->select();

        return $this->sort($tptc);
    }

    public function catetree2($pid)
    {
        $tptc = Db::name('nav_cms')->where('pid='.$pid)->order('id ASC')->select();

        return $this->generateTree($tptc);
    }

    public function sort($data, $tid = 0, $level = 1)
    {
        static $arr = array();

        foreach ($data as $v) {

            if ($v['tid'] == $tid) {

                $v['level'] = $level;
                $arr[]      = $v;
                $this->sort($data, $v['id'], $level + 1);
            }
        }

        return $arr;
    }

    function generateTree($array){
        //第一步 构造数据
        $items = array();
        $cates= Db::name('articlecate')->field('id,alias')->select();
        $cates=array_column($cates,'alias','id');
        foreach($array as $value){
            if($value['sid']==1&&is_numeric($value['link'])){
                $value['link']='index/articles/lists,cate_alias,'.$cates[$value['link']];
            }
            $value['son'] = array();
            $items[$value['id']] = $value;
        }
        //第二部 遍历数据 生成树状结构
        $tree = array();
        foreach($items as $key => $value){
            if(isset($items[$value['tid']])){  
                $items[$value['tid']]['son'][] = &$items[$key];
            }else{
                $tree[] = &$items[$key];
            }
        }
        return $tree;
    }


}