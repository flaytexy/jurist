<?php

namespace app\modules\page\models;

use app\modules\attachment\models\Attachment;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Slider
 * @package app\modules\page\models
 *
 * @property int $id
 * @property int $thumbnail
 * @property int $system
 *
 * @property SliderTranslation|array $translations
 */
class Slider extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%content_slider%}}';
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
                    $this->_edit_link = Url::to(['/admin/page/slider/edit', 'id' => $this->id, 'language' => $language]);
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
            'thumbnail' => 'Слайд',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(SliderTranslation::className(), ['slider_id' => 'id'])->indexBy('language');
    }

    public function getThumbnail()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'thumbnail']);
    }
}
