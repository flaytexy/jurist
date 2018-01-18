<?php

namespace backend\modules\seo;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/seo/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@backend/modules/seo/messages',
            'fileMap' => [
                'modules/seo/module' => 'module.php',
            ],
        ];
    }
}