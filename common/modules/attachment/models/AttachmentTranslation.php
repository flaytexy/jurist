<?php

namespace common\modules\attachment\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * Class AttachmentTranslation
 * @package common\modules\attachment\models
 *
 * @property int $id
 * @property int $attachment_id
 * @property string $language
 * @property string $title
 */
class AttachmentTranslation extends ActiveRecord
{
    public function rules()
    {
        return [
            [['attachment_id', 'title'], 'safe'],
            [['language'], 'in', 'range' => ['ru-RU', 'uk-UA', 'en-US'], 'message' => 'Неверное значение языка'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => 'Заголовок',
        ];
    }
}
