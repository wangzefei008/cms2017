<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%new_captcha}}".
 *
 * @property integer $captcha_id
 * @property string $captcha_width
 * @property string $captcha_height
 * @property string $captcha_textcolor
 * @property string $captcha_textfontsize
 * @property string $captcha_textlength
 */
class NewCaptcha extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%new_captcha}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['captcha_width', 'captcha_height', 'captcha_textcolor', 'captcha_textfontsize', 'captcha_textlength'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'captcha_id' => 'Captcha ID',
            'captcha_width' => 'Captcha Width',
            'captcha_height' => 'Captcha Height',
            'captcha_textcolor' => 'Captcha Textcolor',
            'captcha_textfontsize' => 'Captcha Textfontsize',
            'captcha_textlength' => 'Captcha Textlength',
        ];
    }
}
