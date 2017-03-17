<?php use \yii\helpers\Url;?>
 <article class="U-article Overflow">
  <!--user Favorites-->
  <section class="ShopFav Overflow">
   <span class="ShopFavtitle Block Font14 FontW Lineheight35">我的收藏</span>
    <?php if (!empty($arr)) {?>
    <ul>
    <?php foreach ($arr as $key => $val) {?>
    <a href="<?=Url::to(['index/shop_index','mer'=>$val['merchant']['mer_id']])?>" target="_blank">
    <li>
     <img src="<?=$val['merchant']['mer_logo']?>">
     <p><?=$val['merchant']['mer_name']?> <a href="javascript:void(0)" id="del" collectid="<?=$val['collect_id']?>">( 删除 )</a></p>
    </li>
    </a>
    <?php }?>
    </ul>
    <?php }else{?>
    <ul>
      暂无
    </ul>
    <?php }?>
   
  </section>
 </article>
</section>
<!--End content-->
<script type="text/javascript">
  $(document).delegate("#del","click",function(){
    var collect_id=$(this).attr("collectid");
    $.ajax({
      type:'get',
      url:'<?=Url::to('user/del_collect')?>',
      data:'collect_id='+collect_id,
      success:function(msg)
      {
          if (msg==1) 
          {
            alert('删除成功');location.href="<?=Url::to('user/user_collect')?>";
          }
          else
          {
            alert('删除失败');
          }
      }
    })
  })
</script>