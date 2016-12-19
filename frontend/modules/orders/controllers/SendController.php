<?php
namespace frontend\modules\orders\controllers;

use Yii;
use frontend\modules\orders\models\Orders as OrdersModel;

class SendController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $model = new OrdersModel;

        $request = Yii::$app->request;

        if ($model->load($request->post())) {
            $returnUrl = $model->save() ? $request->post('successUrl') : $request->post('errorUrl');
            return $this->redirect($returnUrl);
        } else {
            return $this->redirect(Yii::$app->request->baseUrl);
        }
    }
}