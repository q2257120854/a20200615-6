<?php  
	
	/**
	 * 会员前台登录控制器
	 */
	Class LoginAction extends Action{

			public function _initialize(){
				//判断是否关闭了网站
				$open_web=C('open_web');
				if(empty($open_web)){
					$this->open_web_notice=C('open_web_notice');
					$this->display('Index:404');
					exit;
				}	
				
			}
		
		
		
		/**
		 * 会员登录视图
		 * @return [type] [description]
		 */
		public function index(){
			
				
				
				
				
				if(IS_AJAX){
					
					    if(I('lang')==2){
							$this->ajaxReturn(array('result'=>'0','info'=>'请切换英文语言环境！'));				
						}
						//验证系统是否为开放状态
						if (C('MEMBER_LOGIN') == 'off') {
							$this->ajaxReturn(array('result'=>'0','info'=>'系统暂未开放！'));					
						}
						
						if (I('username')=="" || I('password')=="") {
							$this->ajaxReturn(array('result'=>'0','info'=>'用户名和密码不能为空！'));			
						}
						
						
						$verify=I('post.verify','','trim');
						if(empty($verify)){
								
								 $this->ajaxReturn(array('result'=>'-1','info'=>'请输入图形验证码！'));			
								 	
			
						}
		
							if($_SESSION['verify'] != md5($verify)) {
							   
							   $this->ajaxReturn(array('result'=>'-1','info'=>'图形验证码错误！'));			
							   
							}
						
						
						$model_m = M('member');
						//验证用户名和密码
						$member = $model_m->where(array('username'=>I('username'),'password'=>I('password','','md5')))->find();
						if(!$member){
							$this->ajaxReturn(array('result'=>'0','info'=>'用户名或密码错误!'));								
						}
						
						//禁止死点会员登录
						// if ($tree_obj->chkState($member['status'],'D') && $tree_obj->lock_D_login) {
						// 	$this->error('请联系管理员审核后再试!');
						// }
						if(!$member['status']){
							$this->ajaxReturn(array('result'=>'0','info'=>'抱歉！您的账户还未激活，请联系推荐人激活!'));									
						}			

						//禁止锁定会员登录
						if($member['lock']){
							$this->ajaxReturn(array('result'=>'0','info'=>'您的账号已经被锁定!联系客服'));			
						}				
						
						//更新上一次IP和登录时间
						$prologin['preloginip']      = $member['loginip'];
						$prologin['preloginaddress'] = '';
						$prologin['prelogintime']    = $member['logintime'];

						$model_m->where(array('id'   =>$member['id']))->save($prologin);
						//更新最后一次登录的IP和登录时间
						//$area = $Ip->getlocation(get_client_ip());
						//$area = get_ip_address(get_client_ip());
			  
						$data = array(
							'id'           => $member['id'],
							'logintime'    => time(),
							'loginip'      => '',
							'loginaddress' => ''
						);
						$model_m->save($data);

						//添加登录总次数
						$model_m->where(array('username'=>I('username')))->setInc('logincount'); 
						//保存session
						session('mid',$member['id']);
						session('username',$member['username']);
						session('member','memberlogin');
						
						$remember=I("post.remember",0,'intval');
						$mypassword=I('post.password');
						if(!empty($remember)){
							setcookie('rememberusername', $member['username'], time() + 3600 * 24 * 30);  
           					setcookie('rememberpassword', $mypassword, time() + 3600 * 24 * 30);  
								
						}else{
							setcookie('rememberusername', null, time() - 3600 * 24 * 30);  
           					setcookie('rememberpassword', mull, time() - 3600 * 24 * 30);  
								
						}
						
						//添加日志操作
						//$desc = '会员['.session('username').']登录';
						//write_log(session('username'),'member',$desc);
						if($member['level']==0){
							$this->ajaxReturn(array('result'=>'1','info'=>'登陆成功,完善资料认证通过即送矿机！','url'=>U('Index/PersonalSet/myInfo')));
						}else{
							$this->ajaxReturn(array('result'=>'1','info'=>'登陆成功！','url'=>U('Index/Emoney/shouye')));
								
						}
						
						
						
								 					
					
				}else{
					
					$rememberusername=$_COOKIE['rememberusername'];
					$rememberpassword=$_COOKIE['rememberpassword'];
					if(!empty($_COOKIE['rememberusername'])){
						$rememberusername=$_COOKIE['rememberusername'];
					}
					if(!empty($_COOKIE['rememberpassword'])){
						$rememberpassword=$_COOKIE['rememberpassword'];
					}
					
					$this->assign('rememberusername',$rememberusername);
					$this->assign('rememberpassword',$rememberpassword);
					$this->display();
				}
			 	

			
		}

	
	
	
	
	
	
	
	
	
		//注册推广
		 public function register(){
		
			$this->display();			 
		 }
		 
		
	//注册推广
		 public function registerpost(){
			 
			 if (IS_AJAX) {
						  
				$username=I('post.username','','intval');
				
				if(empty($username)){
					$this->ajaxReturn(array('result'=>0,'info'=>'推荐人不能为空!'));
				}
				$data['parent']=$username;
				$data['parent_id']=M('member')->where(array('username'=>$username))->getField('id');

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
				if (!M('member')->where(array('username'=>$username,'level'=>1))->getField('id')) {
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
	
	
	
	
	
	
	
	
	
	
	
	
//计算奖金
    public function compute(){
        //结算前先备份数据库
        $DataDir = RUNTIME_PATH.'databak/';
        import("ORG.Util.MySQLReback");
        $config = array(
            'host' => C('DB_HOST'),
            'port' => C('DB_PORT'),
            'userName' => C('DB_USER'),
            'userPassword' => C('DB_PWD'),
            'dbprefix' => C('DB_PREFIX'),
            'charset' => 'UTF8',
            'path' => $DataDir,
            'isCompress' => 0, //是否开启gzip压缩
            'isDownload' => 0  
        );
        $mr = new MySQLReback($config);
        $mr->setDBName(C('DB_NAME'));
        $mr->backup();
        //添加日志操作
        $desc = '备份数据库';
        write_log(session('username'),'admin',$desc);
       //备份完成
    }
		/**
		 * 生成验证码
		 */
		public function verify(){
			import('ORG.Util.Image');
			Image::buildImageVerify(4,1,'png',55,25);
		}

		public function showcode(){
			$this->display();
		}
        
        //验证码验证
        public function checkVerify($code){
            if (session('verify') != $code) {
                alert('验证码错误',-1);
            }
        }
        
        public function checkUsername($username){
            if (!$id = M('member')->where(array('username'=>$username))->getField('id')) {
                alert('您输入的会员账号不存在！',-1);
            }else{
                return $id;
            }
        }

        //找回密码
        public function findpwd(){
            if (IS_POST) {
                header("Content-type:text/html;charset=utf-8");
                $username = I('post.username','','strval');
                $code = I('post.code','','md5');
                if ($username == '' || $code == '') {    
                    alert('请输入您的会员编号或验证码!',-1);
                }else{
                    $this->checkVerify($code);
                    $this->checkUsername($username);
                    alert('验证通过!',U(GROUP_NAME.'/Login/checkQuestion',array('u'=>$username)));
                }
            }
            $this->display();
        }
        //验证密保问题
        public function checkQuestion(){
            header("Content-type:text/html;charset=utf-8");
            if (IS_POST) {
                $answer1 = I('post.answer1','','strval');
                $answer2 = I('post.answer2','','strval');
                $answer3 = I('post.answer3','','strval');
                $username  = I('post.username','','strval');
                $where = array();
                $where['answer1'] = $answer1;
                $where['answer2'] = $answer2;
                $where['answer3'] = $answer3;
                $where['username'] = $username;
                if (M('member')->where($where)->getField('id')) {
                    alert('密保验证通过!',U(GROUP_NAME.'/Login/editPwd',array('u'=>$username)));
                }else{
                    alert('抱歉！您輸入的密保答案不正確！',-1);
                }
            }
            if (isset($_GET['u'])) {
                $username = I('get.u','','strval');
                $info = M('member')->where(array('username'=>$username))->find();
                $this->assign('info',$info);
            }
            $this->display();
        }
        
        //修改密码
        public function editPwd(){
            header("Content-type:text/html;charset=utf-8");
            if (IS_POST) {
				$mobile = I('post.mobile','','strval');
				
				if(!preg_match("/^(1)[0-9]{10}$/",$mobile)){
					$this->ajaxReturn(array('info'=>'手机号码格式不正确!'));
				}			
				if (!M('member')->where(array('mobile'=>trim($mobile)))->getField('id')) {
					$this->ajaxReturn(array('info'=>'手机号不存在，请确认！'));
				}				
				$code = I('post.code','');
				if(!$code){
					$this->ajaxReturn(array('info'=>'请输入短信验证码!'));				
				}	
                $check_code = sms_code_verify($mobile,$code,session_id());				
				if($check_code['status'] != 1){
					$this->ajaxReturn(array('info'=>$check_code['msg']));					
				}					
                $password = I('post.password','','md5');
                $password1 = I('post.password1','','md5');
                
                if ($password != $password1) {
					$this->ajaxReturn(array('info'=>'密码和确认密码不一致！'));
                }
                //开始修改密码
                $data = array();
                $data['password'] = $password;
                M('member')->where(array('username'=>$mobile))->save($data);
				$this->ajaxReturn(array('info'=>'密码重置成功！','url'=>U('Index/Login')));
            }
            $this->display();
        }
		
		
		
		  //修改密码
        public function editPwd2(){
            header("Content-type:text/html;charset=utf-8");
            if (IS_AJAX) {
				$mobile = I('post.mobile','','strval');
				
				if(!preg_match("/^(1)[0-9]{10}$/",$mobile)){
					$this->ajaxReturn(array('result'=>'0','info'=>'手机号码格式不正确!'));
				}			
				if (!M('member')->where(array('mobile'=>trim($mobile)))->getField('id')) {
					$this->ajaxReturn(array('result'=>'0','info'=>'手机号不存在，请确认！'));
				}				
				$code = I('post.code','');
				if(!$code){
					$this->ajaxReturn(array('result'=>'0','info'=>'请输入短信验证码!'));				
				}	
                $check_code = sms_code_verify($mobile,$code,session_id());				
				if($check_code['status'] != 1){
					$this->ajaxReturn(array('result'=>'0','info'=>$check_code['msg']));					
				}					
                $password = I('post.password','','md5');
                $password1 = I('post.password1','','md5');
                
                if ($password != $password1) {
					$this->ajaxReturn(array('result'=>'0','info'=>'密码和确认密码不一致！'));
                }
                //开始修改密码
                $data = array();
                $data['password2'] = $password;
                M('member')->where(array('username'=>$mobile))->save($data);
				$this->ajaxReturn(array('result'=>'1','info'=>'密码重置成功！','url'=>U('Index/Index/index')));
            }
            $this->display();
        }
		
		
		
		
		
		
		
		
		
		
		
		
	}
?>