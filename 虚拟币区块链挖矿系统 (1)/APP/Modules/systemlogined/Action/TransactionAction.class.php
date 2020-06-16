<?php  
	Class TransactionAction extends CommonAction{

		//担保交易记录
		public function guarantee(){
			$map = $this -> _search();

			if (method_exists($this, '_search_filter')) {
				$this -> _search_filter($map);
			}
			$name = 'guarantee';
			$model = D($name);

			if (!empty($model)) {
				$this -> _list($model, $map);
			}
			$this->display();
		}

		//金币买卖记录
		public function business(){
			$map = $this -> _search();

			if (method_exists($this, '_search_filter')) {
				$this -> _search_filter($map);
			}
			$name = 'business';
			$model = D($name);

			if (!empty($model)) {
				$this -> _list($model, $map);
			}
			$this->display();
		}

		/**
		 * 强制取消金币卖出交易
		 * @return [type] [description]
		 */
		public function cancelBusiness(){
			$id = I('get.id',0,'intval');
			$bus_obj = M('business');
			$mem_obj = M('member');
			$b_info = $bus_obj->where(array('id'=>$id))->find();
			if ($b_info['status'] == '交易取消') {
				$this->error('对不起，当前交易已取消，请不要重复操作！');
			}
			//改变状态
			$bus_obj->where(array('id'=>$id))->setField('status','交易取消');
			$oldjinbi = $mem_obj->where(array('username'=>$b_info['seller']))->getField('jinbi');
			//添加交易记录
			$data = array();
			$data['member'] = $b_info['seller'];
			$data['adds'] = $b_info['qty'];
			$data['balance'] = floatval($b_info['qty']) + $oldjinbi;
			$data['addtime'] = time();
			$data['desc'] = '金币卖出交易取消，退回金币';
			M('jinbidetail')->add($data);
			//更新卖家余额
			$mem_obj->where(array('username'=>$b_info['seller']))->setInc('jinbi',$b_info['qty']);
			$this->success('取消交易成功！');
		}


		/**
		 * 强制取消担保交易
		 * @return [type] [description]
		 */
		public function cancelGuarantee(){
			$id = I('get.id',0,'intval');
			$bus_obj = M('guarantee');
			$mem_obj = M('member');
			$b_info = $bus_obj->where(array('id'=>$id))->find();
			if ($b_info['status'] == '交易取消') {
				$this->error('对不起，当前交易已取消，请不要重复操作！');
			}
			//改变状态
			$bus_obj->where(array('id'=>$id,''))->setField('status','交易取消');
			$oldjinbi = $mem_obj->where(array('username'=>$b_info['seller']))->getField('jinbi');
			//添加交易记录
			$data = array();
			$data['member'] = $b_info['seller'];
			$data['adds'] = $b_info['qty'];
			$data['balance'] = floatval($b_info['qty']) + $oldjinbi;
			$data['addtime'] = time();
			$data['desc'] = '担保交易取消，退回金币';
			M('jinbidetail')->add($data);
			//更新卖家余额
			$mem_obj->where(array('username'=>$b_info['seller']))->setInc('jinbi',$b_info['qty']);
			$this->success('取消交易成功！');
		}



	}
?>