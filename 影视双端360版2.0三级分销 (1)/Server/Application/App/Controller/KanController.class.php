<?php
namespace App\Controller;
use Think\Controller;
class KanController extends Controller {

	public function tv(){
		$player ='http://www.360kan.com/dianshi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = "#<div class='group-wrap'>[\s\S]+?</div>#";
		preg_match_all($tvzz, $tvinfo, $tvarr);
		
		//var_dump($tvarr);
		$t = "#<a href='(.*?)' class='p(.*?) g-playicon js-playicon'><img src='(.*?)' alt='(.*?)' />[\s\S]+?<span class='desc'>(.*?)</span>[\s\S]+?</a>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		//var_dump($lianjie);
		$totalLink=count($lianjie);
		//var_dump($totalLink);
		$lianjie1=strstr($lianjie[1][0],"/tv/");
		$lianjie2=strstr($lianjie[1][1],"/tv/");
		$lianjie3=strstr($lianjie[1][2],"/tv/");
		$lianjie4=strstr($lianjie[1][3],"/tv/");
		$lianjie5=strstr($lianjie[1][4],"/tv/");
		
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[3][0],"title"=>$lianjie[4][0],"biao"=>$lianjie[5][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[3][1],"title"=>$lianjie[4][1],"biao"=>$lianjie[5][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[3][2],"title"=>$lianjie[4][2],"biao"=>$lianjie[5][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[3][3],"title"=>$lianjie[4][3],"biao"=>$lianjie[5][3]),
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[3][4],"title"=>$lianjie[4][4],"biao"=>$lianjie[5][4]),
			
			);
	
		}
			echo json_encode($list, JSON_UNESCAPED_UNICODE);
		
	}  
	public function xiaobian(){
		$player ='http://www.360kan.com/dianshi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div class="sync p-mod">[\s\S]+?<div class="content-right" data-block="tj-dsrank" monitor-desc="电视剧热播榜" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		
		
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-180x153'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span>[\s\S]+?<p class='w-newfigure-desc'>(.*?)</p></div>[\s\S]+?</li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		//var_dump($totalLink);
		$lianjie1=strstr($lianjie[2][0],"/tv/");
		$lianjie2=strstr($lianjie[2][1],"/tv/");
		$lianjie3=strstr($lianjie[2][2],"/tv/");
		$lianjie4=strstr($lianjie[2][3],"/tv/");
		$lianjie5=strstr($lianjie[2][4],"/tv/");
		$lianjie6=strstr($lianjie[2][5],"/tv/");
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[7][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[7][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[7][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[7][3],"tag"=>$lianjie[6][3]),
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[7][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[7][5],"tag"=>$lianjie[6][5]),
			
			);
	
		}
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
		
	}
	public function jumi(){
		$player ='http://www.360kan.com/dianshi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<span class="p-mod-label">剧迷福利社</span>[\s\S]+?  <div data-block="tj-neidi" monitor-desc="内地剧场" class="content-left" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		
		
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-180x153'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span>[\s\S]+?<p class='w-newfigure-desc'>(.*?)</p></div>[\s\S]+?</li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		//var_dump($totalLink);
		$lianjie1=strstr($lianjie[2][0],"/tv/");
		$lianjie2=strstr($lianjie[2][1],"/tv/");
		$lianjie3=strstr($lianjie[2][2],"/tv/");
		$lianjie4=strstr($lianjie[2][3],"/tv/");
		$lianjie5=strstr($lianjie[2][4],"/tv/");
		$lianjie6=strstr($lianjie[2][5],"/tv/");
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[7][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[7][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[7][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[7][3],"tag"=>$lianjie[6][3]),
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[7][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[7][5],"tag"=>$lianjie[6][5]),
			
			);
	
		}
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
		
	}
	public function biaoche(){
		$player ='http://www.360kan.com/dianshi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '# <span>大型飙车现场</span>[\s\S]+? <div data-block="tj-底部筛选" monitor-desc="底部筛选"  class="content-wrap g-clear p-topfilter" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);

		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-180x153'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span>[\s\S]+?<p class='w-newfigure-desc'>(.*?)</p></div>[\s\S]+?</li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		//var_dump($totalLink);
		$lianjie1=strstr($lianjie[2][0],"/tv/");
		$lianjie2=strstr($lianjie[2][1],"/tv/");
		$lianjie3=strstr($lianjie[2][2],"/tv/");
		$lianjie4=strstr($lianjie[2][3],"/tv/");
		$lianjie5=strstr($lianjie[2][4],"/tv/");
		$lianjie6=strstr($lianjie[2][5],"/tv/");
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[7][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[7][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[7][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[7][3],"tag"=>$lianjie[6][3]),
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[7][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[7][5],"tag"=>$lianjie[6][5]),
			
			);
	
		}
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
		
	}
	
	public function jushou(){
		$player ='http://www.360kan.com/dianshi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#  <span>警察！举手投降</span>[\s\S]+? <div data-block="tj-进击的泰剧" monitor-desc="进击的泰剧" class="content-wrap g-clear" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);

		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-180x153'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span>[\s\S]+?<p class='w-newfigure-desc'>(.*?)</p></div>[\s\S]+?</li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		//var_dump($totalLink);
		$lianjie1=strstr($lianjie[2][0],"/tv/");
		$lianjie2=strstr($lianjie[2][1],"/tv/");
		$lianjie3=strstr($lianjie[2][2],"/tv/");
		$lianjie4=strstr($lianjie[2][3],"/tv/");
		$lianjie5=strstr($lianjie[2][4],"/tv/");
		$lianjie6=strstr($lianjie[2][5],"/tv/");
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[7][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[7][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[7][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[7][3],"tag"=>$lianjie[6][3]),
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[7][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[7][5],"tag"=>$lianjie[6][5]),
			
			);
	
		}
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
		
	}
	
	public function dlun(){
		$player ='http://www.360kan.com/dianying/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<ul class="b-topslider-btns js-slide-btns">[\s\S]+?<div data-block="tj-顶部标签" monitor-desc="顶部标签" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		$t = '#<li class="b-topslider-btn js-slide-btn(.*?)" data-cover="(.*?)" data-href="(.*?)">[\s\S]+?<span class="b-topslider-tit">(.*?)</span>[\s\S]+?<span class="b-topslider-desc">(.*?)</span>[\s\S]+?</li>#';
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);

		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie[3][0],"pic"=>$lianjie[2][0],"title"=>$lianjie[4][0],"biao"=>$lianjie[5][0]),
			array("lianjie"=>$lianjie[3][1],"pic"=>$lianjie[2][1],"title"=>$lianjie[4][1],"biao"=>$lianjie[5][1]),
			array("lianjie"=>$lianjie[3][2],"pic"=>$lianjie[2][2],"title"=>$lianjie[4][2],"biao"=>$lianjie[5][2]),
			array("lianjie"=>$lianjie[3][3],"pic"=>$lianjie[2][3],"title"=>$lianjie[4][3],"biao"=>$lianjie[5][3]),
			array("lianjie"=>$lianjie[3][4],"pic"=>$lianjie[2][4],"title"=>$lianjie[4][4],"biao"=>$lianjie[5][4]),
			array("lianjie"=>$lianjie[3][5],"pic"=>$lianjie[2][5],"title"=>$lianjie[4][5],"biao"=>$lianjie[5][5]),
			array("lianjie"=>$lianjie[3][6],"pic"=>$lianjie[2][6],"title"=>$lianjie[4][6],"biao"=>$lianjie[5][6]),
			array("lianjie"=>$lianjie[3][7],"pic"=>$lianjie[2][7],"title"=>$lianjie[4][7],"biao"=>$lianjie[5][7]),
			);
	
		}
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
	public function drb(){
		$player ='http://www.360kan.com/dianying/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div data-block="tj-网络热播" class="g-wrap p-type13" monitor-desc="网络热播" monitor-shortpv>[\s\S]+?<div class="g-wrap" data-block="tj-辣评电影" monitor-desc="辣评电影" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		//var_dump($tvarr);
		$t = "#<li  title='(.*?)' class='(.*?)'><a href='(.*?)'  class='js-link'>[\s\S]+?<img src='(.*?)' data-src='(.*?)' alt='(.*?)'  />[\s\S]+?<p class='w-newfigure-desc'>(.*?)</p>[\s\S]+?</a></li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);

		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie[3][0],"pic"=>$lianjie[5][0],"title"=>$lianjie[6][0],"biao"=>$lianjie[7][0]),
			array("lianjie"=>$lianjie[3][1],"pic"=>$lianjie[5][1],"title"=>$lianjie[6][1],"biao"=>$lianjie[7][1]),
			array("lianjie"=>$lianjie[3][2],"pic"=>$lianjie[5][2],"title"=>$lianjie[6][2],"biao"=>$lianjie[7][2]),
			array("lianjie"=>$lianjie[3][3],"pic"=>$lianjie[5][3],"title"=>$lianjie[6][3],"biao"=>$lianjie[7][3]),
			array("lianjie"=>$lianjie[3][4],"pic"=>$lianjie[5][4],"title"=>$lianjie[6][4],"biao"=>$lianjie[7][4]),
			array("lianjie"=>$lianjie[3][5],"pic"=>$lianjie[5][5],"title"=>$lianjie[6][5],"biao"=>$lianjie[7][5]),
			array("lianjie"=>$lianjie[3][6],"pic"=>$lianjie[5][6],"title"=>$lianjie[6][6],"biao"=>$lianjie[7][6]),
			array("lianjie"=>$lianjie[3][7],"pic"=>$lianjie[5][7],"title"=>$lianjie[6][7],"biao"=>$lianjie[7][7]),
			array("lianjie"=>$lianjie[3][8],"pic"=>$lianjie[5][8],"title"=>$lianjie[6][8],"biao"=>$lianjie[7][8]),
			//array("lianjie"=>$lianjie[3][9],"pic"=>$lianjie[5][9],"title"=>$lianjie[6][9],"biao"=>$lianjie[7][9]),
			);
	
		}
	
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
	public function dwl(){
		$player ='http://www.360kan.com/dianying/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div data-block="tj-网络大电影" monitor-desc="网络大电影" monitor-shortpv>[\s\S]+?<div class="b-bannerad  js-bannerad" data-block="tj-jpyx" monitor-desc="精品优选" monitor-shortpv data-small="ZbLvy4" data-wide="s0SSzM">#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		//var_dump($tvarr);
		$t = "#<li  title='(.*?)' class='(.*?)'><a href='(.*?)'  class='js-link'>[\s\S]+?<img src='(.*?)' data-src='(.*?)' alt='(.*?)'  />[\s\S]+?<p class='w-newfigure-desc'>(.*?)</p>[\s\S]+?</a></li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);

		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie[3][0],"pic"=>$lianjie[5][0],"title"=>$lianjie[6][0],"biao"=>$lianjie[7][0]),
			array("lianjie"=>$lianjie[3][1],"pic"=>$lianjie[5][1],"title"=>$lianjie[6][1],"biao"=>$lianjie[7][1]),
			array("lianjie"=>$lianjie[3][2],"pic"=>$lianjie[5][2],"title"=>$lianjie[6][2],"biao"=>$lianjie[7][2]),
			array("lianjie"=>$lianjie[3][3],"pic"=>$lianjie[5][3],"title"=>$lianjie[6][3],"biao"=>$lianjie[7][3]),
			array("lianjie"=>$lianjie[3][4],"pic"=>$lianjie[5][4],"title"=>$lianjie[6][4],"biao"=>$lianjie[7][4]),
			array("lianjie"=>$lianjie[3][5],"pic"=>$lianjie[5][5],"title"=>$lianjie[6][5],"biao"=>$lianjie[7][5]),
			
			);
	
		}
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	public function dqq(){
		$player ='http://www.360kan.com/dianying/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div data-block="tj-全球热映" monitor-desc="全球热映" monitor-shortpv>[\s\S]+?<div data-block="tj-说走就走闯九州" monitor-desc="说走就走闯九州" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		//var_dump($tvarr);
		$t = "#<li  title='(.*?)' class='(.*?)'><a href='(.*?)'  class='js-link'>[\s\S]+?<img src='(.*?)' data-src='(.*?)' alt='(.*?)'  />[\s\S]+?<p class='w-newfigure-desc'>(.*?)</p>[\s\S]+?</a></li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);

		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie[3][0],"pic"=>$lianjie[5][0],"title"=>$lianjie[6][0],"biao"=>$lianjie[7][0]),
			array("lianjie"=>$lianjie[3][1],"pic"=>$lianjie[5][1],"title"=>$lianjie[6][1],"biao"=>$lianjie[7][1]),
			array("lianjie"=>$lianjie[3][2],"pic"=>$lianjie[5][2],"title"=>$lianjie[6][2],"biao"=>$lianjie[7][2]),
			array("lianjie"=>$lianjie[3][3],"pic"=>$lianjie[5][3],"title"=>$lianjie[6][3],"biao"=>$lianjie[7][3]),
			array("lianjie"=>$lianjie[3][4],"pic"=>$lianjie[5][4],"title"=>$lianjie[6][4],"biao"=>$lianjie[7][4]),
			array("lianjie"=>$lianjie[3][5],"pic"=>$lianjie[5][5],"title"=>$lianjie[6][5],"biao"=>$lianjie[7][5]),
			
			);
	
		}
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
	public function zlun(){
		$player ='http://www.360kan.com/zongyi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div data-block="tj-top" monitor-desc="顶部轮播排行">[\s\S]+?<b class="pre-btn page-btn js-leftbtn" title="上一页"></b>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		//var_dump($tvarr);
		//exit;
		  // <a class="js-link js-g-slide-item" href="(.*?)" style="display: block; opacity: (.*?);" data-img="(.*?)">
             //   <span style="background-image:url((.*?))">&nbsp;</span>
          //  </a>
                
		$t = '#<a class="js-link js-g-slide-item" href="(.*?)" style="(.*?)" data-img="(.*?)">[\s\S]+?</a>#';
		$tt = '#<li style="(.*?)">
                    <p class="name">(.*?)</p>
                                        <p class="desc">(.*?)</p>
                                    </li>
#';

preg_match_all($t, $tvarr[0][0], $lianjie);
		preg_match_all($tt, $tvarr[0][0], $title);
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[1][0],"/va/");
		$lianjie2=strstr($lianjie[1][1],"/va/");
		$lianjie3=strstr($lianjie[1][2],"/va/");
		$lianjie4=strstr($lianjie[1][3],"/va/");
		$lianjie5=strstr($lianjie[1][4],"/va/");
		$lianjie6=strstr($lianjie[1][5],"/va/");
		$lianjie7=strstr($lianjie[1][6],"/va/");
		$lianjie8=strstr($lianjie[1][7],"/va/");
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[3][0],"title"=>$title[2][0],"biao"=>$title[3][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[3][1],"title"=>$title[2][1],"biao"=>$title[3][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[3][2],"title"=>$title[2][2],"biao"=>$title[3][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[3][3],"title"=>$title[2][3],"biao"=>$title[3][3]),
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[3][4],"title"=>$title[2][4],"biao"=>$title[3][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[3][5],"title"=>$title[2][5],"biao"=>$title[3][5]),
			array("lianjie"=>$lianjie7,"pic"=>$lianjie[3][6],"title"=>$title[2][6],"biao"=>$title[3][6]),
			array("lianjie"=>$lianjie8,"pic"=>$lianjie[3][7],"title"=>$title[2][7],"biao"=>$title[3][7]),
			);
	
		}
		
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
		public function zzheng(){
		$player ='http://www.360kan.com/zongyi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div class="content-left" data-block="tj-重磅推荐" monitor-desc="重磅推荐" monitor-shortpv>[\s\S]+?<div class="content-right" data-block="tj-排行榜" monitor-desc="排行榜" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
	
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-190x149'><a href='(.*?)'  class='js-link'>[\s\S]+?<img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span>[\s\S]+?<p class='title g-clear'>(.*?)</p>[\s\S]+?</a>[\s\S]+?</li>#";
		
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[2][0],"/va/");
		$lianjie2=strstr($lianjie[2][1],"/va/");
		$lianjie3=strstr($lianjie[2][2],"/va/");
		$lianjie4=strstr($lianjie[2][3],"/va/");
		$lianjie5=strstr($lianjie[2][4],"/va/");
		$lianjie6=strstr($lianjie[2][5],"/va/");

		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[7][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[7][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[7][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[7][3],"tag"=>$lianjie[6][3]),
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[7][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[7][5],"tag"=>$lianjie[6][5]),
			
			);
	
		}
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
		
	}
	public function ztui(){
		$player ='http://www.360kan.com/zongyi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<span class="label">重磅推荐</span>[\s\S]+?<span class="label">生活里那点儿事儿</span>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		//($tvarr);
		//exit;
		  // <a class="js-link js-g-slide-item" href="(.*?)" style="display: block; opacity: (.*?);" data-img="(.*?)">
             //   <span style="background-image:url((.*?))">&nbsp;</span>
          //  </a>
                
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-180x153'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>(.*?)</span></p><p class='w-newfigure-desc'>(.*?)</p></div></a></li>#";

		preg_match_all($t, $tvarr[0][0], $lianjie);
		//preg_match_all($tt, $tvarr[0][0], $title);
		//var_dump($lianjie);
		//exit;
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[2][0],"/va/");
		$lianjie2=strstr($lianjie[2][1],"/va/");
		$lianjie3=strstr($lianjie[2][2],"/va/");
		$lianjie4=strstr($lianjie[2][3],"/va/");
		

		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[8][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[8][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[8][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[8][3],"tag"=>$lianjie[6][3]),
			
			
			);
	
		}

		echo json_encode($list, JSON_UNESCAPED_UNICODE);
		
		
	}
	
	public function zwu(){
		$player ='http://www.360kan.com/zongyi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '# <span class="label">无限刷不停</span>[\s\S]+?<span class="label">唱破次元壁</span>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-180x153'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>(.*?)</span></p><p class='w-newfigure-desc'>(.*?)</p></div></a></li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[2][0],"/va/");
		$lianjie2=strstr($lianjie[2][1],"/va/");
		$lianjie3=strstr($lianjie[2][2],"/va/");
		$lianjie4=strstr($lianjie[2][3],"/va/");
		$lianjie5=strstr($lianjie[2][4],"/va/");
		$lianjie6=strstr($lianjie[2][5],"/va/");
		$lianjie7=strstr($lianjie[2][6],"/va/");
		$lianjie8=strstr($lianjie[2][7],"/va/");

		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[8][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[8][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[8][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[8][3],"tag"=>$lianjie[6][3]),
			
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[8][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[8][5],"tag"=>$lianjie[6][5]),
			array("lianjie"=>$lianjie7,"pic"=>$lianjie[4][6],"title"=>$lianjie[5][6],"biao"=>$lianjie[8][6],"tag"=>$lianjie[6][6]),
			array("lianjie"=>$lianjie8,"pic"=>$lianjie[4][7],"title"=>$lianjie[5][7],"biao"=>$lianjie[8][7],"tag"=>$lianjie[6][7]),
			);
	
		}

		echo json_encode($list, JSON_UNESCAPED_UNICODE);
		
		
	}
	
	public function zwo(){
		$player ='http://www.360kan.com/zongyi/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<span class="label">我不是熊孩子</span>[\s\S]+?<div data-block="tj-底部热门标签" monitor-desc="底部热门标签" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		//($tvarr);
		//exit;
		  // <a class="js-link js-g-slide-item" href="(.*?)" style="display: block; opacity: (.*?);" data-img="(.*?)">
             //   <span style="background-image:url((.*?))">&nbsp;</span>
          //  </a>
                
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-180x153'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>(.*?)</span></p><p class='w-newfigure-desc'>(.*?)</p></div></a></li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[2][0],"/va/");
		$lianjie2=strstr($lianjie[2][1],"/va/");
		$lianjie3=strstr($lianjie[2][2],"/va/");
		$lianjie4=strstr($lianjie[2][3],"/va/");
		$lianjie5=strstr($lianjie[2][4],"/va/");
		$lianjie6=strstr($lianjie[2][5],"/va/");

		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[8][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[8][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[8][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[8][3],"tag"=>$lianjie[6][3]),
			
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[8][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[8][5],"tag"=>$lianjie[6][5]),
			);
	
		}
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
	public function dluns(){
		$player ='http://www.360kan.com/dongman/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div data-block="tj-topslider" monitor-desc="焦点图" monitor-shortpv>[\s\S]+?<div data-block="tj-hotlabel" monitor-desc="热门标签" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		$t = '# <li class="b-topslider-item js-slide-item" style="(.*?)">
            <a class="" href="(.*?)">
                <span class="b-topslider-img js-slide-img" style="background-image:url(?:\()(.*?)(?:\));"></span>
            </a>
        </li>
#';
		
		$tt = '#<li class="b-topslider-btn js-slide-btn (.*?) " data-cover="(.*?)" data-href="(.*?)">[\s\S]+?<span class="b-topslider-tit">(.*?)</span><span class="colon">&nbsp;</span><span class="b-topslider-desc">(.*?)</span>
[\s\S]+? </li>#';
preg_match_all($t, $tvarr[0][0], $lianjie);
		preg_match_all($tt, $tvarr[0][0], $title);
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[2][0],"/ct/");
		$lianjie2=strstr($lianjie[2][1],"/ct/");
		$lianjie3=strstr($lianjie[2][2],"/ct/");
		$lianjie4=strstr($lianjie[2][3],"/ct/");
		$lianjie5=strstr($lianjie[2][4],"/ct/");
		$lianjie6=strstr($lianjie[2][5],"/ct/");
		$lianjie7=strstr($lianjie[2][6],"/ct/");
		$lianjie8=strstr($lianjie[2][7],"/ct/");
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[3][0],"title"=>$title[4][0],"biao"=>$title[5][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[3][1],"title"=>$title[4][1],"biao"=>$title[5][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[3][2],"title"=>$title[4][2],"biao"=>$title[5][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[3][3],"title"=>$title[4][3],"biao"=>$title[5][3]),
			
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[3][4],"title"=>$title[4][4],"biao"=>$title[5][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[3][5],"title"=>$title[4][5],"biao"=>$title[5][5]),
			array("lianjie"=>$lianjie7,"pic"=>$lianjie[3][6],"title"=>$title[4][6],"biao"=>$title[5][6]),
			array("lianjie"=>$lianjie8,"pic"=>$lianjie[3][7],"title"=>$title[4][7],"biao"=>$title[5][7]),
			);
	
		}
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
	public function drebo(){
		$player ='http://www.360kan.com/dongman/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div data-block="tj-热门推荐" monitor-desc="热门推荐" monitor-shortpv>[\s\S]+? <span class="p-mod-label has-icon">精品优选</span>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-234x175'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>(.*?)</span></p><p class='w-newfigure-desc'>(.*?)</p></div></a></li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[2][0],"/ct/");
		$lianjie2=strstr($lianjie[2][1],"/ct/");
		$lianjie3=strstr($lianjie[2][2],"/ct/");
		$lianjie4=strstr($lianjie[2][3],"/ct/");
		$lianjie5=strstr($lianjie[2][4],"/ct/");
		$lianjie6=strstr($lianjie[2][5],"/ct/");
		$lianjie7=strstr($lianjie[2][6],"/ct/");
		$lianjie8=strstr($lianjie[2][7],"/ct/");
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[8][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[8][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[8][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[8][3],"tag"=>$lianjie[6][3]),
			
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[8][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[8][5],"tag"=>$lianjie[6][5]),
			array("lianjie"=>$lianjie7,"pic"=>$lianjie[4][6],"title"=>$lianjie[5][6],"biao"=>$lianjie[8][6],"tag"=>$lianjie[6][6]),
			array("lianjie"=>$lianjie8,"pic"=>$lianjie[4][7],"title"=>$lianjie[5][7],"biao"=>$lianjie[8][7],"tag"=>$lianjie[6][7]),
			);
	
		}
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
	public function drexue(){
		$player ='http://www.360kan.com/dongman/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div class="p-mod slider-container" data-block="tj-热血国漫" monitor-desc="热血国漫" monitor-shortpv>[\s\S]+? <span class="p-mod-label has-icon">精品优选</span>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-234x353'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>(.*?)</span></p><p class='w-newfigure-desc'>(.*?)</p></div></a></li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[2][0],"/ct/");
		$lianjie2=strstr($lianjie[2][1],"/ct/");
		$lianjie3=strstr($lianjie[2][2],"/ct/");
		$lianjie4=strstr($lianjie[2][3],"/ct/");
		$lianjie5=strstr($lianjie[2][4],"/ct/");
		$lianjie6=strstr($lianjie[2][5],"/ct/");
		
		
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[8][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[8][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[8][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[8][3],"tag"=>$lianjie[6][3]),
			
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[8][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[8][5],"tag"=>$lianjie[6][5]),
			
			);
	
		}
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
	public function driman(){
		$player ='http://www.360kan.com/dongman/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<span class="p-mod-label has-icon">经典日漫</span>[\s\S]+?<div class="p-mod slider-container" data-block="tj-欧美动漫" monitor-desc="欧美动漫" monitor-shortpv>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-234x353'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>(.*?)</span></p><p class='w-newfigure-desc'>(.*?)</p></div></a></li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[2][0],"/ct/");
		$lianjie2=strstr($lianjie[2][1],"/ct/");
		$lianjie3=strstr($lianjie[2][2],"/ct/");
		$lianjie4=strstr($lianjie[2][3],"/ct/");
		$lianjie5=strstr($lianjie[2][4],"/ct/");
		$lianjie6=strstr($lianjie[2][5],"/ct/");
		
		
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[8][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[8][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[8][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[8][3],"tag"=>$lianjie[6][3]),
			
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[8][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[8][5],"tag"=>$lianjie[6][5]),
			
			);
	
		}
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
	public function doumei(){
		$player ='http://www.360kan.com/dongman/index.html';
		$tvinfo = file_get_contents($player);
		$tvzz = '#<div class="p-mod slider-container" data-block="tj-欧美动漫" monitor-desc="欧美动漫" monitor-shortpv>[\s\S]+?span class="p-mod-label has-icon">精品优选</span>#';
		preg_match_all($tvzz, $tvinfo, $tvarr);
		$t = "#<li  title='(.*?)' class='w-newfigure w-newfigure-234x353'><a href='(.*?)'  class='js-link'><div class='w-newfigure-imglink g-playicon js-playicon'> <img src='(.*?)' data-src='(.*?)' alt='(.*?)'  /><span class='w-newfigure-hint'>(.*?)</span></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>(.*?)</span></p><p class='w-newfigure-desc'>(.*?)</p></div></a></li>#";
		preg_match_all($t, $tvarr[0][0], $lianjie);
		$totalLink=count($lianjie);
		$lianjie1=strstr($lianjie[2][0],"/ct/");
		$lianjie2=strstr($lianjie[2][1],"/ct/");
		$lianjie3=strstr($lianjie[2][2],"/ct/");
		$lianjie4=strstr($lianjie[2][3],"/ct/");
		$lianjie5=strstr($lianjie[2][4],"/ct/");
		$lianjie6=strstr($lianjie[2][5],"/ct/");
		
		
		$list=array();
		for ($x=1; $x<=$totalLink; $x++) {
			$vv=$x-1;
			$list=
			
			array(
			
			array("lianjie"=>$lianjie1,"pic"=>$lianjie[4][0],"title"=>$lianjie[5][0],"biao"=>$lianjie[8][0],"tag"=>$lianjie[6][0]),
			array("lianjie"=>$lianjie2,"pic"=>$lianjie[4][1],"title"=>$lianjie[5][1],"biao"=>$lianjie[8][1],"tag"=>$lianjie[6][1]),
			array("lianjie"=>$lianjie3,"pic"=>$lianjie[4][2],"title"=>$lianjie[5][2],"biao"=>$lianjie[8][2],"tag"=>$lianjie[6][2]),
			array("lianjie"=>$lianjie4,"pic"=>$lianjie[4][3],"title"=>$lianjie[5][3],"biao"=>$lianjie[8][3],"tag"=>$lianjie[6][3]),
			
			array("lianjie"=>$lianjie5,"pic"=>$lianjie[4][4],"title"=>$lianjie[5][4],"biao"=>$lianjie[8][4],"tag"=>$lianjie[6][4]),
			array("lianjie"=>$lianjie6,"pic"=>$lianjie[4][5],"title"=>$lianjie[5][5],"biao"=>$lianjie[8][5],"tag"=>$lianjie[6][5]),
			
			);
	
		}
		
		echo json_encode($list, JSON_UNESCAPED_UNICODE);
	}
	
}