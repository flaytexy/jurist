<?php

namespace frontend\controllers;

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

    public function actionXml()
    {
//        $contentItems = \Yii::$app->db->createCommand("
//                            SELECT `c`.*, `ct`.`name`, `ct`.`meta_title`, `ct`.`description`, `ct`.`short_description`,
//                                  `ct`.`meta_description`, `c`.id as id, `c`.slug as sluger
//                            FROM `content` as c
//                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
//                            WHERE `type_id` = '2' AND ct.language = 'ru-RU' AND `c`.`status` = '1' AND ct.public_status
//                            ORDER BY c.`id` ASC
//                            LIMIT 1000  ")
//        ->queryAll();

        $contentItems = \Yii::$app->db->createCommand("
                            SELECT `c`.*, `ct`.`name`, `ct`.`meta_title`, `ct`.`description`, `ct`.`short_description`, 
                                  `ct`.`meta_description`, `c`.id as id, `c`.slug as sluger
                            FROM `content` as c
                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
                            WHERE `type_id` = '2' AND ct.language = 'ru-RU' AND `c`.`status` = '1'
                            ORDER BY c.`id` ASC 
                            LIMIT 1000  ")
            ->queryAll();

        $feed = new \common\components\rssnew\Feed();
        $channel = new \common\components\rssnew\Channel();
        $channel
            ->title('IQ Decision')
            ->description('Открыть оффшор эффективно')
            ->url('http://iq-offshore.com/ru/news')
            ->feedUrl('http://iq-offshore.com/rss/xml')
            ->language('en-US')
            ->copyright('Copyright 2016, Iq Decision')
            //->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
            //->lastBuildDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
            ->ttl(60)
            //->pubsubhubbub('http://example.com/feed.xml', 'http://pubsubhubbub.appspot.com') // This is optional. Specify PubSubHubbub discovery if you want.
            ->appendTo($feed);

// Blog item
//        $item = new Item();
//        $item
//            ->title('Blog Entry Title')
//            ->description('<div>Blog body</div>')
//            ->contentEncoded('<div>Blog body</div>')
//            ->url('http://blog.example.com/2012/08/21/blog-entry/')
//            ->author('john@smith.com')
//            ->creator('John Smith')
//            ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
//            ->guid('http://blog.example.com/2012/08/21/blog-entry/', true)
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

            $item
                ->title($title)
                ->description($desc)
                ->url('http://iq-offshore.com/ru/news/'.$contentItem['sluger'])
                ->author('author@iq-offshore.com')
                ->creator('Iq Decision')
                ->pubDate($contentItem['time'])
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

    public function actionFeed()
    {
//        $contentItems = \Yii::$app->db->createCommand("
//                            SELECT `c`.*, `ct`.`name`, `ct`.`meta_title`, `ct`.`description`, `ct`.`short_description`,
//                                  `ct`.`meta_description`, `c`.id as id, `c`.slug as sluger
//                            FROM `content` as c
//                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
//                            WHERE `type_id` = '2' AND ct.language = 'ru-RU' AND `c`.`status` = '1' AND ct.public_status
//                            ORDER BY c.`id` ASC
//                            LIMIT 1000  ")
//        ->queryAll();

        $contentItems = \Yii::$app->db->createCommand("
                            SELECT `c`.*, `ct`.`name`, `ct`.`meta_title`, `ct`.`description`, `ct`.`short_description`, 
                                  `ct`.`meta_description`, `c`.id as id, `c`.slug as sluger
                            FROM `content` as c
                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
                            WHERE `type_id` = '2' AND ct.language = 'ru-RU' AND `c`.`status` = '1'
                            ORDER BY c.`id` ASC 
                            LIMIT 1000  ")
            ->queryAll();

        $feed = new \common\components\rssnew\Feed();
        $channel = new \common\components\rssnew\Channel();
        $channel
            ->title('IQ Decision')
            ->description('Открыть оффшор эффективно')
            ->url('http://iq-offshore.com/ru/news')
            ->feedUrl('http://iq-offshore.com/rss/xml')
            ->language('en-US')
            ->copyright('Copyright 2016, Iq Decision')
            //->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
            //->lastBuildDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
            ->ttl(60)
            //->pubsubhubbub('http://example.com/feed.xml', 'http://pubsubhubbub.appspot.com') // This is optional. Specify PubSubHubbub discovery if you want.
            ->appendTo($feed);

// Blog item
//        $item = new Item();
//        $item
//            ->title('Blog Entry Title')
//            ->description('<div>Blog body</div>')
//            ->contentEncoded('<div>Blog body</div>')
//            ->url('http://blog.example.com/2012/08/21/blog-entry/')
//            ->author('john@smith.com')
//            ->creator('John Smith')
//            ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
//            ->guid('http://blog.example.com/2012/08/21/blog-entry/', true)
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

            $item
                ->title($title)
                ->description($desc)
                ->url('http://iq-offshore.com/ru/news/'.$contentItem['sluger'])
                ->author('author@iq-offshore.com')
                ->creator('Iq Decision')
                ->pubDate($contentItem['time'])
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
}
