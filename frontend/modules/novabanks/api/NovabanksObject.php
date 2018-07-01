<?php
namespace frontend\modules\novabanks\api;

use Yii;
use common\components\APIObject;
use frontend\models\Photo;
use frontend\modules\novabanks\models\Novabanks as NovabanksModel;

/**
 * Class NovabanksObject
 * @package frontend\modules\novabanks\api
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
 * @property \frontend\modules\novabanks\models\Novabanks $model
 *
 * @property \frontend\modules\novabanks\models\Banks $bank
 * @property \frontend\modules\novabanks\models\Banks $child
 */

class NovabanksObject extends APIObject
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