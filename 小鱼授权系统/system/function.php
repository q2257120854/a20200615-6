<?php
function video_play($msg)
{
    $out = '<audio autoplay="autoplay"><source src="http://tts.baidu.com/text2audio?idx=1&tex=' . $msg . '&cuid=baidu_speech_demo&cod=2&lan=zh&ctp=1&pdt=1&spd=5&per=0&vol=0&pit=5" /></audio>';
	return $out;
}
function curl_get($url)
{
$ch=curl_init($url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
$content=curl_exec($ch);
curl_close($ch);
return($content);
}
function link_url($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $klsf[] = 'Accept:*';
    $klsf[] = 'Accept-Encoding:gzip,deflate,sdch';
    $klsf[] = 'Accept-Language:zh-CN,zh;q=0.8';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $klsf);
    curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
    $ret = curl_exec($ch);
    curl_close($ch);
    return $ret;
}
function real_ip(){
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
	$ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR']) AND preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
	foreach ($matches[0] AS $xip) {
		if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
			$ip = $xip;
			break;
		}
	}
}
return $ip;
}
function get_ip_city($ip)
{
        $location = '12345654';
		return $location;
}
function send_mail($to, $sub, $msg) {
	global $conf;
	$From = 'qianxun666@aaa666.club';
	$Host = 'smtp.exmail.qq.com';
	$Port = '465';
	$SMTPAuth = 1;
	$Username = 'qianxun666@aaa666.club';
	$Password = 'HBlxp1314';
	$Nickname = '小鱼_授权系统';
	$SSL = $Port==465?1:0;
	$mail = new SMTP($Host , $Port , $SMTPAuth , $Username , $Password , $SSL);
	$mail->att = array();
	if($mail->send($to , $From , $sub , $msg, $Nickname)) {
		return true;
	} else {
		return $mail->log;
	}
}
function daddslashes($string, $force = 0, $strip = FALSE) {
	!defined('MAGIC_QUOTES_GPC') && define('MAGIC_QUOTES_GPC', get_magic_quotes_gpc());
	if(!MAGIC_QUOTES_GPC || $force) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = daddslashes($val, $force, $strip);
			}
		} else {
			$string = addslashes($strip ? stripslashes($string) : $string);
		}
	}
	return $string;
}

function strexists($string, $find) {
	return !(strpos($string, $find) === FALSE);
}
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
	$ckey_length = 4;
	$key = md5($key ? $key : ENCRYPT_KEY);
	$keya = md5(substr($key, 0, 16));
	$keyb = md5(substr($key, 16, 16));
	$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
	$cryptkey = $keya.md5($keya.$keyc);
	$key_length = strlen($cryptkey);
	$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
	$string_length = strlen($string);
	$result = '';
	$box = range(0, 255);
	$rndkey = array();
	for($i = 0; $i <= 255; $i++) {
		$rndkey[$i] = ord($cryptkey[$i % $key_length]);
	}
	for($j = $i = 0; $i < 256; $i++) {
		$j = ($j + $box[$i] + $rndkey[$i]) % 256;
		$tmp = $box[$i];
		$box[$i] = $box[$j];
		$box[$j] = $tmp;
	}
	for($a = $j = $i = 0; $i < $string_length; $i++) {
		$a = ($a + 1) % 256;
		$j = ($j + $box[$a]) % 256;
		$tmp = $box[$a];
		$box[$a] = $box[$j];
		$box[$j] = $tmp;
		$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
	}
	if($operation == 'DECODE') {
		if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
			return substr($result, 26);
		} else {
			return '';
		}
	} else {
		return $keyc.str_replace('=', '', base64_encode($result));
	}
}

function random($length, $numeric = 0) {
	$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
	$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
	$hash = '';
	$max = strlen($seed) - 1;
	for($i = 0; $i < $length; $i++) {
		$hash .= $seed{mt_rand(0, $max)};
	}
	return $hash;
}
function showmsg($content = '未知的异常',$type = 4,$back = false)
{
switch($type)
{
case 1:
	$panel="success";
break;
case 2:
	$panel="info";
break;
case 3:
	$panel="warning";
break;
case 4:
	$panel="danger";
break;
}
echo '<div class="panel panel-'.$panel.'">
      <div class="panel-heading"><span class="glyphicon glyphicon-stats"><span> 提示信息</span></div>
        <div class="panel-body">';
echo $content;

if ($back) {
	echo '<hr/><a href="'.$back.'"><< 返回授权列表</a>';
	echo '<br/><br/><a href="javascript:history.back(-1)"><< 返回上一页</a>';
}
else
    echo '<hr/><a href="javascript:history.back(-1)"><< 返回上一页</a>';

echo '</div>
    </div>';
}
function checkauth($url,$authcode) {
	global $DB;
	$msg = 0;
//    $DB->close();  
    if($url==''){
       return $msg;
    }
/*  授权检查优化*/
	
    $lianjie=explode(".",$url);	
    if($lianjie[2] != 'www'){//检测域名是否有WWW
      $url1=$lianjie[1].'.'.$lianjie[2];
	  $log_file='./log/'.$url1.'.log';
	if(file_exists($log_file))
	{
	   $msg = 1;
//	   $DB->close();
	   return $msg;	
    }else{
	$find=$DB->get_row("select * from `auth_site` where `url` = '{$url1}' limit 1");
	$find1=$DB->get_row("select * from `auth_site` where `url` = '{$url}' limit 1");
	if($find['active']==1){
		@file_put_contents('./log/'.$find['url'].'.log','1');
		$msg = 1;
		return $msg;
	}elseif($find1['active']==1){
		@file_put_contents('./log/'.$find1['url'].'.log','1');
		$msg = 1;
		return $msg;		
	}else{
		$msg = 0;
		return $msg;
	}			
	}	  
	/////////////////  	  
    }else{
		
	$log_files='./log/'.$url.'.log';
    if(file_exists($log_files)){
//	   $DB->close();
		$msg = 1;
		return $msg;			
	}else{
	$find1=$DB->get_row("select * from `auth_site` where `url` = '{$url}' limit 1");
	
	
	
    if($find1['active']==1){
		@file_put_contents('./log/'.$find1['url'].'.log','1');
		$msg = 1;
		return $msg;		
	}else{
		$msg = 0;
		return $msg;		
	}
	
	}	

	}	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
 	
	//*****检测性优化-结束*****//	
}
/*function checkauth2($url) {
	global $DB;
    if(strstr($url,"www")){//检测域名是否有WWW
      $lianjie=explode(".",$url);
      $url=$lianjie[1].'.'.$lianjie[2];
    }
	$log_file='./log/'.$url.'.log';
	if(file_exists($log_file))
	{
	   return true;	
	}
	else
	{
	$row=$DB->get_row("SELECT * FROM auth_site WHERE `url` LIKE '%".$url."%' limit 1");	
	if ($row) {
		if($row['active']==0){
			return false;
		}else{
		    @file_put_contents('./log/'.$url.'.log',$url.'/'.$row['authcode']); 
		    return true;
		}
	} else {
		return false;
	} 
 	
	}	
}*/
?>