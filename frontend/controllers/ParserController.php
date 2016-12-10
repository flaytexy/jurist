<?php

namespace frontend\controllers;

use common\helpers\Text;
use frontend\models\Parse;
use frontend\modules\offers\models\Offers;
use frontend\modules\offers\models\OffersPackets;
use frontend\modules\offers\models\OffersPacketsOptions;
use frontend\modules\offers\models\OffersProperties;
use Sunra\PhpSimple\HtmlDomParser;


class ParserController extends \yii\web\Controller
{
    public function actionIndex()
    {

        $db = \Yii::$app->db;
        $db->createCommand()->truncateTable('easyii_offers')->execute();
        $db->createCommand()->truncateTable('easyii_offers_options')->execute();
        $db->createCommand()->truncateTable('easyii_offers_packets')->execute();
        $db->createCommand()->truncateTable('easyii_offers_packets_options')->execute();
        $db->createCommand()->truncateTable('easyii_offers_properties')->execute();
        $db->createCommand()->truncateTable('easyii_offers_properties_relations')->execute();

        $url = 'https://it-offshore.com/offshornyie-predlozheniya.html';
        //$current = file_get_contents($url);
        //file_put_contents(\Yii::getAlias('@webroot').'\1.html', $current);

        $dom = HtmlDomParser::file_get_html(\Yii::getAlias('@webroot') . '\1.html');


        $myHref = $dom->find(".//*[@id='offshore-map'] a.offshores_map_marker");
        foreach ($myHref as $a) {
            $aAttr = $a->getAllAttributes();
            $style = $aAttr['style'];
            //e_print($style,'$style');

            preg_match_all( '/(?:[0-9]{1,4})/', $style, $arr);
            //e_print($arr,'$arr');
            $pos = '';
            if(isset($arr[0][0])){
                $pos = trim($arr[0][0]).';'.trim($arr[0][1]);
            }
            e_print($pos,'$pos');
            $idBlockOpen = $aAttr['data-open-block'];
            e_print($idBlockOpen);

            $block = $dom->find(".//*[@id='offshore-windows'] div.window[@data-place='" . $a = str_replace('b', 'id', $idBlockOpen) . "']", 0);

            $blockDetail = false;
            if($idBlockOpen){
                $blockDetail = $dom->find(".//*[@id='" . $idBlockOpen . "']", 0);
            }

            echo $block . "<hr />";
            //$le = $block->find('div.grid',0);
            $title = $block->find('div.top span.name', 0)->text();
            $title = trim($title);




            $descBlock = '';
            $imagePath = '';
            if ($blockDetail) {
                $descBlock = trim($blockDetail->find('div.grid', 0)->innertext);

                $img = $block->find('div.map img', 0)->src;
                if (!empty($img)) {
                    $imgUpload = 'https://it-offshore.com/' . $img;
                    $imagePath = '/uploads/offers/' . Text::transliterate($title) . '.png';
                    file_put_contents(\Yii::getAlias('@webroot') . $imagePath, file_get_contents($imgUpload));
                }
            }

            e_print($title, '$title');
            e_print($imagePath, '$imagePath');

            $offer = Offers::find()
                ->where(['title' => $title])
                ->one();

            if (empty($offer)) {
                $offer = new Parse();
                $offer->type_id = '1';
                $offer->title = $title;
                $offer->text = $descBlock;
                $offer->image = $imagePath;
                $offer->pre_image = $imagePath;
                $offer->pos = $pos;
                //$offer->pre_options = $pre_options;
                //$offer->pre_text = $imagePath;
                $re = $offer->save();
                e_print($re, '$reSave');
            }

            $offer_id = $offer->offer_id;

            if ($offer_id) {

                //////////////////////////////////
                // Properties
                $uls = $block->find('ul.list li');

                if (!empty($uls)) {
                    foreach ($uls as $listItem) {
                        $listTitle = $listItem->text();
                        $listTitle = trim($listTitle);
                        if ($listTitle) {
                            e_print($listTitle, 'listTitle');

                            $offersProperties = OffersProperties::find()
                                ->where(['title' => $listTitle])
                                ->one();

                            if (empty($offersProperties)) {
                                $offersProperties = new OffersProperties();
                                $offersProperties->title = $listTitle;
                                $offersProperties->save();
                            }

                            $property_id = $offersProperties->property_id;

                            if ($property_id) {
                                e_print($property_id, '$property_id');
                                $row = $db
                                    ->createCommand('SELECT *
                                      FROM easyii_offers_properties_relations
                                      WHERE property_id  = :property_id AND offer_id = :offer_id ')
                                    ->bindValues([
                                        ':property_id' => $property_id,
                                        ':offer_id' => $offer_id
                                    ])
                                    ->queryOne();

                                if (empty($row)) {
                                    $row = $db->createCommand()
                                        ->insert('easyii_offers_properties_relations', ['offer_id' => $offer_id, 'property_id' => $property_id])
                                        ->execute();
                                }

                                e_print($row, '$row');
                            }
                        }
                    }

                }

                //////////////////////////////////
                // Packets

                $packets = $blockDetail->find('section.prices div.prices-item');


                if ($packets) {
                    $pack = [];
                    foreach ($packets as $packet) {
                        $pack['title'] = trim($packet->find('div.name', 0)->text());
                        $pack['price'] = trim($packet->find('div.price', 0)->text());


                        $packObj = OffersPackets::find()
                            ->where(['title' => $title])
                            ->one();

                        if (empty($packObj)) {
                            $packObj = new OffersPackets();
                            //$packObj->load($pack);
                            $packObj->title = $pack['title'];
                            $packObj->price = $pack['price'];
                            $packObj->offer_id = $offer_id;
                            $re = $packObj->save();
                            e_print($re, '$reSaveOffersPackets');
                        }

                        $packet_id = $packObj->packet_id;
                        e_print($packet_id, '$packet_id');

                        $uls = $block->find('div.description li');

                        if (!empty($uls)) {
                            foreach ($uls as $listItem) {
                                $listTitle = $listItem->text();
                                $listTitle = trim($listTitle);
                                if ($listTitle) {
                                    e_print($listTitle, 'listTitle_OffersPacketsOptions');

                                    $offersProperties = OffersPacketsOptions::find()
                                        ->where(['title' => $listTitle])
                                        ->one();

                                    if (empty($offersProperties)) {
                                        $offersProperties = new OffersPacketsOptions();
                                        $offersProperties->title = $listTitle;
                                        $offersProperties->save();
                                    }

                                    $option_id = $offersProperties->option_id;

                                    if ($option_id) {

                                        e_print($option_id, '$option_id');
                                        $row = $db
                                            ->createCommand('SELECT *
                                              FROM easyii_offers_packets_options
                                              WHERE packet_id  = :packet_id AND option_id = :option_id ')
                                            ->bindValues([
                                                ':packet_id' => $packet_id,
                                                ':option_id' => $option_id
                                            ])
                                            ->queryOne();

                                        if (empty($row)) {
                                            $row = $db->createCommand()
                                                ->insert('easyii_offers_packets_options', ['packet_id' => $packet_id, 'option_id' => $option_id])
                                                ->execute();
                                        }

                                        e_print($row, '$row');
                                    }
                                }
                            }

                        }
                    }
                }
            }

            e_print($offer->offer_id, 'offer_id');

            echo $blockDetail . "<hr />";


        }

        unset($block);
        unset($dom);


        exit;
        //return $this->render('index');
    }


}
