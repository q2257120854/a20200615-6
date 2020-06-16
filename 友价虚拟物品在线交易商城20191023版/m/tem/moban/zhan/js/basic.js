//底部焦点
function bottomjd(x){
document.getElementById("bottom"+x).className="dm dm1";
document.getElementById("bottom"+x+"img").src=document.getElementById("webhttp").innerHTML+"m/img/bottom"+x+"_1.png";
}

function topxiala(){
 d=document.getElementById("topzhezhao");
 if(d.style.display=="block"){
 document.getElementById("topzhezhao").style.display="none";
 document.getElementById("topxialam").style.display="none";
 }else{
 document.getElementById("topzhezhao").style.display="block";
 document.getElementById("topxialam").style.display="";
 }
}