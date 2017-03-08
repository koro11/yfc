<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * Yii2.0 Food  
 * 餐饮模型类
 * @author Danny
 * @email  351518543@qq.com
 * @Time   2017-2-23 
 */ 
class Food extends ActiveRecord
{
   
     //关联 Food_category 表  
    public function getFood_category()
    {      
        // 第一个参数为要关联的子表模型类名称， 
        // 第二个参数指定通过子表的 info_mer 去关联主表的 mer_id 字段  
        return $this->hasOne(Food_category::className(), ['cate_id' => 'food_cate']);  
    }  
    
}