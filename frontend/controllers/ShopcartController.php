<?php

namespace frontend\controllers;

use frontend\models\AddToCartForm;
use Yii;
use frontend\modules\catalog\api\Catalog;
use frontend\modules\shopcart\api\Shopcart;
use yii\web\NotFoundHttpException;

class ShopcartController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index', [
            'goods' => Shopcart::goods()
        ]);
    }

    public function actionSuccess()
    {
        return $this->render('success');
    }

    public function actionAdd($id)
    {
        $item = Catalog::get($id);

        if(!$item){
            throw new NotFoundHttpException('Item Houston, we have a problem');
        }

        $form = new AddToCartForm();
        $success = 0;
        if($form->load(Yii::$app->request->post()) && $form->validate()){
            $response = Shopcart::add($item->id, $form->count, $form->color);
            $success = $response['result'] == 'success' ? 1 : 0;
        }

        return $this->redirect(Yii::$app->request->referrer.'?'.AddToCartForm::SUCCESS_VAR.'='.$success);
    }

    public function actionRemove($id)
    {
        Shopcart::remove($id);
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionUpdate()
    {
        Shopcart::update(Yii::$app->request->post('Good'));
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionOrder($id, $token)
    {
        $order = Shopcart::order($id);
        if(!$order || $order->access_token != $token){
            throw new NotFoundHttpException('Order Houston, we have a problem');
        }

        return $this->render('order', ['order' => $order]);
    }

}
