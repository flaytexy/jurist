<?php

namespace frontend\modules\Novabanks;

use Yii;

class Module extends \yii\base\Module
{
    public static function t($category, $message, $params = [], $language = null)
    {
        return Yii::t('modules/Novabanks/' . $category, $message, $params, $language);
    }
}
