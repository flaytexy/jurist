<?php
namespace frontend\modules\page\models;

use Yii;
use yii\behaviors\SluggableBehavior;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
use frontend\models\Photo;
use yii\helpers\StringHelper;


class Page extends \frontend\components\ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public $category_detail;

    public static function tableName()
    {
        return 'easyii_pages';
    }

    public function rules()
    {
        return [
            [['text', 'title'], 'required'],
            [['title', 'short', 'text', 'category_detail'], 'trim'],
            ['title', 'string', 'max' => 128],
            [['views', 'time', 'status', 'type_id'], 'integer'],
            ['to_main', 'integer', 'max' => 1],

            ['image', 'image', 'extensions' => 'jpg', 'jpeg'], //'png, jpg, jpeg, gif'
            ['pre_image', 'image', 'extensions' => 'jpg', 'jpeg'], //'png, jpg, jpeg, gif'

            [['views', 'time', 'status'], 'integer'],
            ['time', 'default', 'value' => time()],
            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['slug', 'unique'],
            ['status', 'default', 'value' => self::STATUS_ON],
            ['tagNames', 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'title' => Yii::t('easyii', 'Title'),
            'text' => Yii::t('easyii', 'Text'),
            'short' => Yii::t('easyii/page', 'Short'),
            'image' => Yii::t('easyii', 'Image'),
            'time' => Yii::t('easyii', 'Date'),
            'slug' => Yii::t('easyii', 'Slug'),
            'tagNames' => Yii::t('easyii', 'Tags'),
        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'taggabble' => Taggable::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true
            ],
        ];
    }

    public function getPhotos()
    {
        return $this->hasMany(Photo::className(), ['item_id' => 'page_id'])->where(['class' => self::className()])->sort();
    }



    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {
            $settings = Yii::$app->getModule('admin')->activeModules['page']->settings;
            $this->short = StringHelper::truncate($settings['enableShort'] ? $this->short : strip_tags($this->text), $settings['shortMaxLength']);

            if(strlen($this->category_detail)>1){
                $categoryData = explode(':',$this->category_detail);
                $this->type_id = $categoryData[0];
                $this->category_id = $categoryData[1];
            }

            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }

            if(!empty($this->oldAttributes['slug'])){
                $this->slug = $this->oldAttributes['slug'];
            }elseif(!empty(Yii::$app->request->post('Page')['slug'])){
                $this->slug = Yii::$app->request->post('Page')['slug'];
            }

            return true;
        } else {
            return false;
        }
    }

    public function afterDelete()
    {
        parent::afterDelete();

        if($this->image){
            @unlink(Yii::getAlias('@webroot').$this->image);
        }

        foreach($this->getPhotos()->all() as $photo){
            $photo->delete();
        }
    }

    public function getDate(){
        return date('Y-m-d', $this->time);
    }

    public function getDatetime(){
        return date('Y-m-d H:i:s', $this->time);
    }
}