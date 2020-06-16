<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class User extends Controller
{
	public function index()
	{
		if(check_login())
		{
			$var_7787=Db::table('admin')->where('uid',Session::get('uid'))->find();
			$this->assign('userinfo',$var_7787);
			return $this->fetch(index);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function save()
	{
		$var_7789=$this->onepic_uploade('icon');
		if($var_7789)
		{
			$var_161['icon']=$var_7789;
		}
		$var_7790=$_POST['realname'];
		if($var_7790)
		{
			$var_161['realname']=$var_7790;
		}
		$var_7791=$_POST['mobile'];
		if($var_7791)
		{
			$var_161['mobile']=$var_7791;
		}
		$var_7792=$_POST['email'];
		if($var_7792)
		{
			$var_161['email']=$var_7792;
		}
		$var_7793=$_POST['password'];
		if($var_7793)
		{
			$var_161['password']=md5($var_7793);
		}
		$var_7794=Session::get('uid');
		$var_7795=Db::table('admin')->where('uid',$var_7794)->update($var_161);
		if($var_7795)
		{
			$this->success('用户信息更新成功！');
		}
		else
		{
			$this->error('用户信息更新失败，没有更新项目！');
			exit;
		}
	}
	function onepic_uploade($v_1)
	{
		$var_647=request()->file($v_1);
		if(isset($var_647))
		{
			$var_7797=upload_img();
			$var_7798=$var_647->validate(['ext'=>'jpg,png,gif,jpeg'])->move($var_7797);
			if($var_7798)
			{
				$var_68=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_7798->getFilename();
				return $var_68;
			}
		}
	}
}
?>