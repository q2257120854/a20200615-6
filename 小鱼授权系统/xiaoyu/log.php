<?php
/**
 * 操作记录
**/
$mod='blank';
$title='操作记录';
include './head.php';
if($udata['per_db']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" draggable="true">
<?php
$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$udata['user']."','查看日志','".$date."','".$city."','无')");


if(isset($_GET['cz'])) {
	$sql=" `type`='{$_GET['cz']}'";
	$gls=$DB->count("SELECT count(*) from auth_log WHERE{$sql}");
	$con='操作类型 '.$_GET['cz'].' 共有 <b>'.$gls.'</b> 个操作记录';
}elseif(isset($_GET['uid'])) {
	$sql=" `uid`='{$_GET['uid']}'";
	$gls=$DB->count("SELECT count(*) from auth_log WHERE{$sql}");
	$con='UID '.$_GET['uid'].' 共有 <b>'.$gls.'</b> 个操作记录';
}else{
	$gls=$DB->count("SELECT count(*) from auth_log WHERE 1");
	$sql=" 1";
	$con='授权平台共有 <b>'.$gls.'</b> 个操作记录';
}

$pagesize=30;
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}

echo $con;
?>
<div class="panel-heading font-bold">操作记录</div>
<div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>用户名</th><th>操作类型</th><th>操作时间</th><th>操作地点</th><th>操作详情</th></tr></thead>
          <tbody>
<?php
$rs=$DB->query("SELECT * FROM auth_log WHERE{$sql} order by id desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<tr><td>'.$res['id'].'</td><td><a href="log.php?uid='.$res['uid'].'">'.$res['uid'].'</a></td><td><a href="log.php?cz='.$res['type'].'">'.$res['type'].'</a></td><td>'.$res['date'].'</td><td>'.$res['city'].'</td><td>'.$res['data'].'</td></tr>';

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
echo '<li><a href="log.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="log.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="log.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="log.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="log.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="log.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
    </div>
  </div>
<?php include './foot.php';?>