<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:74:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\applet\index.html";i:1575814731;s:77:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\new_left.html";i:1575814741;s:77:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\new_head.html";i:1575814741;}*/ ?>
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

<input type="hidden" id="choose" value="applet">

		<div class="content">

			<div class="clearfix">

				<div class="content_title fl agent_list_title">小程序管理</div>

				
				<div class="overview_right fr">

					<a href="<?php echo Url('Applet/choose_combo'); ?>"><div class="add_agent fl">新增小程序</div></a>

					<div class="agent_search hbj fl">

						<input class="agent_search_input flex1" type="" name="" id="keyworld" value="" placeholder="输入关键词" />

						<div class="agent_search_icon iconfont icon-sousuo" onclick="searchapp()"></div>

					</div>

				</div>

			</div>
<div class="overview_center clearfix" id="select_change">

                    <div class="overview_all fl" id="type1"><img class="img1" src="/image/list_ysj.png" /><img class="img2" src="/image/list_xjt.png" /><a href="<?php echo Url('Applet/index'); ?>">全部：<?php echo $all_count; ?></a></div>
                    <?php if($usergroup == 2): ?>
                    <div class="overview_all fl" id="type6"><img class="img1" src="/image/list_ysj.png" /><img class="img2" src="/image/list_xjt.png" /><a href="<?php echo Url('Applet/index'); ?>?show=5"> 管理员添加: <?php echo $admin_add_count; ?></a></div>

                    <div class="overview_all fl" id="type7"><img class="img1" src="/image/list_ysj.png" /><img class="img2" src="/image/list_xjt.png" /><a href="<?php echo Url('Applet/index'); ?>?show=6"> 代理商购买：<?php echo $jxs_add_count; ?></a></div>
                    <?php endif; ?>
                    <div class="overview_all fl" id="type2"><img class="img1" src="/image/list_ysj.png" /><img class="img2" src="/image/list_xjt.png" /><a href="<?php echo Url('Applet/index'); ?>?show=1"> 试用中：<?php echo $try_applet; ?></a></div>

                    <div class="overview_all fl" id="type3"><img class="img1" src="/image/list_ysj.png" /><img class="img2" src="/image/list_xjt.png" /><a href="<?php echo Url('Applet/index'); ?>?show=2">已购买：<?php echo $pay_applet; ?></a></div>

                    <div class="overview_all fl" id="type4"><img class="img1" src="/image/list_ysj.png" /><img class="img2" src="/image/list_xjt.png" /><a href="<?php echo Url('Applet/index'); ?>?show=3">购买将过期：<?php echo $littertime_applet; ?></a></div>

                    <div class="overview_all fl" id="type5"><img class="img1" src="/image/list_ysj.png" /><img class="img2" src="/image/list_xjt.png" /><a href="<?php echo Url('Applet/index'); ?>?show=4">购买过期：<?php echo $endtime_applet; ?></a></div>

                    <input type="hidden" value="id1" id="commonID">

                </div>

			<table class="agent_list_table small_program_tabel" border="0" cellspacing="0" cellpadding="0">

				<thead>

					<tr style="width: 100%">

						<th width="4%">ID</th>

						<th width="14%">名称</th>

						<th width="10%">管理员</th>

						<th width="8%">电话</th>

						<th width="8%">类型</th>

						<th width="15%">时间</th>

						<th width="7%">剩余天数</th>

						<th width="34%">操作</th>

					</tr>

					<?php if($allapplet): foreach($allapplet as $item): ?>

					<tr>

						<td class="fontfamily-a"><?php echo $item['id']; ?></td>

						<td><?php echo $item['name']; ?></td>

						<td><?php echo $item['username']; ?></td>

						<td class="fontfamily-a"><?php echo $item['tel']; ?></td>

						<td>

							<?php $type = unserialize($item['type']); if($type): if(in_array('0', $type)): ?>微信小程序<br><?php endif; ?>

						<!-- 	<?php if(in_array('2', $type)): ?>支付宝小程序<br><?php endif; if(in_array('1', $type)): ?>百度小程序<?php endif; ?> -->

							<?php endif; ?>

						</td>

						<td class="fontfamily-a"><?php if($item['end_time']==0): else: ?><?php echo date('Y-m-d',$item['dateline']); ?>-<?php echo date('Y-m-d',$item['end_time']); endif; ?></td>

						<td  class="fontfamily-a"> <?php if($item['end_time']==0): else: ?><?php echo $item['days']; endif; ?></td>

						<td>

							<input type="hidden" value="<?php echo $item['flag']; ?>">

							<a href="<?php echo Url('Datashow/index'); ?>?appletid=<?php echo $item['id']; ?>" >

								<input type="button" value="进入管理" class="newbtn" style="cursor:pointer;color: #fb8166;">

							</a>
                            <span class="linetd"></span>
							<a href="<?php echo Url('Applet/edit'); ?>?id=<?php echo $item['id']; ?>">

								<input type="button" value="编辑"  class="newbtn" style="cursor:pointer">

							</a>
                            <span class="linetd"></span>
							<input type="button" value="绑定管理员"  class="newbtn" style="cursor:pointer" data-toggle="modal" href="#stack2" onclick="bangding(<?php echo $item['id']; ?>)">
                            <span class="linetd"></span>
							<input type="button" value="解绑管理员"  class="newbtn" style="cursor:pointer" onclick="jiebang(<?php echo $item['id']; ?>,<?php echo $item['bangding']; ?>)">
                            <span class="linetd"></span>
							<?php if($item['pay_time'] < 0): ?>

								<a href="<?php echo Url('Applet/billing'); ?>?appletid=<?php echo $item['id']; ?>"><span class="newbtn">开通</span></a>

							<?php else: ?>

								<a href="<?php echo Url('Applet/billing'); ?>?appletid=<?php echo $item['id']; ?>"><span class="newbtn">续费</span></a>

							<?php endif; ?>

						</td>

					</tr>

					<?php endforeach; endif; ?>

				</thead>

			</table>

			<div class="list_page">

					<?php echo $applet->render(); ?>

			</div>

		</div>

		

		<!--解绑管理员-->

		<div class="alertbox" id="jiebang" style="display:none">

			<div class="alert2" style="height: 160px">

				<div class="alert2_head">解绑管理员

					</image src="/image/close_alert.png"/>

				</div>

				<div class="alert2_content hbj">

					<div class="alert2_content_text">您确定要解绑管理员<span id="jb_name" style="color: #f73e4c;">王美丽</span>么？</div>

                    <input type="hidden" id="jb_id" name="jb_id" value="">

					<div style="cursor:pointer" class="alert2_content_btn1" onclick="jieb_ex()">确定</div>

					<div style="cursor:pointer" class="alert2_content_btn2" onclick="cell_jb()">取消</div>

				</div>

			</div>

		</div>

		<!--解绑管理员-->
<!--解绑管理员-->

        <div class="alertbox" id="jiebang2" style="display:none">

            <div class="alert2" style="height: 160px">

                <div class="alert2_head">解绑管理员

                    </image src="/image/close_alert.png"/>

                </div>

                <div class="alert2_content hbj">

                    <div class="alert2_content_text">该小程序还未绑定管理员，请先绑定！</div>

                    <input type="hidden" id="jb_id" name="jb_id" value="">

                    <div style="cursor:pointer" class="alert2_content_btn1" onclick="jieb_ex2()">确定</div>

                </div>

            </div>

        </div>

        <!--解绑管理员-->

		<!--绑定管理员-->

        <form action="<?php echo Url('Applet/admin_add'); ?>"   class="form-horizontal" method="post" enctype="multipart/form-data">

            <div class="alertbox" id="stack2" style="display: none">

                <div class="alert2" style="top: 300px">

                    <div class="alert2_head">绑定管理员

                        <img src="/image/close_alert.png" onclick="notshow()"/>

                    </div>

                    <div class="alert2_content">

                        <div class="hbj">

                            <input type="hidden" name="userid" id="userid">

                            <input type="hidden" name="appletid" id="appletid">

                            <div class="bind_title">手机号</div>

                            <input class="bind_input" type="text" name="" id="tel" value="" />

                            <div onclick="userget()" class="bind_btn">搜索</div>

                        </div>

                        <div class="search_result" id="yonghu">



                            <div class="search_result_title" id="yhm"></div>

                            <div class="search_result_title" id="xim"></div>



                            <button class="bind_btn" style="background-color: #d84a38" type="submit" >绑定</button>

                        </div>



                    </div>

                    <!--<div class="alert2_content hbj" style="display:none" id="yonghu">-->

                        <!--<table >-->

                            <!--<tr>-->

                                <!--<td id="yhm" ></td>-->

                                <!--<td id="xim" ></td>-->

                            <!--</tr>-->

                        <!--</table>-->

                    <!--</div>-->

                    <!--<div  class="alert2_content hbj" style="display:none" id="bangding">-->

                        <!--<button class="bind_btn" type="submit" >绑定</button>-->

                    <!--</div>-->

                </div>

            </div>

        </form>

		<!--绑定管理员-->

	</body>



</html>

<script type="text/javascript">

	//判断显示类型

	$(function () {

		var show = '<?php echo input('show'); ?>';

		if(show){

		    if(show == 1){

		        $("#type2").addClass('on');

			}else if(show == 2){

                $("#type3").addClass('on');

			}else if(show == 3){

                $("#type4").addClass('on');

			}else if(show == 4){

                $("#type5").addClass('on');

			}else if(show == 5){

                $("#type6").addClass('on');

            }else if(show == 6){

                $("#type7").addClass('on');
                
            }



		}else{

		    $("#type1").addClass('on');

		}

    });





    //将请求设置为同步

    $.ajaxSetup({

        async : false

    });



    //关闭绑定窗口

	function notshow() {

		$("#stack2").hide();

    }



    //解绑显示框

    function jiebang(id,bangding) {

        if(bangding==0){

           $('#jiebang2').show()

            return;

        }

        var name = "";

        //获取管理员名称

        $.post("<?php echo Url('Applet/adminname'); ?>",{"appletid":id},function(data){

            name = data;

        })

        $("#jb_name").html(name);

        $("#jb_id").val(id);

        $("#jiebang").show();

    }

    

    //执行解绑
    function jieb_ex2(){
        $('#jiebang2').hide()
    }
    function jieb_ex() {

        var id = $("#jb_id").val();

        $.post("<?php echo Url('Applet/del_admin'); ?>",{"appletid":id},function(data){

            location.reload();

        })
    }



    //关闭解绑

    function cell_jb() {

        $("#jiebang").hide();



    }



    // 搜索功能

    function searchapp(){

        var val = $("#keyworld").val();

        if(!val){

            alert("请输入搜索小程序名称");

        }else{

            location.href="<?php echo Url('Applet/index'); ?>"+"?keyworld="+val;

        }



    }



    // 绑定管理员信息搜索

    function userget(){

        var tel = $("#tel").val();

        if(!tel){

            alert("请输入手机号码！");

            return;

        }

        if(!(/^1[3456789]\d{9}$/.test(tel))){

            alert("请输入正确的手机号码！");

            return ;

        }

        $.post("<?php echo Url('Applet/userinfo'); ?>",{"tel":tel},function(data){



            if(data.message){

                $("#bangding").hide();

                $("#yonghu").hide();

                alert(data.message);

            }else{

                $("#yonghu").show();

                $("#yhm").html("用户名："+data.username);

                $("#xim").html("姓名："+data.realname);

                $("#userid").val(data.uid);

            }



        })





    }

    // 绑定管理员

    function bangding(id){

        $("#stack2").show();

        $("#yonghu").hide();

        $("#tel").val("");

        $("#appletid").val(id);

    }



    // 解绑管理员

    function jieb(id,bangding){

        if(bangding==0){

            alert("该小程序还未绑定管理员，请先绑定！");

            return;

        }

        var name = "";

        //获取管理员名称

        $.post("<?php echo Url('Applet/adminname'); ?>",{"appletid":id},function(data){

            name = data;

        })

        if(confirm('你确定要解绑该小程序的管理员'+name+'嘛？')){

            $.post("<?php echo Url('Applet/del_admin'); ?>",{"appletid":id},function(data){

                location.reload();

            })

        }else{

            return false;

        }



    }







    function checkaddinfo(){



        var username = $("#username").val();



        var realname = $("#realname").val();



        var mobile = $("#mobile").val();



        //业务类型

        var type = [];

        $('input[name="type[]"]:checked').each(function(){

            type.push($(this).val());

        });



        if(!username){



            alert("请输入用户名！");



            return false;



        }else if(!realname){



            alert("请输入用户真实姓名！");



            return false;



        }else if(!mobile){



            alert("请输入用户手机号");



            return false;



        }else if(type.length == 0){



            alert("请选择业务类型");



            return false;



        }else{



            return true;



        }







    }



</script>