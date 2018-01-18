<?php

namespace backend\modules\admin;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/admin/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@backend/modules/admin/messages',
            'fileMap' => [
                'modules/admin/module' => 'module.php',
            ],
        ];

        $app->assetManager->assetMap['jquery.js'] = false;
    }
}