<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Home extends Controller
{
	public function index()
	{
		$var_845='';
		$var_845=Db::table('ims_sudu8_page_system_base')->find();
		$var_6214=Db::table('ims_sudu8_page_system_news')->where('cate',1)->limit(3)->select();
		if($var_6214)
		{
			foreach($var_6214 as &$var_6215)
			{
				$var_6215['creattime']=date('Y-m-d',$var_6215['creattime']);
			}
		}
		$var_6216=Db::table('ims_sudu8_page_system_news')->where('cate',2)->limit(3)->select();
		if($var_6216)
		{
			foreach($var_6216 as &$var_6215)
			{
				$var_6215['creattime']=date('Y-m-d',$var_6215['creattime']);
			}
		}
		$var_6217=Db::table('ims_sudu8_page_system_news')->where('cate',3)->limit(3)->select();
		if($var_6217)
		{
			foreach($var_6217 as &$var_6215)
			{
				$var_6215['creattime']=date('Y-m-d',$var_6215['creattime']);
			}
		}
		$this->assign('news1',$var_6214);
		$this->assign('news2',$var_6216);
		$this->assign('news3',$var_6217);
		$this->assign('sbase',$var_845);
		return $this->fetch(index);
	}
}
?>