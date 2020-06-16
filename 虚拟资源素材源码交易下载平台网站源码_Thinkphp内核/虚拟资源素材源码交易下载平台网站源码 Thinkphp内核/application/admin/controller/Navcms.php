<?php
namespace app\admin\controller;

use app\common\model\NavCms as NavModel;
use app\common\model\Articlecate as ArticlecateModel;
use app\common\controller\AdminBase;
use think\Db;

/**
 * 导航管理
 * Class Nav
 * @package app\admin\controller
 */
class Navcms extends AdminBase
{

    protected $nav_model;
    protected $nav_list;

    protected function _initialize()
    {
        parent::_initialize();
        $this->category_model = new ArticlecateModel();
        $category_level_list  = $this->category_model->catetree();
        $this->assign('category_level_list', $category_level_list);
       $this->nav_model=new NavModel();
        $nav2  = (new NavModel())->catetree(2);
        $nav0  = (new NavModel())->catetree(0);
        $nav1  = (new NavModel())->catetree(1);
        $this->nav_list= array( $nav0 , $nav1 , $nav2 );
          
        $this->assign('nav_level_list',$this->nav_list);
    }

    /**
     * 导航管理
     * @return mixed
     */
    public function index()
    {
        return $this->fetch();
    }

    /**
     * 添加导航
     * @param string $pid
     * @return mixed
     */
    public function add($pid = '')
    {
        return $this->fetch('add');
    }

    /**
     * 保存导航
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Nav');
     
            if ($validate_result !== true) {
                $this->error($validate_result);
            } else {
                if ($this->nav_model->allowField(true)->save($data)) {
                   return json(array('code' => 200, 'msg' => '添加成功'));
                } else {
                  return json(array('code' => 0, 'msg' => '添加失败'));
                }
            }
        }
    }

    /**
     * 编辑导航
     * @param $id
     * @return mixed
     */
    public function edit($id)
    {
        $nav = $this->nav_model->find($id);

        return $this->fetch('edit', ['nav' => $nav,'nav_level'=>$this->nav_list[$nav['tid']]]);
    }

    /**
     * 更新导航
     * @param $id
     */
    public function update($id)
    {
        if ($this->request->isPost()) {
            $data            = $this->request->post();
            $validate_result = $this->validate($data, 'Nav');

            if ($validate_result !== true) {
              //  $this->error($validate_result);
                return json(array('code' => 0, 'msg' => $validate_result));
            } else {
                if ($this->nav_model->allowField(true)->save($data, $id) !== false) {
                   // $this->success('更新成功');
                    return json(array('code' => 200, 'msg' => '更新成功'));
                } else {
                   // $this->error('更新失败');
                    return json(array('code' => 0, 'msg' => '更新失败'));
                }
            }
        }
    }
    public function updatestatus($id,$status)
    {
    	if ($this->request->isGet()) {
    
    
    		 
    		 
    		if ($this->nav_model->where('id', $id)->update(['status' =>$status]) !== false) {
    			//  $this->success('更新成功');
    			return json(array('code' => 200, 'msg' => '更新成功'));
    		} else {
    			// $this->error('更新失败');
    			return json(array('code' => 0, 'msg' => '更新失败'));
    		}
    	}
    	 
    }
    /**
     * 删除导航
     * @param $id
     */
    public function delete($id)
    {
        if ($this->nav_model->destroy($id)) {
            //$this->success('删除成功');
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
        	return json(array('code' => 0, 'msg' => '删除失败'));
           // $this->error('删除失败');
        }
    }
}