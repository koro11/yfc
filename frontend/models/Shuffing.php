<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "{{%shuffing}}".
 *
 * @property string $pic_id
 * @property string $path
 * @property integer $is_show
 * @property integer $sort
 * @property string $shuffing_desc
 * @property string $shuffing_link
 */
class Shuffing extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%shuffing}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_show', 'sort'], 'integer'],
            [['path'], 'string', 'max' => 80],
            [['shuffing_desc', 'shuffing_link'], 'string', 'max' => 60],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pic_id' => 'Pic ID',
            'path' => 'Path',
            'is_show' => 'Is Show',
            'sort' => 'Sort',
            'shuffing_desc' => 'Shuffing Desc',
            'shuffing_link' => 'Shuffing Link',
        ];
    }
}
