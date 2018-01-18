<?php

namespace backend\modules\page\controllers\backend;

use backend\models\Language;
use backend\modules\page\models\Page;
use backend\modules\page\models\PageTranslation;
use backend\modules\page\models\Slider;
use backend\modules\page\models\SliderTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class SliderController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Слайды – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Slider::find()
            ->joinWith('translations')
            ->groupBy(Slider::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([SliderTranslation::tableName() . '.created_at' => SORT_ASC])
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
         * @var Slider $model
         * @var SliderTranslation|array $translation_models
         * @var SliderTranslation $translation_model
         */

        $model = Slider::find()
            ->where([
                Slider::tableName() . '.id' => $id,
            ])
            ->with('translations')
            ->with('thumbnail')
            ->one();

        if ($model instanceof Slider) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/page/slider/index']);
            }

            $model = new Slider;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new SliderTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = Page::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->slider_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Слайд создан.' : 'Слайд обновлен.');

                return $this->redirect(Url::to(['/admin/page/slider/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Slider $model
         * @var SliderTranslation $translation
         */

        $model = Slider::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Слайд удален.');
        }

        return $this->redirect(Url::to(['/admin/page/slider/index']));
    }
}
