<?php

namespace backend\controllers;

use Yii;

use yii\data\Pagination;
use yii\db\ActiveQuery;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ContentController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Видео – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Video::find()
            ->joinWith('translation')
            ->where(['type' => Video::$_type])
            ->orderBy([Video::tableName() . '.publish_date' => SORT_DESC]);
        //vd($query->count());
        //vd($query->createCommand()->rawSql);

        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Video::PAGE_LIMIT,
        ]);

        $models = $query
            ->limit(($pages->page + 1) * $pages->limit)
            ->asArray()
            ->all();

        return $this->render('index', [
            'models' => $models,
            'pages' => $pages,
        ]);
    }

    public function actionView()
    {
        $model = Video::find()
            ->joinWith('translation')
            ->where(['type' => Video::$_type])
            ->andWhere([Video::tableName() . '.id' => Yii::$app->request->get('id')])
            ->asArray()
            ->one();

        if ($model) {
            $next = Video::find()
                ->joinWith('translation')
                ->where([
                    'and',
                    ['<>', Video::tableName() . '.id', $model['id']],
                    ['>=', Video::tableName() . '.publish_date', $model['publish_date']],
                ])
                ->asArray()
                ->one();

            return $this->render('view', [
                'model' => $model,
                'next' => $next,
            ]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
    }

    public function actionLoadMore()
    {
        $offset = Yii::$app->request->get('offset', 0);

        $models = Video::find()
            ->with('translations')
            ->where(['type' => Video::$_type])
            //->orderBy([Video::tableName() . '.created_at' => SORT_DESC])
            ->limit(Video::PAGE_LIMIT)
            ->offset($offset)
            ->all();

        return $this->renderAjax('items', [
            'models' => $models,
        ]);
    }

}
