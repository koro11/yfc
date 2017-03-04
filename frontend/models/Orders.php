<?php 
namespace frontend\models;

use yii\db\ActiveRecord;

class Orders extends ActiveRecord
{
	public function getDate(){
        return $this->hasOne(Date::className(),['deta_id'=>'order_date']);
	}

    public function getUsers(){
        return $this->hasOne(Users::className(),['user_id'=>'user_id']);
    }
    public function getFood(){
        return $this->hasMany(Food::className(),['food_id'=>'food_id']);
    }


}
 ?>