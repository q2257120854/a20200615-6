<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Pinglun extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_6942=input('appletid');
				$var_6943=Db::table('applet')->where('id',$var_6942)->find();
				if(!$var_6943)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6943);
				$var_6944=Db::table('ims_sudu8_page_comment')->alias('a')->join('ims_sudu8_page_products b','a.aid = b.id')->where('a.uniacid',$var_6942)->order('b.id desc')->field('b.title,b.type,a.id,a.aid,a.text,a.flag,a.createtime')->select();
				foreach($var_6944 as $var_6945=>$var_243)
				{
					$var_6944[$var_6945]['createtime']=date('Y-m-d H:i:s',$var_243['createtime']);
				}
				$this->assign('list',$var_6944);
			}
			else
			{
				$var_6946=Session::get('usergroup');
				if($var_6946==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6946==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6946==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(index);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function post()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_2390=input('appletid');
				$var_137=Db::table('applet')->where('id',$var_2390)->find();
				if(!$var_137)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_137);
				$var_6948=intval(input('id'));
				$var_6949=Db::table('ims_sudu8_page_comment')->alias('a')->join('ims_sudu8_page_products b','a.aid = b.id')->where('a.id',$var_6948)->order('b.id desc')->field('b.title,b.type,a.id,a.aid,a.text,a.flag,a.createtime')->find();
				$var_6949['createtime']=date('Y-m-d H:i:s',$var_6949['createtime']);
				$this->assign('list',$var_6949);
			}
			else
			{
				$var_6950=Session::get('usergroup');
				if($var_6950==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6950==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6950==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(post);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function del()
	{
		$var_6952=input('id');
		$var_2345=input('appletid');
		$var_6953=Db::table('ims_sudu8_page_comment')->where('id',$var_6952)->where('uniacid',$var_2345)->delete();
		if($var_6953)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->error('删除失败！');
		}
	}
	public function plsave()
	{
		$var_6955=intval(input('id'));
		$var_6956=input('appletid');
		$var_6957=intval(input('flag'));
		$var_6958=array('flag' =>$var_6957);
		$var_6959=Db::table('ims_sudu8_page_comment')->where('id',$var_6955)->where('uniacid',$var_6956)->update($var_6958);
		if($var_6959)
		{
			$this->success('评论审核成功');
		}
		else
		{
			$this->error('评论审核失败！');
		}
	}
}
?>