<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Diy extends Controller
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5886=input('appletid');
				$var_5887=Db::table('applet')->where('id',$var_5886)->find();
				if(!$var_5887)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5887);
				$var_5888=Db::table('ims_sudu8_page_diy')->where('uniacid',$var_5886)->order('creattime desc')->paginate(10,false,['query' =>array('appletid'=>input('appletid'))]);
				$var_5889=Db::table('ims_sudu8_page_diy')->where('uniacid',$var_5886)->order('creattime desc')->count();
				$this->assign('diys',$var_5888);
				$this->assign('counts',$var_5889);
			}
			else
			{
				$var_5890=Session::get('usergroup');
				if($var_5890==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5890==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5890==3)
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
	public function add()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5892=input('appletid');
				$var_167=Db::table('applet')->where('id',$var_5892)->find();
				if(!$var_167)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_167);
			}
			else
			{
				$var_5893=Session::get('usergroup');
				if($var_5893==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5893==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5893==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(add);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function save()
	{
		$var_5894['uniacid']=input('appletid');
		$var_5894['title']=input('title');
		$var_343=Db::table('ims_sudu8_page_diy')->order('id desc')->limit(1)->select();
		$var_5895=0;
		if(count($var_343)==0)
		{
			$var_5895=1;
		}
		else
		{
			$var_5895=count($var_343)+1;
		}
		$var_5894['url']='pages/main/main?pageid='.$var_5895;
		$var_5894['desc']=input('desc');
		$var_5894['creattime']=time();
		$var_5896=Db::table('ims_sudu8_page_diy')->insert($var_5894);
		if($var_5896)
		{
			$this->success('页面新建成功！');
		}
	}
	public function pages()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_628=input('appletid');
				$var_5897=Db::table('applet')->where('id',$var_628)->find();
				if(!$var_5897)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5897);
			}
			else
			{
				$var_5898=Session::get('usergroup');
				if($var_5898==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5898==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5898==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(pages);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function newpages()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5900=input('appletid');
				$var_5901=Db::table('applet')->where('id',$var_5900)->find();
				if(!$var_5901)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5901);
				$var_5902=Db::table('ims_model')->select();
				$this->assign('mod',$var_5902);
			}
			else
			{
				$var_5903=Session::get('usergroup');
				if($var_5903==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5903==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5903==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(newpages);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
}
?>