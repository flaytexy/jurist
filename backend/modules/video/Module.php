<?php

namespace backend\modules\video;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/video/' . $category, $message, $params, $language);
    }
}
