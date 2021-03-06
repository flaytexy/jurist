<?php

namespace backend\modules\park\controllers\backend;

use backend\models\Language;
use backend\modules\park\models\Category;
use backend\modules\park\models\CategoryTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class CategoryController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Классы – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Category::find()
            ->joinWith('translations')
            ->groupBy(Category::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Category::tableName() . '.created_at' => SORT_ASC])
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
         * @var Category $model
         * @var CategoryTranslation|array $translation_models
         * @var CategoryTranslation $translation_model
         */

        $model = Category::find()
            ->where([Category::tableName() . '.id' => $id])
            ->with('translations')
            ->with('thumbnail')
            ->one();

        if ($model instanceof Category) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/park/category/index']);
            }

            $model = new Category;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new CategoryTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $model->language = Yii::$app->request->get('language', $model->language);

        if ($model->load(Yii::$app->request->post()) && Model::loadMultiple($translation_models, Yii::$app->request->post())) {

            foreach ($translation_models as $language => $translation_model) {
                $translation_model->language = $language;

                if (!Inflector::slug($translation_model->slug)) {
                    $translation_model->slug = Inflector::slug($translation_model->title);
                }

                if ($language !== $model->language && !$translation_model->validate()) {
                    $translation_model->status = CategoryTranslation::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->category_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Класс добавлен.' : 'Класс обновлен.');

                return $this->redirect(Url::to(['/admin/park/category/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Category $model
         * @var CategoryTranslation $translation
         */

        $model = Category::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Класс удален.');
        }

        return $this->redirect(Url::to(['/admin/park/category/index']));
    }
}
