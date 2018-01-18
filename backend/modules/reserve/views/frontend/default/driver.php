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

?>

<section class="reserve_1 container">
    <ul class="reserve_1__steps">
        <li class="search_done done_step_prev"><?= Yii::t('app', 'Результаты поиска') ?></li>
        <li class="done_step"><?= Yii::t('app', 'Дополнения') ?></li>
        <li class="active_step"><?= Yii::t('app', 'Водитель') ?></li>
        <li><?= Yii::t('app', 'Оплата') ?></li>
        <li><?= Yii::t('app', 'Подтверждение') ?></li>
    </ul>
    <div class="reserve_1__main">
        <div class="intro__content__left indent-clear">
            <div class="reserve_timer">
                <div class="reserve_timer__title">
                    <p><?= Yii::t('app', 'Ваше путешествие начинается через') ?>:</p>
                </div>
                <div class="reserve_timer__items">
                    <div class="countdown">
                        <div class="countdown-time">
                            <ul class="clearfix" id="js-countDown">
                                <?php
                                    $reserve_start_in = \backend\modules\reserve\models\Reserve::secondsToTime(strtotime($reserve_data['date_in'] . ' ' . $reserve_data['time_in']) - time());
                                ?>

                                <li class="item"><i class="day"><?= $reserve_start_in['d']; ?></i><span> <?= Yii::t('app', '{d, plural, =0{дней} one{день} few{дня} many{дней} other{день}}', ['d' => $reserve_start_in['d']]); ?></span></li>
                                <li class="blank">:</li>
                                <li class="item"><i class="hour"><?= $reserve_start_in['h']; ?></i><span> <?= Yii::t('app', '{h, plural, =0{часов} one{час} few{часа} many{часов} other{час}}', ['h' => $reserve_start_in['h']]); ?></span></li>
                                <li class="blank">:</li>
                                <li class="item"><i class="minute"><?= $reserve_start_in['m']; ?></i><span> <?= Yii::t('app', '{m, plural, =0{минут} one{минута} few{минуты} many{минут} other{минута}}', ['m' => $reserve_start_in['m']]); ?></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="links">
                <div class="links__title">
                    <p><?= Yii::t('app', 'Полезные ссылки'); ?></p>
                </div>
                <a href="#">Аренда авто в Киеве</a>
                <a href="#">Аренда авто в Киеве авто в Киеве</a>
            </div>
        </div>
        <div class="reserve_1__main__right step3_page">
            <div class="reserve__info"><img src="/img/reserve/done_icon.png"/>
                <div class="reserve_wrapper">
                    <p>Поздравляем! вы выбрали отличный автомобиль эконом класса</p>
                    <p>Чтобы обеспечить себе  эту цену, просто нажмите «Бронировать сейчас»</p>
                </div>
            </div>
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
                </div>
            </div>
            <?php $form = ActiveForm::begin(); ?>
            <div class="about_driver">
                <div class="about_driver__title">
                    <p><?= Yii::t('app', 'Сведения о водителе'); ?></p>
                </div>
                <div class="about_driver__desc">
                    <p><?= Yii::t('app', 'Пожалуйста, введите имя, которое указано в вашем паспорте или международном водельском удостоверении'); ?></p>
                </div>
                <div class="about_driver__main">

                    <?=
                        $form->field($driver_model, 'first_name', ['options' => ['class' => 'form_wrapper']])
                            ->label('* ' . $driver_model->getAttributeLabel('first_name'))
                            ->textInput(['class' => false])
                            ->error(false);
                    ?>

                    <?=
                        $form->field($driver_model, 'last_name', ['options' => ['class' => 'form_wrapper']])
                            ->label('* ' . $driver_model->getAttributeLabel('last_name'))
                            ->textInput(['class' => false])
                            ->error(false);
                    ?>

                    <?=
                        $form->field($driver_model, 'phone', ['options' => ['class' => 'form_wrapper']])
                            ->label('* ' . $driver_model->getAttributeLabel('phone'))
                            ->textInput(['class' => false])
                            ->error(false);
                    ?>

                    <?=
                        $form->field($driver_model, 'email', ['options' => ['class' => 'form_wrapper']])
                            ->label('* ' . $driver_model->getAttributeLabel('email'))
                            ->textInput(['class' => false])
                            ->error(false);
                    ?>

                    <div class="form_wrapper">
                        <label for="card"><?= $driver_model->getAttributeLabel('card'); ?></label>
                        <input type="text" id="card" name="<?= Html::getInputName($driver_model, 'card'); ?>" value="<?= $driver_model->card; ?>"/>
                    </div>
                    <div class="form_wrapper">
                        <label for="avia"><?= $driver_model->getAttributeLabel('avia'); ?></label>
                        <input type="text" id="avia" name="<?= Html::getInputName($driver_model, 'avia'); ?>" value="<?= $driver_model->avia; ?>"/>
                    </div>
                    <div class="about_driver__more">
                        <div class="about_driver__more__title">
                            <p><?= Yii::t('app', 'Дополнительная информация'); ?></p>
                        </div>
                        <div class="about_driver__more__desc">
                            <p><?= Yii::t('app', 'Для более оперативного оформления Вашего заказа, вы можете прикрепить необходимые документы (паспорт, водительское  удостоверение)'); ?></p>
                        </div>
                        <div class="about_driver__more__upload">
                            <?=
                                $form->field(
                                        $driver_model,
                                        'driverFiles',
                                        [
                                            'options' => [
                                                'tag' => false,
                                            ]
                                        ]
                                    )
                                    ->fileInput([
                                        'class' => 'documents jfilestyle',
                                        'multiple' => 'multiple',
                                        'data' => [
                                            'theme' => 'blue',
                                            'input' => 'false',
                                            'buttonText' => '<span class=\'file_icon\'></span>',
                                        ],
                                    ])
                                    ->error(false)
                                    ->label(false);
                            ?>
                            <div class="jpreview-container" id="preview-container">
                                <?php if ($driver_model->realDriverFiles) { ?>
                                    <div class="document-preview-title"><?= Yii::t('app', 'Выбраные файлы'); ?></div>
                                    <?php foreach ($driver_model->realDriverFiles as $realDriverFile) { ?>
                                        <?php
                                        $realDriverFile_data = json_decode($realDriverFile);
                                        ?>
                                        <span class="document-preview-file"><?= $realDriverFile_data->name; ?><span class="document-preview-close">×</span><input type="hidden" name="<?= Html::getInputName($driver_model, 'realDriverFiles[]'); ?>" value='<?= $realDriverFile; ?>'></span>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="news_open_page__main__nav">
                <a class="news_open_page__main__nav__left" href="<?= Url::to(['/reserve/default/additions', 'car' => $reserve_additions_data['car_id']]); ?>">
                    <img src="/img/cars/arrow_left.png"/>
                    <p><?= Yii::t('app', 'Назад'); ?></p>
                </a>
                <button type="submit" class="next_reserve"><?= Yii::t('app', 'Перейти к бронированию'); ?></button>
            </div>
            <div class="reserve_step">
                <p><?= Yii::t('app', 'ШАГ'); ?> <span>3 </span><?= Yii::t('app', 'из'); ?> <span>5</span></p>
            </div>
            <div class="mailing">
                <p><?= Yii::t('app', 'Не пропустите!'); ?></p>
                <p><?= Yii::t('app', 'Для эксклюзивного доступа к спецпредложениям, просто подпишитесь на нашу электронную рассылку. Мы не будем передавать ваши данные кому бы то ни было - вы можете отказаться от подписки в любой момент.'); ?></p>
                <div class="custom_input_wrapper">
                    <?= $form->field($driver_model, 'subscribe', ['options' => ['tag' => false]])->checkbox([], false)->error(false)->label(false); ?>
                    <label for="<?= Html::getInputId($driver_model, 'subscribe'); ?>"><?= $driver_model->getAttributeLabel('subscribe'); ?></label>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
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

    $(document).on('change', '#<?= Html::getInputId($driver_model, 'driverFiles'); ?>', function(e) {
        var files = e.originalEvent.target.files;

        var file_input_name = '<?= Html::getInputName($driver_model, 'realDriverFiles[]'); ?>';

        $('#preview-container')
            .empty()
            .append('<div class="document-preview-title"><?= Yii::t('app', 'Выбраные файлы'); ?></div>');

        $.each(files, function () {
            var reader = new FileReader();

            reader.onload = (function (file) {
                return function (e) {
                    var fileData = { name : file.name, data : e.target.result };

                    $('#preview-container').append('<span class="document-preview-file">' + fileData.name.substring(0, fileData.name.lastIndexOf('.')) + '<span class="document-preview-close">×</span><input type="hidden" name="' + file_input_name + '" value=\'{"name":"' + fileData.name + '","data":"' + fileData.data + '"}\'></span>');
                };
            })(this);

            reader.readAsDataURL(this);
        });

        $(this).replaceWith($("<div />").append($(this).clone()).html());
    });

    $(document).on('click', '.document-preview-close', function () {
        $(this).closest('.document-preview-file').remove();

        if (!$('.document-preview-file').length) {
            $('#preview-container').empty();
        }
    });
</script>
<?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
<?php ob_end_clean(); ?>
<?php $this->registerJs($script); ?>