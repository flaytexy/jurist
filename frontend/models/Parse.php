<?php
namespace frontend\models;

use Yii;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
use yii\helpers\StringHelper;

class Parse extends \common\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;


    public static function tableName()
    {
        return 'easyii_offers';
    }

    public function rules()
    {
        return [
            ['title', 'string', 'max' => 128]
        ];
    }

    public function attributeLabels()
    {
        return [

        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'taggabble' => Taggable::className(),
            'sluggable' => [
                'class' => MySluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ],
        ];
    }

}