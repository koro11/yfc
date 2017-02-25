$(document).ready(function () {
	// 全选        
	$(".allselect").click(function () {
		$(".gwc_tb2 input[name=newslist]").each(function () {
			$(this).attr("checked", true);
		});
		GetCount();
	});

	//反选
	$("#invert").click(function () {
		$(".gwc_tb2 input[name=newslist]").each(function () {
			if ($(this).attr("checked")) {
				$(this).attr("checked", false);

			} else {
				$(this).attr("checked", true);

			} 
		});
		GetCount();
	});
	//取消
	$("#cancel").click(function () {
		$(".gwc_tb2 input[name=newslist]").each(function () {
			$(this).attr("checked", false);

		});
		GetCount();
	});

	// 所有复选(:checkbox)框点击事件
	$(".gwc_tb2 input[name=newslist]").click(function () {
		if ($(this).attr("checked")) {

		} else {

		}
	});

	// 输出
	$(".gwc_tb2 input[name=newslist]").click(function () {

		GetCount();
	});
});
//******************
function GetCount() {
	var conts = 0;
	var aa = 0;
	$(".gwc_tb2 input[name=newslist]").each(function () {
		if ($(this).attr("checked")) {
			for (var i = 0; i < $(this).length; i++) {
				conts += parseInt($(this).val());
				aa += 1;
			}
		}
	});

	$("#shuliang").text(aa);
	$("#zong1").html((conts).toFixed(2));
	if(conts!=0){
		$("#jz1").css("display", "none");
		$("#jz2").css("display", "block");
	}else{
		$("#jz1").css("display", "block");
		$("#jz2").css("display", "none");
	}

}
//ADD:对删除链接进行处理2014-9-20DeathGhost
    $(function(){
		$(".tb1_td7").click(function(){
			var _this = $(this);
			var cartId = _this.find('a').attr('cartid');
			$.get('?r=cart/delcart',{cartId:cartId},function(data){
				if(data.status==1){
					_this.parent().parent().remove();
				}else{
					alert(data.msg);
				}
			},'json')
		});

	});
//<!---商品加减算总数---->

	$(function () {
		$(".add1").click(function () {
			var _this = $(this);
			var t = _this.siblings("input[name='text_box1']");
			var price = _this.parent().siblings('.tb1_td6').find('.tot').text();
			var num = parseInt(t.val()) + 1;
			t.val(num).attr('status',1);

			setTotal($(this),num,price);GetCount();
		})
		$(".min1").click(function () {
			var t = $(this).siblings("input[name='text_box1']");
			var price = $(this).parent().siblings('.tb1_td6').find('.tot').text();
			var num = parseInt(t.val()) - 1;
			if(num<1){
				return false;
			}else{
				t.val(num).attr('status',1);
			}

			setTotal($(this),num,price);GetCount();
		})
		function setTotal(thiss,num,price) {

			//$("#total1").html((parseInt(t.val()) * price).toFixed(2));
			var sum = num*price;

			thiss.parent().siblings('.tb2_td1').find(".newslist-1").val(sum);
		}

	})
//结算
$(function(){
	var status = '1';
	$('#jz2').click(function(){
		var box = $('input:checked');
		if(box.size()==0){
			alert('请选择商品');
			return false;
		}
		var cart = [];

		var sum = box.size();

		for (var i = 0; i < sum; i++) {
			if (box.eq(i).attr("checked")) {
				var num = box.eq(i).parent().siblings('.tb1_td5').find('input[name="text_box1"]');
				var cartId = box.eq(i).attr('cartid');
				//数量做了修改就进行购物
				if(num.attr('status')==1){
					savenum(num.val(),cartId);
				}
				var arr={
					'cartId':cartId,
					'sellerId' : box.eq(i).attr('sellerId'),
				}
			}
			cart[i]=arr;
		}
		if(status!=1){
			alert('网络状态异常,请重试');
			return false;
		}
		$.get('?r=cart/settlement',{order:cart},function(data){
			if(data.status == '0'){
				alert(data.msg);
				return false;
			}else{
				document.location = 'http://127.0.0.1/dongxin/yfc/frontend/web/?r=order/order&buycart='+data.content;
			}
		},'json')

	})

	function savenum(num,id)
	{
		$.ajax({
			type: "get",
			url: "?r=cart/savenum",
			data: {num:num,id:id},
			asynv:false,
			dataType: 'json',
			success: function(data){
				if(data.status==0){
					alert(data.msg);
					status=0;
				}
			}
		});
	}
})
//var ue = UE.getEditor('editor');
//function post(URL, PARAMS) {
//	var form = document.createElement("form");
//	form.action = URL;
//	form.method = "post";
//	form.style.display = "none";
//	for(var x in PARAMS){
//		var text = document.createElement("textarea");
//		text.name = x;
//		text.value = PARAMS[x];
//		form.appendChild(text);
//	}
//	document.body.appendChild(form);
//	form.submit();
//	return form;
//}
//function getContent() {
//	var article_content = [];
//	var article_title = document.getElementById("article_title").value;
//	article_content.push(ue.getContent());
//	article_content.join("\n");
//	post("do_add_article.php", {article_title:article_title, article_content:article_content});
//}
//<!---总数---->
	$(function () {
		$(".quanxun").click(function () {
			setTotal();
			//alert($(lens[0]).text());
		});
		function setTotal() {
			var len = $(".tot");
			var num = 0;
			for (var i = 0; i < len.length; i++) {
				num = parseInt(num) + parseInt($(len[i]).text());

			}
			//alert(len.length);
			$("#zong1").text(parseInt(num).toFixed(2));
			$("#shuliang").text(len.length);
		}
		//setTotal();
	})
//add to cart shoppage
var data = {"total":0,"rows":[]};
		var totalCost = 0;
		
		$(function(){
			$('#cartcontent').datagrid({
				singleSelect:true
			});
			$('.item').draggable({
				revert:true,
				proxy:'clone',
				onStartDrag:function(){
					$(this).draggable('options').cursor = 'not-allowed';
					$(this).draggable('proxy').css('z-index',2);
				},
				onStopDrag:function(){
					$(this).draggable('options').cursor='move';
				}
			});
			$('.cart').droppable({
				onDragEnter:function(e,source){
					$(source).draggable('options').cursor='auto';
				},
				onDragLeave:function(e,source){
					$(source).draggable('options').cursor='not-allowed';
				},
				onDrop:function(e,source){
					var name = $(source).find('p:eq(0)').html();
					var price = $(source).find('p:eq(1)').html();
					addProduct(name, parseFloat(price.split('￥')[1]));
				}
			});
		});
		
		function addProduct(name,price){
			function add(){
				for(var i=0; i<data.total; i++){
					var row = data.rows[i];
					if (row.name == name){
						row.quantity += 1;
						return;
					}
				}
				data.total += 1;
				data.rows.push({
					name:name,
					quantity:1,
					price:price
				});
			}
			add();
			totalCost += price;
			$('#cartcontent').datagrid('loadData', data);
			$('div.cart .total').html('共计金额: ￥'+totalCost);
		}