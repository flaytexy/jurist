<?php
namespace frontend\modules\offers\models;


use frontend\components\ActiveRecord;
use Yii;



class OffersProperties extends ActiveRecord
{

    public $itemId;

    public static function tableName()
    {
        return 'easyii_offers_properties';
    }
}