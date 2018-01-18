<?php

namespace backend\modules\park\models;

use yii\db\ActiveRecord;

class CarTranslation extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function rules()
    {
        return [
            [['title'], 'safe'],
            [['slug'], 'required', 'message' => 'Введите постоянную ссылку'],
            [['equipment'], 'safe'],
            [['status'], 'boolean'],
            [['youtube_id'], 'match', 'pattern' => '/^[\-_0-9a-zA-z]+$/', 'message' => 'Введите корректный YouTube-видео ID'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголок',
            'slug' => 'Постоянная ссылка',
            'equipment' => 'Комплектация (через запятую)',
            'youtube_id' => 'YouTube-видео ID',
        ];
    }
}
