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
 * @property \frontend\modules\Licenses\models\LicensesExt $licenses
 * @property \frontend\modules\Licenses\models\LicensesExt $child
 */

class LicensesObject extends APIObject
{
    public function __construct($model){

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

}