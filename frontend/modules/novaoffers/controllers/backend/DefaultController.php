<?php

namespace frontend\modules\novaoffers\controllers\backend;

use common\controllers\ContentAdminController;
use common\models\Language;

use frontend\modules\novaoffers\models\Novaoffers;
use frontend\modules\novaoffers\models\NovaoffersTranslation;

use frontend\modules\novaoffers\models\Offers;
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
                'modelClass' => Novaoffers::className(),
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
                'modelClass' => Novaoffers::className(),
                'redirectUrl' => function ($model) {
                    /* @var $model Novaoffers */
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
        $query = Novaoffers::find()
            ->joinWith('translations')
            ->where(['type' => Novaoffers::$_type])
            //->groupBy(Novaoffers::tableName() . '.id');
            ->orderBy([Novaoffers::tableName() . '.time' => SORT_DESC]); //publish_date' => SORT_DESC
        //->limit();
        //$sql = $query->createCommand()->rawSql;

        $countQuery = clone $query;

        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 200]);

        $models = $query
            ->where(['type' => Novaoffers::$_type])
            ->orderBy([Novaoffers::tableName() . '.time' => SORT_DESC])//publish_date' => SORT_DESC
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
         * @var Novaoffers $model
         * @var NovaoffersTranslation|array $translation_models
         * @var NovaoffersTranslation $translation_model
         */
        $model = Novaoffers::find()
            ->where([Novaoffers::tableName() . '.id' => $id])
            ->with('translations')
            ->with('images')
            ->one();

        if ($model instanceof Novaoffers) {

            $translation_models = $model->translations;

            foreach (Language::getLanguages() as $language) {
                if (!isset($model->translations[$language['local']])) {
                    $translation_model = new NovaoffersTranslation;
                    $translation_model->loadDefaultValues();
                    $translation_models[$language['local']] = $translation_model;
                }
            }

            $model->category_detail =  $model->type_id . ":" . $model->category_id;
        } else {
            if ($id) {
                return $this->redirect(['/admin/novaoffers/default/index']);
            }

            $model = new Novaoffers;

            $translation_models = [];
            foreach (Language::getLanguages() as $language) {
                $translation_model = new NovaoffersTranslation;
                $translation_model->loadDefaultValues();
                $translation_models[$language['local']] = $translation_model;
            }

            $model->category_detail = Novaoffers::TYPE_ID . ':30';
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
         * @var Novaoffers $model
         * @var NovaoffersTranslation $translation
         */

        $model = Novaoffers::find()
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

        return $this->redirect(Url::to(['/admin/novaoffers/default/index']));
    }


}
