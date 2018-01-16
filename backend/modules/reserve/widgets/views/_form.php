<?php

/**
 * @var array $cities
 */

use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?php
    $form = ActiveForm::begin([
        'action' => Url::to(['/reserve/default/index']),
        'method' => 'post',
        'options' => [
            'class' => 'form-reserve',
            'csrf' => false,
        ],
    ]);
?>
    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
    <input type="hidden" name="Reserve[car_id]" value="<?= $car_id; ?>" />
    <div id="reserve-pickup">
        <div class="reserve-row clearfix">
            <label class="reserve-label"><?= Yii::t('app', 'Страна') ?></label>
            <div class="reserve-input">
                <div class="input-dropdown">
                    <input type="hidden" name="Reserve[country]" value="Украина">
                    <i class="icon-chevron-down input-dropdown-toggle"></i>
                    <div class="value"><?= Yii::t('app', 'Украина'); ?></div>
                    <div class="variants">
                        <div class="variant"><?= Yii::t('app', 'Украина'); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reserve-row clearfix">
            <label class="reserve-label"><?= Yii::t('app', 'Город') ?></label>
            <div class="reserve-input">
                <div class="input-dropdown">
                    <i class="icon-chevron-down input-dropdown-toggle"></i>
                    <input type="hidden" name="Reserve[city]" class="reserve_city" value="<?= $city['value']; ?>">
                    <div class="value"><?= $city['text']; ?></div>
                    <div class="variants">
                        <?php foreach ($cities as $city) { ?>
                            <div class="variant" data-value="<?= $city['id']; ?>"><?= $city['translation']['title']; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="reserve-row clearfix">
            <label class="reserve-label"><?= Yii::t('app', 'Место') ?></label>
            <div class="reserve-input">
                <div class="input-dropdown">
                    <i class="icon-chevron-down input-dropdown-toggle"></i>
                    <input type="hidden" name="Reserve[place]" value="<?= $place['value']; ?>">
                    <div class="value"><?= $place['text']; ?></div>
                    <div class="variants reserve_city_variants">
                        <?php foreach ($places as $place) { ?>
                            <div class="variant<?= $place['id'] ? '" data-value="' . $place['id'] : ' disabled' ?>"><?= $place['title']; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="reserve-row clearfix">
        <label class="reserve-label indent-clear"></label>
        <div class="reserve-input">
            <div class="input-checkbox">
                <label>
                    <span class="input-checkbox-wrapper">
                        <input type="checkbox" name="Reserve[other_out]"<?= $other_out ? ' checked' : ''; ?>>
                        <span class="input-checkbox-element"></span>
                    </span>
                    <?= Yii::t('app', 'Возврат авто в другом местоположении'); ?>
                </label>
            </div>
        </div>
    </div>
    <div class="reserve-dropoff<?= $other_out ? '' : ' hidden'; ?>">
        <div class="reserve-row clearfix">
            <label class="reserve-label"><?= Yii::t('app', 'Страна'); ?></label>
            <div class="reserve-input">
                <div class="input-dropdown">
                    <input type="hidden" name="Reserve[other_country]" value="Украина">
                    <i class="icon-chevron-down input-dropdown-toggle"></i>
                    <div class="value"><?= Yii::t('app', 'Украина'); ?></div>
                    <div class="variants">
                        <div class="variant"><?= Yii::t('app', 'Украина'); ?></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="reserve-row clearfix">
            <label class="reserve-label"><?= Yii::t('app', 'Город') ?></label>
            <div class="reserve-input">
                <div class="input-dropdown">
                    <i class="icon-chevron-down input-dropdown-toggle"></i>
                    <input type="hidden" name="Reserve[other_city]" class="reserve_other_city" value="<?= $other_city['value']; ?>">
                    <div class="value"><?= $other_city['text']; ?></div>
                    <div class="variants">
                        <?php foreach ($cities as $city) { ?>
                            <div class="variant" data-value="<?= $city['id']; ?>"><?= $city['translation']['title']; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="reserve-row clearfix">
            <label class="reserve-label"><?= Yii::t('app', 'Место') ?></label>
            <div class="reserve-input">
                <div class="input-dropdown">
                    <i class="icon-chevron-down input-dropdown-toggle"></i>
                    <input type="hidden" name="Reserve[other_place]" value="<?= $other_place['value']; ?>">
                    <div class="value"><?= $other_place['text']; ?></div>
                    <div class="variants reserve_other_city_variants">
                        <?php foreach ($other_places as $place) { ?>
                        <div class="variant<?= $place['id'] ? '" data-value="' . $place['id'] : ' disabled' ?>"><?= $place['title']; ?></div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <label for="input-service_date_leave"><?= Yii::t('app', 'Дата и время подачи'); ?></label>
    <div class="date_time_wrapper">
        <i class="icon-calendar"></i>
        <input class="text date required input-service_date_leave" type="text" value="<?= $date_in; ?>" name="Reserve[date_in]" readonly="readonly"/>
        <div class="input-service_time_leave">

            <div class="input-dropdown">
                <i class="icon-clock"></i>
                <i class="icon-chevron-down input-dropdown-toggle"></i>
                <input type="hidden" name="Reserve[time_in]" value="<?= $time_in; ?>">
                <div class="value"><?= $time_in; ?></div>
                <div class="variants">
                    <?php for ($i = 0; $i < 24; $i++) { ?>
                        <div class="variant"><?= substr('0' . $i, -2); ?>:00</div>
                        <div class="variant"><?= substr('0' . $i, -2); ?>:30</div>
                    <?php } ?>
                </div>
            </div>

        </div>
    </div>
    <label for="input-service_date_return"><?= Yii::t('app', 'Дата и время возврата'); ?></label>
    <div class="date_time_wrapper">
        <i class="icon-calendar"></i>
        <input class="text date input-service_date_return" type="text" value="<?= $date_out; ?>" name="Reserve[date_out]" readonly="readonly"/>
        <div class="input-service_time_return">
            <div class="input-dropdown">
                <i class="icon-clock"></i>
                <i class="icon-chevron-down input-dropdown-toggle"></i>
                <input type="hidden" name="Reserve[time_out]" value="<?= $time_out; ?>">
                <div class="value"><?= $time_out; ?></div>
                <div class="variants">
                    <?php for ($i = 0; $i < 24; $i++) { ?>
                        <div class="variant"><?= substr('0' . $i, -2); ?>:00</div>
                        <div class="variant"><?= substr('0' . $i, -2); ?>:30</div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <input type="submit" value="<?= $button_text; ?>"/>
<?php ActiveForm::end(); ?>

<?php ob_start(); ?>
<script>
    $(document).off('change', '.reserve_city, .reserve_other_city').on('change', '.reserve_city, .reserve_other_city', function(e) {
        e.preventDefault();

        var $this = $(this),
            $form = $this.closest('.form-reserve');

        $.post(
            '<?= Url::to(['/reserve/ajax/get-places']) ?>',
            {
                city_id: $this.val()
            },
            function (data) {
                if (data) {
                    var $variants = $('.' + $this.attr('class') + '_variants', $form);

                    $variants.mCustomScrollbar('destroy');

                    $variants.empty();

                    for (var i in data) {
                        $variants.append('<div class="variant" data-value="' + data[i].id + '">' + data[i].title + '</div>');
                    }

                    $variants.show().mCustomScrollbar({advanced: {updateOnContentResize: false}}).hide();
                }

                $variants.prev('.value').text('Выберите место').prev('input').val('');
            }
        );
    });

    $(document).on('submit', '.form-reserve', function (e) {
        $('.form-reserve-error', this).remove();
        if (($('input[name="Reserve[city]"]', this).val() === '' || $('input[name="Reserve[place]"]', this).val() === '') || ($('input[name="Reserve[other_out]"]', this).is(':checked') && ($('input[name="Reserve[other_city]"]', this).val() === '' || $('input[name="Reserve[other_place]"]', this).val() === ''))) {
            $(this).append('<div class="form-reserve-error text-center"><?= Yii::t('app', 'Необходимо заполнить данные подачи и возврата'); ?></div>');
            
            return false;
        }
    });
    </script>
    <?php $script = str_replace(['<script>', '</script>'], '', ob_get_contents()); ?>
<?php ob_end_clean(); ?>

<?php $this->registerJs($script); ?>