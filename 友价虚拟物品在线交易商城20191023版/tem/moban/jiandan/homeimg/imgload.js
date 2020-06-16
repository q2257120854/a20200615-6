(function( $ ){ 
$.fn.imglazyload = function( options ){ 
    var o = $.extend({ 
                attr        :   'lazy-src', 
                container   :   window, 
                event       :   'scroll', 
                fadeIn      :   false, 
                threshold   :   520, 
                vertical    :   true 
            }, options ), 
 
        event = o.event, 
        vertical = o.vertical, 
        container = $( o.container ), 
        threshold = o.threshold, 
        // 将jQuery对象转换成DOM数组便于操作 
        elems = $.makeArray( $(this) ), 
        dataName = 'imglazyload_offset', 
        OFFSET = vertical ? 'top' : 'left', 
        SCROLL = vertical ? 'scrollTop' : 'scrollLeft', 
        winSize = vertical ? container.height() : container.width(), 
        scrollCoord = container[ SCROLL ](), 
        docSize = winSize + scrollCoord; 
 
    // 延迟加载的触发器 
    var trigger = { 
 
        init : function( coord ){ 
            return coord >= scrollCoord && 
                            coord <= ( docSize + threshold ); 
        }, 
 
        scroll : function( coord ){ 
            var scrollCoord = container[ SCROLL ](); 
            return coord >= scrollCoord && 
                    coord <= ( winSize + scrollCoord + threshold ); 
        }, 
 
        resize : function( coord ){ 
            var scrollCoord = container[ SCROLL ](), 
                winSize = vertical ? 
                            container.height() : 
                            container.width(); 
            return coord >= scrollCoord && 
                   coord <= ( winSize + scrollCoord + threshold ); 
        } 
    }; 
 
    var loader = function( triggerElem, event ){ 
        var i = 0, 
            isCustom = false, 
            isTrigger, coord, elem, $elem, lazySrc; 
 
        // 自定义事件只要触发即可，无需再判断 
        if( event ){ 
            if( event !== 'scroll' && event !== 'resize' ){ 
                isCustom = true; 
            } 
        } 
        else{ 
            event = 'init'; 
        } 
 
        for( ; i < elems.length; i++ ){ 
            isTrigger = false; 
            elem = elems[i]; 
            $elem = $( elem ); 
            lazySrc = $elem.attr( o.attr ); 
 
            if( !lazySrc || elem.src === lazySrc ){ 
                continue; 
            } 
            // 先从缓存获取offset值，缓存中没有才获取计算值, 
            // 将计算值缓存，避免重复获取引起的reflow 
            coord = $elem.data( dataName ); 
 
            if( coord === undefined ){ 
                coord = $elem.offset()[ OFFSET ]; 
                $elem.data( dataName, coord ); 
            } 
 
            isTrigger = isCustom || trigger[ event ]( coord );           
 
            if( isTrigger ){ 
                // 加载图片 
                elem.src = lazySrc; 
                if( o.fadeIn ){ 
                    $elem.hide().fadeIn(); 
                } 
                // 移除缓存 
                $elem.removeData( dataName ); 
                // 从DOM数组中移除该DOM 
                elems.splice( i--, 1 ); 
            } 
        } 
 
        // 所有的图片加载完后卸载触发事件 
        if( !elems.length ){ 
            if( triggerElem ){ 
                triggerElem.unbind( event, fire ); 
            } 
            else{ 
                container.unbind( o.event, fire ); 
            } 
            $( window ).unbind( 'resize', fire ); 
            elems = null; 
        } 
 
    }; 
 
    var fire = function( e ){ 
        loader( $(this), e.type ); 
    }; 
 
    // 绑定事件 
    container = event === 'scroll' ? container : $( this ); 
    container.bind( event, fire ); 
    $( window ).bind( 'resize', fire ); 
 
    // 初始化 
    loader(); 
 
    return this; 
}; 
 
})( jQuery ); 