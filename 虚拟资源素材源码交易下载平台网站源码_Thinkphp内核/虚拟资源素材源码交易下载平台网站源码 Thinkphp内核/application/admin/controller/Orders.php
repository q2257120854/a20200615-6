<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\User as UserModel;
use think\Db;

class Orders extends AdminBase
{
    protected function _initialize()
    {
        parent::_initialize();

    }
    public function index($keyword = '', $page = 1)
    {
        $map       = [];
        $usermodel = new UserModel();

        if ($keyword) {
            $map['o.uid'] = 0;
            session('orderskeyword', $keyword);
            $mapn['username'] = ['like', "%{$keyword}%"];
            $idarr            = $usermodel->where($mapn)->column('id');
            if (!empty($idarr)) {
                $map['o.uid'] = array('in', $idarr);
            }
        } else {

            if (session('orderskeyword') != '' && $page > 1) {
                $map['o.uid']     = 0;
                $mapn['username'] = ['like', "%" . session('orderskeyword') . "%"];
                $idarr            = $usermodel->where($mapn)->column('id');
                if (!empty($idarr)) {
                    $map['o.uid'] = array('in', $idarr);
                }
            } else {
                session('orderskeyword', null);
            }
        }

        $tptc = Db::name('orders')->where($map)->alias('o')->join('user u', 'u.id=o.uid')->field('o.*,u.username')->order('o.add_time desc')->paginate(10);
        $this->assign('tptc', $tptc);
        return view();
    }
    public function deluseless()
    {
        $map['status']   = 0;
        $map['add_time'] = ['lt', strtotime("-1 hour")];
        $delete          = Db::name('orders')->where($map)->delete();
        if ($delete) {
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
            return json(array('code' => 0, 'msg' => '没有需要删除的订单'));
        }
    }
}
