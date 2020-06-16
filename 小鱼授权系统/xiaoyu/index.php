<?php

$mod='blank';

$title='小鱼授权管理中心';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<?php
if($udata['token']==''){
	$kuaijie='未绑定QQ（点击绑定）';
	$login='toQzoneLogin()';
	}elseif($udata['uid']!=''){
		$kuaijie="已绑定";
		$login='#';
		}	
$mysites=$DB->count("SELECT count(*) from auth_site WHERE addid = ".$udata['uid']."");
$sites=$DB->count("SELECT count(*) from auth_site WHERE 1");
$blocks=$DB->count("SELECT count(*) from auth_block WHERE 1");
?>
  <script type="text/javascript">
            var childWindow;
            function toQzoneLogin()
            {
                childWindow = window.open("link.php","TencentLogin","width=450,height=320,menubar=0,scrollbars=1, resizable=1,status=1,titlebar=0,toolbar=0,location=1");
            } 
            
            function closeChildWindow()
            {
                childWindow.close();
            }
        </script>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" draggable="true">
<div class="panel-heading font-bold"style='background:linear-gradient(to right,#99FFCC,#99FFFF,#33CCFF,#0066FF);'>后台管理首页</div>
<div class="panel-body">
<table class="table table-bordered"style='background:linear-gradient(to right,#33ccff,#99FFFF);'>
<tbody>
<tr height="25">
<td align="center"><font color="red"><b><span class="glyphicon"></span>站点统计：</b></br>正版:<?=$sites?>，盗版:<?=$blocks?></font></td>
<td align="center"><font color="red"><b><i class="glyphicon"></i>快捷登陆情况：</b></br></span><a href="#" onclick='<?=$login?>'"><font color="#1701EA"><?=$kuaijie?></font></a></td>
</tr>
<tr height="25">
<td align="center"><font color="red"><b><i class="glyphicon"></i>您授权了域名：</b></br><?=$mysites?>/个</font></td>
<td align="center"><font color="red"><b><i class="glyphicon"></i>登录时间：</b></span></br><?=$udata['last']?></font></td>
</tr>
<tr height="25">
<td align="center"><font color="red"><b><span class="glyphicon"></span>账号权限：</font></b></br><?php if($udata['per_sq']==1&&$udata['per_db']!=1&&$udata['active']==1){ ?><span class="btn btn-sm btn-info">授权商</span> <?php } ?><?php if($udata['per_db']==1&&$udata['per_sq']==1&&$udata['super']==1&&$udata['active']==1){ ?><span class="btn btn-sm btn-info"><font color='#0033FF'>创始人：小鱼</span> <?php } ?></font><?php if($udata['per_db']==1&&$udata['per_sq']==1&&$udata['super']==0&&$udata['active']==1){ ?><span class="btn btn-sm btn-info">高级授权商</span> <?php } ?></td>
<td align="center"><font color="red"><b><i class="glyphicon"></i>你的:QQ</b></br></span><?=$udata['dlqq']?></font></td>
<tr height="25">
  <?php if($udata['per_sq']==1&&$udata['per_db']!=1&&$udata['active']==1){ 
echo '<td align="center"><font color="red"><b><span class="glyphicon"></span>授权配额数量：</b></br>'.$udata['peie'].'/个</font></td>';
 echo ' <td align="center"><font color="red"><b><i class="glyphicon"></i>授权商配额:</b></br></span>你不是高级授权商</font></td>';
  }elseif($udata['per_db']==1&&$udata['per_sq']==1&&$udata['active']==1){
 echo '<td align="center"><font color="red"><b><span class="glyphicon"></span>授权配额数量：</b></br>'.$udata['peie'].'/个</font></td>'; 
echo '<td align="center"><font color="red"><b><i class="glyphicon"></i>授权商配额:</b></br></span>'.$udata['speie'].'/个</font></td>';
  }?>
</tr>
<tr height="25">
<td align="center"><a href="./password.php" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-home"></i>修改密码</a></td>
<td align="center"><a href="./add.php" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-home"></i>添加授权</a></td>
</tr>
<tr height="25">
<td align="center"><a href="./addsite.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-folder-close"></i>添加站点</a></td>
<td align="center"><a href="./km.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-cog"></i>生成卡密</a></td>
</tr>
<tr height="25">
<td align="center"><a href="http://wpa.qq.com/msgrd?v=3&uin=435184519&site=qq&menu=yes" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-cog"></i>♚联系作者♚</a></td>
<td align="center"><a href="http://wpa.qq.com/msgrd?v=3&uin=435184519&site=qq&menu=yes" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-cog"></i>♝联系作者♝</a></td>
</tbody>
</table>
      </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"style='background:linear-gradient(to right,#99FFCC,#99FFFF,#33CCFF,#0066FF);'><font color="##0033FF">平台公告</font></div>
                <div class="panel-body"style='background:linear-gradient(to right,#33ccff,#99FFFF);'>
<font color='red'>  <b>官方允许(正式版)低价出售授权，授权不得低于38元。<br>
----------------------------------------<br>
授权商正式版140元（40额度）<br>
管理员正式版280元（999额度）<br><br>
<td align="center"><a href="https://jq.qq.com/?_wv=1027&k=5CnLR1Q" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-home"></i>学技术点我进群</a></td><br>
----------------------------------------<br></font>
                </div>
            </div>
            
        </div>
    </div>
  </div>
<?php include './foot.php';?>