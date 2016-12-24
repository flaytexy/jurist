<?php
namespace frontend\modules\admin\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\Response;

use frontend\helpers\Image;
use frontend\components\Controller;
use frontend\models\Packet;
use frontend\behaviors\SortableController;

class PacketsController extends Controller
{
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\filters\ContentNegotiator',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON
                ],
            ],
            [
                'class' => SortableController::className(),
                'model' => Packet::className(),
            ]
        ];
    }

    public function actionUpload($class, $item_id)
    {
        $success = null;

        $packet = new Packet;
        $packet->class = $class;
        $packet->item_id = $item_id;

        if($packet->title){
            if($packet->save()){
                $success = [
                    'message' => Yii::t('easyii', 'Packet uploaded'),
                    'packet' => [
                        'id' => $packet->primaryKey,
                        'title' => $packet->title,
                        'description' => ''
                    ]
                ];
            }
            else{
                $this->error = Yii::t('easyii', 'Create error. {0}', $packet->formatErrors());
            }
        }
        else{
            $this->error = Yii::t('easyii', 'File upload error. Check uploads folder for write permissions');
        }



        return $this->formatResponse($success);
    }

    public function actionDescription($id)
    {
        if(($model = Packet::findOne($id)))
        {
            if(Yii::$app->request->post('description') ||
                Yii::$app->request->post('title') ||
                Yii::$app->request->post('tagNames') ||
                Yii::$app->request->post('price')
            )
            {
                $model->title = Yii::$app->request->post('title');
                $model->description = Yii::$app->request->post('description');
                $model->tagNames = Yii::$app->request->post('tagNames');
                $model->price = Yii::$app->request->post('price');

                if(!$model->update()) {
                    $this->error = Yii::t('easyii', 'Update error. {0}', $model->formatErrors());
                }
            }
            else{
                $this->error = Yii::t('easyii', 'Bad response');
            }
        }
        else{
            $this->error = Yii::t('easyii', 'Not found');
        }

        return $this->formatResponse(Yii::t('easyii', 'Packet description saved'));
    }

    public function actionEdit($id)
    {
        $success = null;

        if(($packet = Packet::findOne($id)))
        {
            if($packet->title){
                if($packet->save()){
                    $success = [
                        'message' => Yii::t('easyii', 'Packet uploaded'),
                        'packet' => [
                            'title' => $packet->title
                        ]
                    ];
                }
                else{
                    $this->error = Yii::t('easyii', 'Update error. {0}', $packet->formatErrors());
                }
            }
            else{
                $this->error = Yii::t('easyii', 'File upload error. Check uploads folder for write permissions');
            }


        }
        else{
            $this->error =  Yii::t('easyii', 'Not found');
        }

        return $this->formatResponse($success);
    }

    public function actionDelete($id)
    {
        if(($model = Packet::findOne($id))){
            $model->delete();
        } else {
            $this->error = Yii::t('easyii', 'Not found');
        }
        return $this->formatResponse(Yii::t('easyii', 'Packet deleted'));
    }

    public function actionUp($id, $class, $item_id)
    {
        return $this->move($id, 'up', ['class' => $class, 'item_id' => $item_id]);
    }

    public function actionDown($id, $class, $item_id)
    {
        return $this->move($id, 'down', ['class' => $class, 'item_id' => $item_id]);
    }
}