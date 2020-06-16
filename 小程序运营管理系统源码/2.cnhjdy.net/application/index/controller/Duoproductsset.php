<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Duoproductsset extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5905=input('appletid');
				$var_5906=Db::table('applet')->where('id',$var_5905)->find();
				if(!$var_5906)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5906);
				$var_785=Db::table('ims_sudu8_page_duo_products_yunfei')->where('uniacid',$var_5905)->find();
				$var_460=Db::table('ims_sudu8_page_formlist')->where('uniacid',$var_5905)->order('id desc')->select();
				$this->assign('yunfeidata',$var_785);
				$this->assign('forms',$var_460);
			}
			else
			{
				$var_5907=Session::get('usergroup');
				if($var_5907==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5907==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5907==3)
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
		$var_5909=input('appletid');
		$var_729=input('yunfei');
		if($var_729)
		{
			$var_5910['yfei']=$var_729;
		}
		else
		{
			$var_5910['yfei']=0;
		}
		$var_5911=input('baoyou');
		if($var_5911)
		{
			$var_5910['byou']=$var_5911;
		}
		else
		{
			$var_5910['byou']=0;
		}
		$var_5910['formset']=input('formset');
		$var_5912=Db::table('ims_sudu8_page_duo_products_yunfei')->where('uniacid',$var_5909)->find();
		if(!$var_5912)
		{
			$var_5910['uniacid']=$var_5909;
			$var_5913=Db::table('ims_sudu8_page_duo_products_yunfei')->insert($var_5910);
		}
		else
		{
			$var_5913=Db::table('ims_sudu8_page_duo_products_yunfei')->where('uniacid',$var_5909)->update($var_5910);
		}
		if($var_5913)
		{
			$this->success('多规格商品设置更新成功！');
		}
		else
		{
			$this->error('多规格商品设置更新失败，没有修改项！');
			exit;
		}
	}
}
?>