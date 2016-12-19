<?php
namespace frontend\modules\admin\controllers;

use Yii;
use frontend\models\Option;
use yii\helpers\Html;
use yii\web\Response;

class OptionsController extends \frontend\components\Controller
{
    public function actionList($query, $type = 1)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $items = [];
        $query = urldecode(mb_convert_encoding($query, "UTF-8"));
        $tags = Option::find()
            ->where(['like', 'name', $query])
            ->asArray()
            ->all();

        foreach ($tags as $tag) {
            $items[] = ['name' => $tag['name']];
        }

        return $items;
    }
}