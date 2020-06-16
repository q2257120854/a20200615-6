<?php
namespace app\user\controller;

use app\common\controller\HomeBase;
use think\Db;

class Message extends HomeBase
{
    public function _initialize()
    {
        parent::_initialize();
    }
    public function readmsg()
    {
        if (!session('userid') || !session('username')) {
            return json(array('code' => 0, 'msg' => '请先登录'));
        } else {
            $uid   = session('userid');
            $tptc  = Db::name('message')->where('touid', $uid)->update(['status' => 2]);
            $tptc1 = Db::name('readmessage')->where(array('uid'=>$uid,'status'=>1))->update(['status' => 2]);
            return json(array('code' => 200, 'msg' => '标记已读成功'));
        }
    }
    //取新的系统消息
    public function getSysMsg()
    {
        $uid = session('userid');
        /////读取系统消息开始
        //所有系统消息
        $tptc = Db::name('message')->where(array('touid' => 0))->column('id');
        //所有已取系统消息
        $tptc1 = Db::name('readmessage')->where(array('uid' => $uid))->column('mid');
        //未取系统消息
        if (!empty($tptc)) {
            foreach ($tptc as $k => $v) {
                if (!in_array($v, $tptc1)) {
                    $messdata['uid']    = $uid;
                    $messdata['mid']    = $v;
                    $messdata['status'] = 1;
                    Db::name('readmessage')->insert($messdata);
                }
            }
        }
    }
    public function getUnreadMsg()
    {
        if (!session('userid') || !session('username')) {
            return json(array('code' => 0, 'msg' => '请先登录'));
        } else {
            $uid       = session('userid');
            $sysmsgnum = $selfmsgnum = 0;
            /////读取系统消息开始
            //所有系统消息
            $tptc = Db::name('message')->where(array('touid' => 0))->column('id');
            //所有已取系统消息
            $tptc1 = Db::name('readmessage')->where(array('uid' => $uid))->column('mid');
            //未取系统消息
            if (!empty($tptc)) {
                foreach ($tptc as $k => $v) {
                    if (!in_array($v, $tptc1)) {
                        $messdata['uid']    = $uid;
                        $messdata['mid']    = $v;
                        $messdata['status'] = 1;
                        Db::name('readmessage')->insert($messdata);
                        $sysmsgnum++;
                    }
                }
            }
            //未读系统消息
            $sysmsgnum = Db::name('readmessage')->where(array('uid' => $uid, 'status' => 1))->count();

            //读取个人未读消息
            $selfmsgnum = Db::name('message')->where(array('touid' => $uid, 'status' => 1))->count();
            return json(array('code' => 200, 'msg' => '获取成功', 'count' => $sysmsgnum + $selfmsgnum));
        }
    }
    public function delallmessage()
    {

        if (!session('userid') || !session('username')) {
            return json(array('code' => 0, 'msg' => '请先登录'));
        } else {
            $uid   = session('userid');
            $tptc  = Db::name('message')->where('touid', $uid)->delete();
            $tptc1 = Db::name('readmessage')->where('uid', $uid)->update(['status' => -1]);
            return json(array('code' => 200, 'msg' => '删除成功'));
        }

    }
    public function readsysmessage($id)
    {
        $uid             = session('userid');
        $messdata['uid'] = $uid;
        $messdata['id']  = $id;
        $res             = Db::name('readmessage')->where($messdata)->update(['status' => 2]);
        if ($res) {
            return json(array('code' => 200, 'msg' => '标记已读成功'));
        } else {
            return json(array('code' => 0, 'msg' => '标记失败'));
        }

    }
    public function delsysmessage($id)
    {
        $uid             = session('userid');
        $messdata['uid'] = $uid;
        $messdata['id']  = is_number($id)?is_number($id):'';
        if(!$messdata['id']){
            return json(array('code' => 0, 'msg' => '请求非法'));
        }
        $res             = Db::name('readmessage')->where($messdata)->update(['status' => -1]);
        if ($res) {
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
            return json(array('code' => 0, 'msg' => '删除失败'));
        }

    }
    public function readmessage($id)
    {
        $uid             = session('userid');
        $messdata['touid'] = $uid;
        $messdata['id']  = is_number($id)?is_number($id):'';
        if(!$messdata['id']){
            return json(array('code' => 0, 'msg' => '请求非法'));
        }
        $res             = Db::name('message')->where($messdata)->update(['status' => 2]);
        if ($res) {
            return json(array('code' => 200, 'msg' => '标记已读成功'));
        } else {
            return json(array('code' => 0, 'msg' => '标记失败'));
        }
    }
    public function delmessage($id)
    {
        $msgId  = is_number($id)?is_number($id):'';
        $uid = session('userid');
        $res=Db::name('message')->where(['id'=>$id,'touid'=>$uid])->find();
        if(!$msgId||!$uid||$res){
            return json(array('code' => 0, 'msg' => '请求非法'));
        }
        
        if (Db::name('message')->delete($id)) {
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
}
