//商品分类点击筛选
function typeonc(x,y){
ptype2.location="../tem/protype2.php?type1id="+x;
document.getElementById("type1name").innerHTML=y+" >> ";
document.f1.type1id.value=x;
document.getElementById("type2name").innerHTML="";
document.getElementById("type3name").innerHTML="";
document.f1.type2id.value=0;
document.f1.type3id.value=0;
ptype3.location="../tem/protype3.php";

}

function tjadd(w,u){
 if(document.f1.type1id.value=="0"){alert("请选择商品类别");return false;}	
 if(1==u){if(document.f1.t1.value==""){alert("请输入会员帐号");return false;}}
 if(document.getElementById("C1").checked==false){alert("请先阅读并同意商品发布须知条款");return false;}
 f1.action=w+"?control=add";
}
function tjupdate(w,x,y){
 if(document.f1.type1id.value=="0"){alert("请选择商品类别");return false;}	
 if(document.getElementById("C1").checked==false){alert("请先阅读并同意商品发布须知条款");return false;}
 f1.action=w+"?control=update&id="+x+"&bh="+y;
}

function kjd1cha(){
 x=document.getElementById("kjd1").value;
 if(x==""){return false;}
 a=x.split(" ");
 b1=a[0].split("yjcode");
 b2=a[1].split("yjcode");
 b3=a[2].split("yjcode");
 b4=a[3].split("yjcode");
 b5=a[4].split("yjcode");
 document.getElementById("type2name").innerHTML="";
 document.getElementById("type3name").innerHTML="";
 document.getElementById("type4name").innerHTML="";
 document.getElementById("type5name").innerHTML="";
 ptype2.location="about:blank";
 ptype3.location="about:blank";
 ptype4.location="about:blank";
 ptype5.location="about:blank";
 document.f1.type1id.value=b1[0];
 document.getElementById("type1name").innerHTML=b1[1]+" >> ";
 ptype2.location="../tem/protype2.php?type1id="+b1[0];
 document.f1.type2id.value=b2[0];
 if(b2[1]!=""){document.getElementById("type2name").innerHTML=b2[1]+" >> ";ptype3.location="../tem/protype3.php?type1id="+b1[0]+"&type2id="+b2[0];}
 document.f1.type3id.value=b3[0];
 if(b3[1]!=""){document.getElementById("type3name").innerHTML=b3[1]+" >> ";ptype4.location="../tem/protype4.php?type1id="+b1[0]+"&type2id="+b2[0]+"&type3id="+b3[0];}
 document.f1.type4id.value=b4[0];
 if(b4[1]!=""){document.getElementById("type4name").innerHTML=b4[1]+" >> ";ptype5.location="../tem/protype5.php?type1id="+b1[0]+"&type2id="+b2[0]+"&type3id="+b3[0]+"&type4id="+b4[0];}
 document.f1.type5id.value=b5[0];
 if(b5[1]!=""){document.getElementById("type5name").innerHTML=b5[1];}
}