<?php

namespace frontend\models;

use Yii;
use frontend\models\Food;
use frontend\models\Merchant;
/**
 * This is the model class for table "yfc_carts".
 *
 * @property string $cart_id
 * @property integer $user_id
 * @property integer $food_id
 * @property string $food_market
 * @property string $food_price
 * @property integer $buy_number
 */
class Carts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%carts}}";
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'food_id', 'food_market', 'food_price', 'buy_number'], 'required'],
            [['user_id', 'food_id', 'buy_number'], 'integer'],
            [['food_market', 'food_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cart_id' => 'Cart ID',
            'user_id' => 'User ID',
            'food_id' => 'Food ID',
            'food_market' => 'Food Market',
            'food_price' => 'Food Price',
            'buy_number' => 'Buy Number',
        ];
    }
    /**
     * 购物车与餐饮进行关联
     * @author Dx
     * @param
     * @return
     */
    public function getFood()
    {
        return $this->hasOne(Food::className(),['food_id'=>'food_id']);
    }
    /**
     * 餐饮与商家进行关联
     * @author Dx
     * @param
     * @return
     */
    public function getMerchant()
    {
        $db = new Food();
        return $db->hasOne(Merchant::className(),['mer_id'=>'seller_id']);
    }
    /**
     * 删除餐饮
     * @author Dx
     * @param
     * @return
     */
    public function delCart($cartId)
    {
        if(empty($cartId))return false;
        $res = $this->deleteAll('cart_id in ('.$cartId.')');
        if($res){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 结算购物车修改数量
     * @author Dx
     * @param intval $id
     * @param intval $num
     * @return
     */
    public function saveNum($id,$num)
    {
        if(empty($id) || empty($num))return false;
        $res = $this->updateAll(['buy_number'=>$num],['cart_id'=>$id]);
        if($res){
            return true;
        }else{
            return false;
        }
    }
    /**
     * 餐饮入购物车
     * @author Dx
     * @param  array $param
     * @return
     */
    public function setCart($param)
    {
        if(empty($param))return false;
        $this->user_id = $param['user_id'];
        $this->food_id = $param['food_id'];
        $this->food_price = $param['food_price'];
        $this->food_market = $param['food_market'];
        $this->buy_number = $param['buy_number'];
        $res = $this->save();
        if(!$res)return false;
        return true;
    }
}
