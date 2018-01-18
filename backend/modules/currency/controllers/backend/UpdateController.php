<?php

namespace backend\modules\currency\controllers\backend;

use backend\modules\currency\models\Currency;
use Yii;
use yii\web\Controller;

class UpdateController extends Controller
{
    public function actionIndex()
    {
        $privatbank_data = @json_decode(@file_get_contents('https://api.privatbank.ua/p24api/pubinfo?json&exchange&coursid=5'), true);

        if ($privatbank_data) {
            foreach ($privatbank_data as $data) {

                $currency = Currency::find()
                    ->where(['iso' => $data['ccy']])
                    ->one();

                if ($currency) {
                    $currency->exchange = $data['sale'];
                    $currency->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', 'Курс валют обновлен.');
            }

        } else {
            Yii::$app->session->setFlash('flash-admin-message-error', 'Ошибка соединения с ПриватБанк API.');
        }

        return $this->redirect(['/admin/currency/default/index']);
    }
}
