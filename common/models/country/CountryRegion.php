<?php

namespace common\models\country;

use Yii;

/**
 * This is the model class for table "{{%country_region}}".
 *
 * @property string $id
 * @property string $name
 * @property integer $is_unep
 * @property integer $sort_order
 *
 * @property CountryRegionAssign[] $countryRegionAssigns
 * @property Country[] $countries
 */
class CountryRegion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country_region}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['is_unep', 'sort_order'], 'integer'],
            [['sort_order'], 'required'],
            [['name'], 'string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'is_unep' => Yii::t('app', 'Is Unep'),
            'sort_order' => Yii::t('app', 'Sort Order'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountryRegionAssigns()
    {
        return $this->hasMany(CountryRegionAssign::className(), ['region_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCountries()
    {
        return $this->hasMany(Country::className(), ['id' => 'country_id'])->viaTable('{{%country_region_assign}}', ['region_id' => 'id']);
    }
}
