<?php
namespace frontend\modules\orders\controllers;

use Yii;
use yii\data\ActiveDataProvider;

use frontend\components\Controller;
use frontend\models\Setting;
use frontend\modules\orders\models\Orders;

class AController extends Controller
{
    public $new = 0;
    public $noAnswer = 0;

    public function init()
    {
        parent::init();

        $this->new = Yii::$app->getModule('admin')->activeModules['orders']->notice;
        $this->noAnswer = Orders::find()->status(Orders::STATUS_VIEW)->count();
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Orders::find()->status(Orders::STATUS_NEW)->asc(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionNoanswer()
    {
        $this->setReturnUrl();

        $data = new ActiveDataProvider([
            'query' => Orders::find()->status(Orders::STATUS_VIEW)->asc(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionAll()
    {
        $this->setReturnUrl();

        $data = new ActiveDataProvider([
            'query' => Orders::find()->desc(),
        ]);
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionView($id)
    {
        $model = Orders::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if($model->status == Orders::STATUS_NEW){
            $model->status = Orders::STATUS_VIEW;
            $model->update();
        }

        $postData = Yii::$app->request->post('Orders');
        if($postData) {
            if(filter_var(Setting::get('admin_email'), FILTER_VALIDATE_EMAIL))
            {
                $model->answer_subject = filter_var($postData['answer_subject'], FILTER_SANITIZE_STRING);
                $model->answer_text = filter_var($postData['answer_text'], FILTER_SANITIZE_STRING);
                if($model->sendAnswer()){
                    $model->status = Orders::STATUS_ANSWERED;
                    $model->save();
                    $this->flash('success', Yii::t('easyii/orders', 'Answer successfully sent'));
                }
                else{
                    $this->flash('error', Yii::t('easyii/orders', 'An error has occurred while sending mail'));
                }
            }
            else {
                $this->flash('error', Yii::t('easyii/orders', 'Please fill correct `Admin E-mail` in Settings'));
            }

            return $this->refresh();
        }
        else {
            if(!$model->answer_text) {
                $model->answer_subject = Yii::t('easyii/orders', $this->module->settings['answerSubject']);
                if ($this->module->settings['answerHeader']) $model->answer_text = Yii::t('easyii/orders', $this->module->settings['answerHeader']) . " " . $model->name . ".\n";
                if ($this->module->settings['answerFooter']) $model->answer_text .= "\n\n" . Yii::t('easyii/orders', $this->module->settings['answerFooter']);
            }

            return $this->render('view', [
                'model' => $model
            ]);
        }
    }

    public function actionSetAnswer($id)
    {
        $model = Orders::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
        }
        else{
            $model->status = Orders::STATUS_ANSWERED;
            if($model->update()) {
                $this->flash('success', Yii::t('easyii/orders', 'Orders updated'));
            }
            else{
                $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
            }
        }
        return $this->back();
    }

    public function actionDelete($id)
    {
        if(($model = Orders::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii/orders', 'Orders deleted'));
    }
}