<?php
// +----------------------------------------------------------------------
// | Author: Bigotry <3162875@qq.com>
// +----------------------------------------------------------------------

namespace app\common\behavior;

use think\Hook;
use think\Db;
use think\Cache;
/**
 * 初始化钩子信息行为
 */
class InitHook
{
	public function run(&$content){
		if(isset($_GET['m']) && $_GET['m'] === 'Install') return;
	
		$data = Cache::get('hooks');
		
		if(!$data){
			$hooks = Db::name('Hooks')->column('name,addons');
			
			foreach ($hooks as $key => $value) {
				if($value){
					$map['status']  =   1;
					$names          =   explode(',',$value);
					$map['name']    =   array('IN',$names);
					$data = Db::name('Addons')->where($map)->column('id,name');
					if($data){
						$addons = array_intersect($names, $data);
						Hook::add($key,array_map('get_addon_class',$addons));
					}
				}
			}
			Cache::set('hooks',Hook::get());
			 
		}else{
		
			Hook::import($data,false);
		}
	}

}
