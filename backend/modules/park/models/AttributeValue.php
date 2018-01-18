<?php

namespace backend\modules\park\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class AttributeValue
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property string $phones
 * @property int $show_in_header
 * @property int $show_in_footer
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AttributeValueTranslation|array $translations
 */
class AttributeValue extends ActiveRecord
{
    public $language = 'ru-RU';

    public $_title = null;
    public $_edit_link = null;

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
        ];
    }

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/park/attribute-value/edit', 'id' => $this->id, 'language' => $language]);
                    break;
                }
            }
        }

        parent::afterFind();
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getEditLink()
    {
        return $this->_edit_link;
    }

    public function rules()
    {
        return [
            [['language', 'attribute_id'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'attribute_id' => 'Характеристика',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(AttributeValueTranslation::className(), ['attribute_value_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(AttributeValueTranslation::className(), ['attribute_value_id' => 'id'])
            ->where([
                AttributeValueTranslation::tableName() . '.status' => AttributeValueTranslation::STATUS_PUBLISHED,
                AttributeValueTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getMainAttribute()
    {
        return $this->hasOne(Attribute::className(), ['id' => 'attribute_id']);
    }

    public function getTranslatedMainAttribute()
    {
        return $this->getMainAttribute()
            ->joinWith('translation');
    }

    public static function getDropdownList()
    {
        /**
         * @var AttributeValue $model
         */
        $result = [];

        $models = static::find()
            ->with('translations')
            ->all();

        foreach ($models as $model) {
            $result[$model->id] = $model->getTitle();
        }

        return $result;
    }
}
