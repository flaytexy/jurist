<?php
namespace frontend\modules\admin\controllers;

use Yii;
use frontend\helpers\WebConsole;
use frontend\models\Setting;

class SystemController extends \frontend\components\Controller
{
    public $rootActions = ['*'];

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionUpdate()
    {
        $result = WebConsole::migrate();

        Setting::set('easyii_version', \frontend\AdminModule::VERSION);
        Yii::$app->cache->flush();

        return $this->render('update', ['result' => $result]);
    }

    public function actionFlushCache()
    {
        Yii::$app->cache->flush();
        $this->flash('success', Yii::t('easyii', 'Cache flushed'));
        return $this->back();
    }

    public function actionClearAssets()
    {
        foreach(glob(Yii::$app->assetManager->basePath . DIRECTORY_SEPARATOR . '*') as $asset){
            if(is_link($asset)){
                unlink($asset);
            } elseif(is_dir($asset)){
                $this->deleteDir($asset);
            } else {
                unlink($asset);
            }
        }
        $this->flash('success', Yii::t('easyii', 'Assets cleared'));
        return $this->back();
    }

    public function actionLiveEdit($id)
    {
        Yii::$app->session->set('easyii_live_edit', $id);
        $this->back();
    }

    private function deleteDir($directory)
    {
        $iterator = new \RecursiveDirectoryIterator($directory, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::CHILD_FIRST);
        foreach($files as $file) {
            if ($file->isDir()){
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        return rmdir($directory);
    }
}