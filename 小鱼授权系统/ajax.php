<?php
$mod='blank';
include_once "./system/api.inc.php";
@header("content-Type:text/json;charset=utf-8");

if(isset($_GET['act'])){$act = $_GET['act'];}else{$act = $_POST['act'];}
ob_clean();//清除BOOM

switch($act){
	case 'check_dl':
	$qq=daddslashes($_GET['qq']?$_GET['qq']:$_POST['qq']);
	$row=$DB->get_row("SELECT * FROM `auth_user` WHERE dlqq='$qq' limit 1");
	if($row['dlqq'] != ''){
		$status = array('code' => 0 , 'msg' => '此QQ是正版授权商,放心购买如发现跑路与诈骗,联系官方' , 'qq' => $row['dlqq']);
	}else{
		$status = array('code' => 1 , 'msg' => '此QQ是非正版授权商,请停止交易！');		
	}
	exit(json_encode($status));	
break;
	case 'check_url':
	$url=daddslashes($_GET['url']?$_GET['url']:$_POST['url']);
	if(checkauth($url)) {
		$status = array('code' => 0 , 'msg' => '检测的域名是小鱼代刷官方正版授权。');
	}else{
		$status = array('code' => 1 , 'msg' => '检测的域名非小鱼代刷官方正版授权。');	
	}
	exit(json_encode($status));	
break;
	case 'zz_sq':
	$km = daddslashes($_POST['km']);
	$qq = daddslashes($_POST['qq']);
	$url = daddslashes($_POST['url']);
	$date = date("Y-m-d H-i-s");
	$row1=$DB->get_row("SELECT * FROM auth_site WHERE 1 order by sign desc limit 1");
	$row2=$DB->get_row("SELECT * FROM auth_site WHERE uid='{$qq}' limit 1");
	$row3=$DB->get_row("SELECT * FROM auth_site WHERE url='{$url}' limit 1");
	$sign=$row1['sign']+1;
	$authcode=md5(random(32).$qq);
	$row = $DB->get_row("SELECT * FROM auth_kms WHERE km = '{$km}'");
	if($km == '' or $qq == '' or $url ==''){
		$status = array('code' => 1 , 'msg' => '请不要留空,谢谢啦！');
	}
	if(!$row){
		$status = array('code' => 1 , 'msg' => '此卡密不存在哦！');		
	}else if($row['zt'] == '0'){
		$status = array('code' => 1 , 'msg' => '此卡密已使用了哦！');			
	}else if($row3 != ''){
		$status = array('code' => 1 , 'msg' => '平台已存在此域名了哦！');			
	}else if($row2 != ''){
		$DB->query("update auth_kms set zt = '0' where id='{$row['id']}'");
		$DB->query("INSERT INTO auth_site (`uid`, `url`, `date`, `authcode`,`addid`, `sign`,`active`) VALUES ('$qq', '$url', '$date', '".$row2['authcode']."','{$row['addid']}', '".$row2['sign']."', '1')");
		$status = array('code' => 0 , 'msg' => '恭喜您,已成功授权域名了呢！');
	}else{
		$DB->query("update auth_kms set zt = '0' where id='{$row['id']}'");
		$DB->query("INSERT INTO auth_site (`uid`, `url`, `date`, `authcode`,`addid`, `sign`,`active`) VALUES ('$qq', '$url', '$date', '$authcode','{$row['addid']}', '$sign', '1')");      
		$status = array('code' => 0 , 'msg' => '恭喜您,已成功授权域名了呢！');
        $nr='  我们系统收到通知</br>你在我们系统进行了授权[以下是你的授权信息]</br>授权域名=><font color="red">'.$url.'</font></br>授权QQ=><font color="bule">'.$qq.'</font></br>授权时间:'.$date.'';
        $tittle='小鱼商务组提示您,你新加了一枚授权';
        $mail=send_mail($qq."@qq.com",$tittle,$nr);      
	}
	exit(json_encode($status));	
break;
default:
    echo json_encode(array('code' => '-1' , 'msg' => 'not act!'));
break;
}

?>