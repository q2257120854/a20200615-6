<div class="treebox">
 <ul class="menu">
 
 <li class="level1" id="leftmenu1" onclick="leftonc(1)">
  <a href="javascript:void(0);" class="a1"><em></em>资讯管理<i></i></a>
  <ul class="level2">
  <li><a href="newslist.php">资讯列表</a></li>
  <li><a href="newslist.php?zt=1">需要审核的资讯</a></li>
  <li><a href="newslx.php">发布新资讯</a></li>
  <li><a href="newspjlist.php">评论列表</a></li>
  </ul>
 </li>
 
 <li class="level1" id="leftmenu2" onclick="leftonc(2)">
  <a href="javascript:void(0);" class="a1"><em></em>网站公告<i></i></a>
  <ul class="level2">
  <li><a href="gglist.php">公告列表</a></li>
  <li><a href="gglx.php">添加公告信息</a></li>
  </ul>
 </li>
 
 </ul>
</div>
<!--LEFT E-->
<script language="javascript">
leftonc(<?=$leftid?>);
</script>