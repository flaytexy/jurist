<?php
namespace frontend\controllers;
use frontend\models\Packet;
use frontend\models\Popularly;
use frontend\modules\news\api\NewsObject;
use frontend\modules\news\models\News;
use frontend\modules\news\NewsModule;
use frontend\modules\offers\api\Offers;
use frontend\modules\page\api\Page;
use frontend\modules\page\api\PageObject;
use frontend\modules\page\models\Page as PageModel;
//use yii\db\Query;

class OffersController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        $type_id = \Yii::$app->request->get('type_id');
        if(empty($type_id))
            $type_id = 1;

        $offers = Offers::items(['tags' => $tag, 'list' => 1, 'orderBy'=>'title', 'type_id' => (int)$type_id, 'pagination' => ['pageSize' => 300]]);

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
        $topNews = [];
        foreach(PageModel::find()
                    ->andWhere(['type_id' => '2'])
                    ->status(PageModel::STATUS_ON)
                    ->sortDate()->limit(4)->all() as $item){
            $obj = new PageObject($item);
            $topNews[] = $obj;
        }

        // Banks
        //$topOffers = Offers::find(2)->asArray()->all();
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_banks as ba')
            ->where("ba.status = '1' ")
            ->orderBy(['views'=> SORT_DESC])
            ->limit(3);
        $command = $query->createCommand();
        $topBanks = $command->queryAll();

        // Offers
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_offers as of')
            ->where("of.status = '1' ")
            ->orderBy(['views'=> SORT_DESC])
            ->limit(4);
        $command = $query->createCommand();
        $topOffers = $command->queryAll();

        // Categories Left Menu
        $query = new \yii\db\Query;
        $query->select('ept.title as parent_title, ept.*, ept2.*,
                (SELECT count(p.page_id) as count FROM easyii_pages as p
                    WHERE p.category_id = ept2.category_id) as counter
            ')
            ->from('easyii_pages_categories as ept')
            ->join('RIGHT JOIN', 'easyii_pages_categories as ept2', 'ept2.parent_id = ept.category_id')
            ->where("ept2.type_id = '2' and ept2.category_id != '2' ")
            ->limit(20);

        $db = \Yii::$app->db;

        $this->getView()->registerJsFile(\Yii::$app->request->BaseUrl . '/js/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

        $offers = Offers::get($slug);

        $offer_id = $offers->model->offer_id;
        $packets = Packet::find()
            ->where([
                'item_id' => $offer_id,
                'class' => \frontend\modules\offers\models\Offers::className()
            ])->all();
//adssad
        foreach ($packets as $packet) {
            $packet_id = $packet->packet_id;
            $packet->price = number_format( $packet->price, 0, '.', '');

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
            throw new \yii\web\NotFoundHttpException('Offers Houston, we have a problem.');
        }

        foreach ($options as $key => $option) {
            foreach ($packets as $key2 => $packet) {
                $options[$key]['child'][$key2] = 0;

                if (isset($packet['options'][$option['option_id']])) {
                    $options[$key]['child'][$key2] = 1;
                }
            }
        }


        $popularly  = Popularly::findOne(['class' => \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id]);
        if(empty($popularly)){ $popularly  = new Popularly; }
        //$popularly->getInherit($news, $popularly);
        $popularly->class = \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id;
        $popularly->slug = 'offers/'.$offers->slug;
        $popularly->title = $offers->title;
        $popularly->item_id = $offers->model->offer_id;
        $popularly->image = $offers->image;
        $popularly->time = time();
        $popularly->save();


        $type_id = \Yii::$app->request->get('type_id');
        if(empty($type_id))
            $type_id = 1;

        $offersList = Offers::items(['list' => 1, 'type_id' => (int)$type_id]);

        return $this->render('view', [
            'offers' => $offers,
            'packets' => $packets,
            'options' => $options,
            'offersList' => $offersList,
            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews
        ]);
    }
}
