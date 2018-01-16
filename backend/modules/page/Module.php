<?php

namespace app\modules\page;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/page/' . $category, $message, $params, $language);
    }
}
