<div class="treebox">
 <ul class="menu">

 <li class="level1" id="leftmenu1" onclick="leftonc(1)">
  <a href="javascript:void(0);" class="a1"><em></em>会员管理<i></i></a>
  <ul class="level2">
  <li><a href="userlist.php">所有会员</a></li>
  <li><a href="userlist.php?shopzt=1" class="red">需要审核的开店申请</a></li>
  <li><a href="userlist.php?rz=xy" class="red">需要审核的实名认证</a></li>
  <li><a href="userlist.php?shopzt=2">正常开店</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu2" onclick="leftonc(2)">
  <a href="javascript:void(0);" class="a1"><em></em>会员资金管理<i></i></a>
  <ul class="level2">
  <li><a href="moneylist.php">详细资金清单</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu3" onclick="leftonc(3)">
  <a href="javascript:void(0);" class="a1"><em></em>会员保证金管理<i></i></a>
  <ul class="level2">
  <li><a href="baomoneylist.php">保证金记录</a></li>
  <li><a href="baomoneylist.php?zt=1" class="red">解冻申请</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu4" onclick="leftonc(4)">
  <a href="javascript:void(0);" class="a1"><em></em>人工对账管理<i></i></a>
  <ul class="level2">
  <li><a href="renglist.php">所有对账信息</a></li>
  <li><a href="renglist.php?zt=1" class="red">需要处理的对账</a></li>
  <li><a href="renglist.php?zt=2">对账成功的记录</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu5" onclick="leftonc(5)">
  <a href="javascript:void(0);" class="a1"><em></em>会员提现<i></i></a>
  <ul class="level2">
  <li><a href="txlist.php">所有提现信息</a></li>
  <li><a href="txlist.php?zt=4">需要处理的提现</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu7" onclick="leftonc(7)">
  <a href="javascript:void(0);" class="a1"><em></em>IP黑名单管理<i></i></a>
  <ul class="level2">
  <li><a href="guolvlist.php">黑名单列表</a></li>
  <li><a href="guolv.php">新增黑名单</a></li>
  </ul>
 </li>

 <li class="level1" id="leftmenu6" onclick="leftonc(6)">
  <a href="javascript:void(0);" class="a1"><em></em>管理员信息<i></i></a>
  <ul class="level2">
  <li><a href="adminlist.php">管理员列表</a></li>
  <li><a href="admin.php">新增管理员</a></li>
  </ul>
 </li>

 </ul>
</div>
<!--LEFT E-->
<script language="javascript">
leftonc(<?=$leftid?>);
</script>