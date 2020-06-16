<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Signbase extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_7635=input('appletid');
				$var_7636=Db::table('applet')->where('id',$var_7635)->find();
				if(!$var_7636)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7636);
				$var_7637=Db::table('ims_sudu8_page_sign_con')->where('uniacid',$var_7635)->find();
				$this->assign('bases',$var_7637);
			}
			else
			{
				$var_842=Session::get('usergroup');
				if($var_842==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_842==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_842==3)
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
		$var_7639=input('appletid');
		$var_2223=Db::table('ims_sudu8_page_sign_con')->where('uniacid',$var_7639)->find();
		$var_7640=input('score');
		$var_7641=input('max_score');
		if(!$var_7640)
		{
			$this->error('随机积分区间不能为空！');
			exit;
		}
		if(!$var_7641)
		{
			$this->error('最大积分不能为空！');
			exit;
		}
		$var_7642=array('score' =>$var_7640,'max_score' =>$var_7641,'uniacid' =>$var_7639);
		if(!$var_2223)
		{
			$var_7643=Db::table('ims_sudu8_page_sign_con')->insert($var_7642);
		}
		else
		{
			$var_7643=Db::table('ims_sudu8_page_sign_con')->where('uniacid',$var_7639)->update($var_7642);
		}
		if($var_7643)
		{
			$this->success('积分签到基本配置更新成功！');
		}
		else
		{
			$this->error('积分签到基本配置更新失败，没有修改项！');
			exit;
		}
	}
	function onepic_uploade($var_331)
	{
		$var_102=request()->file($var_331);
		if(isset($var_102))
		{
			$var_7645=upload_img();
			$var_7646=$var_102->validate(['ext'=>'jpg,png,gif,jpeg'])->move($var_7645);
			if($var_7646)
			{
				$var_7647=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_7646->getFilename();
				return $var_7647;
			}
		}
	}
	public function getimg()
	{
		$var_7649=$_POST['id'];
		$var_167=Db::table('image_url')->where('appletid',$var_7649)->select();
		if($var_167)
		{
			return $var_167;
		}
	}
	public function del()
	{
		$var_7651=input('id');
		$var_7652=Db::table('image_url')->where('id',$var_7651)->delete();
		if($var_7652)
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