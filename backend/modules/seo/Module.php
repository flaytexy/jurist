<?php

namespace app\modules\seo;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/seo/' . $category, $message, $params, $language);
    }
}
