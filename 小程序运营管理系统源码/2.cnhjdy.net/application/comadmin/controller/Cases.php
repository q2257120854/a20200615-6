<?php  namespace app\comadmin\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Cases extends Controller
{
	public function index()
	{
		if(check_login())
		{
			$this->assign('page',1);
			$var_1665=Db::table('ims_sudu8_page_com_cases')->order('num desc,id desc')->paginate(10);
			$var_3578=Db::table('ims_sudu8_page_com_cases')->count();
			$this->assign(count,$var_3578);
			$this->assign('list',$var_1665);
			return $this->fetch(index);
		}
		else
		{
			$this->redirect('Index/Login/index');
		}
	}
	public function add()
	{
		if(check_login())
		{
			$var_3580=input('newsid');
			if($var_3580)
			{
				$var_3581=Db::table('ims_sudu8_page_com_cases')->where('id',$var_3580)->find();
			}
			else
			{
				$var_3581='';
			}
			$this->assign('page',1);
			$this->assign('newsid',$var_3580);
			$this->assign('newsinfo',$var_3581);
			return $this->fetch(add);
		}
		else
		{
			$this->redirect('Index/login/index');
		}
	}
	public function save()
	{
		$var_3582=array();
		$var_416=input('num');
		if($var_416)
		{
			$var_3582['num']=intval($var_416);
		}
		$var_3583=input('flag');
		if($var_3583)
		{
			$var_3582['flag']=intval($var_3583);
		}
		$var_3584=input('recommend');
		if($var_3584)
		{
			$var_3582['recommend']=intval($var_3584);
		}
		else
		{
			$var_3582['recommend']=2;
		}
		$var_3585=input('hits');
		if($var_3585)
		{
			$var_3582['hits']=intval($var_3585);
		}
		$var_3586=input('commonuploadpic1');
		if($var_3586)
		{
			$var_3582['ewm']=$var_3586;
		}
		$var_103=input('commonuploadpic2');
		if($var_103)
		{
			$var_3582['pic']=$var_103;
		}
		$var_3587=input('title');
		if($var_3587)
		{
			$var_3582['title']=$var_3587;
		}
		$var_3588=input('casetype');
		if($var_3588)
		{
			$var_3582['casetype']=$var_3588;
		}
		$var_3589=input('text');
		if($var_3589)
		{
			$var_3582['text']=$var_3589;
		}
		$var_3590=input('newsid');
		if($var_3590)
		{
			$var_3591=Db::table('ims_sudu8_page_com_cases')->where('id',$var_3590)->update($var_3582);
		}
		else
		{
			$var_3582['createtime']=time();
			$var_3591=Db::table('ims_sudu8_page_com_cases')->insert($var_3582);
		}
		if($var_3591)
		{
			$this->success('更新成功！');
		}
		else
		{
			$this->error('更新失败，没有修改项！');
			exit;
		}
	}
	public function del()
	{
		$var_3067=input('newsid');
		if($var_3067)
		{
			$var_3593=Db::table('ims_sudu8_page_com_cases')->where('id',$var_3067)->delete();
			if($var_3593)
			{
				$this->success('删除成功');
			}
			else
			{
				$this->error('删除失败');
				exit;
			}
		}
	}
}
?>