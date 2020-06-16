<?php  
	header("Content-type:text/html;charset=utf-8");
	/**
	 * 会员推广控制器
	 */
	Class SemAction extends Action{
			
			public function _initialize(){
				//判断是否关闭了网站
				$open_web=C('open_web');
				if(empty($open_web)){
					$this->open_web_notice=C('open_web_notice');
					$this->display('Index:404');
					exit;
				}	
				
			}
	   
	   
	   
	   
	   
		public function autoCr(){
			exit;
			 $member = M('member');
			 $jinbidetail = M('jinbidetail');
			 $order = M('order');
			 //查询会员
			 $userlist = $member->where(array("status"=>1))->order('id DESC')->select();
		     $start = strtotime(date("Y-m-d",NOW_TIME));//今日时间戳	
		     $end= $start + 86400;	
			 foreach($userlist as $k=>$v){
				  $username = $v['username'];
                  
				  $path2 = explode('|', $v['parentpath']);
				  array_pop($path2);
				  $parentpath = array_reverse($path2);				    
				  //查询此会员符合条件的订单
				  $orderlist = $order->where(array("user"=>$username,"zt"=>1))->select();
				  foreach($orderlist as $key=>$val){
					
					 $oid = $val['id'];
					 if($val['count']>=$val['yxzq']){//判断如果相差时间等于720小时
							//扣除上级团队算力
							foreach($parentpath as $m=>$n){
								 $member->where(array('id'=>$n))->setDec("teamgonglv",$val['lixi']);
							}					
							//扣除个人算力
							 $member->where(array('username'=>$username))->setDec("mygonglv",$val['lixi']);
						   //查询矿车数据库里的id等于矿车收益数据库里的kcid，更改矿车数据库里的zt字段等于2（2=当前矿车运行完毕）
						   $order->where(array('id'=>$oid))->setField("zt",2);
					 }else{	
                           //判断机器是否超过24小时					 
					      $cha = (NOW_TIME - $val['UG_getTime'])/3600;
						  $cha = floor($cha);
						  if($cha>720){
							  $cha=720;
						  }
					       //判断此机器今天有没产生奖励
						  $ac = $jinbidetail->where("`addtime`>'$start' and `addtime`<'$end' and  `jid`='$oid'")->find();
						  if(!$ac && $cha>=24){
							    //写入明细
								$member->where(array('username'=>$username))->setInc("jinbi",$val['kjsl']);
								account_log($username,$val['kjsl'],'矿机收益',1,1,1,$oid);
								//写入收益次数
								$order->where(array("id"=>$oid))->setField("count",$cha);		
                            	foreach($parentpath as $m=>$n){	
								     $userinfo = M("member")->where(array('id'=>$n))->find();
									 $ldgroup = M("member_group")->where(array('level'=>$userinfo['level']))->find();
									 if($ldgroup['ldj']<$m){
									 $tjj = C("tjj") * $val['kjsl'];
										 $member->where(array('username'=>$parent))->setInc("jinbi",$tjj);
										 account_log($parent,$tjj,$m.'代团队收益来自'.$username,1,2);
                                     }									 
                                }								
						  }
					 }
					 
				  }
				  
				  
			 }
		}
		
		//注册推广
		 public function regSem(){
			 header("Content-type:text/html;charset=utf-8");
			 
			 $d_key=I('get.u','','trim');//$d_keyid=encrypt("t24GWvVczWju",'D','xyb8888');
			 
			 if(!is_int($d_key)){
				  $d_key=str_replace('AAABBB','/',$d_key);
			      $uid =encrypt($d_key,'D','xyb8888');
			 }else{
				 $uid =$d_key; 		 
			}
			 
			 
			
			 $uid =intval($uid);
			 $userinfo = M('member')->where(array('id'=>$uid))->find();
			 if(!$userinfo){
				 //halt("错误的访问请求!");
				 $this->error('错误的访问请求!');
			 }

			
			$this->assign('uid',$uid);			
			$this->display();			 
		 }
		 
		
	//注册推广
		 public function regSempost(){
			 
			 if (IS_AJAX) {
						  
				$parent_id=I('post.parent','','intval');
				
				if(empty($parent_id)){
					$this->ajaxReturn(array('result'=>0,'info'=>'推荐人为空!'));
				}
				$data['parent_id']=$parent_id;
				$data['parent']=M('member')->where(array('id'=>$parent_id))->getField('username');

				$data['username']      = $data['mobile']        = I('post.mobile','','strval');
				$code = I('post.code','');

				$data['weixin']      = I('post.weixin','','strval');
				$data['zhifubao']      = I('post.zhifubao','','strval');
				$data['uname']      = I('post.mobile','','strval');
				
          				
				$password    = I('post.password','','strval');
				$password1   = I('post.password1','','strval');
				$password2  = I('post.password2','','strval');
				$password21  = I('post.password21','','strval');
			
				//验证推荐人信息是否已存在及审核
				if (!M('member')->where(array('username'=>$data['parent'],'status'=>1))->getField('id')) {
					$this->ajaxReturn(array('result'=>0, 'info'=>'推荐人不存在或未审核!'));
				}
				if(empty($data['mobile'])){
					$this->ajaxReturn(array('result'=>0,'info'=>'请填写手机号码!'));
				}	
				
				
				if(!preg_match("/^1[34578]{1}\d{9}$/",$data['mobile'])){
					$this->ajaxReturn(array('result'=>0,'info'=>'手机号码格式不正确!'));
				}		
				if (M('member')->where(array('mobile'=>trim($data['mobile'])))->getField('id')) {
					$this->ajaxReturn(array('result'=>0,'info'=>'手机号已存在，请更换！'));
				}				
				if(empty($data['zhifubao'])){
					$this->ajaxReturn(array('result'=>0,'info'=>'请填写支付宝账号!'));
				}
				
				if($data['zhifubao']!=$data['mobile']){
					$this->ajaxReturn(array('result'=>0,'info'=>'支付宝账号必须与手机号一致!'));
				}
				
				if(empty($data['weixin'])){
					$this->ajaxReturn(array('result'=>0,'info'=>'请填写微信号!'));
				}
				
				
					
				if(!$code){
					$this->ajaxReturn(array('result'=>0,'info'=>'请输入短信验证码!'));				
				}	
                $check_code = sms_code_verify($data['mobile'],$code,session_id());				
				if($check_code['status'] != 1){
					$this->ajaxReturn(array('result'=>0,'info'=>$check_code['msg']));					
				}		
				
		
				
							
				if (empty($password)  || empty($password1)) {
					$this->ajaxReturn(array('result'=>0,'info'=>'登陆密码不能为空'));
				}	
				if(!preg_match("/^[a-zA-Z\d_]{6,}$/",$password)){
					$this->ajaxReturn(array('result'=>0,'info'=>'登陆密码不能小于6位!'));
				}				
				if ($password != $password1) {
					$this->ajaxReturn(array('result'=>0,'info'=>'两次输入的登陆密码不相同!'));
				}					
				if (empty($password2)  || empty($password21)) {
					$this->ajaxReturn(array('result'=>0,'info'=>'交易密码不能为空'));
				}
				if(!preg_match("/^[a-zA-Z\d_]{6,}$/",$password2)){
					$this->ajaxReturn(array('result'=>0,'info'=>'交易密码不能小于6位!'));
				}				
				if ($password2 != $password21) {
					$this->ajaxReturn(array('result'=>0,'info'=>'两次输入的交易密码不相同!'));
				}				

			    /*if(empty($data['alipay_voucher'])){
					$this->ajaxReturn(array('result'=>0,'info'=>'请上传转账凭证!'));
				}*/
				

				$data['acc_type'] = '主账号';
				$data['password']  = md5($password);
				$data['password2'] = md5($password2);
				$parentinfo = M('member')->where(array('username'=>$data['parent']))->find();
				$data['parentpath']  = trim($parentinfo['parentpath'] . $parentinfo['id'] . '|');;
				$data['parentlayer'] = $parentinfo['parentlayer'] + 1;
				$data['regdate']     = time();
				$data['status']      = 1; 
				$data['checkstatus']      = 0; 
				$data['level']      = 0; 
				$data['checkdate']     = time();
				M('member')->add($data);
				//我的上级直推加一
				M('member')->where(array('username' => $data['parent']))->setInc('parentcount',1);
				mmtjrennumadd($parent_id);//  所有上级加一人
				
				$this->ajaxReturn(array('result'=>1,'info'=>'注册成功！请登录后完善个人资料!'));				
					

			}

			 
		}	
		
		
		
		
		
		
		
		
		
		
		
		
		 
     //ajax验证左右区域
    public function checkQuOK(){
        if($_POST['CheckType'] == 'CheckIsBDUser'){
            $member = M('member');
			$uinfo = $member->where(array('username'=>$_POST['username'],'status'=>1))->find();
            if (!$uinfo) {
                $data['result'] = 'nouser';
                echo json_encode($data);
            }else{
				  if($uinfo['left']==NULL && $uinfo['right']==NULL){
					  $data['html'] = 1;
				  }elseif($uinfo['left']==NULL && $uinfo['right']!=NULL){
					  $data['html'] = 2;
				  }elseif($uinfo['left']!=NULL && $uinfo['right']==NULL){
					  $data['html'] = 3;
				  }else{
					  $data['html'] = 4;
				  }				
                 $data['result'] = 'success';
                 $data['usernickname'] = $uinfo['nickname'];
                 echo json_encode($data);
            }
		 }
    }
    //ajax查询推荐人会员编号
    public function checkParent(){
		if(!IS_AJAX){
			halt("页面不存在!");
		}		
        //是否存在nouser
        $member = M('member');
        if (!$member->where(array('username'=>$_POST['username']))->getField('id')) {
            $data['result'] = 'nouser';
            echo json_encode($data);
        }
        //是否激活noactivation
        if (!$nickname = $member->where(array('username'=>$_POST['username'],'status'=>1))->getField('nickname')) {
            $data['result'] = 'noactivation';
            echo json_encode($data);
        }else{
            $data['result'] = 'success';
            $data['nickname'] = $nickname;
            echo json_encode($data);
        }
    }

    //ajax查询会员编号
    public function checkUsername(){
		if(!IS_AJAX){
			halt("页面不存在!");
		}
        if (!M('member')->where(array('username'=>$_POST['username']))->getField('id')) {
            $data['result'] = 'error';
            echo json_encode($data);
        }else{
            $data['result'] = 'success';
            echo json_encode($data);
        }
    }

		//ajax生成新会员编号
		public function createNewAccount(){
			if(!IS_AJAX){
				halt("页面不存在!");
			}			
			$rand=rand(100000,999999);
			$data['result'] = $rand;
			echo json_encode($data);
		}
    /**
     * 发送手机注册验证码
     */
    public function send_sms_reg_code(){
		
		
        $mobile = I('mobile');
		$verify=I('get.verify','','trim');
        if(!check_mobile($mobile))
            exit(json_encode(array('status'=>-1,'msg'=>'手机号码格式有误!')));
        
		if(empty($verify)){
			 exit(json_encode(array('status'=>-1,'msg'=>'请输入图形验证码!')));	
			
		}
		
		if($_SESSION['verify'] != md5($verify)) {
		   exit(json_encode(array('status'=>-1,'msg'=>'图形验证码错误!')));	
		}
		
		if (M('member')->where(array('mobile'=>$mobile))->getField('id')) {
          exit(json_encode(array('status'=>-1,'msg'=>'手机号码已存在!')));
        }		
        $code =  rand(1000,9999);
        $send = sms_log($mobile,$code,session_id());
        if($send['status'] != 1){
			 exit(json_encode(array('status'=>-1,'msg'=>$send['msg'])));
		}
        session('verify',null);   
		exit(json_encode(array('status'=>1,'msg'=>'验证码已发送，请注意查收')));
    }
    
	
	
	 /**
     * 发送手机注册验证码
     */
    public function send_sms_reg_code22(){
		
		
        $mobile = I('mobile');
		
        if(!check_mobile($mobile))
            exit(json_encode(array('status'=>-1,'msg'=>'手机号码格式有误!')));
        
		/*$result=M('member')->where(array('mobile'=>$mobile))->getField('id');
		
		if(empty($result)) {
          exit(json_encode(array('status'=>-1,'msg'=>'手机号码不存在!')));
        }*/		
        $code =  rand(1000,9999);
        $send = sms_log($mobile,$code,session_id());
        if($send['status'] != 1){
			 exit(json_encode(array('status'=>-1,'msg'=>$send['msg'])));
		}
        session('verify',null);   
		exit(json_encode(array('status'=>1,'msg'=>'验证码已发送，请注意查收')));
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	public function send_edit_code(){
        $mobile = I('mobile');
        if(!check_mobile($mobile))
            exit(json_encode(array('status'=>-1,'msg'=>'手机号码格式有误!')));		
        $code =  rand(1000,9999);
        $send = sms_log($mobile,$code,session_id());
        if($send['status'] != 1)
            exit(json_encode(array('status'=>-1,'msg'=>$send['msg'])));
        exit(json_encode(array('status'=>1,'msg'=>'验证码已发送，请注意查收')));
    }	


	public function notify(){
		
		header('Content-Type:text/html;charset=GB2312');
		
		$key	= '1b4186de07a34089a5aeaff73d6fe12d';
		$orderid        = trim($_GET['orderid']);
		$opstate        = trim($_GET['opstate']);
		$ovalue         = trim($_GET['ovalue']);
		$sign           = trim($_GET['sign']);
		$str = print_r($_GET,true);
		file_put_contents(PUBLIC_PATH."/success.txt",$str."\n", FILE_APPEND);
		
		$sign_text	= "orderid=$orderid&opstate=$opstate&ovalue=$ovalue".$key;
		$sign_md5 = md5($sign_text);
		
		$str = $sign_md5."####".md5($sign_text);
		file_put_contents(PUBLIC_PATH."/success.txt",$str."\n", FILE_APPEND);
		
		
		if($sign_md5 == $sign){
				//支付逻辑
				$recharge_info=M("member_recharge")->where("order_sn = '{$orderid}' and status = 0")->find();
				if(empty($recharge_info)){
					echo "opstate=-1";	
					header("location:" .U('Index/index/recharge'));	
					exit;
					
				}
				
				M("member_recharge")->where("order_sn = '{$orderid}' and status = 0")->save(array('status'=>1));
				$get_money=$ovalue*$recharge_info['bili'];
				M('member')->where("id = {$recharge_info['user_id']}")->setInc('jinbi',$get_money);
				$username=M('member')->where("id = {$recharge_info['user_id']}")->getField('username');
				account_log($username,$get_money,'充值',1,5);
				
				exit("opstate=0");		
			
		}else{
			
			exit("opstate=-2");		
		}
		
		
		
		
	}





	public function verify(){
		ob_clean();
        import('ORG.Util.Image');
        Image::buildImageVerify();
    }




    //ajax 图片上传
	
	public function uploads(){
	 
	  
	 
	if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
		
		
		$name = $_FILES['photoimg']['name'];
		$size = $_FILES['photoimg']['size'];

	   	$file_time=date('Ymd',time());
		$file_name = './Public/Uploads/voucher';
		if(!file_exists($file_name)){
			mkdir($file_name);
		}
	   	$path = $file_name.'/';

		$extArr = array("jpg", "png", "gif");
		if(empty($name)){
			echo json_encode(array('result' => 0,'msg'=>'请选择要上传的图片'));
			return;
			
		}
		$ext = $this->extend($name);
		if(!in_array($ext,$extArr)){
			echo json_encode(array('result' => 0,'msg'=>'图片格式错误'));
			return;
			
		}
		if($size>(100*1024)){
			echo json_encode(array('result' => 0,'msg'=>'图片大小不能超过300KB'));
			return;
			
		}
		$image_name = time().rand(100,999).".".$ext;
		$tmp = $_FILES['photoimg']['tmp_name'];
	
		$uploadip = substr($path,9);
		if(move_uploaded_file($tmp, $path.$image_name)){
			// echo '<img src="'.$uploadip.$image_name.'"  class="preview">';
			echo json_encode(array('result' => 1,'url'=>$uploadip.$image_name));
			return;
		}else{
			echo json_encode(array('result' => 0,'msg'=>'上传出错了'));
			return;
		}
		exit;
	}
	exit;

   }

	public function extend($file_name){
		$extend = pathinfo($file_name);
		$extend = strtolower($extend["extension"]);
		return $extend;
	}





}
?>