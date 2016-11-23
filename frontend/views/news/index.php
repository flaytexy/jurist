<?php
use frontend\modules\news\api\News;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-news');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h1><?= $page->seo('h1', $page->title) ?></h1>
<br/>

<?php /*foreach($news as $item) : ?>
    <div class="row">
        <div class="col-md-2">
            <?= Html::img($item->thumb(160, 120)) ?>
        </div>
        <div class="col-md-10">
            <?= Html::a($item->title, ['news/view', 'slug' => $item->slug]) ?>
            <div class="small-muted"><?= $item->date ?></div>
            <p><?= $item->short ?></p>
            <p>
                <?php foreach($item->tags as $tag) : ?>
                    <a href="<?= Url::to(['/news', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
    <br>
<?php endforeach; ?>

<?= News::pages()*/ ?>


<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="recent-news">
                        <div class="remove-ext">
                            <div class="row">
                                <?php foreach($news as $item) : ?>
                                <div class="col-md-6">
                                    <div class="recentnew-post">
                                        <?= Html::img($item->thumb(500, 375)) ?>
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
                    </div><!-- Recent News -->
                    <div id="pagination">
                        <?= News::pages() ?>
                    </div><!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</section>