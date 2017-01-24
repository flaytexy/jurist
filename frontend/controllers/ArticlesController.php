<?php

namespace frontend\controllers;

use frontend\modules\article\api\Article;

class ArticlesController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionCat($slug, $tag = null)
    {
        $cat = Article::cat($slug);
        if(!$cat){
            throw new \yii\web\NotFoundHttpException('Article category Houston, we have a problem.');
        }

        return $this->render('cat', [
            'cat' => $cat,
            'items' => $cat->items(['tags' => $tag, 'pagination' => ['pageSize' => 2]])
        ]);
    }

    public function actionView($slug)
    {
        $article = Article::get($slug);
        if(!$article){
            throw new \yii\web\NotFoundHttpException('Article Houston, we have a problem.');
        }

        return $this->render('view', [
            'article' => $article
        ]);
    }

}
