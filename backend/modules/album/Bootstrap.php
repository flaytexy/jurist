<?php

namespace app\modules\album;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/album/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/album/messages',
            'fileMap' => [
                'modules/album/module' => 'module.php',
            ],
        ];
    }
}