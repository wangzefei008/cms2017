<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%category_major}}".
 *
 * @property string $id
 * @property integer $parentid
 * @property string $categoryname
 * @property integer $category_order
 */
class Major extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%category_major}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parentid', 'categoryname'], 'required'],
            [['parentid', 'category_order'], 'integer'],
            [['categoryname'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parentid' => 'Parentid',
            'categoryname' => 'Categoryname',
            'category_order' => 'Category Order',
        ];
    }
}
