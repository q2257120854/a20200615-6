<div class="helpleft">
 <ul class="u1 fontyh">
 <li class="l1">帮助中心</li>
 <li class="l2"></li>
 </ul>
 <ul class="u2 fontyh">
 <li class="l1"><a href="gglist.html">网站公告</a></li>
 <li class="l2"><a href="gglist.html">公告列表</a></li>
 <?
 $i=1;
 while1("*","yjcode_helptype where admin=1 order by xh asc");while($row1=mysql_fetch_array($res1)){
 $aurl="search_j".$row1[id]."v.html";
 if(returncount("yjcode_help where ty1id=".$row1[id])==1){
 while3("id,ty1id","yjcode_help where ty1id=".$row1[id]." order by sj desc");$row3=mysql_fetch_array($res3);
 $aurl="view".$row3[id].".html";
 }
 ?>
 <li class="l1"><a href="<?=$aurl?>"><?=$row1[name1]?></a></li>
 <?
 while2("*","yjcode_helptype where admin=2 and name1='".$row1[name1]."' order by xh asc");while($row2=mysql_fetch_array($res2)){
 $aurl="search_j".$row1[id]."v_k".$row2[id]."v.html";
 if(returncount("yjcode_help where ty1id=".$row1[id]." and ty2id=".$row2[id])==1){
 while3("id,ty1id,ty2id","yjcode_help where ty1id=".$row1[id]." and ty2id=".$row2[id]);$row3=mysql_fetch_array($res3);
 $aurl="view".$row3[id].".html";
 }
 ?>
 <li class="l2"><a href="<?=$aurl?>"><?=$row2[name2]?></a></li>
 <?
 }
 ?>
 <?
 $i++;
 }
 ?>
 </ul>
</div>