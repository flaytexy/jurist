<?php

namespace frontend\modules\Licenses\controllers\frontend;

use Yii;
use yii\data\Pagination;
use frontend\controllers\General;

use frontend\models\Popularly;
use frontend\modules\Licenses\api\Licenses;
use frontend\modules\Licenses\models\Licenses as LicensesModel;

class DefaultController extends General
{
//    public function beforeAction($action)
//    {
//        $this->view->title = 'Компании – ' . Yii::$app->params['sitePrefix'];
//
//        return parent::beforeAction($action);
//    }

    public function actionIndex($tag = null)
    {
        $offers = Licenses::items(['tags' => $tag, 'list' => 1, 'orderBy'=>'title', 'pagination' => ['pageSize' => 1000]]);

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

        Licenses::clear();

        $offersPerPage = Licenses::items([
            'tags' => $tag, 'list' => 1,
            'orderBy'=>'title',
            'type_id' => (int)LicensesModel::TYPE_ID,
            'pagination' => ['pageSize' => 21]
        ]);

        return $this->render('index', [
            'markers' => json_encode($markers),
            'offers' => $offers,
            'offersPerPage' => $offersPerPage,
            'mapType' => 'world_mill'
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

        $this->getView()->registerJsFile(\Yii::$app->request->BaseUrl . '/js/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

        $offers = Licenses::get($slug);

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

        $offersList = Licenses::items(['list' => 1, 'type_id' => (int) LicensesModel::TYPE_ID]);

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
