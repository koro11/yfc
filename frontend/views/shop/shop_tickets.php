<?php use yii\helpers\Url;?>
<!-- 优惠券页面 -->
<article class="U-article Overflow">
  <!--user Account-->
  <section class="AccManage Overflow">
   <span class="AMTitle Block Font14 FontW Lineheight35">本店优惠券</span>

    <?php if ($tickets): ?>
    <table>
    <tr class="U-order-D">
	<th>优惠券</th>
	<th>开始时间</th>
	<th>使用期限</th>
	<th>优惠金额</th>
	<th>状态操作</th>
	<th>相关操作</th>
    </tr>
    	<?php foreach ($tickets as $key => $value): ?>	
    	<tr tid="<?=$value['tic_id']?>">
		<td width="30%" align="center"><?=$value['tic_desc']?></td>
		<td align="center" class="tic_start"><?=date('Y-m-d H:i:s',$value['tic_start'])?></td>
		<td align="center" class="tic_end"><?=date('Y-m-d H:i:s',$value['tic_end'])?></td>
		<td align="center" class="change_cost" title="点击修改优惠金额">￥<span class="_span"><?=$value['tic_cost']?></span></td>
		<td align="center" tid="<?=$value['tic_id']?>" tst="<?=$value['tic_status']?>" class='is_delete'>
		<?php if ($value['tic_status']): ?>
		<span><font color="blue">启用</font></span>
		<?php else: ?>
		<span><font color="blue">作废</font></span>
		<?php endif ?>
        </td>
		<td align="center" class="operate">
		    <span class='res_btn'>
			<span class="extend_end"><font color="blue">延长使用期限</font></span>
            </span>
            <br>
            <span class="extend_time" style='display:none'>
            <input type="text" class="ext_time" id="">*参考格式2017-01-13 09:00:00<br/>
            <span class="extend_sub" tid="<?=$value['tic_id']?>"><font color="blue">提交</font></span>
            </span>
		</td>
	    </tr>
    	<?php endforeach ?>
    	</table>
    <?php else: ?>
    	<div>
    		贵店还没有发行过优惠券，宝宝悄悄告诉你，优惠券是一种吸引顾客的直接有效的方法哦！去发行一个试试吧！<a href="<?=Url::to('shop/shop_issue_tickets')?>"><font color="blue">点这里</font></a>
    	</div>
    <?php endif ?>
</section>
</article>
<!--End content-->
<script>
	$(function(){
		//启用与作废优惠券
		$(document).on('click','.is_delete',function(){
			var _this = $(this);
			var tid   = _this.attr('tid');
			var tst   = _this.attr('tst');
		        tst   = tst==1 ? 0 : 1;
			
			$.get("<?=Url::to(['shop/shop_ticket_sta']);?>",{tid:tid,tst:tst},function(data){
	        if (data == 1) { 
	        	 _this.attr('tst',tst);
	        	if (tst == 1) {
	             _this.html('<span><font color="blue">启用</font></span>');		
	        	}else{
	             _this.html('<span><font color="blue">作废</font></span>');
	        	}
	        };
	      })
		})
        //延长期限 
		$(document).on('click','.extend_end',function(){
			var _this = $(this).parent();
			_this.html('<span class="extend_reset"><font color="blue">取消</font></span>');
			_this.parent().find('.extend_time').show();
			 
		})
		//取消延长
		$(document).on('click','.extend_reset',function(){
			var re_this = $(this).parent();
			re_this.html('<span class="extend_end"><font color="blue">延长使用期限</font></span>');
			re_this.parent().find('.extend_time').hide();
		})
		//提交延长
		$(document).on('click','.extend_sub',function(){
			var sub_this = $(this);
			var t_id = sub_this.attr('tid');
			var ext_time = sub_this.parent().find('.ext_time').val();
			var reg = /^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2}) (\d{1,2}):(\d{1,2}):(\d{1,2})$/;
            var r = ext_time.match(reg);
            if(r == null){
             alert("输入格式不正确，请按2017-01-13 09:00:00的格式输入！");
             return false;
		    }else{
		     $.get("<?=Url::to(['shop/shop_extend_time']);?>",{tid:t_id,ext_time:ext_time},function(data){
	         if (data == -1) { 
	        	 alert('请输入一个合理的时间');	
	         }else{
	         	 sub_this.parent().parent().parent().find('.tic_end').html(ext_time);
	         	 sub_this.parent().parent().parent().find('.is_delete').attr('tst',0);
	         	 sub_this.parent().parent().parent().find('.is_delete').html('<span><font color="blue">作废</font></span>');		
	             sub_this.parent().parent().find('.res_btn').html('<span class="extend_end"><font color="blue">延长使用期限</font></span>');
	             sub_this.parent().hide();
	        }
	        })
		    }        
		})
	    // 时间插件
		// $(".ext_time").click(function(){
		//  	WdatePicker();
		// })
        //修改优惠金额
        $(document).on('click','._span',function(){
			var _this = $(this);  //td
			var _sta  = _this.parent().parent().find('.is_delete').attr('tst');
			// alert(_sta);
			if (_sta==1) {
			alert('该优惠券未启用，请先启用再修改该优惠金额');
			}else{
		    old_cost = _this.html();
			_this.parent().html('<input type="text" class="_input" size="5" value="'+old_cost+'" />');
			}
		})

		//修改优惠金额文本框
        $(document).on('blur','._input',function(){
        	var input_this = $(this);
        	var tid        = input_this.parent().parent().attr('tid');
        	var input_rege = /^\d{1,4}$/;
        	var input_new  = input_this.val();
        	var input_rest = input_new.match(input_rege);
        	if (input_rest) {
        		if(confirm('确定要修改优惠金额吗？慎重三思哦！'))
        		{
	        		$.get("<?=Url::to(['shop/shop_change_cost']);?>",{tid:tid,input_new:input_new},function(data){
		             // alert(data)
		             if (data==-1) {
		             	alert('大神！请不要js伪造哦！~~~')
		             }else if(data == 0){
		             	alert('修改失败，未知错误')
		             }else{
		             	input_this.parent().html('￥<span class="_span">'+input_new+'</span>')
		             }
		            })
        		}else{
        			input_this.parent().html('￥<span class="_span">'+old_cost+'</span>')
        		}
        	}else{
        		alert('输入一到四位的数字好吗？')
        	}
        	})
	}) 
</script>