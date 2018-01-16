<?php

namespace app\modules\news\controllers\frontend;

use Yii;
use app\modules\news\models\News;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Новости – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = News::find()
            ->joinWith('translation')
            ->where(['type' => News::$_type])
            ->orderBy([News::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
        //var_dump($query->createCommand()->rawSql);exit;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => News::PAGE_LIMIT,
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
        $model = News::find()
            ->with('translation')
            ->with('images')
            ->where([News::tableName() . '.id' => Yii::$app->request->get('id')])
            ->asArray()
            ->one();

        if ($model) {
            $next = News::find()
                ->joinWith('translation')
                ->where(['type' => News::$_type])
                ->andWhere([
                    'and',
                    ['<>', News::tableName() . '.id', $model['id']],
                    ['>=', News::tableName() . '.publish_date', $model['publish_date']],
                ])
                ->orderBy([News::tableName() . '.publish_date' => SORT_ASC])
                ->asArray()
                ->one();

            $prev = News::find()
                ->joinWith('translation')
                ->where(['type' => News::$_type])
                ->andWhere([
                    'and',
                    ['<>', News::tableName() . '.id', $model['id']],
                    ['<=', News::tableName() . '.publish_date', $model['publish_date']],
                ])
                ->orderBy([News::tableName() . '.publish_date' => SORT_DESC])
                ->asArray()
                ->one();

            return $this->render('view', [
                'model' => $model,
                'next' => $next,
                'prev' => $prev,
            ]);
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
    }

    public function actionLoadMore()
    {
        $offset = Yii::$app->request->get('offset', 0);

        $models = News::find()
            ->with('translations')
            ->where(['type' => News::$_type])
            //->orderBy([Video::tableName() . '.created_at' => SORT_DESC])
            ->limit(News::PAGE_LIMIT)
            ->offset($offset)
            ->all();

        return $this->renderAjax('items', [
            'models' => $models,
        ]);
    }
}
