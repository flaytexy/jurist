<?php

namespace backend\modules\video\models;

use backend\models\Content;
use yii\helpers\Url;

/**
 * Class Video
 * @package backend\modules\video\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property int $publish_date
 *
 * @property VideoTranslation|array $translations
 */
class Video extends Content
{

    const PAGE_LIMIT = 6;

    public static $_type = 'video';

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/video/default/edit', 'id' => $this->id, 'language' => $language]);
                    break;
                }
            }
        }

        parent::afterFind();
    }
}
