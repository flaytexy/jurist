<?php

namespace frontend\controllers;

class GuestbookController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
