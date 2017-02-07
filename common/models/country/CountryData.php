<?php

namespace common\models\country;

use Yii;

/**
 * This is the model class for table "{{%country_data}}".
 *
 * @property string $country_id
 * @property integer $old_id
 * @property integer $number
 * @property string $alpha
 * @property integer $calling
 * @property string $name_en
 * @property string $name_ru
 * @property string $name_uk
 *
 * @property Country $country
 */
class CountryData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country_data}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'old_id', 'number', 'alpha', 'calling', 'name_en', 'name_ru', 'name_uk'], 'required'],
            [['country_id', 'old_id', 'number', 'calling'], 'integer'],
            [['alpha'], 'string', 'max' => 2],
            [['name_en', 'name_ru', 'name_uk'], 'string', 'max' => 255],
            [['alpha'], 'unique'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('app', 'Country ID'),
            'old_id' => Yii::t('app', 'Old ID'),
            'number' => Yii::t('app', 'Number'),
            'alpha' => Yii::t('app', 'Alpha'),
            'calling' => Yii::t('app', 'Calling'),
            'name_en' => Yii::t('app', 'Name En'),
            'name_ru' => Yii::t('app', 'Name Ru'),
            'name_uk' => Yii::t('app', 'Name Uk'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }
}
