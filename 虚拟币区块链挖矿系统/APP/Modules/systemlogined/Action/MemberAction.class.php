<?php  

	/**
	* 会员管理控制器
	*/
	class MemberAction extends CommonAction{
		
		
		public function aass(){
			
			//M("member")->where("level = 1")->setDec("jinbi",10);	
			//exit("##");
		}
		
		
		
		
		public function unwan(){
			
			$map = $this -> _search();
			$map['level'] = array('eq',0);
			$map['checkstatus'] = array('eq',0);
			$map['truename'] = array('eq','');

			if (method_exists($this, '_search_filter')) {
				$this -> _search_filter($map);
			}
			
			$name = $this -> getActionName();
			$model = D($name);
			$infos = M('member_group')->field('groupid,name')->select();
			foreach($infos as $k=>$v){
				$group[$v['groupid']] = $v['name'];
			}
			if (!empty($model)) {
				$this -> _list($model, $map);
			}

			$this->assign('group',$group);	
			if (!empty($model)) {
				$this -> _list($model, $map,'',1);
			}
			$this->display('uncheck');
		}
		
		
		//审核没有通过的
		public function notcheck(){
			$map = $this -> _search();
			$map['level'] = array('eq',0);
			$map['checkstatus'] = array('eq',2);

			if (method_exists($this, '_search_filter')) {
				$this -> _search_filter($map);
			}
			
			$name = $this -> getActionName();
			$model = D($name);
			$infos = M('member_group')->field('groupid,name')->select();
			foreach($infos as $k=>$v){
				$group[$v['groupid']] = $v['name'];
			}
			if (!empty($model)) {
				$this -> _list($model, $map);
			}

			$this->assign('group',$group);	
			if (!empty($model)) {
				$this -> _list($model, $map,'',1);
			}
			$this->display();
		}	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
			
		//未审核会员列表
		public function uncheck(){
			$map = $this -> _search();
			//$map['level'] = array('gt',0);
			$map['checkstatus'] = array('eq',0);
			$map['truename'] = array('neq','');
			$map['bzjstatus'] = 1;
			
			

			if (method_exists($this, '_search_filter')) {
				$this -> _search_filter($map);
			}
			$name = $this -> getActionName();
			$model = D($name);
			$infos = M('member_group')->field('groupid,name')->select();
			foreach($infos as $k=>$v){
				$group[$v['groupid']] = $v['name'];
			}
			if (!empty($model)) {
				$this -> _list($model, $map);
			}

			$this->assign('group',$group);	
			if (!empty($model)) {
				$this -> _list($model, $map,'',1);
			}
			$this->display();
		}
		//编辑会员
		public function chekuser(){
			
			$d_id=I('id',0,'intval');
			if(empty($d_id)){
				$this->error('没有了！',U(GROUP_NAME.'/Member/uncheck'));
				exit;
					
			}
			
			
			$member = M('member')->where(array('id'=>I('id')))->find();
			if($member['checkstatus']==3){
				
				$this->error('已经审核！',U(GROUP_NAME.'/Member/check'));
					exit;	
			}
			
			//下一个会员
			
			$next_id=M('member')->where("id > {$d_id} and level > 0 and checkstatus = 0")->order('id asc')->getField('id');
			
			$this->assign('next_id',$next_id);
			$this->assign('member',$member);
			$this->display();
		}

		//编辑会员处理函数
		public function chekuserHandle(){
	        $id = I('id');
			unset($_POST['id']);
	        $data['checkstatus'] = I("post.checkstatus","","intval");
			
			if($data['checkstatus']==3){
				$data['liyou'] = '';
				$data['level'] =1;
				$info = M('member')->where(array('id'=>$id))->find();
				
                //判断升级信息
				
				 $result=reg_jl($id,1);//奖励矿机 
				 
				 if(empty($result['result'])){
						$this->error($result['msg']); 
				 }
				 //updateLevel();				
			}
			
			if($data['checkstatus']==2){
				 $data['liyou'] = I("post.liyou","","trim");	
			}
			
			
			if (M('member')->where(array('id'=>$id))->save($data)) {
				
				$next_id=M('member')->where("checkstatus = 0 and truename!='' ")->order('id asc')->getField('id');
				//$next_id=M('member')->where("level > 0 and checkstatus = 0")->order('id asc')->getField('id');
				$this->success('审核成功！',U(GROUP_NAME.'/Member/chekuser',array('id'=>$next_id)));
			}else{
				$this->error('数据没有更改！',U(GROUP_NAME.'/Member/check'));
			}
		}
		//已审核会员列表
		public function check(){
			
			$map = $this -> _search();
			$pid=I('get.pid',0,'intval');
			if(!empty($pid)){
				$map['parent_id'] = array('eq',$pid);	
			}
			$map['level'] = array('gt',0);
			$map['checkstatus'] = array('eq',3);
			$type=$_POST['type'];
			$typename=$_POST['typename'];
			
			
			
			
	        if (!empty($type) && !empty($typename)) {
	        	//$map['type'] = array("eq",$_POST['type']); 
				if($type ==1){
					$map['id']=	$typename;
				}elseif($type ==2){
					$map['truename']=$typename;	
				}elseif($type ==3){
					$map['mobile']=	$typename;	
				}elseif($type ==4){
					$map['username']=	$typename;	
				}
				
				
	        }			
			if (method_exists($this, '_search_filter')) {
				$this -> _search_filter($map);
			}
			$name = $this -> getActionName();
			
			
			$model = D($name);
			$infos = M('member_group')->field('level,name')->select();
			foreach($infos as $k=>$v){
				$group[$v['level']] = $v['name'];
			}
			$this->assign('group',$group);	
			if (!empty($model)) {
				$this -> _list($model, $map);
			}

			$this->display();
		}
		
		
		
			//已封
		public function lockuser(){
			
			$map = $this -> _search();
			$map['lock'] = array('eq',1);
			$map['level'] = array('gt',0);
			$map['checkstatus'] = array('eq',3);
			$type=$_POST['type'];
			$typename=$_POST['typename'];
			
	        if (!empty($type) && !empty($typename)) {
	        	//$map['type'] = array("eq",$_POST['type']); 
				if($type ==1){
					$map['id']=	$typename;
				}elseif($type ==2){
					$map['truename']=$typename;	
				}elseif($type ==3){
					$map['mobile']=	$typename;	
				}elseif($type ==4){
					$map['username']=	$typename;	
				}
				
				
	        }			
			if (method_exists($this, '_search_filter')) {
				$this -> _search_filter($map);
			}
			$name = $this -> getActionName();
			
			
			$model = D($name);
			$infos = M('member_group')->field('level,name')->select();
			foreach($infos as $k=>$v){
				$group[$v['level']] = $v['name'];
			}
			$this->assign('group',$group);	
			if (!empty($model)) {
				$this -> _list($model, $map);
			}

			$this->display();
		}
		
		
		public function getpnum(){
				
				$userortype_id=I('post.userortype_id',0,'intval');
				$is_include=I('post.is_include',0,'intval');
				$send_style=I('post.send_style',0,'intval');
				$num=I('post.num',0,'intval');
				
				$Member=M('member');
				$memberid_count=0;
				
				if($send_style==1){
						if($is_include==1){
							$memberid_count=$Member->where("level = {$userortype_id}")->count();
						}else{
							$send_log=M('member_award_log')->field('user_id')->where("num={$num} and send_type=1 and userortype_id={$userortype_id} and send_style = {$send_style}")->select();
							
							if(empty($send_log)){
								$memberid_count=$Member->where("level = {$userortype_id}")->count();
									
							}else{
								
								$send_log_arr=array_column($send_log,'user_id');
								$send_log_str=implode(',',$send_log_arr);
								$memberid_count=$Member->where("level = {$userortype_id} and id not in ({$send_log_str})")->count();
									
							}
							
								
						}
					
					
				}else{
					
					if($is_include==1){
							$memberid_count=$Member->where("level = {$userortype_id}")->count();
						}else{
							$send_log=M('member_award_log')->field('user_id')->where("send_type=1 and userortype_id={$userortype_id} and send_style = {$send_style}")->select();
							
							if(empty($send_log)){
								$memberid_count=$Member->where("level = {$userortype_id}")->count();	
								
							}else{
								
								$send_log_arr=array_column($send_log,'user_id');
								$send_log_str=implode(',',$send_log_arr);
								$memberid_count=$Member->where("level = {$userortype_id} and id not in ({$send_log_str})")->count();
									
							}
							
								
					}
					
					
						
					
					
				}
				
				
				
				
				
				echo json_encode(array('memberid_count'=>$memberid_count));
				exit;
				
			
		}
		
		
		
		public function award(){
			
				//会员级别
				$level_list=M('member_group')->select();
				
				$product=M('product')->where("is_on=0")->select();
				$this->assign('level_list',$level_list);
				$this->assign('product',$product);
				$this->display();
			
	    }

		public function gaward(){
			
				//会员级别
				$level_list=M('member_group')->select();
				
				$product=M('product')->where("is_on=0")->select();
				$this->assign('level_list',$level_list);
				$this->assign('product',$product);
				$this->display();
			
	    }
		public function gawardpost(){
			
				$username=I('post.username');
				$num=I('post.num',0,'intval');
				
			
				if(empty($username)){
					$this->error('请输入会员账号');	
				}
				if(empty($num)){
						$this->error('请选择铸币机');	
					}	
				
				$userinfo=M('member')->where(array('username'=>$username))->find();
				$product = M("product");
				//查询矿机信息
				$data = $product ->where(array('id'=>$num))-> find();
				if(empty($userinfo)){
					$this->error('没有该会员,请正确输入');	
				}else{
			$map = array();
			$map['kjbh'] = 'Z' . date('d') . substr(time(), -5) . sprintf('%02d', rand(0, 99));
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
			//$product->where(array("id"=>$id))->setDec("stock");
			//$parentpath = M("member")->where(array("username"=>$userinfo['username']))->getField("parentpath");
			add_award_log($userinfo['id'],1,0,1,$num);
			
				
				
				
				
				$this->success("执行成功！");
				}
			
	    }
		
		public function awardpost(){
			
				$send_type=1;
				$userortype_id=I('post.userortype_id',0,'intval');
				$send_style=I('post.send_style',1,'intval');
				$num=I('post.num',0,'intval');
				$num2=I('post.num2',0,'intval');
				$is_include=I('post.is_include',0,'intval');
				if(empty($userortype_id)){
					$this->error('请输入会员级别/会员ID');	
				}
				
				if($send_style==1){
					
					if(empty($num)){
						$this->error('请选择矿机');	
					}	
				}else{
					
					if(empty($num2)){
						$this->error('请输入金币数量');	
					}
						
				}
				
				
				$Member=M('member');
				
				
					
					if($send_style==1){//级别送矿机
						
						if($is_include==1){//包括
							
							$memberid_arr=$Member->field('id')->where("level = {$userortype_id}")->select();
							if(!empty($memberid_arr)){
								foreach($memberid_arr as $v){
									reg_jl3($v['id'],$num,1);
									add_award_log($v['id'],$send_type,$userortype_id,$send_style,$num);
								}
							}
						}else{
							
							$send_log=M('member_award_log')->field('user_id')->where("num={$num} and send_type=1 and userortype_id={$userortype_id} and send_style = 1")->select();
							if(empty($send_log)){
								$memberid_arr=$Member->field('id')->where("level = {$userortype_id}")->select();
								if(!empty($memberid_arr)){
									foreach($memberid_arr as $v){
										reg_jl3($v['id'],$num,1);
										add_award_log($v['id'],$send_type,$userortype_id,$send_style,$num);
									}
								}
							}else{
								$send_log_arr=array_column($send_log,'user_id');
								$send_log_str=implode(',',$send_log_arr);
								$memberid_arr=$Member->field('id')->where("level = {$userortype_id} and id not in ({$send_log_str})")->select();
								if(!empty($memberid_arr)){
									foreach($memberid_arr as $v){
										reg_jl3($v['id'],$num,1);
										add_award_log($v['id'],$send_type,$userortype_id,$send_style,$num);
									}
									
								}
								
									
							}
							
							
							
						}
						
					}else{//级别送金币
						
						if($is_include==1){//包括
							$memberid_arr=$Member->field('id')->where("level = {$userortype_id}")->select();
							if(!empty($memberid_arr)){
								foreach($memberid_arr as $v){
									$Member->where("id = {$v['id']}")->setInc('jinbi',$num2);
									add_award_log($v['id'],$send_type,$userortype_id,$send_style,$num2);
								}
							}
						
						}else{//不包括
							
							$send_log=M('member_award_log')->field('user_id')->where("send_type=1 and userortype_id={$userortype_id} and send_style = 2")->select();
							if(empty($send_log)){
								$memberid_arr=$Member->field('id')->where("level = {$userortype_id}")->select();
								if(!empty($memberid_arr)){
									foreach($memberid_arr as $v){
										$Member->where("id = {$v['id']}")->setInc('jinbi',$num2);
										add_award_log($v['id'],$send_type,$userortype_id,$send_style,$num2);
									}
								}
							}else{
								$send_log_arr=array_column($send_log,'user_id');
								$send_log_str=implode(',',$send_log_arr);
								$memberid_arr=$Member->field('id')->where("level = {$userortype_id} and id not in ({$send_log_str})")->select();
								if(!empty($memberid_arr)){
									foreach($memberid_arr as $v){
										$Member->where("id = {$v['id']}")->setInc('jinbi',$num2);
										add_award_log($v['id'],$send_type,$userortype_id,$send_style,$num2);
									}
									
								}
								
									
							}
							
								
						}
						
						
						
						
						
					}
					
				
				
				
				$this->success("执行成功！");
				
			
	    }
		
		
		
		
		public function awardlist(){
				
				
			$Data = M('member_award_log'); // 实例化Data数据对象
			import("@.ORG.Util.Page");// 导入分页类
			$map = array();
			if (isset($_POST['id']) && $_POST['id']!='') {
				$map['user_id'] = array("eq",$_POST['id']); 
			}
				
			$count      = $Data->where($map)->count();// 查询满足要求的总记录数
	        $Page       = new Page($count,30);// 实例化分页类 传入总记录数
	        
	        
	        $list = $Data->where($map)->order('add_time desc')->limit($Page ->firstRow.','.$Page -> listRows)->select();
			foreach($list as $k=>$v){
				$list[$k]['username'] = M('member')->where("id ={$v['user_id']}")->getField('username');
				$list[$k]['levle_name'] = M('member_group')->where("groupid ={$v['userortype_id']}")->getField('name');
				
				if($v['send_style']==1){
					$list[$k]['as_name']=M('product')->where("id ={$v['num']}")->getField('title');	
				}else{
					$list[$k]['as_name']=$v['num'];	
				}
				
				
			}
	        $show       = $Page->show();// 分页显示输出
	        $this->assign('page',$show);// 赋值分页输出
	        $this->assign('list',$list);// 赋值数据集
	        $this->display(); // 输出模板
			
		}
		
		
		
		
		
		public function setuser(){
			
			$data=I('post.');
			$mydata=array();
			$map=array();
			$user_arr=$data['userid'];
			if(empty($user_arr)){
				$this->error('请选择会员');	
			}
			if($data['set_type']==1){
					$mydata['lock']=1;
			}
			
			if($data['set_type']==2){
					$mydata['lock']=0;
			}
			$map['id'] = array('in',$user_arr);
			M('member')->where($map)->save($mydata);
			$this->success("操作成功");
				
		}
		
		
		
		
		
		
		
		
		
		
		//修改静态返利处理
		public function editFl(){
			$fl = I('get.fl',0,'intval');
			$id = I('get.id',0,'intval');
			M('member')->where(array('id'=>$id))->save(array("fl"=>$fl));
            $this->success('设置成功！',U(GROUP_NAME.'/Member/check'));

		}	
				//封号解封处理
		public function editFeng(){
			$lock = I('get.lock',0,'intval');
			$id = I('get.id',0,'intval');
			M('member')->where(array('id'=>$id))->save(array("lock"=>$lock));
            $this->success('设置成功！',U(GROUP_NAME.'/Member/check'));

		}
		//开通商户处理
		public function editshop(){
			$shopstatus = I('get.shopstatus',0,'intval');
			$id = I('get.id',0,'intval');
			M('member')->where(array('id'=>$id))->save(array("shopstatus"=>$shopstatus));
            $this->success('商户开通成功！',U(GROUP_NAME.'/Member/check'));

		}
		/**
		 * 金币充值
		 * @return [type] [description]
		 */
		public function addJinbi(){
			$member = M('member')->where(array('id'=>I('get.id',0,'intval')))->find();
			
			$map['desc'] = '平台充值';
			$map['member'] = $member['username'];
			$list = M("jinbidetail")->where($map)->order("id desc")->select();
			$this->assign('list',$list);	
            $this->assign('member',$member);			
			$this->display();
		}

		/**
		 * 金币充值处理函数
		 * @return [type] [description]
		 */
		public function addJinbiHandle(){
			$userid = I('post.id',0,'intval');
			 $jinbi  = I('post.jinbi',0,'intval');
			
			$member = M('member')->where(array('id'=>$userid))->find();
			if($jinbi>0){
		        M('member')->where(array('id'=>$userid))->setInc('jinbi',$jinbi);
				//写入充值记录
				$data            = array();
				$data['member']  = $member['username'];
				$data['adds']     = $jinbi;
				$data['balance'] = $member['jinbi'] + $jinbi;
				$data['addtime'] = time();
				$data['desc']    = '平台充值';
				M('jinbidetail')->add($data);
				$this->success('充值成功！',U(GROUP_NAME.'/Member/check'));
			}elseif($jinbi<0){
				$oldjinbi =$member['jinbi'];
				$jinbi =abs($jinbi);
                 M('member')->where(array('id'=>$userid))->setDec('jinbi',$jinbi);
				$data = array();
				$data['member']  = $member['username'];
				$data['reduce']  = $jinbi;
				$data['balance'] = (floatval($oldjinbi) - floatval($jinbi));
				$data['addtime'] = time();
				$data['desc']    = '平台充值';
				M('jinbidetail')->add($data);		
                $this->success('扣除成功！',U(GROUP_NAME.'/Member/check'));				
				
			}
			
		}
		/**
		 * 报单中心处理函数
		 * @return [type] [description]
		 */
		public function addBaodan(){
			$member = M('member')->where(array('id'=>I('get.id',0,'intval')))->find();
			$this->assign('member',$member);
			$this->display();
		}
		/**
		 * 报单中心处理函数
		 * @return [type] [description]
		 */
		public function addBaodanHandle(){
			$userid = I('post.id',0,'intval');
			$jinbi  = I('post.baodan',0,'intval');
			$member = M('member')->where(array('id'=>$userid))->find();
			$member = M("member"); // 实例化User对象
			// 要修改的数据对象属性赋值
			$data['isbaodan'] = $jinbi;
			$member->where('id='.$userid)->save($data); // 根据条件保存修改的数据
			$this->success('设置成功！',U(GROUP_NAME.'/Member/check'));
		}
    //删除未审核会员
    public function deleteGroup(){
        $member_group = M('member_group');
		$groupid = $_GET['groupid'];
		$info = $member_group->where(array('groupid'=>$groupid))->find();
		if(!$info){
			alert('此会员组信息不存在!',U(GROUP_NAME.'/Member/member_group'));
		}
		$list = $member_group->where("`level` >$info[level] ")->select();
		if(count($list)>0){
			alert('请先删除level级更高的会员组',U(GROUP_NAME.'/Member/member_group'));
			die;
		}
        if($member_group->where(array('groupid'=>$groupid))->delete()) {
            alert('刪除成功！',U(GROUP_NAME.'/Member/member_group'));
        }else{
            alert('刪除失败！',U(GROUP_NAME.'/Member/member_group'));
        }
    }
		//编辑会员
		public function editMember(){
			$member = M('member')->where(array('id'=>I('id')))->find();
			$list = M('member_group')->select();
			$this->assign('list',$list);
			$this->assign('member',$member);
			$this->display();
		}

		//编辑会员处理函数
		public function editMemberHandle(){
			$password = I('password');
			$password2 = I('password2');
			$level = I('level');
			$truename = I('truename');
			
			$id = I('id');
			unset($_POST['id']);
			if ($password!= '') {
				$_POST['password'] = md5($password);
			}else{
				unset($_POST['password']);
			}
			if ($password2 != '') {
				$_POST['password2'] = md5($password2);
			}else{
				unset($_POST['password2']);
			}
			if ($level != '') {
				$_POST['level'] = $level;
			}else{
				unset($_POST['level']);
			}
			if ($level != '') {
				$_POST['truename'] = $truename;
			}else{
				unset($_POST['truename']);
			}
			if (M('member')->where(array('id'=>$id))->save($_POST)) {
				$this->success('编辑成功！',U(GROUP_NAME.'/Member/check'));
			}else{
				$this->error('数据没有更改！',U(GROUP_NAME.'/Member/check'));
			}
		}

		/**
		 * 后台直接跳转到会员前台
		 * @return [type] [description]
		 */
		public function inMember(){
			$username = I('get.u');
			$uid = M('member')->where(array('username'=>$username))->getField('id');
			session('mid',$uid);
			session('username',$username);
			session('usersecondlogin','1');
			session('member','adminlogin');
			$this->redirect('Index/Index/index');
		}

		//删除会员
		public function deleteMember(){
			$member = M('member');
			$minfo = $member->where(array('id'=>I('get.id',0,'intval')))->find();
			if ($member->where(array('id'=>$_GET['id'],'status'=>0))->delete()) {
				//更新安置人左右区信息
				if ($minfo['my_jd'] == 'left') {
					$data['left'] = array('exp','null');
					$member->where(array('username'=>$minfo['fparent']))->save($data);
				}else if($minfo['my_jd'] == 'right'){
					$data['right'] = array('exp','null');
					$member->where(array('username'=>$minfo['fparent']))->save($data);
				}
				alert('删除成功！',U(GROUP_NAME.'/Member/uncheck'));
			}else{
				alert('删除失败！',U(GROUP_NAME.'/Member/uncheck'));
			}			
		}
		
	    //树形图
		public function shu_list(){
			Vendor('Tree.tree');
			$menu = new tree;
				$menu->icon = array('│ ','├─ ','└─ ');
				$menu->nbsp = '&nbsp;&nbsp;&nbsp;';
				$result = M('member')->field('id,username,parentcount,parent')->select();
				foreach($result as $k=>$v){
					 
					 $arr[$v['username']] = $v;
					 $arr[$v['username']]['parentid_node'] = ($v['parent'])? ' class="child-of-node-'.$v['parent'].'"' : '';
				}
				$str  = "<tr id='node-\$username' \$parentid_node>
							<td style='padding-left:30px;'>\$spacer 会员编号：\$username (直推人数：\$parentcount)</td>
						</tr>";
			     
				$menu->init($arr);
				$categorys = $menu->get_tree(NULL, $str);		
                $this->assign('categorys',$categorys);					
			    $this->display();
		}	   
		//会员组列表
		public function member_group(){
			$list = M('member_group')->select();
			$this->assign('list',$list);			
			$this->display('member_group_list');
		}

		//添加会员组
		public function add_member_group(){
			$list = M('member_group')->select();
			$count = count($list)+1;
			$this->assign('level',$count);
			$this->display('add_member_group');
		}
		
		//添加会员组表单处理
		public function addGroupHandle(){
			for($i=0;$i<count($_POST['dai_content']);$i++){
				if(empty($_POST['dai_content'][$i])){
					$this->error('代奖参数不能为空');
				}				 
			}

			$_POST['dai_content'] = implode(",",$_POST['dai_content']);
			$_POST['addtime'] = NOW_TIME;
			if (M('member_group')->add($_POST)) {
				//添加日志操作
				$desc = '添加一个新的会员组';
				write_log(session('username'),'admin',$desc);
               $this->success('添加成功',U(GROUP_NAME.'/Member/member_group'));
			}else{
				$this->error('添加失败');
			}
		}	
        //修改会员组
      	public function	editMemberGroup(){
			$member_group = M('member_group')->where(array('groupid'=>I('groupid')))->find();
			$member_group['dai_content'] = explode(",",$member_group['dai_content']);
			$this->assign('member_group',$member_group);			
			$this->display('editMemberGroup');
		}
		//修改会员组处理
		public function editGroupHandle(){
			$groupid = I('groupid',0,'intval');
			unset($_POST['groupid']);
			$_POST['dai_content'] = implode(",",$_POST['dai_content']);
			M('member_group')->where(array('groupid'=>$groupid))->save($_POST);
			//添加日志
			$desc = '修改ID为'. $groupid .'的会员组';
			write_log(session('username'),'admin',$desc);

			$this->success('会员组修改成功!',U(GROUP_NAME.'/Member/member_group'));

		}			
		
		//异步验证用户组是否存在
		public function checkGroupName(){
			//判断是否异步提交
			IS_AJAX or halt('对不起，页面不存在');

			if (M('member_group')->where(array('name'=>I('name')))->getField('groupid')) {
				echo 'false';
			}else{
				echo 'true';
			}
		}	
        //激活码列表		
		public function pin_list(){

				$pin = M("pin");
				$num =$_POST['pin'];
				$level = $_POST['dai_num'];
				if(!empty($num)){
				   $map['pin'] = array('eq',$num);
				   $this->assign('num',$num);	
				}
				if($level!=0){
					$map['level'] = array('eq',$level);
					$this->assign('level',$level);	
				}				
				import('ORG.Util.Page');
				$count = $pin -> where($map)->count();
				$Page = new Page($count,10);
				$show = $Page -> show();
				$list = $pin -> where($map) -> limit($Page ->firstRow.','.$Page -> listRows)->order('id desc') -> select();
				$infos = M('member_group')->select();
				foreach($infos as $k=>$v){
					$group[$v['groupid']] = $v['name'];
				}
				$this->assign('group',$group);	
				$this->assign('infos',$infos);	
				$this->assign('list',$list);
				$this -> assign("page",$show);
				$this -> assign("list",$list);
				$this -> display(); 

		}
        //激活码生成
        public function pinAdd(){
			$list = M('member_group')->select();
			$this->assign('list',$list);				
			
			$this -> display(); 
			
		}	
        public function pinaddHandle(){
            $data_P = I('post.');
            if (!preg_match('/^[0-9.]{1,10}$/', $data_P ['number'])) {
                   $this->error('请填生成数量！');
            } else {
                 $cgsl = 0;
                 for ($i = 0; $i < $data_P ['number']; $i++) {
                       $pin = md5(sprintf("%0" . strlen(9) . "d", mt_rand(0, 99999999999)));
                       if (!M('pin')->where(array('pin' => $pin))->find()) {                           
					        $data['pin'] = substr($pin,0,28);
                            $data['sc_date'] = NOW_TIME;
                            $data['level'] = $data_P['level'];
						   if (M('pin')->add($data)) {
									 $cgsl++;
						   }

                       }
                 }

                 $this->success('成功添加激活码' . $cgsl . '个',U(GROUP_NAME.'/Member/pin_list'));

            }			
			
		}
		public function deletePin(){


			$User = M('user'); // 實例化User對象

			$data = I('get.id');


			if (M('pin')->where(array('id' => $data))->delete()) {

				$this->success('删除成功!');

			} else {

				$this->success('删除失败!');

			}


		}	

		
		//金字塔排位图
	  public function pw_list(){
		
			//塔顶成员信息
			$memberinfo =  M('member')->where(array('username'=>889001))->find();
			//获取下层成员
			$xiaceng = all_member_down(array($memberinfo['left'],$memberinfo['right']));
			if(empty($_GET['cs'])){
				$username = $memberinfo['username'];//如果为空默认塔顶成员
			}else{
				$username = I('get.cs','','htmlspecialchars'); //选取塔顶信息
				if(!in_array($username,$xiaceng)){
						$username = $memberinfo['username'];
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
		   $px = C('px');
		   $link = U(GROUP_NAME.'/Member/pw_list',array('cs'=>$o[username]));
		   $top_link = U(GROUP_NAME.'/Member/pw_list',array('cs'=>$o['fparent']));
		   //折线
		   if($n<=3){
		     $table ="<table class=\"table table-bordered\" style=\"border: none;width: {$px[$xulie]['xheight']}px;position: absolute;top: {$px[$xulie]['xtop']}px;left: {$px[$xulie]['xleft']}px;height: 20px;\"><tbody><tr><td style=\"border-left: none;\"></td><td></td></tr><tr><td colspan=\"2\" style=\"border-right: 1px solid #ddd;\"></td></tr></tbody></table>";
		   }else{
			  $table =""; 
		   }
			
			$groupname = xian($o[ji]);
		   if($n==1){
			   $class = "btn-danger";
			   $str = "<style>.btn-inverse {width: 150px;}</style><div onclick='location.href=\"{$top_link}\"' style=\"cursor: pointer;position:absolute; top:{$px[$xulie]['top']}px; left:{$px[$xulie]['left']}px;width:150px\" ><div class=\"box border inverse\"><div class=\"box-body\">
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
	            $login = U('inMember',array('u'=>$reg));
			    $str .="<span style=\"position:absolute; top:{$px[$xulie]['top']}px; left:{$px[$xulie]['left']}px;\"><button id='loading-btn' type='button' class='btn {$class}' onclick='window.open(\"{$login}\")'>未加入</button></span>";
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