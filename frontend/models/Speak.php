<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "yfc_speak".
 *
 * @property string $speak_id
 * @property integer $food_id
 * @property string $speak_user
 * @property string $speak_body
 */
class Speak extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'yfc_speak';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['food_id', 'speak_user', 'speak_body'], 'required'],
            [['food_id'], 'integer'],
            [['speak_user'], 'string', 'max' => 15],
            [['speak_body'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'speak_id' => 'Speak ID',
            'food_id' => 'Food ID',
            'speak_user' => 'Speak User',
            'speak_body' => 'Speak Body',
        ];
    }
    /**
     * 评论总条数
     * @author Dx
     * @param  intval $id  餐饮ID
     * @return intval $num 总条数
     */
    public function getCount($id)
    {
        if(empty($id))return false;
        $num = $this->find()->where(['food_id'=>$id])->count();
        if(!$num)return false;
        return $num;
    }
    /**
     * 分页展示数据
     * @author Dx
     * @param  intval $id   餐饮ID
     * @param  intval $now 当前页
     * @param  intval $pageSize 每页条数
     * @return
     */
    public function getComment($id,$now=1,$pageSize)
    {
        if(empty($id))return false;
        $offset = ($now-1)*$pageSize;
        $res = $this->find()->where(['food_id'=>$id])->offset($offset)->limit($pageSize)->asArray()->all();
        if(empty($res))return false;
        return $res;
    }
}
