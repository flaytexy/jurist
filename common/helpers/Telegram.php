<?php

namespace common\helpers;


class Telegram
{

    //iq_offshore_bot
    public static $token = '677147968:AAGgDimjMv_DgrQjErBpR7hxAN677claA6Y';
    public static $chanel = -1001328503194;

    //etrex_tst_iq_bot
    //public static $token = '665566791:AAEz0jjsThdgFxofEP_PFhA4Us9i4F5Xo6I';
    //public static $chanel = -1001292006183;

    //635915590:AAHPk1FQtOaQmevyct8vzYYPSIQtpkj27Xw //etrex_txt_iqs_bot
    //public static $token = '635915590:AAHPk1FQtOaQmevyct8vzYYPSIQtpkj27Xw';
    //public static $chanel = -1001292006183;

    public static function sendMessage($text){
        //https://api.telegram.org/bot677147968:AAGgDimjMv_DgrQjErBpR7hxAN677claA6Y/getUpdates

        //$BotToken = '665566791:AAEz0jjsThdgFxofEP_PFhA4Us9i4F5Xo6I';
        //$BotToken = '677147968:AAGgDimjMv_DgrQjErBpR7hxAN677claA6Y';

        //$chat_id = -1001292006183;
        //$chat_id = -1001328503194;

        $WebsiteURL = "https://api.telegram.org/bot".self::$token;

        $post = $WebsiteURL."/sendMessage?chat_id=".self::$chanel."&text=".urlencode($text)."&parse_mode=html";

        $Update = file_get_contents($post);
        //ex_print($Update, 'xxx');

        return $Update;
    }
}
