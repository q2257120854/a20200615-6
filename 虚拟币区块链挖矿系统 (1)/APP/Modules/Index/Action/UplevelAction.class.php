<?php


class UplevelAction extends Action{
	
	public function index(){
		header("Content-type: text/html; charset=utf-8");
		ini_set('max_execution_time', '1000');
		$t=I('get.t',1,'intval');
		$where="level > 0";
		if($t==1){
			$where.=" and id>0 and id<3000";
		}elseif($t==2){
			$where.=" and id>=3000 and id<6000";
		}elseif($t==3){
			$where.=" and id>=6000 and id<9000";
		}elseif($t==4){
			$where.=" and id>=9000 and id<12000";
		}elseif($t==5){
			$where.=" and id>=12000 and id<15000";
		}elseif($t==6){
			$where.=" and id>=15000 and id<18000";
		}elseif($t==7){
			$where.=" and id>=18000 and id<21000";
		}elseif($t==8){
			$where.=" and id>=21000 and id<24000";
		}elseif($t==9){
			$where.=" and id>=24000 and id<27000";
		}elseif($t==10){
			$where.=" and id>=27000 and id<30000";
		}else{
			$where.=" and id>=30000 ";
		}
		
		
		
		
		$list = M("member")->where($where)->order("id desc")->select();
		
		if(!empty($list)){
			 foreach($list as $k=>$v){
				  $level = $v['level'] + 1;
				  $groupinfo = M("member_group")->where(array("level"=>$level))->find();
				  if($groupinfo){
					  if($v['parentcount']>=$groupinfo['tjjnum'] && $v['gamecount']>=$groupinfo['teamnum'] && $v['teamgonglv']>=$groupinfo['teamsuanli']){
						  M("member")->where(array("id"=>$v['id']))->setField("level",$level);
					  }
				  }
			  }	
		
			$this->redirect('Index/Uplevel/index', array('t' => $t+1), 3, '正在执行升级程序请勿关闭页面...');
		
		}else{
			
			exit("升级程序执行完毕！");		
			
		}
		
		
		 
		
		
		
		
		exit;
		
		
		
		
		
	}	
	
	
	
	
	
		
}

?>