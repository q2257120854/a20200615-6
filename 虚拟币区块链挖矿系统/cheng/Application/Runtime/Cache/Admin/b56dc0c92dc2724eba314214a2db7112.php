<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title><?php echo ($title); ?>——养生链后台管理</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<!-- basic styles -->
		<link rel="stylesheet" href="/Public/admin/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/Public/admin/css/font-awesome.min.css" />

		<!-- ace styles -->
		<link rel="stylesheet" href="/Public/admin/css/ace.min.css" />
		<link rel="stylesheet" href="/Public/admin/css/ace-rtl.min.css" />
		<link rel="stylesheet" href="/Public/admin/css/ace-skins.min.css" />
		
	</head>

	<body>
		<div class="navbar navbar-default" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">

				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav">
						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
								<img class="nav-user-photo" src="/Public/admin/avatars/user.jpg" alt="Jason's Photo" />
								<span class="user-info">
									<small>欢迎光临,</small>
									<?php echo (session('uname')); ?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="<?php echo U('Admin/Profile/index');?>">
										<i class="icon-cog"></i>
										修改密码
									</a>
								</li>
								<li class="divider"></li>

								<li>
									<a href="<?php echo U('Admin/Login/loginOut');?>">
										<i class="icon-off"></i>
										退出
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>

		<div class="main-container" id="main-container">
			<script type="text/javascript">
				try{ace.settings.check('main-container' , 'fixed')}catch(e){}
			</script>
			<div class="main-container-inner">
				<a class="menu-toggler" id="menu-toggler" href="#">
					<span class="menu-text"></span>
				</a>
				
				<!-- 加载左部分 -->
				        <!-- 侧边菜单开始 -->
        <div class="sidebar" id="sidebar">
            <script type="text/javascript">
                try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
            </script>
            <div class="sidebar-shortcuts" id="sidebar-shortcuts" style="height:42px;">
            </div><!-- #sidebar-shortcuts -->

            <ul class="nav nav-list">

                    <li>
                        <a id="indexpage" href="<?php echo U('Admin/Index/index');?>">
                            <i class="icon-dashboard"></i>
                            <span class="menu-text"> 控制台 </span>
                        </a>
                    </li>


               


                
                    <li>
                        <a href="#" class="dropdown-toggle">
                            <i class="icon-asterisk"></i>
                            <span class="menu-text"> 商品管理 </span>

                            <b class="arrow icon-angle-down"></b>
                        </a>

                        <ul class="submenu">
 
                                <li>
                                    <a href="<?php echo U('Admin/Goodsissue/index');?>">
                                        <i class="icon-double-angle-right"></i>
                                        商品发布
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo U('Admin/Goodsup/index');?>">
                                        <i class="icon-double-angle-right"></i>
                                        上架商品
                                    </a>
                                </li>

                                <li>
                                    <a href="<?php echo U('Admin/Goodsdown/index');?>">
                                        <i class="icon-double-angle-right"></i>
                                        仓库商品
                                    </a>
                                </li>
                   
                        </ul>
                    </li>

                    <li>
                        <a href="<?php echo U('Admin/Ordermanage/index');?>">
                            <i class="icon-bar-chart"></i>
                            <span class="menu-text">  订单管理 </span>
                        </a>
                    </li>
       
            
            </ul>

            <div class="sidebar-collapse" id="sidebar-collapse">
                <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
            </div>
        </div>

				<!-- 中间部分开始 -->
				
	<!-- 中间部分开始 -->
	<div class="main-content">
		<div class="breadcrumbs" id="breadcrumbs">
			<script type="text/javascript">
				try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
			</script>
			<!-- 面包屑导航 -->
			<ul class="breadcrumb">
				<li>
					<i class="icon-home home-icon"></i>
					<a href="/admin.php/admin">首页</a>
				</li>
				<li class="active">订单管理</li>
			</ul><!-- .breadcrumb -->
		</div>
		<div class="page-content">
			<!-- 页面导航 -->
			<div class="page-header">
				<h1>
					订单管理
					<small>
						<i class="icon-double-angle-right"></i>
						查看
					</small>
				</h1>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<div class="tabbable">
						<ul class="nav nav-tabs" id="myTab">
							<li id="li_1" class="<?php echo ($active==1?'active':''); ?>">
								<a data-toggle="tab" href="#home">
									<i class="green icon-home bigger-110"></i>
									全部订单
								</a>
							</li>
							<li id="li_2" class="<?php echo ($active==2?'active':''); ?>">
								<a data-toggle="tab" href="#profile">
									<i class="gray  icon-cloud  bigger-110"></i>
									未发货
								</a>
							</li>
							<li id="li_3" class="<?php echo ($active==3?'active':''); ?>">
								<a data-toggle="tab" href="#profile1">
									<i class="green  icon-cloud-upload   bigger-110"></i>
									已发货
								</a>
							</li>
							<li id="li_5" class="<?php echo ($active==5?'active':''); ?>">
								<a data-toggle="tab" href="#profile3">
									<i class="blue  icon-check  bigger-110"></i>
									交易完成
								</a>
							</li>

						</ul>
						<!-- S展示内容 -->
						<div class="tab-content">
							<!-- 全部订单 -->
							<div id="home" class="tab-pane <?php echo ($active==1?'in active':''); ?>">

								<!--搜索结束-->
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover" id="sample-table-2">
										<thead>
											<tr>
												<th class="center" width="120px">商品名称</th>
												<th class="center" width="150px">订单编号</th>
												<th class="center" width="80px">收货人名</th>
												<th class="center" width="80px">收货人电话</th>
												<th class="center" width="80px">商品价格</th>
												<th class="center" width="300px">收货地址</th>
												<!-- <th class="center" width="80px">快递名称</th>
												<th class="center" width="130px">快递单号</th> -->
												<th class="center" width="80px">订单状态</th>
												<th class="center" width="80px">订单时间</th>

											</tr>
										</thead>
										<tbody>
												<?php if(is_array($orders_data)): $i = 0; $__LIST__ = $orders_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
														<td class="center" ><?php echo ($v["shangname"]); ?></td>
														<td class="center" ><?php echo ($v["onumber"]); ?></td>
														<td class="center" ><?php echo ($v["name"]); ?></td>
														<td class="center" ><?php echo ($v["photo"]); ?></td>
														<td class="center" ><?php echo ($v["total"]); ?></td>
														<td class="center" ><?php echo ($v["deliveryaddress"]); ?></td>
														<td class="center" >
															<?php switch($v["status"]): case "0": ?>待发货<?php break;?>
																<?php case "1": ?>待收货<?php break;?>
																<?php case "2": ?>已完成<?php break; endswitch;?>
														</td>
                                                        <td class="center" ><?php echo ($v["otime"]); ?></td>

													</tr><?php endforeach; endif; else: echo "" ;endif; ?>
											<tr style="height:50px;">
												<td colspan="7"><?php echo ($page); ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- 未发货 -->
							<div id="profile" class="tab-pane <?php echo ($active==2?'in active':''); ?>">

								<div class="ta1ble-responsive">
									<table class="table table-striped table-bordered table-hover" id="sample-table-2">
										<thead>
											<tr>
												<th class="center" width="120px">商品名称</th>
												<th class="center" width="150px">订单编号</th>
												<th class="center" width="80px">收货人名</th>
												<th class="center" width="80px">收货人电话</th>
												<th class="center" width="80px">商品价格</th>
												<th class="center" width="300px">收货地址</th>
												<th class="center" width="80px">订单状态</th>
												<th class="center" width="80px">订单时间</th>
												<th class="center" width="100px">操作</th>
											</tr>
										</thead>
										<tbody>
												<?php if(is_array($orders_data)): $i = 0; $__LIST__ = $orders_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
														<td class="center" ><?php echo ($v["shangname"]); ?></td>
														<td class="center" ><?php echo ($v["onumber"]); ?></td>
														<td class="center" ><?php echo ($v["name"]); ?></td>
														<td class="center" ><?php echo ($v["photo"]); ?></td>
														<td class="center" ><?php echo ($v["total"]); ?></td>
														<td class="center" ><?php echo ($v["deliveryaddress"]); ?></td>
														<td class="center" >
															<?php switch($v["status"]): case "0": ?>待发货<?php break;?>
																<?php case "1": ?>待收货<?php break;?>
																<?php case "2": ?>已完成<?php break; endswitch;?>
														</td>
                                                        <td class="center" ><?php echo ($v["otime"]); ?></td>
													<td class="center" >
														<a href="/admin.php/Admin/Ordermanage/orderState/onumber/<?php echo ($v["onumber"]); ?>">
															<i class="green  icon-cloud-upload   bigger-120"></i>
															发货
														</a>
													</td>
												</tr><?php endforeach; endif; else: echo "" ;endif; ?>
											<tr style="height:50px;">
												<td colspan="8"><?php echo ($page); ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- 已发货 -->
							<div id="profile1" class="tab-pane <?php echo ($active==3?'in active':''); ?>">

								<div class="ta1ble-responsive">
									<table class="table table-striped table-bordered table-hover" id="sample-table-2">
										<thead>
											<tr>
												<th class="center" width="120px">商品名称</th>
												<th class="center" width="150px">订单编号</th>
												<th class="center" width="80px">收货人名</th>
												<th class="center" width="80px">收货人电话</th>
												<th class="center" width="80px">商品价格</th>
												<th class="center" width="300px">收货地址</th>
												<th class="center" width="80px">快递名称</th>
												<th class="center" width="130px">快递单号</th> 
												<th class="center" width="80px">订单状态</th>
												<th class="center" width="80px">订单时间</th>
											</tr>
										</thead>
										<tbody>
											<?php if(is_array($orders_data)): $i = 0; $__LIST__ = $orders_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
														<td class="center" ><?php echo ($v["shangname"]); ?></td>
														<td class="center" ><?php echo ($v["onumber"]); ?></td>
														<td class="center" ><?php echo ($v["name"]); ?></td>
														<td class="center" ><?php echo ($v["photo"]); ?></td>
														<td class="center" ><?php echo ($v["total"]); ?></td>
														<td class="center" ><?php echo ($v["deliveryaddress"]); ?></td>
														<td class="center" ><?php echo ($v["kuaidiname"]); ?></td>
														<td class="center" ><?php echo ($v["expressnum"]); ?></td>
														<td class="center" >
															<?php switch($v["status"]): case "0": ?>待发货<?php break;?>
																<?php case "1": ?>待收货<?php break;?>
																<?php case "2": ?>已完成<?php break; endswitch;?>
														</td>
                                                        <td class="center" ><?php echo ($v["otime"]); ?></td>
												</tr><?php endforeach; endif; else: echo "" ;endif; ?>
											<tr style="height:50px;">
												<td colspan="9"><?php echo ($page); ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- 交易完成 -->
							<div id="profile3" class="tab-pane <?php echo ($active==5?'in active':''); ?>">

								<div class="ta1ble-responsive">
									<table class="table table-striped table-bordered table-hover" id="sample-table-2">
										<thead>
											<tr>
												<th class="center" width="120px">商品名称</th>
												<th class="center" width="150px">订单编号</th>
												<th class="center" width="80px">收货人名</th>
												<th class="center" width="80px">收货人电话</th>
												<th class="center" width="80px">商品价格</th>
												<th class="center" width="300px">收货地址</th>
												<th class="center" width="80px">快递名称</th>
												<th class="center" width="130px">快递单号</th> 
												<th class="center" width="80px">订单状态</th>
												<th class="center" width="80px">订单时间</th>
											</tr>
										</thead>
										<tbody>
											<?php if(is_array($orders_data)): $i = 0; $__LIST__ = $orders_data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
														<td class="center" ><?php echo ($v["shangname"]); ?></td>
														<td class="center" ><?php echo ($v["onumber"]); ?></td>
														<td class="center" ><?php echo ($v["name"]); ?></td>
														<td class="center" ><?php echo ($v["photo"]); ?></td>
														
														<td class="center" ><?php echo ($v["total"]); ?></td>
														<td class="center" ><?php echo ($v["deliveryaddress"]); ?></td>
														<td class="center" ><?php echo ($v["kuaidiname"]); ?></td>
														<td class="center" ><?php echo ($v["expressnum"]); ?></td>
														<td class="center" >
															<?php switch($v["status"]): case "0": ?>待发货<?php break;?>
																<?php case "1": ?>待收货<?php break;?>
																<?php case "2": ?>已完成<?php break; endswitch;?>
														</td>
                                                        <td class="center" ><?php echo ($v["otime"]); ?></td>
												</tr><?php endforeach; endif; else: echo "" ;endif; ?>
											<tr style="height:50px;">
												<td colspan="9"><?php echo ($page); ?></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<!-- E展示内容 -->
					</div>
				</div>
			</div>
		</div>
	</div>

			
			</div>
			<!-- 返回顶部 -->
			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="icon-double-angle-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		<!-- //加载公共js -->
		<script type="text/javascript">
		window.jQuery || document.write("<script src='/Public/admin/js/jquery-2.0.3.min.js'>"+"<"+"script>");
		</script>
		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='/Public/admin/js/jquery.mobile.custom.min.js'>"+"<"+"script>");
		</script>
		<script src="/Public/admin/js/bootstrap.min.js"></script>
		<script src="/Public/admin/js/ace-elements.min.js"></script>
		<script src="/Public/admin/js/ace.min.js"></script>
		<script src="/Public/admin/js/ace-extra.min.js"></script>
		
	<!-- //加载公共js -->
	<script type="text/javascript">
		jQuery(function($) {
			//设置当前页面的菜单高亮显示 开始
			var nownav = "#sidebar a[href*=Ordermanage]";
			var parentattr = $(nownav).parent().parent().attr("class");
			$(nownav).parent().addClass('active');
			if (parentattr == 'submenu') {
				$(nownav).parent().parent().parent().addClass('active open');
			};
			//设置当前页面的菜单高亮显示 结束
		});
		$("#li_1").click(function(){
			window.location="/admin.php/Admin/Ordermanage/index";
		});
		$("#li_2").click(function(){
			window.location="/admin.php/Admin/Ordermanage/nonDelivery";
		});
		$("#li_3").click(function(){
			window.location="/admin.php/Admin/Ordermanage/deliverGoods";
		});
		$("#li_5").click(function(){
			window.location="/admin.php/Admin/Ordermanage/completeDeal";
		});
	</script>

	</body>
</html>