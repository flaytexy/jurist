<?php

namespace backend\modules\park\models;

use backend\modules\attachment\models\Attachment;
use yii\db\ActiveRecord;

class CarImage extends ActiveRecord
{

    public function rules()
    {
        return [
            [['car_id'], 'exist', 'targetClass' => Car::className(), 'targetAttribute' => 'id', 'message' => 'Автомобиль не существует'],
            [['attachment_id'], 'exist', 'targetClass' => Attachment::className(), 'targetAttribute' => 'id', 'message' => 'Изображение не существует'],
        ];
    }

}
