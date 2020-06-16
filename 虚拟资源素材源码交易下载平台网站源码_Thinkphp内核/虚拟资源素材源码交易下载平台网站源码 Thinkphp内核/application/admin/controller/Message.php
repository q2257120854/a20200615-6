<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Db;
use think\Session;
use app\common\model\Message as MessageModel;
class Message extends AdminBase
{   protected $message_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->message_model = new MessageModel();
    }


    public function index()
    {
        $slide_category_list = $this->message_model->order('time desc')->paginate(10);

        return $this->fetch('index', ['slide_category_list' => $slide_category_list]);
    }

    /**
     * 添加分类
     * @return mixed
     */
    public function add()
    {
    	
        return $this->fetch();
    }

    /**
     * 保存分类
     */
    public function save()
    {
    	$admin_id = Session::get('admin_id');
        if ($this->request->isPost()) {
            $data = $this->request->post();
             $data['uid']=$admin_id;

            if ($this->message_model->allowField(true)->save($data)) {
                return json(array('code' => 200, 'msg' => '添加成功'));
            } else {
               return json(array('code' => 0, 'msg' => '添加失败'));
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
        $slide_category = $this->message_model->find($id);

        return $this->fetch('edit', ['slide_category' => $slide_category]);
    }

    /**
     * 更新分类
     * @throws \think\Exception
     */
    public function update()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
         //   $data['uid']=$admin_id;
            if ($this->message_model->allowField(true)->save($data,$data['id']) !== false) {
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
        if ($this->message_model->destroy($id)) {
             return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
           return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }
}