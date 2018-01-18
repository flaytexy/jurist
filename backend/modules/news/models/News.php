<?php

namespace backend\modules\news\models;

use backend\models\Content;

/**
 * Class News
 * @package backend\modules\news\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property int $publish_date
 * @property string $image
 *
 * @property NewsTranslation|array $translations
 */
class News extends Content
{
    const PAGE_LIMIT = 7;

    public static $_type = 'news';

    public function init()
    {
        self::$_translateModel = NewsTranslation::className();
    }
}
