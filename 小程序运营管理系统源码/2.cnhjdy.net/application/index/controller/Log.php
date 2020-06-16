<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Log extends Controller
{
	public function index()
	{
		if(check_login())
		{
			if(check_group())
			{
				if(input('show'))
				{
					if(input('show')==1)
					{
						$var_6218=Db::name(log)->alias('a')->join('admin b','a.admin = b.uid')->where('a.type','eq',0)->field('a.*, b.realname')->order('id','desc')->paginate(10,false,['query' =>request()->param()]);
						$var_6219=Db::name(log)->where('type','eq',0)->field('a.*, b.realname')->count();
					}
					else
					{
						$var_6218=Db::name(log)->alias('a')->join('admin b','a.admin = b.uid')->where('a.type','eq',1)->field('a.*, b.realname')->order('id','desc')->paginate(10,false,['query' =>request()->param()]);
						$var_6219=Db::name(log)->where('type','eq',1)->field('a.*, b.realname')->count();
					}
				}
				else
				{
					$var_6218=Db::name(log)->alias('a')->join('admin b','a.admin = b.uid')->field('a.*, b.realname')->order('id','desc')->paginate(10);
					$var_6219=Db::name(log)->count();
				}
				$var_6220=$var_6218->render();
				$this->assign(log,$var_6218);
				$this->assign(count,$var_6219);
				$this->assign('page',$var_6220);
				return $this->fetch(index);
			}
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
}
?>