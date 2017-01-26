<?php
namespace frontend\controllers;
use frontend\models\Popularly;
use frontend\modules\banks\api\Banks;
use yii\data\Pagination;
use yii\widgets\LinkPager;

class BanksController extends \yii\web\Controller
{
    public function actionIndex($tag = null)
    {
        $type_id = \Yii::$app->request->get('type_id');

        $banks = Banks::items(['tags' => $tag, 'type_id' => (int)$type_id,
            'pagination' => ['pageSize' => 300]]);


/*        $query = \frontend\modules\banks\models\Banks::find()->where(['status' => 1]);
        $count = $query->count();
        $pagination = new Pagination(['totalCount' => $count]);
        $banksList = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $banksPagination = LinkPager::widget([
            'pagination' => $pagination,
        ]);*/

        $banksList = Banks::items(['tags' => $tag, 'type_id' => (int)$type_id,
            'pagination' => ['pageSize' => 9]]);
        $banksPagination = Banks::pages();

        $markers = array();
        foreach($banks as $bank){
            $data = array();
            $data['latLng'] = explode(';', $bank->model->coordinates);
            $data['name'] = $bank->title;
            $data['weburl'] = 'b_' . $bank->model->bank_id;
            $markers[] = $data;
        }

        return $this->render('index', [
            'markers' => json_encode($markers),
            'banks' => $banks,
            'banksList' => $banksList,
            'banksPagination' => $banksPagination,
            'bank_type' => $type_id
        ]);
    }

    public function actionView($slug)
    {
        $this->getView()->registerJsFile(\Yii::$app->request->BaseUrl . '/js/site.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

        $banks = Banks::get($slug);

        $popularly  = Popularly::findOne(['class' => \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id]);
        if(empty($popularly)){ $popularly  = new Popularly; }
        //$popularly->getInherit($news, $popularly);
        $popularly->class = \Yii::$app->controller->id.'\\'.\Yii::$app->controller->action->id;
        $popularly->slug = 'news/'.$banks->slug;
        $popularly->title = $banks->title;
        $popularly->item_id = $banks->model->bank_id;
        $popularly->image = $banks->image;
        $popularly->time = time();
        $popularly->save();

        return $this->render('view', [
            'banks' => $banks
        ]);
    }
}
