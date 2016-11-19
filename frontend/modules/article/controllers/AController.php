<?php
namespace frontend\modules\article\controllers;

use frontend\components\CategoryController;

class AController extends CategoryController
{
    /** @var string  */
    public $categoryClass = 'frontend\modules\article\models\Category';

    /** @var string  */
    public $moduleName = 'article';
}