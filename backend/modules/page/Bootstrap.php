<?php

namespace backend\modules\page;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/page/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@backend/modules/page/messages',
            'fileMap' => [
                'modules/page/module' => 'module.php',
            ],
        ];
    }
}