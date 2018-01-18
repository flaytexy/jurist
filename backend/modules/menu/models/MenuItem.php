<?php

namespace backend\modules\menu\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Class MenuItem
 * @package backend\modules\menu\models
 *
 * @property int $id
 * @property int $menu_id
 * @property int $parent_id
 * @property int $order_num
 */
class MenuItem extends ActiveRecord
{
    public $children;

    public function rules()
    {
        return [
            [['menu_id', 'parent_id', 'order_num'], 'safe'],
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(MenuItemTranslation::className(), ['menu_item_id' => 'id'])
            ->indexBy('language');
    }

    public function getTranslation()
    {
        return $this->hasOne(MenuItemTranslation::className(), ['menu_item_id' => 'id'])
            ->where([
                'and',
                ['language' => Yii::$app->language],
                ['<>', 'title', ''],
            ]);
    }

    public function getChildren()
    {
        return $this->hasMany(MenuItem::className(), ['parent_id' => 'id']);
    }

    public function getTranslatedChildren()
    {
        return $this->getChildren()
            ->joinWith('translation');
    }

    static public function getHierarchical($menu_id, $parent_id = 0, $language = '')
    {
        $models = MenuItem::find()
            ->andWhere([
                MenuItem::tableName() . '.menu_id' => $menu_id,
                MenuItem::tableName() . '.parent_id' => $parent_id,
            ])
            ->groupBy(MenuItem::tableName() . '.id')
            ->indexBy('id')
            ->orderBy([
                MenuItem::tableName() . '.order_num' => SORT_ASC,
                MenuItemTranslation::tableName() . '.created_at' => SORT_ASC
            ]);

        if ($language) {
            $models
                ->select([
                    MenuItem::tableName() . '.id',
                    MenuItemTranslation::tableName() . '.link',
                    MenuItemTranslation::tableName() . '.title'
                ])
                ->innerJoinWith('translations', false)
                ->andWhere([
                    MenuItemTranslation::tableName() . '.language' => $language,
                ])
                ->asArray();
        } else {
            $models->joinWith('translations');
        }

        $models = $models->all();

        foreach ($models as $id => $model) {
            if (is_array($model)) {
                $models[$id]['children'] = self::getHierarchical($menu_id, $model['id'], $language);
            } else {
                $model->children = self::getHierarchical($menu_id, $model->id, $language);
            }
        }

        return $models;
    }

    static public function deleteItem($item_id) {
        $model = self::find()->where(['id' => $item_id])->with('translations')->one();

        if ($model) {
            $child = static::find()->where(['parent_id' => $model->id])->with('translations')->all();

            foreach ($child as $children) {
                static::deleteItem($children->id);
            }

            /**
             * @var MenuItemTranslation $translation
             */
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();
        }
    }
}
