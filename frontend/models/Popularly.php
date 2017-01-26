<?php
namespace frontend\models;

use frontend\components\ActiveRecord;

class Popularly extends ActiveRecord
{
    public static function tableName()
    {
        return 'easyii_popularly';
    }

    public function rules()
    {
        return [
            [['class','item_id'], 'required'],
            ['class', 'string', 'max' => 128],

        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            //$this->price = str_replace(",", ".", $this->price);


            return true;
        } else {
            return false;
        }
    }

    public function getInherit($objDonor, $objGetter){
        foreach ($objGetter  as $key => $item) {
            if(!is_object($item)){
                //echo "{$key} => {$item}<br />";

                if(property_exists(get_class($objDonor), $key)){
                    //echo "{$key} => $objDonor->{$key}<br />";
                    $this->{$key} = $objDonor->{$key};
                }elseif(isset($objDonor->model->{$key}) && !is_object($objDonor->model->{$key}) && !is_array($objDonor->model->{$key})){

                    //$this->{$key} = $objDonor->{$key};
                }
            }
        }

        return true;
    }

}