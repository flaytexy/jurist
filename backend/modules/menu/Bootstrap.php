<?php

namespace backend\modules\menu;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/menu/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@backend/modules/menu/messages',
            'fileMap' => [
                'modules/menu/module' => 'module.php',
            ],
        ];
    }
}