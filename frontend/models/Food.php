<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $category_id
 * @property string $category_name
 */
class Food extends \yii\db\ActiveRecord
{

    public function getMer()
    {
        return $this->hasOne(Merchant::className(), ['info_mer' => 'mer_id']);
    }

}
