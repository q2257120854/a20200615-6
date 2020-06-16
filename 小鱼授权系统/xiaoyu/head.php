<?php
include_once "../system/api.inc.php";
@header('Content-Type: text/html; charset=UTF-8');
echo '
<!DOCTYPE html>
  <html lang="en">
  <head>
  <meta charset="utf-8">
  <title>'.$title.'</title>
  <meta name="keywords" content=""/>
  <meta name="description" content=""/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="renderer" content="webkit">
  <link href="//lib.baomitu.com/twitter-bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="//lib.baomitu.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/>
  <script src="//lib.baomitu.com/jquery/1.12.4/jquery.min.js"></script>
  <script src="//lib.baomitu.com/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//lib.baomitu.com/layer/2.3/layer.js"></script>
</head>
<body>
  <nav class="navbar navbar-fixed-top navbar-default">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
          <span class="sr-only">导航按钮</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
<a class="navbar-brand" href="./"><font color="#0099FF">小鱼授权系统授权后台</a></font>
      </div><!-- /.navbar-header -->
      <div id="navbar" class="collapse navbar-collapse">
        <ul class="nav navbar-nav navbar-right">
          <li class="active">
            <a href="./"><span class="glyphicon glyphicon-user"></span> <font color="#0099FF">平台首页</a>
          </li></font>
		  ';
		  if($islogin==1){
		  echo'
		  	<li class="">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-list"></span> <font color="#0099FF">授权管理<b class="caret"></font></b></a>
            <ul class="dropdown-menu">
              <li><a href="./sqlist.php"><font color="#0099FF">我的授权列表</font></a></li>
			  <li><a href="./add.php"><font color="#0099FF">添加授权</font></a></li>
			  <li><a href="./addsite.php"><font color="#0099FF">添加站点</font></a></li>
			  <li><a href="./km.php"><font color="#0099FF">卡密生成</font></a></li>
            </ul>
          </li>			  
';	
}		 
			if($udata['per_db']==1&&$udata['super']==1&&$udata['active']==1){
                echo '
		  <li class="">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-cog"></span><font color="#0099FF"> 高管功能<b class="caret"></font></b></a>
            <ul class="dropdown-menu">
              <li><a href="./adduser.php"><font color="#0099FF">添加用户</font></a></li>			
              <li><a href="./list.php"><font color="#0099FF">授权列表</font></a></li>
              <li><a href="./userlist.php"><font color="#0099FF">用户列表</font></a></li>
              <li><a href="./pirater.php"><font color="#0099FF">盗版记录</font></a></li>		  
            </ul>
          </li>				
				';				
			}
echo'			  
		             <li><a href="./login.php?logout"><span class="glyphicon glyphicon-log-out"></span><font color="#0099FF"> 退出登陆</font></a></li>
        </ul>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
  </nav><!-- /.navbar -->
<div class="container" style="padding-top:100px;">
</div>
';
?>
