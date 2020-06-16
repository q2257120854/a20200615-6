	// 显示隐藏层
	function xiansxz(){
		$(".fxied").show();
		$(".tupscnr").show();
	}
	// 显示隐藏层
	function guanbxz(){
		$(".fxied").hide();
		$(".tupscnr").hide();
	}
	// 选择操作
	function xuanz(me){
		var xz = $(me).find("input[class='xuanz']").val();
		if(xz==0){
			var str = "<div class='xzd_b'></div><div class='xzd'></div>";
			var val = $(me).find("input[class='imgurl']").val();
			$(me).append(str);
			xuanarr.push(val);
			$(me).find("input[class='xuanz']").val(1);
		}

		if(xz==1){
			$(me).find("div[class='xzd_b']").remove();
			$(me).find("div[class='xzd']").remove();
			var val = $(me).find("input[class='imgurl']").val();
            xuanarr=removearr(val);
			$(me).find("input[class='xuanz']").val(0);
		}
	}

    //删除具体操作
    function removearr(val) {
        var index = phparr.indexOf(val);
        if (index > -1) {
            phparr.splice(index, 1);
        }
        return phparr;
    };

    // 确定选择操作
    function quimgs(){
    	phparr.push.apply(phparr,xuanarr);  
        xuanarr = new Array(); //清空选中数组
        var xianzym = $(".xiapd");
        for(var i=0; i<xianzym.length; i++){
            $(xianzym[i]).find("div[class='xzd_b']").remove();
            $(xianzym[i]).find("div[class='xzd']").remove();
            $(xianzym[i]).find("input[class='xuanz']").val(0);
        }
    	$("#imgtext").val(phparr);
    	var str = "";
    	for(var i=0; i<phparr.length; i++){
    		str+=	"<div class='paiwei' onmousemove='xians(this)' onmouseout='gb(this)'>"+
    		"<img src='"+phparr[i]+"' style='width: 140px; height:90px;'>"+
    		"<div class='beijingys'>"+
                "<input type='hidden' val='"+phparr[i]+"'>"+
    		"</div>"+
    		"<div class='sancann'>"+
    		"<span class='cancel' onclick='del(this)'>删除"+
            "<input type='hidden' value='"+phparr[i]+"'>"+
    		"</span>"+
    		"</div>"+
    		"</div>";
    	}
    	$("#imgzs").html(str);
    	$(".fxied").hide();
    	$(".tupscnr").hide();
    }
    //删除照片操作
    function del(me){
    	var val = $(me).find("input[type='hidden']").val();
    	if(confirm('你确定要删除这张图片嘛?')){
            phparr=removearr(val);
    	}

        console.log(phparr);

    	var str = "";
    	for(var i=0; i<phparr.length; i++){
    		str+=	"<div class='paiwei' onmousemove='xians(this)' onmouseout='gb(this)'>"+
    		"<img src='"+phparr[i]+"' style='width: 140px; height:90px;'>"+
    		"<div class='beijingys'>"+
    		"</div>"+
    		"<div class='sancann'>"+
    		"<span class='cancel' onclick='del(this)'>删除"+
    			"<input type='hidden' value='"+phparr[i]+"'>"+
    		"</span>"+
    		"</div>"+
    		"</div>";
    	}
    	$("#imgzs").html(str);

    }
	//进入图片操作
	function xians(me){
		var b = $(me).find("div[class='beijingys']");
		var s = $(me).find("div[class='sancann']");
		$(b).show();
		$(s).show();
	}
	//离开图片操作
	function gb(me){
		var b = $(me).find("div[class='beijingys']");
		var s = $(me).find("div[class='sancann']");
		$(b).hide();
		$(s).hide();
	}


    