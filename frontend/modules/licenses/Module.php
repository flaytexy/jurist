<?php

namespace frontend\modules\licenses;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/licenses/' . $category, $message, $params, $language);
    }
}
