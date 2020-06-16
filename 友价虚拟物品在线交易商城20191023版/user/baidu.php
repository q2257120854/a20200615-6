<?php
function baidu($url){
    //echo $url;
    include("../config/conn.php");
    $sql=mysql_query("select * from baidu where id=0",$conn);
    $res=mysql_fetch_array($sql);
    $site=$res['urls'];
    $api = 'http://data.zz.baidu.com/urls?site='.$site.'&token='.$res['token'];
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => "http://www.baidu.com/".$url,
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
    $r=json_decode($result,true);
    //file_put_contents($url.".txt",$r);
    //print_r($r);
    if($r['success']){
        return true;
    }else{
        return false;
    }
}

function xiongzhang($url){
    include("../config/conn.php");
    $sql=mysql_query("select * from baidu where id=1",$conn);
    $res=mysql_fetch_array($sql);
    $site=$res['urls'];
	$api = 'http://data.zz.baidu.com/urls?appid='.$site.'&token='.$res['token'].'&type=realtime';
    $ch = curl_init();
    $options =  array(
        CURLOPT_URL => $api,
        CURLOPT_POST => true,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POSTFIELDS => "http://www.baidu.cn/".$url,
        CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
    );
    curl_setopt_array($ch, $options);
    $result = curl_exec($ch);
   // file_put_contents("222.txt",$result);
	$r=json_decode($result,true);
	
    if($r['success_realtime']){
        return true;
    }else{
        return false;
    }
}

function share($content,$pic,$token)
{
	include("../config/conn.php");
	$sinalogin=preg_split("/,/",$rowcontrol[sinalogin]);
	include("../api_login/sina/saetv2.ex.class.php");
	$c = new saetclientv2( $sinalogin[0] , $sinalogin[1] ,$token);
	  $content=urlencode(iconv('gbk','utf-8',$content));
	$result = $c->share($content,$pic);
	//var_dump($result);
}
//$r=baidu("m/product/view651.html");
