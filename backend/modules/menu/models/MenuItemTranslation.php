<?php

namespace app\modules\menu\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class MenuItemTranslation extends ActiveRecord
{
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public function rules()
    {
        return [
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['menu_item_id', 'link', 'title'], 'safe'],
        ];
    }
}
