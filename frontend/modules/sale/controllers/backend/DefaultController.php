<?php

namespace frontend\modules\sale\controllers\backend;

use common\controllers\ContentAdminController;
use common\models\Language;

use frontend\modules\sale\models\Sale;
use frontend\modules\sale\models\SaleTranslation;

use frontend\modules\sale\models\Offers;
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
                'modelClass' => Sale::className(),
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
                'modelClass' => Sale::className(),
                'redirectUrl' => function ($model) {
                    /* @var $model Sale */
                    // triggered on !Yii::$app->request->isAjax, else will be returned JSON: {status: "success"}
                    return ['update', 'id' => $model->id];
                },
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->view->title = 'Компании – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $searchpage = Yii::$app->request->post('searchpage');
        $query = Sale::find()
            ->joinWith('translations')
            ->where(['type' => Sale::$_type])
            //->groupBy(Sale::tableName() . '.id');
            ->orderBy([Sale::tableName() . '.time' => SORT_DESC]); //publish_date' => SORT_DESC
        //->limit();
        //$sql = $query->createCommand()->rawSql;

        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 200]);

        $models = $query
            ->where(['type' => Sale::$_type])
            ->filterWhere(['like', 'name', $searchpage])
            ->orderBy([Sale::tableName() . '.time' => SORT_DESC])//publish_date' => SORT_DESC
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

        if($id==false && $request->post('id')){
            $id = $request->post('id');
        }

        /**
         * @var Sale $model
         * @var SaleTranslation|array $translation_models
         * @var SaleTranslation $translation_model
         */
        $model = Sale::find()
            ->where([Sale::tableName() . '.id' => $id])
            ->with('translations')
            ->with('images')
            ->one();

        if ($model instanceof Sale) {

            $translation_models = $model->translations;

            foreach (Language::getLanguages() as $language) {
                if (!isset($model->translations[$language['local']])) {
                    $translation_model = new SaleTranslation;
                    $translation_model->loadDefaultValues();
                    $translation_models[$language['local']] = $translation_model;
                }
            }

            $model->category_detail =  $model->type_id . ":" . $model->category_id;
        } else {
            if ($id) {
                return $this->redirect(['/admin/sale/default/index']);
            }

            $model = new Sale;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new SaleTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }

            $model->category_detail = Sale::TYPE_ID . ':30';
        }

        if (isset($model->child)) {
            //$child = Banks::find()->where(['bank_id'=>$model->child->primaryKey])->one();
            $child = $model->child;
        } else {
            $child = new Offers();
            $child->loadDefaultValues();
        }



        if ($request->post()) {
            $this->_saveItem($model, $request, $translation_models, $child);
        }

        $query = new \yii\db\Query;
        $query->select('ept.title as parent_title, ept.*, ept2.*')
            ->from('content_categories as ept')
            ->join('RIGHT JOIN', 'content_categories as ept2', 'ept2.parent_id = ept.category_id')
            ->limit(20);
        $command = $query->createCommand();
        $categoriesData = $command->queryAll();

        $categories = [];
        foreach ($categoriesData as $value) {
            if ($value['parent_title']) {
                $categories[$value['type_id'] . ":" . $value['category_id']] = $value['parent_title'] . " -> " . $value['title'];
            } else {
                $categories[$value['type_id'] . ":" . $value['category_id']] = $value['title'];
            }
        }

        return $this->render('edit', [
            'model' => $model,
            'child' => $child,
            'categories' => $categories,
            'translation_models' => $translation_models,
        ]);
    }

    public function actionDelete($id)
    {
        /**
         * @var Sale $model
         * @var SaleTranslation $translation
         */

        $model = Sale::find()
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

        return $this->redirect(Url::to(['/admin/sale/default/index']));
    }


}
