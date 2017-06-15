<?php
namespace frontend\controllers;

use frontend\models\Popularly;
use frontend\modules\page\api\Page;

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
            'where' => ['type_id' => (int)$type, 'status' => 1],
            'pagination' => ['pageSize' => 9]
        ]);

        return $this->render('index',[
            'pages' => $pages,
            'typeTitle' => $name
        ]);
    }

    public function actionView($slug, $name = null)
    {
        $parts = explode('/', \Yii::$app->request->getUrl());

        $pages = Page::get($slug);
        if(!$pages){
            throw new \yii\web\NotFoundHttpException('Page Houston, we have a problem.');
        }

        $pageParent = \frontend\modules\page\models\Page::findOne(['slug'=>'page-'.$parts[1]]);


        $popularly  = Popularly::findOne(['class' => \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id.$parts[1]]);
        if(empty($popularly)){ $popularly  = new Popularly; }
        //$popularly->getInherit($news, $popularly);
        $popularly->class = \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id.$parts[1];
        $popularly->slug = $parts[1].'/'.$pages->slug;
        $popularly->title = $pages->title;
        $popularly->item_id = $pages->model->page_id;
        $popularly->image = $pages->image;
        $popularly->time = time();
        $popularly->save();

        return $this->render('view', [
            'page' => $pages,
            'parentPage' => $pageParent,
            'pageParentUrl' => $parts[1]
        ]);
    }
}
