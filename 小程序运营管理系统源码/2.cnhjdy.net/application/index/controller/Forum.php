<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Forum extends Controller
{
	public function func()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_6036=input('appletid');
				$var_6037=Db::table('applet')->where('id',$var_6036)->find();
				if(!$var_6037)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6037);
				$var_6038=Db::table('ims_sudu8_page_forum_func')->where('uniacid',$var_6036)->order('num desc')->paginate(10,false,['query' =>array('appletid'=>input('appletid'))]);
				$var_6039=Db::table('ims_sudu8_page_forum_func')->where('uniacid',$var_6036)->order('num desc')->count();
				$var_6040=$var_6038->toArray()['data'];
				foreach($var_6040 as $var_6041=>&$var_6042)
				{
					$var_6042['func_img']=remote($var_6036,$var_6042['func_img'],1);
				}
				$this->assign(func,$var_6040);
				$this->assign('listV',$var_6038);
				$this->assign('counts',$var_6039);
			}
			else
			{
				$var_6043=Session::get('usergroup');
				if($var_6043==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6043==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6043==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(func);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function funcAdd()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_6045=input('appletid');
				$var_6046=Db::table('applet')->where('id',$var_6045)->find();
				if(!$var_6046)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6046);
				$var_6047=input('func_id');
				$var_6048=Db::table('ims_sudu8_page_forum_func')->where('id',$var_6047)->where('uniacid',$var_6045)->find();
				if($var_6048)
				{
					$var_6048['func_img']=remote($var_6045,$var_6048['func_img'],1);
				}
				$this->assign(func,$var_6048);
				$this->assign('func_id',$var_6047);
			}
			else
			{
				$var_6049=Session::get('usergroup');
				if($var_6049==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6049==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6049==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(funcAdd);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function funcSave()
	{
		$var_6050=array();
		$var_6050['uniacid']=input('appletid');
		$var_6051=input('num');
		if($var_6051)
		{
			$var_6050['num']=$var_6051;
		}
		$var_6052=input('status');
		if($var_6052===null)
		{
			$var_6050['status']=1;
		}
		else
		{
			$var_6050['status']=$var_6052;
		}
		$var_6050['title']=input('title');
		$var_6053=input('commonuploadpic');
		if($var_6053)
		{
			$var_6050['func_img']=remote($var_6050['uniacid'],$var_6053,2);
		}
		$var_6050['title']=input('title');
		$var_6054=input('func_id');
		$var_6050['page_type']=input('page_type');
		$var_6050['createtime']=date('Y-m-d H:i:s',time());
		if($var_6054>0)
		{
			$var_167=Db::table('ims_sudu8_page_forum_func')->where('id',$var_6054)->update($var_6050);
		}
		else
		{
			$var_167=Db::table('ims_sudu8_page_forum_func')->insert($var_6050);
		}
		if($var_167)
		{
			$this->success('功能信息更新成功！',Url('Forum/func').'?appletid='.$var_6050['uniacid']);
		}
		else
		{
			$this->error('功能信息更新失败，没有修改项！');
			exit;
		}
	}
	public function checktitle()
	{
		$var_6056=input('title');
		$var_6057=input('uniacid');
		$var_6058=Db::table('ims_sudu8_page_forum_func')->where('title',$var_6056)->where('uniacid',$var_6057)->find();
		if($var_6058)
		{
			echo 1;
		}
		else
		{
			echo 2;
		}
	}
	public function funcDel()
	{
		$var_6060=input('func_id');
		$var_327=Db::table('ims_sudu8_page_forum_func')->where('id',$var_6060)->delete();
		if($var_327)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->success('删除失败');
		}
	}
	public function set()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_6061=input('appletid');
				$var_6062=Db::table('applet')->where('id',$var_6061)->find();
				if(!$var_6062)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6062);
				$var_391=Db::table('ims_sudu8_page_forum_set')->where('uniacid',$var_6061)->find();
				$this->assign(set,$var_391);
			}
			else
			{
				$var_6063=Session::get('usergroup');
				if($var_6063==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6063==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6063==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(set);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function setsave()
	{
		$var_6065=input('appletid');
		$var_6066=input('release_money');
		$var_629=input('stick_money');
		$var_6067=array('release_money' =>$var_6066,'stick_money' =>$var_629);
		$var_6068=Db::table('ims_sudu8_page_forum_set')->where('uniacid',$var_6065)->find();
		if($var_6068)
		{
			$var_628=Db::table('ims_sudu8_page_forum_set')->where('uniacid',$var_6065)->update($var_6067);
		}
		else
		{
			$var_6067['uniacid']=$var_6065;
			$var_628=Db::table('ims_sudu8_page_forum_set')->insert($var_6067);
		}
		if($var_628)
		{
			$this->success('设置修改成功');
		}
		else
		{
			$this->error('设置修改失败');
		}
	}
	public function release()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_14=input('appletid');
				$var_6070=Db::table('applet')->where('id',$var_14)->find();
				if(!$var_6070)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6070);
				$var_6071=Db::table('ims_sudu8_page_forum_release')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->join('ims_sudu8_page_forum_func c','a.fid = c.id')->where('a.uniacid',$var_14)->field('a.*,b.avatar,b.nickname,c.title as func_title')->order('hot asc, stick asc, a.id desc')->paginate(10,false,['query' =>array('appletid' =>input('appletid'))]);
				$var_6072=Db::table('ims_sudu8_page_forum_release')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->join('ims_sudu8_page_forum_func c','a.fid = c.id')->where('a.uniacid',$var_14)->field('a.*,b.avatar,b.nickname,c.title as func_title')->order('a.id desc')->count();
				$var_6073=$var_6071->toArray()['data'];
				foreach($var_6073 as $var_6074=>&$var_187)
				{
					if($var_187['stick']==1)
					{
						$var_6075=Db::table('ims_sudu8_page_forum_stick')->where('uniacid',$var_14)->where('rid',$var_187['id'])->where('stick',1)->where('stick_status',1)->find();
						$var_6076=strtotime($var_6075['stick_time'])+$var_6075['stick_days']*24*3600;
						if($var_6076<=time())
						{
							Db::table('ims_sudu8_page_forum_stick')->where('uniacid',$var_14)->where('rid',$var_187['id'])->where('stick_status',1)->update(array('stick_status' =>2));
							Db::table('ims_sudu8_page_forum_release')->where('uniacid',$var_14)->where('id',$var_187['id'])->where('stick',1)->update(array('stick' =>2));
							$var_187['stick']=2;
						}
					}
				}
				$this->assign(release,$var_6071);
				$this->assign('counts',$var_6072);
				$this->assign('releaseList',$var_6073);
			}
			else
			{
				$var_6077=Session::get('usergroup');
				if($var_6077==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6077==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6077==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(release);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function releaseCon()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_6079=input('appletid');
				$var_6080=Db::table('applet')->where('id',$var_6079)->find();
				if(!$var_6080)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6080);
				$var_6081=input('release_id');
				$var_6082=Db::table('ims_sudu8_page_forum_release')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->join('ims_sudu8_page_forum_func c','a.fid = c.id')->where('a.uniacid',$var_6079)->where('a.id',$var_6081)->field('a.*,b.avatar,b.nickname,c.title as func_title')->find();
				if($var_6082)
				{
					if($var_6082['stick']==1)
					{
						$var_6083=Db::table('ims_sudu8_page_forum_stick')->where('uniacid',$var_6079)->where('rid',$var_6082['id'])->where('stick',1)->where('stick_status',1)->find();
						$var_6084=strtotime($var_6083['stick_time'])+$var_6083['stick_days']*24*3600;
						if($var_6084<=time())
						{
							Db::table('ims_sudu8_page_forum_stick')->where('uniacid',$var_6079)->where('rid',$var_6082['id'])->where('stick_status',1)->update(array('stick_status' =>2));
							Db::table('ims_sudu8_page_forum_release')->where('uniacid',$var_6079)->where('id',$var_6082['id'])->where('stick',1)->update(array('stick' =>2));
							$var_6082['stick']=2;
						}
					}
					$var_6082['stickall']=Db::table('ims_sudu8_page_forum_stick')->where('rid',$var_6082['id'])->where('stick',1)->order('id desc')->select();
					$var_6082[set]=Db::table('ims_sudu8_page_forum_set')->where('uniacid',$var_6079)->find();
					if($var_6082['stickall'])
					{
						foreach($var_6082['stickall'] as $var_6085=>&$var_6086)
						{
							$var_6086['moneyAll']=$var_6086['stick_money']*$var_6086['stick_days'];
						}
					}
					else
					{
						$var_6082['moneyAll']=0;
					}
					if($var_6082['img'])
					{
						$var_6082['img']=unserialize($var_6082['img']);
						if($var_6082['img'])
						{
							foreach($var_6082['img'] as $var_6087=>$var_6088)
							{
								$var_6082['img'][$var_6087]=remote($var_6079,$var_6088,1);
							}
						}
					}
					$var_6089=strtotime($var_6082['updatetime']);
					if($var_6089<0)
					{
						$var_6082['updatetime']='';
					}
				}
				$this->assign(release,$var_6082);
			}
			else
			{
				$var_6090=Session::get('usergroup');
				if($var_6090==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6090==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6090==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(releaseCon);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function releaseHot()
	{
		$var_6091=input('release_id');
		$var_6092=Db::table('ims_sudu8_page_forum_release')->where('id',$var_6091)->find();
		if($var_6092['hot']==1)
		{
			$var_6093=Db::table('ims_sudu8_page_forum_release')->where('id',$var_6091)->update(array('hot' =>2));
		}
		elseif($var_6092['hot']==2)
		{
			$var_6093=Db::table('ims_sudu8_page_forum_release')->where('id',$var_6091)->update(array('hot' =>1));
		}
		if($var_6093)
		{
			$this->success('操作成功');
		}
		else
		{
			$this->error('操作失败');
		}
	}
	public function releaseDel()
	{
		$var_3134=input('release_id');
		$var_6094=Db::table('ims_sudu8_page_forum_release')->where('id',$var_3134)->delete();
		if($var_6094)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->success('删除失败');
		}
	}
	public function comment()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_1126=input('appletid');
				$var_6096=Db::table('applet')->where('id',$var_1126)->find();
				if(!$var_6096)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6096);
				$var_6097=Db::table('ims_sudu8_page_forum_comment')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_1126)->field('a.*,b.avatar,b.nickname')->order('a.id desc')->paginate(10,false,['query' =>array('appletid' =>input('appletid'))]);
				$var_471=Db::table('ims_sudu8_page_forum_comment')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_1126)->field('a.*,b.avatar,b.nickname')->order('a.id desc')->count();
				$var_6098=$var_6097->toArray()['data'];
				foreach($var_6098 as $var_6099=>&$var_6100)
				{
					$var_6100['reply']=Db::table('ims_sudu8_page_forum_reply')->where('commentId',$var_6100['id'])->select();
				}
				$this->assign(comment,$var_6097);
				$this->assign('counts',$var_471);
				$this->assign('commentList',$var_6098);
			}
			else
			{
				$var_6101=Session::get('usergroup');
				if($var_6101==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6101==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6101==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(comment);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function commentDel()
	{
		$var_222=input('appletid');
		$var_6103=input('comment_id');
		$var_6104=Db::table('ims_sudu8_page_forum_comment')->where('uniacid',$var_222)->where('id',$var_6103)->find();
		$var_6105=Db::table('ims_sudu8_page_forum_comment')->where('uniacid',$var_222)->where('id',$var_6103)->delete();
		if($var_6105)
		{
			$var_6106=Db::table('ims_sudu8_page_forum_release')->where('uniacid',$var_222)->where('id',$var_6104['rid'])->find()[comment];
			$var_6107=$var_6106-1;
			Db::table('ims_sudu8_page_forum_release')->where('uniacid',$var_222)->where('id',$var_6104['rid'])->update(array(comment =>$var_6107));
			Db::table('ims_sudu8_page_forum_comment')->where('uniacid',$var_222)->where('id',$var_6103)->delete();
			Db::table('ims_sudu8_page_forum_comment_likes')->where('uniacid',$var_222)->where('commentId',$var_6104['id'])->delete();
			$this->success('删除成功');
		}
		else
		{
			$this->error('删除失败');
		}
	}
}
?>