<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no,email=no,adress=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>实名认证</title>
	<link href="/Public/kj/css/layer.css" type="text/css" rel="stylesheet">
	<link href="/Public/kj/css/style.css" rel="stylesheet" type="text/css">
	<script src="/Public/kj/js/jquery.min.js"></script>
	<script src="/Public/kj/js/rem.js"></script>
	<script src="/Public/kj/js/safari.js"></script>
	<script src="/Public/kj/js/layer.js"></script>
	<script src="/Public/gec/web/js/jquery.form.js"></script>
</head>
<body>
<!-- 头部-->
<div class="header">
    <span class="go_black" id="goblack"></span>
    <h3>实名认证</h3>
</div>
<!--end-->
<!--兑换矿机-->
<div class="exchange">
    <div class="RealNamebox">
        <form class="Realform" method="post" action="" enctype="multipart/form-data">
            <ul>
                <li style="border-bottom: none"><label>会员等级：</label><input type="text" class="inpt1" value="<?php echo group($memmber['level']);?>"
                                                                           disabled></li>
                <li style="border-bottom: none"><label>手机号码：</label><input type="text" class="inpt1" value="<?php echo ($memmber['mobile']); ?>"
                                                                           disabled></li>
                <li><label>姓名</label>                
				<?php if($memmber['checkstatus'] == 2): ?><input type="text" class="inpt1 inpt3" id="truename" name="truename" value="<?php echo ($memmber['truename']); ?>" placeholder="请输入姓名">
                <?php else: ?>
                	 <?php if(!empty($memmber['truename'])): ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($memmber['truename']); ?>
               		 <?php else: ?>
                		<input type="text" class="inpt1 inpt3" id="truename" name="truename" value="<?php echo ($memmber['truename']); ?>" placeholder="请输入姓名"><?php endif; endif; ?> </li>
                <li><label>身份证</label>
                <?php if($memmber['checkstatus'] == 2): ?><input type="text" class="inpt1 inpt3" id="shenfen" name="shenfen" value="<?php echo ($memmber['shenfen']); ?>" placeholder="请输入身份证号码">
                <?php else: ?>
                	 <?php if(!empty($memmber['shenfen'])): ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($memmber['shenfen']); ?>
               		 <?php else: ?>
                		<input type="text" class="inpt1 inpt3" id="shenfen" name="shenfen" value="<?php echo ($memmber['shenfen']); ?>" placeholder="请输入身份证号码"><?php endif; endif; ?> 
                </li>
                <li><label>银行卡</label>
                <?php if($memmber['checkstatus'] == 2): ?><input type="text" class="inpt1 inpt3" id="idcard" name="idcard"  value="<?php echo ($memmber['idcard']); ?>" placeholder="请输入你的银行卡号" />
                <?php else: ?>
                	 <?php if(!empty($memmber['idcard'])): ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($memmber['idcard']); ?>
               		 <?php else: ?>
                		<input type="text" class="inpt1 inpt3" id="idcard" name="idcard"  value="<?php echo ($memmber['idcard']); ?>" placeholder="请输入你的银行卡号" /><?php endif; endif; ?> 
                <li><label>支付宝</label>
                <?php if($memmber['checkstatus'] == 2): ?><input type="text" class="inpt1 inpt3" id="zhifubao" name="zhifubao"  value="<?php echo ($memmber['zhifubao']); ?>" placeholder="请输入你的支付宝账号" />
                <?php else: ?>
                	 <?php if(!empty($memmber['zhifubao'])): ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($memmber['zhifubao']); ?>
               		 <?php else: ?>
                		<input type="text" class="inpt1 inpt3" id="zhifubao" name="zhifubao"  value="<?php echo ($memmber['zhifubao']); ?>" placeholder="请输入你的支付宝账号" /><?php endif; endif; ?> 

            </ul>
            <div class="uploadImg">
                <h1>上传收款码</h1>
                <div class="Imgbox">
	                <?php if(!empty($memmber['alipay_voucher']) and $memmber['checkstatus'] != 2): ?><img src="<?php echo ($memmber['alipay_voucher']); ?>" style="margin-top:10px;" width="160" height="160" />
	                <?php else: ?>
	                	<img src="" style="display:none;margin-top:10px;" onclick="document.getElementById('upfile').click()" id="clickimg" width="160" height="160">
	                    <span id="spanimg"><i>上传二维码</i></span>
	                    <div class="Uploadbtn">
	                    <input type="file" name="photoimg" id="upfile">
	                    <input type="hidden" name="alipay_voucher" value="" id="alipay_voucher">
	                    </div><?php endif; ?>  
                </div>
            </div>
			
		<?php if($memmber['checkstatus'] == 0): if(!empty($memmber['alipay_voucher']) and $memmber['bzjstatus'] == 0): ?><li style="height: 30px;line-height: 30px;margin-top: 5px;width:100%">审核结果：&nbsp;&nbsp;&nbsp;<font style="color:#F00;">请点击下一步缴纳保证金</font></li>
					<div class="Putforwardbtn Realbtn"><a href="<?php echo U('Index/PersonalSet/pay');?>" class="btn">下一步</a></div><?php endif; ?>
         		<?php if(!empty($memmber['alipay_voucher']) and $memmber['bzjstatus'] == 1): ?><li style="height: 30px;line-height: 30px;margin-top: 5px;width:100%">审核结果：&nbsp;&nbsp;&nbsp;<font style="color:#F00;">正在审核中，请耐心等待！</font></li><?php endif; ?>
         		<?php if(empty($memmber['alipay_voucher']) and $memmber['bzjstatus'] == 0): ?><li style="height: 30px;line-height: 30px;margin-top: 5px;width:100%">审核结果：&nbsp;&nbsp;&nbsp;<font style="color:#F00;">待完善，上传收款码并且支付保证金！</font></li>
					<div class="Putforwardbtn Realbtn"><button type="submit"  class="btn" style="width: 100%;">提 交</button></div><?php endif; endif; ?>	 
		
		<?php if(!empty($memmber['liyou']) and $memmber['checkstatus'] == 2): ?><li style="height: 30px;line-height: 30px;margin-top: 5px;width:100%">审核结果：&nbsp;&nbsp;&nbsp;<font style="color:#F00;"><?php echo ($memmber['liyou']); ?></font></li>
            <div class="Putforwardbtn Realbtn">
                  <button type="submit"  class="btn" style="width: 100%;">提 交</button>
            </div><?php endif; ?>
	   
		<?php if($memmber['checkstatus'] == 3 and $memmber['bzjstatus'] == 1): ?><li style="height: 30px;line-height: 30px;margin-top: 5px;width:100%">审核结果：&nbsp;&nbsp;&nbsp;<font style="color:#F00;">审核已通过</font></li><?php endif; ?>	 

    </div>
</div>
<!--end-->
<!--footer-->
<div class="footer">
    <ul>
        <li><a href="<?php echo U('Index/Emoney/shouye');?>"> <span class="icn1"></span>
            <p>首页</p></a></li>
        <li><a href="<?php echo U('Index/Shop/plist');?>"> <span class="icn2"></span>
            <p>矿机商场</p></a></li>
        <li><a href="<?php echo U('Index/Emoney/index');?>"> <span class="icn3"></span>
            <p>交易中心</p></a></li>
        <li class="active"><a href="<?php echo U('Index/Index/index');?>"> <span class="icn4"></span>
            <p>个人中心</p></a></li>
    </ul>
</div>
<!--end-->
<script type="text/javascript">
 
$(function(){
	$("#upfile").wrap("<form action='<?php echo U('Index/PersonalSet/uploads');?>' method='post' enctype='multipart/form-data'></form>"); 
	
	$("#upfile").off().on('change',function(){
		var objform = $(this).parents();
	    objform.ajaxSubmit({
		dataType:  'json',
		target: '#preview', 
			success:function(data){
				if(data.result==1){
					$("#clickimg").attr('src','/Public/'+data.url).css("display","block");
					$("#alipay_voucher").val('/Public/'+data.url);
					$("#spanimg").css("display","none");
				}else{
					$('.sima1').html('<font style="color:red;">'+data.msg+'</font>')
				}
			},
			error:function(){
			}
		})	
	});
});
 
 </script>
<script src="/Public/kj/js/goblak.js"></script>
</body>
</html>