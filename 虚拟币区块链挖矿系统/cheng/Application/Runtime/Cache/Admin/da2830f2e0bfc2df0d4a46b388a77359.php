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
				<li>
					<a href="/admin.php/admin/goodsdown">仓库商品</a>
				</li>
				<li class="active">商品修改</li>
			</ul><!-- .breadcrumb -->
		</div>
		<div class="page-content">
			<!-- 页面导航 -->
			<div class="page-header">
				<h1>
					商品修改
					<a href="/admin.php/admin/Goodsdown" class="btn btn-info btn-sm pull-right">
						<i class="icon-reply icon-only"></i>
					</a>
				</h1>
			</div>
		</div>
	</div>
	<!-- ================================= -->
	<div class="main-container">
		<div class="col-xs-9">
			<form class="form-horizontal" role="form" action="/admin.php/Admin/Goodsdown/updategoods" method="post" enctype="multipart/form-data">
				<!-- 商品编号 -->
				<input type="hidden" name="gid" value="<?php echo ($goodsdata["gid"]); ?>" />
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right">商品类别：</label>
					<div class="col-sm-10">
						<input type="text" class="col-xs-10 col-sm-5" name="gclassification" value="<?php echo ($goodsdata["gclassification"]); ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right">商品名称：</label>
					<div class="col-sm-10">
						<input type="text" class="col-xs-10 col-sm-5" name="gname" value="<?php echo ($goodsdata["gname"]); ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right">商品属性：</label>
					<div class="col-sm-10">
						<input type="text" class="col-xs-10 col-sm-5" name="gattribute" value="<?php echo ($goodsdata["gattribute"]); ?>" disabled>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right">商品价格：</label>
					<div class="col-sm-10">
						<input type="text" class="col-xs-10 col-sm-5" name="goldprice" value="<?php echo ($goodsdata["goldprice"]); ?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right">商品数量：</label>
					<div class="col-sm-10">
						<input type="text" class="col-xs-10 col-sm-5" value="<?php echo ($goodsdata["goodnums"]); ?>" name="goodnums">
					</div>
				</div>
				<div class="form-group" style="margin-bottom:0px;">
					<label class="col-sm-2 control-label no-padding-right">商品图片：</label>
					<div class="col-sm-10">
						<div class="ace-file-input no-padding col-xs-10 col-sm-5" style="height:220px;">
							<input type="file" class="class-input-file-2" name="gpic[]"  style="height:30px;"/>
							<input type="file" class="class-input-file-2" name="gpic[]"  style="height:30px;"/>
							<input type="file" class="class-input-file-2" name="gpic[]"  style="height:30px;"/>
							<input type="file" class="class-input-file-2" name="gpic[]"  style="height:30px;"/>
							<input type="file" class="class-input-file-2" name="gpic[]"  style="height:30px;"/>
						</div>
						<?php if(is_array($goodsdata["gpic"])): foreach($goodsdata["gpic"] as $key=>$vo): ?><div class="col-sm-5" style="height:47px;">
								<img width="40" src="/Public/Goodsuploads/<?php echo (implode('/60_',explode('/',$vo))); ?>" >
							</div><?php endforeach; endif; ?>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right">商品介绍：</label>
					<div class="col-sm-10">
						<!-- resize设置样式不能拖拽了 -->
						<textarea rows="20" class="col-sm-10" placeholder="商品介绍" name="gintroduce" style="resize:none;" id="content"><?php echo ($goodsdata["gintroduce"]); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right">参数规格：</label>
					<div class="col-sm-10">
						<textarea rows="20" class="col-sm-10" placeholder="参数规格" name="gspecifications" style="resize:none;" id="content1"><?php echo ($goodsdata["gspecifications"]); ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label no-padding-right">是否上架：</label>
					<div class="col-sm-2" style="margin-top:3px;">
						<input type="radio" name="issale" value="1" <?php echo ($goodsdata['issale']?'checked':''); ?>> 是
						&nbsp;&nbsp;&nbsp;
						<input type="radio" name="issale" value="0"  <?php echo ($goodsdata['issale']?'':'checked'); ?>> 否
					</div>
				</div>
				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
						<button type="submit" class="btn btn-info">
							<i class="icon-ok bigger-110"></i>
							发布
						</button>
						&nbsp; &nbsp; &nbsp;
						<button type="reset" class="btn">
							<i class="icon-undo bigger-110"></i>
							重置
						</button>
					</div>
				</div>
			</form>
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
			var nownav = "ul li a[href*=goodsdown]";
			var parentattr = $(nownav).parent().parent().attr("class");
			$(nownav).parent().addClass('active');
			if (parentattr == 'submenu') {
				$(nownav).parent().parent().parent().addClass('active open');
			};
			//设置当前页面的菜单高亮显示 结束
			$('.class-input-file-2').ace_file_input({
				no_file:'选择图片 ...',
				btn_choose:'上传',
				btn_change:'修改',
				droppable:false,
				onchange:null,
				thumbnail:false 
			});				
		
			//文件上传
			$('#id-file-format').removeAttr('checked').on('change', function() {
				var before_change
				var btn_choose
				var no_icon
				if(this.checked) {
					btn_choose = "Drop images here or click to choose";
					no_icon = "icon-picture";
					before_change = function(files, dropped) {
						var allowed_files = [];
						for(var i = 0 ; i < files.length; i++) {
							var file = files[i];
							if(typeof file === "string") {									
								if(! (/\.(jpe?g|png|gif|bmp)$/i).test(file) ) return false;
							}
							else {
								var type = $.trim(file.type);
								if( ( type.length > 0 && ! (/^image\/(jpe?g|png|gif|bmp)$/i).test(type) )
										|| ( type.length == 0 && ! (/\.(jpe?g|png|gif|bmp)$/i).test(file.name) )
									) continue;
							}								
							allowed_files.push(file);
						}
						if(allowed_files.length == 0) return false;
		
						return allowed_files;
					}
				}
				else {
					btn_choose = "Drop files here or click to choose";
					no_icon = "icon-cloud-upload";
					before_change = function(files, dropped) {
						return files;
					}
				}
				var file_input = $('#id-input-file-3');
				file_input.ace_file_input('update_settings', {'before_change':before_change, 'btn_choose': btn_choose, 'no_icon':no_icon})
				file_input.ace_file_input('reset_input');
			});
			$('.date-picker').datepicker({autoclose:true}).prev().on(ace.click_event, function(){
				$(this).next().focus();
			});
		});
	</script>
	<!-- 加载配置文件 2-->
	<script type="text/javascript" src="/Public/admin/js/ueditor/ueditor.config.js"></script>
	<!-- 加载编辑器源码文件3 -->
	<script type="text/javascript" src="/Public/admin/js/ueditor/ueditor.all.js"></script>
	<script type="text/javascript">
	//初始化编辑器，设定显示的按钮
	UE.getEditor('content',{initialFrameHeight:330,initialFrameWidth:650,toolbars:[['bold', 'insertimage', 'emotion','date','undo','redo','paragraph','fontfamily','forecolor','justify','lineheight','cleardoc']]});
	UE.getEditor('content1',{initialFrameHeight:330,initialFrameWidth:650,toolbars:[['bold', 'insertimage', 'emotion','date','undo','redo','paragraph','fontfamily','forecolor','justify','lineheight','cleardoc']]});
	</script>

	</body>
</html>