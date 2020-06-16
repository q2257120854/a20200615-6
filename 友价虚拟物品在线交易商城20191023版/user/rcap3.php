 <ul class="wz">
 <li class="l1" id="rcap1"><a href="product.php?bh=<?=$bh?>">基本资料</a></li>
 <li class="l1" id="rcap2"><a href="javascript:void(0);" onclick="videoonc()">商品视频</a></li>
 <li class="l1" id="rcap3"><a href="taocanlist.php?bh=<?=$rowpro[bh]?>">套餐设置</a></li>
 <? if($rowpro[fhxs]==4){?>
 <li class="l1" id="rcap4"><a href="kclist.php?bh=<?=$rowpro[bh]?>">卡密库存</a></li>
 <? }?>
 </ul>
 