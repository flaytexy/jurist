<?php
namespace frontend\modules\admin\controllers;
use Yii;

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