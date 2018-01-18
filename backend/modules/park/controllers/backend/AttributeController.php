<?php

namespace backend\modules\park\controllers\backend;

use backend\models\Language;
use backend\modules\park\models\Attribute;
use backend\modules\park\models\AttributeTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class AttributeController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Характеристики – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Attribute::find()
            ->joinWith('translations')
            ->groupBy(Attribute::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Attribute::tableName() . '.created_at' => SORT_ASC])
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
         * @var Attribute $model
         * @var AttributeTranslation|array $translation_models
         * @var AttributeTranslation $translation_model
         */

        $model = Attribute::find()
            ->where([Attribute::tableName() . '.id' => $id])
            ->with('translations')
            ->one();

        if ($model instanceof Attribute) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/park/attribute/index']);
            }

            $model = new Attribute;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new AttributeTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = AttributeTranslation::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->attribute_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Характеристика добавлена.' : 'Характеристика обновлена.');

                return $this->redirect(Url::to(['/admin/park/attribute/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Attribute $model
         * @var AttributeTranslation $translation
         */

        $model = Attribute::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Характеристика удалена.');
        }

        return $this->redirect(Url::to(['/admin/park/attribute/index']));
    }
}
