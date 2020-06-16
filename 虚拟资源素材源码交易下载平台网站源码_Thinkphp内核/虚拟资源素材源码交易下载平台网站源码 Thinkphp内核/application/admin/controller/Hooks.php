<?php
namespace app\admin\controller;
use app\common\controller\AdminBase;
use think\Config;
use think\Db;
use app\common\model\Hooks as HooksModel;
class Hooks extends AdminBase {
	protected $hooks_model;
	
	
	protected function _initialize()
	{
		parent::_initialize();
		$this->hooks_model = new HooksModel();
	
	}
	public function index(){
		 $auth_group_list = $this->hooks_model->paginate(10);

        return $this->fetch('index', ['auth_group_list' => $auth_group_list]);
	}
	/**
	 * 添加权限组
	 * @return mixed
	 */
	public function add()
	{
		return $this->fetch();
	}
	
	/**
	 * 保存权限组
	 */
	public function save()
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
			$validate_result = $this->validate($data, 'Hooks');
			
			if ($validate_result !== true) {
				// $this->error($validate_result);
				return json(array('code' => 0, 'msg' =>$validate_result));
			} else {
				if ($this->hooks_model->allowField(true)->save($data) !== false) {
					//   $this->success('保存成功');
					return json(array('code' => 200, 'msg' => '添加成功'));
				} else {
					// $this->error('保存失败');
					return json(array('code' => 0, 'msg' => '添加失败'));
				}
			}
		
		}
	}
	
	/**
	 * 编辑权限组
	 * @param $id
	 * @return mixed
	 */
	public function edit($id)
	{
		$auth_group = $this->hooks_model->find($id);
	
		return $this->fetch('edit', ['auth_group' => $auth_group]);
	}
	
	/**
	 * 更新权限组
	 * @param $id
	 */
	public function update($id)
	{
		if ($this->request->isPost()) {
			$data = $this->request->post();
	
			$validate_result = $this->validate($data, 'Hooks');
				
			if ($validate_result !== true) {
				// $this->error($validate_result);
				return json(array('code' => 0, 'msg' =>$validate_result));
			} else {
			if ($this->hooks_model->allowField(true)->save($data, $id) !== false) {
				//   $this->success('更新成功');
				return json(array('code' => 200, 'msg' => '更新成功'));
	
			} else {
				//  $this->error('更新失败');
				return json(array('code' => 0, 'msg' => '更新失败'));
			}
			}
		}
	}

	/**
	 * 删除权限组
	 * @param $id
	 */
	public function delete($id)
	{

		if ($this->hooks_model->destroy($id)) {
			//   $this->success('删除成功');
			return json(array('code' => 200, 'msg' => '删除成功'));
		} else {
			//  $this->error('删除失败');
			return json(array('code' => 0, 'msg' => '删除失败'));
		}
	}





}
