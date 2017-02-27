<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%hot_word}}".
 *
 * @property string $word_id
 * @property string $hot_word
 * @property integer $hot_length
 * @property integer $word_type
 * @property integer $search_time
 * @property integer $show_status
 */
class Hot_word extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%hot_word}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hot_length', 'word_type', 'search_time', 'show_status'], 'integer'],
            [['hot_word'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'word_id' => 'Word ID',
            'hot_word' => 'Hot Word',
            'hot_length' => 'Hot Length',
            'word_type' => 'Word Type',
            'search_time' => 'Search Time',
            'show_status' => 'Show Status',
        ];
    }
}
