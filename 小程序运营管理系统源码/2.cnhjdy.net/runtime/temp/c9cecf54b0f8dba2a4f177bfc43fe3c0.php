<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:74:"/www/wwwroot/2.cnhjdy.net/public/../application/home/view/index/index.html";i:1575814726;}*/ ?>
<!DOCTYPE html>

<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport" content="width=device-width, initial-scale=0">

<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0,user-scalable=0">

<meta name="renderer" content="webkit">

<meta http-equiv="Cache-Control" content="no-siteapp">

<title><?php echo $sbase['name']; ?></title>

<meta name="keywords" content="<?php echo $sbase['keywords']; ?>">

<meta name="description" content="<?php echo $sbase['description']; ?>">

<link rel="stylesheet" type="text/css" href="/com/css/iconfont.css">

<link rel="stylesheet" type="text/css" href="/com/css/wnmd.css">

<script src="/com/js/jquery.js" type="text/javascript" charset="utf-8"></script>

<script src="/com/js/jquery.SuperSlide.2.1.1.js" type="text/javascript" charset="utf-8"></script>

<script src="/com/js/wnmd.js" type="text/javascript" charset="utf-8"></script>

<link rel="stylesheet" type="text/css" href="/com/img/main.css">
	<script src="../../../../../../../星愿托儿所/util.js"></script>

</head>



<body>

<link rel="stylesheet" type="text/css" href="/com/css/head_foot.css">

<div class="navbox">

			<div class="nav clearfix main3">

				<a href="/"><img class="nav_left block fl" src="<?php echo $sbase['logo']; ?>" style="width:331px;height:74px"/></a>

				<div class="nav_right fr">

					<ul class="clearfix">

						<li class="hover" style="margin-left: 0">

							<a href="/">首页</a>

						</li>

				       	<li>

						  <a href="<?php echo Url('Comhome/functionshow/index'); ?>" title="功能展示">功能展示</a></li>

						<li>

						  <a href="<?php echo Url('Comhome/News/index'); ?>" title="最新动态">最新动态</a></li>

						<li>

						  <a href="<?php echo Url('Comhome/Cases/index'); ?>" title="小程序案例">小程序案例</a></li>

						<li>

						  <a href="<?php echo Url('Comhome/Solution/index'); ?>" title="解决方案">解决方案</a></li>

						<li>

						  <a href="<?php echo Url('Comhome/About/index'); ?>" title="关于我们">关于我们</a></li>

						<li class="top_landing">

							<a href="<?php echo Url('Index/Login/index'); ?>">管理登陆</a>

						</li>

					</ul>

				</div>

			</div> 

		</div>

    <div class="fixbox">

		<div class="fix_yuan fix_contect" style="background-color: #ffcb2d">

    		<img class="fix_yuan_img" src="/com/img/phone_icon.png">

			<div class="fix_yuan_text">咨询热线</div>

			<div class="indexecontect"><?php echo $sbase['hotline']; ?></div>

    	</div>

    	<div class="fix_yuan fix_contect" style="background-color: #606adb">

			<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $sbase['qq']; ?>&amp;site=qq&amp;menu=yes">

				<img class="fix_yuan_img" src="/com/img/indexqq.png">

				<div class="fix_yuan_text">QQ客服</div>

				<div class="indexecontect"><?php echo $sbase['qq']; ?></div>

			</a>

    	</div>

    	<div class="fix_yuan fix_wx" style="background-color: #3DCB86">

    		<img class="fix_yuan_img" src="/com/img/index_wx.png">

			<div class="fix_yuan_text">微信演示</div>

			<div class="fix_wx1">

    		<img class="indexewm" src="<?php echo $sbase['ewm']; ?>">

			</div>

    	</div>

    	<div class="fix_yuan fix_top" style="background-color: rgb(220, 220, 220); display: none;">

    		<img class="fix_yuan_img" src="/com/img/index_top.png">

			<div class="fix_yuan_text">置顶</div>

    	</div>

    </div>

    <script type="text/javascript">

    	$(document).scroll(function() {

  			var scrollTop = $(document).scrollTop();

  			if(scrollTop>0){

	    		$('.fix_top').show();

	    	}else{

	    		$('.fix_top').hide();

	    	}

		});

		$('.fix_top').click(function(){

		 $('html,body').animate({scrollTop:0},1000)

		});

    </script>

    <div class="bannerbox">

    		

			<div class="tempWrap" style="overflow:hidden; position:relative; width:1903px">
				<div class="bannerbd" style="width: 7612px; left: -5709px; position: relative; overflow: hidden; padding: 0px; margin: 0px;">
					<?php if($sbase['banner']['banner1'] != ""): ?>
					<div class="banner1"  style=" background: url('<?php echo $sbase['banner']['banner1']; ?>') top center no-repeat; float: left; width: 1903px;">

						<div class="main">

							<div class="banner1_div1"><?php echo $sbase['banner']['banner1_t1']; ?></div>

							<div class="banner1_div2"><?php echo $sbase['banner']['banner1_t2']; ?></div>

						</div>

					</div>
					<?php endif; if($sbase['banner']['banner2'] != ""): ?>
					<div class="banner2"  style=" background: url('<?php echo $sbase['banner']['banner2']; ?>') top center no-repeat; float: left; width: 1903px;">

						<div class="main">

							<div class="banner1_div1"><?php echo $sbase['banner']['banner2_t1']; ?></div>

							<div class="banner1_div2"><?php echo $sbase['banner']['banner2_t2']; ?></div>

						</div>

					</div>
					<?php endif; if($sbase['banner']['banner3'] != ""): ?>
					<div class="banner3"  style=" background: url('<?php echo $sbase['banner']['banner3']; ?>') top center no-repeat; float: left; width: 1903px;">

						<div class="main">

							<div class="banner1_div1"><?php echo $sbase['banner']['banner3_t1']; ?></div>

							<div class="banner1_div2"><?php echo $sbase['banner']['banner3_t2']; ?></div>

						</div>

					</div>
					<?php endif; ?>

				</div>
			</div>

			<div class="bannerhd">

				<ul>
					<?php if($sbase['bannernum'] == 1): ?>
					<li class="on"></li>
					<?php elseif($sbase['bannernum'] == 2): ?>
					<li class="on"></li>
					<li class=""></li>
					<?php elseif($sbase['bannernum'] == 3): ?>
					<li class="on"></li>
					<li class=""></li>
					<li class=""></li>
					<?php endif; ?>

				</ul>

			</div>

			<div class="prev">

				<img src="/com/img/index_banner_zjt.png">

			</div>

			<div class="next">

				<img src="/com/img/index_banner_zjt.png"> 

			</div>

		</div>


		<div class="advantagebox">

			<div class="advantage main">

				<div class="advantage_cn">我们的优势</div>

				<div style="margin-top: 10px;font-size: 14px;color: #838383;text-align: center;">

					无需编程，各行业模版直接套用，一键生成，轻松搭建小程序

				</div>

				<div class="advantageall clearfix">

				<div class="advantage_single hbj">

					<div class="advantage_single_div">界面自由DIY，<br>打造个性小程序</div>

					<img class="block" src="/com/img/home_advantage1.png" style="margin-left: 50px;">

					<a href="javascript:;" class="advantage_link">可拖拽式DIY布局，开启自定义功能新征程，无需繁琐操作，轻松拖拽即可实现界面布局；同步实时预览，可视化操作让您所见即所得，随心打造个性小程序。</a>

				</div>

				<div class="advantage_single hbj">

					<div class="advantage_single_div">丰富功能组件，<br>适应多种场景需求</div>

					<img class="block" src="/com/img/home_advantage2.png">

					<a href="javascript:;" class="advantage_link">多样的功能组件，不受行业框架限制，可自由组合适应当前场景，让您轻松满足客户的定制需求。</a>

				</div>

				<div class="advantage_single hbj">

					<div class="advantage_single_div">大量插件可用，<br>实现多样营销功能</div>

					<img class="block" src="/com/img/home_advantage3.png" style="margin-left: 28px;">

					<a href="javascript:;" class="advantage_link">积分签到、积分兑换商城、拼团、店内点餐、手机客服等插件可用，满足各种行业场景营销需求，助力客户小程序营销推广。</a>

				</div>

				<div class="advantage_single hbj">

					<div class="advantage_single_div">无需技术基础，<br>轻松玩转小程序</div>

					<img class="block" src="/com/img/home_advantage4.png" style="margin-left: 45px;">

					<a href="javascript:;" class="advantage_link">无需代码编程，无需技术基础，简单的操作页面，清晰的模块分划，详尽的功能组件，让您短时间即可轻松玩转小程序。</a>

				</div>

				<div class="advantage_single hbj">

					<div class="advantage_single_div">垂直研发，深度<br>挖掘行业解决方案</div>

					<img class="block" src="/com/img/home_advantage5.png" style="margin-left: 40px;">

					<a href="javascript:;" class="advantage_link">深入行业了解不同行业的痛点和需求，致力于解决实际问题，给客户带来实际价值，深度挖掘不同行业的解决方案。</a>

				</div>

				<div class="advantage_single hbj">

					<div class="advantage_single_div">售后支持，<br>全面解决后顾之忧</div>

					<img class="block" src="/com/img/home_advantage6.png" style="margin-left: 30px;">

					<a href="javascript:;" class="advantage_link">降低小程序准入门槛，我们提供全面的技术支撑，配置服务器、修复BUG无需困扰，更有售后交流群以及7×24h的客户服务，全面解决您的后顾之忧。</a>

				</div>

			</div>

			</div>

			

		</div>

		<div class="fun_box">

			<div class="fun main">

				<div class="advantage_cn">功能介绍</div>

				<div class="funall clearfix">

					<?php foreach($func as $res): ?>

					<a href="<?php echo Url('Comhome/functionshow/show'); ?>?id=<?php echo $res['id']; ?>" class="fun_single clearfix">

						<div class="fun_single_left iconfont <?php echo $res['icon']; ?> fl"></div>

						<div class="fun_single_right fl">

							<div class="fun_single_right_div1"><?php echo $res['title']; ?></div>

							<div class="fun_single_right_div2"><?php echo $res['descs']; ?></div>

						</div>

					</a>
					<?php endforeach; ?>

					
										

				</div>

				<a class="viewfunall" href="<?php echo Url('Comhome/functionshow/index'); ?>">VIEW ALL FUNCTION</a>

			</div>

		</div>

		<div class="index_div" style="background: url('/com/img/slide.png') center no-repeat;height:280px"></div>

		

		<div class="casebox">

			<div class="main">

				<div class="advantage_cn">成功案例</div>

 				<div class="case_box clearfix">

					<div class="case">

						<img class="case_img1" src="/com/img/case1.png">

						<img class="case_img2" src="/com/img/casec1.png">

					</div>

					<div class="case">

						<img class="case_img1" src="/com/img/case2.png">

						<img class="case_img2" src="/com/img/casec2.png">

					</div>

					<div class="case">

						<img class="case_img1" src="/com/img/case3.png">

						<img class="case_img2" src="/com/img/casec3.png">

					</div>

					<div class="case" style="border-right: 0;">

						<img class="case_img1" src="/com/img/case4.png">

						<img class="case_img2" src="/com/img/casec4.png">

					</div>

					<div class="case" style="border-bottom: 0;">

						<img class="case_img1" src="/com/img/case5.png">

						<img class="case_img2" src="/com/img/casec5.png">

					</div>

					<div class="case" style="border-bottom: 0;">

						<img class="case_img1" src="/com/img/case6.png">

						<img class="case_img2" src="/com/img/casec6.png">

					</div>

					<div class="case" style="border-bottom: 0;">

						<img class="case_img1" src="/com/img/case7.png">

						<img class="case_img2" src="/com/img/casec7.png">

					</div>

					<div class="case" style="border-right: 0;border-bottom: 0;">

						<img class="case_img1" src="/com/img/case8.png">

						<img class="case_img2" src="/com/img/casec8.png">

					</div>

					<div class="case" style="border-bottom: 0;">

						<img class="case_img1" src="/com/img/case9.png">

						<img class="case_img2" src="/com/img/casec9.png">

					</div>

					<div class="case" style="border-bottom: 0;">

						<img class="case_img1" src="/com/img/case10.png">

						<img class="case_img2" src="/com/img/casec10.png">

					</div>

					<div class="case" style="border-bottom: 0;">

						<img class="case_img1" src="/com/img/case11.png">

						<img class="case_img2" src="/com/img/casec11.png">

					</div>

					<div class="case" style="border-right: 0;border-bottom: 0;">

						<img class="case_img1" src="/com/img/case12.png">

						<img class="case_img2" src="/com/img/casec12.png">

					</div>

				</div>

			</div>

		</div>

		<div class="newsbox">

			<div class="main">

				<div class="advantage_cn">最新资讯</div>

				<div class="news clearfix">

					<div class="news_single">

						<div class="news_single_img">

							<img class="block" src="/com/img/index_news1.jpg">

							<div>产品动态</div>

						</div>

						<ul class="news_single_ul1">
						<?php foreach($news1 as $res): ?>
							<li>
								<?php echo $res['createtime']; ?> <a href="<?php echo Url('Comhome/news/show'); ?>?id=<?php echo $res['id']; ?>"><?php echo $res['title']; ?></a>
							</li>
						<?php endforeach; ?>
						</ul>
						<a class="news_single_link" href="<?php echo Url('Comhome/news/index'); ?>">view more</a> 
					</div>

					<div class="news_single">

						<div class="news_single_img">

							<img class="block" src="/com/img/index_news2.jpg">

							<div>企业公告</div>

						</div>


						<ul class="news_single_ul1">
						<?php foreach($news2 as $res): ?>
							<li>
								<?php echo $res['createtime']; ?> <a href="<?php echo Url('Comhome/news/showgg'); ?>?id=<?php echo $res['id']; ?>"><?php echo $res['title']; ?></a>
							</li>
						<?php endforeach; ?>
						</ul>
						<a class="news_single_link" href="<?php echo Url('Comhome/news/gg'); ?>">view more</a> 

					</div>

					<div class="news_single">

						<div class="news_single_img">

							<img class="block" src="/com/img/index_news3.jpg">

							<div>更新日志</div>

						</div>

						<ul class="news_single_ul1">
						<?php foreach($news3 as $res): ?>
							<li>
								<?php echo $res['createtime']; ?> <a href="<?php echo Url('Comhome/news/update'); ?>"><?php echo $res['title']; ?></a>
							</li>
						<?php endforeach; ?>
						</ul>
						<a class="news_single_link" href="<?php echo Url('Comhome/news/update'); ?>">view more</a> 

					</div>

				</div>

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

                        <a href="https://s.click.taobao.com/s5NmkAw/">阿里云</a>

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

    </body>

</html>