<?php
namespace app\admin\controller;

use app\common\model\AuthGroup as AuthGroupModel;
use app\common\model\AuthRule as AuthRuleModel;
use app\common\controller\AdminBase;

/**
 * 权限组
 * Class AuthGroup
 * @package app\admin\controller
 */
class AuthGroup extends AdminBase
{
    protected $auth_group_model;
    protected $auth_rule_model;

    protected function _initialize()
    {
        parent::_initialize();
        $this->auth_group_model = new AuthGroupModel();
        $this->auth_rule_model  = new AuthRuleModel();
    }

    /**
     * 权限组
     * @return mixed
     */
    public function index()
    {
        $auth_group_list = $this->auth_group_model->paginate(10);

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

            if ($this->auth_group_model->allowField(true)->save($data) !== false) {
             //   $this->success('保存成功');
                return json(array('code' => 200, 'msg' => '添加成功'));
            } else {
               // $this->error('保存失败');
                return json(array('code' => 0, 'msg' => '添加失败'));
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
        $auth_group = $this->auth_group_model->find($id);

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

            if ($id == 1 && $data['status'] != 1) {
              //  $this->error('超级管理组不可禁用');
                return json(array('code' => 0, 'msg' => '超级管理组不可禁用'));
            }
            if ($this->auth_group_model->allowField(true)->save($data, $id) !== false) {
             //   $this->success('更新成功');
                return json(array('code' => 200, 'msg' => '更新成功'));
                
            } else {
              //  $this->error('更新失败');
                return json(array('code' => 0, 'msg' => '更新失败'));
            }
        }
    }

    /**
     * 删除权限组
     * @param $id
     */
    public function delete($id)
    {
        if ($id == 1) {
          //  $this->error('超级管理组不可删除');
            return json(array('code' => 0, 'msg' => '超级管理组不可删除'));
        }
        if ($this->auth_group_model->destroy($id)) {
         //   $this->success('删除成功');
            return json(array('code' => 200, 'msg' => '删除成功'));
        } else {
          //  $this->error('删除失败');
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }

    /**
     * 授权
     * @param $id
     * @return mixed
     */
    public function auth($id)
    {
    	
    	
    	
    	//$auth_rule_list  = $this->auth_rule_model->where('pid=0')->field('id,pid,title')->select();
    	
    	$auth_rule_list = $this->auth_rule_model->getAllNode($id);
    	//$currentMenuList = $Group->getGroupAllList($groupId);
    	
    
        return $this->fetch('auth', ['id' => $id, 'auth_rule_list' => $auth_rule_list]);
    }

    /**
     * AJAX获取规则数据
     * @param $id
     * @return mixed
     */
    public function getJson($id)
    {
     //   $auth_group_data = $this->auth_group_model->find($id)->toArray();
       // $auth_rules      = explode(',', $auth_group_data['rules']);
      //  $auth_rule_list  = $this->auth_rule_model->field('id,pid,title')->select();
        $auth_rule_list = $this->auth_rule_model->getAllNode($id);
      

        return $auth_rule_list;
    }

    /**
     * 更新权限组规则
     * @param $id
     * @param $auth_rule_ids
     */
    public function updateAuthGroupRule($id, $auth_rule_ids = '')
    {
        if ($this->request->isPost()) {
            if ($id) {
                $group_data['id']    = $id;
                
                $idarr=$this->auth_rule_model->where('pid=0')->column('id');
                $map['pid']=array('in',$idarr);
                $res = $this->auth_rule_model->where($map)->field('id,pid,title')->select();
               
               
                
                
                if(is_array($auth_rule_ids)){
                	
                	foreach ($res as $k =>$v){
                		 
                		if(in_array($v['id'],$auth_rule_ids)){
                			array_push($auth_rule_ids, $v['pid']);
                		}
                		 
                		 
                	}
                	array_unique($auth_rule_ids);
                	$group_data['rules'] = implode(',', $auth_rule_ids);
                }else{
                	$arr[]=$auth_rule_ids;
                	
                	
                    foreach ($res as $k =>$v){
                		 
                		if($v['id']==$auth_rule_ids){
                			array_push($arr, $v['pid']);
                			
                		}
                		 
                		 
                	}
                	array_unique($arr);
                	$group_data['rules'] = implode(',', $arr);
                }
               
                
              
               // 
                

                if ($this->auth_group_model->save($group_data, $id) !== false) {
                   // $this->success('授权成功');
                    return json(array('code' => 200, 'msg' => '授权成功'));
                } else {
                  //  $this->error('授权失败');
                    return json(array('code' => 0, 'msg' => '授权失败'));
                }
            }
        }
    }
}