<?php
namespace frontend\modules\offers\controllers;


use Yii;
use yii\data\ActiveDataProvider;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use frontend\components\Controller;
use frontend\modules\offers\models\Offers;
use frontend\helpers\Image;


class AController extends Controller
{


    public function actionIndex()
    {

        $data = new ActiveDataProvider([
            'query' => Offers::find()->orderBy(['title' => SORT_ASC]),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);
        //ex_print('saddsa2222');
        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Offers;
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
                        $model->image = Image::upload($model->image, 'offers');
                    }
                    else{
                        $model->image = '';
                    }
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii/offers', 'Offers created: '. $model->offer_id));
                    //return $this->redirect(['/admin/'.$this->module->id]);
                    return $this->redirect(['/admin/'.$this->module->id.'/a/edit/'.$model->offer_id]);
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
        $model = Offers::findOne($id);

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
                        $model->image = Image::upload($model->image, 'offers');
                    }
                    else{
                        $model->image = $model->oldAttributes['image'];
                    }
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii/offers', 'Offers updated'));
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
        if(!($model = Offers::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionPackets($id)
    {
        if(Yii::$app->request->post()){
            return Yii::$app->runAction('/admin/packets/description/', ['id' => Yii::$app->request->post('id')]);
        }

        if(!($model = Offers::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('packets', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if(($model = Offers::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Houston, we have a problem');
        }
        return $this->formatResponse(Yii::t('easyii/offers', 'Offers deleted'));
    }

    public function actionClearImage($id)
    {
        $model = Offers::findOne($id);

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
        return $this->changeStatus($id, Offers::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Offers::STATUS_OFF);
    }
}