<?php use yii\helpers\Url;?>
<?php if ($food): ?>
    <?php foreach ($food as $key => $val): ?>
        <a href="<?=Url::to(['menu/details','id'=>$val['food_id']])?>" target="_blank" title="<?=$val['food_mername'].'-'.$val['food_name'];?>">
            <figure>
                <img src="<?=$val['food_image'];?>">
                <figcaption>
                 <span class="title">
                     <p><?=$val['food_mername'];?></p>
                     <p><?=$val['food_name'];?></p>
                 </span>
                    <span class="price"><i>￥</i>
                        <?php if (empty($val['discount_price'])): ?>
                            <?=$val['food_price'];?>
                        <?php else: ?>
                            <?=$val['discount_price'];?>
                        <?php endif ?>
                 </span>
                </figcaption>
            </figure>
        </a>
    <?php endforeach ?>
<?php else: ?>
    <div class="notfound">
        <p>您要找的菜走丢了</p>
    </div>
<?php endif ?>
