var MOBANTU = {
	paged: 1,
	lazy: 0,
	ias: 0,
	water: 0,
	body: jQuery("body"),
	init: function(obj){
		var that = this;
		that.lazy = obj.lazy;
		that.ias = obj.ias;
		that.water = obj.water;
		if(that.body.hasClass('page-template-waterfall')) that.water=1;
		that.other();
		that.scroll();
		if(that.lazy && !that.water) that.lazyload();
		if(that.ias) that.iasLoad();
		that.erphpBox();
		that.share();
		if(!that.body.hasClass("logged-in"))
			that.login();
		if(that.body.hasClass("page-template-tougao"))
			that.tougao();
		that.catFilter();
		that.comment();
		that.sidebar();
		that.postZan();
		that.postCollect();
	},
	other: function(){
		var that = this;
		var bodyWidth = jQuery(window).width()

		jQuery(window).resize(function(event) {
		    bodyWidth = jQuery(window).width()
		});

		jQuery(".search-loader").click(function(){
			jQuery(".search-wrap").addClass('show');
			jQuery(".search-input").focus();
			jQuery(".search-wrap .dripicons").click(function(){
				jQuery(".search-wrap").removeClass('show');
			});
		});
		jQuery(".nav-loader").click(function(){
			jQuery(".nav-loader i").toggleClass('dripicons-cross').toggleClass('dripicons-dots-3');
			jQuery(".header").toggleClass('nav-mobile-show');
		});
		if(bodyWidth <= 768){
			jQuery(".menu-item-has-children > a").click(function(){
				jQuery(this).next('.sub-menu').toggleClass('show');
				return false;
			});
		}
		jQuery(".totop").click(function(){
			that.scrollTo();
		});

		jQuery(".tocomm").click(function(){
			that.scrollTo('#respond',-140);
		});

		jQuery(".article-content iframe, .article-content embed, .article-content object, .article-content video").each(function(){
		    jQuery(this).width("100%");
		    jQuery(this).height(jQuery(this).width()*9/16);
		});

		jQuery(window).resize(function (){
		    jQuery(".article-content iframe, .article-content embed, .article-content object, .article-content video").each(function(){
			    jQuery(this).height(jQuery(this).width()*9/16);
		    }); 
		});

	},
	tougao: function(){
		var that = this;
		jQuery("#start_down2").on("click",function(){
			jQuery(".tougao-item-erphpdown").show();
		});

		jQuery("#start_down1").on("click",function(){
			jQuery(".tougao-item-erphpdown").hide();
		});

		jQuery(".tougao-upload").click(function(){
			jQuery("#imageFile").trigger('click');
	        jQuery("#imageFile").change(function(){
	            jQuery("#imageForm").ajaxSubmit({
	                //dataType:  'json',
	                beforeSend: function() {
	                    
	                },
	                uploadProgress: function(event, position, total, percentComplete) {
	                    jQuery('#file-progress').text(percentComplete+'%');
	                },
	                success: function(data) {
	                    jQuery('#image').val(data);   
	                },
	                error:function(xhr){
	                    alert('上传失败！'); 
	                }
	            });
	        });
		});
	},
	sidebar: function(){
		var that = this;
		jQuery(function($){
			var _sidebar = $('.sidebar');
	        if (_sidebar) {
	            $('.theiaStickySidebar').theiaStickySidebar({"containerSelector":".content","additionalMarginTop":"90px"});
	        }
	    });
	},
	scroll: function(){
		jQuery(window).scroll(function() {
			document.documentElement.scrollTop + document.body.scrollTop > 79 ? jQuery('.header').addClass('scrolled') : jQuery('.header').removeClass('scrolled');
			document.documentElement.scrollTop + document.body.scrollTop > 150 ? jQuery('.rollbar').show() : jQuery('.rollbar').hide();
		});
	},
	lazyload: function(){
		var that = this;
		if(jQuery('.thumb:first').data('src') || jQuery('.home-blogs .thumb:first').data('src')){
			jQuery('.thumb').lazyload({
		          data_attribute: 'src',
		          placeholder: _MBT.uri + '/static/img/thumbnail.png',
		          threshold: 400
		    });
		    jQuery('.home-blogs .thumb').lazyload({
		          data_attribute: 'src',
		          placeholder: _MBT.uri + '/static/img/thumbnail.png',
		          threshold: 400
		    });
		}
	},
	iasLoad: function(){
		var that = this;
		if(jQuery('.pagination').length){
			if(that.water){
				if(jQuery(".posts").length){
					var grids = document.querySelector('.grids');
					imagesLoaded( grids, function() {
						
					    var msnry = new Masonry( grids, {
					      itemSelector: '.grid',
					      visibleStyle: { transform: 'translateY(0)', opacity: 1 },
	  					  hiddenStyle: { transform: 'translateY(100px)', opacity: 0 },
					    });

						jQuery.ias({
							triggerPageThreshold : 3,
							history              : false,
							container            : '.posts',
							item                 : '.post',
							pagination           : '.pagination',
							next                 : '.next-page a',
							loader               : '<img src="'+_MBT.uri+'/static/img/loader.gif">',
							trigger              : '加载更多',
							onLoadItems          : function(items){
								/* Theme by mobantu.com */
							},
							onRenderComplete     : function(items) {
								imagesLoaded( grids, function() {
								  msnry.appended( items );
								  jQuery('.grid').css({ opacity: 1 });
								});
								
							}
					    });
					    
					});
				}
			}else{
				if(jQuery(".posts").length){
					jQuery.ias({
						triggerPageThreshold : 3,
						history              : false,
						container            : '.posts',
						item                 : '.post',
						pagination           : '.pagination',
						next                 : '.next-page a',
						loader               : '<img src="'+_MBT.uri+'/static/img/loader.gif">',
						trigger              : '加载更多',
						onRenderComplete     : function(items) {
							if(that.lazy) that.lazyload();
						}
				    });
				}
			}

		}
	},
	erphpBox: function(){
		var that = this;
		jQuery('.erphp-box').click(function(){
			var href = jQuery(this).attr("href");
	        layer.open({
	            type: 1,
	            area: ['350px', '350px'],
	            title: '购买资源',
	            resize:false,
	            scrollbar: false,
	            content: '<div class="donate-box"><div class="qr-pay text-center"><iframe src="'+href+'" frameborder="0" width="350px" height="300px" /></div></div>'
	        });
	        return false;
		});
	},
	share: function(){
		var that = this;
        if(jQuery('.article-content img:first').length ){
            _MBT.shareimage = jQuery('.article-content img:first').attr('src')
        }  
		var share = {
	        url: document.URL,
	        pic: _MBT.shareimage,
	        title: document.title || '',
	        desc: jQuery('meta[name="description"]').length ? jQuery('meta[name="description"]').attr('content') : ''    
	    }
	    jQuery('.share-weixin').each(function(){
		    if( !jQuery(this).find('.share-popover').length ){
				jQuery(this).append('<span class="share-popover"><span class="share-popover-inner" id="weixin-qrcode"></span></span>');
				jQuery('#weixin-qrcode').qrcode({
					width: 80,
					height: 80,
					text: jQuery(this).data('url')
				});
			}
		})
		jQuery('.article-shares a').on('click', function(){
			var dom = jQuery(this);
		    var to = dom.data('share');
		    var url = '';
		    switch(to){
		        case 'qq':
		            url = 'http://connect.qq.com/widget/shareqq/index.html?url='+share.url+'&desc='+share.desc+'&summary='+share.title+'&site=zeshlife&pics='+share.pic;
		            break;
		        case 'weibo':
		            url = 'http://service.weibo.com/share/share.php?title='+share.title+'&url='+share.url+'&source=bookmark&pic='+share.pic;
		            break;
		        case 'douban':
		            url = 'http://www.douban.com/share/service?image='+share.pic+'&href='+share.url+'&name='+share.title+'&text='+share.desc;
		            break;
		        case 'qzone':
		            url = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+share.url+'&title='+share.title+'&desc='+share.desc;
		            break;
		        case 'tqq':
		            url = 'http://share.v.t.qq.com/index.php?c=share&a=index&url='+share.url+'&title='+share.title;
		            break;
		        case 'renren':
		            url = 'http://widget.renren.com/dialog/share?srcUrl='+share.pic+'&resourceUrl='+share.url+'&title='+share.title+'&description='+share.desc;
		            break;
		    }
		    if( !dom.attr('href') && !dom.attr('target') ){
		    	dom.attr('href', url).attr('target', '_blank');
		    }
		});
	},
	catFilter: function(){
		var that = this;

		jQuery('.mocat .child a').on('click',function(){
			var the = jQuery(this);
			var con = the.parent().parent().next();
			con.html('<div class="posts-loading" style="display:block"><img src="'+_MBT.uri+'/static/img/loader.gif"></div>');
			the.parent().parent().find('a').removeClass('active');
	        the.addClass('active');
			jQuery.ajax({
		        type: 'get',
		        url: _MBT.uri + '/action/mocat.php?c='+jQuery(this).data('c')+'&c2='+jQuery(this).data('c2')+'&num='+jQuery(this).data('num'),
		        success: function(data){
		           con.html(data);
		           if(that.lazy) that.lazyload();
		        }
		    });
		    return false;
		});

		jQuery('.cat-nav > li > a').on('click',function(){
			var next_url = jQuery(this).attr("href");
		    
	        jQuery('.cat-nav > li').removeClass('current-menu-item');
	        jQuery(this).parent().addClass('current-menu-item');
	        jQuery(".posts-loading").show();
	        jQuery("#posts, .pagination").hide();
	        jQuery(".pagination").html('');
	        jQuery(".pagination-trigger").remove();

		    jQuery.ajax({
		        type: 'get',
		        url: next_url + '#posts',
		        success: function(data){
		            posts = jQuery(data).find("#posts .post");
		            pagination = jQuery(data).find(".pagination ul");

		            next_link = jQuery(pagination).find(".next-page > a").attr("href");
		            if (next_link != undefined){
		                jQuery(".pagination").html(pagination.fadeIn(100));
		            }else{
		            	jQuery(".pagination").html('');
		            }
		            
	                if (next_url.indexOf("page") < 1) {
	                  jQuery("#posts").html('');
	                }
	                jQuery("#posts").append(posts.fadeIn(100));

	                if(that.lazy) that.lazyload();

	                if(that.ias){
		                that.iasLoad();
		            }else{
		            	jQuery(".pagination").show();
		            }
	                
                    jQuery(".posts-loading").hide();
                    jQuery("#posts").show();    
		            
		        }
		    });
		    return false;
		});
	},
	login: function(){
		var that = this;
		jQuery(function($){
			$('.signin-loader').on('click', function(){
				that.body.addClass('sign-show');
				if($('.sign .container').hasClass('has-social')){
					$('.sign .container').height("460px");
				}else{
					$('.sign .container').height("430px");
				}
				$('#sign-in').show().find('input:first').focus();
				$('#sign-up').hide();
				return false;
			});
			$('.signup-loader').on('click', function(){
				that.body.addClass('sign-show');
				if($('.sign .container').hasClass('has-social')){
					$('.sign .container').height("560px");
				}else{
					$('.sign .container').height("530px");
				}
				$('#sign-up').show().find('input:first').focus();
				$('#sign-in').hide();
			});
			$('.signclose-loader').on('click', function(){
				that.body.removeClass('sign-show');
			});
			$('.sign-mask').on('click', function(){
				that.body.removeClass('sign-show');
			});
			
			$('.signinsubmit-loader').on('click', function(){
				if( $("#user_login").val() == '' ){
					logtips('用户名不能为空')
					return
				}
				if( $("#user_pass").val() == '' ){
					logtips('密码不能为空')
					return
				}
				logtips("登录中，请稍等...");
				$('.signinsubmit-loader').attr("disabled",true);
				$.post(
					_MBT.uri+'/action/login.php',
					{
						log: $("#user_login").val(),
						pwd: $("#user_pass").val(),
						action: "mobantu_login",
					},
					function (data) {
						if ($.trim(data) != "1") {
							logtips("用户名或密码错误");
							$('.signinsubmit-loader').attr("disabled",false);
						}
						else {
							logtips("登录成功，跳转中...");
							location.reload();                     
						}
					}
				);
			});

			$('.signupsubmit-loader').on('click', function(){
				if( !is_name($("#user_register").val()) ){
					logtips('用户名只能由字母数字或下划线组成的3-16位字符')
					return
				}
				if( !is_mail($("#user_email").val()) ){
					logtips('邮箱格式错误')
					return
				}
				if( !$("#user_pass2").val() ){
					logtips('请输入密码')
					return
				}
	            logtips("注册中，请稍等...");
	            $('.signupsubmit-loader').attr("disabled",true);
	            $.post(
	            	_MBT.uri+'/action/login.php',
	            	{
	            		user_register: $("#user_register").val(),
	            		user_email: $("#user_email").val(),
	            		password: $("#user_pass2").val(),
	            		captcha: $("#captcha").val(),
					    action: "mobantu_register"
					},
					function (data) {
						if ($.trim(data) == "1") {
							logtips("注册成功，登录中...");
							location.reload(); 
						}else {
							logtips(data);
							$('.signupsubmit-loader').attr("disabled",false);
						}
					}
				);										   
	        });

	        $('.captcha-clk2').bind('click',function(){
				var captcha = _MBT.uri+'/action/captcha2.php?'+Math.random();
				$(this).attr('src',captcha);
			});

			

			$('.captcha-clk').bind('click',function(){

			if( !is_mail($("#user_email").val()) ){

				logtips('邮箱格式错误')

				return

			}

			

			var captcha = $(this);

			if(captcha.hasClass("disabled")){

				logtips('您操作太快了，等等吧')

			}else{

				captcha.addClass("disabled");

				captcha.html("发送中...");

				$.post(

					_MBT.uri+'/action/captcha.php?'+Math.random(),

					{

						action: "mobantu_captcha",

						email:$("#user_email").val()

					},

					function (data) {

						if($.trim(data) == "1"){

							logtips('已发送验证码至邮箱，可能会出现在垃圾箱里哦~')

							var countdown=60; 

							settime()

							function settime() { 

								if (countdown == 0) { 

									captcha.removeClass("disabled");   

									captcha.html("重新发送验证码");

									countdown = 60; 

									return;

								} else { 

									captcha.addClass("disabled");

									captcha.html("重新发送(" + countdown + ")"); 

									countdown--; 

								} 

								setTimeout(function() { settime() },1000) 

							}

							

						}else if($.trim(data) == "2"){

							logtips('邮箱已存在')

							captcha.html("发送验证码至邮箱");

							captcha.removeClass("disabled"); 

						}else{

							logtips('验证码发送失败，请稍后重试')

							captcha.html("发送验证码至邮箱");

							captcha.removeClass("disabled"); 

						}

					}

					);

			}

		});



			var _loginTipstimer

			function logtips(str){

				if( !str ) return false

					_loginTipstimer && clearTimeout(_loginTipstimer)

				$('.sign-tips').html(str).animate({

					height: 29

				}, 220)

				_loginTipstimer = setTimeout(function(){

					$('.sign-tips').animate({

						height: 0

					}, 220)

				}, 5000)

			}
		});
	},
	comment: function(){
		var that = this;
		jQuery(function($){
			$('.commentlist .url').attr('target','_blank')

			$('.comment-user-change').on('click', function(){
				$('#comment-author-info').slideDown(300)
		    	$('#comment-author-info input:first').focus()
			})

			$('#addsmile').on("click", function(e) {
				$('.smile').toggleClass('open');
				$(document).one("click", function() {
					$('.smile').toggleClass('open');
				});
				e.stopPropagation();
				return false;
			});


		    var edit_mode = '0',
		        txt1 = '<div class="comt-tip comt-loading">评论提交中...</div>',
		        txt2 = '<div class="comt-tip comt-error">#</div>',
		        txt3 = '">',
		        cancel_edit = '取消编辑',
		        edit,
		        num = 1,
		        comm_array = [];
		    comm_array.push('');

		    $comments = $('#comments-title');
		    $cancel = $('#cancel-comment-reply-link');
		    cancel_text = $cancel.text();
		    $submit = $('#commentform #submit');
		    $submit.attr('disabled', false);
		    $('.comt-tips').append(txt1 + txt2);
		    $('.comt-loading').hide();
		    $('.comt-error').hide();
		    $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
		    $('#commentform').submit(function() {
		        $('.comt-loading').slideDown(300);
		        $submit.attr('disabled', true).fadeTo('slow', 0.5);
		        if (edit) $('#comment').after('<input type="text" name="edit_id" id="edit_id" value="' + edit + '" style="display:none;" />');
		        $.ajax({
		            url: _MBT.uri + '/action/comment.php',
		            data: $(this).serialize(),
		            type: $(this).attr('method'),
		            error: function(request) {
		                $('.comt-loading').slideUp(300);
		                $('.comt-error').slideDown(300).html(request.responseText);
		                setTimeout(function() {
		                        $submit.attr('disabled', false).fadeTo('slow', 1);
		                        $('.comt-error').slideUp(300)
		                    },
		                    3000)
		            },
		            success: function(data) {
		                $('.comt-loading').slideUp(300);
		                comm_array.push($('#comment').val());
		                $('textarea').each(function() {
		                    this.value = ''
		                });
		                var t = addComment,
		                    cancel = t.I('cancel-comment-reply-link'),
		                    temp = t.I('wp-temp-form-div'),
		                    respond = t.I(t.respondId),
		                    post = t.I('comment_post_ID').value,
		                    parent = t.I('comment_parent').value;
		                if (!edit && $comments.length) {
		                    n = parseInt($comments.text().match(/\d+/));
		                    $comments.text($comments.text().replace(n, n + 1))
		                }
		                new_htm = '" id="new_comm_' + num + '"></';
		                new_htm = (parent == '0') ? ('\n<ol style="clear:both;" class="commentlist commentnew' + new_htm + 'ol>') : ('\n<ul class="children' + new_htm + 'ul>');
		                ok_htm = '\n<span id="success_' + num + txt3;
		                ok_htm += '</span><span></span>\n';

		                if (parent == '0') {
		                    if ($('#postcomments .commentlist').length) {
		                        $('#postcomments .commentlist').before(new_htm);
		                    } else {
		                        $('#respond').after(new_htm);
		                    }
		                } else {
		                    $('#respond').after(new_htm);
		                }

		                $('#comment-author-info').slideUp()

		                // console.log( $('#new_comm_' + num) )
		                $('#new_comm_' + num).hide().append(data);
		                $('#new_comm_' + num + ' li').append(ok_htm);
		                $('#new_comm_' + num).fadeIn(1000);
		                /*$body.animate({
		                        scrollTop: $('#new_comm_' + num).offset().top - 200
		                    },
		                    500);*/
		                $('#new_comm_' + num).find('.comt-avatar .avatar').attr('src', $('.commentnew .avatar:last').attr('src'));
		                countdown();
		                num++;
		                edit = '';
		                $('*').remove('#edit_id');
		                cancel.style.display = 'none';
		                cancel.onclick = null;
		                t.I('comment_parent').value = '0';
		                if (temp && respond) {
		                    temp.parentNode.insertBefore(respond, temp);
		                    temp.parentNode.removeChild(temp)
		                }
		            }
		        });
		        return false
		    });
		    addComment = {
		        moveForm: function(commId, parentId, respondId, postId, num) {
		            var t = this,
		                div, comm = t.I(commId),
		                respond = t.I(respondId),
		                cancel = t.I('cancel-comment-reply-link'),
		                parent = t.I('comment_parent'),
		                post = t.I('comment_post_ID');
		            if (edit) exit_prev_edit();
		            num ? (t.I('comment').value = comm_array[num], edit = t.I('new_comm_' + num).innerHTML.match(/(comment-)(\d+)/)[2], $new_sucs = $('#success_' + num), $new_sucs.hide(), $new_comm = $('#new_comm_' + num), $new_comm.hide(), $cancel.text(cancel_edit)) : $cancel.text(cancel_text);
		            t.respondId = respondId;
		            postId = postId || false;
		            if (!t.I('wp-temp-form-div')) {
		                div = document.createElement('div');
		                div.id = 'wp-temp-form-div';
		                div.style.display = 'none';
		                respond.parentNode.insertBefore(div, respond)
		            }!comm ? (temp = t.I('wp-temp-form-div'), t.I('comment_parent').value = '0', temp.parentNode.insertBefore(respond, temp), temp.parentNode.removeChild(temp)) : comm.parentNode.insertBefore(respond, comm.nextSibling);
		            $body.animate({
		                    scrollTop: $('#respond').offset().top - 180
		                },
		                400);
		                // pcsheight()
		            if (post && postId) post.value = postId;
		            parent.value = parentId;
		            cancel.style.display = '';
		            cancel.onclick = function() {
		                if (edit) exit_prev_edit();
		                var t = addComment,
		                    temp = t.I('wp-temp-form-div'),
		                    respond = t.I(t.respondId);
		                t.I('comment_parent').value = '0';
		                if (temp && respond) {
		                    temp.parentNode.insertBefore(respond, temp);
		                    temp.parentNode.removeChild(temp)
		                }
		                this.style.display = 'none';
		                this.onclick = null;
		                return false
		            };
		            try {
		                t.I('comment').focus()
		            } catch (e) {}
		            return false
		        },
		        I: function(e) {
		            return document.getElementById(e)
		        }
		    };

		    function exit_prev_edit() {
		        $new_comm.show();
		        $new_sucs.show();
		        $('textarea').each(function() {
		            this.value = ''
		        });
		        edit = ''
		    }
		    var wait = 15,
		        submit_val = $submit.val();

		    function countdown() {
		        if (wait > 0) {
		            $submit.val(wait);
		            wait--;
		            setTimeout(countdown, 1000)
		        } else {
		            $submit.val(submit_val).attr('disabled', false).fadeTo('slow', 1);
		            wait = 15
		        }
		    }
		});
	},
	postZan: function(){
		//文章点赞
		jQuery('.article-zan').on('click', function() {
		  var vote_btn = jQuery(this);
		  if (vote_btn.hasClass('active')) {
		    return false;
		  }
		  var pid = vote_btn.data('id');
		  if (checkZan(pid)) {
		    alert("您已赞过！");
		    return false;
		  }
		  jQuery.ajax({
		       url: _MBT.uri+'/action/zan.php',
		       type: 'POST',
		       dataType: 'json', 
		       data: {
		         action:'post',
		         id:pid
		       },
		      success: function(data) {
		        if (data.result == '1') {
		          vote_btn.addClass('active').html('<i class="dripicons dripicons-thumbs-up"></i> <span>'+data.total+'</span>');
		          addZan(pid);
		        }   
		      }
		 });
		});

		function checkZan(pid){
		  zanIds=getCookie('zanIds')
		  if (zanIds!=null && zanIds!="")
		  {
		    comArr = zanIds.split(",");
		    for (i=0;i<comArr.length ;i++ ) 
		    { 
		      if (comArr[i] == pid) {
		        return true;
		      }
		    } 
		  }
		  return false;
		}

		function addZan(pid){
		  zanIds=getCookie('zanIds')
		  if (zanIds!=null && zanIds!="")
		  {
		    zanIds = zanIds+','+pid;
		    setCookie('zanIds', zanIds, 30);
		  }
		  else 
		  {
		    setCookie('zanIds', pid, 30);
		  }
		} 

		function setCookie(c_name,value,expiredays){
		  var exdate=new Date()
		  exdate.setDate(exdate.getDate()+expiredays)
		  document.cookie=c_name+ "=" +escape(value)+
		  ((expiredays==null) ? "" : ";expires="+exdate.toGMTString())
		}

		function getCookie(c_name){
			if (document.cookie.length>0){
			  c_start=document.cookie.indexOf(c_name + "=")
			  if (c_start!=-1){ 
				c_start=c_start + c_name.length+1 
				c_end=document.cookie.indexOf(";",c_start)
				if (c_end==-1) c_end=document.cookie.length
				return unescape(document.cookie.substring(c_start,c_end))
			  } 
			}
			return ""
		}
	},
	postCollect: function(){
		var that = this;
		jQuery('.article-collect').on('click', function() {
		  var vote_btn = jQuery(this);
		  var pid = vote_btn.data('id');
		  if (pid) {
		    jQuery.ajax({
		       url: _MBT.uri+'/action/collect.php',
		       type: 'POST',
		       dataType: 'json', 
		       data: {
		         id:pid
		       },
		      success: function(data) {
		        if (data.result == '1') {
		          vote_btn.addClass('active');
		        }else if (data.result == '2') {
		        	if(jQuery(".user-commentlist").length){
		        		location.reload();
		        	}
		            vote_btn.removeClass('active');
		        }    
		      }
		 	});
		  }
		  
		});
	},
	scrollTo: function(name='', add='', speed='') {
	    if (!speed) speed = 300
	    if (!name) {
	        jQuery('html,body').animate({
	            scrollTop: 0
	        }, speed)
	    } else {
	        if (jQuery(name).length > 0) {
	            jQuery('html,body').animate({
	                scrollTop: jQuery(name).offset().top + (add || 0)
	            }, speed)
	        }
	    }
	}
}


function is_name(str) {    
	return /^[\w]{3,16}$/.test(str) 
}
function is_mail(str) {
	return /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,4})$/.test(str)
}
function is_url(str) {
    return /^((http|https)\:\/\/)([a-z0-9-]{1,}.)?[a-z0-9-]{2,}.([a-z0-9-]{1,}.)?[a-z0-9]{2,}$/.test(str)
}
function grin(tag) {
    var myField;
    tag = ' ' + tag + ' ';
    if (document.getElementById('comment') && document.getElementById('comment').type == 'textarea') {
        myField = document.getElementById('comment');
    } else {
        return false;
    }
    if (document.selection) {
        myField.focus();
        sel = document.selection.createRange();
        sel.text = tag;
        myField.focus();
    }
    else if (myField.selectionStart || myField.selectionStart == '0') {
        var startPos = myField.selectionStart;
        var endPos = myField.selectionEnd;
        var cursorPos = endPos;
        myField.value = myField.value.substring(0, startPos)
                      + tag
                      + myField.value.substring(endPos, myField.value.length);
        cursorPos += tag.length;
        myField.focus();
        myField.selectionStart = cursorPos;
        myField.selectionEnd = cursorPos;
    }
    else {
        myField.value += tag;
        myField.focus();
    }
}