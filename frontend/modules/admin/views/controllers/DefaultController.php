<?php
namespace frontend\controllers;

class DefaultController extends \frontend\components\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionFlush(){
        Yii::$app->cache->flush();
        return $this->render('flush');
    }
}