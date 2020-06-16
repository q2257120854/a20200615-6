<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Delmoney extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_102=input('appletid');
				$var_5878=0;
				$var_5879=Db::table('applet')->where('id',$var_102)->find();
				if(!$var_5879)
				{
					$this->error('找不到对应的小程序！');
				}
				$var_5880=Db::table('ims_sudu8_page_moneyoff')->where('uniacid',$var_102)->order('reach asc')->select();
				if($var_5880)
				{
					$var_5881=count($var_5880);
				}
				else
				{
					$var_5881=0;
				}
				;
				$this->assign('applet',$var_5879);
				$this->assign(index,$var_5878);
				$this->assign('money',$var_5880);
				$this->assign('num',$var_5881);
			}
			else
			{
				$var_5882=Session::get('usergroup');
				if($var_5882==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5882==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5882==3)
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
		$var_408=input('appletid');
		$var_5883=input('num');
		Db::table('ims_sudu8_page_moneyoff')->where('uniacid',$var_408)->delete();
		if($var_5883>0)
		{
			for($var_5884=1;$var_5884<=$var_5883;$var_5884++)
			{
				if(!empty(input('reach'.$var_5884))&& !empty(input('del'.$var_5884)))
				{
					$var_628=array('uniacid' =>$var_408,'reach' =>input('reach'.$var_5884),'del' =>input('del'.$var_5884));
					$var_327=Db::table('ims_sudu8_page_moneyoff')->insert($var_628);
				}
			}
		}
		$var_327=Db::table('ims_sudu8_page_moneyoff')->where('uniacid',$var_408)->select();
		if($var_327)
		{
			$this->success('信息更新成功！');
		}
		else
		{
			$this->error('信息更新失败');
			exit;
		}
		;
	}
}
?>