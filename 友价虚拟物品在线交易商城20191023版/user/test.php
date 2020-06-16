<?
include("../config/conn.php");
include("../config/function.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>免签约测试 - <?=webname?></title>
<link href="css/basic.css" rel="stylesheet" type="text/css" />
<script language="javascript" src="js/basic.js"></script>
</head>
<body>
 <form action="https://shenghuo.alipay.com/send/payment/fill.htm" method="post" target="_blank">
<input name="optEmail" type="hidden" value="199243290@qq.com" />
<input name="payAmount" type="hidden" value="10" /> 
<input name="title" type="hidden" value="编号" />
<input name="memo" type="hidden" value="备注" />
<input name="pay" type="image" value="给我付款" src="https://img.alipay.com/sys/personalprod/style/mc/btn-index.png" />
</form>
</body>
</html>