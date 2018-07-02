<?php

namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\modules\novanews\api\Novanews;
use frontend\modules\novanews\api\NovanewsObject;
use frontend\modules\novanews\models\Novanews as NovanewsModel;
use yii\web\NotFoundHttpException;

class NovanewsController extends General
{
    public function actionIndex($type = null, $tag = null, $name = null, $page = null)
    {
        if(false == $page = Novanews::get('page-'.$name)){
            throw new NotFoundHttpException('Error: #4560');
        }

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

        $pages = Novanews::items([
            'tags' => $tag,
            'where' => ['type_id' => (int)$type, 'status' => 1],
            'pagination' => ['pageSize' => 15]
        ]);
        return $this->render('index',[
            'page' => $page,
            'pages' => $pages,
            'typeTitle' => $name
        ]);
    }

    public function actionView($slug, $name = null)
    {
        $pages = Novanews::get($slug);

        if(!$pages){
            throw new NotFoundHttpException('Page Houston, we have a problem.');
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


        $parts = explode('/', \Yii::$app->request->getUrl());



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
            'parentPage' => \frontend\modules\novanews\models\Novanews::findOne(['slug'=>'page-'.$prefixSlug]),
            'pageParentUrl' => $prefixSlug,
            'top_banks' => $this->getTopOffers(),
            'top_offers' => $this->getTopOffers(),
            'top_news' => $this->getTopNews(),
        ]);
    }
}
