<?php
namespace frontend\modules\gallery\controllers;

use frontend\components\CategoryController;
use frontend\modules\gallery\models\Category;

class AController extends CategoryController
{
    public $categoryClass = 'frontend\modules\gallery\models\Category';
    public $moduleName = 'gallery';
    public $viewRoute = '/a/photos';

    public function actionPhotos($id)
    {
        if(!($model = Category::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }
}