<?php
$mod='blank';
$title='卡密生成';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$num = $_POST['num'];
function getkmkey($len = 16)
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $strlen = strlen($str);
    $randstr = '';
    for ($i = 0; $i < $len; $i++) {
        $randstr .= $str[mt_rand(0, $strlen - 1)];
    }
    return $randstr;
}
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" draggable="true">
<div class="panel-heading font-bold">卡密生成</div>
<div class="panel-body">
<form method="post" action="" >
<input type="hidden" name="do" value="do">
<div class="input-group">
              <span class="input-group-addon">卡密个数</span>
              <input type="text" name="num"  class="form-control" placeholder="输入需要生成的个数">
            </div><br/>
<div class="col-sm-12"><input type="submit" value="确认生成" class="btn btn-primary form-control"/></div>
</form>
</div>
  <div class="panel-footer text-center">请填写生成卡密数量</div>
	</div>
		</div>
		<div class="col-sm-2"></div>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
	  <div class="panel panel-primary">
	  <div class="panel-heading">生成结果</div>
  	<div class="panel-body">
      <?php
	  $uid=$udata['uid'];
if ($_POST['do'] == 'do') {
	
$rowu=$DB->get_row("SELECT * FROM auth_user WHERE user='{$user}' limit 1");


if($rowu['peie']==0){
   showmsg('你的配额不足,无法正常生成卡密<br/>请联系站长购买！'.$DB->error(),4,$_POST['url']);
   exit(0);
}elseif($num > $rowu['peie']){
   showmsg('你的配额不足,无法正常生成卡密<br/>请联系站长购买！'.$DB->error(),4,$_POST['url']);
   exit(0);
}elseif($num > 3){
   showmsg('为防止恶意,一次只给生成三张！！'.$DB->error(),4,$_POST['url']);
   exit(0);
}
	if ($num != '') {
		for ($i=1;$i<=$num;$i++) {
			$key = getkmkey();
			$DB->query("INSERT INTO `auth_kms` (`km`, `zt`, `addid`) VALUES ('$key', '1','$uid')");
			$DB->query("UPDATE `auth_user` SET `peie` = `peie`-'1' WHERE `auth_user`.`user` = '".$user."'");
			
			$city=get_ip_city($clientip);
		    $DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$udata['user']."','生成卡密','".$date."','".$city."','卡密".$key."|数量".$num."')");

			}
				}else{
		exit("<script language='javascript'>alert('数量不能为空！');history.go(-1);</script>");
	}}
			?>
			<div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>卡密</th><th>状态</th></tr></thead>
          <tbody>
<?php
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}
$pagesize=30;
$rs=$DB->query("SELECT * FROM auth_kms WHERE addid = ".$udata['uid']." order by id desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
if($res['zt']==1){
	$zt='<span class="btn btn-xs btn-info">未使用</span>';
}else{
	$zt='<span class="btn btn-xs btn-danger">已使用</span>';
}
echo '<tr><td>'.$res['id'].'</td><td>'.$res['km'].'</td><td>'.$zt.'</td></tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php
echo'<ul class="pagination">';
$s = ceil($gls / $pagesize);
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$s;
if ($page>1)
{
echo '<li><a href="km.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="km.php?page='.$prev.$link.'">«</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>«</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="km.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="km.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="km.php?page='.$next.$link.'">»</a></li>';
echo '<li><a href="km.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>»</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
    </div>
  </div>
<?php include './foot.php';?>