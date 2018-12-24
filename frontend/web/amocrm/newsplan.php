<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dangel
 * Date: 17.12.2018
 * Time: 12:40
 */
use common\helpers\Telegram;
use frontend\modules\novanews\models\Novanews;
use frontend\modules\novanews\models\NovanewsTranslation;
use frontend\helpers\Image;



//$timeNow = date('Y-m-d');
$timeNow = date('2018-12-31');
$models = Novanews::items(['where' => ['publish_date'=>$timeNow]]);

foreach ($models as $model){
    $title = $model->translations[1]->name;
    $description = (!empty($model->translations[1]->meta_description)) ? $model->translation->meta_description : '';

    //$img = (isset($model->image) && !empty($model->image)) ? Image::thumb($model->image, 800, 200) : Image::thumb($model->pre_image, 800, 450);
    $img = Image::thumb($model->pre_image, 800, 450);
    $img = Url::base('https') . $img;

    $link = Url::base('https') . '/news/'. $model->slug ;
    $text = "<a href='".trim($img)."'>✉</a>\n<a href='".$link."'>".trim($title)."</a>\n".trim($description);

    // Telegram::sendMessage($text);

    $translation = $model->translations[1];
    $translation->public_status= Novanews::STATUS_ON;
    $translation->save(false);
    $model->post_telegram = 1;
    $model->save(false);

}

