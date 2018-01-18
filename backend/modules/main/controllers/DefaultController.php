<?php

namespace backend\modules\main\controllers;

use backend\modules\currency\models\Currency;
use backend\modules\page\models\PageTranslation;
use backend\modules\page\models\Review;
use backend\modules\page\models\ReviewTranslation;
use backend\modules\page\models\Service;
use backend\modules\page\models\ServiceTranslation;
use backend\modules\page\models\Slider;
use backend\modules\page\models\SliderTranslation;
use backend\modules\page\models\Useful;
use backend\modules\page\models\UsefulTranslation;
use backend\modules\park\models\Car;
use backend\modules\park\models\CarTranslation;
use backend\modules\park\models\Category;
use backend\modules\park\models\CategoryTranslation;
use Yii;
use backend\modules\page\models\Page;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = '' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
//        Yii::$app->settings->set('twitter2', 'sdadaadss22');
//        //Yii::$app->settings->set('twitter', 'sdadas');
//        var_dump(Yii::$app->settings->get('twitter'));
//        exit;

        return $this->render('index', [

        ]);
    }

    public function actionAbout()
    {
        return $this->render('about', [

        ]);
    }


    public function actionOLDIndex()
    {
        /**
         * Слайдер
         */
        $sliders = Slider::find()
            ->select([
                Slider::tableName() . '.thumbnail',
                SliderTranslation::tableName() . '.title',
                SliderTranslation::tableName() . '.link',
                SliderTranslation::tableName() . '.button_text'
            ])
            ->innerJoinWith('translations', false)
            ->where([
                SliderTranslation::tableName() . '.status' => Slider::STATUS_PUBLISHED,
                SliderTranslation::tableName() . '.language' => Yii::$app->language,
            ])
            ->orderBy([SliderTranslation::tableName() . '.created_at' => SORT_ASC])
            ->asArray()
            ->all();

        /**
         * Классы авто
         */
        $categories = Category::find()
            ->joinWith('translation')
            ->joinWith('minimumPrice')
            ->orderBy([Category::tableName() . '.created_at' => SORT_ASC])
            ->asArray()
            ->all();

        /**
         * Список "Выгодное предложение"
         */
        $offers_query = Car::find()
            ->joinWith('translation')
            ->joinWith('translatedBrand')
            ->joinWith('translatedModel')
            ->where([
                Car::tableName() . '.show_in_homepage' => 1,
            ]);

        $offers_count_query = clone $offers_query;

        $offers_pages = new Pagination([
            'totalCount' => $offers_count_query->count(),
            'defaultPageSize' => 3,
        ]);

        $offers = $offers_query
            ->limit(($offers_pages->page + 1) * $offers_pages->limit)
            ->all();

        /**
         * Список "Наши услуги"
         */
        $services = Service::find()
            ->select([
                Service::tableName() . '.thumbnail',
                ServiceTranslation::tableName() . '.title',
                ServiceTranslation::tableName() . '.link',
            ])
            ->innerJoinWith('translations', false)
            ->where([
                ServiceTranslation::tableName() . '.status' => Service::STATUS_PUBLISHED,
                ServiceTranslation::tableName() . '.language' => Yii::$app->language,
            ])
            ->orderBy([ServiceTranslation::tableName() . '.created_at' => SORT_ASC])
            ->limit(4)
            ->asArray()
            ->all();

        /**
         * Список "Полезно знать"
         */
        $usefuls = Useful::find()
            ->select([
                UsefulTranslation::tableName() . '.title',
                UsefulTranslation::tableName() . '.description',
            ])
            ->innerJoinWith('translations', false)
            ->where([
                UsefulTranslation::tableName() . '.status' => Useful::STATUS_PUBLISHED,
                UsefulTranslation::tableName() . '.language' => Yii::$app->language,
            ])
            ->orderBy([UsefulTranslation::tableName() . '.created_at' => SORT_ASC])
            ->limit(3)
            ->asArray()
            ->all();

        /**
         * Список "Отзывы клиентов"
         */
        $reviews = Review::find()
            ->select([
                ReviewTranslation::tableName() . '.title',
                ReviewTranslation::tableName() . '.description',
                Review::tableName() . '.publish_date',
            ])
            ->innerJoinWith('translations', false)
            ->where([
                ReviewTranslation::tableName() . '.status' => Useful::STATUS_PUBLISHED,
                ReviewTranslation::tableName() . '.language' => Yii::$app->language,
            ])
            ->andWhere(['<', Review::tableName() . '.publish_date', time()])
            ->orderBy('RAND()')
            ->limit(3)
            ->asArray()
            ->all();

        return $this->render('index', [
            'sliders' => $sliders,
            'categories' => $categories,
            'services' => $services,
            'offers' => $offers,
            'offers_pages' => $offers_pages,
            'usefuls' => $usefuls,
            'reviews' => $reviews,
        ]);
    }
}
