<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Wxapps extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_905=input('appletid');
				$var_7298=Db::table('applet')->where('id',$var_905)->find();
				if(!$var_7298)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7298);
				$var_7822=Db::table('ims_sudu8_page_wxapps')->where('uniacid',$var_905)->order('num desc')->paginate(10,false,['query' =>array('appletid'=>$var_905)]);
				$var_7823=Db::table('ims_sudu8_page_wxapps')->where('uniacid',$var_905)->order('num desc')->count();
				$var_7824=$var_7822->toArray();
				foreach($var_7824['data'] as &$var_7298)
				{
					$var_7825=Db::table('ims_sudu8_page_cate')->where('uniacid',$var_905)->where('id',$var_7298['cid'])->find();
					$var_7298['cid']=$var_7825['name'];
					if($var_7298['thumb'])
					{
						$var_7298['thumb']=remote($var_905,$var_7298['thumb'],1);
					}
				}
				$this->assign('wxapps',$var_7824);
				$this->assign('counts',$var_7823);
			}
			else
			{
				$var_175=Session::get('usergroup');
				if($var_175==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_175==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_175==3)
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
				$var_7826=input('appletid');
				$var_7827=Db::table('applet')->where('id',$var_7826)->find();
				if(!$var_7827)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7827);
				$var_7828=Db::table('ims_sudu8_page_cate')->where('uniacid',$var_7826)->where('cid',0)->where('type','showWxapps')->order('num desc')->select();
				$var_7829=array();
				foreach($var_7828 as $var_7830=>$var_7831)
				{
					$var_7832=intval($var_7831['id']);
					$var_7833=Db::table('ims_sudu8_page_cate')->where('uniacid',$var_7826)->where('id',$var_7832)->order('num desc')->select();
					$var_7834=Db::table('ims_sudu8_page_cate')->where('uniacid',$var_7826)->where('cid',$var_7832)->order('num desc')->select();
					$var_7835=Db::table('ims_sudu8_page_cate')->where('uniacid',$var_7826)->where('cid',$var_7832)->order('num desc')->count();
					$var_7833['data']=$var_7834;
					$var_7833['zcount']=$var_7835;
					array_push($var_7829,$var_7833);
				}
				$this->assign('cate',$var_7829);
				$var_14=input('wxappsid');
				$this->assign('wxappsid',$var_14);
				$var_7836='';
				if($var_14)
				{
					$var_7836=Db::table('ims_sudu8_page_wxapps')->where('uniacid',$var_7826)->where('id',$var_14)->find();
					if($var_7836['thumb'])
					{
						$var_7836['thumb']=remote($var_7826,$var_7836['thumb'],1);
					}
				}
				$this->assign('wxappsinfo',$var_7836);
			}
			else
			{
				$var_7837=Session::get('usergroup');
				if($var_7837==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_7837==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_7837==3)
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
		$var_7839=array();
		$var_7839['uniacid']=input('appletid');
		$var_7839['num']=input('num');
		$var_7839['cid']=input('cid');
		$var_7839['type_i']=input('type_i');
		$var_7839['title']=input('title');
		$var_571=input('commonuploadpic');
		if($var_571)
		{
			$var_7839['thumb']=remote($var_7839['uniacid'],$var_571,2);
		}
		$var_7839['appId']=input('appId');
		$var_7839['path']=input('path');
		$var_7839['desc']=input('desc');
		$var_7840=input('wxappsid');
		$var_7841=input('cid');
		$var_7842=Db::table('ims_sudu8_page_cate')->where('id',$var_7841)->where('uniacid',input('appletid'))->field('cid')->find();
		if($var_7842['cid']==0)
		{
			$var_7839['pcid']=$var_7841;
		}
		else
		{
			$var_7839['pcid']=$var_7842['cid'];
		}
		if($var_7840)
		{
			$var_7843=Db::table('ims_sudu8_page_wxapps')->where('id',$var_7840)->update($var_7839);
		}
		else
		{
			$var_7843=Db::table('ims_sudu8_page_wxapps')->insert($var_7839);
		}
		if($var_7843)
		{
			$this->success('小程序信息更新成功！',Url('Wxapps/index').'?appletid='.$var_7839['uniacid']);
		}
		else
		{
			$this->error('小程序信息更新失败，没有修改项！');
			exit;
		}
	}
	public function del()
	{
		$var_7845['id']=input('wxappsid');
		$var_7846=Db::table('ims_sudu8_page_wxapps')->where($var_7845)->delete();
		if($var_7846)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->success('删除失败');
		}
	}
	function onepic_uploade($var_6964)
	{
		$var_4=request()->file($var_6964);
		if(isset($var_4))
		{
			$var_7848=upload_img();
			$var_7849=$var_4->validate(['ext'=>'jpg,png,gif,jpeg'])->move($var_7848);
			if($var_7849)
			{
				$var_7850=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_7849->getFilename();
				return $var_7850;
			}
		}
	}
}
?>