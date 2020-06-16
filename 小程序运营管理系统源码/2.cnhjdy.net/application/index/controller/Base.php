<?php  namespace app\index\controller;
use think\Controller;
use think\Request;
use think\Db;
class Base extends Controller
{
	public function __construct(Request$v_1=null)
	{
		parent::__construct($v_1);
		$this-> is_overdue();
		if(!check_login())
		{
			check_group();
			$this->redirect('Login/index');
		}
		;
	}
	protected function is_overdue()
	{
		$var_4750=input('appletid');
		$var_1304=Db::name('applet')-> where('id',$var_4750)->field('end_time')-> find();
		$var_4751=$var_1304['end_time'];
		$var_4=time();
		if($var_4751!=0)
		{
			if($var_4751<$var_4)
			{
				$this-> error('对不起,您的小程序使用权限已过期,请续费!');
			}
		}
	}
}
?>