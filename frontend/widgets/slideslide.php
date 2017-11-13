<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy
 * Date: 31.08.2017
 * Time: 23:05
 */

namespace frontend\widgets;


class WLang extends \yii\bootstrap\Widget
{
    public function init(){}

    public function run() {
        return $this->render('lang/view', [
            'current' => Lang::getCurrent(),
            'langs' => Lang::find()->where('id != :current_id', [':current_id' => Lang::getCurrent()->id])->all(),
        ]);
    }
}