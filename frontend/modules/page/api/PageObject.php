<?php
namespace frontend\modules\page\api;

use Yii;
use frontend\components\API;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Photo;
use frontend\modules\page\models\Page as PageModel;


class PageObject extends \frontend\components\ApiObject
{
    public $slug;
    public $image;
    public $views;
    public $time;

    private $_photos;

    public function __construct($model){
        parent::__construct($model);
    }

    public function getTitle()
    {
        if ($this->model->isNewRecord) {
            return $this->createLink;
        } else {
            return LIVE_EDIT ? API::liveEdit($this->model->title, $this->editLink) : $this->model->title;
        }
    }

    public function getShort()
    {
        return LIVE_EDIT ? API::liveEdit($this->model->short, $this->editLink) : $this->model->short;
    }

    public function getText()
    {
        if ($this->model->isNewRecord) {
            return $this->createLink;
        } else {
            return LIVE_EDIT ? API::liveEdit($this->model->text, $this->editLink, 'div') : $this->model->text;
        }
    }

    public function getTags()
    {
        return $this->model->tagsArray;
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->time);
    }

    public function getPhotos()
    {
        if (!$this->_photos) {
            $this->_photos = [];

            foreach (Photo::find()->where(['class' => PageModel::className(), 'item_id' => $this->id])->sort()->all() as $model) {
                $this->_photos[] = new PhotoObject($model);
            }
        }
        return $this->_photos;
    }

    public function getEditLink()
    {
        return Url::to(['/admin/page/a/edit/', 'id' => $this->id]);
    }

    public function getCreateLink()
    {
        return Html::a(Yii::t('easyii/page/api', 'Create page'), ['/admin/page/a/create', 'slug' => $this->slug], ['target' => '_blank']);
    }
}