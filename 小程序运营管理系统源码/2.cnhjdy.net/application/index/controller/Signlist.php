<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Signlist extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_7654=input('appletid');
				$var_571=Db::table('applet')->where('id',$var_7654)->find();
				if(!$var_571)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_571);
				$var_7655=Db::table('ims_sudu8_page_sign')->alias('a')->join('ims_sudu8_page_user b','a.openid = b.openid')->where('b.uniacid',$var_7654)->field('b.nickname,b.avatar,a.*')->paginate(10);
				$var_7656=count($var_7655);
				$var_106=$var_7655->all();
				foreach($var_106 as $var_7657=>$var_7658)
				{
					$var_106[$var_7657]['creattime']=date('Y-m-d H:i:s',$var_7658['creattime']);
				}
				$this->assign('counts',$var_7656);
				$this->assign('page',$var_7655->render());
				$this->assign('sign',$var_106);
			}
			else
			{
				$var_5561=Session::get('usergroup');
				if($var_5561==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5561==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5561==3)
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
		$var_7659=input('appletid');
		$var_7660=Db::table('ims_sudu8_page_sign_con')->where('uniacid',$var_7659)->find();
		$var_7661=input('score');
		$var_7662=input('max_score');
		if(!$var_7661)
		{
			$this->error('随机积分区间不能为空！');
			exit;
		}
		if(!$var_7662)
		{
			$this->error('最大积分不能为空！');
			exit;
		}
		$var_7663=array('score' =>$var_7661,'max_score' =>$var_7662,'uniacid' =>$var_7659);
		if(!$var_7660)
		{
			$var_7664=Db::table('ims_sudu8_page_sign_con')->insert($var_7663);
		}
		else
		{
			$var_7664=Db::table('ims_sudu8_page_sign_con')->where('uniacid',$var_7659)->update($var_7663);
		}
		if($var_7664)
		{
			$this->success('积分签到基本配置更新成功！');
		}
		else
		{
			$this->error('积分签到基本配置更新失败，没有修改项！');
			exit;
		}
	}
	function onepic_uploade($var_1602)
	{
		$var_707=request()->file($var_1602);
		if(isset($var_707))
		{
			$var_7666=upload_img();
			$var_729=$var_707->validate(['ext'=>'jpg,png,gif,jpeg'])->move($var_7666);
			if($var_729)
			{
				$var_538=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_729->getFilename();
				return $var_538;
			}
		}
	}
	public function getimg()
	{
		$var_7667=$_POST['id'];
		$var_425=Db::table('image_url')->where('appletid',$var_7667)->select();
		if($var_425)
		{
			return $var_425;
		}
	}
	public function del()
	{
		$var_7669=input('id');
		$var_7670=Db::table('image_url')->where('id',$var_7669)->delete();
		if($var_7670)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->error('删除失败！');
		}
	}
}
?>