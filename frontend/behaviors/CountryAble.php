<?php
namespace frontend\behaviors;

use common\models\country\CountryData;
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
     * @var string PrimaryKey Column
     */
    private $countryPrimaryKey = 'country_id';

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

/*    public function getCountries()
    {
        if(isset($this->owner->primaryKey()[0]))
            return $this->owner->hasMany(CountryData::className(), ['country_id' => 'country_id'])
                ->viaTable('{{%country_assign}}', ['item_id' => "{$this->owner->primaryKey()[0]}"]);

        return false;
    }*/

    public function getCountries(){
        //e_print(get_class($this->owner));
        $countries = $this->owner->hasMany(CountryData::className(), ["{$this->countryPrimaryKey}" => 'country_id'])->via('countryAssigns');
        return $countries;
        //return $this->getCountry();
    }

    public function getCountryAssigns()
    {
       // e_print($this->owner->primaryKey()[0]);
        return $this->owner->hasMany(CountryAssign::className(), ['item_id' => $this->owner->primaryKey()[0]])->where(['class' => get_class($this->owner)]);
    }

    public function getCountry()
    {
        return $this->owner->hasMany(CountryData::className(), ["{$this->countryPrimaryKey}" => 'country_id'])->via('countryAssigns');
    }

    public function getCountryNames_old()
    {
        $countryNames = $this->getCountryArray();
        return implode(', ', $countryNames);
    }

    /**
     * Returns countries.
     * @param boolean|null $asArray
     * @return string|string[]
     */
    public function getCountryNames($asArray = null)
    {
        if (!$this->owner->getIsNewRecord() && $this->_country === null) {
            $this->_country = [];

            /* @var ActiveRecord $tag */
            foreach ($this->owner->{$this->countryRelation} as $country) {

                $this->_country[] = $country->getAttribute($this->countryValueAttribute);
            }
        }

        if ($asArray === null) {
            $asArray = $this->countryNamesAsArray;
        }

        if ($asArray) {
            return $this->_country === null ? [] : $this->_country;
        } else {
            return $this->_country === null ? '' : implode(', ', $this->_country);
        }
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
                $this->_country[] = $country->{$this->countryValueAttribute};
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
                if (!($country = CountryData::findOne(["{$this->countryValueAttribute}" => $name]))) {
                    //$country = new CountryData(["{$this->countryValueAttribute}" => $name]);
                }

                $country->frequency++;
                if ($country->save(false)) {
                    $updatedCountry[] = $country;
                    $countryAssigns[] = [$modelClass, $this->owner->primaryKey, $country->{$this->countryPrimaryKey}];
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
             CountryData::updateAllCounters(['frequency' => -1], ['in', 'country_id', $pks]);
        }
        //CountryData::deleteAll(['frequency' => 0]);
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