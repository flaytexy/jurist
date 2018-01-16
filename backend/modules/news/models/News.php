<?php

namespace app\modules\news\models;

use app\models\Content;

/**
 * Class News
 * @package app\modules\news\models
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
