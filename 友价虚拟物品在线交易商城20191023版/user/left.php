<? 
if(empty($qzmotweb) && empty($rowuser[ifmot]) && $rowcontrol["qzmot"]){Audit_alert("根据网络实名制要求，请先绑定您的手机号码","mobbd.php");}
if(empty($userztweb) && empty($rowuser[zt])){php_toheader("userzt.php");}
?>
<!--左B-->
<div class="userleft">
 <div class="menu">
  
  <? if(2!=$rowuser[shopzt] && 4!=$rowuser[shopzt]){?>
  <? if($rowcontrol[ifopenshop]=="on"){?>
  <div class="cap">我是卖家</div>
  <div class="d1">
  <a href="openshop1.php">我要开店</a>
  </div>
  <? }?>
  
  <? }elseif(4==$rowuser[shopzt]){?>
  <div class="cap">我是卖家</div>
  <div class="d1">
  <a href="openshop4.php">店铺到期续费</a>
  </div>
  
  <? 
  }else{
  $a=returncount("yjcode_order where selluserid=".$rowuser[id]." and ddzt='wait'");
  ?>
  <div class="cap">我是卖家</div>
  <div class="d1">
  <a href="sellorder.php"<? if($a>0){?> class="al"<? }?>>销售订单</a>
  <? if($a>0){?><a href="sellorder.php?ddzt=wait" class="ar">发货<span class="fh"><?=$a?></span></a><? }?>
  <a href="productlist.php" class="al">商品列表</a><a href="productlx.php" class="ar">新增</a>
  <a href="propjlist.php">评价管理</a>
  <? $a=returncount("yjcode_wenda where selluserid=".$rowuser[id]." and hftxt=''");?>
  <a href="prowdlist.php"<? if($a>0){?> class="al"<? }?>>商品问答</a><? if($a>0){?><a href="prowdlist.php?ifhf=no" class="ar">问答<span class="fh"><?=$a?></span></a><? }?>
  <a href="yunfeilist.php">运费模板</a>
  <a href="shop.php" class="al">店铺设置</a><a href="<?=returnmyweb($rowuser[id],$rowuser[myweb])?>" class="ar" target="_blank">预览</a>
  <a href="adlx1.php">自助广告系统</a>
  </div>
  
  <? }?>

  <div class="cap">我的产品</div>
  <div class="d1">
  <a href="order.php">我的订单</a>
  <a href="car.php">购物车</a>
  <a href="favpro.php">我的收藏</a>
  </div>

  <? if(empty($rowcontrol[iftask])){?>
  <div class="cap">任务大厅</div>
  <div class="d1">
  <a href="tasklist.php">我是雇主</a>
  <a href="taskhflist.php">我是接手方</a>
  <a href="<?=weburl?>task/taskadd.php" target="_blank">发起任务</a>
  </div>
  <? }?>
  
  <div class="cap">互动管理</div>
  <div class="d1">
  <a href="newslist.php" class="al">我的稿件</a><a href="newslx.php" class="ar">投稿</a>
  <a href="tjuid.php">我推荐的会员</a>
  </div>
  
 </div>
</div>
<!--左E-->
