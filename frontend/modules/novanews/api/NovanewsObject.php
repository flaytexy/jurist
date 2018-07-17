<?php
namespace frontend\modules\novanews\api;

use Yii;
use common\components\APIObject;
use frontend\models\Photo;
use frontend\modules\novanews\models\Novanews as NovanewsModel;

/**
 * Class NovanewsObject
 * @package frontend\modules\novanews\api
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

class NovanewsObject extends APIObject
{
    private $_photos;

    public function __construct($model){
        parent::__construct($model);
    }

    public function getPhotos()
    {
        if (!$this->_photos) {
            $this->_photos = [];

            foreach (Photo::find()->where(['class' => NovanewsModel::className(), 'item_id' => $this->id])->sort()->all() as $model) {
                //$this->_photos[] = new PhotoObject($model); //@todo
            }
        }
        return $this->_photos;
    }
}