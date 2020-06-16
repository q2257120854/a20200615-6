   <input type="hidden" name="add2" id="add2" value="0" />
   <input type="hidden" name="add3" id="add3" value="0" />
   <div class="fd">
   <select name="area1" class="inp" id="area1" onchange="area1cha()">
   <option value="0">«Î—°‘Ò</option>
   <? while3("*","yjcode_city where level=1 order by xh asc");while($row3=mysql_fetch_array($res3)){?>
   <option value="<?=$row3[bh]?>"<? if($ifarea=="yes"){if($row3[bh]==$add1){?> selected="selected"<? }}?>><?=$row3[name1]?></option>
   <? }?>
   </select>
   </div>
   <div class="fd">
   <iframe name="farea2" id="farea2" marginwidth="1" scrolling="no" marginheight="1" width="390" border="0" frameborder="0" src="<?=weburl?>tem/area2.php?area1id=0"></iframe>
   </div>
   <? if($ifarea=="yes"){?>
   <script language="javascript">
   farea2.location="<?=weburl?>tem/area2.php?area1id=<?=$add1?>&area2id=<?=$add2?>&area3id=<?=$add3?>";	
   </script>
   <? }?>