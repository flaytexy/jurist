<?php

namespace backend\modules\currency;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/currency/' . $category, $message, $params, $language);
    }
}
