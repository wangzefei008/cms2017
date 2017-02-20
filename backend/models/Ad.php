<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%ad}}".
 *
 * @property string $id
 * @property string $alias
 * @property integer $is_display
 * @property integer $category_id
 * @property integer $type_id
 * @property string $title
 * @property string $note
 * @property string $show_order
 * @property string $addtime
 * @property string $starttime
 * @property integer $deadline
 * @property string $text_content
 * @property string $text_url
 * @property string $text_color
 * @property string $img_path
 * @property string $img_url
 * @property string $img_explain
 * @property integer $img_uid
 * @property string $code_content
 * @property string $flash_path
 * @property string $flash_width
 * @property string $flash_height
 * @property integer $floating_type
 * @property string $floating_width
 * @property string $floating_height
 * @property string $floating_url
 * @property string $floating_path
 * @property string $floating_left
 * @property string $floating_right
 * @property integer $floating_top
 * @property string $video_path
 * @property string $video_width
 * @property string $video_height
 */
class Ad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%ad}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'category_id', 'type_id', 'title','addtime', 'starttime', 'deadline','text_content'], 'required'],
            [['is_display', 'category_id', 'type_id', 'show_order', 'addtime', 'starttime', 'deadline', 'img_uid', 'flash_width', 'flash_height', 'floating_type', 'floating_width', 'floating_height', 'floating_top', 'video_width', 'video_height'], 'integer'],
            [['code_content'], 'string'],
            [['alias'], 'string', 'max' => 80],
            [['title'], 'string', 'max' => 100],
            [['note'], 'string', 'max' => 230],
            [['text_content', 'text_url', 'img_path', 'img_url', 'img_explain', 'flash_path', 'floating_url', 'floating_path', 'video_path'], 'string', 'max' => 250],
            [['text_color'], 'string', 'max' => 60],
            [['floating_left', 'floating_right'], 'string', 'max' => 10]
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
            'is_display' => 'Is Display',
            'category_id' => 'Category ID',
            'type_id' => 'Type ID',
            'title' => 'Title',
            'note' => 'Note',
            'show_order' => 'Show Order',
            'addtime' => 'Addtime',
            'starttime' => 'Starttime',
            'deadline' => 'Deadline',
            'text_content' => 'Text Content',
            'text_url' => 'Text Url',
            'text_color' => 'Text Color',
            'img_path' => 'Img Path',
            'img_url' => 'Img Url',
            'img_explain' => 'Img Explain',
            'img_uid' => 'Img Uid',
            'code_content' => 'Code Content',
            'flash_path' => 'Flash Path',
            'flash_width' => 'Flash Width',
            'flash_height' => 'Flash Height',
            'floating_type' => 'Floating Type',
            'floating_width' => 'Floating Width',
            'floating_height' => 'Floating Height',
            'floating_url' => 'Floating Url',
            'floating_path' => 'Floating Path',
            'floating_left' => 'Floating Left',
            'floating_right' => 'Floating Right',
            'floating_top' => 'Floating Top',
            'video_path' => 'Video Path',
            'video_width' => 'Video Width',
            'video_height' => 'Video Height',
        ];
    }
}
