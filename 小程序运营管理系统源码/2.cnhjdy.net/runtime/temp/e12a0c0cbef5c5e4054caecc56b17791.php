<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:79:"/www/wwwroot/2.cnhjdy.net/public/../application/comadmin/view/remote/index.html";i:1575814724;}*/ ?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8" />
		<link rel="stylesheet" type="text/css" href="/css/uploadimg.css"/>
		<script src="/js/jquery.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="/js/jquery.form.js"></script>
		<script src="/js/uploadimg.js" type="text/javascript" charset="utf-8"></script>
		<title></title>
	</head>
	<body>
	<form id='myupload' action="<?php echo Url('Remote/imgupload'); ?>" method='post' enctype='multipart/form-data'>
        <input type="file" id="uploadphoto" name="uploadfile" value="请点击上传图片" accept="image/png,image/jpeg,image/gif"  style="display: none"  />
    </form>
		<div class="alertbox">
			<div class="alert">
				<div class="cjxcalertbox">
					<div class="cjxcalert">
						<div class="cjxcalert_head hbj">
							<div class="cjxcalert_head_left">相册创建</div>
							<div class="cjxcalert_head_right">X</div>
						</div>
						<div class="cjxcalert_content">
							<div class="cjxcalert_content_div"><span>相册名称</span><input class="cjxcalert_input" type="text" value="" placeholder="请输入相册名称" /></div>
						</div>
						<div class="cjxc_btn clearfix">
							<div class="cjxc_btn_close">关闭</div>
							<div class="cjxc_btn_creat" onclick="makegroup()">创建</div>
						</div>
					</div>
				</div>
				<div class="alert_head1 clearfix">
					<div class="alert_head1_left">我的图片</div>
				</div>
				<div class="alert_head2 clearfix">

					<div class="uploadimg" onclick='uploadphoto.click();'>上传图片
					</div>
				</div>
				<div class="content clearfix">
					<div class="content_left">
						<div class="content_left_single content_left_single_on hbj">
							<div class="content_left_single_div1">全部</div>
							<div style="flex: 1;"></div>
							<div class="content_left_single_div2"><?php echo $count; ?></div>
						</div>
					</div>
					<div class="content_right">
						<div class="clearfix" id="allpic">
							<?php if($list): foreach($list as $v): ?>
							<div class="content_right_single" onclick="imgurls('<?php echo $v['imgurl']; ?>',this)">
								<img class="content_right_single_img" src="<?php echo $v['imgurl']; ?>" data-id="<?php echo $v['id']; ?>"/>
								<img class="content_right_single_select" src="/image/select.png"/>
							</div>
							<?php endforeach; endif; ?>
						</div>
						<div class="uploadpage">
							<?php echo $all->render(); ?>
						</div>
					</div>
				</div>
				<div class="sure" onclick="getres()">确认</div>
			</div>
		</div>
	</body>
	<script type="text/javascript">
	var imgsrc = "";
	var type = <?php echo $type; ?>;
	var imgsrcs = new Array();
	$('.content_left_single').click(function(){
		$('.content_left_single').removeClass('content_left_single_on');
		$(this).addClass('content_left_single_on')
	})
	$('.content_left_single').click(function(){
			$('.content_left_single').removeClass('content_left_single_on');
			$(this).addClass('content_left_single_on')
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
	$(function(){
	    $("#uploadphoto").change(function(){
	        $("#myupload").ajaxSubmit({ 
	          dataType:  'json', //数据格式为json 
	          data:{
	          	type:4
	          },
	          success: function(data) {
	            var url = $.parseJSON(data)['url'];
	            var pid = $.parseJSON(data)['pid'];
	      
	            var count = $(".group0").data("count")+1;
	            $(".group0 .content_left_single_div2").html(count);
	            var html = '<div class="content_right_single" onclick="imgurls(\''+url+'\',this)"><img class="content_right_single_img" src="'+url+'" data-id="'+pid+'"/><img class="content_right_single_select" src="/image/select.png"/></div>'+ $("#allpic").html();
	            $("#allpic").html(html);
	          }
	        }); 
	    });
	});
	function imgurls(src,e){
		if(src){
			if($.inArray(src,imgsrcs)>=0){
				imgsrcs.splice(imgsrcs.indexOf(src),1)
			}else{
				imgsrcs.push(src)
			}
		}
		if(type==1){
			$('.content_right_single').removeClass('content_right_single_on');
			$(e).addClass('content_right_single_on')
			imgsrc = $(e).find(".content_right_single_img").attr("src");
		}else{
			if($(e).hasClass('content_right_single_on')){
				$(e).removeClass('content_right_single_on')
				console.log(6)
			}else{
				$(e).addClass('content_right_single_on')
				console.log(5)
			}
		}
	}
	function getres(){
		if(type==2){
			var index=parent.layer.getFrameIndex(window.name);
			parent.$("#handle_status").val(imgsrcs);
		}
		if(type==1){
			var index=parent.layer.getFrameIndex(window.name);
			parent.$("#handle_status").val(imgsrc);
		}
		parent.layer.close(index);
	}
</script>

</html>
