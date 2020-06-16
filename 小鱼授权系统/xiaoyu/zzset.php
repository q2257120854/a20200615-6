<meta charset="utf-8">
<?php
/**
 * 配置信息
 *千寻开发
**/
$mod='blank';
$title='自助购买系统配置';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
$sqjg = $_POST['sqjg'];
$zfjk = $_POST['zfjk'];
$shid = $_POST['shid'];
$shms = $_POST['shms'];	
$peie = $_POST['peie'];	
$a = $DB->query("UPDATE `auth_config` SET `sqjg` = '$sqjg';");
$b = $DB->query("UPDATE `auth_config` SET `sfjk` = '$zfjk';");
$c = $DB->query("UPDATE `auth_config` SET `shid` = '$shid';");
$d = $DB->query("UPDATE `auth_config` SET `shms` = '$shms';");
$e = $DB->query("UPDATE `auth_config` SET `peie` = '$peie';");
echo "<script>alert('数据修改完毕');window.location.href='./zzset.php';</script>";
}
//取值
$row = $DB->get_row("SELECT * FROM `auth_config` WHERE 1");
//foreach($qz as $row1){
//}
//结束
?>
<div class="col-sm-12 col-md-10 center-block" style="float: none;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><b>编辑自助购买授权数据</b></h3>
		</div>
		<div class="panel-body">
			<form action="" method="POST">
				<div class="form-group">
            	  <label >授权价格</label>
            	  <input type="text" name="sqjg" value="<?=$row['sqjg']?>" class="form-control">
            	</div>
				<div class="form-group">
            	  <label >配额价格</label>
            	  <input type="text" name="peie" value="<?=$row['peie']?>" class="form-control">
            	</div>
            	<div class="form-group">
            	  <label >支付接口接入商</label>
            	  <select class="form-control" name="zfjk" default="<?=$row['zfjk']?>"><option value="pay.blypay.cn">BL支付接口(推荐)</option><option value="pay.hackwl.cn">Hack支付接口(推荐)</option><option value="pay.52dsb.cn">52我爱云接口（推荐）</option><option value="www.9ac8.cn">超人支付接口(推荐)</option></select>
            	  
            	</div>
            	<div class="form-group">
            	  <label >商户ID</label>
            	  <input type="text" name="shid" value="<?=$row['shid']?>" class="form-control">
            	</div>
            	<div class="form-group">
            	  <label >商户密匙</label>
            	  <input type="password" name="shms" value="<?=$row['shms']?>" class="form-control">
            	</div>				
				<input type="submit" class="btn btn-primary btn-block" value="确定修改">
			</form>
			<br>
			<a href="./admin">&gt;&gt;返回后台</a>
		</div>
	</div>
</div>
<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}
</script>




