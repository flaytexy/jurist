<?php

namespace backend\modules\news;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/news/' . $category, $message, $params, $language);
    }
}
