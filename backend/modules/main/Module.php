<?php

namespace backend\modules\main;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'backend\modules\main\controllers';

    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/main/' . $category, $message, $params, $language);
    }
}
