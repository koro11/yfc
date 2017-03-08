<?php 
namespace frontend\models;

use yii\db\ActiveRecord;

class Date extends ActiveRecord
{
	public function getOrders(){
    return $this->hasOne(Orders::className(),['order_id'=>'order_id']);
}
}
 ?>