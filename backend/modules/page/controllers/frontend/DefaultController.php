<?php

namespace backend\modules\page\controllers\frontend;

use Yii;
use backend\modules\page\models\Page;
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
        $query = Page::find()
            ->joinWith('translation')
            ->where(['type' => Page::$_type])
            ->orderBy([Page::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
     
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Page::PAGE_LIMIT,
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

        $model = Page::find()
            ->joinWith('translation')
            ->where([Page::tableName() . '.id' => Yii::$app->request->get('id')])
            ->asArray()
            ->one();

        //var_dump($model->createCommand()->getRawSql());exit;
        if ($model) {
            $next = Page::find()
                ->joinWith('translation')
                ->where(['type' => Page::$_type])
                ->andWhere([
                    'and',
                    ['<>', Page::tableName() . '.id', $model['id']],
                    ['>=', Page::tableName() . '.publish_date', $model['publish_date']],
                ])
                ->orderBy([Page::tableName() . '.publish_date' => SORT_ASC])
                ->asArray()
                ->one();


            $prev = Page::find()
                ->joinWith('translation')
                ->where(['type' => Page::$_type])
                ->andWhere([
                    'and',
                    ['<>', Page::tableName() . '.id', $model['id']],
                    ['<=', Page::tableName() . '.publish_date', $model['publish_date']],
                ])
                ->orderBy([Page::tableName() . '.publish_date' => SORT_DESC])
                ->asArray()
                ->one();

            return $this->render('about', [
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

        $models = Page::find()
            ->with('translations')
            ->where(['type' => Page::$_type])
            //->orderBy([Video::tableName() . '.created_at' => SORT_DESC])
            ->limit(Page::PAGE_LIMIT)
            ->offset($offset)
            ->all();

        return $this->renderAjax('items', [
            'models' => $models,
        ]);
    }
}
