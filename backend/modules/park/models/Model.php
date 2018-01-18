<?php

namespace backend\modules\park\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class Model
 * @package backend\modules\park\models
 *
 * @property int $id
 * @property string $phones
 * @property int $show_in_header
 * @property int $show_in_footer
 * @property int $created_at
 * @property int $updated_at
 *
 * @property ModelTranslation|array $translations
 */
class Model extends ActiveRecord
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
                    $this->_edit_link = Url::to(['/admin/park/model/edit', 'id' => $this->id, 'language' => $language]);
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
            [['brand_id'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'brand_id' => 'Марка',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(ModelTranslation::className(), ['model_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(ModelTranslation::className(), ['model_id' => 'id'])
            ->where([
                ModelTranslation::tableName() . '.status' => ModelTranslation::STATUS_PUBLISHED,
                ModelTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public static function getDropdownList($brand_id = null)
    {
        /**
         * @var Model $model
         */
        $result = [];

        $models = static::find()
            ->with('translations');

        if ($brand_id) {
            $models->andWhere(['brand_id' => $brand_id]);
        }

        foreach ($models->all() as $model) {
            $result[$model->id] = $model->getTitle();
        }

        return $result;
    }
}
