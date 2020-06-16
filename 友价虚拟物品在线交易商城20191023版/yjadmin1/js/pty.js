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

//商品图片鼠标移动
function tphover(x){
 try{document.getElementById("tpf"+x).tover();    //适用FF、ie8
 }catch(e){
 window.frames["tpf"+x].tover();    //适用IE6、7
 }
}
function tphout(x){
 try{document.getElementById("tpf"+x).tout();    //适用FF、ie8
 }catch(e){
 window.frames["tpf"+x].tout();    //适用IE6、7
 }
}

