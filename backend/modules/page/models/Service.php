<?php

namespace backend\modules\page\models;

use Yii;
use backend\modules\attachment\models\Attachment;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Service
 * @package backend\modules\page\models
 *
 * @property int $id
 * @property int $thumbnail
 *
 * @property ServiceTranslation|array $translations
 */
class Service extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%content_service%}}';
    }

    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public $language = 'ru-RU';

    private $_title = null;
    private $_edit_link = null;

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/page/service/edit', 'id' => $this->id, 'language' => $language]);
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
        ];
    }

    public function attributeLabels()
    {
        return [
            'thumbnail' => 'Изображение',
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
                ServiceTranslation::tableName() . '.status' => Service::STATUS_PUBLISHED,
                ServiceTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getThumbnail()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'thumbnail']);
    }
}
