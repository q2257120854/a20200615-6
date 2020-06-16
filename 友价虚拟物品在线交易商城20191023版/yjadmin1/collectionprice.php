<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$post=$_POST;
if($post){
    mysql_query("update collectionprice set `1`={$post['1']},`3`={$post['3']},`6`={$post['6']},`12`={$post['12']} where id=1");
}
$sqls=mysql_query("select * from collectionprice");
$prices=mysql_fetch_array($sqls);

$ses=" where id>0";
if($_GET[page]!=""){$page=$_GET[page];}else{$page=1;}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="x-ua-compatible" content="ie=7" />
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title><?=webname?>管理系统</title>
    <link href="css/basic.css" rel="stylesheet" type="text/css" />
    <link href="css/order.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script language="javascript" src="js/basic.js"></script>
    <script language="javascript" src="js/layer.js"></script>
    <script language="javascript">
        function ser(){
            location.href="tuisong.php?st1="+document.getElementById("st1").value;
        }
    </script>
</head>
<body>
<? include("top.php");?>
<script language="javascript">
    document.getElementById("menu9").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0402,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
    <? $leftid=1;include("menu_collection.php");?>

    <div class="right">
        <div class="bqu1">
            <a class="a1" href="javascript:;">采集价格设置</a>
        </div>
        <form action="" method="post">
        <ul class="psel">
            <div><li class="l1">1个月价格：</li><li class="l2"><input name="1" value="<?=$prices[1]?>" type="text" id="st1" size="15" /></li></div>
            <div style="clear: both">
            <li class="l1">3个月价格：</li><li class="l2"><input name="3" value="<?=$prices[3]?>" type="text" id="st2" size="15" /></li>
            </div>
            <div style="clear: both">
            <li class="l1">6个月价格：</li><li class="l2"><input name="6" value="<?=$prices[6]?>" type="text" id="st2" size="15" /></li>
            </div>
                <div style="clear: both">
            <li class="l1">12个月价格：</li><li class="l2"><input name="12" value="<?=$prices[12]?>" type="text" id="st2" size="15" /></li>
                </div>
            <div style="clear: both">
                <li class="l1"></li>
                <li class="l2">
                    <button style="width: 165px;height: 40px;margin-left: -10px">保存</button>
                </li>
            </div>
        </ul>
        </form>
    </ul>
</div>
<?php include("bottom.php");?>
</body>
</html>