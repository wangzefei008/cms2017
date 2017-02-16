<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%config}}".
 *
 * @property integer $id
 * @property string $w_name
 * @property string $w_title
 * @property string $w_keyword
 * @property string $w_desc
 * @property string $w_logo
 * @property string $web
 * @property integer $pay_num
 * @property string $pay_type
 * @property string $member_ad
 * @property string $web_content
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%config}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['w_name'], 'required'],
            [['pay_num'], 'integer'],
            [['w_name'], 'string', 'max' => 100],
            [['w_title', 'w_keyword', 'w_desc', 'w_logo', 'web', 'pay_type', 'member_ad', 'web_content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'w_name' => 'W Name',
            'w_title' => 'W Title',
            'w_keyword' => 'W Keyword',
            'w_desc' => 'W Desc',
            'w_logo' => 'W Logo',
            'web' => 'Web',
            'pay_num' => 'Pay Num',
            'pay_type' => 'Pay Type',
            'member_ad' => 'Member Ad',
            'web_content' => 'Web Content',
        ];
    }
}
