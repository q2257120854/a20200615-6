<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Cygoods extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_167=input('appletid');
				$var_5712=Db::table('applet')->where('id',$var_167)->find();
				if(!$var_5712)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5712);
				$var_5713=Db::table('ims_sudu8_page_food')->where('uniacid',$var_167)->order('num desc')->select();
				foreach($var_5713 as $var_25=>&$var_5714)
				{
					$var_5714['thumb']=remote($var_167,$var_5714['thumb'],1);
				}
				$this->assign('cates',$var_5713);
			}
			else
			{
				$var_3502=Session::get('usergroup');
				if($var_3502==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_3502==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_3502==3)
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
				$var_5716=input('appletid');
				$var_5717=Db::table('applet')->where('id',$var_5716)->find();
				if(!$var_5717)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5717);
				$var_5718=input('cateid');
				if($var_5718)
				{
					$var_5719=Db::table('ims_sudu8_page_food')->where('id',$var_5718)->find();
					if($var_5719['uniacid']==$var_5716)
					{
						$var_5720=$var_5719;
						if($var_5720['thumb'])
						{
							$var_5720['thumb']=remote($var_5716,$var_5720['thumb'],1);
						}
						if($var_5720['descimg'])
						{
							$var_5720['descimg']=remote($var_5716,$var_5720['descimg'],1);
						}
						if($var_5720['labels'])
						{
							$var_5721=unserialize($var_5720['labels']);
						}
					}
					else
					{
						$var_5722=Session::get('usergroup');
						if($var_5722==1)
						{
							$this->error('找不到该产品，或者该产品不属于本小程序');
						}
						if($var_5722==2)
						{
							$this->error('找不到该产品，或者该产品不属于本小程序');
						}
					}
				}
				else
				{
					$var_5718=0;
					$var_5720='';
					$var_5721='';
				}
				$var_5723=Db::table('ims_sudu8_page_food_cate')->where('uniacid',$var_5716)->select();
				$this->assign('labels',$var_5721);
				$this->assign('cate',$var_5723);
				$this->assign('cateid',$var_5718);
				$this->assign('cateinfo',$var_5720);
			}
			else
			{
				$var_5722=Session::get('usergroup');
				if($var_5722==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5722==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5722==3)
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
		$var_779=input('cateid');
		$var_554['uniacid']=input('appletid');
		$var_554['cid']=$_POST['cid'];
		$var_554['num']=$_POST['num'];
		$var_554['title']=$_POST['title'];
		$var_554['counts']=$_POST['counts'];
		$var_554['price']=$_POST['price'];
		$var_554['desccon']=$_POST['desccon'];
		$var_554['unit']=$_POST['unit'];
		$var_5725=input('commonuploadpic1');
		if($var_5725)
		{
			$var_554['thumb']=remote($var_554['uniacid'],$var_5725,2);
		}
		$var_613=input('commonuploadpic2');
		if($var_613)
		{
			$var_554['descimg']=remote($var_554['uniacid'],$var_613,2);
		}
		$var_5726=$_POST['labels'];
		if($var_5726)
		{
			$var_5727=array();
			$var_5728=explode(',',substr($var_5726,0,-1));
			foreach($var_5728 as $var_5729=>$var_5730)
			{
				$var_5731=explode(':',$var_5730);
				foreach($var_5731 as $var_5732=>$var_5733)
				{
					$var_5727[$var_5729][$var_5732]=$var_5733;
				}
			}
			$var_554['labels']=serialize($var_5727);
		}
		if($var_779!=0)
		{
			$var_5734=Db::table('ims_sudu8_page_food')->where('id',$var_779)->update($var_554);
		}
		else
		{
			$var_5734=Db::table('ims_sudu8_page_food')->insert($var_554);
		}
		if($var_5734)
		{
			$this->success('产品信息更新成功！',Url('Cygoods/index').'?appletid='.$var_554['uniacid']);
		}
		else
		{
			$this->error('产品信息更新失败，没有修改项！');
			exit;
		}
	}
	public function del()
	{
		$var_5735['id']=input('cateid');
		$var_5736=Db::table('ims_sudu8_page_food')->where($var_5735)->delete();
		if($var_5736)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->success('删除失败');
		}
	}
	function onepic_uploade($v_1)
	{
		$var_126=request()->file($v_1);
		if(isset($var_126))
		{
			$var_486=upload_img();
			$var_5738=$var_126->move($var_486);
			if($var_5738)
			{
				$var_5739=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_5738->getFilename();
				return $var_5739;
			}
		}
	}
	public function imgupload_duo()
	{
		$var_5741['appletid']=input('appletid');
		$v_1=request()->file('');
		foreach($v_1 as $var_5742)
		{
			$var_5743=$var_5742->move(ROOT_PATH.'public' .DS.'upimages');
			if($var_5743)
			{
				$var_5744=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_5743->getFilename();
				$var_5745=array('url'=>$var_5744);
				return json_encode($var_5745);
			}
			else
			{
				return $this->error($var_5742->getError());
			}
		}
	}
}
?>