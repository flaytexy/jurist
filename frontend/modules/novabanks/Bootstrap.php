<?php

namespace frontend\modules\Novabanks;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/Novabanks/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/Novabanks/messages',
            'fileMap' => [
                'modules/Novabanks/module' => 'module.php',
            ],
        ];
    }
}