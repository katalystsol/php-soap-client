<?php

namespace Katalystsol\PhpSoapClient;

use Katalystsol\PhpSoapClient\Exceptions\SoapComplexTypeNotConfigured;


abstract class ComplexType
{
    /** @var string Class name */
    protected $complexTypeClassName;

    /** @var array  */
    protected $complexTypes = [];

    /** @var array  */
    protected $errors = [];

    /** @var array  */
    protected $propertyValues = [];

    /** @var array  */
    protected $propertyKeys = [];

    /** @var array  */
    protected $values = [];

    public function __construct(array $values)
    {
        $this->values = $values;

        $this->initialize();
    }

    /**
     * Return the properties as an array
     *
     * @return array
     */
    public function toArray()
    {
        return $this->propertyValues;
    }

    /**
     * Initialize the properties for this class
     */
    protected function initialize()
    {
        $this->setPropertyKeys();
        $this->setComplexTypes();
        $this->setComplexTypeClassName();

        foreach ($this->values as $key => $value) {
            if (in_array($key, $this->propertyKeys)) {
                $this->propertyValues[$key] = $this->setValue($key, $value);
            }
        }
    }

    /**
     * Set the value for the key
     *
     * @param string $key
     * @param $value
     *
     * @return array
     */
    protected function setValue($key, $value)
    {
        if ($this->isComplexType($key)) {
            $complexType = $this->createComplexType($key);
            return $complexType->toArray();
        }

        return $value;
    }

    /**
     * Check if the property is a complex type
     *
     * @param string $propertyKey
     *
     * @return bool
     */
    protected function isComplexType($propertyKey)
    {
        return array_key_exists($propertyKey, $this->complexTypes);
    }

    /**
     * Instantiate and return a complex type object
     *
     * @param string $propertyKey
     *
     * @return ComplexType
     */
    protected function createComplexType($propertyKey)
    {
        $complexTypeClassName = $this->complexTypes[$propertyKey];

        return new $complexTypeClassName($this->values);
    }

    /**
     * Set the properties array with the properties / keys needed for the class
     */
    abstract protected function setPropertyKeys();

    /**
     * Set the complex types array
     */
    abstract protected function setComplexTypes();

    /**
     * Sets the class name for the complex type class
     */
    abstract protected function setComplexTypeClassName();
}
