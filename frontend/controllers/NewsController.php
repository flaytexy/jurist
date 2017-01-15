<?php
namespace frontend\controllers;

use frontend\modules\page\api\Page;

class NewsController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        return $this->render('index',[
            'news' => Page::items(['tags' => $tag, 'pagination' => ['pageSize' => 18]])
        ]);
    }

    public function actionView($slug)
    {
        $news = Page::get($slug);
        if(!$news){
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }

        return $this->render('view', [
            'news' => $news
        ]);
    }
}
