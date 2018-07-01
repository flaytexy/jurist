<?php
namespace frontend\modules\novaoffers\api;

use Yii;
use common\components\APIObject;
use frontend\models\Photo;
use frontend\modules\novaoffers\models\Novaoffers as NovaoffersModel;

/**
 * Class NovaoffersObject
 * @package frontend\modules\novaoffers\api
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
 * @property \frontend\modules\novaoffers\models\Novaoffers $model
 *
 * @property \frontend\modules\novaoffers\models\Offers $offer
 * @property \frontend\modules\novaoffers\models\Offers $child
 */

class NovaoffersObject extends APIObject
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

    public function getchild(){
        return $this->model->child;
    }

    public function getprice(){
        return ($this->price!==null) ?  $this->price: $this->model->child->price;
    }

    public function getCoordinates(){
        return ($this->coordinates!==null) ?  $this->coordinates: $this->model->child->coordinates;
    }

    public function getoffer_id(){
        return ($this->offer_id!==null) ?  $this->offer_id: $this->model->child->offer_id;
    }

    public function getregion_name(){
        return ($this->region_name!==null) ?  $this->region_name: $this->model->child->region_name;
    }

    public function gethow_days(){
        return ($this->how_days!==null) ?  $this->how_days: $this->model->child->how_days;
    }
}