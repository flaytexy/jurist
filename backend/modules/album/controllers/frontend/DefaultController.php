<?php

namespace backend\modules\album\controllers\frontend;

use Yii;
use backend\modules\album\models\Album;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Галереи – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Album::find()
            ->joinWith('translation')
            ->where(['type' => Album::$_type])
            ->orderBy([Album::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Album::PAGE_LIMIT,
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
        $model = Album::find()
            ->joinWith('translation')
            ->with('images')
            ->where([Album::tableName() . '.id' => Yii::$app->request->get('id')])
            ->asArray()
            ->one();

        if ($model) {
            $next = Album::find()
                ->joinWith('translation')
                ->where([
                    'and',
                    ['<>', Album::tableName() . '.id', $model['id']],
                    ['>=', Album::tableName() . '.publish_date', $model['publish_date']],
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

        $models = Album::find()
            ->with('translations')
            ->where(['type' => Album::$_type])
            //->orderBy([Video::tableName() . '.created_at' => SORT_DESC])
            ->limit(Album::PAGE_LIMIT)
            ->offset($offset)
            ->all();

        return $this->renderAjax('items', [
            'models' => $models,
        ]);
    }
}
