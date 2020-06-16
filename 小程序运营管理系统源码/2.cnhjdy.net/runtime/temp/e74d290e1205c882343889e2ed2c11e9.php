<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:75:"/www/wwwroot/2.cnhjdy.net/public/../application/index/view/combo/index.html";i:1575814732;s:79:"/www/wwwroot/2.cnhjdy.net/public/../application/index/view/public/new_left.html";i:1575814742;s:79:"/www/wwwroot/2.cnhjdy.net/public/../application/index/view/public/new_head.html";i:1575814742;}*/ ?>
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
<form id='my_upload' action="<?php echo Url('Applet/upimg'); ?>" method='post' enctype='multipart/form-data'>
    <input type="file" id="upload_photo" name="uploadfile" value="请点击上传图片"   style="display:none" />
</form>

<form id='edit_my_upload' action="<?php echo Url('Applet/upimg'); ?>" method='post' enctype='multipart/form-data'>
    <input type="file" id="edit_upload_photo" name="uploadfile" value="请点击上传图片"   style="display:none" />
</form>

<input type="hidden" id="choose" value="combo">

<div class="content">

    <div class="clearfix">

        <div class="content_title fl agent_list_title">我管理的功能套餐</div>

        <div class="overview_right fr">

            <div class="add_agent fl" onclick="add_combo()" style="cursor: pointer">添加功能套餐</div>

            <div class="agent_search hbj fl">

                <input class="agent_search_input flex1" type="" name="" id="keyworld" value="" placeholder="输入关键词" />

                <div class="agent_search_icon iconfont icon-sousuo" onclick="search()"></div>

            </div>

        </div>

    </div>

    <table class="time_meal_table" border="0" cellspacing="0" cellpadding="0">

        <thead>

        <tr>

            <th>ID</th>

            <th>套餐图标</th>

            <th>套餐名称</th>

            <th>微信价格</th>

            <th>百度价格</th>

            <th>支付宝价格</th>

            <th>创建时间</th>

            <th>操作</th>

        </tr>

        <?php if(is_array($combo) || $combo instanceof \think\Collection || $combo instanceof \think\Paginator): $i = 0; $__LIST__ = $combo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

        <tr>

            <td class="fontfamily-a"><?php echo $vo['id']; ?></td>

            <td>

                <?php if($vo['icon']): ?>

                    <img src="<?php echo $vo['icon']; ?>" style="width: 50px; height: 50px"/>

                <?php else: ?>

                    <div class="fun_meal_icon iconfont icon-taocan1"></div>

                <?php endif; ?>

            </td>

            <td><?php echo $vo['name']; ?></td>

            <td class="fontfamily-a"><?php echo $vo['wx_price']; ?></td>

           <td><?php echo $vo['baidu_price']; ?></td>

            <td><?php echo $vo['ali_price']; ?></td>

            <td class="fontfamily-a"><?php echo date('Y-m-d ', $vo['createtime']); ?></td>

            <td>

                <a href="<?php echo Url('Combo/rule'); ?>?id=<?php echo $vo['id']; ?>" style="display: inline-block;">

                    <input type="button" value="分配权限"  class="newbtn" style="cursor: pointer;">

                </a>
                <span class="linetd"></span>
                <div class="newbtn" style="cursor: pointer;display: inline-block;" onclick="edit_combo(<?php echo $vo['id']; ?>)">修改套餐</div>
                <span class="linetd"></span>
                <div class="newbtn" style="margin-right: 0; cursor: pointer;display: inline-block;" onclick="del_combo(<?php echo $vo['id']; ?>)">删除套餐</div>

            </td>

        </tr>

        <?php endforeach; endif; else: echo "" ;endif; ?>

        </thead>

    </table>

    <div class="list_page">

        <?php echo $combo->render(); ?>

    </div>

</div>

<!--添加套餐-->

<div class="alertbox" style="display: none" id="add_combo">

    <div class="alert">

        <div class="alert_head">添加功能套餐

            <img src="/image/close_alert.png" onclick="close_combo()"/>

        </div>

        <div class="alert_content">

            <form action="<?php echo Url('Combo/save_combo'); ?>" id="form_sample_2"  method="post" enctype="multipart/form-data" onsubmit = "return checkinfo();">

                <div class="clearfix">

                    <div class="alert_form_left fl">

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">套餐名称<span>*</span></div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="text" name="name" id="name" value=""/>

                            </div>

                        </div>

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">图标</div>

                            <div class="alert_form_right hbj fl">

                                <img class="upimg" id="upimg" src="/image/upimg.png" />

                                <div class="up_imgbox">

                                    <div class="up_img_btn" onClick="upload_photo.click();">上传图片

                                        <input type="hidden" name="icon" id="icon" value="" />

                                    </div>

                                    <div class="up_img_bz">建议上传正方形图片</div>

                                </div>

                            </div>

                        </div>

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">微信价格<span>*</span></div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="text" name="wx_price" id="wx_price" value="" />

                                <div class="alert_form_dw">元/年</div>

                            </div>

                        </div>

                      <div class="clearfix">

                            <div class="open_form_title fl">百度价格<span>*</span></div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="text" name="baidu_price" id="baidu_price" value="" />

                                <div class="alert_form_dw">元/年</div>

                            </div>

                        </div>

                    </div>

                    <div class="alert_form_left fr">

                       <div class="clearfix mb-30">



                            <div class="alert_form_right fr">

                                <input class="open_form_text" type="text" name="ali_price" id="ali_price" value="" />

                                <div class="alert_form_dw">元/年</div>

                            </div>

                            <div class="open_form_title fr">支付宝价格<span>*</span></div>

                        </div>


                        <div class="clearfix">



                            <div class="alert_form_right fr">

                                <textarea class="alert_form_textarea" name="combo_desc" rows="" cols="" id="combo_desc"></textarea>

                            </div>

                            <div class="open_form_title fr">套餐简介</div>

                        </div>

                    </div>

                </div>

                <input class="alert_submit" type="submit" name="" value="确定" />

            </form>

        </div>

    </div>

</div>

<!--添加套餐-->

<!--编辑套餐-->

<div class="alertbox" style="display: none" id="edit_combo">

    <div class="alert" style="height: 460px;top: 0;bottom: 0">

        <div class="alert_head">修改功能套餐

            <img src="/image/close_alert.png" onclick="close_e_combo()"/>

        </div>

        <div class="alert_content">

            <form action="<?php echo Url('Combo/save_edit_combo'); ?>"   method="post" enctype="multipart/form-data" onsubmit = "return checkeditinfo();">

                <div class="clearfix">

                    <div class="alert_form_left fl">

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">套餐名称<span>*</span></div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="text" name="name" id="e_name" value=""/>

                            </div>

                        </div>

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">图标</div>

                            <div class="alert_form_right hbj fl">

                                <img class="upimg"  src="/image/upimg.png" id="edit_icon" />

                                <div class="up_imgbox">

                                    <div class="up_img_btn" onClick="edit_upload_photo.click();">上传图片

                                        <input type="hidden" name="icon" id="e_icon" value="" />

                                    </div>

                                    <div class="up_img_bz">建议上传正方形图片</div>

                                </div>

                            </div>

                        </div>

                        <div class="clearfix mb-30">

                            <div class="open_form_title fl">微信价格<span>*</span></div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="text" name="wx_price" id="e_wx_price" value="" />

                                <div class="alert_form_dw">元/年</div>

                            </div>

                        </div>

                       <div class="clearfix">

                            <div class="open_form_title fl">百度价格<span>*</span></div>

                            <div class="alert_form_right fl">

                                <input class="open_form_text" type="text" name="baidu_price" id="e_baidu_price" value="" />

                                <div class="alert_form_dw">元/年</div>

                            </div>

                        </div>

                    </div>

                    <div class="alert_form_left fr">

                       <div class="clearfix mb-30">



                            <div class="alert_form_right fr">

                                <input class="open_form_text" type="text" name="ali_price" id="e_ali_price" value="" />

                                <div class="alert_form_dw">元/年</div>

                            </div>

                            <div class="open_form_title fr">支付宝价格<span>*</span></div>

                        </div>


                        <div class="clearfix">



                            <div class="alert_form_right fr">

                                <textarea class="alert_form_textarea" name="combo_desc" rows="" cols="" id="e_combo_desc"></textarea>

                            </div>

                            <div class="open_form_title fr">套餐简介</div>

                        </div>

                    </div>

                </div>

                <input type="hidden" name="id" id="e_id">

                <input class="alert_submit" type="submit" name=""  value="确定" />

            </form>

        </div>

    </div>

</div>

<!--编辑套餐--> 

<!--删除提示-->

<div class="alertbox" style="display: none;" id="show_del">

    <div class="alert2" style="height: 160px;">

        <div class="alert2_head">删除套餐

            <img src="/image/close_alert.png" onclick="close_del()"/>

        </div>

        <div class="alert2_content hbj">

            <div class="alert2_content_text">确定要删除名为<span id="combo_name" style="color: #f73e4c;">王美丽</span>的套餐吗？</div>

            <input type="hidden" value="" name="id" id="id">

            <div class="alert2_content_btn1" onclick="del_ex()" style="cursor: pointer">确定</div>

            <div class="alert2_content_btn2" onclick="close_del()" style="cursor: pointer">取消</div>

        </div>

    </div>

</div>

<!--删除提示-->

<!--删除成功-->

<div class="alertbox" style="display: none;"  id="del_success">

    <div class="alert3">

        <div class="alert2_head">提示

            <img src="/image/close_alert.png" onclick="close_success()"/>

        </div>

        <div class="alert3_content">

            <div class="alert3_content_icon iconfont icon-chenggong"></div>

            <div class="alert3_content_text">删除成功！</div>

        </div>

    </div>

</div>

<!--删除成功-->

</body>

<script type="text/javascript">

    // 搜索功能

    function search(){

        var val = $("#keyworld").val();

        if(!val){

            alert("请输入搜索套餐名");

        }else{

            location.href="<?php echo Url('Combo/index'); ?>"+"?keyworld="+val;

        }

    }

    function del_user_conf(){

        if(confirm('您确定要删除该套餐嘛?')){

            return true;

        }else{

            return false;

        }

    }

    

    //添加套餐

    function add_combo() {

        $("#add_combo").show();

    }



    //关闭添加套餐

    function close_combo() {

        $("#add_combo").hide();

    }



    //检验提交

    function checkinfo(){

        var name = $("#name").val();



        var wx_price = $("#wx_price").val();

        var baidu_price = $("#baidu_price").val();

         var ali_price = $("#ali_price").val();





        if(!name){

            alert("请输入套餐名称！");

            return false;

        }else if(!wx_price){

            alert("请设置套餐微信价格！");

            return false;

        }
        else if(!baidu_price){

            alert("请设置套餐百度价格！");

            return false;

        }else if(!ali_price){

            alert("请设置套餐支付宝价格！");

            return false;

        }
        else{

            return true;

        }

    }



    //删除套餐

    function del_combo(id) {

        var id = id;

        //获取管理员名称

        $.post("<?php echo Url('Combo/combo_name'); ?>",{"id":id},function(data){

            $("#combo_name").html(data);

        });

        $("#id").val(id);

        $("#show_del").show();

    }



    //执行删除

    function del_ex() {

        $("#show_del").hide();

        var id = $("#id").val();

        $.post("<?php echo Url('Combo/del_combo'); ?>",{"id":id},function(data){

            if(data == 1){

                $("#del_success").show();

                setInterval(g, 2000);



            }else{

                return false;

            }

        })

    }



    //关闭删除提示

    function close_del() {

        $("#show_del").hide();

    }



    // //手动关闭成功提示框

    function close_success() {

        $("#del_success").hide();

    }



    function g() {

        location.reload();

    }



    //编辑套餐

    function edit_combo(id) {

        var id = id;

        $.post("<?php echo Url('Combo/combo_info'); ?>",{"id":id},function(data){

            $("#e_id").val(data['id']);

            $("#e_name").val(data['name']);

            $("#e_wx_price").val(data['wx_price']);

            $("#e_baidu_price").val(data['baidu_price']);

            $("#e_ali_price").val(data['ali_price']);

            if(data['icon']){

                $("#edit_icon").attr('src',data['icon']);

            }else{

                $("#edit_icon").attr('src','/image/upimg.png');

            }

            $("#e_combo_desc").html(data['combo_desc']);

        });

        $("#edit_combo").show();

    }



    //关闭套餐

    function close_e_combo (id) {

        $("#edit_combo").hide();

    }



    function checkeditinfo(){

        var name = $("#e_name").val();



        var wx_price = $("#e_wx_price").val();

        var baidu_price = $("#e_baidu_price").val();

        var ali_price = $("#e_ali_price").val();





        if(!name){

            alert("请输入套餐名称！");

            return false;

        }else if(!wx_price){

            alert("请设置套餐微信价格！");

            return false;

        }
        else if(!baidu_price){

            alert("请设置套餐百度价格！");

            return false;

        }else if(!ali_price){

            alert("请设置套餐支付宝价格！");

            return false;

        }
        else{

            return true;

        }

    }

    $("#upload_photo").change(function(){
        $("#my_upload").ajaxSubmit({ 
          dataType:  'json', //数据格式为json 
          success: function(data) {
            $("#icon").val(data);
            $("#upimg").attr("src",data);
          }
        }); 
    });

    $("#edit_upload_photo").change(function(){
        $("#edit_my_upload").ajaxSubmit({ 
          dataType:  'json', //数据格式为json 
          success: function(data) {
            $("#e_icon").val(data);
            $("#edit_icon").attr("src",data);
          }
        }); 
    });





</script>

</html>