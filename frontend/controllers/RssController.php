<?php

namespace frontend\controllers;

use common\components\rss\Channel;
use common\components\rss\Feed;
use common\components\rss\Item;
use yii\web\Response;

class RssController extends \yii\web\Controller
{

    public function actionXml()
    {
        $contentItems = \Yii::$app->db->createCommand("SELECT `c`.*, `ct`.`name`, `ct`.`description`, `c`.id as id, `c`.slug as sluger
                            FROM `content` as c
                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
                            WHERE `type_id` = '2' AND ct.language = 'ru-RU' AND `c`.`status` = '1'
                            ORDER BY c.`id` DESC 
                            LIMIT 1000  ")
        ->queryAll();

        $feed = new Feed();
        $channel = new Channel();
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
            $item = new Item();

            $desc = empty($contentItem['short_description']) ? $contentItem['description'] : $contentItem['short_description'] ;
            $desc = str_replace('&nbsp;',' ',  $desc);
            $desc = trim($desc);
            $desc = mb_substr(strip_tags($desc), 0, 250);
            $pos =  mb_strripos($desc, '.');
            $desc = mb_substr($desc, 0, $pos+1);
            $title = $contentItem['name'];
            $title = trim($title);

            $item
                ->title($title)
                ->description($desc)
                ->url('http://iq-offshore.com/ru/news/'.$contentItem['sluger'])
                ->author('author@iq-offshore.com')
                ->creator('Iq Decision')
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
