<?php
namespace frontend\modules\paysystem\api;

use Yii;
use common\components\APIObject;
use frontend\models\Photo;
use frontend\modules\paysystem\models\Paysystem as PaysystemModel;

/**
 * Class PaysystemObject
 * @package frontend\modules\paysystem\api
 *
 * @property string $id
 * @property string $language
 * @property string $name
 * @property string $title
 * @property string $slug
 * @property string $short_description
 * @property string $short
 * @property string $description
 * @property string $text
 * @property int $public_status
 * @property int $public_status_public
 * @property \frontend\modules\paysystem\models\Paysystem $model
 *
 * @property \frontend\modules\paysystem\models\Banks $bank
 * @property \frontend\modules\paysystem\models\Banks $child
 */

class PaysystemObject extends APIObject
{
    public $price = null;
    public $child = null;

    public function __construct($model){
        parent::__construct($model);

        if($this->price===null){
            $this->price = $this->getPrice();
        }
    }

    public function getChild(){
        return $this->model->child;
    }

    public function getPrice(){
        if($this->price!==null){
            return $this->price;
        }

        return $this->model->child->price;
    }
}