<?php

namespace app\modules\attachment;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/attachment/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/attachment/messages',
            'fileMap' => [
                'modules/attachment/module' => 'module.php',
            ],
        ];
    }
}