<?php

namespace backend\models;

use backend\modules\attachment\models\Attachment;
use Imagine\Image\ImageInterface;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Url;

/**
 * Class News
 * @package backend\modules\news\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property string $type
 * @property int $publish_date
 *
 * @property ContentTranslation|array $translations
 */
class Content extends ActiveRecord
{
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    public $language = 'ru-RU';

    protected $_title = null;
    protected $_edit_link = null;

    protected static $_type = 'content';
    protected static $_translateModel;


    public $image;

    /**
     * @return string the name of the table associated with this ActiveRecord class.
     */
    public static function tableName()
    {
        return '{{content}}';
    }


    public function behaviors()
    {
        return [
            'imageUploaderBehavior' => [
                'class' => 'backend\behavior\ImageUploaderBehavior',
                'imageConfig' => [
                    // Name of image attribute where the image will be stored
                    'imageAttribute' => 'image', //@todo
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

    public static function findContent(){
        return Content::find()->joinWith('translation');
    }


    public function afterFind()
    {
        if (is_null($this->image)) {
            $this->image = $this->_findImage();
        }

        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/'.$this->type.'/default/edit', 'id' => $this->id, 'language' => $language]);
                    break;
                }
            }
        }

        parent::afterFind();
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getEditLink()
    {
        return $this->_edit_link;
    }

    public function rules()
    {
        return [
            [['language', 'thumbnail'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'thumbnail' => 'Миниатюра',
            'publish_date' => 'Дата публикации',
        ];
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
            //->andOnCondition([ContentTranslation::tableName() . '.language' => Yii::$app->language])
            ->where([
                ContentTranslation::tableName() . '.status' => Content::STATUS_PUBLISHED,
                ContentTranslation::tableName() . '.language' => Yii::$app->language
            ]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->initType();

            return true;
        }

        return false;
    }

    protected function initType(){
        if(static::$_type){
            $this->type = static::$_type;
        }else{
            $this->type = self::$_type;
        }
    }
}
