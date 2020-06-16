<?php  
//账号管理控制器
Class AccountAction extends CommonAction{

    //账号管理
    public function index(){
		
        $this->display();
    }


    /**
     * 发送手机注册验证码
     */
    public function send_sms_reg_code(){
        $mobile = I('mobile');
        if(!check_mobile($mobile))
            exit(json_encode(array('status'=>-1,'msg'=>'手机号码格式有误!')));
        if (M('member')->where(array('mobile'=>$mobile))->getField('id')) {
          exit(json_encode(array('status'=>-1,'msg'=>'手机号码已存在!')));
        }		
        $code =  rand(1000,9999);
        $send = sms_log($mobile,$code,session_id());
        if($send['status'] != 1)
            exit(json_encode(array('status'=>-1,'msg'=>$send['msg'])));
        exit(json_encode(array('status'=>1,'msg'=>'验证码已发送，请注意查收')));
    }
	
    //我的玩家账号
    public function myAccount(){

		$parent = session('username');
		$user_id = session('mid');
		import('ORG.Util.Page');
        if (IS_POST) {
            $where['username'] = I("post.username","","htmlspecialchars");
            $where['parent_id'] = $user_id;
			$count = M('member')->where($where)->count();
			$page = new Page($count,25);
			
			$page->setConfig('theme', '%first% %upPage% %linkPage% %downPage% %end%');
            $show = $page->show();// 分页显示输出
            $list = M('member')->where($where)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        }else{
			
			$count = M('member')->where(array('parent_id'=>$user_id))->count();
			$page = new Page($count,25);
			
			$page->setConfig('theme', '%first% %upPage% %linkPage% %downPage% %end%');
			$show = $page->show();// 分页显示输出
            $list = M('member')->where(array('parent_id'=>$user_id))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			
        }
		foreach($list as $k=>$v){
			$list[$k]['zheng'] = M("order")->where(array("zt"=>1,"user"=>$v['username']))->count();
		}
		$userinfo=M('member')->where("id = {$user_id}")->find();
		
		
		//公会总的认证人数
		/*$userall=M('member')->field('id,username,parent,parent_id')->where("id > 0 and checkstatus = 3")->select();
		$TeamUserAll=getChildsId($userall,$user_id,0);
		$TeamUserCount_Y=count($TeamUserAll);
		$TeamUserAll_str=implode(',',$TeamUserAll);
		//公会总算力
		$TeamUserPower=M('order')->where("zt = 1 and user_id in ({$TeamUserAll_str})")->sum('lixi');
		*/
		$myparent_id=M("member")->where("id = {$user_id}")->getField('parent_id');
		$puserinfo=array();
		if(!empty($myparent_id)){
			$puserinfo=M('member')->where("id = {$myparent_id}")->find();
				
		}
		//$MyZhitui=M("member")->where("parent_id = {$user_id}")->count();
		
		//$MyPower=M('order')->where("zt = 1 and user_id ={$user_id}")->sum('lixi');
		$this->assign('puserinfo',$puserinfo);
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->assign('userinfo',$userinfo);
		
        $this->display();
    }
	public function memberAccount(){
		
		
	
		$user_id = session('mid');
		$userinfo=M("member")->where("id = {$user_id}")->find();
		
		if($userinfo['level']>=2){
				$is_edit=1;	
			
		}else{
			$is_edit=0;	
			$p_userinfo=M("member")->where("id = {$userinfo['parent_id']}")->find();
			
		}
		$this->assign('userinfo',$userinfo);
		$this->assign('p_userinfo',$p_userinfo);
		$this->assign('is_edit',$is_edit);
		
		$this->display();
		
	}
	
	public function post_memberAccount(){
		
		if(!IS_AJAX){
			exit;	
		}
		
		
		$president_qq=I('post.president_qq','','trim');
		$president_qqs=I('post.president_qqs','','trim');
		$president_wxewm=I('post.president_wxewm');
		$president_desc=I('post.president_desc');
		if(empty($president_qq) || empty($president_qqs) || empty($president_wxewm) || empty($president_desc)){
			echo json_encode(array('result'=>0,'msg'=>'请完善信息后提交'));
			exit;	
		}
		
		$user_id = session('mid');
		
		$data=array();
		$data['president_qq']=$president_qq;
		$data['president_qqs']=$president_qqs;
		$data['president_wxewm']=$president_wxewm;
		$data['president_desc']=$president_desc;
		
		M("member")->where("id = {$user_id}")->save($data);
		echo json_encode(array('result'=>1,'msg'=>'工会信息更新成功！'));
		exit;	
		
		
		
		
		
		
		
	}
	
	
	
	
	
	
	public function tuiguangma(){
		
		
		
		header ( "Content-type: text/html; charset=utf-8");
		
		$e_keyid=encrypt(session('mid'),'E','xyb8888');
		
		$e_keyid=str_replace('/','AAABBB',$e_keyid);
		
		$tuiguangma = "http://".$_SERVER['SERVER_NAME'].U('Index/Sem/regSem',array('u'=>$e_keyid));
		$erwei = M("member")->where(array('username'=>session('username')))->getField("erwei");
		
		if(!$erwei){
			Vendor('phpqrcode.phpqrcode');
			//生成二维码图片
			$object = new QRcode;
			$level=3;
			$size=6;
			$errorCorrectionLevel =intval($level) ;//容错级别
			$matrixPointSize = intval($size);//生成图片大小
			$path = "Public/erwei/";
			// 生成的文件名
			$fileName = $path.session('username').'.png';
			$object->png($tuiguangma,$fileName, $errorCorrectionLevel, $matrixPointSize, 2);
			import('ORG.Util.Image');
			$Image = new Image();		
			
			define('THINKIMAGE_WATER_CENTER', 5);
			$Image->water(PUBLIC_PATH.'/encard.jpg',$fileName,$fileName,100,array(240,350));	
            $erwei = '/'.$fileName;		
			M("member")->where(array('username'=>session('username')))->setField("erwei",$erwei);
		}
        $this->assign('erwei',$erwei);
		$adurl=C('adurl');
		$adurl2=str_replace('[adurl]',$tuiguangma,$adurl);
		
		$this->assign('tuiguangma',$tuiguangma);
		$this->assign('adurl2',$adurl2);
		$this->display();
	}
    public function bdcenter(){
	    die;
        if (!M('member')->where(array('username'=>session('username'),'isbaodan'=>1))->getField('id')) {
                alert('对不起，您不是配送中心!',-1);die;
        }	

		$wuliu = session('username');
		import('ORG.Util.Page');
        if (IS_POST) {
            $where['username'] = $_POST['username'];
            $where['wuliu'] = $wuliu;
			$count = M('member')->where($where)->count();
			$page = new Page($count,15);
            $show = $page->show();// 分页显示输出
            $list = M('member')->where($where)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        }else{
			
			$count = M('member')->where(array('wuliu'=>$wuliu))->count();
			$page = new Page($count,15);
            $show = $page->show();// 分页显示输出
            $list = M('member')->where(array('wuliu'=>$wuliu))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			
        }
		
        $this->assign('list',$list);
		$this->assign('page',$show);
        $this->display();
    }
    //激活账号
    public function activeAccount(){
     die;
			if (isset($_GET['u'])) {
				$new = I('get.u','','strval');
				$info = M('member')->where(array('username'=>$new,'status'=>0))->find();
				if(!$info){
					echo '<script>alert("会员不存在!请确认后操作!");window.history.back(-1);</script>';
					die;						
				}
				
			}
        $member = M('member');
		
         if(IS_POST){
				$password2   = $_POST['password2'];
				if(empty($password2)){
					$this->ajaxReturn(array('info'=>'二级密码不能为空！'));
				}
			
				//验证二级密码是否正确
				if (!M('member')->where(array('username'=>session('username'),'password2'=>I('post.password2','','md5')))->getField('id')) {
					$this->ajaxReturn(array('info'=>'对不起!二级密码不正确!'));					
				}				 
				$level = I('post.level',0,'intval');
				$member_group = M('member_group')->where(array('level'=>$level))->find();
				if(!$member_group){
					$this->ajaxReturn(array('info'=>'请选择产品类型!'));		
				}			 
               $parent = $info['parent'];//直接推荐人 
                //验证余额是否足额
                $jinbi = getMemberField('jinbi');
				if ($jinbi < $member_group['money']) {
					$this->ajaxReturn(array('info'=>'现金余额不足!'));			
				}	
				
				//验证玩家是否已激活
				if ($member->where(array('username'=>$new))->getField('status')) {
					$this->ajaxReturn(array('info'=>'玩家已激活！请勿重复提交!'));						
				}

				//验证当前用户是否为其报单中心
				$wuliu = $member->where(array('username'=>$new))->getField('wuliu');
				if (session("username")!= $wuliu) {
					$this->ajaxReturn(array('info'=>'对不起，你不是其报单中心!'));		
				}
            //返回上级所有安置会员
            $ffid = fl_top_fid($info['fparent'],1);
		
		    $ffid = explode(",",$ffid);
           //原左右信息查询		 		   
		    $old = array();
			$ffid_new= array();
		    foreach($ffid as $key=>$val){
			   $muceng = array();
			   $u = M('member')->where(array('username'=>$val))->find();
			   $c1 =get_ceng($new);
			   $c2 =get_ceng($val);
			   
			   $old[$val][]= $u['leftpeng'];
			   $old[$val][]= $u['rightpeng'];
			   
			   $old[$val][]= $c1 - $c2;
			   if($key==0){
				   if($u['left']==$new){
					   $ffid_new[$key]['username'] = $val;
					   $ffid_new[$key]['weizhi'] = 'left';
				   }elseif($u['right']==$new){
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
		
            //正式更新数据
            $data['checkdate'] = time();
            $data['status']    = 1;
			$data['level']     = $member_group['level'];
		    $member->where(array('username'=>$new))->setInc('jinzhongzi',C("P1"));
			account_log2($new,C("P1"),'注册赠送',1,1);
			if($member_group['level']==2){
				$data['ji']    = 1;
				$member->where(array('username'=>$new))->setInc('jinzhongzi',C("P2"));
				account_log2($new,C("P2"),'升为主任',1,2);
			}
            $member->where(array('username'=>$new))->save($data);
            //更新推荐人推荐数量
            $member->where(array('username'=>$parent))->setInc('parentcount');

            $path = $info['parentpath'];
            $path = $path2 = explode('|', $path);
            $path = implode(',', array_filter($path));
            $sql = "select * from ds_member where id in (". $path .") order by parentlayer desc";
            $model = new Model();
            $parent_list = $model->query($sql);
            $i = 1;
            foreach ($parent_list as $v) {
                $member->where(array('id'=>$v['id']))->setInc('gamecount');
                $member->where(array('id'=>$v['id']))->setInc('validgamecount');
                $i++;
            }			
			//写入安置统计
		   foreach($ffid_new as $key=>$val){
			    $o = M('member')->where(array('username'=>$val['username'],'status'=>1))->find();
				//左
				if($o['left']!=null && $val['weizhi']=='left'){
					$memberinfo =  M('member')->field('left')->where(array('username'=>$o['left'],'status'=>1))->find();
					if(!empty($memberinfo)){
						
						//人数统计
						$member->where(array('username'=>$val['username']))->setInc('leftnum',1);
						$member->where(array('username'=>$val['username']))->setInc('countnum',1);
							//业绩统计
							$member->where(array('username'=>$val['username']))->setInc('leftpro',$member_group['money']);
							$member->where(array('username'=>$val['username']))->setInc('countpro',$member_group['money']);
							$member->where(array('username'=>$val['username']))->setInc('leftpeng',$member_group['money']);
							$member->where(array('username'=>$val['username']))->setInc('countpeng',$member_group['money']);
							
					}			
				}			
				//右
				if($o['right']!=null && $val['weizhi']=='right'){
					$memberinfo =  M('member')->field('right')->where(array('username'=>$o['right'],'status'=>1))->find();
					if(!empty($memberinfo)){
						//人数统计
						$member->where(array('username'=>$val['username']))->setInc('rightnum',1);
						$member->where(array('username'=>$val['username']))->setInc('countnum',1);
							//业绩统计
							$member->where(array('username'=>$val['username']))->setInc('rightpro',$member_group['money']);
							$member->where(array('username'=>$val['username']))->setInc('countpro',$member_group['money']);	
							$member->where(array('username'=>$val['username']))->setInc('rightpeng',$member_group['money']);
							$member->where(array('username'=>$val['username']))->setInc('countpeng',$member_group['money']);	
									
					}			
				}				
		   }				
		   //扣除余额
            $member->where(array('username'=>$wuliu))->setDec('jinbi',$member_group['money']);					
            account_log($wuliu,$member_group['money'],'会员'.$new.'报单扣除',0,11);	
		   
		   if(!empty($parent)){
			      //推荐奖 
				  $tjj  = cxmoney($member_group['money'] * 0.01 * C("TJJ"));  
				  $member->where(array('username'=>$parent))->setInc('jinbi',$tjj[0]);
				  account_log($parent,$tjj[0],'直接增员奖,来自会员:'.$new,1,1);	
				  $member->where(array('username'=>$parent))->setInc('point',$tjj[1]);
				  account_log3($parent,$tjj[1],'直接增员奖,来自会员:'.$new,1,1);					  
				  $member->where(array('username'=>$parent))->setInc('jinzhongzi',C("P3"));
				  account_log2($parent,C("P3"),'增员奖励',1,3);				 
		    }
			//报单奖
			$bdj =  cxmoney(C("BDJ"));
			$member->where(array('username'=>$wuliu))->setInc('jinbi',$bdj[0]);
			account_log($wuliu,$bdj[0],'报单奖,来自会员:'.$new,1,2);	
			$member->where(array('username'=>$wuliu))->setInc('point',$bdj[1]);
			account_log3($wuliu,$bdj[1],'报单奖,来自会员:'.$new,1,2);				
            //见点奖
            $jd = C("JD");			
			//新左右信息查询		 		   
			$new = array();	
			foreach($ffid as $key=>$val){
				   $u = M('member')->where(array('username'=>$val))->find();
				   $c1 = get_ceng($_GET['u']);
			       $c2 = get_ceng($val);
				   $new[$val][]= $u['leftpeng'];
				   $new[$val][]= $u['rightpeng'];
				   //见点奖
				   if($key < C("JD_CENG")){
					       $jd_money = cxmoney($jd * 0.01 * $member_group['money']);			  
						   $member->where(array('username'=>$val))->setInc('jinbi',$jd_money[0]);
						   account_log($val,$jd_money[0],'间推奖,来自会员：'.$_GET['u'],1,3);	
						   $member->where(array('username'=>$val))->setInc('point',$jd_money[1]);
						   account_log3($val,$jd_money[1],'间推奖,来自会员：'.$_GET['u'],1,3);							   
                   }				   
				   $new[$val][]= $c1 - $c2;	
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
					$weizhi[$k][] = $v[2];  //层
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
								   //奖金
								   $dpj = cxmoney($dpj);
								   $member->where(array('username'=>$k))->setInc('jinbi',$dpj[0]);
								   account_log($k,$dpj[0],'管理奖,来自会员:'.$_GET['u'],1,4);	
								   $member->where(array('username'=>$k))->setInc('point',$dpj[1]);
								   account_log3($k,$dpj[1],'管理奖,来自会员:'.$_GET['u'],1,4);									   
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
								   //奖金
								   $dpj = cxmoney($dpj);
								   $member->where(array('username'=>$k))->setInc('jinbi',$dpj[0]);
								   account_log($k,$dpj[0],'管理奖,来自会员:'.$_GET['u'],1,4);	
								   $member->where(array('username'=>$k))->setInc('point',$dpj[1]);
								   account_log3($k,$dpj[1],'管理奖,来自会员:'.$_GET['u'],1,4);	
								   $member->where(array('username'=>$k))->setDec('rightpeng',$dpmoney);
								   $member->where(array('username'=>$k))->setDec('leftpeng',$dpmoney);
								   $member->where(array('username'=>$k))->setDec('countpeng',$dpmoney*2);								   
							 }								
					   }
							   
			  }
			  
			 
		   }					   
			$this->ajaxReturn(array('info'=>'激活成功！','url'=>U('Index/Account/myAccount')));		   

     
        }
			$m = $member->where(array("username"=>session('username')))->find();
			$list = M('member_group')->select();
			$this->assign('list',$list);	
			$this->assign('m',$m);
			$this->assign('new',$new);
            $this->display();


    }

    //删除未审核会员
    public function deleteUnCheck(){
        $member = M('member');
        $minfo = $member->where(array('id'=>I('get.id',0,'intval')))->find();
        if ($member->where(array('id'=>$_GET['id'],'status'=>0,'parent'=>session('username')))->delete()) {
            //更新安置人左右区信息
            if ($minfo['my_jd'] == 'left') {
				$data['left'] = array('exp','null');
                $member->where(array('username'=>$minfo['fparent']))->save($data);
            }else if($minfo['my_jd'] == 'right'){
				$data['right'] = array('exp','null');
                $member->where(array('username'=>$minfo['fparent']))->save($data);
            }
            alert('刪除成功！',U('Index/Account/myAccount'));
        }else{
            alert('刪除失败！',U('Index/Account/myAccount'));
        }
    }

    //ajax查询推荐人会员编号
    public function checkParent(){
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
        $rand=rand(100000,999999);
        $data['result'] = $rand;
        echo json_encode($data);
    }


    //ajax验证二级密码
    public function checkPass(){
        if (M('member')->where(array('username'=>session('username'),'password2'=>I('post.UserPass2','','md5')))->getField('id')) {
            $data['result'] = 'success';
            echo json_encode($data);
        }else{
            $data['result'] = 'error';
            echo json_encode($data);
        }
    }

    //ajax验证新会员
    public function checkNewUserName(){
        if ($_POST['CheckType'] == 'CheckIsActivation') {
            $member = M('member');
            if (!$member->where(array('username'=>$_POST['username']))->getField('id')) {
                $data['result'] = 'nouser';
                echo json_encode($data);
            }else if ($member->where(array('username'=>$_POST['username'],'status'=>1))->getField('id')) {
                $data['result'] = 'success';
                echo json_encode($data);
            }else{
                $data['result'] = 'noactivation';
                $data['usercontact'] = $member->where(array('username'=>$_POST['username']))->getField('nickname');
                echo json_encode($data);
            }
        }else if($_POST['CheckType'] == 'CheckIsBDUser'){
            $member = M('member');
            if (!$member->where(array('username'=>$_POST['username'],'status'=>1))->getField('id')) {
                $data['result'] = 'nouser';
                echo json_encode($data);
            }else if (!$nickname = $member->where(array('username'=>$_POST['username'],'status'=>1,'isbaodan'=>1))->getField('nickname')) {
                $data['result'] = 'error';
                echo json_encode($data);
            }else{
                $data['result'] = 'success';
                $data['usernickname'] = $nickname;
                echo json_encode($data);
            }
        }
    }
    
    public function checkGameCount(){
        $this->display();
    }
    
    public function gameCount(){
        if (session('verify') != I('yzm','','md5')) {
            echo '<script>alert("請輸入正确的安全碼！");window.history.back(-1);</script>';
            die;
		}
        //直属账号
        $member = M('member')->where(array('username'=>  session('username')))->find();
        $this->assign('parentcount',$member['parentcount']);
        //游戏账号总数gamecount
        $this->assign('gamecount',$member['gamecount']);
        //游戏账号有效数validgamecount
        $this->assign('validgamecount',$member['validgamecount']);
        $this->display();
    }

    /**
     * 编辑新增会员密码
     * @return [type] [description]
     */
    public function editPassword(){
        $mem = M('member')->where(array('id'=>I('get.id',0,'intval')))->find();
        $this->assign('mem',$mem);
        $this->display();
    }

    /**
     * 编辑会员处理方法
     * @return [type] [description]
     */
    public function editPasswordHandle(){
        $pass1 = I('post.pass1');
        $pass2 = I('post.pass2');
        if ($pass1 =='' || $pass2 == '') {
            echo '<script>alert("請輸入新密碼！");window.history.back(-1);</script>';
            die;
        }
        $data = array();
        $data['id'] = I('post.id',0,'intval');
        $data['password'] = md5($pass1);
        $data['password2'] = md5($pass2);
        if (M('member')->save($data)) {
            alert('修改成功！',U('newAccount'));
        }
    }
    	    //树形图
		public function shu_list(){
			Vendor('Tree.tree');
			$menu = new tree;
			    $minfo = M("member")->where(array('username'=>session("username")))->find();
			    $arr[session("username")] = $minfo ;
				$arr[session("username")]['parentid_node'] = '';				
				$menu->icon = array('│ ','├─ ','└─ ');
				$menu->nbsp = '&nbsp;&nbsp;&nbsp;';
				$result = M('member')->field('id,username,parentcount,parent,parentpath')->select();
				foreach($result as $k=>$v){
			       $path = explode("|",$v['parentpath']);
				   array_pop($path);
                   if(in_array($minfo['id'],$path)){
					   $arr[$v['username']] = $v;
					   $arr[$v['username']]['parentid_node'] = ($v['parent'])? ' class="child-of-node-'.$v['parent'].'"' : '';
				   }
				}

				$str  = "<tr id='node-\$username' \$parentid_node>
							<td style='padding-left:30px;'>\$spacer 会员编号：\$username (直推人数：\$parentcount)</td>
						</tr>";
				$menu->init($arr);
				$categorys = $menu->get_tree($minfo['parent'], $str);		
                $this->assign('categorys',$categorys);					
			    $this->display();
		}
			//金字塔排位图
		public function pw_list(){

			//塔顶成员信息
			$memberinfo =  M('member')->where(array('username'=>session('username')))->find();
			//获取下层成员
			$xiaceng = all_member_down(array($memberinfo['left'],$memberinfo['right']));
			if(empty($_GET['cs'])){
				$username = session('username');//如果为空默认塔顶成员
			}else{
				$username = I('get.cs','','htmlspecialchars'); //选取塔顶信息
				if(!in_array($username,$xiaceng)){
						$username = session('username');
				}
			}
	
			 $html = $this->tuopu($memberinfo['fparent'],$username);//返回ID对应层	
			 $this->assign('html',$html);	
			 $this->display();
			 
		}


    //金字塔页面信息

	private function tuopu($pp,$uu,$n=1,$s=0,$reg,$av=0,$xulie="1"){
	   if($n<=4){
	      $o = M('member')->where(array('username'=>$uu))->find();
		   if($o['left']!=NULL && $o['right']==NULL){
		       $cid = array(0=>$o['left'],1=>NULL);
		   }elseif($o['right']!=NULL && $o['left']==NULL){
		      $cid = array(0=>NULL,1=>$o['right']);
		   }elseif($o['left']==NULL && $o['right']==NULL && $uu !=NULL){
		       $cid = array(0=>NULL,1=>NULL);
		   }elseif($o['left']!=NULL && $o['right']!=NULL){
		       $cid = array(0=>$o['left'],1=>$o['right']);
		   }


		   //图形像素
		   $px = C('px2');
		   $link = U(GROUP_NAME.'/account/pw_list',array('cs'=>$o[username]));
		   $top_link = U(GROUP_NAME.'/account/pw_list',array('cs'=>$o['fparent']));
		   //折线
		   if($n<=3){
		     $table ="<table class=\"table table-bordered\" style=\"border: none;width: {$px[$xulie]['xheight']}px;position: absolute;top: {$px[$xulie]['xtop']}px;left: {$px[$xulie]['xleft']}px;height: 20px;\"><tbody><tr><td style=\"border-left: none;border-top: none;\"></td><td style=\"border: none;\"></td></tr><tr><td colspan=\"2\" style=\"border-left: 1px solid #ddd;border-right: 1px solid #ddd;border-bottom: none;\"></td></tr></tbody></table>";
		   }else{
			  $table =""; 
		   }	
			//获取下层数量		
		    //左
            $left_count = $o['leftnum'];	
			//右
            $right_count = $o['rightnum'];	
			//总
            $rl_count = $o['countnum'];	
            $groupname = xian($o[ji]);
		   if($n==1){
			   $class = "btn-danger";
			   $str = "<style>.btn-inverse {width: 140px;}</style><div onclick='location.href=\"{$top_link}\"' style=\"cursor: pointer;position:absolute; top:{$px[$xulie]['top']}px; left:{$px[$xulie]['left']}px;width:140px\" ><div class=\"box border inverse\"><div class=\"box-body\">
				<table class=\"table table-bordered\">
					<thead><tr><th colspan=\"3\" class='{$class}' style=\"text-align:center;\">{$u_type}{$o[username]}<br>{$groupname}</th></tr></thead><tbody>
					<tr><td style=\"text-align: center\">总</td><td style=\"text-align: center\">{$o[leftpro]}({$o[leftnum]})</td><td style=\"text-align: center\">{$o[rightpro]}({$o[rightnum]})</td></tr><tr><td style=\"text-align: center\">剩</td><td style=\"text-align: center\">{$o[leftpeng]}</td><td style=\"text-align: center\">{$o[rightpeng]}</td></tr></tbody></table></div></div></div>{$table}";
		
		   }else{
			   //会员审核状态
			   if($o['status']==0){
				  $u_type = "(未激活)";
				   $class = "btn-inverse";
			   }elseif($o['status']==1){
				   $class = "btn-success";
				  $u_type = "(已激活)";
			   }
			 
			 if($uu==NULL){
	            $login = U(GROUP_NAME.'/sem/regSem',array('u'=>session('username'),'fparent'=>$reg,'lr'=>$s));
			    $str .="<span style=\"position:absolute; top:{$px[$xulie]['top']}px; left:{$px[$xulie]['left']}px;\"><button id='loading-btn' type='button' class='btn {$class}' onclick='window.open(\"{$login}\")'>立即注册</button></span>";
			 }else{
			    $str .= "<div onclick='location.href=\"{$link}\"' style=\"cursor: pointer;position:absolute; top:{$px[$xulie]['top']}px; left:{$px[$xulie]['left']}px;width:150px\" ><div class=\"box border inverse\"><div class=\"box-body\"><table class=\"table table-bordered\"><thead><tr><th colspan=\"3\" class='{$class}' style=\"text-align:center;\">{$u_type}{$o[username]}<br>{$groupname}</th></tr></thead><tbody><tr><td style=\"text-align: center\">总</td><td style=\"text-align: center\">{$o[leftpro]}({$o[leftnum]})</td><td style=\"text-align: center\">{$o[rightpro]}({$o[rightnum]})</td></tr><tr><td style=\"text-align: center\">剩</td><td style=\"text-align: center\">{$o[leftpeng]}</td><td style=\"text-align: center\">{$o[rightpeng]}</td></tr></tbody></table></div></div></div>{$table}";			 
		     }
		   }
           $n++;
	       $h=0;
		   foreach($cid as $k=>$v){
		      $h++;
			  if($n>=3){
				   $xulie =$xulie*$n;
			  }else{
				   $xulie =$n*$h;
			  }
			 
			
		      if($v==NULL){
			     $str .= $this->tuopu($pp,$v,$n,$k,$o['username'],0,$xulie);
			  }else{
			     $str .= $this->tuopu($pp,$v,$n,$k,'',$av,$xulie);
			  }
             
		   }
	  }
	   return $str;
	}

}



?>