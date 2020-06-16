<?php
if(isset($_GET['act']) && $_GET['act']=='save'){
	$_code = $_POST['code'];
    if(strlen($_code)!==40){exit('&#35831;&#36755;&#20837;&#27491;&#30830;&#30340;&#25480;&#26435;&#30721;');}
	$file = file(__FILE__);
	foreach($file as $k=>$v){
		if(strpos($v,'shouquan')!==false && strpos($v,'strpos')===false){
 			$_t = explode('"',$v);
			$file[$k]  = $_t[0].'"'.$_code.'"'.$_t[2];
		}
		file_put_contents(__FILE__,implode("",$file));
	}
	echo "<script>alert('授权成功!');location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
}
//授权码填写部分
$shouquan = "4dff4cdbbc9d0dcb7c827f0d75849c75a5e3a33b";


