<?php
namespace frontend\behaviors;

use Yii;
use yii\db\ActiveRecord;
use frontend\models\Option;
use frontend\models\OptionAssign;

class Optionable extends \yii\base\Behavior
{
    private $_options;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function getOptionAssigns()
    {
        return $this->owner->hasMany(OptionAssign::className(), ['item_id' => $this->owner->primaryKey()[0]])->where(['class' => get_class($this->owner)]);
    }

    public function getOptions()
    {
        return $this->owner->hasMany(Option::className(), ['option_id' => 'option_id'])->via('optionAssigns');
    }

    public function getOptionNames()
    {
        return implode(', ', $this->getOptionsArray());
    }

    public function setOptionNames($values)
    {
        $this->_options = $this->filterOptionValues($values);
    }

    public function getOptionsArray()
    {
        if($this->_options === null){
            $this->_options = [];
            foreach($this->owner->options as $option) {
                $this->_options[] = $option->name;
            }
        }
        return $this->_options;
    }

    public function afterSave()
    {
        if(!$this->owner->isNewRecord) {
            $this->beforeDelete();
        }

        if(count($this->_options)) {
            $optionAssigns = [];
            $modelClass = get_class($this->owner);

            foreach ($this->_options as $name) {
                if (!($option = Option::findOne(['name' => $name]))) {
                    $option = new Option(['name' => $name]);
                }
                $option->frequency++;
                if ($option->save()) {
                    $updatedOptions[] = $option;
                    $optionAssigns[] = [$modelClass, $this->owner->primaryKey, $option->option_id];
                }
            }

            if(count($optionAssigns)) {
                Yii::$app->db->createCommand()->batchInsert(OptionAssign::tableName(), ['class', 'item_id', 'option_id'], $optionAssigns)->execute();
                $this->owner->populateRelation('options', $updatedOptions);
            }
        }
    }

    public function beforeDelete()
    {
        $pks = [];

        foreach($this->owner->options as $option){
            $pks[] = $option->primaryKey;
        }

        if (count($pks)) {
            Option::updateAllCounters(['frequency' => -1], ['in', 'option_id', $pks]);
        }
        Option::deleteAll(['frequency' => 0]);
        OptionAssign::deleteAll(['class' => get_class($this->owner), 'item_id' => $this->owner->primaryKey]);
    }

    /**
     * Filters options.
     * @param string|string[] $values
     * @return string[]
     */
    public function filterOptionValues($values)
    {
        return array_unique(preg_split(
            '/\s*,\s*/u',
            preg_replace('/\s+/u', ' ', is_array($values) ? implode(',', $values) : $values),
            -1,
            PREG_SPLIT_NO_EMPTY
        ));
    }
}