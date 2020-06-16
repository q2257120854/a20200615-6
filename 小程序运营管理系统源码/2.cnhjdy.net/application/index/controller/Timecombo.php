<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Session;
use think\View;
class timecombo extends Controller
{
    public function index()
    {
        if (check_login()) {
            if (check_group()) {
                if (input('keyworld')) {
                } else {
                    $xzv_19 = Db::name('time_combo')->order('id asc')->paginate(10);
                    $xzv_11 = Db::name('time_combo')->order('id desc')->count();
                }
                $this->assign('time_combo', $xzv_19);
                $this->assign('c', $xzv_11);
                return $this->fetch('index');
            } else {
                $this->error('您没有权限操作该模块！', 'Applet/applet');
            }
        } else {
            $this->redirect('Login/index');
        }
    }
    public function add()
    {
        if (check_login()) {
            if (check_group()) {
                return $this->fetch('add');
            }
        } else {
            $this->redirect('Login/index');
        }
    }
    public function save_add()
    {
        $xzv_1 = $_POST['name'];
        $xzv_13 = $_POST['pay_time'];
        $xzv_18 = $_POST['free_time'];
        if ($xzv_1) {
            $xzv_5['name'] = $xzv_1;
        } else {
            $this->error('请输入套餐名称');
        }
        if ($xzv_13) {
            $xzv_5['pay_time'] = $xzv_13;
        } else {
            $this->error('请输入套餐时长');
        }
        if ($xzv_18 !== 0) {
            $xzv_5['free_time'] = $xzv_18;
        } else {
            $this->error('请输入赠送时长');
        }
        $xzv_5['createtime'] = time();
        $xzv_6 = Db::name('time_combo')->insert($xzv_5);
        if ($xzv_6) {
            $this->success('时长套餐添加成功!', 'Timecombo/index');
        } else {
            $this->error('添加失败!');
        }
    }
    public function del()
    {
        $xzv_17 = $_POST['id'];
        $xzv_16 = Db::name('time_combo')->where('id', $xzv_17)->delete();
        if ($xzv_16) {
            return 1;
        } else {
            return 2;
            exit;
        }
    }
    public function edit()
    {
        if (check_login()) {
            if (check_group()) {
                $xzv_8 = $_GET['id'];
                $xzv_10 = Db::name('time_combo')->where('id', $xzv_8)->find();
                $this->assign('time_combo', $xzv_10);
                return $this->fetch('edit');
            }
        } else {
            $this->redirect('Login/index');
        }
    }
    public function save_edit()
    {
        $xzv_3 = $_POST['id'];
        $xzv_14 = $_POST['name'];
        $xzv_15 = $_POST['pay_time'];
        $xzv_12 = $_POST['free_time'];
        if (!$xzv_14) {
            $this->error('请输入套餐名称');
        }
        if (!$xzv_15) {
            $this->error('请输入套餐时长');
        }
        if (!$xzv_12) {
            $this->error('请输入赠送时长');
        }
        $xzv_7 = Db::name('time_combo')->where('id', $xzv_3)->update(['name' => $xzv_14, 'pay_time' => $xzv_15, 'free_time' => $xzv_12]);
        if ($xzv_7 !== false) {
            $this->success('套餐修改成功！', 'Timecombo/index');
        } else {
            $this->error('套餐修改失败！');
            exit;
        }
    }
    public function combo_name()
    {
        $xzv_2 = $_POST['id'];
        $xzv_9 = Db::name('time_combo')->where('id', $xzv_2)->field('name')->find();
        return $xzv_9['name'];
    }
    public function timecombo_info()
    {
        $xzv_4 = $_POST['id'];
        $xzv_0 = Db::name('time_combo')->where('id', $xzv_4)->find();
        return $xzv_0;
    }
}