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
<title>广告设置</title>

</head>

<body>
<div class="margin clearfix">
 <div class="stystems_style">
  <div class="tabbable">
	<ul class="nav nav-tabs" id="myTab">
	  <li class="active">
		<a data-toggle="tab" href="#home"><i class="green fa fa-home bigger-110"></i>&nbsp;添加图片</a></li>
     
	</ul>
	<form action="insert" method="POST" enctype="multipart/form-data">
	
    <div class="tab-content">
		<div id="home" class="tab-pane active">
		
		 <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>分类 </label>
          <div class="col-sm-9">

		  <select class="form-control" id="form-field-select-1" name="type">
		   <option value="1">首页轮播</option>
		   
			  <option value="2">大厅轮播</option> 
			  
				<option value="3">大厅VIP</option> 
				<option value="4">启动图</option> 
				<option value="5">直播源</option> 
		  </select>

		  </div>
          </div>
		
		
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>标题 </label>
          <div class="col-sm-9"><input type="text" placeholder="控制在4个字、6个字节以内" name="title"  class="col-xs-10 "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>图片 </label>
          <div class="col-sm-9"><input type="file" id="website-title" name="picname" value="<?php echo ($mod["xiazai"]); ?>" placeholder="图片" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>链接 </label>
          <div class="col-sm-9"><input type="text" placeholder="" name="link"  class="col-xs-10 "></div>
          </div>
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>排序 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="sort" class="col-xs-10 "></div>
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