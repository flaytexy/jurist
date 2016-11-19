<?php
namespace frontend\modules\admin\controllers;

use yii\data\ActiveDataProvider;

use frontend\models\LoginForm;

class LogsController extends \frontend\components\Controller
{
    public $rootActions = 'all';

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => LoginForm::find()->desc(),
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }
}