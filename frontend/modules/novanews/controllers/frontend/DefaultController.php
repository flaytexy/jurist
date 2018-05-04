<?php

namespace frontend\modules\novanews\controllers\frontend;

use Yii;
use frontend\modules\novanews\models\Novanews;
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
        $query = Novanews::find()
            ->joinWith('translation')
            ->where(['type' => Novanews::$_type])
            ->orderBy([Novanews::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
        //var_dump($query->createCommand()->rawSql);exit;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Novanews::PAGE_LIMIT,
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
        $model = Novanews::find()
            ->with('translation')
            ->with('images')
            ->where([Novanews::tableName() . '.id' => Yii::$app->request->get('id')])
            ->asArray()
            ->one();

        if ($model) {
            $next = Novanews::find()
                ->joinWith('translation')
                ->where(['type' => Novanews::$_type])
                ->andWhere([
                    'and',
                    ['<>', Novanews::tableName() . '.id', $model['id']],
                    ['>=', Novanews::tableName() . '.publish_date', $model['publish_date']],
                ])
                ->orderBy([Novanews::tableName() . '.publish_date' => SORT_ASC])
                ->asArray()
                ->one();

            $prev = Novanews::find()
                ->joinWith('translation')
                ->where(['type' => Novanews::$_type])
                ->andWhere([
                    'and',
                    ['<>', Novanews::tableName() . '.id', $model['id']],
                    ['<=', Novanews::tableName() . '.publish_date', $model['publish_date']],
                ])
                ->orderBy([Novanews::tableName() . '.publish_date' => SORT_DESC])
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

        $models = Novanews::find()
            ->with('translations')
            ->where(['type' => Novanews::$_type])
            //->orderBy([Video::tableName() . '.created_at' => SORT_DESC])
            ->limit(Novanews::PAGE_LIMIT)
            ->offset($offset)
            ->all();

        return $this->renderAjax('items', [
            'models' => $models,
        ]);
    }
}
