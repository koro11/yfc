<?php

namespace frontend\models;

use Yii;
use Yii\db\query;

/**
 * This is the model class for table "yfc_merchant".
 *
 * @property integer $mer_id
 * @property string $mer_name
 * @property string $mer_pass
 * @property integer $mer_status
 * @property string $mer_address
 * @property string $mer_phone
 * @property string $mer_logo
 * @property string $mer_register_time
 * @property string $mer_last_login
 * @property string $mer_now_login
 */
class Merchant extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yfc_merchant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mer_name', 'mer_pass', 'mer_address', 'mer_phone', 'mer_register_time', 'mer_last_login', 'mer_now_login'], 'required'],
            [['mer_status'], 'integer'],
            [['mer_name', 'mer_logo'], 'string', 'max' => 60],
            [['mer_pass'], 'string', 'max' => 32],
            [['mer_address'], 'string', 'max' => 80],
            [['mer_phone'], 'string', 'max' => 20],
            [['mer_register_time', 'mer_last_login', 'mer_now_login'], 'string', 'max' => 13],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'mer_id' => 'Mer ID',
            'mer_name' => 'Mer Name',
            'mer_pass' => 'Mer Pass',
            'mer_status' => 'Mer Status',
            'mer_address' => 'Mer Address',
            'mer_phone' => 'Mer Phone',
            'mer_logo' => 'Mer Logo',
            'mer_register_time' => 'Mer Register Time',
            'mer_last_login' => 'Mer Last Login',
            'mer_now_login' => 'Mer Now Login',
        ];
    }
    /**
     * 商家是否下线
     * @author Dx
     * @param
     * @return boolean
     */
    public function checkOffline($sellerId)
    {
        if(empty($sellerId))return false;
        $res = $this->find()->where(['mer_id'=>$sellerId])->one();
        if(empty($res))return false;
        return $res;
    }

//    public static function tableName()
//    {
//        return 'merchant';
//    }

//    /**
//     * @inheritdoc
//     */
//    public function rules()
//    {
//        return [
//            [['category_name'], 'string', 'max' => 30],
//        ];
//    }


//    public function getCategorys()
//    {
//        // 第一个参数为要关联的子表模型类名，
//        // 第二个参数指定 通过子表的category_id，关联主表的employ_id字段
//        return $this->hasMany(EmployerForm::className(), ['category_id' => 'category_id']);
//    }


    public function getMerinfo()
    {
        return $this->hasOne(MerchantInfo::className(), ['info_mer' => 'mer_id']);
    }

}


