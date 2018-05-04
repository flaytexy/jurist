<?php

namespace frontend\modules\novanews\models;

use common\models\Content;

/**
 * Class Novanews
 * @package frontend\modules\novanews\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property int $publish_date
 * @property string $image
 *
 * @property NovanewsTranslation|array $translations
 */
class Novanews extends Content
{
    const PAGE_LIMIT = 7;

    public static $_type = 'novanews';

    public function init()
    {
        self::$_translateModel = NovanewsTranslation::className();
    }
}
