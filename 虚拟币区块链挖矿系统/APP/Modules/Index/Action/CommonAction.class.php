<?php  
	/**
	 * 会员前台公共控制器
	 */
	Class CommonAction extends Action{

		public function _initialize(){
			header("Content-Type:text/html; charset=utf-8");
			
				
			//判断是否关闭了网站
			$open_web=C('open_web');
			if(empty($open_web)){
				$this->open_web_notice=C('open_web_notice');
				$this->display('Index:404');
					exit;
			}
			
			
			
			
			
	  		if(!isset($_SESSION['mid']) && !isset($_SESSION['username']) ){
	  			$this->redirect('Index/Login/index');
	  		}else{
				  $memberinfo = M("member")->where(array('username'=>$_SESSION['username']))->find();
				  $this->memberinfo = $memberinfo;
				  M("member")->where(array('id'=>$_SESSION['mid']))->save(array('online_time'=>time()));
				  
			}

            if ($_SESSION['username'] == 'admin') {
                $this->redirect('Index/Login/index');
            }
		
			$everyday_last_time=C('everyday_last_time');
			$everyday_rose=C('everyday_rose');
			$everyday_drop=C('everyday_drop');
			//判断今天是否已经更新过了
			$s_time_a=strtotime(date('Y-m-d 00:00:01',time()));
			$o_time_a=strtotime(date('Y-m-d 23:59:59',time()));
			if($everyday_last_time < $s_time_a || $everyday_last_time > $o_time_a){
					$path = './App/Conf/system.php';
					$config = include $path;
					if(!empty($everyday_rose)){
						$config['min_danjia']      = C('min_danjia')+$everyday_rose;
						$config['max_danjia']      = C('max_danjia')+$everyday_rose;
							
					}
					
					if(!empty($everyday_drop)){
						$config['min_danjia']      = C('min_danjia')-$everyday_drop;
						$config['max_danjia']      = C('max_danjia')-$everyday_drop;
							
					}
					
					$config['everyday_last_time']      = time();
					$data = "<?php\r\nreturn " . var_export($config, true) . ";\r\n?>";
					file_put_contents($path, $data);
					
			}
			
		$time=date('Y-m-d 00:00:30',time());
		$time1=date('Y-m-d 23:59:59',time());
		$time2=date('Y-m-d 00:01:20',time());
		$date=strtotime($time);
		$date1=strtotime($time2);
		
		
		$lcsj=M('date')->where(array('date'=>$date))->find();
			
		
		if($lcsj==""){
		
			$sjj=M('date')->where(array())->order('id desc')->find();
			
			$map0['date']=$date;
			$map0['price']=$sjj['price'];
			M('date')->add($map0);
			$map11['date']=$date1;
			$map11['price']=$sjj['price'];
			M('date')->add($map11);
		}
		
		
		}

        /**
         * 二级密码验证首页
         * @return [type] [description]
         */
        public function pwdCheck(){
            $go = $_GET['go'];
            $this->assign('go',$go);
            $this->display();
        }

        /**
         * 二级密码验证页
         * @return [type] [description]
         */
        public function pwdChecking(){
            $this->display();
        }

        /**
         * 验证用户是否需要输入二级密码
         * @return [type] [description]
         */
        public function checkUserSecondLogin(){
            if (!isset($_SESSION['usersecondlogin']) || $_SESSION['usersecondlogin'] == '') {
                $returnurl = $_SERVER['PATH_INFO'];
                $this->redirect('Index/Common/pwdCheck', array('go' => base64_encode($returnurl)), 0, '');
            }
        }

        /**
         * 验证二级密码
         * @return [type] [description]
         */
        public function beginCheck(){
            $pwd2  = I('post.txtUserPass2','','md5');
            $gourl = I('post.go','','strval');
            $gourl = base64_decode($gourl);
           
            if (M('member')->where(array('password2'=>$pwd2,'username'=>session('username')))->getField('id')) {
                $_SESSION['usersecondlogin'] = 1;
                alert('驗證通過',U($gourl),1);
            }else{
                alert('二級密碼錯誤',-1);
            }
        }

        //新手入门
        public function beginners(){
            $newinfo = M('announce')->where(array('id'=>57))->find();
            $this->assign('info',$newinfo);
            $this->display();
        }

        //系统设置
        public function systemSet(){
            
            $this->display();
        }

		public function sendmail($sendto_email, $user_name, $subject, $code){
        vendor('PHPMailer.phpmailer');
        $mail = new PHPMailer();
        $mail->IsSMTP();                  // send via SMTP    
         
        $mail->Host = "smtp.126.com";   // SMTP servers    
        $mail->SMTPAuth = true;           // turn on SMTP authentication    
        $mail->Username = "cxmo";     // SMTP username  注意：普通邮件认证不需要加 @域名    
        $mail->Password = "asdfa"; // SMTP password    
        $mail->From = "cxdemo@126.com";      // 发件人邮箱    
        $mail->FromName = "管理员";  // 发件人    

        $mail->CharSet = "utf-8";   // 这里指定字符集！    
        $mail->Encoding = "base64";
        $mail->AddAddress($sendto_email, $user_name);  // 收件人邮箱和姓名    
        $mail->SetFrom('cxdemo@126.com', 'web');

        //$mail->AddReplyTo("axx@xxx.com", 'xxxxxxxx有限公司');
        //$mail->WordWrap = 50; // set word wrap 换行字数    
        //$mail->AddAttachment("/var/tmp/file.tar.gz"); // attachment 附件    
        //$mail->AddAttachment("/tmp/image.jpg", "new.jpg");    
        $mail->IsHTML(true);  // send as HTML    
        // 邮件主题    
        $mail->Subject = $subject;
        // 邮件内容    
        $mail->Body = '<html><head>   
<meta http-equiv="Content-Language" content="zh-cn"/>   
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>   
</head>   
<body> 
尊敬的玩家' . $user_name . ' ,您好！您正在绑定安全邮箱，您的邮箱验证码为：'. $code .'
</body>
</html>   
';
        $mail->AltBody = "text/html";
        
        if (!$mail->Send())
        {
              $mail->ClearAddresses();
            echo "邮件错误信息: " . $mail->ErrorInfo;
            exit;
        }
        else
        {
            $mail->ClearAddresses();
            //$this->redirect('sendhtml', array('send' => 5,'email'=>$sendto_email));
        }
    }
	}
?>