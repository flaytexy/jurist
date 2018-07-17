<?php
namespace frontend\modules\seo\api;

use Yii;
use common\components\API;
use frontend\models\Photo;
use frontend\modules\seo\models\Seo as SeoModel;
use yii\helpers\Url;

class SeoObject extends \common\components\APIObject
{

    public function __construct($model){
        parent::__construct($model);
        $this->position = explode(';', $this->pos);
    }

    public function getTitle(){
        return LIVE_EDIT ? API::liveEdit($this->model->title, $this->editLink) : $this->model->title;
    }

    public function  getEditLink(){
        return Url::to(['/admin/seo/a/edit/', 'id' => $this->id]);
    }
}