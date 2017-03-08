<?php 
namespace frontend\models;

use yii\db\ActiveRecord;


class User_info extends ActiveRecord
{
	
	public function getUsers(){
    return $this->hasOne(Users::className(),['user_id'=>'user_id']);
    
	}

	

}
 ?>

