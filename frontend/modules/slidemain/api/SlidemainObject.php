<?php

namespace frontend\modules\slidemain\api;

use Yii;
use common\components\API;
use frontend\models\Photo;
use frontend\modules\slidemain\models\Slidemain as SlidemainModel;
use yii\helpers\Url;

/**
 * Class SlidemainObject
 * @package frontend\modules\slidemain\api
 *
 * @property \frontend\modules\slidemain\models\Slidemain $model
 * @property $countries;
 * @property $properties;
 */
class SlidemainObject extends \common\components\APIObject
{
    public $slug;
    public $image;
    public $views;
    public $time;

    public $image_flag;
    public $how_days;
    public $properties;
    public $countries;
    public $pos;
    public $url;

    private $_photos;

    /**
     * SlidemainObject constructor.
     * @param \frontend\modules\slidemain\models\Slidemain $model
     */
    public function __construct($model)
    {
        parent::__construct($model);
    }

    public function getTitle()
    {
        return LIVE_EDIT ? API::liveEdit($this->model->title, $this->editLink) : $this->model->title;
    }

    public function getShort()
    {
        return LIVE_EDIT ? API::liveEdit($this->model->short, $this->editLink) : $this->model->short;
    }

    public function getText()
    {
        return LIVE_EDIT ? API::liveEdit($this->model->text, $this->editLink, 'div') : $this->model->text;
    }

    public function getTags()
    {
        return $this->model->tagsArray;
    }

    public function getOptions()
    {
        return $this->model->optionsArray;
    }

    public function getPrice()
    {
        $price = number_format($this->model->price, 0, '.', '');
        return $price;
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->time);
    }

    public function getPhotos()
    {
        if (!$this->_photos) {
            $this->_photos = [];

            foreach (Photo::find()->where(['class' => SlidemainModel::className(), 'item_id' => $this->id])->sort()->all() as $model) {
                $this->_photos[] = new PhotoObject($model);
            }
        }
        return $this->_photos;
    }

    public function getEditLink()
    {
        return Url::to(['/admin/slidemain/a/edit/', 'id' => $this->id]);
    }

    /**
     * @return mixed
     */
    public function getCountries()
    {
        //return $this->countries;
        return $this->model->countries;
    }

    /**
     * @return mixed
     */
    public function getProperties()
    {
        return $this->model->properties;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        //return $this->countries;
        return $this->model->url;
    }
}