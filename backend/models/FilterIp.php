<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%filter_ip}}".
 *
 * @property integer $ip_id
 * @property string $filter_ip
 * @property string $filter_ip_tips
 */
class FilterIp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%filter_ip}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['filter_ip'], 'string', 'max' => 50],
            [['filter_ip_tips'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ip_id' => 'Ip ID',
            'filter_ip' => 'Filter Ip',
            'filter_ip_tips' => 'Filter Ip Tips',
        ];
    }
}
