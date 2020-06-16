<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Cycate extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5690=input('appletid');
				$var_5691=Db::table('applet')->where('id',$var_5690)->find();
				if(!$var_5691)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5691);
				$var_967=Db::table('ims_sudu8_page_food_cate')->where('uniacid',$var_5690)->order('num desc')->select();
				$this->assign('cates',$var_967);
			}
			else
			{
				$var_2267=Session::get('usergroup');
				if($var_2267==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_2267==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_2267==3)
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
				$var_5693=input('appletid');
				$var_5694=Db::table('applet')->where('id',$var_5693)->find();
				if(!$var_5694)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5694);
				$var_5695=input('cateid');
				if($var_5695)
				{
					$var_187=Db::table('ims_sudu8_page_food_cate')->where('id',$var_5695)->find();
					if($var_187['uniacid']==$var_5693)
					{
						$var_5696=$var_187;
					}
					else
					{
						$var_5697=Session::get('usergroup');
						if($var_5697==1)
						{
							$this->error('找不到该栏目，或者该栏目不属于本小程序');
						}
						if($var_5697==2)
						{
							$this->error('找不到该栏目，或者该栏目不属于本小程序');
						}
					}
				}
				else
				{
					$var_5695=0;
					$var_5696='';
				}
				$this->assign('cateid',$var_5695);
				$this->assign('cateinfo',$var_5696);
			}
			else
			{
				$var_5697=Session::get('usergroup');
				if($var_5697==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5697==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5697==3)
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
		$var_5698=array();
		$var_5698['uniacid']=input('appletid');
		$var_5699=input('num');
		if($var_5699)
		{
			$var_5698['num']=$var_5699;
		}
		$var_5700=input('title');
		if($var_5700)
		{
			$var_5698['title']=$var_5700;
		}
		$var_5701=input('cateid');
		if($var_5701!=0)
		{
			$var_103=Db::table('ims_sudu8_page_food_cate')->where('id',$var_5701)->update($var_5698);
		}
		else
		{
			$var_103=Db::table('ims_sudu8_page_food_cate')->insert($var_5698);
		}
		if($var_103)
		{
			$this->success('点菜分类管理信息更新成功！',Url('Cycate/index').'?appletid='.$var_5698['uniacid']);
		}
		else
		{
			$this->error('点菜分类管理信息更新失败，没有修改项！');
			exit;
		}
	}
	public function del()
	{
		$var_1568['id']=input('cateid');
		$var_23=Db::table('ims_sudu8_page_food_cate')->where($var_1568)->delete();
		if($var_23)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->success('删除失败');
		}
	}
	function onepic_uploade($var_276)
	{
		$var_5703=request()->file($var_276);
		if(isset($var_5703))
		{
			$var_5704=upload_img();
			$var_5705=$var_5703->move($var_5704);
			if($var_5705)
			{
				$var_5706=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_5705->getFilename();
				return $var_5706;
			}
		}
	}
	public function imgupload_duo()
	{
		$var_956['appletid']=input('appletid');
		$var_5708=request()->file('');
		foreach($var_5708 as $var_5709)
		{
			$var_5710=$var_5709->move(ROOT_PATH.'public' .DS.'upimages');
			if($var_5710)
			{
				$var_5711=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_5710->getFilename();
				$var_4=array('url'=>$var_5711);
				return json_encode($var_4);
			}
			else
			{
				return $this->error($var_5709->getError());
			}
		}
	}
}
?>