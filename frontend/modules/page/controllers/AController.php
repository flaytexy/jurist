<?php
namespace frontend\modules\page\controllers;

use frontend\modules\page\models\PageCategories;
use Yii;
use yii\data\ActiveDataProvider;
use frontend\behaviors\SortableDateController;
use yii\widgets\ActiveForm;
use yii\web\UploadedFile;

use frontend\components\Controller;
use frontend\modules\page\models\Page;
use frontend\helpers\Image;
use frontend\behaviors\StatusController;

class AController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => SortableDateController::className(),
                'model' => Page::className(),
            ],
            [
                'class' => StatusController::className(),
                'model' => Page::className()
            ]
        ];
    }

    public function actionIndex()
    {
        $type_id = Yii::$app->request->get('type');

        $query  = Page::find()->sortDate();

        if(!empty($type_id)){
            $query->andWhere(['type_id' => (int)$type_id]);
        }
        $data = new ActiveDataProvider([
            'query' => $query,
        ]);

/*        $data = [
            'data' => \frontend\modules\page\api\Page::items([
                'where' => ['type_id' => $type_id],
                'pagination' => ['pageSize' => 20]
            ])
        ];
        */
        //$data = \frontend\modules\page\api\Page::items(['type_id' => (int)$type_id, 'pagination' => ['pageSize' => 300]]);

        return $this->render('index', [
            'data' => $data
        ]);
    }

    public function actionCreate()
    {
        $model = new Page;
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
                        $model->image = Image::upload($model->image, 'page');
                    }
                    else{
                        $model->image = '';
                    }
                }
                if($model->save()){
                    $this->flash('success', Yii::t('easyii/page', 'Page created'));
                    return $this->redirect(['/admin/'.$this->module->id]);
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
        //$categories = PageCategories::findAll();
        $query = new \yii\db\Query;
        $query->select('ept.title as parent_title, ept.*, ept2.*')
            ->from('easyii_pages_categories as ept')
            ->join('RIGHT JOIN', 'easyii_pages_categories as ept2', 'ept2.parent_id = ept.category_id')
            ->limit(20);
        $command = $query->createCommand();
        $categoriesData = $command->queryAll();

        $categories = [];
        foreach($categoriesData as $value){
            if($value['parent_title'])
                $categories[$value['category_id']] = $value['parent_title'] . " -> ". $value['title'];
            else
                $categories[$value['category_id']] = $value['title'];
        }

        $model = Page::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
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
                        $model->image = Image::upload($model->image, 'page');
                    }
                    else{
                        $model->image = $model->oldAttributes['image'];
                    }
                }

                if($model->save()){
                    $this->flash('success', Yii::t('easyii/page', 'Page updated'));
                }
                else{
                    $this->flash('error', Yii::t('easyii', 'Update error. {0}', $model->formatErrors()));
                }
                return $this->refresh();
            }
        }
        else {
            return $this->render('edit', [
                'model' => $model,
                'categories'=>$categories
            ]);
        }
    }

    public function actionPhotos($id)
    {
        if(!($model = Page::findOne($id))){
            return $this->redirect(['/admin/'.$this->module->id]);
        }

        return $this->render('photos', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        if(($model = Page::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii/page', 'Page deleted'));
    }

    public function actionClearImage($id)
    {
        $model = Page::findOne($id);

        if($model === null){
            $this->flash('error', Yii::t('easyii', 'Not found'));
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
        return $this->changeStatus($id, Page::STATUS_ON);
    }

    public function actionOff($id)
    {
        return $this->changeStatus($id, Page::STATUS_OFF);
    }
}