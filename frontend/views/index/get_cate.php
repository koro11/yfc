<?php if ($type == 1): ?>
    <?php foreach ($foodcate as $key => $val): ?>
        <a href="javascript:void(0);" class="close" cate_id="<?=$val['cate_id']?>" ><?=$val['cate_name'];?><img src="./images/ch.png"></a>
    <?php endforeach ?>
<?php else: ?>
    <?php foreach ($mercate as $key => $val): ?>
        <a href="javascript:void(0);" class="close" cate_id="<?=$val['cat_id']?>" ><?=$val['cat_name'];?><img src="./images/ch.png"></a>
    <?php endforeach ?>
<?php endif ?>
