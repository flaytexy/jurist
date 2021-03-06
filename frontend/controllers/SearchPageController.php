<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dangel
 * Date: 07.11.2018
 * Time: 12:28
 */

namespace frontend\controllers;

use frontend\modules\novanews\models\Novanews;
use frontend\modules\novanews\models\NovanewsTranslation;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\widgets\LinkPager;

class SearchPageController
{
    public function actionIndex()
    {

//        $page = \frontend\modules\novanews\api\Novanews::get('page-search');
//        if($page){
//            $this->view->title = $page->seo('title', $page->model->title);
//            //$this->view->registerMetaTag(['name' => 'keywords', 'content' => 'yii, framework, php']);
//            $this->view->registerMetaTag([
//                'name' => 'title',
//                'content' => $page->seo('title', '')
//            ]);
//            $this->view->registerMetaTag([
//                'name' => 'keywords',
//                'content' => $page->seo('keywords', '')
//            ]);
//            $this->view->registerMetaTag([
//                'name' => 'description',
//                'content' => $page->seo('description', '')
//            ]);
//        }
//
////        $news = Novanews::items([
////            'seasch' => '',
////            'where' => ['status' => 1],
////            'pagination' => ['pageSize' => 250]
////        ]);

        $search = Yii::$app->request->post('searchpage');

        $query = (new Query())->select(['content_translation.*', 'content.*', 'content_categories.slug as slug_category', 'MATCH (`name`,`description`) AGAINST ( :search IN BOOLEAN MODE) as REL'])
            ->from('content_translation')
            ->leftJoin('content', 'content.id = content_translation.content_id')
            ->leftJoin('content_categories', 'content.category_id = content_categories.category_id')
            ->where('(MATCH (`name`,`description`) AGAINST (:search IN BOOLEAN MODE)) ')
            ->andWhere(['content' . '.status' => Novanews::STATUS_ON])
            ->andWhere([NovanewsTranslation::tableName() . '.public_status' => NovanewsTranslation::STATUS_ON])
            ->andWhere([NovanewsTranslation::tableName() . '.language' => Yii::$app->language ])
            ->addParams([':search' => $search])
            //->groupBy(['content.id'])
            ->orderBy('REL DESC');

        $_adp = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 200,
            ],

        ]);

        $items = $_adp->getModels();
        $_adp->pagination->pageSizeParam = false;

        return $this->render('search', [
            'items' => $items,
            'search' => $search,
            'pages' => LinkPager::widget(['pagination' => $_adp->pagination])
        ]);
    }


}

