<?php
namespace frontend\widgets;

use frontend\models\Packet;
use Yii;
use yii\base\Widget;
use yii\base\InvalidConfigException;


class Packets extends Widget
{
    public $model;

    public function init()
    {
        parent::init();

        if (empty($this->model)) {
            throw new InvalidConfigException('Required `model` param isn\'t set.');
        }
    }

    public function run()
    {
        $packets = Packet::find()->where(['class' => get_class($this->model), 'item_id' => $this->model->primaryKey])->sort()->all();

        echo $this->render('packets', [
            'packets' => $packets
        ]);
    }

}