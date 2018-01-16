<?php

namespace app\modules\album\models;

use app\models\Content;
use yii\helpers\Url;

/**
 * Class Album
 * @package app\modules\album\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property int $publish_date
 *
 * @property AlbumTranslation|array $translations
 */
class Album extends Content
{
    const PAGE_LIMIT = 6;
    
    public static $_type = 'album';

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/album/default/edit', 'id' => $this->id, 'language' => $language]);
                    break;
                }
            }
        }

        parent::afterFind();
    }
}
