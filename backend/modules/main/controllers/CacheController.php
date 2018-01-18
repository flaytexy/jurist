<?php

namespace backend\modules\main\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\FileHelper;

class CacheController extends Controller
{
    public function actionFlush()
    {
        Yii::$app->cache->flush();

        $directories = array_filter(glob(Yii::$app->getAssetManager()->basePath . '/*'), 'is_dir');

        foreach ($directories as $directory) {
            FileHelper::removeDirectory($directory);
        }

        return $this->goBack((!empty(Yii::$app->request->referrer) ? Yii::$app->request->referrer : null));
    }
}