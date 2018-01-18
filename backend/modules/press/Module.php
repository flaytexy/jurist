<?php

namespace backend\modules\press;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/press/' . $category, $message, $params, $language);
    }
}
