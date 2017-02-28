<?php 
namespace frontend\models;

use yii\db\ActiveRecord;

class User_ticket extends ActiveRecord
{
	


	public function getTickets(){
    return $this->hasOne(Tickets::className(),['tic_id'=>'tic_id']);
    
	}


}
 ?>