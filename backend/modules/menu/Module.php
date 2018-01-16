<?php

namespace app\modules\menu;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/menu/' . $category, $message, $params, $language);
    }
}
