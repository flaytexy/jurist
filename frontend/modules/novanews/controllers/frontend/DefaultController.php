<?php

namespace frontend\modules\novanews\controllers\frontend;

use Yii;
use frontend\modules\novanews\models\Novanews;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Статьи – ' . Yii::$app->params['sitePrefix'];

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
}
