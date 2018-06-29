<?php

namespace frontend\modules\novabanks;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/novabanks/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/novabanks/messages',
            'fileMap' => [
                'modules/novabanks/module' => 'module.php',
            ],
        ];
    }
}