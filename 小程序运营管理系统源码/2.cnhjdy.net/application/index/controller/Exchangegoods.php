<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Exchangegoods extends Base
{
    public function index()
    {
        if (check_login()) {
            if (powerget()) {
                $xzv_56 = input('appletid');
                $xzv_43 = Db::table('applet')->where('id', $xzv_56)->find();
                if (!$xzv_43) {
                    $this->error('找不到对应的小程序！');
                }
                $this->assign('applet', $xzv_43);
                $xzv_45 = Db::table('ims_sudu8_page_score_shop')->alias('a')->join('ims_sudu8_page_score_cate b', 'a.cid = b.id')->where('a.uniacid', $xzv_56)->order('a.num desc')->order('a.id desc')->field('a.num,a.thumb,a.title,a.id,b.name,a.buy_type,a.onlyid')->paginate(10);
                $xzv_44 = count($xzv_45);
                $xzv_25 = $xzv_45->all();
                foreach ($xzv_25 as $xzv_33 => &$xzv_12) {
                    $xzv_12['thumb'] = remote($xzv_56, $xzv_12['thumb'], 1);
                }
                $this->assign('counts', $xzv_44);
                $this->assign('page', $xzv_45->render());
                $this->assign('products', $xzv_25);
            } else {
                $xzv_46 = Session::get('usergroup');
                if ($xzv_46 == 1) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
                }
                if ($xzv_46 == 2) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
                if ($xzv_46 == 3) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
            }
            return $this->fetch('index');
        } else {
            $this->redirect('Login/index');
        }
    }
    public function add()
    {
        if (check_login()) {
            if (powerget()) {
                $xzv_26 = input('appletid');
                $xzv_8 = Db::table('applet')->where('id', $xzv_26)->find();
                if (!$xzv_8) {
                    $this->error('找不到对应的小程序！');
                }
                $this->assign('applet', $xzv_8);
                $xzv_34 = Db::table('ims_sudu8_page_score_cate')->where('uniacid', $xzv_26)->select();
                $this->assign('cate', $xzv_34);
                $xzv_30 = input('pid');
                if ($xzv_30) {
                    $xzv_47 = Db::table('ims_sudu8_page_score_shop')->where('id', $xzv_30)->find();
                    if ($xzv_47['uniacid'] == $xzv_26) {
                        $xzv_39 = Db::table('products_url')->where('randid', $xzv_47['onlyid'])->select();
                        foreach ($xzv_39 as $xzv_28 => &$xzv_27) {
                            $xzv_27['url'] = remote($xzv_26, $xzv_27['url'], 1);
                        }
                        $xzv_47['thumb'] = remote($xzv_26, $xzv_47['thumb'], 1);
                    }
                } else {
                    $xzv_47 = '';
                    $xzv_30 = 0;
                    $xzv_39 = '';
                }
                $this->assign('allimg', $xzv_39);
                $this->assign('pid', $xzv_30);
                $this->assign('products', $xzv_47);
            } else {
                $xzv_41 = Session::get('usergroup');
                if ($xzv_41 == 1) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/applet');
                }
                if ($xzv_41 == 2) {
                    $this->error('您没有权限操作该小程序或找不到相应小程序！', 'Applet/index');
                }
                if ($xzv_41 == 3) {
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
        $xzv_32 = array();
        $xzv_32['uniacid'] = input('appletid');
        $xzv_51 = $_POST['onlyid'];
        if ($xzv_51) {
            $xzv_32['onlyid'] = $xzv_51;
        }
        if (!$xzv_51) {
        } else {
            $xzv_54 = input('imgsrcs/a');
            if ($xzv_54) {
                $xzv_10 = array();
                foreach ($xzv_54 as $xzv_14 => $xzv_55) {
                    $xzv_10['randid'] = $xzv_51;
                    $xzv_10['appletid'] = $xzv_32['uniacid'];
                    $xzv_10['url'] = remote($xzv_32['uniacid'], $xzv_55, 2);
                    $xzv_10['dateline'] = time();
                    $xzv_36 = Db::table('products_url')->insert($xzv_10);
                }
            } else {
                $xzv_36 = 1;
            }
            $xzv_38 = Db::table('products_url')->where('randid', $xzv_51)->select();
            $xzv_6 = array();
            if ($xzv_38) {
                foreach ($xzv_38 as $xzv_0) {
                    $xzv_6[] = $xzv_0['url'];
                }
                $xzv_32['text'] = serialize($xzv_6);
            } else {
                $xzv_32['text'] = '';
            }
        }
        $xzv_15 = input('num');
        if ($xzv_15) {
            $xzv_32['num'] = intval($xzv_15);
        }
        $xzv_24 = input('cid');
        if ($xzv_24) {
            $xzv_32['cid'] = intval($xzv_24);
        }
        $xzv_9 = input('name');
        if ($xzv_9) {
            $xzv_32['name'] = $xzv_9;
        }
        $xzv_53 = input('hits');
        if ($xzv_53) {
            $xzv_32['hits'] = $xzv_53;
        }
        $xzv_52 = input('sale_num');
        if ($xzv_52) {
            $xzv_32['sale_num'] = $xzv_52;
        }
        $xzv_19 = input('price');
        if ($xzv_19) {
            $xzv_32['price'] = $xzv_19;
        }
        $xzv_17 = input('market_price');
        if ($xzv_17) {
            $xzv_32['market_price'] = $xzv_17;
        }
        $xzv_2 = input('pro_kc');
        if ($xzv_2) {
            $xzv_32['pro_kc'] = $xzv_2;
        }
        $xzv_3 = input('sale_tnum');
        if ($xzv_3) {
            $xzv_32['sale_tnum'] = $xzv_3;
        }
        $xzv_4 = input('labels');
        if ($xzv_4) {
            $xzv_32['labels'] = $xzv_4;
        }
        $xzv_5 = input('title');
        if ($xzv_5) {
            $xzv_32['title'] = $xzv_5;
        }
        $xzv_29 = input('desc');
        if ($xzv_29) {
            $xzv_32['desk'] = $xzv_29;
        }
        $xzv_37 = input('text');
        if ($xzv_37) {
            $xzv_32['product_txt'] = $xzv_37;
        }
        $xzv_50 = input('commonuploadpic');
        if ($xzv_50) {
            $xzv_32['thumb'] = remote($xzv_32['uniacid'], $xzv_50, 2);
        }
        $xzv_23 = input('pid');
        if ($xzv_23 != 0) {
            $xzv_35 = Db::table('ims_sudu8_page_score_shop')->where('id', $xzv_23)->update($xzv_32);
        } else {
            $xzv_35 = Db::table('ims_sudu8_page_score_shop')->insert($xzv_32);
        }
        if ($xzv_35) {
            $this->success('积分商品信息更新成功！', Url('Exchangegoods/index') . '?appletid=' . $xzv_32['uniacid']);
        } else {
            $this->error('积分商品信息更新失败，没有修改项！');
            exit;
        }
    }
    public function del()
    {
        $xzv_7['id'] = input('pid');
        $xzv_1 = Db::table('ims_sudu8_page_score_shop')->where($xzv_7)->delete();
        if ($xzv_1) {
            $this->success('删除成功');
        } else {
            $this->success('删除失败');
        }
    }
    public function imgupload_duo()
    {
        $xzv_20['randid'] = input('randid');
        $xzv_49 = request()->file('');
        foreach ($xzv_49 as $xzv_48) {
            $xzv_40 = $xzv_48->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upimages');
            if ($xzv_40) {
                $xzv_20['url'] = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $xzv_40->getFilename();
                $xzv_20['dateline'] = time();
                $xzv_11 = Db::table('products_url')->insert($xzv_20);
            } else {
                return $this->error($xzv_48->getError());
            }
        }
    }
    public function getimg()
    {
        $xzv_13 = $_POST['id'];
        $xzv_42 = Db::table('products_url')->where('randid', $xzv_13)->select();
        if ($xzv_42) {
            return $xzv_42;
        }
    }
    function onepic_uploade($xzv_21)
    {
        $xzv_31 = request()->file($xzv_21);
        if (isset($xzv_31)) {
            $xzv_22 = upload_img();
            $xzv_16 = $xzv_31->move($xzv_22);
            if ($xzv_16) {
                $xzv_18 = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $xzv_16->getFilename();
                return $xzv_18;
            }
        }
    }
}