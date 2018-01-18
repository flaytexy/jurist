<?php

namespace backend\modules\page\controllers\backend;

use backend\models\Language;
use backend\modules\page\models\Useful;
use backend\modules\page\models\UsefulTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class UsefulController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Полезно знать – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Useful::find()
            ->joinWith('translations')
            ->groupBy(Useful::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([UsefulTranslation::tableName() . '.created_at' => SORT_ASC])
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
         * @var Useful $model
         * @var UsefulTranslation|array $translation_models
         * @var UsefulTranslation $translation_model
         */

        $model = Useful::find()
            ->where([
                Useful::tableName() . '.id' => $id,
            ])
            ->with('translations')
            ->one();

        if ($model instanceof Useful) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/page/useful/index']);
            }

            $model = new Useful;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new UsefulTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = Useful::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->useful_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Раздел создан.' : 'Раздел обновлен.');

                return $this->redirect(Url::to(['/admin/page/useful/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Useful $model
         * @var UsefulTranslation $translation
         */

        $model = Useful::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Раздел удален.');
        }

        return $this->redirect(Url::to(['/admin/page/useful/index']));
    }
}
