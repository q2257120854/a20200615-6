<?php
/**
 * 用户列表
**/
$mod='blank';
$title='用户列表';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" draggable="true">
      <div class="panel-heading font-bold">用户列表</div>
        <div class="panel-body">
<?php
if($udata['per_db']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
if($udata['per_sq']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
	$gls=$DB->count("SELECT count(*) from auth_user WHERE 1");
	$sql=" 1";
	$con='平台共有 <b>'.$gls.'</b> 个用户';


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
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>UID</th><th>用户名</th><th>配额</th><th>权限</th><th>操作</th></tr></thead>
          <tbody>
          <?php
$rs=$DB->query("SELECT * FROM auth_user WHERE{$sql} order by uid asc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
if($res['active']==0){$q="该账号已封禁";}
elseif($res['per_sq']==1&&$res['per_db']==1&&$res['active']==1){$q="全部操作权限";}

elseif($res['per_sq']==1&&$res['per_db']==0&&$res['active']==1){$q="授权操作权限";}

elseif($res['per_sq']==0&&$res['per_db']==0&&$res['active']==1){$q="获取操作权限";}
echo '<tr><td>'.$res['uid'].'</td><td>'.$res['user'].'</td><td>'.$res['peie'].'</td><td>'.$q.'</td><td><a href="./useredit.php?my=edit&uid='.$res['uid'].'" class="btn btn-xs btn-info">编辑</a> <a href="./useredit.php?my=del&uid='.$res['uid'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此用户吗？\');">删除</a></td></tr>';
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
echo '<li><a href="userlist.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="userlist.php?page='.$prev.$link.'">«</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>«</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="userlist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="userlist.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="userlist.php?page='.$next.$link.'">»</a></li>';
echo '<li><a href="userlist.php?page='.$last.$link.'">尾页</a></li>';
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