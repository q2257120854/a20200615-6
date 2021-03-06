<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no,email=no,adress=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>H5矿机商城</title>
    <link href="/Public/kj/css/swiper.min.css" type="text/css" rel="stylesheet">
    <link href="/Public/kj/css/style.css" type="text/css" rel="stylesheet">
    <script src="/Public/kj/js/jquery.min.js"></script>
    <script src="/Public/kj/js/swiper.min.js"></script>
    <script src="/Public/kj/js/rem.js"></script>
    <script src="/Public/kj/js/safari.js"></script>
</head>
<body>
<!-- 头部-->
<div class="header">
    <h3>矿机商城</h3>
</div>
<!--end-->
<!--矿机商场列表-->
<div class="MinerMall">
    <ul>
        <?php if(is_array($typeData)): foreach($typeData as $key=>$ty): ?><li>
            <div class="Minerimg"><img src=<?php echo ($ty["thumb"]); ?> /></div>
            <h3><?php echo ($ty["title"]); ?></h3>
            <p><label>兑换单位：</label><?php echo ($ty["price"]); ?>PCO</p>
            <p><label>产量/小时：</label><?php echo ($ty["shouyi"]); ?></p>
            <p><label>矿机算力：</label><?php echo ($ty["gonglv"]); ?>GH/s</p>
            <p><label>运行周期：</label><?php echo ($ty["yszq"]); ?>小时</p>
            <a href="<?php echo U('Index/Shop/pcontent',array('id'=>$ty['id']));?>" class="more">兑换</a>
        </li><?php endforeach; endif; ?>	
    </ul>
</div>
<!--end-->
<!--footer-->
<div class="footer">
    <ul>
        <li><a href="<?php echo U('Index/Emoney/shouye');?>"> <span class="icn1"></span>
            <p>首页</p></a></li>
        <li class="active"><a href="<?php echo U('Index/Shop/plist');?>"> <span class="icn2"></span>
            <p>矿机商场</p></a></li>
        <li><a href="<?php echo U('Index/Emoney/index');?>"> <span class="icn3"></span>
            <p>交易中心</p></a></li>
        <li><a href="<?php echo U('Index/Index/index');?>"> <span class="icn4"></span>
            <p>个人中心</p></a></li>
    </ul>
</div>
<!--end-->
<!--js-->
<script>
    var swiper = new Swiper('#bannerslider', {
        slidesPerView: 1,
        loop: true,
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '#bannerslider .swiper-pagination',
            clickable: true,
        },
    });
</script>
</body>
</html>