<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * Yii2.0 Speak  
 * 餐饮评论模型类
 * @author Danny
 * @email  351518543@qq.com
 * @Time   2017-3-1 
 */ 
class Speak extends ActiveRecord
{
   
     //关联 Food 表  
    public function getFood()
    {      
        // 第一个参数为要关联的子表模型类名称， 
        // 第二个参数指定通过子表的 food_mer 去关联主表的 food_id 字段  
        return $this->hasOne(Food::className(), ['food_id' => 'food_id']);  
    } 

     //关联 Food 表  
    public function getUser_info()
    {      
        // 第一个参数为要关联的子表模型类名称， 
        // 第二个参数指定通过子表的 info_mer 去关联主表的 mer_id 字段  
        return $this->hasOne(User_info::className(), ['user_id' => 'speak_user']);  
    }  
}