<?php 
namespace frontend\models;

use yii\db\ActiveRecord;

class Collect extends ActiveRecord
{
	


	public function getMerchant(){
    return $this->hasOne(Merchant::className(),['mer_id'=>'mer_id']);
    
	}


}
 ?>