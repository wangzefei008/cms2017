<?php

namespace common\models;

use yii\base\Model;

class EntryForm extends Model
{
    public $name;

    public function rules()
    {
        return [
            [['name'], 'required'],
        ];
    }
}