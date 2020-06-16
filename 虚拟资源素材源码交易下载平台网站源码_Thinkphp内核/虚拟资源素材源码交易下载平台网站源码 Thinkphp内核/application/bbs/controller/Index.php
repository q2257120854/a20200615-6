<?php
namespace app\bbs\controller;

use app\common\controller\HomeBase;
use app\common\model\Forumcate as ForumcateModel;
use think\Cache;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;

class Index extends HomeBase
{
    protected $site_config;
    public function _initialize()
    {
        parent::_initialize();
        $this->site_config = Cache::get('site_config');
        if (CBOPEN == 1) {
            $this->redirect(url('index/index/index'));
        }

    }

    public function index()
    {
        $forum        = Db::name('forum');
        $open['open'] = 1;

        //热评贴子
        $tptch = $forum->field('id,title,reply')->where($open)->order('reply desc')->limit($this->site_config['b_home_hot'])->select();
        $this->assign('tptch', $tptch);

        //发帖Top 12
        $tptm = Db::name('forum')->alias('f')->join('user u', 'f.uid=u.id')->field('u.*,count(*) as forumnum')->group('f.uid')->order('forumnum desc')->limit($this->site_config['b_home_phb'])->select();
        $this->assign('tptm', $tptm);

        $forum              = Db::name('forum');
        $open['open']       = 1;
        $settop['settop']   = 1;
        $nosettop['settop'] = 0;
        $tptc               = $forum->alias('f')->join('forumcate c', 'c.id=f.tid')->join('user m', 'm.id=f.uid', 'left')->field('f.*,c.id as cid,m.id as userid,m.userhead,m.attestation,m.username,c.name')->where($open)->where($settop)->order('f.id desc')->limit($this->site_config['b_home_settop'])->select();
        $this->assign('tptc', $tptc);
        $tptcs = $forum->alias('f')->join('forumcate c', 'c.id=f.tid')->join('user m', 'm.id=f.uid', 'left')->field('f.*,c.id as cid,m.id as userid,m.userhead,m.attestation,m.username,c.name')->where($open)->where($nosettop)->order('f.time desc')->paginate($this->site_config['b_home_main']);
        $this->assign('tptcs', $tptcs);
         //友情链接
         $superlinks = Db::name('superlinks')->where("status = 1 and onwhere ='default'")->order('level desc,id asc')->select();
         foreach($superlinks as $key=>$val){
           if($val['type'] == 1){
               $superlinks[$key]['savepath'] = get_cover($val['cover_id'],'savepath');
           }
         }
         $this->assign('superlinks', $superlinks);
        return view();
    }

    public function cate()
    {
        $cate = input('cate_alias');
        //  echo $cate;die();
        $types = input('type');
        session('forumcate_alias', $cate);
        if (empty($cate)) {
            return $this->error('亲！你迷路了', 'bbs/index/index');
        } else {
            $forum = Db::name('forum');

            $category = Db::name('forumcate');

            if ($cate == 'all') {
                $children = implode(',', $category->column('id'));

                $name = '全部';
            } else {
                $c = $category->where('alias', $cate)->find();
                $this->assign('cateinfo', $c);
                if ($c) {
                    $id   = $c['id'];
                    $name = $c['name'];

                    $catemodel = new ForumcateModel();
                    $children  = $catemodel->getchilrenid($id);
                    array_push($children, $id);
                } else {
                    $this->error('亲！你迷路了！', 'bbs/index/index');
                }

            }
            $forum        = Db::name('forum');
            $open['open'] = 1;
            $num          = $this->site_config['b_list_main'];
            switch ($types) {
                case 'newreply':
                    $tptc = $forum->alias('f')->join('forumcate c', 'c.id=f.tid')->join('comment t', 'f.id=t.fid')->join('user m', 'm.id=t.uid')->field('f.*,f.time as ftime,c.id as cid,t.time,m.id as userid,m.userhead,m.attestation,m.username,c.name')->where('f.tid', 'in', $children)->where('f.open', 1)->group('f.id')->order('t.time desc,f.id desc')->paginate($num);

                    break;
                case 'hot':
                    $tptc = $forum->alias('f')->join('forumcate c', 'c.id=f.tid')->join('user m', 'm.id=f.uid')->field('f.*,c.id as cid,m.id as userid,m.userhead,m.attestation,m.username,c.name')->where('f.tid', 'in', $children)->where('f.open', 1)->order('f.reply desc,f.id desc')->paginate($num);

                    break;
                case 'choice':
                    // $choice['choice'] = 1;
                    $tptc = $forum->alias('f')->join('forumcate c', 'c.id=f.tid')->join('user m', 'm.id=f.uid')->field('f.*,c.id as cid,m.id as userid,m.userhead,m.attestation,m.username,c.name')->where('f.tid', 'in', $children)->where('f.open', 1)->where('f.choice', 1)->order('f.settop desc,f.id desc')->paginate($num);

                    break;
                default:

                    $tptc = $forum->alias('f')->join('forumcate c', 'c.id=f.tid')->join('user m', 'm.id=f.uid')->field('f.*,c.id as cid,c.alias as alias,m.id as userid,m.attestation,m.userhead,m.username,m.grades,c.name')->where('f.tid', 'in', $children)->where('f.open', 1)->order('f.settop desc,f.id desc')->paginate($num);
            }
            $tptch = $forum->field('id,title,reply')->where($open)->where('tid', 'in', $children)->order('reply desc')->limit($this->site_config['b_list_hot'])->select();
            $this->assign('tptch', $tptch);
            $this->assign('tptcs', $tptc);
            $this->assign('cate_alias', $cate);
            $this->assign('type', $types);
            $this->assign('name', $name);
            return view();

        }
    }

    public function search()
    {
        $ks  = input('ks');
        $kss = urldecode(input('ks'));
        if (empty($ks)) {
            return $this->error('亲！你迷路了', 'bbs/index/index');
        } else {
            $forum        = Db::name('forum');
            $open['open'] = 1;
            // if (is_numeric($kss)) {
            //     $map['f.id'] = $kss;
            // } else {
                $map['f.title|f.keywords|f.content'] = ['like', "%{$kss}%"];
            //}

            $tptc = $forum->alias('f')->join('forumcate c', 'c.id=f.tid')->join('user m', 'm.id=f.uid')->field('f.*,c.id as cid,m.id as userid,m.userhead,m.username,c.name')->order('f.id desc')->where($open)->where($map)->paginate(8, false, $config = ['query' => array('ks' => $ks)]);

            $tptch = $forum->field('id,title,reply')->where($open)->order('reply desc')->limit(15)->select();
            $this->assign('tptch', $tptch);
            // //发帖Top 12
            $tptm = Db::name('forum')->alias('f')->join('user u', 'f.uid=u.id')->field('u.*,count(*) as forumnum')->group('f.uid')->order('forumnum desc')->limit(12)->select();
            $this->assign('tptm', $tptm);
            // //热评帖子

            $this->assign('keyword', $ks);
            $this->assign('tptcss', $tptc);
            return view();
        }
    }

    public function errors()
    {
        return view();
    }

    public function thread()
    {
        $id = is_number(input('id')) ? input('id') : '';
        if (empty($id)) {
            return $this->error('亲！你迷路了', 'bbs/index/index');
        } else {
            $forum = Db::name('forum');
            $a     = $forum->where('open', 1)->where("id = {$id}")->find();
            if ($a) {
                $uid = session('userid');
                $forum->where("id = {$id}")->setInc('view', 1);
                $t = $forum->alias('f')->join('forumcate c', 'c.id=f.tid')->join('user m', 'm.id=f.uid', 'left')->field('f.*,m.username,m.status,c.id as cid,c.alias,c.name,m.id as userid,m.grades,m.point,m.userhead,m.attestation')->find($id);              
			   $this->assign('t', $t);
                if ($t['keywords'] != '') {
                    $keywordarr = explode(',', $t['keywords']);
                    $this->assign('keywordarr', $keywordarr);
                }
                $comment['uid'] = array('not in', Db::name('user')->where('status', 'elt', 0)->column('id'));
$viewtype=$viewscore=0;
                if ($t['status'] <= 0) {
                    $content = '<font color="#FF5722">该用户已被禁用或禁言</font>';

                } else {
                    $content = $t['content'];
                    
                    if ($uid != $t['userid']) {
                        //判断是不是付费阅读内容
                        $map['onwhere'] = 'bbs';
                        $map['fid'] = $id;
                        $viewfee = Db::name('payread')->where($map)->find();
                        if ($viewfee) {
                           
                            $count = 0;
                            if ($uid) {
                             
                                $map1['fid']     = $id;
                                $map1['uid']     = $uid;
                                //回复可见
                                if ($viewfee['type'] == 2) {
                                    $count = Db::name('comment')->where($map1)->count('id');
                                } else {
                                    $count = Db::name('payreadlog')->where(array('pid' => $viewfee['id'], 'uid' => $uid))->count('id');
                                }
                            }

                            if ($count == 0) {
                                $viewtype=$viewfee['type'];
                                $viewscore=$viewfee['score'];
                           //去除html标签
                                $content = preg_replace('/\s/', '', clearcontent($content));
                                $content = '<p>' . mb_substr($content, 0, round(mb_strlen($content, 'UTF8') / 2)) . '<p>';
                            }
                        }

                    }
                }
                $this->assign('viewtype', $viewtype);
                $this->assign('viewscore', $viewscore);
                $order         = input('see_desc') ? 'c.id desc' : 'c.id asc';
                $onlylz['uid'] = input('see_lz') ? $a['uid'] : array('>', 0);
                $tptc          = Db::name('comment')->alias('c')->join('user m', 'm.id=c.uid')->where("fid = {$id}")->where($comment)->where($onlylz)->order($order)->field('c.*,m.id as userid,m.grades,m.attestation,m.point,m.userhead,m.username')->paginate($this->site_config['b_view_reply'], false, ['query' => Request::instance()->param()]);

                $this->assign('tptc', $tptc);
                $tptch = Db::name('forum')->field('id,title,reply')->where('open', 1)->order('reply desc')->limit($this->site_config['b_view_hot'])->select();
                $this->assign('tptch', $tptch);

                $this->assign('content', $content);

                //查询当前用户的收藏点赞记录
                $user       = Db::name('user')->where('id', $t['uid'])->find();
                $self       = 0;
                $hasguanzhu = 0;
                $haszan     = 0;
                $hasshang   = 0;
                $hascollect = 0;
                if ($uid == $t['uid']) {
                    $self = 1;
                }
                $guanzhu = Db::name('collect')->where(['uid' => $uid, 'sid' => $t['uid'], 'type' => 0])->find();
                $zan     = Db::name('zan')->where(['uid' => $uid, 'sid' => $id, 'type' => 1])->find();
                $shang   = Db::name('point_note')->where(['controller' => 'tipauthor', 'uid' => $uid, 'pointid' => $id])->count();
                $collect = Db::name('collect')->where(array('uid' => $uid, 'sid' => $id, 'type' => 1))->find();

                if ($guanzhu) {
                    $hasguanzhu = 1;
                }

                if ($zan) {
                    $haszan = 1;
                }

                if ($collect) {
                    $hascollect = 1;
                }
                if ($shang) {
                    $hasshang = $shang;
                }
                $threadext['guanzhu'] = $hasguanzhu;
                $threadext['shang']   = $hasshang;
                $threadext['zan']     = $haszan;
                $threadext['collect'] = $hascollect;
                $threadext['self']    = $self;

                $this->assign('user', $user);

                $this->assign('threadext', $threadext);

                //查询当前用户点赞过的评论
                $commentzan = array();
                if ($uid) {
                    $commentzan = Db::name('zan')->where(array('uid' => $uid, 'type' => 2))->column('sid');
                }
                $this->assign('commentzan', $commentzan);

                //查询是否为版主
                $isbanzhu = 0;
                if (!empty($uid)) {
                    $catemodel = new ForumcateModel();
                    $res       = $catemodel->isbanzhu($uid, $t['tid']);
                    if ($res) {
                        $isbanzhu = 1;
                    }
                }
                $this->assign('isbanzhu', $isbanzhu);
                return view();
            } else {
                return $this->error('亲！你迷路了', 'bbs/index/index');
            }
        }
    }

}
