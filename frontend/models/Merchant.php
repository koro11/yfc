<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property integer $category_id
 * @property string $category_name
 */
class Merchant extends \yii\db\ActiveRecord
{
    /**
     * @return string
     */
//    public static function tableName()
//    {
//        return 'merchant';
//    }

//    /**
//     * @inheritdoc
//     */
//    public function rules()
//    {
//        return [
//            [['category_name'], 'string', 'max' => 30],
//        ];
//    }


//    public function getCategorys()
//    {
//        // 第一个参数为要关联的子表模型类名，
//        // 第二个参数指定 通过子表的category_id，关联主表的employ_id字段
//        return $this->hasMany(EmployerForm::className(), ['category_id' => 'category_id']);
//    }


    public function getMerInfo()
    {
        return $this->hasOne(MerchantInfo::className(), ['info_mer' => 'mer_id']);
    }



}
