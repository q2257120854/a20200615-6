<?php
/**
 * 网站设置
**/
$mod='blank';
$title='网站设置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" draggable="true">
<?php
if($udata['per_sq']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
$gls=$DB->count("SELECT count(*) from auth_tongji WHERE 1");
$pagesize=30;
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}

if(isset($_POST['qq']) && isset($_POST['url'])){

} ?>
<?php
  $log_file='../log.txt';
  $uplog=file_get_contents($log_file);
  
$mod=isset($_GET['mod'])?$_GET['mod']:null;
if($mod=='set'){
	$con=$_POST['content'];
	$log=$_POST['uplog'];
	$ad=file_put_contents('../log.txt',$log);
	if($ad){showmsg('修改成功！',1);
            
	}else showmsg('修改失败！<br/>',4);
}elseif($mod==''){
?>
<div class="panel-heading font-bold">网站返回信息设置</div>
<div class="panel-body">
  <form action="./set.php?mod=set" method="post" class="form-horizontal" role="form">
	<div class="form-group">
		<label class="col-lg-3 control-label">违规站点返回信息</label>
		<div class="col-lg-8">
			<textarea name="content" class="form-control" style="height:200px;"><?php echo $confs['content']?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-lg-3 control-label">版本更新信息</label>
		<div class="col-lg-8">
			<textarea name="uplog" class="form-control" style="height:200px;"><?php echo $uplog?></textarea>
		</div>
	</div>
	<div class="form-group">
	  <div class="col-sm-offset-3 col-sm-8"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
	 </div>
	 </div>
	</div>
  </form>
</div>
</div>
    </div>
    <?php }?>
  </div>
  </div>
<?php include './foot.php';?>