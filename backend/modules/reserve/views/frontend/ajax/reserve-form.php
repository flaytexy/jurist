<?php

use backend\modules\reserve\widgets\Reserve;

?>
<div id="service-popup" class="popup">
    <div class="popup-bg"></div>
    <div class="popup-wrap">
        <div class="popup-container">
            <div class="popup-content">
                <div class="intro__content__left">
                    <div class="popup-title">
                        <?= Yii::t('app', 'Бронирование'); ?>
                        <img src="/img/contacts/cross.png" class="popup-close">
                    </div>

                    <?= Reserve::widget(['button_text' => Yii::t('app', 'Бронировать')]); ?>
                </div>
            </div>
        </div>
    </div>
</div>
