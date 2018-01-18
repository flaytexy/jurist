<?php

namespace backend\modules\page\controllers\backend;

use backend\models\Language;
use backend\modules\page\models\Page;
use backend\modules\page\models\PageTranslation;
use Yii;
use yii\base\Model;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Статические страницы – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Page::find()
            ->andWhere(['type' => Page::$_type])
            ->joinWith('translations')
            ->groupBy(Page::tableName() . '.id');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([PageTranslation::tableName() . '.created_at' => SORT_ASC])
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
         * @var Page $model
         * @var PageTranslation|array $translation_models
         * @var PageTranslation $translation_model
         */

        $model = Page::find()
            ->where([
                Page::tableName() . '.id' => $id,
                Page::tableName() . '.type' => Page::$_type,
            ])
            ->with('translations')
            //->with('thumbnail')
            ->one();

        if ($model instanceof Page) {
            $translation_models = $model->translations;
        } else {

            if ($id) {
                return $this->redirect(['/admin/page/default/index']);
            }

            $model = new Page;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new PageTranslation;
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
                    $translation_model->status = Page::STATUS_DRAFT;
                }

                $translation_model->clearErrors();
            }

            $model->validate();
            $model->type = Page::$_type;

            $is_new_record = $model->isNewRecord;

            if ($translation_models[$model->language]->validate() && $model->save(false)) {
                foreach ($translation_models as $language => $translation_model) {
                    $translation_model->content_id = $model->id;
                    $translation_model->save(false);
                }

                Yii::$app->session->setFlash('flash-admin-message-success', $is_new_record ? 'Страница создана.' : 'Страница обновлена.');

                return $this->redirect(Url::to(['/admin/page/default/edit', 'id' => $model->id, 'language' => $model->language]));
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
         * @var Page $model
         * @var PageTranslation $translation
         */

        $model = Page::find()
            ->where(['id' => $id, 'type' => Page::$_type, 'system' => 0])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Страница удалена.');
        }

        return $this->redirect(Url::to(['/admin/page/default/index']));
    }
}
