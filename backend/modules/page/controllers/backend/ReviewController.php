<?php

namespace app\modules\page\controllers\backend;

use app\models\Language;
use app\modules\page\models\Page;
use app\modules\page\models\PageTranslation;
use app\modules\page\models\Review;
use app\modules\page\models\ReviewTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
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
            ->joinWith('translations')
            ->groupBy(Review::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Review::tableName() . '.publish_date' => SORT_DESC])
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {
        /**
         * @var Review $model
         * @var ReviewTranslation|array $translation_models
         * @var ReviewTranslation $translation_model
         */

        $model = Review::find()
            ->where([
                Review::tableName() . '.id' => $id,
            ])
            ->with('translations')
            ->with('thumbnail')
            ->one();

        if ($model instanceof Review) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/page/review/index']);
            }

            $model = new Review;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new ReviewTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        $model->publish_date = date('d.m.Y', ($model->publish_date ? $model->publish_date : time()));

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = Page::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->publish_date = strtotime($model->publish_date);

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->review_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Отзыв создан.' : 'Отзыв обновлен.');

                return $this->redirect(Url::to(['/admin/page/review/edit', 'id' => $model->id, 'language' => $model->language]));
            }
        }

        return $this->render('edit', [
            'model' => $model,
            'translation_models' => $translation_models,
        ]);
    }

    public function actionDelete($id)
    {
        /**
         * @var Review $model
         * @var ReviewTranslation $translation
         */

        $model = Review::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Отзыв удален.');
        }

        return $this->redirect(Url::to(['/admin/page/review/index']));
    }
}
