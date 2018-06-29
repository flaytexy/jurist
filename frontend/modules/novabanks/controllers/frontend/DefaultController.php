<?php

namespace frontend\modules\novabanks\controllers\frontend;

use Yii;
use frontend\modules\novabanks\models\Novabanks;
use yii\data\Pagination;
use yii\web\Controller;

class DefaultController extends Controller
{
    public function beforeAction($action)
    {
        $this->view->title = 'Новости – ' . Yii::$app->params['sitePrefix'];

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $query = Novabanks::find()
            ->joinWith('translation')
            ->where(['type' => Novabanks::$_type])
            ->orderBy([Novabanks::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
        //var_dump($query->createCommand()->rawSql);exit;
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Novabanks::PAGE_LIMIT,
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
