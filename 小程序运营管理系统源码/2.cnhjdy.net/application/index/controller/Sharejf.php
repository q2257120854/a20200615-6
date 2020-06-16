<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Sharejf extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_1775=input('appletid');
				$var_7514=Db::table('applet')->where('id',$var_1775)->find();
				if(!$var_7514)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7514);
				$var_7515=Db::table('ims_sudu8_page_base')->where('uniacid',$var_1775)->find();
				$this->assign('base',$var_7515);
			}
			else
			{
				$var_647=Session::get('usergroup');
				if($var_647==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_647==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_647==3)
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
		$var_7517=input('appletid');
		$var_275=input('sharejf');
		$var_7518=input('sharexz');
		$var_7519=input('sharetype');
		$var_7520=Db::table('applet')->where('id',$var_7517)->find();
		if(!$var_7520)
		{
			$this->error('找不到对应的小程序！');
		}
		if(!$var_275)
		{
			$this->error('分享积分不能为空！');
			exit;
		}
		if(!$var_7518)
		{
			$this->error('分享次数限制不能为空！');
			exit;
		}
		$var_14['sharejf']=$var_275;
		$var_14['sharexz']=intval($var_7518);
		$var_14['sharetype']=intval($var_7519);
		$var_7520=Db::table('ims_sudu8_page_base')->where('uniacid',$var_7517)->find();
		if(!$var_7520)
		{
			$var_7520=Db::table('ims_sudu8_page_base')->insert($var_14);
		}
		else
		{
			$var_7520=Db::table('ims_sudu8_page_base')->where('uniacid',$var_7517)->update($var_14);
		}
		if($var_7520)
		{
			$this->success('分享积分基本配置更新成功！');
		}
		else
		{
			$this->error('分享积分基本配置更新失败，没有修改项！');
			exit;
		}
	}
	function onepic_uploade($v_1)
	{
		$var_7522=request()->file($v_1);
		if(isset($var_7522))
		{
			$var_7523=upload_img();
			$var_7524=$var_7522->validate(['ext'=>'jpg,png,gif,jpeg'])->move($var_7523);
			if($var_7524)
			{
				$var_7525=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_7524->getFilename();
				return $var_7525;
			}
		}
	}
	public function getimg()
	{
		$var_7527=$_POST['id'];
		$var_7528=Db::table('image_url')->where('appletid',$var_7527)->select();
		if($var_7528)
		{
			return $var_7528;
		}
	}
	public function del()
	{
		$var_7529=input('id');
		$var_7530=Db::table('image_url')->where('id',$var_7529)->delete();
		if($var_7530)
		{
			return 1;
		}
		else
		{
			$this->error('删除失败！');
		}
	}
}
?>