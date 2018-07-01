<?php

namespace frontend\modules\novaoffers;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/novaoffers/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/novaoffers/messages',
            'fileMap' => [
                'modules/novaoffers/module' => 'module.php',
            ],
        ];
    }
}