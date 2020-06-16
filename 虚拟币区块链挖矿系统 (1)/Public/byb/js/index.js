$(function(){
	var $drag = $('.dragBtn'),
		$drop = $('.dropBox'),
		$mask = $('.dropMask'),
		speed = 300,
		state = false,
		iniX,iniY,posX,posY,winX = $(window).width(),winY = $(window).height();
	$(window).resize(function(){
		winX = $(window).width();
		winY = $(window).height();
	});
	var onClick = function(obj){
		switch(obj){
			case 'on':
				$drag.hide();
				$drop.css({'width':50,'height':50,'right':'auto','left':posX,'top':posY}).show().animate({width:300,height:300,left:winX/2-150,top:winY/2-150},speed,function(){state = true;$drop.find('.dropList').show();$mask.show()}) 
			break;
			case 'off':
				state = false;
				$drop.find('.dropList').hide()
				$mask.hide();
				$drop.css('right','auto').animate({width:50,height:50,left:posX,top:posY},speed,function(){$drop.hide();$drag.show();}) 
			break;
		}
	};
	$('.dropBox,.dragBtn,.dropMask').on('touchmove',
	function(e) {
		e.stopPropagation();
		e.preventDefault();
	});
	$drop.find('.dropSkin').on('touchend',function(){
		if(state)onClick('off');
	}); 	
	$mask.on('touchend',function(){
		if(state)onClick('off');
	}); 	
	$drag.draggable({
		cursor:'auto',
		onStartDrag:function(){
			$drag.css('right','auto');
			iniX = $(this).offset().left;
			iniY = $(this).offset().top;
		},
		onDrag:function(e){
			var d = e.data;
			if (d.left < 0){d.left = 0}
			if (d.top < 0){d.top = 0}
			if (d.left + $(d.target).outerWidth() > winX){
				d.left = winX - $(d.target).outerWidth();
			}
			if (d.top + $(d.target).outerHeight() > winY){
				d.top = winY - $(d.target).outerHeight();
			}
			posX = $(this).offset().left;
			posY = $(this).offset().top;
		},
		onStopDrag:function(){
			$drag.css('position','fixed')
			var x = posX < winX/2 ? posX : winX - posX - $drag.width();
			var y = posY < winY/2 ? posY : winY - posY - $drag.height();
			if(x < y){
				if(posX < winX/2){
					$drag.animate({left:0},speed);
				}else{
					$drag.animate({left:winX - $drag.width()},speed);
				}
			}else{
				if(posY < winY/2){
					$drag.animate({top:0},speed);
				}else{
					$drag.animate({top:winY - $drag.height()},speed);
				}
			}
			if(posX == iniX && posY == iniY){
				onClick('on');
			}
		}
	});
});