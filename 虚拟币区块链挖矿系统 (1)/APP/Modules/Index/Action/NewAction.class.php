<?php  
	
	Class NewAction extends CommonAction{

		//公告详细页
		public function newsView(){
			$new = M('announce')->where(array('id'=>I('id')))->find();
			$this->assign('new',$new);
			$this->display();
		}

		//公告列表页
		public function news(){
			$news = M('announce');
			$announce_click=M('announce_click');
			$user_id=session('mid');
			import('ORG.Util.Page');
			$count = $news->count();
			$Page  = new Page($count,10);
			$show  = $Page->show();
			$list = $news->order('addtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			//写入已读
			foreach($list as $v){
				$is_in=$announce_click->where("user_id = {$user_id} and news_id = {$v['id']}")->count();
				if(empty($is_in)){
					$data=array();
					$data['user_id']=$user_id;
					$data['news_id']=$v['id'];
					$announce_click->add($data);	
				}
					
				
			}
			
			
			
			
			
			$this->assign('list',$list);
			$this->assign('page',$show); 
			$this->display();
		}

		public function newsdetails(){
			
			$news_id=I('get.news_id',0,'intval');
			if(empty($news_id)){
				$this->error('页面不存在！');	
				
			}	
			
			$new=M('announce')->where("id = {$news_id}")->find();
			
			
			$this->assign('new',$new);
			$this->display('newsview');
			
		}
		
		
		
		/**
		 * 会员前台帮助中心
		 * @return [type] [description]
		 */
		public function help(){
			$news = M('announce');
			import('ORG.Util.Page');
			$count = $news->where(array('tid'=>7))->count();
			$page  = new Page($count,12);
			$show  = $page->show();
			$list  = $news->where(array('tid'=>7))->order('id desc')->limit($page->firstRow.','.$page->listRows)->select();
			$this->assign('list',$list);
			$this->assign('page',$show);
			$this->display();
		}


	}