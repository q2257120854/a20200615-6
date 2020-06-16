<?php
namespace app\admin\controller;

use app\common\controller\AdminBase;
use app\common\model\Addons as AddonsModel;
use app\common\model\Hooks as HooksModel;
use org\Http;
use think\Cache;
use think\Config;
use think\Request;
use think\Session;
use think\Db;

/**
 * 扩展后台管理页面
 * @author yangweijie <yangweijiester@gmail.com>
 */
class Addons extends AdminBase
{
    protected $addons_model;
    protected $hooks_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->addons_model = new AddonsModel();
        $this->hooks_model = new HooksModel();
    }

    /**
     * 插件列表
     */
    public function index()
    {
        $lists = $this->addons_model->getList();
        if (!$lists) {
            $this->assign('list', 0);
        } else {
            $this->assign('list', $lists);
        }
        return view();
    }
       //已装插件版本列表
     public function getuseaddonlist()
    {
        $a = Db::name('addons')->field('name,version')->select();
        return array_column($a, 'version', 'name');
    }
    public function online()
    {

        $info=$ota_info = '';
        $res = Db::name('system')->where('name', 'otaservice')->find();
        if ($res) {
            $ota_info = unserialize($res['value']);
        }

        if ($ota_info) {

            $htd = new Http();
            $addon_array = get_subdirs(ROOT_PATH . 'addons' . DS);
            $url = $ota_info['updateurl'] .'?upkey='. $ota_info['updatekey'].'&type=pluginlist';
            $data = $htd->get_curl($url);
            $arr = json_decode($data, true);
            if ($data) {
                if ($arr['code'] == 200) {
                    $info = $arr['info'];
                    $res=$this->getuseaddonlist();
                    foreach($info as $k=>$v){
                        $info[$k]['is_down']=0;
                      if (in_array($v['addonname'], $addon_array)) {
                        $info[$k]['is_down']=1;
                      }
                      if(isset($res[$v['addonname']])){
                        if($res[$v['addonname']]<$v['version'])
                        {
                            $info[$k]['is_down']=2;
                        }
                      }
                    }

                }else{
                    $info=$arr['msg'];
                }
            }
        }
        $this->assign('keyvalue', $ota_info['updatekey']);
        $this->assign('info', $info);
        return view();
    }

    /**
     * 插件后台显示页面
     * @param string $name 插件名
     */
    public function adminlist($name)
    {
        // 记录当前列表页的cookie
        // Cookie('__forward__',$_SERVER['REQUEST_URI']);

        $class = get_addon_class($name);
        if (!class_exists($class)) {
            $this->error('插件不存在');
        }

        $addon = new $class();
        $this->assign('addon', $addon);
        $param = $addon->admin_list;

        if (!$param) {
            $this->error('插件列表信息不正确');
        }

        extract($param);

        $this->assign('title', $addon->info['title']);
        $this->assign($param);

        if (!isset($fields)) {
            $fields = '*';
        }

        if (!isset($map)) {
            $map = array();
        }

        $keyword = $this->request->param('keyword');

        if ($keyword != '') {
            $map['title'] = ['like', "%{$keyword}%"];

        }

        $this->assign('keyword', $keyword);

        $list = D("addons://{$name}/{$model}")->where($map)->field($fields)->order($order)->paginate(10);

        $this->assign('list', $list);
        if ($addon->custom_adminlist) {
            $this->assign('custom_adminlist', $this->fetch($addon->addon_path . $addon->custom_adminlist));
        }

        return $this->fetch();
    }

    /**
     * 设置插件页面
     */
    public function config()
    {
        $id = Request::instance()->param('id');
        $addon = $this->addons_model->find($id);
        if (!$addon) {
            return json(array('code' => 0, 'msg' => '插件未安装'));

        }

        $addon_class = get_addon_class($addon['name']);
        if (!class_exists($addon_class)) {
            trace("插件{$addon['name']}无法实例化,", 'ADDONS', 'ERR');
        }

        $data = new $addon_class;
        $addon['addon_path'] = $data->addon_path;
        $addon['custom_config'] = $data->custom_config;

        $db_config = $addon['config'];
        //  $addon['config'] = include $data->config_file;
        $config = include $data->config_file;

        if ($db_config) {
            $db_config = json_decode($db_config, true);

            foreach ($config as $key => $value) {

                if ($value['type'] != 'group') {

                    //  $addon['config'][$key]['value'] =$db_config[$key];

                    $config[$key]['value'] = $db_config[$key];
                } else {

                    foreach ($value['options'] as $gourp => $options) {
                        foreach ($options['options'] as $gkey => $value) {
                            $config[$key]['options'][$gourp]['options'][$gkey]['value'] = $db_config[$gkey];
                        }
                    }
                }

            }
        }
        $addon['config'] = $config;

        $this->assign('id', $id);
        $this->assign('data', $addon);

        if ($addon['custom_config']) {
            $this->assign('custom_config', $this->fetch($addon['addon_path'] . $addon['custom_config']));
        }

        return view();
    }

    /**
     * 保存插件设置
     */
    public function saveConfig()
    {

        $data = $this->request->param();
        $id = $data['id'];
        $config = $data['config'];
        $flag = $this->addons_model->where("id={$id}")->setField('config', json_encode($config));
        if ($flag !== false) {

            return json(array('code' => 200, 'msg' => '保存插件设置成功'));
        } else {

            return json(array('code' => 0, 'msg' => '保存插件设置失败'));
        }
    }

    /**
     * 安装插件
     */
    public function install()
    {
        $addon_name = Request::instance()->param('addon_name'); //trim(I('addon_name'));

        $class = get_addon_class($addon_name);
       
        if (!class_exists($class)) {
            return json(array('code' => 0, 'msg' => $addon_name . '插件不存在'));

        }
        $addons = new $class;
        $info = $addons->info;

        if (!$info || !$addons->checkInfo()) //检测信息的正确性
        {
            return json(array('code' => 0, 'msg' => $addon_name . '插件信息缺失'));

        }
        check_addon_ser($addon_name);
       
        Session::delete('addons_install_error');

        $install_flag = $addons->install();

        if (!$install_flag) {
            return json(array('code' => 0, 'msg' => session('addons_install_error') . '执行插件预安装操作失败'));
        }

        $data = $info;

        if (is_array($addons->admin_list) && $addons->admin_list !== array()) {

            $data['has_adminlist'] = 1;
        } else {
            $data['has_adminlist'] = 0;
        }

        if ($this->addons_model->allowField(true)->save($data)) {

            $config = array('config' => json_encode($addons->getConfig($addon_name)));
            $this->addons_model->where("name='{$addon_name}'")->update($config);
            $hooks_update = $this->hooks_model->updateHooks($addon_name);

            if ($hooks_update) {
                Cache::set('hooks', null);
                return json(array('code' => 200, 'msg' => '插件安装成功', 'title' => $info['title'], 'name' => $info['name']));

            } else {
                $map['name'] = $addon_name;
                $this->addons_model->where($map)->delete();
                return json(array('code' => 0, 'msg' => '更新钩子处插件失败,请尝试重新安装或首先添加相应钩子'));

            }

        } else {
            return json(array('code' => 0, 'msg' => '写入插件数据失败'));

        }
    }

    /**
     * 卸载插件，注意保存数据
     */
    public function uninstall()
    {
        $id = Request::instance()->param('id'); //trim(I('addon_name'));

        $db_addons = $this->addons_model->find($id);
        $class = get_addon_class($db_addons['name']);

        if (!$db_addons || !class_exists($class)) {
            return json(array('code' => 0, 'msg' => '插件不存在'));
        }

        Session::delete('addons_install_error');
        $addons = new $class;

        $info = $addons->info;
        $uninstall_flag = $addons->uninstall();

        if (!$uninstall_flag) {
            return json(array('code' => 0, 'msg' => '执行插件预卸载操作失败'));
        }

        $hooks_update = $this->hooks_model->removeHooks($db_addons['name']);
        if ($hooks_update === false) {
            return json(array('code' => 0, 'msg' => '卸载插件所挂载的钩子数据失败'));
        }
        Cache::set('hooks', null);
        $delete = $this->addons_model->where("name='{$db_addons['name']}'")->delete();
        if ($delete === false) {
            return json(array('code' => 0, 'msg' => '卸载插件失败'));
        } else {
            return json(array('code' => 200, 'msg' => $db_addons['title'] . '"插件卸载成功', 'title' => $info['title'], 'name' => $info['name']));

        }
    }

    public function deladdon()
    {
        $addon_name = Request::instance()->param();
        //验证插件名称防止跨目录删除
        $validate_result = $this->validate($addon_name, 'AddonsDelName');
        if ($validate_result !== true) {
            return json(array('code' => 0, 'msg' => $validate_result));
        }
        $addon_name = $addon_name['addon_name'];
        //验证插件状态
        $this->addons_model = new AddonsModel();
        $status = $this->addons_model->where('status', 1)->where('name', $addon_name)->count();
        if($status){
            //插件正处于启用状态
            return json(array('code' => 0, 'msg' => '删除失败,请先卸载插件'));
        }
        $res=delete_dir_file(ROOT_PATH.'addons'.DS.$addon_name);

        if ($res) {
            return json(array('code' => 200, 'msg' => '删除成功'));
        }else{
            return json(array('code' => 0, 'msg' => '删除失败'));
        }
    }

    public function execute($addon_name = null, $controller_name = null, $action_name = null, $json = false)
    {

        $class_path = "\\" . ADDON_DIR_NAME . "\\" . $addon_name . "\controller\\" . $controller_name;

        $controller = new $class_path();
        if ($json) {
            return json($controller->$action_name());
        } else {
            $controller->$action_name();
        }

    }

}
