<?php  namespace app\comadmin\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class About extends Controller
{
	public function index()
	{
		if(check_login())
		{
			$var_3545=Db::table('ims_sudu8_page_com_about')->field('descs,teamdesc')->find();
			$this->assign('newsinfo',$var_3545);
			return $this->fetch(index);
		}
		else
		{
			$this->redirect('Index/Login/index');
		}
	}
	public function save()
	{
		$var_3546=array();
		$var_3547=input('descs');
		if($var_3547)
		{
			$var_3546['descs']=$var_3547;
		}
		$var_851=input('teamdesc');
		if($var_851)
		{
			$var_3546['teamdesc']=$var_851;
		}
		$var_3548=Db::table('ims_sudu8_page_com_about')->find();
		if($var_3548)
		{
			$var_3549=Db::table('ims_sudu8_page_com_about')->where('id',1)->update($var_3546);
		}
		else
		{
			$var_3549=Db::table('ims_sudu8_page_com_about')->insert($var_3546);
		}
		if($var_3549)
		{
			$this->success('更新成功！');
		}
		else
		{
			$this->error('更新失败，没有修改项！');
			exit;
		}
	}
	public function base()
	{
		if(check_login())
		{
			$var_932=Db::table('ims_sudu8_page_com_about')->find();
			if($var_932['banner'])
			{
				$var_932['banner']=unserialize($var_932['banner']);
				$var_932['banner1']=$var_932['banner']['banner1'];
				$var_932['banner2']=$var_932['banner']['banner2'];
				$var_932['banner3']=$var_932['banner']['banner3'];
				$var_932['banner1_t1']=$var_932['banner']['banner1_t1'];
				$var_932['banner1_t2']=$var_932['banner']['banner1_t2'];
				$var_932['banner2_t1']=$var_932['banner']['banner2_t1'];
				$var_932['banner2_t2']=$var_932['banner']['banner2_t2'];
				$var_932['banner3_t1']=$var_932['banner']['banner3_t1'];
				$var_932['banner3_t2']=$var_932['banner']['banner3_t2'];
			}
			else
			{
				$var_932['banner1']='';
				$var_932['banner2']='';
				$var_932['banner3']='';
				$var_932['banner1_t1']='';
				$var_932['banner1_t2']='';
				$var_932['banner2_t1']='';
				$var_932['banner2_t2']='';
				$var_932['banner3_t1']='';
				$var_932['banner3_t2']='';
			}
			$this->assign('newsinfo',$var_932);
			return $this->fetch(base);
		}
		else
		{
			$this->redirect('Index/Login/index');
		}
	}
	public function basesave()
	{
		$var_3552=array();
		$var_3553=input('name');
		if($var_3553)
		{
			$var_3552['name']=$var_3553;
		}
		$var_3554=input('commonuploadpic1');

		if($var_3554)
		{
			$var_3552['logo']=$var_3554;
		}
		$var_3555=[];
		$var_3555['banner1']=input('commonuploadpic2');
		if(!$var_3555['banner1'])
		{
			$var_3555['banner1']=input('tbanner1');
		}
		$var_3555['banner2']=input('commonuploadpic3');
		if(!$var_3555['banner2'])
		{
			$var_3555['banner2']=input('tbanner2');
		}
		$var_3555['banner3']=input('commonuploadpic4');
		if(!$var_3555['banner3'])
		{
			$var_3555['banner3']=input('tbanner3');
		}
		$var_3555['banner1_t1']=input('banner1_t1');
		$var_3555['banner2_t1']=input('banner2_t1');
		$var_3555['banner3_t1']=input('banner3_t1');
		$var_3555['banner1_t2']=input('banner1_t2');
		$var_3555['banner2_t2']=input('banner2_t2');
		$var_3555['banner3_t2']=input('banner3_t2');
		$var_3552['banner']=serialize($var_3555);
		$var_3556=input('hotline');
		if($var_3556)
		{
			$var_3552['hotline']=$var_3556;
		}
		$var_3557=input('after_sale');
		if($var_3557)
		{
			$var_3552['after_sale']=$var_3557;
		}
		$var_3558=input('email');
		if($var_3558)
		{
			$var_3552['email']=$var_3558;
		}
		$var_3559=input('qq');
		if($var_3559)
		{
			$var_3552['qq']=$var_3559;
		}
		$var_3560=input('commonuploadpic5');
		if($var_3560)
		{
			$var_3552['ewm']=$var_3560;
		}
		$var_3561=input('address');
		if($var_3561)
		{
			$var_3552['address']=$var_3561;
		}
		$var_3562=input('letlon');
		if($var_3562)
		{
			$var_3552['letlon']=$var_3562;
		}
		$var_3563=input('copyright');
		if($var_3563)
		{
			$var_3552['copyright']=$var_3563;
		}
		$var_1314 = input('keywords');
		if($var_1314){
		    $var_3552['keywords']=$var_1314;
        }
        $var_1315 = input('description');
        if($var_1315){
            $var_3552['description']=$var_1315;
        }


		$var_3564=Db::table('ims_sudu8_page_com_about')->find();


		if($var_3564)
		{

			$var_3565=Db::table('ims_sudu8_page_com_about')->where('id',1)->update($var_3552);
		}
		else
		{

			$var_3565=Db::table('ims_sudu8_page_com_about')->insert($var_3552);
		}
		if($var_3565)
		{
			$this->success('更新成功！');
		}
		else
		{
			$this->error('更新失败，没有修改项！');
			exit;
		}
	}
	public function lists()
	{
		$var_312=Db::table('ims_sudu8_page_com_staff')->order('num desc,id desc')->paginate(10);
		$var_3567=Db::table('ims_sudu8_page_com_staff')->count();
		$this->assign('list',$var_312);
		$this->assign(count,$var_3567);
		return $this->fetch(lists);
	}
	public function add()
	{
		if(check_login())
		{
			$var_3569=input('newsid');
			if($var_3569)
			{
				$var_3570=Db::table('ims_sudu8_page_com_staff')->where('id',$var_3569)->find();
			}
			else
			{
				$var_3570='';
			}
			$this->assign('newsid',$var_3569);
			$this->assign('newsinfo',$var_3570);
			return $this->fetch(add);
		}
		else
		{
			$this->redirect('Index/login/index');
		}
	}
	public function addsave()
	{
		$var_3572['num']=input('num');
		$var_3572['flag']=input('flag');
		$var_3572['name']=input('name');
		$var_3572['pic']=input('commonuploadpic1');
		$var_3572['position']=input('position');
		$var_3573=input('newsid');
		if($var_3573)
		{
			$var_3574=Db::table('ims_sudu8_page_com_staff')->where('id',$var_3573)->update($var_3572);
		}
		else
		{
			$var_3572['createtime']=time();
			$var_3574=Db::table('ims_sudu8_page_com_staff')->insert($var_3572);
		}
		if($var_3574)
		{
			$this->success('员工信息更新成功');
		}
		else
		{
			$this->error('员工信息更新失败，没有修改项');
		}
	}
	public function del()
	{
		$var_3575=input('newsid');
		if($var_3575)
		{
			$var_3576=Db::table('ims_sudu8_page_com_staff')->where('id',$var_3575)->delete();
			if($var_3576)
			{
				$this->success('删除成功');
			}
			else
			{
				$this->error('删除失败');
				exit;
			}
		}
	}
}
?>