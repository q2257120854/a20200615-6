<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class News extends Base
{
    public function index()
    {
        if (check_login()) {
            if (powerget()) {
                $xzv_0 = input('appletid');
                $xzv_36 = input('cid') ? input('cid') : 0;
                $xzv_88 = input('key');
                $xzv_97 = Db::table('applet')->where('id', $xzv_0)->find();
                if (!$xzv_97) {
                    $this->error('找不到对应的小程序！');
                }
                $xzv_98 = Db::table('ims_sudu8_page_cate')->where('uniacid', $xzv_0)->where('type', 'showArt')->where('cid', 0)->order('num desc')->select();
                foreach ($xzv_98 as $xzv_99 => &$xzv_87) {
                    $xzv_61 = Db::table('ims_sudu8_page_cate')->where('uniacid', $xzv_0)->where('cid', $xzv_87['id'])->order('num desc')->select();
                    $xzv_87['data'] = $xzv_61;
                }
                $this->assign('cate', $xzv_98);
                $this->assign('applet', $xzv_97);
                $xzv_55 = Db::table('ims_sudu8_page_cate')->where('uniacid', $xzv_0)->where('cid', $xzv_36)->select();
                $xzv_23 = array();
                for ($xzv_25 = 0; $xzv_25 < count($xzv_55); $xzv_25++) {
                    array_push($xzv_23, $xzv_55[$xzv_25]['id']);
                }
                array_push($xzv_23, $xzv_36);
                if ($xzv_36 == 0 && $xzv_88 == false) {
                    $xzv_141 = Db::table('ims_sudu8_page_products')->where('uniacid', $xzv_0)->where('type', 'showArt')->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
                    $xzv_53 = Db::table('ims_sudu8_page_products')->where('uniacid', $xzv_0)->where('type', 'showArt')->order('num desc')->count();
                    $xzv_93 = $xzv_141->toArray();
                    foreach ($xzv_93['data'] as &$xzv_97) {
                        $xzv_29 = Db::table('ims_sudu8_page_cate')->where('id', $xzv_97['cid'])->find();
                        $xzv_97['lanmu'] = $xzv_29['name'];
                        $xzv_97['thumb'] = remote($xzv_0, $xzv_97['thumb'], 1);
                    }
                } else {
                    if ($xzv_36 > 0 && $xzv_88 == false) {
                        $xzv_141 = Db::table('ims_sudu8_page_products')->where('uniacid', $xzv_0)->where('type', 'showArt')->where('cid', 'in', $xzv_23)->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
                        $xzv_53 = Db::table('ims_sudu8_page_products')->where('uniacid', $xzv_0)->where('type', 'showArt')->where('cid', 'in', $xzv_23)->order('num desc')->count();
                        $xzv_93 = $xzv_141->toArray();
                        foreach ($xzv_93['data'] as &$xzv_97) {
                            $xzv_29 = Db::table('ims_sudu8_page_cate')->where('id', $xzv_97['cid'])->find();
                            $xzv_97['lanmu'] = $xzv_29['name'];
                            $xzv_97['thumb'] = remote($xzv_0, $xzv_97['thumb'], 1);
                        }
                    } else {
                        if ($xzv_36 > 0 && $xzv_88 != false) {
                            $xzv_141 = Db::table('ims_sudu8_page_products')->where('uniacid', $xzv_0)->where('type', 'showArt')->where('cid', 'in', $xzv_23)->where('title', 'like', '%' . $xzv_88 . '%')->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
                            $xzv_53 = Db::table('ims_sudu8_page_products')->where('uniacid', $xzv_0)->where('type', 'showArt')->where('cid', 'in', $xzv_23)->where('title', 'like', '%' . $xzv_88 . '%')->order('num desc')->count();
                            $xzv_93 = $xzv_141->toArray();
                            foreach ($xzv_93['data'] as &$xzv_97) {
                                $xzv_29 = Db::table('ims_sudu8_page_cate')->where('id', $xzv_97['cid'])->find();
                                $xzv_97['lanmu'] = $xzv_29['name'];
                                $xzv_97['thumb'] = remote($xzv_0, $xzv_97['thumb'], 1);
                            }
                        } else {
                            if ($xzv_36 == 0 && $xzv_88 != false) {
                                $xzv_141 = Db::table('ims_sudu8_page_products')->where('uniacid', $xzv_0)->where('type', 'showArt')->where('title', 'like', '%' . $xzv_88 . '%')->order('num desc')->paginate(10, false, ['query' => array('appletid' => input('appletid'))]);
                                $xzv_53 = Db::table('ims_sudu8_page_products')->where('uniacid', $xzv_0)->where('type', 'showArt')->where('title', 'like', '%' . $xzv_88 . '%')->order('num desc')->count();
                                $xzv_93 = $xzv_141->toArray();
                                foreach ($xzv_93['data'] as &$xzv_97) {
                                    $xzv_29 = Db::table('ims_sudu8_page_cate')->where('id', $xzv_97['cid'])->find();
                                    $xzv_97['lanmu'] = $xzv_29['name'];
                                    $xzv_97['thumb'] = remote($xzv_0, $xzv_97['thumb'], 1);
                                }
                            }
                        }
                    }
                }
                $this->assign('newnews', $xzv_93['data']);
                $this->assign('news', $xzv_141);
                $this->assign('counts', $xzv_53);
            } else {
                $xzv_92 = Session::get('usergroup');
                if ($xzv_92 == 1) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
                }
                if ($xzv_92 == 2) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
                if ($xzv_92 == 3) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
            }
            return $this->fetch('index');
        } else {
            $this->redirect('Login/index');
        }
    }
    public function navs()
    {
        if (check_login()) {
            if (powerget()) {
                $xzv_65 = input('appletid');
                $xzv_90 = Db::table('applet')->where('id', $xzv_65)->find();
                if (!$xzv_90) {
                    $this->error('找不到对应的小程序！');
                }
                $this->assign('applet', $xzv_90);
                $xzv_69 = Db::table('ims_sudu8_page_art_nav')->where('uniacid', $xzv_65)->select();
                $this->assign('list', $xzv_69);
            } else {
                $xzv_129 = Session::get('usergroup');
                if ($xzv_129 == 1) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
                }
                if ($xzv_129 == 2) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
                if ($xzv_129 == 3) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
            }
            return $this->fetch('navs');
        } else {
            $this->redirect('Login/index');
        }
    }
    public function navsadd()
    {
        if (check_login()) {
            if (powerget()) {
                $xzv_21 = input('appletid');
                $xzv_49 = Db::table('applet')->where('id', $xzv_21)->find();
                if (!$xzv_49) {
                    $this->error('找不到对应的小程序！');
                }
                $this->assign('applet', $xzv_49);
                $xzv_101 = input('newsid');
                if ($xzv_101) {
                    $xzv_140 = Db::table('ims_sudu8_page_art_nav')->where('uniacid', $xzv_21)->where('id', $xzv_101)->find();
                } else {
                    $xzv_140 = '';
                }
                $this->assign('newsid', $xzv_101);
                $this->assign('list', $xzv_140);
            } else {
                $xzv_126 = Session::get('usergroup');
                if ($xzv_126 == 1) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
                }
                if ($xzv_126 == 2) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
                if ($xzv_126 == 3) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
            }
            return $this->fetch('navsadd');
        } else {
            $this->redirect('Login/index');
        }
    }
    public function navssave()
    {
        $xzv_121 = array();
        $xzv_121['uniacid'] = input('appletid');
        $xzv_130 = input('newsid');
        $xzv_5 = input('flag');
        $xzv_121['flag'] = $xzv_5;
        if (input('num')) {
            $xzv_121['num'] = input('num');
        } else {
            $xzv_121['num'] = 0;
        }
        if (input('title')) {
            $xzv_121['title'] = input('title');
        } else {
            $this->error('导航组标题不能为空');
            exit;
        }
        $xzv_68 = DB::table('ims_sudu8_page_art_nav')->where('id', $xzv_130)->find();
        if ($xzv_68) {
            $xzv_7 = Db::table('ims_sudu8_page_art_nav')->where('id', $xzv_130)->update($xzv_121);
        } else {
            $xzv_7 = Db::table('ims_sudu8_page_art_nav')->insert($xzv_121);
        }
        if ($xzv_7) {
            $this->success('导航组添加/修改成功', Url('News/navs') . '?appletid=' . $xzv_121['uniacid']);
        } else {
            $this->success('导航组添加/修改失败，没有修改项');
        }
    }
    public function nav()
    {
        if (check_login()) {
            if (powerget()) {
                $xzv_71 = input('appletid');
                $xzv_63 = Db::table('applet')->where('id', $xzv_71)->find();
                if (!$xzv_63) {
                    $this->error('找不到对应的小程序！');
                }
                $this->assign('applet', $xzv_63);
                $xzv_9 = Db::table('ims_sudu8_page_art_navlist')->where('uniacid', $xzv_71)->select();
                foreach ($xzv_9 as $xzv_52 => $xzv_60) {
                    $xzv_9[$xzv_52]['cname'] = Db::table('ims_sudu8_page_art_nav')->where('uniacid', $xzv_71)->where('id', $xzv_60['cid'])->find()['title'];
                }
                $this->assign('list', $xzv_9);
            } else {
                $xzv_119 = Session::get('usergroup');
                if ($xzv_119 == 1) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
                }
                if ($xzv_119 == 2) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
                if ($xzv_119 == 3) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
            }
            return $this->fetch('nav');
        } else {
            $this->redirect('Login/index');
        }
    }
    public function navadd()
    {
        if (check_login()) {
            if (powerget()) {
                $xzv_135 = input('appletid');
                $xzv_59 = Db::table('applet')->where('id', $xzv_135)->find();
                if (!$xzv_59) {
                    $this->error('找不到对应的小程序！');
                }
                $this->assign('applet', $xzv_59);
                $xzv_51 = input('newsid');
                if ($xzv_51) {
                    $xzv_117 = Db::table('ims_sudu8_page_art_navlist')->where('uniacid', $xzv_135)->where('id', $xzv_51)->find();
                    if ($xzv_117['bgcolor']) {
                        $xzv_117['bgcolor'] = $this->RGBToHex($xzv_117['bgcolor']);
                    }
                    if ($xzv_117['textcolor']) {
                        $xzv_117['textcolor'] = $this->RGBToHex($xzv_117['textcolor']);
                    }
                } else {
                    $xzv_117 = '';
                }
                $xzv_15 = Db::table('ims_sudu8_page_art_nav')->where('uniacid', $xzv_135)->where('flag', 1)->order('num desc')->select();
                $this->assign('cate', $xzv_15);
                $this->assign('newsid', $xzv_51);
                $this->assign('list', $xzv_117);
            } else {
                $xzv_70 = Session::get('usergroup');
                if ($xzv_70 == 1) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
                }
                if ($xzv_70 == 2) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
                if ($xzv_70 == 3) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
            }
            return $this->fetch('navadd');
        } else {
            $this->redirect('Login/index');
        }
    }
    public function navsave()
    {
        $xzv_132 = array();
        $xzv_132['uniacid'] = input('appletid');
        $xzv_86 = input('newsid');
        $xzv_113 = input('flag');
        $xzv_132['flag'] = $xzv_113;
        if (input('num')) {
            $xzv_132['num'] = input('num');
        } else {
            $xzv_132['num'] = 0;
        }
        if (input('cid')) {
            $xzv_132['cid'] = input('cid');
        } else {
            $this->error('请选择导航组');
            exit;
        }
        if (input('title')) {
            $xzv_132['title'] = input('title');
        } else {
            $this->error('导航标题不能为空');
            exit;
        }
        $xzv_132['type'] = intval(input('type'));
        if ($xzv_132['type'] == 3) {
            $xzv_132['url'] = '';
        } else {
            $xzv_132['url'] = input('url');
        }
        $xzv_132['bgcolor'] = $this->hex2rgb(input('bgcolor'));
        $xzv_132['textcolor'] = $this->hex2rgb(input('textcolor'));
        $xzv_50 = DB::table('ims_sudu8_page_art_navlist')->where('id', $xzv_86)->find();
        if ($xzv_50) {
            $xzv_74 = Db::table('ims_sudu8_page_art_navlist')->where('id', $xzv_86)->update($xzv_132);
        } else {
            $xzv_74 = Db::table('ims_sudu8_page_art_navlist')->insert($xzv_132);
        }
        if ($xzv_74) {
            $this->success('导航添加/修改成功', Url('News/nav') . '?appletid=' . $xzv_132['uniacid']);
        } else {
            $this->success('导航添加/修改失败，没有修改项');
        }
    }
    public function navsdel()
    {
        $xzv_106 = input('newsid');
        $xzv_123 = Db::table('ims_sudu8_page_art_nav')->where('id', $xzv_106)->delete();
        if ($xzv_123) {
            $this->success('删除成功');
        } else {
            $this->success('删除失败');
        }
    }
    public function navdel()
    {
        $xzv_142 = input('newsid');
        $xzv_2 = Db::table('ims_sudu8_page_art_navlist')->where('id', $xzv_142)->delete();
        if ($xzv_2) {
            $this->success('删除成功');
        } else {
            $this->success('删除失败');
        }
    }
    public function searchs()
    {
        $xzv_85 = input('keys');
        $xzv_83 = input('appletid');
        $xzv_82 = Db::query('SELECT title,id FROM ims_sudu8_page_products WHERE uniacid = ' . $xzv_83 . " and type ='showArt' and title like '%" . $xzv_85 . "%' ORDER BY num DESC,id DESC");
        echo json_encode($xzv_82);
        exit;
    }
    public function getnews()
    {
        $xzv_80 = input('id');
        $xzv_47 = input('appletid');
        $xzv_77 = Db::table('ims_sudu8_page_products')->where('id', $xzv_80)->where('uniacid', $xzv_47)->where('type', 'showArt')->field('title,id')->find();
        echo json_encode($xzv_77);
        exit;
    }
    public function add()
    {
        if (check_login()) {
            if (powerget()) {
                $xzv_127 = input('appletid');
                $xzv_18 = Db::table('applet')->where('id', $xzv_127)->find();
                if (!$xzv_18) {
                    $this->error('找不到对应的小程序！');
                }
                $this->assign('applet', $xzv_18);
                $xzv_81 = Db::table('ims_sudu8_page_art_nav')->where('uniacid', $xzv_127)->where('flag', 1)->order('num desc')->select();
                $this->assign('navlist', $xzv_81);
                $xzv_107 = Db::table('ims_sudu8_page_cate')->where('uniacid', $xzv_127)->where('cid', 0)->order('num desc')->select();
                $xzv_108 = array();
                foreach ($xzv_107 as $xzv_78 => $xzv_109) {
                    $xzv_73 = intval($xzv_109['id']);
                    $xzv_110 = Db::table('ims_sudu8_page_cate')->where('uniacid', $xzv_127)->where('id', $xzv_73)->order('num desc')->select();
                    $xzv_17 = Db::table('ims_sudu8_page_cate')->where('uniacid', $xzv_127)->where('cid', $xzv_73)->order('num desc')->select();
                    $xzv_111 = Db::table('ims_sudu8_page_cate')->where('uniacid', $xzv_127)->where('cid', $xzv_73)->order('num desc')->count();
                    $xzv_110['data'] = $xzv_17;
                    $xzv_110['zcount'] = $xzv_111;
                    array_push($xzv_108, $xzv_110);
                }
                $this->assign('cate', $xzv_108);
                $xzv_112 = Db::table('ims_sudu8_page_multicate')->where('uniacid', $xzv_127)->where('statue', 1)->where('type', 'showArt')->select();
                $xzv_35 = array();
                $xzv_16 = input('newsid');
                $xzv_48 = array();
                $xzv_136 = array();
                if ($xzv_16) {
                    $xzv_137 = Db::table('ims_sudu8_page_products')->where('id', $xzv_16)->where('type', 'showArt')->find();
                    if ($xzv_137['music_art_info'] == '') {
                        $xzv_137['music_art_info']['musicTitle'] = '';
                        $xzv_137['music_art_info']['music'] = '';
                        $xzv_137['music_art_info']['music_price'] = '';
                        $xzv_137['music_art_info']['autoPlay'] = '';
                        $xzv_137['music_art_info']['loopPlay'] = '';
                        $xzv_137['music_art_info']['art_price'] = '';
                    } else {
                        $xzv_137['music_art_info'] = unserialize($xzv_137['music_art_info']);
                    }
                    if (stristr($xzv_137['share_score'], 'http') || stristr($xzv_137['share_score'], 'sudu8_page')) {
                        $xzv_137['weburl'] = $xzv_137['share_score'];
                        $xzv_137['share_score'] = '';
                    } else {
                        $xzv_137['weburl'] = '';
                    }
                    if ($xzv_137['uniacid'] == $xzv_127) {
                        if ($xzv_137['thumb']) {
                            $xzv_137['thumb'] = remote($xzv_127, $xzv_137['thumb'], 1);
                        }
                        if ($xzv_137['shareimg']) {
                            $xzv_137['shareimg'] = remote($xzv_127, $xzv_137['shareimg'], 1);
                        }
                        if ($xzv_137['labels']) {
                            $xzv_137['labels'] = remote($xzv_127, $xzv_137['labels'], 1);
                        }
                        if ($xzv_137['glnews'] != '') {
                            $xzv_114 = unserialize($xzv_137['glnews']);
                            foreach ($xzv_114 as $xzv_37 => $xzv_115) {
                                $xzv_136[$xzv_37] = Db::table('ims_sudu8_page_products')->where('id', $xzv_115)->where('uniacid', $xzv_127)->find();
                            }
                        }
                        $xzv_48 = $xzv_137;
                        $xzv_138 = Db::table('ims_sudu8_page_multicates')->where('id', 'in', $xzv_48['top_catas'])->select();
                        foreach ($xzv_138 as $xzv_37 => $xzv_115) {
                            $xzv_138[$xzv_37]['sons'] = Db::table('ims_sudu8_page_multicates')->where('pid', $xzv_115['id'])->select();
                        }
                    } else {
                        $xzv_139 = Session::get('usergroup');
                        if ($xzv_139 == 1) {
                            $this->error('找不到该内容，或者该内容不属于本小程序');
                        }
                        if ($xzv_139 == 2) {
                            $this->error('找不到该内容，或者该内容不属于本小程序');
                        }
                    }
                } else {
                    $xzv_16 = 0;
                    $xzv_14 = '';
                    $xzv_56 = '';
                    $xzv_138 = '';
                    foreach ($xzv_112 as $xzv_37 => $xzv_115) {
                        $xzv_112[$xzv_37]['flag'] = 0;
                    }
                }
                $xzv_13 = Db::table('ims_sudu8_page_formlist')->where('uniacid', $xzv_127)->select();
                $this->assign('glnews', $xzv_136);
                $this->assign('sons_keys', $xzv_138);
                $this->assign('forms', $xzv_13);
                $this->assign('cates', $xzv_112);
                $this->assign('newsid', $xzv_16);
                $this->assign('newsinfo', $xzv_48);
            } else {
                $xzv_139 = Session::get('usergroup');
                if ($xzv_139 == 1) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
                }
                if ($xzv_139 == 2) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
                if ($xzv_139 == 3) {
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
        $xzv_116 = array();
        $xzv_116['uniacid'] = input('appletid');
        $xzv_57 = input('num');
        if ($xzv_57) {
            $xzv_116['num'] = $xzv_57;
        }
        $xzv_105 = input('cid');
        if ($xzv_105) {
            $xzv_116['cid'] = $xzv_105;
            $xzv_40 = Db::table('ims_sudu8_page_cate')->where('id', $xzv_105)->find();
            $xzv_116['type'] = $xzv_40['type'];
            $xzv_116['lanmu'] = $xzv_40['name'];
        }
        $xzv_12 = Db::table('ims_sudu8_page_cate')->where('id', $xzv_105)->where('uniacid', input('appletid'))->field('cid')->find();
        if ($xzv_12['cid'] == 0) {
            $xzv_116['pcid'] = $xzv_105;
        } else {
            $xzv_116['pcid'] = $xzv_12['cid'];
        }
        $xzv_125 = input('type_x');
        if ($xzv_125) {
            $xzv_116['type_x'] = (int) $xzv_125;
        } else {
            $xzv_116['type_x'] = 0;
        }
        $xzv_11 = input('type_y');
        if ($xzv_11) {
            $xzv_116['type_y'] = (int) $xzv_11;
        } else {
            $xzv_116['type_y'] = 0;
        }
        if (!is_null(input('choose/a'))) {
            $xzv_116['glnews'] = serialize(array_values(array_unique(input('choose/a'))));
        } else {
            $xzv_116['glnews'] = '';
        }
        $xzv_120 = input('type_i');
        if ($xzv_120) {
            $xzv_116['type_i'] = (int) $xzv_120;
        } else {
            $xzv_116['type_i'] = 0;
        }
        $xzv_39 = input('hits');
        if ($xzv_39) {
            $xzv_116['hits'] = $xzv_39;
        }
        $xzv_122 = input('art_price');
        if ($xzv_122) {
        }
        $xzv_62 = input('title');
        if ($xzv_62) {
            $xzv_116['title'] = $xzv_62;
        }
        $xzv_43 = input('commonuploadpic1');
        if ($xzv_43) {
            $xzv_116['thumb'] = remote($xzv_116['uniacid'], $xzv_43, 2);
        }
        $xzv_1 = input('commonuploadpic2');
        if ($xzv_1) {
            $xzv_116['shareimg'] = remote($xzv_116['uniacid'], $xzv_1, 2);
        }
        $xzv_64 = $_POST['desc'];
        if ($xzv_64) {
            $xzv_116['desc'] = $xzv_64;
        }
        $xzv_8 = strtotime(input('edittime'));
        if ($xzv_8 == 0) {
            $xzv_116['edittime'] = time();
        } else {
            $xzv_116['edittime'] = $xzv_8;
        }
        $xzv_124 = input('video');
        $xzv_116['video'] = $xzv_124;
        $xzv_134 = input('commonuploadpic3');
        if ($xzv_134) {
            $xzv_116['labels'] = remote($xzv_116['uniacid'], $xzv_134, 2);
        } else {
            if ($xzv_43) {
                $xzv_116['labels'] = $xzv_43;
            }
        }
        $xzv_6 = input('price');
        if ($xzv_6) {
            $xzv_116['price'] = $xzv_6;
        } else {
            $xzv_116['price'] = 0;
        }
        $xzv_118 = input('market_price');
        if ($xzv_118) {
            $xzv_116['market_price'] = $xzv_118;
        } else {
            $xzv_116['market_price'] = 'false';
        }
        $xzv_4 = input('text');
        if ($xzv_4) {
            $xzv_116['text'] = $xzv_4;
        }
        $xzv_3 = input('formset');
        if ($xzv_3) {
            $xzv_116['formset'] = $xzv_3;
        }
        $xzv_116['pro_flag'] = input('pro_flag');
        $xzv_20 = input('comment');
        $xzv_116['comment'] = $xzv_20;
        $xzv_104 = input('share_gz');
        $xzv_116['share_gz'] = $xzv_104;
        $xzv_46 = input('share_type');
        $xzv_116['share_type'] = $xzv_46;
        $xzv_19 = input('share_score');
        $xzv_116['share_score'] = $xzv_19;
        $xzv_128 = input('share_num');
        $xzv_116['share_num'] = $xzv_128;
        $xzv_10 = input('newsid');
        $xzv_42 = Db::table('ims_sudu8_page_multicate')->where('id', input('mulitcataid'))->find();
        $xzv_116['sons_catas'] = input('sons/a') ? implode(',', input('sons/a')) : '';
        $xzv_116['top_catas'] = $xzv_42['top_catas'] ? implode(',', unserialize($xzv_42['top_catas'])) : '';
        $xzv_116['mulitcataid'] = input('mulitcataid');
        $xzv_45 = input('muiltcate');
        if ($xzv_45 != '0') {
            $xzv_116['multi'] = 1;
        } else {
            $xzv_116['multi'] = 0;
        }
        $xzv_116['get_share_gz'] = input('get_share_gz');
        $xzv_116['get_share_score'] = input('get_share_score');
        $xzv_116['get_share_num'] = input('get_share_num');
        $xzv_31 = array('musicTitle' => input('musicTitle'), 'art_price' => input('art_price'), 'music' => input('music'), 'music_price' => input('music_price'), 'autoPlay' => input('autoPlay'), 'loopPlay' => input('loopPlay'));
        $xzv_116['music_art_info'] = serialize($xzv_31);
        if (stristr(input('weburl'), 'http') || stristr(input('weburl'), 'sudu8_page')) {
            $xzv_67 = input('weburl');
        } else {
            $xzv_67 = input('share_score');
        }
        $xzv_116['share_score'] = $xzv_67;
        if ($xzv_10) {
            $xzv_116['etime'] = time();
            $xzv_66 = Db::table('ims_sudu8_page_products')->where('id', $xzv_10)->update($xzv_116);
        } else {
            $xzv_116['ctime'] = time();
            $xzv_66 = Db::table('ims_sudu8_page_products')->insert($xzv_116);
        }
        if ($xzv_66) {
            $this->success('基础信息更新成功！', Url('News/index') . '?appletid=' . $xzv_116['uniacid']);
        } else {
            $this->error('基础信息更新失败，没有修改项！');
            exit;
        }
    }
    public function hex2rgb($xzv_30)
    {
        $xzv_30 = str_replace('#', '', $xzv_30);
        if (strlen($xzv_30) > 3) {
            $xzv_44 = hexdec(substr($xzv_30, 0, 2)) . ',' . hexdec(substr($xzv_30, 2, 2)) . ',' . hexdec(substr($xzv_30, 4, 2));
        } else {
            $xzv_30 = $xzv_30;
            $xzv_22 = substr($xzv_30, 0, 1) . substr($xzv_30, 0, 1);
            $xzv_28 = substr($xzv_30, 1, 1) . substr($xzv_30, 1, 1);
            $xzv_102 = substr($xzv_30, 2, 1) . substr($xzv_30, 2, 1);
            $xzv_44 = hexdec($xzv_22) . ',' . hexdec($xzv_28) . ',' . hexdec($xzv_102);
        }
        return $xzv_44;
    }
    public function RGBToHex($xzv_95)
    {
        $xzv_95 = 'rgb(' . $xzv_95 . ')';
        $xzv_58 = '/^rgb\\(([0-9]{0,3})\\,\\s*([0-9]{0,3})\\,\\s*([0-9]{0,3})\\)/';
        $xzv_96 = preg_match($xzv_58, $xzv_95, $xzv_26);
        $xzv_96 = array_shift($xzv_26);
        $xzv_41 = '#';
        $xzv_54 = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
        for ($xzv_100 = 0; $xzv_100 < 3; $xzv_100++) {
            $xzv_72 = null;
            $xzv_34 = $xzv_26[$xzv_100];
            $xzv_94 = array();
            while ($xzv_34 > 16) {
                $xzv_72 = $xzv_34 % 16;
                $xzv_34 = $xzv_34 / 16 >> 0;
                array_push($xzv_94, $xzv_54[$xzv_72]);
            }
            array_push($xzv_94, $xzv_54[$xzv_34]);
            $xzv_91 = array_reverse($xzv_94);
            $xzv_27 = implode('', $xzv_91);
            $xzv_27 = str_pad($xzv_27, 2, '0', STR_PAD_LEFT);
            $xzv_41 .= $xzv_27;
        }
        return $xzv_41;
    }
    public function del()
    {
        $xzv_84['id'] = input('newsid');
        $xzv_38 = Db::table('ims_sudu8_page_products')->where($xzv_84)->delete();
        if ($xzv_38) {
            $this->success('删除成功');
        } else {
            $this->success('删除失败');
        }
    }
    function onepic_uploade($xzv_133)
    {
        $xzv_24 = request()->file($xzv_133);
        if (isset($xzv_24)) {
            $xzv_131 = upload_img();
            $xzv_32 = $xzv_24->validate(['ext' => 'jpg,png,gif,jpeg'])->move($xzv_131);
            if ($xzv_32) {
                $xzv_79 = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $xzv_32->getFilename();
                return $xzv_79;
            }
        }
    }
    public function imgupload()
    {
        $xzv_75 = request()->file('');
        foreach ($xzv_75 as $xzv_33) {
            $xzv_76 = $xzv_33->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
            if ($xzv_76) {
                $xzv_89 = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $xzv_76->getFilename();
                $xzv_103 = array('url' => $xzv_89);
                return json_encode($xzv_103);
            } else {
                return $this->error($xzv_33->getError());
            }
        }
    }
}