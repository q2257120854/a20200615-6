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
<title>系统设置</title>

</head>

<body>
<div class="margin clearfix">
 <div class="stystems_style">
  <div class="tabbable">
	<ul class="nav nav-tabs" id="myTab">
	  <li class="active">
		<a data-toggle="tab" href="#home"><i class="green fa fa-home bigger-110"></i>&nbsp;基本设置</a></li>
     
	</ul>
	<form action="/Houtai/Config/update" method="POST">
	<input type="hidden" name="id" value="1">
    <div class="tab-content">
	
	
	
	
	
	
		<div id="home" class="tab-pane active">
			
		
		
         <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>网站名称： </label>
          <div class="col-sm-9"><input type="text" placeholder="控制在25个字、50个字节以内" name="webname" value="<?php echo ($mod["webname"]); ?>" class="col-xs-10 "></div>
          </div>
		   <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>最低提现： </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="tixian" value="<?php echo ($mod["tixian"]); ?>" placeholder="最低提现" class="col-xs-10 "></div>
          </div>
		 <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>客服信息： </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="kefu" value="<?php echo ($mod["kefu"]); ?>" placeholder="客服信息" class="col-xs-10 "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>APP下载连接： </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="xiazai" value="<?php echo ($mod["xiazai"]); ?>" placeholder="APP下载连接" class="col-xs-10 "></div>
          </div>
          <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>代理公告： </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="gonggao" value="<?php echo ($mod["gonggao"]); ?>" placeholder="代理公告" class="col-xs-10 "></div>
          </div>
		 <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>积分兑换 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jifen" value="<?php echo ($mod["jifen"]); ?>" placeholder="积分兑换（X积分兑换一天使用时间）" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>体验时间 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="time" value="<?php echo ($mod["time"]); ?>" placeholder="体验时间" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>代理生成体验卡价格 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="dailiqi" value="<?php echo ($mod["dailiqi"]); ?>" placeholder="代理生成体验卡价格" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>代理生成月卡价格 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="dailiyi" value="<?php echo ($mod["dailiyi"]); ?>" placeholder="代理生成月卡价格" class="col-xs-10 "></div>
          </div>
		  
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>代理生成季卡价格 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="dailisan" value="<?php echo ($mod["dailisan"]); ?>" placeholder="代理生成季卡价格" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>代理生成半年卡价格 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="daililiu" value="<?php echo ($mod["daililiu"]); ?>" placeholder="代理生成半年卡价格" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>代理生成年卡价格 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="dailinian" value="<?php echo ($mod["dailinian"]); ?>" placeholder="代理生成年卡价格" class="col-xs-10 "></div>
          </div>
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>代理生成永久价格 </label>
          <div class="col-sm-9"><input type="text" id="website-title" name="dailiyongjiu" value="<?php echo ($mod["dailiyongjiu"]); ?>" placeholder="代理生成永久价格" class="col-xs-10 "></div>
          </div>
		  
		  <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>解析1</label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jiexi1" value="<?php echo ($mod["jiexi1"]); ?>" placeholder="解析1" class="col-xs-10 "></div>
          </div>
		   <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>解析2</label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jiexi2" value="<?php echo ($mod["jiexi2"]); ?>" placeholder="解析2" class="col-xs-10 "></div>
          </div>
		    <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>解析3</label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jiexi3" value="<?php echo ($mod["jiexi3"]); ?>" placeholder="解析3" class="col-xs-10 "></div>
          </div>
		    <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>解析4</label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jiexi4" value="<?php echo ($mod["jiexi4"]); ?>" placeholder="解析4" class="col-xs-10 "></div>
          </div>
		    <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>解析5</label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jiexi5" value="<?php echo ($mod["jiexi5"]); ?>" placeholder="解析5" class="col-xs-10 "></div>
          </div>
		    <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>解析6</label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jiexi6" value="<?php echo ($mod["jiexi6"]); ?>" placeholder="解析6" class="col-xs-10 "></div>
          </div>
		    <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>解析7</label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jiexi7" value="<?php echo ($mod["jiexi7"]); ?>" placeholder="解析7" class="col-xs-10 "></div>
          </div>
		    <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>解析8</label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jiexi8" value="<?php echo ($mod["jiexi8"]); ?>" placeholder="解析1" class="col-xs-10 "></div>
          </div>
		    <div class="form-group"><label class="col-sm-1 control-label no-padding-right" for="form-field-1"><i>*</i>解析9</label>
          <div class="col-sm-9"><input type="text" id="website-title" name="jiexi9" value="<?php echo ($mod["jiexi9"]); ?>" placeholder="解析9" class="col-xs-10 "></div>
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