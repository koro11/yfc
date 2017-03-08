<?php
namespace frontend\models;

use yii\db\ActiveRecord;

/**
 * Yii2.0 Merchant  
 * 商家详情模型
 * @author Danny
 * @email  351518543@qq.com
 * @Time   2017-2-23 
 */ 
class Merchant_info extends ActiveRecord
{

	//关联 Merchant 表  
    public function getMerchant()
    {      
        // 第一个参数为要关联的子表模型类名称， 
        // 第二个参数指定通过子表的 info_mer 去关联主表的 mer_id 字段  
        return $this->hasOne(Merchant::className(), ['mer_id' => 'info_mer']);  
    }  
 
    //关联 Merchant_category 表  
    public function getMer_category()
    {      
        // 第一个参数为要关联的子表模型类名称， 
        // 第二个参数指定通过子表的 info_mer 去关联主表的 mer_id 字段  
        return $this->hasOne(Mer_category::className(), ['cat_id' => 'info_mer_cate']);  
    }  
}