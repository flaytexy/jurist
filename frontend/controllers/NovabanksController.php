<?php

namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\modules\novabanks\api\Novabanks as Banks;
use yii\web\View;
use frontend\modules\novanews\models\Novanews as PageModel;
use frontend\modules\novanews\api\NovanewsObject as PageObject;



class NovabanksController extends General
{
    public function actionIndex($tag = null, $type = null, $slug = null, $page = null)
    {
        $type_id = \Yii::$app->request->get('type_id');

        if($page==1 || $page==false){
            $banks = Banks::items(['tags' => $tag, 'list' => 1, 'pagination' => ['pageSize' => 300], 'page'=> $page]);
            Banks::clear();
        }

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

        $banksList = Banks::items([
            'tags' => $tag,
            'pagination' => ['pageSize' => 30],
            'page'=> $page
        ]);

        $render = $this->render('index', [
            'items' => $banks,
            'banksList' => $banksList,
            'bank_type' => $type_id,
            //
            'banksPist' => $this->getBankPist(),
            'top_banks' => $this->getTopBanks(),
            'top_offers' => $this->getTopOffers(),
            'top_news' => $this->getTopNews()
        ]);

        return $render;
    }

    public function actionView($slug)
    {
        $banks = Banks::get($slug);

        if(!$banks){
            throw new \yii\web\NotFoundHttpException('Bank not found by slug.');
        }

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

        $popularly = Popularly::findOne(['class' => \Yii::$app->controller->id . '\\' . \Yii::$app->controller->action->id]);
        if (empty($popularly)) {
            $popularly = new Popularly;
        }
        //$popularly->getInherit($news, $popularly);
        $popularly->class = \Yii::$app->controller->id . '\\' . \Yii::$app->controller->action->id;
        $popularly->slug = 'banks/' . $banks->slug;
        $popularly->title = $banks->title;
        $popularly->item_id = $banks->model->id;
        $popularly->image = $banks->image;
        $popularly->time = time();
        $popularly->save();

        return $this->render('view', [
            'page' => $banks,
            //
            'banksPist' => $this->getBankPist(),
            'top_banks' => $this->getTopBanks(),
            'top_offers' => $this->getTopOffers(),
            'top_news' => $this->getTopNews()
        ]);
    }

    private function getBankPist(){
        $type_id = \Yii::$app->request->get('type_id');
        if (empty($type_id)){
            $type_id = 1;
        }

        return Banks::items(['list' => 1, 'type_id' => (int)$type_id]);
    }
}
