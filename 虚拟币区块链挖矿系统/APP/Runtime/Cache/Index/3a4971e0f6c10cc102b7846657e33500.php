<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="/Public/btb/css/lib.css?2">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1, minimum-scale=1.0"/>
	<meta content="telephone=no" name="format-detection">
	<title>个人中心</title>	
    <link rel="stylesheet" href="/Public/gec/web/css/weui.min.css"/>
	<link rel="stylesheet" href="/Public/gec/web/css/jquery-weui.min.css">
	<link href="/Public/gec/web/css/font-awesome.min.css" rel="stylesheet">
	<link href="/Public/gec/web/fonts/iconfont.css" rel="stylesheet">
	<script src="/Public/gec/web/js/layer.js"></script>
	<link rel="stylesheet" href="/Public/gec/web/css/stylef.css"/>
	
	

</head>

<body>
<!--顶部开始-->
<!--顶部开始-->
<div class="header">
    <span class="header_l"><a href="javascript:history.go(-1);"><i class="fa fa-chevron-left"></i></a></span>
    <span class="header_c">网站公告</span>

		<!--<span style="position: absolute;right: 10%;top: 0px;text-align:center;width:20%;white-space:nowrap; overflow:hidden; text-overflow:ellipsis;font-size: 12px; "><?php echo ($memberinfo['username']); ?> </span>
		<span class="header_r"><a href="<?php echo U(GROUP_NAME .'/personal_set/myInfo');?>"><i class="fa fa-user"></i></a></span>-->
</div>
<div class="height40"></div>
<!--顶部结束-->
<!--顶部结束-->
<style>
	.anchorjs-icon img{ width:100% !important;}

</style>


<div class="inner-block" style="padding:0 3px;">
    <div class="inbox">
    		 
    	 	<div class="col-md-8 compose-right">
					<div class="inbox-details-default">
					<div class="grid_3 grid_4">
			
	     <div class="bs-example">
		    <table class="table">
		      <tbody>
		     
			  <tr>
		          <td align=center><h3 id="h3-bootstrap-heading"><?php echo ($new["title"]); ?></h3></td>
		          
		        </tr>

				
		
			
			 
			 
		        <tr>
		          <td><h5 id="h5-bootstrap-heading">
				  
				 <span class="anchorjs-icon"><?php echo (stripcslashes($new["content"])); ?></span></h5></td>
		        
		        </tr> 
		       
		      </tbody>
		    </table>
								  
<div style="text-align:center; margin-top:30px;">
<input id="btnback" class="buttom" onclick="javascript:window.history.go(-1)" type="button"value="返 回" style=" width:80%; border-radius:4px; padding:5px 10px; border:0px; background:#ff7387; color:#ffffff;"/>
</div>



	     </div>
	  </div>

	  
	  
	  
				      
					  

					  

           
	
	
			
			
			
			
			
			
			
			
			
			
			
					</div>
				</div>
    	
          <div class="clearfix"> </div>     
   </div>
</div>
		
		
    <link href="/Public/kj/css/swiper.min.css" type="text/css" rel="stylesheet">
    <link href="/Public/kj/css/style.css" type="text/css" rel="stylesheet">
<style>
	.footer ul li{
		width: 25%;
	}
</style>
<div class="footer">
    <ul>
        <li><a href="<?php echo U('Index/Emoney/shouye');?>"> <span class="icn1"></span>
            <p>首页</p></a></li>
        <li><a href="<?php echo U('Index/Shop/plist');?>"> <span class="icn2"></span>
            <p>矿机商场</p></a></li>
        <li><a href="<?php echo U('Index/Emoney/index');?>"> <span class="icn3"></span>
            <p>交易中心</p></a></li>
        <li><a href="<?php echo U('Index/Index/index');?>"> <span class="icn4"></span>
            <p>个人中心</p></a></li>
    </ul>
</div>
	<!--底部结束-->
<script src="/Public/gec/reg/js/jquery-1.11.3.min.js"></script>
<script src="/Public/gec/web/js/jquery-weui.min.js"></script>