<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:78:"/www/wwwroot/2.cnhjdy.net/public/../application/comadmin/view/about/lists.html";i:1575814724;s:78:"/www/wwwroot/2.cnhjdy.net/public/../application/comadmin/view/public/head.html";i:1575814724;s:78:"/www/wwwroot/2.cnhjdy.net/public/../application/comadmin/view/public/left.html";i:1575814724;s:83:"/www/wwwroot/2.cnhjdy.net/public/../application/comadmin/view/public/foot_more.html";i:1575814724;}*/ ?>
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

<div class="page-container">
<link rel="stylesheet" href="/css/index.css">
<link rel="stylesheet" href="/css/web-icons/web-icons.css">
<style>
ul{margin:0;}
.btncolor{background: #ffffff;color:#333333;border:1px solid #e7e7e7;}
</style>
<div class="asidebox clearfix">
  <div class="aside1">
    <nav class="aside1_nav" style="padding-top: 30px">
      <ul>
        <li class="" id="navFunc">
          <a class="aside1_nav_a1" href="javascript:;">
            <i class="wb-pie-chart"></i>功能</a>
        </li>
        <li class="" id="navNews">
          <a class="aside1_nav_a1" href="javascript:;">
            <i class="wb-list"></i>动态</a>
        </li>
        <li class="" id="navCase">
          <a class="aside1_nav_a1" href="javascript:;">
            <i class="wb-order"></i>案例</a>
        </li>
        <li class="" id="navSolution">
          <a class="aside1_nav_a1" href="javascript:;">
            <i class="wb-user"></i>方案</a>
        </li>
        <li class="" id="navAbout">
          <a class="aside1_nav_a1" href="javascript:;">
            <i class="wb-map"></i>关于</a>
        </li>
        <li class="" id="navHelp">
          <a class="aside1_nav_a1" href="<?php echo Url('index/applet/index'); ?>"><i class="wb-help-circle"></i>返回</a>
        </li>
      </ul>
    </nav>
  </div>
  <div class="aside2 sidebar-2">
    <div class="aside2_title">功能列表</div>
    <nav class="aside2_nav navFunc" style="display: none">
      <ul>
        <li class="navFunc1">
          <i></i>
          <a href="<?php echo Url('Functionshow/index'); ?>">功能展示</a>
        </li>
      </ul>
    </nav>
    <nav class="aside2_nav navNews" style="display: none">
      <ul>
        <li class="navNews1">
          <i></i>
          <a href="<?php echo Url('News/index'); ?>">产品动态</a>
        </li>
        <li class="navNews2">
          <i></i>
          <a href="<?php echo Url('News/gg'); ?>">公司公告</a>
        </li>
        <li class="navNews3">
          <i></i>
          <a href="<?php echo Url('News/update'); ?>">更新日志</a>
        </li>
      </ul>
    </nav>
    <nav class="aside2_nav navCase" style="display: none">
      <ul>
        <li class="navCase1">
          <i></i>
          <a href="<?php echo Url('Cases/index'); ?>">案例</a>
        </li>
      </ul>
    </nav>
    <nav class="aside2_nav navSolution" style="display: none">
      <ul>
        <li class="navSolution1">
          <i></i>
          <a href="<?php echo Url('Solution/index'); ?>">方案</a>
        </li>
      </ul>
    </nav>
    <nav class="aside2_nav navAbout" style="display: none">
      <ul>
        <li class="navAbout3">
          <i></i>
          <a href="<?php echo Url('About/base'); ?>">基本信息</a>
        </li>
        <li class="navAbout1">
          <i></i>
          <a href="<?php echo Url('About/index'); ?>">关于我们</a>
        </li>
        <li class="navAbout2">
          <i></i>
          <a href="<?php echo Url('About/lists'); ?>">员工列表</a>
        </li>
        
      </ul>
    </nav>
  </div>
  <script>
  $('.aside1_nav li').click(function(){
    var id = $(this).attr("id");
    if(id != "navHelp"){
      $('.aside1_nav li').removeClass("active1");
      $(this).addClass("active1");
      if($('.aside2_nav.'+id+' li a').attr("href")=="javascript:;"){
        window.location.href = $('.aside2_nav.'+id+' li a').eq(1).attr("href");
      }else{
        window.location.href = $('.aside2_nav.'+id+' li a').attr("href");
      }
    }
  });



  // $('.aside1_nav li').click(function(){
  //    var id = $(this).attr("id");
  //    window.location.href = $('.aside2_nav.'+id+' li a').attr("href");
  //  });
  $(function(){
    $('.aside1_nav li').removeClass("active1");
    var nowhtml = $("#nowhtml").val();
    $("#"+nowhtml).addClass("active1");
    $('.aside2_nav').hide();
    $('.aside2_nav.'+nowhtml).show();
    $('.aside2_nav.'+nowhtml+' li').eq(0).addClass("active2");
    $('.aside2_nav.'+nowhtml+' li').removeClass("active2");
    var nowclass = $("#nowhtml").attr("class");
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


    // $(document).ready(function() {
    //   var child = parseInt("19");
    //   $(".sub-item-list").each(function() {
    //     var flag = false;
    //     if (parseInt($(this).data('id')) == child) {
    //       $(this).parents('.sidebar-content').find('.nav-item').addClass('active');
    //       $(this).addClass('active').siblings().addClass('active').find('a').removeClass('active');
    //     }
    //   });
    // });
    </script>
  <div class="aside_user">v2.29</div></div>
<div class="contentbox">
    <div class="content_head clearfix navbar" style="margin-bottom: 0">
      <div class="content_head_left"></div>
      <ul class="nav pull-right">

        <li class="dropdown user">
          <a href="/Index/Applet/index" style="display: inline-block"><返回系统</a>
          <a href="/Index/login/index" style="display: inline-block">
          <i class="icon-key"></i>退出
          </a>
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

<input type="hidden" id="nowhtml" value="navAbout" class="navAbout2">

<ul class="breadcrumb">
    <li>
        <i class="icon-home"></i>
        管理
    </li>
</ul>

<div class="row-fluid">

    <div class="span12">


        <div class="portlet box ">


            <div class="portlet-body">


                <div class="input-box" style="margin-bottom: 10px; position: relative;">

                    <div class="btn-group" style="float:right">

                        <a href="<?php echo Url('About/add'); ?>" >
                            <button id="sample_editable_1_new" class="btn green">
                                添加 <i class="icon-plus"></i>
                            </button>
                        </a>

                    </div>

                </div>

                <table class="table table-striped table-hover table-bordered" id="sample_editable_1">

                    <thead>

                    <tr>

                        <th style="width: 50px;">ID</th>
                        <th style="width: 50px;">姓名</th>
                        <th style="width: 50px;">头像</th>
                        <th style="width: 50px;">操作</th>
                    </tr>

                    </thead>
                    <tbody>
                        <?php if($list): foreach($list as $v): ?>
                            <tr>
                            <td><?php echo $v['id']; ?></td>
                            <td><?php echo $v['name']; ?></td>
                            <td><img src="<?php echo $v['pic']; ?>" alt="" style="width: 80px"></td>
                            <td>
                                <a class="btn" href="<?php echo Url('About/add'); ?>?newsid=<?php echo $v['id']; ?>">修改</a>
                                <a class="btn"  href="<?php echo Url('About/del'); ?>?newsid=<?php echo $v['id']; ?>">删除</a>
                            </td>
                            </tr>
                            <?php endforeach; endif; ?>
                    </tbody>

                   

                </table>


                <!-- 分页 -->
                <div>
                    <div class="fenye_left">
                        一共查询到<font color="red" style="padding:0 10px;"><?php echo $count; ?></font>条数据
                    </div>
                    <div class="fenye_right">
                        <?php echo $list->render(); ?>
                    </div>
                </div>


            </div>

        </div>


    </div>

</div>


<script type="text/javascript">
    function del(){
        if(confirm('该删除操作不可逆，请谨慎操作?')){
            return true;
        }else{
            return false;
        }
    }
    function pass(id,val){
        if(confirm('此操作不可恢复，确认吗？')){
            retun true;
        }else{
            return false;
        }
    }
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
			  content: ['<?php echo Url("Remote/index"); ?>?type='+type,'no'],
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