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
<title>购买设置</title>

</head>

<body>
<div class="margin clearfix">
 <div class="stystems_style">
  <div class="tabbable">
	<ul class="nav nav-tabs" id="myTab">
	  <li class="active">
		<a data-toggle="tab" href="#home"><i class="green fa fa-home bigger-110"></i>&nbsp;修改数据</a></li>
     
	</ul>
	<form action="/Houtai/Jiage/update" method="POST">
	<input type="hidden" name="id" value="1">
    <div class="tab-content">
		<div id="home" class="tab-pane active">
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>七天 </label>
          <div class="col-sm-9"><input type="text" name="day" value="<?php echo ($mod["day"]); ?>" placeholder="七天" class="col-xs-10 "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>一个月 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="month" value="<?php echo ($mod["month"]); ?>" placeholder="一个月" class="col-xs-10 "></div>
          </div>
         
		<div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>三个月 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="quarter" value="<?php echo ($mod["quarter"]); ?>" placeholder="三个月" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>半年 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="half" value="<?php echo ($mod["half"]); ?>" placeholder="半年" class="col-xs-10 "></div>
          </div>
		
		<div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>一年 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="year" value="<?php echo ($mod["year"]); ?>" placeholder="一年" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>永久 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="yongjiu" value="<?php echo ($mod["yongjiu"]); ?>" placeholder="永久" class="col-xs-10 "></div>
          </div>
		  
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>代理 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="daili" value="<?php echo ($mod["daili"]); ?>" placeholder="代理" class="col-xs-10 "></div>
          </div>
          <div class="Button_operation"> 
					<button  class="btn btn-primary radius" type="submit"><i class="fa fa-save "></i>&nbsp;保存修改</button>
               
			</div>
        </div>
        
		 </form>
		</div>
		</div>
 </div>

</div>
</body>
</html>