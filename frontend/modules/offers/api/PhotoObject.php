<?php
namespace frontend\modules\offers\api;

use Yii;
use common\components\API;
use yii\helpers\Html;
use yii\helpers\Url;

class PhotoObject extends \common\components\APIObject
{
    public $image;
    public $description;

    public function box($width, $height){
        $img = Html::img($this->thumb($width, $height));
        $a = Html::a($img, $this->image, [
            'class' => 'easyii-box',
            'rel' => 'offers-'.$this->model->item_id,
            'title' => $this->description
        ]);
        return LIVE_EDIT ? API::liveEdit($a, $this->editLink) : $a;
    }

    public function getEditLink(){
        return Url::to(['/admin/offers/a/photos', 'id' => $this->model->item_id]).'#photo-'.$this->id;
    }
}