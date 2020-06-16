var path = $('#list_smallpic ul li:eq(0)').children(0).children(0).attr('src');
var new_path = path;
$('#xgalleryImg').attr('src',new_path);

$('#list_smallpic ul li').each(function(){
	$(this).click(function(){
		$('#list_smallpic ul li').removeAttr('class');
		$(this).attr('class','current');
		var url = $(this).children(0).children(0).attr('src');
		// var new_url = url.replace(/.\//,'/300_');
		$('#xgalleryImg').attr('src',url);
	});
})
