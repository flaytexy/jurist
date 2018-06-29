<?php
namespace frontend\models;

use Yii;
use frontend\validators\EscapeValidator;

/**
 * Class SeoText
 * @package frontend\models
 *
 * @property $h1
 * @property $title
 * @property $keywords
 * @property $description
 */
class Sir extends \common\components\ActiveRecord
{
    public static function tableName()
    {
        return 'a_sir';
    }

    public function rules()
    {
        return [
            [['good'], 'trim'],
            [['good'], 'string', 'max' => 255],
            [['good'], EscapeValidator::className()],
        ];
    }

//
//    public function isEmpty()
//    {
//        return (!$this->h1 && !$this->title && !$this->keywords && !$this->description);
//    }
}