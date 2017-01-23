<?php
namespace frontend\modules\seo\controllers;

use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;
use frontend\components\Controller;
use frontend\modules\seo\models\Seo;
use frontend\helpers\Image;
//use frontend\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [];
    }

    public function actionIndex()
    {
        //$model = Seo::find()->where(['name' => 'robots'])->one();
        $model = Seo::findOne(1);

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if(isset($_FILES)){
                    $uploadFile = UploadedFile::getInstance($model, 'sitemap');

                    if($uploadFile && $model->validate(['sitemap'])){
                        $uploadFile->saveAs(Yii::getAlias('@upload').'/seo/sitemap.xml');
                        //$model->sitemap = Image::upload($model->sitemap, 'sitemap');
                    }
                }

                if(!empty($model->robots)){
                    //$content=file_get_contents($file->tempName);
                    $robotsTxt = Yii::getAlias('@upload').'/seo/robots.txt';
                    $handle = @fopen($robotsTxt, 'w');
                    if($handle){
                        fwrite($handle, $model->robots);
                    }
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii/offers', 'Seo updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }

                return $this->refresh();
            }
        }
        else {
            return $this->render('index', [
                'model' => $model
            ]);
        }
    }

    public function actionCreate()
    {
        $model = new Seo;

        if ($model->load(Yii::$app->request->post())) {
            if(Yii::$app->request->isAjax){
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            else{
                if(isset($_FILES) && $this->module->settings['enableThumb']){
                    $model->image = UploadedFile::getInstance($model, 'image');
                    if($model->image && $model->validate(['image'])){
                        $model->image = Image::upload($model->image, 'seo');
                    }
                    else{
                        $model->image = '';
                    }
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii/seo', 'Seo created: '. $model->offer_id));
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


    public function actionUpload()
    {
        $model = new Seo();

        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstances($model, 'file');

            if ($model->file && $model->validate()) {
                foreach ($model->file as $file) {
                    $file->saveAs('uploads/' . $file->baseName . '.' . $file->extension);
                }
            }
        }

        return $this->render('upload', ['model' => $model]);
    }
    public function actionImageUpload()
    {
        $model = new Seo();

        $imageFile = UploadedFile::getInstance($model, 'image');




        $model->image = UploadedFile::getInstance($model, 'image');
        if($model->image && $model->validate(['image'])){
            $model->image = Image::upload($model->image, 'seo');
        }
        else{
            $model->image = $model->oldAttributes['image'];
        }

        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }

        if ($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . $fileName;
            if ($imageFile->saveAs($filePath)) {
                $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => $path,
                            'thumbnailUrl' => $path,
                            'deleteUrl' => 'image-delete?name=' . $fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }

        return '';
    }


}