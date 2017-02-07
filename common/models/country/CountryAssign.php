<?php

namespace common\models\country;

use Yii;

/**
 * This is the model class for table "{{%country_assign}}".
 *
 * @property string $class
 * @property integer $item_id
 * @property string $country_id
 */
class CountryAssign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country_assign}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['class', 'item_id', 'country_id'], 'required'],
            [['item_id', 'country_id'], 'integer'],
            [['class'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'class' => Yii::t('app', 'Class'),
            'item_id' => Yii::t('app', 'Item ID'),
            'country_id' => Yii::t('app', 'Country ID'),
        ];
    }
}
