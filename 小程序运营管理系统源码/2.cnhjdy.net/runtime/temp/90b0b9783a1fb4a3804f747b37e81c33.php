<?php if (!defined('THINK_PATH')) exit(); /*a:5:{s:76:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\datashow\index.html";i:1575814734;s:73:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\head.html";i:1575814741;s:72:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\top.html";i:1575814741;s:73:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\left.html";i:1575814741;s:78:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\foot_more.html";i:1575814741;}*/ ?>
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
<style type="text/css">
	form {
	     margin: 0 !important; 
	    display: inline-block !important;
	}	
</style>
<style>
.order-table2{height: 256px;}
.row{flex-wrap:nowrap !important}
.page-content{background-color: #F1F4F5;padding:0}
.all_visit{border-radius: 180px;}
.data_card{border-radius: 6px;}
</style>
<script src="/js/echarts.js" type="text/javascript" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="/css/bootstrap1.css?v=20180322" />
<link rel="stylesheet" type="text/css" href="/css/bootstrap2.css" />
<link rel="stylesheet" type="text/css" href="/css/data_home.css?v180705v3" />
<script src="/js/countUp.js" type="text/javascript" charset="utf-8"></script>
<input type="hidden" id="nowhtml" value="dataShow" class="dataShow1">
		<!--第1行数据-->
		<div class="row">
			<div class="w-20">
				<div class="card card-block data_card position-relative" style="border-top: 1px solid #6671E4;">
					<div class="font-size-18 color-434343">总访问量</div>
					<div class="num_people color-363636 mb-20"><a id="num1">0</a><span class="font-size-14 color-838383">人</span></div>
					<div class="all_visit">
						<img src="/indexImg/visit.png" class="all_visit_img"/>
					</div>
				</div>
			</div>
			<div class="w-20">
				<div class="card card-block data_card position-relative" style="border-top: 1px solid #66E49E;">
					<div class="font-size-18 color-434343">客户数量</div>
					<div class="num_people color-363636 mb-20"><a id="num2">0</a><span class="font-size-14 color-838383">人</span></div>
					<div class="all_customer">
						<img src="/indexImg/customer.png" class="all_visit_img"/>
					</div>
				</div>
			</div>
			<div class="w-20">
				<div class="card card-block data_card position-relative" style="border-top: 1px solid #ED8E20;">
					<div class="font-size-18 color-434343">会员数量</div>
					<div class="num_people color-363636 mb-20"><a id="num3">0</a><span class="font-size-14 color-838383">人</span></div>
					<div class="all_member">
						<img src="/indexImg/member.png" class="all_visit_img"/>
					</div>
				</div>
			</div>
			<div class="w-20">
				<div class="card card-block data_card position-relative" style="border-top: 1px solid #E93C38;">
					<div class="font-size-18 color-434343">生日祝福</div>
					<div class="num_people color-363636 mb-20"><a id="num4">0</a><span class="font-size-14 color-838383">人</span></div>
					<div class="all_birthday">
						<img src="/indexImg/birthday.png" class="all_visit_img"/>
					</div>
				</div>
			</div>
			<div class="w-20">
				<div class="card card-block data_card" style="border-top: 1px solid #0079FE;">
					<div class="font-size-18 color-434343">充值总额</div>
					<div class="num_people color-363636 mb-20"><a id="num5">0</a><span class="font-size-14 color-838383">元</span></div>
					<div class="all_recharge">
						<img src="/indexImg/recharge.png" class="all_visit_img"/>
					</div>
				</div>
			</div>
		</div>
		<!--第2行数据-->
		<div class="row">
			<div class="col-xl-6 zxtbox" style="position: relative; height: 371px;">
				<div class="zxtzj">
					<div>30天成交量：<?php echo $duo_platform_num; ?></div>
					<div>30天成交额：<?php echo $duo_platform_money; ?></div>
				</div>
				<div id="chartmain" style="height: 100%;background: #fff;padding:30px 10px 0;position: relative;border: 1px solid #eee;border-radius: 6px;"></div>
			</div>
			<div class="col-xl-6">
				<div class="order-box">
					<div class="order_des bg-fff">
						<div class="order_navbar clearfix">
							<div class="fl font-size-14 color-434343 pb-10">订单详情</div>
							<div class="fr">
								<ul class="order_li clearfix">
									<li id="order1" class="on">今天</li>
									<li id="order2">昨日</li>
									<li id="order3">最近7天</li>
									<li id="order4">最近30天</li>
								</ul>
							</div>
						</div>
						<div class="clearfix" id='today1'>
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-ED8E20 text-center font-weight-700"><?php echo $today_num; ?><span class="font-size-14 color-838383 font-weight-normal"> 笔</span></div>
									<div class="color-434343 text-center">成交量</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-04C65D text-center font-weight-700"><?php echo $today_money; ?><span class="font-size-14 color-838383 font-weight-normal"> 元</span></div>
									<div class="color-434343 text-center">成交额</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-6671E4 text-center font-weight-700"><?php echo $today_avg; ?><span class="font-size-14 color-838383 font-weight-normal"> 元</span></div>
									<div class="color-434343 text-center">订单平均消费</div>
								</div>
							</div>
						</div>
						<div class="clearfix" id='yes1' style="display: none;">
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-ED8E20 text-center font-weight-700"><?php echo $yes_num; ?><span class="font-size-14 color-838383 font-weight-normal"> 笔</span></div>
									<div class="color-434343 text-center">成交量</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-04C65D text-center font-weight-700"><?php echo $yes_money; ?><span class="font-size-14 color-838383 font-weight-normal"> 元</span></div>
									<div class="color-434343 text-center">成交额</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-6671E4 text-center font-weight-700"><?php echo $yes_avg; ?><span class="font-size-14 color-838383 font-weight-normal"> 元</span></div>
									<div class="color-434343 text-center">订单平均消费</div>
								</div>
							</div>
						</div>
						<div class="clearfix" id='week1' style="display: none;">
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-ED8E20 text-center font-weight-700"><?php echo $week_num; ?><span class="font-size-14 color-838383 font-weight-normal"> 笔</span></div>
									<div class="color-434343 text-center">成交量</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-04C65D text-center font-weight-700"><?php echo $week_money; ?><span class="font-size-14 color-838383 font-weight-normal"> 元</span></div>
									<div class="color-434343 text-center">成交额</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-6671E4 text-center font-weight-700"><?php echo $week_avg; ?><span class="font-size-14 color-838383 font-weight-normal"> 元</span></div>
									<div class="color-434343 text-center">订单平均消费</div>
								</div>
							</div>
						</div>
						<div class="clearfix" id='month1' style="display: none;">
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-ED8E20 text-center font-weight-700"><?php echo $month_num; ?><span class="font-size-14 color-838383 font-weight-normal"> 笔</span></div>
									<div class="color-434343 text-center">成交量</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-04C65D text-center font-weight-700"><?php echo $month_money; ?><span class="font-size-14 color-838383 font-weight-normal"> 元</span></div>
									<div class="color-434343 text-center">成交额</div>
								</div>
							</div>
							<div class="col-sm-4">
								<div class="card card-block1 mb-0">
									<div class="font-size-36 color-6671E4 text-center font-weight-700"><?php echo $month_avg; ?><span class="font-size-14 color-838383 font-weight-normal"> 元</span></div>
									<div class="color-434343 text-center">订单平均消费</div>
								</div>
							</div>
						</div>
					</div>
					<div class="order_des bg-fff mt-20 clearfix" id='today2'>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card1 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $today_flag0; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">待支付订单</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card2 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order2.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $today_flag1; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">待核销订单</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card3 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order3.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $today_flag4; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">维权订单</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="order_des bg-fff mt-20 clearfix" style="display: none;" id='yes2'>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card1 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $yes_flag0; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">待支付订单</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card2 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order2.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $yes_flag1; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">待核销订单</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card3 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order3.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $yes_flag4; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">维权订单</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="order_des bg-fff mt-20 clearfix" style="display: none;" id='week2'>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card1 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $week_flag0; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">待支付订单</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card2 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order2.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $week_flag1; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">待核销订单</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card3 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order3.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $week_flag4; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">维权订单</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="order_des bg-fff mt-20 clearfix" style="display: none;" id='month2'>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card1 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $month_flag0; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">待支付订单</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card2 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order2.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $month_flag1; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">待核销订单</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="bg-F9F9F9 order_card order_card3 text-center">
								<div class="clearfix inline-block">
									<img class="fl block mt-10" src="/indexImg/order3.png" />
									<div class="fl ml-10">
										<div class="font-size-36 font-weight-700 color-434343 mb-0 line-height-36"><?php echo $month_flag4; ?></div>
										<div class="font-size-14 color-838383 mb-0 ml-10">维权订单</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--第3行数据-->
		<div class="row">
			<div class="col-xl-6 mt-20">
				<div class="order_des bg-fff">
					<div class="order2_navbar clearfix">
						<div class="fl">
							<ul class="order2_li clearfix">
								<li id="appoint1" class="on">商品订单</li>
								<li id="appoint2">商户订单</li>
								<li id="appoint3">预约订单</li>
								<li id="appoint4">秒杀订单</li>
								<li id="appoint5">拼团订单</li>
							</ul>
						</div>
						<a href="<?php echo Url('orderlist/index'); ?>?appletid=<?php echo $_GET['appletid']?>" class="fr font-size-12 block  color-6671E4" style="line-height: 20px;">更多<span class="font-size-20 ml-10" style="vertical-align: -2px;">+</span></a>
					</div>
					<div class="order-table order-table1 mt-15" id='duo_platform_order'>
						<table>
							<thead>
								<tr>
									<th>订单号</th>
									<th>商品名称</th>
									<th>状态</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($duo_platform_orders as $item): ?>

								<tr>
									<td><?php echo $item['order_id']; ?></td>
									<td><?php echo $item['pname']; ?></td>
									<td>
									<?php if($item['flag'] =='0'): ?><span class="btn btn-default btn-sm">未支付</span><?php endif; if($item['flag'] =='1' && $item['nav'] == '2'): ?>
						                <span class="btn btn-danger btn-sm" >待核销</span>
						            <?php endif; if($item['flag'] =='1' && $item['nav'] == '1'): ?>
						                <span class="btn btn-danger btn-sm" >待发货</span>
						            <?php endif; if($item['flag'] =='2' && $item['nav'] == '2'): ?> <span class="btn btn-success btn-sm">已核销</span><?php endif; if($item['flag'] =='3'): ?> <span class="btn btn-default btn-sm">已过期</span><?php endif; if($item['flag'] =='4'): ?> <span class="btn btn-success btn-sm">已发货</span><?php endif; if($item['flag'] =='5'): ?> <span class="btn btn-danger btn-sm">退换货</span><?php endif; ?>
						            </td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="order-table order-table1 mt-15" style="display: none" id='duo_shop_order'>
						<table>
							<thead>
								<tr>
									<th>订单号</th>
									<th>商品名称</th>
									<th>状态</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($duo_shop_orders as $item): ?>
								<tr>
									<td><?php echo $item['order_id']; ?></td>
									<td><?php echo $item['pname']; ?></td>
									<td>
									<?php if($item['flag'] =='0'): ?><span class="btn btn-default btn-sm">未支付</span><?php endif; if($item['flag'] =='1' && $item['nav'] == '2'): ?>
						                <span class="btn btn-danger btn-sm" >待核销</span>
						            <?php endif; if($item['flag'] =='1' && $item['nav'] == '1'): ?>
						                <span class="btn btn-danger btn-sm" >待发货</span>
						            <?php endif; if($item['flag'] =='2' && $item['nav'] == '2'): ?> <span class="btn btn-success btn-sm">已核销</span><?php endif; if($item['flag'] =='3'): ?> <span class="btn btn-default btn-sm">已过期</span><?php endif; if($item['flag'] =='4'): ?> <span class="btn btn-success btn-sm">已发货</span><?php endif; if($item['flag'] =='5'): ?> <span class="btn btn-danger btn-sm">退换货</span><?php endif; ?>
						            </td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="order-table order-table1 mt-15" style="display: none" id='yuyue_orders'>
						<table>
							<thead>
								<tr>
									<th>订单号</th>
									<th>商品名称</th>
									<th>状态</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($yuyue_orders as $item): ?>
								<tr>
									<td><?php echo $item['order_id']; ?></td>
									<td><?php echo $item['pname']; ?></td>
									<?php if($item['flag']=='0'): ?><td><span class="btn btn-default btn-sm">未付款</span></td><?php endif; if($item['flag']=='1'): ?><td><span class="btn btn-warning btn-sm">已支付</span></td><?php endif; if($item['flag']=='2'): ?><td><span class="btn btn-success btn-sm">已核销</span></td><?php endif; if($item['flag']=='3'): ?><td><span class="btn btn-default btn-sm">已过期</span></td><?php endif; if($item['flag']=='4'): ?><td><span class="btn btn-danger btn-sm">退换货</span></td><?php endif; ?>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="order-table order-table1 mt-15" style="display: none" id='miaosha_orders'>
						<table>
							<thead>
								<tr>
									<th>订单号</th>
									<th>商品名称</th>
									<th>状态</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($miaosha_orders as $item): ?>

								<tr>
									<td><?php echo $item['order_id']; ?></td>
									<td><?php echo $item['pname']; ?></td>
									<?php if($item['flag']=='0'): ?><td><span class="btn btn-default btn-sm">未付款</span></td><?php endif; if($item['flag']=='1'): ?><td><span class="btn btn-warning btn-sm">已支付</span></td><?php endif; if($item['flag']=='2'): ?><td><span class="btn btn-success btn-sm">已核销</span></td><?php endif; if($item['flag']=='3'): ?><td><span class="btn btn-default btn-sm">已过期</span></td><?php endif; if($item['flag']=='4'): ?><td><span class="btn btn-danger btn-sm">退换货</span></td><?php endif; ?>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="order-table order-table1 mt-15" style="display: none" id='pintuan_orders'>
						<table>
							<thead>
								<tr>
									<th>订单号</th>
									<th>商品名称</th>
									<th>状态</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($pintuan_orders as $item): ?>
								<tr>
									<td><?php echo $item['order_id']; ?></td>
									<td><?php echo $item['pname']; ?></td>
									<?php if($item['flag']=='0'): ?><td><span class="btn btn-default btn-sm">未付款</span></td><?php endif; if($item['flag']=='1'): ?><td><span class="btn btn-warning btn-sm">已支付</span></td><?php endif; if($item['flag']=='2'): ?><td><span class="btn btn-success btn-sm">已核销</span></td><?php endif; if($item['flag']=='3'): ?><td><span class="btn btn-default btn-sm">已过期</span></td><?php endif; if($item['flag']=='4'): ?><td><span class="btn btn-danger btn-sm">退换货</span></td><?php endif; ?>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-xl-6 mt-20">
				<div class="order_des bg-fff">
					<div class="order2_navbar clearfix">
						<div class="fl">
							<ul class="order2_li clearfix">
								<li id="article1" class="on">文章评论</li>
								<li id="article2">视频订单</li>
							</ul>
						</div>
						<a href="<?php echo Url('pinglun/index'); ?>?appletid=<?php echo $_GET['appletid']?>" class="fr font-size-12 block  color-6671E4 " style="line-height: 20px;">更多<span class="font-size-20 ml-10" style="vertical-align: -2px;">+</span></a>
					</div>
					<div class="order-table order-table2 mt-15" id='articlec1'>
						<table>
							<thead>
								<tr>
									<th>评论时间</th>
									<th>评论详情</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($acticle_comments as $item): ?>
								<tr>
									<td><?php echo $item['createtime']; ?></td>
									<td><?php echo $item['text']; ?></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
					<div class="order-table order-table2 mt-15" style="display: none" id='articlec2'>
						<table>
							<thead>
								<tr>
									<th>支付时间</th>
									<th>文章名称</th>
									<th style="width:20%">付费价格</th>
								</tr>
							</thead>
							<tbody>
								<?php foreach($video_orders as $item): ?>
								<tr>
									<td><?php echo $item['creattime']; ?></td>
									<td><?php echo $item['pname']; ?></td>
									<td><span class="btn btn-success btn-sm"><?php echo $item['paymoney']; ?></span></td>
								</tr>
								<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!--第4行数据-->
		<div class="row">
					<div class="col-xl-4 mt-80">
						<div class="all_list_box collect_list bg-fff pt-15">
							<div class="font-size-30 font-weight-700 color-6671E4 text-center"><?php echo $collect_max; ?></div>
							<div class="font-size-14 color-434343 text-center">收藏榜</div>
						</div>
						<div class="order_des bg-fff bottom3">
							<!--a href="" class="block text-right color-6671E4">更多<span class="font-size-20 ml-10" style="vertical-align: -2px;">+</span></a-->
							<div class="order-table collect_table mt-40">
								<table>
									<thead>
										<tr>
											<th>收藏榜单</th>
											<th>商品名称</th>
											<th>收藏数量</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($collects as $index => $item): ?>

										<tr>
											<td><?php echo $index+1; ?></td>
											<td><?php echo $item['title']; ?></td>
											<td><?php echo $item['num']; ?></td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-xl-4 mt-80">
						<div class="all_list_box sale_list bg-fff pt-15">
							<div class="font-size-30 font-weight-700 color-ED8E20 text-center"><?php echo $sale_max; ?></div>
							<div class="font-size-14 color-434343 text-center">销售榜</div>
						</div>
						<div class="order_des bg-fff bottom3">
							<!--a href="" class="block text-right color-6671E4">更多<span class="font-size-20 ml-10" style="vertical-align: -2px;">+</span></a-->
							<div class="order-table collect_table mt-40">
								<table>
									<thead>
										<tr>
											<th>销售榜单</th>
											<th>商品名称</th>
											<th>销售数量</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($sales as  $index => $item): ?>
										<tr>
											<td><?php echo $index+1?></td>
											<td><?php echo $item['title']; ?></td>
											<td><?php echo $item['rsales']; ?></td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="col-xl-4 mt-80">
						<div class="all_list_box recharge_list bg-fff pt-15">
							<div class="font-size-30 font-weight-700 color-0079FE text-center"><?php echo $credit_max; ?></div>
							<div class="font-size-14 color-434343 text-center">积分榜</div>
						</div>
						<div class="order_des bg-fff bottom3">
							<a href="<?php echo Url('wxuser/index'); ?>?appletid=<?php echo $_GET['appletid']?>" class="block text-right color-6671E4">更多<span class="font-size-20 ml-10" style="vertical-align: -2px;">+</span></a>
							<div class="order-table collect_table mt-40">
								<table>
									<thead>
										<tr>
											<th>积分榜单</th>
											<th>姓名</th>
											<th>积分数量</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($credits as $index => $item): ?>
										<tr>
											<td><?php echo $index+1 ?></td>
											<td><?php echo $item['nickname']; ?></td>
											<td><?php echo $item['score']; ?></td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
		</div>		
<script>
	if(typeof $.fn.tooltip != 'function' || typeof $.fn.tab != 'function' || typeof $.fn.modal != 'function' || typeof $.fn.dropdown != 'function') {
		require(['bootstrap']);
	}
</script>

<script type="text/javascript" charset="utf-8">
//数据动态增加
var options = {
  useEasing: true, 
  useGrouping: true, 
  separator: ',', 
  decimal: '.', 
};
var num1 = new CountUp('num1', 0, <?php echo $visitNum; ?>, 0, 2, options);
var num2 = new CountUp('num2', 0, <?php echo $userNum; ?>, 0, 2, options);
var num3 = new CountUp('num3', 0, <?php echo $vipNum; ?>, 0, 2, options);
var num4 = new CountUp('num4', 0, <?php echo $birthNum; ?>, 0, 2, options);
var num5 = new CountUp('num5', 0, <?php echo $yue; ?>, 2,2, options);
num1.start();
num2.start();
num3.start();
num4.start();
num5.start();

option = {
    color: ['#F6B6B5','#6671E4'],
    tooltip : {
        trigger: 'axis'
    },
    legend: {
        data:['交易量','交易额']
    },
    grid:{
    	borderColor:"#eee",
    	borderWidth:0,
    	top:100,
    	left:50,
    	right:50,
    	bottom:50
    },
    xAxis : [
        {
            type : 'category',
            data : <?php echo $last_week_date; ?>,
            axisTick: {
                alignWithLabel: true
            },
	    	axisLine:{
            	lineStyle:{
            		color:"#838383"
            	}
            },
            axisTick: {
                alignWithLabel: true
            }
        }
    ],
    yAxis : [
        {
            type : 'value',
            name: '交易量',
            min: 0,
            max: <?php echo $duo_chart_num_max; ?>,
            interval:<?php echo $duo_chart_num_interval; ?>,
            axisLine:{
            	lineStyle:{
            		color:"#838383"
            	}
            }
        },
        {
            type: 'value',
            name: '交易额',
            position: 'right',
            axisLine:{
            	lineStyle:{
            		color:"#eee"
            	}
            },
            min: 0,
            max: <?php echo $duo_chart_money_max; ?>,
            interval:<?php echo $duo_chart_money_interval; ?>,
            axisLine:{
            	show:false
            },
            axisLabel: {
                show:false
            },
            axisLine:{
            	show:false
            }
        },
    ],
    series : [
        {
            name:'交易量',
            type:'bar',
            barWidth: '30%',
            data:<?php echo $duo_chart_num; ?>
        },
	{
            name:'交易额',
            type:'line',
            yAxisIndex:1,
            data:<?php echo $duo_chart_money; ?>,
	    	lineStyle:{
            	width:3
            },
            smooth:0.5
        }
    ]
};
        //初始化echarts实例
        
        var myChart = echarts.init(document.getElementById('chartmain'),'macarons');
        //使用制定的配置项和数据显示图表
        myChart.setOption(option);
</script>
<script type="text/javascript">
	$('#order1').mouseover(function() {
		$('#order1').addClass('on');
		$('#order2').removeClass('on');
		$('#order3').removeClass('on');
		$('#order4').removeClass('on');
		$('#today1').show();$('#today2').show();
		$('#yes1').hide();$('#yes2').hide();
		$('#week1').hide();$('#week2').hide();
		$('#month1').hide();$('#month2').hide();
	})
	$('#order2').mouseover(function() {
		$('#order1').removeClass('on');
		$('#order2').addClass('on');
		$('#order3').removeClass('on');
		$('#order4').removeClass('on');
		$('#yes1').show();$('#yes2').show();
		$('#today1').hide();$('#today2').hide();
		$('#week1').hide();$('#week2').hide();
		$('#month1').hide();$('#month2').hide();
	})
	$('#order3').mouseover(function() {
		$('#order1').removeClass('on');
		$('#order2').removeClass('on');
		$('#order3').addClass('on');
		$('#order4').removeClass('on');
		$('#week1').show();$('#week2').show();
		$('#today1').hide();$('#today2').hide();
		$('#yes1').hide();$('#yes2').hide();
		$('#month1').hide();$('#month2').hide();
	})
	$('#order4').mouseover(function() {
		$('#order1').removeClass('on');
		$('#order2').removeClass('on');
		$('#order3').removeClass('on');
		$('#order4').addClass('on');
		$('#month1').show();$('#month2').show();
		$('#today1').hide();$('#today2').hide();
		$('#yes1').hide();$('#yes2').hide();
		$('#week1').hide();$('#week2').hide();
	})
	$('#appoint1').mouseover(function(){
		$('#appoint1').addClass('on');
		$('#appoint2').removeClass('on');
		$('#appoint3').removeClass('on');
		$('#appoint4').removeClass('on');
		$('#appoint5').removeClass('on');
		$('#appoint6').removeClass('on');
		$('#duo_platform_order').show();
		$('#duo_shop_order').hide();
		$('#yuyue_orders').hide();
		$('#miaosha_orders').hide();
		$('#pintuan_orders').hide();
	})
	$('#appoint2').mouseover(function(){
		$('#appoint2').addClass('on');
		$('#appoint1').removeClass('on');
		$('#appoint3').removeClass('on');
		$('#appoint4').removeClass('on');
		$('#appoint5').removeClass('on');
		$('#appoint6').removeClass('on');
		$('#duo_shop_order').show();
		$('#duo_platform_order').hide();
		$('#yuyue_orders').hide();
		$('#miaosha_orders').hide();
		$('#pintuan_orders').hide();
	})
	$('#appoint3').mouseover(function(){
		$('#appoint3').addClass('on');
		$('#appoint1').removeClass('on');
		$('#appoint2').removeClass('on');
		$('#appoint4').removeClass('on');
		$('#appoint5').removeClass('on');
		$('#appoint6').removeClass('on');
		$('#yuyue_orders').show();
		$('#duo_platform_order').hide();
		$('#duo_shop_order').hide();
		$('#miaosha_orders').hide();
		$('#pintuan_orders').hide();
	})
	$('#appoint4').mouseover(function(){
		$('#appoint4').addClass('on');
		$('#appoint1').removeClass('on');
		$('#appoint2').removeClass('on');
		$('#appoint3').removeClass('on');
		$('#appoint5').removeClass('on');
		$('#appoint6').removeClass('on');
		$('#miaosha_orders').show();
		$('#yuyue_orders').hide();
		$('#duo_platform_order').hide();
		$('#duo_shop_order').hide();
		$('#pintuan_orders').hide();
	})
	$('#appoint5').mouseover(function(){
		$('#appoint5').addClass('on');
		$('#appoint1').removeClass('on');
		$('#appoint2').removeClass('on');
		$('#appoint3').removeClass('on');
		$('#appoint4').removeClass('on');
		$('#appoint6').removeClass('on');
		$('#pintuan_orders').show();
		$('#yuyue_orders').hide();
		$('#duo_platform_order').hide();
		$('#duo_shop_order').hide();
		$('#miaosha_orders').hide();
	})

	$('#article1').mouseover(function(){
		$('#article1').addClass('on');
		$('#article2').removeClass('on');
		$('#articlec1').show();
		$('#articlec2').hide();
	})
	$('#article2').mouseover(function(){
		$('#article2').addClass('on');
		$('#article1').removeClass('on');
		$('#articlec1').hide();
		$('#articlec2').show();
	})
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