<?php

namespace frontend\modules\licenses\models;

use Yii;

/**
 * This is the model class for table "licenses".
 *
 * @property integer $licenses_id
 * @property integer $content_id
 * @property integer $lic_type
 * @property string $country
 */
class LicensesExt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'licenses';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'lic_type', 'country'], 'required'],
            [['country'], 'string'],
            [['lic_type'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'licenses_id' => Yii::t('app', 'Licenses ID'),
            'content_id' => Yii::t('app', 'Content ID'),
            'lic_type' => Yii::t('app', 'Lic Type'),
            'country' => Yii::t('app', 'Country'),
        ];
    }
}
