<?php
namespace frontend\controllers;

use frontend\modules\page\api\Page;

class PagesController extends \yii\web\Controller
{
    public function actionIndex($type = null, $tag = null, $name = null)
    {

        $pages = Page::items([
            'where' => ['type_id' => (int)$type, 'status' => 1],
            'pagination' => ['pageSize' => 10]
        ]);
ex_print($pages);
        return $this->render('index',[
            'pages' => $pages,
            'typeTitle' => $name
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
