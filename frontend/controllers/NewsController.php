<?php
namespace frontend\controllers;

use frontend\models\Popularly;
//use frontend\modules\page\api\Page as Page;
//use frontend\modules\page\api\PageObject as PageObject;
//use frontend\modules\page\models\Page as PageModel;

use frontend\modules\novanews\api\Novanews as Page;
use frontend\modules\novanews\api\NovanewsObject as PageObject;
use frontend\modules\novanews\models\Novanews as PageModel;

class NewsController extends \yii\web\Controller
{
    public function actionIndex($tag = null, $type = null, $slug = null, $page = null)
    {
        if($slug){
            $pageName = 'page-news-'.$slug;
            if(! $page = Page::get($pageName)){
                $pageName = 'page-news';
            }else{
                //throw new \yii\web\NotFoundHttpException('Page Houston, we have a problem. #54340');
            }

            $query = new \yii\db\Query;
            $query->select('category_id')
                ->from('content_categories as ept')
                ->where("ept.slug = '".$slug."'")
                ->limit(1);
            $command = $query->createCommand();
            $category = $command->queryOne();
            $category_id = $category['category_id'];

            $news = Page::items([
                'where' => ['category_id' => $category_id, 'status' => 1],
                'pagination' => ['pageSize' => 12]
            ]);

        }
        else {
            $pageName = 'page-news';
            $page = Page::get($pageName);
            if(!$page){
                throw new \yii\web\NotFoundHttpException('Page Houston, we have a problem. #54341');
            }

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
            //->orderBy(['views'=> SORT_DESC])
            ->orderBy(['rating'=>SORT_DESC, 'title' => SORT_ASC])
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
        $query->select('tg.name, p.id, tga.tag_id')
            ->from('easyii_tags_assign as tga')
            ->join('LEFT JOIN', 'easyii_tags as tg', 'tga.tag_id = tg.tag_id')
            ->join('LEFT JOIN', 'content as p', 'p.id = tga.item_id')
            ->where("tga.class LIKE '%\\Page' AND p.type_id='2' ")
            //->orderBy(['views'=> SORT_DESC])
            ->limit(5);
        $command = $query->createCommand();
        $topTags = $command->queryAll();

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
            'page' => $page,
            'news' => $news,
            'categories_tops' => $categoriesTops,
            'page_name' => $pageName,
            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews,
            'top_tags' => $topTags,
        ]);
    }

    public function actionIndexed($tag = null, $type = null, $slug = null){

    }

    public function actionView($slug)
    {
        $news = Page::get($slug);

        if(!$news){
            throw new \yii\web\NotFoundHttpException('Page Houston, we have a problem.');
        }


        // News
/*        $query = new \yii\db\Query;
        $query->select('*')
            ->from('content as of')
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

        // Banks
        //$topOffers = Offers::find(2)->asArray()->all();
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_banks as ba')
            ->where("ba.status = '1' ")
            //->orderBy(['views'=> SORT_DESC])
            ->orderBy(['rating'=>SORT_DESC, 'title' => SORT_ASC])
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
        $query->select('tg.name, p.id, tga.tag_id')
            ->from('easyii_tags_assign as tga')
            ->join('LEFT JOIN', 'easyii_tags as tg', 'tga.tag_id = tg.tag_id')
            ->join('LEFT JOIN', 'content as p', 'p.id = tga.item_id')
            ->where("tga.class LIKE '%\\Page' AND p.type_id='2' ")
            //->orderBy(['views'=> SORT_DESC])
            ->limit(5);
        $command = $query->createCommand();
        $topTags = $command->queryAll();

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
        $command = $query->createCommand();
        $categoriesTops = $command->queryAll();



        $popularly  = Popularly::findOne(['class' => \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id]);
        if(empty($popularly)){ $popularly  = new Popularly; }
        //$popularly->getInherit($news, $popularly);
        $popularly->class = \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id;
        $popularly->slug = 'news/'.$news->slug;
        $popularly->title = $news->title;
        $popularly->item_id = $news->model->id;
        $popularly->image = $news->image;
        $popularly->time = time();
        $popularly->save();

        return $this->render('view', [
            //'new' => $news,
            'news' => $news,
            'categories_tops' => $categoriesTops,
            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews,
            'top_tags' => $topTags,
        ]);
    }
}
