<?php
namespace app\bbs\controller;

use app\bbs\model\Forum as ForumModel;
use app\common\controller\HomeBase;
use app\common\model\Forumcate as ForumcateModel;
use app\common\model\User as UserModel;
use think\Cache;
use think\Db;
use think\Session;

class Forum extends HomeBase
{
    public function _initialize()
    {
        parent::_initialize();
        if (CBOPEN == 1) {
            $this->redirect(url('index/index/index'));
        }

    }

    public function add()
    {
        $site_config = Cache::get('site_config');

        if (!session('userid') || !session('username')) {
            $this->error('亲！请登录', url('user/login/index'));
        } else {
			            $res = hook('watercheck', array('type' => 1, 'tid' => @input('tid')), true, 'type');
            if ($res && isset($res['code'])) {
                if ($res['code'] == 0) {
                    $this->error($res['msg'], $_SERVER["HTTP_REFERER"], '', 10);
                }
            }
            //检查权限
            $user = new UserModel();
            if (!$user->checkauths(session('userid'))) {
                $this->error('您的账户被限制使用', url('index/index/index'));
            }

            $forum = new ForumModel();
            if (request()->isPost()) {
                if (session('userstatus') != 2 && session('userstatus') != 5 && $site_config['email_sh'] == 0) {
                    return json(array('code' => 0, 'msg' => '您的邮箱还未激活'));
                }

                $data = input('post.');

                if ($data['tid'] == 0) {
                    return json(array('code' => 0, 'msg' => '版块为空'));
                }

                // if ($data['content'] == '') {
                //     return json(array('code' => 0, 'msg' => '内容为空'));
                // }
                //V2.2.1
                $data['add_time'] = $data['time'] = time();

                if ($site_config['forum_sh'] == 0) {
                    $isdeveloper  = Db::name('user')->where('id',session('userid'))->value('developer');
                    $data['open'] = $isdeveloper > 0 ? 1 : 0;
                } else {
                    $data['open'] = 1;
                }

                $data['view']        = 1;
                $data['uid']         = session('userid');
                $data['description'] = mb_substr(remove_xss($data['content']), 0, 200, 'utf-8');

                $data['title'] = strip_tags($data['title']);

                if (mb_strlen($data['title'], 'utf-8') < 5 || mb_strlen($data['title'], 'utf-8') > 40) {
                    return json(array('code' => 0, 'msg' => '标题长度限制在5个到40字之间'));
                }
                $data['content'] = remove_xss($data['content']);

                if (!empty($data['coverpic'])) {
                    $data['coverpic'] = remove_xss($data['coverpic']);
                }
                if ($forum->add($data)) {

                    point_note($site_config['jifen_add'], session('userid'), 'forumadd', $forum->id);
                    //付费阅读！
                    if (!empty($data['viewtype'])) {
                        if ($data['viewtype'] > 0) {
                            $data2['score'] = $data['fee'];
                            $data2['fid']   = $forum->id;
                            $data2['type']  = $data['viewtype'];
                            Db::name('payread')->insert($data2);
                        }
                    }
                    //附件链接信息
                    if (!empty($data['linkinfo'])) {
                        $data['linkinfo'] = remove_xss($data['linkinfo']);
                        if (!empty($data['score'])) {
                            $data['score']     = 0;
                            $data['otherinfo'] = '';
                        }
                        $res = hook('attachlinksave', array('score' => $data['attachscore'], 'linkinfo' => $data['linkinfo'], 'id' => $forum->id, 'otherinfo' => $data['otherinfo'], 'edit' => 0, 'type' => 2));
                    }

                    return json(array('code' => 200, 'msg' => '添加成功'));
                } else {
                    return json(array('code' => 0, 'msg' => '添加失败'));
                }
            }
            $cid       = 0;
            $requesurl = @$_SERVER["HTTP_REFERER"];
            if ($requesurl) {
                //从帖子跳转过来的
                if (strpos($requesurl, 'cate') !== false) {
                    preg_match('/cate\/(.*).html?/', $requesurl, $match);
                    $cid = db('forumcate')->where('alias', $match[1])->value('id');
                } else if (strpos($requesurl, "thread") !== false) {
                    preg_match('/thread\/(.*).html?/', $requesurl, $match);
                    $cid = db('forum')->where('id', $match[1])->value('tid');
                }
            }

            $category = Db::name('forumcate');
            $tptc     = $category->where(array('show' => 1))->select();
            $this->assign('cid', $cid);
            $this->assign('tptc', $tptc);

            $this->assign('title', '发布帖子');

            return view('add');
        }
    }
    public function edit()
    {
        $site_config = Cache::get('site_config');
        if (!session('userid') || !session('username')) {
            $this->error('亲！请登录', url('user/login/index'));
        } else {
            $uid   = session('userid');
           
            $id = is_number(input('id'))?input('id'):'';
            session('editid', $id);
            $forum = new ForumModel();
            $a     = $forum->find($id);
            //检查权限
            $user = new UserModel();
            if (!$id||!$user->checkauths(session('userid'))) {
                $this->error('您的账户被限制使用', url('index/index/index'));
            }
            //检测是否是版主
            $catemodel = new ForumcateModel();
            $res       = $catemodel->isbanzhu($uid, $a['tid']);
            
            $wcres     = hook('watercheck', array('type' => 1, 'id' => input('id')), true, 'type');
            if ($wcres && isset($wcres['code'])) {
                if ($wcres['code'] == 0) {
                    $this->error($wcres['msg'], $_SERVER["HTTP_REFERER"], '', 10);
                }
            }
            

           
           

            if ((empty($id) || $a == null || $a['uid'] != $uid) && !$res) {
                $this->error('亲！您迷路了');
            } else {
                if (request()->isPost()) {

                    $data       = input('post.');
                    $data['id'] = session('editid');

                    $tidarr = Db::name('forumcate')->column('id');
                    if ($data['tid'] == 0) {
                        return json(array('code' => 0, 'msg' => '版块为空'));
                    }
                    if (!inArray($data['tid'], $tidarr)) {
                        return json(array('code' => 0, 'msg' => '版块不存在'));
                    }
                    session('editid', null);
                    // if ($data['content'] == '') {
                    //     return json(array('code' => 0, 'msg' => '内容为空'));
                    // }
                    $data['time']        = time();
                    $data['description'] = mb_substr(remove_xss($data['content']), 0, 200, 'utf-8');
                    $data['title']       = strip_tags($data['title']);
                    $data['title']       = hook('trigtitle', array('title' => $data['title'], 'id' => $data['id']), true, 'title');

                    $data['content'] = remove_xss($data['content']);
                    if (mb_strlen($data['title'], 'utf-8') < 5 || mb_strlen($data['title'], 'utf-8') > 40) {
                        return json(array('code' => 0, 'msg' => '标题长度限制在5个到40字之间'));
                    }

                    if ($forum->edit($data)) {

                        //检查付费阅读
                       
                        if($data['oldviewtype']>0){
                             //旧的付费阅读有
                            $map['fid'] = $data['id']; 
                            $map['onwhere'] = 'bbs'; 
                            //新的没有
                            if($data['viewtype']==0){
                                //删除旧的规则
                                Db::name('payread')->where($map)->delete();
                            }else{
                               
                                Db::name('payread')->where($map)->update(['score' => $data['score'], 'type' => $data['viewtype']]);
                         
                            }


                        }else{

                            //新的有
                            if($data['viewtype']>0){
                                $data1['score'] = $data['score'];
                                $data1['fid'] = $data['id'];
                                $data1['onwhere'] ='bbs';
                                $data1['type'] = $data['viewtype'];
                                Db::name('payread')->insert($data1);   
                            }

                        }
                       
                        //附件链接信息
                        if (isset($data['oldlinkinfo'])) {
                            $data['linkinfo'] = remove_xss($data['linkinfo']);
                            if (!empty($data['score'])) {
                                $data['score']     = 0;
                                $data['otherinfo'] = '';
                            }
                            $res = hook('attachlinksave', array('score' => $data['attachscore'], 'linkinfo' => $data['linkinfo'], 'otherinfo' => $data['otherinfo'], 'id' => $data['id'], 'edit' => 1, 'type' => 2));
                        }
                        return json(array('code' => 200, 'msg' => '修改成功'));
                    } else {
                        return json(array('code' => 0, 'msg' => '主体内容未做更改！'));
                    }
                }

                $category      = Db::name('forumcate');
                $tptc          = $forum->find($id);
                $tptc['title'] = strip_tags($tptc['title']);
                $tptcs         = $category->where(array('show' => 1))->select();
                $this->assign(array('tptcs' => $tptcs, 'tptc' => $tptc));
             
                $this->assign('title', '编辑帖子');
                //判断付费阅读
                $viewtype=$score=0;
                //判断是不是付费阅读内容
                $map['onwhere'] = 'bbs';
                $map['fid'] = $id;
                $viewfee = Db::name('payread')->where($map)->find();
                
                if ($viewfee) {
                    $viewtype=$viewfee['type'];
                    $score=$viewfee['score'];
                }
                $this->assign('viewtype', $viewtype);
                $this->assign('score', $score);
                return view();
            }

        }

    }

    //付费阅读
    public function payread()
    {
        $uid=session('userid');
        $id = is_number(input('fid'))?input('fid'):'';
        if(!$id||!$uid){
            return array('code' => 0, 'msg' => '没有权限');
        }
        //查询付费阅读
        $map['onwhere'] = 'bbs';
        $map['fid'] = $id;
        $res=Db::name('payread')->alias('p')->join('forum f','f.id=p.fid')->field('f.uid,p.id as pid,p.score')->where($map)->limit(1)->select();
        $score=$res[0]['score'];
        $zuid=$res[0]['uid'];
        $pid=$res[0]['pid'];

        if ($uid != $zuid) {
            $point = Db::name('user')->where('id', $uid)->value('point');
            if ($point < $score && $score > 0) {
                $site_config = Cache::get('site_config');
                if (empty($site_config['jifen_name'])) {
                    $site_config['jifen_name'] = '积分';
                }
                return array('code' => 0, 'msg' => $site_config['jifen_name'] . '不足');
            } else {

                if ($score > 0) {
                    point_note(0 - $score, $uid, 'payreadforum');
                    point_note($score, $zuid, 'payreadforum');
                }
                $data['uid'] = $uid;
                $data['score'] = $score;
                $data['pid'] = $pid;
                Db::name('payreadlog')->insert($data);
                return array('code' => 200, 'msg' => '付费成功');

            }

        } else {
            return array('code' => 0, 'msg' => '不要试图搞破坏哦');
        }
    }
    public function setstatus()
    {
        $data = $this->request->param();
        $uid  = session('userid');
        $id   = is_number(input('id')) ? input('id') : 0;
        $info = Db::name('forum')->find($id);
        if (!$uid || !$id || !$info) {
            $this->error('你迷路了');
        } else {
            //检测是否是版主
            $catemodel = new ForumcateModel();
            $res       = $catemodel->isbanzhu($uid, $info['tid']);
            if (!$res) {
                $this->error('你不是版主');
            }
            if (Db::name('forum')->where('id', $id)->setField($data['field'], $data['value'])) {
                $info    = Db::name('forum')->where('id', $id)->find();
                $content = strip_tags($info['title']);
                $content = '<font color="' . $info['yanse'] . '">' . $content . '</font>';
                if ($info['jiacu'] == 1) {
                    $content = '<b>' . $content . '</b>';
                }
                Db::name('forum')->where('id', $id)->setField('title', $content);
                $this->success('操作成功');
            } else {
                $this->error('操作失败');
            }
        }
    }
    public function delete()
    {
        $uid = session('userid');
        $id  = is_number(input('id')) ? input('id') : 0;

        $forum_model = new ForumModel();

        $info = $forum_model->find($id);
        if ($uid > 0 && $id && $info) {
            //检测是否是版主
            $catemodel = new ForumcateModel();
            $res       = $catemodel->isbanzhu($uid, $info['tid']);
            if ($res) {

                if ($forum_model->destroy($id)) {
                    $this->success('操作成功');
                } else {
                    $this->error('操作失败');
                }

            } else {
                $this->error('没有权限');
            }

        } else {
            $this->error('你迷路了');
        }

    }

    public function delcomment()
    {

        $uid = session('userid');
        $id  = is_number(input('id')) ? input('id') : 0;
        $cid = is_number(input('cid')) ? input('cid') : 0;

        if ($uid > 0 && $id && $cid) {

            //检测是不是自己的
            $zuid = db('comment')->where('id', $id)->value('uid');
            //检测是否是版主
            $res = 0;
            if ($zuid == $uid) {
                $res = 1;
            } else {
                $catemodel = new ForumcateModel();
                $res       = $catemodel->isbanzhu($uid, $cid);
            }

            if ($res) {

                if (db('comment')->delete($id)) {
                    return json(array('code' => 200, 'msg' => '删除成功'));
                } else {
                    return json(array('code' => 0, 'msg' => '删除失败'));
                }

            } else {
                return json(array('code' => 0, 'msg' => '没有权限'));
            }

        } else {
            return json(array('code' => 0, 'msg' => '你迷路了'));
        }
    }
   
    public function jubao(){
          //帖子还是评论
          $uid = session('userid');
          $id  = is_number(input('id')) ? input('id') : 0;
          $type = is_number(input('type')) ? input('type') : 0;
          $table='forum';
          
          $url_anchor='';
          $str='帖子被举报了';
          $fid=$id;
          if($type==2){
            $table='comment';
            $str='评论被举报了';
            $url_anchor='#tpt'.$id;
            //所属帖子
            $fid=Db::name('comment')->where('id',$id)->value('fid');
          } 
          if(!$uid||!$id||!$type){
            return json(array('code' => 0, 'msg' => '你迷路了'));
          }
                $data['uid'] = $uid;
                $data['sid'] = $id;
                $data['type'] = $type;

                //判断是否举报过
                $res=Db::name('jubao')->where($data)->find();
                if($res){
                    return json(array('code' => 0, 'msg' => '您已经举报过了，请等待管理员审核'));
                }

                $data['time'] = time(); 
                $data['content'] = input('str');

                Db::name('jubao')->insert($data);
                Db::name($table)->where('id',$id)->setInc('jubao');
                //该帖子内容
                $site_config = Cache::get('site_config');
                if (isset($site_config['smtp_cs'])) {
                   
                    //发邮件给站长
                $url = (is_HTTPS() ? 'https://' : 'http://' ). $_SERVER['HTTP_HOST'] . url('bbs/index/thread',array('id'=>$fid)).$url_anchor;
                send_mail_local($site_config['smtp_cs'], $str,  '<br />去看看吧' . $url);
                }     
                return array('code' => 200, 'msg' => '举报成功');
          
    }
}
