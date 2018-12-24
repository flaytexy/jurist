<?php
/**
 * Created by IntelliJ IDEA.
 * User: Dangel
 * Date: 06.11.2018
 * Time: 16:10
 */

namespace frontend\models;
use  yii\base\Model;

class PageSearch extends Model
{
    public $searchText;
    public $categoryId;
    public function rules()
    {
        return [
            [['searchText', 'categoryId'], 'required']
        ];
    }
}

