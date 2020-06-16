<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Scorerecord extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_7347=input('appletid');
				$var_7348=Db::table('applet')->where('id',$var_7347)->find();
				if(!$var_7348)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7348);
				$var_7349=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7347)->where('a.score','gt',0)->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'))]);
				$var_7350=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7347)->where('a.score','gt',0)->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->count();
				$this->assign('counts',$var_7350);
				$this->assign('scorelist',$var_7349);
			}
			else
			{
				$var_7351=Session::get('usergroup');
				if($var_7351==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_7351==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_7351==3)
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
}
?>