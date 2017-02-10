<?php
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-news');

if(!empty($page)) $this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>


<div class="container">
    <? if(!empty($page)): ?> <h1> <?=$page->seo('h1', $page->title) ?> </h1> <? endif ?>
    <?php if($page->text): ?><div><?= $page->seo('div', $page->text) ?></div><? endif; ?>
</div>

<section class="content-zone top20">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <div class="recent-news">
                    <div class="remove-ext">
                        <div class="row">
                            <?php foreach ($news as $item) : ?>
                                <div class="col-md-6">
                                    <div class="recentnew-post">
                                        <a href="<?= Url::to(['news/'.$item->slug]) ?>" class="">
                                            <?= Html::img($item->thumb(420, 314)) ?>
                                        </a>
                                        <div class="recentnew-detail2">
                                            <h4>
                                                <?= Html::a($item->title, ['news/view', 'slug' => $item->slug]) ?>
                                            </h4>
                                            <ul class="post-meta">
                                                <li><i class="fa fa-calendar"></i> <?= $item->date ?></li>
                                                <li><i class="fa fa-user"></i> By <a href="#" title="">Admin</a></li>
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
                    <?= Page::pages() ?>
                </div>
                <!-- Pagination -->
            </div>
            <div class="col-md-3">
                <div class="sidebar">
                    <div class="widget widget-categories">
                        <div class="title1 style2">
                            <h2>Категории</h2>
                            <!-- <span>We Provide Best Services</span>-->
                        </div>
                        <ul>
                            <?php foreach($categories_tops as $item) : ?>
                                <li><a href="<?= Url::to(['news/c/'.$item['slug']]) ?>"><?= $item['title'] ?></a> <span><?= $item['counter'] ?></span></li>
                            <?php endforeach; ?>
                        </ul>
                    </div><!-- Widget -->
                    <div class="widget villa-photos-widget">
                        <div class="title1 style2">
                            <h2>Хорошие предложения</h2>
                            <span>Интересные страны для бизнеса</span>
                        </div>
                        <ul class="widget-gallery">
                            <?php foreach($top_offers as $item) : ?>
                                <li><a href="<?= Url::to(['news/c/'.$item['slug']]) ?>">
                                        <?= Html::img(\frontend\helpers\Image::thumb($item['image'], 300, 200)) ?>
                                    </a>
                                    <span><a href="<?= Url::to(['news/c/'.$item['slug']]) ?>"><?= $item['title'] ?></a></span></li>
                            <?php endforeach; ?>

                        </ul>
                    </div><!-- Widget -->
                    <!-- Widget2 -->
                    <div class="widget villa-photos-widget">
                        <div class="title1 style2">
                            <h2>Банки</h2>
                            <span>Лучшие банковские условия</span>
                        </div>
                        <ul class="widget-gallery">
                            <?php foreach($top_banks as $item) : ?>
                                <li><a href="<?= Url::to(['news/c/'.$item['slug']]) ?>">
                                        <?= Html::img(\frontend\helpers\Image::thumb($item['image'], 300, 200)) ?>
                                    </a>
                                    <span><a href="<?= Url::to(['news/c/'.$item['slug']]) ?>"><?= $item['title'] ?></a></span> </li>
                            <?php endforeach; ?>

                        </ul>
                    </div><!-- Widget2 -->
                    <div class="widget tags-widget">
                        <div class="title1 style2">
                            <h2>Облако тегов</h2>
                            <!--<span>We Provide Best Services</span>-->
                        </div>
                        <div class="tags">
                            <ul class="cate-list">
                                <?php foreach($top_tags as $item) : ?>
                                    <li><a href="<?= Url::to(['news/tag/'.$item['name']]) ?>" class="label label-info"><?= $item['name'] ?></a></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div><!-- Widget -->
                    <div class="widget recent-posts-widget">
                        <div class="title1 style2">
                            <h2>Интересные статьи</h2>
                            <span>Популярные новости</span>
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