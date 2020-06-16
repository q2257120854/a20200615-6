<?php
$fang=$_GET['play'];
$jmfang=base64_decode($fang);
$like=file_get_contents($jmfang);
$likezz="/<ul class='s-guess-list g-clear js-list' data-block='tj-guess' monitor-desc=\"猜你喜欢\">(.*?)<\/ul>/is";
$kikez1="/ <img src=\"(.*?)\" data-src='(.*?)'>
            <\/a>
            <div class='s-guess-right'>
                <p class='title'><a href='(.*?)' data-index=(.*?)>(.*?)<\/a><\/p>
            <\/div>
/is";

preg_match_all($likezz, $like,$likearr);
preg_match_all($kikez1, $likearr['1']['0'],$liketitle);

    $host="http://www.360kan.com";
    $host0=$host.$liketitle['3']['0'];
    $hjiami0=base64_encode($host0);
    $host1=$host.$liketitle['3']['1'];
    $hjiami1=base64_encode($host1);
    $host2=$host.$liketitle['3']['2'];
    $hjiami2=base64_encode($host2);
    $host3=$host.$liketitle['3']['3'];
    $hjiami3=base64_encode($host3);
    $host4=$host.$liketitle['3']['4'];
    $hjiami4=base64_encode($host4);

	$title0 =$liketitle['5']['0'];
	$title1 =$liketitle['5']['1'];
	$title2 =$liketitle['5']['2'];
	$title3 =$liketitle['5']['3'];
	$title4 =$liketitle['5']['4'];

	$img0=$liketitle['2']['0'];
	$img1=$liketitle['2']['1'];
	$img2=$liketitle['2']['2'];
	$img3=$liketitle['2']['3'];
	$img4=$liketitle['2']['4'];

    echo "<li title='$title0'  class='w-newfigure w-newfigure-180x287'><a class='js-link' href='./play.php?play=$hjiami0' title='$title0' target='_blank'><div class='w-newfigure-imglink g-playicon js-playicon'><img src='$img0' alt='$title0'/></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>$title0</span></p></div></a></li>  ";
    echo "<li title='$title1'  class='w-newfigure w-newfigure-180x287'><a class='js-link' href='./play.php?play=$hjiami1' title='$title1' target='_blank'><div class='w-newfigure-imglink g-playicon js-playicon'><img src='$img1' alt='$title1'/></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>$title1</span></p></div></a></li>  ";
    echo "<li title='$title2'  class='w-newfigure w-newfigure-180x287'><a class='js-link' href='./play.php?play=$hjiami2' title='$title2' target='_blank'><div class='w-newfigure-imglink g-playicon js-playicon'><img src='$img2' alt='$title2'/></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>$title2</span></p></div></a></li>  ";
    echo "<li title='$title3'  class='w-newfigure w-newfigure-180x287'><a class='js-link' href='./play.php?play=$hjiami3' title='$title3' target='_blank'><div class='w-newfigure-imglink g-playicon js-playicon'><img src='$img3' alt='$title3'/></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>$title3</span></p></div></a></li>  ";
    echo "<li title='$title4'  class='w-newfigure w-newfigure-180x287'><a class='js-link' href='./play.php?play=$hjiami4' title='$title4' target='_blank'><div class='w-newfigure-imglink g-playicon js-playicon'><img src='$img4' alt='$title4'/></div><div class='w-newfigure-detail'><p class='title g-clear'><span class='s1'>$title4</span></p></div></a></li>  ";


