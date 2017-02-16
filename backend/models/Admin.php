<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%admin}}".
 *
 * @property integer $admin_id
 * @property string $admin_name
 * @property string $email
 * @property string $pwd
 * @property string $pwd_hash
 * @property string $purview
 * @property string $rank
 * @property integer $add_time
 * @property integer $last_login_time
 * @property string $last_login_ip
 */
class Admin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['admin_name', 'email', 'pwd', 'pwd_hash', 'purview', 'rank', 'add_time', 'last_login_time', 'last_login_ip'], 'required'],
            [['purview'], 'string'],
            [['add_time', 'last_login_time'], 'integer'],
            [['admin_name', 'email'], 'string', 'max' => 40],
            [['pwd', 'rank'], 'string', 'max' => 32],
            [['pwd_hash'], 'string', 'max' => 30],
            [['last_login_ip'], 'string', 'max' => 15]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'admin_id' => 'Admin ID',
            'admin_name' => 'Admin Name',
            'email' => 'Email',
            'pwd' => 'Pwd',
            'pwd_hash' => 'Pwd Hash',
            'purview' => 'Purview',
            'rank' => 'Rank',
            'add_time' => 'Add Time',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
        ];
    }
}
