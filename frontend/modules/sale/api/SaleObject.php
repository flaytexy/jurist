<?php
namespace frontend\modules\sale\api;

use Yii;
use common\components\APIObject;
use frontend\models\Photo;
use frontend\modules\sale\models\Sale as SaleModel;

/**
 * Class SaleObject
 * @package frontend\modules\sale\api
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
 * @property \frontend\modules\sale\models\Sale $model
 *
 * @property \frontend\modules\sale\models\Offers $offer
 * @property \frontend\modules\sale\models\Offers $child
 */

class SaleObject extends APIObject
{
//    public $location_title = null;
//    public $price = null;
//    public $child = null;
//    public $coordinates = null;
//    //public $offer_id= null;
//    public $region_name = null;
//    public $how_days = null;

    public function __construct($model){

//        foreach($this as $attribute => $value){
//            if($this->{$attribute} === null && $this->canGetProperty($attribute)){
//                //$this->{$attribute} = $value;
//                e_print( $attribute .': '. $this->{$attribute}, 'saddsadsa_aft');
//            }else{
//                e_print( $attribute .': '.$this->{$attribute}, 'saddsadsa_is');
//            }
//        }
//        exit;

        parent::__construct($model);

        foreach($model->attributes as $attribute => $value){
            if($this->canSetProperty($attribute)){
                $this->{$attribute} = $value;
            }
        }
    }

    public function getoffer(){
        return $this->getchild();
    }

    public function getchild(){
        return $this->model->child;
    }

    public function getprice(){
        return ($this->price!==null) ?  $this->price: $this->model->child->price;
    }


    public function getprice_prefix(){
        return ($this->price_prefix!==null) ?  $this->price_prefix: $this->model->child->price_prefix;
    }

}