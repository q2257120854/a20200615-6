<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
define('TOKEN','kefu');
class Customer extends Controller
{
	public function index()
	{
		if(isset($_GET['echostr']))
		{
			$this->valid();
		}
		else
		{
			$this->responseMsg();
		}
	}
	public function valid()
	{
		$var_5614=$_GET['echostr'];
		if($this->checkSignature())
		{
			echo $var_5614;
			exit;
		}
	}
	public function checkSignature()
	{
		$var_5616=$_GET['signature'];
		$var_5617=$_GET['timestamp'];
		$var_5618=$_GET['nonce'];
		$var_5619=TOKEN;
		$var_5620=array($var_5619,$var_5617,$var_5618);
		sort($var_5620);
		$var_5621=implode($var_5620);
		$var_5621=sha1($var_5621);
		if($var_5621==$var_5616)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	function http_post_data($var_103,$v_1,$v_2=30)
	{
		$var_5623=curl_init();
		curl_setopt($var_5623,CURLOPT_TIMEOUT,$v_2);
		curl_setopt($var_5623,CURLOPT_URL,$var_103);
		curl_setopt($var_5623,CURLOPT_SSL_VERIFYPEER,false);
		curl_setopt($var_5623,CURLOPT_SSL_VERIFYHOST,false);
		curl_setopt($var_5623,CURLOPT_HEADER,false);
		curl_setopt($var_5623,CURLOPT_RETURNTRANSFER,true);
		curl_setopt($var_5623,CURLOPT_POST,true);
		curl_setopt($var_5623,CURLOPT_POSTFIELDS,$v_1);
		curl_setopt($var_5623,CURLOPT_CONNECTTIMEOUT,20);
		curl_setopt($var_5623,CURLOPT_TIMEOUT,40);
		set_time_limit(0);
		$var_5624=curl_exec($var_5623);
		if($var_5624)
		{
			curl_close($var_5623);
			return $var_5624;
		}
		else
		{
			$var_5625=curl_errno($var_5623);
			curl_close($var_5623);
			throw new WxPayException("curl出错，错误码:$var_5625");
		}
	}
	public function responseMsg()
	{
		$var_5626=$GLOBALS['HTTP_RAW_POST_DATA'];
		$var_5627=json_decode($var_5626);
		$var_5628=$var_5627->ToUserName;
		$var_507=Db::table('applet')->where('xcxId',$var_5628)->find();
		$var_471=$var_507['appID'];
		$var_2267=$var_507['appSecret'];
		$var_5629=$var_507['id'];
		$var_23=Db::table('ims_sudu8_page_customer_base')->where('uniacid',$var_5629)->find();
		define('OPENID',$var_23['openid']);
		$var_5630='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$var_471.'&secret='.$var_2267;
		$var_2247=$this->http_post_data($var_5630,'');
		$var_815=json_decode($var_2247)->access_token;
		if(!empty($var_5626))
		{
			$var_5631=$var_5627->FromUserName;
			$var_5632=$var_5627->ToUserName;
			$var_276=$var_5627->MsgType;
			if($var_5631==OPENID)
			{
				if($var_276=='text')
				{
					$var_1013=trim($var_5627->Content);
					$var_408=intval(substr($var_1013,0,strpos($var_1013,':')));
					if($var_408)
					{
						$v_1=Db::table('ims_sudu8_page_user')->where('id',$var_408)->find();
						$v_2=$v_1['openid'];
						$var_1013=substr($var_1013,strpos($var_1013,':')+1);
					}
					if($var_1013=='发送图片')
					{
						Db::table('ims_sudu8_page_customer_pic')->insert(array('openid'=>$v_2,'uniacid'=>$var_5629,'flag'=>1));
						exit;
					}
					else if($var_1013=='获取图片id')
					{
						Db::table('ims_sudu8_page_customer_pic')->insert(array('openid'=>OPENID,'uniacid'=>$var_5629,'flag'=>3));
						exit;
					}
					else
					{
						$var_5633='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$var_815;
						$var_5634='{"touser":"'.$v_2.'","msgtype":"text","text":{"content":"'.$var_1013.'"}}';
						$this->http_post_data($var_5633,$var_5634);
					}
				}
				else if($var_276=='image')
				{
					$var_5635=Db::table('ims_sudu8_page_customer_pic')->where('uniacid',$var_5629)->where('flag',1)->order('id desc')->find();
					$var_5633='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$var_815;
					if($var_5635)
					{
						$v_2=$var_5635['openid'];
						$var_5634='{"touser":"'.$v_2.'","msgtype":"image","image":{"media_id":"'.trim($var_5627->MediaId).'"}}';
						$var_5636=$this->http_post_data($var_5633,$var_5634);
						if(json_decode($var_5636)->errmsg =='ok')
						{
							Db::table('ims_sudu8_page_customer_pic')->where('uniacid',$var_5629)->where('flag',1)->order('id desc')->update(array('flag'=>2));
						}
					}
					else
					{
						$var_5637=Db::table('ims_sudu8_page_customer_pic')->where('uniacid',$var_5629)->where('flag',3)->order('id desc')->find();
						if($var_5637)
						{
							$var_5634='{"touser":"'.OPENID.'","msgtype":"text","text":{"content":"'.$var_5627->MediaId.'"}}';
							$var_5636=$this->http_post_data($var_5633,$var_5634);
							if(json_decode($var_5636)->errmsg =='ok')
							{
								Db::table('ims_sudu8_page_customer_pic')->where('uniacid',$var_5629)->where('flag',3)->order('id desc')->update(array('flag'=>2));
							}
						}
					}
				}
				else[]}
			else
			{
				if(isset($var_5627->SessionFrom))
				{
					$var_5633='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$var_815;
					$var_5638=Db::table('ims_sudu8_page_customer_reply')->where('uniacid',$var_5629)->where('flag',1)->select();
					$var_5639=array();
					if($var_5638)
					{
						foreach($var_5638 as $var_331=>$v_53)
						{
							if($v_53['type']==1)
							{
								$var_1013=$v_53['content'];
								$var_5634='{"touser":"'.$var_5631.'","msgtype":"text","text":{"content":"'.$var_1013.'"}}';
								array_push($var_5639,$var_5634);
							}
							if($v_53['type']==2)
							{
								$var_5640=$v_53['content'];
								$var_5634='{"touser":"'.$var_5631.'","msgtype":"image","image":{"media_id":"'.$var_5640.'"}}';
								array_push($var_5639,$var_5634);
							}
							if($v_53['type']==3)
							{
								$var_1013=unserialize($v_53['content']);
								$var_5641=$var_1013['title'];
								$var_5642=$var_1013['pagepath'];
								$var_5643=$var_1013['picurl'];
								$var_5634='{"touser":"'.$var_5631.'","msgtype":"miniprogrampage","miniprogrampage":{"title":"'.$var_5641.'","pagepath":"'.$var_5642.'","thumb_media_id":"'.$var_5643.'"}}';
								array_push($var_5639,$var_5634);
							}
							if($v_53['type']==4)
							{
								$var_1013=unserialize($v_53['content']);
								$var_5641=$var_1013['title'];
								$var_5644=$var_1013['desc'];
								$var_5645=$var_1013['url'];
								$var_5646=$var_1013['thumb_url'];
								$var_5634='{"touser":"'.$var_5631.'","msgtype":"link","link":{"title":"'.$var_5641.'","description":"'.$var_5644.'","url":"'.$var_5645.'","thumb_url":"'.$var_5646.'"}}';
								array_push($var_5639,$var_5634);
							}
						}
						$var_5636=true;
						$var_5647=dirname(__DIR__).'/test.txt';
						$var_5648=fopen($var_5647,'w');
						while($var_5636)
						{
							$var_5634=array_pop($var_5639);
							if(empty($var_5634))
							{
								$var_5636=false;
							}
							else
							{
								$var_5636=$this->http_post_data($var_5633,$var_5634);
								fwrite($var_5648,(String)$var_5636);
							}
						}
						fclose($var_5648);
					}
					else
					{
						$var_5634='{"touser":"'.$var_5631.'","msgtype":"text","text":{"content":"您好，有什么可以帮助您？"}}';
						$this->http_post_data($var_5633,$var_5634);
					}
				}
				else if($var_276=='text')
				{
					$var_1013=trim($var_5627->Content);
					if($var_1013=='openid')
					{
						$var_5633='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$var_815;
						$var_5634='{"touser":"'.$var_5631.'","msgtype":"text","text":{"content":"'.$var_5631.'"}';
						$var_5636=$this->http_post_data($var_5633,$var_5634);
					}
					else
					{
						$v_1=Db::table('ims_sudu8_page_user')->where('openid',$var_5631)->find();
						$var_408=$v_1['id'];
						$var_5649=$v_1['nickname'];
						$var_5633='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$var_815;
						$var_5634='{"touser":"'.OPENID.'","msgtype":"text","text":{"content":"['.$var_408.']'.$var_5649.'：'.$var_1013.'"}}';
						$this->http_post_data($var_5633,$var_5634);
					}
				}
				else if($var_276=='image')
				{
					$v_1=Db::table('ims_sudu8_page_user')->where('openid',$var_5631)->find();
					$var_408=$v_1['id'];
					$var_5649=$v_1['nickname'];
					$var_5633='https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$var_815;
					$var_5650='{"touser":"'.OPENID.'","msgtype":"text","text":{"content":"['.$var_408.']'.$var_5649.'：用户图片如下"}}';
					$var_5651='{"touser":"'.OPENID.'","msgtype":"image","image":{"media_id":"'.trim($var_5627->MediaId).'"}}';
					$this->http_post_data($var_5633,$var_5650);
					$this->http_post_data($var_5633,$var_5651);
				}
				else[]}
		}
	}
}
?>