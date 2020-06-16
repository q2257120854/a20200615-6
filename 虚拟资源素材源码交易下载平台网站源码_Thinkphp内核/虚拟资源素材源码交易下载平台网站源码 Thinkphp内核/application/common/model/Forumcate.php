<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Forumcate extends Model
{
    protected $insert = ['time'];

    public function add($data)
    {
        $result = $this->isUpdate(false)->allowField(true)->save($data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function edit($data)
    {
        $result = $this->isUpdate(true)->allowField(true)->save($data);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }
    public function catetree()
    {
        $tptc = $this->order('id ASC')->select();

        return $this->sort($tptc);
    }
    public function sort($data, $tid = 0, $level = 1)
    {
        static $arr = array();

        foreach ($data as $v) {

            if ($v['tid'] == $tid) {

                $v['level'] = $level;
                $arr[]      = $v;
                $this->sort($data, $v['id'], $level + 1);
            }
        }

        return $arr;
    }

    public function getchilrenid($cateid)
    {
        $cates = $this->select();
        return $this->_getchilrenid($cates, $cateid);
    }
    public function _getchilrenid($cates, $cateid)
    {
        static $arr = array();
        foreach ($cates as $k => $v) {
            if ($v['tid'] == $cateid) {
                $arr[] = $v['id'];
                $this->_getchilrenid($cates, $v['id']);
            }
        }
        return $arr;
    }

    public function getparentid($cateid)
    {
        static $arr = array();
        $tid        = $this->where('id', $cateid)->value('tid');
        if ($tid != 0) {
            $arr[] = $tid;
            $this->getparentid($tid);
        }
        return $arr;
    }

//判断是不是版主
    public function isbanzhu($uid, $tid)
    {

        $pidarr    = $this->getparentid($tid);
        array_push($pidarr, $tid);
        foreach ($pidarr as $k => $v) {
            $map['onwhere']='bbs';
            $map['cid']=['in','0,'.$v];
            $uids = Db::name('banzhu')->where($map)->column('uids');
            if (!empty($uids)) {
                $uidss=join(',',$uids);
                $userarr = explode(',', $uidss);
                if (in_array($uid, $userarr)) {
					return true;
                }
            }
        }
        return false;    
    }

    /**
     * 自动生成时间
     * @return bool|string
     */
    protected function setTimeAttr()
    {
        return time();
    }

}
