<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%jobs}}".
 *
 * @property string $id
 * @property string $uid
 * @property string $jobs_name
 * @property string $companyname
 * @property string $company_id
 * @property string $company_addtime
 * @property integer $company_audit
 * @property integer $recommend
 * @property integer $emergency
 * @property string $highlight
 * @property integer $stick
 * @property integer $nature
 * @property string $nature_cn
 * @property integer $sex
 * @property string $sex_cn
 * @property string $age
 * @property integer $amount
 * @property integer $topclass
 * @property integer $category
 * @property integer $subclass
 * @property string $category_cn
 * @property integer $trade
 * @property string $trade_cn
 * @property integer $scale
 * @property string $scale_cn
 * @property integer $district
 * @property integer $sdistrict
 * @property string $district_cn
 * @property string $street
 * @property string $street_cn
 * @property string $tag
 * @property string $tag_cn
 * @property integer $education
 * @property string $education_cn
 * @property integer $experience
 * @property string $experience_cn
 * @property integer $wage
 * @property string $wage_cn
 * @property integer $negotiable
 * @property integer $graduate
 * @property string $contents
 * @property string $addtime
 * @property string $deadline
 * @property string $refreshtime
 * @property string $setmeal_deadline
 * @property integer $setmeal_id
 * @property string $setmeal_name
 * @property integer $audit
 * @property integer $display
 * @property string $click
 * @property string $key
 * @property integer $user_status
 * @property integer $robot
 * @property string $tpl
 * @property double $map_x
 * @property double $map_y
 * @property integer $add_mode
 */
class Jobs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%jobs}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'jobs_name', 'companyname', 'company_id', 'company_addtime', 'highlight', 'stick', 'nature', 'nature_cn', 'sex_cn', 'age', 'amount', 'topclass', 'category', 'subclass', 'trade', 'trade_cn', 'scale', 'scale_cn', 'district', 'sdistrict', 'district_cn', 'street', 'tag', 'tag_cn', 'education', 'education_cn', 'experience', 'experience_cn', 'wage', 'wage_cn', 'negotiable', 'contents', 'addtime', 'deadline', 'refreshtime', 'setmeal_id', 'setmeal_name', 'key', 'tpl', 'map_x', 'map_y'], 'required'],
            [['uid', 'company_id', 'company_addtime', 'company_audit', 'recommend', 'emergency', 'stick', 'nature', 'sex', 'amount', 'topclass', 'category', 'subclass', 'trade', 'scale', 'district', 'sdistrict', 'street', 'education', 'experience', 'wage', 'negotiable', 'graduate', 'addtime', 'deadline', 'refreshtime', 'setmeal_deadline', 'setmeal_id', 'audit', 'display', 'click', 'user_status', 'robot', 'add_mode'], 'integer'],
            [['contents', 'key'], 'string'],
            [['map_x', 'map_y'], 'number'],
            [['jobs_name', 'nature_cn', 'trade_cn', 'scale_cn', 'education_cn', 'experience_cn', 'wage_cn'], 'string', 'max' => 30],
            [['companyname', 'street_cn', 'tag'], 'string', 'max' => 50],
            [['highlight'], 'string', 'max' => 7],
            [['sex_cn'], 'string', 'max' => 3],
            [['age'], 'string', 'max' => 10],
            [['category_cn', 'district_cn', 'tag_cn'], 'string', 'max' => 100],
            [['setmeal_name', 'tpl'], 'string', 'max' => 60]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'jobs_name' => 'Jobs Name',
            'companyname' => 'Companyname',
            'company_id' => 'Company ID',
            'company_addtime' => 'Company Addtime',
            'company_audit' => 'Company Audit',
            'recommend' => 'Recommend',
            'emergency' => 'Emergency',
            'highlight' => 'Highlight',
            'stick' => 'Stick',
            'nature' => 'Nature',
            'nature_cn' => 'Nature Cn',
            'sex' => 'Sex',
            'sex_cn' => 'Sex Cn',
            'age' => 'Age',
            'amount' => 'Amount',
            'topclass' => 'Topclass',
            'category' => 'Category',
            'subclass' => 'Subclass',
            'category_cn' => 'Category Cn',
            'trade' => 'Trade',
            'trade_cn' => 'Trade Cn',
            'scale' => 'Scale',
            'scale_cn' => 'Scale Cn',
            'district' => 'District',
            'sdistrict' => 'Sdistrict',
            'district_cn' => 'District Cn',
            'street' => 'Street',
            'street_cn' => 'Street Cn',
            'tag' => 'Tag',
            'tag_cn' => 'Tag Cn',
            'education' => 'Education',
            'education_cn' => 'Education Cn',
            'experience' => 'Experience',
            'experience_cn' => 'Experience Cn',
            'wage' => 'Wage',
            'wage_cn' => 'Wage Cn',
            'negotiable' => 'Negotiable',
            'graduate' => 'Graduate',
            'contents' => 'Contents',
            'addtime' => 'Addtime',
            'deadline' => 'Deadline',
            'refreshtime' => 'Refreshtime',
            'setmeal_deadline' => 'Setmeal Deadline',
            'setmeal_id' => 'Setmeal ID',
            'setmeal_name' => 'Setmeal Name',
            'audit' => 'Audit',
            'display' => 'Display',
            'click' => 'Click',
            'key' => 'Key',
            'user_status' => 'User Status',
            'robot' => 'Robot',
            'tpl' => 'Tpl',
            'map_x' => 'Map X',
            'map_y' => 'Map Y',
            'add_mode' => 'Add Mode',
        ];
    }
}
