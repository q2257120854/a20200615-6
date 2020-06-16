<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no,email=no,adress=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>PCO首页</title>
    <link href="/Public/kj/css/swiper.min.css" type="text/css" rel="stylesheet">
    <link href="/Public/kj/css/style.css" type="text/css" rel="stylesheet">
    <script src="/Public/kj/js/jquery.min.js"></script>
    <script src="/Public/kj/js/swiper.min.js"></script>
    <script src="/Public/kj/js/rem.js"></script>
    <script src="/Public/kj/js/safari.js"></script>
</head>
<body>
<!--&lt;!&ndash; 头部&ndash;&gt;-->
<!--<div class="header">-->
<!--<h3>首页</h3>-->
<!--</div>-->
<!--&lt;!&ndash;end&ndash;&gt;-->
<!--轮播图-->
<div class="headrTitle">PCO首页</div>
<div class="swiper-container" id="bannerbgslider">
    <div class="swiper-wrapper">
        <div class="swiper-slide"><img src="/Public/kj/img/bg1.jpg"></div>
        <div class="swiper-slide"><img src="/Public/kj/img/bg2.jpg"></div>
        <div class="swiper-slide"><img src="/Public/kj/img/bg3.jpg"></div>
        <div class="swiper-slide"><img src="/Public/kj/img/bg4.jpg"></div>
    </div>
</div>
<div class="bannerbg">
    <div class="bannerslider">
        <div class="swiper-container" id="bannerslider">
            <div class="swiper-wrapper">
				<?php if(is_array($banner_list)): foreach($banner_list as $key=>$v): ?><div class="swiper-slide"><img src="<?php echo ($v["path"]); ?>"></div><?php endforeach; endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
<!--end-->
<!--导航-->
<div class="indexbg">
    <div class="navbar">
        <div class="navbox">
            <ul>
                <li><a href="<?php echo U('Index/Shop/shop');?>"><span><img src="/Public/kj/img/nav1.jpg"></span>
                    <h3>商城</h3></a></li>
                <li><a href="javascript:alert('暂未开放，敬请期待！');"><span class="icon2"><img src="/Public/kj/img/nav2.jpg"></span>
                    <h3>游戏</h3></a></li>
                <li><a href="javascript:alert('暂未开放，敬请期待！');"><span class="icon3"><img src="/Public/kj/img/nav3.jpg"></span>
                    <h3>合伙人</h3></a></li>
                <li><a href="<?php echo U('Index/Shop/qiandao');?>"><span><img src="/Public/kj/img/nav4.jpg"></span>
                    <h3>签到</h3></a></li>
                <li><a href="javascript:alert('暂未开放，敬请期待！');"><span class="icon5"><img src="/Public/kj/img/nav5.jpg"></span>
                    <h3>项目帮扶</h3></a></li>
                <li><a href="javascript:alert('暂未开放，敬请期待！');"><span><img src="/Public/kj/img/nav6.jpg"></span>
                    <h3>众权基金</h3></a></li>
                <li><a href="javascript:alert('暂未开放，敬请期待！');"><span class="icon3"><img src="/Public/kj/img/nav7.jpg"></span>
                    <h3>直播课堂</h3></a></li>
                <li><a href="javascript:alert('暂未开放，敬请期待！');"><span><img src="/Public/kj/img/nav8.jpg"></span>
                    <h3>平台回购</h3></a></li>
            </ul>
        </div>
    </div>
    <!--end-->
    <!--最新资讯-->
    <div class="NewNews">
        <h3>最新资讯</h3>
        <ul>
        	<?php if(is_array($list)): foreach($list as $key=>$vo): ?><li>
              <a href="<?php echo U('Index/New/newsdetails',array('news_id'=>$vo['id']));?>"><p><?php echo ($vo["title"]); ?></p></a><span><?php echo (date('Y-m-d',$vo["addtime"])); ?></span>
            </li><?php endforeach; endif; ?>
        </ul>
    </div>
    <!--end-->
</div>
<!--footer-->
<div class="footer">
    <ul>
        <li class="active"><a href="<?php echo U('Index/Emoney/shouye');?>"> <span class="icn1"></span>
            <p>首页</p></a></li>
        <li><a href="<?php echo U('Index/Shop/plist');?>"> <span class="icn2"></span>
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
    var Swiper1 = new Swiper('#bannerbgslider');
    var swiper = new Swiper('#bannerslider', {
        slidesPerView: 1,
        observer: true,
        observeParents: true,
        controller: {
            control: Swiper1, //控制Swiper1
        },
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