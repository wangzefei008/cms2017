<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%filter}}".
 *
 * @property integer $filter_id
 * @property string $filter
 * @property string $filter_tips
 */
class Filter extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%filter}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filter'], 'string', 'max' => 200],
            [['filter_tips'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'filter_id' => 'Filter ID',
            'filter' => 'Filter',
            'filter_tips' => 'Filter Tips',
        ];
    }
}
