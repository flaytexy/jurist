<?php

namespace app\modules\menu;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/menu/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/menu/messages',
            'fileMap' => [
                'modules/menu/module' => 'module.php',
            ],
        ];
    }
}