<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"/www/wwwroot/2.cnhjdy.net/public/../application/index/view/upappse/index.html";i:1575814744;s:79:"/www/wwwroot/2.cnhjdy.net/public/../application/index/view/public/new_left.html";i:1575814742;s:79:"/www/wwwroot/2.cnhjdy.net/public/../application/index/view/public/new_head.html";i:1575814742;}*/ ?>
<!DOCTYPE html>

<html>



<head>

    <meta charset="UTF-8">

    <link rel="stylesheet" type="text/css" href="/css/iconfont_new.css" />

    <link rel="stylesheet" type="text/css" href="/css/new-index.css" />

    <script src="/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>

    <script src="/js/new-index.js" type="text/javascript" charset="utf-8"></script>

    <title><?php echo \think\Session::get('sysnames'); ?></title>

</head>



<body>

<div class="nav_side">

    <img class="logo2" src="/image/logo2.png" />

    <div class="nav_sidebox">

        <a href="<?php echo Url('Applet/index'); ?>">

        <div class="nav_side_single" id="index">

            <div class="iconfont icon-index"></div>

            <div class="navside_text">首页</div>

        </div>
        
        <?php if(\think\Session::get('usergroup')==2): ?>
        </a>

        <a href="<?php echo Url('Combo/index'); ?>">

        <div class="nav_side_single" id="combo">

            <div class="iconfont icon-taocan"></div>

            <div class="navside_text">功能套餐</div>

        </div>

        </a>

        <a href="<?php echo Url('Timecombo/index'); ?>">

        <div class="nav_side_single" id="time_combo">

            <div class="iconfont icon-shijian"></div>

            <div class="navside_text">时长套餐</div>

        </div>

        </a>

       

        <a href="<?php echo Url('Applet/jxs'); ?>">

            <div class="nav_side_single" id="jxs">

                <div class="iconfont icon-daili"></div>

                <div class="navside_text">代理商管理</div>

            </div>

        </a>

        
        <a href="<?php echo Url('Log/index'); ?>">

        <div class="nav_side_single" id="log">

            <div class="iconfont icon-rizhi"></div>

            <div class="navside_text">系统日志</div>

        </div>

        </a>

       

        <?php endif; ?>

         <a href="<?php echo Url('Applet/index'); ?>" >

        <div class="nav_side_single" id="applet">

            <div class="iconfont icon-xiaochengxu"></div>

            <div class="navside_text">小程序管理</div>

        </div>

        </a>

        <a href="<?php echo Url('Applet/user'); ?>">

        <div class="nav_side_single" id="user">

            <div class="iconfont icon-guanli"></div>

            <div class="navside_text">用户管理</div>

        </div>

        </a>
       
        <?php if(\think\Session::get('usergroup')==2): ?>
        <a href="<?php echo Url('ComAdmin/Functionshow/index'); ?>">

        <div class="nav_side_single" id="user">

            <div class="iconfont icon-30wangzhanguanli"></div>

            <div class="navside_text">网站管理</div>

        </div>

        </a>
         <a href="<?php echo Url('Upappse/index'); ?>">

            <div class="nav_side_single" id="update">

                <div class="iconfont icon-shujugengxin"></div>

                <div class="navside_text">系统更新</div>

            </div>

        </a>
        <?php endif; ?>

    </div>

</div>



<script>

    $(function () {

        var show = $("#choose").val();

        if(show == 'combo'){

            $("#combo").removeClass('nav_side_single').addClass('nav_side_single_show');

        }else if(show == 'timecombo'){

            $("#time_combo").removeClass('nav_side_single').addClass('nav_side_single_show');

        }else if(show == 'applet'){

            $("#applet").removeClass('nav_side_single').addClass('nav_side_single_show');

        }else if(show == 'jxs'){

            $("#jxs").removeClass('nav_side_single').addClass('nav_side_single_show');

        }else if(show == 'user'){

            $("#user").removeClass('nav_side_single').addClass('nav_side_single_show');

        }else if(show == 'log'){

            $("#log").removeClass('nav_side_single').addClass('nav_side_single_show');

        }else if(show == 'update'){

            $("#update").removeClass('nav_side_single').addClass('nav_side_single_show');

        }



    });

</script>

<script type="text/javascript" src="/js/jquery.form.js"></script>
<div class="head clearfix">
    <div class="fl" style="display: inline-block;color: #584f9e;line-height: 78px;font-size: 24px;font-weight: bold;"><?php echo \think\Session::get('sysnames'); ?></div>

    <div class="head_line fl"></div>

    <div class="head_title fl">运营管理系统</div>

    <div class="fr clearfix">

        <div class="head_balance fl" style="display: none" id="show_balance">

            <span class="iconfont icon-qianbao"></span>余额：<span id="balance">100</span>

        </div>

        <div class="head_line2 fl"></div>

        <div class="head_portrait fl" onclick="show_info()">
            <?php
                $icon = $_SESSION['icon'];
            if($icon): ?>
                <img src="<?php echo $icon; ?>" style="width: 35px; height: 35px; text-align: center;" />
                <div>个人中心</div> 
            <?php else: ?>
                <img src="/image/tx.png" style="width: 35px; height: 35px; text-align: center;" />
                <div>个人中心</div> 
            <?php endif; ?>

            

        </div>

        <div class="head_line2 fl"></div>

        <div class="head_exit fl">

            <span class="iconfont icon-tuichu"></span><a href="<?php echo Url('Login/index'); ?>">退出</a>

        </div>

    </div>

</div>

<form id='myupload' action="<?php echo Url('Applet/upimg'); ?>" method='post' enctype='multipart/form-data'>
    <input type="file" id="uploadphoto" name="uploadfile" value="请点击上传图片"   style="display:none" />
</form>


<div class="alertbox" id="info" style="display: none;">

    <div class="alert" id="alert1">

        <div class="alert_head">个人中心

            <img src="/image/close_alert.png" onclick="close_info()"/>

        </div>

        <div class="alert_content">

            <form action="<?php echo Url('Applet/save_admininfo'); ?>" method="POST" enctype="multipart/form-data" onsubmit="return checkadmininfo()">

                <div class="clearfix">

                    <div class="alert_form_left fl">

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">用户名<span>*</span></div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="text" name="username" id="gr_admin_username" placeholder="密码默认为123456，请登录账号修改"/>

                            </div>

                        </div>

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">头像</div>

                            <div class="alert_form_right hbj fl">

                                <img class="upimg" src="/image/upimg.png" id="showicon" />

                                <div class="up_imgbox">

                                    <div class="up_img_btn" onClick="uploadphoto.click();">上传图片

                                        <input type="hidden" name="icon" id="admin_icon" value="" />

                                    </div>

                                    <div class="up_img_bz">建议上传正方形图片</div>

                                </div>

                            </div>

                        </div>

                        <div class="clearfix">

                            <div class="open_form_title fl">姓名<span>*</span></div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="text" name="realname" id="admin_realname" value="" />

                            </div>

                        </div>

                    </div>

                    <div class="alert_form_left fr">

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">手机号码<span>*</span></div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="text" name="mobile" id="admin_mobile" value="" />

                            </div>

                        </div>

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">邮箱</div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="email" name="email" id="admin_email" value="" />

                            </div>

                        </div>

                        <div class="clearfix">

                            <div class="open_form_title fl">新密码</div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="password" name="password" id="admin_password" value="" />

                            </div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="uid" id="admin_uid" value="">

                <input type="hidden" name="oldusername" id="admin_oldusername" value="">

                <input class="alert_submit" type="submit" name="" id="" value="确定" />

            </form>

        </div>

    </div>

</div>



<script>



    //显示余额

    $(function () {

        $.post("<?php echo Url('Applet/user_balance'); ?>",function(data){

            if(data['group'] == 3){

                console.log(data);

                $("#balance").html(data['balance']);

                $("#show_balance").show();

            }

        });

    });





    function show_info() {

        //获取个人信息

        $.post("<?php echo Url('Applet/admin_info'); ?>",function(data){

            $("#gr_admin_username").val(data['username']);

            $("#admin_oldusername").val(data['username']);

            $("#admin_realname").val(data['realname']);

            $("#admin_mobile").val(data['mobile']);

            $("#admin_email").val(data['email']);

            $("#admin_uid").val(data['uid']);

            $("#admin_password").val("");

            if(data['icon']){

                $("#showicon").attr('src', data['icon']);

            }else{

                $("#showicon").attr('src', '/image/upimg.png');

            }

        });

        $("#info").show();

    }



    function close_info() {

        $("#info").hide();

    }



    function checkadmininfo(){

        var username = $("#gr_admin_username").val();

        var realname = $("#admin_realname").val();

        var mobile = $("#admin_mobile").val();

        if(!username){

            alert("请输入用户名！");

            return false;

        }else if(!realname){

            alert("请输入用户真实姓名！");

            return false;

        }else if(!mobile){

            alert("请输入用户手机号");

            return false;

        }else{

            return true;

        }

    }



    $("#uploadphoto").change(function(){
        $("#myupload").ajaxSubmit({ 
          dataType:  'json', //数据格式为json 
          success: function(data) {
            $("#admin_icon").val(data);
            $(".upimg").attr("src",data);
          }
        }); 
    });






</script>

<input type="hidden" id="choose" value="update">

<div class="content1">

	<div class="update_headbox hbj">

		<div class="upgradebox">

			<img class="upgrade_img" src="/image/upgrade.png"/>

			<div class="upgrade_text1"><?php echo $updateinfo; ?></div>

			<div class="upgrade_text2">当前版本为：V<?php echo VERSION_APP; ?></div>
			<?php
				if($lastver != VERSION_APP){
				echo '<a href="javascript:;"><div class="upgrade_btn" style="cursor: pointer" onclick="update_ver()">升级</div></a>';
				}
			?>
			

		</div>

		<div class="update_head_center flex1">
			<?php if($lastver != VERSION_APP): ?>
			<div class="update_head_center_div">

				<div class="update_title">更新内容：</div>

				<div class="update_contentbox">

					<?php echo $chanageinfo; ?>

				</div>

			</div>
			<?php else: ?>
			<div class="update_head_center_div2" >

				<img src="/image/update_null.jpg"/>

				<div>无更新内容</div>

			</div>
			<?php endif; ?>

		</div>

		<div class="update_timebox fr">

			<img class="upgrade_img" src="/image/update.png"/>

			<div class="update_text1">更新时间</div>
			<?php if($updatetime == "" & $updatemin == ""): ?>
			已是最新版
			<?php else: ?>
			<div class="update_date"><?php echo $updatetime; ?></div>

			<div class="update_date"><?php echo $updatemin; ?></div>
			<?php endif; ?>

		</div>

	</div>

	<div class="update_record">

		<div class="update_record_title">更新记录：</div>

		<div class="update_record_box clearfix">

			<?php if(is_array($l_con) || $l_con instanceof \think\Collection || $l_con instanceof \think\Paginator): $i = 0; $__LIST__ = $l_con;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

				<div class="update_record_single hbj2">



					<div class="update_record_single_right flex1">

						<?php echo $vo; ?>



					</div>



				</div>

			<?php endforeach; endif; else: echo "" ;endif; ?>

		</div>

	</div>

</div>

<!--确认升级提示-->

<div class="alertbox" style="display: none;" id="show_del">

    <div class="alert2" style="height: 168px">

        <div class="alert2_head">是否升级

            <img src="/image/close_alert.png" onclick="close_update()"/>

        </div>

        <div class="alert2_content hbj">

            <div class="alert2_content_text">
            <p style="color:red">升级前,请确认已经做好数据库和程序备份!</p>
			<p style="text-align: center;">确定升级吗？</p>
            </div>

            <div class="alert2_content_btn1" onclick="update_yes()" style="cursor: pointer">确定</div>

            <div class="alert2_content_btn2" onclick="close_update()" style="cursor: pointer">取消</div>

        </div>

    </div>

</div>

<!--确认升级提示-->

<!--确认升级成功提示-->

<div class="alertbox" style="display: none;"  id="del_success">

    <div class="alert3">

        <div class="alert2_head">提示

        </div>

        <div class="alert3_content">

            <div class="alert3_content_icon iconfont icon-chenggong"></div>

            <div class="alert3_content_text">正在升级，请不要关闭页面/跳转页面</div>

        </div>

    </div>

</div>

<!--确认升级成功提示-->

</body>



<div class="update_record_single hbj2" style="display: none">

	<div class="update_record_single_left">

		<img src="/image/label.png"/>

		<div>V2.09</div>

	</div>

	<div class="update_record_single_right flex1">

		<div class="update_record_time">更新时间：2018-08-06  19:03:21</div>

		<div class="update_content_single">【修复】DIY视频提示优化，视频前端不显示修复 </div>



	</div>

</div>

<script>

    function update_ver() {

        $("#show_del").show();

    }
	function update_yes(){
		$("#show_del").hide();
		$("#del_success").show();
		window.location.href="./upcaoz.html?vs=<?php echo $lastver; ?>";
	}

	function close_update(){
		$("#show_del").hide();
	}

</script>

</html>

