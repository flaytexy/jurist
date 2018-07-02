<?php
namespace frontend\controllers;

use frontend\models\Packet;
use frontend\models\Popularly;
//use frontend\modules\offers\api\Offers;
//use frontend\modules\page\api\PageObject;
//use frontend\modules\page\models\Page as PageModel;
use frontend\modules\novaoffers\api\Novaoffers;
use frontend\modules\novanews\api\NovanewsObject as PageObject;
use frontend\modules\novanews\models\Novanews as PageModel;

/**
 * Class OffersController
 * @package frontend\controllers
 */
class NovaoffersController extends General
{
    public function actionIndex($tag = null)
    {
        $type_id = \Yii::$app->request->get('type_id');
        if(empty($type_id))
            $type_id = 1;

        $offers = Novaoffers::items(['tags' => $tag, 'list' => 1, 'orderBy'=>'title', 'type_id' => (int)$type_id, 'pagination' => ['pageSize' => 1000]]);

        $markers = array();
        foreach($offers as $offer){
            $data = array();
            $cords = explode(';', $offer->coordinates);
            $data['latLng'] = [$cords[0],$cords[1]];
            $data['name'] = $offer->title;
            $data['weburl'] = 'b_' . $offer->id;

            $offsetX = isset($cords[2]) ?  $cords[2] : 0;
            $offsetY = isset($cords[3]) ?  $cords[3] : 0;
            $data['offsets'] = array($offsetX,$offsetY);
            //$data['offsets'] = [$cords[2],$cords[3]];

            $markers[] = $data;
        }

        if($type_id==2)
            $mapType = 'europe_mill';
        else
            $mapType = 'world_mill';

        Novaoffers::clear();
        $offersPerPage = Novaoffers::items(['tags' => $tag, 'list' => 1, 'orderBy'=>'title', 'type_id' => (int)$type_id, 'pagination' => ['pageSize' => 21]]);

        return $this->render('index', [
            'markers' => json_encode($markers),
            'offers' => $offers,
            'offersPerPage' => $offersPerPage,
            'offer_type' => $type_id,
            'mapType' => $mapType
        ]);
    }

    public function actionView($slug)
    {

        // Categories Left Menu
        $query = new \yii\db\Query;
        $query->select('ept.title as parent_title, ept.*, ept2.*,
                (SELECT count(p.id) as count FROM content as p
                    WHERE p.category_id = ept2.category_id) as counter
            ')
            ->from('content_categories as ept')
            ->join('RIGHT JOIN', 'content_categories as ept2', 'ept2.parent_id = ept.category_id')
            ->where("ept2.type_id = '2' and ept2.category_id != '2' ")
            ->limit(20);

        $db = \Yii::$app->db;

        $this->getView()->registerJsFile(\Yii::$app->request->BaseUrl . '/js/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

        $offers = Novaoffers::get($slug);

        $popularly  = Popularly::findOne(['class' => \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id]);
        if(empty($popularly)){ $popularly  = new Popularly; }
        //$popularly->getInherit($news, $popularly);
        $popularly->class = \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id;
        $popularly->slug = 'offers/'.$offers->slug;
        $popularly->title = $offers->title;
        $popularly->item_id = $offers->id;
        $popularly->image = $offers->image;
        $popularly->time = time();
        $popularly->save();


        $type_id = \Yii::$app->request->get('type_id');
        if(empty($type_id)){
            $type_id = \frontend\modules\novaoffers\models\Novaoffers::TYPE_ID;
        }


        $offersList = Novaoffers::items(['list' => 1, 'type_id' => (int)$type_id]);

        // News
        $topNews = $this->getTopNews();
        // Banks
        $topBanks = $this->getTopBanks();
        // Offers
        $topOffers = $this->getTopOffers();

        return $this->render('view', [
            'offers' => $offers,
            'offersList' => $offersList,

            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews
        ]);
    }
}
