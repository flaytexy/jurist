<?php
namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\modules\licenses\api\Licenses;
use frontend\modules\licenses\models\Licenses as LicensesModel;
use frontend\modules\licenses\models\LicensesExt;
use yii\web\NotFoundHttpException;
use yii;
/**
 * Class offersController
 * @package frontend\controllers
 */
class LicensesController extends General
{
    public function actionIndex($tag = null)
    {
        $request = Yii::$app->request;
        $lic_type = $request->get('lic_type');
        $country =$request->get('country');
        if(isset($lic_type)) {
            $licensesPerPage = Licenses::items([
                'tags' => $tag, 'list' => 1,
                'orderBy'=>'title',
                'type_id' => (int)LicensesModel::TYPE_ID,
                'pagination' => ['pageSize' => 21],
                'where' => [LicensesExt::tableName().'.lic_type' => $lic_type],
                'whereCountry' =>[LicensesExt::tableName().'.country' => $country]
            ]); }
            else{
                $licensesPerPage = Licenses::items([
                    'tags' => $tag, 'list' => 1,
                    'orderBy'=>'title',
                    'type_id' => (int)LicensesModel::TYPE_ID,
                    'pagination' => ['pageSize' => 21],
                ]);
            }
        if (count($licensesPerPage)==1) {
            return $this->redirect('licenses/'.$licensesPerPage[0]->slug,302)->send();
        }

        return $this->render('index', [
            'licensesPerPage' => $licensesPerPage,

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
        if(!licenses){
            throw new NotFoundHttpException('Page Houston, we have a problem.');
        }

        // News
        $topNews = $this->getTopNews();
        // offers
        $topOffers = $this->getTopOffers();

        return $this->render('view', [
            'licenses' => $licenses,
            'top_offers' => $topOffers,
            'top_news' => $topNews
        ]);
    }
}
