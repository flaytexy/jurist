<?php
namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\modules\news\api\NewsObject;
use frontend\modules\news\models\News;
use frontend\modules\news\NewsModule;
use frontend\modules\offers\api\Offers;
use frontend\modules\page\api\Page;
use frontend\modules\page\api\PageObject;
use frontend\modules\page\models\Page as PageModel;

class PagesController extends \yii\web\Controller
{
    public function actionIndex($type = null, $tag = null, $name = null, $page = null)
    {
        $categoriesTypes = [
            'licenses' => 3,
            'fonds' => 4,
            'processing' => 5,
            'offshore' => 6,
            'sale' => 7
        ];

        if(empty($type) && !empty($name)){
            $type = $categoriesTypes[$name];
        }

        $pages = Page::items([
            'tags' => $tag,
            'where' => ['type_id' => (int)$type, 'status' => 1],
            'pagination' => ['pageSize' => 15]
        ]);

        return $this->render('index',[
            'pages' => $pages,
            'typeTitle' => $name
        ]);
    }

    public function actionView($slug, $name = null)
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
                (SELECT count(p.id) as count FROM content as p
                    WHERE p.category_id = ept2.category_id) as counter
            ')
            ->from('content_categories as ept')
            ->join('RIGHT JOIN', 'content_categories as ept2', 'ept2.parent_id = ept.category_id')
            ->where("ept2.type_id = '2' and ept2.category_id != '2' ")
            ->limit(20);


        $parts = explode('/', \Yii::$app->request->getUrl());

        $pages = Page::get($slug);
        if(!$pages){
            throw new \yii\web\NotFoundHttpException('Page Houston, we have a problem.');
        }

        $prefixSlug = strlen($parts[1])<3 ? $parts[2] : $parts[1];

        $popularly  = Popularly::findOne(['class' => \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id.$prefixSlug]);
        if(empty($popularly)){ $popularly  = new Popularly; }
        //$popularly->getInherit($news, $popularly);


        $popularly->class = \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id.'\\'.$prefixSlug;
        $popularly->slug = $prefixSlug.'/'.$pages->slug;

        $popularly->title = $pages->title;
        $popularly->item_id = $pages->model->id;
        $popularly->image = $pages->image;
        $popularly->time = time();
        $popularly->save();

        return $this->render('view', [
            'page' => $pages,
            'parentPage' => \frontend\modules\page\models\Page::findOne(['slug'=>'page-'.$prefixSlug]),
            'pageParentUrl' => $prefixSlug,

            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews
        ]);
    }
}
