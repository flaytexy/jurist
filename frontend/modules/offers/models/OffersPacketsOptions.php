<?php
namespace frontend\modules\offers\models;


use frontend\components\ActiveRecord;
use Yii;
use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;


class OffersPacketsOptions extends ActiveRecord
{

    public $itemId;

    public static function tableName()
    {
        return 'easyii_offers_options';
    }
}