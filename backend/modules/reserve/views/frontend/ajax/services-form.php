<?php

use yii\helpers\Url;
use backend\modules\attachment\models\Attachment;
use backend\modules\currency\models\Currency;

?>
<div id="service-popup" class="popup">
    <div class="popup-bg"></div>
    <div class="popup-wrap">
        <div class="popup-container">
            <div class="popup-content">
                <div class="popup-title">
                    <?= Yii::t('app', 'Дополнения'); ?>
                    <img src="/img/contacts/cross.png" class="popup-close">
                </div>

                <form action="<?= Url::to(['/reserve/default/payment']); ?>" method="post">
                    <input type="hidden" name="<?= Yii::$app->request->csrfParam; ?>" value="<?= Yii::$app->request->csrfToken; ?>" />
                    <ul class="reserve_1__main__right__list__add__main">
                        <?php foreach ($services as $service) { ?>
                            <li class="add__row">
                                <div class="add__col add__icon"><img src="<?= Attachment::getImage($service['thumbnail'], [46, 46]); ?>" srcset="<?= Attachment::getImage($service['thumbnail'], [92, 92]); ?> 2x" /></div>
                                <div class="add__col">
                                    <p><?= $service['translation']['title']; ?></p>
                                    <?= $service['translation']['description']; ?>
                                </div>
                                <div class="add__col"><span class="add_down">&mdash;</span>
                                    <input type="number" name="Reserve2[service][<?= $service['id']; ?>]" value="<?= isset($reserve_additions_data['service'][$service['id']]) ? $reserve_additions_data['service'][$service['id']]['quantity'] : ''; ?>"/><span class="add_up">+</span>
                                </div>
                                <div class="add__col">
                                    <p><span><?= Currency::format($reserve_period < 15 ? $service['price_1'] : $service['price_15']); ?></span></p>
                                    <p><?= Yii::t('app', 'в день'); ?></p>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="text-right">
                        <button class="popup-button" type="submit"><?= Yii::t('app', 'Сохранить'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
