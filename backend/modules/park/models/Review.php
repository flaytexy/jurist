<?php

namespace app\modules\park\models;

use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

class Review extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public static function tableName()
    {
        return '{{%car_review%}}';
    }

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
            [['name', 'comment'], 'required', 'message' => \Yii::t('app', 'Необходимо заполнить')],
            [['status'], 'boolean']
        ];
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'comment' => 'Отзыв',
        ];
    }
}
