<?php

namespace backend\modules\park\controllers\backend;

use backend\models\Language;
use backend\modules\park\models\Attribute;
use backend\modules\park\models\AttributeValue;
use backend\modules\park\models\AttributeValueTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class AttributeValueController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Значения характеристик – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = AttributeValue::find()
            ->joinWith('translations')
            ->groupBy(AttributeValue::tableName() . '.id');

        $attribute_model = Attribute::find()
            ->where(['id' => Yii::$app->request->get('attribute_id')])
            ->with('translations')
            ->one();

        if ($attribute_model) {
            $query->andWhere([AttributeValue::tableName() . '.attribute_id' => $attribute_model->id]);
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([AttributeValue::tableName() . '.created_at' => SORT_ASC])
            ->limit($pages->limit);

        return $this->render('index', [
            'models' => $models->all(),
            'attribute_model' => $attribute_model,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {
        /**
         * @var AttributeValue $model
         * @var AttributeValueTranslation|array $translation_models
         * @var AttributeValueTranslation $translation_model
         */

        $model = AttributeValue::find()
            ->where([AttributeValue::tableName() . '.id' => $id])
            ->with('translations')
            ->one();

        if ($model instanceof AttributeValue) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/park/attribute-value/index']);
            }

            $model = new AttributeValue;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new AttributeValueTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);
        $model->attribute_id = Yii::$app->request->get('attribute_id', $model->attribute_id);

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if (!Inflector::slug($translation_model->slug)) {
                    $translation_model->slug = Inflector::slug($translation_model->title);
                }

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = AttributeValueTranslation::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->attribute_value_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Вариант характеристики добавлен.' : 'Вариант характеристики обновлен.');

                return $this->redirect(Url::to(['/admin/park/attribute-value/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var AttributeValue $model
         * @var AttributeValueTranslation $translation
         */

        $model = AttributeValue::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Вариант характеристики удален.');
        }

        return $this->redirect(Url::to(['/admin/park/attribute-value/index']));
    }
}
