<?php
namespace frontend\controllers;

use frontend\modules\page\api\Page;

class NewsController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        return $this->render('index',[
            'pages' => Page::items(['tags' => $tag, 'pagination' => ['pageSize' => 4]])
        ]);
    }

    public function actionView($slug)
    {
        $pages = Page::get($slug);
        if(!$pages){
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }

        return $this->render('view', [
            'pages' => $pages
        ]);
    }
}
