<?php

namespace app\modules\reserve;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/reserve/' . $category, $message, $params, $language);
    }
}
