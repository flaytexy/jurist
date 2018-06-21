<?php

namespace frontend\modules\novanews\models;

use common\models\Content;
use yii\behaviors\SluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
/**
 * Class Novanews
 * @package frontend\modules\novanews\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property int $publish_date
 *
 *
 * @property NovanewsTranslation|array $translations
 */
class Topnews extends Content
{
    const PAGE_LIMIT = 7;

    public static $_type = 'novanews';

    public function init()
    {
        self::$_translateModel = NovanewsTranslation::className();
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'taggabble' => Taggable::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ],
        ];
    }
}
