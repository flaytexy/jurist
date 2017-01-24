<?php
namespace frontend\modules\shopcart\controllers;

use Yii;

use frontend\components\Controller;
use frontend\modules\shopcart\models\Good;

class GoodsController extends Controller
{
    public function actionDelete($id)
    {
        if(($model = Good::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Houston, we have a problem');
        }
        return $this->formatResponse(Yii::t('easyii/shopcart', 'Order deleted'));
    }
}