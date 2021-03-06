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
use frontend\modules\banks\models\Banks;
use frontend\modules\novabanks\models\Novabanks;
use frontend\modules\novaoffers\models\Novaoffers;
use frontend\modules\offers\models\Offers;
use frontend\modules\offers\models\OffersPacketsOptions;
use frontend\modules\page\models\Page;
use Sunra\PhpSimple\HtmlDomParser;


class ParserController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $db = \Yii::$app->db;
//
//        $db->createCommand("
// UPDATE `lang` SET `local` = 'en-Us' WHERE `lang`.`id` = 1;
//
//UPDATE `easyii_pages` SET `type` = 'novanews';
//UPDATE `content` SET `type` = 'novanews';
//
//UPDATE `country_assign` SET `class` = 'frontend\\modules\\novaoffers\\models\\Offers' WHERE  `class` = 'frontend\\modules\\offers\\models\\Offers' ;
//UPDATE `country_assign` SET `class` = 'frontend\\modules\\novabanks\\models\\Banks' WHERE  `class` = 'frontend\\modules\\banks\\models\\Banks' ;
//
//ALTER TABLE `content` CHANGE `page_id` `id` INT(11) NOT NULL AUTO_INCREMENT,
//CHANGE `title` `title_old` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
//CHANGE `short` `short_old` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
//CHANGE `text` `text_old` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
//
//ALTER TABLE `easyii_banks`
//CHANGE `title` `title_old` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
//CHANGE `image` `image_old` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
//CHANGE `short` `short_old` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
//CHANGE `text` `text_old` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
//CHANGE `slug` `slug_old` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
//CHANGE `pre_image` `pre_image_old` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
//CHANGE `pre_text` `pre_text_old` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
//
//ALTER TABLE `easyii_banks`
//CHANGE `to_main` `to_main_old` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
//CHANGE `time` `time_old` INT(11) NULL DEFAULT '0',
//CHANGE `views` `views_old` INT(11) NULL DEFAULT '0',
//CHANGE `rating` `rating_old` INT(11) NULL DEFAULT NULL,
//CHANGE `rating_to_main` `rating_to_main_old` INT(11) NULL DEFAULT NULL,
//CHANGE `status` `status_old` TINYINT(1) NULL DEFAULT '1';
//
//ALTER TABLE `easyii_offers`
//CHANGE `to_main` `to_main_old` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
//CHANGE `title` `title_old` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
//CHANGE `image` `image_old` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
//CHANGE `short` `short_old` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
//CHANGE `text` `text_old` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
//CHANGE `slug` `slug_old` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL,
//CHANGE `pre_image` `pre_image_old` VARCHAR(128) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
//CHANGE `pre_text` `pre_text_old` VARCHAR(1024) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
//CHANGE `time` `time_old` INT(11) NULL DEFAULT '0',
//CHANGE `views` `views_old` INT(11) NULL DEFAULT '0',
//CHANGE `status` `status_old` TINYINT(1) NULL DEFAULT '1';
//
//
//ALTER TABLE `easyii_banks` CHANGE `pre_options` `pre_options_old` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
//ALTER TABLE `easyii_offers` CHANGE `pre_options` `pre_options_old` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
//       ")->execute();
//
exit;
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
        $classItems  = 'frontend\\\modules\\\page\\\models\\\Page';
        $classChange = 'frontend\\modules\\novanews\\models\\Novanews';
        foreach ($contentItems as $contentItem){
            //ex_print($contentItem,'$contentItem');
            $contentItem['title'] = $contentItem['title'] ?: $contentItem['title_old'];
            $contentItem['text'] = $contentItem['text'] ?: $contentItem['text_old'];
            $contentItem['short']  = $contentItem['short'] ?: $contentItem['short_old'];
            $contentId = $contentItem['id'];

echo'<hr />';
e_print($contentItem['title'],'TITlE_CONTENT');
e_print($contentId,'$itemId');
e_print($contentId,'$contentId');
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
                        'name' =>               $contentItem['title']. 'En',
                        'description' =>        'En ' . $contentItem['text'],
                        'short_description' =>  'En ' . $contentItem['short'],

                        'public_status' => Content::STATUS_OFF,

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
                //e_print($seoData,'$seoData');
                $seoData = $seoData[0];
                $customer = ContentTranslation::find()->where(['content_id' => $contentId,'language'=>'ru-RU'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'];//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'];//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'];
                $customer->meta_description = $seoData['description'];
                $customer->slug = $contentItem['sluger'];
                $customer->save(false);

                $customer = ContentTranslation::find()->where(['content_id' => $contentId,'language'=>'en-Us'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'].'_EN';//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'].'_EN';//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'].'_EN';
                $customer->meta_description = $seoData['description'].'_EN';
                $customer->slug = $contentItem['sluger'].'_en';;
                $customer->save(false);
            }


            $tagsRows = TagAssign::find()->where(['class' => Page::className(), 'item_id'=> $contentId])->all();//->createCommand()->rawSql;

            if($tagsRows){
                foreach ($tagsRows as $tagsPos){
                    //e_print($tagsPos->attributes,'$tagsPos');
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
        e_print($iter,'$iterContent');

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// BANKS
///
        echo'<hr /><hr /><hr />';

        $db->createCommand("
               ALTER TABLE `content` AUTO_INCREMENT=1000;
       ")->execute();

        $banksItems = $db
            ->createCommand('SELECT `c`.*, `c`.bank_id as id, `c`.slug_old as sluger
                            FROM `easyii_banks` as c
                            LIMIT 100000  ')
            ->queryAll();

        $iter = 0;
        $classItems  = 'frontend\\\modules\\\banks\\\models\\\Banks';
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

            $contentItem['rating']  = $contentItem['rating'] ?: $contentItem['rating_old'];
            $contentItem['rating_to_main']  = $contentItem['rating_to_main'] ?: $contentItem['rating_to_main_old'];
            $contentItem['slug']  = $contentItem['slug'] ?: $contentItem['slug_old'];

            $contentItem['time'] = $contentItem['time'] ?: $contentItem['time_old'];

            $itemId = $contentItem['bank_id'];

echo'<hr />';
e_print($contentItem['title'],'TITlE_BANK');
e_print($itemId,'$itemId');

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

            $newModel->rating = $contentItem['rating'];
            $newModel->rating_to_main =  $contentItem['rating_to_main'];

            $newModel->slug = $contentItem['slug'];

            $newModel->save(false);
            $contentId = $newModel->getPrimaryKey();
e_print($contentId,'$contentId_in_bank');
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
                        'name' =>               $contentItem['title']. 'En',
                        'description' =>        'En ' . $contentItem['text'],
                        'short_description' =>  'En ' . $contentItem['short'],

                        'public_status' => Content::STATUS_OFF,

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
                              AND `seo`.item_id = '".(int)$itemId."'
                            LIMIT 1  ")
                ->queryAll();

            if(!empty($seoData)){
                //e_print($seoData,'$seoData');
                $seoData = $seoData[0];
                $customer = ContentTranslation::find()->where(['content_id' => $contentId,'language'=>'ru-RU'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'];//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'];//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'];
                $customer->meta_description = $seoData['description'];
                $customer->slug = $contentItem['sluger'];
                $customer->save(false);

                $customer = ContentTranslation::find()->where(['content_id' => $contentId,'language'=>'en-Us'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'].'_EN';//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'].'_EN';//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'].'_EN';
                $customer->meta_description = $seoData['description'].'_EN';
                $customer->slug = $contentItem['sluger'].'_en';;
                $customer->save(false);
            }

            $db->createCommand("UPDATE `easyii_banks` SET `content_id` = '".$contentId."' 
                WHERE `bank_id` = '".$itemId."';")->execute();


            $tagsRows = TagAssign::find()->where(['class' => Banks::className(), 'item_id'=> $itemId])->all();//->createCommand()->rawSql;

            if($tagsRows){
                foreach ($tagsRows as $tagsPos){
                    //e_print($tagsPos->attributes,'$tagsPos');
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
        echo'<hr /><hr /><hr />';

        $db->createCommand("
               ALTER TABLE `content` AUTO_INCREMENT=2000;
       ")->execute();

        $banksItems = $db
            ->createCommand('SELECT `c`.*, `c`.offer_id as id, `c`.slug_old as sluger
                            FROM `easyii_offers` as c
                            LIMIT 100000  ')
            ->queryAll();

        $iter = 0;
        $classItems  = 'frontend\\\modules\\\offers\\\models\\\Offers';
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

            $itemId = $contentItem['offer_id'];

echo'<hr />';
e_print($contentItem['title'],'TITlE_OFFER');
e_print($itemId,'$itemId');

            //$contentItem['rating']  = $contentItem['rating'] ?: $contentItem['rating_old'];
            //$contentItem['rating_to_main']  = $contentItem['rating_to_main'] ?: $contentItem['rating_to_main_old'];
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

            //$newModel->rating = $contentItem['rating'];
            //$newModel->rating_to_main =  $contentItem['rating_to_main'];

            $newModel->slug = $contentItem['slug'];

            $newModel->save(false);
            $contentId = $newModel->getPrimaryKey();
e_print($contentId,'$contentId_in_offer');
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
                        'name' =>               $contentItem['title']. 'En',
                        'description' =>        'En ' . $contentItem['text'],
                        'short_description' =>  'En ' . $contentItem['short'],

                        'public_status' => Content::STATUS_OFF,

                        'content_id' => $contentId,
                        'language' => 'en-US'
                    ]
                )
                ->execute();

            /////////////////////////////////////
            /// SEO
//e_print("SELECT * FROM `easyii_seotext` as seo
//                            WHERE `seo`.`class` = '".$classItems."'
//                              AND `seo`.item_id = '".(int)$itemId."'
//                            LIMIT 1  ",
//        'sql'
//);

            $seoData = $db
                ->createCommand("SELECT *
                            FROM `easyii_seotext` as seo
                            WHERE `seo`.`class` = '".$classItems."'
                              AND `seo`.item_id = '".(int)$itemId."'
                            LIMIT 1  ")
                ->queryAll();

            if(!empty($seoData)){
                //e_print($seoData,'$seoData');
                $seoData = $seoData[0];
                $customer = ContentTranslation::find()->where(['content_id' => $contentId,'language'=>'ru-RU'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'];//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'];//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'];
                $customer->meta_description = $seoData['description'];
                $customer->slug = $contentItem['sluger'];
                $customer->save(false);

                $customer = ContentTranslation::find()->where(['content_id' => $contentId,'language'=>'en-Us'])->one();//->createCommand()->rawSql;
                $customer->meta_h1 = $seoData['h1'].'_EN';//($customer['h1']) ?: $contentItem['title'];
                $customer->meta_title = $seoData['title'].'_EN';//$contentItem['title'] ?: $contentItem['title'];
                $customer->meta_keywords = $seoData['keywords'].'_EN';
                $customer->meta_description = $seoData['description'].'_EN';
                $customer->slug = $contentItem['sluger'].'_en';;
                $customer->save(false);
            }

            $db->createCommand("UPDATE `easyii_offers` SET `content_id` = '".$contentId."' 
                WHERE `offer_id` = '".$itemId."';")->execute();

            $tagsRows = TagAssign::find()->where(['class' => Offers::tableName(), 'item_id'=> $itemId])->all();//->createCommand()->rawSql;

            if($tagsRows){
                foreach ($tagsRows as $tagsPos){
                    //e_print($tagsPos->attributes,'$tagsPos');
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

        $db->createCommand("
               ALTER TABLE `content` AUTO_INCREMENT=5000;
       ")->execute();

        e_print($iter,'$iter_OFFERS');

        exit('exit');
        //return $this->render('index');
    }
}
