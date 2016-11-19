<?php
namespace frontend\modules\faq\models;

use Yii;
use frontend\behaviors\CacheFlush;
use frontend\behaviors\SortableModel;

class Faq extends \frontend\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    const CACHE_KEY = 'easyii_faq';

    public static function tableName()
    {
        return 'easyii_faq';
    }

    public function rules()
    {
        return [
            [['question','answer'], 'required'],
            [['question', 'answer'], 'trim'],
            ['status', 'integer'],
            ['status', 'default', 'value' => self::STATUS_ON],
        ];
    }

    public function attributeLabels()
    {
        return [
            'question' => Yii::t('easyii/faq', 'Question'),
            'answer' => Yii::t('easyii/faq', 'Answer'),
        ];
    }

    public function behaviors()
    {
        return [
            CacheFlush::className(),
            SortableModel::className()
        ];
    }
}