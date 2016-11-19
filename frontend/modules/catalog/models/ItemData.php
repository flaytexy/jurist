<?php
namespace frontend\modules\catalog\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\SortableModel;
use frontend\models\Photo;

class ItemData extends \frontend\components\ActiveRecord
{

    public static function tableName()
    {
        return 'easyii_catalog_item_data';
    }
}