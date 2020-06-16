<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
         <link href="/Public/admin/assets/css/bootstrap.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="/Public/admin/css/style.css"/>       
        <link href="/Public/admin/assets/css/codemirror.css" rel="stylesheet">
        <link rel="stylesheet" href="/Public/admin/assets/css/ace.min.css" />
        <link rel="stylesheet" href="/Public/admin/font/css/font-awesome.min.css" />
        <!--[if lte IE 8]>
		  <link rel="stylesheet" href="/Public/admin/assets/css/ace-ie.min.css" />
		<![endif]-->
		<script src="/Public/admin/js/jquery-1.9.1.min.js"></script>
		<script src="/Public/admin/assets/js/typeahead-bs2.min.js"></script>   
        <script src="/Public/admin/js/lrtk.js" type="text/javascript" ></script>		
		<script src="/Public/admin/assets/js/jquery.dataTables.min.js"></script>
		<script src="/Public/admin/assets/js/jquery.dataTables.bootstrap.js"></script>
        <script src="/Public/admin/assets/layer/layer.js" type="text/javascript" ></script>    
				
<title>分类管理</title>
</head>
<style>
/*css manu style pagination*/
.manu{padding:3px;margin:3px;text-align:center;}
.manu a{border:#eee 1px solid;padding:2px 5px;margin:2px;color:#036cb4;text-decoration:none;}
.manu a:hover{border:#999 1px solid;color:#666;}
.manu a:active{border:#999 1px solid;color:#666;}
.manu .current{border:#036cb4 1px solid;padding:2px 5px;font-weight:bold;margin:2px;color:#fff;background-color:#036cb4;}
.manu .disabled{border:#eee 1px solid;padding:2px 5px;margin:2px;color:#ddd;}

</style>
<body>
<div class="page-content clearfix">
 <div class="search_style">
     <form action="/App/Login/daotxt" method="POST">
      <ul class="search_content clearfix">
	<li><label class="l_f">按类型导出</label>
	
	<select name="type" style=" width:150px">
	
	<option value="七天">七天</option>
	  <option value="一个月">一个月</option>
	  <option value="三个月">三个月</option>
	  <option value="六个月">六个月</option>
	  <option value="一年">一年</option>
	
	
	</select>
	
	</li>
       
	   
	   
       <li style="width:90px;"><button type="button" class="btn_search"><i class="fa fa-search"></i>导出</button></li>
      </ul>
    </div>
	</form>
	
 <div class="sort_style">
     <div class="border clearfix">
       <span class="l_f">
        <a href="/App/Login/add" id="sort_add" class="btn btn-warning"><i class="fa fa-plus"></i> 添加卡密</a>
		
		<a href="/App/Login/txt" id="sort_add" class="btn btn-warning" style="background-color:#7EC0EE!important;border-color: #7EC0EE;"><i class="fa fa-plus"></i>导出全部到TXT</a>
        <a href="javascript:ovid()" onclick="del()" class="btn btn-danger"><i class="fa fa-trash"></i> 批量删除</a>
       </span>
       <!-- <span class="r_f">共：<b>5</b>类</span> -->
     </div>
  <div class="sort_list">
    <table class="table table-striped table-bordered table-hover" id="sample-table">
		<thead>
		 <tr>
				<th width="25px"><label><input id="checkall" name="checkall" value="全选" type="checkbox" class="ace"><span class="lbl"></span></label></th>
				<th width="50px">ID</th>
				<th width="100px">卡号</th>
				<th width="50px">生成人</th>
				<th width="50px">充值时间</th>
				<th width="100px">生成时间</th>
				<th width="70px">状态</th>                
				<th width="50px">操作</th>
			</tr>
		</thead>
	<tbody>
		 <?php if(is_array($kami)): $i = 0; $__LIST__ = $kami;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
       <td><label><input type="checkbox" class="ace" name="id[]" value="<?php echo ($vo["id"]); ?>"><span class="lbl"></span></label></td>
       <td><?php echo ($vo["id"]); ?></td>
       <td><?php echo ($vo["dianka"]); ?></td>
       <td>管理员</td>
       <td><?php echo ($vo["name"]); ?></td>
       <td><?php echo (date("Y-m-d H:i:s",$vo["ctime"])); ?></td>
       <td class="td-status">
	   
	    <?php if($vo["y"] == '1' ): ?><span class="label label-success radius">已经使用</span>
	   
	   <?php else: ?>
	   <span class="label label-success radius">未使用</span><?php endif; ?>
	   </td>
      <td class="td-manage">
        
           
        <a title="删除" href="javascript:;"  onclick="member_del(this,<?php echo ($vo["id"]); ?>)"  class="btn btn-xs btn-warning" ><i class="fa fa-trash  bigger-120"></i></a>
      
       </td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </tbody>
    </table>
	
	

	<div class="manu">
	<?php echo ($pageinfo); ?>
	</div>
	
	
	
  </div>
 </div>
</div>

</body>
</html>
<script src="/Public/js/jquery-1.9.1.min.js"></script>
<script type="text/javascript">

$("#checkall").click(function(){ 
		  $("input[name='id[]']").each(function(){
			  if (this.checked) {
				  this.checked = false;
			  }
			  else {
				  this.checked = true;
			  }
		  });
		})

/*广告图片-删除*/
function member_del(obj,id){
	layer.confirm('确认要删除吗？',{icon:0,},function(index){
		$(obj).parents("tr").remove();
		$.ajax({
						url:"/App/Login/del",	//请求地址
						type:"get",		//请求方式
						data:{id:id},//发送数据
						async:true,			//异步情趣
						dataType:"text",	//响应数据格式
						 success:function(res){
						 
						 if(res=="y"){
							alert('删除成功');location="./index";	
							}else{
							$("#code").html("");	
							}
						},
					});
		layer.msg('已删除!',{icon:1,time:1000});
	});
}


function del(){

        var Checkbox=false;
		var ids = '';
			 $("input[name='id[]']").each(function(){
			  if (this.checked==true) {		
				Checkbox=true;	
				ids += ',' + $(this).val(); //逐个获取id
			  }
			});

			  ids = ids.substring(1); // 对id进行处理，去除第一个逗号
			
			
			if (Checkbox){
			
				var t=confirm("您确认要删除选中的内容吗？");
				if (t==false) return false;		
				$("#listform").submit();
					$.ajax({
						url:"/App/Login/del",	//请求地址
						type:"get",		//请求方式
						data:{id:ids},//发送数据
						async:true,			//异步情趣
						dataType:"text",	//响应数据格式
						 success:function(res){
						 
						 if(res=="y"){
							alert('删除成功');location="./index";	
							}else{
							$("#code").html("");	
							}
						},
					});				
			}
			else{
				alert("请选择您要删除的内容!");
				return false;
			}

    }



//面包屑返回值
var index = parent.layer.getFrameIndex(window.name);
parent.layer.iframeAuto(index);
$('.Order_form ,.ads_link').on('click', function(){
	var cname = $(this).attr("title");
	var cnames = parent.$('.Current_page').html();
	var herf = parent.$("#iframe").attr("src");
    parent.$('#parentIframe span').html(cname);
	parent.$('#parentIframe').css("display","inline-block");
    parent.$('.Current_page').attr("name",herf).css({"color":"#4c8fbd","cursor":"pointer"});
	//parent.$('.Current_page').html("<a href='javascript:void(0)' name="+herf+">" + cnames + "</a>");
    parent.layer.close(index);
	
});
function AdlistOrders(id){
	window.location.href = "Ads_list.html?="+id;
};
</script>