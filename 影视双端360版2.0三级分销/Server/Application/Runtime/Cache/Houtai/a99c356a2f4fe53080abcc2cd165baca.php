<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta http-equiv="Cache-Control" content="no-siteapp" />
 <link href="/Public/admin/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/Public/admin/css/style.css"/>       
        <link href="/Public/admin/assets/css/codemirror.css" rel="stylesheet">
        <link rel="stylesheet" href="/Public/admin/assets/css/ace.min.css" />
        <link rel="stylesheet" href="/Public/admin/assets/css/font-awesome.min.css" />
        	<!--[if IE 7]>
		  <link rel="stylesheet" href="/Public/admin/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
        <!--[if lte IE 8]>
		  <link rel="stylesheet" href="/Public/admin/assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/Public/admin/js/jquery-1.9.1.min.js"></script>
        <script src="/Public/admin/assets/js/bootstrap.min.js"></script>
		<script src="/Public/admin/assets/js/typeahead-bs2.min.js"></script>           	
        <script src="/Public/admin/assets/layer/layer.js" type="text/javascript" ></script>          
        <script src="/Public/admin/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="/Public/admin/assets/js/jquery.ui.touch-punch.min.js"></script>
        <script src="/Public/admin/assets/js/ace-elements.min.js"></script>
		<script src="/Public/admin/assets/js/ace.min.js"></script>
		<script src="/Public/js/jquery-1.9.1.min.js"></script>
<title>系统设置</title>



</head>
<script>
$(function(){
$('.editpic').click(function(){
	$('#file').after('<br/><input type="file" name="logo"/><br/');
})
})
</script>
<body>
<div class="margin clearfix">
 <div class="stystems_style">
  <div class="tabbable">
	<ul class="nav nav-tabs" id="myTab">
	  <li class="active">
		<a data-toggle="tab" href="#home"><i class="green fa fa-home bigger-110"></i>&nbsp;添加图片</a></li>
     
	</ul>
	<form action="update" method="POST" enctype="multipart/form-data">
		<input type="hidden" value="<?php echo ($mod["id"]); ?>" name="id">
    <div class="tab-content">
		<div id="home" class="tab-pane active">
		
		 
		
		
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>标题 </label>
          <div class="col-sm-9"><input type="text" name="title" value="<?php echo ($mod["title"]); ?>"   class="col-xs-10 "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>图片 </label>
					<div class="col-sm-9">
         
									 <?php if($mod["picname"] == ''): ?><input type="file" name="picname"/><?php else: ?><img src="<?php echo ($mod["picname"]); ?>" width="50" height="50"/><a href="javascript:void(0)" class="editpic">更换</a><?php endif; ?><span id="file"></span>
									</div>
									
									
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>连接 </label>
          <div class="col-sm-9"><input type="text" name="link" value="<?php echo ($mod["link"]); ?>"  class="col-xs-10 "></div>
          </div>
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>排序 </label>
          <div class="col-sm-9"><input type="text" name="sort" value="<?php echo ($mod["sort"]); ?>" class="col-xs-10 "></div>
          </div>
		
		 
		  
          <div class="Button_operation"> 
					<button  class="btn btn-primary radius" type="submit"><i class="fa fa-save "></i>&nbsp;添加</button>
               
			</div>
        </div>
        
		 </form>
		</div>
		</div>
 </div>

</div>
</body>
</html>