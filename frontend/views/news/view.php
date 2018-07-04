<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

/**
 * @var \frontend\modules\novanews\api\NovanewsObject $news
 */

$this->title = $news->seo('title', $news->title);
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news']];
$this->params['breadcrumbs'][] = $news->title;
?>

<style>
    @media (max-width: 1024px) {
        .sidebar {
            display: none !important;

        }
    }
</style>
<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villarecent-blog">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="blog-post2">
                                    <?php if(isset($news->image) && !empty($news->image)): ?>
                                        <?= Html::img(Image::thumb($news->image, 800, 200)) ?>
                                    <?php else: ?>
                                        <?= Html::img(Image::thumb($news->model->pre_image, 800, 450)) ?>
                                    <?php endif; ?>

                                    <div class="blogpost-detail">
                                        <ul class="post-meta style2">
                                            <li><i class="fa fa-calendar"></i> <?= $news->date ?></li>
                                            <li><i class="fa fa-comment"></i><a href="#" title="">Прочитали <?= $news->views * 3 ?> человек</a></li>
                                        </ul>

                                        <h1><?= $news->seo('h1', $news->title) ?></h1>

                                        <div class="text-con">
                                            <?= $news->getDescription() ?>
                                        </div>

                                        <div class="tags-social">
                                            <div class="tags">
                                                <ul class="cate-list">
                                                    <?php foreach($news->tags as $tag) : ?>
                                                        <li><a href="<?= Url::to(['/news/tag/'.$tag]) ?>" class="label label-info"><?= $tag ?></a></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                            <div class="social-btns">
                                                <ul>
                                                    <li><a href="#" title=""><i class="fa fa-facebook"></i></a></li>
                                                    <li><a href="#" title=""><i class="fa fa-linkedin"></i></a></li>
                                                    <li><a href="#" title=""><i class="fa fa-twitter"></i></a></li>
                                                </ul>
                                            </div>
                                        </div>

                                        <?php if(count($news->photos)) : ?>
                                        <div class="comments-sec">
                                            <h2 class="title2"><span><?php echo count($news->photos);?></span> Photos</h2>
                                                <ul class="list-inline">
                                                    <?php foreach($news->photos as $photo) : ?>
                                                    <li><?= $photo->box(160, 120) ?></li>
                                                    <?php endforeach;?>
                                                </ul>
                                        </div>
                                        <?php endif; ?>

                                        <?php \frontend\modules\novanews\api\Novanews::plugin() ?>
                                    </div>
                                </div>
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
                                    <?php if(isset($top_offers) && count($top_offers)>0): ?>
                                    <div class="widget villa-photos-widget">
                                        <div class="title1 style2">
                                            <h2>Хорошие предложения</h2>
                                            <span>Интересные страны для бизнеса</span>
                                        </div>
                                        <ul class="widget-gallery">
                                            <?php foreach($top_offers as $item) : ?>
                                                <li><a href="<?= Url::to(['offers/'.$item->slug]) ?>">
                                                        <?= Html::img(Image::thumb($item->image, 240, 180)) ?>
                                                    </a>
                                                    <span><a href="<?= Url::to(['offers/'.$item->slug]) ?>"><?= $item->title ?></a></span></li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div><!-- Widget -->
                                    <? endif; ?>
                                    <?php if(isset($top_banks) && count($top_banks)>0): ?>
                                    <!-- Widget2 -->
                                    <div class="widget villa-photos-widget">
                                        <div class="title1 style2">
                                            <h2>Банки</h2>
                                            <span>Лучшие банковские условия</span>
                                        </div>
                                        <ul class="widget-gallery">
                                            <?php foreach($top_banks as $item) : ?>
                                                <li><a href="<?= Url::to(['banks/'.$item->slug]) ?>">
                                                        <?= Html::img(Image::thumb($item->image, 240, 180)) ?>
                                                    </a>
                                                    <span><a href="<?= Url::to(['banks/'.$item->slug]) ?>"><?= $item->title ?></a></span> </li>
                                            <?php endforeach; ?>

                                        </ul>
                                    </div><!-- Widget -->
                                    <? endif; ?>
                                    <?php if(isset($top_banks) && count($top_banks)>0): ?>
                                    <div class="widget recent-posts-widget">
                                        <div class="title1 style2">
                                            <h2>Интересные статьи</h2>
                                            <span>Популярные новости</span>
                                        </div>
                                        <div class="recent-posts">
                                        <?php foreach($top_news as $item) : ?>
                                            <div class="recent-post">
                                                <?= Html::img(Image::thumb($item->image, 90, 90)) ?>
                                                <h4><a href="<?= Url::to(['news/'.$item->slug]) ?>"><?= $item->title ?></a></h4>
                                                <span><i class="fa fa-calendar"></i> <?= $item->date ?></span>
                                            </div>
                                        <?php endforeach; ?>

                                        </div>
                                    </div><!-- Widget -->
                                    <? endif; ?>

                                </div><!-- Sidebar -->
                            </div>
                        </div>
                    </div><!-- Villa Recent Blog -->
                </div>
            </div>
        </div>
    </div>
</section>

