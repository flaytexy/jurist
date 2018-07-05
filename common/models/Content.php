<?php

namespace common\models;

use common\behaviors\MySluggableBehavior;
use common\modules\attachment\models\Attachment;
use common\components\ActiveRecord;

use Imagine\Image\ImageInterface;
use Yii;
use yii\helpers\Url;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;
/**
 *
 * @property int $id
 * @property string $thumbnail
 * @property string $type
 * @property int $type_id
 * @property int $publish_date
 *
 *
 * @property string $name
 * @property string $title
 * @property string $short_description
 * @property string $description
 *
 *
 * @property ContentTranslation[] $translations
 * @property ContentTranslation $translation
 */
class Content extends ActiveRecord
{
    const STATUS_OFF = 0;
    const STATUS_ON = 1;

    public $language = 'ru-RU';

    protected $_name = null;
    protected $_edit_link = null;

    protected static $_type = 'content';
    protected static $_translateModel;

    public $category_detail;

    //public $miniature;
    public $miniature;
    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{content}}';
    }

    public static function primaryKey()
    {
        return ['id'];
    }

    public function rules()
    {
        return [
            [['language', 'thumbnail'], 'safe'],
            [['category_detail'], 'trim'],
            ['image', 'image', 'extensions' => 'jpg, jpeg'], //'png, jpg, jpeg, gif'
            ['pre_image', 'image', 'extensions' => 'jpg, jpeg'], //'png, jpg, jpeg, gif'
            ['tagNames', 'safe'],
            ['to_main', 'integer', 'max' => 1],
            [['rating', 'rating_to_main'], 'integer'],

            ['slug', 'match', 'pattern' => self::$SLUG_PATTERN, 'message' => Yii::t('easyii', 'Slug can contain only 0-9, a-z and "-" characters (max: 128).')],
            ['slug', 'default', 'value' => null],
            ['slug', 'unique'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'thumbnail' => 'Миниатюра',
            'publish_date' => 'Дата публикации',
        ];
    }

    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'taggabble' => Taggable::className(),
//            'sluggable' => [
//                'class' => MySluggableBehavior::className(),
//                'attribute' => 'title',
//                'ensureUnique' => true
//            ],
            'imageUploaderBehavior' => [
                'class' => 'common\behaviors\ImageUploaderBehavior',
                'imageConfig' => [
                    // Name of image attribute where the image will be stored
                    'imageAttribute' => 'miniature', //@todo
                    // Yii-alias to dir where will be stored subdirectories with images
                    'savePathAlias' => '@webroot',
                    // Yii-alias to root project dir, relative path to the image will exclude this part of the full path
                    'rootPathAlias' => '@webroot',
                    // Name of default image. Image placed to: webrooot/images/{noImageBaseName}
                    // You must create all noimage files: noimage.jpg, medium_noimage.jpg, small_noimage.jpg, etc.
                    'noImageBaseName' => 'noimage.jpg',
                    // List of thumbnails sizes.
                    // Format: [prefix=>max_width]
                    // Thumbnails height calculated proportionally automatically
                    // Prefix '' is special, it determines the max width of the main image
                    'imageSizes' => [
                        '' => 1000,
                        'medium_' => 270,
                        'small_' => 70,
                        'my_custom_size' => 25,
                    ],
                    // This params will be passed to \yii\validators\ImageValidator
                    'imageValidatorParams' => [
                        'minWidth' => 400,
                        'minHeight' => 300,
                        // Custom validation errors
                        // see more in \yii\validators\ImageValidator::init() and \yii\validators\FileValidator::init()
                        'tooBig' => \Yii::t('yii', 'The file "{file}" is too big. Its size cannot exceed {formattedLimit}.'),
                    ],
                    // Cropper config
                    'aspectRatio' => 4 / 3, // or 16/9(wide) or 1/1(square) or any other ratio. Null - free ratio
                    // default config
                    'imageRequire' => false,
                    'fileTypes' => 'jpg,jpeg,gif,png',
                    'maxFileSize' => 10485760, // 10mb
                    // If backend is located on a subdomain 'admin.', and images are uploaded to a directory
                    // located in the frontend, you can set this param and then getImageSrc() will be return
                    // path to image without subdomain part even in backend part
                    'backendSubdomain' => 'admin.',
                ],
            ],
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->initType();

            $settings = Yii::$app->getModule('admin')->activeModules['page']->settings;
            //$this->short = StringHelper::truncate($settings['enableShort'] ? $this->short : strip_tags($this->text), $settings['shortMaxLength']);

            if(strlen($this->category_detail)>1){
                $categoryData = explode(':',$this->category_detail);
                $this->type_id = $categoryData[0];
                $this->category_id = $categoryData[1];
            }

            if(!$insert && $this->image != $this->oldAttributes['image'] && $this->oldAttributes['image']){
                @unlink(Yii::getAlias('@webroot').$this->oldAttributes['image']);
            }

            return true;
        }

        return false;
    }

    public function afterDelete() //@todd check errors
    {
        parent::afterDelete();

        if($this->image){
            @unlink(Yii::getAlias('@webroot').$this->image);
        }

        //foreach($this->getPhotos()->all() as $photo){
        //    $photo->delete();
        //}
    }

    public static function findContent(){
        return Content::find()->joinWith('translation');
    }


    public function afterFind()
    {
        if (is_null($this->miniature)) {
            //$this->miniature = ($this->_findImage()) ? $this->_findImage() : $this->image;

            //$this->miniature = $this->_findImage(); //@todo miniature
        }




        if (is_null($this->_name)) {
//            if($this->type==false){
//                $this->initType();
//            }

            if(!empty($this->translations)){
                foreach ($this->translations as $language => $translation) {
                    if ($translation->name) {
                        $this->_name = $translation->name;
                        $this->_edit_link = Url::to(['/admin/'.$this->type.'/default/edit', 'id' => $this->id, 'language' => $language]);
                        break;
                    }
                }
            }else{
                $this->_edit_link = Url::to(['/admin/'.$this->type.'/default/edit', 'id' => $this->id]);
            }

        }

        parent::afterFind();

        //$this->title = $this->getName(); //@todo xxxxxxxxxxxxxxxxxxxxxxxxxx
    }

    public function getTitle()
    {
        return $this->_name;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function getEditLink()
    {
        return $this->_edit_link;
    }


    private static function getModelClassName(){
        if(static::$_translateModel){
            return static::$_translateModel;
        }

        return ContentTranslation::className();
    }

    public function getTranslations()
    {
        return $this->hasMany(self::getModelClassName(), ['content_id' => 'id'])
            ->indexBy('language');
    }

    public function getImages()
    {
        return $this->hasMany(ContentImage::className(), ['content_id' => 'id']);
    }

    private function _findImage($imageId = false, $size = [], $mode = ImageInterface::THUMBNAIL_OUTBOUND)
    {
        $imageId = (empty($imageId)) ? $this->thumbnail : $imageId;
        return Attachment::getImage($imageId, $size, $mode);
    }

    public function getTranslation()
    {
        return $this->hasOne(self::getModelClassName(), ['content_id' => 'id'])
            //->andOnCondition([ContentTranslation::tableName() . '.language' => Yii::$app->language]);
            ->where([
                //ContentTranslation::tableName() . '.public_status' => Content::STATUS_ON,
                ContentTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function getTranslationByStatus()
    {
        return $this->hasOne(self::getModelClassName(), ['content_id' => 'id'])
            //->andOnCondition([ContentTranslation::tableName() . '.language' => Yii::$app->language]);
            ->where([
                ContentTranslation::tableName() . '.public_status' => Content::STATUS_ON,
                ContentTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    protected function initType(){
        if(static::$_type){
            $this->type = static::$_type;
            //e_print(static::$_type,'static');
        }else{
            $this->type = self::$_type;
            //e_print(self::$_type,'self');
        }
    }

    public function getDate(){
        return date('Y-m-d', $this->time);
    }

    public function getDatetime(){
        return date('Y-m-d H:i:s', $this->time);
    }
}
