<?php
namespace frontend\controllers;
use frontend\modules\banks\api\Banks;


class BanksController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        $type_id = \Yii::$app->request->get('type_id');

        $banks = Banks::items(['tags' => $tag, 'type_id' => (int)$type_id, 'pagination' => ['pageSize' => 300]]);

        $markers = array();
        foreach($banks as $bank){
            $data = array();
            $data['latLng'] = explode(';', $bank->model->coordinates);
            $data['name'] = $bank->title;
            $data['weburl'] = 'b_' . $bank->model->bank_id;
            $markers[] = $data;
        }

        return $this->render('index', [
            'markers' => json_encode($markers),
            'banks' => $banks,
            'bank_type' => $type_id
        ]);
    }

    public function actionView($slug)
    {
        $this->getView()->registerJsFile(\Yii::$app->request->BaseUrl . '/js/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

        $banks = Banks::get($slug);

        return $this->render('view', [
            'banks' => $banks
        ]);
    }
}
