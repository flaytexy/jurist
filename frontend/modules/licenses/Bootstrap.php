<?php

namespace frontend\modules\licenses;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/licenses/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/licenses/messages',
            'fileMap' => [
                'modules/licenses/module' => 'module.php',
            ],
        ];
    }
}