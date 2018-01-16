<?php

namespace app\modules\park\controllers\frontend;

use app\modules\park\models\CarPrices;
use app\modules\park\models\Review;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\helpers\Url;
use yii\web\Controller;
use app\modules\park\models\Car;
use app\modules\park\models\City;
use yii\web\NotFoundHttpException;

class CarController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Автомобиль – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $model = Car::find()
            ->joinWith('translation')
            ->joinWith('translatedBrand')
            ->joinWith('translatedModel')
            ->joinWith('translatedCategory')
            ->joinWith('translatedCities')
            ->with('images')
            ->andWhere([Car::tableName() . '.id' => Yii::$app->request->get('id')])
            ->asArray()
            ->one();

        if ($model) {
            if (($city_id = Yii::$app->request->get('city')) &&  isset($model['translatedCities'][$city_id])) {
                $city = $model['translatedCities'][$city_id];
            } elseif ($city_id = array_search('1', array_column($model['translatedCities'], 'default', 'id'))) {
                $city = $model['translatedCities'][$city_id];
            } else {
                $city = reset($model['translatedCities']);
            }

            $model['prices'] = CarPrices::find()
                ->where([
                    'car_id' => $model['id'],
                    'object_id' => $city['id'],
                ])
                ->asArray()
                ->one();

            $reviews_query = Review::find()
                ->where([
                    'car_id' => $model['id'],
                    'status' => Review::STATUS_PUBLISHED,
                ]);
            $reviewsCountQuery = clone $reviews_query;
            $reviews_pages = new Pagination([
                'totalCount' => $reviewsCountQuery->count(),
                'defaultPageSize' => 2,
            ]);

            $reviews = $reviews_query->offset($reviews_pages->offset)
                ->orderBy([Review::tableName() . '.created_at' => SORT_DESC])
                ->limit($reviews_pages->limit)
                ->asArray()
                ->all();

            $review_model = new Review;

            if ($review_model->load(Yii::$app->request->post())) {

                $review_model->car_id = $model['id'];
                $review_model->status = Review::STATUS_DRAFT;

                if ($review_model->save()) {
                    Yii::$app->session->setFlash('flash-review-add-success', Yii::t('app', 'Ваш отзыв добавлен, после проверки модератором, он будет опубликован.'));

                    $review_model = new Review;
                }
            }

            $this->view->registerCssFile('/css/pgwslideshow.min.css');
            $this->view->registerJsFile('/js/pgwslideshow.min.js', ['depends' => 'yii\web\JqueryAsset']);

            return $this->render('index', [
                'city' => $city,
                'model' => $model,
                'reviews' => $reviews,
                'reviews_pages' => $reviews_pages,
                'review_model' => $review_model,
            ]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
    }
}
