<?php

/**
 * @var \yii\web\View $this
 * @var \app\modules\page\models\Page|array $models
 * @var \app\modules\page\models\Page $model
 * @var \yii\data\Pagination $pages
 */

use yii\helpers\Url;
use yii\widgets\LinkPager;

?>

<div class="items-list-page">

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title">
                    Валюты
                </h3>
            </div>
        </div>
    </div>
</div>


<div class="card menu-manage">
    <div class="card-header">
        <div class="header-block">
            <p class="title">Курс валют (наличный курс ПриватБанка в отделениях)</p>
        </div>
    </div>
    <div class="card-block">
        <div class="row">
            <?php foreach ($models as $model) { ?>
                <div class="col-sm-4 text-center">
                    <label><?= $model['iso']; ?></label>
                    <div><?= Yii::$app->formatter->asDecimal($model['exchange']); ?></div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="card-footer">
        <a href="<?= Url::to(['/admin/currency/update']) ?>">Обновить курс валют</a>
    </div>
</div>

<div class="card items">
    <ul class="item-list striped">
        <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
                <div class="item-col item-col-header item-col-title">
                    <div> <span>Валюты</span> </div>
                </div>
                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
        </li>
        <?php if (!empty($models)) { ?>
            <?php foreach ($models as $model) { ?>
                <li class="item">
                    <div class="item-row">

                        <div class="item-col fixed pull-left item-col-title">
                            <div class="item-heading">Заголовок</div>
                            <div>
                                <a href="<?= $model->getEditLink(); ?>">
                                    <h4 class="item-title">
                                        <?= $model->getTitle(); ?><?php if ($model->default) { ?><i class="fa fa-star" style="position:relative;left:5px"></i><?php } ?>
                                    </h4>
                                </a>
                            </div>
                        </div>

                        <div class="item-col fixed item-col-actions-dropdown">
                            <div class="item-actions-dropdown">
                                <a class="item-actions-toggle-btn">
                                    <span class="inactive"><i class="fa fa-cog"></i></span>
                                    <span class="active"><i class="fa fa-chevron-circle-right"></i></span>
                                </a>
                                <div class="item-actions-block">
                                    <ul class="item-actions-list">
                                        <li>
                                            <a class="edit" href="<?= $model->getEditLink(); ?>">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="<?= Url::to(['/admin/currency/default/default', 'id' => $model->id]); ?>">
                                                <i class="fa fa-star"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            <?php } ?>
        <?php } else { ?>
        <li class="item">
            <div class="item-row py-1">
                <small><em>список валют пуст...</em></small>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>
<nav class="text-xs-center">
    <?=
        LinkPager::widget([
            'pagination' => $pages,
            'linkOptions' => [
                'class' => 'page-link',
            ],
            'pageCssClass' => 'page-item',
            'prevPageCssClass' => 'page-item',
            'nextPageCssClass' => 'page-item',
            'disabledListItemSubTagOptions' => [
                'class' => 'page-link',
            ],
        ]);
    ?>
</nav>
</div>