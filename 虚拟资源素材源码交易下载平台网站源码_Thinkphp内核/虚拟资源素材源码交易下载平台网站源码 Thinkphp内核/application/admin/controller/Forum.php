<?php
namespace app\admin\controller;
use app\common\model\Forum as ForumModel;
use app\common\model\Forumcate as ForumcateModel;
use app\common\controller\AdminBase;
use think\Db;


class Forum extends AdminBase
{
    protected $forum_model;
    protected $category_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->category_model = new ForumcateModel();
        $this->forum_model = new ForumModel();
        
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
        $memo=isset($_REQUEST['memo']) ? trim($_REQUEST['memo']) : '';
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
        if ($memo!='') {        
            $map['memo'] = $memo;
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
        $user_list = $this->forum_model->alias('f')->join('forumcate c', 'c.id=f.tid')->join('user u', 'u.id=f.uid','left')->field('f.*,u.username,c.id as cid,c.name,c.alias')->order('f.id desc')->where($map)->paginate(10);
        $this->assign(array('choice' => $choice,'settop' => $settop,'memo' => $memo,'open' => $open,'tid' => $tid,'keyword' => $keyword,'startdate' => $startdate,'enddate' => $enddate,'perpage' => $perpage)); 
      
        return $this->fetch('index', ['user_list' => $user_list]);
    }

    public function toggle($id,$status,$name)
    {
    	if ($this->request->isGet()) {
    
    
    		 
    		 
    		if ($this->forum_model->where('id', $id)->update([$name=>$status]) !== false) {
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
    	$category = new ForumcateModel();
    	
    	$tptcs = $category->catetree();
    	
    	$this->assign(array('tptcs' => $tptcs));
        $slide_category = $this->forum_model->find($id);

        return $this->fetch('edit', ['slide_category' => $slide_category]);
    }

    /**
     * 更新
     * @throws \think\Exception
     */
    public function update()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
           $data['content']= remove_xss($data['content']);
           $data['title']=  $data['title'];
            if ($this->forum_model->allowField(true)->save($data,$data['id']) !== false) {
                return json(array('code' =>200, 'msg' => '更新成功'));
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
    	$info=$this->forum_model->find($id);
    	$score=getpoint($info['uid'],'forumadd',$id);
    	point_note(0-$score,$info['uid'],'forumdelete',$id);
    	
    	
        if ($this->forum_model->destroy($id)) {
        	
        	
        	
            	return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
           return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
    public function alldelete()
    {
    	$params = input('post.');
    	foreach ($params['ids'] as $k =>$v){
    		$info=$this->forum_model->find($v);
    	$score=getpoint($info['uid'],'forumadd',$v);
    	point_note(0-$score,$info['uid'],'forumdelete',$v);	
    		
    	}
    	
    	
    	$ids = implode(',', $params['ids']);
    	  $result = $this->forum_model->destroy($ids);
    	  if ($result) {
    	  	return json(array('code' => 200, 'msg' => '删除成功'));
    	  } else {
    	  	return json(array('code' => 0, 'msg' => '删除失败'));
    	  }
   }
}