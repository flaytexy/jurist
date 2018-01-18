<?php

namespace backend\modules\park\models;

use yii\db\ActiveRecord;

/**
 * Class ServiceTranslation
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property int $service_id
 * @property string $language
 * @property string $title
 * @property string $description
 * @property int $status
 */
class ServiceTranslation extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок'],
            [['description'], 'required', 'message' => 'Введите описание'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'description' => 'Описание',
            'language' => 'Язык',
        ];
    }
}
