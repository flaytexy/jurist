<?php
namespace frontend\modules\banks\api;

use Yii;
use frontend\components\API;
use frontend\models\Photo;
use frontend\modules\banks\models\Banks as BanksModel;
use yii\helpers\Url;

class BanksObject extends \frontend\components\ApiObject
{
    public $slug;
    public $image;
    public $views;
    public $time;

    public $properties;
    public $pos;

    private $_photos;

    public function __construct($model){
        parent::__construct($model);
    }

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

    public function getOptions(){
        return $this->model->optionsArray;
    }

    public function getPrice(){
        $price = number_format( $this->model->price, 0, '.', '');
        return $price;
    }

    public function getDate(){
        return Yii::$app->formatter->asDate($this->time);
    }

    public function getPhotos()
    {
        if(!$this->_photos){
            $this->_photos = [];

            foreach(Photo::find()->where(['class' => BanksModel::className(), 'item_id' => $this->id])->sort()->all() as $model){
                $this->_photos[] = new PhotoObject($model);
            }
        }
        return $this->_photos;
    }

    public function  getEditLink(){
        return Url::to(['/admin/banks/a/edit/', 'id' => $this->id]);
    }
}