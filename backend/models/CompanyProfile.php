<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%company_profile}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $tpl
 * @property string $companyname
 * @property integer $nature
 * @property string $nature_cn
 * @property integer $trade
 * @property string $trade_cn
 * @property integer $district
 * @property integer $sdistrict
 * @property string $district_cn
 * @property integer $street
 * @property string $street_cn
 * @property integer $scale
 * @property string $scale_cn
 * @property string $registered
 * @property string $currency
 * @property string $address
 * @property string $contact
 * @property string $telephone
 * @property string $landline_tel
 * @property string $email
 * @property string $website
 * @property string $license
 * @property string $certificate_img
 * @property string $logo
 * @property string $contents
 * @property integer $audit
 * @property integer $map_open
 * @property string $map_x
 * @property string $map_y
 * @property integer $map_zoom
 * @property string $addtime
 * @property string $refreshtime
 * @property string $click
 * @property integer $user_status
 * @property integer $yellowpages
 * @property integer $contact_show
 * @property integer $telephone_show
 * @property integer $address_show
 * @property integer $email_show
 * @property integer $robot
 * @property integer $resume_processing
 * @property string $tag
 * @property integer $wzp_tpl
 */
class CompanyProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%company_profile}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['uid', 'tpl', 'companyname', 'nature', 'nature_cn', 'trade', 'trade_cn', 'district', 'sdistrict', 'street', 'street_cn', 'scale', 'scale_cn', 'registered', 'currency', 'address', 'contact', 'telephone', 'landline_tel', 'email', 'website', 'license', 'certificate_img', 'logo', 'contents', 'map_x', 'map_y', 'map_zoom', 'addtime', 'refreshtime', 'tag'], 'required'],
            // [['companyname', 'email','logo', 'contents'], 'required'],
            [['uid', 'nature', 'trade', 'district', 'sdistrict', 'street', 'scale', 'audit', 'map_open', 'map_zoom', 'add_time', 'refreshtime', 'click', 'user_status', 'yellowpages', 'contact_show', 'telephone_show', 'address_show', 'email_show', 'robot', 'resume_processing', 'wzp_tpl'], 'integer'],
            [['contents'], 'string'],
            [['tpl', 'companyname', 'tag'], 'string', 'max' => 60],
            [['nature_cn', 'trade_cn', 'scale_cn', 'logo'], 'string', 'max' => 100],
            [['district_cn', 'contact', 'email', 'website'], 'string', 'max' => 100],
            [['street_cn', 'landline_tel', 'map_x', 'map_y'], 'string', 'max' => 50],
            [['registered'], 'string', 'max' => 150],
            [['currency'], 'string', 'max' => 10],
            [['address'], 'string', 'max' => 250],
            [['telephone'], 'string', 'max' => 130],
            [['license'], 'string', 'max' => 120],
            [['certificate_img'], 'string', 'max' => 80]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'c_id' => 'ID',
            'uid' => 'Uid',
            'tpl' => 'Tpl',
            'companyname' => 'Companyname',
            'nature' => 'Nature',
            'nature_cn' => 'Nature Cn',
            'trade' => 'Trade',
            'trade_cn' => 'Trade Cn',
            'district' => 'District',
            'sdistrict' => 'Sdistrict',
            'district_cn' => 'District Cn',
            'street' => 'Street',
            'street_cn' => 'Street Cn',
            'scale' => 'Scale',
            'scale_cn' => 'Scale Cn',
            'registered' => 'Registered',
            'currency' => 'Currency',
            'address' => 'Address',
            'contact' => 'Contact',
            'telephone' => 'Telephone',
            'landline_tel' => 'Landline Tel',
            'email' => 'Email',
            'website' => 'Website',
            'license' => 'License',
            'certificate_img' => 'Certificate Img',
            'logo' => 'Logo',
            'contents' => 'Contents',
            'audit' => 'Audit',
            'map_open' => 'Map Open',
            'map_x' => 'Map X',
            'map_y' => 'Map Y',
            'map_zoom' => 'Map Zoom',
            'add_time' => 'Addtime',
            'refreshtime' => 'Refreshtime',
            'click' => 'Click',
            'user_status' => 'User Status',
            'yellowpages' => 'Yellowpages',
            'contact_show' => 'Contact Show',
            'telephone_show' => 'Telephone Show',
            'address_show' => 'Address Show',
            'email_show' => 'Email Show',
            'robot' => 'Robot',
            'resume_processing' => 'Resume Processing',
            'tag' => 'Tag',
            'wzp_tpl' => 'Wzp Tpl',
        ];
    }
}
