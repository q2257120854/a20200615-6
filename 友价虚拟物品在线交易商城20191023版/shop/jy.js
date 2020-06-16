function extractNodes(pNode){
	if(pNode.nodeType == 3)return null;
	var node,nodes = new Array();
	for(var i=0;node= pNode.childNodes[i];i++){
		if(node.nodeType == 1)nodes.push(node);
	}
	return nodes;
}
num=parseInt(document.getElementById("jynum").innerHTML);
var obj=document.getElementById("rolltxt");
if(num>0){
for(i=0;i<4;i++){
	obj.appendChild(extractNodes(obj)[i].cloneNode(true));
 }
settime=0;
var t=setInterval("rolltxt()",40);
}
function rolltxt(){
	if(obj.scrollTop % (obj.clientHeight-20) ==0){
		settime+=1;
		if(settime==40){
			obj.scrollTop+=1;
			settime=0;
		}
	}else{
		obj.scrollTop+=1;
		if(obj.scrollTop==(obj.scrollHeight-obj.clientHeight)){
			obj.scrollTop=0;
		}
	}
}

obj.onmouseover=function(){clearInterval(t)}
obj.onmouseout=function(){t=setInterval("rolltxt()",40)}

