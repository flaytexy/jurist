<?php
use frontend\modules\page\api\Pages;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Image;

$this->title = $pages->seo('title', $pages->model->title);
$this->params['breadcrumbs'][] = ['label' => 'Pages', 'url' => ['pages/index']];
$this->params['breadcrumbs'][] = $pages->model->title;
?>

<section>
    <div class="block">
        <div class="container">
            <!-- 1-block -->
            <div class="row">
                <div class="col-md-12">
                    <div class="packages-detail">
                        <?php if (count($pages->photos)) : ?>
                            <div class="package-video">
                                <div>
                                    <?= Html::img(Image::thumb($pages->photos[1]->image, 800, 450), ['width' => '100%', 'height' => '100%']) ?>
                                </div>


                                <i class="fa fa-play-circle"></i>
                                <strong class="per-night"><span>$</span>750 <i>Per Night</i></strong>
                                <a href="#" class="book-btn2" title="">BOOK THIS VILL</a>
                                <iframe src="https://www.youtube.com/embed/dVTsZZh54Do"></iframe>
                            </div>
                        <?php endif; ?>
                        <div class="title1 alignleft">
                            <h1><?= $pages->seo('h1', $pages->title) ?></h1>
                            <span><?= $pages->seo('h1', $pages->short) ?></span>
                        </div>
                        <p>
                            <?= $pages->text ?>
                        </p>

                        <div class="package-features">
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
                                            <td>Заказ</td>
                                            <?php foreach ($packets as $packet) : ?>
                                                <td><a class="btn btn-success bb">Заказать</a></td>
                                            <?php endforeach; ?>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <div class="row" style="margin-top: 60px;">
                                <div class="col-md-8">
                                    <div class="all-features">
                                        <img src="/uploads/theme_villa/package-featureimg.jpg" alt="">

                                        <div class="packagefeature-overlay">
                                            <div class="packagefeature-inner">
                                                <div class="bloglist-detail">
                                                    <div class="title1 vertical">
                                                        <h2>Villa Features</h2>
                                                        <span>Provide Best Services</span>
                                                    </div>
                                                    <ul class="features-list">
                                                        <li><i class="flaticon-square"></i> Water Strg : 5000/ltr</li>
                                                        <li><i class="flaticon-volkswagen-car-side-view"></i> Parking
                                                            Capacity : 4
                                                        </li>
                                                        <li><i class="flaticon-home"></i> Bedrooms : 4</li>
                                                        <li><i class="flaticon-floor-wheel"></i> No of Floors : 2</li>
                                                        <li><i class="flaticon-private"></i> Bathrooms : 5</li>
                                                        <li><i class="flaticon-food"></i> No of Kitchen : 1</li>
                                                        <li><i class="flaticon-sport"></i> Swimming Pool : 1</li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="packageimg-gallery">
                                        <?php if (count($pages->photos)) : ?>
                                            <?php foreach ($pages->photos as $photo) : ?>
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
                        <?php foreach ($pages->tags as $tag) : ?>
                            <a href="<?= Url::to(['/pages', 'tag' => $tag]) ?>"
                               class="label label-info"><?= $tag ?></a>
                        <?php endforeach; ?>
                    </p>

                    <div class="small-muted">Views: <?= $pages->views ?></div>
                </div>
            </div>
        </div>
    </div>
</section>

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