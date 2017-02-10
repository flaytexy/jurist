<?php
namespace frontend\behaviors;

use Yii;
use yii\db\ActiveRecord;
use common\models\country\Country;
use common\models\country\CountryAssign;

/**
 * Class CountryAble
 * @package frontend\behaviors
 */
class CountryAble extends \yii\base\Behavior
{
    private $_country;
    /**
     * @var ActiveRecord the owner of this behavior
     */
    public $owner;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterSave',
            ActiveRecord::EVENT_BEFORE_DELETE => 'beforeDelete',
        ];
    }

    public function getCountryAssigns()
    {
        return $this->owner->hasMany(CountryAssign::className(), ['item_id' => $this->owner->primaryKey()[0]])->where(['class' => get_class($this->owner)]);
    }

    public function getCountry()
    {
        return $this->owner->hasMany(Country::className(), ['id' => 'country_id'])->via('countryAssigns');
    }

    public function getCountryNames()
    {
        return implode(', ', $this->getCountryArray());
    }

    public function setCountryNames($values)
    {
        $this->_country = $this->filterCountryValues($values);
    }

    public function getCountryArray()
    {
        if($this->_country === null){
            $this->_country = [];
            foreach($this->owner->country as $country) {
                $this->_country[] = $country->name;
            }
        }
        return $this->_country;
    }

    public function afterSave()
    {
        if(!$this->owner->isNewRecord) {
            $this->beforeDelete();
        }

        if(count($this->_country)) {
            $countryAssigns = [];
            $modelClass = get_class($this->owner);

            foreach ($this->_country as $name) {
                if (!($country = Country::findOne(['name' => $name]))) {
                    $country = new Country(['name' => $name]);
                }
                //$country->frequency++;
                if ($country->save()) {
                    $updatedCountry[] = $country;
                    $countryAssigns[] = [$modelClass, $this->owner->primaryKey, $country->id];
                }
            }

            if(count($countryAssigns)) {
                Yii::$app->db->createCommand()->batchInsert(CountryAssign::tableName(), ['class', 'item_id', 'country_id'], $countryAssigns)->execute();
                $this->owner->populateRelation('country', $updatedCountry);
            }
        }
    }

    public function beforeDelete()
    {
        $pks = [];

        foreach($this->owner->country as $country){
            $pks[] = $country->primaryKey;
        }

        if (count($pks)) {
            //Country::updateAllCounters(['frequency' => -1], ['in', 'country_id', $pks]);
        }
        //Country::deleteAll(['frequency' => 0]);
        CountryAssign::deleteAll(['class' => get_class($this->owner), 'item_id' => $this->owner->primaryKey]);
    }

    /**
     * Filters country.
     * @param string|string[] $values
     * @return string[]
     */
    public function filterCountryValues($values)
    {
        return array_unique(preg_split(
            '/\s*,\s*/u',
            preg_replace('/\s+/u', ' ', is_array($values) ? implode(',', $values) : $values),
            -1,
            PREG_SPLIT_NO_EMPTY
        ));
    }
}