<?php
include_once "./system/api.inc.php";

$mod = $_GET['mod'];

?>
<!----->
<!DOCTYPE html>
<head>
<meta name="baidu-site-verification" content="fkDal4Y1LT" />
<meta name="baidu-site-verification" content="Y08hTzgfkG" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>
<meta name="format-detection" content="telephone=no">
<meta charset="UTF-8">  
  
<title> - </title>
   <meta name="keywords" content="PHP"/>
  <meta name="description" content=""/>
  <link rel="stylesheet" href="other/assets/layui/css/layui.css">
  <script src="other/assets/layui/layui.all.js"></script>
  <script src="https://cdn.bootcss.com/sweetalert/2.1.0/sweetalert.min.js"></script>
</head>
<style>body{background:linear-gradient(to right,#FFCCCC,#CCCCFF);font-family:"";
}
@media only screen and (min-width:700px ) {
	.content{
		left: 50%;
		margin-left: -25%;
	}
}.img{
	width: 7em;
	height: 7em;
	margin:auto;
	display: block;
	border-radius: 10em;
	box-shadow: 3px 3px 8px 1px silver;
	margin-bottom: 1em;
}
.imgbj{
	width: auto;
	height: auto;
	opacity: 0.6;
	top: 0;
	left: 0;
	z-index: -1;
	position: fixed;
}
</style>
<img class="imgbj" src="other/assets/img/rect1.png">
<body layadmin-themealias="dark-blue" style="margin-top: 1em;">	
<div class="layui-fluid">
	<div class="a layui-anim layui-anim-fadein">
    	<div class="layui-row layui-col-space15">
<div class="layui-col-sm6 content">
            <div class="layui-card">
            	<div class="layui-card-header" style="height: 3em; line-height: 3em;">
            		<h3>
            			<a href="index.php"><i class="layui-icon layui-icon-home" style="font-size: 0.9em;color: #66CC99;">  / </i></a>
            		</h3>
            	</div>
<div class="layui-card-body">
<img class="img" src="other/assets/img/logo.png">
<div class="layui-form" action="?mod=reg" method="post">
<div class="layui-form-item">
    <div class="layui-input-company">
      <b><input type="text" id="url" style="text-align: center;" name="url"  lay-verify="required" lay-verType="tips" placeholder="" class="layui-input">
    </div></b>
</div>
<div class="layui-form-item">
    <div class="layui-input-company">
      <s><button onclick="check()" class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo"></button></s>
    </div>
</div>
<center><font color=#66CC99>,</font></center>
<div style="width: 100%;margin-top: 1em;text-align: center;color: ;"><a href="#" onclick="dail()" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-home"></i></a> - <a href="#" onmouseover="km_sq()" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-home"></a> - <a href="./get/" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-home"></a> -  <a onmouseover="updatelog()" href="#" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-home">  </a> —<br><br><br>
<div class="panel-heading"style='background:linear-gradient(to right,#66FFFF,#14b7ff,#CC00FF,#FFCC33);'>
<a href="https://jq.qq.com/?_wv=1027&k=5CnLR1Q" style="font-size: 1.5em;text-align: center;"><font color='#FF0033'></font></a></div>
            	           </div>
                           </div>
			  </div>
			</div>
	<div class="layui-card" id="dowe">
		<div class="layui-card-header" style="font-size: 1.5em;text-align: center;"> </div>
			<p style="width: 100%;color: darkgray;font-size: 0.7em;text-indent: 1.6em;margin-top: 1em;">V3.0 - 201985</p>
  		<div class="layui-card-body">1.0
		
	</div>
	
		</div>
	</div>
 </div>
</div>
<script src="http://lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
<script src="other/assets/layui/layui.js"></script>
<script>
function km_sq(){
	$("#dowe").load("./show.php?act=zz_sq");
}
function updatelog(){
	$("#dowe").load("./show.php?act=gx_log");
}
function Douus(){
	$("#dowe").load("?mod=douus");
}
function anzjiaoc(){
	$("#dowe").load("?mod=anzjiaoc");
}
function check() {
	$("s").html('<button class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo"><i class="layui-icon layui-icon-loading-1 layui-icon layui-anim layui-anim-rotate layui-anim-loop"></i></button>');
	var htai = $("#url").val();
	if (htai == "") {
		swal('','!','warning');
		$("s").html('<button onclick="check()" class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo"></button>');
		layer.close(index);
	} else {
		 $.post("./ajax.php?act=check_url",
    {
        url:htai
    },
        function(tis){
			if (tis.code == "0") {
				swal('',tis.msg,'success');
			} else {
				swal('','','error');
				$("s").html('<button onclick="check()" class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo"></button>');
			}
			$("s").html('<button onclick="check()" class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo"></button>');
		})
	}
}
function zzsq() {
	$("z").html('<button class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo"><i class="layui-icon layui-icon-loading-1 layui-icon layui-anim layui-anim-rotate layui-anim-loop"></i></button>');
	var url = $("#zz_url").val();
	var qq = $("#zz_qq").val();
	var km = $("#zz_km").val();	
	if (url == "" || qq == "" || km == "") {
		swal('','!','warning');
		$("z").html('<button onclick="zzsq()" class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo"></button>');
		layer.close(index);
	} else {
		 $.post("./ajax.php?act=zz_sq",
    {
        url:url,qq:qq,km:km
    },
        function(tis){
			if (tis.code == "0") {
				swal('',tis.msg,'success');
			} else {
				swal('',tis.msg,'error');
				$("z").html('<button onclick="zzsq()" class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo"></button>');
			}
			$("z").html('<button onclick="zzsq()" class="layui-btn layui-btn layui-btn-lg layui-btn-normal layui-btn-fluid" type="submit"  lay-filter="formDemo"></button>');
		})
	}
}
function dail(){
layer.prompt({
  formType: 3,
  value: '',
  title: '<font color=#5FB878>QQ</font>'
}, function(value, index, elem){
  $.post("./ajax.php?act=check_dl",{qq:value},function(data){
  	if(data.code == "1"){
  		swal('',data.msg,'error');
  	}else{
  		swal('',data.msg,'success');
  	}
  });
  layer.close(index);
});
}
$(document).keyup(function(event){
  if(event.keyCode ==13){
   anz();
  }
});	
layui.use('element', function(){
  var element = layui.element;
});
  layui.config({
    base: 'assets/layui/admin/pro/dist/layuiadmin/' //
  }).extend({
    index: 'lib/index' //
  }).use('index'); 
swal('','10~ ','success');
</script>