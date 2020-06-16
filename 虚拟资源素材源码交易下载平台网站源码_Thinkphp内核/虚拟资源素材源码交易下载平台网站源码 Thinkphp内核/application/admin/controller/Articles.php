<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Article as ArticleModel;
use app\common\model\Articlecate as ArticlecateModel;
use app\common\model\Upload as UploadModel;

class Articles extends AdminBase
{
    protected $category_model;
    protected $article_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->category_model = new ArticlecateModel();
        $this->article_model  = new ArticleModel();
        $category_level_list  = $this->category_model->catetree();
        $this->assign('category_level_list', $category_level_list);
    }

    public function index()
    {
        $page =  isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $perpage =  isset($_REQUEST['perpage']) ? $_REQUEST['perpage'] : 10;
        $keyword=isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';
        $tid=isset($_REQUEST['tid']) ? trim($_REQUEST['tid']) : 0;
        $open=isset($_REQUEST['open']) ? trim($_REQUEST['open']) : '';
        $settop=isset($_REQUEST['settop']) ? trim($_REQUEST['settop']) : '';
        $choice=isset($_REQUEST['choice']) ? trim($_REQUEST['choice']) : '';
        $startdate=isset($_REQUEST['startdate']) ? trim($_REQUEST['startdate']) : '';
        $enddate=isset($_REQUEST['enddate']) ? trim($_REQUEST['enddate']) : '';
        $map = [];

        if ($keyword) {      
            $map['title|f.keywords'] = ['like', "%{$keyword}%"];
        }
        if ($tid!='') {     
            $map['f.tid'] = $tid;
        }
        
        if ($open!='') {        
            $map['open'] = $open;
        }  
        if ($settop!='') {        
            $map['settop'] = $settop;
        }
        if ($choice!='') {        
            $map['choice'] = $choice;
        } 
        if ($keyword) {      
            $map['title|f.keywords'] = ['like', "%{$keyword}%"];
        }
        if ($startdate) {      
            $map['time'] = ['egt', strtotime($startdate)];
        }
        if ($enddate) {      
            $map['time'] = ['elt', strtotime($enddate.' 23:59:59')];
        }     
      
        $article_list = $this->article_model->alias('f')->join('articlecate c', 'c.id=f.tid')->join('user u', 'u.id=f.uid','left')->field('f.*,u.username,c.name,c.template')->order('f.id desc')->where($map)->paginate($perpage);
        $this->assign(array('choice' => $choice,'settop' => $settop,'open' => $open,'tid' => $tid,'keyword' => $keyword,'startdate' => $startdate,'enddate' => $enddate,'perpage' => $perpage)); 
        return $this->fetch('index', ['article_list' => $article_list]);
    }
    public function add()
    {
        return view();
    }
    public function save()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
            $data['open']=$data['uid']=1;
    
             $data['updatetime']=time();
             $data['time']=strtotime($data['time']);
             if($data['time']>time()){
                $data['open']=0; //定时发布
             }
            
            //开启图片本地化
            if(isset($data['piclocal'])){
                $uplon=new UploadModel();
                $data['content']=$uplon->getCurContent($data['content']);
            }else{
                $data['content']= remove_xss($data['content']);
            }
            if($data['coverpic']==''){
                //获取第一张图为封面图
                 $data['coverpic']=get_coverpic($data['content']);
            }
            if ($this->article_model->allowField(true)->save($data)) {
                if (!empty($data['linkinfo'])) {
                    $data['linkinfo'] = remove_xss($data['linkinfo']);
                    if (!empty($data['score'])) {
                        $data['score']     = 0;
                        $data['otherinfo'] = '';
                    }
                    $res = hook('attachlinksave', array('score' => $data['attachscore'], 'linkinfo' => $data['linkinfo'], 'id' => $this->article_model->id, 'otherinfo' => $data['otherinfo'],'edit' => 0, 'type' => 1));
                }

                 //视频信息
                 if (!empty($data['videolink'])) {
                    $linkinfo = remove_xss($data['videolink']);
                    $res = hook('saveVideo', array('linkinfo' => remove_xss($linkinfo), 'id' => $this->article_model->id, 'edit' => 0, 'type' => 1));
                }

                return json(array('code' => 200, 'msg' => '添加成功'));
            } else {
                return json(array('code' => 0, 'msg' => '添加失败'));
            }

        }
    }

    public function toggle($id, $status, $name)
    {
        if ($this->request->isGet()) {

            if ($this->article_model->where('id', $id)->update([$name => $status]) !== false) {
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '更新成功'));
            } else {
                // $this->error('更新失败');
                return json(array('code' => 0, 'msg' => '更新失败'));
            }
        }

    }
    /**
     * 编辑分类
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $category = new ArticlecateModel();

        $tptcs = $category->catetree();

        $this->assign(array('tptcs' => $tptcs));
        $tptc = $this->article_model->find($id);

        return $this->fetch('edit', ['tptca' => $tptc]);
        //return view();
    }

    /**
     * 更新分类
     * @throws \think\Exception
     */
    public function update()
    {
        if ($this->request->isPost()) {
            $data = $this->request->param();
           
            $data['updatetime']=time();
            $data['time']=strtotime($data['time']);
            if($data['time']>time()){
               $data['open']=0; //定时发布
            }
            if($data['coverpic']==''){
                //获取第一张图为封面图
                 $data['coverpic']=get_coverpic($data['content']);
            }
            // 过滤post数组中的非数据表字段数据
            $res = $this->article_model->allowField(true)->save($data, ['id' => $data['id']]);
            if ($res) {
                if (isset($data['oldlinkinfo'])) {
                    $data['linkinfo'] = remove_xss($data['linkinfo']);
                    if (!empty($data['score'])) {
                        $data['score']     = 0;
                        $data['otherinfo'] = '';
                    }
                    $res = hook('attachlinksave', array('score' => $data['attachscore'], 'linkinfo' => $data['linkinfo'], 'otherinfo' => $data['otherinfo'], 'id' => $data['id'], 'edit' => 1, 'type' => 1));
                }
                 //视频信息
                 if (isset($data['oldvideolink'])) {
                    $linkinfo = remove_xss($data['videolink']);
                    $res = hook('saveVideo', array('linkinfo' => $linkinfo, 'id' => $data['id'], 'edit' => 1, 'type' => 1));
                }
                return json(array('code' => 200, 'msg' => '更新成功'));
            } else {
                return json(array('code' => 0, 'msg' => '更新失败'));
            }
       }
    }

    /**
     * 删除分类
     * @param $id
     * @throws \think\Exception
     */
    public function delete($id)
    {

        $info  = $this->article_model->find($id);
        $score = getpoint($info['uid'], 'articleadd', $id);
        point_note(0 - $score, $info['uid'], 'articledelete', $id);

        if ($this->article_model->destroy($id)) {

            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
    public function alldelete()
    {
        $params = input('post.');
        foreach ($params['ids'] as $k => $v) {
            $info  = $this->article_model->find($v);
            $score = getpoint($info['uid'], 'articleadd', $v);
            point_note(0 - $score, $info['uid'], 'articledelete', $v);

        }

        $ids    = implode(',', $params['ids']);
        $result = $this->article_model->destroy($ids);
        if ($result) {
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }

    public function setClick()
    {
        $params = input('post.');
        foreach ($params['ids'] as $k => $v) {
            $info  = $this->article_model->find($v);
            $score = getpoint($info['uid'], 'articleadd', $v);
            point_note(0 - $score, $info['uid'], 'articledelete', $v);
        }

        $ids    = implode(',', $params['ids']);
        $result = $this->article_model->destroy($ids);
        if ($result) {
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
}
