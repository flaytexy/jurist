<?php
namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\modules\offers\models\Offers;
use frontend\modules\page\api\Page;
use frontend\modules\page\api\PageObject;
use frontend\modules\page\models\Page as PageModel;

class NewsController extends \yii\web\Controller
{
    public function actionIndex($tag = null, $type = null, $slug = null)
    {
        if($slug){
            $query = new \yii\db\Query;
            $query->select('category_id')
                ->from('easyii_pages_categories as ept')
                ->where("ept.slug = '".$slug."'")
                ->limit(1);
            $command = $query->createCommand();
            $category = $command->queryOne();
            $category_id = $category['category_id'];

            $news = Page::items([
                'where' => ['category_id' => $category_id, 'status' => 1],
                'pagination' => ['pageSize' => 12]
            ]);

        } else {
            $news = Page::items([
                'where' => ['type_id' => 2, 'status' => 1],
                'tags' => $tag,
                'pagination' => ['pageSize' => 12]
            ]);
        }

        // Banks
        //$topOffers = Offers::find(2)->asArray()->all();
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_banks as ba')
            ->where("ba.status = '1' ")
            ->orderBy(['views'=> SORT_DESC])
            ->limit(2);
        $command = $query->createCommand();
        $topBanks = $command->queryAll();

        // Offers
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_offers as of')
            ->where("of.status = '1' ")
            ->orderBy(['views'=> SORT_DESC])
            ->limit(3);
        $command = $query->createCommand();
        $topOffers = $command->queryAll();

        // Tags
        $query = new \yii\db\Query;
        $query->select('tg.name, p.page_id, tga.tag_id')
            ->from('easyii_tags_assign as tga')
            ->join('LEFT JOIN', 'easyii_tags as tg', 'tga.tag_id = tg.tag_id')
            ->join('LEFT JOIN', 'easyii_pages as p', 'p.page_id = tga.item_id')
            ->where("tga.class LIKE '%\\Page' AND p.type_id='2' ")
            //->orderBy(['views'=> SORT_DESC])
            ->limit(5);
        $command = $query->createCommand();
        $topTags = $command->queryAll();

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
        $command = $query->createCommand();
        $categoriesTops = $command->queryAll();

        $topNews = [];
        foreach(PageModel::find()
                    ->andWhere(['type_id' => '2'])
                    ->status(PageModel::STATUS_ON)
                    ->sortDate()->limit(5)->all() as $item){
            $obj = new PageObject($item);
            $topNews[] = $obj;
        }

        return $this->render('index', [
            'news' => $news,
            'categories_tops' => $categoriesTops,
            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews,
            'top_tags' => $topTags,
        ]);
    }

    public function actionView($slug)
    {



        // News
/*        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_pages as of')
            ->where("of.status = '1' and type_id = '2'")
            ->orderBy(['views'=> SORT_DESC])
            ->limit(5);
        $command = $query->createCommand();
        $topNews = $command->queryAll();*/
        $topNews = [];
        foreach(PageModel::find()
                    ->andWhere(['type_id' => '2'])
                    ->status(PageModel::STATUS_ON)
                    ->sortDate()->limit(5)->all() as $item){
            $obj = new PageObject($item);
            $topNews[] = $obj;
        }

        // Tags
        $query = new \yii\db\Query;
        $query->select('tg.name, p.page_id, tga.tag_id')
            ->from('easyii_tags_assign as tga')
            ->join('LEFT JOIN', 'easyii_tags as tg', 'tga.tag_id = tg.tag_id')
            ->join('LEFT JOIN', 'easyii_pages as p', 'p.page_id = tga.item_id')
            ->where("tga.class LIKE '%\\Page' AND p.type_id='2' ")
            //->orderBy(['views'=> SORT_DESC])
            ->limit(5);
        $command = $query->createCommand();
        $topTags = $command->queryAll();

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
        $command = $query->createCommand();
        $categoriesTops = $command->queryAll();

        $news = Page::get($slug);
        if(!$news){
            throw new \yii\web\NotFoundHttpException('Page Houston, we have a problem.');
        }

        $popularly  = Popularly::findOne(['class' => \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id]);
        if(empty($popularly)){ $popularly  = new Popularly; }
        //$popularly->getInherit($news, $popularly);
        $popularly->class = \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id;
        $popularly->slug = 'news/'.$news->slug;
        $popularly->title = $news->title;
        $popularly->item_id = $news->model->page_id;
        $popularly->image = $news->image;
        $popularly->time = time();
        $popularly->save();

        return $this->render('view', [
            'news' => $news,
            'categories_tops' => $categoriesTops,
            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews,
            'top_tags' => $topTags,
        ]);
    }
}
