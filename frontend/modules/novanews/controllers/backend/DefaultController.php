<?php

namespace frontend\modules\novanews\controllers\backend;

use common\controllers\ContentAdminController;
use common\models\ContentImage;
use common\models\Language;
use common\modules\attachment\models\Attachment;
use frontend\modules\novanews\models\Novanews;
use frontend\modules\novanews\models\NovanewsTranslation;
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
                'modelClass' => Novanews::className(),
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
                'modelClass' => Novanews::className(),
                'redirectUrl' => function ($model) {
                    /* @var $model Novanews */
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
        $query = Novanews::find()
            ->joinWith('translations')
            ->where(['type' => Novanews::$_type])
            //->groupBy(Novanews::tableName() . '.id');
            ->orderBy([Novanews::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Novanews::tableName() . '.publish_date' => SORT_DESC])
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
         * @var Novanews $model
         * @var NovanewsTranslation|array $translation_models
         * @var NovanewsTranslation $translation_model
         */
        $model = Novanews::find()
            ->where([Novanews::tableName() . '.id' => $id])
            ->with('translations')
            ->with('images')
            ->one();

        if ($model instanceof Novanews) {
            $translation_models = $model->translations;
        } else {
            if ($id) {
                return $this->redirect(['/admin/novanews/default/index']);
            }

            $model = new Novanews;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new NovanewsTranslation;
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
         * @var Novanews $model
         * @var NovanewsTranslation $translation
         */

        $model = Novanews::find()
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

        return $this->redirect(Url::to(['/admin/novanews/default/index']));
    }
}
