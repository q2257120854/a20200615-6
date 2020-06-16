<?php
/**
 * 下载管理
**/
$mod='blank';
$title='下载管理';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" draggable="true">
<?php
/*if($udata['per_db']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}*/
if(isset($_GET['qq'])) {
$qq=daddslashes($_GET['qq']);
$row=$DB->get_row("SELECT * FROM auth_site WHERE uid='{$qq}' limit 1");
if($row=='')exit("<script language='javascript'>alert('授权平台不存在该QQ！');history.go(-1);</script>");
if($row['active']==0)exit("<script language='javascript'>alert('此QQ的授权已被封禁！');history.go(-1);</script>");
$authcode=$row['authcode'];
$sign=$row['sign'];
?>
<div class="panel-heading font-bold">下载管理</div>
<div class="panel-body">
            <li class="list-group-item"><span class="glyphicon glyphicon-stats"></span> <b>授权ＱＱ：</b> <?=$qq?>&nbsp;<a href="tencent://message/?uin=<?=$qq?>&amp;Site=授权平台&amp;Menu=yes"><img src="http://wpa.qq.com/pa?p=1:<?=$qq?>:1" border=0></a></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-time"></span> <b>授权代码：</b> <?=$authcode?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>特征代码：</b> <?=$sign?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-list"></span> <b>下载类型：</b> 
              <a href="download.php?my=installer&authcode=<?=$authcode?>&sign=<?=$sign?>&r=<?=time()?>" class="btn btn-xs btn-success">完整安装包</a>&nbsp;
              <a href="download.php?my=updater&authcode=<?=$authcode?>&sign=<?=$sign?>&r=<?=time()?>" class="btn btn-xs btn-primary">更新包</a>
            </li>
          </ul>
		  <div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 新购用户请下载完整安装包！
        </div>
      </div>
<?php }else{?>
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">下载管理</h3></div>
        <div class="panel-body">
          <form action="./downfile.php" method="GET" class="form-horizontal" role="form">
            <div class="input-group">
              <span class="input-group-addon">ＱＱ</span>
              <input type="text" name="qq" value="<?=@$_GET['qq']?>" class="form-control" placeholder="购买授权的QQ" autocomplete="off" autofocus="autofocus" required/>
            </div><br/>
            <div class="form-group">
              <div class="col-sm-12"><input type="submit" value="获取下载地址" class="btn btn-primary form-control"/></div>
            </div>
          </form>
        </div>
      </div>
<?php }?>

    </div>
  </div>
<?php include './foot.php';?>