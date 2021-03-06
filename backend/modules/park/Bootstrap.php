<?php

namespace backend\modules\park;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/park/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@backend/modules/park/messages',
            'fileMap' => [
                'modules/park/module' => 'module.php',
            ],
        ];
    }
}