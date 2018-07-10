<?php

namespace frontend\modules\novaoffers\controllers\frontend;

use Yii;
use frontend\modules\novaoffers\models\Novaoffers;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Компании – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Novaoffers::find()
            ->joinWith('translation')
            ->where(['type' => Novaoffers::$_type])
            ->orderBy([Novaoffers::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
        //var_dump($query->createCommand()->rawSql);exit;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Novaoffers::PAGE_LIMIT,
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
