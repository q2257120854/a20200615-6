<?php
namespace app\index\model;
use think\Model;
class Article extends Model
{

   function add($data){
       
		$result = $this->isUpdate(false)->allowField(true)->save($data);
		if($result){
			return true;
		}else{
			return false;
		}
	}

	function edit($data){
		$data['updatetime']=time();
		$result = $this->isUpdate(true)->allowField(true)->save($data);
		if($result){
			return true;
		}else{
			return false;
		}
	}
}
