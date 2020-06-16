//搜索
function psear(x){
m1=document.f1.money1.value;
m2=document.f1.money2.value;
if(isNaN(m1)){alert("价格输入有误！");document.f1.money1.select();return false;}	
if(isNaN(m2)){alert("价格输入有误！");document.f1.money2.select();return false;}	
wz=x+"_b"+m1+"v_c"+m2+"v";
if(document.getElementById("C1").checked){wz=wz+"_a1v";}
if(document.getElementById("C2").checked){wz=wz+"_d1v";}
if(document.getElementById("C3").checked){wz=wz+"_g1v";}
f1.action="../search/index.php?admin=4&getv="+wz;
}
