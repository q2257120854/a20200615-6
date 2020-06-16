<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Cytablenum extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5809=input('appletid');
				$var_5810=Db::table('applet')->where('id',$var_5809)->find();
				if(!$var_5810)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5810);
				$var_5811=input('op');
				if($var_5811=='ewm')
				{
					$var_5812=input('tnum');
					$var_645=input('id');
					$var_5813=Db::table('applet')->where('id',$var_5809)->find();
					$var_5814=$var_5813['appID'];
					$var_5815=$var_5813['appSecret'];
					$var_5816='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$var_5814.'&secret='.$var_5815;
					$var_5817=file_get_contents($var_5816);
					$var_5818=json_decode($var_5817);
					$var_5819=get_object_vars($var_5818);
					$var_5820=$var_5819['access_token'];
					$var_175='https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=' .$var_5820;
					$var_5821=time().rand(1000,9999);
					$var_5822=['page' =>'sudu8_page_plugin_food/food/food','width' =>500,'scene' =>$var_645];
					$var_5822=json_encode($var_5822);
					$var_5823=$this->_requestPost($var_175,$var_5822);
					file_put_contents(ROOT_PATH.'/public/ewmimg/'.$var_5821.'.jpg',$var_5823);
					$var_5824=ROOT_HOST.'/ewmimg/'.$var_5821.'.jpg';
					$var_733=array('thumb' =>$var_5824);
					Db::table('ims_sudu8_page_food_tables')->where('id',$var_645)->update($var_733);
					$this->success('二维码生成成功');
					exit;
				}
				else
				{
					$var_5825=Db::table('ims_sudu8_page_food_tables')->where('uniacid',$var_5809)->order('tnum desc')->select();
					$this->assign('cates',$var_5825);
				}
			}
			else
			{
				$var_5826=Session::get('usergroup');
				if($var_5826==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5826==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5826==3)
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
	public function _requestPost($v_1,$v_2,$v_2=true)
	{
		$var_5828=curl_init();
		curl_setopt($var_5828,CURLOPT_URL,$v_1);
		$var_204=isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
		curl_setopt($var_5828,CURLOPT_USERAGENT,$var_204);
		curl_setopt($var_5828,CURLOPT_AUTOREFERER,true);
		curl_setopt($var_5828,CURLOPT_TIMEOUT,30);
		if($v_2)
		{
			curl_setopt($var_5828,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($var_5828,CURLOPT_SSL_VERIFYHOST,2);
		}
		curl_setopt($var_5828,CURLOPT_POST,true);
		curl_setopt($var_5828,CURLOPT_POSTFIELDS,$v_2);
		curl_setopt($var_5828,CURLOPT_HEADER,false);
		curl_setopt($var_5828,CURLOPT_RETURNTRANSFER,true);
		$var_5829=curl_exec($var_5828);
		if(false===$var_5829)
		{
			echo '<br>',curl_error($var_5828),'<br>';
			return false;
		}
		curl_close($var_5828);
		return $var_5829;
	}
	public function add()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_5831=input('appletid');
				$var_5832=Db::table('applet')->where('id',$var_5831)->find();
				if(!$var_5832)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_5832);
				$var_5833=input('cateid');
				if($var_5833)
				{
					$var_5706=Db::table('ims_sudu8_page_food_tables')->where('id',$var_5833)->find();
					if($var_5706['uniacid']==$var_5831)
					{
						$var_5834=$var_5706;
					}
					else
					{
						$var_5835=Session::get('usergroup');
						if($var_5835==1)
						{
							$this->error('找不到该栏目，或者该栏目不属于本小程序');
						}
						if($var_5835==2)
						{
							$this->error('找不到该栏目，或者该栏目不属于本小程序');
						}
					}
				}
				else
				{
					$var_5833=0;
					$var_5834='';
				}
				$this->assign('cateid',$var_5833);
				$this->assign('cateinfo',$var_5834);
			}
			else
			{
				$var_5835=Session::get('usergroup');
				if($var_5835==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_5835==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_5835==3)
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
		$var_5837=array();
		$var_5837['uniacid']=input('appletid');
		$var_815=input('num');
		if($var_815)
		{
			$var_5837['tnum']=$var_815;
		}
		$var_5838=input('title');
		if($var_5838)
		{
			$var_5837['title']=$var_5838;
		}
		$var_5839=input('cateid');
		if($var_5839!=0)
		{
			$var_5840=Db::table('ims_sudu8_page_food_tables')->where('id',$var_5839)->update($var_5837);
		}
		else
		{
			$var_5840=Db::table('ims_sudu8_page_food_tables')->insert($var_5837);
		}
		if($var_5840)
		{
			$this->success('点菜分类管理信息更新成功！',Url('Cytablenum/index').'?appletid='.$var_5837['uniacid']);
		}
		else
		{
			$this->error('点菜分类管理信息更新失败，没有修改项！');
			exit;
		}
	}
	public function del()
	{
		$var_5841['id']=input('cateid');
		$v_2=Db::table('ims_sudu8_page_food_tables')->where($var_5841)->delete();
		if($v_2)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->success('删除失败');
		}
	}
	function onepic_uploade($var_905)
	{
		$var_5842=request()->file($var_905);
		if(isset($var_5842))
		{
			$var_5843=upload_img();
			$var_5844=$var_5842->move($var_5843);
			if($var_5844)
			{
				$var_5845=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_5844->getFilename();
				return $var_5845;
			}
		}
	}
	public function imgupload_duo()
	{
		$var_647['appletid']=input('appletid');
		$var_5847=request()->file('');
		foreach($var_5847 as $var_5848)
		{
			$var_5849=$var_5848->move(ROOT_PATH.'public' .DS.'upimages');
			if($var_5849)
			{
				$var_5850=ROOT_HOST.'/upimages/'.date('Ymd',time()).'/'.$var_5849->getFilename();
				$var_5851=array('url'=>$var_5850);
				return json_encode($var_5851);
			}
			else
			{
				return $this->error($var_5848->getError());
			}
		}
	}
}
?>