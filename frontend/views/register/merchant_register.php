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
		<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=Ixk1wsRY3ffwS12GLtYmvjyHYkUfu0Uu"></script>
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
								<input type="text" placeholder="地址" name="mer_address" id="suggestId" size="20"  style="width:150px;"  class="address"/>
             			<div id="l-map" style="display:none"></div>
                     <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
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
							<input type="hidden" name="mer_lng">
							<input type="hidden" name="mer_lat">
							<div class="form_btn">
							<!-- <input type="submit" value="注册"> -->
							<button type="submit">注册</button>
							</div>
							
						</form>
						<div class="other_login">
						 <a href="<?=Url::to('login/mer_login')?>">已有账号？请登录</a>	
						 <a href="<?=Url::to('index/index')?>">返回首页</a>
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
	    var phone_st = $('#phone').text();
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
<script type="text/javascript">
    // 百度地图API功能
    function G(id) {
        return document.getElementById(id);
    }

    var map = new BMap.Map("l-map");
    map.centerAndZoom("北京",12);                   // 初始化地图,设置城市和地图级别。

    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
        {"input" : "suggestId"
        ,"location" : map
    });

    ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
    var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }    
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;
        
        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }    
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        G("searchResultPanel").innerHTML = str;
    });

    var myValue;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
    var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;
        
        setPlace();
    });

    function setPlace(){
        map.clearOverlays();    //清除地图上所有覆盖物
        function myFun(){
            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
            map.centerAndZoom(pp, 18);
            map.addOverlay(new BMap.Marker(pp));    //添加标注
        }
        $(document).delegate("#suggestId","blur",function(){
        var name=$(this).val();
        $("#adress").html(name);
        var adds = new Array();
        adds[0]=name;
        geocodeSearch(adds);
    })      
        
    }
    function geocodeSearch(add){
        var myGeo = new BMap.Geocoder();
        myGeo.getPoint(add, function(point){
            if (point) {
                var address = new BMap.Point(point.lng, point.lat);
                var user_id=$("#user_id").attr("user_id");
                var coor_address=add[0];
                var user_lng=address.lng;
                var user_lat=address.lat;
               	$("input[name=mer_lng]").val(user_lng);
               	$("input[name=mer_lat]").val(user_lat);
            }
        }, "北京市");
    }
    
</script>