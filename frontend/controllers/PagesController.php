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

        return $this->render('view', [
            'pages' => $pages,
            'parentPage' => $pageParent,
            'pageParentUrl' => $parts[1]
        ]);
    }
}
