<?php

namespace frontend\modules\paysystem;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/paysystem/' . $category, $message, $params, $language);
    }
}
