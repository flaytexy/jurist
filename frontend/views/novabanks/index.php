<?php
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;

use frontend\helpers\Image;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\TopBanks;

\frontend\assets\BanksAsset::register($this);

/**
 * @var  \yii\web\View $this
 * @var \frontend\modules\novanews\api\Novanews $page
 * @var \frontend\modules\novabanks\models\Novabanks $model
 * @var \frontend\modules\novabanks\api\NovabanksObject[] $items
 *
 * @var \frontend\modules\novanews\api\NovanewsObject[] $top_news
 * @var \frontend\modules\novabanks\api\NovabanksObject[] $top_banks
 * @var \frontend\modules\novaoffers\api\NovaoffersObject[] $top_offers
 */


$this->title = !empty($page->seo('title', $page->title)) ? $page->seo('title', $page->title) : '';
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

$this->params['breadcrumbs'][] = $page->title;
?>

<?php /*if ($this->beginCache(md5(serialize(Yii::$app->request->get())), ['duration' => 700])) : */?>

    <section class="container-fluid">
        <div class="row">
            <div class="col-md-12">
            <?php if ($page->text): ?>
                <div><?= $page->text ?></div><? endif; ?>
            </div>
        </div>
    </section>

    <?php if ($items): ?>
    <section id="banks2" class="scroll-container container-fluid">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="row bank-new-list top20">
                    <div class="col-md-12" id="switchAllBanks">
                        <table id="example" class="table table-bordered display" style="width:100%">
                            <thead>
                            <tr>
                                <th><?= Yii::t('easyii', 'name') ?></th>
                                <th><?= Yii::t('easyii', 'country') ?></th>
                                <th><?= Yii::t('easyii', 'visitBank') ?></th>
                                <th><?= Yii::t('easyii', 'price') ?></th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php if ($items): ?>
                                <?php foreach ($items as $item) : ?>
                                    <tr>
                                        <td data-order="<?= $item->title ?>" class="col-md-8 col-lg-2">
                                            <h6>
                                                <?= Html::a($item->title, ['banks/'.$item->model->slug]) ?>
                                            </h6>

                                            <div class="top15">
                                                <div class="hide-for-small-down text-left">
                                                    <a href="<?= Url::to(['banks/'.$item->model->slug]) ?>"><img data-src="<?=$item->thumb(160, 40)?>"
                                                                                                                 alt="" class="lazy"></a>
                                                </div>
                                            </div>
                                        </td>

                                        <td data-order="<? if ($item->model->child->countries[0]->name_ru): ?><?= $item->model->child->countries[0]->name_ru ?><? else: ?><?= $item->model->bank->location_title ?><? endif ?>" class="col-md-8 col-lg-2 text-center">
                                            <div class="bnk-country">
                                                <? if ($item->model->child->countries[0]->alpha): ?><div class="text-center"><div class="bnk-flag"> <div class="label flag flag-icon-background flag-icon-<?= $item->model->child->countries[0]->alpha ?>">&nbsp;</div></div></div><? endif ?>
                                                <div class="left tBankLi" style="margin: 2px 0 0 0"><? if ($item->model->child->countries[0]->name_ru): ?><?= $item->model->child->countries[0]->name_ru ?><? else: ?><?= $item->model->bank->location_title ?><? endif ?></div>
                                            </div>
                                        </td>
                                        <td data-order="<?= $item->model->bank->personal ?>" class="hidden-xs hidden-sm hidden-md col-lg-8 no-padding">
                                            <table class="table border-none tBankLi">
                                                <tr>
                                                    <td>
                                                        <p class="f" title="Открытие счета без личного присутствия">
                                                            <?= Yii::t('easyii', 'visitBank') ?> </p>
                                                        <?php if ($item->model->bank->personal === 1): ?>
                                                            <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>
                                                        <? else: ?>
                                                            <div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>
                                                        <? endif; ?>
                                                    </td>
                                                    <td>
                                                        <p class="f"><?= Yii::t('easyii', 'bankSite') ?></p>
                                                        <div class="hegg"><?= $item->model->bank->website ?></div>
                                                    </td>
                                                    <td>
                                                        <p class="f"><?= Yii::t('easyii', 'minDeposit') ?></p>
                                                        <div class="hegg">
                                                            <? if ($item->model->bank->min_deposit > 0): ?><?= $item->model->bank->min_deposit ?>
                                                            <? else: ?><div class="">0</div> <? endif ?>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <p class="f"><?= Yii::t('easyii', 'term') ?></p>
                                                        <div class="tBankDays tBankOter"><p><?= $item->model->bank->how_days ?></p></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td data-order="<?= $item->model->bank->price ?>" class="col-md-4 col-lg-2 bg-green-price">
                                            <div class="h6 text-center">
                                                <span><?= Yii::t('easyii', 'price') ?></span>
                                            </div>
                                            <div class="h6 text-center cena">€<?= $item->model->bank->price ?></div>
                                            <div class="bnk-btn text-center">
                                                <a class="btn btn-success" href="javascript:void( window.open( 'https://form.jotformeu.com/82774951021356', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )"><?= Yii::t('easyii', '10') ?></a>
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
            <div class="col-lg-3 col-md-3 col-sm-12">
                <!-- Widget3 -->
                <!-- end: Widget3 -->
                <?= TopBanks::widget(['banks' =>$top_banks,'bankNum' =>3])?>
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
                                    <?= Html::img(\frontend\helpers\Image::thumb($item->model->image, 90, 90)) ?>
                                    <h4><a href="<?= Url::to(['news/'.$item->model->slug]) ?>"><?= $item->model->title ?></a></h4>
                                    <span><i class="fa fa-calendar"></i> <?= $item->date ?></span>
                                </div>
                            <?php endforeach; ?>

                        </div>
                    </div>
                </div><!-- end: Widget1 -->

                <?php if(isset($top_offers)) :?>
                <!-- Widget2 -->
                <div class="widget villa-photos-widget top20">
                    <div class="title1 style2">
                        <h2><?= Yii::t('easyii', 'goodPropositions') ?></h2>
                        <span><?= Yii::t('easyii', 'interestingCountries') ?></span>
                    </div>
                    <ul class="widget-gallery">
                        <?php foreach($top_offers as $item) : ?>
                            <li><a href="<?= Url::to(['offers/'.$item->slug]) ?>">
                                    <?= Html::img(\frontend\helpers\Image::thumb($item->image, 300, 200)) ?>
                                </a>
                                <span><a href="<?= Url::to(['offers/'.$item->slug]) ?>"><?= $item->title ?><br><b>€<?= $item->price ?> / <?= Yii::t('easyii', 'days') ?>: <?= $item->model->child->how_days ?></b></a></span></li>
                        <?php endforeach; ?>

                    </ul>
                </div><!-- end: Widget2 -->
                <? endif; ?>

                <!-- Widget4 -->
                <div class="widget vertical-menu">
                    <a href="#" class="active"><?= Yii::t('easyii', 'banks') ?></a>
                    <?php foreach ($banksPist as $itemList) : ?>
                        <a href="<?= Url::to(['banks/'.$itemList->slug]) ?>"><?=$itemList->title?> <b>€<?= $itemList->model->bank->price ?></b></a>
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
                                                        <span><b><? if ($item->model->child->countries[0]->name_ru): ?><?= $item->child->countries[0]->name_ru ?><? else: ?><?= $item->model->bank->location_title ?><? endif; ?></b></span>
                                                    </div>
                                                    <div class="package-detail">
                                                        <!--                                            <span class="cate">
                                                <?php /*foreach ($item->tags as $tag) : */ ?>
                                                    <a href="<? /*= Url::to(['/pages', 'tag' => $tag]) */ ?>"
                                                       class="label label-info"><? /*= $tag */ ?></a>
                                                <?php /*endforeach; */ ?>
                                            </span>-->
                                                        <h4><?= Html::a($item->title,
                                                                ['banks/view', 'slug' => $item->model->slug]) ?></h4>
                                                        <ul class="location-book">
                                                            <li class="book-btn"><i class="fa fa-info"></i>
                                                                <?= Html::a(Yii::t('easyii', 'more_details'),
                                                                    ['banks/view', 'slug' => $item->model->slug]) ?></li>
                                                            <li class="book-btn"><i class="fa fa-shopping-basket"></i>
                                                                <a href="javascript:void( window.open( 'https://form.jotformeu.com/82774951021356', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )"><?= Yii::t('easyii', '10') ?></a>
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
                                    <?= \frontend\modules\novabanks\api\Novabanks::pages() ?>
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