<?php

namespace app\modules\menu\models;

use yii\db\ActiveRecord;
use app\modules\menu\Module;

/**
 * Class Menu
 * @package app\modules\menu\models
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
