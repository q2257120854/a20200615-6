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
				<li class="active">仓库商品</li>
			</ul><!-- .breadcrumb -->
		</div>
		<div class="page-content">
			<!-- 页面导航 -->
			<div class="page-header">
				<h1>
					仓库商品
					<small>
						<i class="icon-double-angle-right"></i>
						查看
					</small>
				</h1>
			</div>
			<div class="row">
				<div class="col-xs-12">
					<!--搜索-->
					<div class="row" style="padding:0px;height:auto;overflow:hidden;margin-bottom:10px;">
							<div class="col-xs-12 col-sm-8">
							<a class="btn btn-primary pull-left" style="padding:1px 10px;" href="/admin.php/admin/goodsissue">
								<i class="icon-plus-sign bigger-125"></i>
								商品发布
							</a>
						</div>
						<div class="col-xs-12 col-sm-4">
							<form action="/admin.php/Admin/Goodsdown/search" method="get">
								<div class="input-group pull-right">
									<input class="form-control search-query" type="text" value="<?php echo ($searchval); ?>" name="uname" placeholder="输入搜索内容...">
									<span class="input-group-btn">
										<button class="btn btn-info btn-sm" type="submit">
											Search
											<i class="icon-search icon-on-right bigger-110"></i>
										</button>
									</span>
								</div>
							</form>
						</div>
					</div>
					<!--搜索结束-->
					<div class="table-responsive">
						<table id="sample-table-2" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th class="center" width="5%">
										<label>
											<input type="checkbox" class="ace" id="check"/>
											<span class="lbl"></span>
										</label>
									</th>
									<th class="center"  width="10%">商品图片</th>
									<th class="center" >商品名称</th>
									<th class="center" >价格</th>
									<th class="center" >库存</th>
									<th class="center" >总销量</th>
									<th class="center" >发布时间</th>
									<th class="center" width="10%">操作</th>
								</tr>
							</thead>
							<tbody>
								<?php if(is_array($goodupdata)): foreach($goodupdata as $key=>$vo): ?><tr>
										<td class="center">
											<label>
												<input type="hidden" name="gid[]" value="<?php echo ($vo["gid"]); ?>" />
												<input type="checkbox" class="ace" name="box"/>
												<span class="lbl"></span>
											</label>
										</td>
										<td class="center"  width="80px">
											<img width="40px" src="/Public/Goodsuploads/<?php echo (implode('/30_',explode('/',$vo["gpic"]))); ?>">
										</td>
										<td><?php echo ($vo["gname"]); ?></td>
										<td class="center" >￥<?php echo ($vo["goldprice"]); ?></td>
										<td class="center" ><?php echo ($vo["goodnums"]); ?></td>
										<td class="center" ><?php echo ($vo["gsellnums"]); ?></td>
										<td class="center" ><?php echo (date("Y-m-d H:i:s",$vo["gissuetime"])); ?></td>
										<td>
											<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
												<a class="blue" name="up_<?php echo ($vo["gid"]); ?>" data-toggle="modal" href="#myModal">
													<i class="icon-upload bigger-130"></i>
												</a>
												<a class="green" href="/admin.php/Admin/Goodsdown/modgoods/gid/<?php echo ($vo["gid"]); ?>">
													<i class="icon-pencil bigger-130"></i>
												</a>
												<a name="del_<?php echo ($vo["gid"]); ?>" class="red" data-toggle="modal" href="#deleteModal">
													<i class="icon-trash bigger-130"></i>
												</a>
											</div>
										</td>
									</tr><?php endforeach; endif; ?>
								<tr style="height:50px;">
									<td colspan="8"><?php echo ($page); ?></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- 删除按钮弹出层 -->
	<!-- S删除数据提示 -->
	<div class="modal modal-small fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="width:300px;">
			<div class="modal-content" style="top:160px;left:80%;">
				<div class="modal-header" style="height:40px;padding:5px 10px;line-height:30px;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<p class="bigger-120" id="myModalLabel">删除数据</p>
				</div>
				<div class="modal-body" style="height:70px;padding:5px 10px;line-height:60px;">
					<p class="text-danger bigger-150">确定删除数据！</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" id="delete-data">删除</button>
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>
	<!-- E删除数据提示 -->
	<!-- S商品下架提示 -->
	<div class="modal modal-small fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog" style="width:300px;">
			<div class="modal-content" style="top:160px;left:80%;">
				<div class="modal-header" style="height:40px;padding:5px 10px;line-height:30px;">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<p class="bigger-120" id="myModalLabel">商品上架</p>
				</div>
				<div class="modal-body" style="height:70px;padding:5px 10px;line-height:60px;">
					<p class="text-danger bigger-150">确定上架该商品！</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" id="up-goods">确定</button>
					<button type="button" class="btn btn-sm btn-default" data-dismiss="modal">取消</button>
				</div>
			</div>
		</div>
	</div>
	<!-- E商品下架提示 -->
	<div id="delete-success" class="alert alert-success fade in col-xs-4" style="position:fixed;top:20px;left:35%;z-index:1000;">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<strong>删除数据成功!</strong>
	</div>
	<div id="delete-error" class="alert alert-danger fade in col-xs-4" style="position:fixed;top:20px;left:35%;z-index:10000;">
		<button class="close" aria-hidden="true" data-dismiss="alert" type="button">×</button>
		<strong>删除数据失败!</strong>
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
			var nownav = "#sidebar a[href*=Goodsdown]";
			var parentattr = $(nownav).parent().parent().attr("class");
			$(nownav).parent().addClass('active');
			if (parentattr == 'submenu') {
				$(nownav).parent().parent().parent().addClass('active open');
			};
			//设置当前页面的菜单高亮显示 结束
			//全选js
			$('table th input:checkbox').on('click', function(){
				var that = this;
				$(this).closest('table').find('tr > td:first-child input:checkbox')
				.each(function(){
					this.checked = that.checked;
					$(this).closest('tr').toggleClass('selected');
				});
			});
			//删除弹窗和信息提示
			$('#delete-success').fadeOut(0);
			$('#delete-error').fadeOut(0);
			var delid;
			var delline;
			// 操作的是a标签，里面的name属性，匹配给定的属性是以某些值开始的元素（^）
			$('a[name^=del]').on('click',function(){
				// split函数，以'_'拆分name属性，为一个数组，将下标为1的数值保存至变量，即要操作的id值
				delid = ($(this).attr('name').split('_'))[1];
				// 找到当前点击删除位置的tr行，父元素的父元素的父元素就是tr
				delline = $(this).parent().parent().parent();
			});
			// 删除商品ajax操作
			$('#delete-data').on('click',function(){
				$.ajax({
					url:"/admin.php/Admin/Goodsdown/delgoods",
					type:"get",
					data:{gid:delid},
					// 执行成功执行以下函数，返回值为data
					success:function(data){
						if (data == 1) {
							// 干掉相应的tr行
							delline.remove();
							warningInfo("#success-info","删除成功！");
						}else{
							warningInfo("#error-info","删除失败！");
						}
						$('#deleteModal').modal('hide');
					}
				});
			});
			var upid;
			var upline;
			// 操作的是a标签，里面的name属性，匹配给定的属性是以某些值开始的元素（^）
			$('a[name^=up]').on('click',function(){
				// split函数，以'_'拆分name属性，为一个数组，将下标为1的数值保存至变量，即要操作的id值
				upid = ($(this).attr('name').split('_'))[1];
				// 找到当前点击删除位置的tr行，父元素的父元素的父元素就是tr
				upline = $(this).parent().parent().parent();
			});
			// 商品上架ajax操作
			$('#up-goods').on('click',function(){
				$.ajax({
					url:"/admin.php/Admin/Goodsdown/upGoods",
					type:"get",
					data:{gid:upid},
					// 执行成功执行以下函数，返回值为data
					success:function(data){
						if (data == 1) {
							// 干掉相应的tr行
							upline.remove();
							warningInfo("#success-info","商品上架成功！");
						}else{
							warningInfo("#error-info","商品上架失败！");
						}
						$('#myModal').modal('hide');
					}
				});
			}); 
			//信息提示函数
			function warningInfo(id,info){
				$(id).removeClass('hide');
				$(id).fadeOut(0);
				$(id).children().eq(1).html(info);
				$(id).fadeToggle(0).delay(1000).fadeToggle(1000);
			}
		});
	</script>

	</body>
</html>