<?php
namespace frontend\modules\sale\models;

use Yii;
use frontend\behaviors\CountryAble;

use common\behaviors\MySluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
use frontend\behaviors\Optionable;
use frontend\models\Photo;
use yii\helpers\StringHelper;

/**
 * This is the model class for table "sales".
 *
 * @property integer $sale_id
 * @property integer $content_id
 * @property string $price
 * @property integer $price_prefix
 */

class SaleExt extends \common\components\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sales';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['price'], 'number'],
            [['price_prefix'], 'string', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'price' => Yii::t('app', 'Price'),
            'price_prefix' => Yii::t('app', 'Price Prefix'),
        ];
    }
    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            $this->price = str_replace(",", ".", $this->price);

            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if($this->image){
            @unlink(Yii::getAlias('@webroot').$this->image);
        }
    }
}