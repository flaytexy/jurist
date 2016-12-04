<?php
namespace frontend\modules\offers\api;

use Yii;
use frontend\components\API;
use frontend\models\Photo;
use frontend\modules\offers\models\Offers as OffersModel;
use yii\helpers\Url;

class OffersObject extends \frontend\components\ApiObject
{
    public $slug;
    public $image;
    public $views;
    public $time;

    public $pre_option;
    public $pre_image;
    public $pre_text;

    private $_photos;

    public function getTitle(){
        return LIVE_EDIT ? API::liveEdit($this->model->title, $this->editLink) : $this->model->title;
    }

    public function getShort(){
        return LIVE_EDIT ? API::liveEdit($this->model->short, $this->editLink) : $this->model->short;
    }

    public function getText(){
        return LIVE_EDIT ? API::liveEdit($this->model->text, $this->editLink, 'div') : $this->model->text;
    }

    public function getTags(){
        return $this->model->tagsArray;
    }

    public function getDate(){
        return Yii::$app->formatter->asDate($this->time);
    }

    public function getPhotos()
    {
        if(!$this->_photos){
            $this->_photos = [];

            foreach(Photo::find()->where(['class' => OffersModel::className(), 'item_id' => $this->id])->sort()->all() as $model){
                $this->_photos[] = new PhotoObject($model);
            }
        }
        return $this->_photos;
    }

    public function  getEditLink(){
        return Url::to(['/admin/offers/a/edit/', 'id' => $this->id]);
    }
}