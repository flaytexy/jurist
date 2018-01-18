<?php

namespace backend\modules\page\models;

use backend\models\Content;
use yii\helpers\Url;

/**
 * Class Page
 * @package backend\modules\page\models
 *
 * @property int $id
 * @property int $thumbnail
 * @property int $system
 *
 * @property PageTranslation|array $translations
 */
class Page extends Content
{
    const PAGE_LIMIT = 6;
    public static $_type = 'page';

    public function init()
    {
        self::$_translateModel = PageTranslation::className();
    }
}
