<?php
namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\modules\sale\api\Sale;
use frontend\modules\sale\models\Sale as SaleModel;
use yii\web\NotFoundHttpException;

/**
 * Class OffersController
 * @package frontend\controllers
 */
class SaleController extends General
{
    public function actionIndex($tag = null)
    {
        $offers = Sale::items(['tags' => $tag, 'list' => 1, 'orderBy'=>'title', 'pagination' => ['pageSize' => 1000]]);

        $offersPerPage = Sale::items([
            'tags' => $tag, 'list' => 1,
            'orderBy'=>'title',
            'type_id' => (int)SaleModel::TYPE_ID,
            'pagination' => ['pageSize' => 21]
        ]);

        return $this->render('index', [
            'offersPerPage' => $offersPerPage,
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

        $offers = Sale::get($slug);
        if(!$offers){
            throw new NotFoundHttpException('Page Houston, we have a problem.');
        }

        $popularly  = Popularly::findOne(['class' => \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id]);
        if(empty($popularly)){ $popularly  = new Popularly; }
        //$popularly->getInherit($news, $popularly);
        $popularly->class = \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id;
        $popularly->slug = 'sale/'.$offers->slug;
        $popularly->title = $offers->title;
        $popularly->item_id = $offers->id;
        $popularly->image = $offers->image;
        $popularly->time = time();
        $popularly->save();

        // News
        $topNews = $this->getTopNews();
        // Offers
        $topOffers = $this->getTopOffers();

        return $this->render('view', [
            'offers' => $offers,
            'top_offers' => $topOffers,
            'top_news' => $topNews
        ]);
    }
}
