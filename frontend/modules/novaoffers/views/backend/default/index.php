<?php

/**
 * @var \yii\web\View $this
 * @var \frontend\modules\novaoffers\models\Novaoffers|array $models
 * @var \frontend\modules\novaoffers\models\Novaoffers $model
 * @var \yii\data\Pagination $pages
 */

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\Html;

use frontend\modules\novaoffers\models\Novaoffers;

$moduleName = $this->context->module->id;

?>

<div class="items-list-page">

<div class="title-search-block">
    <div class="title-block">
        <div class="row">
            <div class="col-md-6">
                <h3 class="title">
                    Компании
                    <a href="<?= Url::to(['/admin/novaoffers/default/edit', 'id' => 0]); ?>" class="btn btn-primary btn-sm rounded-s">
                        добавить
                    </a>
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
                    <div> <span>Компании</span> </div>
                </div>
                <div class="item-col item-col-header fixed item-col-actions-dropdown"> </div>
            </div>
        </li>
        <?php if (!empty($models)) { ?>
            <table class="table table-hover">
                <thead>
                <tr>
                    <?php if(IS_ROOT) : ?>
                        <th width="50">#</th>
                    <?php endif; ?>
                    <th width="170"><?= Yii::t('easyii', 'Img') ?></th>
                    <th><?= Yii::t('easyii', 'Title') ?></th>
                    <th width="120"><?= Yii::t('easyii', 'Views') ?></th>
                    <th width="100"><?= Yii::t('easyii', 'Date') ?></th>
                    <th width="80"><?= Yii::t('easyii', 'public_status') ?></th>
                    <th width="70"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach($models as $model) : ?>
                    <tr data-id="<?= $model->primaryKey ?>">
                        <?php if(IS_ROOT) : ?>
                            <td><?= $model->primaryKey ?></td>
                        <?php endif; ?>
                        <td>
                            <?php if($model->pre_image) : ?>
                                <img src="<?= \frontend\helpers\Image::thumb($model->pre_image, 160,90) ?>">
                            <?php endif; ?>
                        </td>

                        <td><a href="<?= $model->getEditLink(); ?>"><? if($model->title): ?><?= $model->title ?><? else: ?><?= $model->id ?><? endif;?></a></td>
                        <td><?= $model->views ?></td>
                        <td><?= $model->date ?></td>
                        <td class="public_status">
                            <?= Html::checkbox('status', $model->status == $model::STATUS_ON, [
                                'class' => 'switch',
                                'data-id' => $model->primaryKey,
                                'data-link' => Url::to(['/admin/'.$moduleName.'/default']),
                            ]) ?>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm" role="group">

                                <a href="<?= Url::to(['/admin/'.$moduleName.'/default/up', 'id' => $model->primaryKey]) ?>" class="btn btn-default move-up" title="<?= Yii::t('easyii', 'Move up') ?>"><span class="glyphicon glyphicon-arrow-up"></span></a>
                                <a href="<?= Url::to(['/admin/'.$moduleName.'/default/down', 'id' => $model->primaryKey]) ?>" class="btn btn-default move-down" title="<?= Yii::t('easyii', 'Move down') ?>"><span class="glyphicon glyphicon-arrow-down"></span></a>

                                <!--<a href="<?= Url::to(['/admin/'.$moduleName.'/default/delete', 'id' => $model->primaryKey]) ?>" class="btn btn-default confirm-delete" title="<?= Yii::t('easyii', 'Delete item') ?>"><span class="glyphicon glyphicon-remove"></span></a>-->
                            </div>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
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
        <?php } else { ?>
        <li class="item">
            <div class="item-row py-1">
                <small><em>список новостей пуст...</em></small>
            </div>
        </li>
        <?php } ?>
    </ul>
</div>

</div>