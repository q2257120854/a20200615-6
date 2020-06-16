// JavaScript Document
//初始化轮播组件
$(document).ready(function(){

    var mySwiper = new Swiper('.swiper-container',{
        pagination: '.pagination',
        paginationClickable: true,
        autoplay: 5000,	//自动轮播时间
        autoplayDisableOnInteraction: false,
        loop: true		//循环滚动
     });
	 
	//顶部菜单		
	$("#header-menu").on("click", function(e) {
		$(this).toggleClass('on');
		if ($(this).hasClass('on')) {
			$(".menu-card").animate({
				top: '45px'
			});
			$(this).removeClass('header-menu').addClass('header-del');
		} else {
			$(".menu-card").animate({
				top: '-240px'
			});
			$(this).removeClass('header-del').addClass('header-menu');
		}
	});
	
	 $("#header-menu").on("click", function(){
         if ($(this).hasClass('on')) {
              $("#menubg").show();
          }else {
              $("#menubg").css("display","none");
          }
      });

	$('#menubg').click(function() {
        $("#menubg").css("display","none");
		  $(".menu-card").animate({
				top: '-240px'
			});
		  $("#header-menu").removeClass('header-del').addClass('header-menu');
		  $("#header-menu").removeClass("on");
    });
	
	//文本框边框
	 $('.usesr-form').find('.txt').click(function(e) {
       /*     $(this).css({'border': '1px solid #0caffe','color': '#4a4a4a'});
        }).blur(function() {
            $(this).css({'border': '1px solid #D0D0D0',"color":"#4a4a4a"});*/
        });
		
	$('.c-allinvest').find('.c-txt').click(function(e) {
        /*    $(this).css({'border': '1px solid #0caffe','color': '#4a4a4a'});
        }).blur(function() {
            $(this).css({'border': '1px solid #D0D0D0',"color":"#4a4a4a"});*/
        });
		$(".tx-txt").click(function(e) {
/*            $(this).css({'border': '1px solid #0caffe','color': '#4a4a4a'});
        }).blur(function() {
            $(this).css({'border': '1px solid #D0D0D0',"color":"#4a4a4a"});*/
        });
		
	/* 2.0新增开始 */
		//canvas绘制进度条index--弧形圆
		(function(){
			//定义绘制类
			function DrawCanvas(dom, percent,color) {
				this.ctx = dom.getContext("2d");
				this.W = dom.width;
				this.H = dom.height;
				this.deg = 0;
				this.new_deg = parseInt(percent * (270/100));
				this.dif = 0;
				this.loop = null;
				this.text = '';
				this.text_w = '';
				this.init = function(W, H) {
					//底色线
					this.ctx.clearRect(0, 0, W, H);
					
					//动态线
					var r = this.deg*Math.PI/180;
					this.ctx.beginPath();
					this.ctx.strokeStyle = color;
					this.ctx.lineWidth = 3;			
					this.ctx.arc(W/2, H/2, 120, 135*Math.PI/180, r+135*Math.PI/180, false);
					this.ctx.lineCap = "round";
					this.ctx.stroke();

				}
				this.draw = function() {
					var me = this;
					me.dif = me.new_deg - me.deg;
					var to = function(){
						if (me.deg < me.new_deg) {
							me.deg++;
							me.init(me.W, me.H);
						} else {
							clearInterval(me.loop);
						}
					}
					me.loop = setInterval(to, 300/me.dif);
				}
				this.draw();
			}
			//初始化
			$(".main-che .cnt-canvasmsg").each(function(index, item){
				var percent = $(this).data('percent');
				var iColor = "#0caffa";
				new DrawCanvas(item, percent,iColor);	
			});
			$(".main-fang .cnt-canvasmsg").each(function(index, item){
				var percent = $(this).data('percent');
				var iColor = "#f1483c"; 
				new DrawCanvas(item, percent,iColor);	
			});
		})();


		/* 2.0新增开始 */
		//canvas绘制进度条债权详细页--弧形圆
		(function(){
			//定义绘制类
			function DrawCanvas(dom, percent) {
				this.ctx = dom.getContext("2d");
				this.W = dom.width;
				this.H = dom.height;
				this.deg = 0;
				this.new_deg = parseInt(percent * (270/100));
				this.dif = 0;
				this.loop = null;
				this.text = '';
				this.text_w = '';
				this.init = function(W, H) {
					//底色线
					this.ctx.clearRect(0, 0, W, H);
					
					//动态线
					var r = this.deg*Math.PI/180;
					this.ctx.beginPath();
					this.ctx.strokeStyle = "#ffffff";
					this.ctx.lineWidth = 3;			
					this.ctx.arc(W/2, H/2, 120, 135*Math.PI/180, r+135*Math.PI/180, false);
					this.ctx.lineCap = "round";
					this.ctx.stroke();

				}
				this.draw = function() {
					var me = this;
					me.dif = me.new_deg - me.deg;
					var to = function(){
						if (me.deg < me.new_deg) {
							me.deg++;
							me.init(me.W, me.H);
						} else {
							clearInterval(me.loop);
						}
					}
					me.loop = setInterval(to, 300/me.dif);
				}
				this.draw();
			}
			//初始化
			$(".c-cnt-canvasmsg").each(function(index, item){
				var percent = $(this).data('percent');
				new DrawCanvas(item, percent);	
			});
		})();
		/* 2.0新增结束 */

});