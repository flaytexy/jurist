<?php

namespace app\modules\page\controllers\frontend;

use app\models\Language;
use app\modules\page\models\ReviewTranslation;
use Yii;
use app\modules\page\models\Review;
use yii\base\Model;
use yii\data\Pagination;
use yii\web\Controller;

class ReviewController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Отзывы – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Review::find()
            ->joinWith('translation');
        $countQuery = clone $query;
        $reviews_pages = new Pagination([
            'forcePageParam' => false,
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => 3,
        ]);

        $reviews = $query->offset($reviews_pages->offset)
            ->orderBy([Review::tableName() . '.publish_date' => SORT_DESC])
            ->limit($reviews_pages->limit)
            ->asArray()
            ->all();

        $review_model = new Review;

        $review_translation_models = [];
        foreach (Language::getLanguages() as $language) {
            $review_translation_model = new ReviewTranslation;
            $review_translation_model->loadDefaultValues();
            $review_translation_models[$language['local']] = $review_translation_model;
        }

        if (Model::loadMultiple($review_translation_models, Yii::$app->request->post()) && $review_translation_models[Yii::$app->language]->validate(['title', 'description'])) {
            $review_model->publish_date = time();
            $review_model->save();


            foreach ($review_translation_models as $language => $review_translation_model) {
                $review_translation_model->review_id = $review_model->id;
                $review_translation_model->status = 0;
                $review_translation_model->language = $language;
                $review_translation_model->description = nl2br($review_translation_model->description);
                $review_translation_model->save(false);
            }

            Yii::$app->session->setFlash('flash-review-add-success', Yii::t('app', 'Ваш отзыв добавлен, после проверки модератором, он будет опубликован.'));

            $review_model = new Review;

            $review_translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $review_translation_model = new ReviewTranslation;
                $review_translation_model->loadDefaultValues();
                $review_translation_models[$language['local']] = $review_translation_model;
            }
        }

        return $this->render('index', [
            'reviews' => $reviews,
            'reviews_pages' => $reviews_pages,
            'review_model' => $review_model,
            'review_translation_models' => $review_translation_models,
        ]);
    }
}
