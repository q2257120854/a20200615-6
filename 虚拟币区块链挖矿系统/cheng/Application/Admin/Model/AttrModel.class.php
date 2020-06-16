<?php
    namespace Admin\Model;
    use Think\Model;
    class AttrModel extends Model{

    	/**
        *查询属性列表
        *@return  array  返回数组
        */
        public function selectAttr($map= '1' ,$limit = ''){
        	$attr = D('ClassAttrView');
        	return $attr ->where($map) -> limit($limit) -> order("cid asc,attrsort asc") -> select();
        }

        /**
        *查询属性总数
        *@param  $map fixed      传入查询条件
        *@return array  返回数组
        */
        public function attrCount($map= '1'){
        	$attr = M('attribute');
        	return $attr -> where($map) -> count();
        }

        /**
        *查询所有属性列表包含属性值
        *@param  $map      fixed    传入查询条件
        *@param  $limit   string    查询条数 如 0,5
        *@return array              返回数组
        */
        public function allAttr($map= '1' ,$limit = ''){
        	$attr = $this -> selectAttr($map,$limit);
        	foreach ($attr as $key => $value) {
        		$data = $this -> findAttrValue($value['attrid']);
        		$attrvalue = '';
        		foreach ($data as $k => $v) {
	        		$attrvalue[$k] = $v['attrvalue'];
	        	}
	        	$attr[$key]['attrvalue'] =  implode(',', $attrvalue);
        	}
        	return $attr;
        }

        /**
        *查询指定属性的属性值
        *@param  $attrid  int    指定属性的id
        *@return array  返回数组
        */
        public function findAttrValue($attrid){
        	$attr = M('goodstoattr');
        	return $attr -> where("attrid = $attrid") -> select();
        }
    }