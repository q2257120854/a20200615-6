<?php  
	/**
	 * 会员前台注册新会员
	 */
	Class UserRegAction extends CommonAction{

		public function reg(){
			$reg = A('Reg','Action',1);
			$reg->index();
		}

		/**
		 * 调用公共控制器中的方法
		 * @return [type] [description]
		 */
		public function regHandle(){
			$reg = A('Reg','Action',1);
			$reg->regHandle();
		}

	}
?>