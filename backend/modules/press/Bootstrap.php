<?php

namespace backend\modules\press;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/press/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@backend/modules/press/messages',
            'fileMap' => [
                'modules/press/module' => 'module.php',
            ],
        ];
    }
}