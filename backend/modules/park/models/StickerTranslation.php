<?php

namespace app\modules\park\models;

use yii\db\ActiveRecord;

/**
 * Class StickerTranslation
 * @package app\modules\park\models
 *
 * @property int $id
 * @property string $title
 * @property int $status
 */
class StickerTranslation extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public function rules()
    {
        return [
            [['title'], 'required', 'message' => 'Введите заголовок'],
            [['status'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
        ];
    }
}
