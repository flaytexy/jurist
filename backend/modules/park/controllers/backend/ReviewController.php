<?php

namespace app\modules\park\controllers\backend;

use app\modules\park\models\Review;
use Yii;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\Controller;

class ReviewController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Отзывы – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Review::find();
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);

        $models = $query->offset($pages->offset)
            ->orderBy([Review::tableName() . '.created_at' => SORT_DESC])
            ->limit($pages->limit)
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionEdit($id)
    {
        $model = Review::find()
            ->where([
                Review::tableName() . '.id' => $id,
            ])
            ->one();

        if ($model instanceof Review) {
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('flash-admin-message-success', 'Отзыв обновлен.');

                return $this->redirect(Url::to(['/admin/park/review/edit', 'id' => $model->id]));
            }

            return $this->render('edit', [
                'model' => $model,
            ]);
        } else {
            return $this->redirect(['/admin/park/review/index']);
        }
    }

    public function actionDelete($id)
    {
        /**
         * @var Review $model
         */

        $model = Review::find()
            ->where(['id' => $id])
            ->one();

        if ($model) {
            $model->delete();

            Yii::$app->session->setFlash('flash-admin-message-success', 'Отзыв удален.');
        }

        return $this->redirect(Url::to(['/admin/park/review/index']));
    }
}
