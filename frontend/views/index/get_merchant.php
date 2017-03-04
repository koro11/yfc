<?php use yii\helpers\Url;?>
<?php if ($merchant): ?>
    <?php foreach ($merchant as $key => $val): ?>
        <a href="<?=Url::to(['index/shop_index','mer'=>$val['mer_id']]);?>" target="_blank" title="<?=$val['mer_name'];?>">
            <figure>
                <img src="<?=$val['merinfo']['info_image'];?>">
                <figcaption>
                    <span class="title"><?=$val['mer_name'];?></span>
                    <span class="price"><?=$val['mer_phone'];?></span>
                </figcaption>
                <p class="p1">优惠信息：<q><?=$val['merinfo']['info_favorable'];?></q></p>
                <p class="p2">
                    店铺评分：
                    <img src="images/star-on.png">
                    <img src="images/star-on.png">
                    <img src="images/star-on.png">
                    <img src="images/star-on.png">
                    <img src="images/star-off.png">
                </p>
                <p class="p3">店铺地址：<?=$val['mer_address'];?>...</p>
            </figure>
        </a>
    <?php endforeach ?>
<?php else: ?>
    <div class="notfound">
        <p>您要找的店走丢了</p>
    </div>
<?php endif ?>
