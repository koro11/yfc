<!DOCTYPE html>
<html>
	<head>
		<base href="/">
		<meta charset="utf-8">
		<title>商家驻入</title>
		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/common.css" />
		<link rel="stylesheet" href="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://cdn.static.runoob.com/libs/jquery/2.1.1/jquery.min.js"></script>
		<script src="https://cdn.static.runoob.com/libs/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<?php use yii\helpers\Url;?>
	<body>
		<div class="wrap login_wrap">
			<div class="content">
				
				<div class="logo"></div>
				
				<div class="login_box">	
					
					<div class="login_form">
						<div class="login_title">
							商家驻入
						</div>
						<form action="<?=Url::to('register/merchant_register_do')?>" method="post" enctype="multipart/form-data">
							
							<div class="form_text_ipt">
								<input name="mer_name" type="text" placeholder="(可参考饭店名称)" class="name">
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>

							<div class="form_text_ipt">
								<input name="mer_pass" type="password" placeholder="密码" class="pwd">
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>
								
							<div class="form_text_ipt">
							<font color="gray">请选择地区：</font>
								<select name="dis_id" id="dis" style="margin:10px;">
								<?php foreach($district as $key => $val){?>
									<option value="<?php echo $val['d_id']?>"><?php echo $val['d_name']?></option>
								<?php }?>
								</select>
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>
								
                            <div class="form_text_ipt">
							<font color="gray">请选择分类：</font>
								<select name="info_mer_cate" id="cate" style="margin:10px;">
								<?php foreach($cate as $key => $val){?>
									<option value="<?php echo $val['cat_id']?>"><?php echo $val['cat_name']?></option>
								<?php }?>
								</select>
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>

							<div class="form_text_ipt">
								<input name="mer_address" type="text" placeholder="地址" class="address">
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>

							<div class="form_text_ipt">
								<input name="mer_phone" type="text" placeholder="电话" class="phone"><span id="phone"></span>
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>

							<div class="form_text_ipt">
								<input name="info_catipa" type="text" placeholder="人均消费" class="catipa"><span id="catipa"></span>
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>

							<div class="form_text_ipt">
								<input name="mer_logo" type="file" placeholder="饭店logo" class="logo">
							</div>
							<div class="ececk_warning"><span>数据不能为空</span></div>

							<div class="form_btn">
								<button type="submit">注册</button>
							</div>
							
						</form>
						<div class="other_login">
						 <a href="<?=Url::to('login/mer_login')?>">已有账号？请登录</a>	
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
  	$("form").submit(function(){
  		var name = $('.name').val();
  		var pwd = $('.pwd').val();
	    var phone = $('.phone').val();
	    var address = $('.address').val();
	    var catipa = $('.catipa').val(); 
	    var phone_st = $('#phone').text;
	    if(phone_st!="")
	    {
	    	return false;
	    }
	  	if(name=="")
	  	{
	  		return false;
	  	}
	  	if(phone=="")
	  	{
	  		return false;
	  	}
	  	if(pwd=="")
	  	{
	  		return false;
	  	}
	  	if(address=="")
	  	{
	  		return false;
	  	}
	});
</script>
