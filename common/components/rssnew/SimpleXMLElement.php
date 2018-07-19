<?php

namespace common\components\rssnew;

/**
 * Class SimpleXMLElement
 * @package common\components\rssnew
 */
class SimpleXMLElement extends \SimpleXMLElement
{
    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return \SimpleXMLElement
     */
    public function addChild($name, $value = null, $namespace = null)
    {
        if ($value !== null and is_string($value) === true) {
            $value = str_replace('&', '&amp;', $value);
        }

        return parent::addChild($name, $value, $namespace);
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return \SimpleXMLElement
     */
    public function addCdataChild($name, $value = null, $namespace = null)
    {
        $element = $this->addChild($name, null, $namespace);
        $dom = dom_import_simplexml($element);
        $elementOwner = $dom->ownerDocument;
        $dom->appendChild($elementOwner->createCDATASection($value));
        return $element;
    }

    /**
     * @param string $name
     * @param string $value
     * @param string $namespace
     * @return \SimpleXMLElement
     */
    public function addCdataChildWithoutNamespace($name, $value = null, $namespace = null)
    {
        $element = $this->addChild($name, null);
        $dom = dom_import_simplexml($element);
        $elementOwner = $dom->ownerDocument;
        $dom->appendChild($elementOwner->createCDATASection($value));
        return $element;
    }
}
