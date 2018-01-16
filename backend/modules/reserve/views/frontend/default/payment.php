<?php

/**
 * @var \app\modules\reserve\models\form\DriverForm $driver_model
 */

use app\modules\reserve\widgets\Reserve;
use yii\helpers\Url;
use app\modules\currency\models\Currency;
use app\modules\attachment\models\Attachment;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use app\modules\park\models\Car;

$total_price = 0;
$total_service_price = 0;

?>

<section class="reserve_1 container reserve_4">
    <ul class="reserve_1__steps">
        <li class="search_done done_step_prev"><?= Yii::t('app', 'Результаты поиска') ?></li>
        <li class="done_step"><?= Yii::t('app', 'Дополнения') ?></li>
        <li class="done_step"><?= Yii::t('app', 'Водитель') ?></li>
        <li class="active_step"><?= Yii::t('app', 'Оплата') ?></li>
        <li><?= Yii::t('app', 'Подтверждение') ?></li>
    </ul>
    <div class="reserve_1__main">
        <div class="intro__content__left">
            <div class="payment_details">
                <div class="pay_wrapper title_pay">
                    <p><?= Yii::t('app', 'Подробный расчет'); ?></p>
                </div>
                <div class="pay_wrapper">
                    <p><?= Yii::t('app', 'Стоимость аренды авто'); ?></p>
                    <?php
                        $car_price = Currency::periodPrice($reserve_data['period'], $model['cityPrice'], $model['discount_type'], $model['discount'], false);
                        $total_price += $car_price;
                    ?>
                    <p><?= Currency::format($car_price); ?></p>
                </div>
                <?php if ($reserve_additions_data['insurance'] && isset($model['additionalPrices']['insurance_' . $reserve_additions_data['insurance']])) { ?>
                <div class="pay_wrapper">
                    <p><?= Yii::t('app', 'Полное покрытие'); ?></p>
                    <?php
                        $insurance_price = Currency::periodPrice($reserve_data['period'], $model['additionalPrices']['insurance_' . $reserve_additions_data['insurance']], null, 0, false);
                        $total_price += $insurance_price;
                    ?>
                    <p><?= Currency::format($insurance_price); ?></p>
                </div>
                <?php } ?>
                <?php if ($reserve_additions_data['assistance'] && isset($model['additionalPrices']['assistance'])) { ?>
                <div class="pay_wrapper">
                    <p><?= Yii::t('app', 'Ассистанс 24/7'); ?></p>
                    <?php
                        $assistance_price = Currency::periodPrice($reserve_data['period'], $model['additionalPrices']['assistance'], null, 0,false);
                        $total_price += $assistance_price;
                    ?>
                    <p><?= Currency::format($assistance_price); ?></p>
                </div>
                <?php } ?>
                <?php foreach ($reserve_additions_data['service'] as $service) { ?>
                <div class="pay_wrapper">
                    <p><?= $service['title']; ?></p>
                    <?php
                        $service_price = $reserve_data['period'] * $service['quantity'] * $service['price'];
                        $total_service_price += $service_price;
                        $total_price += $service_price;
                    ?>
                    <p><?= Currency::format($service_price); ?></p>
                </div>
                <?php } ?>
                <div class="pay_wrapper pay_total">
                    <p><?= Yii::t('app', 'Общая стоимость'); ?>: <span><?= Currency::format($total_price); ?></span></p>
                </div>
                <div class="pay_wrapper pay_total">
                    <p><?= Yii::t('app', 'Залог'); ?>: <span><?= Currency::format($model['deposit'] - $reserve_additions_data['insurance'] / 100 * $model['deposit']); ?></span></p>
                </div>
            </div>
            <div class="info_step_4"><img src="/img/reserve/done_icon_lg.png"/>
                <p>Никаких сборов за использование кредитных карт</p>
            </div>
            <div class="info_step_4 car_promo"><img src="/img/reserve/fast.png"/>
                <p>Этот автомобиль пользуется большим спросом!</p>
            </div>
        </div>
        <div class="reserve_1__main__right step3_page">
            <div class="reserve_1__main__right__list__card">
                <div class="reserve_1__main__right__list__card__img">
                    <img src="<?= Attachment::getImage($model['thumbnail'], [165, 140]); ?>" srcset="<?= Attachment::getImage($model['thumbnail'], [330, 280]); ?> 2x"/>
                </div>
                <div class="card_wrapper_main">
                    <div class="reserve_1__main__right__list__card__head">
                        <div class="reserve_1__main__right__list__card__head__left">
                            <div class="card_wrapper">
                                <p>
                                    <?= $model['translatedBrand']['translation']['title']; ?>
                                    <?= $model['translatedModel']['translation']['title']; ?>
                                    <?= $model['translation']['title']; ?>
                                    <span><?= Yii::t('app', 'или аналогичный') ?></span>
                                </p>
                                <p><?= $model['translatedCategory']['translation']['title']; ?> <span><?= $model['acriss']; ?></span></p>
                            </div>
                        </div>
                    </div>
                    <div class="reserve_1__main__right__list__card__bottom step_3_card">
                        <div class="reserve_1__main__right__list__card__bottom__item">
                            <p><?= Yii::t('app', 'Получение'); ?></p>
                            <p><?= $reserve_data['country']; ?>, <?= $reserve_data['city_text']['title']; ?><br><?= $reserve_data['place_text']['title']; ?></p>
                        </div>
                        <div class="reserve_1__main__right__list__card__bottom__item">
                            <p><?= Yii::$app->formatter->asDate($reserve_data['date_in'], 'php:d'); ?> <span><?= Yii::$app->formatter->asDate($reserve_data['date_in'], 'php:F'); ?></span></p>
                            <p><small><?= Yii::$app->formatter->asDate($reserve_data['date_in'], 'php:l'); ?></small></p>
                            <p><?= $reserve_data['time_in'] ?></p>
                        </div>
                        <div class="reserve_1__main__right__list__card__bottom__item">
                            <div class="offer__content__more"><a href="#" class="datetime-edit" data-datetime="in"><?= Yii::t('app', 'Изменить'); ?>
                                    <div class="offer__content__more__overlay"></div></a></div>
                        </div>
                    </div>
                    <div class="reserve_1__main__right__list__card__bottom step_3_card">
                        <div class="reserve_1__main__right__list__card__bottom__item">
                            <p><?= Yii::t('app', 'Возврат'); ?></p>
                            <p><?= $reserve_data['other_country']; ?>, <?= $reserve_data['other_city_text']['title']; ?><br><?= $reserve_data['other_place_text']['title']; ?></p>
                        </div>
                        <div class="reserve_1__main__right__list__card__bottom__item">
                            <p><?= Yii::$app->formatter->asDate($reserve_data['date_out'], 'php:d'); ?> <span><?= Yii::$app->formatter->asDate($reserve_data['date_out'], 'php:F'); ?></span></p>
                            <p><small><?= Yii::$app->formatter->asDate($reserve_data['date_out'], 'php:l'); ?></small></p>
                            <p><?= $reserve_data['time_out'] ?></p>
                        </div>
                        <div class="reserve_1__main__right__list__card__bottom__item">
                            <div class="offer__content__more"><a href="#" class="datetime-edit" data-datetime="out"><?= Yii::t('app', 'Изменить'); ?>
                                    <div class="offer__content__more__overlay"></div></a></div>
                        </div>
                    </div>
                    <div class="reserve_1__main__right__list__card__bottom step_3_card step_4_card">
                        <div class="reserve_1__main__right__list__card__bottom__item">
                            <p><?= Yii::t('app', 'Дополнения'); ?>:</p>
                            <p>
                            <?php if ($reserve_additions_data['service']) { ?>
                                <?php foreach ($reserve_additions_data['service'] as $service) { ?>
                                    <?= $service['title']; ?><br>
                                <?php } ?>
                            <?php } else { ?>
                                <?= Yii::t('app', 'Ничего не выбрано'); ?>
                            <?php } ?>
                            </p>
                        </div>
                        <div class="reserve_1__main__right__list__card__bottom__item">
                            <div class="offer__content__more"><a href="#" id="services-edit"><?= Yii::t('app', 'Изменить'); ?>
                                    <div class="offer__content__more__overlay"></div></a></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="about_driver">
                <div class="about_driver__title">
                    <p><?= Yii::t('app', 'Сведения о водителе'); ?></p>
                </div>
                <div class="about_driver__desc">
                    <p><?= Yii::t('app', 'Имя'); ?>: <span><?= $reserve_driver_data['first_name']; ?> <?= $reserve_driver_data['last_name']; ?></span></p>
                    <p><?= Yii::t('app', 'Эл. почта'); ?>: <span><?= $reserve_driver_data['email']; ?></span></p>
                    <p><?= Yii::t('app', 'Телефон'); ?>: <span><?= $reserve_driver_data['phone']; ?></span></p>
                    <?php if ($reserve_driver_data['avia']) { ?>
                        <p><?= Yii::t('app', 'Номер авиарейса'); ?>: <span><?= $reserve_driver_data['avia']; ?></span></p>
                    <?php } ?>
                </div>
            </div>
            <?php if (!$reserve_additions_data['insurance']) { ?>
            <div class="franshiza">
                <div class="franshiza__left"><img src="/img/reserve/fransh.png"/></div>
                <div class="franshiza__right">
                    <p><?= Yii::t('app', 'Ваша франшиза защищена?'); ?></p>
                    <p><?= Yii::t('app', 'Вы можете столкнуться с непредвиденными расходами во время поездки, поскольку некоторые типы ремонта и определенные затраты при ДТП и повреждениях не покрываются стандартной страховкой. Суперстраховка включают в себя эти затраты, на случай если что-то пойдет не так.'); ?></p>
                    <div class="offer__content__more">
                        <a href="#">
                            <?= Yii::t('app', 'Подробнее'); ?>
                            <div class="offer__content__more__overlay"></div>
                        </a>
                    </div>
                    <a class="full_cover" href="#"><?= Yii::t('app', 'Добавить полное покрытие'); ?></a>
                </div>
            </div>
            <?php } ?>
            <form action="<?= Url::to(['payment']); ?>" method="post">
                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <div class="payment">
                    <div class="payment__title">
                        <p><?= Yii::t('app', 'Выберите вариант оплаты'); ?></p>
                    </div>
                    <div class="payment__body">
                        <div class="pay_wrapper">
                            <label>
                                <input type="radio" name="payment" value="full" checked="checked"/><?= Yii::t('app', 'Полная оплата'); ?>
                            </label>
                            <p>
                                <?= Yii::t('app', 'При полной оплате вы получаете <strong>3% скидку на Ваш заказ</strong>. Вы не оплачиваете дополнения, которые необходимо будет оплатить при получении автомобиля.'); ?>
                                <?php
                                    $total_price += ($model['deposit'] - $reserve_additions_data['insurance'] / 100 * $model['deposit']) - $total_service_price;
                                    $discount = 3 / 100 * $total_price;
                                ?>
                                <span><?= Currency::format($total_price - $discount); ?></span>
                                <br>
                                -3% = <?= Currency::format($discount); ?>
                            </p>
                        </div>
                        <div class="pay_wrapper">
                            <label>
                                <input type="radio" name="payment" value="reservation" /><?= Yii::t('app', 'Оплата резервации'); ?>
                            </label>
                            <p><?= Yii::t('app', 'Данная сумму будет вычтена из общей суммы проката при получении автомобиля.'); ?><span><?= Currency::format(15); ?></span></p>
                        </div>
                    </div>
                </div>
                <div class="news_open_page__main__nav">
                    <button class="next_reserve" type="submit"><?= Yii::t('app', 'Бронирование'); ?></button>
                </div>
            </form>
            <div class="reserve_step">
                <p><?= Yii::t('app', 'ШАГ'); ?> <span>4</span> <?= Yii::t('app', 'из'); ?> <span>5</span></p>
            </div>
            <div class="reserve_info_bottom">
                <p>
                    <?= Yii::t('app', 'Чтобы забронировать автомобиль и принять <a href="{rent-condition}">Условия аренды</a>, нажмите <span>«Бронировать»</span>. Мы отправим вам эл. письмо со всей информацией которую вам необходимо знать.', ['rent-condition' => Url::to(['/page/default/rent-condition'])]); ?>
                </p>
            </div>
        </div>
    </div>
</section>
<?php ob_start(); ?>
    <script>
        $(document).on('click', '.datetime-edit', function(e) {
            e.preventDefault();

            var $this = $(this);

            $.post(
                '<?= Url::to(['/reserve/ajax/datetime-form']) ?>',
                {
                    datetime: $(this).data('datetime')
                },
                function (data) {
                    $('body').addClass('no-scroll no-scroll-padding').append(data);
                    $('.header').addClass('no-scroll-padding');

                    initDatePicker();
                    $('.input-dropdown .variants').show().mCustomScrollbar({advanced: {updateOnContentResize: false}}).hide();
                }
            );
        });
        $(document).on('click', '#services-edit', function(e) {
            e.preventDefault();

            var $this = $(this);

            $.post(
                '<?= Url::to(['/reserve/ajax/services-form']) ?>',
                function (data) {
                    $('body').addClass('no-scroll no-scroll-padding').append(data);
                    $('.header').addClass('no-scroll-padding');
                }
            );
        });
    </script>
<?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
<?php ob_end_clean(); ?>

<?php $this->registerJs($script); ?>