<?
include("../../config/conn.php");
include("../../config/function.php");

if(intval($_GET[admin])==1){  //商品搜索
zwzr();
if(empty($rowcontrol[sermode])){$k=base_encode(sqlzhuru($_POST[topt]));}
elseif($rowcontrol[sermode]==2){$k=urlencode(sqlzhuru($_POST[topt]));}
else{$k=sqlzhuru($_POST[topt]);}
php_toheader("../product/search_s".$k."v.html");

}elseif(intval($_GET[admin])==2){  //表示店铺搜索
zwzr();
if(empty($rowcontrol[sermode])){$k=base_encode(sqlzhuru($_POST[topt]));}
elseif($rowcontrol[sermode]==2){$k=urlencode(sqlzhuru($_POST[topt]));}
else{$k=sqlzhuru($_POST[topt]);}
php_toheader("../shop/search_s".$k."v.html");

}
?>