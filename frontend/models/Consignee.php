<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "yfc_consignee".
 *
 * @property string $cons_id
 * @property integer $user_id
 * @property string $cons_name
 * @property string $cons_province
 * @property string $cons_city
 * @property string $cons_district
 * @property string $cons_address
 * @property string $cons_zipcode
 * @property string $cons_phone
 */
class Consignee extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yfc_consignee';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'cons_name', 'cons_province', 'cons_city', 'cons_district', 'cons_address', 'cons_zipcode', 'cons_phone'], 'required'],
            [['user_id'], 'integer'],
            [['cons_name', 'cons_address'], 'string', 'max' => 60],
            [['cons_province', 'cons_city', 'cons_district'], 'string', 'max' => 30],
            [['cons_zipcode'], 'string', 'max' => 10],
            [['cons_phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cons_id' => 'Cons ID',
            'user_id' => 'User ID',
            'cons_name' => 'Cons Name',
            'cons_province' => 'Cons Province',
            'cons_city' => 'Cons City',
            'cons_district' => 'Cons District',
            'cons_address' => 'Cons Address',
            'cons_zipcode' => 'Cons Zipcode',
            'cons_phone' => 'Cons Phone',
        ];
    }
    /**
     * 获取地址
     * @author Dx
     * @param  string $uid
     * @return
     */
    public function getAddress($uid)
    {
        if(empty($uid))exit('缺少参数');
        $res = $this->find()->where(['user_id'=>$uid])->asArray()->all();
        if(empty($res))return false;
        return $res;
    }

}
