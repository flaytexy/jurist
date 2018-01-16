<?php

namespace app\modules\reserve\models\form;

use Yii;
use yii\base\Model;
use app\modules\main\Module;
use yii\web\UploadedFile;

class DriverForm extends Model
{
    public $first_name;
    public $last_name;
    public $phone;
    public $email;
    public $card;
    public $avia;
    public $subscribe;
    /**
     * @var UploadedFile[]
     */
    public $driverFiles;
    public $realDriverFiles;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['first_name', 'last_name', 'phone', 'email'], 'required', 'message' => Yii::t('app', 'Необходимо заполнить')],
            [['email'], 'email', 'message' => Yii::t('app', 'Неверный адрес эл. почты')],
            [['card', 'avia', 'realDriverFiles'], 'safe'],
            [['driverFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['subscribe'], 'boolean'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'first_name' => Yii::t('app', 'Имя'),
            'last_name' => Yii::t('app', 'Фамилия'),
            'phone' => Yii::t('app', 'Телефон'),
            'email' => Yii::t('app', 'Эл. почта'),
            'card' => Yii::t('app', 'Промокод / карта постоянного клиента'),
            'avia' => Yii::t('app', 'Номер авиарейса'),
            'subscribe' => Yii::t('app', 'Подписаться на рассылку'),
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            foreach ($this->driverFiles as $file) {
                $file->saveAs('reserve/' . $file->baseName . '.' . $file->extension);
            }
            return true;
        } else {
            return false;
        }
    }
}
