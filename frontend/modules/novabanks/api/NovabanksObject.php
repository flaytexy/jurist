<?php
namespace frontend\modules\Novabanks\api;

use Yii;
use common\components\APIObject;
use frontend\models\Photo;
use frontend\modules\Novabanks\models\Novabanks as NovabanksModel;

/**
 * Class NovabanksObject
 * @package frontend\modules\Novabanks\api
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
 */

class NovabanksObject extends APIObject
{
    public $slug;
    public $image;
    public $views;
    public $time;

    private $_photos;

    public function __construct($model){
        parent::__construct($model);
    }

    public function getPhotos()
    {
        if (!$this->_photos) {
            $this->_photos = [];

            foreach (Photo::find()->where(['class' => NovabanksModel::className(), 'item_id' => $this->id])->sort()->all() as $model) {
                //$this->_photos[] = new PhotoObject($model); //@todo
            }
        }
        return $this->_photos;
    }
}