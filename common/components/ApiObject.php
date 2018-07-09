<?php
namespace frontend\components;

use Yii;
use frontend\helpers\Image;

/**
 * Class ApiObject
 * @package frontend\components
 */
class ApiObject extends \yii\base\Object
{
    /** @var \yii\base\Model  */
    public $model;

    /**
     * Generates ApiObject, attaching all settable properties to the child object
     * @param \yii\base\Model $model
     */
    public function __construct($model){
        $this->model = $model;

        foreach($model->attributes as $attribute => $value){
            if($this->canSetProperty($attribute)){
                $this->{$attribute} = $value;
            }
        }

        $this->init();
    }

    /**
     * calls after __construct
     */
    public function init(){}

    /**
     * Returns object id
     * @return int
     */
    public function getId(){
        return $this->model->primaryKey;
    }

    /**
     * Creates thumb from model->image attribute with specified width and height.
     * @param int|null $width
     * @param int|null $height
     * @param bool $crop if false image will be resize instead of cropping
     * @return string
     */
    public function thumb($width = null, $height = null, $crop = true)
    {
        if($this->image && ($width || $height)){
            return Image::thumb($this->image, $width, $height, $crop);
        }
        return '';
    }

    /**
     * Creates thumb from model->image attribute with specified width and height.
     * @param bool|false $fileName
     * @param null $width
     * @param null $height
     * @param bool|true $crop
     * @return string
     */
    public function thumbFile($fileName = false, $width = null, $height = null, $crop = true)
    {
        if(empty($fileName))
            $fileName = $this->image;

        if($fileName && ($width || $height)){
            return Image::thumb($fileName, $width, $height, $crop);
        }
        return '';
    }
    /**
     * Get seo text attached to object
     * @param string $attribute name of seo attribute can be h1, title, description, keywords
     * @param string $default default string applied if seo text Houston, we have a problem
     * @return string
     */
    public function seo($attribute, $default = ''){
        return !empty($this->model->seo->{$attribute}) ? $this->model->seo->{$attribute} : $default;
    }
}