<?php

namespace backend\modules\press\controllers\backend;

use backend\controllers\ContentAdminController;
use backend\models\ContentImage;
use backend\models\Language;
use backend\modules\attachment\models\Attachment;
use backend\modules\press\models\Press;
use backend\modules\press\models\PressTranslation;
use Yii;
use yii\base\Model;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends ContentAdminController
{
    public function beforeAction($action)
    {
        $this->view->title = 'Новости – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Press::find()
            ->joinWith('translations')
            ->where(['type' => Press::$_type])
            //->groupBy(Press::tableName() . '.id');
            ->orderBy([Press::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Press::tableName() . '.publish_date' => SORT_DESC])
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {

        $request = Yii::$app->request;

        /**
         * @var Press $model
         * @var PressTranslation|array $translation_models
         * @var PressTranslation $translation_model
         */
        $model = Press::find()
            ->where([Press::tableName() . '.id' => $id])
            ->with('translations')
            ->with('images')
            ->one();

        if ($model instanceof Press) {
            $translation_models = $model->translations;
        } else {
            if ($id) {
                return $this->redirect(['/admin/press/default/index']);
            }

            $model = new Press;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new PressTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }
        }

        $this->_saveItem($model, $request, $translation_models);

        return $this->render('edit', [
            'model' => $model,
            'translation_models' => $translation_models,
        ]);
    }

    public function actionDelete($id)
    {
        /**
         * @var Press $model
         * @var PressTranslation $translation
         */

        $model = Press::find()
            ->where(['id' => $id])
            ->with('translations')
            ->one();

        if ($model) {
            foreach ($model->translations as $translation) {
                $translation->delete();
            }

            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Новость удалена.');
        }

        return $this->redirect(Url::to(['/admin/press/default/index']));
    }
}
