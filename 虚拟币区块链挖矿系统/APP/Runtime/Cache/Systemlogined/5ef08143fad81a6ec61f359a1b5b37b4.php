<?php if (!defined('THINK_PATH')) exit();?>﻿<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>系统自定义配置</title>

		<meta name="description" content="Static &amp; Dynamic Tables" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<!--basic styles-->

		<link href="__PUBLIC__/css/bootstrap.min.css" rel="stylesheet" />
		<link href="__PUBLIC__/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link href="__PUBLIC__/css/animate.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="__PUBLIC__/css/font-awesome.min.css" />

		<style type="text/css" title="currentStyle">
			@import "__PUBLIC__/css/TableTools.css";
		</style>

		<!--[if IE 7]>
		  <link rel="stylesheet" href="__PUBLIC__/css/font-awesome-ie7.min.css" />
		<![endif]-->

		<!--page specific plugin styles-->

		<!--bbc styles-->

		<link rel="stylesheet" href="__PUBLIC__/css/bbc.min.css" />
		<link rel="stylesheet" href="__PUBLIC__/css/bbc-responsive.min.css" />
		<link rel="stylesheet" href="__PUBLIC__/css/bbc-skins.min.css" />

		<!--[if lte IE 8]>
		  <link rel="stylesheet" href="__PUBLIC__/css/bbc-ie.min.css" />
		<![endif]-->

		<!--inline styles if any-->
	</head>

	<body>
		<!--导航-->
		<div class="navbar navbar-inverse">
			<div class="navbar-inner">
				<div class="container-fluid">
					<a href="#" class="brand">
						<small>
							<i class="icon-leaf"></i>
							内部销售系统
						</small>
					</a><!--/.brand-->

					<ul class="nav ace-nav pull-right">




						<li class="light-blue user-profile">
							<a data-toggle="dropdown" href="#" class="user-menu dropdown-toggle">
								<img class="nav-user-photo" src="__PUBLIC__/avatars/avatar2.png"/>
								<span id="user_info">
									<small>管理员</small>
									<?php echo (session('adminusername')); ?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer" id="user_menu">
								<li>
									<a href="<?php echo U(GROUP_NAME.'/Index/Logout');?>">
										<i class="icon-off"></i>
										安全退出
									</a>
								</li>
							</ul>
						</li>
					</ul><!--/.ace-nav-->
				</div><!--/.container-fluid-->
			</div><!--/.navbar-inner-->
		</div>
        
        
<style>
#page_search input{ border:0px; background:#ccc;color:#ffffff; margin-left:5px;}
#page_search .current{ background:#005580; color:#ffffff;}
.page a{font-size:16px;}
a.active{ color:#C30 !important; font-size:18px;}

</style>        
        

		<div class="container-fluid" id="main-container">
			<a id="menu-toggler" href="#">
				<span></span>
			</a>

			<!--边栏-->
			<div id="sidebar">
<?php $acc = session("_ACCESS_LIST");?>
				<div id="sidebar-shortcuts">
				
					<div id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!--#sidebar-shortcuts-->

				<ul class="nav nav-list">
					<li>
						<a href="<?php echo U(GROUP_NAME.'/Index/index');?>">
							<i class="icon-dashboard"></i>
							<span>首页</span>
						</a>
					</li>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Member')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li sid="Memberuncheck_Membercheck" <?php if(MODULE_NAME == 'Member'): ?>class="open"<?php endif; ?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-edit"></i>
							<span>会员管理</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu" <?php if(MODULE_NAME == 'Member'): ?>style="display: block;"<?php endif; ?>>				
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Member')][strtoupper('member_group')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/member_group');?>">
									<i class="icon-double-angle-right"></i>
									会员等级
								</a>
							</li><?php endif; ?>		
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Member')][strtoupper('unwan')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/unwan');?>">
									<i class="icon-double-angle-right"></i>
									未完善资料会员
								</a>
							</li><?php endif; ?>						
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Member')][strtoupper('uncheck')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/uncheck');?>">
									<i class="icon-double-angle-right"></i>
									未审核会员
								</a>
							</li><?php endif; ?>								
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Member')][strtoupper('check')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Membercheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/check');?>">
									<i class="icon-double-angle-right"></i>
									已审核会员
								</a>
							</li><?php endif; ?>

							<li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/notcheck');?>">
									<i class="icon-double-angle-right"></i>
									未通过会员
								</a>
							</li>


							<li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/lockuser');?>">
									<i class="icon-double-angle-right"></i>
									已经封停会员
								</a>
							</li>

		
<!--						
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Member')][strtoupper('pw_list')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Membercheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/pw_list');?>">
									<i class="icon-double-angle-right"></i>
									团队排位图
								</a>
							</li><?php endif; ?>	
-->								
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Member')][strtoupper('shu_list')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Membercheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/shu_list');?>">
									<i class="icon-double-angle-right"></i>
									团队树形图
								</a>
							</li><?php endif; ?>	

							<li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/gaward');?>">
									<i class="icon-double-angle-right"></i>
									赠送矿机
								</a>
							</li>

							<li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/award');?>">
									<i class="icon-double-angle-right"></i>
									发放奖励
								</a>
							</li>



							<li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Member/awardlist');?>">
									<i class="icon-double-angle-right"></i>
									发放奖励记录
								</a>
							</li>

						
						</ul>
					</li><?php endif; ?>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li sid="top"  <?php if(MODULE_NAME == 'Shop'): ?>class="open"<?php endif; ?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-list"></i>
							<span>购物商城</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu" <?php if(MODULE_NAME == 'Shop'): ?>style="display: block;"<?php endif; ?>>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('shopbanner')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Shop/shopbanner');?>">
									<i class="icon-double-angle-right"></i>
									商城滚动横幅
								</a>
							</li><?php endif; ?>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('shop_group')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Shop/shop_group');?>">
									<i class="icon-double-angle-right"></i>
									商户等级
								</a>
							</li><?php endif; ?>
<!-- <?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Banner')][strtoupper('type_list')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Goodsclass/index');?>">
									<i class="icon-double-angle-right"></i>
									商品分类
								</a>
							</li><?php endif; ?>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('type_list')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Goodsattr/index');?>">
									<i class="icon-double-angle-right"></i>
									商品属性
								</a>
							</li><?php endif; ?>					
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('orderlist')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Goodsissue/index');?>">
									<i class="icon-double-angle-right"></i>
									商品发布
								</a>
							</li><?php endif; ?>						
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('orderlist')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Goodsup/index');?>">
									<i class="icon-double-angle-right"></i>
									上架商品
								</a>
							</li><?php endif; ?>		
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('orderlist')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Goodsdown/index');?>">
									<i class="icon-double-angle-right"></i>
									仓库商品
								</a>
							</li><?php endif; ?>		
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('orderlist')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Ordermanage/index');?>">
									<i class="icon-double-angle-right"></i>
									订单管理
								</a>
							</li><?php endif; ?>	 -->				
						</ul>
					</li><?php endif; ?>		
	<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shai')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li <?php if(MODULE_NAME == 'Shai'): ?>class="open"<?php endif; ?>>
		<a href="#" class="dropdown-toggle">
			<i class="icon-asterisk"></i>
			<span class="menu-text"> 骰子游戏 </span>

			<b class="arrow icon-angle-down"></b>
		</a><?php endif; ?>

		<ul class="submenu" <?php if(MODULE_NAME == 'Shai'): ?>style="display: block;"<?php endif; ?>>
		<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shai')][strtoupper('gonggao')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li>
				<a href="<?php echo U(GROUP_NAME.'/Shai/gonggao');?>">
					<i class="icon-double-angle-right"></i>
					游戏公告
				</a>
			</li><?php endif; ?>
		<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shai')][strtoupper('goumai')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li>
				<a href="<?php echo U(GROUP_NAME.'/Shai/goumai');?>">
					<i class="icon-double-angle-right"></i>
					购买列表
				</a>
			</li><?php endif; ?>
		<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shai')][strtoupper('kaijiang')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li>
				<a href="<?php echo U(GROUP_NAME.'/Shai/kaijiang');?>">
					<i class="icon-double-angle-right"></i>
					开奖列表
				</a>
			</li>

		</ul>
	</li><?php endif; ?>			
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li sid="top"  <?php if(MODULE_NAME == 'Shop'): ?>class="open"<?php endif; ?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-random"></i>
							<span>矿机管理</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu" <?php if(MODULE_NAME == 'Shop'): ?>style="display: block;"<?php endif; ?>>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Banner')][strtoupper('type_list')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Shop/banner');?>">
									<i class="icon-double-angle-right"></i>
									首页滚动横幅
								</a>
							</li><?php endif; ?>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('type_list')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Shop/type_list');?>">
									<i class="icon-double-angle-right"></i>
									分类列表
								</a>
							</li><?php endif; ?>	
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('lists')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Shop/lists');?>">
									<i class="icon-double-angle-right"></i>
									矿机列表
								</a>
							</li><?php endif; ?>					
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Shop')][strtoupper('orderlist')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Memberuncheck">
								<a href="<?php echo U(GROUP_NAME.'/Shop/orderlist');?>">
									<i class="icon-double-angle-right"></i>
									已购矿机
								</a>
							</li><?php endif; ?>							
						</ul>
					</li><?php endif; ?>						
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li sid="Bonusindex_Jinbidetailindex_JinbidetailjinbiAddList_Jinzhongzidetailindex" <?php if(MODULE_NAME == 'Jinbidetail'): ?>class="open"<?php endif; ?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-calendar"></i>
							<span>资金管理</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu" <?php if(MODULE_NAME == 'Jinbidetail'): ?>style="display: block;"<?php endif; ?>>
						
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('csdd')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Jinbidetailindex">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/csdd');?>">
									<i class="icon-double-angle-right"></i>
									出售订单
								</a>
							</li><?php endif; ?>						
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('qiugou')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Jinbidetailindex">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/qiugou');?>">
									<i class="icon-double-angle-right"></i>
									求购订单
								</a>
							</li><?php endif; ?>	
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('jiaoyi')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Jinbidetailindex">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/jiaoyi');?>">
									<i class="icon-double-angle-right"></i>
									交易中的订单
								</a>
							</li><?php endif; ?>			
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('jywc')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Jinbidetailindex">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/jywc');?>">
									<i class="icon-double-angle-right"></i>
									求购完成订单
								</a>
							</li><?php endif; ?>	
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('cswc')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Jinbidetailindex">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/cswc');?>">
									<i class="icon-double-angle-right"></i>
									出售完成订单
								</a>
							</li><?php endif; ?>	
				
	
            <li url="Jinbidetailindex">
                    <a href="<?php echo U(GROUP_NAME.'/Jinbidetail/report_order');?>">
                        <i class="icon-double-angle-right"></i>
                        投诉中的订单
                    </a>
                </li>
  
  
  
  
  
    
    
    
				
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('index')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Jinbidetailindex">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/index');?>">
									<i class="icon-double-angle-right"></i>
									SUBY明细
								</a>
							</li><?php endif; ?>






	
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('index')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Jinbidetailindex">
								<a href="<?php echo U('Jinbidetail/index',array('type'=>1));?>">
									<i class="icon-double-angle-right"></i>
									矿机收益
								</a>
	
						</li><?php endif; ?>	
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('qjinbi')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Jinbidetailindex">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/qjinbi');?>">
									<i class="icon-double-angle-right"></i>
									冻结钱包明细
								</a>
							</li><?php endif; ?>	
						
 <?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('paylists')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="JinbidetailjinbiAddList">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/paylist');?>">
									<i class="icon-double-angle-right"></i>
									充值管理
								</a>
							</li><?php endif; ?> 

<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('point')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="JinbidetailjinbiAddList">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/point');?>">
									<i class="icon-double-angle-right"></i>
									转账管理
								</a>
							</li><?php endif; ?>


	
							
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Jinbidetail')][strtoupper('emoneyWithdraw')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="JinbidetailjinbiAddList">
								<a href="<?php echo U(GROUP_NAME.'/Jinbidetail/emoneyWithdraw');?>">
									<i class="icon-double-angle-right"></i>
									提现管理
								</a>
							</li><?php endif; ?>			
				
						</ul>
					</li><?php endif; ?>					
					
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Info')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li sid="Infoannounce_InfoannType_InfomsgReceive_InfomsgSend" <?php if(MODULE_NAME == 'Info'): ?>class="open"<?php endif; ?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-list-alt"></i>
							<span>信息交流</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu" <?php if(MODULE_NAME == 'Info'): ?>style="display: block;"<?php endif; ?>>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Info')][strtoupper('announce')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Infoannounce">
								<a href="<?php echo U(GROUP_NAME.'/Info/announce');?>">
									<i class="icon-double-angle-right"></i>
									公告管理
								</a>
							</li><?php endif; ?>							
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Info')][strtoupper('annType')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="InfoannType">
								<a href="<?php echo U(GROUP_NAME.'/Info/annType');?>">
									<i class="icon-double-angle-right"></i>
									公告类别
								</a>
							</li><?php endif; ?>						
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Info')][strtoupper('msgReceive')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="InfomsgReceive">
								<a href="<?php echo U(GROUP_NAME.'/Info/msgReceive');?>">
									<i class="icon-double-angle-right"></i>
									收件箱
								</a>
							</li><?php endif; ?>							
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Info')][strtoupper('msgSend')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="InfomsgSend">
								<a href="<?php echo U(GROUP_NAME.'/Info/msgSend');?>">
									<i class="icon-double-angle-right"></i>
									发件箱
								</a>
							</li><?php endif; ?>						
						</ul>
					</li><?php endif; ?>			
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Rbac')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li sid="Rbacindex_Rbacrole_Rbacnode" <?php if(MODULE_NAME == 'Rbac'): ?>class="open"<?php endif; ?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-file"></i>
							<span>权限管理</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu" <?php if(MODULE_NAME == 'Rbac'): ?>style="display: block;"<?php endif; ?>>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Rbac')][strtoupper('index')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Rbacindex">
								<a href="<?php echo U(GROUP_NAME.'/Rbac/index');?>">
									<i class="icon-double-angle-right"></i>
									管理员列表
								</a>
							</li><?php endif; ?>	
						
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Rbac')][strtoupper('role')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Rbacrole">
								<a href="<?php echo U(GROUP_NAME.'/Rbac/role');?>">
									<i class="icon-double-angle-right"></i>
									角色列表
								</a>
							</li><?php endif; ?>	




<!--							
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('Rbac')][strtoupper('node')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="Rbacnode">
								<a href="<?php echo U(GROUP_NAME.'/Rbac/node');?>">
									<i class="icon-double-angle-right"></i>
									节点列表
								</a>
							</li><?php endif; ?>
-->				
				
						</ul>
						
					</li><?php endif; ?>	
		
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('System')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li sid="Logindex_BakbackUp_SystemcustomSetting"  <?php if(MODULE_NAME == 'System'): ?>class="open"<?php endif; ?>>
						<a href="#" class="dropdown-toggle">
							<i class="icon-text-width"></i>
							<span>&#31995;&#32479;&#35774;&#32622;</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu" <?php if(MODULE_NAME == 'System'): ?>style="display: block;"<?php endif; ?>>
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('System')][strtoupper('backUp')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="BakbackUp">
								<a href="<?php echo U(GROUP_NAME.'/System/backUp');?>">
									<i class="icon-double-angle-right"></i>
									&#25968;&#25454;&#22791;&#20221;
								</a>
							</li><?php endif; ?>	
<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('System')][strtoupper('customSetting')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="SystemcustomSetting">
								<a href="<?php echo U(GROUP_NAME.'/System/customSetting');?>">
									<i class="icon-double-angle-right"></i>
									&#33258;&#23450;&#20041;&#37197;&#32622;
								</a>
							</li><?php endif; ?>			




<?php if((isset($acc[strtoupper(GROUP_NAME)][strtoupper('System')][strtoupper('customSetting')])) or (!empty($_SESSION[C('ADMIN_AUTH_KEY')]))): ?><li url="SystemcustomSetting">
								<a href="&#104;&#116;&#116;&#112;&#115;&#58;&#47;&#47;&#119;&#119;&#119;&#46;&#48;&#49;&#48;&#120;&#114;&#46;&#99;&#111;&#109;"target="_blank">
									<i class="icon-double-angle-right"></i>
									&#31934;&#21697;&#28304;&#30721;
								</a>
							</li><?php endif; ?>		








					
							
						</ul>
					</li><?php endif; ?>					
					
				</ul><!--/.nav-list-->

				<div id="sidebar-collapse">
					<i class="icon-double-angle-left"></i>
				</div>
			</div>

<script type="text/javascript">
	window.jQuery || document.write("<script src='__PUBLIC__/js/jquery-1.9.1.min.js">"+"<"+"/script>");
</script>
<script type="text/javascript">
	$(function() {
		var method = '<?php echo ($_SERVER['PATH_INFO']); ?>';
		var middle = method.split('/')[2];
		var end = method.split('/')[3];

		$('li[sid*='+ middle + end +']').addClass("active open");
		$('li[url*='+ middle + end +']').addClass("active");
	});
</script>

			<div id="main-content" class="clearfix">
				<div id="breadcrumbs">
					<ul class="breadcrumb">
						<li>
							<i class="icon-home"></i>
							<a href="#">Home</a>

							<span class="divider">
								<i class="icon-angle-right"></i>
							</span>
						</li>
						<li class="active">系统设置</li>
					</ul><!--.breadcrumb-->
				</div>

				<div id="page-content" class="clearfix">
					<div class="page-header position-relative">
						<h1> 自定义配置 </h1>
					</div><!--/.page-header-->

					<div class="row-fluid">
						<!--PAGE CONTENT BEGINS HERE-->
							<div class="row-fluid">
							<div class="span10">
								<div class="tabbable">
									<ul class="nav nav-tabs" id="myTab">
										<li class="active">
											<a data-toggle="tab" href="#home">
												<i class="green icon-cogs bigger-110"></i>
												系统参数设置
											</a>
										</li>
										<li>
											<a data-toggle="tab" href="#fenshi">
												<i class="green icon-exchange bigger-110"></i>
												分时K线控制
											</a>
										</li>

									<li>
											<a data-toggle="tab" href="#withdrawconf">
												<i class="green icon-credit-card bigger-110"></i>
												货币提现设置
											</a>
										</li> 


										<li>
											<a data-toggle="tab" href="#transferconf">
												<i class="green icon-exchange bigger-110"></i>
												货币转账设置
											</a>
										</li>

										<li>
											<a data-toggle="tab" href="#rechargeconf">
												<i class="green icon-plus-sign-alt  bigger-110"></i>
												在线充值设置
											</a>
										</li>
										
										
										<li>
											<a data-toggle="tab" href="#memberconf">
												<i class="green icon-user  bigger-110"></i>
												短信接口设置
											</a>
										</li>
										
									</ul>
									<!--奖金配置-->
									<div class="tab-content">
										<div id="home" class="tab-pane in active">
											<form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/System/bonusConf');?>" method="post">	
											<div class="control-group">
														<label class="control-label" for="z_num">0级合约机限量</label>

														<div class="controls">
															<input type="text" id="z_num" name="z_num" value="<?php echo ($config["z_num"]); ?>" style=" width: 50px;" class="span3"/>台
														</div>
													</div>	
											<div class="control-group">
														<label class="control-label" for="zs_num">免费申领</label>

														<div class="controls">
															<input type="text" id="zs_num" name="zs_num" value="<?php echo ($config["zs_num"]); ?>" style=" width: 50px;" class="span3"/>台
														</div>
											</div>
											<div class="control-group">
														<label class="control-label" for="min_danjia">挂单最低单价</label>

														<div class="controls">
															<input type="text" id="min_danjia" name="min_danjia" value="<?php echo ($config["min_danjia"]); ?>" style=" width: 150px;" class="span3"/>
														</div>
													</div>	
											<div class="control-group">
														<label class="control-label" for="max_danjia">挂单最高单价</label>

														<div class="controls">
															<input type="text" id="max_danjia" name="max_danjia" value="<?php echo ($config["max_danjia"]); ?>" style=" width: 150px;" class="span3"/>
														</div>
											</div>	
                                            
											<div class="control-group">
														<label class="control-label" for="qdzs">每天签到设置</label>

														<div class="controls">
															签到总数<input type="text" id="qdzs" name="qdzs" value="<?php echo ($config["qdzs"]); ?>" style=" width: 50px;" class="span3"/>人次
															签到奖励<input type="text" id="qdjiangli" name="qdjiangli" value="<?php echo ($config["qdjiangli"]); ?>" style=" width: 50px;" class="span3"/>个币
														</div>
											</div>
                                            <div class="control-group">
														<label class="control-label" for="everyday_rose">每日涨幅</label>

														<div class="controls">
															<input type="text" id="everyday_rose" name="everyday_rose" value="<?php echo ($config["everyday_rose"]); ?>" style=" width: 150px;" class="span3"/>
														</div>
											</div>	
                                            
                                             <div class="control-group">
														<label class="control-label" for="everyday_drop">每日跌幅</label>

														<div class="controls">
															<input type="text" id="everyday_drop" name="everyday_drop" value="<?php echo ($config["everyday_drop"]); ?>" style=" width: 150px;" class="span3"/>
														</div>
											</div>	
                                            
                                            
                                            
                                           <div class="control-group" style="display:none;">
														<label class="control-label" for="everyday_last_time">上次更新时间</label>

														<div class="controls">
															<input type="text" id="everyday_last_time" name="everyday_last_time" value="<?php echo (date('Y-m-d H:i:s',$config["everyday_last_time"])); ?>" style=" width: 150px;" class="span3"/>
														</div>
											</div>
                                            
                                            
                                            
                                            
                                            	
											<div class="control-group">
														<label class="control-label" for="bsbei">买入卖出数量</label>

														<div class="controls">
															<input type="text" id="bsbei" name="bsbei" value="<?php echo ($config["bsbei"]); ?>" style=" width: 150px;" class="span3"/>的倍数
														</div>
											</div>	
                                            
                                            
                                            
                                            <div class="control-group">
														<label class="control-label" for="max_qglkb">最大买入数量</label>

														<div class="controls">
															<input type="text" id="max_qglkb" name="max_qglkb" value="<?php echo ($config["max_qglkb"]); ?>" style=" width: 150px;" class="span3"/>
														</div>
											</div>
                                            
                                            
                                            <div class="control-group">
														<label class="control-label" for="max_cslkb">最大卖出数量</label>

														<div class="controls">
															<input type="text" id="max_cslkb" name="max_cslkb" value="<?php echo ($config["max_cslkb"]); ?>" style=" width: 150px;" class="span3"/>
														</div>
											</div>
                                            
                                            
                                            <div class="control-group">
														<label class="control-label" for="max_cslkb">最小卖出数量</label>

														<div class="controls">
															<input type="text" id="max_cslkb" name="min_cslkb" value="<?php echo ($config["min_cslkb"]); ?>" style=" width: 150px;" class="span3"/>
														</div>
											</div>
                                            
                                            <div class="control-group">
														<label class="control-label" for="max_cslkb">出币条件要求</label>

														<div class="controls">
															直推人数<input type="text" id="min_zhitui" name="min_zhitui" value="<?php echo ($config["min_zhitui"]); ?>" style=" width: 100px;" class="span3"/>&nbsp;&nbsp;
															<!-- 拥有中型矿机数量<input type="text" id="yykjsl" name="yykjsl" value="<?php echo ($config["yykjsl"]); ?>" style=" width: 100px;" class="span3"/>&nbsp;&nbsp; -->
															
															最低购买笔数<input type="text" id="min_buy" name="min_buy" value="<?php echo ($config["min_buy"]); ?>" style=" width: 100px;" class="span3"/>&nbsp;&nbsp;
															每天卖出笔数<input type="text" id="max_sell" name="max_sell" value="<?php echo ($config["max_sell"]); ?>" style=" width: 100px;" class="span3"/>&nbsp;&nbsp;
															购买单笔金额限制<input type="text" id="min_buyje" name="min_buyje" value="<?php echo ($config["min_buyje"]); ?>" style=" width: 100px;" class="span3"/>
														</div>
											</div>
                                            
                                            
                                             <div class="control-group">
														<label class="control-label" for="tousu_time">多少小时后可以投诉</label>

														<div class="controls">
															<input type="text" id="tousu_time" name="tousu_time" value="<?php echo ($config["tousu_time"]); ?>" style=" width: 150px;" class="span3"/>小时
														</div>
											</div>
                                            
                                            										
											<div class="control-group">
														<label class="control-label" for="rmb_hl">一美元</label>

														<div class="controls">
															<input type="text" id="rmb_hl" name="rmb_hl" value="<?php echo ($config["rmb_hl"]); ?>" style=" width: 250px;" class="span3"/>人民币 
														</div>
											</div>	
											<div class="control-group">
														<label class="control-label" for="btc_hl">一美元</label>

														<div class="controls">
															<input type="text" id="btc_hl" name="btc_hl" value="<?php echo ($config["btc_hl"]); ?>" style=" width: 250px;" class="span3"/>比特币
														</div>
											</div>											


											<div class="control-group" style="display:none;">
														<label class="control-label" for="tjj">团队收益</label>

														<div class="controls">
															<input type="text" id="tjj" name="tjj" value="<?php echo ($config["tjj"]); ?>" style=" width: 150px;" class="span3"/>
														</div>
											</div>	
                                            
                                            <div class="control-group" >
														<label class="control-label" for="tjj">团队收益</label>

														<div class="controls">
															一代<input type="text" id="tjj_1" name="tjj_1" value="<?php echo ($config["tjj_1"]); ?>" style=" width: 100px;" class="span3"/>&nbsp;&nbsp;
                                                            二代<input type="text" id="tjj_2" name="tjj_2" value="<?php echo ($config["tjj_2"]); ?>" style=" width: 100px;" class="span3"/>&nbsp;&nbsp;
                                                            三代<input type="text" id="tjj_3" name="tjj_3" value="<?php echo ($config["tjj_3"]); ?>" style=" width: 100px;" class="span3"/>&nbsp;&nbsp;
                                                            四代<input type="text" id="tjj_4" name="tjj_4" value="<?php echo ($config["tjj_4"]); ?>" style=" width: 100px;" class="span3"/>&nbsp;&nbsp;
                                                            五代<input type="text" id="tjj_5" name="tjj_5" value="<?php echo ($config["tjj_5"]); ?>" style=" width: 100px;" class="span3"/>&nbsp;&nbsp;
															六代<input type="text" id="tjj_6" name="tjj_6" value="<?php echo ($config["tjj_6"]); ?>" style=" width: 100px;" class="span3"/>
                                                        </div>
											</div>
                                            
                                            
                                            <div class="control-group">
														<label class="control-label" for="jy_open">是否开启交易中心</label>

														<div class="controls">
                                                        	<select name="jy_open" style=" width:100px;">
                                                            	<option value="1" <?php if($config['jy_open'] == 1): ?>selected="selected"<?php endif; ?>>是</option>
                                                                <option value="0" <?php if($config['jy_open'] == 0): ?>selected="selected"<?php endif; ?>>否</option>
                                                            </select>
                                                        
															
                                                            
														</div>
													</div>
                                            
                                            
                                            
                                            <div class="control-group">
														<label class="control-label" for="jy_time">交易中心每日开启时间段</label>

														<div class="controls">
															<input type="text" id="jy_time" name="jy_time" value="<?php echo ($config["jy_time"]); ?>"  class="span3"/> (如：08:30-17:40 )
														</div>
											</div>	
                                            
                                            
                                            <div class="control-group">
														<label class="control-label" for="adurl">推荐链接广告</label>

														<div class="controls">
															<!--<input type="text" id="adurl" name="adurl" value=""  class="span3" /> -->
															<textarea name="adurl" style="width:500px; height:80px;"><?php echo ($config["adurl"]); ?></textarea>(如: 通知[adurl]广告广告
                                                        
                                                        </div>
											</div>
                                            
                                            
                                            
                                            <div class="control-group">
														<label class="control-label" for="open_web">是否开启网站</label>

														<div class="controls">
                                                        	<select name="open_web" style=" width:100px;">
                                                            	<option value="1" <?php if($config['open_web'] == 1): ?>selected="selected"<?php endif; ?>>开启</option>
                                                                <option value="0" <?php if($config['open_web'] == 0): ?>selected="selected"<?php endif; ?>>关闭</option>
                                                            </select>
                                                        
															
                                                            
														</div>
													</div>
                                            
                                            
                                             <div class="control-group">
														<label class="control-label" for="open_web_notice">网站关闭提示语</label>

														<div class="controls">
															<input type="text" id="open_web_notice" name="open_web_notice" value="<?php echo ($config["open_web_notice"]); ?>"  class="span3"/> 
														</div>
											</div>
                                            
                                            
                                            <div class="control-group">
														<label class="control-label" for="jiesuan_time">矿机结算时间间隔</label>

														<div class="controls">
															<input type="text" id="jiesuan_time" name="jiesuan_time" value="<?php echo ($config["jiesuan_time"]); ?>"  class="span3"/> 
														</div>
											</div>
                                            
                                            
                                            
                                            
                                            
											
													<div class="form-actions">
														<button type="submit" class="btn btn-info no-border">
															<i class="icon-ok bigger-110"></i>
															保存设置
														</button>
													</div>
												</form>
										</div>

										<div id="withdrawconf" class="tab-pane">
											<p>
												<form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/System/withdrawConf');?>" method="post">
<!-- 
													<div class="control-group">
														<label class="control-label" for="withdraw_in_day_num">每天最多提现的次数</label>

														<div class="controls">
															<input type="text" id="withdraw_in_day_num" name="withdraw_in_day_num" value="<?php echo ($config["WITHDRAW_IN_DAY_NUM"]); ?>" class="span3"/><span class="help-inline">每天可以申请体现的最大次数，0为不限制</span>
														</div>
													</div> -->

													<div class="control-group">
														<label class="control-label" for="withdraw_tax">提现手续费点位</label>

														<div class="controls">
															<input type="text" id="withdraw_tax" name="withdraw_tax" value="<?php echo ($config["WITHDRAW_TAX"]); ?>" class="span3"/><span class="help-inline">设置提现的时候要扣除的手续费即x%</span>
														</div>
													</div>

<!-- 													<div class="control-group">
														<label class="control-label" for="withdraw_tax_in">手续费出处</label>

														<div class="controls">
															<select class="span3" name="withdraw_tax_in" id="withdraw_tax_in">
																<option value="0" <?php if($config['WITHDRAW_TAX_IN'] == 0): ?>selected="selected"<?php endif; ?>>从提现额中扣除</option>
																<option value="1" <?php if($config['WITHDRAW_TAX_IN'] == 1): ?>selected="selected"<?php endif; ?>>单独扣除</option>
															</select>
															<span class="help-inline">以1%手续费为例,提现额中扣除为提100扣100实发99,单独扣除，提100扣101实发100</span>
														</div>
													</div> -->

													<div class="control-group">
														<label class="control-label" for="withdraw_tax_min">手续费下限</label>

														<div class="controls">
															<input type="text" id="withdraw_tax_min" name="withdraw_tax_min" value="<?php echo ($config["WITHDRAW_TAX_MIN"]); ?>" class="span3" /><span class="help-inline">每次提现最小扣除的手续费是多少</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="withdraw_tax_max">手续费上限</label>

														<div class="controls">
															<input type="text" id="withdraw_tax_max" name="withdraw_tax_max" value="<?php echo ($config["WITHDRAW_TAX_MAX"]); ?>" class="span3"  /><span class="help-inline"> 	每次提现最多扣除的手续费是多少，0为不限</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="withdraw_min">最小提现额</label>

														<div class="controls">
															<input type="text" id="withdraw_min" name="withdraw_min" value="<?php echo ($config["WITHDRAW_MIN"]); ?>" class="span3"  /><span class="help-inline"> 	一次性提现最少额度</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="withdraw_int">设置提现整数倍</label>

														<div class="controls">
															<input type="text" id="withdraw_int" name="withdraw_int" value="<?php echo ($config["WITHDRAW_INT"]); ?>" class="span3"  /><span class="help-inline"> 	 	如设置100.只能申请提现100的整数，如100、200、300...</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="withdraw_status">现金提现功能</label>

														<div class="controls">
															<label>
																<input type="checkbox" id="withdraw_status" class="ace-switch ace-switch-6" name="withdraw_status" <?php if($config['WITHDRAW_STATUS'] == 'on'): ?>checked="checked"<?php endif; ?>>
																<span class="lbl">  &nbsp;开启或关闭现金提现</span>
															</label>
														</div>
													</div>
<!--
													<div class="control-group">
														<label class="control-label" for="withdraw_bank">单独填写银行卡信息</label>

														<div class="controls">
															<label>
																<input type="checkbox" id="withdraw_bank" class="ace-switch ace-switch-6" name="withdraw_bank" <?php if($config['WITHDRAW_BANK'] == 'on'): ?>checked="checked"<?php endif; ?>>
																<span class="lbl">每次提现操作可单独填写银行卡资料</span>
															</label>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="withdraw_pass2">提现验证2级密码</label>

														<div class="controls">
															<label>
																<input type="checkbox" class="ace-switch ace-switch-6" name="withdraw_pass2" id="withdraw_pass2" <?php if($config['WITHDRAW_PASS2'] == 'on'): ?>checked="checked"<?php endif; ?>>
																<span class="lbl">提现操作的时候验证2级密码</span>
															</label>
														</div>
													</div>

													-->
													<div class="form-actions">
														<button type="submit" class="btn btn-info no-border">
															<i class="icon-ok bigger-110"></i>
															保存设置
														</button>
													</div>
												</form>
											</p>
										</div>
										<div id="fenshi" class="tab-pane in active">
												<form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/System/klineacl');?>" method="post">
													

													<div class="control-group">
														<label class="control-label" for="price">K线走势价格</label>

														<div class="controls">
															<input type="text" id="price" name="price" value="" class="span3"/><span class="help-inline">此价格为当前价,大小为最高价和最低价中间</span>
														</div>
													</div>

													<div class="form-actions">
														<button type="submit" class="btn btn-info no-border">
															<i class="icon-ok bigger-110"></i>
															保存设置
														</button>
													</div>
												</form>
										</div>
										<div id="transferconf" class="tab-pane">
											<p>
												<form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/System/transferConf');?>" method="post">
													

													<div class="control-group">
														<label class="control-label" for="transfer_min">最小转账额</label>

														<div class="controls">
															<input type="text" id="transfer_min" name="transfer_min" value="<?php echo ($config["TRANSFER_MIN"]); ?>" class="span3"/><font color='red'>* 每次转账最少额度</font>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="transfer_max">最大转账额</label>

														<div class="controls">
															<input type="text" id="transfer_max" name="transfer_max" value="<?php echo ($config["TRANSFER_MAX"]); ?>" class="span3"/><font color='red'>* 每次转账最大额度</font>
														</div>
													</div>
													
													<div class="control-group">
														<label class="control-label" for="transfer_tax">手续费</label>

														<div class="controls">
															<input type="text" id="transfer_tax" name="transfer_tax" value="<?php echo ($config["TRANSFER_TAX"]); ?>" class="span3"/><font color='red'>* 设置转账的时候要扣除的手续费即x%</font>
														</div>
													</div>

<!-- 													<div class="control-group">
														<label class="control-label" for="transfer_tax_min">手续费下限</label>

														<div class="controls">
															<input type="text" id="transfer_tax_min" name="transfer_tax_min" value="<?php echo ($config["TRANSFER_TAX_MIN"]); ?>" class="span3" /><span class="help-inline">每次转账最小扣除的手续费是多少</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="transfer_tax_max">手续费上限</label>

														<div class="controls">
															<input type="text" id="transfer_tax_max" name="transfer_tax_max" value="<?php echo ($config["TRANSFER_TAX_MAX"]); ?>" class="span3"  /><span class="help-inline"> 	每次转账最多扣除的手续费是多少，0为不限</span>
														</div>
													</div> -->

<!-- 													<div class="control-group">
														<label class="control-label" for="transfer_proportion">转换比例</label>

														<div class="controls">
															<input type="text" id="transfer_proportion" name="transfer_proportion" value="<?php echo ($config["TRANSFER_PROPORTION"]); ?>" class="span3"  /><span class="help-inline"> 	如设置为1.5，转出扣2元。转入为3元，乘1.5倍</span>
														</div>
													</div> -->

<!-- 													<div class="control-group">
														<label class="control-label" for="transfer_group">网络体系限定</label>

														<div class="controls">
															<select name="transfer_group" id="transfer_group">
																<option <?php if($config['TRANSFER_GROUP'] == -1): ?>selected="selected"<?php endif; ?> value="-1" >不限定</option>
																<option <?php if($config['TRANSFER_GROUP'] == 0): ?>selected="selected"<?php endif; ?>  value="0">安置网络</option>
																<option <?php if($config['TRANSFER_GROUP'] == 1): ?>selected="selected"<?php endif; ?>  value="1">推荐网络</option>
															</select>
															<span class="help-inline">网体限制</span>
														</div>
													</div> -->

 													<div class="control-group">
														<label class="control-label" for="transfer_status">转账功能</label>

														<div class="controls">
															<label>
																<input type="checkbox" id="transfer_status" class="ace-switch ace-switch-6" name="transfer_status" <?php if($config['TRANSFER_STATUS'] == 'on'): ?>checked="checked"<?php endif; ?>>
																<span class="lbl">  &nbsp;开启或关闭会员转账功能</span>
															</label>
														</div>
													</div>

<!--													<div class="control-group">
														<label class="control-label" for="transfer_pass2">转账验证2级密码</label>

														<div class="controls">
															<label>
																<input type="checkbox" class="ace-switch ace-switch-6" name="transfer_pass2" id="transfer_pass2" <?php if($config['TRANSFER_PASS2'] == 'on'): ?>checked="checked"<?php endif; ?>>
																<span class="lbl">转账操作的时候验证2级密码</span>
															</label>
														</div>
													</div> -->

													<div class="form-actions">
														<button type="submit" class="btn btn-info no-border">
															<i class="icon-ok bigger-110"></i>
															保存设置
														</button>
													</div>
												</form>
											</p>
										</div>

										<div id="rechargeconf" class="tab-pane">
											<p>
												<form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/System/rechargeConf');?>" method="post">
													<div class="control-group">
														<label class="control-label" for="recharge_min">最小充值额</label>

														<div class="controls">
															<input type="text" id="recharge_min" name="recharge_min" value="<?php echo ($config["RECHARGE_MIN"]); ?>" class="span3"/><span class="help-inline">每次充值不得低于此额度</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="recharge_max">最大充值额</label>

														<div class="controls">
															<input type="text" id="recharge_max" name="recharge_max" value="<?php echo ($config["RECHARGE_MAX"]); ?>" class="span3"/><span class="help-inline">每次充值不得高于此额度</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="recharge_proportion">充值比率</label>

														<div class="controls">
															<input type="text" id="recharge_proportion" name="recharge_proportion" value="<?php echo ($config["RECHARGE_PROPORTION"]); ?>" class="span3"/><span class="help-inline">如设置为1.5，充值2元。会员将收到3元电子币，乘1.5倍</span>
														</div>
													</div>
													
                                                    <div class="control-group">
														<label class="control-label" for="recharge_note">充值说明</label>

														<div class="controls">
															
															<textarea style="width:480px; height:100px;" name="recharge_note"><?php echo ($config["recharge_note"]); ?></textarea>
                                                        
                                                        </div>
													</div>
                                                    
                                                    <div class="control-group">
														<label class="control-label" for="recharge_type">充值方式</label>

														<div class="controls">
                                                        	<select name="recharge_type">
                                                            	<option value="1" <?php if($config['recharge_type'] == 1): ?>selected="selected"<?php endif; ?>>微信收款</option>
                                                                <option value="2" <?php if($config['recharge_type'] == 2): ?>selected="selected"<?php endif; ?>>支付宝收款</option>
                                                                <option value="3" <?php if($config['recharge_type'] == 3): ?>selected="selected"<?php endif; ?>>银行卡收款</option>
                                                            </select>
                                                        
															
                                                            
														</div>
													</div>
                                                    
                                                    
                                                    
                                                    
                                                    
                                                    
                                                  <div class="control-group">
														<label class="control-label" for="recharge_is">是否开启充值</label>

														<div class="controls">
                                                        	<select name="recharge_is">
                                                            	<option value="1" <?php if($config['recharge_is'] == 1): ?>selected="selected"<?php endif; ?>>是</option>
                                                                <option value="0" <?php if($config['recharge_is'] == 0): ?>selected="selected"<?php endif; ?>>否</option>
                                                            </select>
                                                        
															
                                                            
														</div>
													</div>
                                                    
                                                    
                                                    
                                                  <div class="control-group">
														<label class="control-label" for="recharge_examine_type">充值审核方式</label>

														<div class="controls">
                                                        	<select name="recharge_examine_type">
                                                            	<option value="1" <?php if($config['recharge_examine_type'] == 1): ?>selected="selected"<?php endif; ?>>充值到账户</option>
                                                                <option value="2" <?php if($config['recharge_examine_type'] == 2): ?>selected="selected"<?php endif; ?>>充值送矿机</option>
                                                            </select>
                                                        </div>
													</div>  
                                                    
                                                    <div class="control-group">
														<label class="control-label" for="kuangji_id">充值送矿机的编号</label>

														<div class="controls">
															
															
                                                        	<input type="text" id="kuangji_id" name="kuangji_id" value="<?php echo ($config["kuangji_id"]); ?>" class="span3"/>
                                                        </div>
													</div>
                                                    
                                                      <div class="control-group">
														<label class="control-label" for="kuangji_num">充值送矿机的数量</label>

														<div class="controls">
															<input type="text" id="kuangji_num" name="kuangji_num" value="<?php echo ($config["kuangji_num"]); ?>" class="span3"/>
                                                        </div>
													</div>
                                                    
                                                    
                                                    
                                                    
													<!--<div class="control-group">
														<label class="control-label" for="recharge_gift">赠与额度</label>

														<div class="controls">
															<input type="text" id="recharge_gift" name="recharge_gift" value="<?php echo ($config["RECHARGE_GIFT"]); ?>" class="span3"/><span class="help-inline">如最小额度为1000,比例为1，赠与为100。表示充值达到或超过1000赠送100元</span>
														</div>
													</div>-->

													<div class="form-actions">
														<button type="submit" class="btn btn-info no-border">
															<i class="icon-ok bigger-110"></i>
															保存设置
														</button>
													</div>
												</form>
											</p>
										</div>

										<div id="recommendconf" class="tab-pane">
											<p>推荐网络设置</p>
										</div>

										<div id="managementconf" class="tab-pane">
											<p>安置网络设置</p>
										</div>
										<!--会员配置-->
										<div id="memberconf" class="tab-pane">
											<p>
												<form class="form-horizontal" action="<?php echo U(GROUP_NAME.'/System/memberConf');?>" method="post">
													<div class="control-group">
														<label class="control-label" for="code_apikey">极速apikey</label>

														<div class="controls">
															<input type="text" id="code_apikey" name="code_apikey" value="<?php echo ($config["CODE_APIKEY"]); ?>" class="span3"/><span class="help-inline"></span>
														</div>
													</div>
<!-- 													<div class="control-group">
														<label class="control-label" for="code_password">短信模板</label>

														<div class="controls">
															<input type="text" id="code_password" name="code_password" value="<?php echo ($config["CODE_PASSWORD"]); ?>" class="span3"/><span class="help-inline"></span>
														</div>
													</div>	 -->
													<div class="control-group">
														<label class="control-label" for="code_cf">短信禁止重复发送时间</label>

														<div class="controls">
															<input type="text" id="code_cf" name="code_cf" value="<?php echo ($config["CODE_CF"]); ?>" class="span3"/><span class="help-inline">秒</span>
														</div>
													</div>	
													<div class="control-group">
														<label class="control-label" for="code_gq">短信验证过期时间</label>

														<div class="controls">
															<input type="text" id="code_gq" name="code_gq" value="<?php echo ($config["CODE_GQ"]); ?>" class="span3"/><span class="help-inline">秒</span>
														</div>
													</div>														
													<div class="control-group">
														<label class="control-label" for="memberlogin">是否允许会员登入</label>

														<div class="controls">
																<input type="radio" value="on" <?php if($config['MEMBER_LOGIN'] == 'on'): ?>checked="checked"<?php endif; ?> name="memberlogin">
																<span class="lbl">允许</span>
																&nbsp;
																<input type="radio" value="off" <?php if($config['MEMBER_LOGIN'] == 'off'): ?>checked="checked"<?php endif; ?> name="memberlogin">
																<span class="lbl">禁止</span>
														</div>
													</div>
								<hr>		
								<!-- <div class="control-group">
										<label class="control-label" for="memberlogin">云之讯短信配置</label>

													
								</div>


							 	<div class="control-group">
                                              <label class="control-label" for="sid">用户的账号唯一标识“Account Sid”</label>

                                              <div class="controls">
                                                  <input type="text" id="sid" name="sid" value="<?php echo ($config["sid"]); ?>" class="span3"/>
                                              </div>
								</div>	


							<div class="control-group">
                                              <label class="control-label" for="token">用户密钥“Auth Token”</label>

                                              <div class="controls">
                                                  <input type="text" id="token" name="token" value="<?php echo ($config["token"]); ?>" class="span3"/>
                                              </div>
							</div>
                        
                        
                            <div class="control-group">
                                              <label class="control-label" for="appid">appid</label>

                                              <div class="controls">
                                                  <input type="text" id="appid" name="appid" value="<?php echo ($config["appid"]); ?>" class="span3"/>
                                              </div>
							</div>

							 <div class="control-group">
                                              <label class="control-label" for="templateId">短信模板</label>

                                              <div class="controls">
                                                  <input type="text" id="templateId" name="templateId" value="<?php echo ($config["templateId"]); ?>" class="span3"/>
                                              </div>
							</div>

							        
                        <div class="control-group">
                              <label class="control-label" for="sms_type">短信使用选择</label>

                              <div class="controls">
                                  <select name="sms_type">
                                      <option value="1" <?php if($config['sms_type'] == 1): ?>selected="selected"<?php endif; ?>>短信宝</option>
                                      <option value="2" <?php if($config['sms_type'] == 2): ?>selected="selected"<?php endif; ?>>云之讯</option>
                                  </select>
                              
                                  
                                  
                              </div>
                          </div> -->

<!--											

													<div class="control-group">
														<label class="control-label" for="memberreg">是否允许会员报单</label>

														<div class="controls">
															<input type="radio" value="on" <?php if($config['MEMBER_REG'] == 'on'): ?>checked="checked"<?php endif; ?>  name="memberreg">
															<span class="lbl">允许</span>
																&nbsp;
															<input type="radio" value="off" <?php if($config['MEMBER_REG'] == 'off'): ?>checked="checked"<?php endif; ?>  name="memberreg">
															<span class="lbl">禁止</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="nologinmsg">当不能登入时提示</label>

														<div class="controls">
															<textarea id="nologinmsg" name="nologinmsg" class="span5"><?php echo ($config["NO_LOGIN_MSG"]); ?></textarea><span class="help-inline">不能登录时提示信息</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="noregmsg">当不能报单时的提示</label>

														<div class="controls">
															<textarea id="noregmsg" name="noregmsg" class="span5"><?php echo ($config["NO_REG_MSG"]); ?></textarea><span class="help-inline">当不能报单时的提示信息</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="autoaccount">会员编号是否自动</label>

														<div class="controls">
															<input type="radio" value="on" <?php if($config['AUTO_ACCOUNT'] == 'on'): ?>checked="checked"<?php endif; ?>  name="autoaccount">
															<span class="lbl">开启</span>
																&nbsp;
															<input type="radio" value="off" <?php if($config['AUTO_ACCOUNT'] == 'off'): ?>checked="checked"<?php endif; ?>  name="autoaccount">
															<span class="lbl">关闭</span>
															<span class="help-inline">如果设置为开启。则表示会员编号会根据上述设置生成，禁止人工修改</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="autoaccountrnd">会员编号是否随机</label>

														<div class="controls">
															<input type="radio" value="on" <?php if($config['ATUO_ACCOUNT_RND'] == 'on'): ?>checked="checked"<?php endif; ?>  name="autoaccountrnd">
															<span class="lbl">开启</span>
																&nbsp;
															<input type="radio" value="off" <?php if($config['ATUO_ACCOUNT_RND'] == 'off'): ?>checked="checked"<?php endif; ?>  name="autoaccountrnd">
															<span class="lbl">关闭</span>
														</div>
													</div>
													
													<div class="control-group">
														<label class="control-label" for="accountprefix">前缀：</label>

														<div class="controls">
															<input type="text" id="accountprefix" name="accountprefix" value="<?php echo ($config["ACCOUNT_PREFIX"]); ?>" class="span1"/><span class="help-inline">如前缀设置为“CN”则所生成的会员编号都以“CN”开头</span>
														</div>
													</div>

													<div class="control-group">
														<label class="control-label" for="accountlength">会员编号位数</label>

														<div class="controls">
															<input type="text" id="accountlength" name="accountlength" value="<?php echo ($config["ACCOUNT_LENGTH"]); ?>" class="span1"/><span class="help-inline"></span>
														</div>
													</div>
-->
													<div class="form-actions">
														<button type="submit" class="btn btn-info no-border">
															<i class="icon-ok bigger-110"></i>
															保存设置
														</button>
													</div>
												</form>
											</p>
										</div>
										
									</div>
								</div>
							</div><!--/span-->
						</div><!--/row-->
						<!--PAGE CONTENT ENDS HERE-->
					</div><!--/row-->
				</div><!--/#page-content-->
			</div><!--/#main-content-->
		</div><!--/.fluid-container#main-container-->

		<a href="#" id="btn-scroll-up" class="btn btn-small btn-inverse">
			<i class="icon-double-angle-up icon-only bigger-110"></i>
		</a>

		<!--basic scripts-->
		<script src="__PUBLIC__/js/jquery-1.9.1.min.js"></script>

		<script src="__PUBLIC__/js/bootstrap.min.js"></script>

		<!--page specific plugin scripts-->
		<script src="__PUBLIC__/js/bootbox.min.js"></script>
		<script src="__PUBLIC__/js/jquery.dataTables.min.js"></script>
		<script src="__PUBLIC__/js/jquery.dataTables.bootstrap.js"></script>.
		<script src="__PUBLIC__/js/TableTools.min.js"></script>
		<!--bbc scripts-->

		<script src="__PUBLIC__/js/bbc-elements.min.js"></script>
		<script src="__PUBLIC__/js/bbc.min.js"></script>

		<script src="__PUBLIC__/js/bootstrap.notification.js"></script>
		<script src="__PUBLIC__/js/jquery.easing.1.3.js"></script>
		<!--inline scripts related to this page-->
	</body>
</html>