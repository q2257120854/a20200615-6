<?php

//decode by http://www.yunlu99.com/
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
header('Content-type: text/html; charset=utf-8');
class Products extends Base
{
	public function index()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_0 = input('appletid');
				$_var_1 = Db::table('applet')->where('id', $_var_0)->find();
				if (!$_var_1) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_1);
				$_var_2 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_0)->where('type', 'showPro')->where('is_more', 1)->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
				if ($_var_2->toArray()) {
					$_var_3 = $_var_2->toArray()['data'];
				}
				foreach ($_var_3 as $_var_4 => &$_var_5) {
					if ($_var_5['thumb']) {
						$_var_5['thumb'] = remote($_var_0, $_var_5['thumb'], 1);
					} else {
						$_var_6 = '/image/noimage.jpg';
						$_var_5['thumb'] = remote($_var_0, $_var_6, 1);
					}
				}
				$_var_7 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_0)->where('type', 'showPro')->where('is_more', 1)->order('num desc')->count();
				$this->assign('list', $_var_3);
				$this->assign('news', $_var_2);
				$this->assign('counts', $_var_7);
			} else {
				$_var_8 = Session::get('usergroup');
				if ($_var_8 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_8 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_8 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('index');
		} else {
			$this->redirect('Login/index');
		}
	}
	public function pro()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_9 = input('appletid');
				$_var_10 = input('cid') ? input('cid') : 0;
				$_var_11 = input('key');
				$_var_12 = Db::table('applet')->where('id', $_var_9)->find();
				if (!$_var_12) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_12);
				$_var_13 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_9)->where('cid', 0)->order('num desc')->select();
				$_var_14 = array();
				foreach ($_var_13 as $_var_15 => $_var_16) {
					$_var_17 = intval($_var_16['id']);
					$_var_18 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_9)->where('id', $_var_17)->order('num desc')->select();
					$_var_19 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_9)->where('cid', $_var_17)->order('num desc')->select();
					$_var_20 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_9)->where('cid', $_var_17)->order('num desc')->count();
					$_var_18['data'] = $_var_19;
					$_var_18['zcount'] = $_var_20;
					array_push($_var_14, $_var_18);
				}
				$this->assign('cate', $_var_14);
				$_var_21 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_9)->where('cid', $_var_10)->select();
				$_var_22 = array();
				for ($_var_23 = 0; $_var_23 < count($_var_21); $_var_23++) {
					array_push($_var_22, $_var_21[$_var_23]['id']);
				}
				array_push($_var_22, $_var_10);
				if ($_var_10 == 0 && $_var_11 == false) {
					$_var_24 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_9)->where('type', 'showPro')->where('is_more', 0)->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
					$_var_25 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_9)->where('type', 'showPro')->where('is_more', 0)->order('num desc')->count();
				} else {
					if ($_var_10 > 0 && $_var_11 == false) {
						$_var_24 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_9)->where('type', 'showPro')->where('cid', 'in', $_var_22)->where('is_more', 0)->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
						$_var_25 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_9)->where('type', 'showPro')->where('cid', 'in', $_var_22)->where('is_more', 0)->order('num desc')->count();
					} else {
						if ($_var_10 > 0 && $_var_11 != false) {
							$_var_24 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_9)->where('type', 'showPro')->where('cid', 'in', $_var_22)->where('title', 'like', '%' . $_var_11 . '%')->where('is_more', 0)->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
							$_var_25 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_9)->where('type', 'showPro')->where('cid', 'in', $_var_22)->where('title', 'like', '%' . $_var_11 . '%')->where('is_more', 0)->order('num desc')->count();
						} else {
							if ($_var_10 == 0 && $_var_11 != false) {
								$_var_24 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_9)->where('type', 'showPro')->where('title', 'like', '%' . $_var_11 . '%')->where('is_more', 0)->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
								$_var_25 = Db::table('ims_sudu8_page_products')->where('uniacid', $_var_9)->where('type', 'showPro')->where('title', 'like', '%' . $_var_11 . '%')->where('is_more', 0)->order('num desc')->count();
							}
						}
					}
				}
				if ($_var_24->toArray()) {
					$_var_26 = $_var_24->toArray()['data'];
				}
				foreach ($_var_26 as $_var_15 => &$_var_27) {
					if ($_var_27['thumb']) {
						$_var_27['thumb'] = remote($_var_9, $_var_27['thumb'], 1);
					} else {
						$_var_28 = '/image/noimage.jpg';
						$_var_27['thumb'] = remote($_var_9, $_var_28, 1);
					}
				}
				$this->assign('list', $_var_26);
				$this->assign('news', $_var_24);
				$this->assign('counts', $_var_25);
			} else {
				$_var_29 = Session::get('usergroup');
				if ($_var_29 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_29 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_29 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('pro');
		} else {
			$this->redirect('Login/index');
		}
	}
	public function add()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_30 = input('appletid');
				$_var_31 = Db::table('applet')->where('id', $_var_30)->find();
				if (!$_var_31) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_31);
				$_var_32 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_30)->where('cid', 0)->order('num desc')->select();
				$_var_33 = array();
				foreach ($_var_32 as $_var_34 => $_var_35) {
					$_var_36 = intval($_var_35['id']);
					$_var_37 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_30)->where('id', $_var_36)->order('num desc')->select();
					$_var_38 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_30)->where('cid', $_var_36)->order('num desc')->select();
					$_var_39 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_30)->where('cid', $_var_36)->order('num desc')->count();
					$_var_37['data'] = $_var_38;
					$_var_37['zcount'] = $_var_39;
					array_push($_var_33, $_var_37);
				}
				$this->assign('cate', $_var_33);
				$_var_40 = Db::table('ims_sudu8_page_store')->where('uniacid', $_var_30)->select();
				$this->assign('stores', $_var_40);
				$_var_41 = Db::table('ims_sudu8_page_multicate')->where('uniacid', $_var_30)->where('statue', 1)->where('type', 'showPro')->select();
				$_var_42 = array();
				$_var_43 = '';
				$_var_44 = input('newsid');
				$_var_45 = array();
				if ($_var_44) {
					$_var_46 = Db::table('ims_sudu8_page_products')->where('id', $_var_44)->where('type', 'showPro')->find();
					if ($_var_46['uniacid'] == $_var_30) {
						if ($_var_46['thumb']) {
							$_var_46['thumb'] = remote($_var_30, $_var_46['thumb'], 1);
						}
						if ($_var_46['shareimg']) {
							$_var_46['shareimg'] = remote($_var_30, $_var_46['shareimg'], 1);
						}
						$_var_46['text'] = unserialize($_var_46['text']);
						$_var_43 = Db::table('products_url')->where('randid', $_var_46['onlyid'])->select();
						foreach ($_var_43 as $_var_34 => &$_var_47) {
							$_var_47['url'] = remote($_var_30, $_var_47['url'], 1);
						}
						$_var_45 = $_var_46;
						$_var_48 = Db::table('ims_sudu8_page_multicates')->where('id', 'in', $_var_45['top_catas'])->select();
						foreach ($_var_48 as $_var_49 => $_var_50) {
							$_var_48[$_var_49]['sons'] = Db::table('ims_sudu8_page_multicates')->where('pid', $_var_50['id'])->select();
						}
					} else {
						$_var_51 = Session::get('usergroup');
						if ($_var_51 == 1) {
							$this->error('找不到该内容，或者该内容不属于本小程序');
						}
						if ($_var_51 == 2) {
							$this->error('找不到该内容，或者该内容不属于本小程序');
						}
					}
				} else {
					$_var_44 = 0;
					$_var_52 = '';
					$_var_53 = '';
					$_var_48 = '';
					foreach ($_var_41 as $_var_49 => $_var_50) {
						$_var_41[$_var_49]['flag'] = 0;
					}
				}
				$_var_54 = Db::table('ims_sudu8_page_formlist')->where('uniacid', $_var_30)->select();
				$this->assign('cates', $_var_41);
				$this->assign('forms', $_var_54);
				$this->assign('allimg', $_var_43);
				$this->assign('sons_keys', $_var_48);
				$this->assign('imgcount', count($_var_43));
				$this->assign('newsid', $_var_44);
				$this->assign('newsinfo', $_var_45);
			} else {
				$_var_51 = Session::get('usergroup');
				if ($_var_51 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_51 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_51 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('add');
		} else {
			$this->redirect('Login/index');
		}
	}
	public function save()
	{
		$_var_55 = array();
		$_var_55['uniacid'] = input('appletid');
		$_var_56 = $_POST['num'];
		if ($_var_56) {
			$_var_55['num'] = $_var_56;
		}
		$_var_57 = $_POST['cid'];
		if ($_var_57) {
			$_var_55['cid'] = $_var_57;
			$_var_58 = Db::table('ims_sudu8_page_cate')->where('id', $_var_57)->find();
			$_var_55['type'] = $_var_58['type'];
			$_var_55['lanmu'] = $_var_58['name'];
		}
		$_var_59 = Db::table('ims_sudu8_page_cate')->where('id', $_var_57)->where('uniacid', input('appletid'))->field('cid')->find();
		if ($_var_59['cid'] == 0) {
			$_var_55['pcid'] = $_var_57;
		} else {
			$_var_55['pcid'] = $_var_59['cid'];
		}
		$_var_60 = input('type_x');
		if ($_var_60) {
			$_var_55['type_x'] = (int) $_var_60;
		} else {
			$_var_55['type_x'] = 0;
		}
		$_var_61 = input('type_y');
		if ($_var_61) {
			$_var_55['type_y'] = (int) $_var_61;
		} else {
			$_var_55['type_y'] = 0;
		}
		$_var_62 = input('type_i');
		if ($_var_62) {
			$_var_55['type_i'] = (int) $_var_62;
		} else {
			$_var_55['type_i'] = 0;
		}
		$_var_63 = input('pro_flag');
		if ($_var_63) {
			$_var_55['pro_flag'] = $_var_63;
		} else {
			$_var_55['pro_flag'] = 0;
		}
		$_var_64 = input('labels');
		if ($_var_64) {
			$_var_55['labels'] = $_var_64;
		}
		$_var_65 = $_POST['hits'];
		if ($_var_65) {
			$_var_55['hits'] = $_var_65;
		}
		$_var_66 = $_POST['title'];
		if ($_var_66) {
			$_var_55['title'] = $_var_66;
		}
		$_var_67 = input('sale_num');
		if ($_var_67) {
			$_var_55['sale_num'] = $_var_67;
		}
		$_var_68 = input('price');
		if ($_var_68 !== false) {
			$_var_55['price'] = $_var_68;
		}
		$_var_69 = input('market_price');
		if ($_var_69 !== false) {
			$_var_55['market_price'] = $_var_69;
		}
		$_var_70 = input('pro_kc');
		if ($_var_70) {
			$_var_55['pro_kc'] = $_var_70;
		}
		$_var_71 = input('pro_xz');
		if (!isset($_var_71)) {
		} else {
			$_var_55['pro_xz'] = $_var_71;
		}
		$_var_72 = input('sale_time');
		if ($_var_72) {
			$_var_55['sale_time'] = strtotime($_var_72);
		}
		$_var_73 = input('sale_end_time');
		if ($_var_73) {
			$_var_55['sale_end_time'] = strtotime($_var_73);
		}
		$_var_74 = input('pro_flag_tel');
		if ($_var_74) {
			$_var_55['pro_flag_tel'] = $_var_74;
		} else {
			$_var_55['pro_flag_tel'] = 0;
		}
		$_var_75 = input('pro_flag_add');
		if ($_var_75) {
			$_var_55['pro_flag_add'] = $_var_75;
		} else {
			$_var_55['pro_flag_add'] = 0;
		}
		$_var_76 = input('stores');
		if ($_var_76) {
			$_var_55['stores'] = $_var_76;
		} else {
			$_var_55['stores'] = null;
		}
		$_var_77 = input('pro_flag_ding');
		if ($_var_77) {
			$_var_55['pro_flag_ding'] = $_var_77;
		} else {
			$_var_55['pro_flag_ding'] = 0;
		}
		$_var_78 = $_POST['comment'];
		$_var_55['comment'] = $_var_78;
		$_var_79 = input('share_gz');
		if ($_var_79) {
			$_var_55['share_gz'] = $_var_79;
		} else {
			$_var_55['share_gz'] = 1;
		}
		$_var_80 = $_POST['share_type'];
		$_var_55['share_type'] = $_var_80;
		$_var_81 = $_POST['share_score'];
		$_var_55['share_score'] = $_var_81;
		$_var_82 = $_POST['share_num'];
		$_var_55['share_num'] = $_var_82;
		$_var_83 = $_POST['onlyid'];
		if ($_var_83) {
			$_var_84 = input('imgsrcs/a');
			if ($_var_84) {
				$_var_85 = array();
				foreach ($_var_84 as $_var_86 => $_var_87) {
					$_var_85['randid'] = $_var_83;
					$_var_85['appletid'] = $_var_55['uniacid'];
					$_var_85['url'] = remote($_var_55['uniacid'], $_var_87, 2);
					$_var_85['dateline'] = time();
					$_var_88 = Db::table('products_url')->insert($_var_85);
				}
			} else {
				$_var_88 = 1;
			}
			$_var_55['onlyid'] = $_var_83;
		}
		if (!$_var_83) {
		} else {
			$_var_89 = Db::table('products_url')->where('randid', $_var_83)->select();
			$_var_90 = array();
			if ($_var_89) {
				foreach ($_var_89 as $_var_91) {
					$_var_90[] = $_var_91['url'];
				}
				$_var_55['text'] = serialize($_var_90);
			} else {
				$_var_55['text'] = '';
			}
		}
		$_var_92 = input('commonuploadpic1');
		if ($_var_92) {
			$_var_55['thumb'] = remote($_var_55['uniacid'], $_var_92, 2);
		}
		$_var_93 = input('commonuploadpic2');
		if ($_var_93) {
			$_var_55['shareimg'] = remote($_var_55['uniacid'], $_var_93, 2);
		}
		$_var_94 = $_POST['desc'];
		if ($_var_94) {
			$_var_55['desc'] = $_var_94;
		}
		$_var_95 = input('formset');
		if ($_var_95) {
			$_var_55['formset'] = $_var_95;
		} else {
			$_var_55['formset'] = 0;
		}
		$_var_96 = $_POST['product_txt'];
		if ($_var_96) {
			$_var_55['product_txt'] = $_var_96;
		}
		$_var_97 = input('con2');
		if ($_var_97) {
			$_var_55['con2'] = $_var_97;
		}
		$_var_98 = input('con3');
		if ($_var_98) {
			$_var_55['con3'] = $_var_98;
		}
		$_var_55['buy_type'] = input('buy_type');
		if ($_var_55['buy_type'] == null) {
			$_var_55['buy_type'] = '购买';
		}
		$_var_99 = input('newsid');
		$_var_100 = Db::table('ims_sudu8_page_multicate')->where('id', input('mulitcataid'))->find();
		$_var_55['sons_catas'] = input('sons/a') ? implode(',', input('sons/a')) : '';
		$_var_55['top_catas'] = $_var_100['top_catas'] ? implode(',', unserialize($_var_100['top_catas'])) : '';
		$_var_55['mulitcataid'] = input('mulitcataid');
		$_var_55['get_share_gz'] = input('get_share_gz');
		$_var_55['score'] = input('score');
		$_var_55['get_share_score'] = input('get_share_score');
		$_var_55['get_share_num'] = input('get_share_num');
		$_var_55['ctime'] = time();
		$_var_101 = input('muiltcate');
		if ($_var_101 != '0') {
			$_var_55['multi'] = 1;
		} else {
			$_var_55['multi'] = 0;
		}
		$_var_102 = array();
		if ($_var_99) {
			$_var_103 = Db::table('ims_sudu8_page_products')->where('id', $_var_99)->update($_var_55);
		} else {
			$_var_103 = Db::table('ims_sudu8_page_products')->insert($_var_55);
		}
		if ($_var_103) {
			$this->success('基础信息更新成功！', Url('Products/pro') . '?appletid=' . $_var_55['uniacid']);
		} else {
			$this->error('基础信息更新失败，没有修改项！');
			exit;
		}
	}
	public function add_more()
	{
		if (check_login()) {
			if (powerget()) {
				$_var_104 = input('appletid');
				$_var_105 = Db::table('applet')->where('id', $_var_104)->find();
				if (!$_var_105) {
					$this->error('找不到对应的小程序！');
				}
				$this->assign('applet', $_var_105);
				$_var_106 = Db::table('ims_sudu8_page_store')->where('uniacid', $_var_104)->select();
				$this->assign('stores', $_var_106);
				$_var_107 = Db::table('ims_sudu8_page_formlist')->where('uniacid', $_var_104)->select();
				$this->assign('forms', $_var_107);
				$_var_108 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_104)->where('cid', 0)->order('num desc')->select();
				$_var_109 = array();
				foreach ($_var_108 as $_var_110 => $_var_111) {
					$_var_112 = intval($_var_111['id']);
					$_var_113 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_104)->where('id', $_var_112)->order('num desc')->select();
					$_var_114 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_104)->where('cid', $_var_112)->order('num desc')->select();
					$_var_115 = Db::table('ims_sudu8_page_cate')->where('uniacid', $_var_104)->where('cid', $_var_112)->order('num desc')->count();
					$_var_113['data'] = $_var_114;
					$_var_113['zcount'] = $_var_115;
					array_push($_var_109, $_var_113);
				}
				$_var_116 = Db::table('ims_sudu8_page_multicate')->where('uniacid', $_var_104)->where('statue', 1)->where('type', 'showPro')->select();
				$_var_117 = '';
				$_var_118 = input('newsid');
				$_var_119 = array();
				if ($_var_118) {
					$_var_120 = Db::table('ims_sudu8_page_products')->where('id', $_var_118)->where('type', 'showPro')->find();
					if ($_var_120['uniacid'] == $_var_104) {
						$_var_120['thumb'] = remote($_var_104, $_var_120['thumb'], 1);
						$_var_120['shareimg'] = remote($_var_104, $_var_120['shareimg'], 1);
						$_var_120['text'] = unserialize($_var_120['text']);
						$_var_117 = Db::table('products_url')->where('randid', $_var_120['onlyid'])->select();
						foreach ($_var_117 as $_var_110 => &$_var_121) {
							$_var_121['url'] = remote($_var_104, $_var_121['url'], 1);
						}
						$_var_122 = Db::table('ims_sudu8_page_multipro')->where('proid', $_var_118)->select();
						if ($_var_116) {
							foreach ($_var_116 as $_var_123 => $_var_124) {
								foreach ($_var_122 as $_var_125 => $_var_126) {
									if ($_var_124['id'] == $_var_126['multi_id']) {
										$_var_116[$_var_123]['flag'] = 1;
									}
								}
								if (!isset($_var_116[$_var_123]['flag'])) {
									$_var_116[$_var_123]['flag'] = 0;
								}
							}
						} else {
							$_var_116 = '';
						}
						foreach ($_var_122 as $_var_125 => $_var_126) {
							$_var_127 = Db::table('ims_sudu8_page_cate')->where('id', $_var_126['cid'])->find();
							$_var_128[$_var_125]['id'] = $_var_126['cid'];
							$_var_128[$_var_125]['name'] = $_var_127['name'];
						}
						$_var_129 = array();
						$_var_130 = Db::table('ims_sudu8_page_multipro')->where('proid', $_var_118)->find();
						if ($_var_130) {
							$_var_131 = Db::table('ims_sudu8_page_multicate')->where('statue', 1)->where('id', $_var_130['multi_id'])->find();
							if ($_var_131) {
								foreach (unserialize($_var_131['cid']) as $_var_125 => $_var_126) {
									$_var_132 = Db::table('ims_sudu8_page_cate')->whereOr('id', $_var_126)->whereOr('cid', $_var_126)->field('id,name')->select();
									foreach ($_var_132 as $_var_123 => $_var_124) {
										foreach ($_var_128 as $_var_133 => $_var_134) {
											if ($_var_124['id'] == $_var_134['id']) {
												$_var_132[$_var_123]['flag'] = 1;
											}
										}
										if (!isset($_var_132[$_var_123]['flag'])) {
											$_var_132[$_var_123]['flag'] = 0;
										}
									}
									array_push($_var_129, $_var_132);
								}
							}
						}
						$_var_120['more_type'] = unserialize($_var_120['more_type']);
						$_var_120['labels'] = unserialize($_var_120['labels']);
						$_var_119 = $_var_120;
					} else {
						$_var_135 = Session::get('usergroup');
						if ($_var_135 == 1) {
							$this->error('找不到该内容，或者该内容不属于本小程序');
						}
						if ($_var_135 == 2) {
							$this->error('找不到该内容，或者该内容不属于本小程序');
						}
					}
				} else {
					$_var_118 = 0;
					$_var_130 = '';
					$_var_129 = '';
					foreach ($_var_116 as $_var_123 => $_var_124) {
						$_var_116[$_var_123]['flag'] = 0;
					}
				}
				$this->assign('allimg', $_var_117);
				$this->assign('imgcount', count($_var_117));
				$this->assign('cate', $_var_109);
				$this->assign('multipro', $_var_129);
				$this->assign('cates', $_var_116);
				$this->assign('forms', $_var_107);
				$this->assign('newsid', $_var_118);
				$this->assign('newsinfo', $_var_119);
			} else {
				$_var_135 = Session::get('usergroup');
				if ($_var_135 == 1) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
				}
				if ($_var_135 == 2) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
				if ($_var_135 == 3) {
					$this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
				}
			}
			return $this->fetch('add_more');
		} else {
			$this->redirect('Login/index');
		}
	}
	public function save_more()
	{
		$_var_136 = input('appletid');
		$_var_137['uniacid'] = $_var_136;
		$_var_138 = input('newsid');
		$_var_139 = input('duogg');
		$_var_140 = explode(',', substr($_var_139, 0, strlen($_var_139) - 1));
		$_var_141 = serialize($_var_140);
		$_var_142 = array_chunk($_var_140, 4);
		$_var_143 = serialize($_var_142);
		$_var_144 = array();
		foreach ($_var_142 as &$_var_145) {
			$_var_146 = array('allnum' => $_var_145[2], 'salenum' => 0, 'shennum' => $_var_145[2]);
			$_var_144[] = $_var_146;
		}
		$_var_147 = serialize($_var_144);
		$_var_148 = input('labels');
		$_var_149 = explode(',', substr($_var_148, 0, strlen($_var_148) - 1));
		$_var_150 = array();
		foreach ($_var_149 as $_var_145) {
			$_var_151 = explode(':', $_var_145);
			$_var_152 = $_var_151[0];
			$_var_153 = $_var_151[1];
			$_var_154 = array("{$_var_152}" => $_var_153);
			$_var_150 = array_merge($_var_150, $_var_154);
		}
		$_var_155 = serialize($_var_150);
		$_var_156 = input('cid');
		if ($_var_156) {
			$_var_137['cid'] = $_var_156;
			$_var_157 = Db::table('ims_sudu8_page_cate')->where('id', $_var_156)->find();
			$_var_157 = $_var_157['name'];
		}
		$_var_156 = intval(input('cid'));
		$_var_158 = Db::table('ims_sudu8_page_cate')->where('id', $_var_156)->where('uniacid', $_var_136)->field('cid')->find();
		if ($_var_158['cid'] == 0) {
			$_var_158 = $_var_156;
		} else {
			$_var_158 = intval($_var_158['cid']);
		}
		$_var_159 = input('pro_flag_add');
		if ($_var_159) {
			$_var_159 = $_var_159;
		} else {
			$_var_159 = 0;
		}
		$_var_160 = input('is_score');
		if ($_var_160) {
			$_var_160 = $_var_160;
		} else {
			$_var_160 = 0;
		}
		$_var_161 = input('formset');
		if ($_var_161) {
			$_var_161 = $_var_161;
		} else {
			$_var_161 = 0;
		}
		$_var_162 = input('score_num');
		if ($_var_162) {
			$_var_162 = $_var_162;
		} else {
			$_var_162 = 0;
		}
		$_var_137 = array('uniacid' => $_var_136, 'cid' => intval(input('cid')), 'pcid' => $_var_158, 'num' => intval(input('num')), 'type' => 'showPro', 'type_x' => intval(input('type_x')), 'type_y' => intval(input('type_y')), 'type_i' => intval(input('type_i')), 'hits' => intval(input('hits')), 'sale_num' => intval(input('sale_num')), 'title' => addslashes(input('title')), 'desc' => input('desc'), 'ctime' => time(), 'price' => input('price'), 'market_price' => input('market_price'), 'score' => input('score'), 'pro_flag' => 0, 'pro_flag_tel' => 0, 'pro_flag_data' => 0, 'pro_flag_data_name' => 0, 'pro_flag_time' => 0, 'pro_flag_ding' => input('pro_flag_ding'), 'product_txt' => htmlspecialchars_decode(input('product_txt'), ENT_QUOTES), 'labels' => $_var_155, 'is_more' => 1, 'more_type' => $_var_141, 'more_type_x' => $_var_143, 'more_type_num' => $_var_147, 'flag' => input('flag'), 'buy_type' => input('buy_type'), 'lanmu' => $_var_157, 'pro_flag_add' => $_var_159, 'is_score' => $_var_160, 'score_num' => $_var_162, 'formset' => $_var_161);
		$_var_163 = input('stores');
		if ($_var_163) {
			$_var_137['stores'] = $_var_163;
		} else {
			$_var_137['stores'] = null;
		}
		$_var_137['get_share_gz'] = input('get_share_gz');
		$_var_137['get_share_score'] = input('get_share_score');
		$_var_137['get_share_num'] = input('get_share_num');
		$_var_164 = input('onlyid');
		if ($_var_164) {
			$_var_165 = input('imgsrcs/a');
			if ($_var_165) {
				$_var_166 = array();
				foreach ($_var_165 as $_var_167 => $_var_154) {
					$_var_166['randid'] = $_var_164;
					$_var_166['appletid'] = $_var_137['uniacid'];
					$_var_166['url'] = remote($_var_137['uniacid'], $_var_154, 2);
					$_var_166['dateline'] = time();
					$_var_168 = Db::table('products_url')->insert($_var_166);
				}
			} else {
				$_var_168 = 1;
			}
			$_var_137['onlyid'] = $_var_164;
		}
		$_var_169 = Db::table('products_url')->where('randid', $_var_164)->select();
		$_var_170 = array();
		if ($_var_169) {
			foreach ($_var_169 as $_var_145) {
				$_var_170[] = $_var_145['url'];
			}
			$_var_137['text'] = serialize($_var_170);
		} else {
			$_var_137['text'] = '';
		}
		$_var_171 = input('commonuploadpic1');
		if ($_var_171) {
			$_var_137['thumb'] = remote($_var_137['uniacid'], $_var_171, 2);
		}
		$_var_172 = input('commonuploadpic2');
		if ($_var_172) {
			$_var_137['shareimg'] = remote($_var_137['uniacid'], $_var_172, 2);
		}
		$_var_173 = input('muiltcate');
		if ($_var_173 != '0') {
			$_var_137['multi'] = 1;
		} else {
			$_var_137['multi'] = 0;
		}
		if (!$_var_138) {
			$_var_174 = Db::table('ims_sudu8_page_products')->insert($_var_137);
		} else {
			$_var_174 = Db::table('ims_sudu8_page_products')->where('id', $_var_138)->where('uniacid', $_var_136)->update($_var_137);
		}
		if ($_var_174) {
			if ($_var_173 != '0') {
				if ($_var_138) {
					$_var_175['proid'] = $_var_138;
					$_var_176 = Db::table('ims_sudu8_page_multipro')->where('proid', $_var_138)->delete();
				} else {
					$_var_176 = Db::table('ims_sudu8_page_products')->order('id desc')->field('id')->find();
					$_var_175['proid'] = $_var_176['id'];
				}
				$_var_175['multi_id'] = intval($_var_173);
				$_var_177 = $_POST['catearr'];
				foreach ($_var_177 as $_var_152 => $_var_178) {
					if ($_var_178 != '0') {
						$_var_175['cid'] = $_var_178;
						Db::table('ims_sudu8_page_multipro')->insert($_var_175);
					}
				}
				$_var_175['multi_id'] = $_var_173;
			}
			$this->success('商品信息更新成功！', Url('Products/index') . '?appletid=' . $_var_136);
		} else {
			$this->error('商品信息更新失败，没有修改项！');
			exit;
		}
	}
	public function del()
	{
		$_var_179['id'] = input('newsid');
		$_var_180 = Db::table('ims_sudu8_page_products')->where($_var_179)->delete();
		if ($_var_180) {
			$this->success('删除成功');
		} else {
			$this->success('删除失败');
		}
	}
	function onepic_uploade($_var_181)
	{
		$_var_182 = request()->file($_var_181);
		if (isset($_var_182)) {
			$_var_183 = upload_img();
			$_var_184 = $_var_182->validate(['ext' => 'jpg,png,gif,jpeg'])->move($_var_183);
			if ($_var_184) {
				$_var_185 = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $_var_184->getFilename();
				return $_var_185;
			}
		}
	}
	public function imgupload()
	{
		$_var_186 = request()->file('');
		foreach ($_var_186 as $_var_187) {
			$_var_188 = $_var_187->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
			if ($_var_188) {
				$_var_189 = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $_var_188->getFilename();
				$_var_190 = array('url' => $_var_189);
				return json_encode($_var_190);
			} else {
				return $this->error($_var_187->getError());
			}
		}
	}
	public function imgupload_duo()
	{
		$_var_191['randid'] = input('randid');
		$_var_192 = request()->file('');
		foreach ($_var_192 as $_var_193) {
			$_var_194 = $_var_193->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
			if ($_var_194) {
				$_var_191['url'] = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $_var_194->getFilename();
				$_var_191['dateline'] = time();
				$_var_195 = Db::table('products_url')->insert($_var_191);
			} else {
				return $this->error($_var_193->getError());
			}
		}
	}
	public function getimg()
	{
		$_var_196 = $_POST['id'];
		$_var_197 = Db::table('products_url')->where('randid', $_var_196)->select();
		if ($_var_197) {
			return $_var_197;
		}
	}
}