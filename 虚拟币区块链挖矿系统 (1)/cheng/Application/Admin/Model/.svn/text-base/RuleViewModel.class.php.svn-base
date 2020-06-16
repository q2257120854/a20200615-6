<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class RuleViewModel extends ViewModel{
	public $viewFields=array(
		'rule' => array('_table'=>'sx_auth_rule','id','name','title','type','condition'=>'term','status','mid'),
		'modules' => array('moduleName','_on'=>'rule.mid=modules.id')
		);
}