<?php 
namespace frontend\models;

use frontend\functions\Functions;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\db\Command;
class Orders extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%orders}}";
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['order_sn', 'user_id', 'food_id', 'merchant_id', 'consignee', 'pay_id', 'pay_way', 'food_amount', 'order_amount', 'order_addtime', 'address_id'], 'required'],
            [['user_id', 'merchant_id', 'order_status', 'shipping_status', 'pay_status', 'ship_id', 'pay_id', 'order_speak', 'order_date', 'address_id'], 'integer'],
            [['food_amount', 'ship_free', 'discount_pay', 'order_amount'], 'number'],
            [['order_sn', 'consignee', 'ship_name'], 'string', 'max' => 30],
            [['food_id'], 'string', 'max' => 11],
            [['pay_way'], 'string', 'max' => 20],
            [['order_addtime', 'order_paytime'], 'string', 'max' => 13],
            [['Remarks'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'order_id' => 'Order ID',
            'order_sn' => 'Order Sn',
            'user_id' => 'User ID',
            'food_id' => 'Food ID',
            'merchant_id' => 'Merchant ID',
            'order_status' => 'Order Status',
            'shipping_status' => 'Shipping Status',
            'pay_status' => 'Pay Status',
            'consignee' => 'Consignee',
            'ship_id' => 'Ship ID',
            'ship_name' => 'Ship Name',
            'pay_id' => 'Pay ID',
            'pay_way' => 'Pay Way',
            'food_amount' => 'Food Amount',
            'ship_free' => 'Ship Free',
            'discount_pay' => 'Discount Pay',
            'order_amount' => 'Order Amount',
            'order_addtime' => 'Order Addtime',
            'order_paytime' => 'Order Paytime',
            'order_speak' => 'Order Speak',
            'order_date' => 'Order Date',
            'address_id' => 'Address ID',
            'Remarks' => 'Remarks',
        ];
    }
	public function getDate(){
        return $this->hasOne(Date::className(),['deta_id'=>'order_date']);
	}

    /**
     * 查看订单号是否重复
     * @author  Dx
     * @param $number
     * @return bool
     */
    public function getOrderNumber($number)
    {
        if(empty($number))return false;
        $res = $this->find()->where(['order_sn'=>$number])->asArray()->one();
        if($res)return false;
        return true;
    }
    /**
     * 添加订单
     * @author Dx
     * @param
     * @return
     */
    public function setOrder($data)
    {
        $obj = new Functions();
        $sql = $obj->add('yfc_orders',$data);
        $res = \Yii::$app->db->createCommand($sql)->execute();

        $id = \Yii::$app->db->getLastInsertId();
        return $id;
    }
    public function savePay($id)
    {
        $res = $this->updateAll(['order_paytime'=>time(),'pay_status'=>1],'order_id in ('.$id.')');
        if(!$res)return false;
        return $res;
    }

}
 ?>