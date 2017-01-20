<?php
namespace frontend\controllers;

use frontend\modules\offers\models\Offers;
use frontend\modules\page\api\Page;

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

        return $this->render('index',[
            'news' => $news
        ]);
    }

    public function actionView($slug)
    {

        //$topOffers = Offers::find(2)->asArray()->all();
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_banks as ba')
            ->where("ba.status = '1' ")
            ->orderBy(['views'=> SORT_DESC])
            ->limit(5);
        $command = $query->createCommand();
        $topBanks = $command->queryAll();

        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_offers as of')
            ->where("of.status = '1' ")
            ->orderBy(['views'=> SORT_DESC])
            ->limit(5);
        $command = $query->createCommand();
        $topOffers = $command->queryAll();

        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_pages as of')
            ->where("of.status = '1' and type_id = '2'")
            ->orderBy(['views'=> SORT_DESC])
            ->limit(5);
        $command = $query->createCommand();
        $topNews = $command->queryAll();

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
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }

        return $this->render('view', [
            'news' => $news,
            'categories_tops' => $categoriesTops,
            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews
        ]);
    }
}
