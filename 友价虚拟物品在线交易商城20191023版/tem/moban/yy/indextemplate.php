<?
include("../../../config/conn.php");
include("../../../config/function.php");
include("../../../config/xy.php");
$sj=date("Y-m-d H:i:s");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="x-ua-compatible" content="ie=7" />
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<meta name="keywords" content="<?=$rowcontrol[webkey]?>">
<meta name="description" content="<?=$rowcontrol[webdes]?>">
<title><?=$rowcontrol[webtit]?> - <?=webname?></title>
<link rel="shortcut icon" href="img/favicon.ico" />
    <link href="/css/ppt.css" rel="stylesheet" type="text/css"/>
    <script language="javascript" src="/js/jquery.m.js"></script>
    <script language="javascript" src="/js/layui.js"></script>
    <script language="javascript" src="/js/ppt.js?v=1"></script>
    <script language="javascript" src="/js/index.js"></script>
    <link href="/css/index.css?v=1" rel="stylesheet" type="text/css"/>
    <link href="/css/font_1043715_q2eckx9ho8.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="/css/swiper.min.css">
    <link rel="stylesheet" href="/css/bcat-theme.css">
    <script language="javascript" src="<?=weburl?>js/basic.js"></script>
    <script language="javascript" src="<?=weburl?>js/index.js"></script>
   <? if(empty($rowcontrol[ifwap])){?>
<script language="javascript">
if(is_mobile()) {document.location.href= '<?=weburl?>m/';}
</script>
<? }?>
    <style>
        .module-loading img {
            z-index: 1000;
            top: 38%;
            left: 50%;
            width: 200px;
            height: 200px;
            margin-left: -100px;
            position: absolute;
            text-align: center;
        }
    </style>
</head>
<body>

    <!--头部-->
    <div class="header">
         <div class="left"> 
        </div>
        <div class="x_nav">
			  <a href<?=weburl?> class="logo_link fl"><img alt="<?=webname?>" border="0" src="<?=weburl?>img/logo.png" /></a>
              <ul class="x_nav_list fl">
                <li>
                    <a href="/" class="nav_link" style="color: ">首页</a> 
					
				</li>
               <? while1("*","yjcode_ad where adbh='ADI02' and type1='文字' order by xh asc");while($row1=mysql_fetch_array($res1)){?>
                <li><a href="<?=$row1[aurl]?>" target="_blank" class="nav_link" style="color: "><?=$row1[tit]?></a></li>
                 <? }?>
            </ul>
        </div>
        <!--大屏展示 开始-->
        <div class="x_bannner"
             style="background-image: url(/homeimg/bg_big.png);">
            <div class="x_bannner_con">
                <div class="x_bannner_top">
                    <h1>在线交易服务一站式平台</h1>
                    <div class="recommend_carousel"
                         style="background:url(/homeimg/homesite.jpg) no-repeat;background-position: 50% 100%;">
                        <div class="recommend_carousel_con">
                            <ul>
                                <div class="swiper-container  swiper-container-top">
                                    <div class="swiper-wrapper">
             
             
             <? while0("*","yjcode_gg where zt=0 order by sj desc limit 5");while($row=mysql_fetch_array($res)){?>
   <div class="swiper-slide">
			 <li>
              <a href="/help/ggview394.html"title="<?=$row[tit]?>"target='_blank'><i></i><?=strgb2312($row[tit],0,26)?>&nbsp;&nbsp;&nbsp;&nbsp;[<?=dateMD($row[sj])?>]</a>
			
              </li>
           
			</div>
                   <? }?>                  </div>
                                </div>
                            </ul>
                        </div>
                    </div>
                    <div class="search-chance">
                        <div class="chance-cont">
                            <form name="topf1" method="post" onsubmit="return topftj()">
                                <div class="search-cont">
                                    <i></i>
                                    <input name="topt" id="topt" class="J-top-input" placeholder="请输入搜索内容关键字">
                             <button id="J-top-chance"class="  Search-btn common-chance chance-btn J-top-submit"style="background-image: url(/homeimg/lv_btn.png);">搜索</button>
                             <span class="J-buyBtn-cont top-buy-cont">或
                             <button type="button"class="common-chance fb-btn top-buy-btn J-top-buy-btn J-top-submit"style="background-image: url(/homeimg/red_btn.png);">发布交易</button>
                            </span>
                                </div>
                            </form>
                        </div>
                        <div class="exponent">
                        <span>热门搜索：
                        </span>
                            <span><a href="/product/search_j37v.html">源码/集市</a></span>
                            <span><a href="/product/search_j38v.html">企业/网站</a></span>
                            <span><a href="/product/search_j39v.html">实物/交易</a></span>
							<span><a href="/product/search_j63v.html">汽车/用品</a></span>
							<span><a href="/product/search_j39v_k76v.html">电脑办公</a></span>

                        </div>
                    </div>
                </div>
                <div class="x_bannner_bottom">
                    <div class="x_bannner_lable">
                        <ul class="lable_nav">
                            <li class="J_lable_nav active">限时优惠 <span><i></i>官方推荐，精选源码</span></li>
                            <li class="J_lable_nav">精品店铺 <span><i></i>无忧购买，精品店铺</span></li>
                        </ul>
                        <div>
<div class="lable_conter J_lable_nav_con">
<ul class="link_conter">
 <? 
 $i=1;
 while1("*","yjcode_pro where zt=0 and ifxj=0 and iftuan=1 and yhxs=2 and yhsj2>'".$sj."' order by yhsj2 asc limit 6");while($row1=mysql_fetch_array($res1)){
 $money1=returnyhmoney($row1[yhxs],$row1[money2],$row1[money3],$sj,$row1[yhsj1],$row1[yhsj2],$row1[id]);
 $au="product/view".$row1[id].".html";
 $dqsj=str_replace("-","/",$row1[yhsj2]);
 while2("*","yjcode_user where id=".$row1[userid]);$row2=mysql_fetch_array($res2);
 ?>
 <ul class="u1 u1<?=$i?>">
 <li class="l1">
 <a href="<?=$au?>" target="_blank" title="<?=$row1[tit]?>"><img src="<?=returntp("bh='".$row1[bh]."'","-1")?>" width="60" height="60" border="0" /></a>
 </li>
 <li class="l2"><a href="<?=$au?>" target="_blank" title="<?=$row1[tit]?>"><?=strgb2312($row1[tit],0,20)?></a></li>
 </ul>
 <? $i++;}?>
 </ul>
   <ul class="ad_conter">
   <li>
   <img class="lazy" src="/homeimg/o_1d740j6uq14lvchn14jm17b61o05a.png" alt="" style="display: inline;">
   </li>
   <li>
   <img class="lazy" src="/homeimg/o_1d740mmjh2221v5r1at64kb93ua.png" alt="" style="display: inline;">
   </li>
   <li>
   <img class="lazy" src="/homeimg/o_1d740n24f1ml111s31ak91u01139ha.png" alt="" style="display: inline;">
   </li>
   <li>
   <img class="lazy" src="/homeimg/o_1d740ne8q8do1ku617i6103344ca.png" alt="" style="display: inline;">
   </li>
   </ul>
   </div>
     <div class="lable_conter_3 J_lable_nav_con ipr-hide" style="display: none;">
                                <div class="lable_conter_3_left fl">
                                    <ul class="lable_conter_3_left_nav">
                                        <li class="J_3_nav  active">
                                            自营店
                                        </li>
                                        <li class="J_3_nav ">
                                            旗舰店
                                        </li>
                                        <li class="J_3_nav ">
                                            专营店
                                        </li>
                                    </ul>
                                    <div>
                                        <ul class="lable_conter_3_left_con J_3_conter ">
							 <? 
                              while1("*","yjcode_user where zt=1 and shopzt=2  and pm>0 order by pm asc limit 4");while($row1=mysql_fetch_array($res1)){
                              $sucnum=returnjgdw($row1[xinyong],"",returnxy($row1[id],1));
                              $au=returnmyweb($row1[id],$row1[myweb]);
                              ?>		
                                       <li>
                                                    <div class="left_3_conter ovh">
                                                        <dl class="left_3_conter_left fl">
                                                            <dt>
                                                                <img class="lazy"
                                                                     title="<?=$row1['shopname']?>"
                                                                     src="upload/<?=$row1[id]?>/shop.jpg" onerror="this.src='user/img/nonetx.gif'"
                                                                     style="display: inline;">
                                                            </dt>
                                                        </dl>
                                                        <div class="left_3_conter_rigth fr">
                                                            <p class="name"><?=$row1['shopname']?></p>
                                                            <p class="desc">主要经营：<?=$row1['seodes']?></p>
                                                            <p class="btns">
                                                                <button class="btns_tell J_btns_tell"
                                                                        onclick="window.location.href='<?=$au?>';">
                                                                    立即进入
                                                                </button>
                                                                <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$row1['uqq']?>&amp;site=qq&amp;menu=yes"
                                                                   target="_blank">
                                                                    <button class="btns_ask">
                                                                        在线咨询
                                                                    </button>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                                     <? }?>	                                    </ul>
                                        <ul class="lable_conter_3_left_con J_3_conter ipr-hide">
									 <? 
                                     while1("*","yjcode_user where zt=1 and shopzt=2  and pm>1 order by pm asc limit 4");while($row1=mysql_fetch_array($res1)){
                                     $sucnum=returnjgdw($row1[xinyong],"",returnxy($row1[id],1));
                                     $au=returnmyweb($row1[id],$row1[myweb]);
                                     ?>		
                                         <li>
                                                    <div class="left_3_conter ovh">
                                                        <dl class="left_3_conter_left fl">
                                                            <dt>
                                                                <img class="lazy"
                                                                     title="<?=$row1['shopname']?>"
                                                                     src="upload/<?=$row1[id]?>/shop.jpg" onerror="this.src='user/img/nonetx.gif'"
                                                                     style="display: inline;">
                                                            </dt>
                                                        </dl>
                                                        <div class="left_3_conter_rigth fr">
                                                            <p class="name"><?=$row1['shopname']?></p>
                                                            <p class="desc">主要经营：<?=$row1['seodes']?></p>
                                                            <p class="btns">
                                                                <button class="btns_tell J_btns_tell"
                                                                        onclick="window.location.href='<?=$au?>';">
                                                                    立即进入
                                                                </button>
                                                                <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$row1['uqq']?>&amp;site=qq&amp;menu=yes"
                                                                   target="_blank">
                                                                    <button class="btns_ask">
                                                                        在线咨询
                                                                    </button>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                        <? }?>	        
                                        </ul>
                                        <ul class="lable_conter_3_left_con J_3_conter ipr-hide">
                             <? 
                             while1("*","yjcode_user where zt=1 and shopzt=2  and pm>2 order by pm asc limit 4");while($row1=mysql_fetch_array($res1)){
                             $sucnum=returnjgdw($row1[xinyong],"",returnxy($row1[id],1));
                             $au=returnmyweb($row1[id],$row1[myweb]);
                             ?>		
                                                  <li>
                                                    <div class="left_3_conter ovh">
                                                        <dl class="left_3_conter_left fl">
                                                            <dt>
                                                                <img class="lazy"
                                                                     title="<?=$row1['shopname']?>"
                                                                     src="upload/<?=$row1[id]?>/shop.jpg" onerror="this.src='user/img/nonetx.gif'"
                                                                     style="display: inline;">
                                                            </dt>
                                                        </dl>
                                                        <div class="left_3_conter_rigth fr">
                                                            <p class="name"><?=$row1['shopname']?></p>
                                                            <p class="desc">主要经营：<?=$row1['seodes']?></p>
                                                            <p class="btns">
                                                                <button class="btns_tell J_btns_tell"
                                                                        onclick="window.location.href='<?=$au?>';">
                                                                    立即进入
                                                                </button>
                                                                <a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?=$row1['uqq']?>&amp;site=qq&amp;menu=yes"
                                                                   target="_blank">
                                                                    <button class="btns_ask">
                                                                        在线咨询
                                                                    </button>
                                                                </a>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </li>
                                              <? }?>	        
                                        </ul>
                                    </div>
                                    <div class="label_work_time_description">
                                        <p>工作日：9:00-12:00/13:30-18:00</p>
                                    </div>
                                </div>
                                <div class="lable_conter_3_right fr ">
                                    <p class="tit">什么是自营店</p>
                                    <p class="desc"><?=webname?>优选源码</p>
                                    <div class="manage_loop" id="swiper_manage_loop0">
                                        <ul>
                                            <li>1. 官方源码有保证</li>
                                            <li>2. 源码质量优</li>
                                            <li>3. 24小时专业技术支持</li>
                                        </ul>
                        
                                    </div>
                                    <div class="proccess">
                                        <p class="proccess_tit">订单流程</p>
                                        <div class="proccess_con">
                                            <span>1.选择源码</span><span>2.下单购买</span><span>3.源码搭建</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
							</div>
                <!-- 结束 -->
                </div>
            </div> 
        </div>
        <!--大屏展示 结束-->
  <div class="index-scroll">
  <div class='main'>
  <div class="scrollbox">
  <div class="scrollico icons">
</div>
  <div class="scrollitit">最新交易：</div>
  <div id="scrollDiv" class="scroll-box" times='3000' items='1'>
  <ul>     
 <? $i=0;while1("*","yjcode_order where (ddzt='wait' or ddzt='db' or ddzt='suc') order by sj desc limit 20");while($row1=mysql_fetch_array($res1)){
 $mot=substr($row1[mot],0,3)."*****".substr($row1[mot],8,3);
 ?>
  <LI>
  <a href="product/view<?=returnproid($row1[probh])?>.html"  target="_blank" > <i class='red'>[<span class='green'><?=returnorderzt($row1[ddzt])?></span>]</i>
  <strong><?=mb_substr(returnnc($row1[userid]),0,2);?>***<?=mb_substr(returnnc($row1[userid]),-2,2);?></strong><em><?=$row1[money1]?> 元</em>购买了<span><?=returntitdian($row1[tit],50)?></span>
  </a>
  </LI>
  <? $i++;}?>
  </ul>
 </div>
  <div class="scrollac">
  <a title="向上" id="scroll-prev" action='prev'class='icons scroll-action'></a>
  <a title="向下" id="scroll-next" action='next' class='icons scroll-action'></a>
  </div>
</div>
  <div class="scroll-index">
  <div class='right'>
  <cite>成交<i><?=sprintf("%.0f",$inittjarr[3]+returnsum("money1*num","yjcode_order where ddzt<>'backsuc' and ddzt<>'close'"))?></i>元</cite>
  <cite>商品<i><?=$inittjarr[1]+returncount("yjcode_pro where zt=0 and ifxj=0")?></i> 个</cite>
  <cite>会员<i><?=$inittjarr[0]+returncount("yjcode_user")?></i>位</cite>
  <cite>商家<i><?=returncount("yjcode_user where shopzt=2")?></i>家</cite>
</div>
  <div class='right'>
   <em class='icons'></em>
   <span>本站指数：</span>
                    </div>
                </div>
            </div>
        </div>


    <!--头部-->
    <div class='main'>
        <div class='index-goods'>
            <div class='goods-sidebar' id="code">
                <h3>
                    <a href='/product/' target="_blank" title='查看更多源码' >
                        <i class='iconfont'>&#xe6e7;</i>
                        <p>源码</p>
                    </a>
                </h3>
                <cite class='sidebar-toggle'>
                    <a class='curr'>最新出售</a>
                    <a>推荐源码</a>
                </cite>
                <div class='shop'>
                    <i class='iconfont'>&#xe66d;</i>
                    <p>推荐<br>店铺</p>
                </div>
            </div>
   <div class='goods-box'>
     <div class='goods-main'>
	 
 <? 
 $i=1;
 while0("*","yjcode_pro where ifxj=0 and zt=0 order by lastsj desc limit 5");while($row=mysql_fetch_array($res)){
 $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
 $au="product/view".$row[id].".html";
 while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
 ?>
    <dl>
    <dt>
    <a href='<?=$au?>' class='goods-img' title='<?=$row[tit]?>'target="_blank"><img src='<?=returntp("bh='".$row[bh]."'","-1")?>'onerror="this.src='img/none180x180.gif'"></a>
    </dt>
    <dd>
    <a href='<?=$au?>' title='<?=$row[tit]?>' class='tit'target="_blank"><?=strgb2312($row[tit],0,20)?></a>
    <h2>￥<?=sprintf("%.2f",$money1)?></h2>
    <span>
	<img src='upload/<?=$row3[id]?>/shop.jpg'><a title='<?=strgb2312($row3[shopname],0,17)?>' href='shop/view<?=$row3[id]?>.html'target="_blank"><?=strgb2312($row3[shopname],0,8)?></a>
	</span>
    </dd>
    </dl>   
	<? $i++;}?>
	<div class="clear"></div>
 </div>
 <div class='goods-main hide'>
 <? 
 $i=1;
 while0("*","yjcode_pro where ifxj=0 and zt=0 and iftj!=0 order by iftj asc limit 5");while($row=mysql_fetch_array($res)){
 $money1=returnjgdian(returnyhmoney($row[yhxs],$row[money2],$row[money3],$sj,$row[yhsj1],$row[yhsj2],$row[id]));
 $au="product/view".$row[id].".html";
 while3("*","yjcode_user where id=".$row[userid]);$row3=mysql_fetch_array($res3);
 ?>
       <dl>
           <dt>
           <a href='<?=$row[tit]?>' class='goods-img' title='<?=$row[tit]?>'target="_blank"><img src='<?=returntp("bh='".$row[bh]."'","-1")?>'onerror="this.src='img/none180x180.gif'"></a>
           </dt>
           <dd>
           <a href='<?=$row[tit]?>' title='<?=$row[tit]?>' class='tit'target="_blank"><?=strgb2312($row[tit],0,20)?></a>
           <h2>￥<?=sprintf("%.2f",$money1)?></h2>
           <span>
		   <img src='upload/<?=$row3[id]?>/shop.jpg'><a title='<?=strgb2312($row3[shopname],0,17)?>' href='shop/view<?=$row3[id]?>.html' target="_blank"><?=strgb2312($row3[shopname],0,8)?></a>
		   </span>
           </dd>
           </dl>
           <? $i++;}?>
		   <div class="clear"></div>
                </div>
            </div>
            <div class='goods-shop'>
			 <? 
 while1("*","yjcode_user where zt=1 and shopzt=2 and shopname<>'' and pm>0 order by pm asc limit 10");while($row1=mysql_fetch_array($res1)){
 $sucnum=returnjgdw($row1[xinyong],"",returnxy($row1[id],1));
 $au=returnmyweb($row1[id],$row1[myweb]);
 ?>
             <dl>
             <dt>
             <a class="avatar" href="<?=$au?>" target="_blank"><img alt="" src="upload/<?=$row1[id]?>/shop.jpg"></a>
             <span class="info">
			<a href="<?=$au?>" target="_blank" class="name"title=""><?=$row1[shopname]?></a>
			<p><img class='xy' src='img/dj/<?=returnxytp($sucnum)?>' title='<?=$sucnum?>'></p>
			</span>
             </dt>
             <dd>
             <p>
			  <? 
 while2("*","yjcode_pro where userid=".$row1[id]." and zt=0 and ifxj=0 order by lastsj desc");if($row2=mysql_fetch_array($res2)){
 $money1=returnjgdian(returnyhmoney($row2[yhxs],$row2[money2],$row2[money3],$sj,$row2[yhsj1],$row2[yhsj2],$row2[id]));
 ?>
             <em>￥<?=sprintf("%.2f",$money1)?></em>
			 <a href="product/view<?=$row2[id]?>.html" target="_blank"title="<?=$row2[tit]?>"><?=$row2[tit]?></a>
             <? }?>
			</p>
             </dd>
             <strong>TA的源码<i>(<?=returncount("yjcode_pro where userid=".$row1[id]." and zt=0 and ifxj=0")?>)</i></strong>
			 </dl> 
			           
					 <? }?>			
						</div>
        </div>
        <div class='index-goods  index-goods-serve'>
            <div class='goods-sidebar sidebar-serve' id="serve">
                <h3>
                    <a href='/product/' target="_blank" title='查看更多服务'  >
                        <i class='iconfont'>&#xe8a9;</i>
                        <p>最新任务</p>
                    </a>
                </h3>
             
              
            </div>
  <div class='goods-box goods-task'>
  <div class='goods-task'>
 <?
 pagef($ses,6,"yjcode_task","order by sj desc");while($row=mysql_fetch_array($res)){taskok($row[id]);//获取商品商家信息
 while1("id,nc,shopname,xinyong,myweb,baomoney","yjcode_user where id=".$row['userid']);$row1=mysql_fetch_array($res1);
 ?>		
 <dl>
 <dt>
 <a href="/task/view<?=$row['id']?>.html" class='tit'  target="_blank" title="<?=strgb2312(strip_tags($row[txt]),0,60)?>">
 <em><? if($row['money1']==0){echo'@议价';}else{echo'￥'.$row['money1'];}?></em><?=strgb2312(strip_tags($row['txt']),0,60)?></a>
 <span>
 <img src="upload/<?=$row1['id']?>/user.jpg" onerror="this.src='/user/img/nonetx.gif'" />		
 <a><?=$row1['nc'];?></a>
 </span>
 </dt>
 <dd>
 <h3><?=strgb2312(strip_tags($row[txt]),0,200)?></h3>
 </dd>
 </dl>
 <? }?>			   
    <div class="clear"></div>
  </div>
 </div>
</div>
        <!--我是雇主-->
        <div class="epk-bar">

            <div class="steplinebox">
                <span class="f_l pl_20 font16"><b>如何解决您的需求？</b></span>
                <div class="stepline">
                    <span><span class="red mr_10">1</span> 联系卖家查看演示</span>
                    <span><span class="red mr_10">2</span>选择合作模式</span>
                    <span><span class="red mr_10">3</span>下单托管资金到知速</span>
                    <span><span class="red mr_10">4</span>获取代码发货地址</span>
                    <span style="background:none;"><span class="red mr_10">5</span>验收满意 确认付款</span>
                </div>
            </div> 
        </div>

       <div class="ipr-news">
            <div class="ipr-news-item">
                <div class="ipr-news-content">
                    <div class="title">
                          <span class="title-text">本站公告</span>
                        <a class="title-link" href="/help/" data-link="5909" target="_blank">
                            更多
                        </a>
                    </div>
		<ul class="index-blog-lubo-box">
		<? while1("*","yjcode_ad where adbh='ADN00' and zt=0 order by xh asc limit 1");while($row1=mysql_fetch_array($res1)){?>
        <div class="intro-image">
        <a href="<?=$row1[aurl]?>" data-link="38"target="_blank">
        <img class="lazy" src="../<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row1[bh]?>.<?=$row1[jpggif]?>" data-original="../<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row1[bh]?>.<?=$row1[jpggif]?>"style="display: inline;width:358px;height:auto;">
        </a>
        </div>	
		<? }?>
		<? while1("*","yjcode_news where zt=0 order by lastsj desc limit 1");while($row1=mysql_fetch_array($res1)){?>
		<div class="intro-text">
        <p class="intro-text-title">
        <a href="/news/txtlist_i<?=$row1[id]?>v.html" data-link="38"target="_blank"><?=$row1[tit]?></a>
        </p>
        <p class="intro-text-content">
        <a class="intro-text-info" href="/news/txtlist_i<?=$row1[id]?>v.html"data-link="38" target="_blank"><?=$row1[tit]?></a>
        <a class="intro-text-detail" href="/news/txtlist_i<?=$row1[id]?>v.html"data-link="38" target="_blank">【详情】</a>
        </p>
		<p class="intro-time"><?=$row1[sj]?></p>
        </div>
		<? }?>
      </div>
   </div>
            <div class="ipr-news-item">
                <div class="ipr-news-content">
                    <div class="title">
                        <span class="title-text">资讯新闻</span>
                        <a class="title-link" href="/news/" data-link="111"
                           target="_blank">
                            更多链接
                        </a>
                    </div>
        <div class="industry-news">
		<?while1("*","yjcode_news where zt=0 order by djl asc limit 1");while($row1=mysql_fetch_array($res1)){$tp="../".returntp("bh='".$row1[bh]."' order by xh asc","-1");?>
        <div class="industry-news-img">
        <a href="/news/txtlist_i<?=$row1[id]?>v.html" target="_blank">
		<? while1("*","yjcode_ad where adbh='ADN00' and zt=0 order by xh asc limit 1");while($row1=mysql_fetch_array($res1)){?>
        <img class="lazy"src="../<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row1[bh]?>.<?=$row1[jpggif]?>"data-original="../<?=returnjgdw($rowcontrol[addir],"","gg")?>/<?=$row1[bh]?>.<?=$row1[jpggif]?>"style="display: inline;">
		<?}?>
        </a>
        </div><? }?><?while1("*","yjcode_news where zt=0 order by djl desc limit 1");while($row1=mysql_fetch_array($res1)){$tp="../".returntp("bh='".$row1[bh]."' order by xh asc","-1");?>
        <div class="industry-news-text">
        <p class="industry-news-title">
        <a href="/news/txtlist_i<?=$row1[id]?>v.html" target="_blank"><?=$row1[tit]?></a>
        </p>
        <a class="industry-news-content" target="_blank"><?=$row1[tit]?></a>
        <a href="/news/txtlist_i<?=$row1[id]?>v.html" class="intro-text-detail"="_blank">【详情】</a>
        <p class="intro-time"><?=$row1[sj]?></p>
        </div>
	 <? }?>
   </div>
       <div class="industry-news-detail">
        <?while1("*","yjcode_news where zt=0 order by djl desc limit 4");while($row1=mysql_fetch_array($res1)){$tp="../".returntp("bh='".$row1[bh]."' order by xh asc","-1");?>                                                                                                                                      <p>
        <a href="/news/txtlist_i<?=$row1[id]?>v.html" data-link="5915"target="_blank">【<?=strgb2312(strip_tags($row1[tit]),0,20)?></a>
        <span class="fl_r"><?=$row1[sj]?></span>
        </p>
        <? }?>                                              
       </div>
     </div>
 </div>
            <div class="startop">
                    <div class="startop_tit">
                        <span class="select" style="margin-left:90px;">赚钱</span>
                        <span class="">诚信</span>
                        <span class="">信用</span>
                    </div>
                    <div class="blk10"></div>
                    <div class="startop_box">
                        <ul style="display: block;">
               <? 
              $i=1;while1("*","yjcode_user where shopname<>'' and shopzt=2 and zt=1 order by sellmyue desc limit 5");if($row1=mysql_fetch_array($res1)){
              $au=returnmyweb($row1[id],$row1[myweb]);
               ?>
               <li>
                        <em>

                        <img src="upload/<?=$row1[id]?>/shop.jpg" class=" " onerror="javascript:this.src='/user/img/nonetx.gif';" width="30" height="30"> </a>
                        </em>
                        <span>
                        <p class="font16 font_yh"><?=strgb2312($row1[shopname],0,16)?> &nbsp;&nbsp;&nbsp;￥&nbsp;<?=$row1[sellmyue]?> </a> 
						</p>
						</span>
                        <samp>
                        <a href="<?=$au?>" target="_blank" class="button">进店铺</a>
                        </samp>
                         </li>
						  <? }?>
						 <? while($row1=mysql_fetch_array($res1)){$au=returnmyweb($row1[id],$row1[myweb]);?>
						  <li>
                        <em>
                        <img src="upload/<?=$row1[id]?>/shop.jpg" class=" " onerror="javascript:this.src='/user/img/nonetx.gif';" width="30" height="30"> 
                        </em>
                        <span>
                        <p class="font16 font_yh"><?=strgb2312($row1[shopname],0,16)?> &nbsp;&nbsp;&nbsp;￥&nbsp;<?=$row1[sellmyue]?> </p>
						</p>
				
						</span>
                        <samp>
                        <a href="<?=$au?>" target="_blank" class="button">进店铺</a>
                        </samp>
                         </li>
                        <? }?>
                        </ul>
						 <ul style="display:none">
                            <? $i=1;while1("*","yjcode_user where zt=1 and shopzt=2 and shopname<>'' order by baomoney desc limit 5");while($row1=mysql_fetch_array($res1)){?>
                            <li>
                                <em>
                                    <a href="<?=$au?>"rel="nofollow" target="_blank">
                                     <img src="upload/<?=$row1[id]?>/shop.jpg"class=" " onerror="javascript:this.src='/user/img/nonetx.gif';" width="30" height="30"> </a>
                                </em>
                                <span>
                                <p class="font16 font_yh">
                                   <a href="<?=$au?>"rel="nofollow" target="_blank"><?=strgb2312($row1[shopname],0,16)?> </a> 
								</p> 
                                   <p class="font14  font_yh">已交保证金：<font class="red">￥&nbsp;<?=$row1[baomoney]?> </font></p>
                               </span>
                                <samp>
                                    <a href="<?=$au?>" target="_blank" class="button">进店铺</a>
                                </samp>
                            </li>
                             <? }?>
                        </ul>
                        <ul style="display: none;">
                      <? $i=1;while1("*","yjcode_user where zt=1 and shopzt=2 and shopname<>'' order by xinyong desc limit 5");while($row1=mysql_fetch_array($res1)){?>
                            <li>
                                <em>
                                    <a href="<?=$au?>" rel="nofollow" target="_blank">
                                        <img src="upload/<?=$row1[id]?>/shop.jpg" uid="27" onerror="javascript:this.src='/user/img/nonetx.gif';" class=" " width="30" height="30"> </a>
                                </em>
                                <span>
                                <p class="font16 font_yh">
                                    <a href="<?=$au?>" rel="nofollow" target="_blank"><?=strgb2312($row1[shopname],0,16)?> </a> </p> <p class="font14 font_yh">信用值：<font class="red"><?=$row1[xinyong]?> </font>
                                </p>
                            </span>
                                <samp><a href="<?=$au?>" target="_blank" class="button">进店铺</a></samp>
                            </li>
                            <? }?> 
                            
                        </ul>
                       
                        <div class="clear"></div>
                    </div>
                </div>
        </div>
        <div class="index-news index-link">
            <h3 style='margin:0'>
                <div>
                    <span>友情链接</span>
                    <a target="_blank"href="http://wpa.qq.com/msgrd?v=3&uin=249294043&site=/&menu=yes">申请友链&gt;</a>
            </h3>
            <dl>
                <dt>
               </dt>
                <dd>
				 <? while0("*","yjcode_ad where adbh='ADI14' and zt=0 and type1='文字' order by xh asc");while($row=mysql_fetch_array($res)){?>			
	            <a href="<?=$row[aurl]?>" title="<?=$row[tit]?>" target="_blank"><?=$row[tit]?></a>
                <? }?>          
                </dd>
            </dl>
        </div>
    </div>
    <div class="right-btn-group">
        <ul class="btn-group">
            <li><a href="/user/" class="icon-2 login-a"><span>个人中心</span></a></li>
            <li class="sign-but"><a href="/user/qiandao.php" class="icon-4 login-a" rel="nofollow"><span>点击签到</span></a>
            </li>
            <li><a href="/user/newslx.php" class="icon-3 login-a"><span>我要投稿</span></a></li>
            <li><a href="/user/gdlx.php" class="icon-5" target="_blank"><span>意见反馈</span></a></li>
        </ul>
        <div class="show-wechat">
            <a href="/mt" class="icon-7"><span><img src="http://www.928vip.cn/static/img/qrcode.jpg"
                                                    width="137" height="137" alt="手机二维码"><em>公众号</em></span></a>
        </div>
        <div class="to-top">
            <a href="javascript:;" id="returnTop" class="icon-6" rel="nofollow"><span>返回顶部</span></a>
        </div>
    </div>
    <div class="wic_slogin cl" style="bottom: 0px; opacity: 1;" id="wic_slogin">
        <div class="wp">
            <div class="wic_slogin_info">现在加入我们，<a rel="nofollow" href="/reg/reg.php"
                                                    title="注册一个账号">注册一个账号</a> 或
            </div>
            <div class="wic_slogin_btn">
                <a rel="nofollow" href="/reg" class="head-service" title="账号登录">账号登录</a>
            </div>
            <span class="wic_slogin_line"></span>
            <div class="wic_slogin_qq">
			<i class="iconfont icon-qq" aria-hidden="true"></i><a href="/config/qq/oauth/index.php" target="_top" title="QQ帐号登录" rel="nofollow">QQ登录</a></div>
    
        </div> 
    </div>

        
<div class="bottom">
<div class="main">
		<div class="footer">
			<div class="footer-nav left">
			 
					<dl>
						<dt>买家指南</dt>
						<dd>
						 <p><a href="/help/view7.html" target="_blank" rel="nofollow">如何注册</a></p>
<p><a href="/help/view6.html" target="_blank" rel="nofollow">如何购买</a></p>
<p><a href="/help/search_j9v_k16v.html" target="_blank" rel="nofollow">搜索商品</a></p>
<p><a href="/help/view8.html" target="_blank" rel="nofollow">支付方式</a></p>
</dd>
</dl>

					<dl>
						<dt>卖家指南</dt>
						<dd>
						 <p><a href="/help/view3.html" target="_blank" rel="nofollow">如何出售</a></p>
<p><a href="/help/view15.html" target="_blank" rel="nofollow">收费标准</a></p>
<p><a href="/help/search_j10v_k20v.html" target="_blank" rel="nofollow">入驻签约</a></p>
</dd>
</dl>

					<dl>
						<dt>安全交易</dt>
						<dd>
						 <p><a href="/help/view13.html" target="_blank" rel="nofollow">钓鱼防骗</a></p>
<p><a href="/help/view14.html" target="_blank" rel="nofollow">预防盗号</a></p>
<p><a href="/help/search_j11v_k23v.html" target="_blank" rel="nofollow">谨防诈骗</a></p>
<p><a href="/help/view12.html" target="_blank" rel="nofollow">实名认证</a></p>
</dd>
</dl>

					<dl>
						<dt>常见问题</dt>
						<dd>
						 <p><a href="/help/view11.html" target="_blank" rel="nofollow">如何充值</a></p>
<p><a href="/help/view5.html" target="_blank" rel="nofollow">如何提现</a></p>
<p><a href="/help/view9.html" target="_blank" rel="nofollow">真假客服</a></p>
<p><a href="/help/view10.html" target="_blank" rel="nofollow">忘记密码</a></p>
</dd>
</dl>

					<dl>
						<dt>服务中心</dt>
						<dd>
						 <p><a href="/help/search_j13v_k29v.html" target="_blank" rel="nofollow">我要咨询</a></p>
<p><a href="/help/search_j13v_k30v.html" target="_blank" rel="nofollow">我要建议</a></p>
<p><a href="/help/view28.html" target="_blank" rel="nofollow">我要投诉</a></p>
<p><a href="/help/search_j13v_k32v.html" target="_blank" rel="nofollow">QQ客服</a></p>
</dd>
</dl>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 </div>
	<div class="footer-contact right">
	<dl class="left">
	<b>管理客服</b>											
	<p>Q Q：<a style='color: #007de4;'title="联系客服QQ" href="http://wpa.qq.com/msgrd?v=3&uin=249094043&site=/&menu=yes">249094043</a></p>
	<p>电话：18673809841</p>
	<p>邮箱：249094043@qq.com</p>
	<p>时间：24 x 7 周六日无休息</p>
	</dl>
	<span><img src="http://www.928vip.cn/static/img/qrcode.jpg" width="100" height="100" /></span>	
	<p>&nbsp;&nbsp;官方微信公众号</p>
	</div>
	</div>
		</div>
		<div class="footer-link">
				<div class="footer-link-a left">
					<p><a href="/help/aboutview2.html" target="_blank" rel="nofollow">关于我们</a>  
					<a href="/help/aboutview3.html" target="_blank" rel="nofollow">广告合作</a> 
					<a href="/help/aboutview4.html" target="_blank" rel="nofollow">联系我们</a> 
					<a href="/help/aboutview5.html" target="_blank" rel="nofollow">隐私条款</a> 
					<a href="/help/aboutview6.html" target="_blank" rel="nofollow" title=6>免责声明</a> <em>&nbsp;&nbsp;&nbsp; 2018-2019 知速源码网 版权所有！&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</em> </p>
					<cite>知速源码网 / 网站备案号：鲁ICP备17023700号-1 		 	|
				</div>
				<div class="footer-link-i right">
			
				</div>
			</div>
	</div>
    <script src="/js/swiper.min.js"></script>
    <script src="/js/bcat-theme.js"></script>
</body>
</html>
