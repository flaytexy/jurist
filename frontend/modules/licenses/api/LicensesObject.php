<?php
namespace frontend\modules\licenses\api;

use Yii;
use common\components\APIObject;
use frontend\models\Photo;
use frontend\modules\licenses\models\Licenses as LicensesModel;

/**
 * Class LicensesObject
 * @package frontend\modules\Licenses\api
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
 * @property \frontend\modules\Licenses\models\Licenses $model
 *
 * @property \frontend\modules\Licenses\models\Offers $offer
 * @property \frontend\modules\Licenses\models\Offers $child
 */

class LicensesObject extends APIObject
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