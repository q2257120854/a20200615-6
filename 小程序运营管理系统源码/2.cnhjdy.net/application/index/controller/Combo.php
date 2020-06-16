<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class Combo extends Controller
{
    public function index()
    {
        if (check_login()) {
            if (check_group()) {
                if (input('keyworld')) {
                    $xzv_15 = Db::table('combo')->where('name', 'like', '%' . input('keyworld') . '%')->paginate(10, false, ['query' => array('keyworld' => input('keyworld'))]);
                    $xzv_13 = Db::table('combo')->where('name', 'like', '%' . input('keyworld') . '%')->count();
                } else {
                    $xzv_15 = Db::name('combo')->order('id desc')->paginate(10);
                    $xzv_13 = Db::name('combo')->order('id desc')->count();
                }
                $this->assign('combo', $xzv_15);
                $this->assign('c', $xzv_13);
                return $this->fetch('index');
            } else {
                $this->error('您没有权限操作该模块！', 'Applet/applet');
            }
        } else {
            $this->redirect('Login/index');
        }
    }
    public function add_combo()
    {
        if (check_login()) {
            if (check_group()) {
                return $this->fetch('add_combo');
            }
        } else {
            $this->redirect('Login/index');
        }
    }
    public function save_combo()
    {
        $xzv_2 = $_POST['name'];
        $xzv_36 = $_POST['icon'];
        $xzv_33 = $_POST['wx_price'];
        $xzv_22 = $_POST['combo_desc'];
        if ($xzv_2) {
            $xzv_37['name'] = $xzv_2;
        } else {
            $this->error('请输入套餐名称');
        }
        if ($xzv_36) {
            $xzv_37['icon'] = moveurl($xzv_36);
        }
        if ($xzv_33) {
            if (is_numeric($xzv_33)) {
                $xzv_37['wx_price'] = $xzv_33;
            } else {
                $this->error('请输入正确的套餐微信价格');
            }
        } else {
            $this->error('请输入套餐微信价格');
        }
        $xzv_37['combo_desc'] = $xzv_22;
        $xzv_37['node_id'] = 'a:5:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:3:"104";i:3;s:3:"105";i:4;s:3:"137";}';
        $xzv_37['createtime'] = time();
        $xzv_6 = Db::name('combo')->insert($xzv_37);
        if ($xzv_6) {
            $this->success('套餐添加成功！', 'Combo/');
        } else {
            $this->error('套餐添加失败！');
            exit;
        }
    }
    public function edit_combo()
    {
        if (check_login()) {
            if (check_group()) {
                $xzv_7 = $_GET['id'];
                $xzv_8 = Db::name('combo')->where('id', $xzv_7)->find();
                $this->assign('combo', $xzv_8);
                return $this->fetch('edit_combo');
            }
        } else {
            $this->redirect('Login/index');
        }
    }
    public function save_edit_combo()
    {
        $xzv_26 = $_POST['id'];
        $xzv_23 = $_POST['name'];
        $xzv_10 = $_POST['icon'];
        if ($xzv_10 != null) {
            $xzv_48 = $xzv_10;
        } else {
            $xzv_12 = Db::name('combo')->where('id', $xzv_26)->field('icon')->find();
            $xzv_48 = $xzv_12['icon'];
        }
        $xzv_42 = $_POST['wx_price'];
        $xzv_45 = $_POST['combo_desc'];
        if ($xzv_23) {
            $xzv_52['name'] = $xzv_23;
        } else {
            $this->error('请输入套餐名称');
        }
        if ($xzv_42) {
            if (is_numeric($xzv_42)) {
            } else {
                $this->error('请输入正确的套餐微信价格');
            }
        } else {
            $this->error('请输入套餐微信价格');
        }
        $xzv_12 = Db::name('combo')->where('id', $xzv_26)->update(['name' => $xzv_23, 'wx_price' => $xzv_42, 'icon' => moveurl($xzv_48), 'combo_desc' => $xzv_45]);
        if ($xzv_12 !== false) {
            $this->success('套餐修改成功！', 'Combo/index');
        } else {
            $this->error('套餐修改失败！');
            exit;
        }
    }
    public function del_combo()
    {
        $xzv_53 = $_POST['id'];
        $xzv_24 = Db::name('combo')->where('id', $xzv_53)->delete();
        if ($xzv_24) {
            return 1;
        } else {
            return 2;
        }
    }
    public function rule()
    {
        $xzv_0 = $_GET['id'];
        $xzv_55 = Db::name('combo')->where('id', $xzv_0)->field('node_id')->find();
        $xzv_55 = unserialize($xzv_55['node_id']);
        if (!$xzv_55) {
            $xzv_55 = array();
        }
        $xzv_39 = Db::name('rule')->select();
        $xzv_50 = $this->getTree($xzv_39);
        $xzv_32 = $this->change($xzv_50);
        $this->assign('rule', $xzv_32);
        $this->assign('id', $xzv_0);
        $this->assign('combo', $xzv_55);
        return $this->fetch('rule');
    }
    public function test()
    {
        $xzv_56 = Db::name('rule')->select();
        $xzv_17 = $this->change($xzv_56);
        $this->assign('test', $xzv_17);
        return $this->fetch('test');
    }
    public function save_rule()
    {
        $xzv_31 = $_POST['id'];
        $xzv_54 = $_POST['temp'];
        $xzv_54 = serialize($xzv_54);
        $xzv_21 = Db::name('combo')->where('id', $xzv_31)->update(['node_id' => $xzv_54]);
        if ($xzv_21) {
            return 1;
        } else {
            return 2;
        }
    }
    private function getTree($xzv_5, $xzv_9 = 0, $xzv_51 = 0)
    {
        static $xzv_28 = array();
        foreach ($xzv_5 as $xzv_14 => $xzv_43) {
            if ($xzv_43['pid'] == $xzv_9) {
                $xzv_43['level'] = $xzv_51;
                $xzv_28[] = $xzv_43;
                $this->getTree($xzv_5, $xzv_43['id'], $xzv_51 + 1);
            }
        }
        return $xzv_28;
    }
    public function getChild($xzv_44, $xzv_1, $xzv_46 = false)
    {
        static $xzv_47 = array();
        if ($xzv_46) {
            $xzv_47 = array();
        }
        foreach ($xzv_44 as $xzv_58 => $xzv_41) {
            if ($xzv_41['pid'] == $xzv_1) {
                $xzv_47[] = $xzv_41['id'];
                $this->getChild($xzv_44, $xzv_41['id']);
            }
        }
        return $xzv_47;
    }
    function onepic_uploade($xzv_29)
    {
        $xzv_25 = request()->file($xzv_29);
        if (isset($xzv_25)) {
            $xzv_11 = upload_img();
            $xzv_16 = $xzv_25->move($xzv_11);
            if ($xzv_16) {
                $xzv_20 = ROOT_HOST . '/upimages/' . date('Ymd', time()) . '/' . $xzv_16->getFilename();
                return $xzv_20;
            }
        }
    }
    public function change($xzv_18)
    {
        static $xzv_49 = array();
        foreach ($xzv_18 as $xzv_27 => $xzv_35) {
            if ($xzv_35['pid'] == 0) {
                foreach ($xzv_18 as $xzv_34 => $xzv_30) {
                    if ($xzv_30['pid'] == $xzv_35['id']) {
                        foreach ($xzv_18 as $xzv_4 => $xzv_19) {
                            if ($xzv_19['pid'] == $xzv_30['id']) {
                                $xzv_30['child'][] = $xzv_19;
                            }
                        }
                        $xzv_35['child'][] = $xzv_30;
                    }
                }
                $xzv_49[] = $xzv_35;
            }
        }
        return $xzv_49;
    }
    public function combo_name()
    {
        $xzv_3 = $_POST['id'];
        $xzv_38 = Db::name('combo')->where('id', $xzv_3)->field('name')->find();
        return $xzv_38['name'];
    }
    public function combo_info()
    {
        $xzv_57 = $_POST['id'];
        $xzv_40 = Db::name('combo')->where('id', $xzv_57)->find();
        return $xzv_40;
    }
}