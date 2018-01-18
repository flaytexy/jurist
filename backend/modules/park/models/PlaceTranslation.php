<?php

namespace backend\modules\park\models;

use yii\db\ActiveRecord;

/**
 * Class PlaceTranslation
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property int $place_id
 * @property string $language
 * @property string $title
 * @property int $status
 */
class PlaceTranslation extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function rules()
    {
        return [
            [['place_id'], 'exist', 'targetClass' => Place::className(), 'targetAttribute' => 'id', 'message' => 'Местоположение не существует'],
            [['title'], 'required', 'message' => 'Необходимо заполнить'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'language' => 'Язык',
        ];
    }
}
