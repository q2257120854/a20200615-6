<?php
$openMobile=0;
//检测是否有手机模板
if(is_dir(ROOT_PATH.'template'.DS.config('web.B_TPL').DS.'mobile')&&request()->isMobile()){
	$openMobile=1;
}
return [
	'template'=> [
		'view_path' => './template/'.config('web.B_TPL').($openMobile?'/mobile/':'/html/'),
		'view_suffix' => 'html',
	    'view_depr'    => '_',
    ],
		'view_replace_str'  =>  [
				'__INDEX__' => WEB_URL . '/index.php',
				'__HOME__' => WEB_URL . '/template/'.config('web.B_TPL'),
				'__UPLOAD__' => '/uploads',
				'__PUBLIC__' =>WEB_URL. '/public/',
				'__IMG__' =>WEB_URL. '/public/images/',
			
		],
		//默认错误跳转对应的模板文件
		'dispatch_error_tmpl' => 'index/tips',
		//默认成功跳转对应的模板文件
		'dispatch_success_tmpl' => 'index/tips',

];
