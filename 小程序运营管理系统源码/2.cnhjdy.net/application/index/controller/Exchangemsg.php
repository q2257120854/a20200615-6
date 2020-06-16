<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Exchangemsg extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_100=input('appletid');
				$var_5991=Db::table('applet')->where('id',$var_100)->find();
				if(!$var_5991)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5991);
				$var_5992=Db::table('ims_sudu8_page_message')->where('uniacid',$var_100)->where('flag',5)->find();
				$this->assign('base',$var_5992);
			}
			else
			{
				$var_5993=Session::get('usergroup');
				if($var_5993==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5993==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5993==3)
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
	public function save()
	{
		$var_5995=array();
		$var_5996=input('appletid');
		$var_5997=input('pay_id');
		$var_5995['mid']=trim($var_5997);
		$var_5998=input('url');
		$var_5995['url']=trim($var_5998);
		$var_5999=Db::table('ims_sudu8_page_message')->where('uniacid',$var_5996)->where('flag',5)->count();
		if($var_5999>0)
		{
			$var_6000=Db::table('ims_sudu8_page_message')->where('uniacid',$var_5996)->where('flag',5)->update($var_5995);
		}
		else
		{
			$var_5995['flag']=5;
			$var_5995['uniacid']=$var_5996;
			$var_6000=Db::table('ims_sudu8_page_message')->insert($var_5995);
		}
		if($var_6000)
		{
			$this->success('积分兑换通知更新成功！');
		}
		else
		{
			$this->error('积分兑换通知更新失败，没有修改项！');
			exit;
		}
	}
}
?>