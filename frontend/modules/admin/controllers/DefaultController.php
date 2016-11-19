<?php
namespace frontend\modules\admin\controllers;

class DefaultController extends \frontend\components\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}