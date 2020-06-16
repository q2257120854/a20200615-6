<?php  
	//消息相关控制器
	Class MsgAction extends CommonAction{

		//联系我们
		public function index(){
			$this->display();
		}

		//提交留言
		public function addMsg(){
            
			
			
			
			
			if (IS_POST) {
				
				$title=I('title','','htmlspecialchars');
				$content=I('content','','htmlspecialchars');
				
				if(empty($title)){
					alert('请输入标题',U('Index/Msg/addMsg'));
				}
				if(empty($content)){
					alert('请输入内容',U('Index/Msg/addMsg'));
				}
				$data['sendtime'] = time();
				$data['from'] = session('username');
				$data['subject'] = $title;
				$data['content'] = $content;
				$data['status'] = '处理中';
				if(M('message')->add($data)){
					alert('留言成功！请等待客服回复！',U('Index/Msg/msgList'));
				}else{
					alert('留言失败',U('Index/Msg/addMsg'));
				}
			}		
			$this->display();
		}

		//查看留言
		public function viewMsg(){
			$msg = M('message')->where(array('id'=>$_GET['id']))->find();
			$this->assign('msg',$msg);
			$this->display();
		}

		//关闭留言
		public function closeMsg(){
			$data['status'] = '已关闭';
			$data['writetime'] = time();
			$data['reply'] = '备注：此留言被玩家自行关闭无需处理！';
			if (M('message')->where(array('id'=>$_GET['id']))->save($data)) {
				alert('操作成功！',U('Index/Msg/msgList'));
			}
		}

		//留言记录
		public function msgList(){
      		import('ORG.Util.Page');
			 $count = M('message')->where(array('from'=>session('username')))->count();
        	 $page = new Page($count,15);
       	     $show = $page->show();// 分页显示输出
			
			$list = M('message')->where(array('from'=>session('username')))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('list',$list);
			$this->assign('page',$show);
			$this->display();
		}
	}
?>