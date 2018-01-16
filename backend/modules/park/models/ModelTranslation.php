<?php

namespace app\modules\park\models;

use yii\db\ActiveRecord;

/**
 * Class ModelTranslation
 * @package app\modules\park\models
 *
 * @property int $id
 * @property int $model_id
 * @property string $language
 * @property string $title
 * @property string $slug
 * @property int $status
 */
class ModelTranslation extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок модели'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку для модели'],
            //[['slug'], 'unique', 'message' => 'Постоянная ссылка должна быть уникальной'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
            'slug' => 'Постоянная ссылка',
            'language' => 'Язык',
        ];
    }

    public function getModel()
    {
        return $this->hasOne(Model::className(), ['id' => 'model_id']);
    }
}
