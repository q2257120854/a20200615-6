<?php
// +----------------------------------------------------------------------
// | Author: Bigotry <3162875@qq.com>
// +----------------------------------------------------------------------

namespace app\common\behavior;

use think\Loader;
use think\Db;

/**
 * 初始化基础信息行为
 */
class InitBase
{

    /**
     * 行为入口
     */
    public function run()
    {

        // 初始化路径常量
        $this->initPathConst();
    
        
        // 注册命名空间
        $this->registerNamespace();
    }
  
    /**
     * 初始化路径常量
     */
    private function initPathConst()
    {
    	// 插件目录名称
    	define('ADDON_DIR_NAME', 'addons');
    	
    	// 插件根目录路径
    	define('ADDON_PATH', ROOT_PATH .ADDON_DIR_NAME.DS );
        

    }
    
 
    /**
     * 注册命名空间
     */
    private function registerNamespace()
    {
        
        // 注册插件根命名空间
       Loader::addNamespace(ADDON_DIR_NAME, ADDON_PATH);
    }
}
