<?php  
	
	Class PublicAction extends CommonAction{
		/**
		 * 通用左边页面
		 * @return [type] [description]
		 */
		public function left(){
			$member = M('member')->field(array('regtime','emoney','sumbonus'))->where(array('id'=>session('mid')))->find();
			$this->assign('mem',$member);
			$this->display('left.html');
		}

		public function success(){
			$this->display();
		}

	}

?>