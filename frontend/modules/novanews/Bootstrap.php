<?php

namespace frontend\modules\novanews;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/novanews/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/novanews/messages',
            'fileMap' => [
                'modules/novanews/module' => 'module.php',
            ],
        ];
    }
}