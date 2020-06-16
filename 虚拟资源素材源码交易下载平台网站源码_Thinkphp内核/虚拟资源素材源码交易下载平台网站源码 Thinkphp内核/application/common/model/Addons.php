<?php
// +----------------------------------------------------------------------
// | Author: Bigotry <3162875@qq.com>
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Model;

/**
 * 插件模型
 */
class Addons extends Model
{
    protected $insert = ['create_time'];

    protected function setCreatetimeAttr()
    {
        return time();
    }

    /**
     * 获取插件列表
     * @param string $addon_dir
     */
    public function getList($addon_dir = '')
    {
        if (!$addon_dir) {
            $addon_dir = ADDON_PATH;
        }

        $dirs = array_map('basename', glob($addon_dir . '*', GLOB_ONLYDIR));

        if (empty($dirs)) {
            return false;
        } else {
            if ($dirs === false || !file_exists($addon_dir)) {
                $this->error = '插件目录不可读或者不存在';
                return false;
            }

            $addons = array();
            $where['name'] = array('in', $dirs);

            $list = $this->where($where)->field(true)->select();

            foreach ($list as $addon) {
                $addon['uninstall'] = 0;
                $addons[$addon['name']] = $addon;
            }

            foreach ($dirs as $value) {

                if (!isset($addons[$value])) {

                    $class = get_addon_class($value);

                    if (!class_exists($class)) { // 实例化插件失败忽略执行
                        \Think\Log::record('插件' . $value . '的入口文件不存在！');
                        continue;
                    }

                    $obj = new $class;
                    $addons[$value] = $obj->info;
                    $admin_list = $obj->admin_list;

                    if ($addons[$value]) {
                        $addons[$value]['uninstall'] = 1;
                        unset($addons[$value]['status']);
                    }
                    if ($admin_list) {
                        $addons[$value]['has_adminlist'] = 1;

                    } else {
                        $addons[$value]['has_adminlist'] = 0;
                    }

                }
            }

            int_to_string($addons, array('status' => array(-1 => '损坏', 0 => '禁用', 1 => '启用', null => '未安装')));

            $addons = list_sort_by($addons, 'uninstall', 'desc');
        }

        return $addons;
    }

    /**
     * 获取插件的后台列表
     */
    public function getAdminList()
    {
        $admin = array();
        $db_addons = $this->where("status=1 AND has_adminlist=1")->field('title,name')->select();
        if ($db_addons) {
            foreach ($db_addons as $value) {
                $admin[] = array('title' => $value['title'], 'name' => $value['name'], 'url' => "Addons/adminlist?name={$value['name']}");
            }
        }
        return $admin;
    }

}
