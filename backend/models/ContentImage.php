<?php

namespace backend\models;

use backend\modules\attachment\models\Attachment;
use yii\db\ActiveRecord;

class ContentImage extends ActiveRecord
{
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{content_image}}';
    }

    public function rules()
    {
        return [
            [['content_id'], 'exist', 'targetClass' => Content::className(), 'targetAttribute' => 'id', 'message' => 'Автомобиль не существует'],
            [['attachment_id'], 'exist', 'targetClass' => Attachment::className(), 'targetAttribute' => 'id', 'message' => 'Изображение не существует'],
        ];
    }

}
