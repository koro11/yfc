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
				
				<div class="login_box" style="margin-top:70px;">	
					
					<div class="login_form">
						<div class="login_title">
							<a href="<?=Url::to('login/login')?>">用户登录=></a>
						</div>
					     <div class="login_title">
							<a href="<?=Url::to('login/mer_login')?>">商家登录=></a>
						</div>
					</div>
					<a href="<?=Url::to(['register/choice']);?>">还没账号？请先注册</a>
					<a href="<?=Url::to('index/index')?>">返回首页</a>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/jquery.js" ></script>
		<script type="text/javascript" src="js/common.js" ></script>
	</body>
</html>
