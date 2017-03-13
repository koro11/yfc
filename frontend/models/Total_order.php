<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "yfc_total_order".
 *
 * @property integer $total_order_id
 * @property integer $total_order_user
 * @property string $total_order_sn
 * @property integer $total_creat_time
 * @property string $total_order_details
 */
class Total_order extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%total_order}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['total_order_user', 'total_order_sn', 'total_creat_time', 'total_order_details', 'total_order_price', 'total_order_address'], 'required'],
            [['total_order_user', 'total_creat_time', 'total_order_address', 'total_order_pay'], 'integer'],
            [['total_order_price'], 'number'],
            [['total_order_sn', 'total_order_details'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'total_order_id' => 'Total Order ID',
            'total_order_user' => 'Total Order User',
            'total_order_sn' => 'Total Order Sn',
            'total_creat_time' => 'Total Creat Time',
            'total_order_details' => 'Total Order Details',
            'total_order_price' => 'Total Order Price',
            'total_order_address' => 'Total Order Address',
            'total_order_pay' => 'Total Order Pay',
        ];
    }


    /**
     * 添加主订单
     * @param $param
     * @return bool
     */
    public function setOrder($param)
    {
        if(empty($param))return false;
        $this->setAttributes($param);
        $res = $this->save();
        if(!$res){
            return false;
        }else{
            return true;
        }

    }

    /**
     * 查询订单
     * @param $order_sn
     * @param $uid
     * @return array|bool|null|\yii\db\ActiveRecord
     */
    public function getOne($order_sn,$uid)
    {
       if(empty($order_sn))return false;
       $res =  $this->find('total_order_user')->where(['total_order_sn'=>$order_sn,'total_order_user'=>$uid])->one();
       if(!$res)return false;
       return $res;
    }
    /**
     * 修改支付状态
     * @author
     * @param $id
     * @return bool
     */
    public function savePay($order)

    {
        $res = $this->updateAll(array('total_order_pay'=>1),'order_sn in ('.$order.')');
        if(!$res)return false;
        return true;
    }
}
