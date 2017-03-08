<?php

namespace frontend\models;

use Yii;
use yii\base\Exception;

/**
 * This is the model class for table "yfc_date".
 *
 * @property string $deta_id
 * @property integer $food_id
 * @property integer $food_num
 * @property string $food_name
 * @property string $date_speak
 * @property string $sum_price
 */
class Date extends \yii\db\ActiveRecord
{

	public function getOrders(){
    return $this->hasOne(Orders::className(),['order_id'=>'order_id']);
}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{yfc_date}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['food_id', 'food_num', 'food_name'], 'required'],
            [['food_id', 'food_num'], 'integer'],
            [['sum_price'], 'number'],
            [['food_name'], 'string', 'max' => 255],
            [['date_speak'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'deta_id' => 'Deta ID',
            'food_id' => 'Food ID',
            'food_num' => 'Food Num',
            'food_name' => 'Food Name',
            'date_speak' => 'Date Speak',
            'sum_price' => 'Sum Price',
        ];
    }
    /**
     * 订单详情
     * @author Dx
     * @param $param
     * @return bool
     */
    public function setOrderdetails($param,$id)
    {
        if(empty($param) || !is_array($param))return false;
        unset($param['food_id']);
        if(isset($param['discount_pay']))unset($param['discount_pay']);

        $sum = '';
        foreach($param as $k=>$v){
            if($v['food']['is_discount']){
                $sumPrice = $v['buy_number']*$v['food']['discount_price'];
            }else{
                $sumPrice = $v['buy_number']*$v['food']['food_price'];
            }
            $arr[] = array(
                'food_id'=>$v['food_id'],
                'food_num'=>$v['buy_number'],
                'food_name'=>$v['food_name'],
                'sum_price'=>$sumPrice,
                'order_id'=>$id,
            );
        }

        $res = \Yii::$app->db->createCommand()->batchInsert($this::tableName(),['food_id','food_num','food_name','sum_price','order_id'], $arr)->execute();
        if(!$res){
            return false;
        }else{
            return true;
        }
    }

}
