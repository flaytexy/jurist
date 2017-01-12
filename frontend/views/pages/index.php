<?php
use frontend\modules\pages\api\Pages;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\MapsAsset;
use frontend\helpers\Image;

MapsAsset::register($this);
$page = Page::get('page-'.$typeTitle);

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;

?>

<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <div><?= $page->seo('div', $page->text) ?></div>
</div>

<section id="pages">
    <div class="block">
        <div class="container">
            <nav id="menus" class="navbar">
                <div class="navbar-header"><span id="category" class="visible-xs">Перечень офшоров</span>
                    <button type="button" class="btn btn-navbar navbar-toggle" data-toggle="collapse"
                            data-target=".navbar-ex1-collapse"><i class="fa fa-bars"></i></button>
                </div>
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav" id="menu-show-block">
                        <?php foreach ($pages as $item) : ?>
                            <li><a data-show-block="b_<?= $item->id ?>"><?= $item->title ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </nav>
            <div id="menu-show-block-zone" class="" style="display: none;">
                <?php foreach ($pages as $item) : ?>
                    <div id="b_<?= $item->id ?>" class="block-zone row" style="display: none;">
                        <div class="col-md-4">
                            <div class="package-thumb">
                                <?= Html::img($item->thumbFile($item->image, 500, 375), array('class' => 'sadsa')) ?>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <span><b><?= $item->title ?></b></span>
                            <?= $item->short ?>

                            <ul>
                                <?php foreach ($item->properties as $prop) : ?>
                                    <li>
                                        <?= $prop->name ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>

                            <div class="btn abtn">
                                <?= Html::a('Подробнее', ['pages/view', 'slug' => $item->slug], ['class'=>'btn btn-default']) ?>
                            </div>

                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villaeditors-picks">
                        <div class="packages style2 remove-ext2">
                            <div class="row">
                                <?php foreach ($pages as $item) : ?>
                                    <div class="col-md-4">
                                        <div class="package">

                                            <div class="package-thumb">
                                                <?= Html::img($item->thumb(500, 375)) ?>
                                                <span><i>$<?= $item->model->price ?></i> / <? if ($item->model->how_days): ?><?= $item->model->how_days?><? else: ?>Минимал<? endif; ?></span>
                                            </div>
                                            <div class="package-detail">
                                            <span class="cate">
                                                <?php foreach ($item->tags as $tag) : ?>
                                                    <a href="<?= Url::to(['/pages', 'tag' => $tag]) ?>"
                                                       class="label label-info"><?= $tag ?></a>
                                                <?php endforeach; ?>
                                            </span>
                                                <h4><?= Html::a($item->title, ['pages/view', 'slug' => $item->slug]) ?></h4>
                                                <ul class="location-book">
                                                    <li class="active"><i class="fa fa-map-marker"></i>
                                                        <span><?= $item->date ?></span></li>
                                                    <li class="book-btn"><i class="fa fa-thumbs-o-up"></i><a href="#"
                                                                                                             title="">BOOK
                                                            NOW</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Villa Editors Picks -->
                    <div id="pagination">
                        <div><?= Page::pages() ?></div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</section>