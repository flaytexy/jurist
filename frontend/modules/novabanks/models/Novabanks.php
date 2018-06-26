<?php

namespace frontend\modules\Novabanks\models;

use common\models\Content;

/**
 * Class Novabanks
 * @package frontend\modules\Novabanks\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property int $publish_date
 * @property string $image
 *
 * @property NovabanksTranslation|array $translations
 */
class Novabanks extends Content
{
    const PAGE_LIMIT = 7;

    public static $_type = 'Novabanks';

    public function init()
    {
        self::$_translateModel = NovabanksTranslation::className();
    }
}
