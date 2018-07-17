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
class Ddir extends \common\components\ActiveRecord
{
    public static function tableName()
    {
        return 'a_ddir';
    }

    public function rules()
    {
        return [
            [['title'], 'trim'],
            [['title'], 'string', 'max' => 255],
            [['title'], EscapeValidator::className()],
        ];
    }

//
//    public function isEmpty()
//    {
//        return (!$this->h1 && !$this->title && !$this->keywords && !$this->description);
//    }
}