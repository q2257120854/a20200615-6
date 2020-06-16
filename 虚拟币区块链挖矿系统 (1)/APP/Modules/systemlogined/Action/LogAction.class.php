<?php
	/**
	 * 系统日志控制器
	 */
	Class LogAction extends CommonAction{

		//清空日志
		public function deleteLog(){
			if (M('log')->where('id > 0')->delete()) {
				//添加日志操作
				$desc = '管理员['.session('username').']清空日志';
				write_log(session('username'),'admin',$desc);

				$this->success('删除成功',U(GROUP_NAME.'/Log/index'));
			}else{
				$this->error('删除日志失败');
			}
		}
	}