<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Multicate extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_6517=input('appletid');
				$var_6518=Db::table('applet')->where('id',$var_6517)->find();
				if(!$var_6518)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6518);
				$var_6519=Db::table('ims_sudu8_page_multicate')->where('uniacid',$var_6517)->order('id desc')->select();
				$this->assign('newcoupon',$var_6519);
			}
			else
			{
				$var_6520=Session::get('usergroup');
				if($var_6520==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6520==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6520==3)
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
				$var_1304=input('appletid');
				$var_6522=Db::table('applet')->where('id',$var_1304)->find();
				if(!$var_6522)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6522);
				$var_6523=input('cateid');
				if($var_6523)
				{
					$var_147=Db::table('ims_sudu8_page_multicate')->where('uniacid',$var_1304)->where('id',$var_6523)->find();
					$var_147['top_catas']=unserialize($var_147['top_catas']);
				}
				else
				{
					$var_6523=0;
					$var_147='';
				}
				$var_6524=Db::table('ims_sudu8_page_multicates')->where('uniacid',$var_1304)->where('pid',0)->where('status',1)->select();
				$this->assign('cateinfo',$var_147);
				$this->assign('top_catat',$var_6524);
				$this->assign('cateid',$var_6523);
			}
			else
			{
				$var_6525=Session::get('usergroup');
				if($var_6525==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6525==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6525==3)
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
	public function multikey()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_18=input('appletid');
				$var_6526=Db::table('applet')->where('id',$var_18)->find();
				if(!$var_6526)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6526);
				$var_697=Db::table('ims_sudu8_page_multicates')->where('pid',0)->where('uniacid',$var_18)->select();
				foreach($var_697 as $var_6527=>$var_6528)
				{
					$var_130=Db::table('ims_sudu8_page_multicates')->where('pid',$var_6528['id'])->select();
					$var_6529=[];
					foreach($var_130 as $var_23=>$var_571)
					{
						array_push($var_6529,$var_571['varible']);
					}
					$var_697[$var_6527]['content']=implode(',',$var_6529);
				}
				$this->assign('list',$var_697);
			}
			else
			{
				$var_6530=Session::get('usergroup');
				if($var_6530==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6530==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6530==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(multikey);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function keyadd()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_6531=input('appletid');
				$var_6532=Db::table('applet')->where('id',$var_6531)->find();
				if(!$var_6532)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_6532);
			}
			else
			{
				$var_6533=Session::get('usergroup');
				if($var_6533==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_6533==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_6533==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(keyadd);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function keyedit()
	{
		$var_6535=input('appletid');
		$var_6536=Db::table('applet')->where('id',$var_6535)->find();
		if(!$var_6536)
		{
			$this->error('找不到对应的小程序！');
		}
		$this->assign('applet',$var_6536);
		$var_6535=input('cateid');
		$var_6537=Db::table('ims_sudu8_page_multicates')->where('id',$var_6535)->find();
		$var_6538=Db::table('ims_sudu8_page_multicates')->where('pid',$var_6535)->select();
		$var_6539=[];
		foreach($var_6538 as $var_1134=>$var_357)
		{
			array_push($var_6539,$var_357['varible']);
		}
		$var_6537['content']=implode(',',$var_6539);
		$this->assign('list',$var_6537);
		$this->assign('sons',$var_6538);
		return $this->fetch(keyedit);
	}
	public function keyeditsave()
	{
		$var_6540=input('appletid');
		$var_6541=intval(input('id'));
		$var_6542=input('ids/a');
		$var_6543=input('varibles/a');
		$var_6544=input(sort);
		$var_6545=input('name');
		$var_341=input('status');
		$var_6546=0;
		$var_6547=Db::table('ims_sudu8_page_multicates')->where('pid',$var_6541)->count();
		Db::table('ims_sudu8_page_multicates')->where('id',$var_6541)->update(array(sort =>$var_6544,'varible' =>$var_6545,'status' =>$var_341));
		for($var_6548=0;$var_6548<count($var_6542);
		$var_6548++)
		{
			if($var_6542[$var_6548]>0&& $var_6543[$var_6548]!='')
			{
				Db::table('ims_sudu8_page_multicates')->where('id',$var_6542[$var_6548])->update(array('varible' =>$var_6543[$var_6548]));
			}
			else
			{
				if($var_6543[$var_6548]!='')
				{
					Db::table('ims_sudu8_page_multicates')->insert(array(sort =>$var_6544,'status' =>$var_341,'varible' =>$var_6543[$var_6548],'pid' =>$var_6541,'uniacid' =>$var_6540));
				}
			}
		}
		$this->success('编辑成功',Url('Multicate/multikey').'?appletid='.$var_6540);
	}
	public function keysave()
	{
		$var_6550=array();
		$var_6550['uniacid']=input('appletid');
		$var_6550[sort]=input(sort);
		if(input('status')=='')
		{
			$var_6550['status']=0;
		}
		else
		{
			$var_6550['status']=input('status');
		}
		$var_6550['varible']=input('name');
		$var_6551=input('content');
		if($var_6551=='')
		{
			$this->error('筛选条件不能为空！');
			exit;
		}
		$var_6552=Db::table('ims_sudu8_page_multicates')->insertGetId($var_6550);
		if($var_6552)
		{
			$var_6553=explode(',',$var_6551);
			foreach($var_6553 as $var_6554)
			{
				$var_113['status']=$var_6550['status'];
				$var_113['varible']=$var_6554;
				$var_113['pid']=$var_6552;
				$var_113['uniacid']=$var_6550['uniacid'];
				Db::table('ims_sudu8_page_multicates')->insert($var_113);
			}
			$this->success('添加成功',Url('Multicate/multikey').'?appletid='.$var_6550['uniacid']);
		}
		else
		{
			$this->error('添加失败！');
		}
	}
	public function getcate()
	{
		$var_6556=$_POST['type'];
		$var_6557=$_POST['uniacid'];
		$var_187=Db::table('ims_sudu8_page_cate')->where('uniacid',$var_6557)->where('cid',0)->where('type',$var_6556)->where('statue',1)->field('id,name')->select();
		return $var_187;
	}
	public function getcates()
	{
		$var_6559=$_POST['id'];
		$var_967=Db::table('ims_sudu8_page_cate')->whereOr('cid',$var_6559)->whereOr('id',$var_6559)->where('statue',1)->field('id,name')->order('id asc')->select();
		return $var_967;
	}
	public function save()
	{
		$var_6561=input('appletid');
		$var_6562=input('cateid');
		if(input('name')=='')
		{
			$this->error('请输入栏目名称！');
			exit;
		}
		if(is_null(input('statue')))
		{
			$var_6563=1;
		}
		else
		{
			$var_6563=input('statue');
		}
		$var_629=input('type');
		if($var_629=='showArt' || $var_629=='showPic')
		{
			if(is_null(input('list_style')))
			{
				$var_868=2;
			}
			else
			{
				$var_868=intval(input('list_style'));
			}
		}
		else
		{
			if(is_null(input('list_style')))
			{
				$var_868=12;
			}
			else
			{
				$var_868=intval(input('list_style'));
			}
		}
		if(is_null(input('list_stylet')))
		{
			$var_6564='tl';
		}
		else
		{
			$var_6564=intval(input('list_stylet'));
		}
		if(input('top_cats/a')==null)
		{
			$this->error('请选择顶级栏目！');
			exit;
		}
		$var_6565=array('uniacid' =>$var_6561,'name' =>input('name'),'type' =>$var_629,'statue' =>$var_6563,'list_style' =>$var_868,'list_stylet' =>$var_6564,'top_catas' =>serialize(input('top_cats/a')),);
		if(empty($var_6562))
		{
			$var_6566=Db::table('ims_sudu8_page_multicate')->insert($var_6565);
		}
		else
		{
			$var_6566=Db::table('ims_sudu8_page_multicate')->where('id',$var_6562)->where('uniacid',$var_6561)->update($var_6565);
		}
		if($var_6566)
		{
			$this->success('模块更新成功！',Url('Multicate/index').'?appletid='.$var_6561);
		}
		else
		{
			$this->error('模块更新失败，没有修改项！');
			exit;
		}
	}
	public function onepic_uploade($var_25)
	{
		$var_6568=request()->file($var_25);
		if(isset($var_6568))
		{
			$var_809=upload_img();
			$var_6569=$var_6568->move($var_809);
			if($var_6569)
			{
				$var_3469=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_6569->getFilename();
				return $var_3469;
			}
		}
	}
	public function del()
	{
		$var_6571=input('cateid');
		$var_6572=Db::table('ims_sudu8_page_multicate')->where('id',$var_6571)->delete();
		if($var_6572)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->success('删除失败');
		}
	}
	public function keydel()
	{
		$var_6574=input('cateid');
		$var_6575=Db::table('ims_sudu8_page_multicates')->whereOr('id',$var_6574)->whereOr('pid',$var_6574)->delete();
		if($var_6575)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->success('删除失败');
		}
	}
}
?>