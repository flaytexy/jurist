<?php

namespace app\modules\park\controllers\backend;

use app\models\Language;
use app\modules\park\models\Service;
use app\modules\park\models\ServiceTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class ServiceController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Дополнительные услуги – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Service::find()
            ->joinWith('translations')
            ->groupBy(Service::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Service::tableName() . '.created_at' => SORT_ASC])
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
         * @var Service $model
         * @var ServiceTranslation|array $translation_models
         * @var ServiceTranslation $translation_model
         */

        $model = Service::find()
            ->where([Service::tableName() . '.id' => $id])
            ->with('translations')
            ->with('thumbnail')
            ->one();

        if ($model instanceof Service) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/park/service/index']);
            }

            $model = new Service;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new ServiceTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = ServiceTranslation::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->service_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Дополнительная услуга добавлена.' : 'Дополнительная услуга обновлена.');

                return $this->redirect(Url::to(['/admin/park/service/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Service $model
         * @var ServiceTranslation $translation
         */

        $model = Service::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Дополнительная услуга удалена.');
        }

        return $this->redirect(Url::to(['/admin/park/service/index']));
    }
}
