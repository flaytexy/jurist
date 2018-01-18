<?php

namespace backend\modules\page\models;

use Yii;
use backend\modules\attachment\models\Attachment;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Review
 * @package backend\modules\page\models
 *
 * @var int $id
 * @var int $thumbnail
 * @var int $publish_date
 *
 * @property ReviewTranslation|array $translations
 */
class Review extends ActiveRecord
{
    public $language = 'ru-RU';

    private $_title = null;
    private $_edit_link = null;

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/page/review/edit', 'id' => $this->id, 'language' => $language]);
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
            'thumbnail' => 'Миниатюра',
            'publish_date' => 'Дата публикации',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(ReviewTranslation::className(), ['review_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(ReviewTranslation::className(), ['review_id' => 'id'])
            ->where([
                ReviewTranslation::tableName() . '.status' => ReviewTranslation::STATUS_PUBLISHED,
                ReviewTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getThumbnail()
    {
        return $this->hasOne(Attachment::className(), ['id' => 'thumbnail']);
    }
}
