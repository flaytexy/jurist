<?php
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;

use frontend\helpers\Image;

use yii\helpers\Html;
use yii\helpers\Url;

\frontend\assets\BanksAsset::register($this);

/**
 * @var  \yii\web\View $this
 * @propperty  $page \frontend\modules\page\api\Page
 */

$page = Page::get('page-banks');
$this->title = !empty($page->seo('title', $page->model->title)) ? $page->seo('title', $page->model->title) : '';
if($descriptionSeo = !empty($page->seo('description')) ? $page->seo('description') : ''){
    $this->registerMetaTag([
        'name' => 'description',
        'content' => $descriptionSeo,
    ]);
}
if($keywordsSeo = !empty($page->seo('keywords')) ? $page->seo('keywords') : ''){
    $this->registerMetaTag([
        'name' => 'keywords',
        'content' => $keywordsSeo,
    ]);
}

$this->params['breadcrumbs'][] = $page->model->title;
?>

<?php /*if ($this->beginCache(md5(serialize(Yii::$app->request->get())), ['duration' => 700])) : */?>

    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <h1><?= $page->seo('h1', $page->title) ?></h1>
            <?php if ($page->text): ?>
                <div><?= $page->seo('div', $page->text) ?></div><? endif; ?>
            </div>
        </div>
    </section>

    <?php if ($items): ?>
    <section id="banks2" class="scroll-container container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="row bank-new-list top20">
                    <div class="col-md-12" id="switchAllBanks">
                        <table id="example" class="table table-bordered display" style="width:100%">
                            <thead>
                            <tr>
                                <th>Имя</th>
                                <th>Страна</th>
                                <th>С посещением банка</th>
                                <th>Цена</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if ($items): ?>
                                <?php foreach ($items as $item) : ?>
                                    <tr>
                                        <td data-order="<?= $item->title ?>" class="col-md-8 col-lg-2">
                                            <h6>
                                                <?= Html::a($item->title, ['banks/view', 'slug' => $item->slug]) ?>
                                            </h6>

                                            <div class="top15">
                                                <div class="hide-for-small-down text-left">
                                                    <a href="<?= Url::to(['banks/view', 'slug' => $item->slug]) ?>"><?= Html::img($item->thumb(160, 40)) ?></a>
                                                </div>
                                            </div>
                                        </td>

                                        <td data-order="<? if ($item->model->countries[0]->name_ru): ?><?= $item->model->countries[0]->name_ru ?><? else: ?><?= $item->model->location_title ?><? endif ?>" class="col-md-8 col-lg-2 text-center">
                                            <div class="bnk-country">
                                                <? if ($item->model->countries[0]->alpha): ?><div class="text-center"><div class="bnk-flag"> <div class="label flag flag-icon-background flag-icon-<?= $item->model->countries[0]->alpha ?>">&nbsp;</div></div></div><? endif ?>
                                                <div class="left tBankLi" style="margin: 2px 0 0 0"><? if ($item->model->countries[0]->name_ru): ?><?= $item->model->countries[0]->name_ru ?><? else: ?><?= $item->model->location_title ?><? endif ?></div>
                                            </div>
                                        </td>
                                        <td data-order="<?= $item->model->personal ?>" class="hidden-xs hidden-sm hidden-md col-lg-8 no-padding">
                                            <table class="table border-none tBankLi">
                                                <tr>
                                                    <td>
                                                        <p class="f" title="Открытие счета без личного присутствия">
                                                            С посещением банка </p>
                                                        <?php if ($item->model->personal === 1): ?>
                                                            <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>
                                                        <? else: ?>
                                                            <div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>
                                                        <? endif; ?>
                                                    </td>
                                                    <td>
                                                        <p class="f">Сайт банка</p>
                                                        <div class="hegg"><?= $item->model->website ?></div>
                                                    </td>
                                                    <td>
                                                        <p class="f">Минимальный депозит</p>
                                                        <div class="hegg">
                                                            <? if ($item->model->min_deposit > 0): ?><?= $item->model->min_deposit ?>
                                                            <? else: ?><div class="">0</div> <? endif ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="f">Срок</p>
                                                        <div class="tBankDays tBankOter"><p><?= $item->how_days ?></p></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td data-order="<?= $item->price ?>" class="col-md-4 col-lg-2 bg-green-price">
                                            <div class="h6 text-center">
                                                <span>Цена</span>
                                            </div>
                                            <div class="h6 text-center cena">€<?= $item->price ?></div>
                                            <div class="bnk-btn text-center">
                                                <a class="btn btn-success" href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )"><?= Yii::t('easyii', '10') ?></a>
                                                <!--    <a href="<?= Url::to(['banks/view', 'slug' => $item->slug]) ?>"
                                               class="btn btn-success">Заказать</a>-->
                                            </div>
                                        </td>
                                    </tr>
                                <? endforeach; ?>
                            <? endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <!-- Widget3 -->
                <div class="widget villa-photos-widget top20">
                    <div class="title1 style2">
                        <h2><?= Yii::t('easyii', 'topBanks') ?></h2>
                        <span><?= Yii::t('easyii', 'bestTerm') ?></span>
                    </div>
                    <ul class="widget-gallery">
                        <?php foreach($top_banks as $item) : ?>
                            <li><a href="<?= Url::to(['banks/'.$item['slug']]) ?>">
                                    <?= Html::img(Image::thumb($item['image'], 240, 120)) ?>
                                </a>
                                <span><a href="<?= Url::to(['banks/'.$item['slug']]) ?>"><?= $item['title'] ?></a></span> </li>
                        <?php endforeach; ?>
                    </ul>
                </div><!-- end: Widget3 -->

                <!-- Widget1 -->
                <div class="widget vertical-menu-widget top10">
                    <div class="recent-posts-widget">
                        <div class="title1 style2">
                            <h2><?= Yii::t('easyii', 'articles') ?></h2>
                            <span><?= Yii::t('easyii', 'popularNews') ?></span>
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
                    </div>
                </div><!-- end: Widget1 -->

                <!-- Widget2 -->
                <div class="widget villa-photos-widget top20">
                    <div class="title1 style2">
                        <h2><?= Yii::t('easyii', 'goodPropositions') ?></h2>
                        <span><?= Yii::t('easyii', 'interestingCountries') ?></span>
                    </div>
                    <ul class="widget-gallery">
                        <?php foreach($top_offers as $item) : ?>
                            <li><a href="<?= Url::to(['offers/'.$item['slug']]) ?>">
                                    <?= Html::img(\frontend\helpers\Image::thumb($item['image'], 300, 200)) ?>
                                </a>
                                <span><a href="<?= Url::to(['offers/'.$item['slug']]) ?>"><?= $item['title'] ?><br><b>€<?= $item['price'] ?> / <?= Yii::t('easyii', 'days') ?>: <?= $item['how_days']?></b></a></span></li>
                        <?php endforeach; ?>

                    </ul>
                </div><!-- end: Widget2 -->

                <!-- Widget4 -->
                <div class="widget vertical-menu">
                    <a href="#" class="active">Банки</a>
                    <?php foreach ($banksPist as $itemList) : ?>
                        <a href="<?= Url::to(['banks/'.$itemList->slug]) ?>"><?=$itemList->title?> <b>€<?= $itemList->model->price ?></b></a>
                    <?php endforeach; ?>
                </div><!-- end: Widget4 -->
            </div>
        </div>
    </section>
    <? endif; ?>

    <?php if (true): ?>
        <section id="pages" class="top20">
            <div class="block">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="font-color"><?= Yii::t('easyii', 'More_about_our_banks') ?></h3>
                            <div class="villaeditors-picks">
                                <div class="packages style2 remove-ext2">
                                    <div class="row">
                                        <?php foreach ($banksList as $item) : ?>
                                            <div class="col-md-4">
                                                <div class="package">
                                                    <div class="package-thumb">
                                                        <?= Html::img($item->thumb(240, 60)) ?>
                                                        <span><b><? if ($item->model->countries[0]->name_ru): ?><?= $item->countries[0]->name_ru ?><? else: ?><?= $item->model->location_title ?><? endif; ?></b></span>
                                                    </div>
                                                    <div class="package-detail">
                                                        <!--                                            <span class="cate">
                                                <?php /*foreach ($item->tags as $tag) : */ ?>
                                                    <a href="<? /*= Url::to(['/pages', 'tag' => $tag]) */ ?>"
                                                       class="label label-info"><? /*= $tag */ ?></a>
                                                <?php /*endforeach; */ ?>
                                            </span>-->
                                                        <h4><?= Html::a($item->title,
                                                                ['banks/view', 'slug' => $item->slug]) ?></h4>
                                                        <ul class="location-book">
                                                            <li class="book-btn"><i class="fa fa-info"></i>
                                                                <?= Html::a( Yii::t('easyii', 'more_details'),
                                                                    ['banks/view', 'slug' => $item->slug]) ?></li>
                                                            <li class="book-btn"><i class="fa fa-shopping-basket"></i>
                                                                <a href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )"><?= Yii::t('easyii', '10') ?></a>
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
                                <div>
                                    <?= Banks::pages() ?>
                                </div>
                            </div>
                            <!-- Pagination -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php //$this->endCache(); ?>
<?php //endif; ?>


<!--<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/autofill/2.2.2/js/dataTables.autoFill.min.js"></script>-->