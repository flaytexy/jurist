<?php

namespace common\models\country;

use Yii;

/**
 * This is the model class for table "{{%country_region_assign}}".
 *
 * @property string $id
 * @property string $country_id
 * @property string $region_id
 *
 * @property Country $country
 * @property CountryRegion $region
 */
class CountryRegionAssign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country_region_assign}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id', 'region_id'], 'required'],
            [['country_id', 'region_id'], 'integer'],
            [['country_id', 'region_id'], 'unique', 'targetAttribute' => ['country_id', 'region_id'], 'message' => 'The combination of Country ID and Region ID has already been taken.'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
            [['region_id'], 'exist', 'skipOnError' => true, 'targetClass' => CountryRegion::className(), 'targetAttribute' => ['region_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'country_id' => Yii::t('app', 'Country ID'),
            'region_id' => Yii::t('app', 'Region ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRegion()
    {
        return $this->hasOne(CountryRegion::className(), ['id' => 'region_id']);
    }
}
