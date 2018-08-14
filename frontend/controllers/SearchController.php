<?php
namespace frontend\controllers;

use frontend\modules\novanews\models\NovanewsTranslation;
use frontend\modules\page\api\Page;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\widgets\LinkPager;

/**
 * Site controller
 */
class SearchController extends Controller
{
//    /**
//     * @inheritdoc
//     */
//    public function behaviors()
//    {
//        return [
//            'access' => [
//                'class' => AccessControl::className(),
//                'only' => ['logout', 'signup'],
//                'rules' => [
//                    [
//                        'actions' => ['signup'],
//                        'allow' => true,
//                        'roles' => ['?'],
//                    ],
//                    [
//                        'actions' => ['logout'],
//                        'allow' => true,
//                        'roles' => ['@'],
//                    ],
//                ],
//            ],
//            'verbs' => [
//                'class' => VerbFilter::className(),
//                'actions' => [
//                    'logout' => ['post'],
//                ],
//            ],
//        ];
//    }
//
//    /**
//     * @inheritdoc
//     */
//    public function actions()
//    {
//        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
//            'captcha' => [
//                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
//            ],
//        ];
//    }
//
//    /**
//     * Displays homepage.
//     *
//     * @return mixed
//     */


    public function actionIndex()
    {

        $page = \frontend\modules\page\api\Page::get('page-search');
        if($page){
            $this->view->title = $page->seo('title', $page->model->title);
            //$this->view->registerMetaTag(['name' => 'keywords', 'content' => 'yii, framework, php']);
            $this->view->registerMetaTag([
                'name' => 'title',
                'content' => $page->seo('title', '')
            ]);
            $this->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $page->seo('keywords', '')
            ]);
            $this->view->registerMetaTag([
                'name' => 'description',
                'content' => $page->seo('description', '')
            ]);
        }

//        $news = Novanews::items([
//            'seasch' => '',
//            'where' => ['status' => 1],
//            'pagination' => ['pageSize' => 250]
//        ]);

        $search = Yii::$app->request->post('search');

        $query = (new Query())->select("content_translation.*, content.*, content_categories.slug as slug_category, (MATCH (`description`) AGAINST ('".$search."' IN BOOLEAN MODE)) as REL")
            ->from('content_translation')
            ->where("(MATCH (`description`) AGAINST ('".$search."' IN BOOLEAN MODE)) ")
            ->andWhere([NovanewsTranslation::tableName() . '.public_status' => NovanewsTranslation::STATUS_ON])
            ->leftJoin('content', 'content.id = content_translation.content_id')
            ->leftJoin('content_categories', 'content.category_id = content_categories.category_id')
            ->orderBy('REL DESC');

        $_adp = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
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
