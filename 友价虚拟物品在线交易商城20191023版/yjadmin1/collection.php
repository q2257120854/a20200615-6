<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
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
            <a class="a1" href="javascript:;">采集开通记录</a>
        </div>
        <ul class="ordercap">
            <li class="l2" style="width: 50px">ID</li>
            <li class="l3" style="width: 150px">开通会员</li>
            <li class="l3" style="width: 150px">开通时间</li>
            <li class="l6" style="width: 400px">到期时间</li>
        </ul>
        <?
        pagef($ses,10,"collection","order by id desc");while($row=mysql_fetch_array($res)){
            //print_r($row);
            //$tp="../".returntp("bh='".$row[probh]."' order by iffm desc","-2");
            //$au="orderview.php?orderbh=".$row[orderbh];
            ?>
            <ul class="orderlist" style="height: 40px">

                <li class="l2" style="width: 50px"><?php echo $row['id']; ?></li>
                <li class="l3" style="width: 150px"><? echo $row['user']; ?></li>
                <li class="l3" style="width: 150px"><? echo $row['addtime']; ?></li>
                <li class="l6" style="width: 400px"><? echo $row['date']; ?></li>
            </ul>
        <? }?>
        <?
        $nowurl="collection.php";
        $nowwd="ddzt=".$_GET[ddzt]."&st1=".$_GET[st1]."&st2=".$_GET[st2];
        include("page.php");
        ?>
        <!--E-->

    </div>
</div>
<?php include("bottom.php");?>
</body>
</html>