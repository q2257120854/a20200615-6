<?
//之所以独立出来，是因为这个信誉的定义，可能用户不太一样
function returnxytp($xynum){
 if($xynum>=0 && $xynum<6){ 
  return "s-star-1.gif";
 }elseif($xynum>=6 && $xynum<20){ 
  return "s-star-2.gif";
 }elseif($xynum>=20 && $xynum<50){ 
  return "s-star-3.gif";
 }elseif($xynum>=50 && $xynum<100){ 
  return "s-star-4.gif";
 }elseif($xynum>=100 && $xynum<200){ 
  return "s-star-5.gif";
 }elseif($xynum>=200 && $xynum<350){ 
  return "s-Diamond-1.gif";
 }elseif($xynum>=350 && $xynum<600){ 
  return "s-Diamond-2.gif";
 }elseif($xynum>=600 && $xynum<1000){ 
  return "s-Diamond-3.gif";
 }elseif($xynum>=1000 && $xynum<1500){ 
  return "s-Diamond-4.gif";
 }elseif($xynum>=1500 && $xynum<2500){ 
  return "s-Diamond-5.gif";
 }elseif($xynum>=2500 && $xynum<4000){ 
  return "s-crown-1.gif";
 }elseif($xynum>=4000 && $xynum<6000){ 
  return "s-crown-2.gif";
 }elseif($xynum>=6000 && $xynum<10000){ 
  return "s-crown-3.gif";
 }elseif($xynum>=10000 && $xynum<15000){ 
  return "s-crown-4.gif";
 }elseif($xynum>=15000){ 
  return "s-crown-5.gif";
 }
}
function returnxych($xynum){
 if($xynum>=0 && $xynum<6){ //表示信用大于等0，小于10
  return "一星卖家(1 - 5个信用积分)";
 }elseif($xynum>=6 && $xynum<21){ 
  return "二星卖家(5 - 20个信用积分)";
 }elseif($xynum>=21 && $xynum<51){ 
  return "三星卖家(21 - 50个信用积分)";
 }elseif($xynum>=51 && $xynum<101){ 
  return "四星卖家(51 - 100个信用积分)";
 }elseif($xynum>=101 && $xynum<201){ 
  return "五星卖家(101 - 200个信用积分)";
 }elseif($xynum>=201 && $xynum<351){ 
  return "一钻卖家(201 - 350个信用积分)";
 }elseif($xynum>=351 && $xynum<601){ 
  return "二钻卖家(351 - 600个信用积分)";
 }elseif($xynum>=601 && $xynum<1001){ 
  return "三钻卖家(601 - 1000个信用积分)";
 }elseif($xynum>=1001 && $xynum<1501){ 
  return "四钻卖家(1001 - 1500个信用积分)";
 }elseif($xynum>=1501 && $xynum<2501){ 
  return "五钻卖家(1501 - 2500个信用积分)";
 }elseif($xynum>=2501 && $xynum<4001){ 
  return "一皇冠卖家(2501 - 4000个信用积分)";
 }elseif($xynum>=4001 && $xynum<6001){ 
  return "二皇冠卖家(4001 - 6000个信用积分)";
 }elseif($xynum>=6001 && $xynum<10001){ 
  return "三皇冠卖家(6001 - 10000个信用积分)";
 }elseif($xynum>=10001 && $xynum<15001){ 
  return "四皇冠卖家(10001 - 15000个信用积分)";
 }elseif($xynum>=15001){ 
  return "五皇冠卖家(15001个信用积分)";
 }
}

?>