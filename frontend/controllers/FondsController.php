<?php
namespace frontend\controllers;

use frontend\modules\page\api\Page;

class FondsController extends \yii\web\Controller
{
    public function actionIndex($type = null, $tag = null)
    {
        $pages = Page::items([
            'where' => ['type_id' => (int)$type, 'status' => 1],
            'pagination' => ['pageSize' => 10]
        ]);

        return $this->render('index',[
            'pages' => $pages
        ]);
    }

    public function actionView($slug)
    {
        $pages = Page::get($slug);
        if(!$pages){
            throw new \yii\web\NotFoundHttpException('Page Houston, we have a problem.');
        }

        return $this->render('view', [
            'pages' => $pages
        ]);
    }
}
