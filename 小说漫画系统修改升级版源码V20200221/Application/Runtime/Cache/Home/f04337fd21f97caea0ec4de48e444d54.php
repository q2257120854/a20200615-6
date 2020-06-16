<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- saved from url=(0044)https://m.efucms.com/book/<?php echo U('Mh/book_cate');?> -->
<html data-dpr="1" style="font-size: 41.6px;"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>小说大全_小说分类检索_好看的小说 - <?php echo ($_CFG['site']['name']); ?></title>
    <meta name="keywords" content="<?php echo ($_CFG['site']['name']); ?>小说网,网络小说,小说阅读网,小说">
    <meta name="description" content="<?php echo ($_CFG['site']['name']); ?>小说网是广大书友最值得收藏的网络小说阅读网，<?php echo ($_CFG['site']['name']); ?>小说网站收录了当前最火热的网络小说，<?php echo ($_CFG['site']['name']); ?>小说网免费提供高质量的小说最新章节，是广大网络小说爱好者必备的小说阅读网。">
    <!-- 共用引入资源.开始 -->

    <script src="/Public/home/mhjs/stats.js" name="MTAH5" sid="500462993"></script>
    <meta name="viewport" content="designWidth=750,width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <!-- 防止加载lib.flexible加载的时候文字由大变小的闪烁 -->
    <style>html,body{font-size:12px;}</style>
    <!-- lib.flexible 移动端相对适应比例 必须在浏览器head类 -->
    <script type="text/javascript">
        !function (a, b) { function c() { var b = f.getBoundingClientRect().width; b / i > 540 && (b = 540 * i); var c = b / 10; f.style.fontSize = c + "px", k.rem = a.rem = c } var d, e = a.document, f = e.documentElement, g = e.querySelector('meta[name="viewport"]'), h = e.querySelector('meta[name="flexible"]'), i = 0, j = 0, k = b.flexible || (b.flexible = {}); if (g) {  var l = g.getAttribute("content").match(/initial\-scale=([\d\.]+)/); l && (j = parseFloat(l[1]), i = parseInt(1 / j)) } else if (h) { var m = h.getAttribute("content"); if (m) { var n = m.match(/initial\-dpr=([\d\.]+)/), o = m.match(/maximum\-dpr=([\d\.]+)/); n && (i = parseFloat(n[1]), j = parseFloat((1 / i).toFixed(2))), o && (i = parseFloat(o[1]), j = parseFloat((1 / i).toFixed(2))) } } if (!i && !j) { var p = (a.navigator.appVersion.match(/android/gi), a.navigator.appVersion.match(/iphone/gi)), q = a.devicePixelRatio; i = p ? q >= 3 && (!i || i >= 3) ? 3 : q >= 2 && (!i || i >= 2) ? 2 : 1 : 1, j = 1 / i } if (f.setAttribute("data-dpr", i), !g) if (g = e.createElement("meta"), g.setAttribute("name", "viewport"), g.setAttribute("content", "initial-scale=" + 1 + ", maximum-scale=" + 1 + ", minimum-scale=" + 1 + ", user-scalable=no"), f.firstElementChild) f.firstElementChild.appendChild(g); else { var r = e.createElement("div"); r.appendChild(g), e.write(r.innerHTML) } a.addEventListener("resize", function () { clearTimeout(d), d = setTimeout(c, 300) }, !1), a.addEventListener("pageshow", function (a) { a.persisted && (clearTimeout(d), d = setTimeout(c, 300)) }, !1), "complete" === e.readyState ? e.body.style.fontSize = 12 * i + "px" : e.addEventListener("DOMContentLoaded", function () { e.body.style.fontSize = 12 * i + "px" }, !1), c(), k.dpr = a.dpr = i, k.refreshRem = c, k.rem2px = function (a) { var b = parseFloat(a) * this.rem; return "string" == typeof a && a.match(/rem$/) && (b += "px"), b }, k.px2rem = function (a) { var b = parseFloat(a) / this.rem; return "string" == typeof a && a.match(/px$/) && (b += "rem"), b } }(window, window.lib || (window.lib = {}));
    </script>
    <link rel="stylesheet" type="text/css" href="/Public/home/mhcss/style.min.css">
    <script type="text/javascript" src="/Public/home/mhjs/fundebug.0.1.7.min.js" apikey="ba3a0e0d938e92b44f279067dffb8d071ee87fc35eb75918b7a900e8581a955d"></script>
    <script type="text/javascript" src="/Public/home/mhjs/jquery.js"></script>
    <!-- 共用引入资源.结束 -->
    <script type="text/javascript" src="/Public/home/mhjs/saved_resource"></script>
</head>
<body style="font-size: 12px;">
<div class="navbar flt" id="bookcate">
    <nav class="tab-box">
        <div class="item">
            <a href="<?php echo U('index');?>">首页</a>
        </div>
        <div class="item">
            <a href="<?php echo U('book_cate');?>" class="active">分类</a>
        </div>
    </nav>
    <div class="action">
        <a href="<?php echo U('load_search');?>" class="btn">
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
            <path d="M35.94 35.94l7.71 7.71" fill="none" stroke="#fff" stroke-width="3"></path>
            <circle cx="23.3" cy="23.3" r="18.5" fill="none" stroke="#fff" stroke-width="3"></circle>
            <path d="M11.72 23.15A12 12 0 0 1 24.5 12" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="3"></path></svg>
        </a>
    </div>
</div>

<nav class="nav-row-cate mt-navbar">
    <div class="shrink collect-box condition-box" style="display: none;">
        <div class="row container close-type">
            <div class="item"><a href="javascript:;" type="tid" val="0" class="active" id="close-all">全部</a></div>
            <div class="item"><a href="javascript:;" type="tid" val="1" id="close-8">总裁</a></div>
            <div class="item"><a href="javascript:;" type="tid" val="2" id="close-12">穿越</a></div>
            <div class="item"><a href="javascript:;" type="tid" val="3" id="close-1">校园</a></div>
            <div class="item"><a href="javascript:;" type="tid" val="4" id="close-11">恐怖</a></div>
        </div>
    </div>
    <div class="shrink open-box condition-box" style="display: block;">
        <div class="row has-label">
            <label class="label"><span>分类</span></label>
            <div class="container open-type">
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=0" type="tid" val="0" <?php if($cateid == 0): ?>class="active"<?php endif; ?> id="open-all">全部</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=1" type="tid" val="1" <?php if($cateid == 1): ?>class="active"<?php endif; ?> id="open-1">科幻</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=2" type="tid" val="2" <?php if($cateid == 2): ?>class="active"<?php endif; ?> id="open-2">竞技</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=3" type="tid" val="3" <?php if($cateid == 3): ?>class="active"<?php endif; ?> id="open-3">武侠</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=4" type="tid" val="4" <?php if($cateid == 4): ?>class="active"<?php endif; ?> id="open-4">玄幻</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=5" type="tid" val="5" <?php if($cateid == 5): ?>class="active"<?php endif; ?> id="open-5">历史</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=6" type="tid" val="6" <?php if($cateid == 6): ?>class="active"<?php endif; ?> id="open-6">悬疑</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=7" type="tid" val="7" <?php if($cateid == 7): ?>class="active"<?php endif; ?> id="open-7">都市</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=8" type="tid" val="8" <?php if($cateid == 8): ?>class="active"<?php endif; ?> id="open-8">校园</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=9" type="tid" val="9" <?php if($cateid == 9): ?>class="active"<?php endif; ?> id="open-9">现代</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=10" type="tid" val="10" <?php if($cateid == 10): ?>class="active"<?php endif; ?> id="open-10">穿越</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&cateid=11" type="tid" val="11" <?php if($cateid == 11): ?>class="active"<?php endif; ?> id="open-11">言情</a></div>
            </div>
        </div>
        <div class="row has-label">
            <label class="label"><span>状态</span></label>
            <div class="container">
                <div class="item"><a href="<?php echo ($selfurl); ?>&status=0" type="end" val="0" <?php if($status == 0): ?>class="active"<?php endif; ?> >全部</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&status=1" type="end" val="1" <?php if($status == 1): ?>class="active"<?php endif; ?> >连载</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&status=2" type="end" val="2" <?php if($status == 2): ?>class="active"<?php endif; ?> >完结</a></div>
            </div>
        </div>
        <div class="row has-label">
            <label class="label"><span>属性</span></label>
            <div class="container">
                <div class="item"><a href="<?php echo ($selfurl); ?>&free_type=0" type="vip" val="0" <?php if($free_type == 0): ?>class="active"<?php endif; ?> >全部</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&free_type=1" type="vip" val="1" <?php if($free_type == 1): ?>class="active"<?php endif; ?> >免费</a></div>
                <div class="item"><a href="<?php echo ($selfurl); ?>&free_type=2" type="vip" val="2" <?php if($free_type == 2): ?>class="active"<?php endif; ?> >付费</a></div>
            </div>
        </div>
    </div>
    <div class="action">
        <a href="javascript:void(0);" class="opened"><span class="text">收起</span><i class="icon-arrow"></i></a>
    </div>
</nav>


<div class="books-list mt-10 mb-tabar" id="html_box">
    <!-- <div class="item"> <a href="https://m.efucms.com/book/10058/"> 
    <div class="cover"> <img width="160" height="90" href="/Public/home/mhimages/5a2226c231e1e.jpg"> </div> 
    <div class="body"> <div class="title">我在殡仪馆工作的那些事儿</div> <div class="text">他脱了殡仪馆女尸的衣服，当礼送人</div> 
    <div class="bottom"> 
    <span class="col"><i class="icon-gray-hot"></i> 225.2万</span> 
    <span class="col"><i class="icon-hand"></i> 2万</span> </div> </div> </a> 
    </div> -->
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><div class="item"> 
    <a href="<?php echo U('Book/bookinfo');?>&bid=<?php echo ($vo["id"]); ?>"> 
    <div class="cover"> <img width="160" height="90" src="<?php echo ($vo["cover_pic"]); ?>"> </div> 
    <div class="body"> <div class="title"><?php echo ($vo["title"]); ?></div> 
    <div class="text"><?php echo (mb_substr($vo["summary"],0,20)); ?></div> 
    <div class="bottom"> 
    <span class="col"><i class="icon-gray-hot"></i><?php echo ($vo["reader"]); ?></span> 
    <span class="col"><i class="icon-hand"></i><?php echo ($vo["likes"]); ?></span> 
    </div></div>
    </a>
    </div><?php endforeach; endif; else: echo "" ;endif; ?>
</div>


<div class="tabar flb">
    <nav class="nav hls1">
       <!--  <div class="item">
            <a href="<?php echo U('Mh/video');?>">
                <i class="icon-book"></i><div class="title">必看视频</div>
            </a>
        </div> -->
        <div class="item">
            <a href="<?php echo U('Mh/book_shelf');?>">
                <i class="icon-book"></i><div class="title">书架</div>
            </a>
        </div>
        <div class="item">
            <a href="<?php echo U('Mh/index');?>" class="active">
                <i class="icon-home"></i><div class="title">首页</div>
            </a>
        </div>
        <div class="item">
            <a href="<?php echo U('Mh/my');?>">
                <i class="icon-user"></i><div class="title">我的</div>
            </a>
        </div>
    </nav>
</div>
<div class="backtop" id="icon-top" style="display:none;">
    <a href="javascript:void(0);" class="top">顶部</a>
</div>
<script id="itemTpl" type="text/html">
    {{# for(var i = 0, len = d.length; i < len; i++){ }}
    <div class="item">
        <a href="/book/{{ d[i].id }}/">
            <div class="cover">
                <img width="160" height="90" src="{{ d[i].book_horizontal }}" />
            </div>
            <div class="body">
                <div class="title">{{ d[i].book_name }}</div>
                <div class="text">{{ d[i].short_title }}</div>
                <div class="bottom">
                    <span class="col"><i class="icon-gray-hot"></i> {{=formatTjNumber(d[i].read_cnt) }}</span>
                    <span class="col"><i class="icon-hand"></i> {{=formatTjNumber(d[i].like_cnt) }}</span>
                </div>
            </div>
        </a>
    </div>
    {{# } }}
</script>
<script>
    var p = 1;
    var tid = "all";
    var vip = "all";
    var end = "all";
    $(document).ready(function() {
        $('.nav-row-cate > .action a').click(function(e) {
            var collect = $('.collect-box');
            var open = $('.open-box');
            var self = $(this);
            if (self.hasClass('opened')) {
                open.hide();
                collect.show();
                self.find('.text').text('展开');
                self.removeClass('opened');

                var type_id =  $('.open-type .active').attr('val');
                $(".close-type div a").removeClass('active');
                $('#close-'+type_id).addClass('active');
                return
            }
            var type_id =  $('.close-type .active').attr('val');
            if($("#open-"+type_id).length>0){
                $(".open-type div a").removeClass('active');
            }
            $('#open-'+type_id).addClass('active');
            collect.hide();
            open.show();
            self.find('.text').text('收起');
            self.addClass('opened')
        });

        // 滚动到底部获取新的分页
        var url = "index.php?m=Home&c=Mh&a=ajax_book_cate_list";
        var data = {tid:tid,vip:vip,end:end,p:p};
        if(p == 1){
            get_page_data(url,data);
        }
        list_page(url,data);
        // 选择分类显示
        $(".condition-box .container div a").click(function(){
            var p_entry = $(this).parents('.container');
            p_entry.find("div a").removeClass("active");
            $(this).addClass("active");
            var c_type = $(this).attr('type');
            var c_val = $(this).attr('val');
            if(c_type == 'tid'){
                tid = c_val;
            }
            if(c_type == 'vip'){
                vip = c_val;
            }
            if(c_type == 'end'){
                end = c_val;
            }
            p = 1;
            $("#html_box").empty();
            data['p'] = p;
            data['end'] = end;
            data['vip'] = vip;
            data['tid'] = tid;
            //window.console&&console.log(data);
            get_page_data(url,data);
        });
    })
</script>
<!-- 统计 -->
<script type="text/javascript" src="/Public/home/mhjs/gcoupon.min.js"></script>
<script type="text/javascript">
    function addLoadEvent(func){
        if (typeof window.addEventListener != "undefined") {
            window.addEventListener("load",func,false);
        } else {
            window.attachEvent("onload",func) ;
        }
    }
    function tj_getcookie(name){
        var nameValue = "";
        var arr, reg = new RegExp("(^| )" + name + "=([^;]*)(;|$)");
        if (arr = document.cookie.match(reg)) {
            nameValue = decodeURI(arr[2]);
        }
        return nameValue;
    }
    function getQueryString(name){
        var reg = new RegExp("(^|&)"+name+"=([^&]*)(&|$)","i");
        var r = window.location.search.substr(1).match(reg);
        if (r!=null) return unescape(r[2]); return null;
    }
    addLoadEvent(function(){
        var error_img = new Image(),channel=tj_getcookie('qrmh_channel'),channel_type=tj_getcookie('qrmh_channel_type');
        error_img.onerror=null;
        error_img.src="//www.aikenwu.com/stats/?c="+channel+"&ct="+channel_type+"&rnd="+(+new Date);
        error_img=null;
        //某些地方页面缓存-检测
        var p_img =new Image(), p_userid = parseInt("5414066"),c_auth=tj_getcookie('qrmh_auth'),p_reload = getQueryString('p_reload');
        if(p_userid>0&&c_auth==''){
            if(p_reload==null){
                var url = window.location.href;
                //刷新一次页面
                window.location.href=url.indexOf("?")>0?(url+'&p_reload=1&reload_time='+(+new Date)):(url+'?p_reload=1&reload_time='+(+new Date));
            }else{
                //还是出现这个问题的话，就记录下来
                p_img.onerror=null;
                p_img.src="//www.aikenwu.com/page_stats/?p_userid="+p_userid+"&rnd="+(+new Date);
            }
        }
        p_img=p_userid=c_auth=p_reload=null;
    });
    //update byefucms 20170906 某些手机系统下，旋转屏幕出现页面混乱问题，通过延时500ms滚动页面1个单位得以恢复正常
    var evt = "onorientationchange" in window ? "orientationchange" : "resize";
    window.addEventListener(evt, function() {
        setTimeout(function(){
            window.scrollTo(0, window.pageYOffset+1);
        },500);
    }, false);
</script>
<!-- 统计 -->
<!-- 第三方qq统计 -->
<!-- <script type="text/javascript">
    var _mtac = {};
    (function() {
        setTimeout(function(){
            var mta = document.createElement("script");
            mta.src = (("https:" == document.location.protocol) ? "https://" : "http://")+"pingjs.qq.com/h5/stats.js?v2.0.4";
            mta.setAttribute("name", "MTAH5");
            mta.setAttribute("sid", "500462993");
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(mta, s);
        },888);
    })();
</script> -->
<!-- 第三方qq统计 -->

</body></html>