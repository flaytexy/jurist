<?php

namespace common\models\country;

use Yii;

/**
 * This is the model class for table "{{%country}}".
 *
 * @property string $id
 * @property integer $enabled
 * @property string $code3l
 * @property string $code2l
 * @property string $name
 * @property string $name_official
 * @property string $population
 * @property string $flag_32
 * @property string $flag_128
 * @property string $latitude
 * @property string $longitude
 * @property integer $zoom
 *
 * @property CountryData $countryData
 * @property CountryName[] $countryNames
 * @property CountryRegionAssign[] $countryRegionAssigns
 * @property CountryRegion[] $regions
 */
class Country extends \yii\db\ActiveRecord
{
    public $old_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['enabled', 'population', 'zoom'], 'integer'],
            [['code3l', 'code2l', 'name', 'population'], 'required'],
            [['latitude', 'longitude'], 'number'],
            [['code3l'], 'string', 'max' => 3],
            [['code2l'], 'string', 'max' => 2],
            [['name'], 'string', 'max' => 64],
            [['name_official'], 'string', 'max' => 128],
            [['flag_32', 'flag_128'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code3l'], 'unique'],
            [['code2l'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'enabled' => Yii::t('app', 'Use this country in applications'),
            'code3l' => Yii::t('app', 'ISO 3166-1 alpha-3 three-letter code'),
            'code2l' => Yii::t('app', 'ISO 3166-1 alpha-2 two-letter code'),
            'name' => Yii::t('app', 'Name of the country in English'),
            'name_official' => Yii::t('app', 'Name Official'),
            'population' => Yii::t('app', 'Population'),
            'flag_32' => Yii::t('app', 'Flag 32'),
            'flag_128' => Yii::t('app', 'Flag 128'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
            'zoom' => Yii::t('app', 'Optimal zoom when showing country on map'),
        ];
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryAssign()
    {
        return $this->hasOne(CountryAssign::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryData()
    {
        return $this->hasOne(CountryData::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryNames()
    {
        return $this->hasMany(CountryName::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryRegionAssigns()
    {
        return $this->hasMany(CountryRegionAssign::className(), ['country_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegions()
    {
        return $this->hasMany(CountryRegion::className(), ['id' => 'region_id'])->viaTable('{{%country_region_assign}}', ['country_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return CountryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountryQuery(get_called_class());
    }
}
