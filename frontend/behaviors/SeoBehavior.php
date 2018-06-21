<?php

namespace frontend\behaviors;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\SeoText;

/**
 * Class SeoBehavior
 * @package frontend\behaviors
 *
 * @property SeoText $seoText
 * @property ActiveRecord $owner
 */
class SeoBehavior extends \yii\base\Behavior
{
    private $_model;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function afterInsert()
    {
        if ($this->seoText->load(Yii::$app->request->post())) {
            if (!$this->seoText->isEmpty()) {
                $this->seoText->save();
            }
        }
    }

    public function afterUpdate()
    {
        if ($this->seoText->load(Yii::$app->request->post())) {
            if (!$this->seoText->isEmpty()) {
                $this->seoText->save();
            } else {
                if ($this->seoText->primaryKey) {
                    $this->seoText->delete();
                }
            }
        }
    }

    public function afterDelete()
    {
        if (!$this->seoText->isNewRecord) {
            $this->seoText->delete();
        }
    }

    public function getSeo()
    {
        //ex_print('seo__________1');
        $row = $this->owner->hasOne(
            SeoText::className(),
            ['item_id' => $this->owner->primaryKey()[0]]
        )
        ->where(['class' => get_class($this->owner)])
        ->andWhere(['lang' => Yii::$app->language]);

//        if(!$row){
//            $SeoText = new SeoText([
//                'class' => get_class($this->owner),
//                'item_id' => $this->owner->primaryKey,
//                'lang' => Yii::$app->language
//            ]);
//
//            $row = $this->owner->hasOne(
//                SeoText::className(),
//                ['item_id' => $this->owner->primaryKey()[0]]
//            )
//            ->where(['class' => get_class($this->owner)])
//            ->andWhere(['lang' => Yii::$app->language]);
//
//            ex_print($row,'$row_after_create');
//        }

        return $row;
    }

    public function getSeoNotLang()
    {
        $row = $this->owner->hasOne(
            SeoText::className(),
            ['item_id' => $this->owner->primaryKey()[0]]
        )
            ->where(['class' => get_class($this->owner)]);

        return $row;
    }

    public function getSeoText()
    {
        //ex_print('seo__________2');
        if (!$this->_model) {
            $this->_model = $this->owner->seo;
            if (!$this->_model) {
                $this->_model = new SeoText([
                    'class' => get_class($this->owner),
                    'item_id' => $this->owner->primaryKey,
                    'lang' => Yii::$app->language
                ]);
            }
        }

        return $this->_model;
    }

    public function getSeoTextNotLan()
    {
        if (!$this->_model) {
            $this->_model = $this->owner->seo;
            if (!$this->_model) {
                $this->_model = new SeoText([
                    'class' => get_class($this->owner),
                    'item_id' => $this->owner->primaryKey
                ]);
            }
        }

        return $this->_model;
    }

    public function getSeoTextLang()
    {
        //ex_print('seo__________3');
        return $this->seoTextLang();
    }

    public function seoTextLang($lang = '')
    {
        //$lang = ($lang==false) ? Yii::$app->language : $lang;

        if (!$this->_model) {
            $this->_model = $this->owner->seo;
            if (!$this->_model) {
                $this->_model = new SeoText([
                    'class' => get_class($this->owner),
                    'item_id' => $this->owner->primaryKey,
                    'lang' => $lang
                ]);
            }
        }

        return $this->_model;
    }
}