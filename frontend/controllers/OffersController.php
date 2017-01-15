<?php
namespace frontend\controllers;
use frontend\models\Packet;
use frontend\modules\offers\api\Offers;
//use yii\db\Query;

class OffersController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        $type_id = \Yii::$app->request->get('type_id');

        $offers = Offers::items(['tags' => $tag, 'type_id' => (int)$type_id, 'pagination' => ['pageSize' => 300]]);

        $markers = array();
        foreach($offers as $offer){
            $data = array();
            $cords = explode(';', $offer->model->coordinates);
            $data['latLng'] = [$cords[0],$cords[1]];
            $data['name'] = $offer->title;
            $data['weburl'] = 'b_' . $offer->model->offer_id;
            $data['offsets'] = [$cords[2],$cords[3]];
            $markers[] = $data;
        }

        if($type_id==2)
            $mapType = 'europe_mill';
        else
            $mapType = 'world_mill';

        return $this->render('index', [
            'markers' => json_encode($markers),
            'offers' => $offers,
            'offer_type' => $type_id,
            'mapType' => $mapType
        ]);
    }

    public function actionView($slug)
    {
        $db = \Yii::$app->db;

        $this->getView()->registerJsFile(\Yii::$app->request->BaseUrl . '/js/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

        $offers = Offers::get($slug);

        $offer_id = $offers->model->offer_id;
        $packets = Packet::find()
            ->where([
                'item_id' => $offer_id,
                'class' => \frontend\modules\offers\models\Offers::className()
            ])->all();

        foreach ($packets as $packet) {
            $packet_id = $packet->packet_id;

            $findOptions = $db
                ->createCommand('SELECT *
                                      FROM `easyii_packets` as p
                                      INNER JOIN `easyii_offers_packets_options` as po ON po.packet_id= p.packet_id
                                      INNER JOIN `easyii_offers_options` as o ON po.option_id = o.option_id
                                      WHERE p.packet_id = :packet_id
                                      ORDER BY po.option_id ASC, p.packet_id ASC')
                ->bindValues([
                    ':packet_id' => $packet_id
                ])
                ->queryAll();

            $packetOptions = [];
            foreach ($findOptions as $packetOption) {

                $packetOptions[$packetOption['option_id']] = $packetOption;
            }

            $packet->options = $packetOptions;
        }

        $options = $db
            ->createCommand('SELECT o.*, po.packet_id as packetId, COUNT(p.packet_id) as countPacket
                                      FROM `easyii_packets` as p
                                      INNER JOIN `easyii_offers_packets_options` as po ON po.packet_id = p.packet_id
                                      INNER JOIN `easyii_offers_options` as o ON po.option_id = o.option_id
                                      WHERE p.item_id = :item_id AND p.class = :className
                                        GROUP BY po.option_id
                                      ORDER BY po.option_id ASC, countPacket ASC

                                      ')
            ->bindValues([
                ':item_id' => $offer_id,
                ':className' => \frontend\modules\offers\models\Offers::className()

            ])
            ->queryAll();


        if (!$offers) {
            throw new \yii\web\NotFoundHttpException('Offers not found.');
        }

        foreach ($options as $key => $option) {
            foreach ($packets as $key2 => $packet) {
                $options[$key]['child'][$key2] = 0;

                if (isset($packet['options'][$option['option_id']])) {
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
