<?php
namespace frontend\models;

class Option extends \common\components\ActiveRecord
{
    public static function tableName()
    {
        return 'easyii_options';
    }

    public function rules()
    {
        return [
            ['name', 'required'],
            ['frequency', 'integer'],
            ['name', 'string', 'max' => 64],
        ];
    }
}