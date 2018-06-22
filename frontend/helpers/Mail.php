<?php
namespace frontend\helpers;

use Yii;
use frontend\models\Setting;

class Mail
{
    public static function send($toEmail, $subject, $template = false, $data = [], $options = [])
    {
        if(!filter_var($toEmail, FILTER_VALIDATE_EMAIL) || !$subject){
            return false;
        }

        if(!$template){
            $settings = Yii::$app->getModule('admin')->activeModules['orders']->settings;
            $template = $settings['templateOnNewOrders'];
        }

        $data['subject'] = trim($subject);

        $message = Yii::$app->mailer->compose($template, $data)
            ->setTo($toEmail)
            ->setSubject($data['subject']);

        if(filter_var(Setting::get('robot_email'), FILTER_VALIDATE_EMAIL)){
            $message->setFrom(Setting::get('robot_email'));
        }

        if(!empty($options['replyTo']) && filter_var($options['replyTo'], FILTER_VALIDATE_EMAIL)){
            $message->setReplyTo($options['replyTo']);
        }

        return $message->send();
    }

    public static function sending($subject, $body, $data = [], $options = [], $template = false){

    }
}