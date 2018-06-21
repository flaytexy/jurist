<?php

namespace frontend\controllers;

use common\helpers\Text;
use common\models\Content;
use common\models\ContentTranslation;
use frontend\behaviors\Optionable;
use frontend\models\Option;
use frontend\models\Packet;
use frontend\models\Parse;
use frontend\modules\offers\models\Offers;
use frontend\modules\offers\models\OffersPacketsOptions;
use Sunra\PhpSimple\HtmlDomParser;


class ParserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $db = \Yii::$app->db;
        //$db->createCommand()->truncateTable('easyii_offers')->execute();

//        $row = $db->createCommand()
//            ->insert('easyii_options_assign',
//                [
//                    'item_id' => $offer_id,
//                    'option_id' => $property_id,
//                    'class' => 'frontend\modules\offers\models\Offers'
//
//                ]
//            )
//            ->execute();

//        $row = $db
//            ->createCommand('SELECT *
//                            FROM `content`
//                            WHERE packet_id  = :packet_id AND option_id = :option_id ')
//            ->bindValues([
//                ':packet_id' => $packet_id,
//                ':option_id' => $option_id
//            ])
//            ->queryOne();
        $contentItems = $db
            ->createCommand('SELECT `c`.*, `ct`.*, `c`.id as id, `c`.slug as sluger
                            FROM `content` as c
                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
                            LIMIT 100000  ')
            ->queryAll();


        $iter = 0;
        foreach ($contentItems as $contentItem){
            //ex_print($contentItem,'$contentItem');
            $db->createCommand()
                ->insert('content_translation',
                    [
                        'content_id' => $contentItem['id'],
                        'name' => $contentItem['title'],
                        'description' => $contentItem['text'],
                        'short_description' => $contentItem['short'],
                        'language' => 'ru-RU'
                    ]
                )
                ->execute();

            $insert = $db->createCommand()
                ->insert('content_translation',
                    [
                        'name' => 'EN_EN_EN',
                        'description' =>  '',
                        'short_description' =>  '',

                        'public_status' => Content::STATUS_OFF,

                        'content_id' => $contentItem['id'],
                        'language' => 'en-US'
                    ]
                )
                ->execute();

            ///////////////////////////////////////////////////////////////////////////////////////////////////
            /// SEO
            $seoData = $db
                ->createCommand("SELECT *
                            FROM `easyii_seotext` as seo
                            WHERE `seo`.`class` = 'frontend\\\modules\\\page\\\models\\\Page'
                              AND `seo`.item_id = '".(int)$contentItem['id']."'
                            LIMIT 1  ")
                ->queryAll();

            if(!empty($seoData)){

                $seoData = $seoData[0];
                $customer = ContentTranslation::find()->where(['content_id' => $contentItem['id'],'language'=>'ru-RU'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'];//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'];//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'];
                $customer->meta_description = $seoData['description'];
                $customer->slug = $contentItem['sluger'];
                $customer->save(false);
            }

            if($insert){
                $iter ++;
            }
            //ex_print($insert,'$insert');
        }

        ex_print($iter,'$iter');


        exit('exit');
        //return $this->render('index');
    }

    public function actionDao()
    {
        $db = \Yii::$app->db;
        //$db->createCommand()->truncateTable('easyii_offers')->execute();


        exit;
        //return $this->render('index');
    }

}
