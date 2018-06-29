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
 * @property \frontend\modules\novabanks\models\Banks $bank
 */

class NovabanksObject extends APIObject
{
    public $slug;
    public $image;
    public $views;
    public $time;
    public $location_title;

    public function __construct($model){
        parent::__construct($model);
    }


}