<?php

namespace app\modules\park\controllers\backend;

use app\models\Language;
use app\modules\park\models\Brand;
use app\modules\park\models\Car;
use app\modules\park\models\Model;
use app\modules\park\models\ModelTranslation;
use Yii;
use yii\base\Model as BaseModel;
use yii\helpers\Html;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class ModelController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Модели – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Model::find()
            ->joinWith('translations')
            ->groupBy(Model::tableName() . '.id');


        $brand_model = Brand::find()
            ->where(['id' => Yii::$app->request->get('brand_id')])
            ->with('translations')
            ->one();

        if ($brand_model) {
            $query->andWhere([Model::tableName() . '.brand_id' => $brand_model->id]);
        }

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Model::tableName() . '.created_at' => SORT_ASC])
            ->limit($pages->limit);

        return $this->render('index', [
            'models' => $models->all(),
            'brand_model' => $brand_model,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {
        /**
         * @var Model $model
         * @var ModelTranslation|array $translation_models
         * @var ModelTranslation $translation_model
         */

        $model = Model::find()
            ->where([Model::tableName() . '.id' => $id])
            ->with('translations')
            ->one();

        if ($model instanceof Model) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/park/brand/index']);
            }

            $model = new Model;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new ModelTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);
        $model->brand_id = Yii::$app->request->get('brand_id', $model->brand_id);

        if ($model->load(Yii::$app->request->post()) && BaseModel::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if (!Inflector::slug($translation_model->slug)) {
                    $translation_model->slug = Inflector::slug($translation_model->title);
                }

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = ModelTranslation::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->model_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Модель добавлена.' : 'Модель обновлена.');

                return $this->redirect(Url::to(['/admin/park/model/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Model $model
         * @var ModelTranslation $translation
         */

        $model = Model::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Марка удалена.');
        }

        return $this->redirect(Url::to(['/admin/park/model/index']));
    }

    public function actionGetDropdownList() {
        $items = Model::getDropdownList(Yii::$app->request->post('brand_id'));

        $car_model = new Car;

        return Html::dropDownList(
            Html::getInputName($car_model, 'model_id'),
            null,
            $items,
            [
                'id' => Html::getInputId($car_model, 'model_id'),
                'class' => 'form-control boxed',
                'prompt' => '- Выбрать -',
            ]
        );
    }
}
