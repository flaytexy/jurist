<?php

namespace backend\modules\park\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Sticker
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property string $color
 * @property string $background
 * @property string $border
 *
 * @property StickerTranslation|array $translations
 */
class Sticker extends ActiveRecord
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
                    $this->_edit_link = Url::to(['/admin/park/sticker/edit', 'id' => $this->id, 'language' => $language]);
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
            [['color', 'background', 'border'], 'required', 'message' => 'Введите значение'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'color' => 'Цвет текста',
            'background' => 'Цвет фона',
            'border' => 'Цвет обводки',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(StickerTranslation::className(), ['sticker_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(StickerTranslation::className(), ['sticker_id' => 'id'])
            ->andWhere([
                StickerTranslation::tableName() . '.status' => StickerTranslation::STATUS_PUBLISHED,
                StickerTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public static function getDropdownList()
    {
        /**
         * @var Sticker $model
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
