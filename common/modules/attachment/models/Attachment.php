<?php

namespace common\modules\attachment\models;

use Imagine\Image\Box;
use Imagine\Image\ImageInterface;
use Imagine\Image\Point;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\imagine\Image as Imagine;
use yii\web\UploadedFile;

/**
 * Class Attachment
 * @package common\modules\attachment\models
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $created_at
 * @property int $updated_at
 *
 * @property AttachmentTranslation|array $translations
 */
class Attachment extends ActiveRecord
{
    const UPLOAD_URL = '@web/uploads';
    const UPLOAD_PATH = '@webroot/uploads';
    const CACHE_URL = '@web/image_cache';
    const CACHE_PATH = '@webroot/image_cache';

    const ADMIN_PAGE_LIMIT = 60;
    const STATUS_DRAFT = 0;
    const STATUS_PUBLISHED = 1;

    private static $_imageMaxLength = 1600;
    private static $_imageQuality = 90;

    public $language = 'ru-RU';
    
    /**
     * @var UploadedFile
     */
    public $file;
    private $_title = null;

    static public function getImage($image, $size = [], $mode = ImageInterface::THUMBNAIL_OUTBOUND)
    {
        /**
         * @var Attachment $image
         */
        $image = static::findOne($image);
        $image = $image ? $image->name : '';

        if (!$image) {
            return '';
        } elseif (empty($size)) {
            return Yii::getAlias(static::UPLOAD_URL . '/' . $image);
        } else {
            if (!isset($size[1])) {
                $size[1] = $size[0];
//                $mode = ImageInterface::THUMBNAIL_INSET;
            }

            //$image = explode('/', $image);
            $image_path = Yii::getAlias(static::UPLOAD_PATH . '/' . $image);
            $dist_path = Yii::getAlias(static::CACHE_PATH . '/');
            $dist_image_path = Yii::getAlias($dist_path . '/' . $size[0] . 'x' . $size[1] . '-' . $image);

            if (!is_file($image_path)) {
                return '';
            }

            if (!is_file($dist_image_path)) {
                FileHelper::createDirectory($dist_path);

                Imagine::getImagine()->open($image_path)->thumbnail(new Box($size[0], $size[1]), $mode)->save($dist_image_path, ['quality' => self::$_imageQuality]);
            }

            return Yii::getAlias(static::CACHE_URL . '/' . $size[0] . 'x' . $size[1] . '-' . $image);
        }
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
//            'galleryBehavior' => [
//                'class' => GalleryBehavior::className(),
//                'type' => 'product',
//                'extension' => 'jpg',
//                'directory' => Yii::getAlias('@webroot') . '/uploads/product/gallery',
//                'url' => Yii::getA$this->alias('@web') . '/uploads/product/gallery',
//                'versions' => [
//                    'small' => function ($img) {
//                        /** @var ImageInterface $img */
//                        return $img
//                            ->copy()
//                            ->thumbnail(new Box(200, 200));
//                    },
//                    'medium' => function ($img) {
//                        /** @var ImageInterface $img */
//                        $dstSize = $img->getSize();
//                        $maxWidth = 800;
//                        if ($dstSize->getWidth() > $maxWidth) {
//                            $dstSize = $dstSize->widen($maxWidth);
//                        }
//                        return $img
//                            ->copy()
//                            ->resize($dstSize);
//                    },
//                ]
//            ],

//            'imageUploaderBehavior' => [
//                'class' => 'demi\image\ImageUploaderBehavior',
//                'imageConfig' => [
//                    // Name of image attribute where the image will be stored
//                    'imageAttribute' => 'image',
//                    // Yii-alias to dir where will be stored subdirectories with images
//                    'savePathAlias' => '@frontend/web/uploads/products',
//                    // Yii-alias to root project dir, relative path to the image will exclude this part of the full path
//                    'rootPathAlias' => '@frontend/web',
//                    // Name of default image. Image placed to: webrooot/images/{noImageBaseName}
//                    // You must create all noimage files: noimage.jpg, medium_noimage.jpg, small_noimage.jpg, etc.
//                    'noImageBaseName' => 'noimage.jpg',
//                    // List of thumbnails sizes.
//                    // Format: [prefix=>max_width]
//                    // Thumbnails height calculated proportionally automatically
//                    // Prefix '' is special, it determines the max width of the main image
//                    'imageSizes' => [
//                        '' => 1000,
//                        'medium_' => 270,
//                        'small_' => 70,
//                        'my_custom_size' => 25,
//                    ],
//                    // This params will be passed to \yii\validators\ImageValidator
//                    'imageValidatorParams' => [
//                        'minWidth' => 400,
//                        'minHeight' => 300,
//                        // Custom validation errors
//                        // see more in \yii\validators\ImageValidator::init() and \yii\validators\FileValidator::init()
//                        'tooBig' => Yii::t('yii', 'The file "{file}" is too big. Its size cannot exceed {formattedLimit}.'),
//                    ],
//                    // Cropper config
//                    'aspectRatio' => 4 / 3, // or 16/9(wide) or 1/1(square) or any other ratio. Null - free ratio
//                    // default config
//                    'imageRequire' => false,
//                    'fileTypes' => 'jpg,jpeg,gif,png',
//                    'maxFileSize' => 10485760, // 10mb
//                    // If backend is located on a subdomain 'admin.', and images are uploaded to a directory
//                    // located in the frontend, you can set this param and then getImageSrc() will be return
//                    // path to image without subdomain part even in backend part
//                    'backendSubdomain' => 'admin.',
//                ],
//            ],
        ];
    }

    public function rules()
    {
        return [
            [['file'], 'file',  'extensions' => 'png, jpg, gif, jpeg', 'skipOnEmpty' => false],
            [['name', 'type'], 'safe']
        ];
    }

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    break;
                }
            }
        }

        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $saveFile = FileHelper::normalizePath(Yii::getAlias(self::UPLOAD_PATH)) . DIRECTORY_SEPARATOR . $this->name;

            if (!$this->file->saveAs($saveFile)) {
                return false; // @todo ERROR CODE
            }

            return true;
        }
        return false;
    }

//    public function afterSave($insert, $changedAttributes)
//    {
//        //$pathToSaveImage = Yii::getAlias('@path/to/save/image');
//        $pathToSaveImage = Yii::getAlias(static::UPLOAD_URL);
//        var_dump($pathToSaveImage);exit;
//
//        // open image
//        $image = Image::getImagine()->open($this->image->tempName);
//
//        // rendering information about crop of ONE option
//        $cropInfo = Json::decode($this->crop_info)[0];
//        $cropInfo['dWidth'] = (int)$cropInfo['dWidth']; //new width image
//        $cropInfo['dHeight'] = (int)$cropInfo['dHeight']; //new height image
//        $cropInfo['x'] = $cropInfo['x']; //begin position of frame crop by X
//        $cropInfo['y'] = $cropInfo['y']; //begin position of frame crop by Y
//        // Properties bolow we don't use in this example
//        //$cropInfo['ratio'] = $cropInfo['ratio'] == 0 ? 1.0 : (float)$cropInfo['ratio']; //ratio image.
//        //$cropInfo['width'] = (int)$cropInfo['width']; //width of cropped image
//        //$cropInfo['height'] = (int)$cropInfo['height']; //height of cropped image
//        //$cropInfo['sWidth'] = (int)$cropInfo['sWidth']; //width of source image
//        //$cropInfo['sHeight'] = (int)$cropInfo['sHeight']; //height of source image
//
//        //delete old images
//        $oldImages = FileHelper::findFiles($pathToSaveImage, [
//            'only' => [
//                $this->id . '.*',
//                'thumb_' . $this->id . '.*',
//            ],
//        ]);
//        for ($i = 0; $i != count($oldImages); $i++) {
//            @unlink($oldImages[$i]);
//        }
//
//        //saving thumbnail
//        $newSizeThumb = new Box($cropInfo['dWidth'], $cropInfo['dHeight']);
//        $cropSizeThumb = new Box(200, 200); //frame size of crop
//        $cropPointThumb = new Point($cropInfo['x'], $cropInfo['y']);
//        $pathThumbImage = $pathToSaveImage
//            . '/thumb_'
//            . $this->id
//            . '.'
//            . $this->image->getExtension();
//
//        $image->resize($newSizeThumb)
//            ->crop($cropPointThumb, $cropSizeThumb)
//            ->save($pathThumbImage, ['quality' => 100]);
//
//        //saving original
//        $this->image->saveAs(
//            $pathToSaveImage
//            . '/'
//            . $this->id
//            . '.'
//            . $this->image->getExtension()
//        );
//    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $saveFile = FileHelper::normalizePath(Yii::getAlias(self::UPLOAD_PATH)) . DIRECTORY_SEPARATOR . $this->name;
        //Image::resizeByMaxLength($saveFile, self::$_imageMaxLength, ['quality' => 80], FileHelper::normalizePath(Yii::getAlias('@webroot/uploadsnew2')) . DIRECTORY_SEPARATOR. $model_file_name);

        \frontend\components\Image::resizeByMaxLength($saveFile, self::$_imageMaxLength, ['quality' => self::$_imageQuality]);
        //Image::resizeByMaxLength($saveFile, self::$_imageMaxLength);

    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function setTitle($title)
    {
        $this->_title = $title;
    }

    public function getEditLink()
    {
        return $this->_edit_link;
    }

    public function attributeLabels()
    {
        return [
            'thumbnail' => 'Миниатюра',
            'publish_date' => 'Дата публикации',
        ];
    }

    public function getTranslations()
    {
        return $this->hasMany(AttachmentTranslation::className(), ['attachment_id' => 'id'])->indexBy('language');
    }

    public static function setImageMaxLength($length){
        self::$_imageMaxLength = (int) $length;
    }

    public static function setImageQ($length){
        self::$_imageMaxLength = (int) $length;
    }
}
