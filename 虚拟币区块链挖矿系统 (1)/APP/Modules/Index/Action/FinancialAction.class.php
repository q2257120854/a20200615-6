<?php
//财务相关控制器
Class FinancialAction extends CommonAction{



  
    //金币转账
    public function kChange(){
			


        if (IS_POST) {
            $inusername  = I('post.inusername');
            $outmoney    = I('post.outmoney','','intval');
            $desc        = I('post.desc','');
            $password2   = I('post.safe','','md5');
            $outusername = I('post.outusername');
			
            $member = M('member');
			//$member->startTrans();	
            //验证二级密码是否正确
			if($outmoney==0){
				$this->ajaxReturn(array('info'=>'请填写转账金额!'));
			}
			
			
			
			$shouxufei = $outmoney * C('TRANSFER_TAX')/100;
			$zcje = $outmoney + $shouxufei;
			
            if (!M('member')->where(array('username'=>session('username'),'password2'=>$password2))->getField('id')) {
                   $this->ajaxReturn(array('info'=>'对不起!二级密码错误!')); 
            }
			
            //验证IN会员编号是否存在并已审核
            if (!$member->where(array('username'=>$inusername,'status'=>1))->getField('id')) {
                   $this->ajaxReturn(array('info'=>'对不起，转入会员不存在或未审核')); 
            }
			$memberinfo =  M('member')->where(array('username'=>session('username')))->find();
			
			//是否开启转帐功能
			if (C('TRANSFER_STATUS') == 'off') {
				$this->ajaxReturn(array('info'=>'对不起!转账功能暂未开放!'));								
			}
			/**
			//获取下层成员
			$xiaceng = all_member_down(array($memberinfo['left'],$memberinfo['right']));
			$ffid = fl_top_fid($memberinfo['fparent'],1);
			$ffid = explode(",",$ffid);
            if(!in_array($inusername,$xiaceng) && !in_array($inusername,$ffid)){
				   $this->ajaxReturn(array('info'=>'对方与你不是上下级关系！不能转出！')); 
			}	
           **/			
            //验证是否有足够的货币
            $jinbi = getMemberField('jinbi');
            if ($jinbi < $zcje) {
                  $this->ajaxReturn(array('info'=>'可用金币余额不足!')); 
            }
			$zuixiaosl = C('TRANSFER_MIN');
			$zuidasl = C('TRANSFER_MAX');
			
            if ($inusername == $outusername) {
                  $this->ajaxReturn(array('info'=>'对不起.您不能转账给自己!')); 
            }
			
            if ($outmoney < $zuixiaosl || $outmoney > $zuidasl) {
                  $this->ajaxReturn(array('info'=>'最小转出数量为'. $zuixiaosl .'至'. $zuidasl .'!')); 
            }
            //更新转出人余额
            $res1 = $member->where(array('username'=>$outusername))->setDec('jinbi',$zcje);
			

            //更新转入人余额
            $res2 = $member->where(array('username'=>$inusername))->setInc('jinbi',$outmoney);
            if($res1 && $res2){
				 $member->commit();
                 //转出人购物券明细
                 account_log3($outusername,$outmoney,'转出金币到账号'.$inusername,0);
                 account_log3($outusername,$shouxufei,'转出金币到账号手续费'.$inusername,0);
                 //转入人购物券明细
		       	 account_log3($inusername,$outmoney,'收到账号为'. $outusername .'的金币',1);				 
			}else{
				 $member->rollback();
			}
            //转出记录
            $transfer = M('transfer');
            $data['outer'] = $outusername;
            $data['iner'] = $inusername;
            $data['qty'] = $outmoney;
            $data['sxf'] = $shouxufei;
            $data['addtime'] = time();
            $data['desc'] = $desc;
            $transfer->add($data);
			$this->ajaxReturn(array('info'=>'转账成功！','url'=>U('Index/Financial/kChange')));	
        }
		
        $jinbi = getMemberField('jinbi');
		$feilv = C('TRANSFER_TAX');
		$feil = C('TRANSFER_TAX')/100;
        $this->assign('feil',$feil);
        $this->assign('feilv',$feilv);
        $this->assign('jinbi',$jinbi);
        $this->display();
    }

    //金币转账记录
    public function kChangeList(){
         //用于显示近两个月
        $premonth = get_month(1);
        $date = array(
            date("Y-m"),
            $premonth
        );
        $this->assign('date',$date);

        $data = M('transfer');
        import('ORG.Util.Page');
        $where['outer']  = session('username');
        $where['iner']   = session('username');
        $where['_logic'] = 'or';
        $map['_complex'] = $where;
        if (isset($_GET['month'])) {
            if ($_GET['month'] == $premonth) {
                $map['addtime'] = array('gt',strtotime(date($_GET['month'].'-01', time())));
                $map['addtime'] = array('lt',strtotime(date('Y-m-01', time())));
            }else{
                $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
            }
        }else{
            $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
        }
        $count = $data->where($map)->count();
        $page = new Page($count);
        $show = $page->show();// 分页显示输出
        $list = $data->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
	//矿机收益
    public function ksList(){
			
			
			$zt=I('get.zt',1,'intval');
			$user_id=session('mid');
			$order = M("order");
			import("ORG.Util.Page");
			$count = $order ->where("user_id = {$user_id} and zt = {$zt}")->count();
			$Page       = new Page($count,15);
			$Page->setConfig('theme', '%first% %upPage% %linkPage% %downPage% %end%');
			$show = $Page -> show();
			$orders = $order->where("user_id = {$user_id} and zt = {$zt}") -> limit($Page ->firstRow.','.$Page -> listRows)->order('id desc') -> select();
			foreach($orders as $k=>$v){
				
				$a_time = (time()-strtotime($v['addtime']))/3600;
				$orders[$k]['a_time']=round($a_time,2);
				if(time()-$v['UG_getTime'] < 24*3600){
						$orders[$k]['is_jiesuan']=0;
				}else{
						$orders[$k]['is_jiesuan']=1;//可以结算	
				}
				
				
				
			}
			
            $this -> assign("page",$show);
			$this -> assign("zt",$zt);
			$this -> assign("orders",$orders);
			$this -> display(); 			
		
		/**
        $data = M('jinbidetail');
        import('ORG.Util.Page');
        $map['member']  = $username = session('username');

        $numsQuery = $data->field('FROM_UNIXTIME(addtime,"%Y-%m-%d") as datetime')->where($map)->group('FROM_UNIXTIME(addtime,"%Y-%m-%d")')->buildSql();
		$nums = M()->table("{$numsQuery} as t")->count();  
        $page = new Page($nums,15);
        $show = $page->show();// 分页显示输出
		$info = $data->field('FROM_UNIXTIME(addtime,"%Y-%m-%d") as datetime')->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->group('FROM_UNIXTIME(addtime,"%Y-%m-%d")')->select();
		foreach($info as $key=>$val){
			$date = $val['datetime'];
			//静态红包
			$j1 = $data->where("FROM_UNIXTIME(addtime,'%Y-%m-%d') = '$date' and type=1 and `member`='$username'")->sum('adds');
			if(empty($j1)){
				$j1 = 0;
			}
			$info[$key]['j1'] = $j1;
			//分红红包
			$j2 = $data->where("FROM_UNIXTIME(addtime,'%Y-%m-%d') = '$date' and type=2 and `member`='$username'")->sum('adds');
			if(empty($j2)){
				$j2 = 0;
			}			
			$info[$key]['j2'] = $j2;
			//合伙人红包
			$j3 = $data->where("FROM_UNIXTIME(addtime,'%Y-%m-%d') = '$date' and type=3 and `member`='$username'")->sum('adds');
			if(empty($j3)){
				$j3 = 0;
			}				
			$info[$key]['j3'] = $j3;
			$j4 = $data->where("FROM_UNIXTIME(addtime,'%Y-%m-%d') = '$date' and type=4 and `member`='$username'")->sum('adds');
			if(empty($j4)){
				$j4 = 0;
			}				
			$info[$key]['j4'] = $j4;
			$j5 = $data->where("FROM_UNIXTIME(addtime,'%Y-%m-%d') = '$date' and type=5 and `member`='$username'")->sum('adds');
			if(empty($j5)){
				$j5 = 0;
			}				
			$info[$key]['j5'] = $j5;	
			$j6 = M('jinbidetail')->where("FROM_UNIXTIME(addtime,'%Y-%m-%d') = '$date' and type=6 and `member`='$username'")->sum('adds');
			if(empty($j6)){
				$j6 = 0;
			}				
			$info[$key]['j6'] = $j6;
			$j7 = M('jinbidetail')->where("FROM_UNIXTIME(addtime,'%Y-%m-%d') = '$date' and type=7 and `member`='$username'")->sum('adds');
			if(empty($j7)){
				$j7 = 0;
			}				
			$info[$key]['j7'] = $j7;				
		}
        $this->assign('list',$info);
        $this->assign('page',$show);
        $this->display();
		**/
    }
    //金币转账转入
    public function kChangeInList(){
        //用于显示近两个月
        $premonth = get_month(1);
        $date = array(
            date("Y-m"),
            $premonth
        );
        $this->assign('date',$date);
        $data = M('transfer');
        import('ORG.Util.Page');
        $map['iner']  = session('username');
        if (isset($_GET['month'])) {
            if ($_GET['month'] == $premonth) {
                $map['addtime'] = array('gt',strtotime(date($_GET['month'].'-01', time())));
                $map['addtime'] = array('lt',strtotime(date('Y-m-01', time())));
            }else{
                $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
            }
        }else{
            $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
        }
        $count = $data->where($map)->count();
        $page = new Page($count);
        $show = $page->show();// 分页显示输出
        $list = $data->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    //金币转账转出
    public function kChangeOutList(){
        $premonth = get_month(1);
        $date = array(
            date("Y-m"),
            $premonth
        );
        $this->assign('date',$date);
        $data = M('transfer');
        import('ORG.Util.Page');
        $map['outer']  = session('username');
        if (isset($_GET['month'])) {
            if ($_GET['month'] == $premonth) {
                $map['addtime'] = array('gt',strtotime(date($_GET['month'].'-01', time())));
                $map['addtime'] = array('lt',strtotime(date('Y-m-01', time())));
            }else{
                $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
            }
        }else{
            $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
        }
        $count = $data->where($map)->count();
        $page = new Page($count);
        $show = $page->show();// 分页显示输出
        $list = $data->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    //奖金明细
    public function bonusList(){
        //查询汇总
        $member = M('member')->where(array('username'=>session('username')))->find();
        $this->assign('member',$member);
        //用于显示近两个月
        $premonth = get_month(1);
        $date = array(
            date("Y-m"),
            $premonth
        );
        $this->assign('date',$date);
        $data = M('bonus');
        import('ORG.Util.Page');
        $map['member']  = session('username');
        if (isset($_GET['month'])) {
            if ($_GET['month'] == $premonth) {
                $map['addtime'] = array('gt',strtotime(date($_GET['month'].'-01', time())));
                $map['addtime'] = array('lt',strtotime(date('Y-m-01', time())));
            }else{
                $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
            }
        }else{
            $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
        }
        $count = $data->where($map)->count();
        $page = new Page($count);
        $show = $page->show();// 分页显示输出
        $list = $data->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }

    //现金明细
    public function kList(){
        
        $premonth = get_month(1);
        $date = array(
            date("Y-m"),
            $premonth
        );
        $this->assign('date',$date);

        $data = M('jinbidetail');
        import('ORG.Util.Page');
        $map['member']  = session('username');
	        if ($_POST['type']) {
	        	$map['type'] = array("eq",$_POST['type']); 
	        }
        if (isset($_GET['month'])) {
            if ($_GET['month'] == $premonth) {
                $map['addtime'] = array('gt',strtotime(date($_GET['month'].'-01', time())));
                $map['addtime'] = array('lt',strtotime(date('Y-m-01', time())));
            }else{
                $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
            }
        }else{
            $map['addtime'] = array('gt',strtotime(date('Y-m-01', time())));
        }
        $count = $data->where($map)->count();
        $page = new Page($count,15);
        $show = $page->show();// 分页显示输出
        $list = $data->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
    //重消明细
    public function kzList(){
        
        $data = M('jinbidetail');
        import('ORG.Util.Page');
        $map['member']  = session('username');
		//$map['type'] = array("gt",1);
		$map['type'] = array("eq",2);
        $count = $data->where($map)->count();
        $page = new Page($count,30);
		$page->setConfig('theme', '%first% %upPage% %linkPage% %downPage% %end%');
        $show = $page->show();// 分页显示输出
        $list = $data->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
	
    //账户明细
    public function kgList(){
        $data = M('jinbidetail');
        import('ORG.Util.Page');
        $map['member']  = session('username');
        $count = $data->where($map)->count();
        $page = new Page($count,30);
		$page->setConfig('theme', '%first% %upPage% %linkPage% %downPage% %end%');
		$show = $page->show();// 分页显示输出
        $list = $data->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
	
	
	
	
	   //系统赠送 明细
    public function kgxList(){
        $data = M('member_award_log');
        import('ORG.Util.Page');
        $map['user_id']  = session('mid');
        $count = $data->where($map)->count();
        $page = new Page($count,30);
		$page->setConfig('theme', '%first% %upPage% %linkPage% %downPage% %end%');
		$show = $page->show();// 分页显示输出
        $list = $data->where($map)->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
		
		foreach($list as $k=>$v){
				
				$list[$k]['levle_name'] = M('member_group')->where("groupid ={$v['userortype_id']}")->getField('name');
				if($v['send_style']==1){
					$list[$k]['as_name']=M('product')->where("id ={$v['num']}")->getField('title');	
				}else{
					$list[$k]['as_name']=$v['num'];	
				}
				
				
		}
		
		
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display();
    }
	
	

    //AJAX验证用户名
    public function checkUsername(){
        if ($nickname = M('member')->where(array('username'=>$_POST['UserName'],'status'=>1))->getField('nickname')) {
            $data['result'] = $nickname;
            echo json_encode($data);
        }else{
            $data['result'] = 'nouser';
            echo json_encode($data);
        }
    }

    //AJAX验证二级密码
    public function checkPass(){
        if (M('member')->where(array('username'=>session('username'),'password2'=>I('post.UserPass2','','md5')))->getField('id')) {
                $data['result'] = 'success';
                echo json_encode($data);
        }else{
                $data['result'] = 'error';
                echo json_encode($data);
        }
    }

    /**
     * 生成验证码
     */
    public function verify(){
        import('ORG.Util.Image');
        Image::buildImageVerify(4,1,'png',55,25);
    }
}

?>