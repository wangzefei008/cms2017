<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%power}}".
 *
 * @property integer $power_id
 * @property string $power_conteollers
 * @property string $power_methods
 * @property string $power_name
 */
class Power extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%power}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['power_conteollers', 'power_methods'], 'string', 'max' => 20],
            [['power_name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'power_id' => 'Power ID',
            'power_conteollers' => 'Power Conteollers',
            'power_methods' => 'Power Methods',
            'power_name' => 'Power Name',
        ];
    }
}
