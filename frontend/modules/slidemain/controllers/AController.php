<?php
namespace frontend\modules\slidemain\controllers;


use Yii;
use yii\data\ActiveDataProvider;
use frontend\behaviors\SortableDateController;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use frontend\components\Controller;
use frontend\modules\slidemain\models\Slidemain;
use frontend\helpers\Image;
use frontend\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableDateController::className(),
                'model' => Slidemain::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => Slidemain::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $data = new ActiveDataProvider([
            'query' => Slidemain::find(), //location_title
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Slidemain;
        $model->time = time();

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if(isset($_FILES) && $this->module->settings['enableThumb']){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'slidemain');
                    }
                    else{
                        $model->image = '';
                    }

                    $model->image_flag = UploadedFile::getInstance($model, 'image_flag');
                    if($model->image_flag && $model->validate(['image_flag'])){
                        $model->image_flag = Image::upload($model->image_flag, 'slidemain');
                    }
                    else{
                        $model->image_flag = '';
                    }
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii/slidemain', 'Slidemain created: '. $model->slide_main_id));
                    //return $this->redirect(['/admin/'.$this->module->id]);
                    return $this->redirect(['/admin/'.$this->module->id.'/a/edit/'.$model->slide_main_id]);
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Create error. {0}', $model->formatErrors()));
                    return $this->refresh();
                }
            }
        }
        else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }

    public function actionEdit($id)
    {

        $model = Slidemain::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Houston, we have a problem'));
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        if ($model->load(Yii::$app->request->post())) {


            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if(isset($_FILES) && $this->module->settings['enableThumb']){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'slidemain');
                    }
                    else{
                        $model->image = $model->oldAttributes['image'];
                    }

                    $model->image_flag = UploadedFile::getInstance($model, 'image_flag');

                    if($model->image_flag && $model->validate(['image_flag'])){
                        $model->image_flag = Image::upload($model->image_flag, 'slidemain');
                    }
                    else{
                        $model->image_flag = $model->oldAttributes['image_flag'];
                    }
                }


                if($model->save()){
                    $this->flash('success', Yii::t('easyii/slidemain', 'Slidemain updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model
            ]);
        }
    }

    public function actionPhotos($id)
    {
        if(!($model = Slidemain::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionPackets($id)
    {

        if(!($model = Slidemain::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('packets', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if(($model = Slidemain::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Houston, we have a problem');
        }
        return $this->formatResponse(Yii::t('easyii/slidemain', 'Slidemain deleted'));
    }

    public function actionClearImage($id)
    {
        $model = Slidemain::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Houston, we have a problem'));
        }
        else{
            $model->image = '';
            if($model->update()){
                if(!empty($model->image)) @unlink(Yii::getAlias('@webroot').$model->image);
                $this->flash('success', Yii::t('easyii', 'Image cleared'));
            } else {
                $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
            }
        }
        return $this->back();
    }

    public function actionUp($id)
    {
        return $this->move($id, 'up');
    }

    public function actionDown($id)
    {
        return $this->move($id, 'down');
    }

    public function actionOn($id)
    {
        return $this->changeStatus($id, Slidemain::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Slidemain::STATUS_OFF);
    }
}