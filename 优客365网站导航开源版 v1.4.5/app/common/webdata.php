<?php
/****************优客365网址导航系统 商业版********************/
/*                                                            */
/*  Youke365.site (C)2017 Youke365 Inc.                       */
/*  This is NOT a freeware, use is subject to license terms   */
/*  优客365网址导航商业版 ，如未授权商用，侵犯知识产权必究  */
/*  2018.4                                                    */
/*  官方网址：http://www.yunziyuan.com.cn                     */
/*  官方论坛：http://www.yunziyuan.com.cn                        */                           
/**************************************************************/
function get_sitemeta($url)
{
	 $data = get_url_content($url);
	
	$meta = array();
	if (!empty($data)) {
		#Title
		preg_match('/<TITLE>([\w\W]*?)<\/TITLE>/si', $data, $matches);
		if (!empty($matches[1])) {
			$meta['title'] = $matches[1];
		}
		
		#Keywords
		preg_match('/<META\s+name="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);		
		if (empty($matches[1])) {
			preg_match("/<META\s+name='keywords'\s+content='([\w\W]*?)'/si", $data, $matches);			
		}
		if (empty($matches[1])) {
			preg_match('/<META\s+content="([\w\W]*?)"\s+name="keywords"/si', $data, $matches);			
		}
		if (empty($matches[1])) {
			preg_match('/<META\s+http-equiv="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);			
		}
		if (!empty($matches[1])) {
			$meta['keywords'] = $matches[1];
		}
		preg_match('/<META\s+name="description"\s+content="([\w\W]*?)"/si', $data, $matches);		
		if (empty($matches[1])) {
			preg_match("/<META\s+name='description'\s+content='([\w\W]*?)'/si", $data, $matches);			
		}
		if (empty($matches[1])) {
			preg_match('/<META\s+content="([\w\W]*?)"\s+name="description"/si', $data, $matches);					
		}
		if (empty($matches[1])) {
			preg_match('/<META\s+http-equiv="description"\s+content="([\w\W]*?)"/si', $data, $matches);			
		}
		if (!empty($matches[1])) {
			$meta['description'] = $matches[1];
		}
	}
    
	return $meta; 
}

function get_serverip($url)
{

	 $domain = $url;
	if ($domain) {
			$ip = gethostbyname($domain);
	} else {
		$ip = 0;
	}
	
	return $ip;
}

function get_pagerank($url)
{
	require(CORE_PATH.'include/pagerank.php');
	
	$pr = new PageRank();
	$rank = $pr->getGPR($url);
	return $rank;
}

function get_baidurank($url)
{
	$data= get_url_content('http://seo.chinaz.com/?q='.$url);
	preg_match_all('/<span class="fz12">百度权重：<\/span><a href="(.*)" target="_blank"><img src="(.*)" \/><\/a><\/div>/iUs',$data,$arr);
	
		$num = strripos($arr[2][0],'.gif');
	
		$rank = substr($arr[2][0],$num-1,1);
		 if(isset($rank)){
			 return  $rank;  
		 }else{
		 return  "0";
		 }
}

function get_sogourank($url)
{
	$data = get_url_content("http://rank.ie.sogou.com/sogourank.php?ur=http://$url");
	if (preg_match('/sogourank=(\d+)/i', $data, $matches)) {
		$rank = intval($matches[1]);
	} else {
		$rank = 0;
	}
	return $rank;
}

/*获取网站360权重*/
function get_r360($url)
{
   //360r  

   $url = str_replace(['http://','https://','/'],'',$url);
   $data = get_url_content("https://www.aizhan.com/seo/".$url.'/');
 
  //百度权重
  preg_match_all('/images\/br\/(.*).png/iUs', $data, $arr);
  if ($arr[1][0] == "n") { 
	 $br =  0;
  } else {
	 $br=  $arr[1][0];
  }
  return $br;
 
}
function get_alexarank($url)
{
	$data = get_url_content("http://xml.alexa.com/data?cli=10&dat=nsa&ver=quirk-searchstatus&url=$url");
	if (preg_match('/<POPULARITY[^>]*URL[^>]*TEXT[^>]*\"([0-9]+)\"/i', $data, $matches)) {
		$rank = strip_tags($matches[1]);
	} else {
		$rank = 0;
	}
	return $rank;
}
function get_domain_ip($url)
{
	$data= get_url_content('http://ip.tool.chinaz.com/?ip='.$url);
	 preg_match_all('/<span class="Whwtdhalf w15-0">(.*)<\/span>/',$data,$arr);
     $ip = $arr[1][4];
		 if(!empty($arr[1][4])){
			 return  $ip;  
		 }else{
		   return  "0";
		 }	
}
