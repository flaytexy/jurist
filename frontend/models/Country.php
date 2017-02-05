<?php
namespace frontend\models;

class Country extends \frontend\components\ActiveRecord
{
    public static function tableName()
    {
        return 'country';
    }

    public function rules()
    {
        return [
/*            ['name', 'required'],
            ['frequency', 'integer'],
            ['name', 'string', 'max' => 64],*/
        ];
    }
}