<?php use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;
?>
<div class="widget villa-photos-widget top20">
    <div class="title1 style2">
        <h2><?= Yii::t('easyii', 'topBanks') ?></h2>
        <span><?= Yii::t('easyii', 'bestTerm') ?></span>
    </div>
    <ul class="widget-gallery">
        <?php if ($bankNum > count($banks))  $bankNum = count($banks);
        for ($i=1; $i<$bankNum; $i++) {?>
            <li><a href="<?= Url::to(['banks/'.$banks[$i]->slug]) ?>">
                    <?= Html::img(Image::thumb($banks[$i]->image, 332, 83)) ?>
                </a>
            </li>
        <?php } ?>
    </ul>
</div>
