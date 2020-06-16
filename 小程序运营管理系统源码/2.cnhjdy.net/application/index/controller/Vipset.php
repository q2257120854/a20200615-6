<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Vipset extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_7811=input('appletid');
				$var_7812=Db::table('applet')->where('id',$var_7811)->find();
				if(!$var_7812)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7812);
				$v_3=Db::table('ims_sudu8_page_formlist')->where('uniacid',$var_7811)->order('id desc')->select();
				$var_254=Db::table('ims_sudu8_page_vip_config')->where('uniacid',$var_7811)->find();
				$var_2265=Db::table('ims_sudu8_page_message')->where('uniacid',$var_7811)->where('flag',12)->find();
				$this->assign('item',$var_254);
				$this->assign('forms',$v_3);
				$this->assign('msg',$var_2265);
			}
			else
			{
				$var_7813=Session::get('usergroup');
				if($var_7813==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_7813==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_7813==3)
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
		$var_7815=input('appletid');
		$var_7816=input('isopen');
		$var_7817=input('name');
		$var_7818=array('isopen' =>input('isopen'),'recharge' =>input('recharge'),'coupon'=>input('coupon'),'sign' =>input('sign'),'exchange' =>input('exchange'),'miaosha' =>input('miaosha'),'duo' =>input('duo'),'yuyue' =>input('yuyue'),'pt' =>input('pt'),'formid' =>input('formid'),'shenhe' =>input('shenhe'),'name' =>empty($var_7817)?'会员卡' :input('name'));
		$var_7819=array('uniacid' =>input('appletid'),'mid' =>input('mid'),'url' =>input('url'));
		$var_7820=Db::table('ims_sudu8_page_message')->where('uniacid',$var_7815)->where('flag',12)->find();
		if($var_7820)
		{
			$var_842=Db::table('ims_sudu8_page_message')->where('uniacid',$var_7815)->where('flag',12)->update($var_7819);
		}
		else
		{
			$var_7819['flag']=12;
			$var_842=Db::table('ims_sudu8_page_message')->insert($var_7819);
		}
		$var_7821=Db::table('ims_sudu8_page_vip_config')->where('uniacid',$var_7815)->find();
		if($var_7821)
		{
			$var_30=Db::table('ims_sudu8_page_vip_config')->where('uniacid',$var_7815)->update($var_7818);
		}
		else
		{
			$var_7818['uniacid']=$var_7815;
			$var_30=Db::table('ims_sudu8_page_vip_config')->insert($var_7818);
		}
		if($var_30|| $var_842)
		{
			$this->success('会员卡设置成功');
		}
		else
		{
			$this->error('会员卡设置更新失败，没有修改项！');
			exit;
		}
	}
}
?>