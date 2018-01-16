<?php

use yii\helpers\Url;
use app\modules\attachment\models\Attachment;
use app\modules\currency\models\Currency;

?>
<div id="service-popup" class="popup">
    <div class="popup-bg"></div>
    <div class="popup-wrap">
        <div class="popup-container">
            <div class="popup-content">
                <div class="intro__content__left">
                    <div class="popup-title">
                        <?= $datetime == 'in' ? Yii::t('app', 'Получение') : Yii::t('app', 'Возврат'); ?>
                        <img src="/img/contacts/cross.png" class="popup-close">
                    </div>

                    <form action="" method="post" class="form-reserve">
                        <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />

                        <label for="input-service_date_leave"><?= Yii::t('app', 'Дата и время подачи'); ?></label>
                        <div class="date_time_wrapper">
                            <i class="icon-calendar"></i>
                            <input class="text date required input-service_date_leave" type="text" value="<?= $reserve_data['date_in']; ?>" name="Reserve[date_in]" readonly="readonly"/>
                            <div class="input-service_time_leave">

                                <div class="input-dropdown">
                                    <i class="icon-clock"></i>
                                    <i class="icon-chevron-down input-dropdown-toggle"></i>
                                    <input type="hidden" name="Reserve[time_in]" value="<?= $reserve_data['time_in']; ?>">
                                    <div class="value"><?= $reserve_data['time_in']; ?></div>
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
                            <input class="text date input-service_date_return" type="text" value="<?= $reserve_data['date_out']; ?>" name="Reserve[date_out]" readonly="readonly"/>
                            <div class="input-service_time_return">
                                <div class="input-dropdown">
                                    <i class="icon-clock"></i>
                                    <i class="icon-chevron-down input-dropdown-toggle"></i>
                                    <input type="hidden" name="Reserve[time_out]" value="<?= $reserve_data['time_out']; ?>">
                                    <div class="value"><?= $reserve_data['time_out']; ?></div>
                                    <div class="variants">
                                        <?php for ($i = 0; $i < 24; $i++) { ?>
                                            <div class="variant"><?= substr('0' . $i, -2); ?>:00</div>
                                            <div class="variant"><?= substr('0' . $i, -2); ?>:30</div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right">
                            <button class="popup-button" type="submit"><?= Yii::t('app', 'Сохранить'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
