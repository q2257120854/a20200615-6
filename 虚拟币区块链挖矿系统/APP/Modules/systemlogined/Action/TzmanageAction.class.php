<?php
class TzmanageAction extends CommonAction {
        public function index(){
			
			$jijin = M("jijin");
		    import('ORG.Util.Page');
			$count = $jijin -> count();
			$Page = new Page($count,20);
			$show = $Page -> show();
			$list = $jijin ->  limit($Page ->firstRow.','.$Page -> listRows)->order('date desc') -> select();
            $this -> assign("page",$show);
			$this -> assign("list",$list);
			$this -> display(); 			
			
		}
 		//添加投资类型
		public function add_txlx(){
			
			$this->display('add_txlx');
		}
		
		//添加表单处理
		public function add_txlxHandle(){

			$_POST['date'] = strtotime($_POST['date']);
			if (M('jijin')->add($_POST)) {
				//添加日志操作
				$desc = '添加一个基金日参数';
				 write_log(session('username'),'admin',$desc);
                 $this->success('添加成功',U(GROUP_NAME.'/Tzmanage/index'));
			}else{
				$this->error('添加失败');
			}
		}	
        //修改每日参数
      	public function	edit_txlx(){
			$jijin = M('jijin')->where(array('id'=>I('id')))->find();
			$this->assign('Tzmanage',$jijin);			
			$this->display('edit_txlx');
		}
		//修改每日参数操作
		public function edit_txlxHandle(){
			$id = I('id',0,'intval');
			unset($_POST['id']);
			$_POST['date'] = strtotime($_POST['date']);
			M('jijin')->where(array('id'=>$id))->save($_POST);
			//添加日志
			$desc = '修改ID为'. $id .'的基金参数';
			write_log(session('username'),'admin',$desc);

			$this->success('修改成功!',U(GROUP_NAME.'/Tzmanage/index'));

		}		
		
		//异步验证用户组是否存在
		public function checkJdate(){
			//判断是否异步提交
			IS_AJAX or halt('对不起，页面不存在');
            $date = strtotime($_POST['date']);
			if (M('jijin')->where(array('date'=>$date))->getField('id')) {
				echo 'false';
			}else{
				echo 'true';
			}
		}
		//删除一个广告
		public function del_txlx(){
			$id = I('id');
			$jijin = M("jijin");
			$map['id'] = array('in',$id);
			if($jijin -> where($map) -> delete($id)){
					//添加日志操作
					$desc = '删除一个基金参数';
					write_log(session('username'),'admin',$desc);
					$this->success('删除成功',U(GROUP_NAME.'/Tzmanage/index'));
			}else{
				$this -> error("删除失败");
			}
		}		
		//日曲线
		public function day_quxian(){
			$id = I('id',0,'intval');
			$list = M('day_quxian')->where(array('tid'=>$id))->select();
	
			$this->assign('list',$list);			
			$this->display('day_quxian');
		}
		//日曲线修改
		public function edit_day_quxian(){
			$day_quxian = M('day_quxian')->where(array('id'=>I('id')))->find();
			$this->assign('quxian',$day_quxian);				
			$this->display();
		}

	   //日曲线表单处理
		public function quxianHandle(){
			
			$id = I('id',0,'intval');
			unset($_POST['id']);
			$_POST['a'] = $_POST['ab'];
			$_POST['b'] = $_POST['bb'];
			$_POST['c'] = $_POST['cb'];
			$_POST['d'] = $_POST['db'];	
			$_POST['e'] = $_POST['eb'];
			$_POST['f'] = $_POST['fb'];
			$_POST['g'] = $_POST['gb'];
			$_POST['h'] = $_POST['hb'];		
            $_POST['i'] = $_POST['ib'];				
			M('day_quxian')->where(array('id'=>$id))->save($_POST);
			//添加日志
			$desc = '修改ID为'. $id .'的日曲线参数';
			write_log(session('username'),'admin',$desc);

			$this->success('曲线参数修改成功!',U('Admin/Tzmanage/day_quxian',array('id'=>$id)));
		}
		//月曲线
		public function month_quxian(){
			$id = I('id',0,'intval');
			$list = M('month_quxian')->where(array('tid'=>$id))->select();
	
			$this->assign('list',$list);			
			$this->display('month_quxian');
		}
		//月曲线修改
		public function edit_month_quxian(){
			$month_quxian = M('month_quxian')->where(array('id'=>I('id')))->find();
			$month_quxian['content'] = explode(",",$month_quxian['content']);
			$this->assign('quxian',$month_quxian);				
			$this->display();
		}

	   //月曲线表单处理
		public function MonthquxianHandle(){
			
			$id = I('id',0,'intval');
			unset($_POST['id']);
            $content = $_POST['content'];
			foreach($content as $k=>$v){
				
				if($v<=0){
					$this->error('不能小于等于0');
				}
			}
			 $_POST['content'] = implode(",",$_POST['content']);
			M('month_quxian')->where(array('id'=>$id))->save($_POST);
			//添加日志
			$desc = '修改ID为'. $id .'的月曲线参数';
			write_log(session('username'),'admin',$desc);

			$this->success('曲线参数修改成功!',U('Admin/Tzmanage/month_quxian',array('id'=>$id)));
		}		
}
