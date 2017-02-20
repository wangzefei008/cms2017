<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%members}}".
 *
 * @property string $uid
 * @property integer $utype
 * @property string $username
 * @property string $email
 * @property integer $email_audit
 * @property string $mobile
 * @property integer $mobile_audit
 * @property string $password
 * @property string $pwd_hash
 * @property string $reg_time
 * @property string $reg_ip
 * @property string $last_login_time
 * @property string $last_login_ip
 * @property string $qq_openid
 * @property string $sina_access_token
 * @property string $taobao_access_token
 * @property string $qq_nick
 * @property string $sina_nick
 * @property string $taobao_nick
 * @property string $weixin_nick
 * @property integer $qq_binding_time
 * @property integer $sina_binding_time
 * @property integer $taobao_binding_time
 * @property integer $status
 * @property string $avatars
 * @property integer $robot
 * @property integer $consultant
 * @property string $weixin_openid
 * @property string $bindingtime
 * @property string $remind_email_time
 * @property string $imei
 * @property integer $reg_type
 */
class Members extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%members}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['utype', 'email_audit', 'mobile_audit', 'reg_time', 'last_login_time', 'qq_binding_time', 'sina_binding_time', 'taobao_binding_time', 'status', 'robot', 'consultant', 'bindingtime', 'remind_email_time', 'reg_type'], 'integer'],
            [['email', 'mobile', 'pwd_hash', 'reg_time', 'reg_ip', 'last_login_time', 'last_login_ip', 'qq_openid', 'sina_access_token', 'taobao_access_token', 'qq_nick', 'sina_nick', 'taobao_nick', 'weixin_nick', 'qq_binding_time', 'sina_binding_time', 'taobao_binding_time', 'avatars', 'consultant', 'bindingtime'], 'required'],
            [['username'], 'string', 'max' => 60],
            [['email'], 'string', 'max' => 80],
            [['mobile'], 'string', 'max' => 11],
            [['password', 'qq_nick', 'sina_nick', 'taobao_nick', 'weixin_nick'], 'string', 'max' => 100],
            [['pwd_hash'], 'string', 'max' => 30],
            [['reg_ip', 'last_login_ip'], 'string', 'max' => 15],
            [['qq_openid', 'sina_access_token', 'taobao_access_token', 'weixin_openid', 'imei'], 'string', 'max' => 50],
            [['avatars'], 'string', 'max' => 32],
            [['username'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'uid' => 'Uid',
            'utype' => 'Utype',
            'username' => 'Username',
            'email' => 'Email',
            'email_audit' => 'Email Audit',
            'mobile' => 'Mobile',
            'mobile_audit' => 'Mobile Audit',
            'password' => 'Password',
            'pwd_hash' => 'Pwd Hash',
            'reg_time' => 'Reg Time',
            'reg_ip' => 'Reg Ip',
            'last_login_time' => 'Last Login Time',
            'last_login_ip' => 'Last Login Ip',
            'qq_openid' => 'Qq Openid',
            'sina_access_token' => 'Sina Access Token',
            'taobao_access_token' => 'Taobao Access Token',
            'qq_nick' => 'Qq Nick',
            'sina_nick' => 'Sina Nick',
            'taobao_nick' => 'Taobao Nick',
            'weixin_nick' => 'Weixin Nick',
            'qq_binding_time' => 'Qq Binding Time',
            'sina_binding_time' => 'Sina Binding Time',
            'taobao_binding_time' => 'Taobao Binding Time',
            'status' => 'Status',
            'avatars' => 'Avatars',
            'robot' => 'Robot',
            'consultant' => 'Consultant',
            'weixin_openid' => 'Weixin Openid',
            'bindingtime' => 'Bindingtime',
            'remind_email_time' => 'Remind Email Time',
            'imei' => 'Imei',
            'reg_type' => 'Reg Type',
        ];
    }
}
