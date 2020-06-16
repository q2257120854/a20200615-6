<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:73:"D:\wwwroot\2.cnhjdy.net\public/../application/index\view\login\index.html";i:1575814737;}*/ ?>
<!DOCTYPE html>

<html>

	<head>

		<meta charset="utf-8" />

		<link rel="stylesheet" href="/css/new-index.css" />

		<script src="/js/jquery.min.js" type="text/javascript" charset="utf-8"></script>

		<script src="/js/new-index.js" type="text/javascript" charset="utf-8"></script>

		<title></title>

	</head>

	<body>

		<div class="login_bg">


			<div class="login_div">

				<div class="login_title">小程序运营管理系统</div>
	
				<form class="login_form" action="<?php echo Url('Login/dologin'); ?>" method="post" onsubmit = "return checkinfo();">

					<div class="login_user hbj">

						<img src="/image/user.png"/>

						<div class="login_line"></div>

						<input class="login_input flex1" type="text" name="username" id="username" value="" />

					</div>

					<div class="login_user hbj">

						<img src="/image/pwd.png"/>

						<div class="login_line"></div>

						<input class="login_input flex1" type="password" name="password" id="password" value="" />

					</div>

					<input class="login_submit" type="submit" value="登陆"/>

				</form>

			</div>

		</div>

	</body>

</html>

<script>

    function checkinfo(){



        var username = $("#username").val();

        var password = $("#password").val();



        if(!username){

            alert("用户名不能为空！");

            $("#username").focus();

            return false;

        }

        if(!password){

            alert("密码不能为空！");

            $("#password").focus();

            return false;

        }



    }

</script>