 <? 
 $sj=date("Y-m-d H:i:s");
 $au="../product/view".returnproid($row[probh]).".html";
 $sqlb1="select * from yjcode_user where id=".$row[userid];mysql_query("SET NAMES 'GBK'");$resb1=mysql_query($sqlb1);$rowb1=mysql_fetch_array($resb1);
 ?>
 
 <div class="orderv2">
  <ul class="u1">
  <li class="l1"><a href="<?=$au?>" target="_blank"><?=$row[tit]?></a></li>
  <li class="l2"><span>编号:<?=$orderbh?></span></li>
  <li class="l3"><span class="s1">订单金额</span><span class="s2"><?=returnjgdian($row[money1]*$row[num]+$row[yunfei])?></span></li>
  <li class="l4"><span class="s1">商品数量</span><span class="s2"><?=$row[num]?></span></li>
  <li class="l5"><span class="s1">订单状态</span><span class="s2"><?=returnorderzt($row[ddzt])?></span></li>
  <li class="l6"><span class="s1">买家 [<strong><?=$rowb1[nc]?></strong>]</span><? if(!empty($rowb1[uqq])){?><a href="javascript:void(0);" onclick="opentangqq('<?=$rowb1[uqq]?>')" class="s2"><?=$rowb1[uqq]?></a><? }?><span class="s3"><?=$rowb1[mot]?></span></li>
  </ul>
  
  <? if(!empty($ifztcontrol)){?>
  <!--状态说明B-->
  <div class="ztcontrol">
   <div class="d1"></div>
   <div class="d2">
   
    <? if($row[ddzt]=="wait"){?>
    <div class="ds1">买家已经付款了，请尽快发货。</div>
    <div class="ds3">
    <a href="fahuo.php?orderbh=<?=$orderbh?>" class="a1">发货</a>
    <a href="sellclose.php?orderbh=<?=$orderbh?>" class="a0">取消订单</a>
    </div>
    <? }?>
    
    <? if($row[ddzt]=="close"){?>
    <div class="ds1">您在 <?=$row[closesj]?> 取消了该笔订单。</div>
    <div class="ds2">买家支付的款项已经退回其会员账号。</div>
    <? }?>
    
    <? if($row[ddzt]=="suc"){?>
    <div class="ds1">恭喜您，该笔订单已经交易成功。</div>
    <div class="ds2"><strong>提醒：</strong>如果还需要该商品，请点<a href="<?=$au?>" target="_blank">再次购买</a>。</div>
    <? }?>
    
    <? if($row[ddzt]=="backsuc"){?>
    <div class="ds1">您于 <?=$row[tkoksj]?> 同意了买家的退款申请，款项已经退回到买家账户中。</div>
    <div class="ds2">处理说明：<?=returnjgdw($row[tkjg],"","同意退款")?></div>
    <? }?>
    
    <? 
	if($row[ddzt]=="backerr"){
    while1("*","yjcode_db where orderbh='".$orderbh."'");$row1=mysql_fetch_array($res1);
    $second=strtotime($row1[dboksj])-strtotime($sj);
    $day = floor($second/(3600*24));
    $second = $second%(3600*24);//除去整天之后剩余的时间
    $hour = floor($second/3600);
    $second = $second%3600;//除去整小时之后剩余的时间 
    $minute = floor($second/60);
    $second = $second%60;//除去整分钟之后剩余的时间 
    $sjcv=$day."天".$hour."时".$minute."分".$second."秒";
    ?>
    <div class="ds1">您于 <?=$row[tkoksj]?> 拒绝了买家的退款申请。处理说明：<?=returnjgdw($row[tkjg],"","同意退款")?></div>
    <div class="ds2">资金担保剩余：<?=$sjcv?></div>
    <? }?>
    
    <? 
	if($row[ddzt]=="back"){
    while1("*","yjcode_tk where orderbh='".$orderbh."'");$row1=mysql_fetch_array($res1);
    $second=strtotime($row1[tkoksj])-strtotime($sj);
    $day = floor($second/(3600*24));
    $second = $second%(3600*24);//除去整天之后剩余的时间
    $hour = floor($second/3600);
    $second = $second%3600;//除去整小时之后剩余的时间 
    $minute = floor($second/60);
    $second = $second%60;//除去整分钟之后剩余的时间 
    $sjcv=$day."天".$hour."时".$minute."分".$second."秒";
    ?>
    <div class="ds1">退款需要处理，您需要在 <?=$sjcv?> 内处理该订单的退款申请。</div>
    <div class="ds2">如果超时未处理，系统会自动判断为您同意了退款申请。</div>
    <div class="ds3">
    <a href="selltk.php?orderbh=<?=$orderbh?>" class="a1">处理退款</a>
    </div>
    <? }?>
    
    <? 
	if($row[ddzt]=="db"){
    while1("*","yjcode_db where orderbh='".$orderbh."'");$row1=mysql_fetch_array($res1);
    $second=strtotime($row1[dboksj])-strtotime($sj);
    $day = floor($second/(3600*24));
    $second = $second%(3600*24);//除去整天之后剩余的时间
    $hour = floor($second/3600);
    $second = $second%3600;//除去整小时之后剩余的时间 
    $minute = floor($second/60);
    $second = $second%60;//除去整分钟之后剩余的时间 
    $sjcv=$day."天".$hour."时".$minute."分".$second."秒";
	?>
    <div class="ds1">您已发货，等待买家确认收货。</div>
    <div class="ds2">资金担保剩余时间：<?=$sjcv?></div>
    <? }?>

    <? if($row[ddzt]=="jf"){?>
    <div class="ds1">买家申请了平台介入处理本次退款纠纷，处理过程中资金将被冻结，直至处理完毕。您可以提交更有利于您的证据。</div>
    <div class="ds3"><a href="orderjf2.php?orderbh=<?=$orderbh?>" class="a1">查看记录</a></div>
    <? }?>

    <? if($row[ddzt]=="jfbuy"){?>
    <div class="ds1">平台已经判定本次交易纠纷为买家胜诉，款项已经退回到买家的账户。</div>
    <div class="ds3"><a href="orderjf2.php?orderbh=<?=$orderbh?>" class="a0">查看沟通记录</a></div>
    <? }?>

    <? if($row[ddzt]=="jfsell"){?>
    <div class="ds1">平台已经判定本次交易纠纷为您胜诉，款项已经自动结算至您的账户。</div>
    <div class="ds3"><a href="orderjf2.php?orderbh=<?=$orderbh?>" class="a0">查看沟通记录</a></div>
    <? }?>
    
   </div>
  </div>
  <!--状态说明E-->
  <? }?>
  
  <ul class="u2">
  <li class="l1">下单时间</li><li class="l2"><?=$row[sj]?></li>
  <li class="l1">选购套餐</li><li class="l2"><?=returnjgdw($row[tcv],"","无")?></li>
  </ul>
  <? if(!empty($row[liuyan])){?>
  <table class="table1" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td class="td1">购买留言</td>
  <td class="td2"><?=$row[liuyan]?></td>
  </tr>
  </table>
  <? }?>
  <? if(!empty($row[buyform])){?>
  <table class="table1" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td class="td1">购买信息</td>
  <td class="td2"><?=$row[buyform]?></td>
  </tr>
  </table>
  <? }?>
  <? if(!empty($row[shdz])){?>
  <table class="table1" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td class="td1">收货地址</td>
  <td class="td2"><?=$row[shdz]?></td>
  </tr>
  </table>
  <? }?>
 
  <? if(!empty($row[fhtxt])){?>
  <table class="table1" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td class="td1">发货备注</td>
  <td class="td2"><?=$row[fhtxt]?></td>
  </tr>
  </table>
  <? }?>
 
  <table class="table1" border="0" cellspacing="0" cellpadding="0">
  <tr>
  <td class="td1">收货信息</td>
  <td class="td2">
  <? 
  $sqlpro="select * from yjcode_pro where bh='".$row[probh]."'";mysql_query("SET NAMES 'GBK'");$respro=mysql_query($sqlpro);if($rowpro=mysql_fetch_array($respro)){
  $tcfhxs=0;
  if(!empty($row[tcid])){
   while2("*","yjcode_taocan where id=".$row[tcid]);if($row2=mysql_fetch_array($res2)){$tcfhxs=$row2[fhxs];}
  }
  ?>
 
  <? if((1==$rowpro[fhxs] && empty($tcfhxs)) || 1==$tcfhxs){?><strong class="blue">手动发货</strong><? }?>
  <? if(1==$tcfhxs){?><strong class="blue">手动发货</strong><? }?>
 
  <? if(2==$rowpro[fhxs] && empty($tcfhxs)){?>
  <strong>该订单商品通过网盘下载，以下为下载信息：</strong><br>
  <strong class="blue">网盘地址：<a href="<?=$rowpro[wpurl]?>" target="_blank"><?=$rowpro[wpurl]?></a><br>网盘密码：<?=$rowpro[wppwd]?><br>解压密码：<?=$rowpro[wppwd1]?></strong>
  <? }?>
  <? if(2==$tcfhxs){?>
  <strong>该订单商品通过网盘下载，以下为下载信息：</strong><br>
  <strong class="blue">网盘地址：<a href="<?=$row2[wpurl]?>" target="_blank"><?=$row2[wpurl]?></a><br>网盘密码：<?=$row2[wppwd]?><br>解压密码：<?=$row2[wppwd1]?></strong>
  <? }?>
 
  <? if(3==$rowpro[fhxs] && empty($tcfhxs)){if(empty($rowpro[upty])){$u=weburl."upload/".$rowpro[userid]."/".$rowpro[bh]."/".$rowpro[upf];}else{$u=$rowpro[upf];}?>
  <strong>该订单的商品已经传至服务器，点击图标下载</strong><br>
  <a href="<?=$u?>" target="_blank"><img border="0" style="margin-top:5px;" src="img/down.jpg" /></a>
  <? }?>
  <? if(3==$tcfhxs){if(empty($rowpro[upty])){$u=weburl."upload/".$rowpro[userid]."/".$rowpro[bh]."/".$row2[upf];}else{$u=$row2[upf];}?>
  <strong>该订单的商品已经传至服务器，点击图标下载</strong><br>
  <a href="<?=$u?>" target="_blank"><img border="0" style="margin-top:5px;" src="img/down.jpg" /></a>
  <? }?>
 
  <? if((4==$rowpro[fhxs] && empty($tcfhxs)) || 4==$tcfhxs){?>
  <strong>卡密信息</strong><br>
  <span class="fontc">
  <? if(!empty($rowpro[downurl])){echo "软件下载地址：<a href='".$rowpro[downurl]."' target='_blank'>【点击下载软件】</a><br>";}?>
  <?=$row[txt]?>
  </span>
  <? }?>
 
  <? if((5==$rowpro[fhxs] && empty($tcfhxs)) || 5==$tcfhxs){?>
  <strong>快递物流信息：</strong><br>
  <? if(!empty($row[kdid])){while1("*","yjcode_kuaidi where id=".$row[kdid]);if($row1=mysql_fetch_array($res1)){$kdbh=$row1[kdbh];$kddh=$row[kddh];?>
  快递公司：<a href="<?=$row1[kdweb]?>" target="_blank" class="green"><?=$row1[tit]?></a><br>
  快递单号：<strong><?=$kddh?></strong><br>
  <? while1("*","yjcode_chajian where cjbh='cj001' and zt=0");if($row1=mysql_fetch_array($res1)){include("../config/chajian/cj001/index.php");}?>
  <? }}?>
  <? }?>
 
  <? }else{?>
  <strong class="red">亲，很抱歉，无法提供该订单的发货信息（或已经删除商品信息）</strong>
  <? }?>
  </td>
  </tr>
  </table>

  
 </div>
 
  
 <div class="jfgtlist">
  <div class="cap">&nbsp;&nbsp;沟通记录</div>
  <? 
  $i=1;
  while1("*","yjcode_orderlog where orderbh='".$orderbh."' and selluserid=".$userid." order by sj asc");while($row1=mysql_fetch_array($res1)){
  $txt=$row1[txt];
  if($row1[admin]==1){$tp=returntppd("../upload/".$row1[userid]."/user.jpg","img/nonetx.gif");$sf="买方";}
  elseif($row1[admin]==2){$tp=returntppd("../upload/".$row1[selluserid]."/user.jpg","img/nonetx.gif");$sf="卖方";}
  elseif($row1[admin]==3){$tp="img/nonetx.jpg";$sf="平台";}
  ?>
  <ul class="u1<? if($i==1){?> u0<? }?>">
  <li class="l1"><img src="<?=$tp?>" width="40" height="40" /></li>
  <li class="l2">[<?=$sf?>] <?=$txt?><br><?=$row1[sj]?></li>
  </ul>
  <? $i++;}?>
 </div>
