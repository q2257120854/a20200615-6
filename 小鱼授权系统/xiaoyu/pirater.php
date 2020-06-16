<?php
/**
 * 盗版站点列表
**/
$mod='blank';
$title='盗版站点列表';
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
if($udata['per_db']==0) {
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
<div class="panel-heading font-bold">盗版站点列表</div>
<div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>域名</th><th>入库时间</th><th>类型</th><th>操作</th></tr></thead>
          <tbody>
<?php
$rs=$DB->query("SELECT * FROM auth_block order by date desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
$type='<font color="orange">正常</font>';
$url=urlencode($res['url']);
echo '<tr><td><a href="/jump.php?url='.urlencode('http://'.$res['url'].'/').'" target="_blank">'.$res['url'].'</a>&nbsp;<a href="/jump.php?url='.urlencode('http://'.$res['url'].'/api.php?my=siteinfo').'" target="_blank">[*]</a></td><td>'.$res['date'].'</td><td onclick="alert(\'授权码：'.$res['authcode'].'\')">'.$type.'</td><td><a href="./getpwd.php?url='.$url.'&m=1" class="btn btn-xs btn-primary">查看信息</a> <a href="./edit.php?my=delpirate&url='.$res['url'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此条记录吗？\');">删除</a></td></tr>';
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
echo '<li><a href="pirate.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="pirate.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="pirate.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="pirate.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="pirate.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="pirate.php?page='.$last.$link.'">尾页</a></li>';
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