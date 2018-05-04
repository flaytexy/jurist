<?php

namespace common\modules\attachment;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/attachment/' . $category, $message, $params, $language);
    }
}
