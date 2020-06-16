<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:76:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\applet\billing.html";i:1575814731;s:77:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\new_left.html";i:1575814741;s:77:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\public\new_head.html";i:1575814741;}*/ ?>
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

<script src="/laydate/laydate.js" type="text/javascript" charset="utf-8"></script>

<input type="hidden" id="choose" value="applet">

<div class="content">

    <div class="content_title">小程序开通</div>

    <form class="open_form" action="<?php echo Url('Applet/save_billing'); ?>" method="post" enctype="multipart/form-data" onsubmit = "return checkinfo();">

        <?php if($usergroup == 3): ?>

        <div class="clearfix mb-30">

            <div class="open_form_title fl">开通时长<span>*</span></div>

            <div class="open_form_right fl">

                <select class="open_form_select1" name="pay_time" id="pay_time" onchange="freetime(this)">

                    <option value="-1">--请选择套餐时长--</option>

                    <?php if(is_array($time_combo) || $time_combo instanceof \think\Collection || $time_combo instanceof \think\Paginator): $i = 0; $__LIST__ = $time_combo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

                    <option value="<?php echo $vo['id']; ?>" ><?php echo $vo['name']; ?></option>

                    <?php endforeach; endif; else: echo "" ;endif; ?>

                </select>

            </div>

        </div>

        <div class="clearfix mb-30">

            <div class="open_form_title fl">赠送时长<span>*</span></div>

            <div class="open_form_right fl">

                <select class="open_form_select1" name="free_time" id="free_time">

                    <option value="-1">--请选择赠送时长--</option>

                </select>

            </div>

        </div>

        <?php endif; if($usergroup == 2): ?>

        <div class="clearfix mb-30">

            <div class="open_form_title fl">时间选择<span>*</span></div>

            <div class="open_form_right fl" style="position: relative;">

                <input class="open_form_text" style="font-family: arial;" id="date1" type="text" name="endtime"  value="" readonly />

                <img class="date_img" src="/image/date.png"/>

            </div>

        </div>

        <?php endif; ?>

        <div class="clearfix mb-30">

            <div class="open_form_title fl" style="margin-top: 0;">平台选择</div>

            <div class="open_form_right fl">

                <?php if($usergroup == 3): if(in_array(0, $type)): ?>

                <label class="ptxz hbj">

                    <input class="ptxz_checkbox" type="checkbox" name="type[]"  value="0" <?php if(in_array(0, $applet['type'])): ?>checked <?php endif; ?>disabled="true"/>

                    <img src="/image/wx.png"/>

                    <span class="ptxz_span1">微信小程序</span>

                    <span class="ptxz_span2"><?php echo $combo['wx_price']; ?>/年</span>

                </label>

                <?php endif; ?>

               <!--  <?php if(in_array(2, $type)): ?>

                <label class="ptxz hbj">

                    <input class="ptxz_checkbox" type="checkbox" name="type[]"  value="2" <?php if(in_array(2, $applet['type'])): ?>checked <?php endif; ?>disabled="true" />

                    <img src="/image/zfb.png"/>

                    <span class="ptxz_span1">支付宝小程序</span>

                    <span class="ptxz_span2"><?php echo $combo['ali_price']; ?>/年</span>

                </label>

                <?php endif; ?> -->

                <!-- <?php if(in_array(1, $type)): ?>

                <label class="ptxz hbj">

                    <input class="ptxz_checkbox" type="checkbox" name="type[]"  value="1"  <?php if(in_array(1, $applet['type'])): ?>checked <?php endif; ?>disabled="true"/>

                    <img src="/image/bd.png" style="margin:0 1.5px;"/>

                    <span class="ptxz_span1">百度小程序</span>

                    <span class="ptxz_span2"><?php echo $combo['baidu_price']; ?>/年</span>

                </label>

                <?php endif; ?> -->

                <?php elseif($usergroup == 2): ?>

                <label class="ptxz hbj">

                    <input class="ptxz_checkbox" type="checkbox" name="type[]"  value="0"  <?php if(in_array(0, $applet['type'])): ?>checked <?php endif; ?>disabled="true" />

                    <img src="/image/wx.png"/>

                    <span class="ptxz_span1">微信小程序</span>

                    <span class="ptxz_span2"><?php echo $combo['wx_price']; ?>/年</span>

                </label>

               <!--  <label class="ptxz hbj">

                    <input class="ptxz_checkbox" type="checkbox" name="type[]"  value="2" <?php if(in_array(2, $applet['type'])): ?>checked <?php endif; ?>disabled="true" />

                    <img src="/image/zfb.png"/>

                    <span class="ptxz_span1">支付宝小程序</span>

                    <span class="ptxz_span2"><?php echo $combo['ali_price']; ?>/年</span>

                </label>

                <label class="ptxz hbj">

                    <input class="ptxz_checkbox" type="checkbox" name="type[]"  value="1"  <?php if(in_array(1, $applet['type'])): ?>checked <?php endif; ?>disabled="true"/>

                    <img src="/image/bd.png" style="margin:0 1.5px;"/>

                    <span class="ptxz_span1">百度小程序</span>

                    <span class="ptxz_span2"><?php echo $combo['baidu_price']; ?>/年</span>

                </label> -->

                <?php endif; if($usergroup == 3): ?>

                <div class="clearfix">

                    <input type="hidden" name="price" id="price" value="">

                    <div class="all_money fl" >合计：<span name="price" id="show_price">0</span>元</div>

                    <div class="balance_money fr">您的余额：<?php echo round($jxs['balance'], 2); ?>元</div>

                </div>

                <?php endif; ?>

            </div>

        </div>

        <div class="clearfix mb-30">

            <div class="open_form_title fl">小程序名称<span>*</span></div>

            <div class="open_form_right fl">

                <input class="open_form_text" type="text" name="name" id="name" value="<?php echo $applet['name']; ?>" readonly />

            </div>

        </div>

        <div class="clearfix mb-30">

            <div class="open_form_title fl">小程序Logo<span>*</span></div>

            <div class="open_form_right hbj fl">

                <?php if($applet['thumb']): ?>

                    <img class="upimg" src="<?php echo $applet['thumb']; ?>"}/>

                <?php else: ?>

                    <img class="upimg" src="/image/upimg.png"/>

                <?php endif; ?>



            </div>

        </div>

        <div class="clearfix mb-30">

            <div class="open_form_title fl">小程序描述<span>*</span></div>

            <div class="open_form_right fl">

                <textarea class="open_form_textarea" name="comment" rows="" cols=""><?php echo $applet['comment']; ?></textarea>

            </div>

        </div>

        <div class="clearfix mb-30">

            <div class="open_form_title fl"></div>

            <div class="open_form_right fl">

                <input type="hidden" name="applet_id" value="<?php echo $applet['id']; ?>" />

                <input class="open_form_submit" type="submit" name=""  value="开通" />

            </div>

        </div>

    </form>

</div>

</body>

<script type="text/javascript">

   laydate.render({

        elem: '#date1',

            });



       //提交检验

       function checkinfo(){

           var usergroup = '<?php echo $usergroup; ?>';

           var pay_time = $("#pay_time").val();

           var free_time = $("#free_time").val();

           var name = $("#name").val();

           var endtime = $("#date1").val();



           if(usergroup == 2){

               if(!endtime){

                   alert("请选择小程序到期时间");

                   return false;

               }

           }else if(usergroup == 3){

               if(pay_time == -1){

                   alert("请选择套餐时长");

                   return false;

               }

               if(free_time == -1){

                   alert("请选择赠送时长");

                   return false;

               }



           }else{

               return true;

           }



           if(!name){

               alert("请输入小程序名称");

               return false;

           }

       }



       //根据选择的时长套餐改变赠送时长

       function freetime(a){

           var id = a.value;

           if(id < 0){

               var html = "<option value='0'>--无赠送时间--</option>"

               $('#free_time').html(html);

           }else{

               $.ajax({

                   url: 'getfree_time',

                   type: 'post',

                   dataType: 'json',

                   data:{

                       id: id

                   },

                   success :function (res) {

                       var free = "<option value='0'>--无赠送时间--</option>";

                       for(var i=1; i<= res; i++){

                           free += "<option value='"+i+"'>"+i+"个月</option>"

                       }

                       $('#free_time').html(free);

                   }

               })

           }



           //计算总价

           getprice();

       }



       function getprice(){

      var month = 0;
        var usergroup = '<?php echo $usergroup; ?>';

        var combo_id = '<?php echo $combo["id"]; ?>'; //套餐

        var pay_time = $("#pay_time").val(); //时长

        var type = [];

        $('input[name="type[]"]:checked').each(function(){

            type.push($(this).val());//向数组中添加元素

        });
        

        var price = 0;

        if(pay_time < 0 ){

            $("#price").val(price);

            $("#show_price").html(price);

        }else{

            //根据套餐获取价格  总管理员不需要计算价格
            if(usergroup != 2){

                //根据套餐ID查找套餐的月份
                $.post("<?php echo Url('Applet/get_pay_time'); ?>",{"id":pay_time},function(data){
                    month = data;
                      if(combo_id != 0){

                      $.ajax({

                          url: 'combo_price',

                          type: 'post',

                          dataType: 'json',

                          data: {

                              combo_id : combo_id

                          },

                          success: function (res) {

                              res = JSON.parse(res);

                              var wx_price = res['wx_price']/12;

                              var baidu_price = res['baidu_price']/12;

                              var ali_price = res['ali_price']/12;



                              for(var i=0; i<type.length; i++){

                                  if(type[i] == 0){

                                      price += wx_price * month;

                                  }else if(type[i] == 1){

                                      price += baidu_price * month;

                                  }else{

                                      price += ali_price * month;

                                  }

                              }

                              $("#price").val(price.toFixed(2));

                              $("#show_price").html(price.toFixed(2));

                          }

                      });

                  }else {

                      $("#price").val(0);

                      $("#show_price").html(0);

                  }
                });


                

            }

        }

    }


       $(":checkbox").on("change",function(){

           getprice();

       });



</script>

</html>

