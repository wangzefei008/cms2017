<?php

namespace app\models;
use yii\db\ActiveRecord;
use Yii;

class Hotword extends \yii\db\ActiveRecord
{
    public function rules(){
        return[
            ['w_word','string']
        ];
    }
}
