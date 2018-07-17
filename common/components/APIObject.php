<?php
namespace common\components;

use Yii;
use frontend\helpers\Image;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\models\Setting;
use yii\web\NotFoundHttpException;

/**
 * Class APIObject
 * @package frontend\components
 *
 * @property Model $model
 */
class APIObject extends \yii\base\Object
{
    public $model;

    public $slug;
    public $image;
    public $views;
    public $time;
    public $title;

    /**
     * Generates APIObject, attaching all settable properties to the child object
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
    public function init(){
        $this->title = $this->getName();
    }

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

        $attributeValue = '';
        if(isset($this->model->translation)){
            if(isset($this->model->translation->{'meta_'.$attribute})){
                $attributeValue = $this->model->translation->{'meta_'.$attribute};
            }elseif(isset($this->model->translation->{$attribute})){
                $attributeValue = $this->model->translation->{$attribute};
            }
        }

        if($attributeValue==false && $default!=false){
            $attributeValue = $default;
        }elseif($attributeValue==false){
            $mess = 'SEO_HASNT_ATTR: '.$attribute;
            $data = array(
                '$mess' => $mess,
                'slug' => $this->slug,
                'id' => $this->model->id,
                'type_id' => $this->model->type_id,
                'category_id' => $this->model->category_id
            );

            //$this->mailAPIObject($mess, $data);

            Yii::info(
                serialize($data),
                'seo_hasnt_attr'
            ); //отправка лога
            //ex_print($mess);
            //throw new NotFoundHttpException($mess);
        }

        return $attributeValue;

        //return isset($this->model->seo->{$attribute}) ? $this->model->seo->{$attribute} : $default;
    }

    /**
     * @return mixed|string
     */
    public function getTitle()
    {
        //ex_print('addssad');
        return $this->getName();
    }

    /**
     * @return mixed|string
     */
    public function getName()
    {
        if(isset($this->model->translation)){
            $name = $this->model->translation->name;
        }elseif(isset($this->model->translations) && isset($this->model->translations[Yii::$app->language])){
            ex_print($this->model->translations[Yii::$app->language]);
        }else{
            $name = $this->title;
        }

        return $name;
    }

    /**
     * @return string
     */
    public function getShortDescription()
    {
        if(isset($this->model->translation)){
            $name = $this->model->translation->short_description;
        }else{
            $name = $this->short;
        }

        return LIVE_EDIT ? API::liveEdit($name, $this->editLink) : $name;
    }

    /**
     * @return string
     */
    public function getShort()
    {
        return $this->getShortDescription();
    }

    /**
     * @return mixed|string
     */
    public function getDescription()
    {
        if ($this->model->isNewRecord) {
            return $this->createLink;
        } else {
            if(isset($this->model->translation)){
                $name = $this->model->translation->description;
            }else{
                $name = $this->text;
            }

            return LIVE_EDIT ? API::liveEdit($name, $this->editLink, 'div') : $name;
        }
    }

    /**
     * @return mixed|string
     */
    public function getText()
    {
        return $this->getDescription();
    }

    /**
     * @return mixed
     */
    public function getTags()
    {
        return $this->model->tagsArray;
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->time);
    }

    public function getEditLink()
    {
        return Url::to(['/admin/novanews/default/edit/', 'id' => $this->id]);
    }

    public function getCreateLink()
    {
        return Html::a(Yii::t('easyii/page/api', 'Create page'), ['/admin/novanews/default/create', 'slug' => $this->slug], ['target' => '_blank']);
    }

    public function mailApiObject($errorMessage = '', $data = array()){
        $message = '
                <h1>'.$errorMessage.'</h1>
                <b>404: ' . Url::base('https') . Yii::$app->request->url . '</b><br />
                <span>Referrer: ' . Yii::$app->request->referrer . '</span><br />
                <span>IP: ' . Yii::$app->request->remoteIP . '</span><br />
            ';

        if(is_array($data) && count($data)>0){
            foreach ($data as $key => $value){
                $message .= '<span>'.$key.': ' . $value . '</span><br />';
            }
        }

        return Yii::$app->mailer->compose()
            ->setFrom(Setting::get('robot_email'))
            //->setFrom('itc@iq-offshore.com')
            ->setTo('akvamiris@gmail.com')
            ->setSubject('Рапорт об ошибке Seo')
            ->setHtmlBody($message)//Url::to()
            //->setReplyTo(Setting::get('admin_email'))
            ->send();
    }
}