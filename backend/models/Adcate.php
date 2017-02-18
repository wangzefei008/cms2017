<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ad_category}}".
 *
 * @property integer $id
 * @property string $alias
 * @property string $type_id
 * @property string $categoryname
 * @property integer $admin_set
 * @property integer $expense
 */
class Adcate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad_category}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'type_id', 'categoryname', 'expense'], 'required'],
            [['type_id', 'admin_set', 'expense'], 'integer'],
            [['alias', 'categoryname'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
            'type_id' => 'Type ID',
            'categoryname' => 'Categoryname',
            'admin_set' => 'Admin Set',
            'expense' => 'Expense',
        ];
    }
}
