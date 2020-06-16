 <ul class="wz">
 <li class="l1" id="rcap1"><a href="inf.php">基本资料</a></li>
 <li class="l1" id="rcap2"><a href="touxiang.php">个人头像</a></li>
 <li class="l1" id="rcap3"><a href="pwd.php">修改密码</a></li>
 <li class="l1" id="rcap4"><a href="mobbd.php">手机绑定</a></li>
 <li class="l1" id="rcap5"><a href="emailbd.php">邮箱认证</a></li>
 <li class="l1" id="rcap6"><a href="qq.php">QQ绑定</a></li>
 <? if($rowcontrol[wxlogin]!="" && $rowcontrol[wxlogin]!=","){?>
 <li class="l1" id="rcap9"><a href="weixin.php">微信绑定</a></li>
 <? }?>
 <li class="l1" id="rcap7"><a href="smrz.php">实名认证</a></li>
 <li class="l1" id="rcap8"><a href="shdzlist.php">收货地址</a></li>
 </ul>