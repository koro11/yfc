<?php 
namespace frontend\models;

use yii\db\ActiveRecord;

class Orders extends ActiveRecord
{


	public function getDate(){
    return $this->hasOne(Date::className(),['deta_id'=>'order_date']);

	}


}
 ?>