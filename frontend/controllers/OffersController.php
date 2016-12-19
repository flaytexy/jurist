<?php
namespace frontend\controllers;

use frontend\behaviors\Optionable;
use frontend\modules\offers\api\Offers;
use frontend\modules\offers\models\OffersPackets;
use yii\db\Query;

class OffersController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        $type_id = \Yii::$app->request->get('type_id');

        return $this->render('index', [
            'offers' => Offers::items(['tags' => $tag, 'type_id' => (int)$type_id, 'pagination' => ['pageSize' => 30]]),
            'offer_type' => $type_id
        ]);
    }

    public function actionView($slug)
    {
        $db = \Yii::$app->db;

        $this->getView()->registerJsFile(\Yii::$app->request->BaseUrl . '/js/script3.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

        $offers = Offers::get($slug);

        $offer_id = $offers->model->offer_id;
        $packets = OffersPackets::find()->where(['offer_id' => $offer_id])->all();
        $packets = Optionable::find()->where(['offer_id' => $offer_id])->all();

        foreach ($packets as $packet) {
            $packet_id = $packet->packet_id;

            $findOptions = $db
                ->createCommand('SELECT *
                                      FROM `easyii_offers_packets` as p
                                      INNER JOIN `easyii_offers_packets_options` as po ON po.packet_id= p.packet_id
                                      INNER JOIN `easyii_offers_options` as o ON po.option_id = o.option_id
                                      WHERE p.packet_id = :packet_id
                                      ORDER BY po.option_id ASC, p.packet_id ASC')
                ->bindValues([
                    ':packet_id' => $packet_id
                ])
                ->queryAll();

            $packetOptions = [];
            foreach($findOptions as $packetOption){

                $packetOptions[$packetOption['option_id']] = $packetOption;
            }

            $packet->options = $packetOptions;
        }


        $options = $db
            ->createCommand('SELECT o.*,  COUNT(p.packet_id) as countPacket
                                      FROM `easyii_offers_packets` as p
                                      INNER JOIN `easyii_offers_packets_options` as po ON po.packet_id= p.packet_id
                                      INNER JOIN `easyii_offers_options` as o ON po.option_id = o.option_id
                                      WHERE p.offer_id = :offer_id
                                        GROUP BY po.option_id
                                      ORDER BY po.option_id ASC, countPacket ASC

                                      ')
            ->bindValues([
                ':offer_id' => $offer_id
            ])
            ->queryAll();


        if (!$offers) {
            throw new \yii\web\NotFoundHttpException('Offers not found.');
        }

        foreach($options as $key => $option){
            foreach($packets as $key2 => $packet){
                $options[$key]['child'][$key2] = 0;

                if(isset($packet['options'][$option['option_id']])){
                    $options[$key]['child'][$key2] = 1;
                }
            }
        }

        return $this->render('view', [
            'offers' => $offers,
            'packets' => $packets,
            'options' => $options
        ]);
    }
}
