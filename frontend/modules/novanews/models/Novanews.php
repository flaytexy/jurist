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
    const TYPE_ID = 2;

    public static $_type = 'novanews';

    public function init()
    {
        self::$_translateModel = NovanewsTranslation::className();
    }

//    public function getChild() {
//        return $this->getPlan();
//    }
//
//    public function getPlan() {
//        return $this->hasOne(NewsPlan::className(), ['content_id' => 'id']);
//    }
}
