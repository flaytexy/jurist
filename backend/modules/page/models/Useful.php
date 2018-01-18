<?php

namespace backend\modules\page\models;

use backend\modules\attachment\models\Attachment;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Useful
 * @package backend\modules\page\models
 *
 * @property int $id
 *
 * @property UsefulTranslation|array $translations
 */
class Useful extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%content_useful%}}';
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
                    $this->_edit_link = Url::to(['/admin/page/useful/edit', 'id' => $this->id, 'language' => $language]);
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
            [['language'], 'safe'],
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(UsefulTranslation::className(), ['useful_id' => 'id'])->indexBy('language');
    }
}
