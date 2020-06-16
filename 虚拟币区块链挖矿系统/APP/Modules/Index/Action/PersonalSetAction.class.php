<?php

//个人设置控制器
Class PersonalSetAction extends CommonAction{

    //个人设置
    public function index(){
        $this->display();
    }

    //安全中心
    public function safe(){
        
        $member = M('member')->where(array('id'=>session('mid')))->find();
        $this->assign('member',$member);
        $this->display();
    }


    //设置二代密保
    public function setPwdProtection(){
        if (IS_AJAX) {
			$member = M('member');
			$data['question1'] = $question1 = I('post.question1','','strval');
			$data['answer1'] = $answer1 = I('post.answer1','','strval');
			$data['question2'] = $question2 = I('post.question2','','strval');
			$data['answer2'] = $answer2 = I('post.answer2','','strval');
			$data['question3'] = $question3 = I('post.question3','','strval');
			$data['answer3'] = $answer3 = I('post.answer3','','strval');
			$password2 = I('post.password2','','md5');
			$username = session('username');
            if (empty($question1)  || empty($question2) || empty($question3) ) {
				$this->ajaxReturn(array('info'=>'请选择密保问题'));
            }

            if (empty($answer1) || empty($answer2) || empty($answer3)) {
				$this->ajaxReturn(array('info'=>'请设置密保答案'));
            }

            if ($question1 == $question2 || $question1 == $question3 || $question2 == $question3 ) {
				$this->ajaxReturn(array('info'=>'密保问题不能相同'));
            }

            if (empty($password2)) {
				$this->ajaxReturn(array('info'=>'二级密码不能为空'));
            }

            //验证二级密码是否正确
           
            if (!$member->where(array('username'=>$username,'password2'=>$password2))->getField('id')) {
				$this->ajaxReturn(array('info'=>'二级密码不正确!'));
            }
            if ($member->where(array('username'=>$username))->save($data)) {
				$this->ajaxReturn(array('info'=>'密保设置成功','url'=>U('Index/PersonalSet/setPwdProtection')));	
            }
        }
        $qa = M('member')->where(array('username'=>session('username')))->getField('question1');
        if ($qa) {
            $pp = '已設置';
        }else{
            $pp = '未設置';
        }
        $this->assign('pp',$pp);		
        $this->display();
    }

    //个人资料
    public function myInfo(){
       $checkstatus = checkstatus();
        
		  if (IS_POST) {
			if($checkstatus){
				$this->error('不可更改!');
			}
            $data = array();
										
           $data['truename']     = I('post.truename','','htmlspecialchars');
		   $data['shenfen']     = I('post.shenfen','','htmlspecialchars');
		   $data['idcard']     = I('post.idcard','','htmlspecialchars');
            if (empty($data['truename'])) {
				$this->error('请填写真实姓名');
            }	

            if (empty($data['shenfen'])) {
				//$this->ajaxReturn(array('info'=>'请填写支付宝账户名!'));
				$this->error('请填写身份证号');
            }	
			if (empty($data['idcard'])) {
				//$this->ajaxReturn(array('info'=>'请填写支付宝账户!'));
				$this->error('请填写银行卡号');
            }	
			
			if(isset($_POST['alipay_voucher'])){
					$data['alipay_voucher']     = I('post.alipay_voucher','','htmlspecialchars');
					 if (empty($data['alipay_voucher'])) {
						$this->error('请上传转账凭证');
           			 }	
			}

			
			
			$data['level'] = 0;
			$data['checkstatus'] = 0;
			$data['bzjstatus'] = 0;
            if (M('member')->where(array('username'=>session('username')))->save($data)) {
                //$this->ajaxReturn(array('info'=>'保存成功','url'=>U('Index/PersonalSet/myInfo')));
				
				//奖励一个旷工
				//reg_jl(session('mid'));
				
				//$this->success('保存成功,请等待管理员审核！',U('Index/Shop/plist'));
				$this->success('资料提交成功,请尽快支付！',U('Index/PersonalSet/myInfo'));
				exit;
				
            }else{
                //$this->ajaxReturn(array('info'=>'数据无变化','url'=>U('Index/PersonalSet/myInfo')));
				$this->error('数据无变化',U('Index/PersonalSet/myInfo'));
            }
          }      
        
        $memmber = M('member')->where(array('id'=>session('mid')))->find();
        $country = M("country")->order("id desc")->select();
		$this->assign('checkstatus',$checkstatus);
		$this->assign('country',$country);
        $this->assign('memmber',$memmber);
        $this->display();
    }
	
    //二级密码验证
    public function chekcpwd2(){

    }

    //修改密码
    public function updatePass(){
		 if (IS_AJAX) {
			 $old_password = I('post.old_password','','strval');
			 if(empty($old_password)){
				 $this->ajaxReturn(array('result'=>0,'info'=>'原密码不能为空!'));
			 }
			 $typeid = I('post.typeid',0,'intval');
			 if (!in_array($typeid,array(1,2))) {
				 $this->ajaxReturn(array('result'=>0,'info'=>'参数错误!'.$typeid));
			 }
			 
			 $db = M('member');
			//二级密码验证
			if ($typeid==1) {
				$newpwd = I('post.newpwd','','strval');
				$newpwd1 = I('newpwd1','','strval');
				if (empty($newpwd)  || empty($newpwd1)) {
					$this->ajaxReturn(array('result'=>0,'info'=>'新登陆密码或确认密码不能为空'));
				}
				if(!preg_match("/^[a-zA-Z\d_]{6,}$/",I('post.newpwd'))){
					$this->ajaxReturn(array('result'=>0,'info'=>'新密码长度不能小于6位!'));
				}
				if ($newpwd !=$newpwd1) {
					$this->ajaxReturn(array('result'=>0,'info'=>'两次密码输入不一样!'));
				}				
				$where = array('id'=>session('mid'));
				$old = $db->where($where)->getField('password');
				if ($old != MD5($old_password)) {
					$this->ajaxReturn(array('result'=>0,'info'=>'原登陆密码错误'));
				}
				if ($db->where($where)->save(array('password'=>MD5($newpwd)))) {
					$this->ajaxReturn(array('result'=>1,'info'=>'登陆密码修改成功','url'=>U('Index/PersonalSet/updatePass')));
				}else{
					$this->ajaxReturn(array('result'=>0,'info'=>'登陆密码修改失败','url'=>U('Index/PersonalSet/updatePass')));
				}
			}
			if ($typeid==2) {
				$oldpwd2 = I('post.oldpwd2','','strval');
				$newpwd2 = I('newpwd2','','strval');
				if (empty($oldpwd2)  || empty($newpwd2)) {
					$this->ajaxReturn(array('result'=>0,'info'=>'新安全码或确认密码不能为空'));
				}
				if(!preg_match("/^[a-zA-Z\d_]{6,}$/",I('post.oldpwd2'))){
					$this->ajaxReturn(array('result'=>0,'info'=>'新安全码长度不能小于6位!'));
				}				
				if ($oldpwd2 !=$newpwd2) {
					$this->ajaxReturn(array('result'=>0,'info'=>'两次输入的安全码不一样!'));
				}					
				$where = array('id'=>session('mid'));
				$old = $db->where($where)->getField('password2');
				if ($old != MD5($old_password)) {
					$this->ajaxReturn(array('result'=>0,'info'=>'原安全码错误'));
				}
				if ($db->where($where)->save(array('password2'=>MD5($oldpwd2)))) {
					$this->ajaxReturn(array('result'=>1,'info'=>'安全码修改成功','url'=>U('Index/PersonalSet/updatePass')));
				}else{
					$this->ajaxReturn(array('result'=>0,'info'=>'安全码修改失败','url'=>U('Index/PersonalSet/updatePass')));
				}
			}
		}
        $this->display();
    }



    //修改个人资料
    public function updateUserInfo(){
        if (IS_POST) {
            $data = array();
            $data['mobile'] = I('post.mobile');
            $data['qq']     = I('post.qq');
            if (M('member')->where(array('username'=>session('username')))->save($data)) {
                alert('保存成功',U('Index/PersonalSet/updateUserInfo'));
            }else{
                alert('数据无变化',U('Index/PersonalSet/updateUserInfo'));
            }
        }
        $memmber = M('member')->where(array('id'=>session('mid')))->find();
        $name = $memmber['truename'];
        $name = substr_cn($name,0,2);
        $this->assign('name',$name);
        $mobile = $memmber['mobile'];
        $this->assign('mobile',$mobile);

        $qq = $memmber['qq'];
        $this->assign('qq',$qq);
        $this->display();
    }



    //绑定邮箱
    public function bindEmail(){
        if (isset($_POST['email'])) {
            $member = M('member');

            if ($member->where(array('username'=>$_POST['username'],'email'=>$_POST['email']))->getField('id')) {
                alert('您的帳號已綁定安全郵箱！',U('Index/PersonalSet/bindEmail'));
            }

            if ($member->where(array('username'=>$_POST['username'],'token'=>$_POST['emailcode']))->getField('id')) {
                $member->where(array('username'=>$_POST['username']))->setField('email',$_POST['email']);
                alert('綁定成功！您的帳號已綁定安全郵箱！',U('Index/PersonalSet/myInfo'));
            }else{
                alert('邮箱验证码不正确！',U('Index/PersonalSet/bindEmail'));
            }
        }
        $this->display();
    }

    //异步验证邮箱验证码是否正确
    public function checkEmailCode(){
        $username = $_POST['username'];
        $emailcode = $_POST['emailcode'];
        if (M('member')->where(array('username'=>$username,'token'=>$emailcode))->getField('id')) {
            echo json_encode(array('result'=>'success'));
        }else{
            echo json_encode(array('result'=>'error'));
        }
    }

	
	//会员自助升级
	public function updatelevel(){
		//当前会员信息
		$info = M('member')->where(array('id'=>session('mid')))->find();
		//当前会员组信息
		$member_group = M('member_group')->where(array('level'=>$info['level']))->find();
		$member = M('member');
		if(IS_POST){
			$level = I('post.level','0','intval');
			if($level==0){
				$this->ajaxReturn(array('info'=>'请选择会员等级!'));				
			}
			//查询提交的会员组信息是否存在
			$member_group2 = M('member_group')->where(array('level'=>$level))->find();
			if(empty($member_group2)){
				$this->ajaxReturn(array('info'=>'会员组不存在!请确认!'));								
			}
			//不能降级
			if($member_group['level'] > $member_group2['level']){
                 $this->ajaxReturn(array('info'=>'会员组不存在!请确认!'));					
			}
			$outmoney = $member_group2['money'] - $member_group['money'];//差价
			if($info['jinbi']<$outmoney){
				$this->ajaxReturn(array('info'=>'电子币余额不足!'));						
			}	
            $parent = $info['parent'];	
            $member->startTrans();			

			//扣除金额
			$res1 = $member->where(array('username'=>$info['username']))->setDec('jinbi',$outmoney);  
           //更新会员等级
		    if($info['ji']>=1){
				$ji =$info['ji'];
			}else{
				$ji =1;
			}
			
			$res2 = $member->where(array('id'=>session('mid')))->save(array('level'=>$level,'ji'=>$ji));		
            if($res1 && $res2){		
			    $member->commit();
                //当前会员升级扣除明细
			    account_log($info['username'],$outmoney,$member_group['name'].'升级为'.$member_group2['name'],0,11);	
			    //推荐奖 
				$tjj  = cxmoney($outmoney * 0.01 * C("TJJ"));  
				$member->where(array('username'=>$parent))->setInc('jinbi',$tjj[0]);
				account_log($parent,$tjj[0],'直接增员奖,来自会员:'.$info['username'].'升级',1,1);		
				$member->where(array('username'=>$parent))->setInc('point',$tjj[1]);
				account_log3($parent,$tjj[1],'直接增员奖,来自会员:'.$info['username'].'升级',1,1);	
				
				$ffid = fl_top_fid($info['fparent'],1);
		        $ffid = explode(",",$ffid);	
		        $old = array();
			    $ffid_new= array();
				foreach($ffid as $key=>$val){
				   $muceng = array();
				   $u = M('member')->where(array('username'=>$val))->find();
				   $c1 =get_ceng($info['username']);
				   $c2 =get_ceng($val);
				   
				   $old[$val][]= $u['leftpeng'];
				   $old[$val][]= $u['rightpeng'];
				   $old[$val][]= $c1 - $c2;
				   
				   if($key==0){
					   if($u['left']==$info['username']){
						   $ffid_new[$key]['username'] = $val;
						   $ffid_new[$key]['weizhi'] = 'left';
					   }elseif($u['right']==$info['username']){
						   $ffid_new[$key]['username'] = $val;
						   $ffid_new[$key]['weizhi'] = 'right';					   
					   }
				   }else{
					   if($u['left']==$ffid_new[$key-1]['username']){
						   $ffid_new[$key]['username'] = $val;
						   $ffid_new[$key]['weizhi'] = 'left';
					   }elseif($u['right']==$ffid_new[$key-1]['username']){
						   $ffid_new[$key]['username'] = $val;
						   $ffid_new[$key]['weizhi'] = 'right';					   
					   }				   
				   }
				}	

			//写入安置统计
			   foreach($ffid_new as $key=>$val){
					$o = M('member')->where(array('username'=>$val['username'],'status'=>1))->find();
					//左
					if($o['left']!=null && $val['weizhi']=='left'){
						$memberinfo =  M('member')->field('left')->where(array('username'=>$o['left'],'status'=>1))->find();
						if(!empty($memberinfo)){
							//业绩统计
							M("member")->where(array('username'=>$val['username']))->setInc('leftpro',$outmoney);
							M("member")->where(array('username'=>$val['username']))->setInc('countpro',$outmoney);
							M("member")->where(array('username'=>$val['username']))->setInc('leftpeng',$outmoney);
							M("member")->where(array('username'=>$val['username']))->setInc('countpeng',$outmoney);						
						}			
					}			
					//右
					if($o['right']!=null && $val['weizhi']=='right'){
						$memberinfo =  M('member')->field('right')->where(array('username'=>$o['right'],'status'=>1))->find();
						if(!empty($memberinfo)){
							//业绩统计
							M("member")->where(array('username'=>$val['username']))->setInc('rightpro',$outmoney);
							M("member")->where(array('username'=>$val['username']))->setInc('countpro',$outmoney);	
							M("member")->where(array('username'=>$val['username']))->setInc('rightpeng',$outmoney);
							M("member")->where(array('username'=>$val['username']))->setInc('countpeng',$outmoney);							
						}			
					}			
			   }	
			   
				$new = array();	
				            //见点奖
            $jd = C("JD");	
				foreach($ffid as $key=>$val){
					   $u = M('member')->where(array('username'=>$val))->find();
					   $c1 = get_ceng($info['username']);
					   $c2 = get_ceng($val);
					   $new[$val][]= $u['leftpeng'];
					   $new[$val][]= $u['rightpeng'];
					   $new[$val][]= $c1 - $c2;	
					//见点奖
				   if($key < C("JD_CENG")){
					       $jd_money = cxmoney($jd * 0.01 * $outmoney);			  
						   $member->where(array('username'=>$val))->setInc('jinbi',$jd_money[0]);
						   account_log($val,$jd_money[0],'间推奖,来自会员：'.$info['username'].'升级',1,3);	
						   $member->where(array('username'=>$val))->setInc('point',$jd_money[1]);
						   account_log3($val,$jd_money[1],'间推奖,来自会员：'.$info['username'].'升级',1,3);						   
                   } 
                   //会员自动升级
				   $newArr = groupname($val);
				   $j = 0;
                   if($u['ji']==0){
					     if($u['parentcount']==3){
							 $member->where(array('username'=>$val))->save(array('ji'=>1));
						 }
				   }elseif($u['ji']==1){
					   
			             if(in_array(1,$newArr[0]) && in_array(1,$newArr[1])){
						     $member->where(array('username'=>$val))->save(array('ji'=>2));				 
						 }	
     
				   }elseif($u['ji']==2){
					   
                         if(in_array(2,$newArr[0]) && in_array(2,$newArr[1])){
							 $member->where(array('username'=>$val))->save(array('ji'=>3));
						 }		
						 
				   }elseif($u['ji']==3){
					   
                         if(in_array(3,$newArr[0]) && in_array(3,$newArr[1])){
							 $member->where(array('username'=>$val))->save(array('ji'=>4));
						 }		
				   
				   }elseif($u['ji']==4){
					   
                         if(in_array(4,$newArr[0]) && in_array(4,$newArr[1])){
							 $member->where(array('username'=>$val))->save(array('ji'=>5));
						 }	
						 
				   }elseif($u['ji']==5){
					   
                         if(in_array(5,$newArr[0]) && in_array(5,$newArr[1])){
							 $member->where(array('username'=>$val))->save(array('ji'=>6));
						 }		
						 
				   }elseif($u['ji']==6){
					   
                         if(in_array(6,$newArr[0]) && in_array(6,$newArr[1])){
							 $member->where(array('username'=>$val))->save(array('ji'=>7));
						 }			
						 
				   }				   
				}
							//返回左右位置
				$weizhi = array();
				foreach($new as $k=>$v){
					if($new[$k][0] > $old[$k][0]){
						$weizhi[$k][] = 'left';//位置
						$weizhi[$k][] = $v[2]; //层
					}elseif($new[$k][1] > $old[$k][1]){
						$weizhi[$k][] = 'right';//位置
						$weizhi[$k][] = $v[2];//层
					}
					
				}	
       	   //管理奖
		   $ldj = array(0,C("PY1"),C("PY2"),C("PY3"),C("PY4"),C("PY5"),C("PY6"),C("PY7"),1);			
	       //量碰
		   foreach($weizhi as $k=>$v){
			   $uw = M('member')->where(array('username'=>$k))->find();
			   $newArr = groupname($k);
			   $newArr = array_merge($newArr[0],$newArr[1]);
			   rsort($newArr);				   
			   if($v[0]=='left'){
				       if($uw['rightpeng']!=0 && $uw['ji']>=1){
				              if($uw['leftpeng']>$uw['rightpeng']){
									   $dpmoney = $uw['rightpeng'];
							  }elseif($uw['leftpeng']==$uw['rightpeng']){
									   $dpmoney = $uw['rightpeng'];
							  }elseif($uw['leftpeng']<$uw['rightpeng']){
									   $dpmoney = $uw['leftpeng'];
							  }	
                              if($newArr[0] >= $uw['ji']){
								  $dpj = $dpmoney * $ldj[8] * 0.01;			
							  }else{
								  $dpj = $dpmoney * $ldj[$uw['ji']] * 0.01;
							  }							  
                              				   
							  if($dpj!=0){
								   $dpj = cxmoney($dpj);
								   //奖金
								   $member->where(array('username'=>$k))->setInc('jinbi',$dpj[0]);
								   account_log($k,$dpj[0],'管理奖,来自会员:'.$info['username'].'升级',1,4);	
								   $member->where(array('username'=>$k))->setInc('point',$dpj[1]);
								   account_log3($k,$dpj[1],'管理奖,来自会员:'.$info['username'].'升级',1,4);									   
								   $member->where(array('username'=>$k))->setDec('rightpeng',$dpmoney);
								   $member->where(array('username'=>$k))->setDec('leftpeng',$dpmoney);
								   $member->where(array('username'=>$k))->setDec('countpeng',$dpmoney*2);								   
							  }							
						 
					   }
 				   
			   }elseif($v[0]=='right'){
					   if($uw['leftpeng']!=0 && $uw['ji']>=1){
							  if($uw['leftpeng']>$uw['rightpeng']){
									   $dpmoney = $uw['rightpeng'];
							  }elseif($uw['leftpeng']==$uw['rightpeng']){
									   $dpmoney = $uw['rightpeng'];
							  }elseif($uw['leftpeng']<$uw['rightpeng']){
									   $dpmoney = $uw['leftpeng'];
							  }		
                              if($newArr[0] >= $uw['ji']){
								  $dpj = $dpmoney * $ldj[8] * 0.01;			
							  }else{
								  $dpj = $dpmoney * $ldj[$uw['ji']] * 0.01;
							  }						   						   
							  if($dpj!=0){
								   $dpj = cxmoney($dpj);
								   //奖金
								   $member->where(array('username'=>$k))->setInc('jinbi',$dpj[0]);
								   account_log($k,$dpj[0],'管理奖,来自会员:'.$info['username'].'升级',1,4);	
								   $member->where(array('username'=>$k))->setInc('point',$dpj[1]);
								   account_log3($k,$dpj[1],'管理奖,来自会员:'.$info['username'].'升级',1,4);
								   $member->where(array('username'=>$k))->setDec('rightpeng',$dpmoney);
								   $member->where(array('username'=>$k))->setDec('leftpeng',$dpmoney);
								   $member->where(array('username'=>$k))->setDec('countpeng',$dpmoney*2);								   
							 }								
					   }
							   
			  }
			  
			 
		   }		

		   
			}else{
			        $member->rollback();
			}	
			$this->ajaxReturn(array('info'=>'会员升级成功!','url'=>U('Index/PersonalSet/updatelevel')));		
		}
		$info['groupname'] = $member_group['name'];
		$level = $member_group['level'];
		//查询剩余可升等级
		$list = M('member_group')->where("`status`=1 AND `level`> $level")->select();
		foreach($list as $k=>$v){
			  $list[$k]['cha'] = $v['money'] - $member_group['money'];
			
		}
		$this->assign('list',$list);				
		$this->assign('info',$info);		
		$this->display();
	}		
    //异步发送验证码
    public function seedCode(){
        $email  = $_POST['email'];
        $member = $_POST['username'];
        $token  = randStr(8,'NUMBER');
        //token写入数据库
        M('member')->where(array('id'=>session('mid')))->setField('token',$token);
        $this->sendmail($email,$member,'FC绑定邮箱验证码',$token);
    }
	public function semcode(){
		
		$this->display();
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
		if($size>(300*1024*1024)){
			echo json_encode(array('result' => 0,'msg'=>'图片大小不能超过3M'));
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

	public function pay(){
		$member = M('member')->where(array('id'=>session('mid')))->find();
        $this->assign('member',$member);
		$this->display();
	}
	
	public function order(){
		date_default_timezone_set('PRC');
		$pay_id = $_GET['id'];
		$price = (float)$_GET['money'];
		$param = empty($_GET['module'])?'PersonalSet':$_GET['module'];
		$type = (int)$_GET['type'];

		$codepay_config['id'] = '58441';
		$codepay_config['key'] = 'mIeYozlvjN5l7waWjIMNtQcrrDnWEsx2';
		$codepay_config['chart'] = strtolower('utf-8');
		header('Content-type: text/html; charset=' . $codepay_config['chart']);
		//是否启用免挂机模式 1为启用. 未开通请勿更改否则资金无法及时到账
		$codepay_config['act'] = "0"; //认证版则开启 一般情况都为0
		$codepay_config['page'] = 4; //支付页面展示方式
		$codepay_config['style'] = 1;
		//二维码超时设置  单位：秒
		$codepay_config['outTime'] = 360;//360秒=6分钟 最小值60  不建议太长 否则会影响其他人支付
      	$codepay_config['min'] = 0.01;
		$codepay_config['pay_type'] = 1;
		define('HTTPS', false);  //是否HTTPS站点 false为HTTP true为HTTPS
		$codepay_config['host'] = ($this->isHTTPS() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'];
		$codepay_config['path'] = $codepay_config['host'] . dirname($_SERVER['REQUEST_URI']); //API安装路径 最终为http://域名/codepay
		$codepay_path = $codepay_config['path']; //资源存放路径
		$codepay_config['return_url'] = "http://kj.ekaabb.com.cn/codepay/notify.php"; //自动生成跳转地址
      	$codepay_config['go_time'] = 3;
      	$codepay_config['go_url'] =  $_SERVER[''] == '80' ? '/' : '//'.$_SERVER['SERVER_NAME'];
		$codepay_config['notify_url'] = "http://kj.ekaabb.com.cn/index.php/index/personal_set/notify"; //自动生成通知地址 优先级最高不传入则为系统设置里设置
		
      	//$time = time();
      	//$sql="INSERT INTO `codepay_order` (`pay_id`, `money`, `price`, `type`, `param`, `pay_tag`, `status`, `creat_time`)values($pay_id,$price,$price,$type,'$param','保证金',0,$time)";
      	//M()->execute($sql);
      	//$orderid = M()->getLastInsID();
      	
      
		//构造要请求的参数数组，无需改动
      	$parameter = array(
            "id" => (int)$codepay_config['id'],//平台ID号
            "type" => $type,//支付方式
            "price" => (float)$price,//原价
            "pay_id" => $pay_id, //可以是用户ID,站内商户订单号,用户名
            "param" => $param,//自定义参数
            "act" => (int)$codepay_config['act'],//此参数即将弃用
            "outTime" => (int)$codepay_config['outTime'],//二维码超时设置
            "page" => (int)$codepay_config['page'],//订单创建返回JS 或者JSON
            "return_url" => $codepay_config["return_url"],//付款后附带加密参数跳转到该页面
            "notify_url" => $codepay_config["notify_url"],//付款后通知该页面处理业务
            "style" => (int)$codepay_config['style'],//付款页面风格
            "pay_type" => $codepay_config['pay_type'],//支付宝使用官方接口
            "user_ip" => $this->getIp(),//付款人IP
            "qrcode_url" => $codepay_config['qrcode_url'],//本地化二维码
            "chart" => trim(strtolower($codepay_config['chart']))//字符编码方式
            //其他业务参数根据在线开发文档，添加参数.文档地址:https://codepay.fateqq.com/apiword/
            //如"参数名"=>"参数值"
        );
      
      	$back = $this->create_link($parameter, $codepay_config['key']);
      
      	switch ((int)$type) {
            case 1:
                $typeName = '支付宝';
                break;
            case 2:
                $typeName = 'QQ';
                break;
            default:
                $typeName = '微信';
        }
      	//准备传给前端输出的JSON
		$user_data = array("return_url" => $parameter["return_url"],
   	 		"type" => $parameter['type'], "outTime" => $parameter["outTime"], "codePay_id" => $parameter["id"], "logoShowTime" => 2);
      	$user_data["qrcode_url"] = $codepay_config["qrcode_url"];
      	$user_data["logoShowTime"] = 2;
      
      	if ($parameter['page'] != 3) { //只要不为3 返回JS 就去服务器加载资源
            $parameter['page'] = "4"; //设置返回JSON
            $back = $this->create_link($parameter, $codepay_config['key'],$codepay_config['gateway']); //生成支付URL
            if (function_exists('file_get_contents')) { //如果开启了获取远程HTML函数 file_get_contents
                $codepay_json = file_get_contents($back['url']); //获取远程HTML
            } else if (function_exists('curl_init')) {
                $ch = curl_init(); //使用curl请求
                $timeout = 5;
                curl_setopt($ch, CURLOPT_URL, $back['url']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
                $codepay_json = curl_exec($ch);
                curl_close($ch);
            }
        }

        if (empty($codepay_json)) { //如果没有获取到远程HTML 则走JS创建订单
            $parameter['call'] = "callback";
            $parameter['page'] = "3";
            $back = $this->create_link($parameter, $codepay_config['key'],'https://codepay.fateqq.com/creat_order/?');
            $codepay_html = '<script src="' . $back['url'] . '"></script>'; //JS数据
        } else { //获取到了JSON
            $codepay_data = json_decode($codepay_json);
            $qr = $codepay_data ? $codepay_data->qrcode : '';
            $codepay_html = "<script>callback({$codepay_json})</script>"; //JSON数据
        }
		
		$this->assign('typeName',$typeName);
		$this->assign('type',$type);
		$this->assign('price',$price);
		$this->assign('user_data',json_encode($user_data));
		$this->assign('codepay_html',$codepay_html);
		$this->display();
	}
	
	//主动判断是否HTTPS
	public function isHTTPS()
	{
	    if (defined('HTTPS') && HTTPS) return true;
	    if (!isset($_SERVER)) return FALSE;
	    if (!isset($_SERVER['HTTPS'])) return FALSE;
	    if ($_SERVER['HTTPS'] === 1) {  //Apache
	        return TRUE;
	    } elseif ($_SERVER['HTTPS'] === 'on') { //IIS
	        return TRUE;
	    } elseif ($_SERVER['SERVER_PORT'] == 443) { //其他
	        return TRUE;
	    }
	    return FALSE;
	}
	
	public function getIp()
	{ //取IP函数
	    static $realip;
	    if (isset($_SERVER)) {
	        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
	            $realip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	        } else {
	            $realip = isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : $_SERVER['REMOTE_ADDR'];
	        }
	    } else {
	        if (getenv('HTTP_X_FORWARDED_FOR')) {
	            $realip = getenv('HTTP_X_FORWARDED_FOR');
	        } else {
	            $realip = getenv('HTTP_CLIENT_IP') ? getenv('HTTP_CLIENT_IP') : getenv('REMOTE_ADDR');
	        }
	    }
	    return $realip;
	}
  
  	public function create_link($params, $codepay_key, $host = "")
    {
        ksort($params); //重新排序$data数组
        reset($params); //内部指针指向数组中的第一个元素
        $sign = '';
        $urls = '';
        foreach ($params AS $key => $val) {
            if ($val == '') continue;
            if ($key != 'sign') {
                if ($sign != '') {
                    $sign .= "&";
                    $urls .= "&";
                }
                $sign .= "$key=$val"; //拼接为url参数形式
                $urls .= "$key=" . urlencode($val); //拼接为url参数形式
            }
        }

        $key = md5($sign . $codepay_key);//开始加密
        $query = $urls . '&sign=' . $key; //创建订单所需的参数
        $apiHost = ($host ? $host : "http://api2.fateqq.com:52888/creat_order/?"); //网关
        $url = $apiHost . $query; //生成的地址
        return array("url" => $url, "query" => $query, "sign" => $sign, "param" => $urls);
    }
	
	
	public function notify(){
      exit('success');
    }

















}

?>