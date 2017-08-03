<?php
use frontend\modules\banks\api\Banks;
use frontend\modules\page\api\Page;
use yii\helpers\Html;
use yii\helpers\Url;

use frontend\assets\TablesAsset;

TablesAsset::register($this);

use frontend\assets\SwitcherAsset;
use akavov\countries\assets\CountriesAsset;
CountriesAsset::register($this);
SwitcherAsset::register($this);


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
    <div class="container">
        <h1><?= $page->seo('h1', $page->title) ?></h1>
        <?php if ($page->text): ?>
            <div><?= $page->seo('div', $page->text) ?></div><? endif; ?>
    </div>
<style>
    .package-thumb > span {
        font-size: 14px;
        font-family: Arial, Arial, Helvetica, Tahoma, sans-serif;
        -webkit-transform: translateY(-240%) translateX(-40%);
        -moz-transform: translateY(-240%) translateX(-40%);
        -ms-transform: translateY(-240%) translateX(-40%);
        -o-transform: translateY(-240%) translateX(-40%);
        transform: translateY(-240%) translateX(-40%);
    }
</style>
    <section id="banks2" class="scroll-container">
        <div class="container">
            <div class="row top30">
                <form>
                    <div class="col-md-4">
                        <ul class="list-inline" id="sw-list">
                            <li class="listcenter">Только личный счет?</li><br>
                           <li>Нет</li> <li class="">
                                <div class="switcher">
                                    <input value="0" class="switch" js-filter="js-filter-type-id" name="switchName"
                                           type="checkbox"/>
                                </div>
                            </li>
                            <li>Да</li>
                        </ul>

                    </div>

                    <div class="col-md-4">
                        <ul class="list-inline" id="sw-list">
                            <li  class="listcenter">С посещением банка?</li><br>
                        <li>Нет</li>    <li class="">
                                <div class="switcher">
                                    <input  value="0" class="switch" js-filter="js-filter-personal" name="switchName2"
                                           type="checkbox"/>
                                </div>
                            </li> <li>Да</li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <ul class="list-inline" id="sw-list">
                            <li  class="listcenter">С минимальным депозитом?</li><br>
                          <li>Нет</li>  <li class="">
                                <div class="switcher">
                                    <input value="0" class="switch" js-filter="js-filter-min-deposit" js-filter-switch-only="1" name="switchName3"
                                           type="checkbox"/>
                                </div>
                            </li><li>Да</li>
                        </ul>
                    </div>
                </form>
            </div>
<style>

    .listcenter {
        font-size: 20px;

        position: relative;
        right: 40px;
    }

    @media (max-width: 800px) {
        .listcenter {
            right: 0;
        }
    }
    #tpb {
        position: absolute;
        top: 295px;
        left: -281px;
        transform: rotate(-90deg);
    }
    #tpb h3
    {
        font-size: 1em;
        font-weight: bold;
        position: relative;
        margin: -35px 0 0 0;
        float: right;
        color: #222;
        padding: 10px 250px;
        text-shadow: 0 1px rgba(255,255,255,.8);
        /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+0,7dc20f+100&0+0,1+100 */
        background: -moz-linear-gradient(left,  rgba(255,255,255,0) 0%, rgba(125,194,15,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(left,  rgba(255,255,255,0) 0%,rgba(125,194,15,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to right,  rgba(255,255,255,0) 0%,rgba(125,194,15,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#00ffffff', endColorstr='#7dc20f',GradientType=1 ); /* IE6-9 */

      /*  -moz-box-shadow: 0 2px 2px #ccc;
        -webkit-box-shadow: 0 2px 2px #ccc;
        box-shadow: 0 2px 2px #ccc;*/
    }

    #tpb h3:before, #tpb h3:after{
        content: '';
        position: absolute;
        border-style: solid;
        border-color: transparent;
    }
/*  #tpb h3:before{
        left: -6px;
        top: 0;
        border-color: transparent #555 #555 transparent;
        border-style: solid;
    }*/

</style>
            <div class="row bank-new-list">
                <div class="col-md-12" id="switchAllBanks">
                 <table data-region-assign="reg_3" class="table reg_3 table-bordered 1_0_0.00 js-filter-marker" js-filter-type-id="0" js-filter-personal="0" js-filter-min-deposit="0" style="display: table;">


                        <tbody><tr>

                            <td class="col-md-8 col-lg-2">
                                <div id="tpb"> <h3>TOP BANKS</h3></div>
                                <h6>
                                    <a href="/banks/ceska-sporitelna-bank">Ceska Sporitelna Bank</a>                                    </h6>

                                <div class="no-margin inl-block">
                                    <div class="hide-for-small-down">
                                        <a href="/banks/ceska-sporitelna-bank"><img src="/uploads/thumbs/ceska-sporitelna-9fec73942b-47552b6caf9f377c5af9da7883d5e232.jpg" alt=""></a>
                                    </div>
                                    <div class="top10 row">
                                        <div class="col-xs-3"><div class="b-flag"> <div class="label flag flag-icon-background flag-icon-cz">&nbsp;</div></div></div>                                            <div class="col-xs-9"><div class="left tBankLi" style="margin: 2px 0 0 0">Чехия</div></div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden-xs hidden-sm hidden-md  col-lg-8">
                                <table class="table border-none tBankLi">
                                    <tbody><tr>
                                        <td>

                                            <p class="f">Корпоративный счет</p>
                                            <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>
                                        </td>

                                        <td>
                                            <p class="f" title="Открытие счета без личного присутствия">
                                                С посещением банка </p>
                                            <div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>                                            </td>

                                        <td>
                                            <p class="f">Сайт банка</p>

                                            <div class="hegg">www.csas.cz</div>
                                            <!--<div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>-->
                                        </td>
                                        <td>
                                            <p class="f">Минимальный депозит</p>

                                            <div class="hegg">                                                        <div class="">
                                                    0
                                                </div>                                                </div>
                                            <!--   <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>-->
                                        </td>
                                        <td>
                                            <p class="f">Срок</p>

                                            <div class="tBankDays tBankOter"><p>30</p></div>
                                        </td>
                                        <!--<td>
                                            <p class="">Initial Deposit</p>
                                            <p class="">USD 0</p>
                                        </td>
                                        <td>
                                            <p class=""> Min. Balance</p>
                                            <p class="">USD 0</p>
                                        </td>-->
                                    </tr>
                                    </tbody></table>
                            </td>
                            <td class="col-md-4 col-lg-2 bg-green-price">
                                <div class="h6 text-center">
                                    <span>Цена</span>
                                </div>
                                <div style="font-weight: bolder; font-size: large; font-family: Verdana;" class="h6 text-center cena">€2000</div>

                                <div class="text-center" style="height:35px;">

                                    <a class="btn btn-success" href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a>
                                    <!--    <a href="/banks/ceska-sporitelna-bank"
                                           class="btn btn-success">Заказать</a>-->
                                </div>
                            </td>
                        </tr>
                        </tbody></table>
                    <table data-region-assign="reg_3" class="table reg_3 table-bordered 1_0_0.00 js-filter-marker" js-filter-type-id="0" js-filter-personal="0" js-filter-min-deposit="0" style="display: table;">
                        <tbody><tr>
                            <td class="col-md-8 col-lg-2">
                                <h6>
                                    <a href="/banks/unicredit-bank">UniCredit Bank</a>                                    </h6>

                                <div class="no-margin inl-block">
                                    <div class="hide-for-small-down">
                                        <a href="/banks/unicredit-bank"><img src="/uploads/thumbs/bankunicr-9e4e0a8a91-cb4ad4ab974b32f6b7541bd613b7d602.jpg" alt=""></a>
                                    </div>
                                    <div class="top10 row">
                                        <div class="col-xs-3"><div class="b-flag"> <div class="label flag flag-icon-background flag-icon-cz">&nbsp;</div></div></div>                                            <div class="col-xs-9"><div class="left tBankLi" style="margin: 2px 0 0 0">Чехия</div></div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden-xs hidden-sm hidden-md  col-lg-8">
                                <table class="table border-none tBankLi">
                                    <tbody><tr>
                                        <td>

                                            <p class="f">Корпоративный счет</p>
                                            <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>
                                        </td>

                                        <td>
                                            <p class="f" title="Открытие счета без личного присутствия">
                                                С посещением банка </p>
                                            <div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>                                            </td>

                                        <td>
                                            <p class="f">Сайт банка</p>

                                            <div class="hegg">www.unicreditbank.cz</div>
                                            <!--<div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>-->
                                        </td>
                                        <td>
                                            <p class="f">Минимальный депозит</p>

                                            <div class="hegg">                                                        <div class="">
                                                    0
                                                </div>                                                </div>
                                            <!--   <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>-->
                                        </td>
                                        <td>
                                            <p class="f">Срок</p>

                                            <div class="tBankDays tBankOter"><p>14</p></div>
                                        </td>
                                        <!--<td>
                                            <p class="">Initial Deposit</p>
                                            <p class="">USD 0</p>
                                        </td>
                                        <td>
                                            <p class=""> Min. Balance</p>
                                            <p class="">USD 0</p>
                                        </td>-->
                                    </tr>
                                    </tbody></table>
                            </td>
                            <td class="col-md-4 col-lg-2 bg-green-price">
                                <div class="h6 text-center">
                                    <span>Цена</span>
                                </div>
                                <div style="font-weight: bolder; font-size: large; font-family: Verdana;" class="h6 text-center cena">€1700</div>

                                <div class="text-center" style="height:35px;">

                                    <a class="btn btn-success" href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a>
                                    <!--    <a href="/banks/unicredit-bank"
                                           class="btn btn-success">Заказать</a>-->
                                </div>
                            </td>
                        </tr>
                        </tbody></table>
                    <table data-region-assign="reg_3" class="table reg_3 table-bordered 1_0_0.00 js-filter-marker" js-filter-type-id="0" js-filter-personal="0" js-filter-min-deposit="0" style="display: table;">
                        <tbody><tr>
                            <td class="col-md-8 col-lg-2">
                                <h6>
                                    <a href="/banks/fio">FIO</a>                                    </h6>

                                <div class="no-margin inl-block">
                                    <div class="hide-for-small-down">
                                        <a href="/banks/fio"><img src="/uploads/thumbs/fiobanka1-1c2825cc96-218dda3752e0e989d1ff2e55f9d7a9d3.jpg" alt=""></a>
                                    </div>
                                    <div class="top10 row">
                                        <div class="col-xs-3"><div class="b-flag"> <div class="label flag flag-icon-background flag-icon-cz">&nbsp;</div></div></div>                                            <div class="col-xs-9"><div class="left tBankLi" style="margin: 2px 0 0 0">Чехия</div></div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden-xs hidden-sm hidden-md  col-lg-8">
                                <table class="table border-none tBankLi">
                                    <tbody><tr>
                                        <td>

                                            <p class="f">Корпоративный счет</p>
                                            <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>
                                        </td>

                                        <td>
                                            <p class="f" title="Открытие счета без личного присутствия">
                                                С посещением банка </p>
                                            <div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>                                            </td>

                                        <td>
                                            <p class="f">Сайт банка</p>

                                            <div class="hegg">www.fio.cz</div>
                                            <!--<div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>-->
                                        </td>
                                        <td>
                                            <p class="f">Минимальный депозит</p>

                                            <div class="hegg">                                                        <div class="">
                                                    0
                                                </div>                                                </div>
                                            <!--   <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>-->
                                        </td>
                                        <td>
                                            <p class="f">Срок</p>

                                            <div class="tBankDays tBankOter"><p>3</p></div>
                                        </td>
                                        <!--<td>
                                            <p class="">Initial Deposit</p>
                                            <p class="">USD 0</p>
                                        </td>
                                        <td>
                                            <p class=""> Min. Balance</p>
                                            <p class="">USD 0</p>
                                        </td>-->
                                    </tr>
                                    </tbody></table>
                            </td>
                            <td class="col-md-4 col-lg-2 bg-green-price">
                                <div class="h6 text-center">
                                    <span>Цена</span>
                                </div>
                                <div style="font-weight: bolder; font-size: large; font-family: Verdana;" class="h6 text-center cena">€900</div>

                                <div class="text-center" style="height:35px;">

                                    <a class="btn btn-success" href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a>
                                    <!--    <a href="/banks/fio"
                                           class="btn btn-success">Заказать</a>-->
                                </div>
                            </td>
                        </tr>
                        </tbody></table>
                    <table data-region-assign="reg_3" class="table reg_3 table-bordered 1_0_0.00 js-filter-marker" js-filter-type-id="0" js-filter-personal="0" js-filter-min-deposit="0" style="display: table;">
                        <tbody><tr>
                            <td class="col-md-8 col-lg-2">
                                <h6>
                                    <a href="/banks/csob">CSOB</a>                                    </h6>

                                <div class="no-margin inl-block">
                                    <div class="hide-for-small-down">
                                        <a href="/banks/csob"><img src="/uploads/thumbs/cso-961be587b1-6fe580d40dd43419e042ffab1cfecc21.jpg" alt=""></a>
                                    </div>
                                    <div class="top10 row">
                                        <div class="col-xs-3"><div class="b-flag"> <div class="label flag flag-icon-background flag-icon-cz">&nbsp;</div></div></div>                                            <div class="col-xs-9"><div class="left tBankLi" style="margin: 2px 0 0 0">Чехия</div></div>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden-xs hidden-sm hidden-md  col-lg-8">
                                <table class="table border-none tBankLi">
                                    <tbody><tr>
                                        <td>

                                            <p class="f">Корпоративный счет</p>
                                            <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>
                                        </td>

                                        <td>
                                            <p class="f" title="Открытие счета без личного присутствия">
                                                С посещением банка </p>
                                            <div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>                                            </td>

                                        <td>
                                            <p class="f">Сайт банка</p>

                                            <div class="hegg">www.csob.cz</div>
                                            <!--<div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>-->
                                        </td>
                                        <td>
                                            <p class="f">Минимальный депозит</p>

                                            <div class="hegg">                                                        <div class="">
                                                    0
                                                </div>                                                </div>
                                            <!--   <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>-->
                                        </td>
                                        <td>
                                            <p class="f">Срок</p>

                                            <div class="tBankDays tBankOter"><p>30</p></div>
                                        </td>
                                        <!--<td>
                                            <p class="">Initial Deposit</p>
                                            <p class="">USD 0</p>
                                        </td>
                                        <td>
                                            <p class=""> Min. Balance</p>
                                            <p class="">USD 0</p>
                                        </td>-->
                                    </tr>
                                    </tbody></table>
                            </td>
                            <td class="col-md-4 col-lg-2 bg-green-price">
                                <div class="h6 text-center">
                                    <span>Цена</span>
                                </div>
                                <div style="font-weight: bolder; font-size: large; font-family: Verdana;" class="h6 text-center cena">€1800</div>

                                <div class="text-center" style="height:35px;">

                                    <a class="btn btn-success" href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a>
                                    <!--    <a href="/banks/csob"
                                           class="btn btn-success">Заказать</a>-->
                                </div>
                            </td>
                        </tr>
                        </tbody></table>
                 <!--   <h4>Africa</h4>-->
                    <?php foreach ($items as $item) : ?>
                        <? if($region_name != $item->model->region_name && $item->model->region_name != 'Polar: Arctic' /*&&  $item->model->region_name!=false*/ ): ?>
                           <?php $region_name = $item->model->region_name; ?>
                           <div class='h4 top20 region-id-mark' id="reg_<?= $item->model->region_id ?>"><?= $region_name ?></div>
                        <? endif ?>
                        <table data-region-assign="reg_<?= $item->model->region_id ?>"
                            class="table reg_<?= $item->model->region_id ?> table-bordered <?= $item->model->type_id ?>_<?= $item->model->personal ?>_<?= $item->model->min_deposit ?>"
                            <? if ($item->model->type_id !== 1): ?> js-filter-type-id="1" <? else: ?> js-filter-type-id="0" <? endif; ?>
                            <? if ($item->model->personal === 1): ?> js-filter-personal="1" <? else: ?> js-filter-personal="0" <? endif; ?>
                            <? if ($item->model->min_deposit > 0): ?> js-filter-min-deposit="1" <? else: ?> js-filter-min-deposit="0" <? endif; ?>
                            >
                            <tr>
                                <td class="col-md-8 col-lg-2">
                                    <h6>
                                        <?= Html::a($item->title, ['banks/view', 'slug' => $item->slug]) ?>
                                    </h6>

                                    <div class="no-margin inl-block">
                                        <div class="hide-for-small-down">
                                            <a href="<?= Url::to(['banks/view', 'slug' => $item->slug]) ?>"><?= Html::img($item->thumb(120, 31)) ?></a>
                                        </div>
                                        <div class="top10 row">
                                            <? if ($item->model->countries[0]->alpha): ?><div class="col-xs-3"><div class="b-flag"> <div class="label flag flag-icon-background flag-icon-<?= $item->model->countries[0]->alpha ?>">&nbsp;</div></div></div><? endif ?>
                                            <div class="col-xs-9"><div class="left tBankLi" style="margin: 2px 0 0 0"><? if ($item->model->countries[0]->name_ru): ?><?= $item->model->countries[0]->name_ru ?><? else: ?><?= $item->model->location_title ?><? endif ?></div></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden-xs hidden-sm hidden-md  col-lg-8">
                                    <table class="table border-none tBankLi">
                                        <tr>
                                            <td>

                                                <?php if ($item->model->type_id === 2): ?>
                                                    <p class="f">﻿Личный счет</p>
                                                    <div class="green_yes "><i class="fa fa-check fa-3"
                                                                               aria-hidden="true"></i></div>
                                                <? else: ?>
                                                    <p class="f">Корпоративный счет</p>
                                                    <div class="green_yes "><i class="fa fa-check fa-3"
                                                                               aria-hidden="true"></i></div>
                                                <? endif; ?>
                                            </td>

                                            <td>
                                                <p class="f" title="Открытие счета без личного присутствия">
                                                    С посещением банка </p>
                                                <?php if ($item->model->personal === 1): ?>
                                                    <div class="green_yes "><i class="fa fa-check fa-3"
                                                                               aria-hidden="true"></i></div><? else: ?>
                                                    <div class="green_no"><i class="fa fa-times fa-3"
                                                                             aria-hidden="true"></i></div><? endif; ?>
                                            </td>

                                            <td>
                                                <p class="f">Сайт банка</p>

                                                <div class="hegg"><?= $item->model->website ?></div>
                                                <!--<div class="green_no"><i class="fa fa-times fa-3" aria-hidden="true"></i></div>-->
                                            </td>
                                            <td>
                                                <p class="f">Минимальный депозит</p>

                                                <div class="hegg"><? if ($item->model->min_deposit > 0): ?><?= $item->model->min_deposit ?><? else: ?>
                                                        <div class="">
                                                            0
                                                        </div><? endif ?>
                                                </div>
                                                <!--   <div class="green_yes "><i class="fa fa-check fa-3" aria-hidden="true"></i></div>-->
                                            </td>
                                            <td>
                                                <p class="f">Срок</p>

                                                <div class="tBankDays tBankOter"><p><?= $item->how_days ?></p></div>
                                            </td>
                                            <!--<td>
                                                <p class="">Initial Deposit</p>
                                                <p class="">USD 0</p>
                                            </td>
                                            <td>
                                                <p class=""> Min. Balance</p>
                                                <p class="">USD 0</p>
                                            </td>-->
                                        </tr>
                                    </table>
                                </td>
                                <td class="col-md-4 col-lg-2 bg-green-price">
                                    <div class="h6 text-center">
                                        <span>Цена</span>
                                    </div>
                                    <div style="font-weight: bolder; font-size: large; font-family: Verdana;" class="h6 text-center cena">€<?= $item->price ?></div>

                                    <div class="text-center" style="height:35px;">

                                        <a class="btn btn-success" href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a>
                                    <!--    <a href="<?= Url::to(['banks/view', 'slug' => $item->slug]) ?>"
                                           class="btn btn-success">Заказать</a>-->
                                    </div>
                                </td>
                            </tr>
                        </table>
                    <? endforeach; ?>

                </div>
            </div>
        </div>
    </section>




<? if (true): ?>
    <section id="pages" class="top30">
        <div class="block">

            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="font-color">Подробнее о наших банках</h3>
                        <div class="villaeditors-picks">
                            <div class="packages style2 remove-ext2">
                                <div class="row">
                                    <?php foreach ($banksList as $item) : ?>
                                        <div class="col-md-4">
                                            <div class="package">

                                                <div class="package-thumb">
                                                    <?= Html::img($item->thumb(240, 120)) ?>
                                                    <span><b><? if ($item->model->countries[0]->name_ru): ?><?= $item->model->countries[0]->name_ru ?><? else: ?><?= $item->model->location_title ?><?  endif;  ?></b></span>
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
                                                               <?= Html::a('Подробнее',
                                                                        ['banks/view', 'slug' => $item->slug]) ?></li>
                                                        <li class="book-btn"><i class="fa fa-shopping-basket"></i>
                                                            <a href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a>
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
<? endif; ?>