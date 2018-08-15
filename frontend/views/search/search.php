<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = 'Поиск';
$this->params['breadcrumbs'][] = $this->title;

$this->params['search'] = $search;


?>
<section>
    <div class="container">
        <?php foreach ($items as $item) : ?>
        <?php
            if(strpos($item['type'],'news',0)!==false){
                $item['slug_category'] = 'news';
            }

            ?>
        <div class="row">
            <div class="col-sm-3 col-md-3 no-padding">
                <div class="padv-5">
                    <?php if (!empty($item['image'])) : ?>
                        <a href="<?= \yii\helpers\Url::to($item['slug_category'] . '/'.$item['slug']) ?>"><?= Html::img(\frontend\helpers\Image::thumb($item['image'], 300, 150), ['width' => '100%', 'height' => '100%']) ?></a>
                    <?php elseif (!empty($item['pre_image'])) : ?>
                        <a href="<?= \yii\helpers\Url::to($item['slug_category'] . '/'.$item['slug']) ?>"><?= Html::img(\frontend\helpers\Image::thumb($item['pre_image'], 300, 150), ['width' => '100%', 'height' => '100%']) ?></a>
                    <? endif ?>
                </div>
            </div>
            <div class="col-sm-8 col-md-8">
                <div><a href="<?= \yii\helpers\Url::to($item['slug_category'] . '/'.$item['slug']) ?>"><h6><?= $item['name'] ?></h6></a></div>
                <div>
                    <p>
                        <?= yii\helpers\StringHelper::truncate(strip_tags($item['meta_description']), 600,'...') ?>
                    </p>
                </div>
            </div>
        </div>
        <? endforeach ?>
        <? if($pages): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="pagination">
                    <?=$pages?>
                </div>
            </div>
        </div>
        <? endif;?>
    </div>
</section>
