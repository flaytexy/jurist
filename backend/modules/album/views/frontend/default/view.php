<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\album\models\Album $model
 * @var \backend\modules\album\models\Album $next
 */

use yii\helpers\Url;
use backend\modules\attachment\models\Attachment;

$secImages = $model['images'];
$firstImage = array_shift($secImages);
$secImages[] = $firstImage;


?>

<section class="photo_page">
    <div class="overlay"></div>
    <div class="photo__title">
        <p>Photo</p>
    </div>
    <div class="photo_open__main">
        <div class="photo_open__left">
            <?php $i = 0 ?>
            <?php foreach ($model['images'] as $image) { ?>
                    <img <?php if ($i==0):  ?>class="active_photo"<? endif; ?>  src="<?= Attachment::getImage($image['attachment_id'], [600,400]); ?>" alt="" />
                <?php $i++ ?>
            <?php } ?>
        </div>
        <div class="photo_open__right">
            <?php $i = 0 ?>
            <?php foreach ($secImages as $image) { ?>
                <img <?php if ($i==0):  ?>class="active_photo"<? endif; ?>  src="<?= Attachment::getImage($image['attachment_id'], [300,200]); ?>" alt="" />
                <?php $i++ ?>
            <?php } ?>
        </div>
        <div class="photo_open__nav">
            <div class="nav_back"></div>
            <div class="nav_next"></div>
        </div>
    </div>
</section>
