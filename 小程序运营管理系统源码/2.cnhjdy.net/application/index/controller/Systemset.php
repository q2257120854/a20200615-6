<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Systemset extends Controller
{
	public function index()
	{
		if(check_login())
		{
			$var_14='';
			$var_14=Db::table('ims_sudu8_page_system_base')->find();
			$this->assign('sbase',$var_14);
			return $this->fetch(index);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function add()
	{
		$var_7735=input('name');
		$var_7736=$this->onepic_uploade('logo');
		$var_7737=$this->onepic_uploade('banner');
		$var_7738=$this->onepic_uploade('top_banner');
		$var_7739=$this->onepic_uploade('foot_logo');
		$var_7740=input('ptel');
		$var_2267=input('tel');
		$var_7741=input('ftime');
		$var_7742=input('address');
		$var_7743=input('qq');
		$var_1126=input('email');
		$var_7744=input('beianxx');
		$var_7745=$this->onepic_uploade('erweima');
		$var_7746['name']=$var_7735;
		if($var_7736)
		{
			$var_7746['logo']=$var_7736;
		}
		if($var_7737)
		{
			$var_7746['banner']=$var_7737;
		}
		if($var_7738)
		{
			$var_7746['top_banner']=$var_7738;
		}
		if($var_7739)
		{
			$var_7746['foot_logo']=$var_7739;
		}
		$var_7746['beianxx']=$var_7744;
		$var_7746['ptel']=$var_7740;
		$var_7746['tel']=$var_2267;
		$var_7746['ftime']=$var_7741;
		$var_7746['address']=$var_7742;
		$var_7746['qq']=$var_7743;
		$var_7746['email']=$var_1126;
		if($var_7745)
		{
			$var_7746['erweima']=$var_7745;
		}
		$var_7747=Db::table('ims_sudu8_page_system_base')->count();
		if($var_7747==0)
		{
			$var_100=Db::table('ims_sudu8_page_system_base')->insert($var_7746);
		}
		else
		{
			$var_100=Db::table('ims_sudu8_page_system_base')->where('id',1)->update($var_7746);
		}
		if($var_100)
		{
			$this->success('系统信息更新成功！','Systemset/index');
		}
		else
		{
			$this->error('系统信息更新失败，没有更新项目！');
			exit;
		}
	}
	public function news()
	{
		if(check_login())
		{
			$var_7749='';
			$var_7749=Db::table('ims_sudu8_page_system_news')->order('num desc')->paginate(10,false,['query' =>array('appletid'=>input('appletid'))]);
			$var_697=Db::table('ims_sudu8_page_system_news')->order('num desc')->count();
			$var_459=$var_7749->toArray();
			foreach($var_459['data'] as $var_7750=>&$var_7751)
			{
				$var_7752=Db::table('ims_sudu8_page_system_cate')->where('id',$var_7751['cate'])->find();
				$var_7751['lanmu']=$var_7752['name'];
			}
			$this->assign('newnews',$var_459['data']);
			$this->assign(news,$var_7749);
			$this->assign('counts',$var_697);
			return $this->fetch(news);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function addnews()
	{
		if(check_login())
		{
			$var_651=input('id');
			$var_370=Db::table('ims_sudu8_page_system_cate')->select();
			$this->assign('cate',$var_370);
			$var_382='';
			if($var_651)
			{
				$var_382=Db::table('ims_sudu8_page_system_news')->where('id',$var_651)->find();
			}
			$this->assign(news,$var_382);
			return $this->fetch(addnews);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function savenew()
	{
		if(input('num'))
		{
			$var_5654['num']=input('num');
		}
		else
		{
			$var_5654['num']=50;
		}
		$var_5654['cate']=input('cate');
		$var_5654['title']=input('title');
		$var_243=$this->onepic_uploade('thumb');
		if($var_243)
		{
			$var_5654['thumb']=$var_243;
		}
		$var_5654['desc']=input('desc');
		$var_5654['creattime']=time();
		$var_5654['text']=input('content');
		$var_7755=input('id');
		if($var_7755)
		{
			$var_7756=Db::table('ims_sudu8_page_system_news')->where('id',$var_7755)->update($var_5654);
		}
		else
		{
			$var_7756=Db::table('ims_sudu8_page_system_news')->insert($var_5654);
		}
		if($var_7756)
		{
			$this->success('消息更新成功！','Systemset/news');
		}
		else
		{
			$this->error('消息更新失败，没有更新项目！');
			exit;
		}
	}
	public function del()
	{
		$var_7758['id']=input('id');
		$var_7759=Db::table('ims_sudu8_page_system_news')->where($var_7758)->delete();
		if($var_7759)
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
		$var_7760=request()->file($v_1);
		if(isset($var_7760))
		{
			$v_7=upload_img();
			$var_7761=$var_7760->validate(['ext'=>'jpg,png,gif,jpeg'])->move($v_7);
			if($var_7761)
			{
				$var_363=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_7761->getFilename();
				return $var_363;
			}
		}
	}
	public function imgupload()
	{
		$var_7762=request()->file('');
		foreach($var_7762 as $var_7763)
		{
			$var_7764=$var_7763->validate(['ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH.'public' .DS.'upimages');
			if($var_7764)
			{
				$var_7765=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_7764->getFilename();
				$var_7766=array('url'=>$var_7765);
				return json_encode($var_7766);
			}
			else
			{
				return $this->error($var_7763->getError());
			}
		}
	}
}
?>