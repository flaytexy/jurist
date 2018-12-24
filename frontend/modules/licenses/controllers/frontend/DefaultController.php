<?php

namespace frontend\modules\licenses\controllers\frontend;

use Yii;
use yii\data\Pagination;
use frontend\controllers\General;
use frontend\modules\licenses\api\Licenses;
use frontend\modules\licenses\models\Licenses as LicensesModel;

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

        $LicensesPerPage = Licenses::items([
            'tags' => $tag, 'list' => 1,
            'orderBy'=>'title',
            'type_id' => (int)LicensesModel::TYPE_ID,
            'pagination' => ['pageSize' => 21],

        ]);

        return $this->render('index', [
            'LicensesPerPage' => $LicensesPerPage
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

        $licenses = Licenses::get($slug);

        // News
        $topNews = $this->getTopNews();
        // Offers
        $topOffers = $this->getTopOffers();

        return $this->render('view', [
            'licenses' => $licenses,
            'top_offers' => $topOffers,
            'top_news' => $topNews
        ]);
    }
}
