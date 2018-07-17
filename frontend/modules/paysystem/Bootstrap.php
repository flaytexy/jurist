<?php

namespace frontend\modules\paysystem;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/paysystem/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/paysystem/messages',
            'fileMap' => [
                'modules/paysystem/module' => 'module.php',
            ],
        ];
    }
}