<?php

namespace app\modules\press\controllers\frontend;

use Yii;
use app\modules\press\models\Press;
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
        $query = Press::find()
            ->joinWith('translation')
            ->where(['type' => Press::$_type])
            ->orderBy([Press::tableName() . '.publish_date' => SORT_DESC]);
        $countQuery = clone $query;
     
        $pages = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Press::PAGE_LIMIT,
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

        $model = Press::find()
            ->with('translation')
            ->with('images')
            ->where([Press::tableName() . '.id' => Yii::$app->request->get('id')])
            ->asArray()
            ->one();

        if ($model) {
            $next = Press::find()
                ->joinWith('translation')
                ->where(['type' => Press::$_type])
                ->andWhere([
                    'and',
                    ['<>', Press::tableName() . '.id', $model['id']],
                    ['>=', Press::tableName() . '.publish_date', $model['publish_date']],
                ])
                ->orderBy([Press::tableName() . '.publish_date' => SORT_ASC])
                ->asArray()
                ->one();


            $prev = Press::find()
                ->joinWith('translation')
                ->where(['type' => Press::$_type])
                ->andWhere([
                    'and',
                    ['<>', Press::tableName() . '.id', $model['id']],
                    ['<=', Press::tableName() . '.publish_date', $model['publish_date']],
                ])
                ->orderBy([Press::tableName() . '.publish_date' => SORT_DESC])
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

        $models = Press::find()
            ->with('translations')
            ->where(['type' => Press::$_type])
            //->orderBy([Video::tableName() . '.created_at' => SORT_DESC])
            ->limit(Press::PAGE_LIMIT)
            ->offset($offset)
            ->all();

        return $this->renderAjax('items', [
            'models' => $models,
        ]);
    }
}
