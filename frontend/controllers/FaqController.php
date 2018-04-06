<?php

namespace frontend\controllers;

use frontend\modules\faq\api\Faq;

class FaqController extends \yii\web\Controller
{
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $page = \frontend\modules\page\api\Page::get('page-faq');
        if($page){
            $this->view->title = $page->seo('title', $page->model->title);
            //$this->view->registerMetaTag(['name' => 'keywords', 'content' => 'yii, framework, php']);
            $this->view->registerMetaTag([
                'name' => 'title',
                'content' => $page->seo('title', '')
            ]);
            $this->view->registerMetaTag([
                'name' => 'keywords',
                'content' => $page->seo('keywords', '')
            ]);
            $this->view->registerMetaTag([
                'name' => 'description',
                'content' => $page->seo('description', '')
            ]);
        }

        $faqs = Faq::items([
            'where' => ['status' => 1],
            'pagination' => ['pageSize' => 30]
        ]);

        return $this->render('index', [
            'faqs' => $faqs
        ]);
    }

}
