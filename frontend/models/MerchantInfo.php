<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $category_id
 * @property string $category_name
 */
class MerchantInfo extends \yii\db\ActiveRecord
{
    public function getMerCate()
    {
        return $this->hasOne(MerCategory::className(), ['cat_id' => 'info_mer_cate']);
    }
}
