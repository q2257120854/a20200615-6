<?php  
	
	/**
	 * 前后台公共注册控制器
	 */
	Class RegAction extends Action{
		/**
		 * 会员注册
		 * @return [type] [description]
		 */
		public function index(){
			//验证是否允许注册
			if (C('MEMBER_REG') == 'off') {
				$this->error(C('NO_REG_MSG'));
			}
			
			$upbh = I('get.upbh','','strval');//安置人编号
			$loginmode = I('get.loginmode','user','strval');//模式	user:会员 admin:后台
			
			include APP_PATH.'Common/treeconn.php';
			$tree_obj = get_now_tree($trees);
			$sale_obj = $this->get_reg_sale($tree_obj, true);
			p($sale_obj);die;
			
			//如果注册上级编号不为空的情况下
			if ($upbh != '') {
				$upcnname = M($tree_obj->tablename)->where(array('account'=>$upbh))->getField('name');
				
				
			}
			
			session('reg_account',create_account($tree_obj));
			$this->assign('newaccount',session('reg_account'));
			$this->display();
		}

		/**
		 * 公共注册处理函数
		 * @return [type] [description]
		 */
		public function regHandle(){
			p($_POST);
			die;
		}
		
		//获得注册报单对象
		function get_reg_sale($tree_obj,$star_bool){
			$loginmode = I('get.loginmode','','strval');
			$saleid = I('saleid',0,'intval');
			
			if ($saleid == '' || !is_numeric($saleid)) {
				$this->error('注册报单参数错误');	
			}
			if ($tree_obj->salenum < $saleid || $saleid < 0) {
				$this->error('报单参数越界');
			}
			if ($tree_obj->sale[$saleid]->mode != 0) {
				$this->error('非注册型的报单参数');
			}
			//判断后台，暂不处理
			//......
			
			if (!($tree_obj->sale[$saleid]->use)) {
				$this->error('此报单项目前为关闭状态');
			}
			$getregsale = $tree_obj->sale[$saleid];
			
			if ($getregsale->guestreg) {
				$loginmode = 'user';
			}
			
			
			if ($star_bool) {
				if (session('reg_treename') != $tree_obj->tablename || session('reg_saleid') != $saleid ) {
					session('reg_treename',$tree_obj->tablename);
					session('reg_saleid',$saleid);
				}
			}else{
				if (session('reg_treename') != $tree_obj->tablename || session('reg_saleid') != $saleid ) {
					$this->error('操作超时，请重新填写数据');
				}
			}
			return $getregsale;
		}


	}
?>