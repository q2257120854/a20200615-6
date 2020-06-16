<?php
namespace app\admin\controller;

use app\common\model\Superlinks as SuperlinksModel;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;

/**
 * 友情链接管理
 * Class AdminUser
 * @package app\admin\controller
 */
class Superlinks extends AdminBase
{
    protected $model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->model = new SuperlinksModel();
    
    
    }

    /**
     * 友情链接管理
     * @param string $keyword
     * @param int    $page
     * @return mixed
     */
    public function index($keyword = '', $page = 1)
    {
        $page =  isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $perpage =  isset($_REQUEST['perpage']) ? $_REQUEST['perpage'] : 10;
       
        $status=isset($_REQUEST['status']) ? trim($_REQUEST['status']) : 0;
        $onwhere=isset($_REQUEST['onwhere']) ? trim($_REQUEST['onwhere']) : 0;
        $keyword=isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';

        $map = [];
        if ($keyword) {
        	  $map['title|link|contacts'] = ['like', "%{$keyword}%"];
        }
        if ($onwhere) {
        	
        	  $map['onwhere'] =$onwhere;
        }
        if ($status) {
        	
            $map['status'] =$status;
      }
        
        $list = $this->model->where($map)->order('id DESC')->paginate(10);
     
        $this->assign(array('status' => $status,'onwhere' => $onwhere,'keyword' => $keyword,'perpage' => $perpage)); 
      
        return $this->fetch('index', ['list' => $list, 'keyword' => $keyword]);
    }

    public function toggle($id, $status, $name)
    {
        if ($this->request->isGet()) {

            if ($this->model->where('id', $id)->update([$name => $status]) !== false) {
                //  $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '更新成功'));
            } else {
                // $this->error('更新失败');
                return json(array('code' => 0, 'msg' => '更新失败'));
            }
        }

    }
    /**
     * 添加友情链接
     * @return mixed
     */
    public function add()
    {
        return $this->fetch();
    }

    /**
     * 保存友情链接
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
       
            $data['status']=1;
            
                if ($this->model->allowField(true)->save($data)) {
                    //$this->success('保存成功');
                    return json(array('code' => 200, 'msg' => '添加成功'));
                } else {
                   // $this->error('保存失败');
                    return json(array('code' => 0, 'msg' => '添加失败'));
                }
            
        }
    }

    /**
     * 编辑友情链接
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $info = $this->model->find($id);

        return $this->fetch('edit', ['info' => $info]);
    }

    /**
     * 更新友情链接
     * @param $id
     */
    public function update()
    {

        if ($this->request->isPost()) {
            $data            = $this->request->param();
            if ($this->model->allowField(true)->save($data, ['id' => $data['id']])) {
               // $this->success('保存成功');
                return json(array('code' => 200, 'msg' => '修改成功'));
            } else {
               // $this->error('保存失败');
                return json(array('code' => 0, 'msg' => '修改失败'));
            }
        }
    }

    /**
     * 删除友情链接
     * @param $id
     */
    public function delete($id)
    {
        if ($this->model->destroy($id)) {
            //$this->success('删除成功');
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
           // $this->error('删除失败');
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
}