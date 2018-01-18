<?php

namespace backend\modules\reserve\controllers\frontend;

use backend\modules\park\models\City;
use backend\modules\park\models\CityTranslation;
use backend\modules\park\models\Place;
use backend\modules\park\models\PlaceTranslation;
use backend\modules\park\models\Service;
use backend\modules\park\models\Car;
use backend\modules\park\models\CarPrices;
use backend\modules\park\models\Category;
use backend\modules\reserve\models\form\DriverForm;
use backend\modules\reserve\models\Reserve;
use Yii;
use yii\db\ActiveQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Бронирование – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        if (Yii::$app->request->isPost) {
            Yii::$app->session->remove('reserve');
            Yii::$app->session->remove('reserve_additions_data');
            Yii::$app->session->remove('reserve_driver_data');

            $reserve_data = Yii::$app->request->post('Reserve');

            $datetime_in = strtotime($reserve_data['date_in'] . ' ' . $reserve_data['time_in']);
            $datetime_out = strtotime($reserve_data['date_out'] . ' ' . $reserve_data['time_out']);

            $date_n_in = date('N', $datetime_in);
            $date_n_out = date('N', $datetime_out);

            if ($reserve_data['city']) {
                $reserve_data['city_text'] = City::find()
                    ->select([
                        City::tableName() . '.id',
                        CityTranslation::tableName() . '.title'
                    ])
                    ->where([City::tableName() . '.id' => $reserve_data['city']])
                    ->joinWith('translation', false)
                    ->asArray()
                    ->one();
            }

            if (isset($reserve_data['other_out']) && $reserve_data['other_out'] && $reserve_data['other_city'] && $reserve_data['other_city'] != $reserve_data['city']) {
                $reserve_data['other_city_text'] = City::find()
                    ->select([
                        City::tableName() . '.id',
                        CityTranslation::tableName() . '.title'
                    ])
                    ->where([City::tableName() . '.id' => $reserve_data['other_city']])
                    ->joinWith('translation', false)
                    ->asArray()
                    ->one();
            } else {
                $reserve_data['other_city_text'] = $reserve_data['city_text'];
            }

            if ($reserve_data['place']) {
                $reserve_data['place_text'] = Place::find()
                    ->select([
                        Place::tableName() . '.id',
                        PlaceTranslation::tableName() . '.title',
                        Place::tableName() . '.time_in_' . $date_n_in . ' AS time_from',
                        Place::tableName() . '.time_out_' . $date_n_in . ' AS time_to',

                        Place::tableName() . '.price_airport_work_time AS price_airport_fee_work_time',
                        Place::tableName() . '.price_airport_not_work_time AS price_airport_fee_not_work_time',

                        Place::tableName() . '.price_out_office_work_time AS price_office_work_time',
                        Place::tableName() . '.price_out_office_not_work_time AS price_office_not_work_time',
                        Place::tableName() . '.price_out_city_work_time AS price_city_work_time',
                        Place::tableName() . '.price_out_city_not_work_time AS price_city_not_work_time',
                        Place::tableName() . '.price_out_airport_work_time AS price_airport_work_time',
                        Place::tableName() . '.price_out_airport_not_work_time AS price_airport_not_work_time',
                    ])
                    ->where([Place::tableName() . '.id' => $reserve_data['place']])
                    ->joinWith('translation', false)
                    ->asArray()
                    ->one();

                if ($reserve_data['place_text']['time_from'] && $reserve_data['place_text']['time_to']) {
                    $_datetime_in = strtotime($reserve_data['date_in'] . ' ' . $reserve_data['place_text']['time_from']);
                    $_datetime_out = strtotime($reserve_data['date_in'] . ' ' . $reserve_data['place_text']['time_to']);

                    $in_is_work_time = $datetime_in >= $_datetime_in && $datetime_in <= $_datetime_out;
                } else {
                    $in_is_work_time = false;
                }

                $reserve_data['place_text']['work_time'] = $in_is_work_time;
            }

            if (!$reserve_data['other_place']) {
                $reserve_data['other_place'] = $reserve_data['place'];
            }
            if ($reserve_data['other_place']) {
                $reserve_data['other_place_text'] = Place::find()
                    ->select([
                        Place::tableName() . '.id',
                        PlaceTranslation::tableName() . '.title',
                        Place::tableName() . '.time_in_' . $date_n_out . ' AS time_from',
                        Place::tableName() . '.time_out_' . $date_n_out . ' AS time_to',

                        Place::tableName() . '.price_in_office_work_time AS price_office_work_time',
                        Place::tableName() . '.price_in_office_not_work_time AS price_office_not_work_time',
                        Place::tableName() . '.price_in_city_work_time AS price_city_work_time',
                        Place::tableName() . '.price_in_city_not_work_time AS price_city_not_work_time',
                        Place::tableName() . '.price_in_airport_work_time AS price_airport_work_time',
                        Place::tableName() . '.price_in_airport_not_work_time AS price_airport_not_work_time',
                    ])
                    ->where([Place::tableName() . '.id' => $reserve_data['other_place']])
                    ->joinWith('translation', false)
                    ->asArray()
                    ->one();

                if ($reserve_data['other_place_text']['time_from'] && $reserve_data['other_place_text']['time_to']) {
                    $_datetime_in = strtotime($reserve_data['date_out'] . ' ' . $reserve_data['other_place_text']['time_from']);
                    $_datetime_out = strtotime($reserve_data['date_out'] . ' ' . $reserve_data['other_place_text']['time_to']);

                    $in_is_work_time = $datetime_out >= $_datetime_in && $datetime_out <= $_datetime_out;
                } else {
                    $in_is_work_time = false;
                }

                $reserve_data['other_place_text']['work_time'] = $in_is_work_time;
            }

            $reserve_data['period'] = Reserve::getPeriod($datetime_in, $datetime_out);

            Yii::$app->session->set('reserve', $reserve_data);


            if ($reserve_data['car_id']) {
                return $this->redirect(['/reserve/default/additions', 'car' => $reserve_data['car_id']]);
            } else {
                return $this->refresh();
            }
        }

        if (Yii::$app->session->has('reserve')) {
            $reserve_data = Yii::$app->session->get('reserve');

            $reserve_period = Reserve::getPeriod(strtotime($reserve_data['date_in'] . ' ' . $reserve_data['time_in']), strtotime($reserve_data['date_out'] . ' ' . $reserve_data['time_out']));

            $filter_category = Yii::$app->request->get('category', []);

            /**
             * Классы авто
             */
            $categories = Yii::$app->cache->getOrSet('reserve-categories-' . $reserve_data['city'], function () use ($reserve_data) {
                return Category::find()
                    ->joinWith('translation')
                    ->joinWith([
                        'minimumPrice' => function (ActiveQuery $query) use ($reserve_data) {
                            $query->andOnCondition(CarPrices::tableName() . '.object_id = ' . $reserve_data['city']);
                        }
                    ])
                    ->orderBy([Category::tableName() . '.created_at' => SORT_ASC])
                    ->asArray()
                    ->all();
            });

            $models = Car::find()
                ->joinWith('translation')
                ->joinWith('translatedBrand')
                ->joinWith('translatedModel')
                ->joinWith('translatedCategory')
                ->innerJoinWith([
                    'cityPrice' => function (ActiveQuery $query) use ($reserve_data) {
                        $query->andOnCondition('car_prices_table.object_id = ' . $reserve_data['city']);
                    }
                ])
                ->with('translatedSticker');

            if ($filter_category) {
                $models->andWhere(['in', Car::tableName() . '.category_id', $filter_category]);
            }

            if ($car_id = Yii::$app->request->get('car')) {
                $models->addOrderBy(['FIELD (' . Car::tableName() . '.id, ' . $car_id . ')' => SORT_DESC]);
            }

            $models->addOrderBy(['car_prices_table.price_29' => SORT_ASC]);

            $models = $models
                ->asArray()
                ->all();


            return $this->render('index',[
                'reserve_period' => $reserve_period,
                'categories' => $categories,
                'models' => $models,
            ]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
    }

    public function actionAdditions()
    {
        if ($reserve_data = Yii::$app->session->get('reserve')) {
            if (Yii::$app->request->isPost) {
                Yii::$app->session->remove('reserve_additions_data');
                Yii::$app->session->remove('reserve_driver_data');

                $reserve_additions_data = Yii::$app->request->post('Reserve2', Yii::$app->session->get('reserve_additions_data'));

                $reserve_additions_data['service'] = Reserve::getProcessServices($reserve_data['period'], $reserve_additions_data['service']);

                Yii::$app->session->set('reserve_additions_data', $reserve_additions_data);

                return $this->redirect(['/reserve/default/driver']);
            }

            $model = Car::find()
                ->where([Car::tableName() . '.id' => Yii::$app->request->get('car')])
                ->joinWith('translation')
                ->joinWith('translatedBrand')
                ->joinWith('translatedModel')
                ->joinWith('translatedCategory')
                ->innerJoinWith([
                    'cityPrice' => function (ActiveQuery $query) use ($reserve_data) {
                        $query->andOnCondition('car_prices_table.object_id = ' . $reserve_data['city']);
                    }
                ])
                ->with('additionalPrices')
                ->asArray()
                ->one();

            if ($model) {

                $reserve_period = Reserve::getPeriod(strtotime($reserve_data['date_in'] . ' ' . $reserve_data['time_in']), strtotime($reserve_data['date_out'] . ' ' . $reserve_data['time_out']));

                $services = Service::find()
                    ->joinWith('translation')
                    ->asArray()
                    ->all();

                $models = Car::find()
                    ->where([
                        'and',
                        ['<>', Car::tableName() . '.id', $model['id']],
                        ['>=', 'car_prices_table.price_29', $model['cityPrice']['price_29']],
                    ])
                    ->joinWith('translation')
                    ->joinWith('translatedBrand')
                    ->joinWith('translatedModel')
                    ->joinWith('translatedCategory')
                    ->innerJoinWith([
                        'cityPrice' => function (ActiveQuery $query) use ($reserve_data) {
                            $query->andOnCondition('car_prices_table.object_id = ' . $reserve_data['city']);
                        }
                    ])
                    ->with('additionalPrices')
                    ->with('translatedSticker')
                    ->limit(2)
                    ->asArray();

                switch ($model['category_id']) {
                    case 3:
                        $models->andWhere([
                            'or',
                            ['in', Car::tableName() . '.category_id', [$model['category_id'], 4]],
                        ]);
                        break;
                    case 4:
                        $models->andWhere([
                            'or',
                            ['in', Car::tableName() . '.category_id', [$model['category_id'], 5]],
                        ]);
                        break;
                    case 5:
                        $models->andWhere([
                            'or',
                            ['in', Car::tableName() . '.category_id', [$model['category_id'], 6, 8]],
                        ]);
                        break;
                    default:
                        $models->andWhere([
                            'or',
                            ['in', Car::tableName() . '.category_id', [$model['category_id']]],
                        ]);
                        break;
                }

                $models = $models->all();

                return $this->render('additions', [
                    'reserve_data' => $reserve_data,
                    'reserve_period' => $reserve_period,
                    'model' => $model,
                    'models' => $models,
                    'services' => $services,
                ]);
            }
        }

        return $this->redirect(['/reserve/default/index']);
    }

    public function actionDriver()
    {
        $reserve_data = Yii::$app->session->get('reserve');
        $reserve_additions_data = Yii::$app->session->get('reserve_additions_data');

        if (!$reserve_data || !$reserve_additions_data) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $driver_model = new DriverForm;

        if ($driver_model->load(Yii::$app->request->post()) && $driver_model->validate()) {
            Yii::$app->session->remove('reserve_driver_data');

            Yii::$app->session->set('reserve_driver_data', $driver_model->attributes);

            return $this->redirect(['/reserve/default/payment']);
        }

        if ($datetime_post = Yii::$app->request->post('Reserve')) {
            $reserve_data['date_in'] = $datetime_post['date_in'];
            $reserve_data['time_in'] = $datetime_post['time_in'];
            $reserve_data['date_out'] = $datetime_post['date_out'];
            $reserve_data['time_out'] = $datetime_post['time_out'];

            $reserve_data['period'] = Reserve::getPeriod(strtotime($reserve_data['date_in'] . ' ' . $reserve_data['time_in']), strtotime($reserve_data['date_out'] . ' ' . $reserve_data['time_out']));

            Yii::$app->session->set('reserve', $reserve_data);

            return $this->refresh();
        }

        $model = Car::find()
            ->where([Car::tableName() . '.id' => $reserve_additions_data['car_id']])
            ->joinWith('translation')
            ->joinWith('translatedBrand')
            ->joinWith('translatedModel')
            ->joinWith('translatedCategory')
            ->asArray()
            ->one();

//        $this->view->registerCssFile('/css/jpreview.css');
//        $this->view->registerJsFile('/js/jpreview.js', ['depends' => 'yii\web\JqueryAsset']);
        $this->view->registerJsFile('/js/jquery-filestyle.min.js', ['depends' => 'yii\web\JqueryAsset']);

        return $this->render('driver', [
            'model' => $model,
            'driver_model' => $driver_model,
            'reserve_data' => $reserve_data,
            'reserve_additions_data' => $reserve_additions_data,
        ]);
    }

    public function actionPayment()
    {
        $reserve_data = Yii::$app->session->get('reserve');
        $reserve_additions_data = Yii::$app->session->get('reserve_additions_data');
        $reserve_driver_data = Yii::$app->session->get('reserve_driver_data');

//        vd([$reserve_data, $reserve_additions_data, $reserve_driver_data]);

        if (!$reserve_data || !$reserve_additions_data || !$reserve_driver_data) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        if (($payment = Yii::$app->request->post('payment')) && in_array($payment, ['full', 'reservation'])) {
            $reserve_data['payment'] = $payment;

            Yii::$app->session->set('reserve', $reserve_data);
            
            return $this->redirect(['confirm']);
        }

        $driver_model = new DriverForm;

        if ($driver_model->load(Yii::$app->request->post()) && $driver_model->validate()) {
            Yii::$app->session->remove('reserve_driver_data');

            Yii::$app->session->set('reserve_driver_data', $driver_model->attributes);

            return $this->redirect(['/reserve/default/payment']);
        }

        if ($datetime_post = Yii::$app->request->post('Reserve')) {
            $reserve_data['date_in'] = $datetime_post['date_in'];
            $reserve_data['time_in'] = $datetime_post['time_in'];
            $reserve_data['date_out'] = $datetime_post['date_out'];
            $reserve_data['time_out'] = $datetime_post['time_out'];

            $reserve_data['period'] = Reserve::getPeriod(strtotime($reserve_data['date_in'] . ' ' . $reserve_data['time_in']), strtotime($reserve_data['date_out'] . ' ' . $reserve_data['time_out']));

            Yii::$app->session->set('reserve', $reserve_data);

            return $this->refresh();
        }

        if ($service_post = Yii::$app->request->post('Reserve2')) {
            $reserve_additions_data['service'] = Reserve::getProcessServices($reserve_data['period'], $service_post['service']);
            Yii::$app->session->set('reserve_additions_data', $reserve_additions_data);

            return $this->refresh();
        }

        $model = Car::find()
            ->where([Car::tableName() . '.id' => $reserve_additions_data['car_id']])
            ->joinWith('translation')
            ->joinWith('translatedBrand')
            ->joinWith('translatedModel')
            ->joinWith('translatedCategory')
            ->innerJoinWith([
                'cityPrice' => function (ActiveQuery $query) use ($reserve_data) {
                    $query->andOnCondition('car_prices_table.object_id = ' . $reserve_data['city']);
                }
            ])
            ->with('additionalPrices')
            ->asArray()
            ->one();

        return $this->render('payment', [
            'model' => $model,
            'reserve_data' => $reserve_data,
            'reserve_additions_data' => $reserve_additions_data,
            'reserve_driver_data' => $reserve_driver_data,
        ]);
    }

    public function actionConfirm() {
        $reserve_data = Yii::$app->session->get('reserve');
        $reserve_additions_data = Yii::$app->session->get('reserve_additions_data');
        $reserve_driver_data = Yii::$app->session->get('reserve_driver_data');

        if (!$reserve_data || !$reserve_additions_data || !$reserve_driver_data) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model = Car::find()
            ->where([Car::tableName() . '.id' => $reserve_additions_data['car_id']])
            ->joinWith('translation')
            ->joinWith('translatedBrand')
            ->joinWith('translatedModel')
            ->joinWith('translatedCategory')
            ->innerJoinWith([
                'cityPrice' => function (ActiveQuery $query) use ($reserve_data) {
                    $query->andOnCondition('car_prices_table.object_id = ' . $reserve_data['city']);
                }
            ])
            ->with('additionalPrices')
            ->asArray()
            ->one();

        return $this->render('confirm', [
            'model' => $model,
            'reserve_data' => $reserve_data,
            'reserve_additions_data' => $reserve_additions_data,
            'reserve_driver_data' => $reserve_driver_data,
        ]);
    }
}