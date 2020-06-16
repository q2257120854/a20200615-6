<?php
include("../config/conn.php");
include("../config/function.php");
AdminSes_audit();
$id=$_GET[id];
while0("*","yjcode_user where id=".$id);if(!$row=mysql_fetch_array($res)){php_toheader("userlist.php");}
$sql=mysql_query("select * from collection where uid=".$id);
$crow=mysql_fetch_array($sql);
$post=$_POST;
if($post){

    $status=$post['d1'];

    if($status==0){
        if($crow){
            mysql_query("delete from collection where id={$crow['id']}");
        }
    }else {
        $date = $post['t1'];
        if(!$date){
            Audit_alert("日期不能为空","usercollection.php?id={$id}");
        }
        if ($crow) {
            mysql_query("update collection set `date`='{$date}' where uid={$id}");
        } else {
            $addtime = date("Y-m-d H:i:s");

            mysql_query("insert into collection (uid,`date`,`user`,`addtime`) values({$row['id']},'{$date}','{$row['nc']}','{$addtime}')");
        }
    }
    Audit_alert("修改成功!","usercollection.php?id={$id}");
}
//函数结果
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "https://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="x-ua-compatible" content="ie=7" />
    <meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
    <title><?=webname?>管理系统</title>
    <link href="css/basic.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script language="javascript" src="js/basic.js"></script>
    <script language="javascript" src="js/layer.js"></script>

</head>
<body>
<? include("top.php");?>
<script language="javascript">
    document.getElementById("menu2").className="a1";
</script>
<? if(!strstr($adminqx,",0,") && !strstr($adminqx,",0702,")){echo "<div class='noneqx'>无权限</div>";exit;}?>

<div class="yjcode">
    <? $leftid=1;include("menu_user.php");?>

    <div class="right">
        <? if($_GET[t]=="suc"){systs("恭喜您，操作成功！","usermoney.php?id=".$id);}?>
        <? include("rightcap3.php");?>
        <script language="javascript">document.getElementById("rtit8").className="a1";</script>
        <!--B-->
        <div class="rkuang">
            <form name="f1" method="post" action="">
                <ul class="uk">
                    <li class="l1">会员帐号：</li>
                    <li class="l2"><input type="text" class="inp redony" readonly="readonly" name="tuid" size="20" value="<?=$row[uid]?>" /></li>
                    <li class="l1">可用余额：</li>
                    <li class="l2"><input class="inp redony" readonly="readonly" value="<?=sprintf("%.2f",$row[money1])?>" size="10" type="text"/></li>
                    <li class="l1">冻结金额：</li>
                    <li class="l2"><input class="inp redony" readonly="readonly" value="<?=sprintf("%.2f",$row[djmoney])?>" size="10" type="text"/></li>
                    <li class="l1">采集权限：</li>
                    <li class="l2">
                        <select name="d1" class="inp">
                            <?php if($crow){ ?>
                            <option value="0">关闭权限</option>
                            <option value="1" selected>打开权限</option>
                            <?php }else{ ?>
                                <option value="0"  selected>关闭权限</option>
                                <option value="1">打开权限</option>
                            <?php } ?>
                        </select>
                    </li>
                    <li class="l1">到期日期：</li>
                    <li class="l2"><input name="t1" class="inp" size="10" type="text" value="<?=$crow['date']?>"/><span class="fd">日期格式：2020-08-31</span></li>
                    <li class="l3"><input type="submit" value="保存修改" class="btn1" /></li>
                </ul>
            </form>
        </div>
        <!--E-->

    </div>
</div>
<?php include("bottom.php");?>
</body>
</html>