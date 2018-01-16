<?php

namespace app\modules\park\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Brand
 * @package app\modules\park\models
 *
 * @property int $id
 * @property string $phones
 * @property int $show_in_header
 * @property int $show_in_footer
 * @property int $created_at
 * @property int $updated_at
 *
 * @property BrandTranslation|array $translations
 */
class Brand extends ActiveRecord
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
                    $this->_edit_link = Url::to(['/admin/park/brand/edit', 'id' => $this->id, 'language' => $language]);
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

    public function attributeLabels()
    {
        return [
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(BrandTranslation::className(), ['brand_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(BrandTranslation::className(), ['brand_id' => 'id'])
            ->where([
                BrandTranslation::tableName() . '.status' => BrandTranslation::STATUS_PUBLISHED,
                BrandTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public static function getDropdownList()
    {
        /**
         * @var Brand $model
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

    public static function getMenuItems()
    {
        return Brand::find()
            ->select([
                Brand::tableName() . '.id',
                BrandTranslation::tableName() . '.title',
                BrandTranslation::tableName() . '.slug as link',
            ])
            ->joinWith('translations', false)
            ->where([
                BrandTranslation::tableName() . '.language' => \Yii::$app->language,
                BrandTranslation::tableName() . '.status' => BrandTranslation::STATUS_PUBLISHED,
            ])
            ->asArray()
            ->all();
    }
}
