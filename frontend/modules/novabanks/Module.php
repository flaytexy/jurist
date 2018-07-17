<?php

namespace frontend\modules\novabanks;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/novabanks/' . $category, $message, $params, $language);
    }
}
