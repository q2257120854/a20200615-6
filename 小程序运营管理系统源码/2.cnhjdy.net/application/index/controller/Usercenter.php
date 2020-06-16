<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Usercenter extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_7800=input('appletid');
				$var_7801=Db::table('applet')->where('id',$var_7800)->find();
				if(!$var_7801)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7801);
				$var_7802=Db::table('ims_sudu8_page_usercenter_set')->where('uniacid',$var_7800)->find();
				if($var_7802)
				{
					$var_7803=unserialize($var_7802['usercenterset']);
					for($var_1304=1;$var_1304<=13;$var_1304++)
					{
						if(!isset($var_7803['flag'.$var_1304]))
						{
							$var_7803['flag'.$var_1304]=1;
						}
					}
				}
				else
				{
					$var_7803=array();
				}
				$this->assign('usercenterset',$var_7803);
			}
			else
			{
				$var_7804=Session::get('usergroup');
				if($var_7804==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_7804==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_7804==3)
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
		$var_7806=input('appletid');
		$var_7807=array('title1' =>input('title1'),'num1' =>input('num1'),'thumb1' =>input('img1'),'flag1' =>input('flag1'),'url1' =>input('url1'),'icon1' =>input('icon1'),'title2' =>input('title2'),'num2' =>input('num2'),'thumb2' =>input('img2'),'flag2' =>input('flag2'),'url2' =>input('url2'),'icon2' =>input('icon2'),'title3' =>input('title3'),'num3' =>input('num3'),'thumb3' =>input('img3'),'flag3' =>input('flag3'),'url3' =>input('url3'),'icon3' =>input('icon3'),'title4' =>input('title4'),'num4' =>input('num4'),'thumb4' =>input('img4'),'flag4' =>input('flag4'),'url4' =>input('url4'),'icon4' =>input('icon4'),'title5' =>input('title5'),'num5' =>input('num5'),'thumb5' =>input('img5'),'flag5' =>input('flag5'),'url5' =>input('url5'),'icon5' =>input('icon5'),'title6' =>input('title6'),'num6' =>input('num6'),'thumb6' =>input('img6'),'flag6' =>input('flag6'),'url6' =>input('url6'),'icon6' =>input('icon6'),'title7' =>input('title7'),'num7' =>input('num7'),'thumb7' =>input('img7'),'flag7' =>input('flag7'),'url7' =>input('url7'),'icon7' =>input('icon7'),'title8' =>input('title8'),'num8' =>input('num8'),'thumb8' =>input('img8'),'flag8' =>input('flag8'),'url8' =>input('url8'),'icon8' =>input('icon8'),'title9' =>input('title9'),'num9' =>input('num9'),'thumb9' =>input('img9'),'flag9' =>input('flag9'),'url9' =>input('url9'),'icon9' =>input('icon9'),'title10' =>input('title10'),'num10' =>input('num10'),'thumb10' =>input('img10'),'flag10' =>input('flag10'),'url10' =>input('url10'),'icon10' =>input('icon10'),'title11' =>input('title11'),'num11' =>input('num11'),'thumb11' =>input('img11'),'flag11' =>input('flag11'),'url11' =>input('url11'),'icon11' =>input('icon11'),'title12' =>input('title12'),'num12' =>input('num12'),'thumb12' =>input('img12'),'flag12' =>input('flag12'),'url12' =>input('url12'),'icon12' =>input('icon12'),'title13' =>input('title13'),'num13' =>input('num13'),'thumb13' =>input('img13'),'flag13' =>input('flag13'),'url13' =>input('url13'),'icon13' =>input('icon13'));
		$var_7808=serialize($var_7807);
		$var_7807=array('uniacid' =>$var_7806,'usercenterset' =>$var_7808);
		$var_7809=Db::table('ims_sudu8_page_usercenter_set')->where('uniacid',$var_7806)->find();
		if($var_7809)
		{
			$var_274=Db::table('ims_sudu8_page_usercenter_set')->where('uniacid',$var_7806)->update(array('usercenterset'=>$var_7808));
		}
		else
		{
			$var_274=Db::table('ims_sudu8_page_usercenter_set')->insert($var_7807);
		}
		if($var_274)
		{
			$this->success('更新成功！');
		}
		else
		{
			$this->error('更新失败，没有更新项目！');
			exit;
		}
	}
}
?>