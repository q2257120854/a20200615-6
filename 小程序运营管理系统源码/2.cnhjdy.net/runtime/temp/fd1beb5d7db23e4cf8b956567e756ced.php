<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:69:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\fx\base.html";i:1575814736;s:73:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\head.html";i:1575814741;s:72:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\top.html";i:1575814741;s:73:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\left.html";i:1575814741;s:78:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\foot_more.html";i:1575814741;}*/ ?>
<!DOCTYPE html>

<head>

	<meta charset="utf-8" />
	<title><?php echo APP_COMPANY; ?></title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />

	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

	<link href="/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css"/>

	<link href="/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>

	<link href="/css/style-metro.css" rel="stylesheet" type="text/css"/>

	<link href="/css/style.css" rel="stylesheet" type="text/css"/>

	<link href="/css/style-responsive.css" rel="stylesheet" type="text/css"/>

	<link href="/css/default.css" rel="stylesheet" type="text/css" id="style_color"/>

	<link href="/css/uniform.default.css" rel="stylesheet" type="text/css"/>

	<link rel="stylesheet" type="text/css" href="/css/bootstrap-fileupload.css" />

	<link rel="stylesheet" type="text/css" href="/css/jquery.gritter.css" />

	<link rel="stylesheet" type="text/css" href="/css/chosen.css" />

	<link rel="stylesheet" type="text/css" href="/css/select2_metro.css" />

	<link rel="stylesheet" type="text/css" href="/css/jquery.tagsinput.css" />

	<link rel="stylesheet" type="text/css" href="/css/clockface.css" />

	<link rel="stylesheet" type="text/css" href="/css/bootstrap-wysihtml5.css" />

	<link rel="stylesheet" type="text/css" href="/css/datepicker.css" />

	<link rel="stylesheet" type="text/css" href="/css/timepicker.css" />

	<link rel="stylesheet" type="text/css" href="/css/colorpicker.css" />

	<link rel="stylesheet" type="text/css" href="/css/bootstrap-toggle-buttons.css" />

	<link rel="stylesheet" type="text/css" href="/css/daterangepicker.css" />

	<link rel="stylesheet" type="text/css" href="/css/datetimepicker.css" />

	<link rel="stylesheet" type="text/css" href="/css/multi-select-metro.css" />

	<link href="/css/bootstrap-modal.css" rel="stylesheet" type="text/css"/>

	<link rel="stylesheet" type="text/css" href="/webuploader/css/webuploader.css" />

	<link href="/css/wnmh.css" rel="stylesheet" type="text/css"/>

	<script src="/js/jquery.js" type="text/javascript"></script>
	
	<script src="/js/clipboard.min.js" type="text/javascript"></script>
	
</head>



<body class="page-header-fixed">
	
<!-- 导航 -->

	<!-- <div class="header navbar navbar-inverse navbar-fixed-top">

		<div class="navbar-inner">

			<div class="container-fluid">

				<a class="brand" href="<?php echo Url('Applet/index'); ?>" style="padding-left:20px;">

				<?php echo APP_COMPANY; ?>

				</a>


				<a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">

				<img src="/image/menu-toggler.png" alt="" />

				</a>          
          
				<ul class="nav pull-right">

					<li class="dropdown user">

						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<?php if(\think\Session::get('icon')): ?>
							<img alt="" src="<?php echo \think\Session::get('icon'); ?>" style="width:29px; height:29px;"/> 
						<?php else: ?>
							<img alt="" src="/image/avatar1_small.jpg" style="width:29px; height:29px;" />
						<?php endif; ?>

						<span class="username">
							<?php echo \think\Session::get('name'); ?>
						</span>

						<i class="icon-angle-down"></i>

						</a>

						<ul class="dropdown-menu">

							<li><a href="<?php echo Url('User/index'); ?>"><i class="icon-user"></i>个人中心</a></li>
							<li><a href="<?php echo Url('Login/index'); ?>"><i class="icon-key"></i>退出</a></li>

						</ul>

					</li>

				</ul>


			</div>

		</div>

	</div>
	 -->
	<div class="page-container">
	<link rel="stylesheet" href="/css/index.css">
<link rel="stylesheet" href="/css/web-icons/web-icons.css">
<style>
ul{margin:0;}
.btncolor{background: #ffffff;color:#333333;border:1px solid #e7e7e7;}
</style>
<div class="asidebox clearfix">
  <div class="aside1">
      <a class="logo" href="<?php echo Url('Applet/index'); ?>">
      <img src="<?php echo $applet['thumb']; ?>" class="logoimg"></a>
      <nav class="aside1_nav">
        <ul>
          <?php
            $node_id = $_SESSION['node_id'];
         if(in_array('1', $node_id)): ?>
          <li class="" id="dataShow">
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-pie-chart"></i>总览</a>
          </li>
          <?php endif; if(in_array('3', $node_id)): ?>
          <li class="" id="navCon">
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-list"></i>内容</a>
          </li>
          <?php endif; if(in_array('19', $node_id)): ?>
          <li class="" id="navOrder">
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-order"></i>订单</a>
          </li>
          <?php endif; if(in_array('24', $node_id)): ?>
          <li class="" id="navVIP">
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-user"></i>会员</a>
          </li>
          <?php endif; if(in_array('39', $node_id)): ?>
          <li class="" id="navStore">
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-map"></i>门店</a>
          </li>
          <?php endif; if(in_array('42', $node_id)): ?>
          <li class="" id="navSale">
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-star"></i>营销</a>
          </li>
          <?php endif; if(in_array('62', $node_id)): ?>
          <li class="" id="navFx">
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-users"></i>分销</a>
          </li>
          <?php endif; if(in_array('73', $node_id)): ?>
          <li class="" id='navDIY'>
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-layout"></i>DIY</a>
          </li>
          <?php endif; if(in_array('85', $node_id)): ?>
          <li class="" id="navSystem">
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-settings"></i>系统</a>
          </li>
          <?php endif; if(in_array('104', $node_id)): ?>
          <li class="" id="navModel">
            <a class="aside1_nav_a1" href="javascript:;">
              <i class="wb-settings"></i>模块</a>
          </li>
          <?php endif; if(in_array('137', $node_id)): ?>
          <li class="" id="navHelp">
            <a class="aside1_nav_a1"  href="javascript:;">
              <i class="wb-help-circle"></i>帮助</a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
  </div>
  <div class="aside2 sidebar-2">
    <div class="aside2_title">功能列表</div>
    <nav class="aside2_nav dataShow" style="display: none">
      <ul>
        <?php if(in_array('2', $node_id)): ?>
        <li class="dataShow1">
          <i></i>
          <a href="<?php echo Url('Datashow/index'); ?>?appletid=<?php echo $_GET['appletid']?>">数据预览</a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <nav class="aside2_nav navCon" style="display: none">
      <ul>
        <?php if(in_array('4', $node_id)): ?>
        <li class="navCon1">
          <i></i>
          <a href="<?php echo Url('Cate/index'); ?>?appletid=<?php echo $_GET['appletid']?>">栏目管理</a>
        </li>
        <?php endif; if(in_array('5', $node_id)): ?>
        <li class="navCon2">
          <i></i>
          <a href="<?php echo Url('Products/index'); ?>?appletid=<?php echo $_GET['appletid']?>">预约预定商品</a>
        </li>
        <?php endif; if(in_array('6', $node_id)): ?>
        <li class="navCon3">
          <i></i>
          <a href="<?php echo Url('Products/pro'); ?>?appletid=<?php echo $_GET['appletid']?>">秒杀商品</a>
        </li>
        <?php endif; if(in_array('7', $node_id)): ?>
        <li class="navCon4">
          <i></i>
          <a href="<?php echo Url('News/index'); ?>?appletid=<?php echo $_GET['appletid']?>">文章管理</a>
        </li>
        <?php endif; if(in_array('8', $node_id)): ?>
        <li class="navCon5">
          <i></i>
          <a href="<?php echo Url('Duoproducts/index'); ?>?appletid=<?php echo $_GET['appletid']?>">多规格商品</a>
        </li>
        <?php endif; if(in_array('9', $node_id)): ?>
        <li class="navCon6">
          <i></i>
          <a href="<?php echo Url('Pictures/index'); ?>?appletid=<?php echo $_GET['appletid']?>">组图管理</a>
        </li>
        <?php endif; if(in_array('10', $node_id)): ?>
        <li class="navCon7">
          <i></i>
          <a href="<?php echo Url('Wxapps/index'); ?>?appletid=<?php echo $_GET['appletid']?>">小程序管理</a>
        </li>
        <?php endif; if(in_array('11', $node_id)): ?>
        <li class="navCon8">
          <i></i>
          <a href="<?php echo Url('Pinglun/index'); ?>?appletid=<?php echo $_GET['appletid']?>">评论管理</a>
        </li>
        <?php endif; if(in_array('12', $node_id)): ?>
        <li class="navCon9">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navCon9-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>文章底部菜单</span>
        </a>
              <?php if(in_array('13', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navCon9-1" href="<?php echo Url('News/navs'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>菜单组</span>
            </a>
          </div>
              <?php endif; if(in_array('14', $node_id)): ?>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navCon9-2" href="<?php echo Url('News/nav'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>菜单</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('15', $node_id)): ?>
        <li class="navCon10">
      <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i class="active"></i>
        <a class="nav-item child-item navCon10-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>多栏目</span>
        </a>
        <?php if(in_array('17', $node_id)): ?>
        <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navCon10-1" href="<?php echo Url('Multicate/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>管理</span>
            </a>
          </div>
        <?php endif; if(in_array('18', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navCon10-2" href="<?php echo Url('Multicate/multikey'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>筛选条件</span>
            </a>
          </div>
        <?php endif; ?>
      </div>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <nav class="aside2_nav navOrder" style="display: none">
      <ul>
        <?php if(in_array('20', $node_id)): ?>
        <li class="navOrder1">
          <i></i>
          <a href="<?php echo Url('Orderlist/index'); ?>?appletid=<?php echo $_GET['appletid']?>">限时秒杀订单</a>
        </li>
        <?php endif; if(in_array('21', $node_id)): ?>
        <li class="navOrder2">
          <i></i>
          <a href="<?php echo Url('Orderlist/yuyue'); ?>?appletid=<?php echo $_GET['appletid']?>">预约预定订单</a>
        </li>
        <?php endif; if(in_array('22', $node_id)): ?>
        <li class="navOrder3">
          <i></i>
          <a href="<?php echo Url('Orderlist/video'); ?>?appletid=<?php echo $_GET['appletid']?>">付费视频订单</a>
        </li>
        <?php endif; if(in_array('23', $node_id)): ?>
        <li class="navOrder4">
          <i></i>
          <a href="<?php echo Url('Duoproducts/order'); ?>?appletid=<?php echo $_GET['appletid']?>">多规格订单</a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <nav class="aside2_nav navVIP" style="display: none">
      <ul>
        <?php if(in_array('25', $node_id)): ?>
        <li class="navVIP1">
          <i></i>
          <a href="<?php echo Url('Wxuser/index'); ?>?appletid=<?php echo $_GET['appletid']?>">会员管理</a>
        </li>
        <?php endif; if(in_array('26', $node_id)): ?>
        <li class="navVIP2">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navVIP2-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>消费流水</span>
        </a>
              <?php if(in_array('27', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP2-1" href="<?php echo Url('Wxuser/moneyturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=display">
              <span>全部</span>
            </a>
          </div>
              <?php endif; if(in_array('28', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP2-2" href="<?php echo Url('Wxuser/moneyturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=get">
              <span>获取记录</span>
            </a>
          </div>
              <?php endif; if(in_array('29', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP2-3" href="<?php echo Url('Wxuser/moneyturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=spend">
              <span>消费记录</span>
            </a>
          </div>
              <?php endif; if(in_array('30', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP2-4" href="<?php echo Url('Wxuser/moneyturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=store">
              <span>店内支付</span>
            </a>
          </div>
              <?php endif; if(in_array('144', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP2-5" href="<?php echo Url('Wxuser/moneyturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=forum">
              <span>微同城流水</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('31', $node_id)): ?>
        <li class="navVIP3">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navVIP3-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>积分流水</span>
        </a>
              <?php if(in_array('32', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP3-1" href="<?php echo Url('Wxuser/scoreturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=display">
              <span>全部</span>
            </a>
          </div>
              <?php endif; if(in_array('33', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP3-2" href="<?php echo Url('Wxuser/scoreturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=cz">
              <span>充值获得</span>
            </a>
          </div>
              <?php endif; if(in_array('34', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP3-3" href="<?php echo Url('Wxuser/scoreturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=xf">
              <span>消费抵扣</span>
            </a>
          </div>
              <?php endif; if(in_array('35', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP3-4" href="<?php echo Url('Wxuser/scoreturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=qd">
              <span>签到获得</span>
            </a>
          </div>
              <?php endif; if(in_array('36', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP3-5" href="<?php echo Url('Wxuser/scoreturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=fx">
              <span>分享获得</span>
            </a>
          </div>
              <?php endif; if(in_array('37', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navVIP3-6" href="<?php echo Url('Wxuser/scoreturnove'); ?>?appletid=<?php echo $_GET['appletid']?>&op=store">
              <span>店内抵扣</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('38', $node_id)): ?>
        <li class="navVIP4">
          <i></i>
          <a href="<?php echo Url('Wxuser/registerrecord'); ?>?appletid=<?php echo $_GET['appletid']?>">开卡记录</a>
        </li>
        <?php endif; if(in_array('148', $node_id)): ?>
        <li class="navVIP5">
          <i></i>
          <a href="<?php echo Url('Wxuser/apply'); ?>?appletid=<?php echo $_GET['appletid']?>">申请记录</a>
        </li>
        <?php endif; if(in_array('55', $node_id)): ?>
        <li class="navVIP6">
          <i></i>
          <a href="<?php echo Url('Vipset/index'); ?>?appletid=<?php echo $_GET['appletid']?>">会员卡设置</a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <nav class="aside2_nav navStore" style="display: none">
      <ul>
        <?php if(in_array('40', $node_id)): ?>
        <li class="navStore1">
          <i></i>
          <a href="<?php echo Url('Shops/baseset'); ?>?appletid=<?php echo $_GET['appletid']?>">基础设置</a>
        </li>
        <?php endif; if(in_array('41', $node_id)): ?>
        <li class="navStore2">
          <i></i>
          <a href="<?php echo Url('Shops/index'); ?>?appletid=<?php echo $_GET['appletid']?>">列表管理</a>
        </li>
        <?php endif; if(in_array('149', $node_id)): ?>
        <li class="navStore3">
          <i></i>
          <a href="<?php echo Url('Shops/staff'); ?>?appletid=<?php echo $_GET['appletid']?>">员工管理</a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <nav class="aside2_nav navSale" style="display: none">
      <ul>
        <?php if(in_array('43', $node_id)): ?>
        <li class="navSale1">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navSale1-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>优惠券</span>
        </a>
              <?php if(in_array('45', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale1-1" href="<?php echo Url('Coupon/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>管理</span>
            </a>
          </div>
              <?php endif; if(in_array('46', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale1-2" href="<?php echo Url('Coupon/set'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>设置</span>
            </a>
          </div>
              <?php endif; if(in_array('47', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale1-3" href="<?php echo Url('Coupon/userrecord'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>领取记录</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('48', $node_id)): ?>
        <li class="navSale2">
          <i></i>
          <a href="<?php echo Url('Coupon/hxmm'); ?>?appletid=<?php echo $_GET['appletid']?>">核销密码</a>
        </li>
        <?php endif; if(in_array('49', $node_id)): ?>
        <li class="navSale3">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navSale3-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>充值管理</span>
        </a>
              <?php if(in_array('50', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale3-1" href="<?php echo Url('Cz/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>充值管理</span>
            </a>
          </div>
              <?php endif; if(in_array('51', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale3-2" href="<?php echo Url('Cz/guiz'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>充值规则</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('52', $node_id)): ?>
        <li class="navSale4">
          <i></i>
          <a href="<?php echo Url('Sharejf/index'); ?>?appletid=<?php echo $_GET['appletid']?>">分享积分</a>
        </li>
        <?php endif; if(in_array('53', $node_id)): ?>
        <li class="navSale5">
          <i></i>
          <a href="<?php echo Url('Scorerecord/index'); ?>?appletid=<?php echo $_GET['appletid']?>">积分流水</a>
        </li>
        <?php endif; if(in_array('54', $node_id)): ?>
        <li class="navSale6">
          <i></i>
          <a href="<?php echo Url('Duoproductsset/index'); ?>?appletid=<?php echo $_GET['appletid']?>">商品设置</a>
        </li>
        <?php endif; if(in_array('56', $node_id)): ?>
    <li class="navSale8">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navSale8-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>表单</span>
        </a>
              <?php if(in_array('57', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale8-1" href="<?php echo Url('Order/xinx'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>万能预约信息列表</span>
            </a>
          </div>
              <?php endif; if(in_array('58', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale8-2" href="<?php echo Url('Order/wnlist'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>万能表单列表</span>
            </a>
          </div>
              <?php endif; if(in_array('59', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale8-3" href="<?php echo Url('Order/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>系统预约信息列表</span>
            </a>
          </div>
              <?php endif; if(in_array('60', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale8-4" href="<?php echo Url('Order/add'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>系统预约配置</span>
            </a>
          </div>
              <?php endif; if(in_array('61', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navSale8-5" href="<?php echo Url('Order/emailset'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>提醒接收人</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('138', $node_id)): ?>
        <li class="navSale9">
          <i></i>
          <a href="<?php echo Url('Delmoney/index'); ?>?appletid=<?php echo $_GET['appletid']?>">满额立减</a>
        </li>
        <?php endif; if(in_array('147', $node_id)): ?>
        <li class="navSale10">
          <i></i>
          <a href="<?php echo Url('Shake/jfrule'); ?>?appletid=<?php echo $_GET['appletid']?>">积分规则</a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <nav class="aside2_nav navFx" style="display: none">
      <ul>
        <?php if(in_array('63', $node_id)): ?>
        <li class="navFx1">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navFx1-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>分销设置</span>
        </a>
              <?php if(in_array('64', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navFx1-1" href="<?php echo Url('Fx/base'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>基本设置</span>
            </a>
          </div>
              <?php endif; if(in_array('65', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navFx1-2" href="<?php echo Url('Fx/relation'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>上下级关系及分销资格</span>
            </a>
          </div>
              <?php endif; if(in_array('66', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navFx1-3" href="<?php echo Url('Fx/agree'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>分销商申请协议</span>
            </a>
          </div>
              <?php endif; if(in_array('67', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navFx1-4" href="<?php echo Url('Fx/extension'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>分销推广</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('68', $node_id)): ?>
        <li class="navFx2">
          <i></i>
          <a href="<?php echo Url('Fx/dealer'); ?>?appletid=<?php echo $_GET['appletid']?>">分销商管理</a>
        </li>
        <?php endif; if(in_array('69', $node_id)): ?>
        <li class="navFx3">
          <i></i>
          <a href="<?php echo Url('Fx/order'); ?>?appletid=<?php echo $_GET['appletid']?>">分销订单</a>
        </li>
        <?php endif; if(in_array('70', $node_id)): ?>
        <li class="navFx4">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navFx4-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>分销提现管理</span>
        </a>
              <?php if(in_array('71', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navFx4-1" href="<?php echo Url('Fx/txreply'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>提现申请</span>
            </a>
          </div>
              <?php endif; if(in_array('72', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navFx4-2" href="<?php echo Url('Fx/txset'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>提现设置</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <nav class="aside2_nav navDIY" style="display: none">
      <ul>
        <?php if(in_array('74', $node_id)): ?>
        <li class="navDIY1">
          <i></i>
          <a href="<?php echo Url('Stylediy/diyset'); ?>?appletid=<?php echo $_GET['appletid']?>">DIY设置</a>
        </li>
        <?php endif; if(in_array('75', $node_id)): ?>
        <li class="navDIY2">
          <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
          <i></i>
          <a class="nav-item child-item navDIY2-0" href="javascript:;">
            <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
            <span>默认首页</span>
          </a>
            <?php if(in_array('76', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navDIY2-1" href="<?php echo Url('Stylediy/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>样式DIY</span>
              </a>
            </div>
            <?php endif; if(in_array('77', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navDIY2-2" href="<?php echo Url('Adv/adv'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>幻灯片设置</span>
              </a>
            </div>
            <?php endif; if(in_array('78', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navDIY2-3" href="<?php echo Url('Adv/kadv'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>开屏广告</span>
              </a>
            </div>
            <?php endif; if(in_array('79', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navDIY2-4" href="<?php echo Url('Adv/sadv'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>弹窗广告</span>
              </a>
            </div>
            <?php endif; if(in_array('80', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navDIY2-5" href="<?php echo Url('Adv/tadv'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>首页广告</span>
              </a>
            </div>
            <?php endif; if(in_array('81', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navDIY2-6" href="<?php echo Url('Nav/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>导航设置</span>
              </a>
            </div>
            <?php endif; if(in_array('82', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navDIY2-7" href="<?php echo Url('Nav/navlist'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>自定义导航</span>
              </a>
            </div>
            <?php endif; if(in_array('83', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navDIY2-8" href="<?php echo Url('Copyright/demo'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>一键模板</span>
              </a>
            </div>
            <?php endif; ?>
          </div>
        </li>
        <?php endif; if(in_array('84', $node_id)): ?>
        <li class="navDIY3">
          <i></i>
          <a href="<?php echo Url('Diypage/moban'); ?>?appletid=<?php echo $_GET['appletid']?>">DIY布局</a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <nav class="aside2_nav navSystem" style="display: none">
      <ul>
        <?php if(in_array('86', $node_id)): ?>
        <li class="active2 navSystem1">
          <i></i>
          <a href="<?php echo Url('Index/index'); ?>?appletid=<?php echo $_GET['appletid']?>">基础设置</a>
        </li>
        <?php endif; if(in_array('87', $node_id)): ?>
        <li class="navSystem2">
          <i></i>
          <a href="<?php echo Url('About/index'); ?>?appletid=<?php echo $_GET['appletid']?>">公司介绍</a>
        </li>
        <?php endif; if(in_array('88', $node_id)): ?>
        <li class="navSystem3">
          <i></i>
          <a href="<?php echo Url('Usercenter/index'); ?>?appletid=<?php echo $_GET['appletid']?>">个人中心</a>
        </li>
        <?php endif; if(in_array('89', $node_id)): ?>
        <li class="navSystem4">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
            <i></i>
            <a class="nav-item child-item navSystem4-0" href="javascript:;">
              <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
              <span>底部菜单</span>
            </a>
              <?php if(in_array('90', $node_id)): ?>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                <a class="nav-item navSystem4-1" href="<?php echo Url('Menu/newfoot'); ?>?appletid=<?php echo $_GET['appletid']?>">
                  <span>新版菜单</span>
                </a>
              </div>
              <?php endif; if(in_array('91', $node_id)): ?>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                <a class="nav-item navSystem4-2" href="<?php echo Url('Menu/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
                  <span>老版菜单</span>
                </a>
              </div>
              <?php endif; ?>
          </div>
        </li>
        <?php endif; if(in_array('93', $node_id)): ?>
        <li class="navSystem5">
          <i></i>
          <a href="<?php echo Url('Copyright/index'); ?>?appletid=<?php echo $_GET['appletid']?>">版权管理</a>
        </li>
        <?php endif; if(in_array('26', $node_id)): ?>
        <li class="navSystem6">
          <i></i>
          <a href="<?php echo Url('Copyright/comment'); ?>?appletid=<?php echo $_GET['appletid']?>">版权内容</a>
        </li>
        <?php endif; if(in_array('94', $node_id)): ?>
        <li class="navSystem7">
          <i></i>
          <a href="<?php echo Url('Copyright/mail'); ?>?appletid=<?php echo $_GET['appletid']?>">邮箱配置</a>
        </li>
        <?php endif; if(in_array('95', $node_id)): ?>
        <li class="navSystem8">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
            <i></i>
            <a class="nav-item child-item navSystem8-0" href="javascript:;">
              <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
              <span>模板消息</span>
            </a>
              <?php if(in_array('96', $node_id)): ?>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                <a class="nav-item navSystem8-1" href="<?php echo Url('Message/msg_pay'); ?>?appletid=<?php echo $_GET['appletid']?>">
                  <span>支付通知</span>
                </a>
              </div>
              <?php endif; if(in_array('97', $node_id)): ?>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                <a class="nav-item navSystem8-2" href="<?php echo Url('Message/msg_form'); ?>?appletid=<?php echo $_GET['appletid']?>">
                  <span>系统表单通知</span>
                </a>
              </div>
              <?php endif; if(in_array('98', $node_id)): ?>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                <a class="nav-item navSystem8-3" href="<?php echo Url('Message/msg_yue'); ?>?appletid=<?php echo $_GET['appletid']?>">
                  <span>预约通知</span>
                </a>
              </div>
              <?php endif; if(in_array('99', $node_id)): ?>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                <a class="nav-item navSystem8-4" href="<?php echo Url('Message/msg_duo'); ?>?appletid=<?php echo $_GET['appletid']?>">
                  <span>多规格订单通知</span>
                </a>
              </div>
              <?php endif; if(in_array('100', $node_id)): ?>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                <a class="nav-item navSystem8-5" href="<?php echo Url('Message/msg_pt'); ?>?appletid=<?php echo $_GET['appletid']?>">
                  <span>拼团订单通知</span>
                </a>
              </div>
              <?php endif; if(in_array('101', $node_id)): ?>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                <a class="nav-item navSystem8-6" href="<?php echo Url('Message/msg_vip'); ?>?appletid=<?php echo $_GET['appletid']?>">
                  <span>会员卡开通通知</span>
                </a>
              </div>
              <?php endif; ?>
          </div>
        </li>
        <?php endif; if(in_array('102', $node_id)): ?>
        <li class="navSystem9">
          <i></i>
          <a href="<?php echo Url('Stylediy/remote'); ?>?appletid=<?php echo $_GET['appletid']?>">远程附件</a>
        </li>
        <?php endif; if(in_array('103', $node_id)): ?>
        <li class="navSystem10">
          <i></i>
          <a href="<?php echo Url('wxreview/index'); ?>?appletid=<?php echo $_GET['appletid']?>">上传审核</a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <nav class="aside2_nav navModel" style="display: none;">
      <ul>
        <?php if(in_array('105', $node_id)): ?>
      <li class="navModel100">
          <i></i>
          <a href="<?php echo Url('Modals/index'); ?>?appletid=<?php echo $_GET['appletid']?>">应用中心</a>
        </li>
        <?php endif; if(in_array('106', $node_id)): ?>
        <li class="navModel5">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
              <i></i>
              <a class="nav-item child-item navModel5-0" href="javascript:;">
                <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
                <span>拼团</span>
              </a>
              <?php if(in_array('107', $node_id)): ?>
                <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                  <a class="nav-item navModel5-1" href="<?php echo Url('Pt/set'); ?>?appletid=<?php echo $_GET['appletid']?>">
                    <span>拼团设置</span>
                  </a>
                </div>
              <?php endif; if(in_array('108', $node_id)): ?>
                <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                  <a class="nav-item navModel5-2" href="<?php echo Url('Pt/cate'); ?>?appletid=<?php echo $_GET['appletid']?>">
                    <span>栏目设置</span>
                  </a>
                </div>
              <?php endif; if(in_array('109', $node_id)): ?>
                <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                  <a class="nav-item navModel5-3" href="<?php echo Url('Pt/pro'); ?>?appletid=<?php echo $_GET['appletid']?>">
                    <span>商品管理</span>
                  </a>
                </div>
              <?php endif; if(in_array('110', $node_id)): ?>
                <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                  <a class="nav-item navModel5-4" href="<?php echo Url('Pt/order'); ?>?appletid=<?php echo $_GET['appletid']?>">
                    <span>订单管理</span>
                  </a>
                </div>
              <?php endif; if(in_array('111', $node_id)): ?>
                <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                  <a class="nav-item navModel5-5" href="<?php echo Url('Pt/yaoqing'); ?>?appletid=<?php echo $_GET['appletid']?>">
                    <span>成团管理</span>
                  </a>
                </div>
              <?php endif; if(in_array('112', $node_id)): ?>
                <div class="sub-item-list  " data-id="75" style="overflow: visible;">
                  <a class="nav-item navModel5-6" href="<?php echo Url('Pt/tuikuan'); ?>?appletid=<?php echo $_GET['appletid']?>">
                    <span>退款管理</span>
                  </a>
                </div>
              <?php endif; ?>
            </div>
        </li>
        <?php endif; if(in_array('113', $node_id)): ?>
        <li class="navModel2">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navModel2-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>餐饮</span>
        </a>
              <?php if(in_array('114', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel2-1" href="<?php echo Url('Cyindex/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>基础设置</span>
            </a>
          </div>
              <?php endif; if(in_array('115', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel2-2" href="<?php echo Url('Cycate/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>分类管理</span>
            </a>
          </div>
              <?php endif; if(in_array('116', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel2-3" href="<?php echo Url('Cytablenum/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>桌号管理</span>
            </a>
          </div>
              <?php endif; if(in_array('117', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel2-4" href="<?php echo Url('Cygoods/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>商品管理</span>
            </a>
          </div>
              <?php endif; if(in_array('118', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel2-5" href="<?php echo Url('Cyorder/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>订单管理</span>
            </a>
          </div>
              <?php endif; if(in_array('119', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel2-6" href="<?php echo Url('Cprinter/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>打印机设置</span>
            </a>
          </div>
              <?php endif; if(in_array('120', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel2-7" href="<?php echo Url('Cymsg/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>点餐通知</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('121', $node_id)): ?>
        <li class="navModel3">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navModel3-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>积分兑换</span>
        </a>
              <?php if(in_array('122', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel3-1" href="<?php echo Url('Exchangecate/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>栏目管理</span>
            </a>
          </div>
              <?php endif; if(in_array('123', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel3-2" href="<?php echo Url('Exchangegoods/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>商品管理</span>
            </a>
          </div>
              <?php endif; if(in_array('124', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel3-3" href="<?php echo Url('Exchangeorder/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>订单管理</span>
            </a>
          </div>
              <?php endif; if(in_array('125', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel3-4" href="<?php echo Url('Exchangemsg/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>积分兑换通知</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('126', $node_id)): ?>
        <li class="navModel4">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
        <i></i>
        <a class="nav-item child-item navModel4-0" href="javascript:;">
          <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
          <span>积分签到</span>
        </a>
              <?php if(in_array('127', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel4-1" href="<?php echo Url('Signbase/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>基础设置</span>
            </a>
          </div>
              <?php endif; if(in_array('128', $node_id)): ?>
          <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            <a class="nav-item navModel4-2" href="<?php echo Url('Signlist/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
              <span>签到管理</span>
            </a>
          </div>
              <?php endif; ?>
      </div>
        </li>
        <?php endif; if(in_array('129', $node_id)): ?>
        <li class="navModel1">
          <i></i>
          <a href="<?php echo Url('Customers/index'); ?>?appletid=<?php echo $_GET['appletid']?>">手机客服</a>
        </li>
        <?php endif; if(in_array('130', $node_id)): ?>
        <li class="navModel6">
          <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
            <i></i>
            <a class="nav-item child-item navModel6-0" href="javascript:;">
              <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
              <span>全能小程序</span>
            </a>
            <?php if(in_array('131', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navModel6-1" href="<?php echo Url('Powerfulsh/cate'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>分类管理</span>
              </a>
            </div>
            <?php endif; if(in_array('132', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navModel6-2" href="<?php echo Url('Powerfulsh/tenant'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>店铺管理</span>
              </a>
            </div>
            <?php endif; if(in_array('133', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navModel6-3" href="<?php echo Url('Powerfulsh/goods'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>商品管理</span>
              </a>
            </div>
            <?php endif; if(in_array('134', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navModel6-4" href="<?php echo Url('Powerfulsh/order'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>订单管理</span>
              </a>
            </div>
            <?php endif; if(in_array('135', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navModel5-5" href="<?php echo Url('Powerfulsh/withdraw'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>提现管理</span>
              </a>
            </div>
            <?php endif; if(in_array('136', $node_id)): ?>
            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <a class="nav-item navModel6-6" href="<?php echo Url('Powerfulsh/system'); ?>?appletid=<?php echo $_GET['appletid']?>">
                <span>系统设置</span>
              </a>
            </div>
            <?php endif; ?>
          </div>
        </li>
        <?php endif; if(in_array('139', $node_id)): ?>
        <li class="navModel7">
	          <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
	            <i></i>
	            <a class="nav-item child-item navModel7-0" href="javascript:;">
	              <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
	              <span>微同城</span>
	            </a>
	            <div class="sub-item-list  " data-id="75" style="overflow: visible;">
            	<?php if(in_array('140', $node_id)): ?>
	              <a class="nav-item navModel7-1" href="<?php echo Url('Forum/func'); ?>?appletid=<?php echo $_GET['appletid']?>">
	                <span>分类管理</span>
	              </a>
	            <?php endif; if(in_array('141', $node_id)): ?>
	              <a class="nav-item navModel7-2" href="<?php echo Url('Forum/release'); ?>?appletid=<?php echo $_GET['appletid']?>">
	                <span>发布管理</span>
	              </a>
				<?php endif; if(in_array('142', $node_id)): ?>
	              <a class="nav-item navModel7-3" href="<?php echo Url('Forum/comment'); ?>?appletid=<?php echo $_GET['appletid']?>">
	                <span>评论管理</span>
	              </a>
	            <?php endif; if(in_array('143', $node_id)): ?>
	              <a class="nav-item navModel7-4" href="<?php echo Url('Forum/set'); ?>?appletid=<?php echo $_GET['appletid']?>">
	                <span>相关设置</span>
	              </a>
	              <?php endif; ?>
	            </div>
	          </div>
        </li>
		<?php endif; if(in_array('145', $node_id)): ?>
        <li class="navModel8">
            <div class="sidebar-content" style="width: 100%;margin:0" id="aaa">
              <i></i>
              <a class="nav-item child-item navModel8-0" href="javascript:;">
                <span class="nav-pointer iconfont icon-play_fill" style="margin-left: 10px"></span>
                <span>摇一摇抽奖全能小程序</span>
              </a>
              <div class="sub-item-list  " data-id="75" style="overflow: visible;">
              <?php if(in_array('146', $node_id)): ?>
                <a class="nav-item navModel8-1" href="<?php echo Url('Shake/index'); ?>?appletid=<?php echo $_GET['appletid']?>">
                  <span>活动管理</span>
                </a>
              <?php endif; ?>
              </div>
            </div>
        </li>
    <?php endif; ?>

      </ul>
    </nav>
    <nav class="aside2_nav navHelp" style="display: none">
      <ul>
        <li>
          <i></i>
          <a href="<?php echo Url('Help/index'); ?>?appletid=<?php echo $_GET['appletid']?>">帮助</a>
        </li>
      </ul>
    </nav>

  </div>
  <script>
  $('.aside1_nav li').click(function(){
    var id = $(this).attr("id");
    $('.aside1_nav li').removeClass("active1");
    $(this).addClass("active1");
    if($('.aside2_nav.'+id+' li a').attr("href")=="javascript:;"){
      window.location.href = $('.aside2_nav.'+id+' li a').eq(1).attr("href");
    }else{
      window.location.href = $('.aside2_nav.'+id+' li a').attr("href");
    }
  });

  $(function(){
    $('.aside1_nav li').removeClass("active1");
    var nowhtml = $("#nowhtml").val();
    $("#"+nowhtml).addClass("active1");
    $('.aside2_nav').hide();
    $('.aside2_nav.'+nowhtml).show();
    $('.aside2_nav.'+nowhtml+' li').eq(0).addClass("active2");
    $('.aside2_nav.'+nowhtml+' li').removeClass("active2");
    var nowclass = $("#nowhtml").attr("class");
    console.log(nowclass);
    if(nowclass.indexOf("-")>=0) { 
      var arr = nowclass.split('-');
      $('.aside2_nav.'+nowhtml+' li.'+arr[0]+" a").removeClass("active");
      $('.aside2_nav.'+nowhtml+' li.'+arr[0]+' a.'+arr[0]+"-0").addClass("active");
      $('.aside2_nav.'+nowhtml+' li.'+arr[0]+' a.'+nowclass).addClass("active");
      $('.aside2_nav.'+nowhtml+' li.'+arr[0]+' .sub-item-list').addClass("active");
      var subtitle = $('.aside2_nav.'+nowhtml+' li.'+arr[0]+' a.'+nowclass+" span").html();
      $(".navbar .content_head_left").html(subtitle);
    }else{
      $('.aside2_nav.'+nowhtml+' li.'+nowclass).addClass("active2");
      var subtitle = $('.aside2_nav.'+nowhtml+' li.'+nowclass+" a").html();
      $(".navbar .content_head_left").html(subtitle);
    }
  });

  $(document).on("click", ".child-item",
    function() {
      if ($(this).hasClass('active')) {
        $(this).removeClass('active');
      } else {
        $(this).addClass('active');
      }
      if ($($(this).parents('li')).find('.sub-item-list').hasClass('active')) {
        $($(this).parents('li')).find('.sub-item-list').removeClass('active');
      } else {
        $($(this).parents('li')).find('.sub-item-list').addClass('active');
        var liclass = $($(this).parents('li')).attr("class");
        var nclass = $("#nowhtml").attr("class");
        if(nclass.indexOf(liclass)>=0){
          $($(this).parents('li')).find('.sub-item-list a.'+nclass).addClass('active');
        }else{
          $($(this).parents('li')).find('.sub-item-list a').addClass('active');
        }
      }
    });

    </script>
  <div class="aside_user">v<?php echo VERSION_APP; ?></div>
</div>
<div class="contentbox">
    <!--主体头start-->
    <div class="content_head clearfix navbar" style="margin-bottom: 0">
        <div class="content_head_left"></div>
       <ul class="nav pull-right">

      <li class="dropdown user">
        <a href="<?php echo Url('Applet/index'); ?>" style="display: inline-block"><返回系统</a>
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="display: inline-block;">
        <?php if(\think\Session::get('icon')): ?>
          <img alt="" src="<?php echo \think\Session::get('icon'); ?>" style="width:29px; height:29px;"/>
        <?php else: ?>
          <img alt="" src="/image/avatar1_small.jpg" style="width:29px; height:29px;" />
        <?php endif; ?>
        <span class="username">
          <?php echo \think\Session::get('name'); ?>
        </span>
        <i class="icon-angle-down"></i>
        </a>
        <ul class="dropdown-menu">
          <li><a href="<?php echo Url('User/index'); ?>"><i class="icon-user"></i>个人中心</a></li>
          <li><a href="<?php echo Url('Login/index'); ?>"><i class="icon-key"></i>退出</a></li>
        </ul>
      </li>
    </ul>
    </div>
	<div style="margin:25px">
	<div class="page-content" id="container">
<style>
.radio input[type="radio"], .checkbox input[type="checkbox"]{
	margin-left: 0
}
</style>
<input type="hidden" id="nowhtml" value="navFx" class="navFx1-1">



	<ul class="breadcrumb">

		<li>

			<i class="icon-home"></i>

			分销基本配置--<?php echo $applet['name']; ?>

		</li>

	</ul>

	<div class="row-fluid">



		<div class="portlet box">





			<div class="portlet-body form">



				<!-- BEGIN FORM-->



				<form action="<?php echo Url('Fx/basesave'); ?>?appletid=<?php echo $_GET['appletid']?>" id="form_sample_2" class="form-horizontal" method="post" enctype="multipart/form-data">
                    <div class="control-group">



                        <label class="control-label">分销商名称 <span style="color: red">*</span></label>



                        <div class="controls">



                            <input name="fxs_name" type="text" class="span3 m-wrap" value="<?php if($item): ?><?php echo $item['fxs_name']; endif; ?>"  style="height: 35px !important;" />

                            <span style="color:#999999; line-height:40px; margin-left:20px;"></span>

                        </div>



                    </div>
					<div class="control-group">
                        <label class="control-label">申请图  <span style="color: red">*</span></label>



                        <div class="controls">



                            <div class="fileupload fileupload-new" data-provides="fileupload">



                                <div class="fileupload-new thumbnail commonuploadpic" style="width: 140px; height:90px;">

                                    <?php if($item && $item['sq_thumb']): ?>
                                    <input type="hidden" value="<?php echo $item['sq_thumb']; ?>" name="sq_thumb2">
                                    <img src="<?php echo $item['sq_thumb']; ?>"/>

                                    <?php else: ?>

                                    <img src="/image/noimage.jpg" alt="" />

                                    <?php endif; ?>

                                </div>
                                <div>
                                    <span class="btn btn-file"><span class="fileupload-new commonchangepic" data-type="1">选择图片<input type="hidden" name="commonuploadpic"></span></span>

                                </div>



                            </div>

                        </div>

                    </div>
					<div class="control-group">

						<label class="control-label">分销层级</label>

						<div class="controls">

							<label class="radio">

							<input type="radio" name="fx_cj" value="4" <?php if($item): if($item['fx_cj']==4): ?>checked=checked<?php endif; else: ?>checked=checked <?php endif; ?>/>

							不启用

							</label>

							<label class="radio">

							<input type="radio" name="fx_cj" value="1" <?php if($item): if($item['fx_cj']==1): ?>checked=checked<?php endif; endif; ?>/>

							一级分销

							</label> 

							<label class="radio">

							<input type="radio" name="fx_cj" value="2" <?php if($item): if($item['fx_cj']==2): ?>checked=checked<?php endif; endif; ?>/>

							二级分销

							</label> 

							<label class="radio">

							<input type="radio" name="fx_cj" value="3" <?php if($item): if($item['fx_cj']==3): ?>checked=checked<?php endif; endif; ?>/>

							三级分销

							</label> 

						</div>

					</div>


					<div class="control-group">



						<label class="control-label">一级分销商比例</label>



						<div class="controls">



							<input name="one_bili" type="text" class="span3 m-wrap" value="<?php if($item): ?><?php echo $item['one_bili']; endif; ?>"  style="height: 35px !important;" />

							<span style="color:#999999; line-height:40px; margin-left:20px;"></span>

						</div>



					</div>

					<div class="control-group">



						<label class="control-label">二级分销商比例</label>



						<div class="controls">



							<input name="two_bili" type="text" class="span3 m-wrap" value="<?php if($item): ?><?php echo $item['two_bili']; endif; ?>"  style="height: 35px !important;" />

							<span style="color:#999999; line-height:40px; margin-left:20px;"></span>

						</div>



					</div>

					<div class="control-group">



						<label class="control-label">三级分销商比例</label>



						<div class="controls">



							<input name="three_bili" type="text" class="span3 m-wrap" value="<?php if($item): ?><?php echo $item['three_bili']; endif; ?>"  style="height: 35px !important;" />

							<span style="color:#999999; line-height:40px; margin-left:20px;"></span>

						</div>



					</div>


					

				
					<div class="form-actions">



						<button type="submit" class="btn green">确定</button>



					</div>



				</form>



				<!-- END FORM-->



			</div>



		</div>



	</div>



	

	

	<style type="text/css">

		.modal{

			width: 795px !important;

			margin-left: -397px !important;

			min-height: 290px !important;

		}

	</style>
	<div id="stack2" class="modal fade" tabindex="-1" data-focus-on="input:first" style="width:795px !important; margin-left:-400px;">



		<div class="modal-header">



			<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>



			<h3>图片上传</h3>



		</div>

		

		<div class="controls">

			<div class="uploader-list-container" >

				<div class="queueList">

					<div id="dndArea" class="placeholder">

						<div id="filePicker-2"></div>

					</div>

				</div>

				<div class="statusBar" style="display:none;">

					<div class="progress"> <span class="text">0%</span> <span class="percentage"></span> </div>

					<div class="info"></div>

					<div class="btns">

						<div id="filePicker2"></div>

						<div class="uploadBtn">开始上传</div>

					</div>

				</div>

			</div>



		</div>



	</div>

<script src="/js/jquery.js"></script> 

<script type="text/javascript" src="/webuploader/js/webuploader.min.js"></script>

<script type="text/javascript" >



function del(id){
	if(confirm('你确定要删除这张图片嘛?')){



		$("#li"+id).remove();

		$.post("<?php echo Url('Index/del'); ?>",{"id":id},function(data){
				
		})

	}else{
        return false;
    }



}

function xians(me){

	var b = $(me).find("div[class='beijingys']");

	var s = $(me).find("div[class='sancann']");

	$(b).show();

	$(s).show();

}

function gb(me){

	var b = $(me).find("div[class='beijingys']");

	var s = $(me).find("div[class='sancann']");

	$(b).hide();

	$(s).hide();

}


(function( $ ){

    // 当domReady的时候开始初始化

    $(function() {
        var $wrap = $('.uploader-list-container'),
            // 图片容器

            $queue = $( '<ul class="filelist" id="filelist"></ul>' )

                .appendTo( $wrap.find( '.queueList' ) ),

            // 状态栏，包括进度和控制按钮

            $statusBar = $wrap.find( '.statusBar' ),

            // 文件总体选择信息。

            $info = $statusBar.find( '.info' ),

            // 上传按钮

            $upload = $wrap.find( '.uploadBtn' ),

            // 没选择文件之前的内容。

            $placeHolder = $wrap.find( '.placeholder' ),
            $progress = $statusBar.find( '.progress' ).hide(),

            // 添加的文件数量

            fileCount = 0,

            // 添加的文件总大小

            fileSize = 0,



            // 优化retina, 在retina下这个值是2

            ratio = window.devicePixelRatio || 1,



            // 缩略图大小

            thumbnailWidth = 180 * ratio,

            thumbnailHeight = 120 * ratio,



            // 可能有pedding, ready, uploading, confirm, done.

            state = 'pedding',



            // 所有文件的进度信息，key为file id

            percentages = {},

            // 判断浏览器是否支持图片的base64

            isSupportBase64 = ( function() {

                var data = new Image();

                var support = true;

                data.onload = data.onerror = function() {

                    if( this.width != 1 || this.height != 1 ) {

                        support = false;

                    }

                }

                data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";

                return support;

            } )(),



            // 检测是否已经安装flash，检测flash的版本

            flashVersion = ( function() {

                var version;



                try {

                    version = navigator.plugins[ 'Shockwave Flash' ];

                    version = version.description;

                } catch ( ex ) {

                    try {

                        version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')

                                .GetVariable('$version');

                    } catch ( ex2 ) {

                        version = '0.0';

                    }

                }

                version = version.match( /\d+/g );

                return parseFloat( version[ 0 ] + '.' + version[ 1 ], 10 );

            } )(),



            supportTransition = (function(){

                var s = document.createElement('p').style,

                    r = 'transition' in s ||

                            'WebkitTransition' in s ||

                            'MozTransition' in s ||

                            'msTransition' in s ||

                            'OTransition' in s;

                s = null;

                return r;

            })(),



            // WebUploader实例

            uploader;







        // 实例化

        uploader = WebUploader.create({

            pick: {

                id: '#filePicker-2',

                label: '点击选择图片'

            },

            formData: {

                uid: 123

            },

            dnd: '#dndArea',

            paste: '#uploader',

            swf: '/webuploader/Uploader.swf',

            chunked: false,

            chunkSize: 512 * 1024,

            server: '<?php echo Url('Index/imgupload'); ?>?appletid=<?php echo $_GET['appletid']?>',

            // runtimeOrder: 'flash',



            // accept: {

            //     title: 'Images',

            //     extensions: 'gif,jpg,jpeg,bmp,png',

            //     mimeTypes: 'image/*'

            // },



            // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。

            disableGlobalDnd: false,

            fileNumLimit: 8,

            fileSizeLimit: 200 * 1024 * 1024,    // 200 M

            fileSingleSizeLimit: 50 * 1024 * 1024    // 50 M

        });



        // 拖拽时不接受 js, txt 文件。

        uploader.on( 'dndAccept', function( items ) {

            var denied = false,

                len = items.length,

                i = 0,

                // 修改js类型

                unAllowed = 'text/plain;application/javascript ';



            for ( ; i < len; i++ ) {

                // 如果在列表里面

                if ( ~unAllowed.indexOf( items[ i ].type ) ) {

                    denied = true;

                    break;

                }

            }



            return !denied;

        });



        uploader.on('dialogOpen', function() {

            console.log('here');

        });

        // 添加“添加文件”的按钮，

        uploader.addButton({

            id: '#filePicker2',

            label: '继续添加'

        });



        uploader.on('ready', function() {

            window.uploader = uploader;

        });



        // 当有文件添加进来时执行，负责view的创建

        function addFile( file ) {

            var $li = $( '<li id="' + file.id + '">' +

                    '<p class="imgWrap"></p>'+                

                    '</li>' ),



                $btns = $('<div class="file-panel">' +

                    '<span class="cancel">删除</span>' +

					'</div>').appendTo( $li ),

                $prgress = $li.find('p.progress span'),

                $wrap = $li.find( 'p.imgWrap' ),

                $info = $('<p class="error"></p>'),



                showError = function( code ) {

                    switch( code ) {

                        case 'exceed_size':

                            text = '文件大小超出';

                            break;



                        case 'interrupt':

                            text = '上传暂停';

                            break;



                        default:

                            text = '上传失败，请重试';

                            break;

                    }



                    $info.text( text ).appendTo( $li );

                };



            if ( file.getStatus() === 'invalid' ) {

                showError( file.statusText );

            } else {

                // @todo lazyload

                $wrap.text( '预览中' );

                uploader.makeThumb( file, function( error, src ) {

                    var img;



                    if ( error ) {

                        $wrap.text( '不能预览' );

                        return;

                    }



                    if( isSupportBase64 ) {

                        img = $('<img src="'+src+'">');

                        $wrap.empty().append( img );

                    } else {

                        $.ajax('/webuploader/server/preview.php', {

                            method: 'POST',

                            data: src,

                            dataType:'json'

                        }).done(function( response ) {

                            if (response.result) {

                                img = $('<img src="'+response.result+'">');

                                $wrap.empty().append( img );

                            } else {

                                $wrap.text("预览出错");

                            }

                        });

                    }

                }, thumbnailWidth, thumbnailHeight );



                percentages[ file.id ] = [ file.size, 0 ];

                file.rotation = 0;

            }



            file.on('statuschange', function( cur, prev ) {

                if ( prev === 'progress' ) {

                    $prgress.hide().width(0);

                } else if ( prev === 'queued' ) {

                    $li.off( 'mouseenter mouseleave' );

                    $btns.remove();

                }



                // 成功

                if ( cur === 'error' || cur === 'invalid' ) {

                    console.log( file.statusText );

                    showError( file.statusText );

                    percentages[ file.id ][ 1 ] = 1;

                } else if ( cur === 'interrupt' ) {

                    showError( 'interrupt' );

                } else if ( cur === 'queued' ) {

                    percentages[ file.id ][ 1 ] = 0;

                } else if ( cur === 'progress' ) {

                    $info.remove();

                    $prgress.css('display', 'block');

                } else if ( cur === 'complete' ) {

                    $li.append( '<span class="success"></span>' );

                }



                $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );

            });



            $li.on( 'mouseenter', function() {

                $btns.stop().animate({height: 30});

            });



            $li.on( 'mouseleave', function() {

                $btns.stop().animate({height: 0});

            });



            $btns.on( 'click', 'span', function() {

                var index = $(this).index(),

                    deg;



                switch ( index ) {

                    case 0:

                        uploader.removeFile( file );

                        return;



                    case 1:

                        file.rotation += 90;

                        break;



                    case 2:

                        file.rotation -= 90;

                        break;

                }



                if ( supportTransition ) {

                    deg = 'rotate(' + file.rotation + 'deg)';

                    $wrap.css({

                        '-webkit-transform': deg,

                        '-mos-transform': deg,

                        '-o-transform': deg,

                        'transform': deg

                    });

                } else {

                    $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');

                    // use jquery animate to rotation

                    // $({

                    //     rotation: rotation

                    // }).animate({

                    //     rotation: file.rotation

                    // }, {

                    //     easing: 'linear',

                    //     step: function( now ) {

                    //         now = now * Math.PI / 180;



                    //         var cos = Math.cos( now ),

                    //             sin = Math.sin( now );



                    //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");

                    //     }

                    // });

                }





            });



            $li.appendTo( $queue );

        }



        // 负责view的销毁

        function removeFile( file ) {

            var $li = $('#'+file.id);



            delete percentages[ file.id ];

            updateTotalProgress();

            $li.off().find('.file-panel').off().end().remove();

        }



        function updateTotalProgress() {

            var loaded = 0,

                total = 0,

                spans = $progress.children(),

                percent;



            $.each( percentages, function( k, v ) {

                total += v[ 0 ];

                loaded += v[ 0 ] * v[ 1 ];

            } );



            percent = total ? loaded / total : 0;





            spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );

            spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );

            updateStatus();

        }



        function updateStatus() {

            var text = '', stats;



            if ( state === 'ready' ) {

                text = '选中' + fileCount + '张图片，共' +

                        WebUploader.formatSize( fileSize ) + '。';

            } else if ( state === 'confirm' ) {

                stats = uploader.getStats();

                if ( stats.uploadFailNum ) {

                    text = '已成功上传' + stats.successNum+ '张照片至XX相册，'+

                        stats.uploadFailNum + '张照片上传失败，<a class="retry" href="#">重新上传</a>失败图片或<a class="ignore" href="#">忽略</a>'

                }



            } else {

                stats = uploader.getStats();

                text = '共' + fileCount + '张（' +

                        WebUploader.formatSize( fileSize )  +

                        '），已上传' + stats.successNum + '张';



                if ( stats.uploadFailNum ) {

                    text += '，失败' + stats.uploadFailNum + '张';

                }

            }



            $info.html( text );

        }



        function setState( val ) {

            var file, stats;



            if ( val === state ) {

                return;

            }



            $upload.removeClass( 'state-' + state );

            $upload.addClass( 'state-' + val );

            state = val;



            switch ( state ) {

                case 'pedding':
                console.log("pedding");
                    $placeHolder.removeClass( 'element-invisible' );

                    $queue.hide();

                    $statusBar.addClass( 'element-invisible' );

                    uploader.refresh();

                    break;



                case 'ready':
                console.log("ready");
                    $placeHolder.addClass( 'element-invisible' );

                    $( '#filePicker2' ).removeClass( 'element-invisible');

                    $queue.show();

                    $statusBar.removeClass('element-invisible');

                    uploader.refresh();

                    break;



                case 'uploading':
                console.log("uploading");
                    $( '#filePicker2' ).addClass( 'element-invisible' );

                    $progress.show();

                    $upload.text( '暂停上传' );

                    break;



                case 'paused':
                console.log("paused");
                    $progress.show();

                    $upload.text( '继续上传' );

                    break;



                case 'confirm':
                console.log("confirm");
                    $progress.hide();

                    $( '#filePicker2' ).removeClass( 'element-invisible' );

                    $upload.text( '开始上传' );



                    stats = uploader.getStats();

                    if ( stats.successNum && !stats.uploadFailNum ) {

                        setState( 'finish' );

                        return;

                    }

                    break;

                case 'finish':
                console.log("finish");
                    stats = uploader.getStats();

                    if ( stats.successNum ) {

                        

                        $.post("<?php echo Url('Index/getimg'); ?>",{"id":<?php echo $_GET['appletid']?>},function(data){

                        	var str="";

                        	if(data){



                        		for(var i=0; i<data.length; i++){



                        			str+=	"<div class='paiwei' onmousemove='xians(this)' onmouseout='gb(this)' id='li"+data[i].id+"'>"+

												"<img src='"+data[i].url+"' style='width: 140px; height:90px;'>"+

												"<div class='beijingys'>"+

										

												"</div>"+

												"<div class='sancann' onclick='del("+data[i].id+")'>"+

													"<span class='cancel'>删除</span>"+

												"</div>"+

											"</div>"

                        		}

                        		$("#imgzs").html(str);

                        	}

                        })



                        alert( '上传成功' );

                    } else {

                        // 没有成功的图片，重设

                        state = 'done';

                    }

                    break;

            }



            updateStatus();

        }



        uploader.onUploadProgress = function( file, percentage ) {

            var $li = $('#'+file.id),

                $percent = $li.find('.progress span');



            $percent.css( 'width', percentage * 100 + '%' );

            percentages[ file.id ][ 1 ] = percentage;

            updateTotalProgress();

        };



        uploader.onFileQueued = function( file ) {

            fileCount++;

            fileSize += file.size;



            if ( fileCount === 1 ) {

                $placeHolder.addClass( 'element-invisible' );

                $statusBar.show();

            }



            addFile( file );

            setState( 'ready' );

            updateTotalProgress();

        };



        uploader.onFileDequeued = function( file ) {

            fileCount--;

            fileSize -= file.size;



            if ( !fileCount ) {

                setState( 'pedding' );

            }



            removeFile( file );

            updateTotalProgress();



        };



        uploader.on( 'all', function( type ) {

            var stats;

            switch( type ) {

                case 'uploadFinished':

                    setState( 'confirm' );

                    break;



                case 'startUpload':

                    setState( 'uploading' );

                    break;



                case 'stopUpload':

                    setState( 'paused' );

                    break;



            }

        });



        uploader.onError = function( code ) {

            alert( 'Eroor: ' + code );

        };



        $upload.on('click', function() {

            if ( $(this).hasClass( 'disabled' ) ) {

                return false;

            }



            if ( state === 'ready' ) {

                uploader.upload();

            } else if ( state === 'paused' ) {

                uploader.upload();

            } else if ( state === 'uploading' ) {

                uploader.stop();

            }

        });



        $info.on( 'click', '.retry', function() {

            uploader.retry();

        } );



        $info.on( 'click', '.ignore', function() {

            alert( 'todo' );

        } );



        $upload.addClass( 'state-' + state );

        updateTotalProgress();

    });



})( jQuery );

</script>







		</div>
	</div>
</div>
<input type="hidden" id="handle_status">
<script>
function copyid(id){
	var clipboard = new Clipboard('.js-clip'+id);
	clipboard.on('success', function(e) {
	    alert("ID复制成功");
	    e.clearSelection();
	});

	clipboard.on('error', function(e) {
	    alert("ID复制失败");
	});
}
</script>

	

	<script src="/js/jquery-migrate-1.2.1.min.js" type="text/javascript"></script>

	<script src="/js/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>      

	<script src="/js/bootstrap.min.js" type="text/javascript"></script>

	<script src="/js/jquery.slimscroll.min.js" type="text/javascript"></script>

	<script src="/js/jquery.blockui.min.js" type="text/javascript"></script>  

	<script src="/js/jquery.cookie.min.js" type="text/javascript"></script>

	<script src="/js/jquery.uniform.min.js" type="text/javascript" ></script>

	<script type="text/javascript" src="/js/bootstrap-fileupload.js"></script>

	<script type="text/javascript" src="/js/chosen.jquery.min.js"></script>

	<script type="text/javascript" src="/js/select2.min.js"></script>

	<script type="text/javascript" src="/js/wysihtml5-0.3.0.js"></script> 

	<script type="text/javascript" src="/js/bootstrap-wysihtml5.js"></script>

	<script type="text/javascript" src="/js/jquery.tagsinput.min.js"></script>

	<script type="text/javascript" src="/js/jquery.toggle.buttons.js"></script>

	<script type="text/javascript" src="/js/bootstrap-datepicker.js"></script>

	<script type="text/javascript" src="/js/bootstrap-datetimepicker.js"></script>

	<script type="text/javascript" src="/js/clockface.js"></script>

	<script type="text/javascript" src="/js/date.js"></script>

	<script type="text/javascript" src="/js/daterangepicker.js"></script> 

	<script type="text/javascript" src="/js/bootstrap-colorpicker.js"></script>  

	<script type="text/javascript" src="/js/bootstrap-timepicker.js"></script>

	<script type="text/javascript" src="/js/jquery.inputmask.bundle.min.js"></script>   

	<script type="text/javascript" src="/js/jquery.input-ip-address-control-1.0.min.js"></script>

	<script type="text/javascript" src="/js/jquery.multi-select.js"></script>   

	<script src="/js/bootstrap-modal.js" type="text/javascript" ></script>

	<script src="/js/bootstrap-modalmanager.js" type="text/javascript" ></script> 

	<script src="/js/app.js"></script>
	
	
	<script src="/js/form-components.js"></script>   

	<script src="/js/ui-modals.js"></script>
	<script src="/js/layer/layer.js"></script>  
	<link href="/js/layer/theme/default/layer.css" rel="stylesheet" type="text/css"/>
	
	<script>
		var path ="1";
		$(".commonchangepic").click(function(){
			var type =  $(this).data('type');
			var classname = $(this).find("input").attr("name");
			layer.open({
			  type: 2,
			  title: false,
			  area: ['1000px', '680px'],
			  fixed: false, //不固定
			  maxmin: true,
			  content: ['<?php echo Url("Remote/index"); ?>?appletid=<?php echo $_GET['appletid']?>&type='+type,'no'],
			  success:function(layero,index){
		      },
		      end:function(){
		      		if(type==2){
			            var handle_status = $("#handle_status").val();       
			            if(handle_status!=""){
				            $("input[name="+classname+"]").val(handle_status)
				            var imgarr = handle_status.split(',');
				            var str = "";
				            var imginput = "";
				            for(var i=0; i<imgarr.length; i++){
				            	str+="<div class='paiwei shanc"+i+"' onmousemove='xians(this)' onmouseout='gb(this)'>"+
											"<img src='"+imgarr[i]+"' style='width: 140px; height:90px;'>"+
											"<div class='beijingys'>"+
											"</div>"+
											"<div class='sancann' onclick='dels("+i+")'>"+
												"<span class='cancel'>删除</span>"+
											"</div>"+
										"</div>";
								imginput += '<input type="hidden" name="imgsrcs[]" value="'+imgarr[i]+'" class="shanc'+i+'" />';
				            }
				            if(str){
								$(".commonuploadslide").append(str);
				            }
				            if(imginput){
								$(".commonuploadslide").append(imginput);
				            }
			            }
		      		}
		      		if(type==1){
		      			var handle_status = $("#handle_status").val();
		      			if(handle_status){
				            $("input[name="+classname+"]").val(handle_status)
				            $("."+classname+" img").attr("src",handle_status)
		      			}
		      		}
		        }
			});
		});

		function dels(i){
			$(".shanc"+i).remove();
		}
		jQuery(document).ready(function() {  
		   	App.init(); // initlayout and core plugins
		   	FormComponents.init();
			UIModals.init();
			$.fn.datetimepicker.dates['zh-CN'] = {  
	            days: ["星期日", "星期一", "星期二", "星期三", "星期四", "星期五", "星期六", "星期日"],  
	            daysShort: ["周日", "周一", "周二", "周三", "周四", "周五", "周六", "周日"],  
	            daysMin:  ["日", "一", "二", "三", "四", "五", "六", "日"],  
	            months: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],  
	            monthsShort: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],  
	            today: "今天",  
	            suffix: [],  
	            meridiem: ["上午", "下午"]  
	    	}; 
		   	$('#datetimepicker').datetimepicker({language:  'zh-CN'});
		   	$('#datetimepickers').datetimepicker({
		   		minView: "month",//设置只显示到月份
		   		language:  'zh-CN',
		   		format : "yyyy-mm-dd",//日期格式
				autoclose:true,//选中关闭
		   	});
		   	$('#datetimepicker2').datetimepicker({language:  'zh-CN'});
		});

	</script>


	</body>
	<script type="text/javascript">
		$('.content_left_single').click(function(){
		$('.content_left_single').removeClass('content_left_single_on');
		$(this).addClass('content_left_single_on')
	})
	$('.content_right_single').each(function(){
		$(this).click(function(){
			if($(this).hasClass('content_right_single_on')){
				$(this).removeClass('content_right_single_on')
			}else{
				$(this).addClass('content_right_single_on')
			}
		})
	})
	$('.creatphoto').click(function(){
		$('.cjxcalertbox').show()
	})
	$('.cjxc_btn_close').click(function(){
		$('.cjxcalertbox').hide()
	})
	$('.cjxcalert_head_right').click(function(){
		$('.cjxcalertbox').hide()
	})
	$('.cjxc_btn_creat').click(function(){
		var val = $('.cjxcalert_input').val();
		var html = $('.content_left').html();
		html += '<div class="content_left_single hbj"><div class="content_left_single_div1">'+val+'</div><div style="flex: 1;"></div><div class="content_left_single_div2">0</div></div>';
		$('.content_left').html(html);
		 $('.cjxcalert_input').val("");
	})
	</script>

	</body>
</html>