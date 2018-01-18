<?php

namespace backend\modules\seo\models;

use yii\db\ActiveRecord;

class Seo extends ActiveRecord
{

    public function rules()
    {
        return [
            [['view', 'action_params', 'uri'], 'safe'],
            [['title', 'keywords', 'description', 'h1', 'text'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'uri' => 'Постоянная ссылка',
            'title' => 'Заголовок окна браузера',
            'keywords' => 'Cписок ключевых слов',
            'description' => 'Мета-описание страницы',
            'h1' => 'Текст H1',
            'text' => 'SEO-текст',
        ];
    }
}
