<?php

namespace frontend\controllers;

use common\helpers\Telegram;
use frontend\helpers\Image;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Response;

class RssController extends \yii\web\Controller
{

    public function actionTest (){
        //date_default_timezone_set('Europe/London');

        if (date_default_timezone_get()) {
            echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';

            e_print(time()) ;
            e_print($date = date("Y-m-d H:i:s", time()));
            e_print(strtotime($date));
        }

        date_default_timezone_set('Europe/London');

        if (date_default_timezone_get()) {
            echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';

            e_print(time()) ;
            e_print($date = date("Y-m-d H:i:s", time()));
            e_print(strtotime($date));
        }

        date_default_timezone_set('Europe/Kiev');

        if (date_default_timezone_get()) {
            echo 'date_default_timezone_set: ' . date_default_timezone_get() . '<br />';

            e_print(time()) ;
            e_print($date = date("Y-m-d H:i:s", time()));
            e_print(strtotime($date));
        }

        if (ini_get('date.timezone')) {
            echo 'date.timezone: ' . ini_get('date.timezone');

            e_print(time()) ;
            e_print($date = date("Y-m-d H:i:s", time()));
            e_print(strtotime($date));
        }

        exit;
    }

    public function actionFeed()
    {
//        $contentItems = \Yii::$app->db->createCommand("
//                            SELECT `c`.*, `ct`.`name`, `ct`.`meta_title`, `ct`.`description`, `ct`.`short_description`,
//                                  `ct`.`meta_description`, `c`.id as id, `c`.slug as sluger
//                            FROM `content` as c
//                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
//                            WHERE `type_id` = '2' AND ct.language = 'ru-RU' AND `c`.`status` = '1' AND ct.public_status = '1'
//                            ORDER BY c.`id` ASC
//                            LIMIT 1000  ")
//        ->queryAll();

        $contentItems = \Yii::$app->db->createCommand("
                            SELECT `c`.*, `ct`.`name`, `ct`.`meta_title`, `ct`.`description`, `ct`.`short_description`, 
                                  `ct`.`meta_description`, `c`.id as id, `c`.slug as sluger
                            FROM `content` as c
                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
                            WHERE `type_id` = '2' AND ct.language = 'ru-RU' AND `c`.`status` = '1' AND ct.public_status = '1'
                            ORDER BY c.`id` DESC 
                            LIMIT 1000  ")
            ->queryAll();

        $feed = new \common\components\rssnew\Feed();
        $channel = new \common\components\rssnew\Channel();
        $channel
            ->title('IQ Decision')
            ->description('Открыть оффшор эффективно')
            ->url('https://iq-offshore.com/ru/news')
            ->feedUrl('https://iq-offshore.com/feed')
            ->language('ru-RU')
            ->copyright('Copyright 2016, Iq Decision')
            //->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
            //->lastBuildDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
            ->ttl(60)
            //->pubsubhubbub('https://example.com/feed.xml', 'https://pubsubhubbub.appspot.com') // This is optional. Specify PubSubHubbub discovery if you want.
            ->appendTo($feed);

// Blog item
//        $item = new Item();
//        $item
//            ->title('Blog Entry Title')
//            ->description('<div>Blog body</div>')
//            ->contentEncoded('<div>Blog body</div>')
//            ->url('https://blog.example.com/2012/08/21/blog-entry/')
//            ->author('john@smith.com')
//            ->creator('John Smith')
//            ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
//            ->guid('https://blog.example.com/2012/08/21/blog-entry/', true)
//            ->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
//            ->appendTo($channel);


        foreach ($contentItems as $contentItem){
            $item = new \common\components\rssnew\Item();


            $desc = $contentItem['meta_description'];

            if(empty($desc)){
                $desc = empty($contentItem['short_description']) ? $contentItem['description'] : $contentItem['short_description'] ;
            }

            $desc = strip_tags($desc);


            $desc = str_replace('&nbsp;',' ',  $desc);
            $desc = trim($desc);
            $desc = mb_substr($desc, 0, 250);

            $pos =  mb_strripos($desc, '.');
            if($pos!==false){
                $desc = mb_substr($desc, 0, $pos+1);
            }

            $title = empty($contentItem['meta_title']) ? $contentItem['name'] : $contentItem['meta_title'] ;
            $title = trim($title);
            $title = strip_tags($title);
            $title = str_replace(array('&#34', '"', "'"), '', $title);

            $item
                ->title($title)
                ->description($desc)
                //->contentEncoded($contentItem['description'])
                ->contentEncoded("<p>".Html::img(Url::base('https') . Image::thumb($contentItem['image'], 800, 200)).'</p>
                                <p>'.$desc.'</p>')
                ->url('https://iq-offshore.com/ru/news/'.$contentItem['sluger'])
                //->thumbnail(Url::base('https') . Image::thumb($contentItem['image'], 800, 200))
                //->author('author@iq-offshore.com')
                ->creator('Iq Decision')
                ->pubDate($contentItem['time'])
                ->guid('https://iq-offshore.com/ru/news/'.$contentItem['sluger'], true)
                ->appendTo($channel);
        }

        //header("Content-type: text/xml; charset=utf-8");
        //print "\xEF\xBB\xBF";
        //header("Content-type: text/xml; charset=utf-8");
        //echo $feed->render();exit;

        \Yii::$app->response->format = Response::FORMAT_XML;
        $headers = \Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        \Yii::$app->response->content = $feed->render();
    }

    public function actionXml()
    {
//        $contentItems = \Yii::$app->db->createCommand("
//                            SELECT `c`.*, `ct`.`name`, `ct`.`meta_title`, `ct`.`description`, `ct`.`short_description`,
//                                  `ct`.`meta_description`, `c`.id as id, `c`.slug as sluger
//                            FROM `content` as c
//                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
//                            WHERE `type_id` = '2' AND ct.language = 'ru-RU' AND `c`.`status` = '1' AND ct.public_status = '1'
//                            ORDER BY c.`id` ASC
//                            LIMIT 1000  ")
//        ->queryAll();

        $contentItems = \Yii::$app->db->createCommand("
                            SELECT `c`.*, `ct`.`name`, `ct`.`meta_title`, `ct`.`description`, `ct`.`short_description`, 
                                  `ct`.`meta_description`, `c`.id as id, `c`.slug as sluger
                            FROM `content` as c
                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
                            WHERE `type_id` = '2' AND ct.language = 'ru-RU' AND `c`.`status` = '1' AND ct.public_status = '1'
                            ORDER BY c.`id` ASC 
                            LIMIT 1000  ")
            ->queryAll();

        $feed = new \common\components\rss\Feed();
        $channel = new \common\components\rss\Channel();
        $channel
            ->title('IQ Decision')
            ->description('Открыть оффшор эффективно')
            ->url('https://iq-offshore.com/ru/news')
            ->feedUrl('https://iq-offshore.com/rss/xml')
            ->language('ru-RU')
            ->copyright('Copyright 2016, Iq Decision')
            //->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
            //->lastBuildDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
            ->ttl(60)
            //->pubsubhubbub('https://example.com/feed.xml', 'https://pubsubhubbub.appspot.com') // This is optional. Specify PubSubHubbub discovery if you want.
            ->appendTo($feed);

// Blog item
//        $item = new Item();
//        $item
//            ->title('Blog Entry Title')
//            ->description('<div>Blog body</div>')
//            ->contentEncoded('<div>Blog body</div>')
//            ->url('https://blog.example.com/2012/08/21/blog-entry/')
//            ->author('john@smith.com')
//            ->creator('John Smith')
//            ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
//            ->guid('https://blog.example.com/2012/08/21/blog-entry/', true)
//            ->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
//            ->appendTo($channel);


        foreach ($contentItems as $contentItem){
            $item = new \common\components\rss\Item();


            $desc = $contentItem['meta_description'];

            if(empty($desc)){
                $desc = empty($contentItem['short_description']) ? $contentItem['description'] : $contentItem['short_description'] ;
            }

            $desc = strip_tags($desc);


            $desc = str_replace('&nbsp;',' ',  $desc);
            $desc = trim($desc);
            $desc = mb_substr($desc, 0, 250);

            $pos =  mb_strripos($desc, '.');
            if($pos!==false){
                $desc = mb_substr($desc, 0, $pos+1);
            }

            $title = empty($contentItem['meta_title']) ? $contentItem['name'] : $contentItem['meta_title'] ;
            $title = trim($title);
            $title = strip_tags($title);
            $title = str_replace(array('&#34', '"', "'"), '', $title);

            $item
                ->title($title)
                ->description($desc)
                //->contentEncoded($contentItem['description'])
                ->url('https://iq-offshore.com/ru/news/'.$contentItem['sluger'])
                ->author('author@iq-offshore.com')
                ->creator('Iq Decision')
                ->pubDate($contentItem['time'])
                ->guid('https://iq-offshore.com/ru/news/'.$contentItem['sluger'], true)
                ->appendTo($channel);
        }

        //header("Content-type: text/xml; charset=utf-8");
        //print "\xEF\xBB\xBF";
        //header("Content-type: text/xml; charset=utf-8");
        //echo $feed->render();exit;

        \Yii::$app->response->format = Response::FORMAT_XML;
        $headers = \Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/xml; charset=utf-8');
        \Yii::$app->response->content = $feed->render();
    }


    public function actionTg()
    {
        $text = "<a href='https://iq-offshore.com/uploads/offers/text-how-to-open-an-offshore-com-4ecc0851e7.jpg'>✉</a>\n<a href='https://iq-offshore.com/ru/news/bystraa-i-nedorogaa-licenzia-na-foreks-v-2018-godu6'>Новое выгодное решение: компания в Сингапуре со счетом в 2018 году!</a>\nМы подскажем Вам,где лучше всего открыть компанию для работы с ICO, а также как получить лицензию на ICO на Багамских островах.";
        Telegram::sendMessage($text);

        ex_print($text,'$text');
        exit;
    }


}
