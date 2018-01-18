<?php

namespace backend\modules\album;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/album/' . $category, $message, $params, $language);
    }
}
