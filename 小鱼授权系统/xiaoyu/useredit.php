<?php
/**
 * 编辑用户
**/
$mod='blank';
$title='编辑用户';
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
if($_GET['my']=='edit') {
$uid=intval($_GET['uid']);
$row=$DB->get_row("SELECT * FROM auth_user WHERE uid='{$uid}' limit 1");
$classid=$row['class'];
if($row=='')exit("<script language='javascript'>alert('授权管理平台不存在该用户！');history.go(-1);</script>");
if($uid==1){
	showmsg('您无法修改系统账号！',3);
	exit;
}else if($uid==$udata['uid']){
	showmsg('您无法修改自己账号！',3);
	exit;
}
if(isset($_POST['submit'])) {
$user=daddslashes($_POST['user']);
$dlqq=daddslashes($_POST['dlqq']);
$peie=daddslashes($_POST['peie']);
$per=daddslashes($_POST['per']);
if($_POST['pass']==""){
	$pass=$row['pass'];
}else{
	$pass=daddslashes($_POST['pass']);
}
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
		$sql="update `auth_user` set `user` ='{$user}',`pass` ='{$pass}',`dlqq` ='{$dlqq}',`peie` ='{$peie}',`per_sq` ='{$per_sq}',`per_db` ='{$per_db}',`active` ='{$active}' where `uid`='{$uid}'";
		if($DB->query($sql)){showmsg('修改成功！',1,$_POST['backurl']);
	$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$udata['user']."','修改用户','".$date."','".$city."','用户名".$user."|密码".$pass."|授权".$per_sq."|获取".$per_db."|状态".$active."')");
}
		else showmsg('修改失败！<br/>'.$DB->error(),4,$_POST['backurl']);
}else{
$row=$DB->get_row("SELECT * FROM auth_user WHERE uid='{$uid}' limit 1");
?>
      <div class="panel-heading font-bold">编辑用户</div>
        <div class="panel-body">
          <form action="./useredit.php?my=edit&uid=<?php echo $uid; ?>" method="post" class="form-horizontal" role="form">
		  <input type="hidden" name="backurl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"/>
            <div class="form-group">
              <label class="col-sm-2 control-label">用户名</label>
              <div class="col-sm-10"><input type="text" name="user" value="<?php echo $row['user']; ?>" class="form-control" readonly/></div>
            </div><br/>
            <?php if($udata['uid']==1){ ?>
			<div class="form-group">
              <label class="col-sm-2 control-label">密码</label>
              <div class="col-sm-10"><input type="text" name="pass" value="<?php echo $row['pass']; ?>" class="form-control" ></div>
            </div><br/>
			<div class="form-group">
              <label class="col-sm-2 control-label">QQ</label>
              <div class="col-sm-10"><input type="text" name="dlqq" value="<?php echo $row['dlqq']; ?>" class="form-control" ></div>
            </div><br/>
			<div class="form-group">
              <label class="col-sm-2 control-label">配额数量</label>
              <div class="col-sm-10"><input type="text" name="peie" value="<?php echo $row['peie']; ?>" class="form-control" ></div>
            </div><br/>
              <div class="form-group">
              <label class="col-sm-2 control-label">授权商配额数量</label>
              <div class="col-sm-10"><input type="text" name="speie" value="<?php echo $row['speie']; ?>" class="form-control" autocomplete="off" required/></div>
            </div><br/>
            <?php } else{?>
            	<div class="form-group">
              <label class="col-sm-2 control-label">密码</label>
              <div class="col-sm-10"><input type="password" name="pass" value="" class="form-control" readonly/></div>
            </div><br/><?php } ?>
			<div class="form-group">
              <label class="col-sm-2 control-label">权限</label>
              <div class="col-sm-10"><select name="per" class="form-control">
				<?php
				
				if(($udata['uid'])=="1"){$all='<option value="1">全部操作权限</option>"';}else{$all='';}
				if(($row['active'])=="0"){
				
					echo '
					<option value="3">该用户已封禁</option>
					<option value="2">授权操作权限</option>
						'.$all;
				}	else if($row['per_sq']==1&&$row['per_db']==0&&$row['active']==1){
					echo '
					
					<option value="2">授权操作权限</option>
					<option value="3">封禁该用户</option>
										'.$all;
				}else if($row['per_sq']==0&&$row['per_db']==1&&$row['active']==1){
					echo '
				
					<option value="2">授权操作权限</option>
					<option value="3">封禁该用户</option>
					'.$all;
				}else if (($row['per_sq']==1&&$row['per_db']==1&&$row['active']==1)){
				echo $all.'
			
					<option value="3">封禁该用户</option>
					<option value="2">授权操作权限</option>
						
					';
					}
				?>
              </select></div>
            </div><br/>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10"><input type="submit" name="submit" value="修改" class="btn btn-primary form-control"/><br/>
			  <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>">返回用户列表</a></div>
            </div>
          </form>
        </div>
           <?php if($udata['uid']==1){ ?>
        <div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 密码为空则不修改密码
        </div><?php } ?>
      </div>
<?php
}
}else if($_GET['my']=='del'){
	$uid=intval($_GET['uid']);
	if($uid==1){
	showmsg('您无法删除系统账号！',3);
	exit;
	}else if($uid==$udata['uid']){
	showmsg('您无法删除自己账号！',3);
	exit;
	}
	$sql="DELETE FROM auth_user WHERE uid='$uid' limit 1";
	if($DB->query($sql)){showmsg('删除成功！',1,$_SERVER['HTTP_REFERER']);
		
	}
	else showmsg('删除失败！<br/>'.$DB->error(),4,$_SERVER['HTTP_REFERER']);
}
?>

    </div>
  </div>
<?php include './foot.php';?>