<?php
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\TablesAsset;

TablesAsset::register($this);

$page = Page::get('page-banks');
if($page){
    $this->title = $page->seo('title', $page->model->title);
    //$this->view->registerMetaTag(['name' => 'keywords', 'content' => 'yii, framework, php']);
    $this->registerMetaTag([
        'name' => 'title',
        'content' => $page->seo('title', '')
    ]);
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $page->seo('keywords', '')
    ]);
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $page->seo('description', '')
    ]);
}

$this->params['breadcrumbs'][] = $page->model->title;
?>
<div class="container">
    <h1><?= $page->seo('h1', $page->title) ?></h1>
    <?php if ($page->text): ?>
        <div><?= $page->seo('div', $page->text) ?></div><? endif; ?>
</div>

<section id="banks" class="content-zone top20">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <table class="table" id="table-js">
                    <thead>
                    <tr>
                        <th>Название</th>
                        <th>Страна</th>
                        <th>Сайт</th>
                        <th>Мин. депозит/баланс</th>
                        <th>Срок</th>
                        <th>Цена</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($banks as $item) : ?>
                        <tr>
                            <td>
                                <?= Html::a($item->title, ['banks/view', 'slug' => $item->slug]) ?>
                            </td>
                            <td>
                                <?= $item->model->location_title ?>
                            </td>
                            <td>
                                <?= $item->model->website ?>
                            </td>
                            <td>
                                <?= $item->model->min_deposit ?>
                            </td>
                            <td>
                                <?= $item->model->how_days ?>
                            </td>
                            <td>
                                <?= $item->price ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>

<section id="pages">
    <div class="block">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="villaeditors-picks">
                        <div class="packages style2 remove-ext2">
                            <div class="row">
                                <?php foreach ($banksList as $item) : ?>
                                    <div class="col-md-4">
                                        <div class="package">

                                            <div class="package-thumb">
                                                <?= Html::img($item->thumb(500, 375)) ?>
                                                <!--<span><i>$<? /*= $item->model->price */ ?></i> / <? /* if ($item->model->how_days): */ ?><? /*= $item->model->how_days*/ ?><? /* else: */ ?>Минимал<? /* endif; */ ?></span>-->
                                            </div>
                                            <div class="package-detail">
                                                <!--                                            <span class="cate">
                                                <?php /*foreach ($item->tags as $tag) : */ ?>
                                                    <a href="<? /*= Url::to(['/pages', 'tag' => $tag]) */ ?>"
                                                       class="label label-info"><? /*= $tag */ ?></a>
                                                <?php /*endforeach; */ ?>
                                            </span>-->
                                                <h4><?= Html::a($item->title, ['banks/view', 'slug' => $item->slug]) ?></h4>
                                                <ul class="location-book">
                                                    <li class="active"><i class="fa fa-map-marker"></i>
                                                        <span><?= $item->date ?></span></li>
                                                    <li class="book-btn"><i class="fa fa-thumbs-o-up"></i>
                                                        <?= Html::a('Детальней', ['banks/view', 'slug' => $item->slug]) ?>
                                                    </li>
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
                        <div><?= $banksPagination ?></div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>
</section>