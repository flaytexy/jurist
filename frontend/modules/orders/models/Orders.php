<?php
namespace frontend\modules\orders\models;

use Yii;
use frontend\behaviors\CalculateNotice;
use frontend\helpers\Mail;
use frontend\models\Setting;
use frontend\validators\ReCaptchaValidator;
use frontend\validators\EscapeValidator;
use yii\helpers\Url;

class Orders extends \frontend\components\ActiveRecord
{
    const STATUS_NEW = 0;
    const STATUS_VIEW = 1;
    const STATUS_ANSWERED = 2;

    const FLASH_KEY = 'eaysiicms_orders_send_result';

    public $reCaptcha;

    public static function tableName()
    {
        return 'easyii_offers_orders';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'text'], 'required'],
            [['name', 'email', 'phone', 'title', 'text'], 'trim'],
            [['name','title', 'text'], EscapeValidator::className()],
            ['title', 'string', 'max' => 128],
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^[\d\s-\+\(\)]+$/'],
//            ['reCaptcha', ReCaptchaValidator::className(), 'when' => function($model){
//                return $model->isNewRecord && Yii::$app->getModule('admin')->activeModules['orders']->settings['enableCaptcha'];
//            }],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if($insert){
                $this->ip = Yii::$app->request->userIP;
                $this->time = time();
                $this->status = self::STATUS_NEW;
            }
            return true;
        } else {
            return false;
        }
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if($insert){
            $this->mailAdmin();
        }
    }

    public function attributeLabels()
    {
        return [
            'email' => 'E-mail',
            'name' => Yii::t('easyii', 'Name'),
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
            'answer_subject' => Yii::t('easyii/orders', 'Subject'),
            'answer_text' => Yii::t('easyii', 'Text'),
            'phone' => Yii::t('easyii/orders', 'Phone'),
            'reCaptcha' => Yii::t('easyii', 'Anti-spam check')
        ];
    }

    public function behaviors()
    {
        return [
            'cn' => [
                'class' => CalculateNotice::className(),
                'callback' => function(){
                    return self::find()->status(self::STATUS_NEW)->count();
                }
            ]
        ];
    }

    public function mailAdmin()
    {
        $settings = Yii::$app->getModule('admin')->activeModules['orders']->settings;

        if(!$settings['mailAdminOnNewOrders']){
            return false;
        }
        return Mail::send(
            Setting::get('admin_email'),
            $settings['subjectOnNewOrders'],
            $settings['templateOnNewOrders'],
            ['orders' => $this, 'link' => Url::to(['/admin/orders/a/view', 'id' => $this->primaryKey], true)]
        );
    }

    public function sendAnswer()
    {
        $settings = Yii::$app->getModule('admin')->activeModules['orders']->settings;

        return Mail::send(
            $this->email,
            $this->answer_subject,
            $settings['answerTemplate'],
            ['orders' => $this],
            ['replyTo' => Setting::get('admin_email')]
        );
    }
}