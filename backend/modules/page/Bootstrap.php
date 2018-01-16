<?php

namespace app\modules\page;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/page/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/page/messages',
            'fileMap' => [
                'modules/page/module' => 'module.php',
            ],
        ];
    }
}