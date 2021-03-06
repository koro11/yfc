<!DOCTYPE html>
<html>
	<head>
		<base href="/">
		<meta charset="utf-8">
		<title>登录</title>
		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/common.css" />
	</head>
	<?php use yii\helpers\Url;?>
	<body>
		<div class="wrap login_wrap">
			<div class="content">
				
				<div class="logo"></div>
				
				<div class="login_box">	
					
					<div class="login_form">
						<div class="login_title">
							商家登录
						</div>
						<form action="<?=Url::to('login/mer_login_do')?>" method="post">
							
							<div class="form_text_ipt">
								<input name="mer_phone" type="text" placeholder="手机号" class="phone">
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>
							<div class="form_text_ipt">
								<input name="mer_pass" type="password" placeholder="密码" class="password">
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>
							<div class="form_check_ipt">
								<div class="left check_left">
									<label><input name="" type="checkbox"> 下次自动登录</label>
								</div>
								<div class="right check_right">
									<a href="javascript:;">忘记密码</a>
								</div>
							</div>
							<div class="form_btn">
								<button type="button" class="submit">登录</button>
							</div>
							<div class="form_reg_btn">
								<span>还没有帐号？</span><a href="<?=Url::to('register/user_register')?>">马上注册</a>
							</div>
						</form>
						<div class="other_login">
						<a href="<?=Url::to('index/index')?>">返回首页</a>
							<div class="left other_left">
								<span>其它登录方式</span>
							</div>
							<div class="right other_right">
								<a href="<?=Url::to('login/login')?>">用户登录</a>
							</div>
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
	$(".submit").click(function(){
	    var phone = $('.phone').val();
	  	var password = $('.password').val();
	  	if(phone=="")
	  	{
	  		return false;
	  	}
	  	if(password=="")
	  	{
	  		return false;
	  	}
	  	$.ajax({
		   type: "POST",
		   url: "<?=Url::to('login/mer_login_do')?>",
		   data: {mer_phone:phone,mer_pass:password},
		   success: function(msg){
		     if(msg=="no")
		     {
		     	alert('手机号或密码有误!');
		     	return false;
		     }
		     else
		     {
		     	location.href="<?=Url::to('/index/index')?>";
		     }
		   }
		});
	  	
	});
</script>
