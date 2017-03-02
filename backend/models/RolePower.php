<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%role_power}}".
 *
 * @property integer $rp_id
 * @property integer $role_id
 * @property integer $power_id
 */
class RolePower extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%role_power}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'power_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'rp_id' => 'Rp ID',
            'role_id' => 'Role ID',
            'power_id' => 'Power ID',
        ];
    }
}
