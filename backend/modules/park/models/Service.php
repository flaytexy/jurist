<?php

namespace backend\modules\park\models;

use Yii;
use backend\modules\attachment\models\Attachment;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Service
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property int $thumbnail
 * @property float $price_1
 * @property float $price_15
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ServiceTranslation|array $translations
 */
class Service extends ActiveRecord
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
                    $this->_edit_link = Url::to(['/admin/park/service/edit', 'id' => $this->id, 'language' => $language]);
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
            [['max_quantity'], 'integer', 'message' => 'Максимальное количество должно быть целым числом'],
            [['price_1', 'price_15'], 'double', 'message' => 'Введите корректную цену'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'thumbnail' => 'Миниатюра',
            'max_quantity' => 'Максимальное количесто',
            'price_1' => '1 - 14',
            'price_15' => '15+',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(ServiceTranslation::className(), ['service_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(ServiceTranslation::className(), ['service_id' => 'id'])
            ->where([
                ServiceTranslation::tableName() . '.status' => ServiceTranslation::STATUS_PUBLISHED,
                ServiceTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getThumbnail()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'thumbnail']);
    }

    public static function getDropdownList()
    {
        /**
         * @var Service $model
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
