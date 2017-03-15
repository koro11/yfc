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
							登录
						</div>
						<form action="<?=Url::to('login/login_do')?>" method="post">
							
							<div class="form_text_ipt">
								<input name="user_phone" type="text" placeholder="手机号" class="phone">
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>
							<div class="form_text_ipt">
								<input name="user_password" type="password" placeholder="密码" class="password">
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>
							<div class="form_check_ipt">
								<div class="left check_left">
									<label><input name="" type="checkbox"> 下次自动登录</label>
								</div>
								<div class="right check_right">
									<a href="#">忘记密码</a>
								</div>
							</div>
							<div class="form_btn">
								<button type="button" class="submit">登录</button>
							</div>
							<div class="form_reg_btn">
								<span>还没有帐号？</span><a href="<?=Url::to('register/user_register')?>">马上注册</a>
								<a href="<?=Url::to('login/mer_login')?>" style="font-size:23px;">商家登录</a>
							</div>
						</form>
						<div class="other_login">
						<a href="<?=Url::to('index/index')?>">返回首页</a>
							<div class="left other_left">
								<span>其它登录方式</span>
							</div>
							<div class="right other_right">
								 <a href="<?=Url::to('login/qqlogin')?>" ><img src="images/QQ.png" alt=""></a>
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
		   url: "<?=Url::to('login/login_do')?>",
		   data: {user_phone:phone,user_password:password},
		   success: function(msg){
		     if(msg=="no")
		     {
		     	alert('用户名或密码有误!');
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
<script>
/* function toLogin()
 {
   //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
   //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
   var A=window.open("oauth/index.php","TencentLogin", 
   "width=450,height=320,menubar=0,scrollbars=1,
   resizable=1,status=1,titlebar=0,toolbar=0,location=1");
 } */
</script>
