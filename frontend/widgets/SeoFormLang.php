<?php
namespace frontend\widgets;

use frontend\behaviors\SeoBehavior;
use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;
use yii\helpers\Html;

/**
 * Class SeoFormLang
 * @package frontend\widgets
 *
 * @property SeoBehavior $model
 */
class SeoFormLang extends Widget
{
    public $model;
    public $lang;

    public function init()
    {
        parent::init();

        if (empty($this->model)) {
            throw new InvalidConfigException('Required `model` param isn\'t set.');
        }
    }

    public function run()
    {
        echo $this->render('seo_form_lang', [
            'lang' => $this->lang,
            'model' => $this->model->seoTextLang($this->lang)
        ]);
    }

}