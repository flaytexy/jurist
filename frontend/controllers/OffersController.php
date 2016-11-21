<?php
namespace frontend\controllers;

use frontend\modules\offers\api\Offers;

class OffersController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        return $this->render('index',[
            'offers' => Offers::items(['tags' => $tag, 'pagination' => ['pageSize' => 15]])
        ]);
    }

    public function actionView($slug)
    {
        $offers = Offers::get($slug);
        if(!$offers){
            throw new \yii\web\NotFoundHttpException('Offers not found.');
        }

        return $this->render('view', [
            'offers' => $offers
        ]);
    }
}
