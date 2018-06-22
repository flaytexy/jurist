<?php

namespace frontend\modules\novanews\controllers\backend;

use common\controllers\ContentAdminController;
use common\models\Language;

use frontend\modules\novanews\models\Novanews;
use frontend\modules\novanews\models\NovanewsTranslation;

use Yii;
use yii\helpers\Url;
use yii\data\Pagination;

class DefaultController extends ContentAdminController
{
    public function actions()
    {
        return [
            'deleteImage' => [
                'class' => 'common\action\DeleteImageAction',
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
                'class' => 'common\action\CropImageAction',
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
            //->where(['type' => Novanews::$_type])
            //->groupBy(Novanews::tableName() . '.id');
            ->orderBy([Novanews::tableName() . '.time' => SORT_DESC]); //publish_date' => SORT_DESC
            //->limit();
        //$sql = $query->createCommand()->rawSql;

        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 200]);

        $models = $query
            //->where(['type' => Novanews::$_type])
            ->orderBy([Novanews::tableName() . '.time' => SORT_DESC]) //publish_date' => SORT_DESC
            ->offset($pages->offset)
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

            foreach (Language::getLanguages() as $language) {
                if(!isset($model->translations[$language['local']])){
                    $translation_model = new NovanewsTranslation;
                    $translation_model->loadDefaultValues();
                    $translation_models[$language['local']] = $translation_model;
                }
            }
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

        if($request->post()){
            $model->category_detail =  $model->type_id . ":" . $model->category_id;
            $model->time = time();

            $this->_saveItem($model, $request, $translation_models);
        }

        //$categories = PageCategories::findAll();
        $query = new \yii\db\Query;
        $query->select('ept.title as parent_title, ept.*, ept2.*')
            ->from('content_categories as ept')
            ->join('RIGHT JOIN', 'content_categories as ept2', 'ept2.parent_id = ept.category_id')
            ->limit(20);
        $command = $query->createCommand();
        $categoriesData = $command->queryAll();

        $categories = [];
        foreach($categoriesData as $value){
            if($value['parent_title']) {
                $categories[$value['type_id'] . ":" .$value['category_id']] = $value['parent_title'] . " -> ". $value['title'];

            }
            else {
                $categories[$value['type_id'] . ":" .$value['category_id']] = $value['title'];
            }

        }

        return $this->render('edit', [
            'model' => $model,
            'categories' => $categories,
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
