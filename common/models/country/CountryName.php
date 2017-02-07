<?php

namespace common\models\country;

use Yii;

/**
 * This is the model class for table "{{%country_name}}".
 *
 * @property string $id
 * @property string $country_id
 * @property string $code2l
 * @property string $language
 * @property string $name
 * @property string $name_official
 * @property string $source
 *
 * @property Country $country
 */
class CountryName extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%country_name}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['country_id'], 'required'],
            [['country_id'], 'integer'],
            [['code2l'], 'string', 'max' => 2],
            [['language'], 'string', 'max' => 5],
            [['name', 'name_official', 'source'], 'string', 'max' => 255],
            [['code2l', 'language'], 'unique', 'targetAttribute' => ['code2l', 'language'], 'message' => 'The combination of ISO 2-letter code and Language code (ie. pt-pt) has already been taken.'],
            [['country_id', 'language'], 'unique', 'targetAttribute' => ['country_id', 'language'], 'message' => 'The combination of Country ID and Language code (ie. pt-pt) has already been taken.'],
            [['country_id'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['country_id' => 'id']],
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
            'code2l' => Yii::t('app', 'ISO 2-letter code'),
            'language' => Yii::t('app', 'Language code (ie. pt-pt)'),
            'name' => Yii::t('app', 'Name'),
            'name_official' => Yii::t('app', 'Name Official'),
            'source' => Yii::t('app', 'Data source'),
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
