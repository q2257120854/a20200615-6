<?php

//decode by http://www.yunlu99.com/
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
vendor('Qiniu.autoload');
use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use Qiniu\Storage\UploadManager;
class Pt extends Base
{
	public function set()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_0 = input('appletid');
				$_var_1 = Db::table('applet')->where('id', $_var_0)->find();
				if (!$_var_1) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_1);
				$_var_2 = Db::table('ims_sudu8_page_pt_gz')->where('uniacid', $_var_0)->find();
				$this->assign('pintuan', $_var_2);
			} else {
				$_var_3 = Session::get('usergroup');
				if ($_var_3 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_3 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_3 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('set');
		} else {
			$this->redirect('Login/index');
		}
	}
	function printf_info($_var_4)
	{
		foreach ($_var_4 as $_var_5 => $_var_6) {
			echo "<font color='#f00;'>{$_var_5}</font> : {$_var_6} <br/>";
		}
	}
	public function tuikuan()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_7 = input('appletid');
				$_var_8 = Db::table('applet')->where('id', $_var_7)->find();
				if (!$_var_8) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_8);
				$_var_9 = input('op');
				if ($_var_9) {
					if ($_var_9 == 'shenhe') {
						$_var_10 = input('id');
						$_var_11 = input('val');
						$_var_12 = Db::table('ims_sudu8_page_pt_tx')->where('id', $_var_10)->where('uniacid', $_var_7)->find();
						$_var_13 = Db::table('ims_sudu8_page_pt_order')->where('order_id', $_var_12['ptorder'])->where('flag', 5)->where('uniacid', $_var_7)->find();
						$_var_14 = $_var_13['yue_price'];
						$_var_15 = $_var_13['wx_price'];
						$_var_16 = Db::table('ims_sudu8_page_user')->where('openid', $_var_12['openid'])->where('uniacid', $_var_7)->find();
						if ($_var_11 == 2) {
							$_var_17 = array();
							if ($_var_14 > 0) {
								$_var_18 = $_var_16['money'] + $_var_14;
								$_var_19 = array('money' => $_var_18);
								Db::table('ims_sudu8_page_user')->where('id', $_var_16['id'])->update($_var_19);
								Db::table('ims_sudu8_page_pt_order')->where('id', $_var_13['id'])->update(array('yue_price' => 0));
							}
							if ($_var_15 > 0) {
								$_var_20 = Db::table('applet')->where('id', $_var_7)->find();
								$_var_21 = $_var_20['mchid'];
								$_var_22 = $_var_20['signkey'];
								$_var_23 = $_var_20['appID'];
								$_var_24 = $_var_20['appSecret'];
								$_var_25 = Db::table('ims_sudu8_page_pt_tx')->where('uniacid', $_var_7)->where('id', $_var_10)->find();
								$_var_26 = $_var_25['openid'];
								$_var_27 = $_var_25['ptorder'];
								$_var_28 = $_var_25['money'] * 100;
								$_var_29 = $_var_25['ptorder'];
								$_var_30 = $_var_25['money'] * 100;
								$_var_31 = ROOT_PATH . 'public/Cert/' . $_var_7 . '/apiclient_cert.pem';
								$_var_32 = ROOT_PATH . 'public/Cert/' . $_var_7 . '/apiclient_key.pem';
								$_var_33 = $_var_21;
								include 'WinXinRefund.php';
								$_var_34 = new WinXinRefund($_var_26, $_var_27, $_var_28, $_var_29, $_var_30, $_var_31, $_var_32, $_var_33, $_var_23, $_var_22);
								$_var_17 = $_var_34->refund();
								if (!$_var_17) {
									$this->error('退款失败 请检查证书是否正常');
								}
							}
							if ($_var_17) {
								if ($_var_17['result_code'] == 'SUCCESS') {
									if ($_var_15 > 0) {
										$_var_35 = array('uniacid' => $_var_7, 'orderid' => $_var_12['ptorder'], 'uid' => $_var_16['id'], 'type' => 'add', 'score' => $_var_15, 'message' => '拼团失败退款', 'creattime' => time());
										Db::table('ims_sudu8_page_money')->insert($_var_35);
									}
									if ($_var_14 > 0) {
										$_var_36 = array('uniacid' => $_var_7, 'orderid' => $_var_12['ptorder'], 'uid' => $_var_16['id'], 'type' => 'add', 'score' => $_var_14, 'message' => '拼团失败退款', 'creattime' => time());
										Db::table('ims_sudu8_page_money')->insert($_var_36);
									}
									Db::table('ims_sudu8_page_pt_tx')->where('id', $_var_10)->update(array('flag' => 2, 'txtime' => time()));
									Db::table('ims_sudu8_page_pt_order')->where('id', $_var_13['id'])->update(array('wx_price' => 0));
									$this->success('退款成功 状态修改成功');
								} else {
									$this->error('退款失败 非微信支付订单或商户余额不足');
								}
							} else {
								if ($_var_15 > 0) {
									$_var_35 = array('uniacid' => $_var_7, 'orderid' => $_var_12['ptorder'], 'uid' => $_var_16['id'], 'type' => 'add', 'score' => $_var_15, 'message' => '拼团失败退款', 'creattime' => time());
									Db::table('ims_sudu8_page_money')->insert($_var_35);
								}
								if ($_var_14 > 0) {
									$_var_36 = array('uniacid' => $_var_7, 'orderid' => $_var_12['ptorder'], 'uid' => $_var_16['id'], 'type' => 'add', 'score' => $_var_14, 'message' => '拼团失败退款', 'creattime' => time());
									Db::table('ims_sudu8_page_money')->insert($_var_36);
								}
								Db::table('ims_sudu8_page_pt_tx')->where('id', $_var_10)->update(array('flag' => 2, 'txtime' => time()));
								$this->success('退款成功');
							}
						}
						if ($_var_11 == 3) {
							Db::table('ims_sudu8_page_pt_tx')->where('id', $_var_10)->update(array('flag' => 3, 'txtime' => time()));
							$this->success('提现状态 修改成功');
						}
					}
				} else {
					$_var_25 = Db::table('ims_sudu8_page_pt_tx')->where('uniacid', $_var_7)->order('id desc')->select();
					foreach ($_var_25 as $_var_37 => &$_var_8) {
						$_var_38 = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_7)->where('openid', $_var_8['openid'])->find();
						$_var_8['userinfo'] = $_var_38;
						$_var_8['creattime'] = date('Y-m-d H:i:s', $_var_8['creattime']);
					}
					$this->assign('sqtx', $_var_25);
				}
			} else {
				$_var_39 = Session::get('usergroup');
				if ($_var_39 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_39 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_39 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('tkreply');
		} else {
			$this->redirect('Login/index');
		}
	}
	public function setsave()
	{
		$_var_40 = array();
		$_var_40['uniacid'] = input('appletid');
		$_var_40['types'] = input('types');
		$_var_40['is_pt'] = input('is_pt');
		$_var_40['pt_time'] = input('pt_time');
		if ($_var_40['pt_time'] == 0 || $_var_40['pt_time'] == null || $_var_40['pt_time'] == '') {
			$_var_40['pt_time'] = 24;
		}
		$_var_40['fahuo'] = input('fahuo');
		if ($_var_40['fahuo'] == 0 || $_var_40['fahuo'] == null || $_var_40['fahuo'] == '') {
			$_var_40['fahuo'] = 7;
		}
		$_var_40['guiz'] = input('content');
		$_var_41 = Db::table('ims_sudu8_page_pt_gz')->where('uniacid', $_var_40['uniacid'])->find();
		if (!$_var_41) {
			$_var_42 = Db::table('ims_sudu8_page_pt_gz')->insert($_var_40);
		} else {
			$_var_42 = Db::table('ims_sudu8_page_pt_gz')->where('uniacid', $_var_40['uniacid'])->update($_var_40);
		}
		if ($_var_42) {
			$this->success('拼团规则新增/更新成功!');
		} else {
			$this->error('拼团规则新增/更新更新失败，没有修改项！');
			exit;
		}
	}
	public function yaoqing()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_43 = input('appletid');
				$_var_44 = Db::table('applet')->where('id', $_var_43)->find();
				if (!$_var_44) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_44);
				$this->doovershare($_var_43);
				$_var_45 = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $_var_43)->order('id desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
				$_var_46 = $_var_45->all();
				$_var_47 = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $_var_43)->order('id desc')->count();
				$_var_48 = Db::table('ims_sudu8_page_pt_gz')->where('uniacid', $_var_43)->find();
				foreach ($_var_46 as $_var_49 => &$_var_44) {
					$_var_50 = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $_var_43)->where('id', $_var_44['pid'])->find();
					if ($_var_50['thumb']) {
						$_var_50['thumb'] = remote($_var_43, $_var_50['thumb'], 1);
					} else {
						$_var_50['thumb'] = remote($_var_43, '/image/noimage_1.png', 1);
					}
					$_var_44['pro'] = $_var_50;
					$_var_51 = $_var_44['creattime'] * 1 + $_var_48['pt_time'] * 3600;
					$_var_44['creattime'] = date('Y-m-d H:i:s', $_var_44['creattime']);
					$_var_44['overtime'] = date('Y-m-d H:i:s', $_var_51);
					$_var_44['team'] = $this->getmytd($_var_43, $_var_44['shareid']);
				}
				$this->assign('plist', $_var_46);
				$this->assign('orders', $_var_45);
				$this->assign('counts', $_var_47);
			} else {
				$_var_52 = Session::get('usergroup');
				if ($_var_52 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_52 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_52 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('yaoqing');
		} else {
			$this->redirect('Login/index');
		}
	}
	function getmytd($_var_53, $_var_54)
	{
		$_var_55 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_53)->where('flag', 'neq', 0)->where('flag', 'neq', 3)->where('pt_order', $_var_54)->order('creattime desc')->select();
		foreach ($_var_55 as $_var_56 => &$_var_57) {
			$_var_58 = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_53)->where('openid', $_var_57['openid'])->find();
			$_var_57['team'] = $_var_58;
		}
		return $_var_55;
	}
	public function cate()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_59 = input('appletid');
				$_var_60 = Db::table('applet')->where('id', $_var_59)->find();
				if (!$_var_60) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_60);
				$_var_61 = Db::table('ims_sudu8_page_pt_cate')->where('uniacid', $_var_59)->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
				$_var_62 = Db::table('ims_sudu8_page_pt_cate')->where('uniacid', $_var_59)->order('num desc')->count();
				$this->assign('cates', $_var_61);
				$this->assign('counts', $_var_62);
			} else {
				$_var_63 = Session::get('usergroup');
				if ($_var_63 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_63 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_63 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('cate');
		} else {
			$this->redirect('Login/index');
		}
	}
	public function cateadd()
	{
		$_var_64 = input('appletid');
		$_var_65 = Db::table('applet')->where('id', $_var_64)->find();
		if (!$_var_65) {
			$this->error('找不到对应的小程序！');
		}
		$this->assign('applet', $_var_65);
		$_var_66 = intval(input('cateid'));
		$_var_67 = Db::table('ims_sudu8_page_pt_cate')->where('uniacid', $_var_64)->where('id', $_var_66)->find();
		if (!$_var_66) {
			$_var_66 = 0;
		}
		$this->assign('cate', $_var_67);
		$this->assign('cateid', $_var_66);
		return $this->fetch('cateadd');
	}
	public function catesave()
	{
		$_var_68 = array();
		$_var_69 = input('appletid');
		$_var_70 = input('num');
		if ($_var_70) {
			$_var_68['num'] = $_var_70;
		} else {
			$_var_68['num'] = 1;
		}
		$_var_71 = input('title');
		if ($_var_71) {
			$_var_68['title'] = $_var_71;
		} else {
			$this->error('栏目名称不能为空！');
			exit;
		}
		$_var_68['creattime'] = time();
		$_var_72 = intval(input('cateid'));
		if (!$_var_72) {
			$_var_68['uniacid'] = $_var_69;
			$_var_73 = Db::table('ims_sudu8_page_pt_cate')->where('uniacid', $_var_69)->select();
			foreach ($_var_73 as $_var_74) {
				if ($_var_74['title'] == $_var_71) {
					$this->error('栏目名称已经存在');
					exit;
				}
			}
			$_var_75 = Db::table('ims_sudu8_page_pt_cate')->insert($_var_68);
		} else {
			$_var_73 = Db::table('ims_sudu8_page_pt_cate')->where('uniacid', $_var_69)->where('id', 'neq', $_var_72)->select();
			foreach ($_var_73 as $_var_74) {
				if ($_var_74['title'] == $_var_71) {
					$this->error('栏目名称已经存在');
					exit;
				}
			}
			$_var_75 = Db::table('ims_sudu8_page_pt_cate')->where('id', $_var_72)->where('uniacid', $_var_69)->update($_var_68);
		}
		if ($_var_75) {
			$this->success('拼团分类新增/更新成功!', Url('Pt/cate') . '?appletid=' . $_var_69);
		} else {
			$this->error('拼团分类新增/更新更新失败，没有修改项！');
			exit;
		}
	}
	public function catedel()
	{
		$_var_76 = input('appletid');
		$_var_77 = input('cateid');
		$_var_78 = array('uniacid' => $_var_76, 'id' => $_var_77);
		$_var_79 = Db::table('ims_sudu8_page_pt_cate')->where($_var_78)->delete();
		if ($_var_79) {
			$this->success('拼团栏目删除成功');
		} else {
			$this->success('拼团栏目删除失败');
		}
	}
	public function pro()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_80 = input('appletid');
				$_var_81 = Db::table('applet')->where('id', $_var_80)->find();
				if (!$_var_81) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_81);
				$_var_82 = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $_var_80)->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
				$_var_83 = $_var_82->all();
				if ($_var_83) {
					foreach ($_var_83 as $_var_84 => &$_var_81) {
						$_var_85 = Db::table('ims_sudu8_page_pt_cate')->where('uniacid', $_var_80)->where('id', $_var_81['cid'])->find();
						$_var_81['cate'] = $_var_85['title'];
						if ($_var_81['thumb']) {
							$_var_81['thumb'] = remote($_var_80, $_var_81['thumb'], 1);
						} else {
							$_var_81['thumb'] = remote($_var_80, '/image/noimage.jpg', 1);
						}
					}
				}
				$_var_86 = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $_var_80)->count();
				$this->assign('products', $_var_82);
				$this->assign('prolist', $_var_83);
				$this->assign('counts', $_var_86);
			} else {
				$_var_87 = Session::get('usergroup');
				if ($_var_87 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_87 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_87 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('pro');
		} else {
			$this->redirect('Login/index');
		}
	}
	public function proadd()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_88 = input('appletid');
				$_var_89 = Db::table('applet')->where('id', $_var_88)->find();
				if (!$_var_89) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_89);
				$_var_90 = input('pid');
				$_var_91 = Db::table('ims_sudu8_page_pt_cate')->where('uniacid', $_var_88)->order('num desc')->order('id desc')->select();
				if ($_var_90) {
					$_var_92 = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $_var_88)->where('id', $_var_90)->find();
					$_var_93 = Db::table('products_url')->where('randid', $_var_92['onlyid'])->select();
					foreach ($_var_93 as $_var_94 => &$_var_95) {
						$_var_95['url'] = remote($_var_88, $_var_95['url'], 1);
					}
					if ($_var_92['thumb']) {
						$_var_92['thumb'] = remote($_var_88, $_var_92['thumb'], 1);
					}
					if ($_var_92['shareimg']) {
						$_var_92['shareimg'] = remote($_var_88, $_var_92['shareimg'], 1);
					}
					$_var_96 = Db::table('ims_sudu8_page_pt_pro_val')->where('pid', $_var_90)->order('id desc')->select();
					if ($_var_96) {
						$_var_97 = $_var_96[0]['comment'];
						$_var_98 = explode(',', $_var_97);
						$_var_99 = count($_var_98);
						$_var_100 = [];
						foreach ($_var_98 as $_var_94 => &$_var_101) {
							$_var_102 = 'type' . ($_var_94 + 1);
							$_var_103 = Db::table('ims_sudu8_page_pt_pro_val')->where('pid', $_var_90)->group($_var_102)->field($_var_102)->select();
							$_var_104 = array();
							foreach ($_var_103 as $_var_94 => $_var_89) {
								array_push($_var_104, $_var_89[$_var_102]);
							}
							$_var_100[$_var_101] = $_var_104;
						}
						$_var_105 = [];
						foreach ($_var_96 as $_var_94 => &$_var_101) {
							$_var_106 = $_var_101['type1'] . $_var_101['type2'] . $_var_101['type3'];
							$_var_107 = $_var_101['kc'] . ',' . $_var_101['price'] . ',' . $_var_101['dprice'] . ',' . $_var_101['thumb'];
							$_var_105[$_var_106] = $_var_107;
						}
					} else {
						$_var_99 = 0;
					}
				} else {
					$_var_92 = '';
					$_var_90 = 0;
					$_var_93 = '';
					$_var_99 = 0;
					$_var_98 = [];
					$_var_100 = [];
					$_var_105 = [];
				}
				$this->assign('counttypes', $_var_99);
				$this->assign('typesarr', $_var_98);
				$this->assign('typesjson', $_var_100);
				$this->assign('datajson', $_var_105);
				$this->assign('allimg', $_var_93);
				$this->assign('id', $_var_90);
				$this->assign('products', $_var_92);
				$this->assign('listAll', $_var_91);
				$_var_108 = Db::table('ims_sudu8_page_store')->where('uniacid', $_var_88)->select();
				$this->assign('stores', $_var_108);
			} else {
				$_var_109 = Session::get('usergroup');
				if ($_var_109 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_109 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_109 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('proadd');
		} else {
			$this->redirect('Login/index');
		}
	}
	public function prosave()
	{
		$_var_110 = input('appletid');
		$_var_111 = input('pid');
		$_var_112 = intval(input('cid'));
		$_var_113 = input('onlyid');
		if ($_var_113) {
			$_var_114 = input('imgsrcs/a');
			if ($_var_114) {
				$_var_115 = array();
				foreach ($_var_114 as $_var_116 => $_var_117) {
					$_var_115['randid'] = $_var_113;
					$_var_115['appletid'] = $_var_110;
					$_var_115['url'] = remote($_var_110, $_var_117, 2);
					$_var_115['dateline'] = time();
					$_var_118 = Db::table('products_url')->insert($_var_115);
				}
			} else {
				$_var_118 = 1;
			}
		}
		$_var_119 = Db::table('products_url')->where('randid', $_var_113)->select();
		$_var_120 = array();
		foreach ($_var_119 as $_var_116 => $_var_117) {
			array_push($_var_120, $_var_117['url']);
		}
		$_var_121 = Db::table('ims_sudu8_page_pt_cate')->where('uniacid', $_var_110)->where('id', $_var_112)->find();
		$_var_122 = input('tz_yh');
		if (!$_var_122) {
			$_var_122 = 10;
		}
		$_var_123 = input('type_x');
		if (!$_var_123) {
			$_var_123 = 0;
		}
		$_var_124 = input('type_y');
		if (!$_var_124) {
			$_var_124 = 0;
		}
		$_var_125 = input('type_i');
		if (!$_var_125) {
			$_var_125 = 0;
		}
		$_var_126 = input('kuaidi');
		if (!$_var_126) {
			$_var_126 = 0;
		}
		$_var_127 = input('stores');
		if (!$_var_127) {
			$_var_127 = null;
		}
		if ($_var_121) {
			$_var_128 = array('uniacid' => $_var_110, 'num' => input('num'), 'cid' => input('cid'), 'type_x' => $_var_123, 'type_y' => $_var_124, 'type_i' => $_var_125, 'title' => input('title'), 'price' => input('price'), 'mark_price' => input('mark_price'), 'imgtext' => serialize($_var_120), 'descs' => input('descs'), 'explains' => input('explains'), 'score' => input('score'), 'onlyid' => $_var_113, 'texts' => input('texts'), 'pt_min' => input('pt_min'), 'pt_max' => input('pt_max'), 'tz_yh' => $_var_122, 'kuaidi' => $_var_126, 'stores' => $_var_127);
			$_var_129 = input('commonuploadpic1');
			if ($_var_129) {
				$_var_128['thumb'] = remote($_var_110, $_var_129, 2);
			}
			$_var_130 = input('commonuploadpic2');
			if ($_var_130) {
				$_var_128['shareimg'] = remote($_var_110, $_var_130, 2);
			}
			$_var_131 = input('ischeck');
			$_var_128['types'] = intval($_var_131);
			if ($_var_111) {
				Db::table('ims_sudu8_page_pt_pro')->where('id', $_var_111)->update($_var_128);
				$_var_132 = $_var_111;
			} else {
				$_var_132 = Db::table('ims_sudu8_page_pt_pro')->insertGetId($_var_128);
			}
			$_var_133 = input('typelen');
			$_var_134 = input('typesarr');
			$_var_135 = $_var_134;
			$_var_136 = explode(',', $_var_134);
			$_var_137 = stripslashes(html_entity_decode(input('biaogedata')));
			$_var_138 = json_decode($_var_137, true);
			$_var_139 = 0;
			$_var_140 = Db::table('ims_sudu8_page_pt_pro_val')->where('pid', $_var_132)->count();
			foreach ($_var_138 as $_var_141 => $_var_142) {
				if ($_var_133 == 1) {
					$_var_143 = $_var_142[$_var_136[0]];
					$_var_144 = '';
					$_var_145 = '';
				}
				if ($_var_133 == 2) {
					$_var_143 = $_var_142[$_var_136[0]];
					$_var_144 = $_var_142[$_var_136[1]];
					$_var_145 = '';
				}
				if ($_var_133 == 3) {
					$_var_143 = $_var_142[$_var_136[0]];
					$_var_144 = $_var_142[$_var_136[1]];
					$_var_145 = $_var_142[$_var_136[2]];
				}
				$_var_146 = array('pid' => $_var_132, 'type1' => $_var_143, 'type2' => $_var_144, 'type3' => $_var_145, 'kc' => $_var_142['库存'], 'price' => $_var_142['拼团价'], 'dprice' => $_var_142['单买价'], 'thumb' => $_var_142['规格图片'], 'comment' => $_var_135, 'updatetime' => time());
				if ($_var_140 > 0) {
					$_var_147 = $_var_140 - $_var_141;
					if ($_var_141 < $_var_140) {
						$_var_148 = Db::table('ims_sudu8_page_pt_pro_val')->where('pid', $_var_132)->select();
						$_var_149 = Db::table('ims_sudu8_page_pt_pro_val')->where('id', $_var_148[$_var_141]['id'])->update($_var_146);
					} else {
						$_var_149 = Db::table('ims_sudu8_page_pt_pro_val')->insert($_var_146);
					}
				} else {
					$_var_149 = Db::table('ims_sudu8_page_pt_pro_val')->insert($_var_146);
				}
				if ($_var_149) {
					$_var_139++;
					if ($_var_139 == count($_var_138)) {
						$this->success('拼团商品更新成功', Url('Pt/pro') . '?appletid=' . $_var_110);
					}
				}
			}
		}
	}
	public function prodel()
	{
		$_var_150 = input('appletid');
		$_var_151 = input('pid');
		$_var_152 = array('uniacid' => $_var_150, 'id' => $_var_151);
		$_var_153 = Db::table('ims_sudu8_page_pt_pro')->where($_var_152)->delete();
		if ($_var_153) {
			$this->success('拼团商品删除成功');
		} else {
			$this->success('拼团商品删除失败');
		}
	}
	public function order()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_154 = input('appletid');
				$_var_155 = Db::table('applet')->where('id', $_var_154)->find();
				if (!$_var_155) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_155);
				$_var_156 = input('op');
				$_var_157 = array('display', 'hx', 'fahuo', 'fh');
				$_var_156 = in_array($_var_156, $_var_157) ? $_var_156 : 'display';
				$this->doovershare($_var_154);
				if ($_var_156 == 'hx') {
					$_var_158 = input('orderid');
					$_var_159['hxtime'] = time();
					$_var_159['flag'] = 2;
					$_var_155 = Db::table('ims_sudu8_page_pt_order')->where('id', $_var_158)->update($_var_159);
					if ($_var_155) {
						$this->success('核销成功');
					}
				}
				if ($_var_156 == 'fh') {
					$_var_158 = input('orderid');
					$_var_159['flag'] = 2;
					$_var_155 = Db::table('ims_sudu8_page_pt_order')->where('id', $_var_158)->update($_var_159);
					if ($_var_155) {
						$this->success('操作成功');
					}
				}
				if ($_var_156 == 'fahuo') {
					$_var_158 = input('orderid');
					$_var_159['hxtime'] = time();
					$_var_159['kuadi'] = input('kuadi');
					$_var_159['kuaidihao'] = input('kuaidihao');
					$_var_159['flag'] = 4;
					$_var_155 = Db::table('ims_sudu8_page_pt_order')->where('id', $_var_158)->update($_var_159);
					if ($_var_155) {
						$this->success('发货成功');
					}
				}
				$_var_160 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_154)->where('flag', 4)->select();
				$_var_161 = Db::table('ims_sudu8_page_pt_gz')->where('uniacid', $_var_154)->find();
				foreach ($_var_160 as $_var_162 => &$_var_155) {
					$_var_163 = $_var_155['hxtime'] + 3600 * 24 * $_var_161['fahuo'];
					if ($_var_163 < time()) {
						$_var_164 = array('hxtime' => $_var_163, 'flag' => 2);
						Db::table('ims_sudu8_page_pt_order')->where('id', $_var_155['id'])->update($_var_164);
						$_var_165 = $_var_155['order_id'];
						$_var_166 = $_var_155['openid'];
						$_var_167 = Db::table('ims_sudu8_page_fx_ls')->where('uniacid', $_var_154)->where('order_id', $_var_165)->find();
						if ($_var_167) {
							$this->dopagegivemoney($_var_154, $_var_166, $_var_165);
						}
					}
				}
				$_var_168 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_154)->where('flag', 0)->select();
				foreach ($_var_168 as $_var_162 => &$_var_155) {
					$_var_163 = $_var_155['creattime'] + 1800;
					if ($_var_163 < time()) {
						$_var_164 = array('flag' => 3);
						Db::table('ims_sudu8_page_pt_order')->where('id', $_var_155['id'])->update($_var_164);
						Db::table('ims_sudu8_page_fx_ls')->where('uniacid', $_var_154)->where('order_id', $_var_155['order_id'])->update($_var_164);
					}
				}
				$_var_165 = input('order_id');
				$_var_169 = input('ptorder');
				if ($_var_165) {
					$_var_170 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_154)->where('order_id', 'like', '%' . $_var_165 . '%')->where('jqr', 1)->order('creattime desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
					$_var_171 = $_var_170->all();
					$_var_172 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_154)->where('order_id', 'like', '%' . $_var_165 . '%')->where('jqr', 1)->order('creattime desc')->count();
					foreach ($_var_171 as $_var_162 => &$_var_155) {
						$_var_173 = Db::table('ims_sudu8_page_pt_tx')->where('ptorder', $_var_155['order_id'])->where('uniacid', $_var_154)->find();
						$_var_155['pt_tx'] = $_var_173;
						$_var_174 = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $_var_154)->where('shareid', $_var_155['pt_order'])->find();
						$_var_155['join_count'] = $_var_174['join_count'];
						$_var_155['pt_min'] = $_var_174['pt_min'];
						$_var_155['pt_max'] = $_var_174['pt_max'];
						$_var_155['hxinfo2'] = '';
						if ($_var_155['hxinfo'] == '' || $_var_155['hxinfo'] == null) {
							$_var_155['hxinfo2'] = '暂无核销信息';
						} else {
							$_var_155['hxinfo'] = unserialize($_var_155['hxinfo']);
							if ($_var_155['hxinfo'][0] == 1) {
								$_var_155['hxinfo2'] = '系统核销';
							} else {
								$_var_175 = Db::table('ims_sudu8_page_store')->where('id', $_var_155['hxinfo'][1])->where('uniacid', $_var_154)->find();
								$_var_176 = Db::table('ims_sudu8_page_staff')->where('id', $_var_155['hxinfo'][2])->where('uniacid', $_var_154)->find();
								$_var_155['hxinfo2'] = '门店：' . $_var_175['title'] . '</br>员工：' . $_var_176['realname'];
							}
						}
						$_var_155['jsondata'] = unserialize($_var_155['jsondata']);
						$_var_155['creattime'] = date('Y-m-d H:i:s', $_var_155['creattime']);
						$_var_155['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_154)->where('openid', $_var_155['openid'])->find();
						$_var_155['counts'] = count($_var_155['jsondata']);
						$_var_177 = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $_var_154)->where('id', $_var_155['coupon'])->find();
						$_var_178 = Db::table('ims_sudu8_page_coupon')->where('uniacid', $_var_154)->where('id', $_var_177['cid'])->find();
						$_var_155['couponinfo'] = $_var_178;
						$_var_179 = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $_var_154)->where('shareid', $_var_155['pt_order'])->field('flag,join_count,pid')->find();
						$_var_180 = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $_var_154)->where('id', $_var_179['pid'])->field('pt_min')->find();
						$_var_181 = 0;
						foreach ($_var_155['jsondata'] as $_var_182 => &$_var_183) {
							$_var_181 += $_var_183['num'] * 1 * $_var_183['proinfo']['price'];
							if (!isset($_var_183['baseinfo2'])) {
								$_var_183['baseinfo2'] = Db::table('ims_sudu8_page_pt_pro')->where('id', $_var_183['baseinfo'])->find();
								if ($_var_183['baseinfo2']['thumb']) {
									$_var_183['baseinfo2']['thumb'] = remote($_var_154, $_var_183['baseinfo2']['thumb'], 1);
								} else {
									$_var_183['baseinfo2']['thumb'] = remote($_var_154, '/image/noimage_1.png', 1);
								}
								$_var_183['proinfo'] = Db::table('ims_sudu8_page_pt_pro_val')->where('id', $_var_183['proinfo'])->find();
								if ($_var_183['proinfo']) {
									$_var_183['proinfo']['ggz'] = $_var_183['proinfo']['comment'] . ':' . $_var_183['proinfo']['type1'];
								}
							}
						}
						$_var_155['allprice'] = $_var_181;
						$_var_184 = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid', $_var_154)->find();
						if (!$_var_184) {
							$_var_185 = 10000;
							$_var_186 = 1;
						} else {
							$_var_185 = $_var_184['score'];
							$_var_186 = $_var_184['money'];
						}
						$_var_155['jfmoney'] = $_var_155['jf'] * $_var_186 / $_var_185;
						if ($_var_155['address'] != 0) {
							$_var_155['address_get'] = Db::table('ims_sudu8_page_duo_products_address')->where('openid', $_var_155['openid'])->where('id', $_var_155['address'])->find();
						} else {
							$_var_155['address_get'] = $_var_155['m_address'];
						}
					}
				} else {
					if ($_var_169) {
						$_var_170 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_154)->where('pt_order', $_var_169)->where('jqr', 1)->order('creattime desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
						$_var_171 = $_var_170->all();
						$_var_172 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_154)->where('pt_order', $_var_169)->where('jqr', 1)->order('creattime desc')->count();
						foreach ($_var_171 as $_var_162 => &$_var_155) {
							$_var_173 = Db::table('ims_sudu8_page_pt_tx')->where('ptorder', $_var_155['order_id'])->where('uniacid', $_var_154)->find();
							$_var_155['pt_tx'] = $_var_173;
							$_var_174 = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $_var_154)->where('shareid', $_var_155['pt_order'])->find();
							$_var_155['join_count'] = $_var_174['join_count'];
							$_var_155['pt_min'] = $_var_174['pt_min'];
							$_var_155['pt_max'] = $_var_174['pt_max'];
							$_var_155['hxinfo2'] = '';
							if ($_var_155['hxinfo'] == '' || $_var_155['hxinfo'] == null) {
								$_var_155['hxinfo2'] = '暂无核销信息';
							} else {
								$_var_155['hxinfo'] = unserialize($_var_155['hxinfo']);
								if ($_var_155['hxinfo'][0] == 1) {
									$_var_155['hxinfo2'] = '系统核销';
								} else {
									$_var_175 = Db::table('ims_sudu8_page_store')->where('id', $_var_155['hxinfo'][1])->where('uniacid', $_var_154)->find();
									$_var_176 = Db::table('ims_sudu8_page_staff')->where('id', $_var_155['hxinfo'][2])->where('uniacid', $_var_154)->find();
									$_var_155['hxinfo2'] = '门店：' . $_var_175['title'] . '</br>员工：' . $_var_176['realname'];
								}
							}
							$_var_155['jsondata'] = unserialize($_var_155['jsondata']);
							$_var_155['creattime'] = date('Y-m-d H:i:s', $_var_155['creattime']);
							$_var_155['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_154)->where('openid', $_var_155['openid'])->find();
							$_var_155['counts'] = count($_var_155['jsondata']);
							$_var_177 = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $_var_154)->where('id', $_var_155['coupon'])->find();
							$_var_178 = Db::table('ims_sudu8_page_coupon')->where('uniacid', $_var_154)->where('id', $_var_177['cid'])->find();
							$_var_155['couponinfo'] = $_var_178;
							$_var_179 = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $_var_154)->where('shareid', $_var_155['pt_order'])->field('flag,join_count,pid')->find();
							$_var_180 = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $_var_154)->where('id', $_var_179['pid'])->field('pt_min')->find();
							$_var_181 = 0;
							foreach ($_var_155['jsondata'] as $_var_182 => &$_var_183) {
								$_var_181 += $_var_183['num'] * 1 * $_var_183['proinfo']['price'];
								if (!isset($_var_183['baseinfo2'])) {
									$_var_183['baseinfo2'] = Db::table('ims_sudu8_page_pt_pro')->where('id', $_var_183['baseinfo'])->find();
									if ($_var_183['baseinfo2']['thumb']) {
										$_var_183['baseinfo2']['thumb'] = remote($_var_154, $_var_183['baseinfo2']['thumb'], 1);
									} else {
										$_var_183['baseinfo2']['thumb'] = remote($_var_154, '/image/noimage_1.png', 1);
									}
									$_var_183['proinfo'] = Db::table('ims_sudu8_page_pt_pro_val')->where('id', $_var_183['proinfo'])->find();
									if ($_var_183['proinfo']) {
										$_var_183['proinfo']['ggz'] = $_var_183['proinfo']['comment'] . ':' . $_var_183['proinfo']['type1'];
									}
								}
							}
							$_var_155['allprice'] = $_var_181;
							$_var_184 = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid', $_var_154)->find();
							if (!$_var_184) {
								$_var_185 = 10000;
								$_var_186 = 1;
							} else {
								$_var_185 = $_var_184['score'];
								$_var_186 = $_var_184['money'];
							}
							$_var_155['jfmoney'] = $_var_155['jf'] * $_var_186 / $_var_185;
							if ($_var_155['address'] != 0) {
								$_var_155['address_get'] = Db::table('ims_sudu8_page_duo_products_address')->where('openid', $_var_155['openid'])->where('id', $_var_155['address'])->find();
							} else {
								$_var_155['address_get'] = $_var_155['m_address'];
							}
						}
					} else {
						$_var_170 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_154)->where('jqr', 1)->order('creattime desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
						$_var_171 = $_var_170->all();
						$_var_172 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_154)->where('jqr', 1)->order('creattime desc')->count();
						foreach ($_var_171 as $_var_162 => &$_var_155) {
							$_var_173 = Db::table('ims_sudu8_page_pt_tx')->where('ptorder', $_var_155['order_id'])->where('uniacid', $_var_154)->find();
							$_var_155['pt_tx'] = $_var_173;
							$_var_174 = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $_var_154)->where('shareid', $_var_155['pt_order'])->find();
							$_var_155['join_count'] = $_var_174['join_count'];
							$_var_155['pt_min'] = $_var_174['pt_min'];
							$_var_155['pt_max'] = $_var_174['pt_max'];
							$_var_155['hxinfo2'] = '';
							if ($_var_155['hxinfo'] == '' || $_var_155['hxinfo'] == null) {
								$_var_155['hxinfo2'] = '暂无核销信息';
							} else {
								$_var_155['hxinfo'] = unserialize($_var_155['hxinfo']);
								if ($_var_155['hxinfo'][0] == 1) {
									$_var_155['hxinfo2'] = '系统核销';
								} else {
									$_var_175 = Db::table('ims_sudu8_page_store')->where('id', $_var_155['hxinfo'][1])->where('uniacid', $_var_154)->find();
									$_var_176 = Db::table('ims_sudu8_page_staff')->where('id', $_var_155['hxinfo'][2])->where('uniacid', $_var_154)->find();
									$_var_155['hxinfo2'] = '门店：' . $_var_175['title'] . '</br>员工：' . $_var_176['realname'];
								}
							}
							$_var_155['jsondata'] = unserialize($_var_155['jsondata']);
							$_var_155['creattime'] = date('Y-m-d H:i:s', $_var_155['creattime']);
							$_var_155['hxtime'] = $_var_155['hxtime'] == 0 ? '未核销' : date('Y-m-d H:i:s', $_var_155['hxtime']);
							$_var_155['userinfo'] = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_154)->where('openid', $_var_155['openid'])->find();
							$_var_155['counts'] = count($_var_155['jsondata']);
							$_var_177 = Db::table('ims_sudu8_page_coupon_user')->where('uniacid', $_var_154)->where('id', $_var_155['coupon'])->find();
							$_var_178 = Db::table('ims_sudu8_page_coupon')->where('uniacid', $_var_154)->where('id', $_var_177['cid'])->find();
							$_var_155['couponinfo'] = $_var_178;
							$_var_179 = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $_var_154)->where('shareid', $_var_155['pt_order'])->field('flag,join_count,pid')->find();
							$_var_180 = Db::table('ims_sudu8_page_pt_pro')->where('uniacid', $_var_154)->where('id', $_var_179['pid'])->field('pt_min')->find();
							$_var_181 = 0;
							foreach ($_var_155['jsondata'] as $_var_182 => &$_var_183) {
								$_var_181 += $_var_183['num'] * 1 * $_var_183['proinfo']['price'];
								if (!isset($_var_183['baseinfo2'])) {
									$_var_183['baseinfo2'] = Db::table('ims_sudu8_page_pt_pro')->where('id', $_var_183['baseinfo'])->find();
									if ($_var_183['baseinfo2']['thumb']) {
										$_var_183['baseinfo2']['thumb'] = remote($_var_154, $_var_183['baseinfo2']['thumb'], 1);
									} else {
										$_var_183['baseinfo2']['thumb'] = remote($_var_154, '/image/noimage_1.png', 1);
									}
									$_var_183['proinfo'] = Db::table('ims_sudu8_page_pt_pro_val')->where('id', $_var_183['proinfo'])->find();
									if ($_var_183['proinfo']) {
										$_var_183['proinfo']['ggz'] = $_var_183['proinfo']['comment'] . ':' . $_var_183['proinfo']['type1'];
									}
								}
							}
							$_var_155['allprice'] = $_var_181;
							$_var_184 = Db::table('ims_sudu8_page_rechargeconf')->where('uniacid', $_var_154)->find();
							if (!$_var_184) {
								$_var_185 = 10000;
								$_var_186 = 1;
							} else {
								$_var_185 = $_var_184['score'];
								$_var_186 = $_var_184['money'];
							}
							$_var_155['jfmoney'] = $_var_155['jf'] * $_var_186 / $_var_185;
							if ($_var_155['address'] != 0) {
								$_var_155['address_get'] = Db::table('ims_sudu8_page_duo_products_address')->where('openid', $_var_155['openid'])->where('id', $_var_155['address'])->find();
							} else {
								$_var_155['address_get'] = $_var_155['m_address'];
							}
						}
					}
				}
				if ($_var_165) {
					$this->assign('order_id', $_var_165);
				} else {
					$_var_165 = '';
					$this->assign('order_id', $_var_165);
				}
				$this->assign('orders', $_var_171);
				$this->assign('olist', $_var_170);
				$this->assign('counts', $_var_172);
			} else {
				$_var_187 = Session::get('usergroup');
				if ($_var_187 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_187 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_187 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('order');
		} else {
			$this->redirect('Login/index');
		}
	}
	public function dopagegivemoney($_var_188, $_var_189, $_var_190)
	{
		$_var_191 = Db::table('ims_sudu8_page_fx_gz')->where('uniacid', $_var_188)->order('creattime desc')->find();
		$_var_192 = Db::table('ims_sudu8_page_fx_ls')->where('uniacid', $_var_188)->where('order_id', $_var_190)->find();
		Db::table('ims_sudu8_page_fx_ls')->where('order_id', $_var_190)->update(array('flag' => 2));
		$_var_193 = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['openid'])->find();
		$_var_194 = $_var_193['p_get_money'];
		$_var_195 = $_var_193['p_p_get_money'];
		$_var_196 = $_var_193['p_p_p_get_money'];
		if ($_var_191['fx_cj'] == 1) {
			if ($_var_192['parent_id']) {
				$_var_197 = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['parent_id'])->find();
				$_var_198 = array('fx_allmoney' => $_var_197['fx_allmoney'] + $_var_192['parent_id_get'], 'fx_money' => $_var_197['fx_money'] + $_var_192['parent_id_get']);
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['parent_id'])->update($_var_198);
				$_var_199 = $_var_194 * 1 + $_var_192['parent_id_get'] * 1;
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['openid'])->update(array('p_get_money' => $_var_199));
			}
		}
		if ($_var_191['fx_cj'] == 2) {
			if ($_var_192['parent_id']) {
				$_var_197 = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['parent_id'])->find();
				$_var_198 = array('fx_allmoney' => $_var_197['fx_allmoney'] + $_var_192['parent_id_get'], 'fx_money' => $_var_197['fx_money'] + $_var_192['parent_id_get']);
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['parent_id'])->update($_var_198);
				$_var_199 = $_var_194 * 1 + $_var_192['parent_id_get'] * 1;
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['openid'])->update(array('p_get_money' => $_var_199));
			}
			if ($_var_192['p_parent_id']) {
				$_var_197 = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['p_parent_id'])->find();
				$_var_198 = array('fx_allmoney' => $_var_197['fx_allmoney'] + $_var_192['p_parent_id_get'], 'fx_money' => $_var_197['fx_money'] + $_var_192['p_parent_id_get']);
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['p_parent_id'])->update($_var_198);
				$_var_200 = $_var_195 * 1 + $_var_192['p_parent_id_get'] * 1;
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['openid'])->update(array('p_p_get_money' => $_var_200));
			}
		}
		if ($_var_191['fx_cj'] == 3) {
			if ($_var_192['parent_id']) {
				$_var_197 = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['parent_id'])->find();
				$_var_198 = array('fx_allmoney' => $_var_197['fx_allmoney'] + $_var_192['parent_id_get'], 'fx_money' => $_var_197['fx_money'] + $_var_192['parent_id_get']);
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['parent_id'])->update($_var_198);
				$_var_199 = $_var_194 * 1 + $_var_192['parent_id_get'] * 1;
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['openid'])->update(array('p_get_money' => $_var_199));
			}
			if ($_var_192['p_parent_id']) {
				$_var_197 = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['p_parent_id'])->find();
				$_var_198 = array('fx_allmoney' => $_var_197['fx_allmoney'] + $_var_192['p_parent_id_get'], 'fx_money' => $_var_197['fx_money'] + $_var_192['p_parent_id_get']);
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['p_parent_id'])->update($_var_198);
				$_var_200 = $_var_195 * 1 + $_var_192['p_parent_id_get'] * 1;
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['openid'])->update(array('p_p_get_money' => $_var_200));
			}
			if ($_var_192['p_p_parent_id']) {
				$_var_197 = Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['p_p_parent_id'])->find();
				$_var_198 = array('fx_allmoney' => $_var_197['fx_allmoney'] + $_var_192['p_p_parent_id_get'], 'fx_money' => $_var_197['fx_money'] + $_var_192['p_p_parent_id_get']);
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['p_p_parent_id'])->update($_var_198);
				$_var_201 = $_var_196 * 1 + $_var_192['p_p_parent_id_get'] * 1;
				Db::table('ims_sudu8_page_user')->where('uniacid', $_var_188)->where('openid', $_var_192['openid'])->update(array('p_p_p_get_money' => $_var_201));
			}
		}
	}
	function doovershare($_var_202)
	{
		$_var_203 = time();
		$_var_204 = Db::table('ims_sudu8_page_pt_gz')->where('uniacid', $_var_202)->find();
		$_var_205 = Db::table('ims_sudu8_page_pt_share')->where('uniacid', $_var_202)->where('flag', 'in', [1, 2])->select();
		foreach ($_var_205 as $_var_206 => &$_var_207) {
			$_var_208 = $_var_207['pt_max'] * 1;
			$_var_209 = $_var_207['pt_min'] * 1;
			$_var_210 = $_var_207['creattime'];
			$_var_211 = $_var_210 * 1 + $_var_204['pt_time'] * 3600;
			if ($_var_211 >= $_var_203) {
				if ($_var_207['join_count'] >= $_var_209) {
					Db::table('ims_sudu8_page_pt_share')->where('id', $_var_207['id'])->update(array('flag' => 2));
				}
			}
			if ($_var_211 < $_var_203) {
				if ($_var_207['join_count'] < $_var_209) {
					if ($_var_204['is_pt'] == 2) {
						Db::table('ims_sudu8_page_pt_share')->where('id', $_var_207['id'])->update(array('flag' => 2, 'join_count' => $_var_209));
						$_var_212 = $_var_209 - $_var_207['join_count'];
						$_var_213 = range(1, 30);
						$_var_214 = array_rand($_var_213, $_var_212);
						for ($_var_215 = 0; $_var_215 < $_var_212; $_var_215++) {
							$_var_216 = Db::table('ims_sudu8_page_pt_robot')->where('id', $_var_214[$_var_215]);
							$_var_217 = array('uniacid' => $_var_202, 'openid' => $_var_216['openid'], 'pt_order' => $_var_207['shareid'], 'ck' => 2, 'jqr' => 2);
							Db::table('ims_sudu8_page_pt_order')->insert($_var_217);
						}
					} else {
						Db::table('ims_sudu8_page_pt_share')->where('id', $_var_207['id'])->update(array('flag' => 3));
						$_var_218 = Db::table('ims_sudu8_page_pt_order')->where('uniacid', $_var_202)->where('pt_order', $_var_207['shareid'])->where('jqr', 1)->select();
						foreach ($_var_218 as $_var_219 => &$_var_220) {
							Db::table('ims_sudu8_page_pt_order')->where('id', $_var_220['id'])->update(array('flag' => 5));
							$_var_221 = Db::table('ims_sudu8_page_user')->where('openid', $_var_220['openid'])->where('uniacid', $_var_202)->find();
							$_var_222 = array('uniacid' => $_var_202, 'openid' => $_var_220['openid'], 'ptorder' => $_var_220['order_id'], 'money' => $_var_220['price'], 'creattime' => time(), 'flag' => 1);
							Db::table('ims_sudu8_page_pt_tx')->insert($_var_222);
							$_var_223 = $_var_221['score'];
							$_var_224 = $_var_223 * 1 + $_var_220['jf'] * 1;
							if ($_var_220['jf'] > 0) {
								$_var_225 = array('uniacid' => $_var_202, 'orderid' => $_var_220['id'], 'uid' => $_var_221['id'], 'type' => 'add', 'score' => $_var_220['jf'] * 1, 'message' => '拼团退还积分', 'creattime' => time());
								Db::table('ims_sudu8_page_score')->insert($_var_225);
							}
							Db::table('ims_sudu8_page_user')->where('uniacid', $_var_202)->where('openid', $_var_221['openid'])->update(array('score' => $_var_224));
							if ($_var_220['coupon'] != 0) {
								$_var_226 = Db::table('ims_sudu8_page_coupon_user')->where('id', $_var_220['coupon'])->where('uniacid', $_var_202)->find();
								if ($_var_226['etime'] == 0) {
									Db::table('ims_sudu8_page_coupon_user')->where('id', $_var_220['coupon'])->update(array('utime' => 0, 'flag' => 0));
								} else {
									if ($_var_203 <= $_var_226['etime']) {
										Db::table('ims_sudu8_page_coupon_user')->where('id', $_var_220['coupon'])->update(array('utime' => 0, 'flag' => 0));
									}
								}
							}
						}
					}
				} else {
					Db::table('ims_sudu8_page_pt_share')->where('id', $_var_207['id'])->update(array('flag' => 4));
				}
			}
		}
	}
	function onepic_uploade($_var_227)
	{
		$_var_228 = request()->file($_var_227);
		if (isset($_var_228)) {
			$_var_229 = upload_img();
			$_var_230 = $_var_228->validate(['ext' => 'jpg,png,gif,jpeg'])->move($_var_229);
			if ($_var_230) {
				$_var_231 = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $_var_230->getFilename();
				return $_var_231;
			}
		}
	}
	public function imgupload()
	{
		$_var_232 = input('uniacid');
		$_var_233 = Db::table('ims_sudu8_page_base')->where('uniacid', $_var_232)->field('remote')->find()['remote'];
		if (!$_var_233) {
			$_var_233 = 1;
		}
		$_var_234 = 0;
		if ($_var_233 == 1) {
			$_var_235 = request()->file('');
			foreach ($_var_235 as $_var_236) {
				$_var_237 = $_var_236->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
				if ($_var_237) {
					$_var_238 = '/upimages/' . date('Ymd', time()) . '/' . $_var_237->getFilename();
					$_var_239 = array('url' => $_var_238);
					return json_encode($_var_239);
				} else {
					return $this->error($_var_236->getError());
				}
			}
		} else {
			if ($_var_233 == 2) {
				$_var_240 = Db::table('ims_sudu8_page_remote')->where('type', 2)->where('uniacid', $_var_232)->find();
				$_var_236 = $_FILES['uploadfile']['tmp_name'];
				$_var_241 = getimagesize($_var_236);
				if ($_var_241) {
				}
				$_var_242 = $_FILES['uploadfile']['name'];
				$_var_243 = pathinfo($_var_242);
				$_var_244 = $_var_243['extension'];
				$_var_245 = 'upimages/' . md5(uniqid(microtime(true), true)) . '.' . $_var_244;
				$_var_246 = $_var_240['ak'];
				$_var_247 = $_var_240['sk'];
				$_var_248 = new Auth($_var_246, $_var_247);
				$_var_249 = $_var_240['bucket'];
				$_var_250 = $_var_240['domain'];
				$_var_251 = $_var_248->uploadToken($_var_249);
				$_var_252 = new UploadManager();
				list($_var_253, $_var_254) = $_var_252->putFile($_var_251, $_var_245, $_var_236);
				if ($_var_254 !== null) {
					echo ['err' => 1, 'msg' => $_var_254, 'data' => ''];
				} else {
					$_var_239 = array('url' => $_var_240['domain'] . '/' . $_var_253['key']);
					return json_encode($_var_239);
				}
			}
		}
	}
	public function imgupload_duo()
	{
		$_var_255['randid'] = input('randid');
		$_var_256 = request()->file('');
		foreach ($_var_256 as $_var_257) {
			$_var_258 = $_var_257->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
			if ($_var_258) {
				$_var_255['url'] = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $_var_258->getFilename();
				$_var_255['dateline'] = time();
				$_var_259 = Db::table('products_url')->insert($_var_255);
			} else {
				return $this->error($_var_257->getError());
			}
		}
	}
	public function getimg()
	{
		$_var_260 = $_POST['id'];
		$_var_261 = Db::table('products_url')->where('randid', $_var_260)->select();
		if ($_var_261) {
			return $_var_261;
		}
	}
	public function del_img()
	{
		$_var_262 = input('id');
		$_var_263 = Db::table('products_url')->where('id', $_var_262)->delete();
		if ($_var_263) {
			return 1;
		} else {
			$this->error('删除失败！');
		}
	}
}