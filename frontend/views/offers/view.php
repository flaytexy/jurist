<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

$this->title = $offers->seo('title', $offers->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Компании', 'url' => ['offers/index']];
$this->params['breadcrumbs'][] = $offers->model->title;
?>
<style>
    .tiiitle {
        position: relative;
        -webkit-perspective: 400;
        perspective: 400;
        padding-left: 17px;
        font-family: Arial;
        font-weight: bold;
        font-size: 52px;
        text-transform: uppercase;
        color: #000000;
    }
    .tiiitle:before {
        content: '';
        display: block;
        position: absolute;
        height: 100%;
        width: 6px;
        background: #ff1212;
        top: 0;
        left: 0;
        opacity: 1;

    }
    .tiiitle .title-word {
        opacity: 1;

    }

</style>
<section>
    <div class="block">
        <div class="container">
            <!-- 1-block -->
            <div class="row">
                <div class="col-md-12">
                    <div class="packages-detail">
                        <div class="tiiitle">
                            <div class="title-word"><?= $offers->seo('h1', $offers->title) ?></div>
                            <div class="title-word"><span>$</span><?= $offers->price; ?></div>
                            <div class="title-word">Дней: <?= $offers->model->how_days; ?></div>
                        </div>
                        <!--
                        <?php if (count($offers->photos) || !empty($offers->model->image)) : ?>
                            <div class="package-video">
                                <div>
                                    <?php if (!empty($offers->model->image)) : ?>
                                        <?= Html::img(Image::thumb($offers->model->image, 1100, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? else: ?>
                                        <?= Html::img(Image::thumb($offers->photos[0]->image, 1100, 300), ['width' => '100%', 'height' => '100%']) ?>
                                    <? endif ?>
                                </div>

                               <!-- <i class="fa fa-play-circle"></i>-->
                                <strong class="per-night"><span>$</span><?= $offers->price; ?> <i>Дней: <?= $offers->model->how_days; ?></i></strong>
                                <a href="#order-zone" class="book-btn2" title="">Заказать</a>
                                <!--<iframe src="https://www.youtube.com/embed/dVTsZZh54Do"></iframe>-->
                             <!--   <div class="title-video alignleft">
                                    <h1><?= $offers->seo('h1', $offers->title) ?></h1>
                                    <span><?= $offers->seo('h1', $offers->short) ?></span>
                                </div>-->
                            </div>
                        <?php endif; ?> -->

                        <p>
                            <?= $offers->text ?>
                        </p>

                        <div class="package-features" id="order-zone">
                            <!-- 2-block -->
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <tr>
                                            <td>Пакеты</td>
                                            <?php foreach ($packets as $packet) : ?>
                                                <td><?= $packet->title ?></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <?php foreach ($options as $option) : ?>
                                            <tr>
                                                <td>
                                                    <?= $option['title'] ?>
                                                </td>
                                                <?php foreach ($option['child'] as $opt) : ?>
                                                    <td><? if ($opt) : ?><i class="fa fa-check"
                                                                            aria-hidden="true"></i><? endif; ?></td>
                                                <?php endforeach; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr>
                                            <td>Цены</td>
                                            <?php foreach ($packets as $packet) : ?>
                                                <td><span>$<?= $packet->price?></span></td>
                                            <?php endforeach; ?>
                                        </tr>
                                        <tr>
                                            <td>Заказ</td>
                                            <?php foreach ($packets as $packet) : ?>
                                                <td> <a class="btn btn-success bb" href="javascript:void( window.open( 'https://form.jotformeu.com/71136944138357', 'blank', 'scrollbars=yes, toolbar=no, width=700, height=700, align=center' ) )">Заказать</a></td>

                                            <?php endforeach; ?>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 60px;">
                                <div class="col-md-4">
                                    <div class="packageimg-gallery">
                                        <?php if (count($offers->photos)) : ?>
                                            <?php foreach ($offers->photos as $photo) : ?>
                                                <div class="packageimg-gallerythumb"><?= $photo->box(555, 483) ?></div>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Blog List Posts -->
                </div>
            </div>

            <!-- 3-block -->
            <div class="row" style="margin-top: 80px;">
                <div class="col-md-12">
                    <p>
                        <?php foreach ($offers->tags as $tag) : ?>
                            <a href="<?= Url::to(['/offers', 'tag' => $tag]) ?>"
                               class="label label-info"><?= $tag ?></a>
                        <?php endforeach; ?>
                    </p>

<!--                    <div class="small-muted">Views: --><?//= $offers->views ?><!--</div>-->
                </div>
            </div>
        </div>
    </div>
</section>
<!--
<div style="display:none">
    <div class="container-fluid" id="succes_packet">
        <form id="succes_packet_form" name="succes_packet_form" class="succes_packet_form" action="/admin/orders/send" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-6">
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="firstName">ИМЯ</label>
                            <input name="Feedback[name]" class="form-control" type="text">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="email">Е-МЕЙЛ</label>
                            <input name="Feedback[email]" class="form-control" type="email">
                        </div>
                    </div>
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="password">ТЕЛЕФОН</label>
                            <input name="Feedback[phone]" class="form-control" type="text">
                        </div>
                    </div>


                </div>
                <div class="col-md-6">
                    <div class="row-fluid">
                        <div class="form-group">
                            <label for="password">ВАШ КОММЕНТАРИЙ</label><br/>
                            <textarea name="Feedback[comment]" class="form-control" rows="7"></textarea>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12 col-lg-12" style="text-align: center;">
                    <hr>
                    <input id="top-save-button" type="submit" name="save" value="Подтвердить" class="btn btn-success regbutton" />
                </div>
            </div>
        </form>
    </div>
</div>
-->