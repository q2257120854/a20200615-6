<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Cymsg extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5201=input('appletid');
				$var_5776=Db::table('applet')->where('id',$var_5201)->find();
				if(!$var_5776)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5776);
				$var_5777=Db::table('ims_sudu8_page_message')->where('uniacid',$var_5201)->where('flag',4)->find();
				$this->assign('base',$var_5777);
			}
			else
			{
				$var_1668=Session::get('usergroup');
				if($var_1668==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_1668==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_1668==3)
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
		$var_5779=array();
		$var_5780=input('appletid');
		$var_5781=input('pay_id');
		$var_5779['mid']=trim($var_5781);
		$var_5782=input('url');
		$var_5779['url']=trim($var_5782);
		$var_5783=Db::table('ims_sudu8_page_message')->where('uniacid',$var_5780)->where('flag',4)->count();
		if($var_5783>0)
		{
			$var_5784=Db::table('ims_sudu8_page_message')->where('uniacid',$var_5780)->where('flag',4)->update($var_5779);
		}
		else
		{
			$var_5779['flag']=4;
			$var_5779['uniacid']=$var_5780;
			$var_5784=Db::table('ims_sudu8_page_message')->insert($var_5779);
		}
		if($var_5784)
		{
			$this->success('点餐通知更新成功！');
		}
		else
		{
			$this->error('点餐通知更新失败，没有修改项！');
			exit;
		}
	}
}
?>