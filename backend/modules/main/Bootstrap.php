<?php

namespace backend\modules\main;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/main/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@backend/modules/main/messages',
            'fileMap' => [
                'modules/main/module' => 'module.php',
            ],
        ];
    }
}