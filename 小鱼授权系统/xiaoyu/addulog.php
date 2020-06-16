<?php
/**
 * 添加授权商日志
 * BY-小鱼
 * Time：2019年7月19日01:25:26
**/
$mod='blank';

$title='添加授权商日志';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$sl=$DB->count("SELECT count(*) from zcd_log WHERE type = 2");
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" draggable="true">
<?php
$pagesize=30;
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}

$sql="`type`=2";

echo '<div class="panel-heading font-bold">授权商记录列表-共'.$sl.'</div>
<div class="panel-body">
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>授权商账号</th><th>添加者ID</th><th>时间</th><th>操作</th></tr></thead>
          <tbody>';
		  //循环写出信息
$rs=$DB->query("SELECT * FROM zcd_log WHERE{$sql} order by id desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<tr><td>'.$res['url'].'</td><td><a href="list.php?qq='.$res['adduser'].'">'.$res['adduser'].'</a>&nbsp;<a href="tencent://message/?uin='.$res['url'].'&Site=%E6%8E%88%E6%9D%83%E5%B9%B3%E5%8F%B0&Menu=yes">[?]</a></td><td>'.$res['addtime'].'</td><td></td><td><a href="./addlog.php?my=del&id='.$res['id'].'" class="btn btn-xs btn-danger" onclick="return confirm(\'你确实要删除此条授权记录吗？\');">删除</a></td></tr>';
}	
         //结束	  
		 echo '          </tbody>
        </table>
      </div>    </div>
  </div>';
?>
<?php
echo'<ul class="pagination">';
$s = ceil($sl / $pagesize);
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$s;
if ($page>1)
{
echo '<li><a href="list.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="list.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="list.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="list.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
