<?php

namespace app\modules\press\models;

use app\models\Content;
use yii\helpers\Url;

/**
 * Class press
 * @package app\modules\press\models
 *
 * @property int $id
 * @property string $thumbnail
 * @property int $publish_date
 *
 * @property PressTranslation|array $translations
 */
class Press extends Content
{
    const PAGE_LIMIT = 6;
    
    public static $_type = 'press';

    public function afterFind()
    {
        if (is_null($this->_title)) {
            foreach ($this->translations as $language => $translation) {
                if ($translation->title) {
                    $this->_title = $translation->title;
                    $this->_edit_link = Url::to(['/admin/press/default/edit', 'id' => $this->id, 'language' => $language]);
                    break;
                }
            }
        }

        parent::afterFind();
    }
}
