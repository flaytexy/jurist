<?php
//use frontend\modules\novanews\api\Novanews as Page;

/**
 * @var \frontend\modules\novanews\api\NovanewsObject $page
 * @var \frontend\modules\novanews\api\NovanewsObject[] $news
 */

use frontend\helpers\Image;

use yii\helpers\Html;
use yii\helpers\Url;


if(!empty($page)) $this->title = $page->seo('title', $page->title);
$this->params['breadcrumbs'][] = $page->title;

?>


<div class="container">
    <? if(!empty($page)): ?> <h1> <?=$page->seo('h1', $page->title) ?> </h1> <? endif ?>
</div>

<section class="content-zone top20" id="new-index">
    <div class="container">
        <div class="row">
            <div class="col-md-9 col-sm-12">
                <div class="recent-news">
                    <div class="remove-ext">
                        <div class="row">
                            <?php foreach ($news as $item) : ?>
                                <div class="col-md-6">
                                    <div class="recentnew-post">
                                        <a href="<?= Url::to(['news/'.$item->slug]) ?>" class="">
                                            <?php if(isset($item->model->pre_image) && !empty($item->model->pre_image)): ?>
                                                <?= Html::img(Image::thumb($item->model->pre_image, 320, 180)) ?>
                                            <?php else: ?>
                                                <?= Html::img(Image::thumb($item->model->image, 320, 180)) ?>
                                            <?php endif; ?>
                                        </a>
                                        <div class="recentnew-detail2">
                                            <h4>
                                                <?= Html::a($item->title, ['news/view', 'slug' => $item->slug]) ?>
                                            </h4>
                                            <ul class="post-meta">
                                                <li><i class="fa fa-calendar"></i> <?= $item->date ?></li>
                                               <!--<li><i class="fa fa-user"></i> By <a href="#" title="">Admin</a></li>-->
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- Recent Pages -->
                <div id="pagination">
                    <?= \frontend\modules\novanews\api\Novanews::pages() ?>
                </div>
                <!-- Pagination -->

                <?php if($page->text): ?><div><?= $page->text; ?></div><? endif; ?>
            </div>
            <div class="col-md-3 col-sm-4">
                <div class="sidebar">
                    <div class="widget widget-categories">
                        <div class="title1 style2">
                            <h2><?= Yii::t('easyii', 'Categories') ?></h2>
                            <!-- <span>We Provide Best Services</span>-->
                        </div>
                        <ul>
                            <?php foreach($categories_tops as $item) : ?>
                                <li><a href="<?= Url::to(['news-category/'.$item['slug']]) ?>"><?= $item['title'] ?></a> <span><?= $item['counter'] ?></span></li>
                            <?php endforeach; ?>
                        </ul>
                    </div><!-- Widget -->
                    <?php if(isset($top_offers)) :?>
                    <div class="widget villa-photos-widget">
                        <div class="title1 style2">
                            <h2><?= Yii::t('easyii', 'goodPropositions') ?></h2>
                            <span><?= Yii::t('easyii', 'interestingCountries') ?></span>
                        </div>
                        <ul class="widget-gallery">
                            <?php foreach($top_offers as $item) : ?>
                                <li><a href="<?= Url::to(['offers/'.$item->slug]) ?>">
                                        <?= Html::img(Image::thumb($item->image, 300, 200)) ?>
                                    </a>
                                    <span><a href="<?= Url::to(['offers/'.$item->slug]) ?>"><?= $item->title ?></a></span></li>
                            <?php endforeach; ?>
                        </ul>
                    </div><!-- Widget -->
                    <? endif; ?>

                    <?php if(isset($top_banks)) :?>
                    <!-- Widget2 -->
                    <div class="widget villa-photos-widget widget-bank">
                        <div class="title1 style2">
                            <h2><?= Yii::t('easyii', 'topBanks') ?></h2>
                            <span><?= Yii::t('easyii', 'bestTerm') ?></span>
                        </div>
                        <ul class="widget-gallery">
                            <?php foreach($top_banks as $item) : ?>
                                <li><a href="<?= Url::to(['banks/'.$item->slug]) ?>" title="<?= $item->title ?>">
                                        <?php if(isset($item->pre_image) && !empty($item->pre_image)): ?>
                                            <?= Html::img(Image::thumb($item->pre_image, 332, 83)) ?>
                                        <?php else: ?>
                                            <?= Html::img(Image::thumb($item->image, 332, 83)) ?>
                                        <?php endif; ?>
                                    </a></li>
                            <?php endforeach; ?>

                        </ul>
                    </div><!-- Widget2 -->
                    <? endif; ?>

                    <div class="widget recent-posts-widget">
                        <div class="title1 style2">
                            <h2><?= Yii::t('easyii', 'articles') ?> </h2>
                            <span><?= Yii::t('easyii', 'popularNews') ?> </span>
                        </div>
                        <div class="recent-posts">
                            <?php foreach($top_news as $item) : ?>
                                <div class="recent-post">
                                    <?= Html::img(\frontend\helpers\Image::thumb($item->image, 90, 90)) ?>
                                    <h4><a href="<?= Url::to(['news/'.$item->slug]) ?>"><?= $item->title ?></a></h4>
                                    <span><i class="fa fa-calendar"></i> <?= $item->date ?></span>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div><!-- Widget -->
                </div><!-- Sidebar -->
            </div>
        </div>
    </div>

</section>
<style>
    @media (max-width: 1024px) {
        .sidebar {
            display: none !important;

        }
    }
</style>