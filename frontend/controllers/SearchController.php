<?php
namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;
use Yii;
use yii\base\InvalidParamException;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\modules\offers\api\Offers;
use yii\widgets\LinkPager;

/**
 * Site controller
 */
class SearchController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
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

        $search = Yii::$app->request->post('search');

        $query = (new Query())->select("*, MATCH (title,text) AGAINST ('".$search."' IN BOOLEAN MODE) as REL")
            ->from('content')
            ->where("MATCH (title,text) AGAINST ('".$search."' IN BOOLEAN MODE) OR `text` LIKE  '%".$search."%' ")
            ->orderBy('REL DESC');

        $_adp = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
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
