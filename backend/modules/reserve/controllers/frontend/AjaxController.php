<?php

namespace backend\modules\reserve\controllers\frontend;

use backend\modules\park\models\City;
use backend\modules\park\models\CityTranslation;
use backend\modules\park\models\Place;
use backend\modules\park\models\PlaceTranslation;
use backend\modules\park\models\Service;
use backend\modules\reserve\models\Reserve;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
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

    public function actionGetPlaces()
    {
        if ($city_id = Yii::$app->request->post('city_id')) {
            return Place::find()
                ->select([
                    Place::tableName() . '.id',
                    PlaceTranslation::tableName() . '.title',
                ])
                ->where([Place::tableName() . '.city_id' => $city_id])
                ->joinWith('translation', false)
                ->asArray()
                ->all();
        } else {
            return '';
        }
    }

    public function actionReserveForm()
    {
        return $this->renderAjax('reserve-form', [

        ]);
    }

    public function actionDatetimeForm()
    {
        if (in_array($datetime = Yii::$app->request->post('datetime'), ['in', 'out']) && $reserve_data = Yii::$app->session->get('reserve')) {

            return $this->renderAjax('datetime-form', [
                'reserve_data' => $reserve_data,
                'datetime' => $datetime,
            ]);
        } else {
            return '';
        }
    }

    public function actionServicesForm()
    {
        if ($reserve_data = Yii::$app->session->get('reserve') && $reserve_additions_data = Yii::$app->session->get('reserve_additions_data')) {
            $reserve_period = Reserve::getPeriod(strtotime($reserve_data['date_in'] . ' ' . $reserve_data['time_in']), strtotime($reserve_data['date_out'] . ' ' . $reserve_data['time_out']));

            $services = Service::find()
                ->joinWith('translation')
                ->asArray()
                ->all();

            return $this->renderAjax('services-form', [
                'reserve_additions_data' => $reserve_additions_data,
                'reserve_period' => $reserve_period,
                'services' => $services,
            ]);
        } else {
            return '';
        }
    }
}