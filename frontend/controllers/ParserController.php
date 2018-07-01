<?php

namespace frontend\controllers;

use common\helpers\Text;
use common\models\Content;
use common\models\ContentTranslation;
use frontend\behaviors\Optionable;
use frontend\models\Option;
use frontend\models\Packet;
use frontend\models\Parse;
use frontend\models\TagAssign;
use frontend\modules\novabanks\models\Novabanks;
use frontend\modules\novaoffers\models\Novaoffers;
use frontend\modules\offers\models\Offers;
use frontend\modules\offers\models\OffersPacketsOptions;
use Sunra\PhpSimple\HtmlDomParser;


class ParserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $db = \Yii::$app->db;

        $db->createCommand("
            DELETE FROM `content` WHERE `type` ='novabanks';
            DELETE FROM `content` WHERE `type` ='novaoffers';
            TRUNCATE `content_translation`;
            DELETE FROM `easyii_tags_assign` WHERE `class` LIKE '%novanews%';
            DELETE FROM `easyii_tags_assign` WHERE `class` LIKE '%novabanks%';
            DELETE FROM `easyii_tags_assign` WHERE `class` LIKE '%novaoffers%';
       ")->execute();

        //$db->createCommand()->truncateTable('easyii_offers')->execute();

        $contentItems = $db
            ->createCommand('SELECT `c`.*, `ct`.*, `c`.id as id, `c`.slug as sluger
                            FROM `content` as c
                            LEFT JOIN `content_translation` as ct ON c.id = ct.content_id
                            LIMIT 100000  ')
            ->queryAll();


        $iter = 0;
        $classItems = 'frontend\\modules\\page\\models\\Page';
        $classChange = 'frontend\\modules\\novanews\\models\\Novanews';
        foreach ($contentItems as $contentItem){
            //ex_print($contentItem,'$contentItem');
            $contentItem['title'] = $contentItem['title'] ?: $contentItem['title_old'];
            $contentItem['text'] = $contentItem['text'] ?: $contentItem['text_old'];
            $contentItem['short']  = $contentItem['short'] ?: $contentItem['short_old'];
            $contentId = $contentItem['id'];
            $db->createCommand()
                ->insert('content_translation',
                    [
                        'content_id' => $contentId,
                        'name' => $contentItem['title'],
                        'description' => $contentItem['text'],
                        'short_description' => $contentItem['short'],
                        'public_status' => Content::STATUS_ON,
                        'language' => 'ru-RU'
                    ]
                )
                ->execute();

            $insert = $db->createCommand()
                ->insert('content_translation',
                    [
                        'name' =>               'En ' . $contentItem['title'],
                        'description' =>        'En ' . $contentItem['text'],
                        'short_description' =>  'En ' . $contentItem['short'],

                        'public_status' => Content::STATUS_ON,

                        'content_id' => $contentItem['id'],
                        'language' => 'en-US'
                    ]
                )
                ->execute();

            /////////////////////////////////////
            /// SEO
            $seoData = $db
                ->createCommand("SELECT *
                            FROM `easyii_seotext` as seo
                            WHERE `seo`.`class` = '".$classItems."'
                              AND `seo`.item_id = '".(int)$contentId."'
                            LIMIT 1  ")
                ->queryAll();

            if(!empty($seoData)){

                $seoData = $seoData[0];
                $customer = ContentTranslation::find()->where(['content_id' => $contentId,'language'=>'ru-RU'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'];//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'];//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'];
                $customer->meta_description = $seoData['description'];
                $customer->slug = $contentItem['sluger'];
                $customer->save(false);
            }


            $tagsRows = TagAssign::find()->where(['class' => $classItems, 'item_id'=> $contentId])->all();//->createCommand()->rawSql;

            if($tagsRows){
                foreach ($tagsRows as $tagsPos){
                    $tagsNewPos = new TagAssign();
                    $tagsNewPos->class = $classChange;
                    $tagsNewPos->item_id = $contentId;
                    $tagsNewPos->tag_id = $tagsPos->tag_id;
                    $tagsNewPos->save(false);
                }   //ex_print($tagsNewPos->getPrimaryKey(), '$tagsNewPos');
            }
            //ex_print('xxxxxxxxxxxxxxx');

            if($insert){
                $iter ++;
            }
            //ex_print($insert,'$insert');
        }
        e_print($iter,'$iterContent');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// BANKS
///

        $banksItems = $db
            ->createCommand('SELECT `c`.*, `c`.bank_id as id, `c`.slug_old as sluger
                            FROM `easyii_banks` as c
                            LIMIT 100000  ')
            ->queryAll();

        $iter = 0;
        $classItems = 'frontend\\modules\\banks\\models\\Banks';
        $classChange = 'frontend\\modules\\novabanks\\models\\Novabanks';
        foreach ($banksItems as $contentItem){
            //ex_print($contentItem,'$contentItem');
            $contentItem['title'] = $contentItem['title'] ?: $contentItem['title_old'];
            $contentItem['text'] = $contentItem['text'] ?: $contentItem['text_old'];
            $contentItem['short']  = $contentItem['short'] ?: $contentItem['short_old'];

            $contentItem['image'] = $contentItem['image'] ?: $contentItem['image_old'];
            $contentItem['pre_image']  = $contentItem['pre_image'] ?: $contentItem['pre_image_old'];

            $contentItem['views'] = $contentItem['views'] ?: $contentItem['views_old'];
            $contentItem['to_main']  = $contentItem['to_main'] ?: $contentItem['to_main_old'];
            $contentItem['time'] = $contentItem['time'] ?: $contentItem['time_old'];

            //$contentItem['rating']  = $contentItem['rating'] ?: $contentItem['rating_old'];
            //$contentItem['rating_to_main']  = $contentItem['rating_to_main'] ?: $contentItem['rating_to_main_old'];
            $contentItem['slug']  = $contentItem['slug'] ?: $contentItem['slug_old'];

            $contentItem['time'] = $contentItem['time'] ?: $contentItem['time_old'];

            //e_print(array($contentItem['title'],$contentItem['slug']),'_BANKS');
            $newModel = new Novabanks();
            $newModel->title_old = $contentItem['title'];
            $newModel->text_old = $contentItem['text'];
            $newModel->short_old = $contentItem['short'];

            $newModel->image = $contentItem['image'];
            $newModel->pre_image = $contentItem['pre_image'];

            $newModel->type_id = 101;
            $newModel->category_id = 20;

            $newModel->views = $contentItem['views'];
            $newModel->to_main = $contentItem['to_main'];
            $newModel->time =  $contentItem['time'];

            //$newModel->rating = $contentItem['rating'];
            //$newModel->rating_to_main =  $contentItem['rating_to_main'];

            $newModel->slug = $contentItem['slug'];

            $newModel->save(false);
            $contentId = $newModel->getPrimaryKey();

            $db->createCommand()
                ->insert('content_translation',
                    [
                        'content_id' => $contentId,
                        'name' => $contentItem['title'],
                        'description' => $contentItem['text'],
                        'short_description' => $contentItem['short'],

                        'public_status' => Content::STATUS_ON,

                        'language' => 'ru-RU'
                    ]
                )
                ->execute();

            $insert = $db->createCommand()
                ->insert('content_translation',
                    [
                        'name' =>               'En ' . $contentItem['title'],
                        'description' =>        'En ' . $contentItem['text'],
                        'short_description' =>  'En ' . $contentItem['short'],

                        'public_status' => Content::STATUS_ON,

                        'content_id' => $contentId,
                        'language' => 'en-US'
                    ]
                )
                ->execute();

            /////////////////////////////////////
            /// SEO
            $seoData = $db
                ->createCommand("SELECT *
                            FROM `easyii_seotext` as seo
                            WHERE `seo`.`class` = '".$classItems."'
                              AND `seo`.item_id = '".(int)$contentId."'
                            LIMIT 1  ")
                ->queryAll();

            if(!empty($seoData)){

                $seoData = $seoData[0];
                $customer = ContentTranslation::find()->where(['content_id' => $contentId,'language'=>'ru-RU'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'];//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'];//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'];
                $customer->meta_description = $seoData['description'];
                $customer->slug = $contentItem['sluger'];
                $customer->save(false);
            }

            $db->createCommand("UPDATE `easyii_banks` SET `content_id` = '".$contentId."' 
                WHERE `bank_id` = '".$contentItem['id']."';")->execute();


            $tagsRows = TagAssign::find()->where(['class' => $classItems, 'item_id'=> $contentId])->all();//->createCommand()->rawSql;

            if($tagsRows){
                foreach ($tagsRows as $tagsPos){
                    $tagsNewPos = new TagAssign();
                    $tagsNewPos->class = $classChange;
                    $tagsNewPos->item_id = $contentId;
                    $tagsNewPos->tag_id = $tagsPos->tag_id;
                    $tagsNewPos->save(false);
                }   //ex_print($tagsNewPos->getPrimaryKey(), '$tagsNewPos');
            }

            if($insert){
                $iter ++;
            }
            //ex_print($insert,'$insert');
        }
        e_print($iter,'$iter_BANKS');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// OFFERS
///

        $banksItems = $db
            ->createCommand('SELECT `c`.*, `c`.offer_id as id, `c`.slug_old as sluger
                            FROM `easyii_offers` as c
                            LIMIT 100000  ')
            ->queryAll();

        $iter = 0;
        $classItems = 'frontend\\modules\\offers\\models\\Offers';
        $classChange = 'frontend\\modules\\novaoffers\\models\\Novaoffers';
        foreach ($banksItems as $contentItem){
            //ex_print($contentItem,'$contentItem');
            $contentItem['title'] = $contentItem['title'] ?: $contentItem['title_old'];
            $contentItem['text'] = $contentItem['text'] ?: $contentItem['text_old'];
            $contentItem['short']  = $contentItem['short'] ?: $contentItem['short_old'];

            $contentItem['image'] = $contentItem['image'] ?: $contentItem['image_old'];
            $contentItem['pre_image']  = $contentItem['pre_image'] ?: $contentItem['pre_image_old'];

            $contentItem['views'] = $contentItem['views'] ?: $contentItem['views_old'];
            $contentItem['to_main']  = $contentItem['to_main'] ?: $contentItem['to_main_old'];
            $contentItem['time'] = $contentItem['time'] ?: $contentItem['time_old'];

            $contentItem['rating']  = $contentItem['rating'] ?: $contentItem['rating_old'];
            $contentItem['rating_to_main']  = $contentItem['rating_to_main'] ?: $contentItem['rating_to_main_old'];
            $contentItem['slug']  = $contentItem['slug'] ?: $contentItem['slug_old'];

            $contentItem['time'] = $contentItem['time'] ?: $contentItem['time_old'];
            //e_print(array($contentItem['title'],$contentItem['slug']),'_OFFERS');
            $newModel = new Novaoffers();
            $newModel->title_old = $contentItem['title'];
            $newModel->text_old = $contentItem['text'];
            $newModel->short_old = $contentItem['short'];

            $newModel->image = $contentItem['image'];
            $newModel->pre_image = $contentItem['pre_image'];

            $newModel->type_id = 201;
            $newModel->category_id = 30;

            $newModel->views = $contentItem['views'];
            $newModel->to_main = $contentItem['to_main'];
            $newModel->time =  $contentItem['time'];

            $newModel->rating = $contentItem['rating'];
            $newModel->rating_to_main =  $contentItem['rating_to_main'];

            $newModel->slug = $contentItem['slug'];

            $newModel->save(false);
            $contentId = $newModel->getPrimaryKey();

            $db->createCommand()
                ->insert('content_translation',
                    [
                        'content_id' => $contentId,
                        'name' => $contentItem['title'],
                        'description' => $contentItem['text'],
                        'short_description' => $contentItem['short'],

                        'public_status' => Content::STATUS_ON,

                        'language' => 'ru-RU'
                    ]
                )
                ->execute();

            $insert = $db->createCommand()
                ->insert('content_translation',
                    [
                        'name' =>               'En ' . $contentItem['title'],
                        'description' =>        'En ' . $contentItem['text'],
                        'short_description' =>  'En ' . $contentItem['short'],

                        'public_status' => Content::STATUS_ON,

                        'content_id' => $contentId,
                        'language' => 'en-US'
                    ]
                )
                ->execute();

            /////////////////////////////////////
            /// SEO
            $seoData = $db
                ->createCommand("SELECT *
                            FROM `easyii_seotext` as seo
                            WHERE `seo`.`class` = '".$classItems."'
                              AND `seo`.item_id = '".(int)$contentId."'
                            LIMIT 1  ")
                ->queryAll();

            if(!empty($seoData)){

                $seoData = $seoData[0];
                $customer = ContentTranslation::find()->where(['content_id' => $contentId,'language'=>'ru-RU'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'];//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'];//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'];
                $customer->meta_description = $seoData['description'];
                $customer->slug = $contentItem['sluger'];
                $customer->save(false);
            }

            $db->createCommand("UPDATE `easyii_offers` SET `content_id` = '".$contentId."' 
                WHERE `offer_id` = '".$contentItem['id']."';")->execute();

            $tagsRows = TagAssign::find()->where(['class' => $classItems, 'item_id'=> $contentId])->all();//->createCommand()->rawSql;

            if($tagsRows){
                foreach ($tagsRows as $tagsPos){
                    $tagsNewPos = new TagAssign();
                    $tagsNewPos->class = $classChange;
                    $tagsNewPos->item_id = $contentId;
                    $tagsNewPos->tag_id = $tagsPos->tag_id;
                    $tagsNewPos->save(false);
                }   //ex_print($tagsNewPos->getPrimaryKey(), '$tagsNewPos');
            }

            if($insert){
                $iter ++;
            }
            //ex_print($insert,'$insert');
        }

        e_print($iter,'$iter_OFFERS');

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
