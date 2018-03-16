<?php
namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\models\Setting;
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;
use Yii;
use yii\base\InvalidParamException;
use yii\helpers\Url;
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
use yii\web\NotFoundHttpException;

/**
 * Site controller
 */
class SiteController extends Controller
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
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionError()
    {

        $mail = '';

        if(!strpos(Yii::$app->request->url, 'debug/default/toolbar')!==false){
            if (!Yii::$app->mailer->compose()
                ->setFrom(Setting::get('robot_email'))
                //->setFrom('itc@iq-offshore.com')
                ->setTo('akvamiris@gmail.com')
                ->setSubject('Рапорт об ошибке')
                ->setHtmlBody('
                <b>404: ' . Url::base('https') . Yii::$app->request->url . '</b><br />
                <span>Referrer: ' . Yii::$app->request->referrer . '</span><br />
            ')//Url::to()
                //->setReplyTo(Setting::get('admin_email'))
                ->send())
            {
                $mail = 'Email not sended!!!!!';
            }
        }


        return $this->render('error', [
            'message' => Yii::t('yii', 'Page not found.').' '.$mail,
            'exception' => Yii::$app->errorHandler->exception
        ]);
        /*
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }*/
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $page = \frontend\modules\page\api\Page::get('page-main');
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


        if (!Yii::$app->getModule('admin')->installed) {
            //return $this->redirect(['/install/step1']);
        }

        $offers = Offers::items([
            'where' => ['to_main' => 1, 'status' => 1],
            'pagination' => ['pageSize' => 10]
        ]);

        $news = Page::items([
            'where' => ['type_id' => 2, 'to_main' => 1, 'status' => 1],
            'pagination' => ['pageSize' => 3]
        ]);

        $licenses = Page::items([
            'where' => ['type_id' => 3, 'to_main' => 1, 'status' => 1],
            'pagination' => ['pageSize' => 10]
        ]);

        $banks = Banks::items([
            'where' => ['to_main' => 1, 'status' => 1],
            'pagination' => ['pageSize' => 10]
        ]);

        $fonds = Page::items([
            'where' => ['type_id' => 4, 'to_main' => 1, 'status' => 1],
            'pagination' => ['pageSize' => 2]
        ]);
        $sale = Page::items([
            'where' => ['type_id' => 7, 'to_main' => 1, 'status' => 1],
            'pagination' => ['pageSize' => 10]
        ]);

        return $this->render('main', [
            'offers' => $offers,
            'news' => $news,
            'licenses' => $licenses,
            'fonds' => $fonds,
            'banks' => $banks,
            'sale' => $sale
        ]);
    }

//    /**
//     * @return string|\yii\web\Response
//     */
//    public function actionIndexold()
//    {
//
//        $this->view->registerCssFile(Yii::$app->request->baseUrl . '/css/revicons/revolution.css', ['depends' => ['yii\bootstrap\BootstrapAsset']]);
//        //$this->view->registerJsFile('path/to/myfile');
//
//        if (!Yii::$app->getModule('admin')->installed) {
//            //return $this->redirect(['/install/step1']);
//        }
//        // layout from /frontend/views/layouts/layoutName.php
//        $this->layout = "@app/views/layouts/main.old.php";
//
//        return $this->render('index');
//    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionRedirect($url = '')
    {
        if (substr($url, -1) === '/') {
            return $this->redirect('/' . substr($url, 0, -1), 301);
        } else {
            throw new NotFoundHttpException;
        }
    }
}
