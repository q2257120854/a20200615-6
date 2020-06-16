<?php  namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Wxuser extends Base
{
	public function index()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_7852=input('appletid');
				$var_7853=input('vip');
				$var_7854=input('user_info');
				$var_7855=Db::table('applet')->where('id',$var_7852)->find();
				if(!$var_7855)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7855);
				$var_7856='';
				if($var_7854)
				{
					if($var_7853==2)
					{
						$var_7856=' vipid is not null and (nickname like \'%'.$var_7854.'%\' or mobile like \'%'.$var_7854.'%\')';
					}
					else if($var_7853==3)
					{
						$var_7856=' vipid is null and (nickname like \'%'.$var_7854.'%\' or mobile like \'%'.$var_7854.'%\')';
					}
					else
					{
						$var_7856='nickname like \'%'.$var_7854.'%\' or mobile like \'%'.$var_7854.'%\'';
					}
				}
				else
				{
					if($var_7853==2)
					{
						$var_7856=' vipid is not null';
					}
					else if($var_7853==3)
					{
						$var_7856=' vipid is null';
					}
				}
				$var_7857=Db::table('ims_sudu8_page_user')->where('uniacid',$var_7852)-> where($var_7856)->order('id desc')->paginate(10,false,['query' =>array('appletid'=>input('appletid'))]);
				$var_7858=$var_7857->toArray();
				foreach($var_7858['data'] as &$var_7859)
				{
					$var_7860=Db::table('ims_sudu8_page_order')->where('uniacid',$var_7852)->where('openid',$var_7859['openid'])->count();
					$var_7859['orders']=$var_7860;
					$var_7859['createtime']=$var_7859['createtime']?date('Y-m-d H:i:s',$var_7859['createtime']):date('Y-m-d H:i:s',$var_7859['vipcreatetime']);
					$var_1247=Db::table('ims_sudu8_page_coupon_user')->where('uniacid',$var_7852)->where('flag',0)->where('uid',$var_7859['id'])->count();
					$var_7859['coupon']=$var_1247;
					if(!$var_7859['mobile']|| $var_7859['mobile']=='')
					{
						$var_7859['mobile']='暂未获取到该用户手机号';
					}
					$var_7859['nickname']=rawurldecode($var_7859['nickname']);
				}
				$var_7861=Db::table('ims_sudu8_page_user')->where('uniacid',$var_7852)-> where($var_7856)->order('id desc')->count();
				$this->assign('user',$var_7858);
				$this->assign('userold',$var_7857);
				$this->assign('counts',$var_7861);
			}
			else
			{
				$var_425=Session::get('usergroup');
				if($var_425==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_425==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_425==3)
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
	public function delete()
	{
		$var_7863=input('appletid');
		$var_7864=input('id');
		$var_7865=Db::table('ims_sudu8_page_user')->where('uniacid',$var_7863)->where('id',$var_7864)->delete();
		if($var_7865)
		{
			$this->success('删除成功！');
		}
		else
		{
			$this->error('删除失败！');
		}
	}
	public function cz()
	{
		$var_7867=input('appletid');
		$var_1203=input('type')?input('type'):1;
		$var_7868=input('id');
		$var_7869=Db::table('applet')->where('id',$var_7867)->find();
		if(!$var_7869)
		{
			$this->error('找不到对应的小程序！');
		}
		$this->assign('applet',$var_7869);
		$var_7870=Db::table('ims_sudu8_page_user')->where('uniacid',$var_7867)->where('id',$var_7868)->find();
		$var_7870['createtime']=date('Y-m-d H:i:s',$var_7870['createtime']);
		if(!$var_7870['mobile']|| $var_7870['mobile']=='')
		{
			$var_7870['mobile']='暂未获取到该用户手机号';
		}
		$var_7870['birth']=strtotime($var_7870['birth']);
		$this->assign('item',$var_7870);
		$this->assign('type',$var_1203);
		$var_103=input('op');
		if($var_103==cz)
		{
			$var_7871=input('types');
			if($var_7871==1)
			{
				$var_7872=input('czjf_change');
				if($var_7872==0)
				{
					$var_7873['score']=input('scoreNum')+$var_7870['score'];
				}
				if($var_7872==1)
				{
					$var_7874=$var_7870['score']-input('scoreNum');
					if($var_7874<0)
					{
						$var_7873['score']=0;
					}
					else
					{
						$var_7873['score']=$var_7874;
					}
				}
				if($var_7872==2)
				{
					$var_7873['score']=input('scoreNum');
				}
			}
			if($var_7871==2)
			{
				$v_7=input('czye_change');
				if($v_7==0)
				{
					$var_7873['money']=input('yueNum')+$var_7870['money'];
				}
				if($v_7==1)
				{
					$var_7873['money']=$var_7870['money']-input('yueNum');
					if($var_7873['money']<0)
					{
						$var_7873['money']=0;
					}
				}
				if($v_7==2)
				{
					$var_7873['money']=input('yueNum');
				}
			}
			$var_7869=Db::table('ims_sudu8_page_user')->where('uniacid',$var_7867)->where('id',$var_7868)->update($var_7873);
			if($var_7869)
			{
				$this->success('充值成功');
			}
			else
			{
				$this->error('充值失败');
			}
		}
		return $this->fetch(cz);
	}
	public function post()
	{
		$var_7875=input('appletid');
		$var_7876=Db::table('applet')->where('id',$var_7875)->find();
		if(!$var_7876)
		{
			$this->error('找不到对应的小程序！');
		}
		$this->assign('applet',$var_7876);
		$var_83=input('id');
		$var_7877=Db::table('ims_sudu8_page_user')->where('uniacid',$var_7875)->where('id',$var_83)->find();
		$var_7877['createtime']=date('Y-m-d H:i:s',$var_7877['createtime']);
		if(!$var_7877['mobile']|| $var_7877['mobile']=='')
		{
			$var_7877['mobile']='暂未获取到该用户手机号';
		}
		$var_7877['birth']=strtotime($var_7877['birth']);
		$this->assign('item',$var_7877);
		$var_7878=input('op');
		if($var_7878=='save')
		{
			$var_7879=input('realname');
			$var_7880=input('mobile');
			$var_99=input('birth');
			if(empty($var_7879))
			{
				$this->error('真实姓名不能为空！');
				exit;
			}
			else
			{
				$var_7881['realname']=$var_7879;
			}
			if(empty($var_7880))
			{
				$this->error('手机号不能为空');
				exit;
			}
			else
			{
				$var_7881['mobile']=$var_7880;
			}
			if(empty($var_99))
			{
				$this->error('生日不能为空！');
				exit;
			}
			else
			{
				$var_7881['birth']=$var_99;
			}
			$var_7882=Db::table('ims_sudu8_page_user')->where('uniacid',$var_7875)->where('id',$var_83)->update($var_7881);
			if($var_7882)
			{
				$this->success('修改成功！');
			}
			else
			{
				$this->error('修改失败！');
				exit;
			}
		}
		return $this->fetch(post);
	}
	public function moneyturnove()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_7884=input('appletid');
				$var_7885=Db::table('applet')->where('id',$var_7884)->find();
				if(!$var_7885)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7885);
				$var_7886=input('op');
				if($var_7886=='display')
				{
					$var_7887=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->count();
					$var_7888=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'display')]);
				}
				if($var_7886=='get')
				{
					$var_7887=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->where('a.type','add')->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->count();
					$var_7888=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->where('a.type','add')->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'get')]);
				}
				if($var_7886=='spend')
				{
					$var_7887=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->where('a.type','del')->where('a.message','消费扣金钱')->count();
					$var_7888=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->where('a.type','del')->where('a.message','消费扣金钱')->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'spend')]);
				}
				if($var_7886=='store')
				{
					$var_7887=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->where('a.type','del')->where('a.orderid',1001)->count();
					$var_7888=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->where('a.type','del')->where('a.orderid',1001)->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'store')]);
				}
				if($var_7886=='forum')
				{
					$var_7889=['评论插件信息发布','论坛信息发布'];
					$var_7887=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->where('a.type','del')->where('a.message','in',$var_7889)->count();
					$var_7888=Db::table('ims_sudu8_page_money')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_7884)->where('a.score','gt',0)->where('a.type','del')->where('a.message','in',$var_7889)->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'forum')]);
				}
				$this->assign('scorelist',$var_7888);
				$this->assign('counts',$var_7887);
				$this->assign('op',$var_7886);
			}
			else
			{
				$var_7890=Session::get('usergroup');
				if($var_7890==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_7890==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_7890==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(moneyturnove);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function scoreturnove()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_571=input('appletid');
				$var_7892=Db::table('applet')->where('id',$var_571)->find();
				if(!$var_7892)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7892);
				$var_7893=input('op');
				if($var_7893=='display')
				{
					$var_7894=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->count();
					$var_7895=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'display')]);
				}
				if($var_7893==cz)
				{
					$var_7894=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','充值送积分')->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->count();
					$var_7895=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','充值送积分')->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>cz)]);
				}
				if($var_7893=='xf')
				{
					$var_7894=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','消费')->count();
					$var_7895=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','消费')->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'xf')]);
				}
				if($var_7893=='qd')
				{
					$var_7894=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','签到增加积分')->count();
					$var_7895=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','签到增加积分')->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'qd')]);
				}
				if($var_7893=='fx')
				{
					$var_7894=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','like','%分享%')->count();
					$var_7895=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','like','%分享%')->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'fx')]);
				}
				if($var_7893=='store')
				{
					$var_7894=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','消费扣积分')->count();
					$var_7895=Db::table('ims_sudu8_page_score')->alias('a')->join('ims_sudu8_page_user b','a.uid = b.id')->where('a.uniacid',$var_571)->where('a.score','gt',0)->where('a.message','消费扣积分')->order('a.creattime desc')->field('a.*,b.avatar,b.nickname')->paginate(10,false,['query' =>array('appletid'=>input('appletid'),'op' =>'fx')]);
				}
				$this->assign('scorelist',$var_7895);
				$this->assign('counts',$var_7894);
				$this->assign('op',$var_7893);
			}
			else
			{
				$var_7896=Session::get('usergroup');
				if($var_7896==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_7896==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_7896==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(scoreturnove);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function registerrecord()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_7898=input('appletid');
				$var_7899=Db::table('applet')->where('id',$var_7898)->find();
				if(!$var_7899)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7899);
				$var_7900=Db::table('ims_sudu8_page_user')->where('uniacid',$var_7898)->where('vipid','gt',0)->order('vipcreatetime desc')->field('nickname,vipid,vipcreatetime,avatar')->paginate(10,false,['query' =>array('appletid'=>input('appletid'))]);
				$var_7901=Db::table('ims_sudu8_page_user')->where('uniacid',$var_7898)->where('vipid','gt',0)->order('vipcreatetime desc')->field('nickname,vipid,vipcreatetime,avatar')->count();
				$this->assign('list',$var_7900);
				$this->assign('counts',$var_7901);
			}
			else
			{
				$var_7902=Session::get('usergroup');
				if($var_7902==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_7902==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_7902==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(registerrecord);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function apply()
	{
		if(check_login())
		{
			if(powerget())
			{
				$var_7904=input('appletid');
				$var_7905=Db::table('applet')->where('id',$var_7904)->find();
				if(!$var_7905)
				{
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet',$var_7905);
				$var_7906=Db::table('ims_sudu8_page_vip_apply')->alias('a')->join('ims_sudu8_page_user b','a.openid = b.openid')->where('a.uniacid',$var_7904)->where('b.uniacid',$var_7904)->order('a.id desc')->field('a.*,b.nickname,b.avatar')->paginate(10,false,['query' =>array('appletid'=>input('appletid'))]);
				$var_7907=Db::table('ims_sudu8_page_vip_apply')->alias('a')->join('ims_sudu8_page_user b','a.openid = b.openid')->where('a.uniacid',$var_7904)->where('b.uniacid',$var_7904)->count();
				$this->assign('list',$var_7906);
				$this->assign('counts',$var_7907);
			}
			else
			{
				$var_7908=Session::get('usergroup');
				if($var_7908==1)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/applet');
				}
				if($var_7908==2)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
				if($var_7908==3)
				{
					$this->error('您没有权限操作该小程序或找不到相应小程序！','Applet/index');
				}
			}
			return $this->fetch(apply);
		}
		else
		{
			$this->redirect('Login/index');
		}
	}
	public function applydel()
	{
		$var_7910=input('appletid');
		$var_7911=Db::table('applet')->where('id',$var_7910)->find();
		if(!$var_7911)
		{
			$this->error('找不到对应的小程序！');
		}
		$this->assign('applet',$var_7911);
		$var_2345=intval(input('newsid'));
		$var_7911=Db::table('ims_sudu8_page_vip_apply')->where('uniacid',$var_7910)->where('id',$var_2345)->delete();
		if($var_7911)
		{
			$this->success('删除成功');
		}
		else
		{
			$this->error('删除失败');
		}
	}
	public function applyinfo()
	{
		$var_7913=input('appletid');
		$var_7914=Db::table('applet')->where('id',$var_7913)->find();
		if(!$var_7914)
		{
			$this->error('找不到对应的小程序！');
		}
		$this->assign('applet',$var_7914);
		$var_1668=intval(input('newsid'));
		$var_7915=Db::table('ims_sudu8_page_vip_apply')->alias('a')->join('ims_sudu8_page_user b','a.openid = b.openid')->where('a.id',$var_1668)->where('a.uniacid',$var_7913)->where('b.uniacid',$var_7913)->field('a.*,b.nickname,b.avatar,b.realname,b.birth,b.address,b.mobile')->find();
		$var_7916=Db::table('ims_sudu8_page_formcon')->alias('a')->join('ims_sudu8_page_formlist b','a.fid = b.id')->where('a.id',$var_7915['fid'])->where('a.uniacid',$var_7913)->field('a.*,b.formname as title')->find();
		if($var_7916)
		{
			if(isset($var_7916['val']))
			{
				$var_7916['val']=unserialize($var_7916['val']);
			}
			else
			{
				$var_7916['val']='';
			}
		}
		$this->assign('item',$var_7915);
		$this->assign('forminfo',$var_7916);
		return $this->fetch(applyinfo);
	}
	public function shenhe()
	{
		$var_7918=intval(input('newsid'));
		$var_7919=input('appletid');
		$var_7920=Db::table('ims_sudu8_page_vip_apply')->where('id',$var_7918)->where('uniacid',$var_7919)->find();
		if(!$var_7920)
		{
			$this->error('申请不存在或是已经被删除！');
			exit;
		}
		$var_7921=intval(input('flag'));
		$var_7922=date('Y-m-d H:i:s',time());
		$var_7923='';
		$var_7924='';
		if($var_7921==2)
		{
			$var_7924='会员卡申请审核不通过';
			$var_7923=input('beizhu');
		}
		$var_7925=Db::table('ims_sudu8_page_vip_apply')->where('id',$var_7918)->where('uniacid',$var_7919)->update(array('flag' =>$var_7921,'examinetime' =>$var_7922,'beizhu' =>$var_7923));
		if($var_7921==1)
		{
			$var_7924='会员卡申请审核通过';
			Db::table('ims_sudu8_page_user')->where('openid',$var_7920['openid'])->where('uniacid',$var_7919)->update(array('vipid' =>$var_7920['vipid'],'vipcreatetime' =>time()));
		}
		$var_7926=Db::table('applet')->where('id',$var_7919)->find();
		$var_243=$var_7926['appID'];
		$var_967=$var_7926['appSecret'];
		if($var_7926)
		{
			$var_7927=Db::table('ims_sudu8_page_message')->where('uniacid',$var_7919)->where('flag',12)->find();
			if($var_7927)
			{
				if($var_7927['mid']!='')
				{
					$var_7928=$var_7927['mid'];
					$var_7929='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$var_243.'&secret='.$var_967;
					$var_7930=$this->_requestGetcurl($var_7929);
					if($var_7930)
					{
						$var_7931='https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$var_7930['access_token'];
						$var_7932=$var_7920['formid'];
						$var_647=$var_7920['applytime'];
						$var_7933=$var_7920['openid'];
						$var_7934=$var_7927['url'];
						$var_7935='{' . "\n" . '                                  "touser": "'.$var_7933.'",  ' . "\n" . '                                  "template_id": "'.$var_7928.'", ' . "\n" . '                                  "page": "'.$var_7934.'",          ' . "\n" . '                                  "form_id": "'.$var_7932.'",         ' . "\n" . '                                  "data": {' . "\n" . '                                      "keyword1": {' . "\n" . '                                          "value": "'.$var_7924.'", ' . "\n" . '                                          "color": "#173177"' . "\n" . '                                      },' . "\n" . '                                      "keyword2": {' . "\n" . '                                          "value": "'.$var_647.'", ' . "\n" . '                                          "color": "#173177"' . "\n" . '                                      },' . "\n" . '                                      "keyword3": {' . "\n" . '                                          "value": "'.$var_7922.'", ' . "\n" . '                                          "color": "#173177"' . "\n" . '                                      }' . "\n" . '                                  },' . "\n" . '                                  "emphasis_keyword": "" ' . "\n" . '                                }';
						$this->_requestPost($var_7931,$var_7935);
					}
				}
			}
		}
		$this->success('审核成功');
	}
	function _requestGetcurl($v_1)
	{
		$v_3=curl_init();
		$var_815=array('authorization: Basic YS1sNjI5dmwtZ3Nocmt1eGI2Njp1TlQhQVFnISlWNlkySkBxWlQ=','content-type: application/json','cache-control: no-cache','postman-token: cd81259b-e5f8-d64b-a408-1270184387ca');
		curl_setopt($v_3,CURLOPT_HEADER,1);
		curl_setopt($v_3,CURLOPT_HTTPHEADER,$var_815);
		curl_setopt($v_3,CURLOPT_URL,$v_1);
		curl_setopt($v_3,CURLOPT_HEADER,0);
		curl_setopt($v_3,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($v_3,CURLOPT_TIMEOUT,30);
		curl_setopt($v_3,CURLOPT_SSL_VERIFYPEER,false);
		$var_7937=curl_exec($v_3);
		if(false===$var_7937)
		{
			echo '<br>',curl_error($v_3),'<br>';
			return false;
		}
		curl_close($v_3);
		$var_7938=stripslashes(html_entity_decode($var_7937));
		$var_7938=json_decode($var_7938,true);
		return $var_7938;
	}
	function _requestPost($v_2,$var_67,$v_3=true)
	{
		$var_7940=curl_init();
		curl_setopt($var_7940,CURLOPT_URL,$v_2);
		$var_7941=isset($_SERVER['HTTP_USER_AGENT'])?$_SERVER['HTTP_USER_AGENT']:'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:38.0) Gecko/20100101 Firefox/38.0 FirePHP/0.7.4';
		curl_setopt($var_7940,CURLOPT_USERAGENT,$var_7941);
		curl_setopt($var_7940,CURLOPT_AUTOREFERER,true);
		curl_setopt($var_7940,CURLOPT_TIMEOUT,30);
		if($v_3)
		{
			curl_setopt($var_7940,CURLOPT_SSL_VERIFYPEER,false);
			curl_setopt($var_7940,CURLOPT_SSL_VERIFYHOST,2);
		}
		curl_setopt($var_7940,CURLOPT_POST,true);
		curl_setopt($var_7940,CURLOPT_POSTFIELDS,$var_67);
		curl_setopt($var_7940,CURLOPT_HEADER,false);
		curl_setopt($var_7940,CURLOPT_RETURNTRANSFER,true);
		$var_7942=curl_exec($var_7940);
		if(false===$var_7942)
		{
			echo '<br>',curl_error($var_7940),'<br>';
			return false;
		}
		curl_close($var_7940);
		return $var_7942;
	}
}
?>