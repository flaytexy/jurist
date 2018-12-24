<?php

namespace frontend\modules\sale;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/sale/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/sale/messages',
            'fileMap' => [
                'modules/sale/module' => 'module.php',
            ],
        ];
    }
}