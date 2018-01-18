<?php

/**
 * @var \backend\modules\reserve\models\form\DriverForm $driver_model
 */

use backend\modules\reserve\widgets\Reserve;
use yii\helpers\Url;
use backend\modules\currency\models\Currency;
use backend\modules\attachment\models\Attachment;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use backend\modules\park\models\Car;

$total_price = 0;
$total_service_price = 0;

?>

<section class="done_page container">
    <div class="done_page__title">
        <p>Ваш заказ успешно оформлен!</p>
        <p>В ближайшее время, наш менеджер свяжется с Вами для уточнения деталей заказа</p>
    </div>
    <div class="done_page__main">
        <div class="done_page__main__info">
            <div class="done_page__main__info__left">
                <img src="<?= Attachment::getImage($model['thumbnail'], [225, 190]); ?>" srcset="<?= Attachment::getImage($model['thumbnail'], [450, 380]); ?> 2x"/>
            </div>
            <div class="done_page__main__info__right">
                <div class="done_page__main__info__right__name">
                    <p>
                        <span>
                            <?= $model['translatedBrand']['translation']['title']; ?>
                            <?= $model['translatedModel']['translation']['title']; ?>
                            <?= $model['translation']['title']; ?>
                        </span>
                        <?= Yii::t('app', 'или аналогичный'); ?>
                    </p>
                </div>
                <div class="done_page__main__info__right__class">
                    <p><?= $model['translatedCategory']['translation']['title']; ?> <span><?= $model['acriss']; ?></span></p>
                </div>
                <div class="done_page__main__info__right__zakaz">
                    <p><?= Yii::t('app', 'Заказ'); ?>: <span>№<?= str_pad('1', 7, '0', STR_PAD_LEFT); ?></span></p>
                </div>
                <div class="done_page__main__info__right__date">
                    <p><?= Yii::t('app', 'Оформлен'); ?> <span><?= Yii::$app->formatter->asDatetime(time(), 'php:d.m.Y H:i:s'); ?></span></p>
                </div>
                <div class="done_page__main__info__right__pay_type">
                    <p><?= Yii::t('app', 'Способ оплаты'); ?>: <span>Банковский перевод</span></p>
                </div>
                <div class="done_page__main__info__right__pay">
                    <p><?= Yii::t('app', 'К оплате'); ?>: <span>$101.99</span></p>
                </div>
                <div class="done_page__main__info__right__actions"><a href="#">
                        <div class="img"></div>
                        <p><?= Yii::t('app', 'Wallet'); ?></p></a><a href="#">
                        <div class="img"></div>
                        <p><?= Yii::t('app', 'Cкачать PDF'); ?></p></a><a href="#" onclick="window.print(); return false;">
                        <div class="img"></div>
                        <p><?= Yii::t('app', 'Распечатать'); ?></p></a></div>
            </div>
        </div>
        <div class="done_page__main__sub">
            <div class="done_page__main__sub__title">
                <p><?= Yii::t('app', 'Сведения о водителе'); ?>:</p>
            </div>
            <div class="done_page__main__sub__desc">
                <p><?= Yii::t('app', 'Имя'); ?>: <span><?= $reserve_driver_data['first_name']; ?> <?= $reserve_driver_data['last_name']; ?></span></p>
                <p><?= Yii::t('app', 'Эл. почта'); ?>: <span><?= $reserve_driver_data['email']; ?></span></p>
                <p><?= Yii::t('app', 'Телефон'); ?>: <span><?= $reserve_driver_data['phone']; ?></span></p>
                <?php if ($reserve_driver_data['avia']) { ?>
                    <p><?= Yii::t('app', 'Номер авиарейса'); ?>: <span><?= $reserve_driver_data['avia']; ?></span></p>
                <?php } ?>
            </div>
        </div>
        <div class="done_page__main__sub location">
            <div class="done_page__main__sub__title">
                <p><?= Yii::t('app', 'Получение'); ?></p>
            </div>
            <div class="done_page__main__sub__desc">
                <p><span><?= $reserve_data['country']; ?>, <?= $reserve_data['city_text']['title']; ?><br><?= $reserve_data['place_text']['title']; ?></span></p>
                <div class="done_page__main__sub__desc__info">
                    <p><?= Yii::$app->formatter->asDate($reserve_data['date_in'], 'php:d'); ?> <span><?= Yii::$app->formatter->asDate($reserve_data['date_in'], 'php:F'); ?></span></p>
                    <p><small><?= Yii::$app->formatter->asDate($reserve_data['date_in'], 'php:l'); ?></small></p>
                    <p><?= $reserve_data['time_in'] ?></p>
                </div>
            </div>
        </div>
        <div class="done_page__main__sub location">
            <div class="done_page__main__sub__title">
                <p><?= Yii::t('app', 'Возврат'); ?></p>
            </div>
            <div class="done_page__main__sub__desc">
                <p><span><?= $reserve_data['other_country']; ?>, <?= $reserve_data['other_city_text']['title']; ?><br><?= $reserve_data['other_place_text']['title']; ?></span></p>
                <div class="done_page__main__sub__desc__info">
                    <p><?= Yii::$app->formatter->asDate($reserve_data['date_out'], 'php:d'); ?> <span><?= Yii::$app->formatter->asDate($reserve_data['date_out'], 'php:F'); ?></span></p>
                    <p><small><?= Yii::$app->formatter->asDate($reserve_data['date_out'], 'php:l'); ?></small></p>
                    <p><?= $reserve_data['time_out'] ?></p>
                </div>
            </div>
        </div>
    </div>
</section>