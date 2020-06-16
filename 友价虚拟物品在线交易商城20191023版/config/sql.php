<?
 $getfilter = "'|(and|or)\\b.+?(>|<|=|in|like)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
 $postfilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";
 $cookiefilter = "\\b(and|or)\\b.{1,6}?(=|>|<|\\bin\\b|\\blike\\b)|\\/\\*.+?\\*\\/|<\\s*script\\b|\\bEXEC\\b|UNION.+?SELECT|INSERT\\s+INTO.+?VALUES|(SELECT|DELETE).+?FROM|(CREATE|ALTER|DROP|TRUNCATE)\\s+(TABLE|DATABASE)";

 function stopattack($StrFiltKey, $StrFiltValue, $ArrFiltReq){
  if(is_array($StrFiltValue))$StrFiltValue = implode($StrFiltValue);
  if (preg_match("/".$ArrFiltReq."/is",$StrFiltValue) == 1){   
   echo '4004';exit;
  }
 }

 foreach($_GET as $key=>$value){
  if(stripos($value,"<?")!==false){echo '4004';exit;}
  if(stripos($value,"&lt;?")!==false){echo '4004';exit;}
  if(stripos($value,"?>")!==false){echo '4004';exit;}
  if(stripos($value,"?&gt;")!==false){echo '4004';exit;}
  if(stripos($value,"<script")!==false){echo '4004';exit;}
  stopattack($key,$value,$getfilter);
 }
?>