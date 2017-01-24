<?php
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-news');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>


<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <?php if($page->text): ?><div><?= $page->seo('div', $page->text) ?></div><? endif; ?>
</div>

<section class="content-zone top20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="recent-news">
                    <div class="remove-ext">
                        <div class="row">
                            <?php foreach ($news as $item) : ?>
                                <div class="col-md-6">
                                    <div class="recentnew-post">
                                        <a href="<?= Url::to([$typeTitle.'/'.$item->slug]) ?>" class="">
                                            <?= Html::img($item->thumb(500, 375)) ?>
                                        </a>
                                        <div class="recentnew-detail">
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
        </div>
    </div>

</section>