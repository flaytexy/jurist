<?php

/**
 * @var \yii\web\View $this
 * @var \backend\modules\seo\models\Seo|array $models
 * @var \backend\modules\seo\models\Seo $model
 * @var \yii\data\Pagination $pages
 */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Json;

?>

<div class="items-list-page">

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title">
                    SEO
                </h3>
            </div>
        </div>
    </div>
</div>

<div class="card items">
    <ul class="item-list striped">
        <li class="item item-list-header hidden-sm-down">
            <div class="item-row">
                <div class="item-col item-col-header item-col-title">
                    <div> <span>Страницы</span> </div>
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
                                <a href="<?= Url::to(['/admin/seo/default/edit', 'id' => $model->id]); ?>">
                                    <h4 class="item-title"><?= $model->title ? $model->title . ' (' . Url::to(['/' . $model->view] + Json::decode($model->action_params)) . ')' : Url::to(['/' . $model->view] + Json::decode($model->action_params)); ?></h4>
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
                                            <a class="remove" href="<?= Url::to(['/admin/seo/default/delete', 'id' => $model->id]); ?>">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="edit" href="<?= Url::to(['/admin/seo/default/edit', 'id' => $model->id]); ?>">
                                                <i class="fa fa-pencil"></i>
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
                <small><em>список страниц пуст...</em></small>
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