function plistaover(x){
for(i=1;i<=2;i++){
document.getElementById("plista"+i).className="a1";
document.getElementById("plistma"+i).style.display="none";
}
document.getElementById("plista"+x).className="a1 a11";
document.getElementById("plistma"+x).style.display="";
}

function plistbover(x){
al=parseInt(document.getElementById("itynum").innerHTML);
for(i=1;i<al;i++){
document.getElementById("plistb"+i).className="a1";
document.getElementById("plistmb"+i).style.display="none";
}
document.getElementById("plistb"+x).className="a1 a11";
document.getElementById("plistmb"+x).style.display="";
}