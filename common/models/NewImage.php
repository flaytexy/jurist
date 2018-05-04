<?php

namespace common\models;

use Yii;
use Imagine\Image\Box;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\imagine\Image as Imagine;
use Imagine\Image\ImageInterface;

class NewImage
{
    const UPLOAD_URL = '@web/uploads';
    const UPLOAD_PATH = '@webroot/uploads';
    const CACHE_URL = '@web/image_cache';
    const CACHE_PATH = '@webroot/image_cache';

    static public function upload($uploadedFile)
    {
        if ($uploadedFile instanceof UploadedFile) {
            $file_name = explode(DIRECTORY_SEPARATOR, substr_replace(
                md5_file($uploadedFile->tempName) . '.' . $uploadedFile->extension,
                DIRECTORY_SEPARATOR,
                2,
                0
            ));

            if (!is_dir($dir = Yii::getAlias(static::UPLOAD_PATH . DIRECTORY_SEPARATOR . $file_name[0]))) {
                FileHelper::createDirectory($dir);
            }

            if ($uploadedFile->saveAs($dir . DIRECTORY_SEPARATOR . $file_name[1])) {
                return implode(DIRECTORY_SEPARATOR, $file_name);
            }
        }

        return '';
    }

    static public function get($image, $size = [], $mode = ImageInterface::THUMBNAIL_OUTBOUND)
    {
        if (!$image) {
            return '';
        } elseif (empty($size)) {
            return Yii::getAlias(static::UPLOAD_URL . '/' . $image);
        } else {
            if (!isset($size[1])) {
                $size[1] = $size[0];
//                $mode = ImageInterface::THUMBNAIL_INSET;
            }

            $image = explode('/', $image);
            $image_path = Yii::getAlias(static::UPLOAD_PATH . '/' . $image[0] . '/' . $image[1]);
            $dist_path = Yii::getAlias(static::CACHE_PATH . '/' . $image[0]);
            $dist_image_path = Yii::getAlias($dist_path . '/' . $size[0] . 'x' . $size[1] . '-' . $image[1]);

            if (!is_file($image_path)) {
                return '';
            }

            if (!is_file($dist_image_path)) {
                FileHelper::createDirectory($dist_path);

                Imagine::getImagine()->open($image_path)->thumbnail(new Box($size[0], $size[1]), $mode)->save($dist_image_path , ['quality' => 90]);
            }

            return Yii::getAlias(static::CACHE_URL . '/' . $image[0] . '/' . $size[0] . 'x' . $size[1] . '-' . $image[1]);
        }
    }
}