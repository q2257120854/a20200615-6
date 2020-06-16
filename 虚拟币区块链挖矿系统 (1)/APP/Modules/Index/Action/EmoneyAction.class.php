<?php  
	
	/**
	 * 电子货币控制器
	 */
	Class EmoneyAction extends CommonAction{
		
	public function delqiugou(){

		$id= I("get.id",0,"intval");
		$result = M('ppdd')->where(array('id'=>$id,'p_user'=>$_SESSION['username']))->delete();
		if($result){
			     alert('取消成功！',U('Emoney/myjiaoyi'));		   
		}else{
				alert('取消失败！',U('Emoney/myjiaoyi'));		   
		}
	}		
		/**
		 * [会员奖金提现]
		 * @return [type] [description]
		 */
		public function tixian(){
			$user = M('member')->where(array('username'=>session('username')))->find();

			$sxf = C("WITHDRAW_TAX")/100;
			$sxfl = C("WITHDRAW_TAX");
			$this->assign('user',$user);
			$this->assign('balance',$balance);

			$this->assign('sxf',$sxf);
			$this->assign('sxfl',$sxfl);
			$this->display();
		}

		public function tixianshenqing(){
			$user = M('member')->field("jinbi,point,truename,alipay_voucher,yj")->where(array('id'=>session('mid')))->find();
			if (IS_POST) {
				$db = M('emoneydetail');
				$member = M('member');
				$money = I('post.money',0,'intval');
				$password2   = I('post.safe','','md5');
				
				//当前会员余额
				$balance = $member->where(array('id'=>session('mid')))->getField('yj');
				
				$money == 0 and  $this->ajaxReturn(array('info'=>'提现金额不能为0！','url'=>''));
				//验证二级密码是否正确
				if (!$member->where(array('username'=>session('username'),'password2'=>$password2))->getField('id')) {
					$this->ajaxReturn(array('info'=>'对不起!二级密码不正确!'));					
				}		
			
				if (empty($user['alipay_voucher']) || empty($user['truename'])) {
					$this->ajaxReturn(array('info'=>'请先添加收款信息!','url'=>U('personal_set/myInfo')));
				}
				//是否开启提现功能
				if ($type==2 && C('WITHDRAW_STATUS') == 'off') {
					$this->ajaxReturn(array('info'=>'对不起!现金提现功能暂未开放!'));								
				}

				//一次性提现最少额度
				if($money < C('WITHDRAW_MIN')){
					$this->ajaxReturn(array('info'=>"您输入的提现金额小于最少提现金额，请输入至少" . C('WITHDRAW_MIN') . ""));
					
				}
				//设置提现整数倍
				if (C('WITHDRAW_INT') > 0) {
					if ($money % C('WITHDRAW_INT') != 0) {
						$this->ajaxReturn(array('info'=>"您输入的提现金额必须为". C('WITHDRAW_INT') ."的整数倍"));					
					}
				}
/* 				//每天最多提现的次数	待测试
 				if (C('WITHDRAW_IN_DAY_NUM') > 0) {

					$where = array('account'=>session('account'),'mode'=>'applywd');
					$where['_string'] = 'addtime >= '. todaytime('start') .' AND addtime <= '. todaytime('end') .'';

					$thisdayget = $db->where($where)->count();
					if ($thisdayget >= C('WITHDRAW_IN_DAY_NUM')) {
						$this->ajaxReturn(array('info'=>"每日最多只能提现" . C('WITHDRAW_IN_DAY_NUM') . "次"));					
					}
				}  */

				//提现手续费点位、手续费上限、手续费下限	设置提现的时候要扣除的手续费即x%
				if (C('WITHDRAW_TAX')>0) {
					$withdrawtaxnum = $money * (C('WITHDRAW_TAX') / 100);
				}
				$withdrawtaxnum = intval($withdrawtaxnum);
				$money = intval($money);
				//正式处理
				$balance = $balance - ($money + $withdrawtaxnum);

				$tixianedu = $money + $withdrawtaxnum;
				if ($tixianedu > $balance) {
					$this->ajaxReturn(array('info'=>"已超过您的当前额度"));					
				}
					
				$data['member'] = session('username');
				$data['mode'] = '电子币提现';
				$data['name'] = $user['truename'];
				$data['addtime'] = time();


						$data['amount'] =  -($money + $withdrawtaxnum);
						$data['shouxufei'] =  $withdrawtaxnum;
						$data['koujinbi'] =  $money + $withdrawtaxnum;
						$data['balance'] = $balance;
						$data['images'] = $user['alipay_voucher'];
						$data['charge'] = $withdrawtaxnum;
						$data['remark'] = '申请提现'.$money.'元,扣除'. $withdrawtaxnum .'作为手续费扣除';
						if ($db->data($data)->add()) {
							$member->where(array('username'=>session('username')))->setField('yj',$balance);
							$this->ajaxReturn(array('info'=>'提现成功！',url=>U('Index/Emoney/withdrawList')));	
						}else{
							$this->ajaxReturn(array('info'=>'提现失败！','url'=>U('Index/Emoney/withdrawList')));	
						}			
				 
            }      

			$status = C("WITHDRAW_STATUS");
			$this->assign('status',$status);
			$this->assign('v',$user);
			$this->display();
		}
		
	public function yjlist(){
		
		$member = M('yongjindetail')->where(array('username'=>$_SESSION['username']))->order('addtime desc')->select();
		$this ->assign('member',$member);
		$this->display();
	}
	//买入取消 退钱给g_id
	
	public function qxdd(){
		
		
		
		$id= I("post.id",0,"intval");
		$ppddinfo = M('ppdd')->where(array('id'=>$id,'zt'=>'1','p_user'=>$_SESSION['username']))->find();
		if(empty($ppddinfo)){
			echo json_encode(array('result'=>0,'msg'=>'订单不存在'));	
			exit;
		}
		
		$g_info=M("member")->where(array('id'=>$ppddinfo['g_id']))->find();
		$sxf = M("member_group")->where(array("level"=>$g_info['level']))->getField("shouxu");
		$fan_money=$ppddinfo['lkb']+$sxf*$ppddinfo['lkb'];
		
		
		$inc = M('member') -> where(array('id'=>$ppddinfo['g_id']))->setInc('jinbi',$fan_money);
	    account_log($ppddinfo['g_user'],$fan_money,'买家取消订单返回',1);	
		
		$dec = M('member') -> where(array('id'=>$ppddinfo['g_id']))->setDec('qjinbi',$fan_money);
	    account_log4($ppddinfo['g_user'],$fan_money,'买家取消订单扣除',0);	
		$result=M('ppdd')->where(array('id'=>$id))->delete();
		
		echo json_encode(array('result'=>1,'msg'=>'取消成功'));	
		exit;
			
			
		
	}
	
	
	
	//卖出取消 退钱给p_id
	
	public function csqx(){
		
			$id= I("post.id",0,"intval");
			$ppddinfo = M('ppdd')->where(array('id'=>$id,'zt'=>'1','g_user'=>$_SESSION['username']))->find();
			if(empty($ppddinfo)){
				echo json_encode(array('result'=>0,'msg'=>'订单不存在'));	
				exit;
			}
			
			
			
			$p_info=M("member")->where(array('id'=>$ppddinfo['p_id']))->find();
			$sxf = M("member_group")->where(array("level"=>$p_info['level']))->getField("shouxu");
			$fan_money=$ppddinfo['lkb']+$sxf*$ppddinfo['lkb'];
			
			
			$inc = M('member') -> where(array('id'=>$ppddinfo['p_id']))->setInc('jinbi',$fan_money);
			account_log($ppddinfo['p_user'],$fan_money,'买家取消订单返回',1);	
			
			$dec = M('member') -> where(array('id'=>$ppddinfo['p_id']))->setDec('qjinbi',$fan_money);
			account_log4($ppddinfo['p_user'],$fan_money,'买家取消订单扣除',0);	
			$result=M('ppdd')->where(array('id'=>$id))->delete();
			
			echo json_encode(array('result'=>1,'msg'=>'取消成功'));	
			exit;
			
			
			
				
	
	}
	
	
	
	
	
	public function del(){
		$id= I("get.id",0,"intval");
		
		$oob = M('ppdd')->where(array('id'=>$id))->find();
		if($oob['p_user']!=$_SESSION['username']){
			die("<script>alert('操作失败！');history.back(-1);</script>");
		}			
		$oobs = M('member')->where(array('username'=>$oob['p_user']))->find();
	
		$inc = M('member') -> where(array('username'=>$oob['p_user']))->setInc('jinbi',$oobs['qjinbi']);
	    account_log($_SESSION['username'],$oobs['qjinbi'],'订单撤销返还',1);	
		
		$dec = M('member') -> where(array('username'=>$oob['p_user']))->setDec('qjinbi',$oobs['qjinbi']);
	    account_log4($_SESSION['username'],$oobs['qjinbi'],'订单撤销扣除',0);	
		
		$result=M('ppdd')->where(array('id'=>$id))->delete();
		if($result && $inc && $dec){
			 alert('取消成功！',U('Emoney/myjiaoyi'));		   
		}else{
			alert('取消失败！',U('Emoney/myjiaoyi'));		   
		}
	}
	public function wancheng(){
		$data_P = I("get.id",0,"intval");
		$result = M('ppdd')->where(array('id'=>$data_P))->find();
	    if($result['p_user']==$_SESSION['username']){
			$this->ajaxReturn('请等待卖家确定交易。');
		}
		if($result['g_user']==$_SESSION['username']){
			$djmoney = M('member')->where(array('username'=>$result['g_user']))->find();
			$djmoney2=M('member')->where(array('username'=>$result['p_user']))->find();			
			$zz = M('ppdd')->where(array('id'=>$data_P,'g_user'=>$result['g_user'],'zt'=>1))->find();
			if($zz){
				
				$sxf = M("member_group")->where(array("level"=>$djmoney['level']))->getField("shouxu");
				$lkb1 = $result['lkb'] + $result['lkb'] * $sxf;
				
				$obs = M('member')->where(array('username'=>$result['g_user']))->setDec('qjinbi',$lkb1);
				account_log4($result['g_user'],$lkb1,'交易订单完成扣除',0);
				
				//$sxf = M("member_group")->where(array("level"=>$djmoney2['level']))->getField("shouxu");
				//$lkb = $result['lkb'] - $result['lkb'] *$sxf;
				$lkb = $result['lkb']; 
				$oob = M('member')->where(array('username'=>$result['p_user']))->setInc('jinbi',$lkb);
				
				account_log($result['p_user'],$lkb,'交易订单完成获得',1);		
				
			}
			$re = M('ppdd')->where(array('id'=>$data_P,'g_user'=>$result['g_user'],'zt'=>1))->data(array('zt'=>2))->save();
			if($oob && $obs && $re){
				
				$respond['status']=1;
				$respond['msg']='订单已完成。';

				$jydate=M('ppdd')->order('jydate desc')->find();
					
				$maps['date'] = time();
				$maps['price'] = $jydate['danjia'];
				M('date')->add($maps);
				$this->ajaxReturn($respond);
			}	
				
		}
	}		
	public function cswancheng(){

		$data_P = I("get.id",0,"intval");
		$result=M('ppdd')->where(array('id'=>$data_P))->find();
		if($result['p_user']==$_SESSION['username']){
			$djmoney=M('member')->where(array('username'=>$result['p_user']))->find();
			$djmoney2=M('member')->where(array('username'=>$result['g_user']))->find();
			$zz = M('ppdd')->where(array('id'=>$data_P,'g_user'=>$result['g_user'],'zt'=>1))->find();
			if($zz){
				
				$sxf = M("member_group")->where(array("level"=>$djmoney['level']))->getField("shouxu");
				$lkb1 = $result['lkb'] + $result['lkb'] * $sxf;
				
				$obs = M('member')->where(array('username'=>$result['p_user']))->setDec('qjinbi',$lkb1);
				account_log4($result['p_user'],$lkb1,'交易订单完成扣除',0);		
				
				$lkb = $result['lkb'];
				$oob = M('member')->where(array('username'=>$result['g_user']))->setInc('jinbi',$lkb);
				account_log($result['g_user'],$lkb,'交易订单完成获得',1);		
			}
			
			$re = M('ppdd')->where(array('id'=>$data_P,'g_user'=>$result['g_user'],'zt'=>1))->data(array('zt'=>2))->save();
			if($oob && $obs && $re){				
				$respond['status']=1;
				$respond['msg']='订单已完成。';
				$jydate=M('ppdd')->order('jydate desc')->find();
					
				$maps['date']=time();
				$maps['price']=$jydate['danjia'];
				M('date')->add($maps);
				$this->ajaxReturn($respond);
			}	
				
		}
		
	}	
	public function myjiaoyi(){
		
		$gname = session("username");
		
		$result = M('ppdd')->where(array('p_user'=>$gname,'zt'=>0,'datatype'=>'qglkb'))->select();
		$cslb = M('ppdd')->where(array('p_user'=>$gname,'zt'=>0,'datatype'=>'cslkb'))->select();
		$map1['zt']=1;
		$map1['_string']="(p_user = '$gname' or g_user = '$gname')";
		$results = M('ppdd')->where($map1)->select();
		//查看个人交易信息
		$grxx=M('ppdd')->where($map1)->find();
		$datatype=$grxx['datatype'];		
		//$imagpath=M('ppdd')->where(array('p_user'=>'$gname'))->order('id desc')->find();
		//dump($imagpath);die();
		if($grxx['imagepath']){
			$tp=1;
		}else{
			$tp=2;
		}
		if(empty($results)){
			$ts=1;
		}
		import('ORG.Util.Page');
		$map['zt']=2;
		$map['_string']="(p_user = '$gname' or g_user = '$gname')";
		
		$count = M('ppdd')->where($map)->count();
		$page = new Page($count,30);
		$page->setConfig('theme', '%first% %upPage% %linkPage% %downPage% %end%');
		$show = $page->show();// 分页显示输出
		$obs = M('ppdd')->where($map)->order('jydate desc')->limit($page->firstRow.','.$page->listRows)->select();

		$time=strtotime('+1days');
		$this->assign('time',$time);
		$this->assign('datatype',$datatype);
		$this->assign('page',$show);
		$this->assign('cslkb',$cslb);
		$this->assign('tp',$tp);
		$this->assign('ts',$ts);
		$this->assign('oob',$obs);
		$this->assign('lists',$results);
		$this->assign('list',$result);
		$this->display();
	}	
	public function gettime(){
		
		$gname=$_SESSION['username'];
		$map1['_string']="(p_user = '$gname' or g_user = '$gname')";
		$map1['zt']=1;
		$grxx=M('ppdd')->where($map1)->find();
		$time=strtotime($grxx['jydate']);
		$time=C('tousu_time')*60*60+$time;
		$this->ajaxReturn($time);
	}	
	public function tousu(){
		$data_P = 	I("get.id",0,"intval");
		$text = 	I("get.txt",'',"htmlspecialchars");
		
		$result=M('ppdd')->where(array('id'=>$data_P))->find();
		
		$tousu=M('tousu')->where(array('pid'=>$data_P))->find();//说明已经有一方投诉过了
		if($tousu){
			if($tousu['user']=$_SESSION['username']){
				$this->ajaxReturn('请勿重复投诉');
			}
		}
	
		if($text==""){
			$this->ajaxReturn('投诉内容不能为空');
		}
		if($result['p_user']==$_SESSION['username']){
				
			$map['text']=$text;//投诉内容
			$map['user']=$_SESSION['username'];//投诉人；
			$map['buser'] =$result['g_user']; //被投诉人
			$map['date'] = date('Y-m-d H:i:s');
			$map['pid'] = $data_P;
			$oob=M('tousu')->add($map);
			if($oob){
				$this->ajaxReturn('投诉成功，等待管理员处理。。。');
			}
		}
		
		if($result['g_user']==$_SESSION['username']){
			
			$map1['text']=$text;//投诉内容
			$map1['user']=$_SESSION['username'];//投诉人；
			$map1['buser'] =$result['p_user']; //被投诉人
			$map1['date'] = date('Y-m-d H:i:s');
			$map1['pid'] = $data_P;
			$oobs=M('tousu')->add($map1);
			if($oobs){
				$this->ajaxReturn('投诉成功，等待管理员处理。。。');
			}
			
		}
	}
	public function mjxx(){
		$data_P = 	I("get.id",0,"intval");
		
		$map['id']=$data_P;
		$map['zt']=1;
		$gname=$_SESSION['username'];
		
		$map['_string']="(p_user = '$gname' or g_user = '$gname')";
		$result=M('ppdd')->where($map)->find();
		
		if(!$result){
			
			$this->ajaxReturn('非法操作');
		}else{

		$rmb = $result['jb'] * C('rmb_hl');
		$btc= $result['jb'] * C('btc_hl');
		$meiyuan=$result['jb'];
		
		$user=M('member')->where(array('username'=>$result['g_user']))->field('username,truename,alipay_voucher')->find();
		$user['rmb']=$rmb;
		$user['btc']=$btc;
		$user['meiyuan'] = $meiyuan;
		$this->ajaxReturn($user);
		}
	}	
	public function maijia(){

		$data_P = 	I("get.id",0,"intval");
			
		$map['id']=$data_P;
		$map['zt']=1;
		$gname=$_SESSION['username'];
		
		$map['_string']="(p_user = '$gname' or g_user = '$gname')";
		$result=M('ppdd')->where($map)->find();
		if(!$result){
			
			$this->ajaxReturn('非法操作');
		}else{

		$rmb = $result['jb']*C("rmb_hl");
		$btc= $result['jb']*C("btc_hl");
		$meiyuan=$result['jb'];
		
		
		$user = M('member')->where(array('username'=>$result['p_user']))->field('username,truename,alipay_voucher')->find();
		$user['rmb']=$rmb;
		$user['btc']=$btc;
		$user['meiyuan'] = $meiyuan;
		
		$this->ajaxReturn($user);
		}
	}	
	public function cktp(){
		$id=$_GET['id'];
		$result=M('ppdd')->where(array('id'=>$id))->find();
		$photo=$result['imagepath'];
		$this->ajaxReturn($photo);
	}
	
	
	public function uploadsmax(){
	 	
			
			
			$order_id=I('get.id',0,'intval');
			$jtype=I('get.jtype');
			
			
			if(empty($order_id)){
				$this->ajaxReturn(array('result'=>'0','msg'=>"参数丢失"));
			}
			
			if($jtype=='qglkb'){
				$order_info=M('ppdd')->where(array('id'=>$order_id,'p_user'=>$_SESSION['username'],'zt'=>1,'datatype'=>'qglkb'))->find();
			
			}else{
				
				$order_info=M('ppdd')->where(array('id'=>$order_id,'g_user'=>$_SESSION['username'],'zt'=>1,'datatype'=>'cslkb'))->find();
				
			}
			if(empty($order_info)){
				$this->ajaxReturn(array('result'=>'0','msg'=>"订单不存在"));
			}
			
			
			
			import('ORG.Net.UploadFile');
		    $upload = new UploadFile();// 实例化上传类
			$upload->maxSize   =  3145728 ;// 设置附件上传大小
		    $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->allowTypes =array('image/png','image/jpg','image/jpeg','image/gif');
			$upload->savePath =  './Public/Uploads/pingzheng/'; // 设置附件上传目录
			
			 if(!$upload->upload()) {// 上传错误提示错误信息
				 $error = $upload->getErrorMsg();
				 $this->ajaxReturn(array('status'=>'failed','reason'=>$error));
			 }else{// 上传成功 获取上传文件信息
				  $info =  $upload->getUploadFileInfo();
			 }
			
			
			
			 if(!empty($info)){
					$savepath = str_replace(".","",$info[0]['savepath']);
					$filePath = $savepath.$info[0]['savename'];
				    //$pdtj=M('ppdd')->where(array('p_user'=>$_SESSION['username'],'zt'=>1,'datatype'=>'qglkb'))->find();
				    //$pdtj1=M('ppdd')->where(array('g_user'=>$_SESSION['username'],'zt'=>1,'datatype'=>'cslkb'))->find();
					
					
					if($jtype=='qglkb'){
						$result=M('ppdd')->where(array('id'=>$order_id,'p_user'=>$_SESSION['username'],'zt'=>1))->data(array('imagepath'=>$filePath))->save();
					}else{
						$result=M('ppdd')->where(array('id'=>$order_id,'g_user'=>$_SESSION['username'],'zt'=>1))->data(array('imagepath'=>$filePath))->save();
					}
					
					$returnData['result'] = 1;
					$returnData['msg'] = "上传成功";					
					$this->ajaxReturn($returnData);
			 }else{
					$error = $upload->getErrorMsg();
					$this->ajaxReturn(array('result'=>'0','msg'=>$error));
			 }	
		

   }

	public function extend($file_name){
		$extend = pathinfo($file_name);
		$extend = strtolower($extend["extension"]);
		return $extend;
	}


	
	
	
	
	
	
	
	
	
	public function sctp(){
		
		    import('ORG.Net.UploadFile');
		    $upload = new UploadFile();// 实例化上传类
			$upload->maxSize   =  3145728 ;// 设置附件上传大小
		    $upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		    $upload->allowTypes =array('image/png','image/jpg','image/jpeg','image/gif');
			$upload->savePath =  './Public/Uploads/pingzheng/'; // 设置附件上传目录
			exit("###");
			 if(!$upload->upload()) {// 上传错误提示错误信息
				 $error = $upload->getErrorMsg();
				 $this->ajaxReturn(array('status'=>'failed','reason'=>$error));
			 }else{// 上传成功 获取上传文件信息
				  $info =  $upload->getUploadFileInfo();
			 }
			 if($info){
					$savepath = str_replace(".","",$info[0]['savepath']);
					$filePath = $savepath.$info[0]['savename'];
				    $pdtj=M('ppdd')->where(array('p_user'=>$_SESSION['username'],'zt'=>1,'datatype'=>'qglkb'))->find();
				    $pdtj1=M('ppdd')->where(array('g_user'=>$_SESSION['username'],'zt'=>1,'datatype'=>'cslkb'))->find();
					if($pdtj){
						$result=M('ppdd')->where(array('p_user'=>$_SESSION['username'],'zt'=>1))->data(array('imagepath'=>$filePath))->save();
					}
					if($pdtj1){
						$result=M('ppdd')->where(array('g_user'=>$_SESSION['username'],'zt'=>1))->data(array('imagepath'=>$filePath))->save();
					}
					$returnData['status'] = 'success';
					$returnData['data']['path'] = $filePath;					
					$this->ajaxReturn($returnData);
			 }else{
					$error = $upload->getErrorMsg();
					$this->ajaxReturn(array('status'=>'failed','reason'=>$error));
			 }			
	}
	
	public function index(){
				//判断师傅开启
				$jy_open=C('jy_open');
				$jy_time=C('jy_time');
				if(empty($jy_open)){
					alert('交易中心未开放！',U('Index/index/index'));
					exit;		
					
				}
				if(!empty($jy_time)){
					$jy_time_arr=explode('-',$jy_time);
					$s_time=strtotime(date("Y-m-d ".$jy_time_arr[0]));
					$o_time=strtotime(date("Y-m-d ".$jy_time_arr[1]));
					if(time() < $s_time || time() > $o_time){
						alert('交易中心开放时间为'.$jy_time,U('Index/index/index'));
						exit;		
					}
				}
				
				
		        
				
				
				
				
				
				$p_mobile=I('get.p_id');
				
				$p_id=M('member')->where("mobile = {$p_mobile}")->getField('id');
				
				$xgcs = M('member')->where(array('username'=>session("username")))->find();
			    if($xgcs['level']==0){
					  alert('请先完善个人资料提交系统审核！',U('personal_set/myInfo'));	
				} 
				
				if($xgcs['checkstatus']==2){
					  alert('账户信息审核失败，请先完善个人资料提交系统审核！',U('personal_set/myInfo'));
				} 
				
				
				$a='0';
				$b='1';
				$map['zt'] = array(array('eq',$a),array('eq',$b),'or');
				$map['datatype'] = 'qglkb';
				
				if(!empty($p_id)){
					$map['p_id'] = $p_id;	
				}
				
		
		
				$list=	M('ppdd')->where($map)->order('zt asc, danjia desc')->select();
			
				$c='0';
				$d= '1';
				$map1['datatype']='cslkb';
				$map1['zt']=array(array('eq',$c),array('eq',$d),'or');
				
				if(!empty($p_id)){
					$map1['p_id'] = $p_id;	
				}
				
				
				
			$lists=	M('ppdd')->where($map1)->order('zt asc, danjia desc')->select();
			
			$gao = C('max_danjia');
			$di  = C('min_danjia');
			$zuihou = M('date')->order('id desc')->find();
			$zuihou = $zuihou['price'];
			
			$fu=($gao/$di)-1;
			$fu=$fu*100;
			$fu=number_format($fu,2);
			
			$time = date('Y-m-d 00:00:00',time());
			$time1 = date('Y-m-d 23:59:59',time());
			
			$maps['jydate']=array(array('gt',$time),array('lt',$time1));

			$liang=M('ppdd')->where($maps)->sum('lkb');
			$zjjy=M('jyl')->order('id desc')->find();
			$liang=$liang+$zjjy['num'];

			//今开
			$yestoday=strtotime("-1days");
			$yest=date('Y-m-d 00:00:00',$yestoday);
			$yests=date('Y-m-d 23:59:59',$yestoday);
			$ztime=strtotime($yest);
			$ztimes=strtotime($yests);
			/* echo $ztime; echo "<br />";
			echo $ztimes; */
			
			$maap['date']=array(array('gt',$ztime),array('lt',$ztimes));
			$zuoshou=M('date')->where($maap)->order('id desc')->find();
			$zuoshou=$zuoshou['price'];
			//echo $zuoshou;
			
			//作收
			//今开
			$jtime=strtotime($time);
			$jtime1=strtotime($time1);
			$maaps['date']=array(array('egt',$jtime),array('lt',$jtime1));
			$jinkai=M('date')->where($maaps)->order('id asc')->find();
			//dump($jinkai);
			$jinkai=$jinkai['price'];
			//今天最高
			$jrsj=strtotime(date('Y-m-d',TIME()));
			//ECHO $jrsj;
			$jrzg=M('date')->where($maaps)->max('price');
			$jrzd=M('date')->where($maaps)->min('price');
			$rxpan=M('ridate')->where(array('date'=>$jrsj))->find();
			if(!$rxpan){
				$data['jinkai']=$jinkai;
				$data['zuoshou']=$zuoshou;
				$data['jrzg']=$jrzg;
				$data['jrzd']=$jrzd;
				$data['date']=$jrsj;
				M('ridate')->add($data);
			}
			if($rxpan['jrzg']<$jrzg){
				M('ridate')->where(array('date'=>$jrsj))->save(array('jrzg'=>"$jrzg"));
			}
			if($rxpan['jrzd']>$jrzd){
				M('ridate')->where(array('date'=>$jrsj))->save(array('jrzd'=>"$jrzd"));
			}
			
			$level = M('member')->where(array('username'=>session("username")))->find();
			$levels = $level['level'];
			$this->assign('level',$levels);
			$this->assign('gao',$gao);
			$this->assign('di',$di);
			$this->assign('zuihou',$zuihou);
			$this->assign('liang',$liang);
			$this->assign('fu',$fu);
			$this->assign('lists',$lists);
			$this->assign('list',$list);
			$this->assign('zuoshou',$zuoshou);
			$this->assign('jinkai',$jinkai);
			$this->assign('jrzg',$jrzg);
			$this->assign('jrzd',$jrzd);
			$this->assign('mymobile',$level['mobile']);			
			$this->display();
		}
//买入		
public function myjiaoyis(){
	
		$price= I("post.price",0,"floatval");
		$lkb = I("post.lkb",0,"floatval");
		$zdjy = I("post.zdjy",0,"floatval");
		/*//交易密码
		$password_m = I("post.password_m",'',"trim");
		if(empty($password_m)){
			$this->ajaxReturn(array("status"=>2,"info"=>'请输入交易密码！'));	
		}*/
		
		//交易密码
	/*	$password_m = I("post.password_m",'',"trim");
		if(empty($password_m)){
			$this->ajaxReturn(array("status"=>2,"info"=>'请输入短信验证码！'));	
		}
		$user_id = session('mid');
		$check_mobile=M('member')->where("id = {$user_id}")->getField('mobile');
		
		$check_code = sms_code_verify($check_mobile,$password_m,session_id());				
		if($check_code['status'] != 1){
				$this->ajaxReturn(array('status'=>2,'info'=>$check_code['msg']));					
		}*/
		
		
		
		
		
		
		
		
			

		if($lkb < C("bsbei") || $lkb%C("bsbei")!=0){
			$this->ajaxReturn(array("status"=>2,"info"=>'交易数量必须为'.C("bsbei").'的倍数'));
		}
		
		if($lkb > C("max_qglkb")){
			$this->ajaxReturn(array("status"=>2,"info"=>'最大交易数量为'.C("max_qglkb")));
		}
		
		
		if($price < C("min_danjia") || $price > C("max_danjia")){
			$this->ajaxReturn(array("status"=>2,"info"=>'交易单价最低：'.C("min_danjia").'美元，最高：'.C("max_danjia").'美元'));
			
		}
		$gname = session("username");
		$user = M('member')->where(array('username'=>session("username")))->find();
		if($user['level']==0){
			$this->ajaxReturn(array("status"=>2,"info"=>'交易前请先到个人资料完善个人信息'));
		}
		//判断交易密码是否正确
		
		/*if(md5($password_m)!=$user['password2']){
			$this->ajaxReturn(array("status"=>2,"info"=>'交易密码错误！'));
		}
		*/
		
		
				
		$a=1;
		$b=0;
		$maps['zt']=array(array('eq',$a),array('eq',$b),'or');
		$maps['_string']="(p_user = '$gname' or g_user = '$gname')";
		$pd = M('ppdd')->where($maps)->find();
		if($pd){
			$this->ajaxReturn(array("status"=>2,"info"=>'您还有未完成交易的订单'));
		}

		$danjia = $price;
		$map['p_id'] = $user['id'];
		$map['p_user'] = $user['username'];
		$map['jb'] = $price*$lkb;
		$map['lkb'] = $lkb;
		$map['date']= date('Y-m-d H:i:s');
		$map['p_name'] = $user['nickname'];
		$map['p_level'] = $user['level'];
		$map['danjia']  = $danjia;
		$map['datatype'] = 'qglkb';
		$map['zdjyr'] = $zdjy;
		$sail= M('ppdd')->where(array('p_user'=>$gname))->data(array('p_level'=>$user['level']))->save();
		$result=M('ppdd');
		$oob=$result->add($map);
		if($oob){
			$this->ajaxReturn(array("status"=>1,"info"=>'订单已成功发送至交易大厅。'));
		}
	}		
	//卖出
	public function cslkb(){
		
		$price= I("post.price",0,"floatval");
		$lkb = I("post.lkb",0,"floatval");
		$zdjy = I("post.zdjy",'',"htmlspecialchars");
		
			//交易密码
		$mobile_code_n = I("get.mobile_code_n",'',"trim");
		
		if(empty($mobile_code_n)){
			$this->ajaxReturn(array("status"=>2,"info"=>'请输入交易密码！'));	
		}
		/*
		$user_id = session('mid');
		$check_mobile=M('member')->where("id = {$user_id}")->getField('mobile');
		
		$check_code = sms_code_verify($check_mobile,$mobile_code_n,session_id());				
		if($check_code['status'] != 1){
				$this->ajaxReturn(array('status'=>2,'info'=>$check_code['msg']));					
		}		*/
		
		
	
        $gname = session("username");
		$zd = M("member")->where("username = '{$zdjy}' or id = '{$zdjy}'")->find();
		
		$zdname=$zdjy;
		$c=1;
		$d=0;
		$map1s['zt']=array(array('eq',$c),array('eq',$d),'or');
		$map1s['_string']="(p_user = '$zdname' or g_user = '$zdname' or p_id = '$zdname' or g_id = '$zdname')";
		//$zdzt = M('ppdd')->where("p_user = '{$zdname}' or g_user = '{$zdname}' or p_id = '{$zdname}' or g_id = '{$zdname}' ")->where("zt < 2")->find();
		$zdzt = M('ppdd')->where($map1s)->find();
		
		$zdtj = M("member")->where(array('username'=>$gname))->find();
		if($zdtj['level']>0){
			if($zdjy!=""){
					if(!$zd){
						 $this->ajaxReturn(array("status"=>2,"info"=>'指定交易人不存在'));
					}
					if($zdzt){
						 $this->ajaxReturn(array("status"=>2,"info"=>'指定交易人有尚未完成的订单'));
					}
			}
		}
		
		//----------------
		if(empty($zdjy)){
			if($lkb < C("bsbei") || $lkb%C("bsbei")!=0){
				$this->ajaxReturn(array("status"=>2,"info"=>'交易数量必须为'.C("bsbei").'的倍数'));
				}

 			if($lkb > C("max_cslkb")){
				$this->ajaxReturn(array("status"=>2,"info"=>'最大交易数量为'.C("max_cslkb")));
			}
			
			if($lkb < C("min_cslkb")){
				$this->ajaxReturn(array("status"=>2,"info"=>'最小交易数量为'.C("min_cslkb")));
			} 
			
			
		}
		//查询矿机限购数量
 		$zskj=M('product')->where(array('id'=>1))->getField('xianshou');
		$xxkj=M('product')->where(array('id'=>2))->getField('xianshou');
		$zxkj=M('product')->where(array('id'=>4))->getField('xianshou');
		$dxkj=M('product')->where(array('id'=>5))->getField('xianshou');
		$cjkj=M('product')->where(array('id'=>6))->getField('xianshou');
		$wxkj=M('product')->where(array('id'=>9))->getField('xianshou');
	
		
		//背包里面在运营的矿机数量
		$zskjs=M("order")->where(array('user'=>session('username'),'sid'=>1,'zt'=>1))->count();
		$xxkjs=M("order")->where(array('user'=>session('username'),'sid'=>2,'zt'=>1))->count();
		$zxkjs=M("order")->where(array('user'=>session('username'),'sid'=>4,'zt'=>1))->count();
		$dxkjs=M("order")->where(array('user'=>session('username'),'sid'=>5,'zt'=>1))->count();
		$cjkjs=M("order")->where(array('user'=>session('username'),'sid'=>6,'zt'=>1))->count();
		$wxkjs=M("order")->where(array('user'=>session('username'),'sid'=>9,'zt'=>1))->count();
		
		//用户当前级别
		$info=M("member")->where(array('username'=>$gname))->find();
		$dqyhjb=M('member_group')->where(array('level'=>$info['level']))->getField('csbl');
		
		//现有矿机的销售数量
		$kmai=$zskjs * $zskj;
		$kmai1=$xxkjs * $xxkj;
		$kmai2=$zxkjs * $zxkj;
		$kmai3=$dxkjs * $dxkj;
		$kmai4=$cjkjs * $cjkj;
		$kmai5=$wxkjs * $wxkj;
		$kmze=($kmai + $kmai1 + $kmai2 + $kmai3 + $kmai4 + $kmai5) * $dqyhjb; //可卖总数

		
		$time=date('Y-m-d 00:00:00',time());
		$time1=date('Y-m-d 23:59:59',time());


		$mapa1['p_user']=session("username");
		$mapa1['datatype']=array('eq', 'cslkb');
		$mapa1['date']=array(array('gt',$time),array('lt',$time1));
				
		$cslkbsl = M('ppdd')->where($mapa1)->sum('lkb');

		$mapaa1['g_user']=session("username");
		$mapaa1['datatype']=array('eq', 'qglkb');
		$mapaa1['date']=array(array('gt',$time),array('lt',$time1));
		
		$qglkbsl = M('ppdd')->where($mapaa1)->sum('lkb');
				
		$ymkbsl = $cslkbsl + $qglkbsl;
		
		$kmkbsl = $kmze - $ymkbsl;
		
		
		$sxf = M("member_group")->where(array("level"=>$info['level']))->getField("shouxu");
		$totalprice = $lkb + $lkb * $sxf;	
 		if($totalprice > $kmkbsl ){
			$this->ajaxReturn(array("status"=>2,"info"=>'您当前所持有的矿机每天最多可出售'. $kmze .'个币,今天已经出售'. $ymkbsl .'个币!'));
		} 
		if($totalprice > $info['jinbi']){
			$this->ajaxReturn(array("status"=>2,"info"=>'您的余额不足'));
		}

		if(empty($zdjy)){
			if($price < C("min_danjia") || $price > C("max_danjia")){
				$this->ajaxReturn(array("status"=>2,"info"=>'交易单价最低：'.C("min_danjia").'美元，最高：'.C("max_danjia").'美元'));
			}
		}

		
		//判断交易密码是否正确
		$user=M("member")->where(array('username'=>$gname))->find();
		if(md5($mobile_code_n)!=$user['password2']){
			$this->ajaxReturn(array("status"=>2,"info"=>'交易密码错误！'));
		}
		
		$a=1;
		$b=0;
		$maps['zt']=array(array('eq',$a),array('eq',$b),'or');
		$maps['_string']="(p_user = '$gname' or g_user = '$gname')";
		$pd=M('ppdd')->where($maps)->find();
		if($pd){
			$this->ajaxReturn(array("status"=>2,"info"=>'您还有未完成交易的订单'));
		}
		
		if($user['level']==0){
			$this->ajaxReturn(array("status"=>2,"info"=>'未审核会员不能操作！'));
		}	
		
		$yqztrs = C('min_zhitui');//要求的直推人数
		$yqddsl = C('min_buy');//要求的订单数量

		$yqddje = C('min_buyje');//要求的订单金额
				$max_sell = C('max_sell');//每天允许卖出笔数
				
				$ztrs = M('member')->where(array('parent'=>session("username"),'checkstatus'=>3 ))->count();//直推人数
				
				
				$mapss['p_user']=session("username");
				$mapss['datatype']=qglkb;
				$mapss['zt']=2;
				$mapss['lkb']=array('gt',$yqddje);
				
				$ddshuls=M('ppdd')->where($mapss)->count();//DD数量
				
				$mapsss['g_user']=session("username");
				$mapsss['datatype']=cslkb;
				$mapsss['zt']=2;
				$mapsss['lkb']=array('gt',$yqddje);
				
				$ddshul=M('ppdd')->where($mapsss)->count();//DD数量
				
				
				$ddxzsl=$ddshuls + $ddshul;
				
				if($ztrs<$yqztrs){
					$this->ajaxReturn(array("status"=>2,"info"=>'直推15人或15人以上才可以出售!'));	
				}
 				if($ddxzsl<$yqddsl){
					$this->ajaxReturn(array("status"=>2,"info"=>'必须在交易大厅购买'. $yqddsl .'单并且数量大于'. $yqddje .'才可以出售!'));					
				}

				
				$time=date('Y-m-d 00:00:00',time());
				$time1=date('Y-m-d 23:59:59',time());


				$mapa['p_user']=session("username");
				$mapa['datatype']=array('eq', 'cslkb');
				$mapa['date']=array(array('gt',$time),array('lt',$time1));
				
				$cszsls = M('ppdd')->where($mapa)->count();

				$mapaa['g_user']=session("username");
				$mapaa['datatype']=array('eq', 'qglkb');
				$mapaa['date']=array(array('gt',$time),array('lt',$time1));
		
				$qgzsls = M('ppdd')->where($mapaa)->count();
				
				$yxsell = $cszsls + $qgzsls;
				
				if($yxsell>$max_sell){
					$this->ajaxReturn(array("status"=>2,"info"=>'每天只允许卖出'. $max_sell .'笔'));					
				} 
				
				
		$dajia = $price/$lkb;
		$map['p_id'] = $user['id'];
		$map['p_user'] = $user['username'];
		$map['jb'] = $price*$lkb;
		$map['lkb'] = $lkb;
		$map['date']= date('Y-m-d H:i:s');
		$map['p_name'] = $user['nickname'];
		$map['p_level'] = $user['level'];
		$map['danjia']  = $price;
		$map['datatype']='cslkb';
		$map['zdjyr']=$zdjy;
		$sail=M('ppdd')->where(array('p_user'=>$gname))->data(array('p_level'=>$user['level']))->save();
		$result=M('ppdd');
		
    	$chushou = M('member')->where(array('username'=>$gname))->setDec('jinbi',$totalprice);
		account_log($gname,$totalprice,' 卖出挂单',0);		
		
		$csdec = M('member')->where(array('username'=>$gname))->setInc('qjinbi',$totalprice);
		account_log4($gname,$totalprice,' 卖出挂单',1);		
		$oob = $result->add($map);
		if($csdec){
			if($zdname!=""){
				$zdxx = M('member')->where("username = '{$zdjy}' or id = '{$zdjy}'")->find();
				$re = M('ppdd')->where(array('id'=>$oob))->data(array('zt'=>1,'jydate'=>date('Y-m-d H:i:s',time()),'g_name'=>$zdxx['nickname'],'g_user'=>$zdxx['username'],'g_level'=>$zdxx['level'],'g_id'=>$zdxx['id']))->save();
			}
			$this->ajaxReturn(array("status"=>1,"info"=>'订单已成功发送至交易大厅。'));
		}

	}	
	public function huilv(){
		$data_P = $_GET['huilv'];
		$rmb = $data_P * C("rmb_hl");
		$btc = $data_P * C("btc_hl");
		$respond['rmb']=$rmb;
		$respond['btc']=$btc;
		
		$this->ajaxReturn($respond);
	}
	public function lksc(){
		$data_P = I('GET.');
		
		if(IS_AJAX){
			$data_P = I('GET.');
			if(false){
				$this->ajaxReturn ( array ('data' => '网络错误!','sf' => 0 ));
			}else{
				$user = M('member')->where(array('username'=>session("username")))->find();//登录账户本人信息
				$result = M('ppdd')->where(array('id'=>$data_P['id']))->find();//订单信息
				$gname = session("username");
				
				$map['zt']=1;
				$map['_string']="(p_user = '$gname' or g_user = '$gname')";
				
				$oob = M('ppdd') ->where($map)->find();
				$maps['zt']=0;
				$maps['_string']="(p_user = '$gname' or g_user = '$gname')";
				
				$oob1 = M('ppdd') ->where($maps)->find();
				if($user['level']==0){
					$this->ajaxReturn(array("status"=>2,"msg"=>'交易前请先到个人资料完善个人信息'));
				}
				if($result['zdjyr']!=""){
					if(session("username")!=$result['zdjyr']){
						$this->ajaxReturn(array("status"=>2,"msg"=>'该订单已有指定交易人'));
					}
				}
				if($oob || $oob1){
					$this->ajaxReturn(array("status"=>2,"msg"=>'你还有未完成交易的订单。'));
				}else
				if($result['p_user']==session("username")){
					$this->ajaxReturn(array("status"=>2,"msg"=>'您不能购买自己出售的 。'));
				}elseif($result['zt']==1){
					$this->ajaxReturn(array("status"=>2,"msg"=>'对方正在交易中。'));
				}elseif($result['zt']==2){
					$this->ajaxReturn(array("status"=>2,"msg"=>'对方交易已完成。'));
				}else{
        			$time=date('Y-m-d H:i:s');
        			$re = M('ppdd')->where(array('id'=>$data_P['id']))->data(array('zt'=>1,'jydate'=>$time,'g_name'=>$user['nickname'],'g_user'=>$user['username'],'g_level'=>$user['level'],'g_id'=>$user['id']))->save();
					if($re){
						unset($respond);
						$maijia=$result['g_user'];//购买方
						$mj = $result['p_user'];//出售方				
						$this->ajaxReturn(array("status"=>1,"msg"=>'匹配成功，请到我的交易中查看详情'));
					}
				}

			}

		}
		
		
		
	}	
	public function chushou(){
		if(IS_AJAX){
			$data_P = I('GET.');
			if(false){
				$this->ajaxReturn ( array ('data' => '网络错误!','sf' => 0 ));
			}else{
				$user=M('member')->where(array('username'=>session("username")))->find();
				$result = M('ppdd')->where(array('id'=>$data_P['id']))->find();
				$gname = session("username");
				
				$map['zt']=1;
				$map['_string']="(p_user = '$gname' or g_user = '$gname')";
				
				$oob = M('ppdd') ->where($map)->find();
				$maps['zt']=0;
				$maps['_string']="(p_user = '$gname' or g_user = '$gname')";
				
				$oob1 = M('ppdd') ->where($maps)->find();
				
				
				
			   $mobile_code = $data_P['mobile_code'];
				if(empty($mobile_code)){
					$this->ajaxReturn(array("status"=>2,"msg"=>'请输入交易密码！'));	
				}
				/*$user_id = session('mid');
				$check_mobile=M('member')->where("id = {$user_id}")->getField('mobile');
				
				$check_code = sms_code_verify($check_mobile,$mobile_code,session_id());				
				if($check_code['status'] != 1){
						$this->ajaxReturn(array('status'=>2,'msg'=>$check_code['msg']));					
				}
				*/
				
				//判断交易密码是否正确
		
				if(md5($mobile_code)!=$user['password2']){
					$this->ajaxReturn(array("status"=>2,"msg"=>'交易密码错误！'));
				}
				
				if($user['level']==0){
					$this->ajaxReturn(array("status"=>2,"msg"=>'交易前请先到个人资料完善个人信息'));
				}
				
				$yqztrs = C('min_zhitui');//要求的直推人数
				$yqddsl = C('min_buy');//要求的订单数量
				$yqddje = C('min_buyje');//要求的订单数量
				$max_sell = C('max_sell');//每天允许卖出笔数
				
				$ztrs = M('member')->where(array('parent'=>session("username"),'checkstatus'=>3 ))->count();//直推人数
				
				
				$mapss['p_user']=session("username");
				$mapss['datatype']=qglkb;
				$mapss['zt']=2;
				$mapss['lkb']=array('gt',$yqddje);
				
				$ddshuls=M('ppdd')->where($mapss)->count();//DD数量
				
				$mapsss['g_user']=session("username");
				$mapsss['datatype']=cslkb;
				$mapsss['zt']=2;
				$mapsss['lkb']=array('gt',$yqddje);
				
				$ddshul=M('ppdd')->where($mapsss)->count();//DD数量
				
				
				$ddxzsl=$ddshuls + $ddshul;
				
				if($ztrs<$yqztrs){
					$this->ajaxReturn(array("status"=>2,"msg"=>'直推15人或15人以上才可以出售!'));	
				}
 				if($ddxzsl<$yqddsl){
					$this->ajaxReturn(array("status"=>2,"msg"=>'必须在交易大厅购买'. $yqddsl .'单并且数量大于'. $yqddje .'才可以出售!'));					
				}
				
				$time=date('Y-m-d 00:00:00',time());
				$time1=date('Y-m-d 23:59:59',time());
				
				$mapa['p_user']=session("username");
				$mapa['datatype']=array('eq', 'cslkb');
				$mapa['date']=array(array('gt',$time),array('lt',$time1));
				
				$cszsls = M('ppdd')->where($mapa)->count();

				$mapaa['g_user']=session("username");
				$mapaa['datatype']=array('eq', 'qglkb');
				$mapaa['date']=array(array('gt',$time),array('lt',$time1));
		
				$qgzsls = M('ppdd')->where($mapaa)->count();
				
				$yxsell = $cszsls + $qgzsls;
				
				if($yxsell>$max_sell){
					$this->ajaxReturn(array("status"=>2,"msg"=>'每天只允许卖出'. $max_sell .'笔'));					
				} 
				
				//查询矿机限购数量
				$zskj=M('product')->where(array('id'=>1))->getField('xianshou');
				$xxkj=M('product')->where(array('id'=>2))->getField('xianshou');
				$zxkj=M('product')->where(array('id'=>3))->getField('xianshou');
				$dxkj=M('product')->where(array('id'=>4))->getField('xianshou');
				$cjkj=M('product')->where(array('id'=>5))->getField('xianshou');
				$wxkj=M('product')->where(array('id'=>6))->getField('xianshou');
	
		
				//背包里面在运营的矿机数量
				$zskjs=M("order")->where(array('user'=>session('username'),'sid'=>1,'zt'=>1))->count();
				$xxkjs=M("order")->where(array('user'=>session('username'),'sid'=>2,'zt'=>1))->count();
				$zxkjs=M("order")->where(array('user'=>session('username'),'sid'=>3,'zt'=>1))->count();
				$dxkjs=M("order")->where(array('user'=>session('username'),'sid'=>4,'zt'=>1))->count();
				$cjkjs=M("order")->where(array('user'=>session('username'),'sid'=>5,'zt'=>1))->count();
				$wxkjs=M("order")->where(array('user'=>session('username'),'sid'=>6,'zt'=>1))->count();
				
				//用户当前级别
				$dqyhjb=M('member_group')->where(array('level'=>$user['level']))->getField('csbl');
		
				//现有矿机的销售数量
				$kmai=$zskjs * $zskj;
				$kmai1=$xxkjs * $xxkj;
				$kmai2=$zxkjs * $zxkj;
				$kmai3=$dxkjs * $dxkj;
				$kmai4=$cjkjs * $cjkj;
				$kmai5=$wxkjs * $wxkj;
				$kmze=($kmai + $kmai1 + $kmai2 + $kmai3 + $kmai4 + $kmai5) * $dqyhjb; //可卖总数
		
		
				$time=date('Y-m-d 00:00:00',time());
				$time1=date('Y-m-d 23:59:59',time());


				$mapa1['p_user']=session("username");
				$mapa1['datatype']=array('eq', 'cslkb');
				$mapa1['date']=array(array('gt',$time),array('lt',$time1));
				
				$cslkbsl = M('ppdd')->where($mapa1)->sum('lkb');

				$mapaa1['g_user']=session("username");
				$mapaa1['datatype']=array('eq', 'qglkb');
				$mapaa1['date']=array(array('gt',$time),array('lt',$time1));
		
				$qglkbsl = M('ppdd')->where($mapaa1)->sum('lkb');
				
				$ymkbsl = $cslkbsl + $qglkbsl;
		
				$kmkbsl = $kmze - $ymkbsl;
				
				$sxf = M("member_group")->where(array("level"=>$user['level']))->getField("shouxu");
				$totalprice=$result['lkb'] + $result['lkb']* $sxf;
				
				if($totalprice > $kmkbsl ){
					$this->ajaxReturn(array("status"=>2,"msg"=>'您当前所持有的矿机每天最多可出售'. $kmze .'个币,今天已经出售'. $ymkbsl .'个币!'));
				} elseif($user['jinbi'] < $totalprice){
					$this->ajaxReturn(array("status"=>2,"msg"=>'你的账户余额不足'));					
				}elseif($oob || $oob1){
					$this->ajaxReturn(array("status"=>2,"msg"=>'你还有未完成交易的订单。'));						
				}elseif($result['p_user']==session("username")){
					$this->ajaxReturn(array("status"=>2,"msg"=>'您不能出售币到自己的账户'));					
				}elseif($result['zt']==1){
					$this->ajaxReturn(array("status"=>2,"msg"=>'对方正在交易中。'));					
				}elseif($result['zt']==2){
					$this->ajaxReturn(array("status"=>2,"msg"=>'对方交易已完成。'));					
				}else{
        			$time=date('Y-m-d H:i:s');
        			$re=M('ppdd')->where(array('id'=>$data_P['id']))->data(array('zt'=>1,'jydate'=>$time,'g_name'=>$user['nickname'],'g_user'=>$user['username'],'g_level'=>$user['level'],'g_id'=>$user['id']))->save();

					$results = M('member')->where(array('username'=>session("username")))->setDec('jinbi',$totalprice);
                    account_log($gname,$totalprice,'交易市场下单扣除',0);
					$obs = M('member')->where(array('username'=>session("username")))->setInc('qjinbi',$totalprice);
					account_log4($gname,$totalprice,'交易市场下单',1);
					if($results && $obs){
						unset($respond);
						$maijia=$result['g_user'];//卖家
						$mj = $result['p_user'];//买家
						$this->ajaxReturn(array("status"=>1,"msg"=>'匹配成功，请到我的交易中查看详情'));

					}
				}

			}

		}
	}	
	
    public function shouye(){


			$list = M('announce') ->where(array("tid"=>3))->order('id DESC')->select();
			$banner_list=M('banner')->order('sort DESC')->select();
			$this->banner_list=$banner_list;
			$this->assign('list',$list);		
			$this->display();
    }
	
	
	public function getgp(){
		$time=date('Y-m-d 00:00:00',time());
		$time1=date('Y-m-d 23:59:59',time());
		$date=strtotime($time);
		$date1=strtotime($time1);
		
		$maps['date']=array(array('gt',$date),array('lt',$date1));
		$xngp=M("date");
		$rsxng=$xngp->where($maps)->field('date,price')->select();
		echo json_encode($rsxng);
	}
	//
	public function getgps(){
		$rsxngs=M('ridate')->order('id asc')->select();
		echo json_encode($rsxngs);
	}

	
		/**
		 * [买入]
		 * @return [type] [description]
		 */
		public function buy(){
			$username = session('username');
            $jinzhongzi = getMemberField('jinzhongzi');
			$id = I('get.id',0,'intval');
			$info = M("jiaoyi")->where(array("id"=>$id,'status'=>0))->find();
			
			if (IS_AJAX) {
				
				
				if(!$info){
					$this->ajaxReturn(array('info'=>'交易订单不存在！'));
				}
				if($info['selluser'] == $username){
					$this->ajaxReturn(array('info'=>'不能购买自己的订单！'));
				}				
				$password2   = $_POST['password2'];
				if(empty($password2)){
					$this->ajaxReturn(array('info'=>'二级密码不能为空！'));
				}
			
				//验证二级密码是否正确
				if (!M('member')->where(array('username'=>session('username'),'password2'=>I('post.password2','','md5')))->getField('id')) {
					$this->ajaxReturn(array('info'=>'对不起!二级密码不正确!'));					
				}	
				if ($jinzhongzi < $info['jinzhongzi']) {
						$this->ajaxReturn(array('info'=>'对不起，种子余额不足，请重试！'));					
				}	
			
				$data['buyuser'] = $username;
				$data['buytime'] = NOW_TIME;
				$data['status']  = 1;	
                M("jiaoyi")->where(array("id"=>$id,'status'=>0))->save($data);	
				//扣除买家电子币
				M('member')->where(array('username'=>$username))->setDec('jinbi',$info['jinbi']);
				account_log($username,$info['jinbi'],'交易大厅消费',0);                				
				//交易完成买家得到
				M('member')->where(array('username'=>$username))->setInc('jinzhongzi',$info['jinzhongzi']);
				account_log2($username,$info['jinzhongzi'],'交易大厅购入',1,5);		
                //卖家得到电子币	
				M('member')->where(array('username'=>$info['selluser']))->setInc('jinbi',$info['jinbi']);
				account_log($info['selluser'],$info['jinbi'],'交易大厅卖出',1,5);					
                $this->ajaxReturn(array('info'=>'交易成功！','url'=>U('Index/Emoney/bblist')));				
            }      
			
			$this->assign('jinzhongzi',$jinzhongzi);
			$this->assign('info',$info);
			$this->display();
		}	
		/**
		 * [卖出]
		 * @return [type] [description]
		 */
		public function sell(){
			$username = session('username');
            $jinzhongzi = getMemberField('jinzhongzi');
        			
			if (IS_AJAX) {
				$data['jinbi']      = I('post.jinbi',0,'intval'); //卖出总价
				$data['jinzhongzi'] = I('post.jinzhongzi',0,'intval'); //卖出股票数量
				$password2          = $_POST['password2'];
                if($data['jinzhongzi'] == 0){
					$this->ajaxReturn(array('info'=>'卖出股票数量不能为0！'));
				}
				if($data['jinbi'] == 0){
					$this->ajaxReturn(array('info'=>'卖出总价不能为0！'));
				}				
				if(empty($password2)){
					$this->ajaxReturn(array('info'=>'二级密码不能为空！'));
				}
			    //验证二级密码是否正确
				if (!M('member')->where(array('username'=>$username,'password2'=>I('post.password2','','md5')))->getField('id')) {
					$this->ajaxReturn(array('info'=>'对不起!二级密码不正确!'));					
				}	
				if ($data['jinzhongzi'] > $jinzhongzi) {
						$this->ajaxReturn(array('info'=>'对不起，原始股余额不足，请重试！'));					
				}	
                $data['unit']     = $data['jinzhongzi'] / $data['jinbi'];	//换购单价
				$data['selluser'] = $username;
				$data['selltime'] = NOW_TIME;
				//柿子扣除
				M('member')->where(array('username'=>$username))->setDec('jinzhongzi',$data['jinzhongzi']);
				account_log2($username,$data['jinzhongzi'],'交易中心挂单扣除',0);	
                M("jiaoyi")->add($data);				
               	$this->ajaxReturn(array('info'=>'提交成功！','url'=>U('Index/Emoney/sell')));				
            }      
			
			$this->assign('jinzhongzi',$jinzhongzi);
			$this->display();
		}				

        //支付页面
		public function payadd(){
			
			$this->display();
		}
		public function sblist(){
            import('ORG.Util.Page');
			$username = session('username');
			$count = M('jiaoyi')->where(array('selluser'=>$username))->count();
			$page = new Page($count,15);
			$show = $page->show();// 分页显示输出
			$list = M('jiaoyi')->where(array('selluser'=>$username))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();		
			$this->assign('username',$username);
			$this->assign('list',$list);
			$this->assign('page',$show);
			$this->display();
		}	
		//买入记录表
		public function bblist(){
            import('ORG.Util.Page');
			$username = session('username');
			$count = M('jiaoyi')->where(array('buyuser'=>$username))->count();
			$page = new Page($count,15);
			$show = $page->show();// 分页显示输出
			$list = M('jiaoyi')->where(array('buyuser'=>$username))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('username',$username);
			$this->assign('list',$list);
			$this->assign('page',$show);
			$this->display();
		}	
		/**
      //确认打款操作
       public function overdk(){
			$username = session('username');
			$id = I('get.id',0,'intval');
            $info = M("jiaoyi")->where(array("id"=>$id,'buyuser'=>$username,'status'=>3))->find();
			if(!$info){
				echo '<script>alert("交易订单不存在！请确认！");window.history.back(-1);</script>';
				die;				
			}	
            $data['buytime'] = NOW_TIME;						
			$data['status']  = 4;	
            M("jiaoyi")->where(array("id"=>$id,'buyuser'=>$username,'status'=>3))->save($data);			
			alert('操作成功！',U('Index/Emoney/bblist'));		   
	   }	
**/	   
		public function buylist(){
            import('ORG.Util.Page');
			$username = session('username');
			$count = M('jiaoyi')->where(array('status'=>0))->count();
			$page = new Page($count,15);
			$show = $page->show();// 分页显示输出
			$list = M('jiaoyi')->where(array('status'=>0))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			
			$this->assign('username',$username);
			$this->assign('list',$list);
			$this->assign('page',$show);
			$this->display();
		}
		/**
      //确认收款
       public function oversk(){
			$username = session('username');
			$id = I('get.id',0,'intval');
            $info = M("jiaoyi")->where(array("id"=>$id,'selluser'=>$username,'status'=>4))->find();
			if(!$info){
				echo '<script>alert("交易订单不存在！请确认！");window.history.back(-1);</script>';
				die;				
			}		
            $data['buytime'] = NOW_TIME;			
			$data['status']  = 1;	
            M("jiaoyi")->where(array("id"=>$id,'selluser'=>$username,'status'=>4))->save($data);		
			//扣除股份
			M('member')->where(array('username'=>$username))->setDec('jinzhongzi',$info['jinzhongzi']);
			account_log2($username,$info['jinzhongzi'],'交易完成扣除',0);					
        	//交易完成买家得到
			M('member')->where(array('username'=>$info['buyuser']))->setInc('jinzhongzi',$info['jinzhongzi']);
			account_log2($info['buyuser'],$info['jinzhongzi'],'交易大厅购入',1,5);				
			alert('交易完成！',U('Index/Emoney/sblist'));		   
	   }	
**/	   
		//撤单
		public function cd(){
			$username = session('username');
			$id = I('get.id',0,'intval');
            $info = M("jiaoyi")->where(array("id"=>$id,'selluser'=>$username,'status'=>0))->find();
			if(!$info){
				echo '<script>alert("交易订单不存在！");window.history.back(-1);</script>';
				die;				
			}			
			
			$data['status']  = 2;	
            M("jiaoyi")->where(array("id"=>$id,'selluser'=>$username,'status'=>0))->save($data);	
			//返还金额
			M('member')->where(array('username'=>$username))->setInc('jinzhongzi',$info['jinzhongzi']);
		    account_log2($username,$info['jinzhongzi'],'交易中心撤单',1,6);				
			alert('撤单成功！',U('Index/Emoney/sblist'));
		}		
			
		
		//基金走势
		public function jjHistory(){
			$endtime = strtotime(date("Y-m-d",NOW_TIME))+86400;//今日时间戳	
			$jijin=M("jijin")->where("`date`<'$endtime'")->limit(7)->order("date desc")->select();
			$this->assign('jijin',$jijin);
			$this->display();
		}
		/**
		 * [基金买入]
		 * @return [type] [description]
		 */
		public function buyJijin(){
			die;
			$date = strtotime(date("Y-m-d",NOW_TIME));
			$jijin=M("jijin")->where(array("date"=>$date))->find();
			$member = M('member')->field("jinbi")->where(array('id'=>session('mid')))->find();
			$username = session('username');
			if (IS_AJAX) {
				$num = I('post.num',0,'intval');
				$password2   = $_POST['password2'];
                //本日买入单价
				$unit = $jijin['money'];
				if($num == 0){
					$this->ajaxReturn(array('info'=>'购买数量不能为0！'));
				}
				if(empty($password2)){
					$this->ajaxReturn(array('info'=>'二级密码不能为空！'));
				}
			
				//验证二级密码是否正确
				if (!M('member')->where(array('username'=>session('username'),'password2'=>I('post.password2','','md5')))->getField('id')) {
					$this->ajaxReturn(array('info'=>'对不起!二级密码不正确!'));					
				}	
				if (($unit * $num)> $member['jinbi']) {
						$this->ajaxReturn(array('info'=>'对不起，现金余额不足，请重试！'));					
				}	
                $buymoney= $unit * $num;	//购买总价
                //扣除现金明细
				M('member')->where(array('username'=>$username))->setDec('jinbi',$buymoney);
				account_log($username,$buymoney,'购买基金份额:'.$num.',单价:'.$unit,0,5);					
                //写入基金明细				
				M('member')->where(array('username'=>$username))->setInc('jijin',$num);	
                $this->ajaxReturn(array('info'=>'购入成功！','url'=>U('Index/Emoney/buyJijin')));				
            }      
			
			$this->assign('jijin',$jijin);
			$this->assign('v',$member);
			$this->display();
		}	
		/**
		 * [基金卖出]
		 * @return [type] [description]
		 */
		public function sellJijin(){
			
			$date = strtotime(date("Y-m-d",NOW_TIME));
			$member = M('member')->where(array('id'=>session('mid')))->find();
			$username = session('username');
			if (IS_AJAX) {
				$num = I('post.num',0,'intval');
				$password2   = $_POST['password2'];
                //本日卖出单价
				$unit = C("GU");
				if($num == 0){
					$this->ajaxReturn(array('info'=>'卖出数量不能为0！'));
				}
				if(empty($password2)){
					$this->ajaxReturn(array('info'=>'二级密码不能为空！'));
				}
			
				//验证二级密码是否正确
				if (!M('member')->where(array('username'=>session('username'),'password2'=>I('post.password2','','md5')))->getField('id')) {
					$this->ajaxReturn(array('info'=>'对不起!二级密码不正确!'));					
				}	
				if ($num> $member['jinzhongzi']) {
						$this->ajaxReturn(array('info'=>'对不起，持有股票余额不足，请重试！'));					
				}	
                $sellmoney= $unit * $num;	//卖出总价
				//基金扣除
				M('member')->where(array('username'=>$username))->setDec('jinzhongzi',$num);	
                //得到现金明细
				M('member')->where(array('username'=>$username))->setInc('jinbi',$sellmoney);
				account_log($username,$sellmoney,'卖出:'.$num.'股,单价:'.$unit,1,6);					
               		
				
                $this->ajaxReturn(array('info'=>'卖出成功！','url'=>U('Index/Emoney/sellJijin')));				
            }      
			$this->assign('v',$member);
			$this->display();
		}			
		/**
		 * [会员电子货币提现]
		 * @return [type] [description]
		 */
		public function withdraw(){
		   $user = M('member')->field("jinbi,point,truename,sktype,sknumber")->where(array('id'=>session('mid')))->find();
			if (IS_POST) {
				$db = M('emoneydetail');
				$member = M('member');
				$money = I('post.money',0,'intval');
				$type = I('post.type',0,'intval');
				$password2   = I('post.password2','','md5');
				if(!in_array($type,array(1,2))){
					 $this->ajaxReturn(array('info'=>'参数错误！'));
				}
				//当前会员余额
				if($type==1){
					$balance = $member->where(array('id'=>session('mid')))->getField('jinbi');
					
				}else{
					$balance = $member->where(array('id'=>session('mid')))->getField('point');
				}
				
				$money == 0 and  $this->ajaxReturn(array('info'=>'提现金额不能为0！','url'=>''));
				//验证二级密码是否正确
				if (!$member->where(array('username'=>session('username'),'password2'=>$password2))->getField('id')) {
					$this->ajaxReturn(array('info'=>'对不起!二级密码不正确!'));					
				}		
				
				//是否开启提现功能
				if ($type==2 && C('WITHDRAW_STATUS') == 'off') {
					$this->ajaxReturn(array('info'=>'对不起!现金提现功能暂未开放!'));								
				}

				//一次性提现最少额度
				if($money < C('WITHDRAW_MIN')){
					$this->ajaxReturn(array('info'=>"您输入的提现金额小于最少提现金额，请输入至少" . C('WITHDRAW_MIN') . ""));
					
				}
				//设置提现整数倍
				if (C('WITHDRAW_INT') > 0) {
					if ($money % C('WITHDRAW_INT') != 0) {
						$this->ajaxReturn(array('info'=>"您输入的提现金额必须为". C('WITHDRAW_INT') ."的整数倍"));					
					}
				}
				//每天最多提现的次数	待测试
				if (C('WITHDRAW_IN_DAY_NUM') > 0) {

					$where = array('account'=>session('account'),'mode'=>'applywd');
					$where['_string'] = 'addtime >= '. todaytime('start') .' AND addtime <= '. todaytime('end') .'';

					$thisdayget = $db->where($where)->count();
					if ($thisdayget >= C('WITHDRAW_IN_DAY_NUM')) {
						$this->ajaxReturn(array('info'=>"每日最多只能提现" . C('WITHDRAW_IN_DAY_NUM') . "次"));					
					}
				}

				//提现手续费点位、手续费上限、手续费下限	设置提现的时候要扣除的手续费即x%
				$withdrawtaxnum = 0;
				if (C('WITHDRAW_TAX')<>0) {
					$withdrawtaxnum = $money * (C('WITHDRAW_TAX') / 100);
				}

				if ($withdrawtaxnum < C('WITHDRAW_TAX_MIN')) {
					$withdrawtaxnum = C('WITHDRAW_TAX_MIN');
				}

				if (C('WITHDRAW_TAX_MAX') != 0 && $withdrawtaxnum > C('WITHDRAW_TAX_MAX')) {
					$withdrawtaxnum = C('WITHDRAW_TAX_MAX');
				}
				
				//手续费出处	0:从提现额中扣除	1:单独扣除
				//if (C('WITHDRAW_TAX_IN') == 1 && ($money + $withdrawtaxnum)> $balance ) {
					//	$this->ajaxReturn(array('info'=>"对不起，余额不足，请重试！"));					
				//}

				if (C('WITHDRAW_TAX_IN') == 0 && $money > $balance) {
					if($type==1){
						$this->ajaxReturn(array('info'=>"对不起，现金余额不足，请重试！"));	
					}else{
						$this->ajaxReturn(array('info'=>"对不起，消费积分余额不足，请重试！"));	
					}
						
				}

				$withdrawtaxnum = intval($withdrawtaxnum);
				$money = intval($money);
				//正式处理
				if (C('WITHDRAW_TAX_IN') == 1) {
					$balance = $balance - ($money + $withdrawtaxnum);
				}else{
					$balance = $balance - $money;
				}
				
				$data['name'] = $user['truename'];
				if($type==1){
					$data['mode'] = '电子币提现';
				}else{
					$data['mode'] = '消费币提现';
				}

				$data['addtime'] = time();
				$data['member'] = session('username');
				if ($withdrawtaxnum == 0) {
					$data['amount'] =  -$money;
					$data['balance'] = $balance;
					$data['charge'] = 0;
					$data['remark'] = '申请提现'.$money.'元';
					if ($db->data($data)->add()) {
						if($type==1){
							$member->where(array('username'=>session('username')))->setField('jinbi',$balance);
						}else{
							$member->where(array('username'=>session('username')))->setField('point',$balance);
						}
						$this->ajaxReturn(array('info'=>'提现成功！','url'=>U('Index/Emoney/withdraw')));
					}else{
						$this->ajaxReturn(array('info'=>'提现失败！','url'=>U('Index/Emoney/withdraw')));
					}				
				}else{
					if (C('WITHDRAW_TAX_IN') == 1) {
						$data['amount'] =  -($money + $withdrawtaxnum);
						$data['balance'] = $balance;
						$data['charge'] = $withdrawtaxnum;
						$data['remark'] = '申请提现'.$money.'元,扣除'. $withdrawtaxnum .'作为手续费扣除';
						if ($db->data($data)->add()) {
							if($type==1){
								$member->where(array('username'=>session('username')))->setField('jinbi',$balance);
							}else{
								$member->where(array('username'=>session('username')))->setField('point',$balance);
							}
							$this->ajaxReturn(array('info'=>'提现成功！','url'=>U('Index/Emoney/withdraw')));	
						}else{
							$this->ajaxReturn(array('info'=>'提现失败！','url'=>U('Index/Emoney/withdraw')));	
						}			
					}else{
						$data['amount'] =  -$money;
						$data['balance'] = $balance;
						$data['charge'] = $withdrawtaxnum;
						$data['remark'] = '申请提现'.$money.'元,扣除'. $withdrawtaxnum .'作为手续费扣除';
						if ($db->data($data)->add()) {
							if($type==1){
								$member->where(array('username'=>session('username')))->setField('jinbi',$balance);
							}else{
								$member->where(array('username'=>session('username')))->setField('point',$balance);
							}
							$this->ajaxReturn(array('info'=>'提现成功！','url'=>U('Index/Emoney/withdraw')));
						}else{
							$this->ajaxReturn(array('info'=>'提现失败！','url'=>U('Index/Emoney/withdraw')));	
						}
					}
				 }
            }      
		
			
			if (empty($user['truename']) || empty($user['sktype']) || empty($user['sknumber'])) {
			    alert('请先添加收款信息',U('personal_set/myInfo'));			
            }
			$status = C("WITHDRAW_STATUS");
			$this->assign('status',$status);
			$this->assign('v',$user);
			$this->display();
		}

		public function ajaxCheckPassword2(){
			//判断是否异步提交
			IS_AJAX or halt('对不起，页面不存在');

			if (M('member')->where(array('id'=>session('mid'),'password2'=>I('password2','','md5')))->getField('id')) {
				echo 'true';
			}else{
				echo 'false';
			}
		}

		/**
		 * [会员提现记录]
		 * @return [type] [description]
		 */
		public function withdrawList(){
			$data = M('emoneydetail')->where(array('member'=>session('username')))->order('id desc')->select();
			$this->assign('data',$data);
			$this->display();
		}
		public function Putforward(){
			$data = M('emoneydetail')->where(array('member'=>session('username')))->order('id desc')->select();
			$this->assign('data',$data);
			$this->display();
		}

		/**
		 * [会员电子货币转账]
		 * @return [type] [description]
		 */
		public function transfer(){
			$this->display();
		}

		public function ajaxGetNickName(){
			IS_AJAX or halt('您访问的页面不存在');

			$nickname = M('member')->where(array('account'=>I('post.account','','strval')))->getField('nickname');
			echo $nickname;
		}

		/**
		 * 会员电子货币转账处理
		 * @return [type] [description]
		 */
		public function transferHandle(){
			$db = M('emoneydetail');
			$money = I('money',0,'intval');
			$account = I('receive_account','','strval');
			$emoney = getMemberField('emoney');
			$toemoney = getFieldValue('member',array('account'=>$account),'emoney');
			if (getMemberField('state') != 'checked') {
				$this->error('非正式会员不允许进行转账操作');
			}

			if (C('TRANSFER_STATUS') == 'off') {
				$this->error('系统目前不允许转账!');
			}

			if (strtoupper(session('account')) == strtoupper(I('receive_account','','strval'))) {
				$this->error('转入编号不应为自己的编号!');
			}

			$account == '' and $this->error('转入编号不能为空!');

			$money <= 0 and $this->error('转账金额不能小于或等于0');

			if ($money < C('TRANSFER_MIN')) {
				$this->error('转账金额不能小于'. C('TRANSFER_MIN'));
			}

			//验证接收会员是否存在及审核
			if (!getFieldValue('member',array('account'=>$account,'state'=>'checked'),'id')) {
				$this->error('转入编号不存在或未审核');
			}

			//判断网体,如果不在一个网体返回错误信息
			//.........待更新
			
			//二级密码验证
			if (C('WITHDRAW_PASS2') == 'on') {
				if ($member->where(array('account'=>session('account'),'password2'=>I('password2','','md5')))->getField('id')) {
				}else{
					$this->error('二级密码错误,请重新输入');
				}
			}

			//正式处理
			$transfertax = intval($money * (C('TRANSFER_TAX') / 100));
			//手续费上限
			if (C('TRANSFER_TAX_MAX') != 0 && $transfertax > C('TRANSFER_TAX_MAX')) {
				$transfertax = C('TRANSFER_TAX_MAX');
			}
			//手续费下限
			if ($transfertax < C('TRANSFER_TAX_MIN')) {
				$transfertax = C('TRANSFER_TAX_MIN');
			}

			if (($money + $transfer) > $emoney) {
				$this->error('你的余额不足'.($money + $transfer).'请重新输入');
			}

			$emoney = $emoney - intval($money + $transfer);//转出会员余额更新
			$toemoney = $toemoney +  ($money * C('TRANSFER_PROPORTION'));

			if ($transfertax = 0) {
				$memsgstr = '转账给编号为'. $account .'的'. I('money',0,'intval') .'元';
				$tomsgstr = '收到编号为'. session('account') .'的'. I('money',0,'intval') .'元';
				//转出账号->sql
				$data['account'] = session('account');
				$data['targetaccount'] = $account;
				$data['mode'] = '转账转出';
				$data['addtime'] = time();
				$data['amount'] = -$money;
				$data['balance'] = $emoney;
				$data['remark'] = $memsgstr;
				$db->data($data)->add();
				//转入账号->sql
				unset($data);
				$data['account'] = $account;
				$data['targetaccount'] = session('account');
				$data['mode'] = '转账转入';
				$data['addtime'] = time();
				$data['amount'] = $money;
				$data['balance'] = $toemoney;
				$data['remark'] = $tomsgstr;
				$db->data($data)->add();
			}else{
				//开始写入数据库
				//转出账号->sql
				$data['account'] = session('account');
				$data['targetaccount'] = $account;
				$data['mode'] = '转账转出';
				$data['addtime'] = time();
				$data['amount'] = -($money + $transfertax);
				$data['balance'] = $emoney;
				$data['remark'] = '转账给编号为'. $account .'的'. $money .'元, 手续费' . $transfertax;
				$db->data($data)->add();
				//转入账号->sql
				unset($data);
				$data['account'] = $account;
				$data['targetaccount'] = session('account');
				$data['mode'] = '转账转入';
				$data['addtime'] = time();
				$data['amount'] = $money;
				$data['balance'] = $toemoney;
				$data['remark'] = '收到编号为' . session('account') . '的' . $money .'元';
				$db->data($data)->add();
			}
		}

		/**
		 * [会员电子货币明细]
		 * @return [type] [description]
		 */
		public function emoneyDetail(){
			$emoney = M('emoneydetail'); // 实例化User对象
			import('ORG.Util.Page');// 导入分页类
			$count      = $emoney->where(array('account'=>session('account')))->count();// 查询满足要求的总记录数
			$Page       = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出
			// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
			$list = $emoney->where(array('account'=>session('account')))->order('id desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->assign('list',$list);// 赋值数据集
			$this->assign('page',$show);// 赋值分页输出
			$this->display(); // 输出模板
		}
	    public function payLists(){
			import('ORG.Util.Page');// 导入分页类
			$count      = M('paydetails')->where(array('member'=>session('username')))->count();// 查询满足要求的总记录数
			$Page       = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
			$show       = $Page->show();// 分页显示输出			
			$data = M('paydetails')->where(array('member'=>session('username')))->order('id desc')->select();
			$this->assign('data',$data);
			$this->assign('page',$show);// 赋值分页输出
			$this->display();
		}
		public function pays(){
			
			if (IS_POST) {
				$db = M('paydetails');
				$member = M('member');
				$money = I('post.money',0,'intval');
				$password2   = I('post.password2','','md5');
				$data['type'] = I('post.type',0,'strval');
				$data['account'] = I('post.account',0,'strval');
				$data['name'] = I('post.name',0,'strval');
				if(empty($data['type']) || empty($data['account']) || empty($data['name'])){
					
					$this->ajaxReturn(array('info'=>'请完善打款账号信息！'));
				}
				$money == 0 and  $this->ajaxReturn(array('info'=>'提现金额不能为0！'));
				//验证二级密码是否正确
				if (!$member->where(array('username'=>session('username'),'password2'=>$password2))->getField('id')) {
					$this->ajaxReturn(array('info'=>'对不起!二级密码不正确!'));					
				}		
				$money = intval($money);
				$shoukuan = $member->where(array('member'=>session('username')))->find();
				

				$data['addtime'] = time();
				$data['member'] = session('username');
	            $data['amount'] =  $money;
					if ($db->data($data)->add()) {

						$this->ajaxReturn(array('info'=>'提交成功，等待审核！','url'=>U('Index/Emoney/pays')));
					}else{
						$this->ajaxReturn(array('info'=>'提交失败！','url'=>U('Index/Emoney/pays')));
					}				

            }      
			$member = M('member')->field("jinbi")->where(array('id'=>session('mid')))->find();
			
			$status = C("WITHDRAW_STATUS");
			$this->assign('status',$status);
			$this->assign('v',$member);
			$this->display();
		}

	}
?>