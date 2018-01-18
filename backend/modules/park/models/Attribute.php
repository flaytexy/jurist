<?php

namespace backend\modules\park\models;

use Yii;
use backend\modules\attachment\models\Attachment;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Attribute
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property int $thumbnail
 * @property int $show_in_filter
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AttributeTranslation|array $translations
 */
class Attribute extends ActiveRecord
{
    public $language = 'ru-RU';

    private $_title = null;
    private $_edit_link = null;

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
                    $this->_edit_link = Url::to(['/admin/park/attribute/edit', 'id' => $this->id, 'language' => $language]);
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
            [['language', 'thumbnail'], 'safe'],
            [['show_in_filter'], 'boolean'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'thumbnail' => 'Миниатюра',
            'show_in_filter' => 'Отображать в фильтре',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(AttributeTranslation::className(), ['attribute_id' => 'id'])->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(AttributeTranslation::className(), ['attribute_id' => 'id'])
            ->where([
                AttributeTranslation::tableName() . '.status' => AttributeTranslation::STATUS_PUBLISHED,
                AttributeTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getThumbnail()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'thumbnail']);
    }

    public function getValues()
    {
        return $this->hasMany(AttributeValue::className(), ['attribute_id' => 'id']);
    }

    public static function getDropdownList()
    {
        /**
         * @var Attribute $model
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
