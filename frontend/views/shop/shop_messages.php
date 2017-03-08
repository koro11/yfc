<?php use yii\helpers\Url;?>
<!-- 用户留言页面 -->
<article class="U-article Overflow">
  <!--user Account-->
  <section class="AccManage Overflow">
   <span class="AMTitle Block Font14 FontW Lineheight35">用户留言</span>
     <div class="message_list">
     <?php foreach ($shop_message as $k => $v): ?>     
         <span class="Ask" ><i><?=$v['user_name']?></i>:<?=$v['m_message']?>-<i>于<?=$v['m_addtime']?></i></span>
         <?php if ($v['back']!=''): ?> 
         <div>
          <font color="gray">商家已回复</font><span><a href="javascript:void(0)" class="mess_show" style="color:blue">查看</a></span> 
          <div class="back_data" style="display:none">
          <span ><?=$v['back']['m_message']?>-<i><?=$v['back']['m_addtime']?></i></span>
   
          </div>
          </div>
          <?php else: ?>
          	<div>
          	 <span class='show_back' ><font color="blue">回复</font></span>
          	  <div class="text_show" style="display:none">
          	  <textarea name="message_back" class="message_back" cols="50" rows="3" ></textarea>
          	  <input type="button" class="back_btn"value="提交" uid="<?=$v['m_user']?>" mid="<?=$v['m_id']?>" merid="<?=$v['m_mer']?>">
          	  <input type="button" class="reset_btn"value="取消">
          	  </div>
          	</div>
          	
          <?php endif ?>
          <?php endforeach ?>
         
     </div>
     <div class="TurnPage">
          <?=$pages?>
        </div>
<input type="hidden" class="back_url" value="<?=Url::to('shop/shop_message_back')?>">
<input type="hidden" class="page_url" value="<?=Url::to('shop/shop_page_back')?>">
</section>
</article>
<!--End content-->
<script>
    //分页
  function page(p){

    var page_url = $('.page_url').val();
    
    $.ajax({
       type: "GET",
       url: page_url,
       data: {p:p},
       dataType:'json',
       success: function(msg){
            str1(msg);
            $('.TurnPage').html(msg.page);
       }
    });

  }
  function str1(data)
  {
  	var str = '';
  	$.each(data.msg,function(k,v){
         str+='<span class="Ask" ><i>'+v.user_name+'</i>:'+v.m_message+'-<i>于'+v.m_addtime+'</i></span>'
         if (v.back!='') {
         	
          str+='<div>'
          str+='<font color="gray">商家已回复</font><span><a href="javascript:void(0)" class="mess_show" style="color:blue">查看</a></span>' 
          str+='<div class="back_data" style="display:none">'
          str+=' <span >'+v.back.m_message+'-<i>'+v.back.m_addtime+'</i></span>'
   
          str+='</div>'
          str+='</div>'
          }else{
          str+='<div>'
          str+='<span class="show_back" ><font color="blue">回复</font></span>'
          str+='<div class="text_show" style="display:none">'
          str+='<textarea name="message_back" class="message_back" cols="50" rows="3" ></textarea>'
          str+='<input type="button" class="back_btn"value="提交" uid="'+v.m_user+'" mid="'+v.m_id+'" merid="'+v.m_mer+'">'
          str+='<input type="button" class="reset_btn"value="取消">'
          str+='</div>'
          str+='</div>' 	
          }
        })
  	// alert(str);return false;
    $('.message_list').html(str);
  }

	$(function(){
		//查看回复
		$(document).on('click','.mess_show',function(){
          $(this).parent().parent().find('.back_data').show();
          $(this).parent().html('<a href="javascript:void(0)" class="mess_hide" style="color:blue">收起回复</a>')
		})
		// 收起回复
		$(document).on('click','.mess_hide',function(){
          $(this).parent().parent().find('.back_data').hide();
          $(this).parent().html('<a href="javascript:void(0)" class="mess_show" style="color:blue">查看</a>')
		})
		//回复
		$(document).on('click','.back_btn',function(){
			var _this = $(this);
			var mid = _this.attr('mid');
			var uid = _this.attr('uid');
			var mer_id = _this.attr('merid');
			var back_url = $('.back_url').val();
            var message = _this.parent().find('.message_back').val();
			// alert(message)
			if (message == '')
			 {
                alert('回复不能为空');return false;
			 }else{
                $.ajax({
					   type: "POST",
					   url: back_url,
					   data: {
					   	m_user:uid,m_message:message,m_pid:mid,m_mer:mer_id
					   },
					   success: function(msg){
					     if (msg) {
					     	history.go(0);
					     }else{
					     	alert('提交失败了')
					     }
					   }
					});
			 }
		})
        
        //回复文本框显示
		$(document).on('click','.show_back',function(){
           $(this).parent().find('.text_show').show();
		})
		//回复文本框隐藏
		$(document).on('click','.reset_btn',function(){
           $(this).parent().hide();
		})
	})
</script>