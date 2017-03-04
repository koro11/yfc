<?php
use yii\captcha\Captcha;
?>
<!DOCTYPE html>
<html>
	<head>
		<base href="/">
		<meta charset="utf-8">
		<title>用户注册</title>
		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/common.css" />
	</head>
	<?php use yii\helpers\Url;?>
	<body onload="document.forms[0].reset()">
		<div class="wrap login_wrap">
			<div class="content">
				
				<div class="logo"></div>
				
				<div class="login_box">	
					
					<div class="login_form">
						<div class="login_title">
							用户注册
						</div>
						<form action="<?=Url::to('register/user_register_do')?>" method="post">
							
							<div class="form_text_ipt">
								<input name="user_phone" type="text" placeholder="用户手机号" class="phone"><span id="phone" style="color:#f00;"></span>
							</div>
							<div class="ececk_warning"><span></span></div>

							<div class="form_text_ipt">
								<input name="user_password" type="password" placeholder="密码" class="password">
							</div>
							<div class="ececk_warning"><span></span></div>
							
							<div class="form_text_ipt">
								<input type="password" placeholder="再次输入密码" class="rpassword"><span id="rpwd" style="color:#f00;"></span>
							</div>
							<div class="ececk_warning"><span></span></div>
							<div class="form_btn">
								<button type="submit" style="margin-top:20px;">注册</button>
							</div>
						</form>
						<div class="other_login">
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.js" ></script>
		<script type="text/javascript" src="js/common.js" ></script>
	</body>
</html>
<script>
  	$('.phone').blur(function(){
		var phone = $('.phone').val();
  		var tel=/^1[3|5|7|8]\d{9}$/;//匹配手机号码
  		if(!tel.test(phone))
	    {
	      $('#phone').text('请输入正确的手机号码');
	    }
	    else
	    {
	    	$('#phone').text('');
	    }
  	});
  	$('.rpassword').blur(function(){
	  	var password = $('.password').val();
	  	var rpassword = $('.rpassword').val();
  		//alert(rpassword);
  		if(password!=rpassword)
	  	{
	  		$('#rpwd').text('两次输入不同!请重新输入！');
	  	}
	  	else
	  	{
	  		$('#rpwd').text('');
	  	}
	 });
  	$("form").submit(function(){
	    var phone = $('.phone').val();
	  	var password = $('.password').val();
	  	var rpassword = $('.rpassword').val();
	  	var phone_st = $('#phone').text();
  		var tel=/^1[3|5|7|8]\d{9}$/;//匹配手机号码
  		if(!tel.test(phone))
	    {
	    	return false;
	    }
	  	if(phone_st!="")
	  	{
	  		return false;
	  	}
	  	if(password!=rpassword)
	  	{
	  		return false;
	  	}
	  	if(phone=="")
	  	{
	  		return false;
	  	}
	  	if(password=="")
	  	{
	  		return false;
	  	}
	  	if(rpassword=="")
	  	{
	  		return false;
	  	}
	});
</script>