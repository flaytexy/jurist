<?php

namespace backend\modules\currency;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/currency/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@backend/modules/currency/messages',
            'fileMap' => [
                'modules/currency/module' => 'module.php',
            ],
        ];
    }
}