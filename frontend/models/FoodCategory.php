<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%food_category}}".
 *
 * @property integer $cate_id
 * @property string $cate_name
 */
class FoodCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%food_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_name'], 'required'],
            [['cate_name'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cate_id' => 'Cate ID',
            'cate_name' => 'Cate Name',
        ];
    }
}
