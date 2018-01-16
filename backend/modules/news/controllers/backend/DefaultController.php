<?php

namespace app\modules\news\controllers\backend;

use app\controllers\ContentAdminController;
use app\models\ContentImage;
use app\models\Language;
use app\modules\attachment\models\Attachment;
use app\modules\news\models\News;
use app\modules\news\models\NewsTranslation;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Inflector;
use yii\helpers\Url;
use yii\data\Pagination;
use yii\web\Request;

class DefaultController extends ContentAdminController
{

//    /**
//     * @inheritdoc
//     */
    public function actions()
    {
        return [
            'deleteImage' => [
                'class' => 'app\action\DeleteImageAction',
                'modelClass' => News::className(),
                'canDelete' => function ($model) {
                    /* @var $model \yii\db\ActiveRecord */
                    return $model->user_id == Yii::$app->user->id;
                },
                'redirectUrl' => function ($model) {
                    /* @var $model \yii\db\ActiveRecord */
                    // triggered on !Yii::$app->request->isAjax, else will be returned JSON: {status: "success"}
                    return ['post/view', 'id' => $model->primaryKey];
                },
                'afterDelete' => function ($model) {
                    /* @var $model \yii\db\ActiveRecord */
                    // You can customize response by this function, e.g. change response:
                    if (Yii::$app->request->isAjax) {
                        Yii::$app->response->getHeaders()->set('Vary', 'Accept');
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                        return ['status' => 'success', 'message' => 'Image deleted'];
                    } else {
                        return Yii::$app->response->redirect(['post/view', 'id' => $model->primaryKey]);
                    }
                },
            ],
            'cropImage' => [
                'class' => 'app\action\CropImageAction',
                'modelClass' => News::className(),
                'redirectUrl' => function ($model) {
                    /* @var $model News */
                    // triggered on !Yii::$app->request->isAjax, else will be returned JSON: {status: "success"}
                    return ['update', 'id' => $model->id];
                },
            ],
        ];
    }
    
    public function beforeAction($action)
    {
        $this->view->title = 'Новости – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = News::find()
            ->joinWith('translations')
            ->where(['type' => News::$_type])
            //->groupBy(News::tableName() . '.id');
            ->orderBy([News::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([News::tableName() . '.publish_date' => SORT_DESC])
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
         * @var News $model
         * @var NewsTranslation|array $translation_models
         * @var NewsTranslation $translation_model
         */
        $model = News::find()
            ->where([News::tableName() . '.id' => $id])
            ->with('translations')
            ->with('images')
            ->one();

        if ($model instanceof News) {
            $translation_models = $model->translations;
        } else {
            if ($id) {
                return $this->redirect(['/admin/news/default/index']);
            }

            $model = new News;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new NewsTranslation;
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
         * @var News $model
         * @var NewsTranslation $translation
         */

        $model = News::find()
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

        return $this->redirect(Url::to(['/admin/news/default/index']));
    }
}
