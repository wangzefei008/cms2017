<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%pms}}".
 *
 * @property string $pmid
 * @property string $type
 * @property string $email
 * @property string $pwd
 * @property integer $registertime
 */
class Pms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%pms}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'email', 'pwd', 'registertime'], 'required'],
            [['registertime'], 'integer'],
            [['type'], 'string', 'max' => 10],
            [['email'], 'string', 'max' => 30],
            [['pwd'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pmid' => 'Pmid',
            'type' => 'Type',
            'email' => 'Email',
            'pwd' => 'Pwd',
            'registertime' => 'Registertime',
        ];
    }
}
