<?php

namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\modules\banks\api\Banks;
use yii\data\Pagination;
use yii\web\View;
use yii\widgets\LinkPager;
use frontend\modules\page\models\Page as PageModel;
use frontend\modules\page\api\PageObject;

class BanksController extends \yii\web\Controller
{

    public function actionIndex($tag = null, $type = null, $slug = null, $page = null)
    {

        $type_id = \Yii::$app->request->get('type_id');

        if($page==1 || $page==false){
            $banks = Banks::items(['tags' => $tag, 'list' => 1, 'pagination' => ['pageSize' => 300], 'page'=> $page]);
            Banks::clear();
        }

        //ex_print(count($banks),'$banks');
        /* $query = \frontend\modules\banks\models\Banks::find()->where(['status' => 1]);
                $count = $query->count();
                $pagination = new Pagination(['totalCount' => $count]);
                $banksList = $query->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
                $banksPagination = LinkPager::widget([
                    'pagination' => $pagination,
                ]);*/

        $this->getView()->registerJs(
            "
                //$('#sw-list input.switch').switcher({copy: {en: {yes: '', no: ''}}});
                //reCheckJsFilter();
                //$('#sw-list input.switch').on('change', function(){
                //    reCheckJsFilter($(this));
                //});
            ",
            View::POS_READY,
            'my-switch-handler'
        );

        //e_print('clear');

        //e_print('$banksList');
        $banksList = Banks::items([
            'tags' => $tag,
            'pagination' => ['pageSize' => 30],
            'page'=> $page
        ]);
        //e_print('$banksList_end');


        //e_print('$render');

        $banksPist = Banks::items(['list' => 1, 'type_id' => (int)$type_id]);
        $topNews = [];
        foreach (PageModel::find()
                     ->andWhere(['type_id' => '2'])
                     ->status(PageModel::STATUS_ON)
                     ->sortDate()->limit(5)->all() as $item) {
            $obj = new PageObject($item);
            $topNews[] = $obj;
        }


        //$topOffers = Offers::find(2)->asArray()->all();
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_banks as ba')
            ->where("ba.status = '1' ")
            ->orderBy(['rating' => SORT_DESC])
            ->limit(3);
        $command = $query->createCommand();
        $topBanks = $command->queryAll();

        // Offers
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_offers as of')
            ->where("of.status = '1' ")
            ->orderBy(['views' => SORT_DESC])
            ->limit(3);
        $command = $query->createCommand();
        $topOffers = $command->queryAll();


        $render = $this->render('index', [
            'items' => $banks,
            'banksList' => $banksList,
            'bank_type' => $type_id,
            'banksPist' => $banksPist,
            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews
        ]);
        //e_print('$render_end');

        return $render;
    }

    public function actionView($slug)
    {
        $banks = Banks::get($slug);

        if(!$banks){
            throw new \yii\web\NotFoundHttpException('Bank not found by slug.');
        }

        $topNews = [];
        foreach (PageModel::find()
                     ->andWhere(['type_id' => '2'])
                     ->status(PageModel::STATUS_ON)
                     ->sortDate()->limit(5)->all() as $item) {
            $obj = new PageObject($item);
            $topNews[] = $obj;
        }

        // Banks
        //$topOffers = Offers::find(2)->asArray()->all();
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_banks as ba')
            ->where("ba.status = '1' ")
            ->orderBy(['rating' => SORT_DESC])
            ->limit(3);
        $command = $query->createCommand();
        $topBanks = $command->queryAll();

        // Offers
        $query = new \yii\db\Query;
        $query->select('*')
            ->from('easyii_offers as of')
            ->where("of.status = '1' ")
            ->orderBy(['views' => SORT_DESC])
            ->limit(3);
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

        $this->getView()->registerJsFile(\Yii::$app->request->BaseUrl . '/js/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);



        $popularly = Popularly::findOne(['class' => \Yii::$app->controller->id . '\\' . \Yii::$app->controller->action->id]);
        if (empty($popularly)) {
            $popularly = new Popularly;
        }
        //$popularly->getInherit($news, $popularly);
        $popularly->class = \Yii::$app->controller->id . '\\' . \Yii::$app->controller->action->id;
        $popularly->slug = 'banks/' . $banks->slug;
        $popularly->title = $banks->title;
        $popularly->item_id = $banks->model->bank_id;
        $popularly->image = $banks->image;
        $popularly->time = time();
        $popularly->save();

        $type_id = \Yii::$app->request->get('type_id');
        if (empty($type_id))
            $type_id = 1;

        $banksPist = Banks::items(['list' => 1, 'type_id' => (int)$type_id]);

        return $this->render('view', [
            'page' => $banks,
            'banksPist' => $banksPist,
            'top_banks' => $topBanks,
            'top_offers' => $topOffers,
            'top_news' => $topNews
        ]);
    }

    public function actionNew($tag = null)
    {

        $type_id = \Yii::$app->request->get('type_id');

        $banks = Banks::items(['tags' => $tag, 'list' => 1, 'pagination' => ['pageSize' => 300]]);

        /*        $query = \frontend\modules\banks\models\Banks::find()->where(['status' => 1]);
                $count = $query->count();
                $pagination = new Pagination(['totalCount' => $count]);
                $banksList = $query->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
                $banksPagination = LinkPager::widget([
                    'pagination' => $pagination,
                ]);*/

        $this->getView()->registerJs(
            "
                $('#sw-list input.switch').switcher({copy: {en: {yes: '', no: ''}}});
                reCheckJsFilter();
                $('#sw-list input.switch').on('change', function(){
                    reCheckJsFilter($(this));
                });
            ",
            View::POS_READY,
            'my-switch-handler'
        );


        Banks::clear();
        $banksList = Banks::items(['tags' => $tag, 'pagination' => ['pageSize' => 6]]);
        $banksPagination = Banks::pages();

        return $this->render('index_new', [
            'banks' => $banks,
            'banksList' => $banksList,
            'banksPagination' => $banksPagination,
            'bank_type' => $type_id
        ]);
    }
    /*
        public function actionIndexOLD($tag = null)
        {
            $type_id = \Yii::$app->request->get('type_id');

            $banks = Banks::items(['tags' => $tag, 'type_id' => (int)$type_id,
                'pagination' => ['pageSize' => 300]]);

    //        $query = \frontend\modules\banks\models\Banks::find()->where(['status' => 1]);
    //        $count = $query->count();
    //        $pagination = new Pagination(['totalCount' => $count]);
    //        $banksList = $query->offset($pagination->offset)
    //            ->limit($pagination->limit)
    //            ->all();
    //        $banksPagination = LinkPager::widget([
    //            'pagination' => $pagination,
    //        ]);

            $banksList = Banks::items(['tags' => $tag, 'type_id' => (int)$type_id,
                'pagination' => ['pageSize' => 9]]);
            $banksPagination = Banks::pages();

            $markers = array();
            foreach($banks as $bank){
                $data = array();
                $data['latLng'] = explode(';', $bank->model->coordinates);
                $data['name'] = $bank->title;
                $data['weburl'] = 'b_' . $bank->model->bank_id;
                $markers[] = $data;
            }

            return $this->render('index', [
                'markers' => json_encode($markers),
                'banks' => $banks,
                'banksList' => $banksList,
                'banksPagination' => $banksPagination,
                'bank_type' => $type_id
            ]);
        }*/
}
