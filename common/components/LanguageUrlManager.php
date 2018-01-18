<?php
namespace common\components;

use yii\web\UrlManager;
use backend\models\Language;

class LanguageUrlManager extends UrlManager
{
    public function createUrl($params)
    {
        if (isset($params['language_id'])) {
            $language = Language::getLanguageByUrl($params['language_id']);
            if ($language === null) {
                $language = Language::getDefaultLanguage();
            }
            unset($params['language_id']);
        } else {
            $language = Language::getCurrent();
        }

        $url = str_replace('//', '/', parent::createUrl($params));

        if ($language['id'] === Language::getDefaultLanguage()['id']) {
            return $url;
        } else {
            return '/' . $language['id'] . $url;
        }
    }
}