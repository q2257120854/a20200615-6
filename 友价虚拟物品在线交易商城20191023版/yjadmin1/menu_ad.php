<div class="treebox">
 <ul class="menu">

 <li class="level1" id="leftmenu1" onclick="leftonc(1)">
  <a href="javascript:void(0);" class="a1"><em></em>广告管理<i></i></a>
  <ul class="level2">
  <li><a href="adtype.php">广告管理</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu2" onclick="leftonc(2)">
  <a href="javascript:void(0);" class="a1"><em></em>帮助中心<i></i></a>
  <ul class="level2">
  <li><a href="helplist.php">帮助列表</a></li>
  <li><a href="helplx.php">添加帮助信息</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu3" onclick="leftonc(3)">
  <a href="javascript:void(0);" class="a1"><em></em>任务大厅<i></i></a>
  <ul class="level2">
  <li><a href="tasklist.php">单人任务</a></li>
  <li><a href="tasklist.php?zt=1"  class="red">审核单人任务</a></li>
  <li><a href="taskhflist.php">单人任务接手</a></li>
  <li><a href="tasklist1.php">多人任务</a></li>
  <li><a href="tasklist1.php?zt=105"  class="red">审核多人任务</a></li>
  <li><a href="taskhflist1.php">多人任务接手</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu5" onclick="leftonc(5)">
  <a href="javascript:void(0);" class="a1"><em></em>举报管理<i></i></a>
  <ul class="level2">
  <li><a href="jubaolist.php">所有举报信息</a></li>
  <li><a href="jubaolist.php?zt=1">未查看的信息</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu4" onclick="leftonc(4)">
  <a href="javascript:void(0);" class="a1"><em></em>工单管理<i></i></a>
  <ul class="level2">
  <li><a href="gdlist.php">所有工单</a></li>
  <? for($i=1;$i<=4;$i++){?>
  <li><a href="gdlist.php?gdzt=<?=$i?>"><?=returngdzt($i)?></a></li>
  <? }?>
  </ul>
 </li>

 </ul>
</div>
<!--LEFT E-->
<script language="javascript">
leftonc(<?=$leftid?>);
</script>







