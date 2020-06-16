<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:81:"D:\wwwroot\2.cnhjdy.net\public/../application/comhome\view\functionshow\show.html";i:1575814725;s:74:"D:\wwwroot\2.cnhjdy.net\public/../application/comhome\view\public\top.html";i:1575814725;s:75:"D:\wwwroot\2.cnhjdy.net\public/../application/comhome\view\public\head.html";i:1575814725;s:75:"D:\wwwroot\2.cnhjdy.net\public/../application/comhome\view\public\foot.html";i:1575814725;}*/ ?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=0">
<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0" />
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp"/>


<title>功能展示</title>

<meta name="keywords" content="功能展示">

<meta name="description" content="功能展示">
<link rel="stylesheet" type="text/css" href="/com/css/icon/iconfont.css"/>
<link rel="stylesheet" type="text/css" href="/com/css/index.css"/>
<link rel="stylesheet" type="text/css" href="/com/css/wnmd.css"/>
<script src="/com/js/jquery.js" type="text/javascript" charset="utf-8"></script>
<script src="/com/js/jquery.SuperSlide.2.1.1.js" type="text/javascript" charset="utf-8"></script>
<script src="/com/js/index.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>
    
<link rel="stylesheet" type="text/css" href="/com/css/head_foot.css">

<div class="navbox">

			<div class="nav clearfix main3">

				<a href="/"><img class="nav_left block fl" src="<?php echo $sbase['logo']; ?>" style="width:331px;height:74px"/></a>

				<div class="nav_right fr">

					<ul class="clearfix">

						<li style="margin-left: 0">

							<a href="/">首页</a>

						</li>

				       	<li class="<?php if($page==1): ?>hover<?php endif; ?>">

						  <a href="<?php echo Url('Functionshow/index'); ?>" title="功能展示">功能展示</a></li>

						<li class="<?php if($page==2): ?>hover<?php endif; ?>">

						  <a href="<?php echo Url('News/index'); ?>" title="最新动态">最新动态</a></li>

						<li class="<?php if($page==3): ?>hover<?php endif; ?>">

						  <a href="<?php echo Url('Cases/index'); ?>" title="小程序案例">小程序案例</a></li>

						<li class="<?php if($page==4): ?>hover<?php endif; ?>">

						  <a href="<?php echo Url('Solution/index'); ?>" title="解决方案">解决方案</a></li>

						<li class="<?php if($page==5): ?>hover<?php endif; ?>">

						  <a href="<?php echo Url('About/index'); ?>" title="关于我们">关于我们</a></li>

						<li class="top_landing">

							<a href="<?php echo Url('Index/login/index'); ?>">管理登陆</a>

						</li>

					</ul>

				</div>

			</div> 

		</div>

    <div class="funbox" style="padding-top: 50px">

            <div class="fun main clearfix">

                <div class="fun_leftbox">

                    <div class="fun_leftbd">

                        <?php if($info): if($info['funcimg']): foreach($info['funcimg'] as $index=>$val): ?>

                                <div>

                                    <img src="<?php echo $val; ?>" style="width: 260px;height: 459px" />

                                </div>

                                <?php endforeach; endif; endif; ?>

                    </div>

                    <div class="fun_left_hd">

                        <ul></ul>

                    </div>

                    <div class="prev iconfont icon-arrow-left"></div>

                    <div class="next iconfont icon-arrow-right"></div>

                </div>

                <div class="fun_right">

                    <p class="fun_right_p1"><?php if($info): ?><?php echo $info['title']; endif; ?></p>

                    <p class="fun_right_p2"><?php if($info): ?><?php echo $info['descs']; endif; ?></p>

                    <p class="fun_right_p3"><span class="iconfont icon-changjing"></span>适用场合</p>

                    <div class="fun_right_div1">

                    <?php if($info): if($info['place']): foreach($info['place'] as $rs): ?>

                        <span><?php echo $rs; ?></span>

                        <?php endforeach; endif; endif; ?>

                    </div>

                    <p class="fun_right_p3"><span class="iconfont icon-gongnenglan"></span>功能展示</p>

                    <div class="fun_right_div2">

                    <?php if($info): if($info['func']): foreach($info['func'] as $rs): ?>

                        <span><?php echo $rs; ?></span>

                        <?php endforeach; endif; endif; ?>

                    </div>

                    <!-- <div id="myfunshow" style="display: none"></div> -->

                </div>

            </div>

        </div>

        <div class="casesbox fun2box">

            <div class="main">

                <?php if($info): ?><?php echo $info['text']; endif; ?>

            </div>

        </div>

    <div class="bottombox">

            <div class="main" style="width: 1200px">

                <ul class="bottom1_ul1 clearfix">

                    <li><span>免</span>免费配置服务器</li>

                    <li><span>免</span>免费修复bug</li>

                    <li><span class="iconfont icon-chengben"></span>成本价定制功能</li>

                    <li><span class="iconfont icon-group"></span>5000人交流大群</li>

                    <li><span class="iconfont icon-kefu"></span>7X24小时客户服务</li>

                </ul>

                <div class="bottom_fl clearfix">

                    <div class="bottom_fl_div1 fl">

                        <div class="bottom_fl_title">功能模块</div>

                        <ul class="bottom_fl_div1_ul clearfix">

                            <li>

                                <a href="/comhome/functionshow/show.html?id=8">可拖拽DIY</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=32">分销模块</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=28">文章管理系统</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=5">多规格商城</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=6">付费视频系统</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=30">万能表单</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=27">预约报名</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=7">多门店系统</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=34">付费预约</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=35">优惠券系统</a>

                            </li>

                        </ul>

                    </div>

                    <div class="bottom_fl_div2 fl">

                        <div class="bottom_fl_title">营销系统</div>

                        <ul class="bottom_fl_div2_ul">

                            <li>

                                <a href="/comhome/functionshow/show.html?id=37">店内点餐小程序</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=36">拼团商城小程序</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=33">秒杀商城小程序</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=39">积分签到小程序  </a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=41">积分兑换商城</a>

                            </li>

                            <li>

                                <a href="/comhome/functionshow/show.html?id=14">手机客服小程序</a>

                            </li>

                        </ul>

                    </div>

                    <div class="bottom_fl_div1 fl">

                        <div class="bottom_fl_title">行业解决方案</div>

                        <ul class="bottom_fl_div1_ul clearfix">

                            <li>

                                <a href="/comhome/solution/show.html?id=2">智慧餐饮</a>

                            </li>

                            <li>

                                <a href="/comhome/solution/show.html?id=7">智慧家装</a>

                            </li>

                            <li>

                                <a href="/comhome/solution/show.html?id=3">智慧商城</a>

                            </li>

                            <li>

                                <a href="/comhome/solution/show.html?id=8">智慧教育</a>

                            </li>

                            <li>

                                <a href="/comhome/solution/show.html?id=4">智慧美业</a>

                            </li>

                            <li>

                                <a href="/comhome/solution/show.html?id=9">婚纱摄影</a>

                            </li>

                            <li>

                                <a href="/comhome/solution/show.html?id=5">智慧旅游</a>

                            </li>

                            <li>

                                <a href="/comhome/solution/show.html?id=10">同城服务</a>

                            </li>

                            <li>

                                <a href="/comhome/solution/show.html?id=6">智慧休娱</a>

                            </li>

                        </ul>

                    </div>

                    <div class="bottom_fl_div2 fl">

                        <div class="bottom_fl_title">关于我们</div>

                        <ul class="bottom_fl_div2_ul">

                            <li>

                                <a href="<?php echo Url('Comhome/about/index'); ?>">公司介绍</a>

                            </li>


                        </ul>

                    </div>

                    <div class="fr clearfix">

                        <ul class="bottom_fl_right fr">

                            <li>

                                <img src="/com/img/home_qq.png"><?php echo $sbase['qq']; ?>

                            </li>

                            <li>

                                <img src="/com/img/home_phone.png"><?php echo $sbase['hotline']; ?>

                            </li>

                        </ul>

                        <div class="bottom_fl_right_div fr">

                            <img src="<?php echo $sbase['ewm']; ?>" style="width: 109px">

                            <div>扫一扫关注我们</div>

                        </div>

                    </div>

                </div>

                <ul class="bottom2_ul1">

                    <li>

                        <a href="https://pay.weixin.qq.com/">微信支付</a>

                    </li>


                    <li>·</li>

                    <li>

                        <a href="https://www.aliyun.com/">阿里云</a>

                    </li>

                    <li>·</li>

                    <li>

                        <a href="https://cloud.tencent.com/">腾讯云</a>

                    </li>

                    <li>·</li>

                    <li>

                        <a href="https://www.5g-yun.com/">5G云</a>

                    </li>

                    <li>·</li>

                    <li>

                        <a href="https://mp.weixin.qq.com/cgi-bin/wx">微信小程序</a>

                    </li>

                </ul>

                <p class="bottom2_p"><?php echo $sbase['name']; ?>&nbsp;&nbsp;版权所有&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $sbase['copyright']; ?></p>

            </div>

        </div>

    

    <!--[if lt IE 9]>

    <div class="notsupport">

        <h1>:( 非常遗憾</h1>

        <h2>您的浏览器版本太低，请升级您的浏览器</h2>

    </div>

    <![endif]-->


</body>
<script>
$(function(){
            $.ajax({
                url:"<?php echo Url('Functionshow/addHits'); ?>?id=<?php echo $_GET['id']?>",
                type:"POST",
                dateType:"json",
                success:function(res){
                    if(res == 1){
                        // alert(res)
                    }
                }
            });
        })
</script>
</html>