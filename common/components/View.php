<?php
/**
 * Created by PhpStorm.
 * User: Vitaliy
 * Date: 31.01.2018
 * Time: 15:19
 */

namespace common\components;

class View extends \yii\web\View {

    /**
     * @var string Content that should be injected to end of `<head>` tag
     */
    public $injectToHead    = '';

    /**
     * @var string Content that should be injected to end of `<body>` tag
     */
    public $injectToBodyEnd = '';

    /**
     * @inheritdoc
     */
    protected function renderHeadHtml()
    {
        return parent::renderHeadHtml() . $this->injectToHead;
    }

    /**
     * @inheritdoc
     */
    protected function renderBodyEndHtml($ajaxMode)
    {
        return parent::renderBodyEndHtml($ajaxMode) . $this->injectToBodyEnd;
    }

}