<div class="treebox">
 <ul class="menu">

 <li class="level1" id="leftmenu1" onclick="leftonc(1)">
  <a href="javascript:void(0);" class="a1"><em></em>商品管理<i></i></a>
  <ul class="level2">
  <li><a href="productlist.php">所有商品</a></li>
  <li><a href="productlist.php?zt=0">正在出售的商品</a></li>
  <li><a href="productlist.php?zt=1" class="red">需要审核的商品</a></li>
  <li><a href="productlx.php">发布商品</a></li>
  <li><a href="propjlist.php">评价列表</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu2" onclick="leftonc(2)">
  <a href="javascript:void(0);" class="a1"><em></em>充值卡密<i></i></a>
  <ul class="level2">
  <li><a href="paykamilist.php">卡密列表</a></li>
  </ul>
 </li>

 </ul>
</div>
<!--LEFT E-->
<script language="javascript">
leftonc(<?=$leftid?>);
</script>