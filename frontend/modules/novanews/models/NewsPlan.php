<?php

namespace frontend\modules\novanews\models;

use Yii;

/**
 * This is the model class for table "novanews_plan".
 * @property integer $content_id
 * @property string $post_date
 */
class NewsPlan extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'novanews_plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_date'], 'safe'],
            ['post_date', 'default', 'value' => '0000-00-00'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_date' => Yii::t('app', 'Post Date'),
        ];
    }
}

