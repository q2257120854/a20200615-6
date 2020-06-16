<?php  
	/**
	 * 公告、消息控制器
	 */
	Class InfoAction extends CommonAction{

		/**
		 * 公司公告视图
		 * @return [type] [description]
		 */
		public function news(){
			$ann = M('announce')->where(array('tid'=>3))->order('addtime desc')->select();
			$this->assign('ann',$ann);
			$this->display();
		}

		/**
		 * 留言信息
		 * @return [type] [description]
		 */
		public function box(){
			$msg = M('message')->where(array('from'=>session('account')))->order(array('id'=>'desc'))->select();
			$this->assign('msg',$msg);
			$this->display();
		}

		/**
		 * 发送留言视图
		 */
		public function seedMsg(){
			$this->display();
		}

		/**
		 * 发送留言处理函数
		 * @return [type] [description]
		 */
		public function seedMsgHandle(){
			$_POST['to'] = 'admin';
			$_POST['sendtime'] = time();

			if (M('message')->add($_POST)) {
				$this->success('发送成功！');
			}else{
				$this->error('发送失败');
			}
		}

		/**
		 * 异步读取信息
		 */
		public function ajaxMsg(){
			//判断是否异步提交
			IS_AJAX or halt('对不起，页面不存在');

			$msg = M('message'); 
			$data = $msg->where(array('id'=>I('id')))->find();
			$data['content'] = stripslashes($data['content']);
			$this->ajaxReturn($data,'JSON');
		}

		/**
		 * 会员删除留言
		 */
		public function deleteSeedMsg(){
			if (M('message')->where(array('id'=>I('id',0,'intval')))->delete()) {
				$this->success('删除成功！',U(GROUP_NAME.'/Info/box'));
			}else{
				$this->error('删除失败！');
			}
		}


	}
?>