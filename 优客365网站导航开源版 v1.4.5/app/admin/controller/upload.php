<?php
/****************优客365网址导航系统 开源版********************/
/*                                                            */
/*  Youke365.site (C)2017 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航开源版 个人用户可免费使用  请保留底部版权  */
/*  2018.4                                                    */
/*  官方网址：http://www.yunziyuan.com.cn                     */
/*  官方论坛：http://www.yunziyuan.com.cn                        */                           
/**************************************************************/
if (!defined('IN_YOUKE365')) exit('Access Denied');
include APP_PATH.__MODULE__.'/base.php';
header('Content-type: application/json'); 
if(isAjax()){ 
$opstion = get_options();

//ajax提交
$type     = I('get.type','','addslashes');
	if($type =='logo'){
		   $uploads_path =  'uploads/logo/'.date("Ymd",time()).'/';  //上传目录

			if(!empty($_FILES['logo']['name'])){
					  //上传logo
					     
						 $Upload = new FileUpload;
						 $Upload->set('maxsize','1000000');
						 $Upload->set('israndname',true);	
						 $Upload->set('allowtype',['jpg','gif','png']);	
						 
						 $Upload->set('path',ROOT_PATH.$uploads_path);

						 $Upload->upload('logo');
						 if(!$Upload->getFileName()){
					        
					         $data['status'] = -1;
						     $data['msg'] = $Upload->getErrorMsg();
						
						 }

						 $data['status'] = 0;
						 $data['msg'] = "上传成功";
						 $data['data'] = '/'.$uploads_path.$Upload->getFileName();

						 exit(json_encode($data));
			         }
	    }else if($type =='images'){
	 	$uploads_path =  $opstion['upload_dir'].'/images/'.date("Ymd",time()).'/';  //上传目录

			if(!empty($_FILES['images']['name'])){
					  //上传images
					     
						 $Upload = new FileUpload;
						 $Upload->set('maxsize','1000000');
						 $Upload->set('israndname',true);	
						 $Upload->set('allowtype',['jpg','gif','png']);	
						 
						 $Upload->set('path',ROOT_PATH.$uploads_path);

						 $Upload->upload('images');
						 if(!$Upload->getFileName()){
					        
					         $data['status'] = -1;
						     $data['msg'] = $Upload->getErrorMsg();
						
						 }

						 $data['status'] = 0;
						 $data['msg'] = "上传成功";
						 $data['data'] = '/'.$uploads_path.$Upload->getFileName();

						 exit(json_encode($data));
			         }
	    }else{
			$data['status'] = -1;
			$data['msg'] = '请求类型错误';
			exit(json_encode($data));
		}

}else{
	$data['status'] = -1;
	$data['msg'] = '非法请求';
	exit(json_encode($data));
}
	


