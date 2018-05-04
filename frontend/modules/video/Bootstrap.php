<?php

namespace common\modules\video;

use yii\base\BootstrapInterface;

class Bootstrap implements BootstrapInterface
{
    public function bootstrap($app)
    {
        $app->i18n->translations['modules/video/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'forceTranslation' => true,
            'basePath' => '@app/modules/video/messages',
            'fileMap' => [
                'modules/video/module' => 'module.php',
            ],
        ];
    }
}