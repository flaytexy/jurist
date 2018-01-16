<?php

namespace app\modules\main\controllers;

use app\modules\currency\models\Currency;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class AjaxController extends Controller
{
    public function beforeAction($action)
    {
        if (!Yii::$app->request->isAjax) {
            throw new BadRequestHttpException;
        }

        Yii::$app->request->enableCsrfValidation = false;

        Yii::$app->response->format = Response::FORMAT_JSON;

        return parent::beforeAction($action);
    }

    public function actionSetCurrency()
    {
        Currency::setCurrent(Yii::$app->request->post('currency'));

        return '';
    }
}
