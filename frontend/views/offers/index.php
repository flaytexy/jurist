<?php
use frontend\modules\offers\api\Offers;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

$page = Page::get('page-offers');

$this->title = $page->seo('title', $page->model->title);
$this->params['breadcrumbs'][] = $page->model->title;
?>
<h1><?= $page->seo('h1', $page->title) ?></h1>
<br/>

<?php /*foreach($offers as $item) : ?>
    <div class="row">
        <div class="col-md-2">
            <?= Html::img($item->thumb(160, 120)) ?>
        </div>
        <div class="col-md-10">
            <?= Html::a($item->title, ['offers/view', 'slug' => $item->slug]) ?>
            <div class="small-muted"><?= $item->date ?></div>
            <p><?= $item->short ?></p>
            <p>
                <?php foreach($item->tags as $tag) : ?>
                    <a href="<?= Url::to(['/offers', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                <?php endforeach; ?>
            </p>
        </div>
    </div>
    <br>
<?php endforeach; ?>

<?= Offers::pages() */ ?>

<section>
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villaeditors-picks">
                        <div class="packages style2 remove-ext2">
                            <div class="row">
                                <?php foreach($offers as $item) : ?>
                                    <div class="col-md-4">
                                        <div class="package">
                                            <div class="package-thumb">
                                                <?= Html::img($item->thumb(160, 120)) ?>
                                                <span><i>$380</i> / Минимал</span>
                                            </div>
                                            <div class="package-detail">
                                            <span class="cate">
                                                <?php foreach($item->tags as $tag) : ?>
                                                    <a href="<?= Url::to(['/offers', 'tag' => $tag]) ?>" class="label label-info"><?= $tag ?></a>
                                                <?php endforeach; ?>
                                            </span>
                                                <h4><a href="packages-detail.html" title=""> <?= Html::a($item->title, ['offers/view', 'slug' => $item->slug]) ?></a></h4>
                                                <ul class="location-book">
                                                    <li class="active"><i class="fa fa-map-marker"></i> <span><?= $item->date ?></span></li>
                                                    <li class="book-btn"><i class="fa fa-thumbs-o-up"></i><a href="#" title="">BOOK NOW</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div><!-- Villa Editors Picks -->
                    <div id="pagination">
                        <div><?= Offers::pages() ?></div>
                    </div><!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</section>