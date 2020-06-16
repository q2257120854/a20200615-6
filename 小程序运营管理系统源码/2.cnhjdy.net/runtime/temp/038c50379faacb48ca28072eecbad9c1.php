<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"/www/wwwroot/2.cnhjdy.net/public/../application/comadmin/view/about/add.html";i:1575814724;s:78:"/www/wwwroot/2.cnhjdy.net/public/../application/comadmin/view/public/head.html";i:1575814724;s:78:"/www/wwwroot/2.cnhjdy.net/public/../application/comadmin/view/public/left.html";i:1575814724;s:83:"/www/wwwroot/2.cnhjdy.net/public/../application/comadmin/view/public/foot_more.html";i:1575814724;}*/ ?>
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

	.editors{

		max-width: 770px;

		min-height: 600px;

	}

	.w-e-text-container{

		min-height: 600px !important;

	}
	.weiz{

		margin-left:20px;

		margin-top: 40px;

		margin-bottom: 20px;

	}

</style>



<input type="hidden" id="nowhtml" value="navAbout" class="navAbout2">



	<ul class="breadcrumb">

		<li>

			<i class="icon-home"></i>

			内容管理

		</li>

	</ul>



<style>
	.chongdingy{

		background-color:#f5f5f5; 

		padding:10px 0;

	}

	.chongdingywz{

		text-align: left !important;

		font-size: 16px;

		padding-left: 20px;

	}

</style>



	<div class="row-fluid">



		<div class="portlet box">



			

			<div class="portlet-body form">

				<form action="<?php echo Url('About/addsave'); ?>?newsid=<?php echo $newsid; ?>" id="form_sample_2" class="form-horizontal" method="post" enctype="multipart/form-data" onsubmit = "return checkinfo();">


					<div class="control-group chongdingy">



						<label class="control-label chongdingywz">员工信息管理</label>



					</div>
				

					<div class="control-group">



						<label class="control-label">序号</label>



						<div class="controls">



							<input name="num" type="text" class="span1 m-wrap" value="<?php if($newsinfo): ?><?php echo $newsinfo['num']; endif; ?>"  style="height: 35px !important;" />

							<span style="color:#999999; line-height:40px; margin-left:20px;">序号越大越靠前</span>

						</div>



					</div>
					<div class="control-group">



						<label class="control-label">是否上线</label>



						<div class="controls">



							<label class="radio">



							<input type="radio" name="flag" value="1" <?php if($newsinfo): if($newsinfo['flag']==1): ?>checked=checked<?php endif; endif; ?>/>



							上线



							</label>



							<label class="radio">



							<input type="radio" name="flag" value="2" <?php if($newsinfo): if($newsinfo['flag']==2): ?>checked=checked<?php endif; endif; ?>/>



							下线



							</label> 



							<span style="color:#999999; line-height:40px; margin-left:20px;"></span>

						</div>



					</div>


					<div class="control-group">
						<label class="control-label">姓名</label>
						<div class="controls">
							<input name="name" type="text" class="span5 m-wrap" value="<?php if($newsinfo): ?><?php echo $newsinfo['name']; endif; ?>"  style="height: 35px !important;" />
							<span style="color:#999999; line-height:40px; margin-left:20px;">请填写标题</span>
						</div>
					</div>
					
					
					<div class="control-group">
						<label class="control-label">头像</label>
						<div class="controls">
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="fileupload-new thumbnail commonuploadpic1" style="width: 140px; height:90px;">

									<?php if($newsinfo && $newsinfo['pic']): ?>

									<img src="<?php echo $newsinfo['pic']; ?>"/>

									<?php else: ?>

									<img src="/image/noimage.jpg" alt="" />

									<?php endif; ?>

								</div>
								<div>
									<span class="btn btn-file"><span class="fileupload-new commonchangepic" data-type="1">选择图片<input type="hidden" name="commonuploadpic1"></span></span>
								</div>
								<font color="#999999">图片大小为194*172</font>
							</div>

						</div>

					</div>
					<div class="control-group">
						<label class="control-label">职位</label>
						<div class="controls">
							<input name="position" type="text" class="span5 m-wrap" value="<?php if($newsinfo): ?><?php echo $newsinfo['position']; endif; ?>"  style="height: 35px !important;" />
							<span style="color:#999999; line-height:40px; margin-left:20px;"></span>
						</div>
					</div>
				

					
					<div class="form-actions">



						<button type="submit" class="btn green">确定</button>



					</div>
					




				</form>



			</div>



		</div>



	</div>





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