<?php

namespace backend\modules\album;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/album/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@backend/modules/album/messages',
            'fileMap' => [
                'modules/album/module' => 'module.php',
            ],
        ];
    }
}