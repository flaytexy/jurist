<?php
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$this->title = $news->seo('title', $news->model->title);
$this->params['breadcrumbs'][] = ['label' => 'News', 'url' => ['/news']];
$this->params['breadcrumbs'][] = $news->model->title;
?>


<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villarecent-blog">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="blog-post2">
                                    <?= Html::img($news->thumb(600, 450)) ?>
                                    <div class="blogpost-detail">
                                        <ul class="post-meta style2">
                                            <li><i class="fa fa-calendar"></i> <?= $news->date ?></li>
                                            <li><i class="fa fa-user"></i> By <a href="#" title="">Admin</a></li>
                                            <li><i class="fa fa-comment"></i><a href="#" title=""><?= $news->views?> Views</a></li>
                                            <li><i class="fa fa-comment"></i><a href="#" title="">03 Comments</a></li>
                                        </ul>



                                        <h1><?= $news->seo('h1', $news->title) ?></h1>
                                        <div class="tags-social">
                                            <div class="tags">
                                                <ul class="cate-list">
                                                    <?php foreach($news->tags as $tag) : ?>
                                                    <li><a href="<?= Url::to(['/news', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a></li>
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
                                        <div class="text-con">
                                            <?= $news->text ?>
                                        </div>
                                        <?php if(count($news->photos)) : ?>
                                        <div class="comments-sec">
                                            <h2 class="title2"><span><?php echo count($news->photos);?></span> Photos</h2>
                                                <ul class="list-inline">
                                                    <?php foreach($news->photos as $photo) : ?>
                                                    <li><?= $photo->box(150, 120) ?></li>
                                                    <?php endforeach;?>
                                                </ul>
                                        </div>
                                        <?php endif; ?>

                                        <?php Page::plugin() ?>
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
                                            <h2>Tags Cloud</h2>
                                            <span>We Provide Best Services</span>
                                        </div>
                                        <div class="tags">
                                            <ul class="cate-list">
                                                <li><a href="#" title="">Uncategorized</a></li>
                                                <li><a href="#" title="">Standard</a></li>
                                                <li><a href="#" title="">Villa</a></li>
                                                <li><a href="#" title="">Standard</a></li>
                                                <li><a href="#" title="">Villa</a></li>
                                                <li><a href="#" title="">Category</a></li>
                                                <li><a href="#" title="">Uncategorized</a></li>
                                                <li><a href="#" title="">Standard</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- Widget -->
                                    <div class="widget quick-links-widget">
                                        <div class="title1 style2">
                                            <h2>Quick Links</h2>
                                            <span>We Provide Best Services</span>
                                        </div>
                                        <div class="menu-links">
                                            <ul>
                                                <li><a href="#" title="">Faq's</a></li>
                                                <li><a href="#" title="">Support</a></li>
                                                <li><a href="#" title="">Community</a></li>
                                                <li><a href="#" title="">Membership</a></li>
                                                <li><a href="#" title="">Events</a></li>
                                                <li><a href="#" title="">Contact us</a></li>
                                            </ul>
                                        </div>
                                    </div><!-- Widget -->
                                    <div class="widget recent-posts-widget">
                                        <div class="title1 style2">
                                            <h2>Recent Posts</h2>
                                            <span>We Provide Best Services</span>
                                        </div>
                                        <div class="recent-posts">
                                        <?php foreach($top_news as $item) : ?>
                                            <div class="recent-post">
                                                <?= Html::img(\frontend\helpers\Image::thumb($item['image'], 90, 90)) ?>
                                                <h4><a href="<?= Url::to(['news/c/'.$item['slug']]) ?>"><?= $item['title'] ?></a></h4>
                                                <span><i class="fa fa-calendar"></i> 26 May 2016</span>
                                            </div>
                                        <?php endforeach; ?>

                                        </div>
                                    </div><!-- Widget -->
                                </div><!-- Sidebar -->
                            </div>
                        </div>
                    </div><!-- Villa Recent Blog -->
                </div>
            </div>
        </div>
    </div>
</section>


<?php /*if(false) : */?><!--
<h1><?/*= $news->seo('h1', $news->title) */?></h1>

<?/*= $news->text */?>

<?php /*if(count($news->photos)) : */?>
    <div>
        <h4>Photos</h4>
        <?php /*foreach($news->photos as $photo) : */?>
            <?/*= $photo->box(100, 100) */?>
        <?php /*endforeach;*/?>
        <?php /*News::plugin() */?>
    </div>
    <br/>
<?php /*endif; */?>
<p>
    <?php /*foreach($news->tags as $tag) : */?>
        <a href="<?/*= Url::to(['/news', 'tag' => $tag]) */?>" class="label label-info"><?/*= $tag */?></a>
    <?php /*endforeach; */?>
</p>

<div class="small-muted">Views: <?/*= $news->views*/?></div>
--><?php /*endif; */?>