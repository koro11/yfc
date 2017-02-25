<?php

namespace frontend\models;

use Yii;

use frontend\models\Carts;
use frontend\models\Merchant;
/**
 * This is the model class for table "yfc_food".
 *
 * @property integer $food_id
 * @property string $food_name
 * @property integer $food_cate
 * @property integer $food_mer
 * @property string $food_mername
 * @property string $food_image
 * @property string $food_price
 * @property integer $is_discount
 * @property string $discount_price
 * @property string $discount_start
 * @property string $discount_end
 * @property integer $food_inventory
 * @property integer $food_sort
 * @property integer $is_new
 * @property string $food_addtime
 * @property integer $is_delete
 * @property integer $food_click
 * @property integer $food_saled
 * @property integer $is_score
 * @property integer $food_score
 * @property string $food_desc
 */
class Food extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yfc_food';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['food_cate', 'food_mer', 'is_discount', 'food_inventory', 'food_sort', 'is_new', 'is_delete', 'food_click', 'food_saled', 'is_score', 'food_score'], 'integer'],
            [['food_price', 'discount_price'], 'number'],
            [['food_desc'], 'string'],
            [['food_name', 'food_image'], 'string', 'max' => 80],
            [['food_mername'], 'string', 'max' => 60],
            [['discount_start', 'discount_end', 'food_addtime'], 'string', 'max' => 13],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'food_id' => 'Food ID',
            'food_name' => 'Food Name',
            'food_cate' => 'Food Cate',
            'food_mer' => 'Food Mer',
            'food_mername' => 'Food Mername',
            'food_image' => 'Food Image',
            'food_price' => 'Food Price',
            'is_discount' => 'Is Discount',
            'discount_price' => 'Discount Price',
            'discount_start' => 'Discount Start',
            'discount_end' => 'Discount End',
            'food_inventory' => 'Food Inventory',
            'food_sort' => 'Food Sort',
            'is_new' => 'Is New',
            'food_addtime' => 'Food Addtime',
            'is_delete' => 'Is Delete',
            'food_click' => 'Food Click',
            'food_saled' => 'Food Saled',
            'is_score' => 'Is Score',
            'food_score' => 'Food Score',
            'food_desc' => 'Food Desc',
        ];
    }
}
