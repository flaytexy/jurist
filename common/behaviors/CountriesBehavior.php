<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

class CountriesBehavior extends Behavior
{
    /**
     * @var boolean whether to return countries as array instead of string
     */
    public $countryNamesAsArray = true;
    /**
     * @var string the countries relation name
     */
    public $countryRelation = 'countries';
    /**
     * @var string the countries model value attribute name
     */
    public $countryValueAttribute = 'name_en';
    /**
     * @var string the countries model value attribute name
     */
    public $countryFlagAttribute = 'alpha';
    /**
     * @var string[]
     */
    private $_countryNames;
    /**
     * @inheritdoc
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT    => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE    => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE   => 'beforeDelete',
        ];
    }
    /**
     * Returns countries.
     * @param boolean|null $asArray
     * @return string|string[]
     */
    public function getCountryNames($asArray = null)
    {
        if (!$this->owner->getIsNewRecord() && $this->_countryNames === null) {
            $this->_countryNames = [];

            /* @var ActiveRecord $tag */
            foreach ($this->owner->{$this->countryRelation} as $country) {
                $this->_countryNames[] = $country->getAttribute($this->countryValueAttribute);
            }
        }

        if ($asArray === null) {
            $asArray = $this->countryNamesAsArray;
        }

        if ($asArray) {
            return $this->_countryNames === null ? [] : $this->_countryNames;
        } else {
            return $this->_countryNames === null ? '' : implode(', ', $this->_countryNames);
        }
    }
    /**
     * Sets countries.
     * @param string|string[] $names
     */
    public function setCountryNames($names)
    {
        $this->_countryNames = $this->filterCountryNames($names);
    }
    /**
     * Adds countries.
     * @param string|string[] $names
     */
    public function addCountryNames($names)
    {
        $this->_countryNames = array_unique(array_merge($this->getCountryNames(true), $this->filterCountryNames($names)));
    }
    /**
     * Removes countries.
     * @param string|string[] $names
     */
    public function removeCountryNames($names)
    {
        $this->_countryNames = array_diff($this->getCountryNames(true), $this->filterCountryNames($names));
    }
    /**
     * Removes all countries.
     */
    public function removeAllCountryNames()
    {
        $this->_countryNames = [];
    }
    /**
     * Returns a value indicating whether countries exists.
     * @param string|string[] $names
     * @return boolean
     */
    public function hasCountryNames($names)
    {
        $countryNames = $this->getCountryNames(true);

        foreach ($this->filterCountryNames($names) as $value) {
            if (!in_array($value, $countryNames)) {
                return false;
            }
        }

        return true;
    }
    /**
     * @return void
     */
    public function afterSave()
    {
        if ($this->_countryNames === null) {
            return;
        }

        if (!$this->owner->getIsNewRecord()) {
            $this->beforeDelete();
        }

        $countryRelation = $this->owner->getRelation($this->countryRelation);
        $pivot = $countryRelation->via->from[0];
        /* @var ActiveRecord $class */
        $class = $countryRelation->modelClass;
        $rows = [];

        foreach ($this->_countryNames as $value) {
            /* @var ActiveRecord $tag */
            $country = $class::findOne([$this->countryValueAttribute => $value]);
            if($country == null){
                $country = $class::findOne([$this->countryFlagAttribute => $value]);
            }
            $rows[] = [$this->owner->getPrimaryKey(), $country->getPrimaryKey()];
        }

        if (!empty($rows)) {
            $this->owner->getDb()
                ->createCommand()
                ->batchInsert($pivot, [key($countryRelation->via->link), current($countryRelation->link)], $rows)
                ->execute();
        }
    }
    /**
     * @return void
     */
    public function beforeDelete()
    {
        $countryRelation = $this->owner->getRelation($this->countryRelation);
        $pivot = $countryRelation->via->from[0];

        $this->owner->getDb()
            ->createCommand()
            ->delete($pivot, [key($countryRelation->via->link) => $this->owner->getPrimaryKey()])
            ->execute();
    }
    /**
     * Filters countries.
     * @param string|string[] $names
     * @return string[]
     */
    public function filterCountryNames($names)
    {
        return array_unique(preg_split('/\s*,\s*/u', preg_replace('/\s+/u', ' ', is_array($names) ? implode(',', $names) : $names), -1, PREG_SPLIT_NO_EMPTY));
    }

}
