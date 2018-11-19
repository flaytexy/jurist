<?php

namespace frontend\modules\Licenses\models;

use common\behaviors\MySluggableBehavior;
use common\models\Content;
use frontend\behaviors\CountryAble;
use frontend\behaviors\Optionable;
use frontend\behaviors\SeoBehavior;
use frontend\behaviors\Taggable;

/**
 * Class Licenses
 * @package frontend\modules\Licenses\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property int $publish_date
 * @property string $image
 * @property Offers $offer
 *
 * @property LicensesTranslation|array $translations
 */
class Licenses extends Content
{
    const PAGE_LIMIT = 7;
    const TYPE_ID = 201;

    public static $_type = 'Licenses';

    public function init()
    {
        self::$_translateModel = LicensesTranslation::className();
    }


    public function behaviors()
    {
        return [
            'seoBehavior' => SeoBehavior::className(),
            'taggabble' => Taggable::className(),
            'optionabble' => Optionable::className(),
//            'sluggable' => [
//                'class' => MySluggableBehavior::className(),
//                'attribute' => 'title',
//                'ensureUnique' => true
//            ],
            'countryable' => CountryAble::className(),
            //'CountriesBehavior' => CountriesBehavior::className(),
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
                    'aspectRatio' => 16 / 9, // or 16/9(wide) or 1/1(square) or any other ratio. Null - free ratio
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

    public function getChild() {
        return $this->getOffer();
    }

    public function getOffer() {
        return $this->hasOne(Offers::className(), ['content_id' => 'id']);
    }
}
