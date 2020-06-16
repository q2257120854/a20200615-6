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
$zcd=isset($_GET['zcd'])?$_GET['zcd']:null;
?>
<?php
if($_POST['act'] == '记录订单'){
	$orderid=$_POST['WIDout_trade_no'];
	$qq=$_POST['qq'];
	$url=$_POST['url'];
	$DB->query("INSERT INTO zcd_dd (`id`,`orderid`,`qq`,`url`,`active`) VALUES ('NULL','$orderid','$qq','$url','0')");
echo "<script>alert('订单已记录,请前往付款！');window.location.href='?zcd=fk&orderid=$orderid';</script>";	
}
//取值
$row = $DB->get_row("SELECT * FROM `auth_config` WHERE 1");
//foreach($qz as $row1){
//}
//结束
?>
<?php
if($zcd=='jl'){?>
<div class="col-sm-12 col-md-10 center-block" style="float: none;">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><b>授权配额购买-（暂时只能一个购买）</b></h3>
		</div>
		<div class="panel-body">
					<form name="fzsj" action="<?=$_SERVER['PHP_SELF']?>" method="post" target="_blank">
					<input type="hidden" name="do" value="do">
				<div class="form-group">
            	  <label >订单号</label>
				  <input type="text" class="form-control" name="WIDout_trade_no" value="<?php echo date("YmdHis").mt_rand(100,999); ?>"readonly="readonly"/><br>
            	</div>
				<div class="form-group">
            	  <label >配额价格</label>
            	  <input type="text" class="form-control" name="WIDtotal_fee" value="<?=$row['peie']?>" readonly="readonly"/><br>
            	</div>
				<label >购买QQ</label>
			    <input type="text" class="form-control" name="qq" value="<?=$udata['dlqq']?>" readonly="readonly"/><br>    
				
				<input type="text" style="display: none;" class="form-control" name="url" value="1" readonly="readonly"/>
				
				
																<input type="submit"
												
							class="btn btn-primary btn-block" name="act" value="记录订单">	
				
<?php } ?>				
<?php
if($zcd=='fk'){
$order=$_GET['orderid'];
$dd=$DB->get_row("SELECT * FROM `zcd_dd` WHERE `orderid` = '$order'");

?>
<form class="form-horizontal" method="post" action="../epayapi.php">
<label >订单号</label>
      <input type="text" name="WIDout_trade_no" class="form-control" value="<?=$dd['orderid']?>" readonly="readonly">
	  
						<label >购买QQ</label>						
						<input type="text" name='qq' class="form-control" value="<?=$dd['qq']?>" readonly="readonly"><br>
						
						<label>商品名字</label>
						<input type="text" class="form-control" name="WIDsubject" value="购买配额" readonly="readonly"/>	
						<label>数量</label>
						<input type="text" class="form-control" name="WIDsubject" value="1" readonly="readonly"/>							

						<label>需要支付</label>
            	  <input type="text" class="form-control" name="WIDtotal_fee" value="<?=$row['peie']?>" readonly="readonly"/><br>
				  
	  
					
			<button type="submit" class="btn btn-default" name="type" value="alipay">
				<img src="../assets/icon/alipay.ico"  width="16" height="16">支付宝
			</button>

			<button type="submit" class="btn btn-default" name="type" value="qqpay">
				<img src="../assets/icon/qqpay.ico"  width="16" height="16">QQ钱包
			</button>

			<button type="submit" class="btn btn-default" name="type" value="wxpay">
				<img src="../assets/icon/wechat.ico"  width="16" height="16">微信支付
			</button>	
			
			</form>
			<br>
			<a href="./admin">&gt;&gt;返回后台</a>
<?php }?>
		</div>
	</div>
</div>

<script>
var items = $("select[default]");
for (i = 0; i < items.length; i++) {
	$(items[i]).val($(items[i]).attr("default"));
}
</script>




