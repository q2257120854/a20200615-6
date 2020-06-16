//guoxun01@126.com
//实例化...................................
//$('.Homeslide').homeslide(home_slide_data);
;(function($) {
    //guoxun@staff.sina.com.cn
    $.fn.homeslide = function(data,auto,time) {
        var cur = 0;
        var self = $(this);   
        var length = data.length;
        var bigwrap = self.find('.Homeslide_bigwrap');
        //操控的dom
        var bigimg = self.find('.Homeslide_bigpicdiv a img');
        var biga = self.find('.Homeslide_bigpicdiv a');
        var thumb= self.find('.Homeslide_thumb ul');
        var li;
        //每次滚动宽度
        var thumb_w;
        var Timer;
        //初始化
        (function(){
            thumbcreate();
            bigto(0);
        })();
        //大图
        function bigto(n){
            bigwrap.stop().animate({'opacity':0.5}, 100,function(){
                if(n>=length) n = n-length;
                var dat = data[n];
                bigimg.attr('src', dat['image']);
                bigimg.attr('onclick', dat['onc']);
                //相关
                bigwrap.animate({'opacity':1}, 200);
            });
        }
        //生成缩略图
        function thumbcreate(){
            var html = "";
            var first = '';
            for (var i = 0; i < 2*length; i++) {
                first= (i==0)?'this':'';
                var j = i;
                if(j>=length) j = i-length;
                html+='<li class="'+first+'"><span class="Homeslide_angle"></span><img src="'+data[j]['thumb']+'"></li>';
            };
            thumb.html(html);
            //操控的dom
            thumb= self.find('.Homeslide_thumb ul');
            li = self.find('.Homeslide_thumb ul li');
            thumb_w = li.width();
            ang = self.find('.Homeslide_angle');
        }
        // 幻灯主函数
        function moveto(n){
            //大图
            bigto(n);
            //小图移动
            var left = -n*thumb_w;
            thumb.stop().animate({'left':left}, 350,function(){
                if(n>=length){
                    thumb.css('left', -(n-length)*thumb_w);
                    n=n-length;
                }
                cur=n;
                li.eq(n).addClass('this').siblings('li').removeClass('this');
            });
            //缩略图背景
            li.eq(n).addClass('this').siblings('li').removeClass('this');
        }

        thumb.delegate('li', 'click', function(event) {
            var index = $(this).index();
            moveto(index);
        });

        //左右键
        self.find('.Homeslide_hand1').click(function(event) {
            cur++;
            if(cur==2*length) cur=0;
            bigto(cur);
            moveto(cur);
        });
        self.find('.Homeslide_hand0').click(function(event) {
            if(cur==0){
                thumb.css('left', -length*thumb_w);
                cur=length;
            }
            cur--;
            bigto(cur);
            moveto(cur);
        });
        //自动播放
        if(auto){
            var tfuc = function(){ self.find('.Homeslide_hand1').click() };
            Timer= setInterval(tfuc,time);
            self.hover(function() {
                clearInterval(Timer);
            }, function() {
                Timer= setInterval(tfuc,time);
            });
        }
        return self;
    };
})(jQuery);