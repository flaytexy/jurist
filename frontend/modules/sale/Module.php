<?php

namespace frontend\modules\sale;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/sale/' . $category, $message, $params, $language);
    }
}
