<?php

namespace backend\modules\park;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/park/' . $category, $message, $params, $language);
    }
}
