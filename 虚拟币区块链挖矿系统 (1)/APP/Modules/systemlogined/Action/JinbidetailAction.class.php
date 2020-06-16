<?php
class JinbidetailAction extends CommonAction {
	public function qxjy(){
		$id = $_GET['id'];
		
		$map['id']=$id;
		
		$result=M('ppdd')->where($map)->find();//出售人信息
		if($result['datatype']=='cslkb'){
				$oobs = M('member')->where(array('username'=>$result['p_user']))->find();		
				$oob=M('member')->where(array('username'=>$result['p_user']))->setInc('jinbi',$oobs['qjinbi']);
				$obs=M('member')->where(array('username'=>$result['p_user']))->setDec('qjinbi',$oobs['qjinbi']);			
		}else{
				$oobs = M('member')->where(array('username'=>$result['g_user']))->find();		
				$oob=M('member')->where(array('username'=>$result['g_user']))->setInc('jinbi',$oobs['qjinbi']);
				$obs=M('member')->where(array('username'=>$result['g_user']))->setDec('qjinbi',$oobs['qjinbi']);			
			
		}

		
		
		if($oob && $obs){
			$re=M('ppdd')->where(array('id'=>$id))->delete();
			if($re){
				$this->success('订单删除成功');
			}	
		
		}
	}
	
	
	//toushu
	public function report_order(){
		
			$ppdd_id=I('get.ppdd_id',0,'intval');
			$where="1=1";
			
			if(!empty($ppdd_id)){
				$where.=" and a.pid = ".$ppdd_id;
			}
			import("ORG.Util.Page");// 导入分页类    	   	    	
			$count = M('tousu')->alias('a')->where ($where)->count (); // 查詢滿足要求的總記錄數
			$p = new Page($count,30);
			
			
			$list=M('tousu')->alias('a')
			->field("a.*,b.id as user_id,c.id as buser_id")
			->join("ds_member as b on a.user=b.username")
			->join("ds_member as c on a.buser=c.username")
			->where($where)->order("a.id desc")->limit ( $p->firstRow, $p->listRows )->select();
			$show = $p->show();// 分页显示输出
			$this->assign('page',$show);// 赋值分页输出		
	
			$this->assign ( 'list', $list ); // 賦值數據集
			$this->display();
		
		
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function jiaoyi(){
		
		
		
		$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );
		
		
		$gname=$data;
		if($data){
			$map['_string']="(p_user = '$gname' or g_user = '$gname')";
		}
			$map['zt']=1;
		
		$id=I('get.id','0','intval');
		
		if(!empty($id)){
			$map['id']=$id;
				
		}
		
		
        import("@.ORG.Util.Page");// 导入分页类    	   	    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = new Page($count,50);
    
    	$list = $User->where ( $map )->order ( 'jydate desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		
		
		
	     $show       = $p->show();// 分页显示输出
	     $this->assign('page',$show);// 赋值分页输出		

    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->display();
	}
	 public function cswc(){
		$User = M ( 'ppdd' ); // 實例化User對象

    	$data = I ( 'post.user' );
		$gname=$data;
		if($data){
			$map['_string']="(p_user = '$gname' or g_user = '$gname')";
		
		}
			$map['zt']=2;
			$map['datatype']="cslkb";
		
    	import("@.ORG.Util.Page");// 导入分页类    	   	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = new Page($count,12);
    
    	$list = $User->where ( $map )->order ( 'jydate  desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		
	     $show       = $p->show();// 分页显示输出
	     $this->assign('page',$show);// 赋值分页输出		

    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->display();
	}
	public function jywcdel(){
		$id=$_GET['id'];
		$ppdd=M('ppdd')->where(array('id'=>$id))->delete();
		if($ppdd){
			$this->success("删除成功");
		}
	}
    public function jywc(){
		
		
		$User = M ( 'ppdd' ); // 實例化User對象

		$gname=I ( 'post.user' );

		if($data){
			$map['_string']="(p_user = '$gname' or g_user = '$gname')";
		}
		$map['zt']=2;
		$map['datatype']="qglkb";
		
     	import("@.ORG.Util.Page");// 导入分页类    	   	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = new Page($count,50);
    
    	$list = $User->where ( $map )->order ( 'jydate  desc' )->limit ( $p->firstRow, $p->listRows )->select ();
		
	     $show       = $p->show();// 分页显示输出
	     $this->assign('page',$show);// 赋值分页输出		

    	$this->assign ( 'list', $list ); // 賦值數據集
		$this->display();
	}	
    public function qiugou(){

    	$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );	

		
		if($data){
			$map['p_user']=$data;
		}
		
		$map['zt']=0;
		$map['datatype']="qglkb";
    	import("@.ORG.Util.Page");// 导入分页类    	
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = new Page($count,12);
    
    	$list = $User->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
	     $show       = $p->show();// 分页显示输出
	     $this->assign('page',$show);// 赋值分页输出		

    	$this->assign ( 'list', $list ); // 賦值數據集
    	$this->display();
    }	
	public function qiugoudel(){
		$id=$_GET['id'];
		$ppdd=M('ppdd')->where(array('id'=>$id))->delete();
		if($ppdd){
			$this->success("删除成功");
		}
	}	
    public function csdd(){
    	$User = M ( 'ppdd' ); // 實例化User對象
    	$data = I ( 'post.user' );
		if($data){
			$map['p_user']=$data;

		}
		$map['zt']=0;
		$map['datatype']="cslkb";
		
    	import("@.ORG.Util.Page");// 导入分页类
    	$count = $User->where ( $map )->count (); // 查詢滿足要求的總記錄數
    	$p = new Page($count,12);
    
    	$list = $User->where ( $map )->order ( 'id desc' )->limit ( $p->firstRow, $p->listRows )->select ();
	     $show       = $p->show();// 分页显示输出
	     $this->assign('page',$show);// 赋值分页输出		

    	$this->assign ( 'list', $list ); // 賦值數據集
        $this->display();
	}	
	public function csdddel(){
		$id=$_GET['id'];
		$result=M('ppdd')->where(array('id'=>$id))->find();
		$users=M('member')->where(array('username'=>$result['p_user']))->find();
		$user1=M('member')->where(array('username'=>$result['p_user']))->setInc('jinbi',$users['qjinbi']);
		$user=M('member')->where(array('username'=>$result['p_user']))->setDec('qjinbi',$users['qjinbi']);
		$ppdd=M('ppdd')->where(array('id'=>$id))->delete();
		if($ppdd){
			$this->success("删除成功");
		}
	}	
 		public function index(){
			$map = $this -> _search();
	        if ($_GET['type']) {
	        	$map['type'] = array("eq",$_GET['type']); 
	        }			
			if (method_exists($this, '_search_filter')) {
				$this -> _search_filter($map);
			}
			$name = $this -> getActionName();
			$model = D($name);

			if (!empty($model)) {
				$this -> _list($model, $map);
			}

			$this->display();
		}   
    /**
     * 金币充值记录
     * @return [type] [description]
     */
    public function jinbiAddList(){	
    	$map = $this -> _search();
    	$map['desc'] = '平台充值';
		if (method_exists($this, '_search_filter')) {
			$this -> _search_filter($map);
		}
		$name = $this -> getActionName();
		$model = D($name);

		if (!empty($model)) {
			$this -> _list($model, $map);
		}
		$this -> display();
    }

		/**
		 * 电子货币明细
		 * @return [type] [description]
		 */
		public function emoneyList(){

			$Data = M('emoneydetail'); // 实例化Data数据对象
	        import("@.ORG.Util.Page");// 导入分页类
	        $map = array();
	        if (isset($_GET['account']) && $_GET['account']!='') {
	        	$map['account'] = $_GET['account']; 
	        }

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,10);// 实例化分页类 传入总记录数
	        
	        
	        $list = $Data->where($map)->order('id desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}

		/**
		 * 电子货币提现
		 * @return [type] [description]
		 */
		public function emoneyWithdraw(){
			$Data = M('emoneydetail'); // 实例化Data数据对象
	        import("@.ORG.Util.Page");// 导入分页类
	        $map = array();
	        if (isset($_POST['account']) && $_POST['account']!='') {
	        	$map['member'] = array("eq",$_POST['account']); 
	        }
	        if (isset($_POST['start_time']) && $_POST['start_time']!='') {
	        	$map['addtime'] = array("egt",strtotime($_POST['start_time'])); 
	        }
	        if (isset($_POST['end_time']) && $_POST['end_time']!='') {
	        	$map['addtime'] = array("elt",strtotime($_POST['end_time'])); 
	        }			

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,10);// 实例化分页类 传入总记录数
	        
	        
	        $list = $Data->where($map)->order('id desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}

        //提现信息查看页面
      	public function	editEmoney(){
			$emoneydetail = M('emoneydetail')->where(array('id'=>I('id')))->find();
			if($emoneydetail['type'] != 0){
				$this->error('非法操作!',U(GROUP_NAME.'/Jinbidetail/emoneyWithdraw'));
			}
			$this->assign('emoneydetail',$emoneydetail);			
			$this->display('editEmoney');
		}
		//提现信息处理
		public function editemoneyhandle(){
			$id = I('id',0,'intval');
			unset($_POST['id']);

			$type = $_POST['status'];
			if($type == 2){
				$emoneydetail = M('emoneydetail')->where(array('id'=>$id))->find();
				M('member')->where(array('username'=>$emoneydetail['member']))->setInc('yj',$emoneydetail['koujinbi']);
			}
			M('emoneydetail')->where(array('id'=>$id))->save(array('type'=>$type));
			//添加日志
			$desc = 'ID为'. $id .'的提现处理';
			write_log(session('username'),'admin',$desc);

			$this->success('提现处理完成!',U(GROUP_NAME.'/Jinbidetail/emoneyWithdraw'));

		}	
		//奖金查询
		public function jiangjin(){
			$member = M("member");
	        $map = array();
	        if (isset($_POST['account']) && $_POST['account']!='') {
	        	$where['username'] = array("eq",$_POST['account']); 
	        }
	
		    import("@.ORG.Util.Page");
			$count   = $member ->where($where)-> count();
			$Page   = new Page($count,15);
			$show = $Page -> show();
			$list = $member ->where($where)-> limit($Page ->firstRow.','.$Page -> listRows)->order('id desc') -> select();
	        if (isset($_POST['start_time']) && $_POST['start_time']!='') {
	        	$map['addtime'] = array("egt",strtotime($_POST['start_time'])); 
	        }
	        if (isset($_POST['end_time']) && $_POST['end_time']!='') {
	        	$map['addtime'] = array("elt",strtotime($_POST['end_time'])); 
	        }			
			foreach($list as $k=>$v){
				//前
				
				$map['member'] = array("eq",$v['username']); 
				
				$map['type']   = array("eq",1); 
				$list[$k]['j1'] =  M('jinbidetail')->where($map)->sum('adds');
				unset($map['type']);
				$map['type']   = array("eq",2); 
				$list[$k]['j2'] =  M('jinbidetail')->where($map)->sum('adds');
				unset($map['type']);
								$map['type']   = array("eq",3); 
				$list[$k]['j3'] =  M('jinbidetail')->where($map)->sum('adds');
				unset($map['type']);
								$map['type']   = array("eq",4); 
				$list[$k]['j4'] =  M('jinbidetail')->where($map)->sum('adds');
				unset($map['type']);
								$map['type']   = array("eq",5); 
				$list[$k]['j5'] =  M('jinbidetail')->where($map)->sum('adds');
				unset($map['type']);			
			}
            $this -> assign("page",$show);

			$this -> assign("list",$list);
			
			$this->display();
		}
		
		
		public function payList(){

			$Data = M('member_recharge'); // 实例化Data数据对象
	        import("@.ORG.Util.Page");// 导入分页类
	        $map = array();
	        if (isset($_POST['id']) && $_POST['id']!='') {
	        	$map['user_id'] = array("eq",$_POST['id']); 
	        }
	        if (isset($_POST['start_time']) && $_POST['start_time']!='') {
	        	$map['add_time'] = array("egt",strtotime($_POST['start_time'])); 
	        }
	        if (isset($_POST['end_time']) && $_POST['end_time']!='') {
	        	$map['add_time'] = array("elt",strtotime($_POST['end_time'])); 
	        }	

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,50);// 实例化分页类 传入总记录数
	        
	        
	        $list = $Data->where($map)->order('add_time desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
			foreach($list as $k=>$v){

				$list[$k]['username'] = M('member')->where("id ={$v['user_id']}")->getField('username');
				
			}
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}
		
		
		
		public function editPaypost(){
			
					$status=I('post.status',0,'intval');
					$r_id=I('post.r_id',0,'intval');
					if(empty($status) || empty($r_id)){
						
						$this->ajaxReturn(array('result'=>0,'info'=>'参数丢失'));	
						
					}
					$info=M('member_recharge')->where("r_id = {$r_id}")->find();
					
					if(empty($info)){
						$this->ajaxReturn(array('result'=>0,'info'=>'参数丢失#2'));		
						
					}
					$recharge_examine_type=C('recharge_examine_type'); // 审核类型 1 是充值到账户 2是 充值送矿机
					$kuangji_id=C('kuangji_id');//赠送矿机的ID
					$kuangji_num=C('kuangji_num');//赠送的数量
					if($status==1){
							if($recharge_examine_type == 1){
								
									M("member")->where("id = {$info['user_id']}")->setInc('jinbi',$info['gbc']);
									$username=M('member')->where("id = {$info['user_id']}")->getField('username');
									account_log($username,$info['gbc'],'充值',1,5);	
							
								
									
							}elseif($recharge_examine_type == 2){
								$userinfo=M("member")->where("id = {$info['user_id']}")->find();
								$product = M("product");
								$id =  $kuangji_id;
								//查询矿机信息
								$data = $product -> find($id);
								if(empty($data)){
									$this->ajaxReturn(array('result'=>0,'info'=>'矿机不存在'));	
									exit;
								}
								
								for($i=1;$i<=$kuangji_num;$i++){
										$map = array();
										$map['kjbh'] = 'S' . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
										$map['user'] = $userinfo['username'];
										$map['user_id'] = $userinfo['id'];
										$map['project']= $data['title'];
										$map['sid'] = $data['id'];
										$map['yxzq'] = $data['yszq'];		
										$map['sumprice'] = $data['price'];
										$map['addtime'] = date('Y-m-d H:i:s');	
										$map['imagepath'] = $data['thumb'];
										$map['lixi']	= $data['gonglv'];
										$map['kjsl'] =  $data['shouyi'];
										$map['zt'] =  1;	
										$map['UG_getTime'] =  time();		  
										M('order')->add($map);
										M("member")->where(array("id"=>$userinfo['id']))->setInc("mygonglv",$map['lixi']);		
										$product->where(array("id"=>$id))->setDec("stock");
										$parentpath = M("member")->where(array("username"=>$userinfo['username']))->getField("parentpath");
										$path2 = explode('|', $parentpath);
										array_pop($path2);
										$parentpath = array_reverse($path2);
										foreach($parentpath as $k=>$v){
											 M("member")->where(array('id'=>$v))->setInc("teamgonglv",$map['lixi']);
										}	
									
								}
								
							}
					
					
					}
					
					
					
					
					//修改状态
					M('member_recharge')->where("r_id = {$r_id}")->save(array('status'=>$status));
					$this->ajaxReturn(array('result'=>1,'info'=>'审核成功'));	
					
					
					
					
					
					
			
		}	
		
		
		
		
		
		
		
		
		/*public function payList(){

			$Data = M('paydetail'); // 实例化Data数据对象
	        import("@.ORG.Util.Page");// 导入分页类
	        $map = array();
	        if (isset($_POST['account']) && $_POST['account']!='') {
	        	$map['member'] = array("eq",$_POST['account']); 
	        }
	        if (isset($_POST['start_time']) && $_POST['start_time']!='') {
	        	$map['addtime'] = array("egt",strtotime($_POST['start_time'])); 
	        }
	        if (isset($_POST['end_time']) && $_POST['end_time']!='') {
	        	$map['addtime'] = array("elt",strtotime($_POST['end_time'])); 
	        }	

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,10);// 实例化分页类 传入总记录数
	        
	        
	        $list = $Data->where($map)->order('id desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
			foreach($list as $k=>$v){
				$list[$k]['zhe'] = $v['amount']/2;
				
			}
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}*/
        //提现信息查看页面
      	public function	editPay(){
			$emoneydetail = M('paydetail')->where(array('id'=>I('id')))->find();
			$emoneydetail['zhe'] = $emoneydetail['amount']/2;
			$this->assign('emoneydetail',$emoneydetail);			
			$this->display();
		}
		//提现信息处理
		public function editPayhandle(){
			$id = I('id',0,'intval');
			unset($_POST['id']);
            $emoneydetail = M('paydetail')->where(array('id'=>$id))->find();
			$data['status'] = $_POST['status'];
		
			$data['remark'] = $_POST['remark'];
			M('paydetail')->where(array('id'=>$id))->save($data);
			if($data['status'] == 2){
				$ling = $emoneydetail['amount'] * 0.01 * C("LINGSHOU");
				M("member")->where(array('username'=>$emoneydetail['member']))->setInc('jinbi',$ling);
				account_log($emoneydetail['member'],$ling,'零售奖',1,5);	
	   
		    }				
			//添加日志
			$desc = 'ID为'. $id .'的零售处理';
			write_log(session('username'),'admin',$desc);

			$this->success('处理完成!',U(GROUP_NAME.'/jinbidetail/payList'));

		}
		/**
		 * 重消明细
		 * @return [type] [description]
		 */
		public function jinzhongzi(){
			$Data = M('jinzhongzidetail'); // 实例化Data数据对象
	        import("@.ORG.Util.Page");// 导入分页类
	        $map = array();
	        if (isset($_POST['account']) && $_POST['account']!='') {
	        	$map['member'] = array("eq",$_POST['account']); 
	        }		

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
	        
	        
	        $list = $Data->where($map)->order('id desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}
		public function qjinbi(){
			$Data = M('qjinbidetail'); // 实例化Data数据对象
	        import("@.ORG.Util.Page");// 导入分页类
	        $map = array();
	        if (isset($_POST['account']) && $_POST['account']!='') {
	        	$map['member'] = array("eq",$_POST['account']); 
	        }		

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
	        
	        
	        $list = $Data->where($map)->order('id desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}		
		/**
		//交易中心
		public function jiaoyi(){
			$Data = M('jiaoyi'); // 实例化Data数据对象
	        import("@.ORG.Util.Page");// 导入分页类
	        $map = array();
	        if (isset($_POST['type']) && $_POST['type']!='') {
				if($_POST['type']==1){
					$map['selluser'] = array("eq",$_POST['account']); 
				}elseif($_POST['type']==2){
	        	    $map['buyuser'] = array("eq",$_POST['account']); 
				}
	        }		

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
	        
	        
	        $list = $Data->where($map)->order('id desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}
		**/
		//撤单
		public function cd(){
			$id = I('get.id',0,'intval');
            $info = M("jiaoyi")->where(array("id"=>$id))->find();
			if(!$info){
				echo '<script>alert("交易订单不存在！");window.history.back(-1);</script>';
				die;				
			}			
		    if($info['status']==1 || $info['status']==2){
				echo '<script>alert("此状态不可操作！");window.history.back(-1);</script>';
				die;				
			}			
			$data['status']  = 2;	
            M("jiaoyi")->where(array("id"=>$id))->save($data);	
			//返还金额
			M('member')->where(array('username'=>$info['selluser']))->setInc('jinzhongzi',$info['jinzhongzi']);
		    account_log2($info['selluser'],$info['jinzhongzi'],'交易中心撤单',1,6);				
			alert('撤单成功！',U(GROUP_NAME .'/jinbidetail/jiaoyi'));
		}	
		public function point(){
			$Data = M('pointdetail'); // 实例化Data数据对象
	        import("@.ORG.Util.Page");// 导入分页类
	        $map = array();
	        if (isset($_POST['account']) && $_POST['account']!='') {
	        	$map['member'] = array("eq",$_POST['account']); 
	        }		

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,15);// 实例化分页类 传入总记录数
	        
	        
	        $list = $Data->where($map)->order('id desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}
		public function payLists(){

			$Data = M('paydetails'); // 实例化Data数据对象
	        import("@.ORG.Util.Page");// 导入分页类
	        $map = array();
	        if (isset($_POST['account']) && $_POST['account']!='') {
	        	$map['member'] = array("eq",$_POST['account']); 
	        }
	        if (isset($_POST['start_time']) && $_POST['start_time']!='') {
	        	$map['addtime'] = array("egt",strtotime($_POST['start_time'])); 
	        }
	        if (isset($_POST['end_time']) && $_POST['end_time']!='') {
	        	$map['addtime'] = array("elt",strtotime($_POST['end_time'])); 
	        }	

	        $count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,10);// 实例化分页类 传入总记录数
	        
	        $list = $Data->where($map)->order('id desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
		}
        //提现信息查看页面
      	public function	editPays(){
			$emoneydetail = M('paydetails')->where(array('id'=>I('id')))->find();
			$this->assign('emoneydetail',$emoneydetail);			
			$this->display();
		}
		//提现信息处理
		public function editPayhandles(){
			$id = I('id',0,'intval');
			unset($_POST['id']);
            $emoneydetail = M('paydetails')->where(array('id'=>$id))->find();
			$data2['status'] = $_POST['status'];
		
			$data2['remark'] = $_POST['remark'];
			M('paydetails')->where(array('id'=>$id))->save($data2);
			if($data2['status'] == 2){
		       
				$member = M('member')->where(array('username'=>$emoneydetail['member']))->find();
				//写入充值记录
				$data            = array();
				$data['member']  = $member['username'];
				$data['adds']     = $emoneydetail['amount'];
				$data['balance'] = $member['jinbi'] + $emoneydetail['amount'];
				$data['addtime'] = time();
				$data['desc']    = '充值';
				M('jinbidetail')->add($data);
				 M('member')->where(array('username'=>$emoneydetail['member']))->setInc('jinbi',$emoneydetail['amount']);
			}				
			//添加日志
			$desc = 'ID为'. $id .'的充值处理';
			write_log(session('username'),'admin',$desc);

			$this->success('处理完成!',U(GROUP_NAME.'/jinbidetail/payLists'));

		}		
}
