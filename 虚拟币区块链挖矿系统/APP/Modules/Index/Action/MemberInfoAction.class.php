<?php  
	
	/**
	 * 会员信息控制器
	 */
	Class MemberInfoAction extends CommonAction{
		/**
		 * 我的资料
		 * @return [type] [description]
		 */
		public function index(){
			$member = M('member')->where(array('id'=>session('mid')))->find();
			$this->assign('v',$member);
			$this->display();
		}

		/**
		 * 编辑会员信息视图
		 * @return [type] [description]
		 */
		public function editMemberInfo(){
			$member = M('member')->where(array('id'=>session('mid')))->find();
			$this->assign('v',$member);
			$this->display();
		}

		/**
		 * [编辑会员信息处理]
		 * @return [type] [description]
		 */
		public function editMemberInfoHandle(){
			$result = M('member')->where(array('id'=>session('mid')))->save($_POST);
			if ($result !== false) {
				$this->success('修改成功',U(GROUP_NAME.'/MemberInfo/editMemberInfo'));
			}else{
				$this->error('修改失败');
			}
			
		}

		/**
		 * 编辑密码视图
		 */
		public function editMemberPwd(){
			$this->display();
		}

		/**
		 * [编辑会员密码处理]
		 * @return [type] [description]
		 */
		public function editMemberPwdHandle(){

			IS_POST or halt('页面不存在');

			I('newloginpwd') != I('newloginpwded') and $this->error('两次密码不一致');
			I('newsafepwd') != I('newsafepwded') and $this->error('两次密码不一致');
			
			$db = M('member');
			//修改登录密码
			if (I('post.oldloginpwd') != '' && I('post.newloginpwd') !='' ) {
				//验证旧登录密码
				$old = $db->where(array('id' => session('mid')))->getField('password');
				if (I('post.oldloginpwd','','md5') != $old) {
					$this->error('旧密码错误');
				}

				if ($db->where(array('id'=>session('mid')))->save(array('password'=>I('post.newloginpwd','','md5')))) {
					$this->success('修改成功');
				}else{
					$this->error('修改失败');
				}
			}
			//修改二级密码
			if (I('post.oldsafepwd') != '' && I('post.newsafepwd') !='' ) {
				//验证旧安全密码
				$old = $db->where(array('id' => session('mid')))->getField('password2');
				if (I('post.oldsafepwd','','md5') != $old) {
					$this->error('旧密码错误');
				}
				$result = $db->where(array('id'=>session('mid')))->save(array('password2'=>I('post.newsafepwd','','md5')));
				if ($result !== false) {
					$this->success('修改成功');
				}else{
					$this->error('修改失败');
				}
			}



		}
     
	}
?>