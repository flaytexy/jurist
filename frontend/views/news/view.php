<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

/**
 * @var \frontend\modules\novanews\api\NovanewsObject $page
 */

$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['/news']];
$this->params['breadcrumbs'][] = $page->name;

///_____meta
$this->title = $page->seo('meta_title', $page->name);

if($descriptionSeo = $page->seo('meta_description')){
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $descriptionSeo,
    ]);
}

if($keywordsSeo = $page->seo('meta_keywords')){
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $keywordsSeo,
    ]);
}

\Yii::$app->view->registerMetaTag([
    'property' => 'og:type',
    'content' => 'article'
]);

\Yii::$app->view->registerMetaTag([
    'property' => 'og:title',
    'content' => $page->title
]);

\Yii::$app->view->registerMetaTag([
    'property' => 'og:description',
    'content' => $descriptionSeo
]);

\Yii::$app->view->registerMetaTag([
    'property' => 'og:url',
    'content' => Url::to(['news/'.$page->slug])
]);

$image = (isset($page->image) && !empty($page->image)) ? Image::thumb($page->image, 800, 200) : Image::thumb($page->model->pre_image, 800, 450);
\Yii::$app->view->registerMetaTag([
    'property' => 'og:image',
    'content' => Url::base('https') . $image
]);

$imagex = (isset($page->image) && !empty($page->image)) ? $page->image : $page->model->pre_image;
Yii::$app->view->registerMetaTag([
    'property' => 'imagex',
    'content' => Url::base('https') . $imagex
]);

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
                                    <?php if(isset($page->image) && !empty($page->image)): ?>
                                        <?= Html::img(Image::thumb($page->image, 800, 200)) ?>
                                    <?php else: ?>
                                        <?= Html::img(Image::thumb($page->model->pre_image, 800, 450)) ?>
                                    <?php endif; ?>

                                    <div class="blogpost-detail">
                                        <ul class="post-meta style2">
                                            <li><i class="fa fa-calendar"></i> <?= $page->date ?></li>
                                            <li><i class="fa fa-comment"></i><a href="#" title="">Прочитали <?= $page->views * 3 ?> человек</a></li>
                                        </ul>

                                        <div class="text-con">
                                            <?= $page->getDescription() ?>
                                        </div>

                                        <div class="tags-social">
                                            <div class="tags">
                                                <ul class="cate-list">
                                                    <?php foreach($page->tags as $tag) : ?>
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

                                        <?php if(count($page->photos)) : ?>
                                        <div class="comments-sec">
                                            <h2 class="title2"><span><?php echo count($page->photos);?></span> Photos</h2>
                                                <ul class="list-inline">
                                                    <?php foreach($page->photos as $photo) : ?>
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
                                            <h2><?= Yii::t('easyii', 'goodPropositions') ?></h2>
                                            <span><?= Yii::t('easyii', 'interestingCountries') ?></span>
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
                                                <li><a href="<?= Url::to(['banks/'.$item->slug]) ?>" title="<?= $item->title ?>">
                                                        <?= Html::img(Image::thumb($item->image, 332, 83)) ?>
                                                    </a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div><!-- Widget -->
                                    <? endif; ?>
                                    <?php if(isset($top_banks) && count($top_banks)>0): ?>
                                    <div class="widget recent-posts-widget">
                                        <div class="title1 style2">
                                            <h2><?= Yii::t('easyii', 'articles') ?></h2>
                                            <span><?= Yii::t('easyii', 'popularNews') ?></span>
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

