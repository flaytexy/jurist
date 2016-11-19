<?php
namespace frontend\models;

class Tag extends \frontend\components\ActiveRecord
{
    public static function tableName()
    {
        return 'easyii_tags';
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