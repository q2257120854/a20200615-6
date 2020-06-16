<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class About extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5360=input('appletid');
				$var_5361=Db::table('applet')->where('id',$var_5360)->find();
				if(!$var_5361)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5361);
				$var_5362=Db::table('ims_sudu8_page_about')->where('uniacid',$var_5360)->find();
				$this->assign('abouts',$var_5362);
			}
			else
			{
				$var_5363=Session::get('usergroup');
				if($var_5363==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5363==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5363==3)
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
		$var_912['content']=$_POST['content'];
		$var_912[header]=input(header);
		$var_912['tel_box']=input('tel_box');
		$var_912['serv_box']=input('serv_box');
		$var_5365=input('appletid');
		$var_5366=Db::table('ims_sudu8_page_about')->where('uniacid',$var_5365)->count();
		if($var_5366>0)
		{
			$var_5367=Db::table('ims_sudu8_page_about')->where('uniacid',$var_5365)->update($var_912);
			if($var_5367)
			{
				$this->success('公司介绍更新成功！');
			}
			else
			{
				$this->error('公司介绍更新失败，没有修改项！');
			}
		}
		else
		{
			$var_912['uniacid']=$var_5365;
			$var_5367=Db::table('ims_sudu8_page_about')->insert($var_912);
			if($var_5367)
			{
				$this->success('公司介绍更新成功！');
			}
			else
			{
				$this->error('公司介绍更新失败，没有修改项！');
			}
		}
	}
	public function imgupload()
	{
		$var_5369=request()->file('');
		foreach($var_5369 as $var_5370)
		{
			$var_5371=$var_5370->move(ROOT_PATH.'public' .DS.'upimages');
			if($var_5371)
			{
				$var_5372=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_5371->getFilename();
				$var_5373=array('url'=>$var_5372);
				return json_encode($var_5373);
			}
			else
			{
				return $this->error($var_5370->getError());
			}
		}
	}
}
?>