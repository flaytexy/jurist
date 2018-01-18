<?php

namespace backend\modules\menu\models;

use yii\db\ActiveRecord;
use backend\modules\menu\Module;

/**
 * Class Menu
 * @package backend\modules\menu\models
 *
 * @property int $id
 * @property string $name
 */
class Menu extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['name', 'required', 'message' => 'Введите название меню'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Module::t('module', 'MENU_NAME'),
        ];
    }
}
