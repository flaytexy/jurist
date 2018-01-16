<?php

namespace app\modules\park\controllers\frontend;

use app\modules\park\models\Car;
use app\modules\park\models\CarPrices;
use app\modules\park\models\Category;
use app\modules\park\models\City;
use Yii;
use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Парк авто – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $filter_category = Yii::$app->request->get('category', []);

        $cities = City::getParkCities();
        if (($city_id = Yii::$app->request->get('city')) &&  isset($cities[$city_id])) {
            $city = $cities[$city_id];
        } elseif ($city_id = array_search('1', array_column($cities, 'default', 'id'))) {
            $city = $cities[$city_id];
        } else {
            $city = reset($cities);
        }

        /**
         * Классы авто
         */
        $categories = Yii::$app->cache->getOrSet('categories-' . $city['id'], function () use ($city) {
            return Category::find()
                ->joinWith('translation')
                ->joinWith([
                    'minimumPrice' => function (ActiveQuery $query) use ($city) {
                        $query->andOnCondition(CarPrices::tableName() . '.object_id = ' . $city['id']);
                    }
                ])
                ->orderBy([Category::tableName() . '.created_at' => SORT_ASC])
                ->asArray()
                ->all();
        });

        $models = Yii::$app->cache->getOrSet('park-' . $city['id'] . '-' . implode('-', $filter_category), function () use ($city, $filter_category) {
            $models = Car::find()
                ->joinWith('translation')
                ->joinWith('translatedBrand')
                ->joinWith('translatedModel')
                ->joinWith('translatedCategory')
                ->innerJoinWith([
                    'cityPrice' => function (ActiveQuery $query) use ($city) {
                        $query->andOnCondition('car_prices_table.object_id = ' . $city['id']);
                    }
                ])
                ->with('translatedSticker');

            if ($filter_category) {
                $models->andWhere(['in', Car::tableName() . '.category_id', $filter_category]);
            }

            return $models
                ->asArray()
                ->all();
        });

        return $this->render('index', [
            'categories' => $categories,
            'city' => $city,
            'cities' => $cities,
            'models' => $models,
        ]);
    }

    public function actionBrand()
    {
        $filter_category = Yii::$app->request->get('category', []);
        $filter_brand = Yii::$app->request->get('brand');

        if ($filter_brand) {
            /**
             * Классы авто
             */
            $categories = Yii::$app->cache->getOrSet('brand-categories-' . $filter_brand, function () {
                return Category::find()
                    ->joinWith('translation')
                    ->orderBy([Category::tableName() . '.created_at' => SORT_ASC])
                    ->asArray()
                    ->all();
            });

            $models = Yii::$app->cache->getOrSet('brand-park-' . $filter_brand, function () use ($filter_category, $filter_brand) {
                $models = Car::find()
                    ->joinWith('translation')
                    ->joinWith('translatedBrand')
                    ->joinWith('translatedModel')
                    ->joinWith('translatedCategory')
                    ->with('translatedSticker');

                if ($filter_category) {
                    $models->andWhere(['in', Car::tableName() . '.category_id', $filter_category]);
                }

                if ($filter_brand) {
                    $models->andWhere(['in', Car::tableName() . '.brand_id', $filter_brand]);
                }

                return $models
                    ->asArray()
                    ->all();
            });

            return $this->render('brand', [
                'categories' => $categories,
                'models' => $models,
            ]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
    }
}
