<?php

namespace Katalystsol\PhpSoapClient;

use Katalystsol\PhpSoapClient\Exceptions\SoapMethodDoesNotExist;
use SoapClient;

abstract class Consumer
{
    /** @var \SoapClient  */
    protected $client;

    /**
     * Consumer constructor.
     *
     * @param \SoapClient $client
     */
    public function __construct(SoapClient $client)
    {
        $this->client = $client;
    }

    /**
     * Call the SOAP method
     *
     * @param $method
     * @param $parameters
     *
     * @return mixed
     * @throws SoapMethodDoesNotExist
     */
    public function __call($method, $parameters)
    {
        if (!class_exists($class = $this->getClassNameFromMethod($method))) {
            throw new SoapMethodDoesNotExist("Method {$method} does not exist for {$class}");
        }

        $instance = new $class($this->client);

        if (count($parameters) && isset($parameters[0])) {
            $parameters = $parameters[0];
        }

        return call_user_func([$instance, 'execute'], $parameters);
    }

    /**
     * Get class name that handles execution of this method
     *
     * @param string $method
     *
     * @return string
     */
    protected function getClassNameFromMethod($method)
    {
        $namespace = $this->getClassNameSpace();
        return $namespace.'\\Methods\\'.ucwords($method);
    }

    /**
     * Get the class namespace
     *
     * Override this method as needed
     *
     * @return string
     */
    public function getClassNameSpace()
    {
        return __NAMESPACE__;
    }
}
