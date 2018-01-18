<?php

use backend\modules\reserve\widgets\Reserve;
use yii\helpers\Url;
use backend\modules\currency\models\Currency;
use backend\modules\attachment\models\Attachment;

?>

<section class="reserve_1 container">
    <ul class="reserve_1__steps">
        <li class="search_done"><?= Yii::t('app', 'Результаты поиска') ?></li>
        <li class="active_step"><?= Yii::t('app', 'Дополнения') ?></li>
        <li><?= Yii::t('app', 'Водитель') ?></li>
        <li><?= Yii::t('app', 'Оплата') ?></li>
        <li><?= Yii::t('app', 'Подтверждение') ?></li>
    </ul>
    <div class="reserve_1__main">
        <div class="intro__content__left">
            <div class="intro__content__left__title">
                <p><?= Yii::t('app', 'Позвольте найти для Вас идеальный автомобиль!') ?>!</p>
            </div>
            <?= Reserve::widget(); ?>
        </div>
        <div class="reserve_1__main__right">
            <div class="reserve__info"><img src="/img/reserve/atention.png"/>
                <div class="reserve_wrapper">
                    <p>Бронируйте авто сейчас </p>
                    <p>Цены растут, автомобили распродаются — очень много людей арендует авто в городе киев в это время года.</p>
                </div>
            </div>
            <div class="reserve__date_info">
                <div class="reserve__date_info__get">
                    <div class="reserve__date_info__get__left">
                        <p><?= Yii::t('app', 'Получение'); ?></p>
                        <p><?= $reserve_data['country']; ?>, <?= $reserve_data['city_text']['title']; ?><br><?= $reserve_data['place_text']['title']; ?></p>
                    </div>
                    <div class="reserve__date_info__get__right">
                        <p><?= Yii::$app->formatter->asDate($reserve_data['date_in'], 'php:d'); ?> <span><?= Yii::$app->formatter->asDate($reserve_data['date_in'], 'php:F'); ?></span></p>
                        <p><small><?= Yii::$app->formatter->asDate($reserve_data['date_in'], 'php:l'); ?></small></p>
                        <p><?= $reserve_data['time_in'] ?></p>
                    </div>
                </div>
                <div class="reserve__date_info__get">
                    <div class="reserve__date_info__get__left">
                        <p><?= Yii::t('app', 'Возврат'); ?></p>
                        <p><?= $reserve_data['other_country']; ?>, <?= $reserve_data['other_city_text']['title']; ?><br><?= $reserve_data['other_place_text']['title']; ?></p>
                    </div>
                    <div class="reserve__date_info__get__right">
                        <p><?= Yii::$app->formatter->asDate($reserve_data['date_out'], 'php:d'); ?> <span><?= Yii::$app->formatter->asDate($reserve_data['date_out'], 'php:F'); ?></span></p>
                        <p><small><?= Yii::$app->formatter->asDate($reserve_data['date_out'], 'php:l'); ?></small></p>
                        <p><?= $reserve_data['time_out'] ?></p>
                    </div>
                </div>
            </div>
            <form action="<?= Url::to(['/reserve/default/additions']); ?>" method="post">

                <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                <input type="hidden" name="Reserve2[car_id]" value="<?= $model['id']; ?>" />

                <div class="reserve_1__main__right__list">
                    <div class="reserve_1__main__right__list__card">
                        <div class="reserve_1__main__right__list__card__img"><img src="<?= Attachment::getImage($model['thumbnail'], [165, 140]); ?>" srcset="<?= Attachment::getImage($model['thumbnail'], [330, 280]); ?> 2x"/>
                            <div class="info"><img src="/img/reserve/info.png"/><a href="#">важная информация</a></div>
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

                            <div class="reserve_1__main__right__list__card__main">
                                <div class="reserve_1__main__right__list__card__main__item small">
                                    <i class="icon-seat"></i>
                                    <div class="card_wrapper">
                                        <p><?= Yii::t('app', 'Мест') ?><br><?= $model['attr_seat'] ?: 'n/a' ?></p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item medium">
                                    <i class="icon-rear-drive"></i>
                                    <div class="card_wrapper">
                                        <p>
                                            <?= $model['attr_rear_drive'] ?: 'n/a' ?>
                                            <?= Yii::t('app', 'привод') ?>
                                        </p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item">
                                    <i class="icon-conditioner"></i>
                                    <div class="card_wrapper">
                                        <p><?= $model['attr_conditioner'] == 'Да' ? Yii::t('app', 'С кондиционером') : ($model['attr_conditioner'] == 'Нет' ? Yii::t('app', 'Без кондиционера') : 'n/a') ?></p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item small">
                                    <i class="icon-engine"></i>
                                    <div class="card_wrapper">
                                        <p><?= $model['attr_engine'] ?: Yii::t('app', 'Двигатель'); ?><br><?= $model['attr_capacity'] ?: 'n/a' ?></p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item medium">
                                    <i class="icon-fuel"></i>
                                    <div class="card_wrapper">
                                        <p><?= Yii::t('app', 'Расход топлива') ?><br><?= $model['attr_fuel'] ?: 'n/a' ?> <?= Yii::t('app', 'л./100км') ?></p>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__main__item">
                                    <i class="icon-<?= $model['attr_transmission'] == 'Автоматическая' ? 'automat' : 'transmission' ?>"></i>
                                    <div class="card_wrapper">
                                        <p><?= $model['attr_transmission'] ?: 'n/a' ?> <?= Yii::t('app', 'трансмиссия') ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="reserve_1__main__right__list__card__bottom">
                                <div class="reserve_1__main__right__list__card__bottom__item">
                                    <p><?= Currency::dayPrice($reserve_period, $model['cityPrice']); ?> / <span><?= Yii::t('app', 'день') ?></span></p>
                                </div>
                                <div class="reserve_1__main__right__list__card__bottom__item">
                                    <p><?= Yii::t('app', 'залог') ?>: <span><?= Currency::format($model['deposit']); ?></span></p>
                                </div>
                                <div class="reserve_1__main__right__list__card__bottom__item">
                                    <p><?= Yii::t('app', 'итого') ?>: <span><?= Currency::periodPrice($reserve_period, $model['cityPrice'], $model['discount_type'], $model['discount']); ?></span></p>
                                    <?php if ($model['discount_type'] && $model['discount']) { ?>
                                        <div class="label active">
                                            <p><?= Yii::t('app', 'Сейчас') ?> -<?= Currency::formatDiscount($model['discount_type'], $model['discount']); ?></p>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="reserve_1__main__right__list__free">
                        <div class="reserve_1__main__right__list__free__title">
                            <p><?= Yii::t('app', 'Мы даем вам это бесплатно') ?>:</p>
                        </div>
                        <div class="reserve_1__main__right__list__free__items">
                            <?php if ($reserve_period > 3) { ?>
                                <div class="free__item"><img src="/img/reserve/done_icon.png"/>
                                    <p><?= Yii::t('app', 'Безлимитный пробег') ?></p>
                                </div>
                            <?php } else { ?>
                                <div class="free__item has-tooltip">
                                    <img src="/img/reserve/done_icon.png"/>
                                    <p>
                                        <?= Yii::t('app', '350 км/сутки') ?>
                                        <img src="/img/reserve/info.png" class="indent-clear" title="<?= Yii::t('app', 'Безлимитный пробег доступен при аренде на 4 дня и более. Доплата за перепробег согласно тарифов компании KUZNECOV.') ?>">
                                        <span class="tooltip">
                                            <?= Yii::t('app', 'Безлимитный пробег доступен при аренде на 4 дня и более. Доплата за перепробег согласно тарифов компании KUZNECOV.') ?>
                                        </span>
                                    </p>
                                </div>
                            <?php } ?>
                            <div class="free__item"><img src="/img/reserve/done_icon.png"/>
                                <p><?= Yii::t('app', 'Внесение изменений') ?></p>
                            </div>
                            <div class="free__item"><img src="/img/reserve/done_icon.png"/>
                                <p><?= Yii::t('app', 'Assistance 24/7') ?></p>
                            </div>
                            <div class="free__item"><img src="/img/reserve/done_icon.png"/>
                                <p><?= Yii::t('app', 'Шины по сезону') ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="reserve_1__main__right__list__option">
                        <div class="reserve_1__main__right__list__option__title">
                            <p><?= Yii::t('app', 'Суперстраховка'); ?></p>
                        </div>
                        <div class="reserve_1__main__right__list__option__desc">
                            <p><?= Yii::t('app', 'Для полного душевного спокойствия.'); ?></p>
                            <p><?= Yii::t('app', 'Вы можете столкнуться с непредвиденными расходами во время поездки, поскольку некоторые типы ремонта и определенные затраты при ДТП и повреждениях не покрываются стандартной страховкой. Пакеты полного покрытия - Суперстраховка 50 и Суперстраховка 100 включают в себя эти затраты, на случай если что-то пойдет не так.'); ?></p>
                        </div>
                        <ul class="reserve_1__main__right__list__option__main">
                            <li class="option__row option__head">
                                <div class="option__col sub_title">
                                    <p>&nbsp;</p>
                                </div>
                                <div class="option__col">
                                    <label><?= Yii::t('app', 'Стандартные условия'); ?><span><?= Yii::t('app', 'включено в стоимость'); ?></span>
                                        <input type="radio" name="Reserve2[insurance]" value="0" checked/>
                                    </label>
                                </div>
                                <div class="option__col">
                                    <label><?= Yii::t('app', 'Суперстраховка 50'); ?><span><?= Currency::dayPrice($reserve_period, isset($model['additionalPrices']['insurance_50']) ? $model['additionalPrices']['insurance_50'] : 0); ?> <?= Yii::t('app', 'в день'); ?></span>
                                        <input type="radio" name="Reserve2[insurance]" value="50"/>
                                    </label>
                                </div>
                                <div class="option__col">
                                    <label><?= Yii::t('app', 'Cуперстраховка 100'); ?><span><?= Currency::dayPrice($reserve_period, isset($model['additionalPrices']['insurance_100']) ? $model['additionalPrices']['insurance_100'] : 0); ?> <?= Yii::t('app', 'в день'); ?></span>
                                        <input type="radio" name="Reserve2[insurance]" value="100"/>
                                    </label>
                                </div>
                            </li>
                            <li class="option__row">
                                <div class="option__col">
                                    <p><?= Yii::t('app', 'Залог'); ?></p>
                                </div>
                                <div class="option__col text-center"><?= Yii::t('app', 'Полный залог'); ?></div>
                                <div class="option__col text-center"><?= Yii::t('app', 'Уменьшение залога на 50%'); ?></div>
                                <div class="option__col text-center"><?= Yii::t('app', 'Без залога'); ?></div>
                            </li>
                            <li class="option__row">
                                <div class="option__col">
                                    <p><?= Yii::t('app', 'Штрафной платеж в случае ДТП'); ?></p>
                                </div>
                                <div class="option__col text-center"><?= Yii::t('app', 'В рамках залоговой суммы'); ?></div>
                                <div class="option__col text-center"><?= Yii::t('app', 'На 50% меньше стандартного'); ?></div>
                                <div class="option__col text-center"><?= Yii::t('app', 'Без штрафных платежей'); ?></div>
                            </li>
                            <li class="option__row">
                                <div class="option__col">
                                    <p><?= Yii::t('app', 'Штрафной платеж в случае в случае угона или тотального уничтожения авто'); ?></p>
                                </div>
                                <div class="option__col text-center"><?= Yii::t('app', '10% от стоимости автомобиля'); ?></div>
                                <div class="option__col text-center"><?= Yii::t('app', 'На 50% меньше стандартного'); ?></div>
                                <div class="option__col text-center"><?= Yii::t('app', 'Без штрафных платежей'); ?></div>
                            </li>
                        </ul>
                        <br>
                        <strong><?= Yii::t('app', 'ВАЖНО!!! Для того чтобы воспользоваться услугой Суперстраховка Ваш возраст должен быть не менее 25 лет, а стаж вождения не менее 3х') ?></strong>
                    </div>
                    <div class="reserve_1__main__right__list__option">
                        <div class="reserve_1__main__right__list__option__title">
                            <p><?= Yii::t('app', 'Помощь в дороге (Assistance 24/7)'); ?></p>
                        </div>
                        <div class="reserve_1__main__right__list__option__desc">
                            <p><?= Yii::t('app', 'Если вследствие поломки, ДТП или другого события, предусмотренного договором проката, автомобиль не способен передвигаться, клиенты автопроката KUZNECOV получают следующие услуги'); ?>:</p>
                        </div>
                        <ul class="reserve_1__main__right__list__option__main">
                            <li class="option__row option__head">
                                <div class="option__col sub_title">
                                    <p><?= Yii::t('app', 'Что включает'); ?>:</p>
                                </div>
                                <div class="option__col">
                                    <label><?= Yii::t('app', 'Без сервиса'); ?>
                                        <input type="radio" name="Reserve2[assistance]" value="0"/>
                                    </label>
                                </div>
                                <div class="option__col">
                                    <label><?= Yii::t('app', 'Assistance 24/7'); ?><span><?= Yii::t('app', 'всего'); ?> <?= Currency::dayPrice($reserve_period, isset($model['additionalPrices']['assistance']) ? $model['additionalPrices']['assistance'] : 0); ?> <?= Yii::t('app', 'в день'); ?></span>
                                        <input type="radio" name="Reserve2[assistance]" value="1" checked/>
                                    </label>
                                </div>
                            </li>
                            <li class="option__row">
                                <div class="option__col">
                                    <p><?= Yii::t('app', 'Эвакуация транспортного средства и подача подменного автомобиля'); ?></p>
                                </div>
                                <div class="option__col"><img src="/img/reserve/cross_icon.png"/></div>
                                <div class="option__col"><img src="/img/reserve/done_icon.png"/></div>
                            </li>
                            <li class="option__row">
                                <div class="option__col">
                                    <p><?= Yii::t('app', 'Техническая помощь в дороге'); ?></p>
                                </div>
                                <div class="option__col"><img src="/img/reserve/cross_icon.png"/></div>
                                <div class="option__col"><img src="/img/reserve/done_icon.png"/></div>
                            </li>
                            <li class="option__row">
                                <div class="option__col">
                                    <p><?= Yii::t('app', 'Доставка топлива, замена поврежденного колеса и запуск двигателя от постороннего источника питания'); ?></p>
                                </div>
                                <div class="option__col"><img src="/img/reserve/cross_icon.png"/></div>
                                <div class="option__col"><img src="/img/reserve/done_icon.png"/></div>
                            </li>
                        </ul>
                        <div><?= Yii::t('app', 'Служба поддержки KUZNECOV Assistance работает ежедневно и круглосуточно. Вне зависимости от выбранного пакета, Вам в любом случае будет представлена качественная консультация со всеми инструкциями от нашего менеджера!'); ?></div>
                    </div>
                    <div class="reserve_1__main__right__list__add">
                        <div class="reserve_1__main__right__list__add__title">
                            <p><?= Yii::t('app', 'Дополнения'); ?></p>
                        </div>
                        <p><?= Yii::t('app', 'К оплате при получении'); ?></p>
                        <small><?= Yii::t('app', 'Если вы бронируете любую из этих дополнительных услуг, вы будете платить за них в офисе проката.'); ?></small>
                        <ul class="reserve_1__main__right__list__add__main">
                            <?php foreach ($services as $service) { ?>
                                <li class="add__row">
                                    <div class="add__col add__icon"><img src="<?= Attachment::getImage($service['thumbnail'], [46, 46]); ?>" srcset="<?= Attachment::getImage($service['thumbnail'], [92, 92]); ?> 2x" /></div>
                                    <div class="add__col">
                                        <p><?= $service['translation']['title']; ?></p>
                                        <?= $service['translation']['description']; ?>
                                    </div>
                                    <div class="add__col"><span class="add_down">&mdash;</span>
                                        <input type="number" name="Reserve2[service][<?= $service['id']; ?>]"/><span class="add_up">+</span>
                                    </div>
                                    <div class="add__col">
                                        <p><span><?= Currency::format($reserve_period < 15 ? $service['price_1'] : $service['price_15']); ?></span></p>
                                        <p><?= Yii::t('app', 'в день'); ?></p>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                        <div class="more_add">
                            <p><?= Yii::t('app', 'Нужно ли вам что-нибудь еще?'); ?></p>
                            <textarea name="Reserve2[comment]"></textarea>
                        </div>
                    </div>

                    <button class="next_reserve" type="submit"><?= Yii::t('app', 'Перейти к бронированию'); ?></button>

                    <div class="reserve_step">
                        <p><?= Yii::t('app', 'ШАГ'); ?> <span>2 </span><?= Yii::t('app', 'из'); ?> <span>5</span></p>
                    </div>

                    <?php if ($models) { ?>
                        <div class="offer__content__title reserve_2_title">
                            <p><?= Yii::t('app', 'Повысьте класс автомобиля'); ?></p>
                        </div>
                        <?php foreach ($models as $model) { ?>
                        <div class="reserve_1__main__right__list__card alternate">
                            <div class="reserve_1__main__right__list__card__img"><img src="<?= Attachment::getImage($model['thumbnail'], [165, 140]); ?>" srcset="<?= Attachment::getImage($model['thumbnail'], [330, 280]); ?> 2x"/>
                                <?php if ($model['translatedSticker']) { ?>
                                    <?php
                                    $this->registerCss(".sticker-" . $model['translatedSticker']['id'] . " {color:" . $model['translatedSticker']['color'] . "!important;background:" . $model['translatedSticker']['background'] . "!important;border-color:" . $model['translatedSticker']['border'] . "!important;}");
                                    ?>
                                    <div class="label active sticker-<?= $model['translatedSticker']['id']; ?>">
                                        <p><?= $model['translatedSticker']['translation']['title']; ?></p>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="card_wrapper_main">
                                <div class="reserve_1__main__right__list__card__head">
                                    <div class="reserve_1__main__right__list__card__head__left">
                                        <div class="card_wrapper">
                                            <p>
                                                <?= $model['translatedBrand']['translation']['title']; ?>
                                                <?= $model['translatedModel']['translation']['title']; ?>
                                                <?= $model['translation']['title']; ?>
                                                <span><?= Yii::t('app', 'или аналогичный'); ?></span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="reserve_1__main__right__list__card__bottom">
                                    <div class="reserve_1__main__right__list__card__bottom__item">
                                        <p><?= Currency::dayPrice($reserve_period, $model['cityPrice']); ?> / <span><?= Yii::t('app', 'день') ?></span></p>
                                    </div>
                                    <div class="reserve_1__main__right__list__card__bottom__item">
                                        <p><?= Yii::t('app', 'залог') ?>: <span><?= Currency::format($model['deposit']); ?></span></p>
                                    </div>
                                </div><a class="reserve_1__main__right__list__card__chose" href="<?= Url::to(['', 'car' => $model['id']]) ?>"><?= Yii::t('app', 'Выбрать'); ?></a>
                            </div>
                        </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </form>
        </div>
    </div>
</section>
