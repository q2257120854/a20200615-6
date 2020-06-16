<?php
    namespace Admin\Model;
    use Think\Model;
    class BrandModel extends Model{
        /**
        *查询品牌列表
        *@param  $map      fixed    传入查询条件
        *@param  $limit   string    查询条数 如 0,5
        *@return array              返回数组
        */
        public function selectBrand($map= '1' ,$limit = ''){
        	$brand = M('brand');
        	return $brand -> where($map) -> limit($limit) -> order("brandpic asc,bid asc") -> select();
        }

        /**
        *查询品牌的总数
        *@param  $map      fixed    传入查询条件
        *@return array              返回数组
        */
        public function brandCount($map= '1'){
        	$brand = M('brand');
        	return $brand -> where($map) -> count();
        }

        /**
        *查询包含指定品牌的分类
        *@param  $bid    int    传入品牌的id
        *@return array          返回数组
        */
        public function allClass($bid){
        	$brand = D('ClassBrandView');
        	return $brand -> where("bid = $bid") -> select();
        }
    }