<?php
/**
 * 添加用户
**/
$mod='blank';
$title='添加用户';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" draggable="true">
<?php
if($udata['per_sq']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
if($udata['per_db']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
if(isset($_POST['user']) && isset($_POST['pass'])&& isset($_POST['dlqq'])){
$user=daddslashes($_POST['user']);
$dlqq=daddslashes($_POST['dlqq']);
$row=$DB->get_row("SELECT * FROM auth_user WHERE user='{$user}' limit 1");
if($row) {
	showmsg('用户名已存在',3);
	exit;
}
$peie=daddslashes($_POST['peie']);
  $speie=daddslashes($_POST['speie']);
$pass=daddslashes($_POST['pass']);
$per=daddslashes($_POST['per']);
if($per=="1"){
	$per_sq=1;
	$per_db=1;
	$active=1;
}else if($per=="2"){
	$per_sq=1;
	$per_db=0;
	$active=1;
}else if($per=="3"){
	$per_sq=0;
	$per_db=0;
	$active=0;
	}
  if($udata['per_db']==1){
   	$sql="insert into `auth_user` (`user`,`pass`,`dlqq`,`peie`,`speie`,`per_sq`,`per_db`,`active`) values ('".$user."','".$pass."','".$dlqq."','".$peie."','".$speie."','".$per_sq."','".$per_db."','".$active."')";
	$DB->query($sql);
    $DB->query("UPDATE `auth_user` set `speie`=`speie`-1 where user = '".$udata['user']."'");
 $DB->query("insert into `zcd_log` (`url`,`type`,`addtime`,`adduser`) values ('".$user."','2','".$date."','".$udata['user']."')");  
  }

echo "<script language='javascript'>alert('添加用户成功！');window.location.href='userlist.php';</script>";
  $nr='  我们系统收到通知</br>你在我们系统购买了授权商[以下是你的授权商信息]</br>授权用户名=><font color="red">'.$user.'</font></br>用户密码=><font color="red">'.$pass.'</font></br>授权QQ=><font color="bule">'.$dlqq.'</font>
  </br>添加时间:'.$date.'</br>登录后台：<a href="http://baidu.com/">点我前往</a><br>地址为：http://baidu.com/';
        $tittle='小鱼商务组提示您,你购买了一枚授权商';
        $mail=send_mail($dlqq."@qq.com",$tittle,$nr);  
  exit;
} 
				if(($udata['uid'])=="1"){$all='	<option value="1">高级授权商</option>';}
  if(($udata['uid'])=="1"){$syyun='            <div class="input-group">
              <span class="input-group-addon">授权商配额:</span>
              <input type="text" name="speie" value="8" class="form-control" autocomplete="off" required/>
            </div><br/>';}
?>
      <div class="panel-heading font-bold">添加用户</div>
        <div class="panel-body">
          <form action="./adduser.php" method="post" class="form-horizontal" role="form">
		  <input type="hidden" name="backurl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"/>
            <div class="input-group">
              <span class="input-group-addon">用户名:</span>
              <input type="text" name="user" value="<?=@$_POST['user']?>" class="form-control" placeholder="" autocomplete="off" required/>
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon">密码:</span>
              <input type="password" name="pass" value="<?=@$_POST['pass']?>" class="form-control" autocomplete="off" required/>
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon">QQ:</span>
              <input type="text" name="dlqq" value="<?=@$_POST['dlqq']?>" class="form-control" autocomplete="off" required/>
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon">添加配额数量:</span>
              <input type="text" name="peie" value="20" class="form-control" autocomplete="off" required/>
            </div><br/>
            <?php echo $syyun;?>
			<div class="input-group">
			  <span class="input-group-addon">权限:</span>
			  <select name="per" class="form-control">
				<?php echo $all;?>
					<option value="2">代理商权限</option>
					<option value="3">封禁该用户</option>
              </select>
            </div><br/>
            <div class="form-group">
              <div class="col-sm-12"><input type="submit" value="添加" class="btn btn-primary form-control"/></div>
            </div>
          </form>
        </div>
        <div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 全部操作权限才可以管理其他用户
        </div>
      </div>
    </div>
  </div>
<?php include './foot.php';?>