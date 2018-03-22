<?php
namespace frontend\modules\slidesmall\api;

use Yii;
use frontend\components\API;
use yii\helpers\Html;
use yii\helpers\Url;

class PhotoObject extends \frontend\components\ApiObject
{
    public $image;
    public $description;

    public function box($width, $height){
        $img = Html::img($this->thumb($width, $height));
        $a = Html::a($img, $this->image, [
            'class' => 'easyii-box',
            'rel' => 'slidesmall-'.$this->model->item_id,
            'title' => $this->description
        ]);
        return LIVE_EDIT ? API::liveEdit($a, $this->editLink) : $a;
    }

    public function getEditLink(){
        return Url::to(['/admin/slidesmall/a/photos', 'id' => $this->model->item_id]).'#photo-'.$this->id;
    }
}