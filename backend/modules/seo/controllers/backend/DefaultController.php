<?php

namespace app\modules\seo\controllers\backend;

use app\modules\seo\models\Seo;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'SEO – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Seo::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {
        $model = Seo::find()
            ->where([
                Seo::tableName() . '.id' => $id,
            ])
            ->one();

        if (!$model) {
            return $this->redirect(['index']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('flash-admin-message-success', 'SEO страницы обновлено.');

            return $this->redirect(Url::to(['/admin/seo/default/edit', 'id' => $model->id]));
        }

        return $this->render('edit', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = Seo::find()
            ->where(['id' => $id])
            ->one();

        if ($model) {
            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'SEO страницы удалено.');
        }

        return $this->redirect(Url::to(['/admin/seo/default/index']));
    }
}
